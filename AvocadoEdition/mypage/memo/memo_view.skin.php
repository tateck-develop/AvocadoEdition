<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<div class="message-item <?=$class?>">
	<div class="thumb">
	<? if($ch['ch_thumb']) {?>
		<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$ch['ch_id']?>">
			<img src="<?=$ch['ch_thumb']?>" />
		</a>
	<?} ?>
	</div>
	<div class="detail theme-box">
		<div class="info">
			<p class="name"><? if($ch['ch_name']) { ?>[<?=$ch['ch_name']?>] <? } ?><?=$mb['mb_name']?></p>
			<p class="date"><?=date('m-d H:i', strtotime($me['me_send_datetime']))?></p>
			<p class="check">
			<? if($me['me_read_datetime'] == '0000-00-00 00:00:00' && $mb['mb_id'] == $member['mb_id']) { ?>
				***
			<? } else { ?>
				읽음
			<? } ?>

			<? if($del){ ?>
				<a href="<?=$del?>" onclick="return confirm('정말 삭제하시겠습니까? 상대방의 우편함의 내용도 함께 삭제 됩니다.');" class="ui-btn ico del">삭제</a>
			<? } ?>
			</p>
		</div>
		<div class="text">
			<?=conv_content($me['me_memo'], 0)?>
		</div>
	</div>
</div>