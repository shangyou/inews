<?php

use Phpmig\Migration\Migration;

class AddArticleStatus extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("ALTER TABLE `article` ADD `status` TINYINT  NULL  DEFAULT 0 AFTER `digg_count`;");

        $this->container['pdo']->exec('UPDATE `article` SET `status` = 1');
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("ALTER TABLE `article` DROP `status`;");
    }
}
