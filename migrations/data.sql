LOCK TABLES `article` WRITE;

INSERT INTO `article` (`id`, `title`, `link`, `content`, `point`, `comments_count`, `digg_count`, `modified_at`, `created_at`, `user_id`)
  VALUES
  (1, 'Look baidu?', '', 'Baidu is long...', NULL, NULL, NULL, '2013-03-23 00:10:49', '2013-03-23 00:10:49', 2),
  (2, 'Siri是苹果的未来？', 'http://apple4us.com/2012/11/is-siri-really-apple-future-by-kontra-chinese.html', '', NULL, NULL, NULL, '2013-03-23 00:11:56', '2013-03-23 00:11:56', 2),
  (4, 'Mac下支持ssh tunnel的软件罗列', 'http://blog.itman.cc/archives/mac-software-to-support-ssh-tunnel-list/', 'aaa', NULL, NULL, NULL, NULL, '2013-03-23 00:15:23', 3);

UNLOCK TABLES;


LOCK TABLES `comment` WRITE;

INSERT INTO `comment` (`id`, `text`, `modified_at`, `created_at`, `user_id`, `article_id`, `comment_id`)
  VALUES
  (3, '百度就是“狼”', NULL, '2013-03-23 12:15:00', 2, 1, 0);

UNLOCK TABLES;


LOCK TABLES `user` WRITE;

INSERT INTO `user` (`id`, `name`, `password`, `email`, `bio`, `modified_at`, `created_at`)
  VALUES
  (2, 'hfcorriez', '1', 'hfcorriez@gmail.com', 'ddd', '2013-03-22 23:23:47', '2013-03-22 23:23:47'),
  (3, 'sofish', '1', 'sofish@163.com', NULL, '2013-03-22 23:23:47', '2013-03-22 23:23:47');

UNLOCK TABLES;

