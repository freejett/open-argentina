<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Canvas\Models\Post;
use Illuminate\View\View;

class BlogController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->templateBase .= 'blog.';
        view()->share('templateBase', $this->templateBase);
    }

    /**
     * Список постов
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $posts = Post::published()
                    ->orderBy('published_at', 'desc')
                    ->paginate(20);
//        dd($posts);

        return view($this->templateBase . $this->currentMethod, [
            'posts' => $posts,
        ]);
    }

    /**
     * Просмотр поста
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $post = Post::firstWhere('slug', $slug);;
//        dd($post);

        return view($this->templateBase . $this->currentMethod, [
            'post' => $post,
        ]);
    }


}
