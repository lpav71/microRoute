-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.30 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных bd
CREATE DATABASE IF NOT EXISTS `bd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bd`;

-- Дамп структуры для таблица bd.locality
CREATE TABLE IF NOT EXISTS `locality` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `region_id` int unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `region_id_foreign` (`region_id`),
  CONSTRAINT `region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы bd.locality: ~9 rows (приблизительно)
DELETE FROM `locality`;
INSERT INTO `locality` (`id`, `region_id`, `name`) VALUES
	(1, 1, 'Краснодар'),
	(2, 1, 'Москва'),
	(3, 1, 'Челябинск'),
	(4, 2, 'Нур-Султан'),
	(5, 3, 'Минск'),
	(6, 4, 'Уфа'),
	(10, 13, 'Токио'),
	(11, 3, 'Витебск'),
	(12, 44, 'Сидней'),
	(13, 44, 'Сидней'),
	(14, 44, 'Мельбурн');

-- Дамп структуры для таблица bd.region
CREATE TABLE IF NOT EXISTS `region` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы bd.region: ~18 rows (приблизительно)
DELETE FROM `region`;
INSERT INTO `region` (`id`, `name`) VALUES
	(1, 'Россия'),
	(2, 'Казахстан'),
	(3, 'Белоруссия'),
	(4, 'Башкирия'),
	(13, 'Япония'),
	(19, 'Германия'),
	(20, 'Швеция'),
	(21, 'Канада'),
	(22, 'США'),
	(23, 'Польша'),
	(24, 'Чехия'),
	(25, 'Словения'),
	(30, 'Ирак'),
	(31, 'Иран'),
	(32, 'Судан'),
	(33, 'Боливия'),
	(34, 'Чили'),
	(44, 'Австралия');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
