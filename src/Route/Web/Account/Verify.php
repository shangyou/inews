<?php

namespace Route\Web\Account;

use Model\User;
use Route\Web;
use Model\Model;

class Verify extends Web
{
    protected $auth = false;
    protected $title = 'Verify your mail';

    public function get()
    {
        $this->tpl = 'account/verify.php';

        $email = $this->app->cryptor->decrypt($this->input->query('code'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->alert('Verify data is error');
        }

        $user = Model::factory('User')
            ->where('email', $email)
            ->find_one();

        if (!$user) {
            $this->alert('Verify email is not exists');
        }

        if ($user->isUnVerified()) {
            $user->status = User::OK;
            $user->save();
        }
    }
}