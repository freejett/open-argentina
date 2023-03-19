<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BackendController extends Controller
{
    /**
     * Base path for blade templates of entity
     * @var string
     */
    protected string $templateBase = 'backend.';

    /**
     * Current controller's method name for blade path
     * @var string
     */
    protected string $currentMethod = '';

    public function __construct()
    {
        $this->currentMethod = Route::getCurrentRoute()->getActionMethod();

//        view()->share([
//            'menuItems' => $this->getMainMenu(),
//        ]);
    }
}
