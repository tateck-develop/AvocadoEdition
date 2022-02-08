<?php
include_once('./_common.php');
include_once('./_head.php');

$re_mb = get_member($re_mb_id);
if(!$re_mb['mb_id']) { $re_mb['mb_id'] = $re_mb_id; }
$re_ch = get_character($re_mb['ch_id']);

// 읽음 표시 설정
// -- 해당 멤버와 나눈 대화 전체 읽음 표시
$sql = " update {$g5['memo_table']}
			set me_read_datetime = '".G5_TIME_YMDHIS."'
			where me_send_mb_id = '{$re_mb['mb_id']}'
			and me_recv_mb_id = '{$member['mb_id']}'
			and me_read_datetime = '0000-00-00 00:00:00' ";
sql_query($sql);

// 대화 알람 제거
$sql = " update {$g5['member_table']}
			set mb_memo_call = ''
			where mb_id = '{$member['mb_id']}'";
sql_query($sql);


// 최근 대화내역 가져오기
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
?>


<div class="ui-list-control">
	<a href="javascript:location.reload();" class="ui-btn">REFRESH</a>
	<a href="./" class="ui-btn point">&nbsp;LIST&nbsp;</a>
</div>

<div class="ui-chatting-memo view">
<? if($total_page > 1) { ?>
	<a href="#" id="load_talk_prev" class="ui-btn small full etc">이전대화보기</a>
<? } ?>
	<div class="ui-chatting-list">
<? for($i=($max_count-1); $i >= 0; $i--) { 
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

	// 템플릿 불러오기
	include('./memo_view.skin.php');

} ?>
	</div>

	<form name="fmemoform" action="./memo_update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
		<input type="hidden" name="pop" value="<?=$pop?>" />
		<input type="hidden" name="re_mb_id" value="<?=$re_mb['mb_id']?>" />
		<div class="ui-memo-write">
			<div class="textarea">
				<textarea name="me_memo" id="me_memo" required class="required" tabindex="1"><?php echo $content ?></textarea>
			</div>
			<div class="win_btn">
				<button type="submit" class="ui-btn full point" tabindex="2">답장보내기</button>
			</div>
		</div>
	</form>
</div>

<hr class="padding" />
<hr class="padding" />


<script>
var paging = 1;
$('#me_memo').focus();
$('#load_talk_prev').on('click', function() {
	paging++;
	$.ajax({
		type: 'get'
		, async: true
		, url: "./ajax/ajax_prev_talk.php?re_mb_id=<?=$re_mb_id?>&page="+paging
		, beforeSend: function() {
			
		  }
		, success: function(data) {
			var response = data.trim();
			$('.ui-chatting-list').prepend(response);
			if(!response) {
				$('#load_talk_prev').remove();
			}
		}
		, error: function(data, status, err) {
			
		}
		, complete: function() { 
		}
	});
	return false;
});


$(function(){
	setInterval(function(){load_comment_list()},5000);
});

var last_cmcode = <?=$last_me_id?>;
function load_comment_list () {
	$.ajax({
		type: 'get'
		, async: true
		, url: "./ajax/ajax_latest_talk.php?re_mb_id=<?=$re_mb_id?>&me_id="+last_cmcode
		, beforeSend: function() {
		  }
		, success: function(data) {
			var response = data.trim();
			if(response) {
				$('.ui-chatting-list').append(response);
				var last_me_id = $('#last_idx').text();
				var last_count = $('#last_count').text();

				$('#last_idx').remove();
				$('#last_count').remove();
				last_cmcode = last_me_id;
				for(i=0; i < last_count; i++) { 
					$('.ui-chatting-list .ch-item').eq(i).remove();
				}
			}
		  }
		 , complete: function() { 
		}
	});
}
function fmemoform_submit(f)
{
	return true;
}
</script>

<?
include_once('./_tail.php');
?>
