<?php

namespace App\Parsers\Exchange\Telegram;

use App\Helpers\StringFunctions;
use App\Models\RawTelegramMsg;
use App\Models\References\ReferenceExchangeDirections;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use App\Models\MoneyExchange as MoneyExchangeModel;
use Illuminate\Support\Facades\Log;

class WesternUrion implements MoneyExchangeInterface
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
            ->limit(10)
            ->get();

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
        $dateStr = StringFunctions::cleanDigitsDotStr($msgStrings[0]);
        return date('Y-m-d', strtotime($dateStr));
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

            $msgLine = strtolower($msgLine);
            // USDT |ARS
            if (str_contains($msgLine, "499 usdt -")) {
                $msgParts = explode('-', $msgLine);
                $rate[5] = StringFunctions::cleanDigitsStr($msgParts[1]);
            } // USD |ARS
            elseif (str_contains($msgLine, "1 usd = ")) {
                $msgParts = explode('=', $msgLine);
                $rate[1] = StringFunctions::cleanDigitsStr($msgParts[1]);
            } // USD |USDT
            elseif (str_contains($msgLine, "usd ➡️ usdt")) {
                $msgParts = explode('%', $msgLine);
                $rate[8] = StringFunctions::cleanDigitsDotStr($msgParts[0]);
            } // USDT |USD
            elseif (str_contains($msgLine, "usdt ➡️")) {
                $msgParts = explode('%', $msgLine);
                $rate[6] = StringFunctions::cleanDigitsDotStr($msgParts[0]);
            } // RUB |ARS
            elseif (str_contains($msgLine, "рублей =")) {
                $msgParts = explode('=', $msgLine);
                $rateCompare = StringFunctions::cleanDigitsStr($msgParts[1]);
                // новый вариант выгоднее существующего
                if( !isset($rate[3]) || $rateCompare > $rate[3] ) {
                    $rate[3] = $rateCompare;
                }
            }
        }

        return $rate;
    }
}
