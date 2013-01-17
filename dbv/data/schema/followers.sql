CREATE TABLE `followers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `friend_id` bigint(20) NOT NULL,
  `fullname` varchar(128) DEFAULT NULL,
  `is_markio_friend` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pair` (`user_id`,`friend_id`),
  KEY `user_fk_idx` (`user_id`),
  CONSTRAINT `follower_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8