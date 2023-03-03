<?php

namespace App\Http\Controllers\Backend\Parsers\MoneyExchange;

use App\Http\Controllers\Controller;
use App\Models\ChatSettings;
use App\Models\Telegram\TelegramChat;
use App\Traits\MoneyExchangeTrait;
use Illuminate\Support\Facades\Log;

/**
 * Парсер данных по обменным курсам из Телеграм каналов
 */
class TelegramController extends Controller
{
    use MoneyExchangeTrait;

    protected array $chatIds;

    public function __construct()
    {
        //*
        $this->chatIds = config('parsers.exchange.telegram');
        $this->chatIds = collect($this->chatIds)->keys()->toArray();
        /*/
            $this->chatIds = TelegramChat::select('chat_id')->where('type_id', 2)->pluck('chat_id')->toArray();
        //*/
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
//            dd($this->MadelineProto);
            // список чатов
//            $dialogsList = $this->MadelineProto->getFullDialogs();
//            echo '<pre>'; print_r($dialogsList); exit();

            // получить сообщения чата
            $this->getChatMessages();

            /**
             * получить и сохранить аватарку чата
             */
            $photoInfo = $this->MadelineProto->getPropicInfo($chatId);
            $this->getChatAvatar($photoInfo);

            $updData = [
                'chat_photo' => $photoInfo['name'] . $photoInfo['ext']
            ];
            $this->updateChatInfo($updData);

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
        foreach ($this->chatIds as $chatId) {
            $this->setChatId($chatId);
            $this->updateChatSettings();
        }

        return true;
    }

    // [pinned] => 1
    public function telegram()
    {
//        $dialogsList = $this->MadelineProto->getFullDialogs();
//        echo '<pre>'; print_r($dialogsList); exit();

        $t = $this->MadelineProto->getFullInfo(-1001738900965);
        echo '<hr><pre>'; print_r($t);

//        $t = $this->MadelineProto->getFullInfo(-1001686458347);
//        echo '<hr><pre>'; print_r($t);
//
//        $t = $this->MadelineProto->getFullInfo(-1001756848597);
//        echo '<hr><pre>'; print_r($t);
    }
}
