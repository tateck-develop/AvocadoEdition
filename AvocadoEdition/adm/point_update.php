<?php
$sub_menu = "500900";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$mb_id = $_POST['mb_id'];
$po_point = $_POST['po_point'];
$po_content = $_POST['po_content'];
$expire = preg_replace('/[^0-9]/', '', $_POST['po_expire_term']);


if($take_type == 'A') {
	// 전체지급
	$sql_common = " from {$g5['member_table']} ";
	$sql_search = " where mb_level > 1 ";
	$sql = " select * {$sql_common} {$sql_search} ";
	$result = sql_query($sql);

	for($i=0; $mb = sql_fetch_array($result); $i++) { 
		if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point']))
		alert('소지금를 깎는 경우 현재 소지금보다 작으면 안됩니다.', './point_list.php?'.$qstr);

		insert_point($mb['mb_id'], $po_point, $po_content, '@passive', $mb['mb_id'], $member['mb_id'].'-'.uniqid(''), $expire);
	}
} else {
	// 개별지급
	if(!$mb_id && $mb_name) {
		$mb = sql_fetch("select * from {$g5['member_table']} where mb_name = '{$mb_name}'");
		$mb_id = $mb['mb_id'];
	} else {
		$mb = get_member($mb_id);
	}

	if (!$mb['mb_id'])
		alert('존재하는 회원이 아닙니다.');

	if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point']))
		alert('소지금를 깎는 경우 현재 소지금보다 작으면 안됩니다.', './point_list.php?'.$qstr);

	insert_point($mb['mb_id'], $po_point, $po_content, '@passive', $mb['mb_id'], $member['mb_id'].'-'.uniqid(''), $expire);
}



goto_url('./point_list.php?'.$qstr);
?>
