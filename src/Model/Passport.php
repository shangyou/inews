<?php

namespace Model;

use Pagon\App;

/**
 * 第三方账号模型
 *
 * @package Model
 * @param string $provider        账号来源
 * @param string $uid             账号uid
 * @param string $display_name    账号显示名称
 * @param string $info            账号原始信息
 * @param string $access_token
 * @param string $expired_at
 */
class Passport extends Model
{
    public static $_table = 'passport';

    public function user()
    {
        return $this->belongs_to('User');
    }
}