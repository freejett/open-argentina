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
     * @var string
     */
    protected string $routePrefix = 'front';

    /**
     * Тег Title
     * @var string
     */
    protected string $pageTitle = '';

    /**
     * Тег Description
     * @var string
     */
    protected string $metaDescription = '';

    /**
     * Тег Keyword
     * @var string
     */
    protected string $metaKeyword = '';

    /**
     * Current controller's method name for blade path
     * @var string
     */
    protected string $currentMethod = '';

    public function __construct()
    {
        $this->currentMethod = Route::getCurrentRoute()->getActionMethod();

        view()->share([
            'title' => $this->pageTitle,
            'description' => $this->metaDescription,
            'keyword' => $this->metaKeyword,
            'menuItems' => $this->getMainMenu(),
            'avatarPath' => $this->avatarPath,
            'tgLinkBase' => $this->tgLinkBase,
        ]);
    }

    protected function getMainMenu(): array
    {
        return [
            route($this->routePrefix .'.main') => '<i class="fa fa-home" aria-hidden="true"></i>',
            route($this->routePrefix .'.aparts.index') => 'Поиск квартиры',
            route($this->routePrefix .'.exchange.index') => 'Обмен валюты',
            '2' => 'Каталог услуг',
            route($this->routePrefix .'.news.index') => 'Новости',
            route($this->routePrefix .'.blog.index') => 'Блог',
            '4' => 'Контакты',
        ];
    }
}
