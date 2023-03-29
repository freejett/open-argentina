<?php

namespace App\Traits;

use App\Helpers\StringFunctions;
use App\Models\ChatSettings;
use App\Models\News;
use App\Models\RawTelegramMsg;
use App\Models\Telegram\TelegramChat;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

/**
 * Если передавать с параметром ?only_photos=1
 * то будут выкачиваться фото для сообщений, у которых есть фото и оно не скачено
 * Нужно доработать так, чтобы выкачивалось не больше 10 фото за раз (пагинация)
 */
trait TelegramNewsTrait {

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
     * Название чата телеграм
     * @var string
     */
    public string $chatName;

    /**
     * Путь до изображений квартир
     * @var string
     */
    public string $basePhotoPath = 'app/public/aparts/';

    /**
     * Настройки чата
     * @var object
     */
    protected object $chatSettings;

    /**
     * Парсеры квартир
     * @var array|string[]
     */
    protected array $parsers = [
//        'ArgentinaHouse' => \App\Parsers\Aparts\Telegram\ArgentinaHouse::class,
//        'buenas_hatas' => \App\Parsers\Aparts\Telegram\BuenasHatas::class,
    ];

    protected object $parser;

    /**
     * Инициализация объекта для работы с API Telegram
     * @return void
     */
    public function telegramInit(): void
    {
        $this->MadelineProto = new API('index.madeline');
        $me = $this->MadelineProto->start();
    }

    /**
     * @param $chatId
     * @return void
     */
    public function setChatId($chatId = null): void
    {
        // для работы с конкретным чатом
        if ($chatId) {
            $this->chatId = $chatId;
        } else {
            Log::info('Не передан ID чата для получения настроек');
        }
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
            if ($message['_'] != 'message' || $message['message'] == '') {
                continue;
            }
//            echo '<pre>'; print_r($message); exit();
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
                'date' => isset($message['date']) ? (int) $message['date'] : null,
                'views' => isset($message['views']) ? (int) $message['views'] : null,
                'forwards' => isset($message['forwards']) ? (int) $message['forwards'] : null,
                'msg' => $message['message'],
                'is_appartment' => 0,
                'photo' => $imageName,
            ];

            try {
                $r = RawTelegramMsg::updateOrCreate($rawMsgData, $updateMsgData);
                Log::info('Сообщение '. $message['id'] .' записали в БД. Фото: '. $imageName);
                dump('Сообщение '. $message['id'] .' записали в БД. Данные: '. json_encode($updateMsgData));
            } catch (Exception $exception) {
                Log::error($exception->getMessage());;
            }
        }
        $this->setNewCurrentMsgId();

        return true;
    }

    /**
     * Обновить ID последнего сообщения в телеграм чате и получить настройки чата
     * @param array $chatIds
     * @return bool
     */
    public function updateChatSettings(array $chatIds): bool
    {
        $dialogsList = $this->MadelineProto->getFullDialogs();

        if (!count($dialogsList)) {
            Log::info('Chats not found');
            return true;
        }

        foreach ($dialogsList as $chatId => $dialog) {
            if (!in_array($chatId, $chatIds)) {
                continue;
            }

            $this->chatId = $chatId;
            $photoInfo = $this->MadelineProto->getPropicInfo($this->chatId);
            $this->getChatAvatar($photoInfo);

            $updData = [
                'chat_photo' => $photoInfo['name'] . $photoInfo['ext']
            ];
            $this->updateChatInfo($updData);

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
        $rawMsgs = RawTelegramMsg::where('chat_id', $this->chatId)
            ->whereNull('status')
            ->orderBy('date', 'asc')
//            ->limit(1)
            ->get();

        foreach ($rawMsgs as $rawMsg) {
            // разбиваем на строки для удобства обработки
            $rawMsgArr = explode(PHP_EOL, $rawMsg->msg);

            if (count($rawMsgArr) < 5) {
                continue;
            }

            $newsCheckData = [
                'chat_id' => $this->chatId,
                'msg_id' => $rawMsg->msg_id,
            ];

            $newsData = [
                'date' => $rawMsg->date,
                'title' => $this->getTitle($rawMsgArr),
                'body' => $rawMsg->msg,
                'announcement' => $this->getAnnounce($rawMsg->msg),
                'link' => '',
                'status' => 0
            ];

            $r = News::updateOrCreate($newsCheckData, $newsData);
            Log::info('Новость '. $this->chatId .':'. $rawMsg->msg_id .' обработана.');
        }

        return true;
    }

    /**
     * Установить новое текущее сообщение для телеграм чата
     * @return void
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
    protected function getMsgImage($message): string|null
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
            $msgIds = RawTelegramMsg::where('is_appartment', 1)->whereNull('photo')->pluck('msg_id')->toArray();
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

    /**
     * Проверяет наличие фото, скачивает на сервер и возвращает имя файла
     * @param array $fileInfo
     * @return null|string
     */
    protected function getChatAvatar(array $fileInfo): string|null
    {
        $imageName = '';

        try {
            $path = storage_path(TelegramChat::$baseAvatarPath . $this->chatId );
            $mkDirResult = @File::makeDirectory($path, 0777, true, true);
            $imageName = $this->MadelineProto->downloadToDir($fileInfo, $path);
        } catch (Exception $exception) {
            Log::error('getChatAvatar. '. $exception->getMessage());
        }

        return $imageName;
    }

    /**
     * Обновить информацию о чате
     * @param array $updData
     * @return void
     */
    protected function updateChatInfo(array $updData): void
    {
        $comparedValues = [
            'chat_id' => $this->chatId,
        ];

        try {
            TelegramChat::updateOrCreate($comparedValues, $updData);
            Log::info("Updated $this->chatId settings");
        } catch (\danog\MadelineProto\RPCErrorException $e) {
            Log::error($this->chatId .' updateChatInfo Error#1: '. $e->getMessage());
//                dd($chatId .' Error#1: '. $e);
        } catch (\Exception $e) {
            Log::error($this->chatId .' updateChatInfo Error#2: '. $e->getMessage());
//                dd($chatId .' Error#2: '. $e);
        }
    }

    /**
     * Получить заголовок новости
     * @param array $msgStrings
     * @return string
     */
    protected function getTitle(array $msgStrings): string
    {
        $title = $msgStrings[0];
        if (strlen($title) > 255) {
            $title = substr($title, 0, 255);
        }
        $p = strrpos($title, ' ');
        return substr($title, 0, $p);
    }

    /**
     * Вернуть анонс новости
     * @param string $msg
     * @return string
     */
    protected function getAnnounce(string $msg): string
    {
        $announce = mb_substr($msg, 0, 1000);
        $pos = mb_strrpos($announce, ' ');
        return mb_substr($announce, 0, $pos);
    }
}
