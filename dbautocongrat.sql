-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 173.201.217.102
-- Generation Time: Nov 21, 2010 at 04:42 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbautocongrat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblBirthday`
--

CREATE TABLE `tblBirthday` (
  `bId` int(11) NOT NULL auto_increment,
  `bTitle` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'Mesajda gorunmur bu sadece user tebrikleri ferqlendirsin deye',
  `bReceiverNumber` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT 'tebriki qebul edenin nomresi, kodla birge',
  `bMessage` text collate utf8_unicode_ci NOT NULL,
  `uId` int(11) NOT NULL,
  `bDate` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT 'tebrik bu tarixde  gonderilcek',
  `bWasSent` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT '0-mesaj getmeyib, 1-mesaj gedib',
  `bNotified` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT '0-istifadeciye xeberdarliq gonderilmiyib 1-gonderilib',
  PRIMARY KEY  (`bId`),
  KEY `uId` (`uId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tblBirthday`
--

INSERT INTO `tblBirthday` VALUES(18, 'Atamin dogum gunu', '505834629', 'Ad gunun mubarek, ata!', 0, '2010-11-26', '0', '0');
INSERT INTO `tblBirthday` VALUES(19, 'Cavidin ad gunu', '556539533', 'Green glass, Greeen glass, Greeeen glass to youuuuuu!', 1, '2011-6-25', '0', '0');
INSERT INTO `tblBirthday` VALUES(23, 'test1', '518230551', 'wegwegwe', 1, '2010-11-21', '0', '0');
INSERT INTO `tblBirthday` VALUES(24, 'test2', '518230551', 'wegwegwe', 1, '2010-11-21', '0', '0');
INSERT INTO `tblBirthday` VALUES(25, 'test3', '518230551', 'wegwegwe', 1, '2010-11-21', '0', '0');
INSERT INTO `tblBirthday` VALUES(26, 'test', '506678560', 'test test', 1, '2010-11-22', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblUser`
--

CREATE TABLE `tblUser` (
  `uId` int(11) NOT NULL auto_increment,
  `uSign` varchar(255) collate utf8_unicode_ci default NULL COMMENT 'gonderenin imzasi-ad soyad ve.s olar biler',
  `uUsername` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'bu userin azercell ve ya bakcell de olan loginidir',
  `uOrgPassword` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'bu userin azercell ve ya bakcell de olan paroludur',
  `uPassword` varchar(255) collate utf8_unicode_ci NOT NULL,
  `uOperator` enum('Bakcell','Azercell') collate utf8_unicode_ci NOT NULL,
  `uPhoneNumber` varchar(9) collate utf8_unicode_ci NOT NULL COMMENT '9 reqemli telefon nomresi',
  PRIMARY KEY  (`uId`),
  UNIQUE KEY `uUsername` (`uUsername`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tblUser`
--

INSERT INTO `tblUser` VALUES(1, 'hers19', 'hers19@hotmail.com', 'hers1989', '058d294621e28309c69d3e6221168ffdff21a967', 'Bakcell', '558230551');
INSERT INTO `tblUser` VALUES(4, '', '7694946', '123456', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Azercell', '507694946');
INSERT INTO `tblUser` VALUES(5, 'Shahriyar', '5119611', 'SnaKe2375', '361237ed2e7afa0b2cef0033b66adc6ab89d9ce5', 'Azercell', '505119611');
