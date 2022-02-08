<?php
include_once('./_common.php');
include_once('./_head.php');


$content = "";
// 탈퇴한 회원에게 쪽지 보낼 수 없음
if ($me_recv_mb_id)
{
	$mb = get_member($me_recv_mb_id);
	if (!$mb['mb_id'])
		alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.');

	if (!$mb['mb_open'] && $is_admin != 'super')
		alert_close('정보공개를 하지 않았습니다.');

	// 4.00.15
	$row = sql_fetch(" select me_memo from {$g5['memo_table']} where me_id = '{$me_id}' and (me_recv_mb_id = '{$member['mb_id']}' or me_send_mb_id = '{$member['mb_id']}') ");
	if ($row['me_memo'])
	{
		$content = "\n\n\n".' >'
						 ."\n".' >'
						 ."\n".' >'.str_replace("\n", "\n> ", get_text($row['me_memo'], 0))
						 ."\n".' >'
						 .' >';

	}
}

?>


<form name="fmemoform" action="./memo_update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
	<table class="theme-form">
		<colgroup>
			<col style="width: 100px;" />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<th>받는사람</th>
				<td>
					<input type="hidden" name="re_mb_id" id="re_mb_id" value="" />
					<input type="text" name="re_mb_name" value="" id="re_mb_name" onkeyup="get_ajax_member(this, 'member_list', 're_mb_id');" />
					<div id="member_list" class="ajax-list-box theme-box"><div class="list"></div></div>
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td>
					<textarea name="me_memo" id="me_memo" required class="required" rows="10"><?php echo $content ?></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="txt-center" style="padding: 20px 0;">
		<button type="submit" class="ui-btn point">전송</button>
	</div>

</form>


<?
include_once('./_tail.php');
?>
