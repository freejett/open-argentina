<?php

namespace App\Widgets;

use App\Models\MoneyExchange;
use App\Models\References\ReferenceExchangeDirections;
use Arrilot\Widgets\AbstractWidget;

class ExchangeRate extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $exchangeDirectionsId = [1,3,5];
        $exchange = MoneyExchange::getTodayExchanges($exchangeDirectionsId);
        $referenceExchangeDirections = ReferenceExchangeDirections::all()->keyBy('direction_id');

        return view('widgets.exchange_rate', [
            'config' => $this->config,
            'referenceExchangeDirections' => $referenceExchangeDirections,
            'exchange' => $exchange,
        ]);
    }
}
