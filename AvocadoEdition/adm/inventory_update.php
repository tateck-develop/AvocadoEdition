<?php
$sub_menu = "500300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

check_token();

if(!$it_id && $it_name) {
	$it = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$it_name}'");
	if($it['it_id'] == 0) {
		alert("해당 아이템의 정보가 없습니다.");
	}
	$it_id = $it['it_id'];
}

if($take_type == 'A') {
	// 전체지급
	$sql_common = " from {$g5['character_table']} ";
	$sql_search = " where ch_state = '승인' ";
	$sql = " select ch_id, ch_name {$sql_common} {$sql_search} ";
	$result = sql_query($sql);

	for($i=0; $ch = sql_fetch_array($result); $i++) { 
		$sql = " insert into {$g5['inventory_table']}
					set ch_id = '{$ch['ch_id']}',
						it_id = '{$it_id}',
						it_name = '{$it_name}',
						ch_name = '{$ch['ch_name']}'";
		sql_query($sql);
	}
} else {
	// 개별지급
	if(!$ch_id && $ch_name) {
		$ch = sql_fetch("select ch_id, ch_name from {$g5['character_table']} where ch_name = '{$ch_name}'");
		$ch_id = $ch['ch_id'];
	} else {
		$ch = sql_fetch("select ch_id, ch_name from {$g5['character_table']} where ch_id = '{$ch_id}'");
	}

	if (!$ch['ch_id'])
		alert('존재하는 캐릭터가 아닙니다.');

	$sql = " insert into {$g5['inventory_table']}
				set ch_id = '{$ch['ch_id']}',
					it_id = '{$it_id}',
					it_name = '{$it_name}',
					ch_name = '{$ch['ch_name']}'";
	sql_query($sql);
}


goto_url('./inventory_list.php?'.$qstr);
?>
