<?php
$sub_menu = "600200";
include_once('./_common.php');

if ($w == "u" || $w == "d")
	check_demo();

if ($w == 'd')
	auth_check($auth[$sub_menu], "d");
else
	auth_check($auth[$sub_menu], "w");

check_admin_token();

$sql_common = " ra_title			= '{$ra_title}',
				bo_table			= '{$bo_table}',
				ra_progress_title	= '{$ra_progress_title}',
				ra_text				= '{$ra_text}',
				ra_img				= '{$ra_img}',
				ra_use				= '{$ra_use}',
				ra_progress			= '{$ra_progress}',
				ra_progress_max		= '{$ra_progress_max}',
				ra_progress_p		= '{$ra_progress_p}',
				ra_progress_m		= '{$ra_progress_m}',
				ra_limit			= '{$ra_limit}',
				ra_limit_day		= '{$ra_limit_day}',
				ra_skin				= '{$ra_skin}'";

if ($w == "") {
	$sql = " insert {$g5['random_dice_table']}
				set $sql_common ";
	sql_query($sql);
}
else if ($w == "u") {
	$ra = sql_fetch("select * from {$g5['random_dice_table']} where ra_id = '{$ra_id}'");
	if(!$ra['ra_id']) {
		alert("랜덤다이스 정보가 존재하지 않습니다.");
	}
	$sql = " update {$g5['random_dice_table']}
				set $sql_common
			  where ra_id = '$ra_id' ";
	sql_query($sql);
}

if($ra_id) { 
	goto_url("./random_form.php?w=u&ra_id={$ra_id}");
} else { 
	goto_url("./random_list.php");
}

?>
