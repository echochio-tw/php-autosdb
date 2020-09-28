-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `Position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`position_id`),
  KEY `position_ibfk_1` (`profile_id`),
  CONSTRAINT `position_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Position` (`position_id`, `profile_id`, `rank`, `year`, `description`) VALUES
(2,	2,	1,	1911,	'test1'),
(3,	3,	1,	1911,	'test3'),
(4,	3,	2,	1912,	'test3');

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

INSERT INTO `Profile` (`profile_id`, `user_id`, `first_name`, `last_name`, `email`, `headline`, `summary`) VALUES
(2,	1,	'test2',	'test2',	'test2@',	'test2',	'test2'),
(3,	1,	'test3',	'test3',	'test3@',	'test3',	'test3');

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

-- 2020-09-22 17:29:40
