CREATE TABLE `article` (
  `id`             BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`          VARCHAR(255)        NOT NULL DEFAULT '',
  `link`           VARCHAR(255) DEFAULT '',
  `content`        TEXT,
  `point`          INT(11) DEFAULT '0',
  `comments_count` INT(11) DEFAULT '0',
  `digg_count`     INT(11) DEFAULT '0',
  `modified_at`    DATETIME DEFAULT NULL,
  `created_at`     DATETIME DEFAULT NULL,
  `user_id`        BIGINT(20)          NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `comment` (
  `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text`        TEXT                NOT NULL,
  `modified_at` DATETIME DEFAULT NULL,
  `created_at`  DATETIME DEFAULT NULL,
  `user_id`     BIGINT(20)          NOT NULL DEFAULT '0',
  `article_id`  BIGINT(20)          NOT NULL DEFAULT '0',
  `comment_id`  BIGINT(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  KEY `article_id_2` (`article_id`, `created_at`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(50)      NOT NULL DEFAULT '',
  `password`    VARCHAR(50)      NOT NULL DEFAULT '',
  `email`       VARCHAR(50) DEFAULT '',
  `bio`         TEXT,
  `modified_at` DATETIME DEFAULT NULL,
  `created_at`  DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `user_digg` (
  `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`     BIGINT(20)          NOT NULL,
  `article_id`  BIGINT(20)          NOT NULL,
  `modified_at` DATETIME DEFAULT NULL,
  `created_at`  DATETIME            NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_artcile` (`user_id`, `article_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;