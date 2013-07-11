<?php

namespace Route;

use Helper\Html;
use Model\Model;
use Pagon\Route\Rest;
use Pagon\Url;
use Route\Web;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed extends Rest
{
    protected $tpl = 'index.php';

    public function get()
    {
        $this->app->loadOrm();

        $posts = Model::factory('Article')->where('status', '1')->order_by_desc('point')->limit(10)->find_many();

        $feed = new Feed();

        $channel = new Channel();
        $channel
            ->title(config('site.title'))
            ->description(config('site.default_meta'))
            ->url(Url::site())
            ->appendTo($feed);

        foreach ($posts as $post) {
            $item = new Item();
            /** @var $post \Model\Article */
            $item
                ->title($post->title)
                ->description(Html::fromMarkdown($post->content))
                ->url($post->permalink(true))
                ->pubDate(strtotime($post->created_at))
                ->appendTo($channel);
        }

        echo substr($feed, 0, -1);
    }
}