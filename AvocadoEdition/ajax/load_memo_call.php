<?php
include_once('./_common.php');
if($member['mb_memo_call']) {
	$re_mb_id = sql_fetch("select mb_id from {$g5['member_table']} where mb_name = '{$member['mb_memo_call']}'");
	$re_mb_id = $re_mb_id['mb_id'];

	$link = G5_URL."/mypage/memo/";
	if($re_mb_id) { 
		$link .= "memo_view.php?re_mb_id={$re_mb_id}";
	}
?>
<div class="ui-memo-alram-box theme-box none-trans">
	<div class="ui-alram-popup">
		<div class="alram-content">
			<p>
				<strong><?=$member['mb_memo_call']."</strong>님으로부터 쪽지가 도착하였습니다."?>
			</p>
			<a href="<?=$link?>" class="ui-btn">쪽지함 바로가기</a>
			<a href="#" onclick="close_memo(); return false;" class="ui-btn">닫기</a>
		</div>
	</div>
</div>

<script>
	var memo_message = "<?=$member['mb_memo_call']?>님으로부터 쪽지가 도착하였습니다.";
	var memo_options = {
		body: memo_message,
		icon: "<?=G5_IMG_URL?>/notify_icon.png"
	}
	function notify_memo_call() {
		if (("Notification" in window)) {
			if(Notification.permission === "granted") {
				var notification = new Notification("<?=$config['cf_title']?>", memo_options);
				notification.onclick = function(event) {
					location.href="<?=$link?>";
				};
			} else if (Notification.permission !== 'denied') {

				Notification.requestPermission(function (permission) {
					if (permission === "granted") {
						var notification = new Notification("<?=$config['cf_title']?>", memo_options);
					}
				});
				Notification.onclick = function(event) {
					location.href="<?=$link?>";
				};
			}
		}
	}

	notify_memo_call();

</script>

<? if(!G5_IS_MOBILE) { ?>
	<!--audio autoplay>
		<source src="<?=G5_URL?>/ajax/memo_call.MP3" type="audio/mpeg">
	</audio-->
<? } }?>