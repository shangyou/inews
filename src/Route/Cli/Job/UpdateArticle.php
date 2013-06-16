<?php

namespace Route\Cli\Job;

use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class UpdateArticle extends Route
{
    public function run()
    {
        $articles = Model::factory('Article')
            ->find_many();

        foreach ($articles as $article) {
            $article->comments_count = $article->comments()->count();
            $article->digg_count = Model::factory('UserDigg')->where('article_id', $article->id)->count();
            $article->save();
        }

        print Cli::text('Update article count ok' . PHP_EOL, 'green');
    }
}