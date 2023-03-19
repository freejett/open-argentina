<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StageController extends BackendController
{
    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'stage.';
//        $this->routeBase = 'template.';

        view()->share('templateBase', $this->templateBase);
//        view()->share('routeBase',    $this->routeBase);
    }

    public function index(): View
    {
        return view($this->templateBase . $this->currentMethod, [
            'check' => 'cheeeck',
        ]);
    }
}
