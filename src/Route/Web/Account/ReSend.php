<?php

namespace Route\Web\Account;

use Model\User;
use Route\Web;
use SendGrid;

class ReSend extends Web
{
    protected $auth = true;
    protected $title = 'Resend verify mail';

    public function get()
    {
        $this->tpl = 'account/welcome.php';

        if (!$this->user->isUnVerified()) {
            $this->alert('You don not need re-send verify mail');
        }

        $this->sendVerifyMail($this->user);
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