<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 미궁 테이블값 추가
$g5['maze_table'] = G5_TABLE_PREFIX.'maze';


// 미궁 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['maze_table']} ")) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['maze_table']}` (
	  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
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
	) ", false);
}

// 미궁진행값이 존재하지 않을 경우
if($is_member && !isset($member['mb_maze'])) { 
	sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_maze` INT(11) NOT NULL DEFAULT '0' AFTER `mb_10` ");
}
if($is_member && !isset($member['mb_maze_datetime'])) { 
	sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_maze_datetime` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `mb_maze` ");
}

?>
