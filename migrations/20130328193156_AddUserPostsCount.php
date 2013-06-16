<?php

use Phpmig\Migration\Migration;

class AddUserPostsCount extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` ADD `posts_count` INT  NULL  DEFAULT 0 AFTER `bio`;");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("ALTER TABLE `user` DROP `posts_count`;");
    }
}
