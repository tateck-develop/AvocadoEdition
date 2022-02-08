<?php
include_once('./_common.php');

$sql = " select * from {$g5['memo_table']} where me_id = '{$me_id}' ";
$me = sql_fetch($sql);

if($me['me_send_mb_id'] != $member['mb_id'] && !$is_admin) { 
	alert('본인이 보낸 우편만 삭제 가능합니다.');
}

$call_name = get_member_name($row['me_send_mb_id']);

if ($me['me_read_datetime']=='0000-00-00 00:00:00') {
	$sql = " update {$g5['member_table']}
				set mb_memo_call = ''
				where mb_id = '{$me['me_recv_mb_id']}'
				and mb_memo_call = '{$call_name}' ";
	sql_query($sql);
}

$sql = " delete from {$g5['memo_table']}
			where me_id = '{$me_id}'
			and (me_recv_mb_id = '{$member['mb_id']}' or me_send_mb_id = '{$member['mb_id']}') ";
sql_query($sql);

goto_url('./memo_view.php?re_mb_id='.$me['me_recv_mb_id']);
?>
