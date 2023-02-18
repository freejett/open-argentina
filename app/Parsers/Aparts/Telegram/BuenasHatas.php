<?php

namespace App\Parsers\Aparts\Telegram;

use App\Helpers\StringFunctions;
use App\Models\ApartmentsData;
use App\Models\RawAppartmentsData;
use App\Parsers\Aparts\ApartsInterface;
use App\Traits\TelegramTrait;
use Illuminate\Support\Facades\Log;

class BuenasHatas implements ApartsInterface
{
    use TelegramTrait;

    protected array $delimiters = ['$', 'usd'];

    /**
     * Парсер данных. Основная функция
     * @param int $chatId
     * @return void
     */
    public function parse(int $chatId): void
    {
        echo '<pre>';
        $rawAparts = RawAppartmentsData::where('chat_id', $chatId)
//            ->where('is_appartment', 1)
            ->orderBy('msg_id', 'desc')
            ->get();

        // обработка каждого сообщения
        foreach ($rawAparts as $apartmentRaw) {
            // разбиваем на строки для удобства обработки
            $apartmentArr = explode(PHP_EOL, $apartmentRaw->msg);

            $address = $fullAddress = $cost = $fullPrice = $title = '';

            $title = $this->getTitle($apartmentArr);
            list($address, $fullAddress) = $this->getAddress($apartmentArr);
            list($cost, $fullPrice) = $this->getCost($apartmentArr);

            $rawMsgData = [
                'chat_id' => $chatId,
                'msg_id' => $apartmentRaw->msg_id,
            ];

            $apartData = [
                'title' => $title,
                'address' => $address,
                'full_address' => $fullAddress,
                'full_price' => $fullPrice,
                'photo' => $apartmentRaw->photo,
            ];

            if ($cost && (int) $cost < 15000) {
                $apartData['price'] = $cost;
            }

            // определяем, какие из сообщений НЕ объявления о квартире
            if (!$apartData['address'] && !$apartData['full_price']) {
                continue;
            }

//            print_r($apartData);
            $r = ApartmentsData::updateOrCreate($rawMsgData, $apartData);
            Log::info('Сообщение '. $apartmentRaw->msg_id .' обработано.');
//            dump('Сообщение '. $apartmentRaw->msg_id .' обработано. Данные: '. json_encode($apartData));
        }
    }

    /**
     * Поиск адреса в сообщении
     * @param array $msgStrings
     * @return array
     */
    public function getAddress(array $msgStrings): array
    {
        $address = '';
        $fullAddress = '';

        foreach ($msgStrings as $apartmentLine) {
            $apartmentLine = strtolower($apartmentLine);

            if (strpos($apartmentLine, 'айон')) {
                $fullAddress = $apartmentLine;
//                $apartmentLineAddr = preg_split('/[,|(|)]/', $apartmentLine);
                $address = StringFunctions::clearUmlauts($fullAddress);
                $address = StringFunctions::cleanDigitsEngStr($address);

                $address = explode('   ', $address);
                $address = $address[0];
            }
        }

        return [$address, $fullAddress];
    }

    /**
     * Поиск стоимости в сообщении
     * @param array $msgStrings
     * @return array
     */
    public function getCost(array $msgStrings): array
    {
        $cost = '';
        $fullPrice = '';

        foreach ($msgStrings as $apartmentLine) {
            $apartmentLine = strtolower($apartmentLine);

            if (!strpos($apartmentLine, 'словия')) {
                continue;
            }

            $fullPrice = $apartmentLine;

            // ищем варианты стоимости по подстроке '$' или 'usd'
            foreach ($this->delimiters as $delimiter) {
                if (!strpos($apartmentLine, $delimiter) && !$cost) {
                    continue;
                }

                $rawCost = explode($delimiter, $apartmentLine);

                if (count($rawCost) < 1) {
                    continue;
                }
                $cost = trim( StringFunctions::cleanDigitsStr($rawCost[0]));

                if (!$cost) {
                    $costPrepare1 = substr($rawCost[1], 0, 7);
                    if ($costPrepare1) {
                        $costPrepare2 = StringFunctions::cleanDigitsStr($costPrepare1);
                        if ($costPrepare2) {
                            $cost = (int) trim($costPrepare2);
                        }
                    }
                }
            }
        }

        if (str_ends_with($cost, '1')) {
            $cost = (int) substr($cost, 0, -1);
        }

        return [$cost, $fullPrice];
    }

    /**
     * Поиск заголовка квартиры
     * @param array $msgStrings
     * @return string
     */
    public function getTitle(array $msgStrings): string
    {
        $title = '';
        if (strpos($msgStrings[0], 'СДАНА')) {
            return '';
        }

        if (strpos($msgStrings[0], '|') ||
            strpos($msgStrings[0], 'посредник') ||
            strpos($msgStrings[0], 'СДА') ||
            str_starts_with($msgStrings[0], 'СДА') ||
            str_starts_with($msgStrings[0], 'сда')
        ) {
            if (isset($msgStrings[1]) && strpos($msgStrings[1], 'Посредник')) {
                if (isset($msgStrings[2])) {
                    $title = $msgStrings[2];
                }
            } else {
                if (isset($msgStrings[1])) {
                    $title = $msgStrings[1];
                }
            }
        } else {
            if (isset($msgStrings[1])) {
                $title = $msgStrings[0];
            }
        }

        $title = trim($title);
        str_replace('СДАМ', '', $title);
        str_replace('ПОСРЕДНИК', '', $title);
        str_replace('Посредник', '', $title);
        $title = trim($title);

        if (!$title) {
            if (isset($msgStrings[2]) && $msgStrings[2] && !strpos(strtolower($msgStrings[0]), 'посред')) {
                $title = $msgStrings[2];
            } else {
                if (isset($msgStrings[3]) && $msgStrings[3]) {
                    $title = $msgStrings[3];
                }
            }
        }

        if ($title) {
            if (preg_match('/^.{1,255}\b/s', $title, $match)) {
                $title = $match[0];
            }
        }

        return trim($title);
    }
}
