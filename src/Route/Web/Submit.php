<?php

namespace Route\Web;

use Model\Article;
use ORM;
use Route\Web;
use Model\Model;

class Submit extends Web
{
    protected $auth = true;
    protected $title = 'Share one';

    public function get()
    {
        $this->tpl = 'submit.php';

        // 支持一下 url 发布
        $input = $this->input;
        if (!$this->user->isUnVerified() && $input->query('title') && ($input->query('link') || $input->query('content'))) {
            $article = new \stdClass();
            $article->title = $input->query('title');
            $article->link = $input->query('link');
            $article->content = $input->query('content');
            $this->data['article'] = $article;
        }
    }

    public function post()
    {
        if ($this->user->isUnVerified()) {
            $this->alert('Your account is not active now, plz check your mail and active.');
        }

        if (!$this->input->data('link') && !$this->input->data('content')) {
            $this->alert('At least one between url and content');
        }

        // Check link format
        if ($this->input->data('link') && !filter_var($this->input->data('link'), FILTER_VALIDATE_URL)) {
            $this->alert('Url format is wrong');
        }

        // Check url if exists
        if ($this->input->data('link')
            && Model::factory('Article')
                ->where('link', $this->input->data('link'))
                ->find_one()
        ) {
            $this->alert('Url "' . $this->input->data('link') . '" is already exists');
        }

        // Check title
        if (!$this->input->data('title')) {
            $this->alert('Title need');
        }

        $article = Model::factory('Article')->create(array(
            'title'   => $this->input->data('title'),
            'link'    => $this->input->data('link'),
            'content' => $this->input->data('content'),
            'user_id' => $this->user->id,
            'status'  => Article::OK
        ));

        try {
            ORM::get_db()->beginTransaction();
            if (!$article->save()) {
                $this->alert('Submit error');
            }

            $this->user->set_expr('posts_count', '`posts_count` + 1');
            $this->user->save();
            ORM::get_db()->commit();
        } catch (\PDOException $e) {
            ORM::get_db()->rollback();
            $this->alert('Share error with error database');
        }

        $this->redirect('/p/' . $article->id);
    }
}