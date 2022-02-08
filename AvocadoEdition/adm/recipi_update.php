<?php
$sub_menu = "500220";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


// 레시피 정보 등록
// - $re_item_order 를 큰 순서 대로 입력한다.

if(!$re_item1 && $re_item1_name) {
	$it = sql_fetch("select it_id, it_use_recepi from {$g5['item_table']} where it_name = '{$re_item1_name}'");
	if($it['it_use_recepi'] == 0) {
		alert("해당 아이템은 레시피 재료 기능이 설정되지 않은 아이템입니다.");
	}
	$re_item1 = $it['it_id'];
}
if(!$re_item2 && $re_item2_name) {
	$it = sql_fetch("select it_id, it_use_recepi from {$g5['item_table']} where it_name = '{$re_item2_name}'");
	if($it['it_use_recepi'] == 0) {
		alert("해당 아이템은 레시피 재료 기능이 설정되지 않은 아이템입니다.");
	}
	$re_item2 = $it['it_id'];
}
if(!$re_item3 && $re_item3_name) {
	$it = sql_fetch("select it_id, it_use_recepi from {$g5['item_table']} where it_name = '{$re_item3_name}'");
	if($it['it_use_recepi'] == 0) {
		alert("해당 아이템은 레시피 재료 기능이 설정되지 않은 아이템입니다.");
	}
	$re_item3 = $it['it_id'];
}


if(!$it_id && $it_name) {
	$it = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$it_name}'");
	$it_id = $it['it_id'];
}


$re_item[0] = $re_item1;
$re_item[1] = $re_item2;
$re_item[2] = $re_item3;
sort($re_item);

$re_item_order = implode("||", $re_item);

$re = sql_fetch("select count(*) as cnt from {$g5['recepi_table']} where re_item_order = '{$re_item_order}'");;

if($re['cnt'] > 0)
	alert('이미 등록된 레시피 조합 입니다.', './recipi_list.php?'.$qstr);

sql_query ("insert into {$g5['recepi_table']}
				set re_item_order	 ='{$re_item_order}',
					it_id = '{$it_id}',
					re_use = '{$re_use}'
		");

goto_url('./recipi_list.php?'.$qstr);

?>
