-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2013 at 08:38 AM
-- Server version: 5.5.30-MariaDB
-- PHP Version: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kluftboerse`
--

-- --------------------------------------------------------

--
-- Table structure for table `kluftBoerse_offers`
--

CREATE TABLE IF NOT EXISTS `kluftBoerse_offers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=invisible (e.g. sold); 1=selling; 2=searching;',
  `owner` int(11) NOT NULL COMMENT 'user Id of owner',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `kluftBoerse_offers`
--

INSERT INTO `kluftBoerse_offers` (`id`, `description`, `type`, `owner`) VALUES
(1, 'Test Verkauf', 1, 1),
(2, 'Test Verkauf 2', 1, 1),
(3, 'Test Gesuch ', 2, 1),
(4, 'Test Gesuch 2', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kluftBoerse_user`
--

CREATE TABLE IF NOT EXISTS `kluftBoerse_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UserId',
  `username` text NOT NULL,
  `password` text NOT NULL,
  `salt` text NOT NULL,
  `email` text NOT NULL,
  `givenname` text NOT NULL,
  `familyname` text NOT NULL,
  `session_key` text NOT NULL,
  `session_fingerprint` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
