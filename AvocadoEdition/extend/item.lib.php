<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_item ($it_id) 
{
	global $g5;
	$result = sql_fetch("select * from {$g5['item_table']} where it_id = '{$it_id}'");
	return $result;
}

function get_item_img($it_id) { 
	global $g5;
	$result = sql_fetch("select it_img from {$g5['item_table']} where it_id = '{$it_id}'");
	return $result['it_img'];
}

function get_item_detail_img($it_id) { 
	global $g5;
	$result = sql_fetch("select it_1 from {$g5['item_table']} where it_id = '{$it_id}'");
	return $result['it_1'];
}

function get_item_name($it_id) { 
	global $g5;
	$result = sql_fetch("select it_name from {$g5['item_table']} where it_id = '{$it_id}'");
	return $result['it_name'];
}
function get_inventory_item($in_id) {
	global $g5;
	//$result = sql_fetch("select inven.in_id, inven.ch_id, item.it_type, item.it_value, item.it_name from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id");
	$result = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id");

	return $result;
}

// 아이템 삭제
function delete_inventory($in_id, $is_del = 0) {
	global $g5;
	if($is_del == '0') {
		sql_query("delete from {$g5['inventory_table']} where in_id = '{$in_id}'");
	}
}

// 아이템 인벤토리 추가 기능
function insert_inventory($ch_id, $it_id, $item = null, $count = 1) {
	global $g5;

	if(!$item['it_id']) {
		$item = get_item($it_id);
	}
	$ch = get_character($ch_id);

	if($ch['ch_id']) {
		for($i=0; $i < $count; $i++) {
			$inven_sql = " insert into {$g5['inventory_table']}
					set ch_id = '{$ch['ch_id']}',
						it_id = '{$item['it_id']}',
						it_name = '{$item['it_name']}',
						ch_name = '{$ch['ch_name']}'";
			sql_query($inven_sql);
		}
	}
	return $count;
}

// 아이템 뽑기 함수
function get_item_explo($ch_id, $it_id) {
	global $g5;

	$seed = rand(0, 100);
	$result = array();

	// 템 검색 시작
	$item_result = sql_fetch("
		select re_it_id as it_id
			from {$g5['explorer_table']}
			where	it_id = '".$it_id."'
				and (ie_per_s <= '{$seed}' and ie_per_e >= '{$seed}')
			order by RAND()
			limit 0, 1
	");
	
	if($item_result['it_id']) {
		// 아이템 획득에 성공한 경우, 해당 아이템을 인벤토리에 삽입
		// 아이템 획득에 성공 시
		$item_result['it_name'] = get_item_name($item_result['it_id']);

		insert_inventory($ch_id, $item_result['it_id']);
		
		$result['it_id'] = $item_result['it_id'];
		$result['it_name'] = $item_result['it_name'];
	}

	return $result;
}
?>