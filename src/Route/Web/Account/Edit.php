<?php

namespace Route\Web\Account;

use Model\User;
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
            $this->user->password = Crypt::makePassword($password, $this->app->salt);
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
            $this->sendVerifyMail($this->user);
        }

        $this->redirect('/u/' . $this->user->id);
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