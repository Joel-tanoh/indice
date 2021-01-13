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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

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
  `user_to_join` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `posted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_category` (`id_category`),
  KEY `fk_id_sub_category` (`id_sub_category`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_announces`
--

LOCK TABLES `ind_announces` WRITE;
/*!40000 ALTER TABLE `ind_announces` DISABLE KEYS */;
INSERT INTO `ind_announces` VALUES (13,'Une belle voiture','&lt;p&gt;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet voluptatem labore cupiditate molestiae porro velit inventore totam eos? Reiciendis tempore quae odio perferendis pariatur. Placeat aliquid sapiente consequuntur ullam alias vitae rem iure aperiam dolor dolorum culpa sit eius quas fugit blanditiis nisi nemo dolores repellat pariatur, maiores corrupti ipsa commodi enim.&lt;br&gt;&lt;/p&gt;','une-belle-voiture-13',2,NULL,'3500000','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan',NULL,NULL,0,'2020-12-28 23:56:12',NULL,NULL,0,NULL),(16,'Vente d\'ordinateur ASUS Core i5 7ème génération 6 G Ram','&lt;p&gt;Un bel ordinateur Asus Core i5 avec 6 G de ram.&lt;br&gt;&lt;/p&gt;','vente-d-ordinateur-asus-core-i5-7eme-generation-6-g-ram-16',5,NULL,'130000','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan','offre','particulier',0,'2021-01-09 10:27:19',NULL,NULL,0,NULL),(17,'Belle villa 5 pièces','&lt;p&gt;Une belle maison 5 pièces, dans la ville de Yamoussokro.&lt;/p&gt;Bien située elle a été construite en 2018.','belle-villa-5-pieces-17',3,NULL,'on','tanohbassapatrick@gmail.com',NULL,NULL,'Yamoussoukro','offre','particulier',0,'2021-01-10 18:46:31',NULL,NULL,0,NULL),(18,'test','Une offre d\'emploi extraordinaire.&lt;br&gt;','test-18',6,NULL,'price_on_call','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan','offre','professionnel',0,'2021-01-10 18:54:44',NULL,NULL,0,NULL),(19,'Bloggeur à Blabla TV','&lt;p&gt;Bon job à blabla tv&lt;br&gt;&lt;/p&gt;','bloggeur-a-blabla-tv-19',6,NULL,'price_on_call','tanohbassapatrick@gmail.com',NULL,NULL,'San-Pedro','offre','particulier',0,'2021-01-10 19:33:09',NULL,NULL,0,NULL);
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
INSERT INTO `ind_categories` VALUES (4,'Bonnes affaires','bonnes-affaires','2020-12-24 06:30:57',NULL,NULL,'lni-control-panel'),(2,'Véhicules','vehicules','2020-12-24 06:17:23',NULL,NULL,'lni-car'),(3,'Immobilier','immobilier','2020-12-24 06:17:23',NULL,NULL,'lni-home'),(5,'High-Tech','high-tech','2020-12-24 06:30:57',NULL,NULL,'lni-laptop'),(6,'Emploi Formations','emploi-formations','2020-12-24 06:46:14',NULL,NULL,'lni-briefcase'),(7,'Rencontre','rencontre','2020-12-24 06:46:14',NULL,NULL,'lni-heart'),(8,'Matériel professionnel','materiel-professionnel','2020-12-24 06:46:14',NULL,NULL,'lni-notepad'),(9,'Communauté','communaute','2020-12-24 06:46:14',NULL,NULL,'lni-hand'),(10,'Bien-être','bien-etre','2020-12-24 06:46:14',NULL,NULL,'lni-leaf');
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
  `registered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_pseudo` (`pseudo`),
  UNIQUE KEY `un_email` (`email_address`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_users`
--

LOCK TABLES `ind_users` WRITE;
/*!40000 ALTER TABLE `ind_users` DISABLE KEYS */;
INSERT INTO `ind_users` VALUES (1,'IdUqwvLaEK4','tanohbassapatrick@gmail.com','TANOH','Joel','jojo1509','$2y$10$kRrZ5L6LsT1T3LI3iaU./eHQgdYAH53zcDJy64DNY1DGsaEv97JDq','+225 45996095','2021-01-01 23:03:25',NULL,1,0),(2,'YiETEdLCO28','joel.developpeur@gmail.com','Bassa','Patrick joel','basspat','$2y$10$RBWXcEFnYNlgKO2aXKgQu.0gttR046POmkkNkerNkmbS6fX4kiPXy','45996095','2021-01-01 23:13:57',NULL,0,0),(3,'3TSTjAY8','abc@abc.abc','Bassa','Patrick joel','patco255','$2y$10$9JkdUgfZfQQRuAQkjuYdFuDouffCraJG/qWxesBaTrmleXIaRDZmC','45996095','2021-01-01 23:24:05',NULL,0,0),(4,'9ZIE0t','lohuxyansteeven@outlook.com','Lohoux','Yan Steeven','Curtis13','$2y$10$tpjPd5UgyX60Z2M0asNro.6KXBKOUuIQcQPTgWplrgmU5TRT2.dIy','+22508260930','2021-01-04 20:20:20',NULL,0,0),(5,'znXhrQ','toto@gmail.com','Bassa','Joel','basjo1509','$2y$10$zt2uouSsHwpYu.Gyq4eN5uttB5tRN3cmjZnGLHp2rqFOaevwJTcBS','45996095','2021-01-07 19:04:03',NULL,0,0);
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

-- Dump completed on 2021-01-13 23:49:10
