<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_title($ti_id) { 
	global $g5;
	$result = "";
	$ti = sql_fetch("select * from {$g5['title_table']} where ti_id = '{$ti_id}' and ti_use = 'Y'");
	return $ti;
}
function get_title_value($ti_id) { 
	global $g5;
	$result = "";
	$ti = sql_fetch("select ti_value from {$g5['title_table']} where ti_id = '{$ti_id}'");
	if($ti['ti_value']) $result = $ti['ti_value'];

	return $result;
}
function get_title_image($ti_id) { 
	global $g5;
	$result = "";
	$ti = sql_fetch("select ti_img from {$g5['title_table']} where ti_id = '{$ti_id}'");
	if($ti['ti_img']) $result = "<img src='".$ti['ti_img']."' />";

	return $result;
}

?>