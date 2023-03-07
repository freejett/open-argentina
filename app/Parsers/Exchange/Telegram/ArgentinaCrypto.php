<?php

namespace App\Parsers\Exchange\Telegram;

use App\Helpers\StringFunctions;
use App\Models\RawTelegramMsg;
use App\Models\References\ReferenceExchangeDirections;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use App\Models\MoneyExchange as MoneyExchangeModel;
use Illuminate\Support\Facades\Log;

class ArgentinaCrypto implements MoneyExchangeInterface
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
            if (count($ratesArr) < 3) {
                continue;
            }

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

            $msgLine = strtolower($msgLine);
            // USD |ARS
            if (str_contains($msgLine, "usd -> ars")) {
                $msgParts = array_filter(explode(' ', $msgLine));
                $rate[1] = (int) StringFunctions::cleanDigitsStr(end($msgParts));
            } // RUB |ARS
            elseif (str_contains($msgLine, "rub -> ars")) {
                $msgParts = array_filter(explode(' ', $msgLine));
                $rate[3] = StringFunctions::cleanDigitsDotStr(end($msgParts)) * 10000;
            } // EUR |ARS
            elseif (str_contains($msgLine, "eur -> ars")) {
                $msgParts = array_filter(explode(' ', $msgLine));
                $rate[4] = (int) StringFunctions::cleanDigitsStr(end($msgParts));
            } // USDT |ARS
            elseif (str_contains($msgLine, "usdt -> ars")) {
                $msgParts = array_filter(explode(' ', $msgLine));
                $rate[5] = (int) StringFunctions::cleanDigitsStr(end($msgParts));
            } // USDT |USD
            elseif (str_contains($msgLine, "usdt -> usd")) {
                $msgParts = array_filter(explode(' ', $msgLine));
                $rate[6] = StringFunctions::cleanDigitsDotStr(end($msgParts));
            }
        }

        return $rate;
    }
}
