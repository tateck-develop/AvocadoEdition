<?php
include_once('./_common.php');

$in = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id");
$ch = get_character($in['ch_id']);

$is_mine = $ch['mb_id'] == $character['mb_id'] ? true : false;

if(!$in['in_id']) { 
	echo "<p>아이템 보유 정보를 확인할 수 없습니다.</p>";
} else {

	if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/inventory/item.skin.php")) {
		include(G5_THEME_PATH."/inventory/item.skin.php");
	} else {
		include(G5_PATH."/inventory/skin/item.skin.php");
	}

} ?>