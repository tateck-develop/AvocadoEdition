<?php
$sub_menu = "600300";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

for($i=0; $i < count($index); $i++) { 

	$k = $index[$i];

	$start_code = $mf_start;
	$end_code = $mf_end[$k];
	$money = $mf_money[$k];
	$use = $mf_use[$k];

	$temp = sql_fetch("select * from {$g5['map_move_table']} where mf_start = '{$start_code}' and mf_end = '{$end_code}'");

	if($temp['mf_id']) { 
		// 수정모드
		$sql = " update {$g5['map_move_table']}
                 set mf_use = '{$use}' 
				where mf_id = '{$temp['mf_id']}'";

		sql_query($sql);
		$mf_id = $temp['mf_id'];
		
	} else { 
		// 입력모드
		$sql = " insert {$g5['map_move_table']}
                 set mf_start = '{$start_code}',
                     mf_end = '{$end_code}',
                     mf_use = '{$use}' ";
		sql_query($sql);
	}
}

goto_url('./map_move_list.php?ma_id='.$mf_start, false);
?>