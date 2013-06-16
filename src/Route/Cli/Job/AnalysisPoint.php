<?php

namespace Route\Cli\Job;

use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class AnalysisPoint extends Route
{
    public function run()
    {
        $articles = Model::factory('Article')
            ->find_many();

        foreach ($articles as $article) {
            $article->point = $article->analysisPoint();
            $article->save();
        }

        print Cli::text('Analysis article point ok' . PHP_EOL, 'green');
    }
}