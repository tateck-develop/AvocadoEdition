<?php
include_once('./_common.php');

$re_mb = get_member($re_mb_id);
if(!$re_mb['mb_id']) { return; }
$re_ch = get_character($re_mb['ch_id']);

$sql = "select *
		from	{$g5['memo_table']}
		where	((me_recv_mb_id = '{$re_mb['mb_id']}' and me_send_mb_id = '{$member['mb_id']}')
			OR	(me_send_mb_id = '{$re_mb['mb_id']}' and me_recv_mb_id = '{$member['mb_id']}'))
			AND me_id > '{$me_id}'
		ORDER BY me_id asc ";
$result = sql_query($sql);
$total = sql_num_rows($result);

$last_me_id = 0;
if($total > 0 ) { 
	$sql = " update {$g5['member_table']}
				set mb_memo_call = ''
				where	mb_id = '{$member['mb_id']}'
					and mb_name = '{$re_ch['mb_name']}";
	sql_query($sql);

	for($i = 0; $me = sql_fetch_array($result); $i++) {
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

			$sql = " update {$g5['memo_table']}
						set me_read_datetime = '".G5_TIME_YMDHIS."'
						where me_send_mb_id = '{$re_mb['mb_id']}'
						and me_recv_mb_id = '{$member['mb_id']}'
						and me_read_datetime = '0000-00-00 00:00:00' ";
			sql_query($sql);
		}
		$last_me_id = $last_me_id > $me['me_id'] ? $last_me_id : $me['me_id'];
		// 템플릿 불러오기
		include('../memo_view.skin.php');
	}
	?>
	<i id="last_idx" style="display: none;"><?=$last_me_id ?></i>
	<i id="last_count" style="display: none;"><?=$i?></i>
<? } ?>