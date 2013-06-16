<?php

namespace Model;

class UserDigg extends Model
{
    public static $_table = 'user_digg';

    public function article()
    {
        return $this->has_one('Article');
    }

    public function user()
    {
        return $this->has_one('User');
    }
}