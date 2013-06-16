<?php

namespace Route\Web\Article;

use Route\Web;
use Model\Model;
use ORM;

class Digg extends Web
{
    protected $auth = true;

    public function get()
    {
        if (!$article = Model::factory('Article')
            ->find_one($this->input->params['id'])
        ) {
            $this->alert('Article is not exists');
        }

        if (Model::factory('UserDigg')
            ->where('user_id', $this->user->id)
            ->where('article_id', $this->input->params['id'])
            ->find_one()
        ) {
            $this->alert('You already digg this article');
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
                $this->alert('Digg create error');
            }

            $article->set_expr('digg_count', '`digg_count` + 1');
            $article->save();

            ORM::get_db()->commit();
        } catch (\PDOException $e) {
            ORM::get_db()->rollBack();
            // @TODO Logging
            $this->alert('Digg error because of the bad database');
        }

        $this->redirect($this->input->refer() ? $this->input->refer() : '/p/' . $this->input->param('id'));
    }
}