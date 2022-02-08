<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_status($ch_id, $st_id) { 
	global $g5;

	$result = array();
	$sc = sql_fetch("select sc_value, sc_max from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$st_id}'");
	$sl = sql_fetch("select st_id, st_use_max, st_max, st_min from {$g5['status_config_table']} where st_id = '{$st_id}'");
	
	$result['config_max'] = $sl['st_use_max'] ? true : false;
	$result['max'] = (int)$sl['st_max'];
	$result['min'] = (int)$sl['st_min'];
	$result['drop'] = (int)$sc['sc_value'];
	$result['now'] = $sc['sc_max'] - $sc['sc_value'];
	$result['has'] = (int)$sc['sc_max'];

	return $result;
}
function get_status_by_name($ch_id, $st_name) { 
	global $g5;

	$result = array();

	$sl = sql_fetch("select st_id, st_use_max, st_max from {$g5['status_config_table']} where st_name = '{$st_name}'");
	$sc = sql_fetch("select sc_value, sc_max from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$sl['st_id']}'");

	if($sl['st_use_max']) {
		// 최대값 기준으로 출력 시, 스탯 설정에서 등록한 최대값을 MAX 값으로 둔다
		$result['max'] = $sl['st_max'];
	} else {
		$result['max'] = $sl['sc_max'];
	}
	
	$result['drop'] = $sc['sc_value'];
	$result['now'] = $sc['sc_max'] - $sc['sc_value'];
	$result['has'] = $sc['sc_max'];

	return $result;
}

// 사용한 포인트
function get_use_status($ch_id) { 
	global $g5;

	$sc = sql_fetch("select SUM(sc_max) as total from {$g5['status_table']} where ch_id = '{$ch_id}'");
	$result = $sc['total'];

	return $result;
}

// 미분배 포인트
function get_space_status($ch_id) { 
	global $g5, $config;

	$ch = get_character($ch_id);
	$use_point = get_use_status($ch_id);


	if(!$ch['ch_point']) $ch['ch_point'] = $config['cf_status_point'];

	$result = $ch['ch_point'] - $use_point;

	return $result;
}

//스탯 변동 적용
function set_status($ch_id, $st_id, $hunt, $msg='') { 
	global $g5; 

	$result = array(); 
	
	$sl = sql_fetch("select st_id from {$g5['status_config_table']} where st_id = '{$st_id}'");
	$sc = sql_fetch("select sc_id, sc_value, sc_max from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$sl['st_id']}'");

	$sc['sc_value'] = $sc['sc_value'] + $hunt; 

	$message = ""; 

	if($sc['sc_value'] >= $sc['sc_max']) { 
		$message = $msg; 
		$sc['sc_value'] = $sc['sc_max']; 
	} else if($sc['sc_value'] < 0) { 
		$sc['sc_value'] = 0; 
	} 
	sql_query(" update {$g5['status_table']} set sc_value = '{$sc['sc_value']}' where sc_id = '{$sc['sc_id']}'"); 

	return $message; 

}
function set_status_by_name($ch_id, $st_name, $hunt, $msg='') { 
	global $g5; 

	$result = array(); 
	
	$sl = sql_fetch("select st_id from {$g5['status_config_table']} where st_name = '{$st_name}'");
	$sc = sql_fetch("select sc_id, sc_value, sc_max from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$sl['st_id']}'");

	$sc['sc_value'] = $sc['sc_value'] + $hunt; 

	$message = ""; 

	if($sc['sc_value'] >= $sc['sc_max']) { 
		$message = $msg; 
		$sc['sc_value'] = $sc['sc_max']; 
	} else if($sc['sc_value'] < 0) { 
		$sc['sc_value'] = 0; 
	} 
	sql_query(" update {$g5['status_table']} set sc_value = '{$sc['sc_value']}' where sc_id = '{$sc['sc_id']}'"); 

	return $message; 
} 
?>