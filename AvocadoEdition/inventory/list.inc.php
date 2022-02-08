<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
$inven_list = array();
$p_count = 0;

// 개인 아이템 - 선물
$pe_inven_sql = "select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.ch_id = '$ch_id' and item.it_id = inven.it_id and inven.se_ch_id != '' order by inven.it_id asc";
$pe_inven_result = sql_query($pe_inven_sql);
for($i=0; $row=sql_fetch_array($pe_inven_result); $i++) {
	$inven_list[$p_count] = $row;
	$p_count++;
}

// 개인 아이템 - 비선물
$pe_inven_sql = "select *, count(*) as cnt from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.ch_id = '$ch_id' and item.it_id = inven.it_id and inven.se_ch_id = '' group by inven.it_id order by inven.it_id asc";
$pe_inven_result = sql_query($pe_inven_sql);
for($i; $row=sql_fetch_array($pe_inven_result); $i++) {
	$inven_list[$p_count] = $row;
	$p_count++;
}
$i = 0;



if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/inventory/list.skin.php")) {
	include(G5_THEME_PATH."/inventory/list.skin.php");
} else {
	include(G5_PATH."/inventory/skin/list.skin.php");
}

?>
