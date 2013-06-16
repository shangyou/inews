<?php

namespace Helper;


class Crypt
{
    public static function makePassword($password, $key)
    {
        return sha1($password . '$' . $key);
    }
}