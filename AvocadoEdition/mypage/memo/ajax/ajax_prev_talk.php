<?php
include_once('./_common.php');

$re_mb = get_member($re_mb_id);
if(!$re_mb['mb_id']) { $re_mb['mb_id'] = $re_mb_id; }
$re_ch = get_character($re_mb['ch_id']);

$sql = "select *
		from	{$g5['memo_table']}
		where	(me_recv_mb_id = '{$re_mb['mb_id']}' and me_send_mb_id = '{$member['mb_id']}')
			OR	(me_send_mb_id = '{$re_mb['mb_id']}' and me_recv_mb_id = '{$member['mb_id']}')
		ORDER BY me_id desc ";
$result = sql_query($sql);
$total = sql_num_rows($result);
$page_rows = 5;

if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$total_page  = ceil($total / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$sql .= " limit {$from_record}, $page_rows ";
$result = sql_query($sql);
$max_count = sql_num_rows($result);

$last_me_id = 0;
$list = array();
for($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$last_me_id = $last_me_id > $row['me_id'] ? $last_me_id : $row['me_id'];
}

for($i=($max_count-1); $i >= 0; $i--) { 
	$me = $list[$i];

	if($me['me_send_mb_id'] == $member['mb_id']) { 
		$class = "me";
		$mb = $member;
		$ch = $character;
		$del= './memo_delete.php?me_id='.$me['me_id'];
	} else { 
		$class = "you";
		$mb = $re_mb;
		$ch = $re_ch;
		$del = '';
	}
	$last_me_id = $me['me_id'];

	// 템플릿 불러오기
	include('../memo_view.skin.php');
} ?>
