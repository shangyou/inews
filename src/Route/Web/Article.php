<?php

namespace Route\Web;

use Route\Web;
use Model\Model;

class Article extends Web
{
    public function get()
    {
        $this->tpl = 'article.php';

        $this->data['article'] = Model::factory('Article')->find_one($this->input->params['id']);

        if (!$this->data['article']) {
            $this->alert('Article is not exists');
        }

        // Un-normal Article is only display for his author
        if (!$this->data['article']->isOK()
            && (!$this->user || $this->data['article']->user_id != $this->user->id)
        ) {
            $this->alert('Article is not ready');
        }

        $this->data['comments'] = $this->data['article']->comments()->order_by_desc('created_at')->find_many();

        $this->title = $this->data['article']->title;
    }
}