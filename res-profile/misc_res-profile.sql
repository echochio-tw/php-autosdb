-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Profile`;
CREATE TABLE `Profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `headline` text DEFAULT NULL,
  `summary` text DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  KEY `profile_ibfk_2` (`user_id`),
  CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `email_2` (`email`),
  KEY `password_2` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_id`, `name`, `email`, `password`) VALUES
(1,	'Chuck',	'csev@umich.edu',	'1a52e17fa899cf40fb04cfc42e6352f1'),
(2,	'UMSI',	'umsi@umich.edu',	'1a52e17fa899cf40fb04cfc42e6352f1');

-- 2020-09-21 04:48:17
