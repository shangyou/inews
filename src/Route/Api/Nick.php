<?php

namespace Route\Api;

use Model\Model;
use Route\Api;

class Nick extends Api
{
    public function get()
    {
        if ($this->user) {
            $this->data = $this->user->name;
        } else {
            $this->data = '';
        }
    }
}