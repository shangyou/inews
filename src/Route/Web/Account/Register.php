<?php

namespace Route\Web\Account;

use ORM;
use Route\Web;
use Model\Model;
use Helper\Crypt;
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

        $user = Model::factory('User')->create(array(
            'name'     => $this->input->data('name'),
            'password' => Crypt::makePassword($this->input->data('password'), $this->app->password_salt),
            'email'    => $this->input->data('email'),
            'bio'      => $this->input->data('bio')
        ));

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

        // Send verify email
        $this->sendVerifyMail($user);

        // $this->redirect('/account/login');

        // login when success
        $this->input->session('login', $user->id);
        $this->redirect('/account/welcome');
    }

    private function sendVerifyMail($user)
    {
        $link = 'http://' . $this->input->domain() . '/account/verify?code=' . urlencode($this->app->cryptor->encrypt($user->email));

        $sendgrid = new SendGrid($this->app->sendgrid['username'], $this->app->sendgrid['password']);
        $mail = new SendGrid\Mail();
        $mail->addTo($user->email, $user->name)
            ->setFrom('trimidea@gmail.com')
            ->setSubject('[iNews] Please confirm your email address.')
            ->setHtml('Hi ' . $user->name . ',<br /><br />
Please confirm your email address in order to fully-activate your new iNews account.<br/><br/><a href="' . $link . '">' . $link . '</a>')
            ->addFilterSetting('subscriptiontrack', 'enable', false);

        $sendgrid->web->send($mail);
    }
}