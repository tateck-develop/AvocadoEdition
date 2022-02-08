<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_rank_name ($rank) { 
	global $g5;

	$str = "";
	
	$result = sql_fetch("select lv_name from {$g5['level_table']} where lv_id = '{$rank}'");
	$str = $result['lv_name'];

	if(!$str) { 
		$str = '-';
	}

	return $str;
}


function get_rank_id($rank) { 
	global $g5;

	$str = "";
	
	$result = sql_fetch("select lv_id from {$g5['level_table']} where lv_name = '{$rank}'");
	$str = $result['lv_id'];

	return $str;
}

function get_rank_exp ($exp, $ch_id) {
	global $g5;
	
	$result = array();

	// 캐릭터의 현재 랭킹
	$ch = sql_fetch("select ch_rank from {$g5['character_table']} where ch_id = '{$ch_id}'");
	$ch_rank = sql_fetch("select * from {$g5['level_table']} where lv_id = '{$ch['ch_rank']}'");
	
	$level = sql_fetch("select * from {$g5['level_table']} where lv_exp <= {$exp} order by lv_exp desc limit 0, 1");
	$n_level = sql_fetch("select * from {$g5['level_table']} where lv_exp >= {$level['lv_exp']} order by lv_exp asc limit 0, 1");

	// 스탯 추가치 계산 -- 현재 기본적으로 적용 되어 있지 않음. 해당 부분 적용 시, 별개의 데이터 요구 필요

	if($ch_rank['lv_exp'] < $level['lv_exp']) { 
		// -- 캐릭터의 랭크가 업데이트 되는 랭크 보다 낮을때 (정상)
		$add_status = sql_fetch("select SUM(lv_add_state) as status from {$g5['level_table']} where lv_exp > '{$ch_rank['lv_exp']}' and lv_exp <= '{$level['lv_exp']}'");
		$add_status = $add_status['status'];

	} else if($ch_rank['lv_exp'] > $level['lv_exp']) { 
		// -- 캐릭터의 랭크가 업데이트 되는 랭크 보다 높을때 (하락, 획득한 스탯포인트 감소)
		$add_status = sql_fetch("select SUM(lv_add_state) as status from {$g5['level_table']} where lv_exp <= '{$ch_rank['lv_exp']}' and lv_exp > '{$level['lv_exp']}'");
		$add_status = $add_status['status'] * -1;
	}

		
	$result['rank'] = $level['lv_id'];
	$result['next_rank'] = $n_level['lv_id'];
	$result['add_point'] = $add_status;
	$result['rest_exp'] = ($n_level ? $n_level['lv_exp'] - $level['lv_exp'] : 0);

	return $result;
}


?>