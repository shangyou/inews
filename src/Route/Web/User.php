<?php

namespace Route\Web;

use Route\Web;
use Model\Model;

class User extends Web
{
    public function get()
    {
        $this->tpl = 'user.php';

        $this->data['author'] = Model::factory('User')->find_one($this->input->params['id']);

        if (!$this->data['author']) {
            $this->alert('User is not exists');
        }

        $this->title = $this->data['author']->name;
    }
}