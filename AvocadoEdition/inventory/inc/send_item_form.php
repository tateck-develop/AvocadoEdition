<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<div class="info">
	<div class="ui-thumb">
		<img src="<?=$in['it_img']?>" />
	</div>
</div>
<div class="text">
	<p class="title">
		<?=$in['it_name']?>
		<span><?=number_format($in['it_sell'])?><?=$config['cf_money_pice']?></span>
	</p>
</div>
<form action="<?=G5_URL?>/inventory/inventory_update.php" method="post">
	<input type="hidden" name="in_id" value="<?=$in['in_id']?>" />
	<input type="hidden" name="ch_id" value="<?=$ch['ch_id']?>" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<div class="send-item-form">
		<div class="item-input">

			<input type="hidden" name="re_ch_id" id="send_re_ch_id" value="" />
			<input type="text" name="re_ch_name" value="" id="send_re_ch_name" onkeyup="get_ajax_character(this, 'send_character_list', 'send_re_ch_id', 'user');" placeholder="받는 사람 이름 검색"></input>
			<div id="send_character_list" class="ajax-list-box"><div class="list"></div></div>

		</div>
		<div class="item-input">
			<input type="text" name="in_memo" placeholder="전달 메세지" />
		</div>

	</div>
	<div class="control-box">
		<button type="submit" class="ui-btn simple">보내기</button>
	</div>
</form>