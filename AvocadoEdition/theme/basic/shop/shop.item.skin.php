<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<?
if($item['sh_id']) { 
	// 상품 진열 정보가 있을 경우
?>
<div class="type-item theme-box">
	<div id="item_talk">
		<div id="item_simple_viewer">
			<div id="buy_item_data">
				<div class="item-thumb">
					<img src="<?=$item['it_img']?>" />
				</div>
				<div class="item-name"><?=$item['it_name']?> <sup><?=$money?></sup></div>
				<div class="item-content"><?=$item['it_content']?></div>
			</div>
		</div>
		<div class="item_talk"><?=$item['sh_content']?></div>
		<br />
	</div>

	<? if($character['ch_id'] && $character['ch_state'] == '승인') { ?>
		<a href="javascript:fn_buy_item('<?=$item['sh_id']?>');" id="btn_buy" class="ui-btn full point">
			구매하기
		</a>
	<? } ?>
</div>
<? } else {
	// 상품 진열 정보가 없을 경우
?>
	<div id="default_talk">
		<p>
			오류가 발생했습니다. 다시 한번 선택해 주시길 바랍니다.
		</p>
	</div>
<? } ?>