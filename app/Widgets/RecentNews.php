<?php

namespace App\Widgets;

use App\Models\News;
use Arrilot\Widgets\AbstractWidget;

class RecentNews extends AbstractWidget
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
        $news = News::with('channel')
            ->active()
            ->orderBy('date', 'desc')
            ->limit(9)
            ->get();

        return view('widgets.recent_news', [
            'news' => $news,
        ]);
    }
}
