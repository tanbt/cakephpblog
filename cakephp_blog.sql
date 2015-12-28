-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 31, 2015 at 09:58 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cakephp_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `body`, `created`, `modified`, `user_id`) VALUES
(1, 'UPDATE BY REST REST', 'asdf', '2015-02-26 15:41:16', '2015-08-31 02:58:00', 1),
(2, 'A title once again', 'And the article body follows.', '2015-02-26 15:41:16', NULL, 2),
(3, 'third Article', 'third Article body', '2015-02-26 15:41:16', '2015-02-26 10:27:09', 2),
(6, 'new article in web', 'new article in web body', '2015-02-26 10:23:25', '2015-02-26 10:23:25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
  KEY `I18N_FIELD` (`model`,`foreign_key`,`field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `i18n`
--

INSERT INTO `i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'vi', 'Articles', 1, 'title', 'TIêU đề TIếNG VIệT'),
(2, 'vi', 'Articles', 1, 'body', 'Nội dung của bài báo số một bằng tiếng Việt.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`) VALUES
(1, 'admin', '$2y$10$y/mxU3oYfUKoKCvTOv0Q4.hsdjRl1uo30cldrlcKmXs7fjnzrvwga', 'admin', NULL, NULL),
(2, 'tan', '$2y$10$C0vOBBqz6vT.lu0pBl516O7glVs6inivCNz4WyZFELeqjExf/l/zK', 'author', NULL, NULL),
(3, 'tanbt', '$2y$10$mPHDJNjM3KEDPDYahN0iLeAZl/c35xdV2EVEvhfaUkaZ0rVCRs7kK', 'author', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
