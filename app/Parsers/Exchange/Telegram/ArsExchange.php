<?php

namespace App\Parsers\Exchange\Telegram;

use App\Helpers\StringFunctions;
use App\Models\RawTelegramMsg;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use App\Models\MoneyExchange as MoneyExchangeModel;
use Illuminate\Support\Facades\Log;

class ArsExchange implements MoneyExchangeInterface
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
        $dateStr = StringFunctions::clearNonPrintableCharacters($msgStrings[0]);
        $dateStr = substr($dateStr, 0, 2) .'-'. substr($dateStr, 2, 2) .'-'. substr($dateStr, 4, 4);
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

            $msgLine = str_replace(' ', '', strtolower(StringFunctions::clearNonPrintableCharacters($msgLine)));
            if (str_contains($msgLine, 'u$dpeso')) {
                $msgParts = explode(':', $msgLine);
                $rate[1] = StringFunctions::cleanDigitsDotCommaStr($msgParts[1]);
            } // EUR |ARS
            elseif (str_contains($msgLine, "europeso")) {
                $msgParts = explode(':', $msgLine);
                $rate[4] = StringFunctions::cleanDigitsStr($msgParts[1]);
            } // USDT |ARS
            elseif (str_contains($msgLine, "usdtpeso")) {
                $msgParts = explode(':', $msgLine);
                $rate[5] = StringFunctions::cleanDigitsStr($msgParts[1]);
            } // USDT |USD
            elseif (str_contains($msgLine, 'usdtu$d')) {
                $msgParts = explode(':', $msgLine);
                $rate[6] = StringFunctions::cleanDigitsStr($msgParts[1]);
            } // USD |USDT
            elseif (str_contains($msgLine, 'u$dusdt')) {
                $msgParts = explode(':', $msgLine);
                $rate[8] = StringFunctions::cleanDigitsStr($msgParts[1]);
            }
        }

        return $rate;
    }
}
