<?php

namespace Route\Web\Article;

use Model\Article;
use Model\Model;
use Route\Web;

class Destroy extends Web
{
    protected $auth = true;

    public function get()
    {
        if (!$article = Model::factory('Article')
            ->find_one($this->input->params['id'])
        ) {
            $this->alert('Article is not exists');
        }

        if (!$this->user->isAdmin() && $article->user_id != $this->user->id) {
            $this->alert('Article only can be deleted by owner');
        }

        $this->tpl = 'article/delete.php';
    }

    public function post()
    {
        if (!$article = Model::factory('Article')
            ->find_one($this->input->params['id'])
        ) {
            $this->alert('Article is not exists');
        }

        if (!$this->user->isAdmin() && $article->user_id != $this->user->id) {
            $this->alert('Article only can be deleted by owner');
        }

        $article->status = Article::DELETED;
        $article->save();

        $this->redirect('/my/posts');
    }
}