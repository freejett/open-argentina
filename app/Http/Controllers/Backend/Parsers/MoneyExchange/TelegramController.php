<?php

namespace App\Http\Controllers\Backend\Parsers\MoneyExchange;

use App\Helpers\StringFunctions;
use App\Http\Controllers\Controller;
use App\Models\ChatSettings;
use App\Models\RawAppartmentsData;
use App\Parsers\Exchange\MoneyExchangeInterface;
use App\Traits\MoneyExchangeTrait;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use danog\MadelineProto\Exception;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\Logger;

/**
 * Парсер данных по обменным курсам из Телеграм каналов
 */
class TelegramController extends Controller
{
    use MoneyExchangeTrait;

    protected array $chatIds;

    public function __construct()
    {
        $this->chatIds = config('parsers.exchange.telegram');

        if (!count($this->chatIds)) {
            Log::info('Не найдены чаты parsers.exchange.telegram для обновления параметров');
            return true;
        }
    }

    /**
     * Получаем сообщения из телеграм канала и записываем в БД
     * @return bool
     */
    public function index(): bool
    {
        foreach ($this->chatIds as $chatId => $chatName) {
//            $this->telegramInit($chatId);
//            $this->getChatMessages();

            $cashMsg = RawAppartmentsData::where('chat_id', $chatId)->orderBy('msg_id', 'desc')->get()->toArray();
            echo '<pre>'; print_r($cashMsg); //exit();
        }
        return true;
    }

    /**
     * Парсим данные из сообщений
     * @return bool
     */
    public function parse(): bool
    {
        foreach ($this->chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->parseRawData();
        }

        return true;
    }

    /**
     * Обновить ID последнего сообщения в телеграм чате и настройки чата
     * @return bool
     */
    public function updateChatsSettings(): bool
    {
        foreach ($this->chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->updateChatSettings();
        }

        return true;
    }
}