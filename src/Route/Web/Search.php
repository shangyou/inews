<?php

namespace Route\Web;

use Model\Model;
use Route\Web;
use Helper\Html;

class Search extends Web
{
    protected $tpl = 'index.php';

    public function get()
    {
        if (($page = $this->input->query('page', 1)) < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $kw = $this->input->query('kw');

        $total = Model::factory('Article')->where('status', '1')->where_like('title', '%' . $this->input->query('kw') . '%')->count();

        $this->data['kw'] = $kw;
        $this->data['articles'] = Model::factory('Article')->where('status', '1')->where_like('title', '%' . $kw . '%')->order_by_desc('point')->offset($offset)->limit($limit)->find_many();

        $this->data['page'] = Html::makePage($this->input->uri(), 'page=(:num)', $page, $total, $limit);
    }
}