<?php

namespace App\Http\Controllers\Backend\Parsers\Telegram;

use App\Http\Controllers\Controller;
use App\Traits\TelegramTrait;
use Illuminate\Support\Facades\Log;


/**
 * Если передавать с параметром ?only_photos=1
 * то будут выкачиваться фото для сообщений, у которых есть фото и оно не скачено
 * Нужно доработать так, чтобы выкачивалось не больше 10 фото за раз (пагинация)
 */
class TelegramController extends Controller
{
    use TelegramTrait;

    protected array $chatIds;

    public function __construct()
    {
        $this->chatIds = config('parsers.exchange.telegram');
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
        foreach ($this->chatIds as $chatId => $chatName) {
            $this->setChatId($chatId);
            $this->getChatMessages();

//            $cashMsg = RawTelegramMsg::where('chat_id', $chatId)->orderBy('msg_id', 'desc')->get()->toArray();
//            echo '<pre>'; print_r($cashMsg); exit();
        }

//        $dialogsList = $this->MadelineProto->getFullDialogs();
//
//        if (!count($dialogsList)) {
//            Log::info('Chats not found');
//            return true;
//        }
//        echo '<pre>'; print_r($dialogsList); exit();

//        $this->chatId = TelegramController::CASH_CHAT_ID;
//        $this->updateChatSettings();
//        $this->getChatMessages();

//        $cashMsg = RawAppartmentsData::where('chat_id', TelegramController::CASH_CHAT_ID)->get()->toArray();
//        echo '<pre>'; print_r($cashMsg); exit();

        return true;
    }

    /**
     * Парсим данные из сообщений
     * @return bool
     */
    public function parse(): bool
    {
        foreach ($this->chatIds as $chatId => $chatName) {
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
        foreach ($this->chatIds as $chatId => $chatName) {
            $this->setChatId($chatId);
            $this->updateChatSettings();
        }

        return true;
    }

}
