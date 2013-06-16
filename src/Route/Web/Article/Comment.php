<?php

namespace Route\Web\Article;

use Route\Web;
use Model\Model;
use ORM;

class Comment extends Web
{
    protected $auth = true;

    public function post()
    {
        if ($this->user->isUnVerified()) {
            $this->alert('Your account is not active now, plz check your mail and active.');
        }

        if (!$article = Model::factory('Article')
            ->find_one($this->input->param('id'))
        ) {
            $this->alert('Article is not exists');
        }

        $comment = Model::factory('Comment')->create(array(
            'article_id' => $this->input->param('id'),
            'text'       => $this->input->data('text'),
            'user_id'    => $this->user->id,
        ));

        try {
            ORM::get_db()->beginTransaction();

            if (!$comment->save()) {
                $this->alert('Comment create error');
            }

            $article->set_expr('comments_count', '`comments_count` + 1');
            $article->save();

            ORM::get_db()->commit();
        } catch (\PDOException $e) {
            ORM::get_db()->rollBack();
            // @TODO Logging
            $this->alert('Comment error because of the bad database');
        }

        $this->app->emit('comment', $comment);

        $this->redirect('/p/' . $comment->article_id);
    }
}