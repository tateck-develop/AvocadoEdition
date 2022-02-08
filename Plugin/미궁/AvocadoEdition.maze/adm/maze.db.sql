-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- 호스트: localhost:3307
-- 처리한 시간: 17-12-15 14:29
-- 서버 버전: 5.1.73-log
-- PHP 버전: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `aphopis`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `avo_maze`
--

CREATE TABLE IF NOT EXISTS `avo_maze` (
  `ma_id` int(11) NOT NULL auto_increment,
  `ma_subject` varchar(255) NOT NULL,
  `ma_content` text NOT NULL,
  `ma_answer` varchar(255) NOT NULL default '',
  `ma_btn_prev` varchar(255) NOT NULL default '',
  `ma_btn_next` varchar(255) NOT NULL default '',
  `ma_background` varchar(255) NOT NULL default '',
  `ma_order` int(11) NOT NULL default '0',
  `ma_rank_1` int(11) NOT NULL default '0',
  `ma_rank_2` int(11) NOT NULL default '0' default '0',
  `ma_rank_3` int(11) NOT NULL default '0',
  `ma_rank_4` int(11) NOT NULL default '0',
  `ma_rank_5` int(11) NOT NULL default '0',
  PRIMARY KEY (`ma_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `avo_maze`
--
