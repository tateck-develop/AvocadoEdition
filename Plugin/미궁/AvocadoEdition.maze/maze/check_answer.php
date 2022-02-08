<?php
include_once('./_common.php');

if(!$answer) { 
	echo "답을 입력해 주시길 바랍니다.";
	exit;
}

// 현재 미궁 정보 가져오기
if($member['mb_maze']) { 
	// 이전에 미궁을 진입한 기록이 있다면
	// 이전 미궁 정보를 가져 온다.
	$ma_id = $member['mb_maze'];
	$ma = sql_fetch("select * from {$g5['maze_table']} where ma_id = '{$ma_id}'");
} else {
	// 첫번재 미궁 IDX 정보를 가져온다
	// 멤버 정보 업데이트
	$ma = sql_fetch("select * from {$g5['maze_table']} order by ma_order asc limit 0, 1");
	$ma_id = $ma['ma_id'];
	sql_query("
		update {$g5['member_table']}
				set		mb_maze = '{$ma_id}'
			where		mb_id = '{$member['mb_id']}'
	");
}

if($ma['ma_answer'] == $answer) { 
	// 정답일 경우
	$result = sql_fetch("select ma_id from {$g5['maze_table']} where ma_order >= '{$ma['ma_order']}' and ma_id != '{$ma_id}' order by ma_order asc, ma_id asc limit 0, 1");
	$result = $result['ma_id'];
	sql_query("
		update {$g5['member_table']}
				set		mb_maze = '{$result}'
			where		mb_id = '{$member['mb_id']}'
	");
	echo "Y";
} else {
	// 오답일 경우
	echo "답이 아닙니다.";
}

?>
