<?php
include_once('./_common.php');

if($member['mb_board_call']) {
	// 알람 내역을 가져온다
	$row = sql_fetch("select count(*) as cnt from {$g5['call_table']} where re_mb_id = '{$member['mb_id']}' and bc_check = '0'");
	$total_count = $row['cnt'];
	
?>

<div class="ui-call-alram-box theme-box none-trans">
	<div class="ui-alram-popup">
		<div class="alram-content">
			<p>
				<strong><?=$member['mb_board_call']?></strong>님이 호출하셨습니다. [ 확인하지 않은 호출 <span id="none_check_calling"><?=$total_count?></span>건 ]</strong>
			</p>
			<a href="<?=G5_URL?>/mypage/" onclick="move_call(this.href); return false;" class="ui-btn">호출내역확인</a>
			<a href="<?=$member['mb_board_link']?>" onclick="move_call(this.href); return false;" class="ui-btn">바로가기</a>
			<a href="#" onclick="close_call(); return false;" class="ui-btn">닫기</a>
		</div>
	</div>
</div>

<script>
	var call_message = "<?=$member['mb_board_call']?>님이 호출하셨습니다.\n[ 확인하지 않은 호출 <?=$total_count?>건 ]";
	var call_options = {
		body: call_message,
		icon: "<?=G5_IMG_URL?>/notify_icon.png"
	}
	function notify_board_call() {
		if (("Notification" in window)) {
			if(Notification.permission === "granted") {
				var notification = new Notification("<?=$config['cf_title']?>", call_options);
				notification.onclick = function(event) {
					move_call("<?=$member['mb_board_link']?>");
				};
			} else if (Notification.permission !== 'denied') {

				Notification.requestPermission(function (permission) {
					if (permission === "granted") {
						var notification = new Notification("<?=$config['cf_title']?>", call_options);
					}
				});
				Notification.onclick = function(event) {
					move_call("<?=$member['mb_board_link']?>");
				};
			}
		}
	}

	notify_board_call();

</script>

<? if(!G5_IS_MOBILE) { ?>
	<!--audio autoplay>
		<source src="<?=G5_URL?>/ajax/memo_call.MP3" type="audio/mpeg">
	</audio-->
<? } }?>

