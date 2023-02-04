<?php

namespace App\Http\Controllers\Backend\Parsers\Telegram;

use App\Helpers\StringFunctions;
use App\Http\Controllers\Controller;
use App\Models\ApartmentsData;
use App\Models\ChatSettings;
use App\Models\RawAppartmentsData;
use App\Traits\TelegramTrait;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Log;
use danog\MadelineProto\Exception;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\Logger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


/**
 * Если передавать с параметром ?only_photos=1
 * то будут выкачиваться фото для сообщений, у которых есть фото и оно не скачено
 * Нужно доработать так, чтобы выкачивалось не больше 10 фото за раз (пагинация)
 */
class TelegramController extends Controller
{
    use TelegramTrait;

    /**
     * Получаем сообщения из телеграм канала и записываем в БД
     * @return bool
     */
    public function index(): bool
    {
        $chatIds = config('parsers.aparts.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.aparts.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
//            $this->telegramInit($chatId);
//            $this->getChatMessages();

            $cashMsg = RawAppartmentsData::where('chat_id', $chatId)->orderBy('msg_id', 'desc')->get()->toArray();
            echo '<pre>'; print_r($cashMsg); exit();
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
        $chatIds = config('parsers.aparts.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.aparts.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
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
        $chatIds = config('parsers.aparts.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.aparts.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->updateChatSettings();
        }

        return true;
    }

}
