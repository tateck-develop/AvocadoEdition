<?php
$sub_menu = "400410";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'w');
check_token();

$ch_id = $_POST['ch_id'];
$ch_name = $_POST['ch_name'];
$ex_point = $_POST['ex_point'];
$ex_content = $_POST['ex_content'];

$action = '획득';
if($ex_point < 0) { 
	$action = '차감';
}

if($take_type == 'A') {
	// 전체지급
	$sql_common = " from {$g5['character_table']} ";
	$sql_search = " where ch_state = '승인' ";
	$sql = " select * {$sql_common} {$sql_search} ";
	$result = sql_query($sql);

	for($i=0; $ch = sql_fetch_array($result); $i++) { 
		if (($ex_point < 0) && ($ex_point * (-1) > $ch['ch_exp'])) continue;
		
		insert_exp($ch['ch_id'], $ex_point, $ex_content, $action);
	}

} else {
	// 개별지급
	if(!$ch_id && $ch_name) {
		$ch = sql_fetch("select ch_id, ch_name, ch_exp from {$g5['character_table']} where ch_name = '{$ch_name}'");
		$ch_id = $ch['ch_id'];
	} else {
		$ch = sql_fetch("select ch_id, ch_name, ch_exp from {$g5['character_table']} where ch_id = '{$ch_id}'");
	}

	if (!$ch['ch_id'])
		alert('존재하는 캐릭터가 아닙니다.');

	if (($ex_point < 0) && ($ex_point * (-1) > $ch['ch_exp']))
		alert('경험치를 차감하는 경우 현재 경험치보다 작으면 안됩니다.');

	insert_exp($ch['ch_id'], $ex_point, $ex_content, $action);
}

goto_url('./exp_list.php?'.$qstr);
?>
