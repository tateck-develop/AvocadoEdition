<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$qa_skin_path = get_skin_path('qa', $qaconfig['qa_skin']);
$qa_skin_url  = get_skin_url('qa', $qaconfig['qa_skin']);


if(is_include_path_check($qaconfig['qa_include_head']))
	@include ($qaconfig['qa_include_head']);
else
	include ('./_head.php');

?>