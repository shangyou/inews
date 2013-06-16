<?php

namespace Model;

use Pagon\App;

class Event extends Model
{
    public static $_table = 'event';

    public static function findAllTags()
    {
        return array_map(function ($row) {
            return $row['tag'];
        }, static::dispense()->select('tag')->distinct()->find_array());
    }
}