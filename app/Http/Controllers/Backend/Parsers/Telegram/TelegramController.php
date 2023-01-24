<?php

namespace App\Http\Controllers\Backend\Parsers\Telegram;

use App\Helpers\Functions;
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

    public const CHAT_IDS = [-1001632649859];
    public const CHAT_ID = -1001632649859;

    /**
     * Получаем сообщения из телеграм канала и записываем в БД
     * @return bool
     */
    public function index(): bool
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->getChatMessages();

        return true;
    }

    /**
     * Парсим данные из сообщений
     * @return bool
     */
    public function parse(): bool
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->parseRawData();

        return true;
    }

    /**
     * Обновить ID последнего сообщения в телеграм чате и настройки чата
     * @return bool
     */
    public function updateChatsSettings(): bool
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->updateChatSettings();

        return true;
    }

}
