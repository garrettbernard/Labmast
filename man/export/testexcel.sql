-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 20, 2010 at 03:19 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `testexcel`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `customer`
-- 

CREATE TABLE `customer` (
  `id` int(11) NOT NULL auto_increment,
  `company_name` varchar(100) default NULL,
  `email` varchar(100) default NULL,
  `city` varchar(100) default NULL,
  `username` varchar(50) default NULL,
  `regdate` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `customer`
-- 

INSERT INTO `customer` (`id`, `company_name`, `email`, `city`, `username`, `regdate`) VALUES 
(2, 'Smartcoderszone', 'amitkumarpaliwal@gmail.com', 'indore', 'smartcoderszone', '2010-09-17');
