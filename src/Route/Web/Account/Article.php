<?php

namespace Route\Web\Account;

use Helper\Html;
use Route\Web;

class Article extends Web
{
    protected $auth = true;
    protected $tpl = 'account/article.php';
    protected $title = 'My posts';

    public function get()
    {
        if (($page = $this->input->query('page', 1)) < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $total = $this->user->articles()->where_gt('status', '-1')->count();

        $this->data['articles'] = $this->user->articles()->where_gt('status', '-1')->offset($offset)->limit($limit)->order_by_desc('created_at')->find_many();

        $this->data['page'] = Html::makePage($this->input->uri(), 'page=(:num)', $page, $total, $limit);
    }
}