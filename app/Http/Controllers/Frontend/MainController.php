<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Frontend\ApartsFilter;
use App\Models\ApartmentsData;
use App\Models\MoneyExchange;
use App\Models\References\ReferenceExchangeDirections;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends FrontController
{
    protected array $chatIds;

    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'main.';
//        $this->routeBase = 'template.';
        $this->pageTitle = 'Открытая Аргентина. Поиск квартиры, недвижимости, обменных курсов, услул, новости Буэнос-Айреса, Аргентины и Латинской Америки';
        $this->metaDescription = 'Открытая Аргентина. Поиск квартиры, недвижимости, обменных курсов, услул, новости Буэнос-Айреса, Аргентины и Латинской Америки';
        $this->metaKeyword = 'Найти квартиру Буэнос-Айрес, обмен валюты Буэнос-Айрес, снять квартиру, новости Буэнос-Айрес';

        view()->share('templateBase', $this->templateBase);
//        view()->share('routeBase',    $this->routeBase);
        view()->share('title',    $this->pageTitle);
        view()->share('description',    $this->metaDescription);
        view()->share('keyword',    $this->metaKeyword);
    }

    /**
     * @param Request $request
     * @param ApartsFilter $filter
     * @return View
     */
    public function index(Request $request, ApartsFilter $filter): View
    {
//        $lastPosts = \Canvas\Models\Post::published()->limit(5)->get();
//        dd($lastPosts);
        // квартиры для карты
        $apartments = ApartmentsData::select('id', 'title', 'lat', 'lng', 'price')
            ->filter($filter)
            ->where('chat_id', -1001632649859)
            ->whereNull('status')
            ->get();

        // направления обмена
        $referenceExchangeDirections = ReferenceExchangeDirections::all()->keyBy('direction_id');
        // текущие курсы обмена
        $exchange = MoneyExchange::getTodayExchanges();

        return view($this->templateBase . $this->currentMethod, [
            'apartments' => $apartments,
            'referenceExchangeDirections' => $referenceExchangeDirections,
            'exchange' => $exchange,
        ]);
    }
}
