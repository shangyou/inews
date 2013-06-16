<?php

namespace Route\Cli\Job;

use Model\Article;
use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class UpdateUser extends Route
{
    public function run()
    {
        $users = Model::factory('User')
            ->find_many();

        foreach ($users as $user) {
            $user->posts_count = $user->articles()->where('status', Article::OK)->count();
            $user->digged_count = 0;
            foreach ($user->articles()->where('status', Article::OK)->find_many() as $article) {
                $user->digged_count += $article->digg_count;
            }
            $user->save();
        }

        print Cli::text('Update user count ok' . PHP_EOL, 'green');
    }
}