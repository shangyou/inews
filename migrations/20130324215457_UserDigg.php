<?php

use Phpmig\Migration\Migration;

class UserDigg extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->container['pdo']->exec("CREATE TABLE IF NOT EXISTS `user_digg` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_artcile` (`user_id`,`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->container['pdo']->exec("UPDATE article SET point = 0 WHERE point is NULL");

        $this->container['pdo']->exec("UPDATE article SET comments_count = 0 WHERE comments_count is NULL");

        $this->container['pdo']->exec("UPDATE article SET digg_count = 0 WHERE digg_count is NULL");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->container['pdo']->exec("DROP TABLE IF EXISTS `user_digg`");
    }
}
