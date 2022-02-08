<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 랜덤 테이블값 추가
$g5['random_dice_table'] = G5_TABLE_PREFIX.'random_dice';

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
	  `ra_progress_title` NOT NULL default '',
	  `ra_progress_max` int(11) NOT NULL default '0',
	  `ra_progress_p` int(11) NOT NULL default '0',
	  `ra_progress_m` int(11) NOT NULL default '0',
	  `ra_limit` int(11) NOT NULL default '0',
	  `ra_limit_day` int(11) NOT NULL default '0',
	  `ra_skin` varchar(255) NOT NULL default '',
	  PRIMARY KEY (`ra_id`)
	) ", false);
}

?>