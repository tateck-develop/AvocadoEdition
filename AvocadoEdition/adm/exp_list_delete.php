<?php
$sub_menu = '400410';
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'd');
check_token();

$count = count($_POST['chk']);
if(!$count)
	alert($_POST['act_button'].' 하실 항목을 하나 이상 체크하세요.');

for ($i=0; $i<$count; $i++)
{
	// 실제 번호를 넘김
	$k = $_POST['chk'][$i];
	$ch_id = $_POST['ch_id'][$k];
	$ch = sql_fetch("select ch_id, ch_name, ch_exp, ch_rank, ch_point from {$g5['character_table']} where ch_id = '{$ch_id}'");

	// 포인트 내역정보
	$sql = " select * from {$g5['exp_table']} where ex_id = '{$_POST['ex_id'][$k]}' ";
	$row = sql_fetch($sql);

	if(!$row['ex_id'])
		continue;

	// 포인트 내역삭제
	$sql = " delete from {$g5['exp_table']} where ex_id = '{$_POST['ex_id'][$k]}' ";
	sql_query($sql);

	// ex_ch_exp에 반영
	$sql = " update {$g5['exp_table']}
				set ex_ch_exp = ex_ch_exp - '{$row['ex_point']}'
				where ch_id = '{$ch_id}'
				  and ex_id > '{$_POST['ex_id'][$k]}' ";
	sql_query($sql);

	// 포인트 UPDATE
	$sum_point = get_exp_sum($ch_id);
	$sql= " update {$g5['character_table']} set ch_exp = '$sum_point' where ch_id = '{$ch_id}' ";
	sql_query($sql);

	$rank_info = get_rank_exp($sum_point, $ch_id);
	// 기존 랭크에서 변동이 있을 경우에만 실행
	if($ch['ch_rank'] != $rank_info['rank']) { 
		$state_point = $ch['ch_point'] + $rank_info['add_point'];
		// 스텟 포인트 변동 사항 및 랭크 변동사항 저장
		$rank_up_sql = " update {$g5['character_table']} set ch_rank = '{$rank_info['rank']}', ch_point = '{$state_point}' where ch_id = '$ch_id' ";
		sql_query($rank_up_sql); 
	}
}

goto_url('./exp_list.php?'.$qstr);
?>