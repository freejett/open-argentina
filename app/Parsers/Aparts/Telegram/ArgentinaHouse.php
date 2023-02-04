<?php

namespace App\Parsers\Aparts\Telegram;

use App\Helpers\StringFunctions;
use App\Models\RawAppartmentsData;
use App\Models\ApartmentsData;
use App\Parsers\Aparts\ApartsInterface;
use App\Traits\TelegramTrait;
use Illuminate\Support\Facades\Log;

class ArgentinaHouse implements ApartsInterface
{
    use TelegramTrait;

    /**
     * Парсер данных. Основная функция
     * @return void
     */
    public function parse(int $chatId): void
    {
        // определяем, какие из сообщений - объявления о квартире
        RawAppartmentsData::select('chat_id', 'msg_id', 'is_appartment')
            ->where('msg', 'like', 'Лот #%')
            ->update(['is_appartment' => 1]);

        $rawAparts = RawAppartmentsData::where('chat_id', $chatId)
            ->where('is_appartment', 1)
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

            if (strpos($apartmentLine, 'айон:')) {
                $fullAddress = $apartmentLine;
                $apartmentLineAddr = preg_split('/[,|(|)]/', $apartmentLine);
                $address = trim(StringFunctions::cleanAddressStr($apartmentLineAddr[0]));
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
        $cost = '0';
        $fullPrice = '';

        foreach ($msgStrings as $apartmentLine) {
            $apartmentLine = strtolower($apartmentLine);

            if (strpos($apartmentLine, 'словия:')) {
                $fullPrice = $apartmentLine;
                $rawCost = explode('$', $apartmentLine);

                if (count($rawCost) > 1) {
//                        $cost = (int) trim($this->cleanDigitsStr($rawCost[0]));
                    $cost = (int) trim( StringFunctions::cleanDigitsStr($rawCost[0]) );

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
        $title = $msgStrings[0];

        return $title;
    }
}