<?php

namespace App\Traits;

use App\Models\ChatSettings;
use App\Models\Telegram\TelegramChat;
use App\Models\RawTelegramMsg;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

trait MoneyExchangeTrait
{
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
     * Настройки чата
     * @var object
     */
    protected object $chatSettings;

    /**
     * Парсеры обменных курсов
     * @var array|string[]
     */
    protected array $parsers = [
        'cashflowexchange' => \App\Parsers\Exchange\Telegram\CashflowExchange::class,
        'ArgentinaUSD' => \App\Parsers\Exchange\Telegram\ArgentinaUSD::class,
    ];

    protected object $parser;

    /**
     * Инициализация объекта для работы с API Telegram
     * @param null $chatId
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

            $rawMsgData = [
                'chat_id' => $this->chatId,
                'msg_id' => $message['id'],
            ];

            $updateMsgData = [
                'msg' => $message['message'],
                'is_appartment' => 0,
            ];

            try {
                $r = RawTelegramMsg::updateOrCreate($rawMsgData, $updateMsgData);
                Log::info('Сообщение '. $message['id'] .' записали в БД.');
                dump('Сообщение '. $this->chatId .':'. $message['id'] .' записали в БД. Данные: '. json_encode($updateMsgData));
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
        // определяем класс-обработчик для парсинга данных
        $this->getParser();

        // парсим данные в классе-парсере
        $this->parser->parse($this->chatId);

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
     * Массив ID сообщений для telegram
     * @return array
     */
    protected function getMsgsIds(): array
    {
        $msgIds = [];

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
     * Определить класс-обработчик
     * @return void
     */
    protected function getParser(): void
    {
        $this->chatSettings = ChatSettings::where('chat_id', $this->chatId)->first();
        $chatName = $this->chatSettings->chat_name;
        $this->parser = new $this->parsers[$chatName];
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
            $mkDirResult = File::makeDirectory($path, 0777, true, true);
            $imageName = $this->MadelineProto->downloadToDir($fileInfo, $path);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());;
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
}
