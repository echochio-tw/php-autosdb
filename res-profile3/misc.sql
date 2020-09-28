-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Education`;
CREATE TABLE `Education` (
  `profile_id` int(11) NOT NULL,
  `institution_id` int(11) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  PRIMARY KEY (`profile_id`,`institution_id`),
  KEY `education_ibfk_2` (`institution_id`),
  CONSTRAINT `education_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `education_ibfk_2` FOREIGN KEY (`institution_id`) REFERENCES `Institution` (`institution_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Institution`;
CREATE TABLE `Institution` (
  `institution_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`institution_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Institution` (`institution_id`, `name`) VALUES
(6,	'Duke University'),
(7,	'Michigan State University'),
(8,	'Mississippi State University'),
(9,	'Montana State University'),
(5,	'Stanford University'),
(4,	'University of Cambridge'),
(1,	'University of Michigan'),
(3,	'University of Oxford'),
(2,	'University of Virginia');

DROP TABLE IF EXISTS `Position`;
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

-- 2020-09-28 14:28:52
