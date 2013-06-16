<?php

namespace Route\Web\Account;

use Route\Web;
use Model\Model;
use Helper\Crypt;

class Login extends Web
{
    protected $auth = false;
    protected $title = 'Login';

    public function get()
    {
        if ($this->user) $this->redirect('/');

        $this->tpl = 'account/login.php';
    }

    public function post()
    {
        if (filter_var($this->input->data('name'), FILTER_VALIDATE_EMAIL)) {
            if (!$user = Model::factory('User')
                ->where('email', $this->input->data('name'))
                ->find_one()
            ) {
                $this->alert('User email not found');
            }
        } else {
            if (!$user = Model::factory('User')
                ->where('name', $this->input->data('name'))
                ->find_one()
            ) {
                $this->alert('User name not found');
            }
        }

        if ($user->password != Crypt::makePassword($this->input->data('password'), $this->app->password_salt)) {
            $this->alert('User name and password is not match');
        }

        $this->input->session('login', $user->id);

        $this->redirect($this->input->query('continue') ? $this->input->query('continue') : '/');
    }
}