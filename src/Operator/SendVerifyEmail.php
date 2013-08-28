<?php

namespace Operator;

use Helper\Mailer;
use Model\User;

class SendVerifyEmail
{
    public static function perform(User $user)
    {
        if (!$user->email || $user->isOK()) return false;

        if (!$config = config('mail')) return false;

        $link = site_url() . '/account/verify?code=' . urlencode(app()->cryptor->encrypt($user->email));

        try {
            $mailer = new Mailer($config);
            $mailer->to($user->email, $user->name)
                ->subject('[iNews] Please confirm your email address.')
                ->html('Hi ' . $user->name . ',<br /><br />
Please confirm your email address in order to fully-activate your new iNews account.<br/><br/><a href="' . $link . '">' . $link . '</a>')
                ->send();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}