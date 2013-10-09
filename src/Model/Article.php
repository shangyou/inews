<?php

namespace Model;

use Pagon\Url;

/**
 * 文章模型
 *
 * @package Model
 * @param string $title     标题
 * @param string $content   内容
 * @param string $link      外链
 */
class Article extends Model
{
    public static $_table = 'article';

    const DELETED = -1;
    const UNCHECKED = 0;
    const OK = 1;

    public function author()
    {
        return $this->belongs_to('User');
    }

    public function comments()
    {
        return $this->has_many('Comment');
    }

    public function diggs()
    {
        return $this->has_many('UserDigg');
    }

    public function link()
    {
        if ($this->content) {
            return '/p/' . $this->id;
        } else {
            return $this->link;
        }
    }

    public function permalink($full = false)
    {
        return ($full ? Url::site() : '') . '/p/' . $this->id;
    }

    public function diggUsers()
    {
        return $this->has_many_through('User', 'UserDigg');
    }

    public function isDiggBy($user_id)
    {
        return (bool)self::factory('UserDigg')
            ->where('user_id', $user_id)
            ->where('article_id', $this->id)
            ->find_one();
    }

    public function analysisPoint()
    {
        $past_time = time() - strtotime($this->created_at);
        $past_hour = ceil($past_time / 3600);

        return ($this->digg_count + $this->comments_count * 0.8 - 1.8 + max((1.5 - $past_hour / 48), 0)) / pow(($past_hour + 2), 1.8);
    }

    public function isDeleted()
    {
        return $this->status == self::DELETED;
    }

    public function isOK()
    {
        return $this->status == self::OK;
    }

    public function isUnChecked()
    {
        return $this->status == self::UNCHECKED;
    }
}