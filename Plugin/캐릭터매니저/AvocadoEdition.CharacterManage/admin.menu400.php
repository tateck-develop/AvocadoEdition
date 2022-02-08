<?php
$menu['menu400'] = array (
	array('400000', '캐릭터관리', ''.G5_ADMIN_URL.'/character_list.php', ''),
	array('400100', '프로필 양식 관리', ''.G5_ADMIN_URL.'/character_article_list.php', ''),
	array('400200', '캐릭터 관리', ''.G5_ADMIN_URL.'/character_list.php', ''),
	array('400210', '┗… 합격관리', ''.G5_ADMIN_URL.'/character_pass_manager.php', ''),
	array('400300', '타이틀 관리', ''.G5_ADMIN_URL.'/title_list.php', ''),
	array('400310', '보유타이틀 관리', ''.G5_ADMIN_URL.'/title_has_list.php', ''),
	array('400400', $config['cf_rank_name'].' 설정 관리', ''.G5_ADMIN_URL.'/level_list.php', ''),
	array('400410', $config['cf_exp_name'].' 관리', ''.G5_ADMIN_URL.'/exp_list.php', ''),
	array('400420', '스탯 관리', ''.G5_ADMIN_URL.'/status_list.php', ''),
	array('400500', '커플 관리', ''.G5_ADMIN_URL.'/couple_list.php', '')
);

if($config['cf_side_title']) {
	$menu['menu400'][] = array('400600', $config['cf_side_title'].' 관리', G5_ADMIN_URL.'/side_list.php', '');
}
if($config['cf_class_title']) {
	$menu['menu400'][] = array('400700', $config['cf_class_title'].' 관리', G5_ADMIN_URL.'/class_list.php', '');
}

?>