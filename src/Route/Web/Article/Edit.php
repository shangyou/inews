<?php

namespace Route\Web\Article;

use Model\Article;
use Model\Model;
use Route\Web;

class Edit extends Web
{
    protected $auth = true;

    public function get()
    {
        $this->tpl = 'submit.php';
        $article = Model::factory('Article')->find_one($this->input->params['id']);

        if (!$article) {
            return $this->data['alert'] = 'Article is not exists. Submit a new one?';
        }

        if (!$this->user->isAdmin() && $article->user_id != $this->user->id) {
            return $this->data['alert'] = 'Article only can be edit by owner. Submit a new one?';
        }

        $this->data['article'] = $article;
    }

    public function post()
    {
        $this->tpl = 'submit.php';

        if (!$article = Model::factory('Article')
            ->find_one($this->input->params['id'])
        ) {
            return $this->alert('Article is not exists');
        }

        if (!$this->user->isAdmin() && $article->user_id != $this->user->id) {
            return $article->alert('Article only can be edit by owner');
        }

        // not url or content
        $input = $this->input;
        if (
            !($input->data('title') &&
            ($input->data('link') || $input->data('content')))
        ) return $this->redirect('/p/' . $article->id . '/edit');

        $article->title = $input->data('title');
        $article->link = $input->data('link');
        $article->content = $input->data('content');
        $article->save();

        $this->redirect('/p/' . $article->id);
    }
}