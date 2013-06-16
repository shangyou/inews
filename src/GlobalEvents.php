<?php

use Model\Comment;
use Model\Notify;
use Model\User;
use Operator\CommentNotify;
use Pagon\App;

class GlobalEvents
{
    public static function register(App $app)
    {
        $app->on('comment', function (Comment $comment) {
            CommentNotify::perform($comment);
        });
    }
}