<?php

namespace Route\Web\Account;

use Helper\Crypt;
use Model\Model;
use Operator\SendVerifyEmail;
use ORM;
use Route\Web;
use SendGrid;

class Register extends Web
{
    protected $auth = false;
    protected $title = 'Register';

    public function get()
    {
        $this->tpl = 'account/register.php';
    }

    public function post()
    {
        $is_verify_user = $this->app->verify_user;

        // Check email
        if (!filter_var($this->input->data('email'), FILTER_VALIDATE_EMAIL)) {
            $this->alert('Email format is wrong');
        }

        // Check user name rule
        if (!preg_match("/^[\w]{4,20}$/", $this->input->data('name'))) {
            $this->alert('User name only use a-z and 0-9, length must be 6-20');
        }

        // Check password length
        if (strlen($this->input->data('password')) < 6) {
            $this->alert('Password length must be great than or equal 6');
        }

        // Check if exists user name
        if (Model::factory('User')
            ->where('name', $this->input->data('name'))
            ->find_one()
        ) {
            $this->alert('User already exists');
        }

        // Check if exists user email
        if (Model::factory('User')
            ->where('email', $this->input->data('email'))
            ->find_one()
        ) {
            $this->alert('Email already taken');
        }

        // Create user
        /** @var $user \Model\User */
        $user = Model::factory('User')->create(array(
            'name'     => $this->input->data('name'),
            'password' => Crypt::makePassword($this->input->data('password'), $this->app->password_salt),
            'email'    => $this->input->data('email'),
            'bio'      => $this->input->data('bio')
        ));

        // If disable verify_user will set user verified automatic.
        if (!$is_verify_user) {
            $user->setVerified();
        }

        try {
            ORM::get_db()->beginTransaction();

            if (!$user->save()) {
                $this->alert('User create error');
            }

            ORM::get_db()->commit();
        } catch (\PDOException $e) {
            $this->alert('User register error because of the bad database');
            //@TODO log
            ORM::get_db()->rollback();
        }

        // login when success
        $this->input->session('login', $user->id);

        // Check if verify user
        if ($is_verify_user) {
            // Send verify email
            SendVerifyEmail::perform($user);
            $this->redirect('/account/welcome');
        } else {
            $this->redirect('/');
        }
    }
}