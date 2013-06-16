<?php

namespace Operator;

use Model\Comment;
use Model\Notify;
use Model\User;

class CommentNotify
{
    public static function perform(Comment $comment)
    {
        if ($comment->comment_id) {
            return;
        }

        $article = $comment->article()->find_one();

        if ($article->user_id != $comment->user_id) {
            Notify::dispense()->create(array(
                'user_id'      => $article->user_id,
                'from_user_id' => $comment->user_id,
                'type'         => Notify::REPLY,
                'object_type'  => $article->type(),
                'object_id'    => $article->id,
                'message'      => $comment->text
            ))->save();
        }

        if (!preg_match_all('/@(\w+)/', $comment->text, $match)) {
            return;
        }

        $users = array();

        foreach ($match[1] as $username) {
            if (isset($users[$username])) {
                continue;
            }

            if (!$user = User::dispense()
                ->where('name', $username)
                ->find_one()
            ) {
                continue;
            }

            // If mention in reply, ignore mention notify
            if ($user->id == $article->user_id) {
                continue;
            }

            $users[$username] = $user->id;
        }

        foreach ($users as $user_id) {
            Notify::dispense()->create(array(
                'user_id'      => $user_id,
                'from_user_id' => $comment->user_id,
                'type'         => Notify::MENTION,
                'object_type'  => $article->type(),
                'object_id'    => $article->id,
                'message'      => $comment->text
            ))->save();
        }
    }
}