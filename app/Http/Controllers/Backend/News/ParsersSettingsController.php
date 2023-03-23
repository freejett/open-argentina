<?php

namespace App\Http\Controllers\Backend\News;

use App\Http\Controllers\Backend\BackendController;
use App\Models\References\ReferenceExchangeDirections;
use App\Models\Telegram\TelegramChat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ParsersSettingsController extends BackendController
{

    public function __construct()
    {
        parent::__construct();

        $this->telegramTypeName = 'news';
        $this->routePath = 'news.settings';
        $this->telegramTypeId = array_search($this->telegramTypeName, config("parsers.telegram_channel_types"));
//        $this->telegramTypeId = 2;
        $this->templateBase .= $this->routePath .'.';

        view()->share('templateBase', $this->templateBase);
        view()->share('avatarPath', $this->avatarPath);
    }

    /**
     * Список телеграм чатов
     * @return View
     */
    public function index(): View
    {
        $telegramChats = TelegramChat::where('type_id', $this->telegramTypeId)->paginate(50);
//        dd($telegramChats);

      return view($this->templateBase . $this->currentMethod, [
            'telegramChats' => $telegramChats,
//            'exchanges' => $exchanges,
//            'exchangeMsg' => $exchangeMsg,
//            'referenceExchangeDirections' => $this->referenceExchangeDirections,
        ]);
    }

    /**
     * Форма добавления чата
     * @return View
     */
    public function create(): View
    {
        $telegramChat = new TelegramChat();
        return view($this->templateBase . $this->currentMethod, [
            'telegramChat' => $telegramChat
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
//        request()->validate(TelegramChat::$rules);
        $request['type_id'] = $this->telegramTypeId;
        $telegramChat = TelegramChat::create($request->all());

        return redirect()->route('backend.news.settings.index')
            ->with('success', 'TelegramChat created successfully.');
    }

    /**
     * Редактирование настроек канала
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $telegramChat = TelegramChat::find($id);

        return view($this->templateBase . $this->currentMethod, [
            'telegramChat' => $telegramChat,
        ]);
    }

    /**
     * Изменение настроек канала
     * @param Request $request
     * @param TelegramChat $telegramChat
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $telegramChat = TelegramChat::find($id);
//        dd($request->all());
        $telegramChat->update($request->all());

        return redirect()->route('backend.news.settings.edit', $id)
            ->with('success', 'TelegramChat updated successfully');
    }
}
