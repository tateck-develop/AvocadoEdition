<?php
$sub_menu = '600100';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$html_title = '파일 ';
$g5['title'] = $html_title.'관리';

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>




<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
