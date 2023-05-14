-- Adminer 4.8.1 MySQL 8.0.33 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE `auctions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `cat_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `description` text NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `auctions_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auctions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `auctions` (`id`, `name`, `cat_id`, `user_id`, `description`, `end_date`) VALUES
(3,	'Samantha Huber',	6,	10,	'Esse sunt qui cum m',	'2004-05-07 00:00:00'),
(4,	'Cameron Mclaughlin',	7,	10,	'Adipisci qui quam ve',	'1998-01-22 00:00:00'),
(5,	'Ivy Browning',	8,	10,	'Quia quos pariatur',	'2000-10-24 00:00:00'),
(6,	'Raven James',	6,	10,	'Vero dolor esse dol',	'2004-11-12 00:00:00'),
(7,	'Dalton Carr',	10,	10,	'Voluptas enim repell',	'2005-08-19 00:00:00'),
(8,	'Rama Jacobson',	9,	10,	'Aspernatur natus per',	'2006-02-27 00:00:00'),
(9,	'Darryl Manning',	6,	10,	'Tempora saepe sint d',	'2005-06-29 00:00:00'),
(10,	'Willa Moore',	7,	11,	'Nihil laboriosam se',	'1984-05-01 00:00:00');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` (`id`, `name`) VALUES
(6,	'Test'),
(7,	'Home & Garden'),
(8,	'Electronics'),
(9,	'Fashion'),
(10,	'Sport');

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `auction_id` bigint NOT NULL,
  `review` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `auction_id` (`auction_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reviews` (`id`, `user_id`, `auction_id`, `review`) VALUES
(5,	10,	3,	'Et quaerat tenetur a'),
(6,	10,	9,	'Eiusmod error vero c sdf gasdg asdga dfnas asfha asdg asdg asdga\r\nasdfa sdga'),
(7,	10,	9,	'Officia incidunt su'),
(8,	10,	9,	'Officia incidunt su'),
(9,	11,	8,	'from suman'),
(10,	17,	10,	'Hello');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(10,	'admin',	'a@a.a',	'21232f297a57a5a74389'),
(11,	'suman',	'suman@a.a',	'1533c67e5e70ae7439a9'),
(12,	'Suman Mali',	'suman@suman.com',	'1533c67e5e70ae7439a9aa993d6a3393'),
(13,	'Dorian Carlson',	'zysy@mailinator.com',	'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(14,	'Damon Dixon',	'qajyzad@mailinator.com',	'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(15,	'Medge Mason',	'fulyduv@mailinator.com',	'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(16,	'Lucian Leon',	'maryrohy@mailinator.com',	'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(17,	'Suman ABC',	'x@x.x',	'1533c67e5e70ae7439a9aa993d6a3393');

-- 2023-05-02 08:53:16
