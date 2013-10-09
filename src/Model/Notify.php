<?php

namespace Model;

use Model\Model;

/**
 * 通知模型
 *
 * @package Model
 * @param string $type              类型
 * @param string $status            状态
 * @param string $user_id           来源ID
 * @param string $from_user_id      目标ID
 * @param string $object_type       所属对象类型
 * @param string $object_id         所属对象ID
 */
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