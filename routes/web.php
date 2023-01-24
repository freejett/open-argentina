<?php

use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\ApartsController;
use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Http\Controllers\Backend\Geo\HereMapController;

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

//Route::get('/', [Controller::class, 'index'])->name('index');

/**
 * Парсеры
 */
Route::name('parsers.')->group(function () {
    /**
     * Телеграм
     */
    Route::controller(TelegramController::class)->prefix('telegram')->name('telegram.')->group(function () {
        Route::any('/', 'index')->name('index');
        Route::get('/update_chats_settings', 'updateChatsSettings')->name('update_chats_settings.parser');
        Route::get('/parse', 'parse')->name('parse');
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

    // Apartments
    Route::controller(ApartsController::class)->prefix('aparts')->name('aparts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/show', 'show')->name('show');
    });

});
