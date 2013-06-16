<?php

namespace Model;

use Model\Model;

class Notify extends Model
{
    public static $_table = 'notify';

    const READ = 1;
    const UNREAD = 0;

    const REPLY = 1;
    const MENTION = 2;

    public static function getUserUnreadCount($user_id)
    {
        return self::dispense()->where('user_id', $user_id)->where('status', self::UNREAD)->count();
    }

    public function user()
    {
        return $this->belongs_to('User');
    }

    public function sender()
    {
        return $this->belongs_to('User', 'from_user_id');
    }

    public function object()
    {
        return $this->belongs_to($this->object_type, 'object_id');
    }

    public function markRead()
    {
        $this->status = self::READ;
        return $this;
    }

    public function isRead()
    {
        return $this->status == self::READ;
    }
}