<?php

namespace App\Traits;

use App\Helpers\Functions;
use App\Models\ApartmentsData;
use App\Models\ChatSettings;
use App\Models\RawAppartmentsData;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

/**
 * Если передавать с параметром ?only_photos=1
 * то будут выкачиваться фото для сообщений, у которых есть фото и оно не скачено
 * Нужно доработать так, чтобы выкачивалось не больше 10 фото за раз (пагинация)
 */
trait TelegramTrait {

    /**
     * Объект для работы с API телеграм
     * @var object|API
     */
    public object $MadelineProto;

    /**
     * ID чата телеграм
     * @var int
     */
    public int $chatId;

    /**
     * Путь до изображений квартир
     * @var string
     */
    public string $basePhotoPath = 'app/public/aparts/';

    /**
     * @var object
     */
    protected object $chatSettings;

    /**
     * Инициализация объекта для работы с API Telegram
     * @return void
     */
    public function telegramInit($chatId): void
    {
        $this->MadelineProto = new API('index.madeline');
        $me = $this->MadelineProto->start();
//        $me = $this->MadelineProto->getSelf();
        $this->chatId = $chatId;
    }

    /**
     * Получаем сообщения из телеграм канала и записываем в БД
     * @return bool
     */
    public function getChatMessages(): bool
    {
        $this->chatSettings = ChatSettings::where('chat_id', $this->chatId)->first();
        $msgIds = $this->getMsgsIds();

        // если новых сообщений нет - останавливаем
        if (!count($msgIds)) {
            Log::info('Для чата '. $this->chatId .' нет новых сообщений');
            return true;
        }

        $messages_Messages = $this->MadelineProto->channels->getMessages(channel: $this->chatId, id: $msgIds);

        foreach ($messages_Messages['messages'] as $k => $message) {
            // если не сообщение или текст сообщения пустой
            //  || !$message['message']
            if ($message['_'] != 'message') {
                // значит квартира перенесена в архив
                $rawApartData = RawAppartmentsData::where('chat_id', $this->chatId)
                    ->where('msg_id', $message['id'])
                    ->first();

                // устанавливаем метку, что сообщение - не квартира
                // тогда эта квартина не будет выпадать в результатах поиска
                if ($rawApartData) {
                    $rawApartData->fill(['is_appartment', 0])
                        ->save();
                }

                continue;
            }

            $imageName = null;
            // если есть фото - выкачиваем
            if (isset($message['media']) && isset($message['media']['photo'])) {
                $imageName = $this->getMsgImage($message);
            }

            $rawMsgData = [
                'chat_id' => $this->chatId,
                'msg_id' => $message['id'],
            ];

            if ($imageName) {
                $imageName = basename($imageName);
            }
            $updateMsgData = [
                'msg' => $message['message'],
                'is_appartment' => 0,
                'photo' => $imageName,
            ];

            try {
                $r = RawAppartmentsData::updateOrCreate($rawMsgData, $updateMsgData);
                Log::info('Сообщение '. $message['id'] .' записали в БД. Фото: '. $imageName);
//                dump('Сообщение '. $message['id'] .' записали в БД. Данные: '. json_encode($updateMsgData));
            } catch (Exception $exception) {
                Log::error($exception->getMessage());;
            }
        }

        $this->setNewCurrentMsgId();

        return true;
    }

    /**
     * Обновить ID последнего сообщения в телеграм чате и получить настройки чата
     * @return bool
     */
    public function updateChatSettings(): bool
    {
        $dialogsList = $this->MadelineProto->getFullDialogs();

        if (!count($dialogsList)) {
            Log::info('Chats not found');
            return true;
        }

        foreach ($dialogsList as $chatId => $dialog) {
            if ($chatId != $this->chatId) {
                continue;
            }

            $comparedValues = [
                'chat_id' => $chatId,
            ];
            $updData = [
                'current_msg_id' => 1,
                'last_chat_msg_id' => $dialog['top_message'],
                'chat_info' =>  json_encode($dialog),
            ];
            try {
                ChatSettings::updateOrCreate($comparedValues, $updData);
                Log::info("Updated $chatId settings");
            } catch (\danog\MadelineProto\RPCErrorException $e) {
                Log::error($chatId .' Error#1: '. $e->getMessage());
//                dd($chatId .' Error#1: '. $e);
            } catch (\Exception $e) {
                Log::error($chatId .' Error#2: '. $e->getMessage());
//                dd($chatId .' Error#2: '. $e);
            }
        }

        return true;
    }

    /**
     * Парсим данные из сообщений
     * @return bool
     */
    public function parseRawData(): bool
    {
        // определяем, какие из сообщений - объявления о квартире
        RawAppartmentsData::select('chat_id', 'msg_id', 'is_appartment')
            ->where('msg', 'like', 'Лот #%')
            ->update(['is_appartment' => 1]);

        $rawAparts = RawAppartmentsData::where('chat_id', $this->chatId)
            ->where('is_appartment', 1)
            ->get();

        foreach ($rawAparts as $apartmentRaw) {
            // разбиваем на строки
            $apartmentArr = explode(PHP_EOL, $apartmentRaw->msg);
            $address = '';
            $fullAddress = '';
            $cost = '';
            $fullPrice = '';
            $title = $apartmentArr[0];

            foreach ($apartmentArr as $apartmentLine) {
                $apartmentLine = strtolower($apartmentLine);

                // ищем адрес
                if (strpos($apartmentLine, 'айон:')) {
                    $fullAddress = $apartmentLine;
                    $apartmentLineAddr = preg_split('/[,|(|)]/', $apartmentLine);
                    $address = trim(Functions::cleanAddressStr($apartmentLineAddr[0]));
                }

                // ищем стоимость
                if (strpos($apartmentLine, 'словия:')) {
                    $fullPrice = $apartmentLine;
                    $rawCost = explode('$', $apartmentLine);

                    if (count($rawCost) > 1) {
//                        $cost = (int) trim($this->cleanDigitsStr($rawCost[0]));
                        $cost = (int) trim( Functions::cleanDigitsStr($rawCost[0]) );

                        if (!$cost) {
                            $costPrepare1 = substr($rawCost[1], 0, 7);
                            if ($costPrepare1) {
                                $costPrepare2 = Functions::cleanDigitsStr($costPrepare1);
                                if ($costPrepare2) {
                                    $cost = (int) trim($costPrepare2);
                                }
                            }
                        }
                    }
                }
            }

            $rawMsgData = [
                'chat_id' => $this->chatId,
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
//            dump($apartData);

            $r = ApartmentsData::updateOrCreate($rawMsgData, $apartData);
            Log::info('Сообщение '. $apartmentRaw->msg_id .' обработано.');
//            dump('Сообщение '. $apartmentRaw->msg_id .' обработано. Данные: '. json_encode($apartData));
        }

        return true;
    }

    /**
     * Установить новое текущее сообщение для телеграм чата
     * @return int
     */
    protected function setNewCurrentMsgId(): void
    {
        $newCurrentMsgId = $this->chatSettings->current_msg_id + $this->chatSettings->per_page;
        if ($newCurrentMsgId > $this->chatSettings->last_chat_msg_id) {
            $newCurrentMsgId = $this->chatSettings->last_chat_msg_id;
        }

        $this->chatSettings->fill(['current_msg_id' => $newCurrentMsgId])->save();
    }

    /**
     * Проверяет наличие фото, скачивает на сервер и возвращает имя файла
     * @param $message
     * @return null|string
     */
    protected function getMsgImage($message): string
    {
        $imageName = '';
//        $fileId = $message['media']['photo']['id'];

        try {
            $path = storage_path($this->basePhotoPath . $this->chatId . '/' . $message['id']);
            $mkDirResult = File::makeDirectory($path, 0777, true, true);
            $imageName = $this->MadelineProto->downloadToDir($message, $path);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());;
        }

        return $imageName;
    }

    /**
     * Массив ID сообщений для telegram
     * @return array
     */
    protected function getMsgsIds(): array
    {
        $msgIds = [];

        // если докачиваем только фотографии, то выбираем ID сообщений без фото
        if (\Request::get('only_photos')) {
            $msgIds = RawAppartmentsData::where('is_appartment', 1)->whereNull('photo')->pluck('msg_id')->toArray();
            return $msgIds;
        }

        // если текущее сообщение равно максимальному сообщению в чате
        // то нечего нечего обновлять
        if ($this->chatSettings->current_msg_id >= $this->chatSettings->last_chat_msg_id) {
            return [];
        }

        $lastIterationMsgId = $this->chatSettings->current_msg_id + $this->chatSettings->per_page;
        for ($i = $this->chatSettings->current_msg_id; $i < $lastIterationMsgId; $i++) {
            $msgIds[] = $i;
        }

        return $msgIds;
    }
}
