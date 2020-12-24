-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 24 déc. 2020 à 09:23
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `inoveinn_wp806`
--

-- --------------------------------------------------------

--
-- Structure de la table `ind_announces`
--

DROP TABLE IF EXISTS `ind_announces`;
CREATE TABLE IF NOT EXISTS `ind_announces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_sub_category` int(11) DEFAULT NULL,
  `user_email_address` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `posted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_address` (`user_email_address`),
  KEY `fk_id_category` (`id_category`),
  KEY `fk_id_sub_category` (`id_sub_category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ind_categories`
--

DROP TABLE IF EXISTS `ind_categories`;
CREATE TABLE IF NOT EXISTS `ind_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `description` text,
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_title` (`title`),
  UNIQUE KEY `uni_slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ind_categories`
--

INSERT INTO `ind_categories` (`id`, `title`, `slug`, `created_at`, `updated_at`, `description`, `icon_class`) VALUES
(4, 'Bonnes affaires', 'bonnes-affaires', '2020-12-24 06:30:57', NULL, NULL, 'lni-control-panel'),
(2, 'Véhicules', 'vehicules', '2020-12-24 06:17:23', NULL, NULL, 'lni-car'),
(3, 'Immobiler', 'immobiler', '2020-12-24 06:17:23', NULL, NULL, 'lni-home'),
(5, 'High-Tech', 'high-tech', '2020-12-24 06:30:57', NULL, NULL, 'lni-laptop'),
(6, 'Emploi Formations', 'emploi-formations', '2020-12-24 06:46:14', NULL, NULL, 'lni-briefcase'),
(7, 'Rencontre', 'rencontre', '2020-12-24 06:46:14', NULL, NULL, 'lni-heart'),
(8, 'Matériel professionnel', 'materiel-professionnel', '2020-12-24 06:46:14', NULL, NULL, 'lni-notepad'),
(9, 'Communauté', 'communaute', '2020-12-24 06:46:14', NULL, NULL, 'lni-hand'),
(10, 'Bien-être', 'bien-etre', '2020-12-24 06:46:14', NULL, NULL, 'lni-leaf');

-- --------------------------------------------------------

--
-- Structure de la table `ind_sub_categories`
--

DROP TABLE IF EXISTS `ind_sub_categories`;
CREATE TABLE IF NOT EXISTS `ind_sub_categories` (
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

--
-- Déchargement des données de la table `ind_sub_categories`
--

INSERT INTO `ind_sub_categories` (`id`, `title`, `slug`, `id_category`, `created_at`, `modified_at`, `description`) VALUES
(1, 'Jeu de football', 'jeu-de-football', 1, '2020-11-27 23:57:24', NULL, 'C\'est un jeu de football');

-- --------------------------------------------------------

--
-- Structure de la table `ind_users`
--

DROP TABLE IF EXISTS `ind_users`;
CREATE TABLE IF NOT EXISTS `ind_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_names` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_pseudo` (`pseudo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
