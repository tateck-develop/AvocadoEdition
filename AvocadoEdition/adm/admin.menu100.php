<?php
$menu['menu100'] = array (
	array('100000', '환경설정', G5_ADMIN_URL.'/config_form.php',   'config'),
	array('100100', '기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic'),
	array('100200', '커뮤니티 설정', G5_ADMIN_URL.'/community_form.php', 'cf_comm_basic'),
	array('100250', '화면 설정', G5_ADMIN_URL.'/viewer_form.php', 'cf_view_basic'),
	array('100280', '테마설정', G5_ADMIN_URL.'/theme.php',     'cf_theme', 1),
	array('100300', '디자인 설정', G5_ADMIN_URL.'/design_form.php', 'cf_design_basic'),
	/*array('100310', '팝업레이어관리', G5_ADMIN_URL.'/newwinlist.php', 'scf_poplayer'),*/
	array('100320', '메인슬라이드 관리', G5_ADMIN_URL.'/banner_list.php', 'cf_banner'),
	array('100330', '인트로 관리', G5_ADMIN_URL.'/intro_list.php', 'cf_banner'),
	array('100990', 'DB관리', G5_DB_URL, '')
);

/*
if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) {
	$menu['menu100'][] = array('100510', 'Browscap 업데이트', G5_ADMIN_URL.'/browscap.php', 'cf_browscap');
	$menu['menu100'][] = array('100520', '접속로그 변환', G5_ADMIN_URL.'/browscap_convert.php', 'cf_visit_cnvrt');
}
$menu['menu100'][] = array('100400', '부가서비스', G5_ADMIN_URL.'/service.php', 'cf_service');
*/
?>