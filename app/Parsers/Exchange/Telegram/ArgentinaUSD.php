<?php

namespace App\Parsers\Exchange\Telegram;

use App\Helpers\StringFunctions;
use App\Models\MoneyExchange as MoneyExchangeModel;
use App\Models\RawTelegramMsg;
use App\Models\References\ReferenceExchangeDirections;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use Illuminate\Support\Facades\Log;

class ArgentinaUSD implements MoneyExchangeInterface
{
    use MoneyExchangeTrait;

    /**
     * Парсер данных. Основная функция
     * @param int $chatId
     * @return void
     */
    public function parse(int $chatId): void
    {
        $rawMsgs = RawTelegramMsg::where('chat_id', $chatId)
            ->orderBy('msg_id', 'desc')
            ->limit(1)
            ->get();
        $exchangeDirections = ReferenceExchangeDirections::all()->pluck('direction_id','title' )->toArray();

        foreach ($rawMsgs as $rawMsg) {
            // разбиваем на строки для удобства обработки
            $rawMsgArr = explode(PHP_EOL, $rawMsg->msg);

            $date = $this->getDate($rawMsgArr);

            if ($date < '1980-01-01') {
                $date = date('Y-m-d', strtotime($rawMsg->created_at));
            }

            $ratesArr = $this->getRate($rawMsgArr);

            foreach ($ratesArr as $exchangeDirectionId => $rate) {
                if (!$rate) {
                    continue;
                }

                $rateExchangeCheckData = [
                    'chat_id' => $chatId,
                    'msg_id' => $rawMsg->msg_id,
                    'exchange_direction_id' => $exchangeDirectionId,
                ];

                $rateExchangeData = [
                    'date' => $date,
                    'rate' => $rate,
//                    'msg' => $rawMsg->msg,
                ];

                $r = MoneyExchangeModel::updateOrCreate($rateExchangeCheckData, $rateExchangeData);
            }

            Log::info('Сообщение '. $chatId .':'. $rawMsg->msg_id .' обработано.');
        }
    }

    /**
     * Поиск даты актуального курса
     * @param array $msgStrings
     * @return string
     */
    public function getDate(array $msgStrings): string
    {
        return '';
    }

    /**
     * Поиск обменного курса для каждого варианта обмена
     * @param array $msgStrings
     * @return array|null
     */
    public function getRate(array $msgStrings): array|null
    {
        $rate = [];
        foreach ($msgStrings as $lineNumber => $msgLine) {
            if (!$msgLine) {
                continue;
            }

            // доллар 💵
            if (str_contains($msgLine, "💵") && !isset($rate[1])) {
                $rate[1] = StringFunctions::cleanDigitsStr($msgLine);
            } // евро '💶'
            elseif (str_contains($msgLine, "💶") && !isset($rate[4])) {
                $rate[4] = StringFunctions::cleanDigitsStr($msgLine);
            } elseif ( str_contains(str_replace(' ', '',$msgLine), 'USDT➡️USD') ) {
                $rate[6] = StringFunctions::cleanDigitsDotStr($msgLine);
            } elseif ( str_contains(str_replace(' ', '',$msgLine), 'USDT➡️PESO') ) {
                $rate[5] = StringFunctions::cleanDigitsDotStr($msgLine);
            } elseif ( str_contains(str_replace(' ', '',$msgLine), 'USD➡️USDT') ) {
                $rate[8] = StringFunctions::cleanDigitsDotStr($msgLine);
            }

        }

        return $rate;
    }
}
