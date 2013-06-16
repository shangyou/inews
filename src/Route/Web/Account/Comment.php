<?php

namespace Route\Web\Account;

use Helper\Html;
use Route\Web;

class Comment extends Web
{
    protected $auth = true;
    protected $tpl = 'account/comment.php';
    protected $title = 'My comments';

    public function get()
    {
        if (($page = $this->input->query('page', 1)) < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $total = $this->user->comments()->count();

        $this->data['comments'] = $this->user->comments()->offset($offset)->limit($limit)->order_by_desc('created_at')->find_many();

        $this->data['page'] = Html::makePage($this->input->uri(), 'page=(:num)', $page, $total, $limit);
    }
}