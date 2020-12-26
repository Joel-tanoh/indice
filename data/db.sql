-- MySQL dump 10.13  Distrib 5.7.19, for Win64 (x86_64)
--
-- Host: localhost    Database: inoveinn_wp806
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ind_announces`
--

DROP TABLE IF EXISTS `ind_announces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_announces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `id_sub_category` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `user_email_address` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `posted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_category` (`id_category`),
  KEY `fk_id_sub_category` (`id_sub_category`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_announces`
--

LOCK TABLES `ind_announces` WRITE;
/*!40000 ALTER TABLE `ind_announces` DISABLE KEYS */;
INSERT INTO `ind_announces` VALUES (4,'un super vélo','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','un-super-velo-4',4,NULL,'25000','tanohbassapatrick@gmail.com','+22549324696','Abobo Avocatier',0,'2020-12-25 10:34:17',NULL,NULL,0,NULL),(5,'une belle voiture','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','une-belle-voiture-5',2,NULL,'3500000','tanohbassapatrick@gmail.com','+22549324696','',0,'2020-12-25 10:37:48',NULL,NULL,0,NULL),(6,'Une grande maison','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','une-grande-maison-6',3,NULL,'27000000','tanohbassapatrick@gmail.com','+22549324696','',0,'2020-12-25 10:44:12',NULL,NULL,0,NULL),(7,'De belles chaussures','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','de-belles-chaussures-7',4,NULL,'5000','tanohbassapatrick@gmail.com','+22549324696','Cocody Riviera',0,'2020-12-25 10:57:19',NULL,NULL,0,NULL),(8,'De belles chaussures','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','de-belles-chaussures-8',4,NULL,'5000','tanohbassapatrick@gmail.com','+22549324696','Cocody Riviera',0,'2020-12-25 10:59:43',NULL,NULL,0,NULL),(9,'De belles chaussures','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','de-belles-chaussures-9',4,NULL,'5000','tanohbassapatrick@gmail.com','+22549324696','Cocody Riviera',0,'2020-12-25 11:01:16',NULL,NULL,0,NULL),(10,'De belles chaussures','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','de-belles-chaussures-10',4,NULL,'5000','tanohbassapatrick@gmail.com','+22549324696','Cocody Riviera',0,'2020-12-25 11:01:29',NULL,NULL,0,NULL),(11,'De beaux habits','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','de-beaux-habits-11',4,NULL,'5000','tanohbassapatrick@gmail.com','+22549324696','',0,'2020-12-25 11:14:03',NULL,NULL,0,NULL),(12,'Test','Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.','test-12',2,NULL,'','tanohbassapatrick@gmail.com','+22549324696','',0,'2020-12-25 23:27:15',NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `ind_announces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_categories`
--

DROP TABLE IF EXISTS `ind_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `description` text,
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_title` (`title`),
  UNIQUE KEY `uni_slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_categories`
--

LOCK TABLES `ind_categories` WRITE;
/*!40000 ALTER TABLE `ind_categories` DISABLE KEYS */;
INSERT INTO `ind_categories` VALUES (4,'Bonnes affaires','bonnes-affaires','2020-12-24 06:30:57',NULL,NULL,'lni-control-panel'),(2,'Véhicules','vehicules','2020-12-24 06:17:23',NULL,NULL,'lni-car'),(3,'Immobiler','immobiler','2020-12-24 06:17:23',NULL,NULL,'lni-home'),(5,'High-Tech','high-tech','2020-12-24 06:30:57',NULL,NULL,'lni-laptop'),(6,'Emploi Formations','emploi-formations','2020-12-24 06:46:14',NULL,NULL,'lni-briefcase'),(7,'Rencontre','rencontre','2020-12-24 06:46:14',NULL,NULL,'lni-heart'),(8,'Matériel professionnel','materiel-professionnel','2020-12-24 06:46:14',NULL,NULL,'lni-notepad'),(9,'Communauté','communaute','2020-12-24 06:46:14',NULL,NULL,'lni-hand'),(10,'Bien-être','bien-etre','2020-12-24 06:46:14',NULL,NULL,'lni-leaf');
/*!40000 ALTER TABLE `ind_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_sub_categories`
--

DROP TABLE IF EXISTS `ind_sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `id_category` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_title` (`title`) USING BTREE,
  UNIQUE KEY `uni_slug` (`slug`),
  KEY `fk_id_category` (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_sub_categories`
--

LOCK TABLES `ind_sub_categories` WRITE;
/*!40000 ALTER TABLE `ind_sub_categories` DISABLE KEYS */;
INSERT INTO `ind_sub_categories` VALUES (1,'Jeu de football','jeu-de-football',1,'2020-11-27 23:57:24',NULL,'C\'est un jeu de football');
/*!40000 ALTER TABLE `ind_sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_users`
--

DROP TABLE IF EXISTS `ind_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_names` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_pseudo` (`pseudo`),
  UNIQUE KEY `un_email` (`email_address`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_users`
--

LOCK TABLES `ind_users` WRITE;
/*!40000 ALTER TABLE `ind_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ind_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-26  1:50:42
