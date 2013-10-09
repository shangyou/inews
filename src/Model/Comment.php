<?php

namespace Model;

/**
 * 评论模型
 *
 * @package Model
 * @param string $text            内容
 * @param string $article_id      所属文章
 * @param string $comment_id      父级评论ID
 */
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