<?php

namespace Route\Web;

use Model\Model;
use Route\Web;
use Helper\Html;

class Index extends Web
{
    protected $tpl = 'index.php';

    public function get()
    {
        if (($page = $this->input->query('page', 1)) < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $total = Model::factory('Article')->where('status', '1')->count();

        $this->data['articles'] = Model::factory('Article')->where('status', '1')->order_by_desc('point')->offset($offset)->limit($limit)->find_many();

        $this->data['page'] = Html::makePage($this->input->uri(), 'page=(:num)', $page, $total, $limit);
    }
}