<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->templateBase .= 'news.';

        $this->pageTitle = 'Open Argentina. Новости Буэнос-Айреса Аргентины и Латинской Америки';
        $this->metaDescription = 'Open Argentina. Новости Аргентины и Латинской Америки';
        $this->metaKeyword = 'Новости Буэнос-Айрес, Новости Аргентина, Новости Чили, Новости Бразилия, Новости Латинская Америка';

        view()->share('title', $this->pageTitle);
        view()->share('description', $this->metaDescription);
        view()->share('keyword', $this->metaKeyword);
        view()->share('templateBase', $this->templateBase);
    }

    /**
     * Список постов
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $news = News::with('channel')
            ->active()
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view($this->templateBase . $this->currentMethod, [
            'news' => $news,
        ]);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $news = News::with('channel')
            ->active()
            ->find($id);
//        dd($news);

        return view($this->templateBase . $this->currentMethod, [
            'news' => $news,
        ]);
    }
}
