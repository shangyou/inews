<?php

use Phpmig\Migration\Migration;

class NotifyTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("CREATE TABLE IF NOT EXISTS `notify`(
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `user_id` bigint(20) NOT NULL,
  `from_user_id` bigint(20) DEFAULT NULL,
  `object_type` varchar(50) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_status` (`user_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("DROP TABLE IF EXISTS `notify`;");
    }
}
