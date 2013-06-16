<?php

namespace Model;

class Comment extends Model
{
    public static $_table = 'comment';

    public function article()
    {
        return $this->belongs_to('Article');
    }

    public function user()
    {
        return $this->belongs_to('User');
    }

    public function parent()
    {
        return $this->belongs_to('Comment');
    }
}