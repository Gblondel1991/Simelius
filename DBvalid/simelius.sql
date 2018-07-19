-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 19 juil. 2018 à 12:23
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
-- Base de données :  `simelius`
--
CREATE DATABASE IF NOT EXISTS `simelius` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `simelius`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `article_id_UNIQUE` (`article_id`),
  KEY `fk_article_user_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`article_id`, `user_id`, `title`, `content`, `created_at`, `updated_at`, `status`) VALUES
(51, 8, 'Cryptage des mots de passe', 'Bonjour à toute la communauté, je sollicite votre aide dans le cadre d\'un projet sur lequel je travaille.\r\n\r\nJe dois élaborer un réseau social (je travaille sur PhP), et j\'aimerais savoir quel système de cryptage de mots de passe vous semble le approprié, afin de me prévenir tout hackage de ma base de données.\r\n\r\nMerci de vos réponses.', '2018-07-18 16:26:09', NULL, 1),
(53, 11, 'Incompatibilité avec supérieur en mission', 'Bonjour à tous, Actuellement en mission chez le client, le courant passe mal avec la personne de qui je dépends. Que me conseillez-vous, est-ce que je dois faire part de mon mal-être à ma société ? Avoir une conversation avec la personne en question ? J\'ai peur que cela ne tourne au clash... Merci. ', '2018-06-18 16:45:32', NULL, 1),
(54, 10, 'Module de reconnaissance faciale', 'Bonjour,\r\nJe planche sur la création d\'un module de reconnaissance faciale. Actuellement, j\'en suis à la phase de réflexion. Selon vous, quel langage semble le plus adapté ?\r\nMerci', '2018-07-19 09:19:06', NULL, 1),
(55, 10, 'Hello World', 'Bonjour, hello, hallo, buongiorno, buenos dias', '2018-07-10 09:21:57', NULL, 1),
(56, 8, 'Connexion défaillante', 'Help,\r\n\r\nNous sommes à la veille de notre soutenance, et subissons un sérieux problème de connexion internet. Les ultimes détails ne peuvent apportés, et risquent bien de ne jamais voir le jour.\r\nIl y a une fenêtre à côté de moi, dois-je sauter ?', '2018-07-19 10:04:10', '2018-07-19 12:39:04', 1),
(57, 11, 'Ecologie', 'Bonjour,\r\nDepuis quelques temps, je suis tiraillé par des soucis environnementaux. En effet, on ne peut pas dire que notre métier soit des plus écologistes... or, je porte un vrai intérêt pour la planète. Auriez-vous quelques astuces qui, au quotidien, seraient autant de gestes en faveur de l\'environnement ?', '2018-07-19 11:01:18', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `article_has_category`
--

DROP TABLE IF EXISTS `article_has_category`;
CREATE TABLE IF NOT EXISTS `article_has_category` (
  `article_id` int(11) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  PRIMARY KEY (`article_id`,`category_id`),
  KEY `fk_article_has_category_category1_idx` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article_has_category`
--

INSERT INTO `article_has_category` (`article_id`, `category_id`) VALUES
(55, 1),
(53, 2),
(55, 2),
(53, 3),
(55, 3),
(56, 3),
(51, 4),
(54, 4),
(55, 4),
(56, 4),
(55, 5),
(56, 5),
(57, 5);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_id_UNIQUE` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Juridique'),
(2, 'Management'),
(3, 'Social'),
(4, 'Technique'),
(5, 'Environnement');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_activated` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`comment_id`),
  UNIQUE KEY `idcomment_UNIQUE` (`comment_id`),
  KEY `fk_comment_user1_idx` (`user_id`),
  KEY `fk_comment_article1_idx` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `article_id`, `content`, `created_at`, `updated_at`, `is_activated`) VALUES
(204, 10, 51, ' \r\nBonjour Guillaume, Sous PhP, tu peux utiliser la fonction Password Hash, qui en paramètres prend un système de cryptage. BCRYPT est le plus utilisé, et semble tout à fait adapté à ton cas de figure. ', '2018-07-18 16:35:03', '2018-07-18 16:35:39', 1),
(205, 11, 51, 'Juninho est dans le vrai.\r\nQuoi qu\'il arrive, l\'auto-implémentation te proposera d\'autres systèmes de cryptage, il te suffira de choisir.\r\n', '2018-07-18 16:39:34', NULL, 1),
(206, 8, 53, 'Bonjour Alexandre,\r\nPeux-tu préciser ? Quelle est la relation hiérarchique qui vous lie ?\r\nQuoi qu\'il arrive, je te conseille de mettre de l\'eau dans ton vin, et d\'avoir une discussion apaisée avec ladite personne.\r\nIl ne faudrait pas mettre ta situation personnelle en péril !\r\n', '2018-07-18 16:49:22', NULL, 1),
(207, 8, 54, 'Python est ton ami\r\n', '2018-07-19 10:05:18', NULL, 1),
(208, 8, 55, 'Ciao ciao\r\n', '2018-07-19 10:28:22', NULL, 1),
(209, 8, 57, 'Economiseur de batterie...\r\n', '2018-07-19 12:37:25', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `CV_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_profession_id` smallint(6) NOT NULL,
  `lastname` varchar(120) NOT NULL,
  `firstname` varchar(120) NOT NULL,
  `birthday` date NOT NULL,
  `profession` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `picture` longblob,
  `diploma1` varchar(90) DEFAULT NULL,
  `diploma2` varchar(90) DEFAULT NULL,
  `diploma3` varchar(90) DEFAULT NULL,
  `experience1` varchar(255) DEFAULT NULL,
  `experience2` varchar(255) DEFAULT NULL,
  `experience3` varchar(255) DEFAULT NULL,
  `hobby1` varchar(90) DEFAULT NULL,
  `hobby2` varchar(90) DEFAULT NULL,
  `hobby3` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`CV_id`),
  UNIQUE KEY `CV_id_UNIQUE` (`CV_id`),
  KEY `fk_CV_user1_idx` (`user_id`,`user_profession_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `participant` varchar(90) DEFAULT NULL,
  `drawing` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_id_UNIQUE` (`event_id`),
  KEY `fk_event_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `event_has_category`
--

DROP TABLE IF EXISTS `event_has_category`;
CREATE TABLE IF NOT EXISTS `event_has_category` (
  `event_id` int(11) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  PRIMARY KEY (`event_id`,`category_id`),
  KEY `fk_event_has_category_category1_idx` (`category_id`),
  KEY `fk_event_has_category_event1_idx` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `profession`
--

DROP TABLE IF EXISTS `profession`;
CREATE TABLE IF NOT EXISTS `profession` (
  `profession_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  PRIMARY KEY (`profession_id`),
  UNIQUE KEY `profession_id_UNIQUE` (`profession_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profession`
--

INSERT INTO `profession` (`profession_id`, `name`) VALUES
(1, 'Développeur'),
(2, 'Ecrivain'),
(8, 'Architecte'),
(9, 'Artisan'),
(10, 'Boulanger'),
(11, 'Artiste-peintre'),
(12, 'Cuisinier'),
(13, 'Agriculteur'),
(14, 'Astronaute'),
(15, 'Boucher'),
(16, 'Charcutier'),
(17, 'Chocolatier'),
(18, 'Commis'),
(19, 'Apiculteur'),
(20, 'Aquaculteur'),
(21, 'Berger'),
(22, 'Chasseur'),
(23, 'Eleveur'),
(24, 'Archetier'),
(25, 'Armurier'),
(26, 'Bijoutier'),
(27, 'Céramiste'),
(28, 'Coiffeur'),
(29, 'Ciseleur'),
(30, 'Ebeniste'),
(31, 'Accessoiriste'),
(32, 'Acteur'),
(33, 'Acrobate'),
(34, 'Artificier'),
(35, 'Chanteur'),
(36, 'Carreleur'),
(37, 'Charpentier'),
(38, 'Acheteur'),
(39, 'Buraliste'),
(40, 'Caissier'),
(41, 'Avocat'),
(42, 'Chercheur'),
(43, 'Chef de laboratoire'),
(44, 'Approvisionneur'),
(45, 'Balayeur'),
(46, 'Actuaire'),
(47, 'Automaticien');

-- --------------------------------------------------------

--
-- Structure de la table `revelant_answer`
--

DROP TABLE IF EXISTS `revelant_answer`;
CREATE TABLE IF NOT EXISTS `revelant_answer` (
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  KEY `fk_revelant_answer_user1_idx` (`user_id`),
  KEY `fk_revelant_answer_comment1_idx` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revelant_answer`
--

INSERT INTO `revelant_answer` (`user_id`, `comment_id`) VALUES
(10, 204),
(11, 204),
(11, 205),
(11, 204),
(11, 204),
(8, 205),
(8, 205),
(8, 204),
(8, 205),
(8, 206),
(8, 205),
(8, 204),
(8, 207),
(8, 208),
(8, 209);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `profession_id` smallint(6) NOT NULL,
  `lastname` varchar(120) NOT NULL,
  `firstname` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `society` varchar(120) NOT NULL,
  `experience` date NOT NULL,
  `created_at` datetime NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`profession_id`),
  UNIQUE KEY `iduser_UNIQUE` (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_user_profession1_idx` (`profession_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `profession_id`, `lastname`, `firstname`, `email`, `password`, `society`, `experience`, `created_at`, `profile_picture`) VALUES
(6, 1, 'Jean', '0', '0000@gmail.com', '00000000', '00000000', '2018-07-11', '2018-07-04 00:00:00', 'zghr'),
(7, 1, 'a', 'a', 'aaaaa@gmail.com', '0000', '0000', '2018-07-04', '2018-07-11 00:00:00', '0000'),
(8, 1, 'Blondel', 'Guillaume', 'gblondel@gmail.com', '$2y$10$w8sC4EqmOLdDxRrAMyBTPu7pln1XYFWbpPU1QClo78uKFiQT8iPOe', 'Modis', '2018-07-09', '2018-07-18 14:20:48', 'views/default/images/avatars/a6a0ddc413f6aff6.jpg'),
(9, 1, 'Pernambucano', 'Juninho', 'juni@gmail.com', '$2y$10$aUyJtEf4C4QA.2SWxmJgU.Sv3cGUw2FUH98uKnh6e7zMxirGlCgEG', 'Cegid', '2003-06-10', '2018-07-18 14:31:43', 'views/default/images/avatars/e1846408f0a4d3a7.jpeg'),
(10, 1, 'Pernambucano', 'Juninho', 'juninho@gmail.com', '$2y$10$mfXhTFMAk5jovt2Heu2oQelnHts/HI0R.7Dkbj.904AzPA.InBgL2', 'Cegid', '2001-02-15', '2018-07-18 14:33:17', 'views/default/images/avatars/41ec2778badbd7b1.jpeg'),
(11, 1, 'Aulas', 'Alexandre', 'aaulas@gmail.com', '$2y$10$eWHZR.tI1vM0EXdCbtxbi.UAs8mSFsabGM7QsV0W3NLGi0QAqpVmS', 'Abricorp', '2014-05-12', '2018-07-18 14:38:25', 'views/default/images/avatars/fdabe59a3829de28.jpg'),
(14, 1, 'gorj', 'rzaguj', 'gzorj', 'goreijh', 'ohrzi', '2018-07-04', '2018-07-11 00:00:00', 'gzr'),
(15, 1, 'eg', 'etge', 'tghte@ggk.com', '00', '00', '2018-07-11', '2018-07-11 00:00:00', 'grzg'),
(23, 1, 'grze', 'teghet', 'ethget', 'gerz', 'ger', '2018-07-10', '2018-07-11 00:00:00', 'rgzrz'),
(25, 1, 'rzg', 'gerzf', 'ztfgzr', 'rtgrze', 'gre', '2018-07-10', '2018-07-11 00:00:00', 'ezf'),
(69, 1, 'erzgre', 'tget', 'gzrgr', 'rgz', 'rzg', '2018-07-10', '2018-07-11 00:00:00', 'rgrz');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article` ADD FULLTEXT KEY `title_fulltext` (`title`);
ALTER TABLE `article` ADD FULLTEXT KEY `content_fulltext` (`content`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `article_has_category`
--
ALTER TABLE `article_has_category`
  ADD CONSTRAINT `fk_article_has_category_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_article_has_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `fk_CV_user1` FOREIGN KEY (`user_id`,`user_profession_id`) REFERENCES `user` (`user_id`, `profession_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event_has_category`
--
ALTER TABLE `event_has_category`
  ADD CONSTRAINT `fk_event_has_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_has_category_event1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `revelant_answer`
--
ALTER TABLE `revelant_answer`
  ADD CONSTRAINT `fk_revelant_answer_comment1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_revelant_answer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_profession1` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`profession_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
