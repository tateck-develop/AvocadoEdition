<?php
$menu['menu900'] = array (
    array('900000', '기타관리', G5_ADMIN_URL.'/session_file_delete.php', ''),
    array('900100', '세션파일 일괄삭제',G5_ADMIN_URL.'/session_file_delete.php', 'cf_session', 1),
	array('900200', '캐시파일 일괄삭제',G5_ADMIN_URL.'/cache_file_delete.php',   'cf_cache', 1),
	array('900300', '썸네일파일 일괄삭제',G5_ADMIN_URL.'/thumbnail_file_delete.php',   'cf_thumbnail', 1),
	/*array('900400', '데이터 백업지점 설정',G5_ADMIN_URL.'/data_backup.php',   '', 1),
	array('900500', '데이터 복원하기',G5_ADMIN_URL.'/data_restore.php',   '', 1)*/
);
?>