<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Frontend\ApartsFilter;
use App\Http\Controllers\Controller;
use App\Models\ApartmentsData;
use App\Models\MoneyExchange;
use App\Models\References\ReferenceExchangeDirections;
use Illuminate\Http\Request;

class MainController extends FrontController
{
    protected array $chatIds;

    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'main.';
//        $this->routeBase = 'template.';
//        $this->pageTitle = 'Шаблоны оповещений';

        view()->share('templateBase', $this->templateBase);
//        view()->share('routeBase',    $this->routeBase);
//        view()->share('title',    $this->pageTitle);
    }

    public function index(Request $request, ApartsFilter $filter)
    {
        // квартиры для карты
        $apartments = ApartmentsData::select('id', 'title', 'lat', 'lng', 'price')
            ->filter($filter)
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
