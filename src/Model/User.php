<?php

namespace Model;

use Pagon\App;

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