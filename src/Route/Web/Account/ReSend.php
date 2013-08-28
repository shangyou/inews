<?php

namespace Route\Web\Account;

use Helper\Mailer;
use Model\User;
use Operator\SendVerifyEmail;
use Route\Web;
use SendGrid;

class ReSend extends Web
{
    protected $auth = true;
    protected $title = 'Resend verify mail';

    public function get()
    {
        $this->tpl = 'account/welcome.php';

        if ($this->user->isOK()) {
            $this->alert('You don not need re-send verify mail');
        }

        if (!$this->user->email) {
            $this->alert("No email found, can not reactive!");
        }

        SendVerifyEmail::perform($this->user);
    }
}