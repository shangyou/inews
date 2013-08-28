<?php

use Phpmig\Migration\Migration;

class AddUserCreatePassportId extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec('ALTER TABLE `user` MODIFY COLUMN `create_passport_id` INT(11) DEFAULT NULL AFTER `status`;');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec('ALTER TABLE `user` DROP `create_passport_id`;');
    }
}
