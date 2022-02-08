<?php
include_once('./_common.php');

if($url) { 
	$return_url = urldecode($url);
} else {
	$return_url = "./viewer.php?ch_id=".$ch_id;
}

if(!$re_ch_id && $re_ch_name) {
	$re_ch = get_character_by_name($re_ch_name);
} else {
	$re_ch = get_character($re_ch_id);
}

if(!$re_ch['ch_id']) {
	alert("받는 사람의 정보를 확인할 수 없습니다.", $return_url);
}

if($ch_id == $character['ch_id']) {
	$se_ch = $character;
} else {
	$se_ch = get_character($ch_id);
}

$in = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id and inven.ch_id = '{$ch_id}'");
if(!$in['in_id']) { 
	alert("아이템 보유 정보를 확인할 수 없습니다.", $return_url);
}

if($in['in_id'] && $re_ch['ch_id']) { 
	$inven_sql = "update {$g5['inventory_table']}
					set ch_id = '{$re_ch['ch_id']}',
						ch_name = '{$re_ch['ch_name']}',
						se_ch_id = '{$se_ch['ch_id']}',
						se_ch_name = '{$se_ch['ch_name']}',
						re_ch_id = '{$re_ch['ch_id']}',
						re_ch_name = '{$re_ch['ch_name']}',
						in_memo = '{$in_memo}'
						{$add_sql}
					where in_id = '{$in_id}'";
	sql_query($inven_sql);

	$recv_mb_id   = $re_ch['mb_id'];
	$memo_content = "[ ".$se_ch['ch_name']."님이 보내신 《".$in['it_name']."》아이템이 도착 하였습니다. ] 캐릭터 인벤토리를 확인하세요.";

	// 쪽지 보내기
	send_memo($member['mb_id'], $recv_mb_id, $memo_content);

	alert($re_ch['ch_name'].'님께 선물이 배송되었습니다.',$return_url, FALSE);
}

alert('사용 및 적용이 실패하였습니다.',$return_url);
?>
