-- MariaDB dump 10.17  Distrib 10.5.5-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: phpwebinars
-- ------------------------------------------------------
-- Server version	10.5.5-MariaDB-1:10.5.5+maria~xenial

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Утюги'),(2,'Микроволновые печи'),(3,'Кофеварки и кофемашины');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) DEFAULT NULL,
  `size` int(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'1_1_upload1599280477.jpg','/upload/products/1/1_1_upload1599280477.jpg',41623),(2,1,'1_2_upload1599280478.jpg','/upload/products/1/1_2_upload1599280478.jpg',32245),(3,1,'1_3_upload1599280478.jpg','/upload/products/1/1_3_upload1599280478.jpg',31877),(4,1,'1_4_upload1599280479.jpg','/upload/products/1/1_4_upload1599280479.jpg',64390),(5,2,'2_5_upload1599280479.jpg','/upload/products/2/2_5_upload1599280479.jpg',42630),(6,2,'2_6_upload1599280479.jpg','/upload/products/2/2_6_upload1599280479.jpg',43726),(7,2,'2_7_upload1599280480.jpg','/upload/products/2/2_7_upload1599280480.jpg',56392),(8,3,'3_8_upload1599280480.jpg','/upload/products/3/3_8_upload1599280480.jpg',29533),(9,4,'4_9_upload1599280481.jpg','/upload/products/4/4_9_upload1599280481.jpg',42765),(10,4,'4_10_upload1599280481.png','/upload/products/4/4_10_upload1599280481.png',305545),(11,4,'4_11_upload1599280482.png','/upload/products/4/4_11_upload1599280482.png',358050),(12,5,'5_12_upload1599280483.jpg','/upload/products/5/5_12_upload1599280483.jpg',26610),(13,6,'6_13_upload1599280483.jpg','/upload/products/6/6_13_upload1599280483.jpg',20228),(14,6,'6_14_upload1599280483.jpg','/upload/products/6/6_14_upload1599280483.jpg',38074),(15,6,'6_15_upload1599280484.jpg','/upload/products/6/6_15_upload1599280484.jpg',50682);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `article` varchar(255) NOT NULL DEFAULT '',
  `price` double unsigned DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Утюг Philips GC4902/20 Azur','GC4902/20 Azur',5990,28,'мощность: 2800 Вт\\nпостоянный пар: 50 г/мин\\nпаровой удар: 220 г/мин\\nвертикальное отпаривание\\nфункция разбрызгивания\\nавтоматическое отключение\\nпротивокапельная система\\nвес: 1.67 кг',1),(2,'Утюг Morphy Richards 305003','305003',7490,9,'мощность: 2400 Вт\\nматериал подошвы: керамика\\nпостоянный пар: 50 г/мин\\nпаровой удар: 230 г/мин\\nвертикальное отпаривание\\nфункция разбрызгивания\\nавтоматическое отключение\\nпротивокапельная система\\nвес: 1.69 кг',1),(3,'Микроволновая печь LG MS-20R42D','MS-20R42D',5650,18,'объем 20 л\\nмощность 700 Вт\\nвнутреннее покрытие камеры: эмаль\\nкнопочные переключатели\\nдисплей\\nсистема равномерного распределения микроволн\\nзащита от детей',2),(4,'Утюг Scarlett SC-SI30K37','SC-SI30K37',1390,4,'мощность: 2400 Вт\\nматериал подошвы: керамика\\nпостоянный пар: 45 г/мин\\nпаровой удар: 145 г/мин\\nвертикальное отпаривание\\nфункция разбрызгивания\\nпротивокапельная система',1),(5,'Кофемашина Nespresso C30 Essenza Mini','С30',5790,2,'капсульная\\nкапсулы Nespresso\\nрегулировка порции воды\\nотключение при неиспользовании\\nкорпус из пластика',3),(6,'Кофемашина De\\\'Longhi Magnifica ECAM 22.110','ECAM 22.110',29990,4,'автоматическая, 15 бар\\nдля зернового и молотого кофе\\nкофемолка с регулировкой степени помола\\nконтроль крепости кофе\\nнастройка температуры\\nрегулировка порции воды\\nсамоочистка от накипи\\nприготовление капучино\\nотключение при неиспользовании\\nодновременная раздача на 2 чашки\\nкорпус из пластика',3);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks_queue`
--

DROP TABLE IF EXISTS `tasks_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `task` varchar(255) NOT NULL DEFAULT '',
  `params` varchar(255) NOT NULL,
  `status` enum('new','in_process','done','error') DEFAULT 'new',
  `created_at` datetime /* mariadb-5.3 */ NOT NULL,
  `updated_at` datetime /* mariadb-5.3 */ NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_queue`
--

LOCK TABLES `tasks_queue` WRITE;
/*!40000 ALTER TABLE `tasks_queue` DISABLE KEYS */;
INSERT INTO `tasks_queue` VALUES (1,'Импорт товаров i_1599280004.import.csv','App\\Import::productsFromFileTask','{\"filename\":\"i_1599280004.import.csv\"}','done','2020-09-05 11:26:44','2020-09-05 11:34:44');
/*!40000 ALTER TABLE `tasks_queue` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-15  9:03:22
