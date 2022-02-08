<?php
$sub_menu = "400500";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

if(!$co_left && $ch_name_left) {
	$ch = sql_fetch("select ch_id, ch_name, ch_exp from {$g5['character_table']} where ch_name = '{$ch_name_left}'");
	$co_left = $ch['ch_id'];

	if(!$co_left) alert("존재하지 않는 캐릭터 입니다.");
}
if(!$co_right && $ch_name_right) {
	$ch = sql_fetch("select ch_id, ch_name, ch_exp from {$g5['character_table']} where ch_name = '{$ch_name_right}'");
	$co_right = $ch['ch_id'];

	if(!$co_right) alert("존재하지 않는 캐릭터 입니다.");
}

$sql_common = " co_left            = '{$_POST['co_left']}',
				co_right            = '{$_POST['co_right']}',
				co_order            = '{$_POST['co_order']}',
				co_date			= '{$_POST['co_date']}' ";

$sql = " insert into {$g5['couple_table']}
		set $sql_common ";
sql_query($sql);

goto_url('./couple_list.php?'.$qstr);
?>
