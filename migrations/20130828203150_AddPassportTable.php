<?php

use Phpmig\Migration\Migration;

class AddPassportTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("CREATE TABLE `passport` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(10) DEFAULT NULL,
  `uid` varchar(50) NOT NULL DEFAULT '',
  `display_name` varchar(20) DEFAULT NULL,
  `info` text,
  `user_id` int(11) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider` (`provider`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("DROP TABLE IF EXISTS `passport`;");
    }
}
