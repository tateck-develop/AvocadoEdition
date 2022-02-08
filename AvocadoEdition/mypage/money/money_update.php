<?php
include_once('./_common.php');

$point = (int)$po_point;

if($point > 0) { 
	if($member['mb_point'] < $point) {
		alert("소지".$config['cf_money']." 보다 많은 ".$config['cf_money'].j($config['cf_money'], '은')." 보낼 수 없습니다.");
	}
	if(!$ch_id) {
		$re_ch = sql_fetch("select * from {$g5['character_table']} where ch_name = '{$ch_name}'");
	} else { 
		$re_ch = get_character($ch_id);
	}
	$recv_name = get_member_name($re_ch['mb_id']);

	if(!$recv_name) { 
		alert("상대를 확인할 수 없습니다.");
	}

	$recv_id = $re_ch['mb_id'];

	insert_point($recv_id, $point, "[받음] ".$member['mb_name'].'님 ('.$point.' '.$config['cf_money_pice'].' )', 'money', time(), '입금');
	insert_point($member['mb_id'], ($point * -1), "[보냄] ".$recv_name.'님 (-'.$point.' '.$config['cf_money_pice'].' )', 'money', time(), '출금');

	$memo_content = $member['mb_name']."님이 ".$point.$config['cf_money_pice']." 보냈습니다.";

	// 쪽지 보내기
	send_memo($member['mb_id'], $recv_id, $memo_content);

	alert($recv_name."님께 ".$point.$config['cf_money']." 보냈습니다.");
} else {
	alert("오류로 인해 보내지 못하였습니다.");
}

?>
