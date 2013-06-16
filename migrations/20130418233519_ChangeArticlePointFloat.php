<?php

use Phpmig\Migration\Migration;

class ChangeArticlePointFloat extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("ALTER TABLE `article` CHANGE `point` `point` FLOAT NULL  DEFAULT '0';");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("ALTER TABLE `article` CHANGE `point` `point` INT(11) NULL  DEFAULT '0';");
    }
}
