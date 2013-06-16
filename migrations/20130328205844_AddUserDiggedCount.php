<?php

use Phpmig\Migration\Migration;

class AddUserDiggedCount extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` ADD `digged_count` INT  NULL  DEFAULT 0 AFTER `posts_count`;");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` DROP `digged_count`;");
    }
}
