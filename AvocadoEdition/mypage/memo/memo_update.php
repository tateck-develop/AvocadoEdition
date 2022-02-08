<?php
include_once('./_common.php');

if($re_mb_id) {
	$re_mb = get_member($re_mb_id);
}
if(!$re_mb['mb_id'] && $re_mb_name) { 
	$re_mb = sql_fetch("select mb_id from {$g5['member_table']} where mb_name = '{$re_mb_name}'");
	$re_mb_id = $re_mb['mb_id'];
}

if($re_mb['mb_id']) { 
	send_memo($member['mb_id'], $re_mb_id, $me_memo);
	goto_url('./memo_view.php?re_mb_id='.$re_mb_id);
} else {
	alert('상대방을 확인할 수 없습니다.');
}
?>
