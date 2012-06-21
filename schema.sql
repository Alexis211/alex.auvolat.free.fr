-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 21 Juin 2012 à 14:33
-- Version du serveur: 5.5.25-log
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `alex_auvolat`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `priv` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) NOT NULL,
  `reg_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `model` text NOT NULL,
  `contents` text NOT NULL,
  `json_data` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`list`,`name`),
  KEY `list` (`list`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `batch_review`
--

CREATE TABLE IF NOT EXISTS `batch_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  `results` text NOT NULL,
  `score` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `batch` (`batch`),
  KEY `user_idx` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `batch_study`
--

CREATE TABLE IF NOT EXISTS `batch_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  `last_review` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `batch` (`batch`),
  KEY `user_idx` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `text` text NOT NULL,
  `text_html` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post` (`post`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `text` text NOT NULL,
  `text_html` text NOT NULL,
  `date` datetime NOT NULL,
  `draft` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poster` (`owner`),
  KEY `draft` (`draft`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blog_tags`
--

CREATE TABLE IF NOT EXISTS `blog_tags` (
  `post` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  KEY `post` (`post`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deck` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text_md` text NOT NULL,
  `text_html` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`deck`,`name`),
  UNIQUE KEY `unique_number` (`deck`,`number`),
  KEY `deck_idx` (`deck`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `card_study`
--

CREATE TABLE IF NOT EXISTS `card_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deck_study` int(11) NOT NULL,
  `card` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `next_review` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deck_study` (`deck_study`,`card`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `decks`
--

CREATE TABLE IF NOT EXISTS `decks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment_md` text NOT NULL,
  `comment_html` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`owner`,`name`),
  KEY `owner_idx` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `deck_study`
--

CREATE TABLE IF NOT EXISTS `deck_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `deck` int(11) NOT NULL,
  `last_card` int(11) NOT NULL DEFAULT '0',
  `learn_rate` int(11) NOT NULL DEFAULT '10',
  `need_check` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_deck` (`user`,`deck`),
  KEY `user_idx` (`user`),
  KEY `deck_idx` (`deck`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `upl_date` date NOT NULL,
  `folder` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_html` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`),
  KEY `folder` (`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_html` text NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment_md` text NOT NULL,
  `comment_html` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`owner`,`name`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `list_study`
--

CREATE TABLE IF NOT EXISTS `list_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `list` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_list` (`user`,`list`),
  KEY `user` (`user`),
  KEY `list_idx` (`list`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `text_html` text NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`,`parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
