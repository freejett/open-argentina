<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class FrontController extends Controller
{
    /**
     * Base path for blade templates of entity
     * @var string
     */
    protected string $templateBase = 'frontend.';

    /**
     * Current controller's method name for blade path
     * @var string
     */
    protected string $currentMethod = '';

    public function __construct()
    {
        $this->currentMethod = Route::getCurrentRoute()->getActionMethod();

        view()->share([
            'menuItems' => $this->getMainMenu(),
        ]);
    }

    protected function getMainMenu(): array
    {
        return [
            route('front.main') => '<i class="fa fa-home" aria-hidden="true"></i>',
            route('front.aparts.index') => 'Поиск квартиры',
            route('front.exchange.index') => 'Обмен валюты',
            '2' => 'Каталог услуг',
            route('front.blog.index') => 'Блог / Новости',
            '4' => 'Контакты',
        ];
    }
}
