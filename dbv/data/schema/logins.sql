CREATE TABLE `logins` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `logged_in_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_logins_fk_idx` (`user_id`),
  CONSTRAINT `user_logins_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8