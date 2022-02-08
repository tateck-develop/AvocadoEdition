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
	<div>
		<p><?=$in['it_content']?></p>
	</div>
</div>
<form action="<?=G5_URL?>/inventory/item_form_update.php" method="post" name="frmItemAdd" enctype="multipart/form-data">
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="in_id" id="a_item_add_in_id" value="<?=$in['in_id']?>" />
	<input type="hidden" name="ch_id" id="a_item_add_ch_id" value="<?=$ch['ch_id']?>" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<div class="add-item-form">
		<div class="item-info">
			<input type="file" name="it_img" id="inven_it_img" class="required" required/>
		</div>
		<div class="item-input">
			<input type="text" name="it_name" class="frm_input required" placeholder="아이템 이름" required/>
		</div>
		<div class="item-input">
			<input type="text" name="it_content" class="frm_input required" placeholder="아이템 설명" required/>
		</div>
	</div>
	<div class="control-box">
		<button type="submit" class="ui-btn simple">등록하기</button>
	</div>
</form>