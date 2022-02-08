<?php
include_once('./_common.php');

if($url) { 
	$return_url = urldecode($url);
} else {
	$return_url = "./viewer.php?ch_id=".$ch_id;
}

$in = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id");
if(!$in['in_id']) { 
	echo "<p>아이템 보유 정보를 확인할 수 없습니다.</p>";
} else {
	$money = $in['it_sell'];
	insert_point($member['mb_id'], $money, '아이템 : '.$in['it_name'].' 판매보상 ( '.$money.$config['cf_money_pice'].' 획득 )', 'item', time(), '판매');
	delete_inventory($in['in_id']);
	echo "LOCATIONURL||||".$return_url;
} ?>