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
  `subject_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `subject_type` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Côte d\'Ivoire','cote-d-ivoire');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
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
  `status` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `posted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_category` (`id_category`),
  KEY `fk_id_sub_category` (`id_sub_category`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_announces`
--

LOCK TABLES `ind_announces` WRITE;
/*!40000 ALTER TABLE `ind_announces` DISABLE KEYS */;
INSERT INTO `ind_announces` VALUES (20,'mon super ordinateur','&lt;p&gt;Mon super ordinateur&lt;/p&gt;','mon-super-ordinateur-20',5,NULL,'250000','tanohbassapatrick@gmail.com',NULL,NULL,'Bouake','offre','particulier',2,'2021-01-15 20:22:40',NULL,NULL,0,NULL),(16,'Vente d\'ordinateur ASUS Core i5 7ème génération 6 G Ram','&lt;p&gt;Un bel ordinateur Asus Core i5 avec 6 G de ram.&lt;br&gt;&lt;/p&gt;','vente-d-ordinateur-asus-core-i5-7eme-generation-6-g-ram-16',5,NULL,'130000','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan','offre','particulier',2,'2021-01-09 10:27:19',NULL,NULL,0,NULL),(18,'test','Une offre d\'emploi extraordinaire.&lt;br&gt;','test-18',6,NULL,'price_on_call','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan','offre','professionnel',2,'2021-01-10 18:54:44',NULL,NULL,0,NULL),(19,'Rédacteur à Jesus Bénit TV','&lt;p&gt;Bon job à JésusBénit tv&lt;br&gt;&lt;/p&gt;','redacteur-a-jesus-benit-tv-19',6,NULL,'price_on_call','tanohbassapatrick@gmail.com','tanohbassapatrick@gmail.com','+225 45996095','Yamoussoukro','offre','professionnel',1,'2021-01-10 19:33:09',NULL,NULL,0,NULL),(24,'test','&lt;p&gt;Petite description.&lt;br&gt;&lt;/p&gt;','test-24',7,NULL,'price_on_call','joel.developpeur@gmail.com',NULL,NULL,'Daloa','offre','professionnel',1,'2021-02-01 20:43:43',NULL,NULL,0,NULL),(22,'Une belle femme','&lt;p&gt;Une belle femme !&lt;br&gt;&lt;/p&gt;','une-belle-femme-22',7,NULL,'price_on_call','tanohbassapatrick@gmail.com',NULL,NULL,'Gagnoa','offre','particulier',1,'2021-01-16 13:29:26',NULL,NULL,0,NULL);
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
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `suscribed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (2,'tanohbassapatrick@gmail.com','2021-01-31 22:37:09'),(3,'joel.developpeur@gmail.com','2021-01-31 23:13:21');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `towns`
--

DROP TABLE IF EXISTS `towns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_country` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `towns`
--

LOCK TABLES `towns` WRITE;
/*!40000 ALTER TABLE `towns` DISABLE KEYS */;
INSERT INTO `towns` VALUES (1,'Abidjan',1,'abidjan'),(2,'Bouaké',1,'bouake'),(3,'Daloa',1,'daloa'),(4,'Yamoussokro',1,'yamoussokro'),(5,'San-Pédro',1,'san-pedro'),(6,'Divo',1,'divo'),(7,'Korhogo',1,'korhogo'),(8,'Abengourou',1,'agengourou'),(9,'Man',1,'man'),(10,'Gagnoa',1,'gagnoa'),(11,'Soubré',1,'soubre'),(12,'Agboville',1,'agboville'),(13,'Dabou',1,'dabou'),(14,'Grand-Bassam',1,'grand-bassam'),(15,'Bouaflé',1,'bouaflé'),(16,'Issia',1,'issia'),(17,'Sinfra',1,'sinfra'),(18,'Katiola',1,'katiola'),(19,'Bingerville',1,'bingerville'),(20,'Adzopé',1,'adzope'),(21,'Séguéla',1,'seguela'),(22,'Bondoukou',1,'bondoukou'),(23,'Oumé',1,'oume'),(24,'Ferkessedougou',1,'ferkessedougou'),(25,'Dimbokro',1,'dimbokro'),(26,'Odienné',1,'odienne'),(27,'Danané',1,'danane'),(28,'Tingréla',1,'tingrela'),(29,'Guiglo',1,'guiglo'),(30,'Boundiali',1,'boundiali'),(31,'Agnibilékro',1,'agnibilékro'),(32,'Daoukro',1,'daoukro'),(33,'Vavoua',1,'vavoua'),(34,'Zuénoula',1,'zuenoula'),(35,'Tiassalé',1,'tiassale'),(36,'Toumodi',1,'toumodi'),(37,'Akoupé',1,'akoupe'),(38,'Lakota',1,'lakota');
/*!40000 ALTER TABLE `towns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'IdUqwvLaEK4','tanohbassapatrick@gmail.com','TANOH','Joel','jojo1509','$2y$10$kRrZ5L6LsT1T3LI3iaU./eHQgdYAH53zcDJy64DNY1DGsaEv97JDq','+225 45996095','2021-01-01 23:03:25',NULL,1,0),(8,'fbPP60','joel.developpeur@gmail.com','Bassa','Patrick','dieudesannounces','$2y$10$rEabaRX.C1iVB2DKMU9e3OIFoBYS/l7oFPbWK61ZK6HQteHuTiZE6','0749324696','2021-02-01 19:07:15',NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_value` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_action_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitors`
--

LOCK TABLES `visitors` WRITE;
/*!40000 ALTER TABLE `visitors` DISABLE KEYS */;
INSERT INTO `visitors` VALUES (11,'tanohbassapatrick@gmail.com','2021-01-30 22:15:57','2021-01-30 22:16:48'),(12,'4ETIYcbq','2021-01-30 22:17:38','2021-01-30 22:44:26'),(13,'tLfReJDDqw','2021-01-31 10:34:23','2021-02-01 01:02:34'),(14,'joel.developpeur@gmail.com','2021-02-01 07:13:57','2021-02-01 07:17:50'),(15,'tanohbassapatrick@gmail.com','2021-02-01 18:59:04','2021-02-01 19:02:15');
/*!40000 ALTER TABLE `visitors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-01 22:06:48
