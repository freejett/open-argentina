<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Frontend\FrontController;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->templateBase .= 'pages.';
        view()->share('templateBase', $this->templateBase);
    }

    /**
     * Выводим статическую страницу
     * @param string $pageSlug
     * @return mixed
     */
    public function show(string $pageSlug): mixed
    {
        $page = Page::where('slug', $pageSlug)->first();

        if (!$page) {
            abort(404);
        }

        return view($this->templateBase . $this->currentMethod, [
            'page' => $page,
        ]);
    }
}
