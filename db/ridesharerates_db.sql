-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `api_key` varchar(500) NOT NULL,
  `google_api_key` varchar(250) NOT NULL,
  `driver_rate` varchar(5) NOT NULL,
  `paypal_id` varchar(250) NOT NULL,
  `paypal_password` varchar(250) NOT NULL,
  `signature` text NOT NULL,
  `paypal_account` enum('sandbox','live') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'sandbox',
  `admin_fee` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `username`, `password`, `api_key`, `google_api_key`, `driver_rate`, `paypal_id`, `paypal_password`, `signature`, `paypal_account`, `admin_fee`) VALUES
(2,	'admin',	'21232f297a57a5a743894a0e4a801fc3',	'AIzaSyBsNTGBg_lUc9bVaSglWAUb3LmFF8HB1Cg',	'AIzaSyBsNTGBg_lUc9bVaSglWAUb3LmFF8HB1Cg',	'10',	'',	'',	'',	'sandbox',	34)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `username` = VALUES(`username`), `password` = VALUES(`password`), `api_key` = VALUES(`api_key`), `google_api_key` = VALUES(`google_api_key`), `driver_rate` = VALUES(`driver_rate`), `paypal_id` = VALUES(`paypal_id`), `paypal_password` = VALUES(`paypal_password`), `signature` = VALUES(`signature`), `paypal_account` = VALUES(`paypal_account`), `admin_fee` = VALUES(`admin_fee`);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `app_fixed_bank`;
CREATE TABLE `app_fixed_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(200) NOT NULL,
  `routing_number` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `app_fixed_bank` (`id`, `bank_name`, `routing_number`) VALUES
(1,	'Republic Bank & Trust',	264171241)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `bank_name` = VALUES(`bank_name`), `routing_number` = VALUES(`routing_number`);

DROP TABLE IF EXISTS `book_request`;
CREATE TABLE `book_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `mechanic_id` int DEFAULT NULL,
  `description` text NOT NULL,
  `lat` varchar(150) NOT NULL,
  `lang` varchar(150) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1:Active 2:Inactive',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `book_request_image`;
CREATE TABLE `book_request_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT 'A:Active 2: Inactive',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(50) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1:Active 2:Inactive',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `brands` (`id`, `brand_name`, `status`, `created_date`, `updated_date`) VALUES
(1,	'Suzuki',	'1',	'2020-07-20 13:33:06',	'2023-04-14 05:31:58'),
(2,	'Audi',	'1',	'2020-07-29 14:47:13',	'2020-07-29 14:47:13'),
(3,	'Acura',	'1',	'2020-10-29 08:05:31',	'2020-10-29 08:05:31'),
(4,	'Alfa Romeo',	'1',	'2020-10-29 08:08:33',	'2020-10-29 08:08:33'),
(5,	'BMW',	'1',	'2020-10-29 08:08:45',	'2020-10-29 08:08:45'),
(6,	'Bentley',	'1',	'2020-10-29 08:09:20',	'2020-10-29 08:09:20'),
(7,	'Buick',	'1',	'2020-10-29 08:09:28',	'2020-10-29 08:09:28'),
(8,	'Cadillac',	'1',	'2020-10-29 08:09:36',	'2020-10-29 08:09:36'),
(9,	'Chevrolet',	'1',	'2020-10-29 08:09:47',	'2020-10-29 08:09:47'),
(10,	'Chrysler',	'1',	'2020-10-29 08:09:56',	'2020-10-29 08:09:56'),
(11,	'Dodge',	'1',	'2020-10-29 08:10:03',	'2020-10-29 08:10:03'),
(12,	'Fiat',	'1',	'2020-10-29 08:10:11',	'2020-10-29 08:10:11'),
(13,	'Ford',	'1',	'2020-10-29 08:10:18',	'2020-10-29 08:10:18'),
(14,	'GMC',	'1',	'2020-10-29 08:10:26',	'2020-10-29 08:10:26'),
(15,	'Honda',	'1',	'2020-10-29 08:10:48',	'2020-10-29 08:10:48'),
(16,	'Hyundai',	'1',	'2020-10-29 08:10:55',	'2020-10-29 08:10:55'),
(17,	'Jaguar',	'1',	'2020-10-29 08:11:02',	'2020-10-29 08:11:02'),
(18,	'Jeep',	'1',	'2020-10-29 08:11:10',	'2020-10-29 08:11:10'),
(19,	'Kia',	'1',	'2020-10-29 08:11:16',	'2023-04-14 05:40:03'),
(20,	'Land Rover',	'1',	'2020-10-29 08:11:35',	'2020-10-29 08:11:35'),
(21,	'Lexus',	'1',	'2020-10-29 08:11:43',	'2023-04-14 05:40:14'),
(22,	'Mercedes-Benz',	'1',	'2020-10-29 08:11:55',	'2023-04-14 05:35:43'),
(23,	'Mitsubishi',	'1',	'2020-10-29 08:12:03',	'2020-10-29 08:12:03'),
(24,	'Nikola',	'1',	'2020-10-29 08:12:12',	'2020-10-29 08:12:12'),
(25,	'Nissan',	'1',	'2020-10-29 08:12:19',	'2020-10-29 08:12:19'),
(26,	'Porsche',	'1',	'2020-10-29 08:12:27',	'2020-10-29 08:12:27'),
(27,	'Tesla',	'1',	'2020-10-29 08:13:20',	'2020-10-29 08:13:20'),
(28,	'Toyota',	'1',	'2020-10-29 08:13:27',	'2023-04-14 05:32:46'),
(29,	'Volkswagen',	'1',	'2020-10-29 08:13:37',	'2020-10-29 08:13:37'),
(30,	'Volvo',	'1',	'2020-10-29 08:13:43',	'2020-10-29 08:13:43')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `brand_name` = VALUES(`brand_name`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `cancelled_ride`;
CREATE TABLE `cancelled_ride` (
  `id` int NOT NULL AUTO_INCREMENT,
  `driver_id` int NOT NULL,
  `ride_id` int NOT NULL,
  `reason` char(150) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_id` (`driver_id`),
  KEY `ride_id` (`ride_id`),
  CONSTRAINT `cancelled_ride_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `cancelled_ride_ibfk_2` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cancelled_ride` (`id`, `driver_id`, `ride_id`, `reason`, `created_date`, `updated_date`) VALUES
(1,	1004,	4398,	NULL,	'2024-01-31 09:40:28',	'2024-01-31 09:40:28'),
(2,	1024,	4402,	NULL,	'2024-02-08 00:00:39',	'2024-02-08 00:00:39'),
(3,	1024,	4408,	NULL,	'2024-02-08 18:45:27',	'2024-02-08 18:45:27')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `driver_id` = VALUES(`driver_id`), `ride_id` = VALUES(`ride_id`), `reason` = VALUES(`reason`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `card_detail`;
CREATE TABLE `card_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `card_number` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expiry_month` varchar(2) DEFAULT NULL,
  `expiry_date` year DEFAULT NULL,
  `card_holder_name` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `customer_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `billing_address` varchar(150) NOT NULL,
  `is_default` enum('1','2') NOT NULL COMMENT '1:Active 2: Inactive',
  `default_source` varchar(150) NOT NULL,
  `card_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `card_detail` (`id`, `user_id`, `card_number`, `expiry_month`, `expiry_date`, `card_holder_name`, `bank_name`, `customer_id`, `billing_address`, `is_default`, `default_source`, `card_type`, `date`) VALUES
(1,	982,	'a09Gc09TVHkxRjBLYjlvNzlRa0J2dUtyS3h0TXZYNEFFL3krVzJVbWhhWT0=',	'12',	'2025',	'M1FZanozNU1UOW01MHIxWVFCSzZYUT09',	'',	'cus_PKrwJyEz52y81A',	'Patiala',	'1',	'card_1OWCCCAyQV9SI7qTu3ZdKY97',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-08 01:20:26'),
(2,	983,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'02',	'2025',	'VGVBcVFDQWhmenh3Tmg4SnR0SFViUT09',	'',	'cus_PKvqrYrbuMNRgE',	'Noida ',	'1',	'card_1OWFynAyQV9SI7qT7SyuuaG4',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-08 05:22:51'),
(3,	985,	'ZCtzakJkcGpHWE9TRlRjMW0xdHVrUFZyVFZac0ZzWERsSGlTS1o0WnVwUT0=',	'12',	'2025',	'M1FZanozNU1UOW01MHIxWVFCSzZYUT09',	'',	'cus_PKwLpFi8w79yyH',	'Aggaha',	'1',	'card_1OWGT0AyQV9SI7qT3dKcaBvN',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-08 05:54:04'),
(4,	989,	'a09Gc09TVHkxRjBLYjlvNzlRa0J2dUtyS3h0TXZYNEFFL3krVzJVbWhhWT0=',	'12',	'2025',	'M1FZanozNU1UOW01MHIxWVFCSzZYUT09',	'',	'cus_PLerCg4YWjmeKN',	'Vvbb',	'1',	'card_1OWxXJAyQV9SI7qTeKsEUwVx',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-10 03:53:23'),
(5,	995,	'ZCtzakJkcGpHWE9TRlRjMW0xdHVrUFZyVFZac0ZzWERsSGlTS1o0WnVwUT0=',	'12',	'2025',	'M1FZanozNU1UOW01MHIxWVFCSzZYUT09',	'',	'cus_PLizgwSMgamNFi',	'Ha',	'1',	'card_1OX1XxAyQV9SI7qT9JEN3CsP',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-10 08:10:18'),
(6,	994,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'02',	'2025',	'UDArTUgrdk5HQmI1Tzh5M0RzeWphZz09',	'',	'cus_PLyWPSJrmAjwhf',	'noida',	'1',	'card_1OXGYwAyQV9SI7qThUdH5Gja',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-11 00:12:20'),
(7,	1008,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'02',	'2025',	'VGVBcVFDQWhmenh3Tmg4SnR0SFViUT09',	'',	'cus_POFMgeGL6CmeJv',	'Noida',	'1',	'card_1OZSsCAyQV9SI7qTkbfONHC3',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-17 01:45:18'),
(8,	1009,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'02',	'2027',	'MFEzQ2ltdzhoQmY4NC9lbXl1WjZlQT09',	'',	'cus_POJuVwhRg8RD8N',	'2996 Spruce Circle Snellville GA 30078',	'1',	'card_1OZXGsAyQV9SI7qTanSOG5Hw',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-17 06:27:03'),
(9,	1011,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'02',	'2027',	'aTYyeXE4RDhHdTlXa056R3d4ZDNuUT09',	'',	'cus_PPPHZpH6Ehj7ur',	'2996 Spruce Circle Snellville GA 30078',	'1',	'card_1OaaSnAyQV9SI7qTPHr703Cq',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-20 04:03:43'),
(10,	1012,	'eUF4d3hjWjY2MjdNa3NOWEh1TXRGc0ZDaUU3bjhNVFJRSW5qSU5UdzFVcz0=',	'04',	'2029',	'K2laZllsYk1XQTdic21TYlhEc3p3QT09',	'',	'cus_PQKWXCD76ApfsU',	'3411 Chattahoochee cir Roswell GA 30075',	'1',	'card_1ObTrNAyQV9SI7qT52mEnSJG',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-22 15:12:46'),
(11,	1013,	'ZCtzakJkcGpHWE9TRlRjMW0xdHVrUFZyVFZac0ZzWERsSGlTS1o0WnVwUT0=',	'12',	'2025',	'M1FZanozNU1UOW01MHIxWVFCSzZYUT09',	'',	'cus_PQT8rlgA8uN98R',	'patiala',	'1',	'card_1ObcCOAyQV9SI7qTX7mKeU9o',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-23 00:07:01'),
(12,	1018,	'bFViekxMZ2ZycUJ1UXZBS2ZWM0lLSmRlVlFkWDl5RmxUYzJZVEYzeWdwYz0=',	'2',	'2029',	'MFEzQ2ltdzhoQmY4NC9lbXl1WjZlQT09',	'',	'cus_PQmCb2BwUCgw5h',	'2996 Spruce circle Snellville Ga 30078',	'1',	'card_1Obue3AyQV9SI7qToPkedYMH',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-01-23 19:48:50'),
(13,	1017,	'aUllbTZSbUxzRTcwY3NwVXlaYURkU1VJQUZycjFHMjZxTUV1eXFWSnFrQT0=',	'02',	'2029',	'VGozZDkzcllyYUZJV3psUXlmY1l1QT09',	'',	'cus_PRWkPCgOJB3FGZ',	'2996 spruce circle Snellville GA 30078',	'1',	'card_1Ocdh5AyQV9SI7qTrdK0v5Jz',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-01-25 19:54:57'),
(14,	1023,	'c0dSNXU0SDRMMGFIY3lkZFJwTXRaVVJQSStQS2pJcGhyUERqQWJMWVNsTT0=',	'5',	'2027',	'KzV1OG1GWFc1OWY0UHNFUUhMWWJxZz09',	'',	'cus_PU90SdisYeZ27D',	'3752 BrookWood Blvd  Rex ga 30273',	'1',	'card_1OfAi0AyQV9SI7qTbQkzP1I2',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'2024-02-01 19:34:22'),
(15,	1027,	'aUllbTZSbUxzRTcwY3NwVXlaYURkU1VJQUZycjFHMjZxTUV1eXFWSnFrQT0=',	'02',	'2029',	'VGozZDkzcllyYUZJV3psUXlmY1l1QT09',	'',	'cus_PWfarnHFmhe2DM',	'2996 Spruce Circle Snellville GA 30078',	'1',	'card_1OhcFlAyQV9SI7qTphJjRPSQ',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-02-08 18:23:19'),
(16,	1028,	'aUllbTZSbUxzRTcwY3NwVXlaYURkU1VJQUZycjFHMjZxTUV1eXFWSnFrQT0=',	'02',	'2029',	'VGozZDkzcllyYUZJV3psUXlmY1l1QT09',	'',	'cus_PWxfsW0xH3I0NU',	'2996 spruce circle Snellville GA 30078',	'1',	'card_1Ohtk0AyQV9SI7qTTWF4rL4b',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-02-09 13:03:42'),
(17,	1031,	'T0g4R3JBWnk4Q25ycnZmT3l5MUVpZWRLS1RJRUdkbzkxMWN4R2p6Rm8wdz0=',	'06',	'2026',	'VGozZDkzcllyYUZJV3psUXlmY1l1QT09',	'',	'cus_PXjn4w8tXocxQg',	'2996 Spruce Circle Snellville GA 30078',	'1',	'card_1OieJzAyQV9SI7qTCY1pBbhc',	'THVycCtwRzdkUmRjZGN2aVpMZ3RCQT09',	'2024-02-11 14:47:57')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `card_number` = VALUES(`card_number`), `expiry_month` = VALUES(`expiry_month`), `expiry_date` = VALUES(`expiry_date`), `card_holder_name` = VALUES(`card_holder_name`), `bank_name` = VALUES(`bank_name`), `customer_id` = VALUES(`customer_id`), `billing_address` = VALUES(`billing_address`), `is_default` = VALUES(`is_default`), `default_source` = VALUES(`default_source`), `card_type` = VALUES(`card_type`), `date` = VALUES(`date`);

DROP TABLE IF EXISTS `driver_account_detail`;
CREATE TABLE `driver_account_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `account_holder_name` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `routing_number` varchar(100) NOT NULL,
  `account_number` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1: Active 2: Inactive',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `driver_account_detail` (`id`, `user_id`, `account_holder_name`, `bank_name`, `routing_number`, `account_number`, `status`, `date`) VALUES
(1,	1002,	'MFEzQ2ltdzhoQmY4NC9lbXl1WjZlQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'1',	'2024-01-14 13:37:55'),
(2,	1004,	'MFEzQ2ltdzhoQmY4NC9lbXl1WjZlQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'Rit4TUJTSTAydE0wb0R1R0FhSFd6QT09',	'1',	'2024-01-15 04:08:54'),
(3,	997,	'TUVVQTRRaEFLSW1keWtmS2VSQk9jdz09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'1',	'2024-01-21 20:53:43'),
(4,	1000,	'TVJBemVRTUhjSm9mZ2JDcHNNdnpaMUdRUS9OemZ4MHZ2ZncvTzd5NGNIND0=',	'V1FPNllhdTA4Y0s1Zk85b1hxNnVmbUdUY3BNWllML2Z1ZTRiVU9nNVczYz0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'1',	'2024-02-02 18:23:34'),
(5,	1024,	'MFEzQ2ltdzhoQmY4NC9lbXl1WjZlQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'1',	'2024-02-07 00:39:39'),
(6,	1029,	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'QlRzWEJMWUxuL3k1K2JoTGZaeWVUQT09',	'1',	'2024-02-10 18:11:51'),
(7,	1029,	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'QlRzWEJMWUxuL3k1K2JoTGZaeWVUQT09',	'1',	'2024-02-10 18:11:51'),
(8,	1029,	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'QlRzWEJMWUxuL3k1K2JoTGZaeWVUQT09',	'1',	'2024-02-10 18:11:51'),
(9,	1030,	'MTBMSDdhQ1dhcXRXbjYybzN0NllDQT09',	'bHl3VWoySjlJdDZWby82b2QyVGMzdG1jVWdVangxU284NzdON0dsSHgrTT0=',	'OG42UDdqZ2R3eU9Dazg5NWl6K1BsQT09',	'cFN5ekJCc0lJRDdvazlFWWFPVjdwZz09',	'1',	'2024-02-10 18:35:10')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `account_holder_name` = VALUES(`account_holder_name`), `bank_name` = VALUES(`bank_name`), `routing_number` = VALUES(`routing_number`), `account_number` = VALUES(`account_number`), `status` = VALUES(`status`), `date` = VALUES(`date`);

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `driver_id` int NOT NULL,
  `ride_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` varchar(150) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ride_id` (`ride_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `feedback` (`id`, `driver_id`, `ride_id`, `rating`, `comment`, `created_date`, `updated_date`) VALUES
(14,	1004,	4396,	5,	'',	'2024-01-23 19:56:50',	'2024-01-23 19:56:50'),
(15,	1004,	4397,	5,	'',	'2024-01-24 09:00:06',	'2024-01-24 09:00:06'),
(16,	1004,	4399,	5,	'',	'2024-01-31 10:45:42',	'2024-01-31 10:45:42'),
(17,	1024,	4401,	5,	'',	'2024-02-07 00:33:36',	'2024-02-07 00:33:36'),
(18,	1024,	4403,	5,	'',	'2024-02-08 11:49:49',	'2024-02-08 11:49:49'),
(19,	1024,	4404,	5,	'',	'2024-02-08 12:19:28',	'2024-02-08 12:19:28'),
(20,	1024,	4405,	5,	'',	'2024-02-08 12:43:13',	'2024-02-08 12:43:13'),
(21,	1024,	4406,	5,	'',	'2024-02-08 12:57:06',	'2024-02-08 12:57:06'),
(22,	1024,	4407,	5,	'',	'2024-02-08 18:30:27',	'2024-02-08 18:30:27'),
(23,	1024,	4409,	5,	'',	'2024-02-08 18:47:58',	'2024-02-08 18:47:58')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `driver_id` = VALUES(`driver_id`), `ride_id` = VALUES(`ride_id`), `rating` = VALUES(`rating`), `comment` = VALUES(`comment`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `hold_payment_history`;
CREATE TABLE `hold_payment_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `txn_id` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `charge_amount` varchar(200) DEFAULT NULL,
  `rest_amount` varchar(200) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1 Active 0 Inactive',
  `created_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `hold_payment_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `hold_payment_history` (`id`, `user_id`, `txn_id`, `amount`, `charge_amount`, `rest_amount`, `status`, `created_date`) VALUES
(1,	1018,	'ch_3ObukwAyQV9SI7qT4LwDtV5F',	'8',	'3.03',	'4.97',	'0',	'2024-01-29 07:04:46'),
(2,	1018,	'ch_3Oc6xgAyQV9SI7qT0HMmgaN9',	'8',	'3.03',	'4.97',	'0',	'2024-01-29 07:04:59'),
(3,	1018,	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	'8',	NULL,	NULL,	'1',	'2024-01-25 22:44:08'),
(4,	1017,	'ch_3OcdheAyQV9SI7qT3yJOXvoM',	'8.0',	NULL,	NULL,	'1',	'2024-01-26 00:55:31'),
(5,	1027,	'ch_3OhcICAyQV9SI7qT2GREMeXB',	'6.0',	'3.03',	'2.97',	'0',	'2024-02-08 18:30:05'),
(6,	1027,	'ch_3OhcctAyQV9SI7qT3zK0PZIG',	'6.0',	'3.03',	'2.97',	'0',	'2024-02-08 18:47:48'),
(7,	1031,	'ch_3OieSbAyQV9SI7qT2mJVtSO5',	'6.0',	NULL,	NULL,	'0',	'2024-02-12 05:56:19')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `txn_id` = VALUES(`txn_id`), `amount` = VALUES(`amount`), `charge_amount` = VALUES(`charge_amount`), `rest_amount` = VALUES(`rest_amount`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`);

DROP TABLE IF EXISTS `identification_document`;
CREATE TABLE `identification_document` (
  `id` int NOT NULL AUTO_INCREMENT,
  `document_name` varchar(50) NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1:Active 2:Inactive',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `identification_document` (`id`, `document_name`, `status`, `created_date`, `updated_date`) VALUES
(1,	'Driver\'s license',	'1',	'2022-08-05 07:47:43',	'2022-08-05 07:47:43'),
(2,	'Passport',	'2',	'2022-08-05 07:47:43',	'2022-08-05 07:47:43'),
(3,	'Green Card',	'2',	'2022-08-05 07:47:43',	'2022-08-05 07:47:43')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `document_name` = VALUES(`document_name`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `keys`;
CREATE TABLE `keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_type` varchar(10) DEFAULT NULL,
  `key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `login_token`;
CREATE TABLE `login_token` (
  `user_id` int NOT NULL,
  `token` text NOT NULL,
  `created_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `login_token` (`user_id`, `token`, `created_date`) VALUES
(983,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4MyIsIm5hbWUiOiJSb2hpdCIsImVtYWlsIjoicm9oaXRAZ21haWwuY29tIiwidXR5cGUiOiIxIiwiaWF0IjoxNzA0NzA5MzQ4LCJleHAiOjE3MzYyNDUzNDh9.nG6NI5miSsqoHElK23K7IIVTSkSVKh4bxTEOPuyoTFA',	'2024-01-08 05:22:28'),
(985,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4NSIsIm5hbWUiOiJSaWRlciIsImVtYWlsIjoiYXBwbGVyaWRlckBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDQ3ODQwMzIsImV4cCI6MTczNjMyMDAzMn0.LzIZCO68MOx560YsL72i2MGxhjNkEMrV_uOjYFHkKL4',	'2024-01-09 02:07:12'),
(989,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4OSIsIm5hbWUiOiJUZXN0IiwiZW1haWwiOiJ0dEBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDQ4NzczMTMsImV4cCI6MTczNjQxMzMxM30.qgzYZNXjcDQsjFGEiLF8tz4JV47lac8ROmm8CsdUdtA',	'2024-01-10 04:01:53'),
(996,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5NiIsIm5hbWUiOiJEZW1ldHJpdXMgYnJ1bmRpZGdlICIsImVtYWlsIjoiZGVlOThAY29tY2FzdC5uZXQiLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDQ5Mzc0NzQsImV4cCI6MTczNjQ3MzQ3NH0.umSoCgmfy-Mv6CXSsW_Qi3L5iNlzIdd8Dy77aRhEqBc',	'2024-01-10 20:44:34'),
(994,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5NCIsIm5hbWUiOiJTYW5qYXkgUmlkZXIiLCJlbWFpbCI6InNhbmpheUBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDQ5NzkwNzAsImV4cCI6MTczNjUxNTA3MH0.Z5FXu0R0I4QV8uRPcGS3ayja8BR_saIGUJwrk-ZYcTo',	'2024-01-11 08:17:50'),
(999,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5OSIsIm5hbWUiOiJBbGV4YW5kZXIgRG9tYWgiLCJlbWFpbCI6ImFsZXhkdHJhbnNwb3J0QGdtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNTE3NDI3NiwiZXhwIjoxNzM2NzEwMjc2fQ.qhFA79LnMHni_JxRKQZi1YOezAtEwcqPuOMKWzsWwTw',	'2024-01-13 14:31:16'),
(1001,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDEiLCJuYW1lIjoiSG9wZXRvbiBCbGFpciIsImVtYWlsIjoiaG9wZXRvbmJsYWlyQGdtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNTIzMDMwNywiZXhwIjoxNzM2NzY2MzA3fQ.l4b1mS3oh0ozZ1Gr0yUZcIdKzWld3xSwhQ1Eo0ok6Gg',	'2024-01-14 06:05:07'),
(998,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5OCIsIm5hbWUiOiIgQ3VydGlzIFdvb2Rob3VzZSIsImVtYWlsIjoiY3VydHdvb2QyQGdtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNTI0NjAxOCwiZXhwIjoxNzM2NzgyMDE4fQ.QRgx_gEWx_By1oCWcjC3WFG1EmRBj3-X-yi2dy5gKZQ',	'2024-01-14 10:26:58'),
(1000,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDAiLCJuYW1lIjoiTUFNQURPVSBDT1VMSUJBTFkgIiwiZW1haWwiOiJtYWNvdWx0cmFuc3BvcnRAZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA1Mjg3Njc1LCJleHAiOjE3MzY4MjM2NzV9.rLGRTeGtNcJ_6hRuuNyZyVdmLqEWYnLrH3BExjw23CY',	'2024-01-14 22:01:15'),
(1002,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDIiLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6Im1hdXJpY2Vtb3JyaXMyMDEyQGdtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNTQwNzc2MiwiZXhwIjoxNzM2OTQzNzYyfQ.WnVC9rTz3UIH_uvBjvKuMbFMhvD7AFHr0exs7nAE9Z0',	'2024-01-16 07:22:42'),
(1005,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDUiLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6InJpZGVzaGFyZXJhdGVzY2hpY2Fnb0BnbWFpbC5jb20iLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDU0MTEzNTQsImV4cCI6MTczNjk0NzM1NH0.wZFdATOmlRcqmbYVeZg55vRFtFchFM9tHcm_5GCwV0k',	'2024-01-16 08:22:34'),
(1007,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDciLCJuYW1lIjoiSmFuaWNlIEdhZHNvbiIsImVtYWlsIjoiamFuaWNlbmljb2xlMTk5MUBnbWFpbC5jb20iLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDU0NTExNDEsImV4cCI6MTczNjk4NzE0MX0.uAvnD_OlfTZpQrVgGkQujMnIC9e8tjmAX5CQ056Zue8',	'2024-01-16 19:25:41'),
(1010,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTAiLCJuYW1lIjoiUm8iLCJlbWFpbCI6InJyaXZAbWUuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA1NjY4ODQxLCJleHAiOjE3MzcyMDQ4NDF9.w2-BHUQaHFSNQpcT_j4vgfldosYylM82vZtw7ve2sQE',	'2024-01-19 07:54:01'),
(1011,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTEiLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6InN3b2xsQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNTk0MjIyMCwiZXhwIjoxNzM3NDc4MjIwfQ.MB0asJRwpnI59VqCK42qrgy-jx5KUI0p7XoAU73BRv0',	'2024-01-22 11:50:20'),
(1012,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTIiLCJuYW1lIjoiU29ueWEiLCJlbWFpbCI6InNvbnlhcGV0dGVyc29uQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNTk1NDI5MiwiZXhwIjoxNzM3NDkwMjkyfQ.e0puzgY6oVuGZZCLPaLBxuFZu5l4JUbhJv8tlkYMNyI',	'2024-01-22 15:11:32'),
(1013,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTMiLCJuYW1lIjoiTWxpdmUiLCJlbWFpbCI6Im1saXZlcmlkZXJAZ21haWwuY29tIiwidXR5cGUiOiIxIiwiaWF0IjoxNzA1OTkwMjI5LCJleHAiOjE3Mzc1MjYyMjl9.4U1gOweXqMHEYK4QDJJIS1gjlNyx_-EQ_Q7O_8J_Pbw',	'2024-01-23 01:10:29'),
(995,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5NSIsIm5hbWUiOiJUZXN0MjIiLCJlbWFpbCI6InRlc3QyMkBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDU5OTEyNjEsImV4cCI6MTczNzUyNzI2MX0.dCNcQkdkLJshuSNMFdKAvj8C6ZtzTkmdOfx-V1obEZI',	'2024-01-23 01:27:41'),
(982,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4MiIsIm5hbWUiOiJUZXN0bWFsaWthIiwiZW1haWwiOiJ0ZXN0bWFsaWthQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNTk5OTQ4OSwiZXhwIjoxNzM3NTM1NDg5fQ.1gH-ziNS6Pn5lQwPCecWKG7csbI9Cs2JDmACdXd4A3A',	'2024-01-23 03:44:49'),
(1008,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDgiLCJuYW1lIjoiUm9oaXQgcmlkZXIiLCJlbWFpbCI6InJvaGl0cmlkZXJAZ21haWwuY29tIiwidXR5cGUiOiIxIiwiaWF0IjoxNzA2MDAxMTkyLCJleHAiOjE3Mzc1MzcxOTJ9.OzitpiaBK9oEKfhCX-uGxBf2iMkAVI6ZChrlAxApqus',	'2024-01-23 04:13:12'),
(981,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4MSIsIm5hbWUiOiJMb25nbW9udCIsImVtYWlsIjoicm9oaXRkdGVzdEB5b3BtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNjAwMTkyNSwiZXhwIjoxNzM3NTM3OTI1fQ.MHsZyMPrQ7UFqhzSjdSm74Ma3TbFcJb0Jw4OXaX8Yew',	'2024-01-23 04:25:25'),
(1009,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDkiLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6InRoZWxhdmlzaHN0b3JlQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNjAxMzg5MSwiZXhwIjoxNzM3NTQ5ODkxfQ.lqHdApKs0NSFrE6jke7lc7F1TgCd1pzchRHI5TP6EdI',	'2024-01-23 07:44:51'),
(1017,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTciLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6InRoZWxhdmlzaHN0b3JlQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNjAxODMzMiwiZXhwIjoxNzM3NTU0MzMyfQ.bDNOTnv72JNZa2gq3Y7JZ5ZKAFpOU9pydcLGwwTqTyI',	'2024-01-23 08:58:52'),
(1020,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjAiLCJuYW1lIjoiTWFya2VyIiwiZW1haWwiOiJtYXJrZXJAZ21haWwuY29tIiwidXR5cGUiOiIxIiwiaWF0IjoxNzA2MTY0MjYzLCJleHAiOjE3Mzc3MDAyNjN9.JOyaWqXhDnN5IxU_JOT8wHz3Ec4Cy-SBW_thSj15BPI',	'2024-01-25 01:31:03'),
(1021,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjEiLCJuYW1lIjoiUmFtIiwiZW1haWwiOiJyYW1AeW9wbWFpbC5jb20iLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDYxNjY0NTYsImV4cCI6MTczNzcwMjQ1Nn0.Aii7_dDYzwYsg38LeS_Sjo2TTeE18ZoitokfbCjfBAw',	'2024-01-25 02:07:36'),
(1003,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDMiLCJuYW1lIjoiSWJyYWhpbWEgRGlhbGxvIiwiZW1haWwiOiJkc2FsaW91MTBAaG90bWFpbC5jb20iLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDYzODA5ODksImV4cCI6MTczNzkxNjk4OX0.ZYgXoDKm0JaE71_gfkEWi30mHGYW-UNB9rkMjMoZlFY',	'2024-01-27 13:43:09'),
(1019,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTkiLCJuYW1lIjoiUm9oaXQgUmlkZXIiLCJlbWFpbCI6InJvaGl0QGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNjUzNjY2MiwiZXhwIjoxNzM4MDcyNjYyfQ.ITAhxPSajWhqf_lvt_9XZvfFI5lv7cGGOctsONqftow',	'2024-01-29 08:57:42'),
(997,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk5NyIsIm5hbWUiOiJBbnRob255IGNvb3BlciIsImVtYWlsIjoiYWV4b3RpY2xpbW9AZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA2NzA5MjkxLCJleHAiOjE3MzgyNDUyOTF9.osYd04FWwMh1_40Kvtv8VPWYVYrWJWzjfn3nIPHYRac',	'2024-01-31 08:54:51'),
(1022,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjIiLCJuYW1lIjoiVGVzdCIsImVtYWlsIjoibWFsaWthQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNjc5MDA4OCwiZXhwIjoxNzM4MzI2MDg4fQ.IlVUXWQj1g7k9PorySFnZ4ue1VxadsUmbloGPYjJEQ0',	'2024-02-01 07:21:28'),
(1023,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjMiLCJuYW1lIjoiU0JHICBFTlQgIiwiZW1haWwiOiJzYmdlbnQxQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNjgzNzQ1MCwiZXhwIjoxNzM4MzczNDUwfQ.5bY9ktFNJibrln-j8g2b_K8uSQBD6LcWfJn26rDkGh8',	'2024-02-01 20:30:50'),
(1025,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjUiLCJuYW1lIjoiVHJhY2V5IFRhdGUiLCJlbWFpbCI6InNzc3RhdGUyQGdtYWlsLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNzI3MjMyNiwiZXhwIjoxNzM4ODA4MzI2fQ.4ci_aLkaV-nckXcAJwEOWvvSBq_CBID_7GbK-bbUrXc',	'2024-02-07 02:18:46'),
(1016,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTYiLCJuYW1lIjoiUHJlZXRpIE1hbGhvdHJhIiwiZW1haWwiOiJwcmVldGltYWxob3RyYTg4QGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNzI5Mzk1NiwiZXhwIjoxNzM4ODI5OTU2fQ.Zg0qgj6rZxOb4rB4o1Knu6Cg8_z2rl7pSXd8g2MVqGQ',	'2024-02-07 08:19:16'),
(1018,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMTgiLCJuYW1lIjoiTWF1cmljZSBNb3JyaXMiLCJlbWFpbCI6Ind5a2VzZGV0cm9pdEBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDczOTY5MDksImV4cCI6MTczODkzMjkwOX0.dkXgcAMldvt1jsdkaJ18vqcPspaYHjJWcAGIBnhNycM',	'2024-02-08 12:55:09'),
(1024,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjQiLCJuYW1lIjoiTW9lIiwiZW1haWwiOiI3NTUxd3lrZXNAZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA3NDg3NDM2LCJleHAiOjE3MzkwMjM0MzZ9.e64hidr5aYOG_ouVdjHMiiXnwFOsQXaFJYkeL9pxTYY',	'2024-02-09 14:03:56'),
(1029,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjkiLCJuYW1lIjoiRnJlZGVyaWNvIE1vYmxleSIsImVtYWlsIjoiZnJlZGVyaWNvbW9ibGV5QHlhaG9vLmNvbSIsInV0eXBlIjoiMiIsImlhdCI6MTcwNzUyMjgxNSwiZXhwIjoxNzM5MDU4ODE1fQ.HowmY2mUWCTxJhUtLqYmwWrsODU5pvXQ7ovOM3sK2As',	'2024-02-09 23:53:35'),
(1030,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMzAiLCJuYW1lIjoiU2VuZXF1YSBNb2JsZXkiLCJlbWFpbCI6InNlbmVxdWFtb2JsZXlAZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA3NTI1NTg4LCJleHAiOjE3MzkwNjE1ODh9.9-cfBq1OmMFu-DoLJSmXrKukiJOfZcyGg8RUKj1DlNw',	'2024-02-10 00:39:48'),
(1004,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMDQiLCJuYW1lIjoiTWF1cmljZSIsImVtYWlsIjoicmlkZXNoYXJlcmF0ZXNAZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA3NjYwMjE2LCJleHAiOjE3MzkxOTYyMTZ9.L3jeS3KQNGr2U0iMNcBUmvEbbOMA6FgQMbkU-YJEVkE',	'2024-02-11 14:03:36'),
(1027,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjciLCJuYW1lIjoiTWF1cmljZSIsImVtYWlsIjoiZGV0cm9pdG1vZUBnbWFpbC5jb20iLCJ1dHlwZSI6IjEiLCJpYXQiOjE3MDc3MTU4NzksImV4cCI6MTczOTI1MTg3OX0.8efBgJp3VcBm_NYsNLWZ786HiU94owkjcTb5gRSdGYA',	'2024-02-12 05:31:19'),
(1028,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMjgiLCJuYW1lIjoiTWF1cmljZSIsImVtYWlsIjoiZGV0cm9pdHJpZGVyQGdtYWlsLmNvbSIsInV0eXBlIjoiMSIsImlhdCI6MTcwNzczMzc1NCwiZXhwIjoxNzM5MjY5NzU0fQ.Ockg-dkWi-8OIC6oxE6zjwS75dJ4rz0JlpxBuSvBl_Q',	'2024-02-12 10:29:14'),
(984,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ijk4NCIsIm5hbWUiOiJqYWNrIiwiZW1haWwiOiJhcHBsZWRyaXZlckBnbWFpbC5jb20iLCJ1dHlwZSI6IjIiLCJpYXQiOjE3MDc3NDk2MTgsImV4cCI6MTczOTI4NTYxOH0.HG3eiuJESQ-uLRBrGk5FZgicSOAlj5MwayZUi6ZiTKs',	'2024-02-12 14:53:38'),
(1032,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMzIiLCJuYW1lIjoiTGVuaXNlIiwiZW1haWwiOiJjMXJ0cmFuc3BvcnRhdGlvbjIwMjJAZ21haWwuY29tIiwidXR5cGUiOiIyIiwiaWF0IjoxNzA3Nzc5NjgzLCJleHAiOjE3MzkzMTU2ODN9.yHMSc_nf9iZeuXlCzdrHtTi55SS4HUTn-t_jwxtNWnA',	'2024-02-12 23:14:43'),
(1031,	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEwMzEiLCJuYW1lIjoiTWF1cmljZSIsImVtYWlsIjoibGF2aXNoY29sbGVjdGlvbkBhb2wuY29tIiwidXR5cGUiOiIxIiwiaWF0IjoxNzA3Nzk4ODE3LCJleHAiOjE3MzkzMzQ4MTd9.ZBaxGPI4LEMMfSNYleaUcEUxKeKvLn1djcMihXiiPfk',	'2024-02-13 04:33:37')
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `token` = VALUES(`token`), `created_date` = VALUES(`created_date`);

DROP TABLE IF EXISTS `models`;
CREATE TABLE `models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_id` int NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1:Active 2:Inactive',
  `created_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`),
  CONSTRAINT `models_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `models` (`id`, `brand_id`, `model_name`, `status`, `created_date`, `updated_date`) VALUES
(298,	1,	'Test Car',	'1',	'2023-07-29 12:03:29',	'2023-07-29 12:03:29')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `brand_id` = VALUES(`brand_id`), `model_name` = VALUES(`model_name`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `payment_history`;
CREATE TABLE `payment_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ride_id` int NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cancellation_charge` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment_history` (`id`, `ride_id`, `txn_id`, `amount`, `cancellation_charge`, `date`) VALUES
(1,	4396,	'ch_3ObukwAyQV9SI7qT4LwDtV5F',	3.03,	0.00,	'2024-01-23 19:56:38'),
(2,	4397,	'ch_3Oc6xgAyQV9SI7qT0HMmgaN9',	3.03,	0.00,	'2024-01-24 13:58:38'),
(3,	4407,	'ch_3OhcICAyQV9SI7qT2GREMeXB',	3.03,	0.00,	'2024-02-08 23:30:05'),
(4,	4409,	'ch_3OhcctAyQV9SI7qT3zK0PZIG',	3.03,	0.00,	'2024-02-08 23:47:48')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `ride_id` = VALUES(`ride_id`), `txn_id` = VALUES(`txn_id`), `amount` = VALUES(`amount`), `cancellation_charge` = VALUES(`cancellation_charge`), `date` = VALUES(`date`);

DROP TABLE IF EXISTS `payout_status`;
CREATE TABLE `payout_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `driver_id` int NOT NULL,
  `ride_id` int NOT NULL,
  `total_payout` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `txn_id` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `genrated_payout_date` varchar(100) NOT NULL,
  `crated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ride_id` (`ride_id`),
  CONSTRAINT `payout_status_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `question_category_id` int NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_category_id` (`question_category_id`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`question_category_id`) REFERENCES `question_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `question` (`id`, `question`, `question_category_id`, `email`, `created_date`, `updated_at`) VALUES
(1,	'Below are the trips you have recently completed according to what we have in the app. Which one of them do you need help with?',	1,	'lisa.steward@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(2,	'Updating vehicles and documents',	2,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(3,	'Rating rate',	2,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(4,	'Issue placing call within the app',	2,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(5,	'Can’t sign in or having hard time going online',	2,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(6,	'My payment taking long time',	2,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(7,	'How do I receive my earnings',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(8,	'Why is my recent trip not showing up in my earnings',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(9,	'My estimated and total balance is completely different. Why?\r\n',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(10,	'What is surge or surging meaning?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(11,	'Can I cash out my earnings the same day? And how do I go about it?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(12,	'Where or what section within the app can I see my trip earnings?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(13,	'When do I receive my earnings or payment?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(14,	'How do I track tips in my earnings?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(15,	'There is a trip missing from my pay statement. Why?',	3,	'sharon.holly@ridesharerates.com',	'2022-08-12 09:05:02',	'2022-08-12 09:05:02'),
(16,	'The customer left an item in my car. How do I return it?',	4,	'lisa.steward@ridesharerates.com',	'2022-08-12 09:50:10',	'2022-08-12 09:50:10'),
(18,	'Safety reporting line',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(19,	'Reporting Criminal activity\r\n\r\n',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(20,	'A rider was very racist to me',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(21,	'I was involved in an accident while driving rider or going to pick up rider',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(22,	'I think my passenger needs immediate help. It seems like she is a victim of human trafficking. What should I do?',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(23,	'My rider made me feel completely unsafe',	5,	'janice.gadson@ridesharerates.com',	'2022-08-12 09:53:42',	'2022-08-12 09:53:42'),
(24,	'How do I assist riders with disabilities get in my car?\r\n',	6,	'lisa.steward@ridesharerates.com',	'2022-08-12 10:01:28',	'2022-08-12 10:01:28'),
(26,	'Why am I being charged twice?\r\n',	7,	'janice.gadson@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(27,	'Why am I being charged a cancellation fee yet I didn’t cancel my trip?',	7,	'janice.gadson@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(28,	'My credit expired and I am unable to update it',	7,	'janice.gadson@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(29,	'How to add a new payment method to my account?',	7,	'sharon.holly@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(30,	'What number should I call to talk to customer care right away?',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(31,	'Why is my area always showing surge or surging prices?',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(32,	'I left my phone in the car. How do I get my phone back?',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(33,	'The driver was racist to me',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(34,	'The driver was very rude to me\r\n',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(35,	'The car was dirty and smelled bad. Please advise your drivers to keep their cars clean',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27'),
(36,	'The driver plays a very loud music throughout my ride',	7,	'lisa.steward@ridesharerates.com',	'2022-08-12 11:04:27',	'2022-08-12 11:04:27')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `question` = VALUES(`question`), `question_category_id` = VALUES(`question_category_id`), `email` = VALUES(`email`), `created_date` = VALUES(`created_date`), `updated_at` = VALUES(`updated_at`);

DROP TABLE IF EXISTS `question_category`;
CREATE TABLE `question_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_category` varchar(150) NOT NULL,
  `user_type` enum('1','2') NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `question_category` (`id`, `question_category`, `user_type`, `email`, `status`, `created_date`, `updated_date`) VALUES
(1,	'Help with a trip',	'2',	'',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(2,	'Account and App issues',	'2',	'',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(3,	'Earnings',	'2',	'sharon.holly@ridesharerates.com',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(4,	'Found Item in the back of my car seat',	'2',	'',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(5,	'Safety Issue',	'2',	'janice.gadson@ridesharerates.com',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(6,	'Accessibility',	'2',	'',	'1',	'2022-08-12 08:37:18',	'2022-08-12 08:37:18'),
(7,	'Rider Help Section',	'1',	'',	'1',	'2022-08-12 08:53:48',	'2022-08-12 08:53:48')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `question_category` = VALUES(`question_category`), `user_type` = VALUES(`user_type`), `email` = VALUES(`email`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `rate_chart`;
CREATE TABLE `rate_chart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `monday` smallint NOT NULL,
  `tuesday` smallint NOT NULL,
  `wednesday` smallint NOT NULL,
  `thursday` smallint NOT NULL,
  `friday` smallint NOT NULL,
  `saturday` smallint NOT NULL,
  `sunday` smallint NOT NULL,
  `total_highest_ride` tinyint NOT NULL,
  `highest_ride_price` tinyint NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rate_chart` (`id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `total_highest_ride`, `highest_ride_price`, `created_date`, `updated_date`) VALUES
(1,	0,	0,	0,	0,	0,	0,	0,	10,	12,	'2024-01-31 06:55:50',	'2024-01-31 06:55:50')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `monday` = VALUES(`monday`), `tuesday` = VALUES(`tuesday`), `wednesday` = VALUES(`wednesday`), `thursday` = VALUES(`thursday`), `friday` = VALUES(`friday`), `saturday` = VALUES(`saturday`), `sunday` = VALUES(`sunday`), `total_highest_ride` = VALUES(`total_highest_ride`), `highest_ride_price` = VALUES(`highest_ride_price`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `ride_audio`;
CREATE TABLE `ride_audio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ride_id` int NOT NULL,
  `user_id` int NOT NULL,
  `audio_file` varchar(150) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1:Active 2:Inactive',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_id` (`ride_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ride_audio_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`),
  CONSTRAINT `ride_audio_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `rider_feedback`;
CREATE TABLE `rider_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rider_id` int NOT NULL,
  `ride_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `created_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment` (`comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `rider_feedback` (`id`, `rider_id`, `ride_id`, `rating`, `comment`, `created_date`, `updated_date`) VALUES
(1,	982,	4387,	5,	'',	'2024-01-08 02:44:32',	'2024-01-08 02:44:32'),
(2,	985,	4388,	0,	'',	'2024-01-09 02:34:08',	'2024-01-09 02:34:08'),
(3,	994,	4390,	4,	'',	'2024-01-12 07:31:11',	'2024-01-12 07:31:11'),
(4,	1008,	4391,	5,	'',	'2024-01-17 02:07:21',	'2024-01-17 02:07:21'),
(5,	1011,	4393,	5,	'',	'2024-01-22 14:13:45',	'2024-01-22 14:13:45'),
(6,	1008,	4395,	5,	'',	'2024-01-23 04:06:24',	'2024-01-23 04:06:24'),
(7,	1018,	4396,	5,	'',	'2024-01-23 19:56:47',	'2024-01-23 19:56:47'),
(8,	1018,	4397,	5,	'',	'2024-01-24 09:00:10',	'2024-01-24 09:00:10'),
(9,	1018,	4399,	5,	'',	'2024-01-31 09:44:47',	'2024-01-31 09:44:47'),
(10,	1018,	4401,	0,	'',	'2024-02-06 13:49:20',	'2024-02-06 13:49:20'),
(11,	1018,	4403,	5,	'',	'2024-02-08 11:49:59',	'2024-02-08 11:49:59'),
(12,	1018,	4404,	5,	'',	'2024-02-08 12:19:36',	'2024-02-08 12:19:36'),
(13,	1018,	4405,	5,	'',	'2024-02-08 12:47:26',	'2024-02-08 12:47:26'),
(14,	1018,	4406,	5,	'',	'2024-02-08 12:57:11',	'2024-02-08 12:57:11'),
(15,	1027,	4407,	5,	'',	'2024-02-08 18:30:17',	'2024-02-08 18:30:17'),
(16,	1027,	4409,	5,	'',	'2024-02-08 18:47:53',	'2024-02-08 18:47:53')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `rider_id` = VALUES(`rider_id`), `ride_id` = VALUES(`ride_id`), `rating` = VALUES(`rating`), `comment` = VALUES(`comment`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `rides`;
CREATE TABLE `rides` (
  `ride_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `driver_id` int NOT NULL,
  `vehicle_type_id` int NOT NULL,
  `vehicle_detail_id` int DEFAULT NULL,
  `pickup_adress` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `is_destination_ride` enum('1','2') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT '2',
  `drop_address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `pikup_location` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `pickup_lat` varchar(100) NOT NULL,
  `pickup_long` varchar(100) NOT NULL,
  `drop_locatoin` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `drop_lat` varchar(100) NOT NULL,
  `drop_long` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `drop_city` varchar(20) NOT NULL,
  `drop_state` varchar(20) NOT NULL,
  `drop_country` varchar(20) NOT NULL,
  `distance` varchar(50) NOT NULL,
  `status` enum('PENDING','ACCEPTED','COMPLETED','CANCELLED','START_RIDE','NOT_CONFIRMED','FAILED','DELETED') DEFAULT 'NOT_CONFIRMED',
  `is_technical_issue` enum('Yes','No','Simple') NOT NULL DEFAULT 'Simple',
  `cancelled_by` int DEFAULT NULL,
  `cancelled_count` int NOT NULL,
  `payment_status` enum('PENDING','COMPLETED') NOT NULL DEFAULT 'PENDING',
  `confirmation_time` datetime DEFAULT NULL,
  `cancellation_time` datetime DEFAULT NULL,
  `cancellation_charge` int DEFAULT NULL,
  `base_fare_fee` int DEFAULT NULL,
  `surcharge_fee` int DEFAULT NULL,
  `taxes` int DEFAULT NULL,
  `permile_rate` int DEFAULT NULL,
  `vehicle_name` varchar(300) DEFAULT '',
  `vehicle_category_id` int DEFAULT NULL,
  `pay_driver` tinyint(1) DEFAULT '0',
  `payment_mode` varchar(25) NOT NULL,
  `payout_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Pay to driver 2: Not pay to driver',
  `amount` varchar(10) NOT NULL,
  `tip_amount` decimal(10,2) DEFAULT NULL,
  `AdminRide_charges` varchar(100) NOT NULL DEFAULT '30',
  `txn_id` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payout_txn_id` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `card_id` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_payout_completed` enum('2','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '2' COMMENT '2:Incomplete.  1:Complete',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ride_created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rides` (`ride_id`, `user_id`, `driver_id`, `vehicle_type_id`, `vehicle_detail_id`, `pickup_adress`, `is_destination_ride`, `drop_address`, `pikup_location`, `pickup_lat`, `pickup_long`, `drop_locatoin`, `drop_lat`, `drop_long`, `city`, `state`, `country`, `drop_city`, `drop_state`, `drop_country`, `distance`, `status`, `is_technical_issue`, `cancelled_by`, `cancelled_count`, `payment_status`, `confirmation_time`, `cancellation_time`, `cancellation_charge`, `base_fare_fee`, `surcharge_fee`, `taxes`, `permile_rate`, `vehicle_name`, `vehicle_category_id`, `pay_driver`, `payment_mode`, `payout_status`, `amount`, `tip_amount`, `AdminRide_charges`, `txn_id`, `payout_txn_id`, `card_id`, `is_payout_completed`, `time`, `ride_created_time`) VALUES
(4396,	1018,	1004,	25,	547,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84910221624292',	'-84.03488719515695',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-01-23 19:56:35',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'ONLINE',	'2',	'3.03',	NULL,	'34',	'ch_3ObukwAyQV9SI7qT4LwDtV5F',	'',	'12',	'2',	'2024-01-23 19:55:56',	'2024-02-08 07:21:29'),
(4397,	1018,	1004,	25,	547,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84912778160893',	'-84.03490738019723',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-01-24 08:58:35',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'ONLINE',	'2',	'3.03',	NULL,	'34',	'ch_3Oc6xgAyQV9SI7qT0HMmgaN9',	'I',	'12',	'1',	'2024-01-24 13:57:54',	'2024-02-08 11:37:51'),
(4398,	1018,	1004,	25,	547,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491123',	'-84.0348327',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'CANCELLED',	'Simple',	1004,	1,	'PENDING',	'2024-01-31 09:40:28',	NULL,	5,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-01-31 14:39:30',	'2024-01-31 14:40:28'),
(4399,	1018,	1004,	25,	547,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491244',	'-84.0349556',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'Yes',	NULL,	0,	'COMPLETED',	'2024-01-31 09:44:36',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-01-31 14:41:50',	'2024-01-31 14:44:37'),
(4400,	1018,	1024,	25,	553,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84910800031752',	'-84.0349152591862',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'CANCELLED',	'',	1018,	0,	'COMPLETED',	'2024-02-06 12:01:08',	'2024-02-06 12:01:08',	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-06 16:59:07',	'2024-02-06 12:01:08'),
(4401,	1018,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491353',	'-84.0349627',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'Yes',	NULL,	0,	'COMPLETED',	'2024-02-06 13:48:59',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-06 18:48:11',	'2024-02-06 13:49:00'),
(4402,	1018,	1024,	25,	553,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84908127440205',	'-84.03488249469456',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'CANCELLED',	'Simple',	1024,	1,	'PENDING',	'2024-02-08 00:00:39',	NULL,	5,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 04:56:36',	'2024-02-08 00:00:39'),
(4403,	1018,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491241',	'-84.0349119',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 11:49:16',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 16:48:55',	'2024-02-08 11:49:18'),
(4404,	1018,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491581',	'-84.0348337',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 12:19:21',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 17:18:57',	'2024-02-08 12:19:22'),
(4405,	1018,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8489365',	'-84.0349434',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'0.9',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 12:44:02',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'2.92',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 17:42:30',	'2024-02-08 12:44:02'),
(4406,	1018,	1024,	25,	553,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84909291823593',	'-84.03487520460644',	'Empire Lounge, 2671, Centerville Highway, Snellville, Georgia, United States30078, ',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 12:56:53',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 17:56:26',	'2024-02-08 12:56:54'),
(4407,	1027,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8490925',	'-84.034914',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 18:30:03',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'ONLINE',	'2',	'3.03',	NULL,	'34',	'ch_3OhcICAyQV9SI7qT2GREMeXB',	NULL,	'15',	'2',	'2024-02-08 23:25:50',	'2024-02-08 18:30:05'),
(4408,	1018,	1024,	25,	NULL,	'2996, Spruce Cir, Snellville, United States, 30078 ',	'2',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'2996, Spruce Cir, Snellville, United States, 30078 ',	'33.84910769267488',	'-84.03489303695433',	'Speedway, 3205, Stone Mountain Highway, Snellville, Georgia, United States30078, ',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'FAILED',	'Simple',	1024,	1,	'PENDING',	'2024-02-08 18:45:27',	NULL,	5,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OcbeVAyQV9SI7qT2gzv0fPg',	NULL,	'12',	'2',	'2024-02-08 23:44:59',	'2024-02-08 18:45:27'),
(4409,	1027,	1024,	25,	553,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8490978',	'-84.0349083',	'3205 Stone Mountain Hwy, Snellville, GA 30078, USA',	'33.8516887',	'-84.0447234',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'COMPLETED',	'',	NULL,	0,	'COMPLETED',	'2024-02-08 18:47:46',	NULL,	0,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'ONLINE',	'2',	'3.03',	NULL,	'34',	'ch_3OhcctAyQV9SI7qT3zK0PZIG',	NULL,	'15',	'2',	'2024-02-08 23:47:12',	'2024-02-08 18:47:48'),
(4410,	1031,	1004,	25,	547,	'3015 Spruce Cir, Snellville, GA 30078, USA',	'2',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'3015 Spruce Cir, Snellville, GA 30078, USA',	'33.8491106',	'-84.034966',	'2671 Centerville Hwy, Snellville, GA 30078, USA',	'33.8378351',	'-84.0345457',	'Gwinnett County',	'Georgia',	'United States',	'Gwinnett County',	'Georgia',	'United States',	'1.0',	'CANCELLED',	'Simple',	1031,	0,	'PENDING',	'2024-02-11 18:30:56',	'2024-02-11 18:30:56',	5,	1,	1,	1,	1,	'LUXURY 2022-2024 S550 Comparable ',	1,	0,	'',	'2',	'3.03',	NULL,	'34',	'ch_3OieSbAyQV9SI7qT2mJVtSO5',	NULL,	'20',	'2',	'2024-02-11 23:24:59',	'2024-02-11 18:30:56')
ON DUPLICATE KEY UPDATE `ride_id` = VALUES(`ride_id`), `user_id` = VALUES(`user_id`), `driver_id` = VALUES(`driver_id`), `vehicle_type_id` = VALUES(`vehicle_type_id`), `vehicle_detail_id` = VALUES(`vehicle_detail_id`), `pickup_adress` = VALUES(`pickup_adress`), `is_destination_ride` = VALUES(`is_destination_ride`), `drop_address` = VALUES(`drop_address`), `pikup_location` = VALUES(`pikup_location`), `pickup_lat` = VALUES(`pickup_lat`), `pickup_long` = VALUES(`pickup_long`), `drop_locatoin` = VALUES(`drop_locatoin`), `drop_lat` = VALUES(`drop_lat`), `drop_long` = VALUES(`drop_long`), `city` = VALUES(`city`), `state` = VALUES(`state`), `country` = VALUES(`country`), `drop_city` = VALUES(`drop_city`), `drop_state` = VALUES(`drop_state`), `drop_country` = VALUES(`drop_country`), `distance` = VALUES(`distance`), `status` = VALUES(`status`), `is_technical_issue` = VALUES(`is_technical_issue`), `cancelled_by` = VALUES(`cancelled_by`), `cancelled_count` = VALUES(`cancelled_count`), `payment_status` = VALUES(`payment_status`), `confirmation_time` = VALUES(`confirmation_time`), `cancellation_time` = VALUES(`cancellation_time`), `cancellation_charge` = VALUES(`cancellation_charge`), `base_fare_fee` = VALUES(`base_fare_fee`), `surcharge_fee` = VALUES(`surcharge_fee`), `taxes` = VALUES(`taxes`), `permile_rate` = VALUES(`permile_rate`), `vehicle_name` = VALUES(`vehicle_name`), `vehicle_category_id` = VALUES(`vehicle_category_id`), `pay_driver` = VALUES(`pay_driver`), `payment_mode` = VALUES(`payment_mode`), `payout_status` = VALUES(`payout_status`), `amount` = VALUES(`amount`), `tip_amount` = VALUES(`tip_amount`), `AdminRide_charges` = VALUES(`AdminRide_charges`), `txn_id` = VALUES(`txn_id`), `payout_txn_id` = VALUES(`payout_txn_id`), `card_id` = VALUES(`card_id`), `is_payout_completed` = VALUES(`is_payout_completed`), `time` = VALUES(`time`), `ride_created_time` = VALUES(`ride_created_time`);

DROP TABLE IF EXISTS `selected_driver_service`;
CREATE TABLE `selected_driver_service` (
  `user_id` int NOT NULL,
  `vehicle_type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1,	'FARE',	'5'),
(2,	'UNIT',	'$'),
(3,	'SMTP_HOST',	'mail.ridesharerates.com'),
(4,	'SMTP_PORT',	'465'),
(5,	'SMTP_USER',	'support@ridesharerates.com'),
(6,	'SMTP_PASS',	'?AN!?36PZ-m4'),
(7,	'FROM',	'support@ridsharerates.com')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `value` = VALUES(`value`);

DROP TABLE IF EXISTS `tbl_country`;
CREATE TABLE `tbl_country` (
  `id_country` int NOT NULL AUTO_INCREMENT,
  `Country Name` varchar(32) DEFAULT NULL,
  `phone_code` varchar(19) DEFAULT NULL,
  `Currency` varchar(13) DEFAULT NULL,
  `Phones (Mobile)` varchar(10) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `tbl_country` (`id_country`, `Country Name`, `phone_code`, `Currency`, `Phones (Mobile)`, `status`) VALUES
(239,	'us',	'1',	'Doller',	'10525000',	1),
(240,	'UAE',	'971',	'Dollar',	'12614000',	1)
ON DUPLICATE KEY UPDATE `id_country` = VALUES(`id_country`), `Country Name` = VALUES(`Country Name`), `phone_code` = VALUES(`phone_code`), `Currency` = VALUES(`Currency`), `Phones (Mobile)` = VALUES(`Phones (Mobile)`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `user_answer`;
CREATE TABLE `user_answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `ride_id` int DEFAULT NULL,
  `question_id` int NOT NULL,
  `answer` char(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `user_id` (`user_id`),
  KEY `ride_id` (`ride_id`),
  CONSTRAINT `user_answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  CONSTRAINT `user_answer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_answer_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  CONSTRAINT `user_answer_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_answer_ibfk_5` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user_answer` (`id`, `user_id`, `ride_id`, `question_id`, `answer`, `created_date`, `updated_date`) VALUES
(1,	1028,	NULL,	29,	'Detroitrider@gmail.com',	'2024-02-09 16:25:05',	'2024-02-09 16:25:05'),
(2,	1028,	NULL,	26,	'Detroitrider@gmail.com',	'2024-02-09 16:25:12',	'2024-02-09 16:25:12')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `ride_id` = VALUES(`ride_id`), `question_id` = VALUES(`question_id`), `answer` = VALUES(`answer`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name_title` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `country_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobile` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `countrycode_mobile` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `country` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `city` varchar(30) DEFAULT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `destination_lat` varchar(20) DEFAULT NULL,
  `destination_long` varchar(20) DEFAULT NULL,
  `gcm_token` text,
  `avatar` varchar(100) DEFAULT NULL,
  `profile_upload_date` date DEFAULT NULL,
  `verification_id` varchar(150) DEFAULT NULL,
  `verification_id_approval_atatus` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2:Not approved',
  `identification_document_id` int DEFAULT NULL,
  `identification_issue_date` date DEFAULT NULL,
  `identification_expiry_date` date DEFAULT NULL,
  `ssn` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `home_address` varchar(150) DEFAULT NULL,
  `status` enum('1','2','3','4') DEFAULT NULL COMMENT '1: Active 2:Need to email verification 3:Need to admin approval 4: Inactive by admin',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `utype` enum('1','2') NOT NULL COMMENT '1:user 2:Driver',
  `random` varchar(150) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `paypal_id` varchar(100) NOT NULL,
  `stripe_account_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `stripe_onboarding` tinyint DEFAULT NULL,
  `is_online` enum('1','2','3') DEFAULT '3' COMMENT '1:Online 2:Busy in ride 3:Offline',
  `is_deleted` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0' COMMENT '1:Acount Deleted, 0: Acount Active ',
  `count_cancelled_ride` tinyint NOT NULL,
  `cancellation_charge` decimal(10,2) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `offline_time` datetime DEFAULT NULL,
  `online_time` datetime DEFAULT NULL,
  `total_working_hour` varchar(10) NOT NULL COMMENT '0',
  `background_approval_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2:Not approved',
  `is_logged_in` enum('1','2') NOT NULL COMMENT '1:Logged in 2:Logout',
  `device_type` varchar(200) NOT NULL DEFAULT '0',
  `device_token` varchar(200) NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `identification_document_id` (`identification_document_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`identification_document_id`) REFERENCES `identification_document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`user_id`, `name`, `name_title`, `last_name`, `email`, `password`, `country_code`, `mobile`, `countrycode_mobile`, `country`, `state`, `city`, `latitude`, `longitude`, `destination_lat`, `destination_long`, `gcm_token`, `avatar`, `profile_upload_date`, `verification_id`, `verification_id_approval_atatus`, `identification_document_id`, `identification_issue_date`, `identification_expiry_date`, `ssn`, `dob`, `home_address`, `status`, `reg_date`, `utype`, `random`, `otp`, `paypal_id`, `stripe_account_id`, `stripe_onboarding`, `is_online`, `is_deleted`, `count_cancelled_ride`, `cancellation_charge`, `login_time`, `offline_time`, `online_time`, `total_working_hour`, `background_approval_status`, `is_logged_in`, `device_type`, `device_token`, `created_date`, `updated_date`) VALUES
(981,	'Longmont',	NULL,	NULL,	'rohitdtest@yopmail.com',	'fcea920f7412b5da7be0cf42b8c93759',	'+1',	'9897022161',	'+1(969) 191-7318',	'India',	'Uttar Pradesh',	'Meerut Division',	'0.0',	'0.0',	'28.5729847',	'77.32490430000001',	'eoPVL9m4TQO2lHvnzJlZUb:APA91bGSyIfxGKevvEo7fL3YcOxaxZXGPYo0oalQ_exEvS5iUWhlBVYk62BA5CLmrVCcAMEDFEhuB7OkOByo3FLw_GZl_iRdFihKzppnUBd1k2o6l5kvg-jfhJejIWXMbaTvKF39ZPlK',	'ridesharerates1704694652.jpg',	'2024-01-08',	'ridesharerates1704694652.jpg',	'1',	1,	'2022-01-08',	'2027-01-08',	'135-68-0918',	'2000-01-08',	'Noida Sector 18, Noida, Uttar Pradesh 201301, India',	'1',	'2024-01-08 06:17:32',	'2',	'vMShywpEb81BDmhf',	'369218',	'',	'acct_1OhRHGPioS0kcoSO',	1,	'3',	'0',	0,	NULL,	'2024-01-23 04:02:27',	NULL,	'2024-01-23 04:02:33',	'1',	'1',	'1',	'android',	'cc4ccde2639b2354',	'2024-01-08 01:17:32',	'2024-01-19 05:26:37'),
(984,	'jack',	'Ms.',	'mor',	'appledriver@gmail.com',	'b24331b1a138cde62aa1f679164fc62f',	'+1',	'(805) 254-5579',	'+1(805) 254-5579',	'India',	'Punjab',	'Patiala Division',	'30.365868201507652',	'76.38333141810855',	NULL,	NULL,	'eMmnsGcYYk48nkkOYoBvXP:APA91bEhzaHjqU7zj2ihmBjJWPUVVRAnULSZnP01BcpMWYHz994a5DJct6x_LFb50N0eyT5lprxhI1nB1P0tuD2j1qqnb5qUNWFAFTOI6stS-bQ_E5Iy_qajiIw88I8S9-XuoLDJ2tu_',	'ridesharerates1704710794.jpg',	'2024-01-08',	'ridesharerates1704710794.jpg',	'1',	NULL,	NULL,	NULL,	'545-67-3766',	'2006-01-08',	'Patiala, Punjab, India',	'1',	'2024-01-08 10:46:34',	'2',	'qveSBCYLdmIoUaWf',	'Q0v092',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-02-12 13:27:22',	NULL,	'2024-02-12 13:28:15',	'18',	'1',	'1',	'ios',	'B1DF7089-C91A-4AE7-8C62-2B5841655F11',	'2024-01-08 05:46:34',	'2024-01-08 05:49:39'),
(996,	'Demetrius brundidge ',	NULL,	NULL,	'dee98@comcast.net',	'027c7e02d5064e48fda408df6b0aecfe',	'+1',	'(770) 880-4724',	'+1(770) 880-4724',	'United States',	'Georgia',	'Cobb County',	'33.80183986357668',	'-84.5507282566832',	NULL,	NULL,	NULL,	'ridesharerates1704918576.jpg',	'2024-01-10',	'ridesharerates1704918576.jpg',	'1',	1,	'2020-02-04',	'2026-02-04',	'084-50-6052',	'1973-02-04',	'6201 Huntington Ridge Rd, Mableton, GA 30126, USA',	'1',	'2024-01-10 20:29:36',	'2',	'fG19ylEeMfq9m9wO',	'y6s376',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-10 15:29:36',	NULL,	NULL,	'0',	'1',	'2',	'ios',	'7DD6C189-5488-4CEE-A67F-E1902A7F8B07',	'2024-01-10 15:29:36',	'2024-01-10 20:46:41'),
(997,	'Anthony cooper',	NULL,	NULL,	'aexoticlimo@gmail.com',	'1fee1ff1f272a371243bb53ec9904725',	'+1',	'(678) 522-6235',	'+1(678) 522-6235',	'United States',	'Georgia',	'Clayton County',	'33.57212671156367',	'-84.26673422263207',	NULL,	NULL,	'extcg6I5sU1MuJHOH_cpnX:APA91bEeqJof1vRj-hFnvwxdCuebMDYqI70uMvRMr7UcnnACIaE4MOFcc4r-NQj17b7TrSLVbQwQyEflTf9WUN9RgB9zIDZ9ztcDPM_r63Lshct2PhuwDVMNCxlMU590ANeXpIx_HVQB',	'ridesharerates1705110119.jpg',	'2024-01-12',	'ridesharerates1705110119.jpg',	'1',	1,	'2019-11-19',	'2027-12-04',	'328-64-2247',	'1973-12-04',	'3752 Brookwood Blvd, Rex, GA 30273, USA',	'1',	'2024-01-13 01:41:59',	'2',	'VLPvYSVPeae5OWSj',	'GiR709',	'',	'acct_1OiPzvBNDjBEuPcK',	NULL,	'3',	'0',	0,	NULL,	'2024-01-31 08:54:51',	NULL,	'2024-01-31 08:55:22',	'61',	'1',	'2',	'ios',	'C9C82975-6238-43EF-B9D5-9AC4CAF3DAE6',	'2024-01-12 20:41:59',	'2024-01-12 20:52:45'),
(998,	' Curtis Woodhouse',	NULL,	NULL,	'curtwood2@gmail.com',	'927b740f4d5776fc03b459f30d8b3632',	'+1',	'(757) 644-8633',	'+1(757) 644-8633',	'United States',	'Virginia',	'',	'36.78950995581891',	'-76.23379811815606',	NULL,	NULL,	'csGH8D9X5E_5p3c9a5jBco:APA91bEFfwzwNnEc4Zcj8lcLPqfhDSp1cuv4lYp0jp8kXVS3wngfj15_x7NQuMqhkzyDo2jr8bYI2XICGLPWxWlwnY4mRDNT8IWu3nNtwgJZppwit3qntSwasgawEnDeh-JHdW3_2E9V',	'ridesharerates1705119532.jpg',	'2024-01-12',	'ridesharerates1705119532.jpg',	'1',	1,	'2019-11-23',	'2028-11-23',	'111-11-1111',	'1982-11-23',	'Absinth Dr, South Fulton, GA 30349, USA',	'3',	'2024-01-13 04:18:52',	'2',	'E3cXSH4U7H9TUozN',	'450319',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-14 10:26:58',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'E5B3D0C8-E64D-45AF-860F-314C13EE4CFF',	'2024-01-12 23:18:52',	'2024-01-14 05:26:19'),
(999,	'Alexander Domah',	NULL,	NULL,	'alexdtransport@gmail.com',	'fc404c60410fb700fc09ec5843fc9b35',	'+1',	'(770) 572-8965',	'+1(770) 572-8965',	'United States',	'Georgia',	'Fulton County',	'33.65843640493317',	'-84.42751182910024',	NULL,	NULL,	'cREl5QxoAE48rSJQwuNVub:APA91bGTEAA8WXHBqXJjDucciSJxMVDtVl02iq45eDrIsHWm85MPm1juZ2UNkDdMWChMKTblVlFDeUO0ZmkEdKbiwvzYgFvPe4L0v4VX_CkQmxb-ZaOP4LYKmiwFXvg2uWNG6ntOfGMb',	'ridesharerates1705174205.jpg',	'2024-01-13',	'ridesharerates1705174205.jpg',	'1',	1,	'2023-10-27',	'2031-08-17',	'767-43-0428',	'1965-08-17',	'3159 Creston Park Ct, Duluth, GA 30096, USA',	'3',	'2024-01-13 19:30:05',	'2',	'wQmwezKVEmymZ2XV',	'LpK603',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-13 14:30:05',	NULL,	NULL,	'0',	'2',	'1',	'ios',	'1AADDA0C-D0E5-4BFC-95E9-FDBF21A2873E',	'2024-01-13 14:30:05',	'2024-01-13 17:46:34'),
(1000,	'MAMADOU COULIBALY',	NULL,	NULL,	'macoultransport@gmail.com',	'a0116bd897a7551ad8dfe5bf0ec8731a',	'+1',	'(770) 906-7128',	'+1(770) 906-7128',	'United States',	'Georgia',	'Clayton County',	'33.64104915572159',	'-84.44540462063688',	NULL,	NULL,	'e3r8rRCdj0s7pJycGpnGbX:APA91bFaO9dX5ftVAPS7M7IJV35OMvewxlWpwffqussKB2rTLX85BUj3WmmN92pzWEAzq83vipO7suxAa_vmQN41tS-iapfEnHjsZ6DxdI24JUiC5UcPqA7pcXA3vdSV8RSC962LOF0E',	'ridesharerates1705178046.jpg',	'2024-01-13',	'ridesharerates1705178046.jpg',	'',	1,	NULL,	NULL,	'185-78-3446',	'1962-05-02',	'491 Highpoint Crossing, Powder Springs, GA 30127, USA',	'3',	'2024-01-13 20:34:06',	'2',	'o1p3UnohGrqqPz0s',	'0kC408',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-14 22:01:15',	NULL,	NULL,	'0',	'2',	'1',	'ios',	'913329E2-872D-4CAD-A8C4-EC12990DF65B',	'2024-01-13 15:34:06',	'2024-02-09 09:56:35'),
(1001,	'Hopeton Blair',	NULL,	NULL,	'hopetonblair@gmail.com',	'bb45b8037c56e913068a5a45eedbe407',	'+1',	'(404) 953-9710',	'+1(404) 953-9710',	'United States',	'Georgia',	'Fulton County',	'33.62541355227218',	'-84.42118802030852',	NULL,	NULL,	'c389xMRfpEdJl1PLXQrkHh:APA91bErr-rd_S7PhWfKg2ISsh9nuWpo4W_jSbOYIinFVo55W1RYhr5VaEQfTNWMC1nJ31n-L-Q0tL88iVMcb7owpcSXqOs8h2JBjlavEF94pBU_XJ9WWjh4aEB4EMB7O2BDmfHuF8Jz',	'ridesharerates1705230266.jpg',	'2024-01-14',	'ridesharerates1705230266.jpg',	'1',	1,	'2019-10-08',	'2024-10-08',	'064-62-9836',	'1962-10-27',	'4997 Thompson Mill Rd, Stonecrest, GA 30038, USA',	'3',	'2024-01-14 11:04:26',	'2',	'tT4kW7Ln6Opy1a7h',	'OWU735',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-14 06:04:26',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'9F51035E-BDA6-42B5-AC8A-212B239E7191',	'2024-01-14 06:04:26',	'2024-01-14 19:15:03'),
(1003,	'Ibrahima Diallo',	NULL,	NULL,	'dsaliou10@hotmail.com',	'9e5e3f913f38117171a2fed5b1f54bb1',	'+1',	'(470) 985-2498',	'+1(470) 985-2498',	'United States',	'Georgia',	'Fulton County',	'33.70228600783359',	'-84.48397240312448',	NULL,	NULL,	'fb7X2vd4_Um4r8QAnOagWD:APA91bGJBfr60mvOLI9rRmtKolPBeK1ABwx2M7PthWfuHbstZU9yP_bhftMAS7VpvQgDm_r69h_j5oxjPV8kSzoT1kDmJ39BthxEhwliZKjdy-rJYHAXu-REoTmXa-NQmdnm6Cot3Mu6',	'ridesharerates1705292611.jpg',	'2024-01-14',	'ridesharerates1705292611.jpg',	'1',	1,	'2022-10-28',	'2031-01-01',	'130-94-3635',	'1968-01-01',	'Landrum Dr SW, Atlanta, GA 30311, USA',	'3',	'2024-01-15 04:23:31',	'2',	'rK64Tp7Zw76JzAd0',	'B24612',	'',	'acct_1OgO5oFJ0SFHXPqq',	NULL,	'3',	'0',	0,	NULL,	'2024-01-27 13:43:09',	NULL,	NULL,	'0',	'2',	'1',	'ios',	'EBA4FF90-3736-4EF3-8CA7-3C1D16817A37',	'2024-01-14 23:23:31',	'2024-01-17 09:39:19'),
(1004,	'Maurice',	'Boss.',	'Morris',	'ridesharerates@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(470) 746-9142',	'+1(470) 746-9142',	'United States',	'Georgia',	'Gwinnett County',	'33.8490905762',	'-84.0348623109',	NULL,	NULL,	'ePkQMGi3GEs8t1pCgVRIss:APA91bHFhFa3wMjQ4DAGsbmNQE3tsAzw7bczuasqsOT0JdHc81aSPS__-sL8EXOisl41H2IR_TGNEDzu2FtPScMOO-bSDM-uPEqkaMirbHvS0fZQ5KNpSOHscJpl80CqkRK-Z-UgokPk',	'1706451340rideshareratesjpg.jpg',	'2024-01-15',	'ridesharerates1705308875.jpg',	'1',	1,	'2022-01-07',	'2027-01-07',	'376-68-6962',	'1969-05-10',	'2996 Spruce Cir SW, Snellville, GA 30078, USA',	'1',	'2024-01-15 08:54:35',	'2',	'oTwq7H0waIKZlfru',	'586934',	'',	'acct_1OhVdUBBKNcTLJSo',	1,	'3',	'0',	0,	NULL,	'2024-02-11 14:03:35',	NULL,	'2024-02-12 12:49:46',	'138',	'1',	'1',	'ios',	'935868DA-E3B0-436F-B5EE-0CD4213C2485',	'2024-01-15 03:54:35',	'2024-01-15 04:32:48'),
(1006,	'Mtest',	NULL,	NULL,	'malikabcoder@gmail.com',	'd8578edf8458ce06fbc5bb76a58c5ca4',	'+1',	'(582) 585-6888',	'+1(582) 585-6888',	'India',	'Punjab',	'Patiala Division',	'30.3397809',	'76.3868797',	NULL,	NULL,	NULL,	'ridesharerates1705409504.jpg',	'2024-01-16',	NULL,	'2',	NULL,	NULL,	NULL,	'557-56-7658',	'2006-01-16',	'Patiala, Punjab, India',	'3',	'2024-01-16 12:51:44',	'2',	'2veEC1JhbRyn9bHb',	'758096',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-16 07:51:44',	NULL,	NULL,	'0',	'2',	'2',	'0',	'0',	'2024-01-16 07:51:44',	'2024-01-16 07:51:44'),
(1007,	'Janice Gadson',	NULL,	NULL,	'janicenicole1991@gmail.com',	'bea09a871c0873628b36f3ef3acfb46b',	'+1',	'(313) 685-6317',	'+1(313) 685-6317',	'',	'',	'',	'0.0',	'0.0',	NULL,	NULL,	'd--o-jxLQy6qq0HJToOTmN:APA91bFGCyo6FrjRdperipY9jJWjImFjRxDxepLknx68GN1GyOUQF5drYUUkLRYAyGEYN0Bm_fnprYsbxLUhE8MBlQaj5brtS24BaENAYy961Sijv6oEyplIEJPehm-oayHACutfdwGy',	'ridesharerates1705451117.jpg',	'2024-01-16',	'ridesharerates1705451117.jpg',	'',	1,	NULL,	NULL,	'111-11=1111',	'1993-01-16',	'3411 Chattahoochee Cir, Roswell, GA 30075, USA',	'1',	'2024-01-17 00:25:17',	'2',	'91Q1bhOcL1z8IfZz',	'IyU590',	'',	'acct_1OiPtzBHVxMHAYlM',	1,	'3',	'0',	0,	NULL,	'2024-01-16 19:25:17',	NULL,	NULL,	'0',	'1',	'2',	'0',	'0',	'2024-01-16 19:25:17',	'2024-02-10 23:40:11'),
(1016,	'Preeti Malhotra',	NULL,	NULL,	'preetimalhotra88@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	'+1',	'(699) 964-9999',	'+1(699) 964-9999',	'India',	'Haryana',	'Gurgaon Division',	'28.4792617',	'77.0237256',	NULL,	NULL,	'eV4r5D5VTRO-_xlzAmN6nd:APA91bGkcL0Ck9C78NQ5-JOp75TwId00bd2JIuRqFfi-DNUe3fWHHmusP-x6SFVtTrzlM4ud5N8OPQtilHevRaOP0ORCgbyLSukj_heVkxT0ae5hDmIDg39cH51ekB2Kz2I6s62Ob5xW',	NULL,	NULL,	NULL,	'2',	NULL,	NULL,	NULL,	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-23 13:33:41',	'1',	'DU0KsMKV91F15P1J',	'fMz086',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-23 08:33:41',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'CC4EE60E-A138-4852-877D-9CE3E405C4C9',	'2024-01-23 08:33:41',	'2024-01-23 08:33:41'),
(1017,	'Maurice Morris',	NULL,	NULL,	'thelavishstore@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(404) 207-5621',	'+1(404) 207-5621',	'United States',	'Georgia',	'Gwinnett County',	'33.8488512',	'-84.0349819',	NULL,	NULL,	'cEFQuxMOSAmrfQ_X4WKIPg:APA91bFz9JlGKOmEj9Wnxn0bAjIOjnuN-Rdkrlb6PNI_tmVLxXYgsy1P5hRCeBI14inMk3DSxBCOoAEgzjFWvFUq9nfCWkkzTzyaUB7rL4iej4wYkktffXywhjPqmAtU820vzhLHq-WX',	'1706230562rideshareratesjpg.jpg',	'2024-01-25',	NULL,	'2',	NULL,	NULL,	NULL,	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-23 13:58:10',	'1',	'qzAcoZSSX4k09LBl',	'Gji418',	'',	NULL,	NULL,	'3',	'0',	0,	0.00,	'2024-01-23 08:58:10',	NULL,	NULL,	'0',	'2',	'1',	'android',	'ba516e43e18d3682',	'2024-01-23 08:58:10',	'2024-01-23 08:58:10'),
(1018,	'Maurice Morris',	NULL,	NULL,	'wykesdetroit@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(404) 207-5622',	'+1(404) 207-5622',	'United States',	'Georgia',	'Gwinnett County',	'33.84909891212908',	'-84.03489339997628',	NULL,	NULL,	'f9fucKx_SYq13Po-FIi0yi:APA91bFBzMFh0Vlrb8-T9CZplxJ_oDdC72y6936jTI-t6qCQqKbuGVGAa-NIRe4YoWX0BehP_eY-zMhtCIw5pUG6BaIONxo5WPuhXTuXl7-J_8AkyXUvET0C52cI_8xYoUJRiZf5W5-6',	'1706223039rideshareratesjpg.jpg',	NULL,	'ridesharerates1706848467.jpg',	'2',	1,	'2024-02-02',	'2027-02-03',	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-24 00:41:56',	'1',	'lgh340GTLJAcYPqF',	'EhD752',	'',	NULL,	NULL,	'3',	'0',	0,	0.00,	'2024-01-23 19:41:56',	NULL,	NULL,	'0',	'2',	'1',	'ios',	'935868DA-E3B0-436F-B5EE-0CD4213C2485',	'2024-01-23 19:41:56',	'2024-01-23 19:41:56'),
(1019,	'Rohit Rider',	NULL,	NULL,	'rohit@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	'+1',	'(131) 546-4879',	'+1(131) 546-4879',	'India',	'Uttar Pradesh',	'Meerut Division',	'28.6021094',	'77.3541364',	NULL,	NULL,	'fXlrx_8sREU6v0vJN2xVgS:APA91bGPodN7gOBlm6i2VykWefOb07Bk_YkBOEpjxdZp-nmCHEVA1qxPY7NXZrAUjki6-t5zunP8Qre277RQlOkkXszHi2hqwst4SLn5iwEp-MNI2XU_OGMF2CGduDYmktB06Iqp4N67',	'1706523828rideshareratesjpg.jpg',	'2024-01-24',	'ridesharerates1706098298.jpg',	'2',	NULL,	NULL,	NULL,	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-24 11:48:40',	'1',	'ijSwYfVTuR68dRnq',	'7Bs953',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-24 06:48:40',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'360A5AD9-E306-47EF-BD40-56BD0EF58F83',	'2024-01-24 06:48:40',	'2024-01-24 06:48:40'),
(1020,	'Marker',	NULL,	NULL,	'marker@gmail.com',	'fcea920f7412b5da7be0cf42b8c93759',	'+1',	'(916) 314-4494',	'+1(916) 314-4494',	'India',	'Uttar Pradesh',	'Meerut Division',	'28.6021143',	'77.3541371',	NULL,	NULL,	'cPVhmL6mTiGRGe3xmjFCew:APA91bFXG7MdYZEc528r1MrLKhPGAqDWtZTUxReHbjjAlppybg__QpxAuUltpRDMcAy5i9M2dYTzCQjRYKDXsLdWJOdEcDYadNArC-B3wZE8U1RkqkDU4c1gKqxplUrsgaQssAy9gy2Q',	'ridesharerates1706164253.jpg',	'2024-01-25',	'ridesharerates1706164253.jpg',	'2',	1,	'2021-01-25',	'2028-01-25',	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-25 06:30:53',	'1',	'r2gjDew805PkecKj',	'MUE412',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-25 01:30:53',	NULL,	NULL,	'0',	'2',	'2',	'android',	'd404aa1ca40a90bc',	'2024-01-25 01:30:53',	'2024-01-25 01:30:53'),
(1021,	'Ram ',	'Mr.',	'Chauhan',	'ramkishor.niletechnologies@gmail.com',	'd41d8cd98f00b204e9800998ecf8427e',	'Colorado',	'(888) 888-7777',	'+1(987) 987-9457',	'India',	'Uttar Pradesh',	'Meerut Division',	'28.6021172',	'77.3541462',	NULL,	NULL,	'dd3qp42eQ26IdNdzBUyVKI:APA91bH-hqlJWt-7dZTXDcUvTZIy7y3bxJCNLbeb-YnlsvplfLei4-zRlQCdEXwW4tcjLe-lIKABDv5ixeGRGzX4srSFRydrx7PP7O3Sp04DkSnjcwF2dzHIgIF9PUSK1xS7uTvt2MVz',	'ridesharerates1706166418.jpg',	'2024-01-25',	'ridesharerates1706166418.jpg',	'',	1,	NULL,	NULL,	'123-45-6789',	'2004-01-25',	'Sector 57 Rd, Block C, Sector 57, Noida, Uttar Pradesh 201301, India',	'1',	'2024-01-25 07:06:58',	'2',	'j0q3P9J1DJK7ZM2X',	'426013',	'',	'acct_1OhVaEB9sJyUeTb1',	NULL,	'3',	'0',	0,	NULL,	'2024-01-25 02:06:58',	NULL,	NULL,	'0',	'1',	'2',	'android',	'cfa5cf6cb4e20618',	'2024-01-25 02:06:58',	'2024-02-12 09:50:20'),
(1022,	'Test',	NULL,	NULL,	'malika@gmail.com',	'd8578edf8458ce06fbc5bb76a58c5ca4',	'+1',	'(875) 848-8757',	'+1(875) 848-8757',	'India',	'Punjab',	'Patiala Division',	'30.365805198877435',	'76.38335055010101',	NULL,	NULL,	'eH3IIGB5aUiGoFcXDtpDMO:APA91bF-iK4FSya05uBRBFZwjcCT0lSy-DV5zz7jdL_PWasBV2MWu2yQpPTdup23pvfwbG0Ypkwj9Wo06mKce3eY2zsDH7vwQwfvL86s21vBJi6fikikLCIFTTWFzAQd7zJlmNmp6ZB0',	'ridesharerates1706536634.jpg',	'2024-01-29',	'ridesharerates1706536634.jpg',	'2',	1,	'2024-01-29',	'2026-01-30',	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-29 13:57:14',	'1',	'GAtCr6fjfng5zRF7',	'dax748',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-29 08:57:14',	NULL,	NULL,	'0',	'2',	'2',	'0',	'0',	'2024-01-29 08:57:14',	'2024-01-29 08:57:14'),
(1023,	'SBG  ENT ',	NULL,	NULL,	'sbgent1@gmail.com',	'c4771454f411f8b2fbd2862d0c40f2a9',	'+1',	'(678) 629-0673',	'+1(678) 629-0673',	'United States',	'Georgia',	'Clayton County',	'33.57210501352612',	'-84.26674718288298',	NULL,	NULL,	'df5uU8ikqUWAla3GfHimu0:APA91bFg35mHva0GLfisvJCW9GBpHmZfCkvswenAqA49fbe0bhKWl1mJWLJZVzMA9fHgqKvBcZNlqweswQ1Xz8A0UrABRKcfyZZ-ckAJuuSfKwMUkAWvZIv4E8FqkMv93z77A8XYpfyi',	'ridesharerates1706711517.jpg',	'2024-01-31',	'ridesharerates1706711517.jpg',	'2',	1,	'2019-11-11',	'2027-12-04',	NULL,	'1969-12-31',	NULL,	'1',	'2024-01-31 14:31:57',	'1',	'WV3VIGsT3zRqW8wM',	'135867',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-01-31 09:31:57',	NULL,	NULL,	'0',	'2',	'1',	'ios',	'C9C82975-6238-43EF-B9D5-9AC4CAF3DAE6',	'2024-01-31 09:31:57',	'2024-01-31 09:31:57'),
(1024,	'Maurice',	'Boss.',	'Anthony',	'7551wykes@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(404) 207-5620',	'+1(404) 207-5620',	'United States',	'Georgia',	'Gwinnett County',	'33.8490159',	'-84.0349144',	NULL,	NULL,	'cxBEN-t8QmyJ4z6h9JJerR:APA91bEm4QF9tw-E__-Mh4Sectv-i2_yNbCquDKs0o2fSefFiQGfGLnP-3vAXyzRdsd1iOENbVzJOKWcL7_UXJ7YRkHXDa3cDPdo8QPCVj0pl32q_Lc7Y2EP6KoAW_z0HjIVIYcXjwr6',	'1706947454rideshareratesjpg.jpg',	'2024-02-03',	'ridesharerates1706839085.jpg',	'',	1,	'0000-00-00',	'0000-00-00',	'111-11-1111',	'1969-05-10',	'2996 Spruce Cir SW, Snellville, GA 30078, USA',	'1',	'2024-02-02 01:58:05',	'2',	'OW4I6f0AgbE4JDtg',	'qjL695',	'',	'acct_1OhbIsPYPR45iV30',	1,	'3',	'0',	0,	NULL,	'2024-02-09 14:03:56',	NULL,	'2024-02-13 06:05:20',	'165',	'1',	'1',	'android',	'ba516e43e18d3682',	'2024-02-01 20:58:05',	'2024-02-03 08:13:14'),
(1025,	'Tracey ',	'Ms.',	'Tate',	'ssstate2@gmail.com',	'32c706c4565de3275411410495c3aa86',	'+1',	'(248) 469-5570',	'+1(248) 469-5570',	'United States',	'Michigan',	'Wayne County',	'42.4855041504',	'-83.2419037354',	NULL,	NULL,	'dOHHUDImIk3Nlna3M_5l7V:APA91bGqVAJ3Xcvj5_nMFqZNa4BgnsHG-C1_pSALk0QRVW5B_UAHQb5rvJNdPAttY70rG--NUOMbmBd4D1kYjGNErN1kbVmeVbCy4e-VWCraP5JlO0GvFCJ9T7VAKg37odJ_XhVq0XzC',	'ridesharerates1707260112.jpg',	'2024-02-06',	'ridesharerates1707260112.jpg',	'',	1,	NULL,	NULL,	'375-82-6425',	'1970-05-24',	'20049 Evergreen Meadows Rd, Southfield, MI 48076, USA',	'1',	'2024-02-06 22:55:12',	'2',	'DgxEo1Tb6zkMD9oi',	'pxO073',	'',	NULL,	NULL,	'1',	'0',	0,	NULL,	'2024-02-06 22:55:12',	NULL,	'2024-02-08 03:25:07',	'0',	'1',	'1',	'ios',	'F5452A25-528E-42B9-9956-FA4292F7084B',	'2024-02-06 22:55:12',	'2024-02-13 00:44:22'),
(1026,	'Fname',	'boss',	'lname',	'testname@gmail.com',	'd8578edf8458ce06fbc5bb76a58c5ca4',	'+1',	'(878) 788-7873',	'+1(878) 788-7873',	'India',	'Bihar',	'Patna Division',	'25.5940947',	'85.1375645',	NULL,	NULL,	NULL,	'ridesharerates1707293152.jpg',	'2024-02-07',	NULL,	'2',	NULL,	NULL,	NULL,	'578-76-9797',	'2004-02-07',	'Patna, Bihar, India',	'3',	'2024-02-07 08:05:52',	'2',	'FVTSfrgxY03tz6rY',	'8Po910',	'',	'acct_1OiPcSB18hd9Q0o1',	NULL,	'3',	'0',	0,	NULL,	'2024-02-07 08:05:52',	NULL,	NULL,	'0',	'2',	'2',	'0',	'0',	'2024-02-07 08:05:52',	'2024-02-07 08:05:52'),
(1027,	'Maurice',	'Boss',	'morris',	'detroitmoe@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(470) 213-9896',	'+1(470) 213-9896',	'United States',	'Georgia',	'Gwinnett County',	'33.8491254',	'-84.0348867',	NULL,	NULL,	'eNJ3bFQaXkgYsZ3dalCaaO:APA91bEsYpBBASegmKYIGlo5yNUMn_uktiWVSJYcwQ4q-Ow4JuSc5sHVFs_UcL2nAv9bddRxYO8t5yEjhqbe4b5USqfClUJZFmHNOkEY8OFvtcacbOVIqiU8_Brko9nI8CtMoI8tB9Yf',	'ridesharerates1707416479.jpg',	'2024-02-08',	'ridesharerates1707416479.jpg',	'2',	1,	'2022-02-08',	'2026-02-08',	NULL,	'1970-01-01',	NULL,	'1',	'2024-02-08 18:21:19',	'1',	'bVx6fev6o4PJS2BD',	'Vph583',	'',	NULL,	NULL,	'3',	'0',	0,	0.00,	'2024-02-08 18:21:19',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'CC4EE60E-A138-4852-877D-9CE3E405C4C9',	'2024-02-08 18:21:19',	'2024-02-08 18:21:19'),
(1028,	'Maurice',	'Boss',	'Morris',	'detroitrider@gmail.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(313) 516-5818',	'+1(313) 516-5818',	'United States',	'Georgia',	'Gwinnett County',	'33.8490858',	'-84.0349166',	NULL,	NULL,	'ezMPM8xkTkO_dnoHL0WlQ5:APA91bH-z_n6rKxcSRDWqHOIbzwlQKguCO8gZyGtX5XKkPljikmKiTkVYuKGqG2tREIHFJERH7oBGoNay13OWDL3qTqIvOevX4hR6LH4a5k3KWgClcG_SZoLXNP2nRT-8ABHeqcv42Hj',	'ridesharerates1707483548.jpg',	'2024-02-09',	'ridesharerates1707483548.jpg',	'2',	1,	'2023-02-09',	'2025-02-09',	NULL,	'1970-01-01',	NULL,	'1',	'2024-02-09 12:59:08',	'1',	'tq3pi04Qu7h7M0e6',	'629075',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-02-09 12:59:08',	NULL,	NULL,	'0',	'2',	'1',	'android',	'192c15306d4d4a2e',	'2024-02-09 12:59:08',	'2024-02-09 12:59:08'),
(1029,	'Frederico Mobley',	'Boss',	'',	'fredericomobley@yahoo.com',	'e9776003297cc602df734825c72221da',	'+1',	'(313) 729-9329',	'+1(313) 729-9329',	'',	'',	'',	'0.0',	'0.0',	NULL,	NULL,	'd0zOsmMITBOvjTXxWgC2wv:APA91bEWxoXeepiE2vj3qWpgESkg89ZqjW1rglvoHhSjFG7YNAFTcomvCSE5PNr5vNb_9rfo_ORq6bex0LgAvLN6FjRyKcGwLofV30oQGDsBT3LX6DkSpr-YqHd94UStdudfuHq-hvIm',	'ridesharerates1707522786.jpg',	'2024-02-09',	'ridesharerates1707522786.jpg',	'',	1,	NULL,	NULL,	'378-78-7343',	'1970-03-28',	'8873 Stonebridge Ct, Belleville, MI 48111, USA',	'1',	'2024-02-09 23:53:06',	'2',	'abYslNQyaiIbgm53',	'CoF694',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-02-09 23:53:06',	NULL,	NULL,	'0',	'1',	'1',	'android',	'55fe57fabb94842b',	'2024-02-09 23:53:06',	'2024-02-10 23:00:58'),
(1030,	'Senequa Mobley',	'Boss',	NULL,	'senequamobley@gmail.com',	'4e9ffc76027585259e3117d577927a80',	'+1',	'(313) 729-3721',	'+1(313) 729-3721',	'United States',	'Michigan',	'Wayne County',	'42.2367311',	'-83.5138639',	NULL,	NULL,	'fcFCyhIiQD-yhmhIxrGA_R:APA91bH5nhJVuSW2y7TQTZ9ug1_RT9HPflmoKopIhaJKAu1kZiygV7Lm3n2YnabO5zj4IeAnzDFDiJewdH7WS0r0ylgb_J0HW2xCHLsGJA9LcnGt7XNMUSLRd4T7d6_WrENrhKWqZlRr',	'ridesharerates1707525570.jpg',	'2024-02-10',	NULL,	'',	1,	'2023-01-20',	'2027-01-16',	'364-78-0397',	'1973-01-16',	'8873 Stonebridge Ct, Belleville, MI 48111, USA',	'3',	'2024-02-10 00:39:30',	'2',	'Ck42rYWb70Hwpi08',	'0yR106',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-02-10 00:39:30',	NULL,	NULL,	'0',	'1',	'1',	'android',	'101c28af85b2b701',	'2024-02-10 00:39:30',	'2024-02-10 23:33:41'),
(1031,	'Maurice',	'Boss',	'morris',	'lavishcollection@aol.com',	'bea0948a5271ecd6076fcb91e8b34961',	'+1',	'(313) 231-0822',	'+1(313) 231-0822',	'United States',	'Georgia',	'Gwinnett County',	'33.849149',	'-84.0349449',	NULL,	NULL,	'cNKlBiYERGevDwJaZZLYMm:APA91bEkzzbK20qcN5b__3GljudjQBZYH6Dtjgv5ET_ZCoYysEt-4I1UuAi_TZB8bGQSug1W8yp-ddqUBX3YUTFIKMJCp9R6DWprXvtgR323APkt0IuiW0gYEwoJ04U0THZ45_A73sJ-',	'ridesharerates1707573195.jpg',	'2024-02-10',	'ridesharerates1707573195.jpg',	'2',	1,	'2024-02-10',	'2026-02-10',	NULL,	'1970-01-01',	NULL,	'1',	'2024-02-10 13:53:15',	'1',	'2Q2Ob3BGCg21yhsH',	'Ksa065',	'',	NULL,	NULL,	'3',	'0',	0,	5.00,	'2024-02-10 13:53:15',	NULL,	NULL,	'0',	'2',	'1',	'android',	'ba516e43e18d3682',	'2024-02-10 13:53:15',	'2024-02-10 13:53:15'),
(1032,	'Lenise',	'Ms.',	'wilson ',	'c1rtransportation2022@gmail.com',	'c124133d6a66ff02f472086310f58e42',	'+1',	'(313) 449-2102',	'+1(313) 449-2102',	'United States',	'Michigan',	'Oakland County',	'42.45594780626549',	'-83.21189213626396',	NULL,	NULL,	'eRmZ5a_7zUlPjsFRWs4NOu:APA91bFQ2fDaICRuHt3z83snkNyAVNe6jL-dO4tm2wVRLN4KBj3_X8DH0lGiALtriIkBulSQG4ylASvKBT7GoY5hkqnDUnyQsCqyXFRdU4l5md6RGq6VsVJa20mhR7JxVrQNnvmCRNLM',	'ridesharerates1707779554.jpg',	'2024-02-12',	NULL,	'',	1,	NULL,	NULL,	'375-82-6055',	'1977-06-19',	'16400 N Park Dr, Southfield, MI 48075, USA',	'3',	'2024-02-12 23:12:34',	'2',	'v0JhJrJ7yIMT95xa',	'TIE425',	'',	NULL,	NULL,	'3',	'0',	0,	NULL,	'2024-02-12 23:12:34',	NULL,	NULL,	'0',	'2',	'2',	'ios',	'C4A9A58D-E170-47FD-9AC1-ADFC78B4724C',	'2024-02-12 23:12:34',	'2024-02-13 00:44:55')
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `name` = VALUES(`name`), `name_title` = VALUES(`name_title`), `last_name` = VALUES(`last_name`), `email` = VALUES(`email`), `password` = VALUES(`password`), `country_code` = VALUES(`country_code`), `mobile` = VALUES(`mobile`), `countrycode_mobile` = VALUES(`countrycode_mobile`), `country` = VALUES(`country`), `state` = VALUES(`state`), `city` = VALUES(`city`), `latitude` = VALUES(`latitude`), `longitude` = VALUES(`longitude`), `destination_lat` = VALUES(`destination_lat`), `destination_long` = VALUES(`destination_long`), `gcm_token` = VALUES(`gcm_token`), `avatar` = VALUES(`avatar`), `profile_upload_date` = VALUES(`profile_upload_date`), `verification_id` = VALUES(`verification_id`), `verification_id_approval_atatus` = VALUES(`verification_id_approval_atatus`), `identification_document_id` = VALUES(`identification_document_id`), `identification_issue_date` = VALUES(`identification_issue_date`), `identification_expiry_date` = VALUES(`identification_expiry_date`), `ssn` = VALUES(`ssn`), `dob` = VALUES(`dob`), `home_address` = VALUES(`home_address`), `status` = VALUES(`status`), `reg_date` = VALUES(`reg_date`), `utype` = VALUES(`utype`), `random` = VALUES(`random`), `otp` = VALUES(`otp`), `paypal_id` = VALUES(`paypal_id`), `stripe_account_id` = VALUES(`stripe_account_id`), `stripe_onboarding` = VALUES(`stripe_onboarding`), `is_online` = VALUES(`is_online`), `is_deleted` = VALUES(`is_deleted`), `count_cancelled_ride` = VALUES(`count_cancelled_ride`), `cancellation_charge` = VALUES(`cancellation_charge`), `login_time` = VALUES(`login_time`), `offline_time` = VALUES(`offline_time`), `online_time` = VALUES(`online_time`), `total_working_hour` = VALUES(`total_working_hour`), `background_approval_status` = VALUES(`background_approval_status`), `is_logged_in` = VALUES(`is_logged_in`), `device_type` = VALUES(`device_type`), `device_token` = VALUES(`device_token`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `vehicle_categor_year`;
CREATE TABLE `vehicle_categor_year` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `category_year` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `vehicle_categor_year` (`id`, `category_id`, `category_year`, `status`) VALUES
(1,	1,	2022,	1),
(2,	1,	2023,	1),
(4,	2,	2022,	1),
(5,	2,	2023,	1),
(7,	3,	2010,	1),
(8,	3,	2011,	1),
(9,	3,	2012,	1),
(10,	3,	2013,	1),
(11,	3,	2014,	1),
(12,	3,	2015,	1),
(13,	3,	2016,	1),
(14,	3,	2017,	1),
(15,	3,	2018,	1),
(16,	3,	2019,	1),
(17,	3,	2020,	1),
(18,	3,	2021,	1),
(19,	3,	2022,	1),
(20,	3,	2023,	1),
(22,	4,	1950,	1),
(23,	4,	1951,	1),
(24,	4,	1952,	1),
(25,	4,	1953,	1),
(26,	4,	1954,	1),
(27,	4,	1955,	1),
(28,	4,	1956,	1),
(29,	4,	1957,	1),
(30,	4,	1958,	1),
(31,	4,	1959,	1),
(32,	4,	1960,	1),
(33,	4,	1961,	1),
(34,	4,	1962,	1),
(35,	4,	1963,	1),
(36,	4,	1964,	1),
(37,	4,	1965,	1),
(38,	4,	1965,	1),
(39,	4,	1966,	1),
(40,	4,	1967,	1),
(41,	4,	1968,	1),
(42,	4,	1969,	1),
(43,	4,	1970,	1),
(44,	4,	1971,	1),
(46,	4,	1972,	1),
(47,	4,	1973,	1),
(48,	4,	1974,	1),
(49,	4,	1975,	1),
(50,	4,	1976,	1),
(51,	4,	1977,	1),
(52,	4,	1978,	1),
(53,	4,	1979,	1),
(54,	4,	1980,	1),
(55,	4,	1981,	1),
(56,	4,	1982,	1),
(57,	4,	1983,	1),
(58,	4,	1984,	1),
(59,	4,	1985,	1),
(60,	4,	1986,	1),
(61,	4,	1987,	1),
(62,	4,	1988,	1),
(63,	4,	1989,	1),
(64,	4,	1990,	1),
(65,	4,	1991,	1),
(66,	4,	1992,	1),
(67,	4,	1993,	1),
(68,	4,	1994,	1),
(69,	4,	1995,	1),
(70,	4,	1996,	1),
(71,	4,	1997,	1),
(72,	4,	1998,	1),
(73,	4,	1999,	1),
(74,	4,	2000,	1),
(75,	4,	2001,	1),
(76,	4,	2002,	1),
(77,	4,	2003,	1),
(78,	4,	2004,	1),
(79,	4,	2005,	1),
(80,	4,	2006,	1),
(81,	4,	2007,	1),
(82,	4,	2008,	1),
(83,	4,	2009,	1),
(84,	4,	2010,	1),
(85,	4,	2011,	1),
(86,	4,	2012,	1),
(87,	4,	2013,	1),
(88,	4,	2014,	1),
(89,	4,	2015,	1),
(90,	4,	2016,	1),
(91,	4,	2017,	1),
(92,	4,	2018,	1),
(93,	4,	2019,	1),
(94,	4,	2020,	1),
(95,	4,	2020,	1),
(96,	4,	2021,	1),
(97,	4,	2022,	1),
(98,	4,	2023,	1),
(100,	5,	1950,	1),
(101,	5,	1951,	1),
(102,	5,	1952,	1),
(103,	5,	1953,	1),
(104,	5,	1954,	1),
(105,	5,	1955,	1),
(106,	5,	1956,	1),
(107,	5,	1957,	1),
(108,	5,	1958,	1),
(109,	5,	1959,	1),
(110,	5,	1960,	1),
(111,	5,	1961,	1),
(112,	5,	1962,	1),
(113,	5,	1963,	1),
(114,	5,	1964,	1),
(115,	5,	1965,	1),
(116,	5,	1966,	1),
(117,	5,	1967,	1),
(118,	5,	1968,	1),
(119,	5,	1969,	1),
(120,	5,	1970,	1),
(121,	5,	1971,	1),
(122,	5,	1972,	1),
(123,	6,	1973,	1),
(124,	6,	1974,	1),
(125,	6,	1975,	1),
(126,	6,	1976,	1),
(127,	6,	1977,	1),
(128,	6,	1978,	1),
(129,	6,	1979,	1),
(130,	6,	1980,	1),
(131,	6,	1981,	1),
(132,	6,	1982,	1),
(133,	6,	1983,	1),
(134,	6,	1984,	1),
(135,	6,	1985,	1),
(136,	6,	1986,	1),
(137,	6,	1987,	1),
(138,	6,	1988,	1),
(139,	6,	1989,	1),
(140,	6,	1990,	1),
(141,	6,	1991,	1),
(142,	6,	1992,	1),
(143,	6,	1993,	1),
(144,	6,	1994,	1),
(145,	6,	1995,	1),
(146,	6,	1996,	1),
(147,	6,	1997,	1),
(148,	6,	1998,	1),
(149,	6,	1999,	1),
(150,	7,	2019,	1),
(151,	7,	2020,	1),
(152,	7,	2021,	1),
(153,	7,	2022,	1),
(154,	7,	2023,	1),
(156,	11,	2014,	1),
(157,	11,	2015,	1),
(158,	11,	2016,	1),
(159,	11,	2017,	1),
(160,	11,	2018,	1),
(161,	11,	2019,	1),
(162,	11,	2020,	1),
(163,	11,	2021,	1),
(164,	11,	2022,	1),
(165,	11,	2023,	1),
(167,	7,	2024,	1),
(168,	3,	2024,	1),
(169,	2,	2024,	1),
(170,	1,	2024,	1),
(171,	11,	2024,	1),
(172,	4,	2024,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `category_id` = VALUES(`category_id`), `category_year` = VALUES(`category_year`), `status` = VALUES(`status`);

DROP TABLE IF EXISTS `vehicle_detail`;
CREATE TABLE `vehicle_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `model_id` int NOT NULL,
  `vehicle_type_id` int DEFAULT NULL,
  `year` year NOT NULL,
  `color` varchar(150) NOT NULL,
  `vehicle_no` varchar(150) NOT NULL,
  `seat_no` int DEFAULT NULL,
  `premium_facility` varchar(20) DEFAULT NULL,
  `license` varchar(150) NOT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `license_approve_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2: Not Approve',
  `insurance` varchar(150) NOT NULL,
  `insurance_issue_date` date DEFAULT NULL,
  `insurance_expiry_date` date DEFAULT NULL,
  `insurance_approve_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2: Not approve',
  `permit` varchar(150) NOT NULL,
  `car_pic` varchar(150) NOT NULL,
  `car_issue_date` date DEFAULT NULL,
  `car_expiry_date` date DEFAULT NULL,
  `car_registration` varchar(100) NOT NULL,
  `car_registration_approve_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2: Not approved',
  `inspection_document` char(150) DEFAULT NULL,
  `inspection_issue_date` date DEFAULT NULL,
  `inspection_expiry_date` date DEFAULT NULL,
  `inspection_approval_status` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1:Approved 2: Not Approved',
  `status` enum('1','2','3') NOT NULL COMMENT '1:Active 2:Inactive 3:Delete',
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vehicle_detail` (`id`, `user_id`, `brand_id`, `model_id`, `vehicle_type_id`, `year`, `color`, `vehicle_no`, `seat_no`, `premium_facility`, `license`, `license_issue_date`, `license_expiry_date`, `license_approve_status`, `insurance`, `insurance_issue_date`, `insurance_expiry_date`, `insurance_approve_status`, `permit`, `car_pic`, `car_issue_date`, `car_expiry_date`, `car_registration`, `car_registration_approve_status`, `inspection_document`, `inspection_issue_date`, `inspection_expiry_date`, `inspection_approval_status`, `status`, `created_date`, `updated_date`) VALUES
(536,	981,	4,	34,	34,	'2020',	'White',	'BWK628BW',	2,	'',	'1704694689ocory.jpg',	'2021-01-08',	'2027-01-08',	'1',	'1704694701ocory.jpg',	'2021-01-08',	'2027-01-08',	'1',	'',	'1704694652ocory.jpg',	'2021-01-08',	'2027-01-08',	'1704694676ocory.jpg',	'1',	'1704694715ocory.jpg',	'2021-01-08',	'2026-01-08',	'1',	'1',	'2024-01-08 01:17:32',	'2024-01-19 05:26:37'),
(537,	984,	1,	25,	NULL,	'2024',	'red',	'qwhsh123',	2,	'',	'1704710933ocory.jpg',	'2024-01-08',	'2035-01-09',	'1',	'1704710947ocory.jpg',	'2024-01-08',	'2029-01-09',	'1',	'',	'1704710794ocory.jpg',	'2021-01-08',	'2033-01-09',	'1704710919ocory.jpg',	'1',	'1704710961ocory.jpg',	'2024-01-08',	'2029-01-09',	'1',	'1',	'2024-01-08 05:46:34',	'2024-01-08 05:50:00'),
(539,	996,	1,	26,	26,	'2023',	'black',	'lm11711',	2,	NULL,	'',	'0000-00-00',	'0000-00-00',	'1',	'',	'0000-00-00',	'0000-00-00',	'1',	'',	'1704918576ocory.jpg',	'0000-00-00',	'0000-00-00',	'',	'1',	'',	'2024-01-10',	'2024-01-10',	'1',	'1',	'2024-01-10 15:29:36',	'2024-01-10 20:46:41'),
(540,	997,	1,	26,	NULL,	'2023',	'black ',	'LM1499',	2,	'',	'',	'2019-11-19',	'2027-12-04',	'1',	'',	'2024-01-12',	'2026-01-12',	'1',	'',	'1705158841ocory.jpg',	'2024-01-12',	'2026-01-12',	'',	'1',	'',	'2024-01-12',	'2027-01-12',	'1',	'1',	'2024-01-12 20:41:59',	'2024-01-13 10:14:01'),
(541,	998,	7,	41,	41,	'2019',	'black',	'Ran3325',	2,	NULL,	'',	'2017-10-02',	'2025-11-23',	'1',	'',	'0000-00-00',	'0000-00-00',	'2',	'',	'1705119532ocory.jpg',	'0000-00-00',	'0000-00-00',	'',	'2',	'',	'2024-01-13',	'2024-01-13',	'2',	'1',	'2024-01-12 23:18:52',	'2024-01-14 05:26:19'),
(542,	999,	1,	26,	NULL,	'2023',	'black ',	'LM12612',	2,	'',	'1705174946ocory.jpg',	'2023-10-27',	'2031-08-17',	'1',	'1705174412ocory.jpg',	'2023-09-21',	'2024-09-21',	'1',	'',	'1705174205ocory.jpg',	'2023-09-25',	'2025-01-31',	'1705175104ocory.jpg',	'1',	'1705174584ocory.jpg',	'2023-12-30',	'2024-12-30',	'1',	'1',	'2024-01-13 14:30:05',	'2024-01-13 17:46:34'),
(543,	1000,	1,	26,	NULL,	'2022',	'Black',	'LM1934a',	2,	'',	'1705179214ocory.jpg',	'2021-06-17',	'2029-05-02',	'1',	'1706400757ocory.jpg',	'2023-08-27',	'2024-08-27',	'2',	'',	'1705178046ocory.jpg',	'2023-04-03',	'2024-05-02',	'1705179598ocory.jpg',	'1',	'1706294333ocory.jpg',	'2024-01-15',	'2024-03-16',	'2',	'1',	'2024-01-13 15:34:06',	'2024-02-09 09:56:35'),
(544,	1001,	1,	26,	26,	'2023',	'Black',	'LM 11434',	2,	NULL,	'1705230459ocory.jpg',	'2019-10-08',	'2024-10-08',	'1',	'1705233754ocory.jpg',	'2023-09-12',	'2024-09-12',	'2',	'',	'1705230266ocory.jpg',	'0000-00-00',	'0000-00-00',	'',	'2',	'',	'2024-01-14',	'2024-01-14',	'2',	'1',	'2024-01-14 06:04:26',	'2024-01-14 19:15:03'),
(546,	1003,	1,	26,	26,	'2023',	'Black',	'LM8900',	2,	NULL,	'1705292674ocory.jpg',	'2022-10-28',	'2031-01-01',	'1',	'1705292961ocory.jpg',	'2023-09-21',	'2024-09-21',	'1',	'',	'1705292611ocory.jpg',	'2023-12-19',	'2025-01-01',	'1705292900ocory.jpg',	'1',	'1705293775ocory.jpg',	'2023-12-11',	'2024-05-08',	'2',	'1',	'2024-01-14 23:23:31',	'2024-01-17 09:39:19'),
(547,	1004,	1,	25,	0,	'2023',	'white',	'080WBE',	2,	'',	'1705309359ocory.jpg',	'2021-01-07',	'2027-01-07',	'1',	'1705309390ocory.jpg',	'2021-01-07',	'2027-01-07',	'1',	'',	'1705308875ocory.jpg',	'2021-01-07',	'2027-01-07',	'1705309327ocory.jpg',	'1',	'1705309416ocory.jpg',	'2022-01-07',	'2027-01-07',	'1',	'1',	'2024-01-15 03:54:35',	'2024-01-23 19:55:15'),
(549,	1006,	4,	35,	35,	'1951',	'red',	'hcch',	2,	NULL,	'',	NULL,	NULL,	'2',	'',	NULL,	NULL,	'2',	'',	'1705409504ocory.jpg',	NULL,	NULL,	'',	'2',	NULL,	NULL,	NULL,	'2',	'1',	'2024-01-16 07:51:44',	'2024-01-16 07:51:44'),
(550,	1007,	1,	25,	25,	'2022',	'White',	'1234',	2,	'',	'1705451465ocory.jpg',	'2024-01-16',	'2025-01-16',	'1',	'1705451478ocory.jpg',	'2024-01-16',	'2025-01-16',	'1',	'',	'1705451117ocory.jpg',	'2024-01-16',	'2026-01-16',	'1705451442ocory.jpg',	'1',	'1705451494ocory.jpg',	'2024-01-16',	'2026-01-16',	'2',	'1',	'2024-01-16 19:25:17',	'2024-02-10 23:40:11'),
(552,	1021,	1,	25,	25,	'2023',	'black',	'dgaf342',	2,	'',	'1706174672ocory.jpg',	'2024-01-25',	'2025-01-25',	'1',	'1706174695ocory.jpg',	'2024-01-25',	'2026-01-25',	'1',	'',	'1706166418ocory.jpg',	'2024-01-25',	'2026-01-25',	'1706174644ocory.jpg',	'1',	'1706174715ocory.jpg',	'2024-01-25',	'2026-01-25',	'2',	'1',	'2024-01-25 02:06:58',	'2024-02-12 09:50:20'),
(553,	1024,	1,	25,	0,	'2023',	'white',	'080wwe',	2,	'',	'1706839192ocory.jpg',	'2023-01-03',	'2026-02-01',	'1',	'1706839217ocory.jpg',	'2023-02-01',	'2025-02-01',	'1',	'',	'1706839085ocory.jpg',	'2023-12-01',	'2025-12-03',	'1706839159ocory.jpg',	'1',	'1706839247ocory.jpg',	'2024-02-01',	'2025-02-01',	'1',	'1',	'2024-02-01 20:58:05',	'2024-02-06 11:58:23'),
(554,	1025,	2,	28,	28,	'2023',	'graphite/ Grey',	'C8141777',	2,	NULL,	'1707272620ocory.jpg',	'2022-01-04',	'2025-05-24',	'1',	'1707316666ocory.jpg',	'2024-01-05',	'2024-07-05',	'1',	'',	'1707260112ocory.jpg',	'2024-02-06',	'2025-02-28',	'1707272542ocory.jpg',	'1',	'1707316880ocory.jpg',	'2024-01-05',	'2026-01-05',	'1',	'1',	'2024-02-06 22:55:12',	'2024-02-13 00:44:22'),
(555,	1026,	3,	32,	32,	'2011',	'red',	'ushs',	2,	NULL,	'',	NULL,	NULL,	'2',	'',	NULL,	NULL,	'2',	'',	'1707293152ocory.jpg',	NULL,	NULL,	'',	'2',	NULL,	NULL,	NULL,	'2',	'1',	'2024-02-07 08:05:52',	'2024-02-07 08:05:52'),
(556,	1029,	3,	32,	32,	'2016',	'black13',	'EGZ7934',	2,	'',	'1707522962ocory.jpg',	'2020-04-01',	'2024-03-28',	'1',	'1707527438ocory.jpg',	'2023-11-17',	'2024-05-17',	'1',	'',	'1707522786ocory.jpg',	'2023-03-28',	'2024-03-28',	'1707523281ocory.jpg',	'1',	'1707527465ocory.jpg',	'2023-02-09',	'2024-02-09',	'1',	'1',	'2024-02-09 23:53:06',	'2024-02-10 23:00:58'),
(557,	1030,	1,	26,	26,	'2022',	'white',	'EQS7754',	2,	'',	'',	'2023-01-20',	'2027-01-16',	'2',	'1707527258ocory.jpg',	'2023-11-17',	'2024-05-17',	'1',	'',	'1707525570ocory.jpg',	'2023-03-28',	'2024-03-28',	'1707525662ocory.jpg',	'1',	'1707525775ocory.jpg',	'2023-02-09',	'2024-02-09',	'1',	'1',	'2024-02-10 00:39:30',	'2024-02-10 23:33:41'),
(558,	1032,	7,	41,	41,	'2023',	'Black ',	'DE41850',	2,	NULL,	'',	'0000-00-00',	'0000-00-00',	'2',	'',	'0000-00-00',	'0000-00-00',	'2',	'',	'1707779554ocory.jpg',	'0000-00-00',	'0000-00-00',	'',	'2',	'',	'2024-02-13',	'2024-02-13',	'2',	'1',	'2024-02-12 23:12:34',	'2024-02-13 00:44:55')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `brand_id` = VALUES(`brand_id`), `model_id` = VALUES(`model_id`), `vehicle_type_id` = VALUES(`vehicle_type_id`), `year` = VALUES(`year`), `color` = VALUES(`color`), `vehicle_no` = VALUES(`vehicle_no`), `seat_no` = VALUES(`seat_no`), `premium_facility` = VALUES(`premium_facility`), `license` = VALUES(`license`), `license_issue_date` = VALUES(`license_issue_date`), `license_expiry_date` = VALUES(`license_expiry_date`), `license_approve_status` = VALUES(`license_approve_status`), `insurance` = VALUES(`insurance`), `insurance_issue_date` = VALUES(`insurance_issue_date`), `insurance_expiry_date` = VALUES(`insurance_expiry_date`), `insurance_approve_status` = VALUES(`insurance_approve_status`), `permit` = VALUES(`permit`), `car_pic` = VALUES(`car_pic`), `car_issue_date` = VALUES(`car_issue_date`), `car_expiry_date` = VALUES(`car_expiry_date`), `car_registration` = VALUES(`car_registration`), `car_registration_approve_status` = VALUES(`car_registration_approve_status`), `inspection_document` = VALUES(`inspection_document`), `inspection_issue_date` = VALUES(`inspection_issue_date`), `inspection_expiry_date` = VALUES(`inspection_expiry_date`), `inspection_approval_status` = VALUES(`inspection_approval_status`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `vehicle_service`;
CREATE TABLE `vehicle_service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `vehicle_type_id` int NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1:Active 2:Inactive',
  `created_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `vehicle_type_id` (`vehicle_type_id`),
  CONSTRAINT `vehicle_service_ibfk_11` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET DEFAULT ON UPDATE SET DEFAULT,
  CONSTRAINT `vehicle_service_ibfk_12` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle_detail` (`id`) ON DELETE SET DEFAULT ON UPDATE SET DEFAULT,
  CONSTRAINT `vehicle_service_ibfk_13` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_subcategory_type` (`id`) ON DELETE SET DEFAULT ON UPDATE SET DEFAULT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `vehicle_service` (`id`, `user_id`, `vehicle_id`, `vehicle_type_id`, `status`, `created_date`, `updated_date`) VALUES
(2563,	984,	537,	25,	'1',	'2024-01-08 05:50:00',	'2024-01-08 05:50:00'),
(2566,	996,	539,	26,	'1',	'2024-01-10 20:46:41',	'2024-01-10 20:46:41'),
(2577,	997,	540,	26,	'1',	'2024-01-13 10:14:01',	'2024-01-13 10:14:01'),
(2582,	999,	542,	26,	'1',	'2024-01-13 17:46:34',	'2024-01-13 17:46:34'),
(2587,	998,	541,	41,	'1',	'2024-01-14 05:26:19',	'2024-01-14 05:26:19'),
(2591,	1001,	544,	26,	'1',	'2024-01-14 19:15:03',	'2024-01-14 19:15:03'),
(2599,	1006,	549,	35,	'1',	'2024-01-16 07:51:44',	'2024-01-16 07:51:44'),
(2616,	1003,	546,	26,	'1',	'2024-01-17 09:39:19',	'2024-01-17 09:39:19'),
(2650,	981,	536,	34,	'1',	'2024-01-19 05:26:37',	'2024-01-19 05:26:37'),
(2652,	1004,	547,	25,	'1',	'2024-01-23 19:55:15',	'2024-01-23 19:55:15'),
(2674,	1024,	553,	25,	'1',	'2024-02-06 11:58:23',	'2024-02-06 11:58:23'),
(2676,	1026,	555,	32,	'1',	'2024-02-07 08:05:52',	'2024-02-07 08:05:52'),
(2681,	1000,	543,	26,	'1',	'2024-02-09 09:56:35',	'2024-02-09 09:56:35'),
(2684,	1029,	556,	32,	'1',	'2024-02-10 23:00:58',	'2024-02-10 23:00:58'),
(2687,	1030,	557,	26,	'1',	'2024-02-10 23:33:41',	'2024-02-10 23:33:41'),
(2688,	1007,	550,	25,	'1',	'2024-02-10 23:40:11',	'2024-02-10 23:40:11'),
(2691,	1021,	552,	25,	'1',	'2024-02-12 09:50:20',	'2024-02-12 09:50:20'),
(2694,	1025,	554,	28,	'1',	'2024-02-13 00:44:22',	'2024-02-13 00:44:22'),
(2695,	1032,	558,	41,	'1',	'2024-02-13 00:44:55',	'2024-02-13 00:44:55')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `vehicle_id` = VALUES(`vehicle_id`), `vehicle_type_id` = VALUES(`vehicle_type_id`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `vehicle_subcategory_type`;
CREATE TABLE `vehicle_subcategory_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_type_category_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `seat` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `base_fare_fee` varchar(100) NOT NULL DEFAULT '0',
  `cancellation_fee` varchar(100) DEFAULT '0',
  `taxes` varchar(100) NOT NULL DEFAULT '0',
  `surcharge_fee` varchar(100) DEFAULT '0',
  `hold_amount` varchar(100) DEFAULT '0',
  `admin_charges` varchar(100) DEFAULT NULL,
  `rate` varchar(100) NOT NULL DEFAULT '0',
  `short_description` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `car_pic` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `status` enum('1','2') NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `vehicle_type_category_id` (`vehicle_type_category_id`),
  CONSTRAINT `vehicle_subcategory_type_ibfk_1` FOREIGN KEY (`vehicle_type_category_id`) REFERENCES `vehicle_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vehicle_subcategory_type` (`id`, `vehicle_type_category_id`, `title`, `seat`, `base_fare_fee`, `cancellation_fee`, `taxes`, `surcharge_fee`, `hold_amount`, `admin_charges`, `rate`, `short_description`, `car_pic`, `status`, `created_date`, `updated_date`) VALUES
(25,	1,	'LUXURY 2022-2024 S550 Comparable ',	'2',	'1',	'5',	'1',	'1',	'6',	'34',	'1',	'2 Passenger Rear Seating Only',	'1694639738-BackgroundEraser_20230913_165521712.png',	'1',	'2024-02-06 19:05:21',	'2024-02-06 14:05:21'),
(26,	1,	'LUXURY SUV 2022-2024 Escalade ALL COLORS Comparable ',	'7',	'120',	'10',	'8',	'8',	'275',	'34',	'3',	'7 Passenger Escalade Comparable ',	'1696834288-BackgroundEraser_20230913_182237881.png',	'1',	'2024-01-26 09:19:34',	'2024-01-26 04:19:34'),
(27,	2,	'ELECTRIC 2022-2024 Porsche Taycan Comparable ',	'2',	'75',	'10',	'8',	'8',	'300',	'36',	'2',	'2 Passenger Porsche Taycan or Comparable ',	'1694638353-BackgroundEraser_20230913_165003448.png',	'1',	'2024-01-26 09:19:53',	'2024-01-26 04:19:53'),
(28,	2,	'ELECTRIC 2022-2024 Karma Comparable ',	'2',	'90',	'10',	'8',	'8',	'250',	'36',	'2',	'2 Passenger Rear Seating Only',	'1694638432-BackgroundEraser_20230913_165003448.png',	'1',	'2024-01-26 09:20:17',	'2024-01-26 04:20:17'),
(29,	2,	'ELECTRIC 2022-2024 SUV RIVIAN Comparable ',	'2',	'93',	'10',	'8',	'8',	'325',	'36',	'2',	'2-4 Passenger',	'1701513999-BackgroundEraser_20230913_165521712.png',	'1',	'2024-01-26 09:20:36',	'2024-01-26 04:20:36'),
(30,	3,	'EXOTIC SEDAN 2018-2024 Rolls-Royce Comparable ',	'2',	'677',	'150',	'8',	'8',	'2500',	'33',	'10',	'Rolls-Royce Phantom Comparable ',	'1694640370-BackgroundEraser_20230913_172140761.png',	'1',	'2024-01-26 09:20:57',	'2024-01-26 04:20:57'),
(31,	3,	'EXOTIC SEDAN 2010-2017 Rolls-Royce, Maybach, Bentley ',	'2',	'333',	'150',	'8',	'8',	'1000',	'33',	'8',	'Rolls-Royce Phantom, Maybach, Bentley Comparable ',	'1694640836-BackgroundEraser_20230913_172140761.png',	'1',	'2024-01-26 09:21:15',	'2024-01-26 04:21:15'),
(32,	3,	'EXOTIC Coupe 2014-2019 Rolls-Royce Drophead Comparable ',	'1',	'308',	'150',	'8',	'8',	'1400',	'33',	'8',	'1 Passenger',	'1694640922-BackgroundEraser_20230913_173324011.png',	'1',	'2024-01-26 09:23:31',	'2024-01-26 04:23:31'),
(33,	3,	'EXOTIC SUV  2020-2024 Rolls-Royce Cullinan ',	'2',	'486',	'150',	'8',	'8',	'2000',	'33',	'10',	'2 Passenger Rear Seating Only',	'1694641769-BackgroundEraser_20230913_173839690_(1).png',	'1',	'2024-01-26 09:21:37',	'2024-01-26 04:21:37'),
(34,	4,	'RARE COUPE One-Offs or Limited',	'1',	'466',	'10',	'8',	'8',	'2200',	'33',	'15',	'1 Passenger',	'1694641986-BackgroundEraser_20230913_175133147.png',	'1',	'2024-01-26 09:22:06',	'2024-01-26 04:22:06'),
(35,	4,	'RARE SEDAN One-offs or Limited',	'2',	'493',	'150',	'8',	'8',	'1500',	'33',	'12',	'2 Passenger Rear Seating Only',	'1696834214-BackgroundEraser_20230913_183304850.png',	'1',	'2024-01-26 09:22:25',	'2024-01-26 04:22:25'),
(36,	4,	'RARE SUV  One-offs or Limited ',	'2',	'479',	'150',	'8',	'8',	'1500',	'33',	'12',	'2 Passennger Rear Seating Only',	'1694642975-BackgroundEraser_20230913_173839690_(1).png',	'1',	'2024-01-26 09:23:10',	'2024-01-26 04:23:10'),
(37,	5,	'VINTAGE SEDAN 1950-1960',	'2',	'333',	'150',	'8',	'8',	'1500',	'33',	'8',	'2 Passenger Rear Seating Only',	'1694643188-BackgroundEraser_20230913_181135215.png',	'1',	'2024-01-26 09:22:43',	'2024-01-26 04:22:43'),
(38,	5,	'VINTAGE Coupe 1950-1960',	'1',	'399',	'150',	'8',	'8',	'1500',	'33',	'8',	'1 Passenger',	'1694643211-BackgroundEraser_20230913_181135215.png',	'1',	'2024-01-26 09:23:59',	'2024-01-26 04:23:59'),
(39,	6,	'CLASSIC  Sedan 25-50 years old',	'2',	'333',	'150',	'8',	'8',	'1200',	'33',	'4',	'2 Passenger Rear Seating Only',	'1694643232-BackgroundEraser_20230913_181135215.png',	'1',	'2024-01-26 09:24:21',	'2024-01-26 04:24:21'),
(40,	6,	'CLASSIC Coupe 25-50yrs Old',	'1',	'233',	'150',	'8',	'8',	'1000',	'33',	'8',	'1 Passenger',	'1694643250-BackgroundEraser_20230913_181135215.png',	'1',	'2024-01-26 09:24:40',	'2024-01-26 04:24:40'),
(41,	7,	'SPRINTER Van',	'',	'200',	'150',	'8',	'8',	'500',	'33',	'4',	'7-10 Passengers',	'1697289046-BackgroundEraser_20231014_091001616.png',	'1',	'2024-01-26 09:24:55',	'2024-01-26 04:24:55'),
(50,	11,	'Armored Truck',	'7',	'200',	'150',	'8',	'8',	'500',	'33',	'5',	'SUV',	'1696833719-BackgroundEraser.png',	'1',	'2024-01-26 09:25:18',	'2024-01-26 04:25:18')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `vehicle_type_category_id` = VALUES(`vehicle_type_category_id`), `title` = VALUES(`title`), `seat` = VALUES(`seat`), `base_fare_fee` = VALUES(`base_fare_fee`), `cancellation_fee` = VALUES(`cancellation_fee`), `taxes` = VALUES(`taxes`), `surcharge_fee` = VALUES(`surcharge_fee`), `hold_amount` = VALUES(`hold_amount`), `admin_charges` = VALUES(`admin_charges`), `rate` = VALUES(`rate`), `short_description` = VALUES(`short_description`), `car_pic` = VALUES(`car_pic`), `status` = VALUES(`status`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `vehicle_type`;
CREATE TABLE `vehicle_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1:Active 2:Inactive',
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `vehicle_type` (`id`, `title`, `status`, `short_description`, `created_date`, `updated_date`) VALUES
(1,	'LUXURY:',	'1',	'2 Passenger Rear Seating',	'2023-12-23 21:14:27',	'2023-12-23 21:14:27'),
(2,	'ELECTRIC: ',	'1',	'2 Passenger Rear Seating Only',	'2023-12-22 14:01:38',	'2023-12-22 14:01:38'),
(3,	'EXOTIC: ',	'1',	'2 Passenger Rear Seating Only',	'2023-12-22 14:01:49',	'2023-12-22 14:01:49'),
(4,	'RARE: ',	'1',	'1-2 Passenger Seating',	'2023-12-22 14:02:01',	'2023-12-22 14:02:01'),
(5,	'VINTAGE: ',	'1',	'Sedan (2) passenger',	'2023-12-22 14:02:13',	'2023-12-22 14:02:13'),
(6,	'CLASSIC: ',	'1',	'2 Passenger Rear Seating Only (May have aftermarket wheels)',	'2023-12-22 14:02:26',	'2023-12-22 14:02:26'),
(7,	'SPRINTER',	'1',	'Up to 7 Passenger Seating ',	'2023-09-09 02:33:05',	'2023-09-09 02:33:05'),
(11,	'Armored Truck',	'1',	'SUV',	'2023-09-20 10:55:47',	'2023-09-20 10:55:47')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `short_description` = VALUES(`short_description`), `created_date` = VALUES(`created_date`), `updated_date` = VALUES(`updated_date`);

DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `version_no` varchar(100) DEFAULT NULL,
  `is_android` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `version` (`id`, `title`, `version_no`, `is_android`, `created_at`, `updated_at`) VALUES
(1,	'Driver',	'1.0',	1,	'2023-03-28 17:08:02',	'2023-03-28 17:08:02'),
(2,	'Rider',	'1.0',	1,	'2023-03-28 17:08:02',	'2023-03-28 17:08:02'),
(3,	'Driver',	'1.0',	0,	'2023-03-28 17:20:22',	'2023-03-28 17:20:22'),
(4,	'Rider',	'1.0',	0,	'2023-03-28 17:20:22',	'2023-03-28 17:20:22')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `title` = VALUES(`title`), `version_no` = VALUES(`version_no`), `is_android` = VALUES(`is_android`), `created_at` = VALUES(`created_at`), `updated_at` = VALUES(`updated_at`);

DROP TABLE IF EXISTS `work_invoice`;
CREATE TABLE `work_invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ride_id` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1: Active 2: Inactive',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ride_id` (`ride_id`),
  CONSTRAINT `work_invoice_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `book_request` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2024-02-13 06:41:55
