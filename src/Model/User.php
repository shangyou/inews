<?php

namespace Model;

use Pagon\App;

/**
 * 用户模型
 *
 * @package Model
 * @param string $name                 名称
 * @param string $password             加密密码
 * @param string $email                邮箱
 * @param string $bio                  账号BIO
 * @param string $posts_count          发送数量
 * @param string $digged_count         顶帖数量
 * @param int    $status               状态
 */
class User extends Model
{
    public static $_table = 'user';

    const UNVERIFIED = 0;
    const OK = 1;

    public function articles()
    {
        return $this->has_many('Article');
    }

    public function comments()
    {
        return $this->has_many('Comment');
    }

    public function diggs()
    {
        return $this->has_many_through('Article', 'UserDigg');
    }

    public function notifies()
    {
        return $this->has_many('Notify');
    }

    public function setVerified()
    {
        $this->status = self::OK;
        return $this;
    }

    public function unreadNotifyCount()
    {
        return Notify::getUserUnreadCount($this->id);
    }

    public function isUnVerified()
    {
        return $this->status == self::UNVERIFIED;
    }

    public function isOK()
    {
        return $this->status == self::OK;
    }

    public function isAdmin()
    {
        return $this->isSuperAdmin() || false;
    }

    public function isSuperAdmin()
    {
        return ($admins = App::self()->get('admins')) ? in_array($this->name, $admins) : false;
    }
}