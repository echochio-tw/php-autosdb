-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `misc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `misc`;

DROP TABLE IF EXISTS `autos`;
CREATE TABLE `autos` (
  `auto_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `make` varchar(128) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `autos` (`auto_id`, `make`, `year`, `mileage`) VALUES
(14,	'Kia',	1974,	132489),
(16,	'FCA Italy\'; DROP TABLE autos;\'-- ?',	2014,	316211),
(17,	'Mitsubishi Motors Co',	2006,	337183),
(18,	'&lt;b&gt;Mercedes-Benz Bold&lt;/b&gt;',	1978,	79812),
(19,	'FOMOCO\'; DROP TABLE autos;\'-- ?',	2005,	120141);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `password` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`password`) VALUES
('php123');

-- 2020-09-14 03:22:12
