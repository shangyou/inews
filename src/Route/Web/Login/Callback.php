<?php

namespace Route\Web\Login;

use Model\Model;
use Model\User;
use Route\Web;

class Callback extends Web
{
    public function post()
    {
        if (!isset($this->input->auth)) {
            $this->alert('Authorize failed!');
        }

        $auth = $this->input->auth['auth'];

        try {
            if ($passport = Model::factory('Passport')
                ->where('provider', $auth['provider'])
                ->where('uid', $auth['uid'])->find_one()
            ) {
                $passport->access_token = $auth['credentials']['token'];
                $passport->expired_at = !empty($auth['credentials']['expires']) ? $auth['credentials']['expires'] : null;
                $passport->save();
            } else {
                // 检查当前是否有登陆用户
                if (!$user_id = $this->input->session('login')) {
                    // 没有用户创建一个
                    $user = Model::factory('User')->create();
                    $user->name = $auth['info']['name'];

                    if (isset($auth['info']['description']) && ($bio = $auth['info']['description'])
                        || isset($auth['raw']['description']) && ($bio = $auth['raw']['description'])
                    ) {
                        $user->bio = $bio;
                    }

                    if (isset($auth['info']['email']) && ($email = $auth['info']['email'])) {
                        $user->email = $email;
                    }

                    $user->status = User::OK;
                    $user->save();
                    $user_id = $user->id;
                }

                // 绑定Passport
                $passport = Model::factory('Passport')->create();
                $passport->provider = $auth['provider'];
                $passport->uid = $auth['uid'];
                $passport->display_name = $auth['info']['nickname'];
                $passport->access_token = $auth['credentials']['token'];
                $passport->expired_at = !empty($auth['credentials']['expires']) ? $auth['credentials']['expires'] : null;
                $passport->user_id = $user_id;
                $passport->save();

                if (!empty($user)) {
                    $user->create_passport_id = $passport->id;
                    $user->save();
                }
            }
        } catch (\Exception $e) {
            $this->alert("Create user error!");
        }

        $this->input->session('login', $passport->user_id);
        $this->redirect('/');
    }
}