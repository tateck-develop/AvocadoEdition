<?php
include_once('./_common.php');

$in = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id");
if(!$in['in_id']) { 
	echo "<p>아이템 보유 정보를 확인할 수 없습니다.</p>";
} else {
	if($in['ch_id'] == $character['ch_id']) {
		$ch = $character;
	} else {
		$ch = get_character($in['ch_id']);
	}
	
	include('./inc/send_item_form.php');
} ?>