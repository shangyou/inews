<?php

namespace Route\Web;

use Model\Model;
use Route\Web;
use Helper\Html;

class Leader extends Web
{
    protected $tpl = 'leader.php';
    protected $title = 'Leaders';

    public function get()
    {
        $this->data['leaders'] = Model::factory('User')->where('status', '1')->order_by_desc('digged_count')->limit(18)->find_many();
    }
}