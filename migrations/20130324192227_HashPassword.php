<?php

use Phpmig\Migration\Migration;
use Helper\Crypt;

class HashPassword extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $query = $this->container['pdo']->query('SELECT * FROM `user`');

        $password = array();
        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            if (strlen($row['password']) < 40) {
                $password[$row['id']] = Crypt::makePassword($row['password'], $this->container['app']->password_salt);
            }
        }

        foreach ($password as $id => $pass) {
            $this->container['pdo']->exec("UPDATE `user` SET `password` = '{$pass}' WHERE `id` = '$id'");
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
    }
}
