<?php

namespace Route\Api;

use Model\Article;
use Route\Api;
use Model\Model;
use ORM;

class Digg extends Api
{
    protected $auth = true;

    public function post()
    {
        $article = $this->loadArticle();

        if ($this->input->data('action') != 'cancel') {
            $this->digg($article);
        } else {
            $this->cancel($article);
        }
    }

    private function loadArticle()
    {
        if (!$article = Model::factory('Article')
            ->find_one($this->input->data('article_id'))
        ) {
            $this->error('Article is not exists');
        }
        return $article;
    }

    private function digg(Article $article)
    {
        if (Model::factory('UserDigg')
            ->where('user_id', $this->user->id)
            ->where('article_id', $this->input->data('article_id'))
            ->find_one()
        ) {
            $this->error('You already digg this article');
        }

        try {
            ORM::get_db()->beginTransaction();

            if (!Model::factory('UserDigg')
                ->create(array(
                    'user_id'    => $this->user->id,
                    'article_id' => $article->id
                ))
                ->save()
            ) {
                $this->error('Digg create error');
            }

            $article->set_expr('digg_count', '`digg_count` + 1');
            $article->save();

            ORM::get_db()->exec("UPDATE `user` SET `digged_count` = `digged_count` + 1 WHERE `id` = '" . $article->user_id . "'");

            ORM::get_db()->commit();

            $article = $this->loadArticle();
            $this->data['digg_count'] = $article->digg_count;
        } catch (\PDOException $e) {
            ORM::get_db()->rollBack();
            // @TODO Logging
            $this->error('Digg error because of the bad database');
        }

        $this->ok('Digg ok');
    }

    private function cancel($article)
    {
        if (!$user_digg = Model::factory('UserDigg')
            ->where('user_id', $this->user->id)
            ->where('article_id', $this->input->data('article_id'))
            ->find_one()
        ) {
            $this->error('You have not digg this article');
        }

        try {
            ORM::get_db()->beginTransaction();

            if (!$user_digg->delete()) {
                $this->error('Digg cancel error');
            }

            $article->set_expr('digg_count', '`digg_count` - 1');
            $article->save();

            ORM::get_db()->exec("UPDATE `user` SET `digged_count` = `digged_count` - 1 WHERE `id` = '" . $article->user_id . "'");

            ORM::get_db()->commit();

            $article = $this->loadArticle();
            $this->data['digg_count'] = $article->digg_count;
        } catch (\PDOException $e) {
            ORM::get_db()->rollBack();
            // @TODO Logging
            $this->error('Digg cancel error because of the bad database');
        }

        $this->ok('Digg canceled');
    }
}