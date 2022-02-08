<?php
include_once('./_common.php');


$sql_common = " from {$g5['couple_table']} ";
$sql_search = "  ";
$sql_order = " order by co_order asc ";
$sql_limit = "";
$sql = " select * {$sql_common} {$sql_search} {$sql_order} ";
$result = sql_query($sql);

$list = array();
for($i=0; $co = sql_fetch_array($result); $i++) {
	$list[$i] = $co;

	$ch_left = sql_fetch("select ch_name, ch_thumb, mb_id from {$g5['character_table']} where ch_id = '{$co['co_left']}'");
	$ch_right = sql_fetch("select ch_name, ch_thumb, mb_id from {$g5['character_table']} where ch_id = '{$co['co_right']}'");

	$ch_left['ch_name'] = explode(' ', $ch_left['ch_name']);
	$ch_left['ch_name'] = $ch_left['ch_name'][0];

	$ch_right['ch_name'] = explode(' ', $ch_right['ch_name']);
	$ch_right['ch_name'] = $ch_right['ch_name'][0];

	$h=date('H'); //현재시를 구함 
	$m=date('i'); //현재 분을 구함 
	$s=date('s'); //현재 초를 구함 
	$date=date("U",strtotime($co['co_date'])); //생일의 유닉스타임스탬프를 구함 
	$today=time(); //현재의 유닉스타임스탬프를 구함 
	$day=($today-$date)/60/60/24; //몇일이지났는가를 계산
	$day=ceil($day);

	$list[$i]['left']['idx'] = $co['co_left'];
	$list[$i]['left']['name'] = $ch_left['ch_name'];
	$list[$i]['left']['thumb'] = $ch_left['ch_thumb'];

	$list[$i]['right']['idx'] = $co['co_right'];
	$list[$i]['right']['name'] = $ch_right['ch_name'];
	$list[$i]['right']['thumb'] = $ch_right['ch_thumb'];

	$list[$i]['dday'] = $day;
}


$g5['title'] = "커플";
include_once('./_head.php');

if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/couple/list.skin.php")) {
	include(G5_THEME_PATH."/couple/list.skin.php");
} else {
	include(G5_PATH."/couple/skin/list.skin.php");
}

include_once(G5_PATH.'/tail.php');
?>
