<?php

namespace Route\Api;

use Model\Model;
use Route\Api;

class Alfred extends Api
{
    public function get()
    {
        switch ($this->input->param('type')) {
            case 'index':
                $this->data = Model::factory('Article')->where('status', '1')->order_by_desc('point')->limit(10)->find_array();
                break;
            case 'latest':
                $this->data = Model::factory('Article')->where('status', '1')->order_by_desc('created_at')->limit(10)->find_array();
                break;
            default:
                $this->error('Un-support alfred api "' . $this->input->param('type') . '"');
        }

        // Map site links
        $this->data = array_map(function ($item) {
            if (!$item['link']) $item['link'] = 'http://inews.io/p/' . $item['id'];
            return $item;
        }, $this->data);
    }
}