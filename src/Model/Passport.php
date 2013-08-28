<?php

namespace Model;

use Pagon\App;

class Passport extends Model
{
    public static $_table = 'passport';

    public function user()
    {
        return $this->belongs_to('User');
    }
}