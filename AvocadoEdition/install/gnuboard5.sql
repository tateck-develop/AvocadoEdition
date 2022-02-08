-- --------------------------------------------------------

--
-- Table structure for table `avo_auth`
--

DROP TABLE IF EXISTS `avo_auth`;
CREATE TABLE IF NOT EXISTS `avo_auth` (
  `mb_id` varchar(20) NOT NULL default '',
  `au_menu` varchar(20) NOT NULL default '',
  `au_auth` set('r','w','d') NOT NULL default '',
  PRIMARY KEY  (`mb_id`,`au_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Table structure for table `avo_backup`
--

DROP TABLE IF EXISTS `avo_backup`;
CREATE TABLE IF NOT EXISTS `avo_backup` (
  `ba_id` int(11) NOT NULL auto_increment,
  `ba_cate` varchar(255) NOT NULL DEFAULT '',
  `ba_title` varchar(255) NOT NULL DEFAULT '',
  `ba_path` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ba_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
--
-- Table structure for table `avo_board`
--

DROP TABLE IF EXISTS `avo_board`;
CREATE TABLE IF NOT EXISTS `avo_board` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `bo_type` varchar(20) NOT NULL DEFAULT '',
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `bo_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `bo_admin` varchar(255) NOT NULL DEFAULT '',
  `bo_list_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_read_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_write_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_reply_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_comment_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_upload_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_download_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_html_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_link_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_count_delete` tinyint(4) NOT NULL DEFAULT '0',
  `bo_count_modify` tinyint(4) NOT NULL DEFAULT '0',
  `bo_read_point` int(11) NOT NULL DEFAULT '0',
  `bo_write_point` int(11) NOT NULL DEFAULT '0',
  `bo_comment_point` int(11) NOT NULL DEFAULT '0',
  `bo_download_point` int(11) NOT NULL DEFAULT '0',
  `bo_use_category` tinyint(4) NOT NULL DEFAULT '0',
  `bo_category_list` text NOT NULL,
  `bo_use_sideview` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_file_content` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_secret` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_dhtml_editor` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_rss_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_good` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_nogood` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_name` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_signature` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_ip_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_file` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_content` tinyint(4) NOT NULL DEFAULT '0',
  `bo_table_width` int(11) NOT NULL DEFAULT '0',
  `bo_subject_len` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_subject_len` int(11) NOT NULL DEFAULT '0',
  `bo_page_rows` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `bo_new` int(11) NOT NULL DEFAULT '0',
  `bo_hot` int(11) NOT NULL DEFAULT '0',
  `bo_image_width` int(11) NOT NULL DEFAULT '0',
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_include_head` varchar(255) NOT NULL DEFAULT '',
  `bo_include_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_content_head` text NOT NULL,
  `bo_mobile_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int(11) NOT NULL DEFAULT '0',
  `bo_gallery_width` int(11) NOT NULL DEFAULT '0',
  `bo_gallery_height` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_gallery_width` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_gallery_height` int(11) NOT NULL DEFAULT '0',
  `bo_upload_size` int(11) NOT NULL DEFAULT '0',
  `bo_reply_order` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_search` tinyint(4) NOT NULL DEFAULT '0',
  `bo_order` int(11) NOT NULL DEFAULT '0',
  `bo_count_write` int(11) NOT NULL DEFAULT '0',
  `bo_count_comment` int(11) NOT NULL DEFAULT '0',
  `bo_write_min` int(11) NOT NULL DEFAULT '0',
  `bo_write_max` int(11) NOT NULL DEFAULT '0',
  `bo_comment_min` int(11) NOT NULL DEFAULT '0',
  `bo_comment_max` int(11) NOT NULL DEFAULT '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_email` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '',
  `bo_use_sns` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_chick` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_noname` tinyint(4) NOT NULL DEFAULT '0',
  `bo_sort_field` varchar(255) NOT NULL DEFAULT '',
  `bo_1_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_2_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_3_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_4_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_5_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_6_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_7_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_8_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_9_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_10_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_1` varchar(255) NOT NULL DEFAULT '',
  `bo_2` varchar(255) NOT NULL DEFAULT '',
  `bo_3` varchar(255) NOT NULL DEFAULT '',
  `bo_4` varchar(255) NOT NULL DEFAULT '',
  `bo_5` varchar(255) NOT NULL DEFAULT '',
  `bo_6` varchar(255) NOT NULL DEFAULT '',
  `bo_7` varchar(255) NOT NULL DEFAULT '',
  `bo_8` varchar(255) NOT NULL DEFAULT '',
  `bo_9` varchar(255) NOT NULL DEFAULT '',
  `bo_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bo_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_board_file`
--

DROP TABLE IF EXISTS `avo_board_file`;
CREATE TABLE IF NOT EXISTS `avo_board_file` (
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `bf_no` int(11) NOT NULL default '0',
  `bf_source` varchar(255) NOT NULL default '',
  `bf_file` varchar(255) NOT NULL default '',
  `bf_download` int(11) NOT NULL DEFAULT '0',
  `bf_content` text NOT NULL,
  `bf_filesize` int(11) NOT NULL default '0',
  `bf_width` int(11) NOT NULL default '0',
  `bf_height` smallint(6) NOT NULL default '0',
  `bf_type` tinyint(4) NOT NULL default '0',
  `bf_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_board_good`
--

DROP TABLE IF EXISTS `avo_board_good`;
CREATE TABLE IF NOT EXISTS `avo_board_good` (
  `bg_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bg_flag` varchar(255) NOT NULL default '',
  `bg_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_board_new`
--

DROP TABLE IF EXISTS `avo_board_new`;
CREATE TABLE IF NOT EXISTS `avo_board_new` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `ca_name` varchar(255) NOT NULL default '',
  `wr_parent` int(11) NOT NULL default '0',
  `bn_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_config`
--

DROP TABLE IF EXISTS `avo_config`;
CREATE TABLE IF NOT EXISTS `avo_config` (
  `cf_title` varchar(255) NOT NULL DEFAULT '',
  `cf_theme` varchar(255) NOT NULL DEFAULT '',
  `cf_admin` varchar(255) NOT NULL DEFAULT '',
  `cf_admin_email` varchar(255) NOT NULL DEFAULT '',
  `cf_admin_email_name` varchar(255) NOT NULL DEFAULT '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint(4) NOT NULL DEFAULT '0',
  `cf_point_term` int(11) NOT NULL DEFAULT '0',
  `cf_use_copy_log` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_email_certify` tinyint(4) NOT NULL DEFAULT '0',
  `cf_login_point` int(11) NOT NULL DEFAULT '0',
  `cf_cut_name` tinyint(4) NOT NULL DEFAULT '0',
  `cf_nick_modify` int(11) NOT NULL DEFAULT '0',
  `cf_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_new_rows` int(11) NOT NULL DEFAULT '0',
  `cf_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_read_point` int(11) NOT NULL DEFAULT '0',
  `cf_write_point` int(11) NOT NULL DEFAULT '0',
  `cf_comment_point` int(11) NOT NULL DEFAULT '0',
  `cf_download_point` int(11) NOT NULL DEFAULT '0',
  `cf_write_pages` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_pages` int(11) NOT NULL DEFAULT '0',
  `cf_link_target` varchar(255) NOT NULL DEFAULT '',
  `cf_delay_sec` int(11) NOT NULL DEFAULT '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_use_homepage` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_homepage` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_tel` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_tel` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_hp` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_hp` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_addr` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_addr` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_signature` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_signature` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_profile` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_profile` tinyint(4) NOT NULL DEFAULT '0',
  `cf_register_level` tinyint(4) NOT NULL DEFAULT '0',
  `cf_register_point` int(11) NOT NULL DEFAULT '0',
  `cf_icon_level` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_recommend` tinyint(4) NOT NULL DEFAULT '0',
  `cf_recommend_point` int(11) NOT NULL DEFAULT '0',
  `cf_leave_day` int(11) NOT NULL DEFAULT '0',
  `cf_search_part` int(11) NOT NULL DEFAULT '0',
  `cf_email_use` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_group_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_board_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_write` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_comment_all` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_mb_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_mb_member` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_po_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int(11) NOT NULL DEFAULT '0',
  `cf_memo_del` int(11) NOT NULL DEFAULT '0',
  `cf_visit_del` int(11) NOT NULL DEFAULT '0',
  `cf_popular_del` int(11) NOT NULL DEFAULT '0',
  `cf_optimize_date` date NOT NULL default '0000-00-00',
  `cf_use_member_icon` tinyint(4) NOT NULL DEFAULT '0',
  `cf_member_icon_size` int(11) NOT NULL DEFAULT '0',
  `cf_member_icon_width` int(11) NOT NULL DEFAULT '0',
  `cf_member_icon_height` int(11) NOT NULL DEFAULT '0',
  `cf_login_minutes` int(11) NOT NULL DEFAULT '0',
  `cf_image_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_flash_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_movie_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_formmail_is_member` tinyint(4) NOT NULL DEFAULT '0',
  `cf_page_rows` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `cf_visit` varchar(255) NOT NULL DEFAULT '',
  `cf_max_po_id` int(11) NOT NULL DEFAULT '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_open_modify` int(11) NOT NULL DEFAULT '0',
  `cf_memo_send_point` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_captcha_mp3` varchar(255) NOT NULL DEFAULT '',
  `cf_editor` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_use` tinyint(4) NOT NULL DEFAULT '0',
  `cf_cert_ipin` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_hp` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcb_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_lg_mid` varchar(255) NOT NULL DEFAULT '',
  `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_limit` int(11) NOT NULL DEFAULT '0',
  `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0',
  `cf_sms_use` varchar(255) NOT NULL DEFAULT '',
  `cf_sms_type` varchar(10) NOT NULL DEFAULT '',
  `cf_icode_id` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_pw` varchar(255) NOT NULL DEFAULT '',  
  `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '',
  `cf_googl_shorturl_apikey` varchar(255) NOT NULL DEFAULT '',
  `cf_facebook_appid` varchar(255) NOT NULL DEFAULT '',
  `cf_facebook_secret` varchar(255) NOT NULL DEFAULT '',
  `cf_twitter_key` varchar(255) NOT NULL DEFAULT '',
  `cf_twitter_secret` varchar(255) NOT NULL DEFAULT '',
  `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '',
  `cf_bgm` varchar(255) NOT NULL DEFAULT '',
  `cf_open` tinyint(4) NOT NULL DEFAULT '0',
  `cf_twitter` varchar(255) NOT NULL DEFAULT '',
  `cf_side_title` varchar(255) NOT NULL DEFAULT '',
  `cf_class_title` varchar(255) NOT NULL DEFAULT '',
  `cf_shop_category` varchar(255) NOT NULL DEFAULT '',
  `cf_item_category` varchar(255) NOT NULL DEFAULT '',
  `cf_site_descript` varchar(255) NOT NULL DEFAULT '',
  `cf_site_img` varchar(255) NOT NULL DEFAULT '',
  `cf_favicon` varchar(255) NOT NULL DEFAULT '',
  `cf_character_count` int(11) NOT NULL DEFAULT '0',
  `cf_search_count` int(11) NOT NULL DEFAULT '0',
  `cf_status_point` int(11) NOT NULL DEFAULT '0',
  `cf_money` varchar(255) NOT NULL DEFAULT '',
  `cf_money_pice` varchar(255) NOT NULL DEFAULT '',
  `cf_exp_name` varchar(255) NOT NULL DEFAULT '',
  `cf_exp_pice` varchar(255) NOT NULL DEFAULT '',
  `cf_rank_name` varchar(255) NOT NULL DEFAULT '',
  `cf_1` varchar(255) NOT NULL DEFAULT '',
  `cf_2` varchar(255) NOT NULL DEFAULT '',
  `cf_3` varchar(255) NOT NULL DEFAULT '',
  `cf_4` varchar(255) NOT NULL DEFAULT '',
  `cf_5` varchar(255) NOT NULL DEFAULT '',
  `cf_6` varchar(255) NOT NULL DEFAULT '',
  `cf_7` varchar(255) NOT NULL DEFAULT '',
  `cf_8` varchar(255) NOT NULL DEFAULT '',
  `cf_9` varchar(255) NOT NULL DEFAULT '',
  `cf_10` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_cert_history`
--

DROP TABLE IF EXISTS `avo_cert_history`;
CREATE TABLE IF NOT EXISTS `avo_cert_history` (
  `cr_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `cr_company` varchar(255) NOT NULL DEFAULT '',
  `cr_method` varchar(255) NOT NULL DEFAULT '',
  `cr_ip` varchar(255) NOT NULL DEFAULT '',
  `cr_date` date NOT NULL DEFAULT '0000-00-00',
  `cr_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_group`
--

DROP TABLE IF EXISTS `avo_group`;
CREATE TABLE IF NOT EXISTS `avo_group` (
  `gr_id` varchar(10) NOT NULL default '',
  `gr_subject` varchar(255) NOT NULL default '',
  `gr_device` ENUM('both','pc','mobile') NOT NULL DEFAULT 'both',
  `gr_admin` varchar(255) NOT NULL default '',
  `gr_use_access` tinyint(4) NOT NULL default '0',
  `gr_order` int(11) NOT NULL default '0',
  `gr_1_subj` varchar(255) NOT NULL default '',
  `gr_2_subj` varchar(255) NOT NULL default '',
  `gr_3_subj` varchar(255) NOT NULL default '',
  `gr_4_subj` varchar(255) NOT NULL default '',
  `gr_5_subj` varchar(255) NOT NULL default '',
  `gr_6_subj` varchar(255) NOT NULL default '',
  `gr_7_subj` varchar(255) NOT NULL default '',
  `gr_8_subj` varchar(255) NOT NULL default '',
  `gr_9_subj` varchar(255) NOT NULL default '',
  `gr_10_subj` varchar(255) NOT NULL default '',
  `gr_1` varchar(255) NOT NULL default '',
  `gr_2` varchar(255) NOT NULL default '',
  `gr_3` varchar(255) NOT NULL default '',
  `gr_4` varchar(255) NOT NULL default '',
  `gr_5` varchar(255) NOT NULL default '',
  `gr_6` varchar(255) NOT NULL default '',
  `gr_7` varchar(255) NOT NULL default '',
  `gr_8` varchar(255) NOT NULL default '',
  `gr_9` varchar(255) NOT NULL default '',
  `gr_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_group_member`
--

DROP TABLE IF EXISTS `avo_group_member`;
CREATE TABLE IF NOT EXISTS `avo_group_member` (
  `gm_id` int(11) NOT NULL auto_increment,
  `gr_id` varchar(255) NOT NULL default '',
  `mb_id` varchar(20) NOT NULL default '',
  `gm_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_login`
--

DROP TABLE IF EXISTS `avo_login`;
CREATE TABLE IF NOT EXISTS `avo_login` (
  `lo_ip` varchar(255) NOT NULL default '',
  `mb_id` varchar(20) NOT NULL default '',
  `lo_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY  (`lo_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_mail`
--

DROP TABLE IF EXISTS `avo_mail`;
CREATE TABLE IF NOT EXISTS `avo_mail` (
  `ma_id` int(11) NOT NULL auto_increment,
  `ma_subject` varchar(255) NOT NULL default '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL default '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY  (`ma_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_member`
--

DROP TABLE IF EXISTS `avo_member`;
CREATE TABLE IF NOT EXISTS `avo_member` (
  `mb_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `ch_id` int(11) NOT NULL default '0',
  `mb_password` varchar(255) NOT NULL default '',
  `mb_name` varchar(255) NOT NULL default '',
  `mb_nick` varchar(255) NOT NULL default '',
  `mb_nick_date` date NOT NULL default '0000-00-00',
  `mb_email` varchar(255) NOT NULL default '',
  `mb_homepage` varchar(255) NOT NULL default '',
  `mb_level` tinyint(4) NOT NULL default '0',
  `mb_sex` char(1) NOT NULL default '',
  `mb_birth` varchar(255) NOT NULL default '',
  `mb_tel` varchar(255) NOT NULL default '',
  `mb_hp` varchar(255) NOT NULL default '',
  `mb_certify` varchar(20) NOT NULL default '',
  `mb_adult` tinyint(4) NOT NULL default '0',
  `mb_dupinfo` varchar(255) NOT NULL default '',
  `mb_zip1` char(3) NOT NULL default '',
  `mb_zip2` char(3) NOT NULL default '',
  `mb_addr1` varchar(255) NOT NULL default '',
  `mb_addr2` varchar(255) NOT NULL default '',
  `mb_addr3` varchar(255) NOT NULL default '',
  `mb_addr_jibeon` varchar(255) NOT NULL default '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL default '',
  `mb_point` int(11) NOT NULL default '0',
  `mb_today_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL default '',
  `mb_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL default '',
  `mb_leave_date` varchar(8) NOT NULL default '',
  `mb_intercept_date` varchar(8) NOT NULL default '',
  `mb_email_certify` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_email_certify2` varchar(255) NOT NULL default '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL DEFAULT '',
  `mb_mailling` tinyint(4) NOT NULL default '0',
  `mb_sms` tinyint(4) NOT NULL default '0',
  `mb_open` tinyint(4) NOT NULL default '0',
  `mb_open_date` date NOT NULL default '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL default '',
  `mb_board_call` varchar(255) NOT NULL default '',
  `mb_board_link` varchar(255) NOT NULL default '',
  `mb_1` varchar(255) NOT NULL default '',
  `mb_2` varchar(255) NOT NULL default '',
  `mb_3` varchar(255) NOT NULL default '',
  `mb_4` varchar(255) NOT NULL default '',
  `mb_5` varchar(255) NOT NULL default '',
  `mb_6` varchar(255) NOT NULL default '',
  `mb_7` varchar(255) NOT NULL default '',
  `mb_8` varchar(255) NOT NULL default '',
  `mb_9` varchar(255) NOT NULL default '',
  `mb_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_memo`
--

DROP TABLE IF EXISTS `avo_memo`;
CREATE TABLE IF NOT EXISTS `avo_memo` (
  `me_id` int(11) NOT NULL default '0',
  `me_recv_mb_id` varchar(20) NOT NULL default '',
  `me_send_mb_id` varchar(20) NOT NULL default '',
  `me_send_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  PRIMARY KEY  (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_point`
--

DROP TABLE IF EXISTS `avo_point`;
CREATE TABLE IF NOT EXISTS `avo_point` (
  `po_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL default '',
  `po_point` int(11) NOT NULL default '0',
  `po_use_point` int(11) NOT NULL default '0',
  `po_expired` tinyint(4) NOT NULL default '0',
  `po_expire_date` date NOT NULL default '0000-00-00',
  `po_mb_point` int(11) NOT NULL default '0',
  `po_rel_table` varchar(20) NOT NULL default '',
  `po_rel_id` varchar(20) NOT NULL default '',
  `po_rel_action` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_poll`
--

DROP TABLE IF EXISTS `avo_poll`;
CREATE TABLE IF NOT EXISTS `avo_poll` (
  `po_id` int(11) NOT NULL auto_increment,
  `po_subject` varchar(255) NOT NULL default '',
  `po_poll1` varchar(255) NOT NULL default '',
  `po_poll2` varchar(255) NOT NULL default '',
  `po_poll3` varchar(255) NOT NULL default '',
  `po_poll4` varchar(255) NOT NULL default '',
  `po_poll5` varchar(255) NOT NULL default '',
  `po_poll6` varchar(255) NOT NULL default '',
  `po_poll7` varchar(255) NOT NULL default '',
  `po_poll8` varchar(255) NOT NULL default '',
  `po_poll9` varchar(255) NOT NULL default '',
  `po_cnt1` int(11) NOT NULL default '0',
  `po_cnt2` int(11) NOT NULL default '0',
  `po_cnt3` int(11) NOT NULL default '0',
  `po_cnt4` int(11) NOT NULL default '0',
  `po_cnt5` int(11) NOT NULL default '0',
  `po_cnt6` int(11) NOT NULL default '0',
  `po_cnt7` int(11) NOT NULL default '0',
  `po_cnt8` int(11) NOT NULL default '0',
  `po_cnt9` int(11) NOT NULL default '0',
  `po_etc` varchar(255) NOT NULL default '',
  `po_level` tinyint(4) NOT NULL default '0',
  `po_point` int(11) NOT NULL default '0',
  `po_date` date NOT NULL default '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  PRIMARY KEY  (`po_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_poll_etc`
--

DROP TABLE IF EXISTS `avo_poll_etc`;
CREATE TABLE IF NOT EXISTS `avo_poll_etc` (
  `pc_id` int(11) NOT NULL default '0',
  `po_id` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `pc_name` varchar(255) NOT NULL default '',
  `pc_idea` varchar(255) NOT NULL default '',
  `pc_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`pc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_popular`
--

DROP TABLE IF EXISTS `avo_popular`;
CREATE TABLE IF NOT EXISTS `avo_popular` (
  `pp_id` int(11) NOT NULL auto_increment,
  `pp_word` varchar(50) NOT NULL default '',
  `pp_date` date NOT NULL default '0000-00-00',
  `pp_ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_scrap`
--

DROP TABLE IF EXISTS `avo_scrap`;
CREATE TABLE IF NOT EXISTS `avo_scrap` (
  `ms_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` varchar(15) NOT NULL default '',
  `ms_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_visit`
--

DROP TABLE IF EXISTS `avo_visit`;
CREATE TABLE IF NOT EXISTS `avo_visit` (
  `vi_id` int(11) NOT NULL default '0',
  `vi_ip` varchar(255) NOT NULL default '',
  `vi_date` date NOT NULL default '0000-00-00',
  `vi_time` time NOT NULL default '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_visit_sum`
--

DROP TABLE IF EXISTS `avo_visit_sum`;
CREATE TABLE IF NOT EXISTS `avo_visit_sum` (
  `vs_date` date NOT NULL default '0000-00-00',
  `vs_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_unique`
--

DROP TABLE IF EXISTS `avo_uniqid`;
CREATE TABLE IF NOT EXISTS `avo_uniqid` (
  `uq_id` bigint(20) unsigned NOT NULL,
  `uq_ip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_autosave`
--

DROP TABLE IF EXISTS `avo_autosave`;
CREATE TABLE IF NOT EXISTS `avo_autosave` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint(20) unsigned NOT NULL,
  `as_subject` varchar(255) NOT NULL DEFAULT '',
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_qa_config`
--

DROP TABLE IF EXISTS `avo_qa_config`;
CREATE TABLE IF NOT EXISTS `avo_qa_config` (
  `qa_title` varchar(255) NOT NULL DEFAULT'',
  `qa_category` varchar(255) NOT NULL DEFAULT'',
  `qa_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_use_email` tinyint(4) NOT NULL DEFAULT '0',
  `qa_req_email` tinyint(4) NOT NULL DEFAULT '0',
  `qa_use_hp` tinyint(4) NOT NULL DEFAULT '0',
  `qa_req_hp` tinyint(4) NOT NULL DEFAULT '0',
  `qa_use_sms` tinyint(4) NOT NULL DEFAULT '0',
  `qa_send_number` varchar(255) NOT NULL DEFAULT '0',
  `qa_admin_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_admin_email` varchar(255) NOT NULL DEFAULT '',
  `qa_use_editor` tinyint(4) NOT NULL DEFAULT '0',
  `qa_subject_len` int(11) NOT NULL DEFAULT '0',
  `qa_mobile_subject_len` int(11) NOT NULL DEFAULT '0',
  `qa_page_rows` int(11) NOT NULL DEFAULT '0',
  `qa_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `qa_image_width` int(11) NOT NULL DEFAULT '0',
  `qa_upload_size` int(11) NOT NULL DEFAULT '0',
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL DEFAULT '',
  `qa_include_tail` varchar(255) NOT NULL DEFAULT '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_2_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_3_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_4_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_5_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_qa_content`
--

DROP TABLE IF EXISTS `avo_qa_content`;
CREATE TABLE IF NOT EXISTS `avo_qa_content` (
  `qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `qa_num` int(11) NOT NULL DEFAULT '0',  
  `qa_parent` int(11) NOT NULL DEFAULT '0',
  `qa_related` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `qa_name` varchar(255) NOT NULL DEFAULT '',
  `qa_email` varchar(255) NOT NULL DEFAULT '',
  `qa_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_type` tinyint(4) NOT NULL DEFAULT '0',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_email_recv` tinyint(4) NOT NULL DEFAULT '0',
  `qa_sms_recv` tinyint(4) NOT NULL DEFAULT '0',
  `qa_html` tinyint(4) NOT NULL DEFAULT '0',
  `qa_subject` varchar(255) NOT NULL DEFAULT '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint(4) NOT NULL DEFAULT '0',
  `qa_file1` varchar(255) NOT NULL DEFAULT '',
  `qa_source1` varchar(255) NOT NULL DEFAULT '',
  `qa_file2` varchar(255) NOT NULL DEFAULT '',
  `qa_source2` varchar(255) NOT NULL DEFAULT '',
  `qa_ip` varchar(255) NOT NULL DEFAULT '',
  `qa_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_content`
--

DROP TABLE IF EXISTS `avo_content`;
CREATE TABLE IF NOT EXISTS `avo_content` (
  `co_id` varchar(20) NOT NULL DEFAULT '',
  `co_html` tinyint(4) NOT NULL DEFAULT '0',
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` longtext NOT NULL,
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT '0',
  `co_hit` int(11) NOT NULL DEFAULT '0',
  `co_include_head` varchar(255) NOT NULL DEFAULT '',
  `co_include_tail` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`co_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_faq`
--

DROP TABLE IF EXISTS `avo_faq`;
CREATE TABLE IF NOT EXISTS `avo_faq` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_id` int(11) NOT NULL DEFAULT '0',
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_faq_master`
--

DROP TABLE IF EXISTS `avo_faq_master`;
CREATE TABLE IF NOT EXISTS `avo_faq_master` (
  `fm_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_subject` varchar(255) NOT NULL DEFAULT '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_new_win`
--

DROP TABLE IF EXISTS `avo_new_win`;
CREATE TABLE IF NOT EXISTS `avo_new_win` (
  `nw_id` int(11) NOT NULL AUTO_INCREMENT,
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int(11) NOT NULL DEFAULT '0',
  `nw_left` int(11) NOT NULL DEFAULT '0',
  `nw_top` int(11) NOT NULL DEFAULT '0',
  `nw_height` int(11) NOT NULL DEFAULT '0',
  `nw_width` int(11) NOT NULL DEFAULT '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `nw_content_html` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nw_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `avo_menu`
--

DROP TABLE IF EXISTS `avo_menu`;
CREATE TABLE IF NOT EXISTS `avo_menu` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `me_link` varchar(255) NOT NULL DEFAULT '',
  `me_target` varchar(255) NOT NULL DEFAULT '',
  `me_order` int(11) NOT NULL DEFAULT '0',
  `me_use` tinyint(4) NOT NULL DEFAULT '0',
  `me_mobile_use` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`me_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `avo_exp`
--
DROP TABLE IF EXISTS `avo_exp`;
CREATE TABLE IF NOT EXISTS `avo_exp` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` varchar(20) NOT NULL DEFAULT '',
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `ex_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ex_content` varchar(255) NOT NULL DEFAULT '',
  `ex_point` int(11) NOT NULL DEFAULT '0',
  `ex_ch_exp` int(11) NOT NULL DEFAULT '0',
  `ex_rel_action` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `avo_character`
--
DROP TABLE IF EXISTS `avo_character`;
CREATE TABLE IF NOT EXISTS `avo_character` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `ch_thumb` varchar(255) NOT NULL DEFAULT '',
  `ch_head` varchar(255) NOT NULL DEFAULT '',
  `ch_body` varchar(255) NOT NULL DEFAULT '',
  `ch_title` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `ch_side` varchar(255) NOT NULL DEFAULT '0',
  `ch_class` varchar(255) NOT NULL DEFAULT '0',
  `ch_rank` char(4) NOT NULL DEFAULT '',
  `ch_exp` int(11) NOT NULL DEFAULT '0',
  `ch_point` int(11) NOT NULL DEFAULT '0',
  `ch_type` varchar(255) NOT NULL DEFAULT '',
  `ch_search_date` varchar(255) NOT NULL DEFAULT '',
  `ch_search` int(11) NOT NULL DEFAULT '0',
  `ch_state` varchar(255) NOT NULL DEFAULT '',
  `ma_id` int(11) NOT NULL DEFAULT '0',
  `ch_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `avo_character_class`
--
DROP TABLE IF EXISTS `avo_character_class`;
CREATE TABLE IF NOT EXISTS `avo_character_class` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_name` varchar(255) NOT NULL DEFAULT '',
  `cl_img` varchar(255) NOT NULL DEFAULT '',
  `cl_auth` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`cl_id`),
  KEY `cl_id` (`cl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `avo_character_side`
--
DROP TABLE IF EXISTS `avo_character_side`;
CREATE TABLE IF NOT EXISTS `avo_character_side` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_name` varchar(255) NOT NULL DEFAULT '',
  `si_img` varchar(255) NOT NULL DEFAULT '',
  `si_auth` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`si_id`),
  KEY `si_id` (`si_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_character_closthes`
--
DROP TABLE IF EXISTS `avo_character_closthes`;
CREATE TABLE IF NOT EXISTS `avo_character_closthes` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` int(11) NOT NULL DEFAULT '0',
  `cl_subject` varchar(255) NOT NULL DEFAULT '',
  `cl_path` varchar(255) NOT NULL DEFAULT '',
  `cl_use` int(4) NOT NULL DEFAULT '0',
  `cl_type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cl_id`),
  KEY `cl_id` (`cl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_couple`
--
DROP TABLE IF EXISTS `avo_couple`;
CREATE TABLE IF NOT EXISTS `avo_couple` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT,
  `co_left` int(11) NOT NULL DEFAULT '0',
  `co_right` int(11) NOT NULL DEFAULT '0',
  `co_order` int(11) NOT NULL DEFAULT '0',
  `co_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY  (`co_id`),
  KEY `co_id` (`co_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_emoticon`
--
DROP TABLE IF EXISTS `avo_emoticon`;
CREATE TABLE IF NOT EXISTS `avo_emoticon` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_text` varchar(255) NOT NULL DEFAULT '',
  `me_img` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`me_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_inventory`
--
DROP TABLE IF EXISTS `avo_inventory`;
CREATE TABLE IF NOT EXISTS `avo_inventory` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `it_id` varchar(255) NOT NULL DEFAULT '',
  `it_name` varchar(255) NOT NULL DEFAULT '',
  `it_rel` varchar(255) NOT NULL DEFAULT '',
  `ch_id` varchar(255) NOT NULL DEFAULT '',
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `se_ch_id` varchar(255) NOT NULL DEFAULT '',
  `se_ch_name` varchar(255) NOT NULL DEFAULT '',
  `re_ch_id` varchar(255) NOT NULL DEFAULT '',
  `re_ch_name` varchar(255) NOT NULL DEFAULT '',
  `in_sdatetime` datetime NOT NULL DEFAULT '0000-00-00',
  `in_edatetime` datetime NOT NULL DEFAULT '0000-00-00',
  `in_memo` varchar(255) NOT NULL DEFAULT '',
  `in_use` varchar(255) NOT NULL DEFAULT '',
  `in_1` varchar(255) NOT NULL DEFAULT '',
  `in_2` varchar(255) NOT NULL DEFAULT '',
  `in_3` varchar(255) NOT NULL DEFAULT '',
  `in_4` varchar(255) NOT NULL DEFAULT '',
  `in_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`in_id`),
  KEY `in_id` (`in_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `avo_item`
--
DROP TABLE IF EXISTS `avo_item`;
CREATE TABLE IF NOT EXISTS `avo_item` (
  `it_id` int(11) NOT NULL DEFAULT '0',
  `it_name` varchar(255) NOT NULL DEFAULT '',
  `it_category` varchar(255) NOT NULL DEFAULT '',
  `it_content` varchar(255) NOT NULL DEFAULT '',
  `it_content2` text NOT NULL,
  `it_use_class` varchar(255) NOT NULL DEFAULT '',
  `it_use_side` varchar(255) NOT NULL DEFAULT '',
  `it_use_able` varchar(255) NOT NULL DEFAULT '',
  `it_use_mmb_able` int(4) NOT NULL DEFAULT '0',
  `it_img` varchar(255) NOT NULL DEFAULT '',
  `it_has` int(11) NOT NULL DEFAULT '0',
  `it_sell` int(11) NOT NULL DEFAULT '0',
  `it_use_sell` int(11) NOT NULL DEFAULT '0',
  `it_use_ever` int(11) NOT NULL DEFAULT '0',
  `it_use` char(4) NOT NULL DEFAULT '',
  `it_type` varchar(255) NOT NULL DEFAULT '',
  `it_value` varchar(255) NOT NULL DEFAULT '',
  `it_use_recepi` int(11) NOT NULL DEFAULT '0',
  `it_seeker` int(4) NOT NULL DEFAULT '0',
  `it_seeker_per_s` int(11) NOT NULL DEFAULT '0',
  `it_seeker_per_e` int(11) NOT NULL DEFAULT '0',
  `st_id` int(11) NOT NULL DEFAULT '0',
  `it_1` varchar(255) NOT NULL DEFAULT '',
  `it_2` varchar(255) NOT NULL DEFAULT '',
  `it_3` varchar(255) NOT NULL DEFAULT '',
  `it_4` varchar(255) NOT NULL DEFAULT '',
  `it_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`it_id`),
  KEY `it_id` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `avo_item_recepi`
--
DROP TABLE IF EXISTS `avo_item_recepi`;
CREATE TABLE IF NOT EXISTS `avo_item_recepi` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `re_item_order` varchar(255) NOT NULL DEFAULT '',
  `it_id` int(11) NOT NULL DEFAULT '0',
  `re_use` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`re_id`),
  KEY `re_id` (`re_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- 테이블 구조 `avo_order`
--
DROP TABLE IF EXISTS `avo_order`;
CREATE TABLE IF NOT EXISTS `avo_order` (
  `or_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` varchar(255) NOT NULL DEFAULT '',
  `it_id` varchar(255) NOT NULL DEFAULT '',
  `or_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `or_use` varchar(11) NOT NULL DEFAULT '',
  `add_state` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`or_id`),
  KEY `or_id` (`or_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `avo_relation_character`
--
DROP TABLE IF EXISTS `avo_relation_character`;
CREATE TABLE IF NOT EXISTS `avo_relation_character` (
  `rm_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_id` int(11) NOT NULL DEFAULT '0',
  `re_ch_id` int(11) NOT NULL DEFAULT '0',
  `rm_memo` text NOT NULL,
  `rm_like` int(11) NOT NULL DEFAULT '0',
  `rm_link` text NOT NULL,
  `rm_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`rm_id`),
  KEY `rm_id` (`rm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_banner`
--
DROP TABLE IF EXISTS `avo_banner`;
CREATE TABLE IF NOT EXISTS `avo_banner` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT,
  `bn_img` varchar(255) NOT NULL DEFAULT '',
  `bn_m_img` varchar(255) NOT NULL DEFAULT '',
  `bn_alt` varchar(255) NOT NULL DEFAULT '',
  `bn_url` varchar(255) NOT NULL DEFAULT '',
  `bn_new_win` tinyint(4) NOT NULL DEFAULT '0',
  `bn_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- 테이블 구조 `avo_intro`
--
DROP TABLE IF EXISTS `avo_intro`;
CREATE TABLE IF NOT EXISTS `avo_intro` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT,
  `bn_img` varchar(255) NOT NULL DEFAULT '',
  `bn_m_img` varchar(255) NOT NULL DEFAULT '',
  `bn_alt` varchar(255) NOT NULL DEFAULT '',
  `bn_url` varchar(255) NOT NULL DEFAULT '',
  `bn_new_win` tinyint(4) NOT NULL DEFAULT '0',
  `bn_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
--
-- 테이블 구조 `avo_call_board`
--
DROP TABLE IF EXISTS `avo_call_board`;
CREATE TABLE IF NOT EXISTS `avo_call_board` (
  `bc_id` int(11) NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(255) NOT NULL DEFAULT '',
  `wr_id` varchar(255) NOT NULL DEFAULT '',
  `wr_num` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `mb_name` varchar(255) NOT NULL DEFAULT '',
  `ch_side` int(11) NOT NULL DEFAULT '0',
  `re_mb_id` varchar(255) NOT NULL DEFAULT '',
  `re_mb_name` varchar(255) NOT NULL DEFAULT '',
  `memo` text NOT NULL,
  `bc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bc_check` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`bc_id`),
  KEY `bc_id` (`bc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `avo_character_title`;
CREATE TABLE IF NOT EXISTS `avo_character_title` (
  `ti_id` int(11) NOT NULL AUTO_INCREMENT,
  `ti_title` varchar(255) NOT NULL DEFAULT '',
  `ti_img` varchar(255) NOT NULL DEFAULT '',
  `ti_use` char(4) NOT NULL DEFAULT '',
  `ti_value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`ti_id`),
  KEY `ti_id` (`ti_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_has_title`;
CREATE TABLE IF NOT EXISTS `avo_has_title` (
  `hi_id` int(11) NOT NULL AUTO_INCREMENT,
  `ti_id` int(11) NOT NULL DEFAULT '0',
  `ch_id`  int(11) NOT NULL DEFAULT '0',
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `hi_use` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`hi_id`),
  KEY `hi_id` (`hi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_css_config`;
CREATE TABLE IF NOT EXISTS `avo_css_config` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(255) NOT NULL DEFAULT '',
  `cs_value` varchar(255) NOT NULL DEFAULT '',
  `cs_descript` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_1` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_2` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_3` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_4` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_5` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_6` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_7` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_8` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_9` varchar(255) NOT NULL DEFAULT '',
  `cs_etc_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cs_id`),
  KEY `cs_id` (`cs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_article`;
CREATE TABLE IF NOT EXISTS `avo_article` (
  `ar_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ar_theme` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_code` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_name` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_type` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_size` INT(11) NOT NULL DEFAULT '0',
  `ar_text` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_help` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_order` INT(11) NOT NULL DEFAULT '0',
  `ar_secret` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`ar_id`),
  KEY `ar_id` (`ar_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_article_default`;
CREATE TABLE IF NOT EXISTS `avo_article_default` (
  `ad_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ad_use_thumb` INT(11) NOT NULL DEFAULT '0',
  `ad_use_head` INT(11) NOT NULL DEFAULT '0',
  `ad_use_body` INT(11) NOT NULL DEFAULT '0',
  `ad_use_name` INT(11) NOT NULL DEFAULT '0',
  `ad_text_thumb` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_text_head` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_text_body` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_text_name` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_help_thumb` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_help_head` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_help_body` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_help_name` VARCHAR(255) NOT NULL DEFAULT '',
  `ad_url_thumb` INT(11) NOT NULL DEFAULT '0',
  `ad_url_head` INT(11) NOT NULL DEFAULT '0',
  `ad_url_body` INT(11) NOT NULL DEFAULT '0',
  `ad_use_title` INT(11) NOT NULL DEFAULT '0',
  `ad_use_closet` INT(11) NOT NULL DEFAULT '0',
  `ad_use_inven` INT(11) NOT NULL DEFAULT '0',
  `ad_use_money` INT(11) NOT NULL DEFAULT '0',
  `ad_use_rank` INT(11) NOT NULL DEFAULT '0',
  `ad_use_exp` INT(11) NOT NULL DEFAULT '0',
  `ad_use_status` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`ad_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_article_value`;
CREATE TABLE IF NOT EXISTS `avo_article_value` (
  `av_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ch_id` INT(11) NOT NULL DEFAULT '0',
  `ar_theme` VARCHAR(255) NOT NULL DEFAULT '',
  `ar_code` VARCHAR(255) NOT NULL DEFAULT '',
  `av_value` TEXT NOT NULL ,
  `av_1` VARCHAR(255) NOT NULL DEFAULT '',
  `av_2` VARCHAR(255) NOT NULL DEFAULT '',
  `av_3` VARCHAR(255) NOT NULL DEFAULT '',
  `av_4` VARCHAR(255) NOT NULL DEFAULT '',
  `av_5` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`av_id`),
  KEY `av_id` (`av_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_level_setting`;
CREATE TABLE IF NOT EXISTS `avo_level_setting` (
  `lv_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `lv_name` VARCHAR(255) NOT NULL DEFAULT '',
  `lv_exp` INT(11) NOT NULL DEFAULT '0',
  `lv_add_state` INT(11) NOT NULL DEFAULT '0',
  `lv_1` VARCHAR(255) NOT NULL DEFAULT '',
  `lv_2` VARCHAR(255) NOT NULL DEFAULT '',
  `lv_3` VARCHAR(255) NOT NULL DEFAULT '',
  `lv_4` VARCHAR(255) NOT NULL DEFAULT '',
  `lv_5` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`lv_id`),
  KEY `lv_id` (`lv_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_shop`;
CREATE TABLE IF NOT EXISTS `avo_shop` (
  `sh_id` int(11) NOT NULL AUTO_INCREMENT ,
  `it_id` int(11) NOT NULL DEFAULT '0',
  `ca_name` varchar(255) NOT NULL DEFAULT '',
  `sh_limit` int(11) NOT NULL DEFAULT '0',
  `sh_qty` int(11) NOT NULL DEFAULT '0',
  `sh_money` int(11) NOT NULL DEFAULT '0',
  `sh_use_money` int(11) NOT NULL DEFAULT '0',
  `sh_exp` int(11) NOT NULL DEFAULT '0',
  `sh_use_exp` int(11) NOT NULL DEFAULT '0',
  `sh_content` varchar(255) NOT NULL DEFAULT '',
  `sh_side` varchar(255) NOT NULL DEFAULT '',
  `sh_use_side` int(11) NOT NULL DEFAULT '0',
  `sh_class` varchar(255) NOT NULL DEFAULT '',
  `sh_use_class` int(11) NOT NULL DEFAULT '0',
  `sh_rank` varchar(255) NOT NULL DEFAULT '',
  `sh_use_rank` int(11) NOT NULL DEFAULT '0',
  `sh_has_item` int(11) NOT NULL DEFAULT '0',
  `sh_use_has_item` int(11) NOT NULL DEFAULT '0',
  `sh_has_title` int(11) NOT NULL DEFAULT '0',
  `sh_use_has_title` int(11) NOT NULL DEFAULT '0',
  `sh_date_s` varchar(255) NOT NULL DEFAULT '',
  `sh_date_e` varchar(255) NOT NULL DEFAULT '',
  `sh_time_s` int(11) NOT NULL DEFAULT '0',
  `sh_time_e` int(11) NOT NULL DEFAULT '0',
  `sh_week` varchar(255) NOT NULL DEFAULT '',
  `sh_order` int(11) NOT NULL DEFAULT '0',
  `sh_use` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`sh_id`),
  KEY `lv_id` (`sh_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_item_explorer`;
CREATE TABLE IF NOT EXISTS `avo_item_explorer` (
  `ie_id` int(11) NOT NULL AUTO_INCREMENT,
  `it_id` int(11) NOT NULL DEFAULT '0',
  `re_it_id` int(11) NOT NULL DEFAULT '0',
  `ie_per_s` int(11) NOT NULL DEFAULT '0',
  `ie_per_e` int(11) NOT NULL DEFAULT '0',
  `ma_id` int(11) NOT NULL DEFAULT '0',
  `ie_1` int(11) NOT NULL DEFAULT '0',
  `ie_2` int(11) NOT NULL DEFAULT '0',
  `ie_3` int(11) NOT NULL DEFAULT '0',
  `ie_4` int(11) NOT NULL DEFAULT '0',
  `ie_5` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`ie_id`),
  KEY `lv_id` (`ie_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_status`;
CREATE TABLE IF NOT EXISTS `avo_status` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_name`  varchar(255) NOT NULL DEFAULT '',
  `st_max` int(11) NOT NULL DEFAULT '0',
  `st_min` int(11) NOT NULL DEFAULT '0',
  `st_use_max` int(11) NOT NULL DEFAULT '0',
  `st_order` int(11) NOT NULL DEFAULT '0',
  `st_help`  varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`st_id`),
  KEY `lv_id` (`st_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `avo_status_character`;
CREATE TABLE IF NOT EXISTS `avo_status_character` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_id` int(11) NOT NULL DEFAULT '0',
  `ch_id` int(11) NOT NULL DEFAULT '0',
  `sc_max` int(11) NOT NULL DEFAULT '0',
  `sc_value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`sc_id`),
  KEY `sc_id` (`sc_id`)
) ENGINE = MyISAM  DEFAULT CHARSET=utf8;
