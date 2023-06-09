<?php

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Geo\HereMapController;
use App\Http\Controllers\Backend\Parsers\MoneyExchange\TelegramController as MoneyExchangeController;
use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Http\Controllers\Backend\News\ParsersSettingsController as NewsParsersSettingsController;
use App\Http\Controllers\Backend\Parsers\News\TelegramController as NewsTelegramController;
use App\Http\Controllers\Backend\News\NewsController as BackendNewsController;
use App\Http\Controllers\Backend\StageController;
use App\Http\Controllers\Frontend\ApartsController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ExchangeController;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PagesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

/**
 * Парсеры
 */
Route::name('parsers.')->group(function () {
    /**
     * Парсер апартаментов Телеграм
     */
    Route::controller(TelegramController::class)->prefix('telegram')->name('telegram.')->group(function () {
        Route::any('/', 'index')->name('index');
        Route::get('/update_chats_settings', 'updateChatsSettings')->name('update_chats_settings.parser');
        Route::get('/parse', 'parse')->name('parse');
    });

    /**
     * Парсер новостей телеграм
     */
    Route::controller(NewsTelegramController::class)->prefix('news_parser')->name('news.')->group(function () {
        Route::any('/', 'index')->name('index');
        Route::get('/update_chats_settings', 'updateChatsSettings')->name('update_chats_settings.parser');
        Route::get('/parse', 'parse')->name('parse');
    });

    /**
     * Парсер обменных курсов Телеграм
     */
    Route::controller(MoneyExchangeController::class)->prefix('money_exchange')->name('money_exchange.')->group(function () {
        Route::any('/', 'index')->name('index');
        Route::get('/update_chats_settings', 'updateChatsSettings')->name('update_chats_settings.parser');
        Route::get('/parse', 'parse')->name('parse');
        // тестовая функция
        Route::get('/telegram', 'telegram')->name('telegram');
    });
});

/**
 * ГЕО службы
 */
Route::name('geo.')->group(function () {
    /**
     * HERE geocoder
     */
    Route::controller(HereMapController::class)->prefix('here')->name('here.')->group(function () {
        Route::any('/', 'index')->name('index');
    });
});


/**
 * Фронт
 */
Route::name('front.')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('main');

    /**
     * Квартиры
     */
    Route::controller(ApartsController::class)->prefix('aparts')->name('aparts.')->group(function () {
        // список/фильтр квартир
        Route::get('/', 'index')->name('index');
        // страница риэлтора
        Route::get('/realtor/{channel_id}', 'show_realtor')->name('realtor');
        // просмотр квартиры
        Route::get('/{id}/show', 'show')->name('show');
    });

    /**
     * Обменные курсы
     */
    Route::controller(ExchangeController::class)->prefix('exchange')->name('exchange.')->group(function () {
        // обменные курсы каналов
        Route::get('/', 'index')->name('index');
        // просмотр обменных курсов канала
        Route::get('/{channel_name}', 'show')->name('show');
    });

    /**
     *  Новости
     */
    Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
        // список последних записей в блоге
        Route::get('/', 'index')->name('index');
        // просмотр записи
        Route::get('/{id}', 'show')->name('show');
    });

    /**
     * Блог
     */
    Route::controller(BlogController::class)->prefix('blog')->name('blog.')->group(function () {
        // список последних записей в блоге
        Route::get('/', 'index')->name('index');
        // просмотр записи
        Route::get('/{slug}', 'show')->name('show');
    });

    /**
     * Статичные страницы
     */
    Route::controller(PagesController::class)->prefix('page')->name('page.')->group(function () {
        // статичная страница
        Route::get('/{slug}', 'show')->name('show');
    });

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Админка
     */
    Route::name('backend.')->prefix('stage')->group(function () {
        /**
         * Дашборд админки
         */
        Route::controller(StageController::class)->name('stage.')->group(function () {
            // список последних записей в блоге
            Route::get('/', 'index')->name('index');
        });

        Route::prefix('news')->name('news.')->group(function () {
            /**
             * Управление новостями
             */
            Route::resource('list',BackendNewsController::class);

            Route::controller(BackendNewsController::class)->name('list.')->group(function () {
                Route::patch('list/{id}/set_news_status/', 'setNewsStatus')->name('setNewsStatus');
            });

            /**
             * Настройка новостных ТК
             */
            Route::resource('settings',NewsParsersSettingsController::class);
        });
    });
});
