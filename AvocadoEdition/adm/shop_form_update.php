<?php
$sub_menu = "500100";
include_once('./_common.php');

if ($w == 'u') check_demo();
auth_check($auth[$sub_menu], 'w');
check_token();

// 요일 데이터 저장
if(count($sh_week) > 0) { 
	$sh_week = implode("||", $sh_week);
	$sh_week = "||".$sh_week."||";
}

// 소속 제한 설정 저장
if(count($sh_side) > 0) {
	$sh_side = implode("||", $sh_side);
	$sh_side = "||".$sh_side."||";
}
// 종족 제한 설정 저장
if(count($sh_class) > 0) {
	$sh_class = implode("||", $sh_class);
	$sh_class = "||".$sh_class."||";
}
// 랭킹 제한 설정 저장
if(count($sh_rank) > 0) {
	$sh_rank = implode("||", $sh_rank);
	$sh_rank = "||".$sh_rank."||";
}

// 진열 아이템 유효성 여부 체크
if(!$it_id && $it_name) {
	$it = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$it_name}'");
	$it_id = $it['it_id'];
	if(!$it['it_id']) {
		alert("진열 아이템으로 등록되는 아이템의 정보가 없습니다.");
	}
}

// 교환 아이템 유효성 여부 체크
if(!$sh_has_item && $sh_has_item_name) {
	$has_item = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$sh_has_item_name}'");
	$sh_has_item = $has_item['it_id'];
	if(!$has_item['it_id']) {
		alert("교환 아이템으로 등록되는 아이템의 정보가 없습니다.");
	}
}
if(!$sh_has_item_name) { $sh_has_item = 0; }


// 교환 타이틀 유효성 여부 체크
if(!$sh_has_title && $sh_has_title_name) {
	$has_title = sql_fetch("select ti_id from {$g5['item_table']} where ti_title = '{$sh_has_title_name}'");
	$sh_has_title = $has_title['ti_id'];
	if(!$has_title['ti_id']) {
		alert("교환 타이틀로 등록되는 타이틀의 정보가 없습니다.");
	}
}
if(!$sh_has_title_name) { $sh_has_title = 0; }

$sql_common = "
	it_id				= '{$it_id}',
	ca_name				= '{$ca_name}',
	sh_limit			= '{$sh_limit}',
	sh_qty				= '{$sh_qty}',
	sh_money			= '{$sh_money}',
	sh_use_money		= '{$sh_use_money}',
	sh_exp				= '{$sh_exp}',
	sh_use_exp			= '{$sh_use_exp}',
	sh_content			= '{$sh_content}',
	sh_side				= '{$sh_side}',
	sh_use_side			= '{$sh_use_side}',
	sh_class			= '{$sh_class}',
	sh_use_class		= '{$sh_use_class}',
	sh_rank				= '{$sh_rank}',
	sh_use_rank			= '{$sh_use_rank}',
	sh_has_item			= '{$sh_has_item}',
	sh_use_has_item		= '{$sh_use_has_item}',
	sh_has_title		= '{$sh_has_title}',
	sh_use_has_title	= '{$sh_use_has_title}',
	sh_use				= '{$sh_use}',
	sh_date_s			= '{$sh_date_s}',
	sh_date_e			= '{$sh_date_e}',
	sh_time_s			= '{$sh_time_s}',
	sh_time_e			= '{$sh_time_e}',
	sh_week				= '{$sh_week}',
	sh_order			= '{$sh_order}'
";


if($w == '') { 
	$sql = " insert into {$g5['shop_table']}
				set {$sql_common}";
	sql_query($sql);
} else {
	$sh = sql_fetch("select sh_id from {$g5['shop_table']} where sh_id = '{$sh_id}'");

	if(!$sh['sh_id']) {
		alert("상품 진열 정보가 존재하지 않습니다.");
	}

	$sql = " update {$g5['shop_table']}
				set {$sql_common}
				where sh_id = '{$sh_id}'";
	sql_query($sql);
}

goto_url('./shop_list.php?'.$qstr, false);
?>
