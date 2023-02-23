<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MoneyExchange;
use App\Models\References\ReferenceExchangeDirections;
use App\Models\Telegram\TelegramChat;
use Illuminate\Http\Request;

class ExchangeController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'exchange.';
        view()->share('templateBase', $this->templateBase);
    }

    public function index()
    {
        // направления обмена
        $referenceExchangeDirections = ReferenceExchangeDirections::all()->keyBy('direction_id');
        // текущие курсы обмена
        $exchanges = MoneyExchange::getExchanges();
        // названия ТГ-каналов
        $chatsNames = config('parsers.exchange.telegram');
        // информация по чатам с обменом валют
        $telegramChatsInfo = TelegramChat::where('type_id', 2)->get()->keyBy('chat_id');
//        dd($telegramChatsInfo);

        return view($this->templateBase . $this->currentMethod, [
            'referenceExchangeDirections' => $referenceExchangeDirections,
            'exchanges' => $exchanges,
            'chatsNames' => $chatsNames,
            'telegramChatsInfo' => $telegramChatsInfo,
        ]);
    }
}
