<?php

namespace Route\Web\Account;

use Route\Web;

class Welcome extends Web
{
    protected $auth = false;
    protected $tpl = 'account/welcome.php';
    protected $title = 'Welcome';

    public function get()
    {
    }
}