<?php

namespace App\Parsers\Exchange\Telegram;

use App\Helpers\StringFunctions;
use App\Models\RawTelegramMsg;
use App\Models\References\ReferenceExchangeDirections;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use App\Models\MoneyExchange as MoneyExchangeModel;
use Illuminate\Support\Facades\Log;

class CashflowExchange implements MoneyExchangeInterface
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
        $exchangeDirections = ReferenceExchangeDirections::all()->pluck('direction_id','title' )->toArray();

        foreach ($rawMsgs as $rawMsg) {
            // разбиваем на строки для удобства обработки
            $rawMsgArr = explode(PHP_EOL, $rawMsg->msg);

            $date = $this->getDate($rawMsgArr);

            if ($date < '1980-01-01') {
                continue;
            }

            $ratesArr = $this->getRate($rawMsgArr);

            foreach ($ratesArr as $exchangeDirection => $rate) {
                if (!$rate) {
                    continue;
                }

                $exchangeDirection = strtoupper($exchangeDirection);

                $rateExchangeCheckData = [
                    'chat_id' => $chatId,
                    'msg_id' => $rawMsg->msg_id,
                    'exchange_direction_id' => $exchangeDirections[$exchangeDirection],
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
        $dateStr = StringFunctions::cleanDigitsDotStr($msgStrings[0]);
        $date = str_replace('/', '-', $dateStr);
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Поиск обменного курса для каждого варианта обмена
     * @param array $msgStrings
     * @return array|null
     */
    public function getRate(array $msgStrings): array|null
    {
        $exchangeDirections = ReferenceExchangeDirections::all()->pluck('title', 'direction_id')->toArray();

        $rate = [];
        foreach ($msgStrings as $lineNumber => $msgLine) {
            if (!$msgLine) {
                continue;
            }

            $msgLine = strtolower($msgLine);

            foreach ($exchangeDirections as $k => $exchangeDirection) {
                $exchangeDirection = strtolower($exchangeDirection);
                $resultRate = 0;
                if ($this->strContainsMultipleWords($msgLine, explode('|', $exchangeDirection))) {
                    if (str_contains($msgLine, 'rub') || str_contains($msgLine, 'kzt')) {
                        $msgLineArr = explode('=', $msgStrings[$lineNumber+1]);
                        if (isset($msgLineArr[1])) {
                            $resultRate = (int) StringFunctions::cleanDigitsEngRuStr($this->removeContentBetweenBrackets($msgLineArr[1]));
                        }
                    } else {
                        $resultRate = StringFunctions::cleanDigitsDotStr($this->removeContentBetweenBrackets($msgLine));
                    }

                    if (!isset($rate[$exchangeDirection]) || $rate[$exchangeDirection] < $resultRate) {
                        $rate[$exchangeDirection] = $resultRate;
                    }
                }
            }
        }

        return $rate;
    }

    /**
     * Содержит ли строка несколько слов
     * @param $string
     * @param $array_of_words
     * @return bool
     */
    public function strContainsMultipleWords($string, $array_of_words) {
        if (!$array_of_words) {
            return false;
        }

        $i = 0;
        foreach ($array_of_words as $words) {
            if (strpos($string, $words) !== FALSE) $i++;
        }

        return ($i == count($array_of_words)) ? true : false;
    }

    /**
     * Удалить содержимое между скобок
     * @param $str
     * @return array|string|string[]|null
     */
    private function removeContentBetweenBrackets($str)
    {
        return preg_replace("/\([^)]+\)/","", $str);
    }
}
