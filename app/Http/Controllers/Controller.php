<?php

namespace App\Http\Controllers;

use Hu\MadelineProto\Facades\MadelineProto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Базовый путь до аватаров телеграм
     * @var string
     */
    protected string $avatarPath = 'storage/telegram/chats/avatars/';

}
