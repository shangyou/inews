<?php

namespace Route\Cli\Job;

use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class AnalysisPoint extends Route
{
    public function run()
    {
        /** @var $articles \Model\Article[] */
        $articles = Model::factory('Article')
            ->where_gte('created_at', date('Y-m-d', strtotime('-1 month')))
            ->find_many();

        foreach ($articles as $article) {
            $article->digg_count = $article->diggs()->count();
            $article->comments_count = $article->comments()->count();
            $article->point = $article->analysisPoint();
            $article->save();
        }

        print Cli::text('Analysis article point ok' . PHP_EOL, 'green');
    }
}