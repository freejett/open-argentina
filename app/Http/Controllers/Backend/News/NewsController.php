<?php

namespace App\Http\Controllers\Backend\News;

use App\Http\Controllers\Backend\BackendController;
use App\Models\News;
use App\Models\Telegram\TelegramChat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class NewsController extends BackendController
{
    protected string $telegramTypeName = 'news';
    protected string $routePath = 'news';

    public function __construct()
    {
        parent::__construct();

        $this->telegramTypeId = array_search($this->telegramTypeName, config("parsers.telegram_channel_types"));
        $this->templateBase .= $this->routePath .'.';

        view()->share('templateBase', $this->templateBase);
        view()->share('avatarPath', $this->avatarPath);
    }

    /**
     * Список новостей
     * @return View
     */
    public function index(): View
    {
        $news = News::orderBy('date', 'desc')->paginate(50);
        $newStatus = News::$newStatus;
//        dd($newStatus);

        return view($this->templateBase . $this->currentMethod, [
            'news' => $news,
            'newStatus' => $newStatus,
        ]);
    }

    /**
     * Редактирование новости
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $news = News::find($id);

        return view($this->templateBase . $this->currentMethod, [
            'news' => $news,
        ]);
    }

    /**
     * Обновление новости
     * @param Request $request
     * @param News $news
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, News $news, int $id): RedirectResponse
    {
        $news->find($id)->update($request->all());
//        dd($news);

        return redirect()->route('backend.news.list.edit', $id)
            ->with('success', 'News updated successfully');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function setNewsStatus(Request $request, News $news, int $id)
    {
        $news->find($id)->update($request->all());
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $news = News::find($id)->delete();

        return redirect()->route('news.index')
            ->with('success', 'News deleted successfully');
    }
}
