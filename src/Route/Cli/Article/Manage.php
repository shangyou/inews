<?php

namespace Route\Cli\Article;

use Model\Article;
use Model\Model;
use Pagon\Cli;
use Route\Cli as Route;

class Manage extends Route
{
    protected $arguments = array(
        'id' => array('help' => 'Article id to destroy'),
    );

    public function run()
    {
        $post = Model::factory('Article')->find_one($this->params['id']);

        if (!$post) {
            echo Cli::text('Article is not exists' . PHP_EOL, 'red');
        }

        echo 'Article is ' . PHP_EOL . PHP_EOL . "\t" . Cli::text($post->title, 'green') . PHP_EOL . PHP_EOL;

        switch ($this->input->param('action')) {
            case 'delete':
                if (!Cli::confirm('Do you want to delete')) {
                    return;
                }
                $post->status = Article::DELETED;
                $post->save();
                break;
            case 'revert':
                $post->status = Article::OK;
                $post->save();
                break;
            default:
                echo Cli::text('Error action!', 'red') . PHP_EOL;
        }

        echo 'Action done!' . PHP_EOL;
    }
}