<?php
if (!defined('_GNUBOARD_')) exit;

if (!isset($config['cf_add_script'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_script` TEXT NOT NULL AFTER `cf_admin_email_name` ", true);
}

if (!isset($config['cf_mobile_new_skin'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `cf_memo_send_point`,
					ADD `cf_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_new_skin`,
					ADD `cf_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_search_skin`,
					ADD `cf_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_connect_skin` ", true);
}

if (isset($config['cf_gcaptcha_mp3'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					CHANGE `cf_gcaptcha_mp3` `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if (!isset($config['cf_captcha_mp3'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_mobile_member_skin` ", true);
}

if(!isset($config['cf_editor'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_googl_shorturl_apikey'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_mobile_pages'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `cf_write_pages` ", true);
	sql_query(" UPDATE `{$g5['config_table']}` SET cf_mobile_pages = '5' ", true);
}

if(!isset($config['cf_facebook_appid'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_facebook_appid` VARCHAR(255) NOT NULL AFTER `cf_googl_shorturl_apikey`,
					ADD `cf_facebook_secret` VARCHAR(255) NOT NULL AFTER `cf_facebook_appid`,
					ADD `cf_twitter_key` VARCHAR(255) NOT NULL AFTER `cf_facebook_secret`,
					ADD `cf_twitter_secret` VARCHAR(255) NOT NULL AFTER `cf_twitter_key` ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['uniqid_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['uniqid_table']}` (
				  `uq_id` bigint(20) unsigned NOT NULL,
				  `uq_ip` varchar(255) NOT NULL,
				  PRIMARY KEY (`uq_id`)
				) ", false);
}

if(!sql_query(" SELECT uq_ip from {$g5['uniqid_table']} limit 1 ", false)) {
	sql_query(" ALTER TABLE {$g5['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['autosave_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['autosave_table']}` (
				  `as_id` int(11) NOT NULL AUTO_INCREMENT,
				  `mb_id` varchar(20) NOT NULL,
				  `as_uid` bigint(20) unsigned NOT NULL,
				  `as_subject` varchar(255) NOT NULL,
				  `as_content` text NOT NULL,
				  `as_datetime` datetime NOT NULL,
				  PRIMARY KEY (`as_id`),
				  UNIQUE KEY `as_uid` (`as_uid`),
				  KEY `mb_id` (`mb_id`)
				) ", false);
}

if(!isset($config['cf_admin_email'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_admin_email` VARCHAR(255) NOT NULL AFTER `cf_admin` ", true);
}

if(!isset($config['cf_admin_email_name'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_admin_email_name` VARCHAR(255) NOT NULL AFTER `cf_admin_email` ", true);
}

if(!isset($config['cf_cert_use'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `cf_editor`,
					ADD `cf_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_use`,
					ADD `cf_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_ipin`,
					ADD `cf_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_hp`,
					ADD `cf_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcb_cd`,
					ADD `cf_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `cf_cert_kcp_cd` ", true);
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
	sql_query(" update {$g5['member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
	sql_query(" update {$g5['member_table']} set mb_certify = '' where mb_certify = '0' ");
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['cert_history_table']}` (
				  `cr_id` int(11) NOT NULL auto_increment,
				  `mb_id` varchar(255) NOT NULL DEFAULT '',
				  `cr_company` varchar(255) NOT NULL DEFAULT '',
				  `cr_method` varchar(255) NOT NULL DEFAULT '',
				  `cr_ip` varchar(255) NOT NULL DEFAULT '',
				  `cr_date` date NOT NULL DEFAULT '0000-00-00',
				  `cr_time` time NOT NULL DEFAULT '00:00:00',
				  PRIMARY KEY (`cr_id`),
				  KEY `mb_id` (`mb_id`)
				)", true);
}

if(!isset($config['cf_analytics'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_analytics` TEXT NOT NULL AFTER `cf_intercept_ip` ", true);
}

if(!isset($config['cf_add_meta'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_meta` TEXT NOT NULL AFTER `cf_analytics` ", true);
}

if (!isset($config['cf_syndi_token'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_syndi_token` VARCHAR(255) NOT NULL AFTER `cf_add_meta` ", true);
}

if (!isset($config['cf_syndi_except'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_syndi_except` TEXT NOT NULL AFTER `cf_syndi_token` ", true);
}

if(!isset($config['cf_sms_use'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_limit`,
					ADD `cf_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use`,
					ADD `cf_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_id`,
					ADD `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_pw`,
					ADD `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_ip` ", true);
}

if(!isset($config['cf_mobile_page_rows'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `cf_page_rows` ", true);
}

if(!isset($config['cf_cert_req'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_cert_limit` ", true);
}

if(!isset($config['cf_faq_skin'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_connect_skin`,
					ADD `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_mobile_connect_skin` ", true);
}

// LG유플러스 본인확인 필드 추가
if(!isset($config['cf_lg_mid'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcp_cd`,
					ADD `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_lg_mid` ", true);
}

if(!isset($config['cf_optimize_date'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_optimize_date` date NOT NULL default '0000-00-00' AFTER `cf_popular_del` ", true);
}

// 카카오톡링크 api 키
if(!isset($config['cf_kakao_js_apikey'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `cf_googl_shorturl_apikey` ", true);
}

// 캐릭터 프로필 항목 분류 추가
if(!isset($config['cf_profile_group'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_profile_group` text NOT NULL AFTER `cf_10` ", true);
}
if(!isset($config['cf_profile_group_use'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_profile_group_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_profile_group` ", true);
}

// SMS 전송유형 필드 추가
if(!isset($config['cf_sms_type'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 접속자 정보 필드 추가
if(!sql_query(" select vi_browser from {$g5['visit_table']} limit 1 ")) {
	sql_query(" ALTER TABLE `{$g5['visit_table']}`
					ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
					ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
					ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

?>