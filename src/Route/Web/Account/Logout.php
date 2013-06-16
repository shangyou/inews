<?php

namespace Route\Web\Account;

use Route\Web;
use Model\Model;

class Logout extends Web
{
    protected $auth = true;
    
    public function get()
    {
        $this->input->session('login', '0');

        $this->redirect('/');
    }
}