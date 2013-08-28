<?php

namespace Route\Web\Account;

use Model\User;
use Operator\SendVerifyEmail;
use ORM;
use Pagon\Http\Input;
use Route\Web;
use Model\Model;
use Helper\Crypt;
use SendGrid;

class Edit extends Web
{
    protected $title = 'Edit Profile';

    public function get()
    {
        $this->tpl = 'account/edit.php';
    }

    public function post(Input $req)
    {
        // Check email
        if (!filter_var($req->data('email'), FILTER_VALIDATE_EMAIL)) {
            $this->alert('Email format is wrong');
        }

        if ($password = $req->data('password')) {
            // Check password length
            if (strlen($req->data('password')) < 6) {
                $this->alert('Password length must be great than or equal 6');
            }

            if ($req->data('password') != $req->data('re_password')) {
                $this->alert('Password dose not match');
            }
        }

        $this->user->set('bio', $req->data('bio'));

        // Change password
        if ($password) {
            $this->user->password = Crypt::makePassword($password, $this->app->password_salt);
        }

        $send = false;
        // Change email
        if ($this->user->email != $req->data('email')) {
            // Check if exists user email
            if (Model::factory('User')
                ->where('email', $req->data('email'))
                ->find_one()
            ) {
                $this->alert('Email already taken');
            }

            $this->user->email = $req->data('email');
            $this->user->status = User::UNVERIFIED;
            $send = true;
        }

        try {
            if (!$this->user->save()) {
                $this->alert('User create error');
            }
        } catch (\PDOException $e) {
            $this->alert('User register error because of the bad database');
        }

        if ($send) {
            // Send verify email
            SendVerifyEmail::perform($this->user);
        }

        $this->redirect('/u/' . $this->user->id);
    }
}