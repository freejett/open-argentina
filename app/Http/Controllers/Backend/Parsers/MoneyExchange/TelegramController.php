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

    protected array $dialogsList;

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
//        $this->chatId = -1001531614658;
//        $msgIds = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168];
        echo '<pre>';
        $this->dialogsList = $this->MadelineProto->getFullDialogs();
        $this->chatIds = $this->getChatsId();
        $this->getDialogsInfo();
        exit();

//        $t = $this->MadelineProto->getFullInfo(-1001738900965);
//        $messages = $this->MadelineProto->channels->getMessages(channel: $this->chatId, id: $msgIds);
//        echo '<hr><pre>'; print_r($messages);
//        exit();

//        $t = $this->MadelineProto->getFullInfo(-1001686458347);
//        echo '<hr><pre>'; print_r($t);
//
//        $t = $this->MadelineProto->getFullInfo(-1001756848597);
//        echo '<hr><pre>'; print_r($t);
    }

    private function getChatsId()
    {
        $result = [];
        foreach ($this->dialogsList as $key => $diaslog) {
//            if (!isset($diaslog['folder_id'])) {
            if ($diaslog['pinned'] != 1) {
               continue;
            }

            $result[] = $key;
        }

        return $result;
    }

    private function getDialogsInfo()
    {
        foreach ($this->chatIds as $chatId) {
            $chatFullInfo = $this->MadelineProto->getFullInfo($chatId);
            print_r($chatFullInfo); echo '<hr>';
        }
    }
}
