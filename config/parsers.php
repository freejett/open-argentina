<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Типы телеграм каналов
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'telegram_channel_types' => [
        1 => 'aparts',
        2 => 'exchange',
        3 => 'news',
        4 => 'poster',
    ],

    /*
    |--------------------------------------------------------------------------
    | Парсеры данных
    |--------------------------------------------------------------------------
    |
    | Парсеры квартир, обменных курсов и т/д/
    |
    */


    'aparts' => [
        'telegram' => [
            -1001632649859 => 'ArgentinaHouse',
//            -1001671940764 => 'buenas_hatas',
        ],
        'telegraph' => [],
        'instagram' => [],
    ],
    'exchange' => [
        'telegram' => [
            -1001531614658 => 'cashflowexchange',
            -1001828314778 => 'ArgentinaUSD',
            -1001686458347 => 'WesternUrion',
            -1001756848597 => 'argentina_crypto',
            -1001738900965 => 'ArsExchange',
        ],
    ],

];
