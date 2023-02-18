<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Canvas\Models\Post;

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
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function index(Request $request): mixed
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
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function show(string $slug): mixed
    {
        $post = Post::firstWhere('slug', $slug);;
//        dd($post);

        return view($this->templateBase . $this->currentMethod, [
            'post' => $post,
        ]);
    }


}
