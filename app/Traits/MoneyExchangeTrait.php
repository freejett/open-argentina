<?php

namespace App\Traits;

use App\Models\ChatSettings;
use App\Models\RawAppartmentsData;
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
    ];

    protected object $parser;

    /**
     * Инициализация объекта для работы с API Telegram
     * @param null $chatId
     * @return void
     */
    public function telegramInit($chatId = null): void
    {
        $this->MadelineProto = new API('index.madeline');
        $me = $this->MadelineProto->start();

        // для работы с конкретным чатом
        if ($chatId) {
            $this->chatId = $chatId;
        }
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
}