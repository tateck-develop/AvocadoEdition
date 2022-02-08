<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


/*******************************************
	 경험치 부분 
********************************************/
// 경험치 부여
function insert_exp($ch_id, $exp, $content='', $rel_action='')
{
	global $config;
	global $g5;
	global $is_admin;

	if ($exp == 0) { return 0; }
	if ($ch_id == '') { return 0; }
	$ch = get_character($ch_id);
	if (!$ch['ch_id']) { return 0; }

	// 캐릭터 경험치
	$ch_exp = get_exp_sum($ch_id);

	// 경험치 건별 생성
	$ex_ch_exp = $ch_exp + $exp;

	$sql = " insert into {$g5['exp_table']}
				set ch_id = '$ch_id',
					ch_name = '{$ch['ch_name']}',
					ex_datetime = '".G5_TIME_YMDHIS."',
					ex_content = '".addslashes($content)."',
					ex_point = '$exp',
					ex_ch_exp = '$ex_ch_exp',
					ex_rel_action = '$rel_action' ";
	sql_query($sql);
	
	// 경험치 UPDATE
	$sql = " update {$g5['character_table']} set ch_exp = '$ex_ch_exp' where ch_id = '$ch_id' ";
	sql_query($sql);
	
	$rank_info = get_rank_exp($ex_ch_exp, $ch_id);
	
	// 기존 랭크에서 변동이 있을 경우에만 실행
	if($ch['ch_rank'] != $rank_info['rank']) { 

		$state_point = $ch['ch_point'] + $rank_info['add_point'];
		// 스텟 포인트 변동 사항 및 랭크 변동사항 저장
		$rank_up_sql = " update {$g5['character_table']} set ch_rank = '{$rank_info['rank']}', ch_point = '{$state_point}' where ch_id = '$ch_id' ";
		sql_query($rank_up_sql); 
	}

	return 1;
}

// 경험치 내역 합계
function get_exp_sum($ch_id)
{
	global $g5, $config;

	// 포인트합
	$sql = " select sum(ex_point) as sum_ex_point
				from {$g5['exp_table']}
				where ch_id = '$ch_id' ";
	$row = sql_fetch($sql);

	return $row['sum_ex_point'];
}

?>