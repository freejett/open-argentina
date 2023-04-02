<?php

namespace App\Http\Controllers\Backend\Parsers\News;

use App\Http\Controllers\Controller;
use App\Models\Telegram\TelegramChat;
use App\Traits\TelegramNewsTrait;
use Illuminate\Support\Facades\Log;


/**
 * Парсер новостей ТГ-каналов
 */
class TelegramController extends Controller
{
    use TelegramNewsTrait;

    protected array $chatIds;
    protected string $telegramTypeName;
    protected int $telegramTypeId;

    public function __construct()
    {
        $this->telegramTypeName = 'news';
        $this->telegramTypeId = array_search($this->telegramTypeName, config("parsers.telegram_channel_types"));

        $this->chatIds = TelegramChat::where('type_id', $this->telegramTypeId)
//            ->limit(3)
            ->pluck('chat_id')
            ->toArray();
        $this->telegramInit();

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
        foreach ($this->chatIds as $chatId) {
            $this->setChatId($chatId);
            $this->getChatMessages();
        }
        return true;
    }

    /**
     * Парсим данные из сообщений
     * @return bool
     */
    public function parse(): bool
    {
        foreach ($this->chatIds as $chatId) {
            $this->setChatId($chatId);
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
        $this->updateChatSettings($this->chatIds);
        return true;
    }

}
