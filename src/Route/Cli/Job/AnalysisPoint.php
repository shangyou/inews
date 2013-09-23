<?php

namespace Route\Cli\Job;

use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class AnalysisPoint extends Route
{
    protected $arguments = array(
        '-a|--all' => array('help' => 'Process all articles'),
    );

    public function run()
    {
        $model = Model::factory('Article');

        if (!$this->params['all']) {
            $model->where_gte('created_at', date('Y-m-d', strtotime('-1 month')));
        }

        /** @var $articles \Model\Article[] */
        $articles = $model->find_many();

        foreach ($articles as $article) {
            $article->digg_count = $article->diggs()->count();
            $article->comments_count = $article->comments()->count();
            $article->point = $article->analysisPoint();
            $article->save();
        }

        print Cli::text('Analysis article point ok' . PHP_EOL, 'green');
    }
}