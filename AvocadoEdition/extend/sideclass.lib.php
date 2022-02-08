<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_side_name ($si_id)
{
	global $g5;
	$result = sql_fetch("select si_name from {$g5['side_table']} where si_id = '{$si_id}'");

	$str = $result['si_name'];
	if(!$str) $str = '-';

	return $str;
}

function get_class_name ($cl_id)
{
	global $g5;
	$result = sql_fetch("select cl_name from {$g5['class_table']} where cl_id = '{$cl_id}'");
	
	$str = $result['cl_name'];
	if(!$str) $str = '-';

	return $str;
}

function get_side_icon ($si_id)
{
	global $g5;
	$str = "";
	$side_url = G5_DATA_URL."/side";
	$result = sql_fetch("select si_img, si_name from {$g5['side_table']} where si_id = '{$si_id}'");

	if($result['si_img']) { 
		$str = "<img src='".$result['si_img']."' alt='".$result['si_name']."' class='ui-side-icon'/>";
	}

	return $str;
}

function get_class_icon ($cl_id)
{
	global $g5;
	$str = "";
	$class_url = G5_DATA_URL."/class";

	$result = sql_fetch("select cl_img, cl_name from {$g5['class_table']} where cl_id = '{$cl_id}'");
	if($result['cl_img']) { 
		$str = "<img src='".$result['cl_img']."' alt='".$result['cl_name']."' class='ui-class-icon'/>";
	}
	return $str;
}
?>