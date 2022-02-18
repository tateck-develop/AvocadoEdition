<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 랜덤 테이블값 추가
$g5['random_dice_table'] = G5_TABLE_PREFIX.'random_dice';
$g5['random_dice_log_table'] = G5_TABLE_PREFIX.'random_dice_log';

// 랜덤 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['random_dice_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['random_dice_table']}` (
	  `ra_id` int(11) NOT NULL AUTO_INCREMENT,
	  `bo_table` varchar(255)  NOT NULL default '',
	  `ra_title` varchar(255)  NOT NULL default '',
	  `ra_text` text NOT NULL,
	  `ra_img` text NOT NULL,
	  `ra_use` int(11) NOT NULL default '0',
	  `ra_progress` int(11) NOT NULL default '0',
	  `ra_progress_title` varchar(255) NOT NULL default '',
	  `ra_progress_max` int(11) NOT NULL default '0',
	  `ra_progress_p` int(11) NOT NULL default '0',
	  `ra_progress_m` int(11) NOT NULL default '0',
	  `ra_limit` int(11) NOT NULL default '0',
	  `ra_limit_day` int(11) NOT NULL default '0',
	  `ra_skin` varchar(255) NOT NULL default '',
	  PRIMARY KEY (`ra_id`)
	) ", false);
}

// 랜덤 로그 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['random_dice_log_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['random_dice_log_table']}` (
	  `rl_id` int(11) NOT NULL AUTO_INCREMENT,
	  `ra_id` int(11) NOT NULL DEFAULT '0',
	  `bo_table` varchar(11) NOT NULL DEFAULT '',
	  `wr_id` int(11) NOT NULL DEFAULT '0',
	  `mb_id` varchar(11) NOT NULL DEFAULT '',
	  `ch_id` int(11) NOT NULL DEFAULT '0',
	  `rl_text` TEXT NOT NULL,
	  `rl_img` varchar(11) NOT NULL DEFAULT '',
	  `rl_date` varchar(11) NOT NULL DEFAULT '',
	  PRIMARY KEY (`rl_id`)
	) ", false);
}

/**********************
	색상 설정 값
**********************/

$i_color = "#C8FE2E"; // 랜덤 다이스 메세지의 <i>태그 컬러
$em_color = "#FFD700"; // 랜덤 다이스 메세지의 <em>태그 컬러
$strong_color = "#00FFFF"; // 랜덤 다이스 메세지의 <strong>태그 컬러
?>