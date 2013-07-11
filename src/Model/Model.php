<?php

namespace Model;

use Helper\Time;

/**
 * Class Model
 *
 * @package Model
 * @param int $id
 * @param string $modified_at
 * @param string $created_at
 */
class Model extends \Model
{
    /**
     * @param string|null $connection
     * @return \ORM|\ORMWrapper|static|Model
     */
    public static function dispense($connection = null)
    {
        return self::factory(self::model(), $connection);
    }

    /**
     * Model type
     *
     * @return string
     */
    public static function model()
    {
        return substr(get_called_class(), strlen(__NAMESPACE__) + 1);
    }

    /**
     * Get model type dynamic
     *
     * @return string
     */
    public function type()
    {
        return self::model();
    }

    /**
     * Save
     *
     * @return mixed
     */
    public function save()
    {
        if ($this->is_new()) {
            $this->created_at = Time::now();
        } else {
            $this->modified_at = Time::now();
        }
        return parent::save();
    }
}