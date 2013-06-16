<?php

use Phpmig\Migration\Migration;

class AddUserStatus extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` ADD `status` TINYINT  NULL  DEFAULT 0 AFTER `bio`;");

        $this->container['pdo']->exec('UPDATE `user` SET `status` = 1');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` DROP `status`;");
    }
}
