<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Canvas\Models\Post;

class RecentPosts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $lastPosts = Post::published()
            ->limit(5)
            ->get();

        return view('widgets.recent_posts', [
            'config' => $this->config,
            'lastPosts' => $lastPosts,
        ]);
    }
}
