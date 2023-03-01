<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MoneyExchange;
use App\Models\RawTelegramMsg;
use App\Models\References\ReferenceExchangeDirections;
use App\Models\Telegram\TelegramChat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExchangeController extends FrontController
{
    /**
     * Список направлений обмена валют курсов
     * @var Collection
     */
    public Collection $referenceExchangeDirections;

    /**
     * Названия ТГ-каналов-обменников
     * @var Collection
     */
    public Collection $chatsNames;

    public string $avatarPath = 'storage/telegram/chats/avatars/';

    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'exchange.';
        view()->share('templateBase', $this->templateBase);
        view()->share('avatarPath', $this->avatarPath);

        $this->referenceExchangeDirections = ReferenceExchangeDirections::all()->keyBy('direction_id');
        $this->chatsNames = collect(config('parsers.exchange.telegram'));
    }

    /**
     * Страница обменных курсов всех каналов
     * @return View
     */
    public function index(): View
    {
        // текущие курсы обмена
        $exchanges = MoneyExchange::getExchanges();
        // информация по чатам с обменом валют
        $telegramChatsInfo = TelegramChat::where('type_id', 2)->get()->keyBy('chat_id');
//        dd($exchanges);

        return view($this->templateBase . $this->currentMethod, [
            'referenceExchangeDirections' => $this->referenceExchangeDirections,
            'exchanges' => $exchanges,
            'chatsNames' => $this->chatsNames,
            'telegramChatsInfo' => $telegramChatsInfo,
        ]);
    }

    /**
     * Просмотр обменных курсов канала
     * @param string $channelName
     * @return View
     */
    public function show(string $channelName): View
    {
        $telegramChat = TelegramChat::where('username', $channelName)->first();
        // текущие курсы обмена канала
        $exchanges = MoneyExchange::getCurrentExchangesForChat($telegramChat->chat_id);
        // последнее сообщение в чате
        $exchangeMsg = RawTelegramMsg::where('chat_id', $telegramChat->chat_id)->orderBy('msg_id', 'desc')->first();
//        dd($exchangeMsg);

        return view($this->templateBase . $this->currentMethod, [
            'telegramChat' => $telegramChat,
            'exchanges' => $exchanges,
            'exchangeMsg' => $exchangeMsg,
            'referenceExchangeDirections' => $this->referenceExchangeDirections,
        ]);
    }
}
