<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($is_comment_write) {
	if($w == '') $w = 'c';
?>
<!-- 댓글 쓰기 시작 { -->
<aside class="bo_vc_w" id="bo_vc_w_<?=$list_item['wr_id']?>">
	<form name="fviewcomment" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $list_item[wr_id] ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">

	<input type="hidden" name="ch_id" value="<?=$character['ch_id']?>" />
	<input type="hidden" name="ti_id" value="<?=$character['ch_title']?>" />
	<input type="hidden" name="ma_id" value="<?=$character['ma_id']?>" />
	<input type="hidden" name="wr_subject" value="<?=$character['ch_name'] ? $character['ch_name'] : "GUEST"?>" />

	<div class="input-comment">
	<? if(count($mmb_item) > 0) { ?>
		<select name="use_item" class="full">
			<option value="">사용할 아이템 선택</option>
		<?	for($h=0; $h < count($mmb_item); $h++) { ?>
			<option value="<?=$mmb_item[$h]['in_id']?>">
				<?=$mmb_item[$h]['it_name']?>
			</option>
		<? } ?>
		</select>
	<? } ?>

		<textarea name="wr_content" required class="required" title="내용"></textarea>

		<div class="action-check form-input">
		<? if($character['ch_state']=='승인') { ?>
			<input type="radio" name="action" id="action_<?=$list_item['wr_id']?>_" value="" checked/>
			<label for="action_<?=$list_item['wr_id']?>_">일반행동&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<? if($is_able_search) { ?>
			<input type="radio" name="action" id="action_<?=$list_item['wr_id']?>_S" value="S" />
			<label for="action_<?=$list_item['wr_id']?>_S">탐색&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<? } ?>
		<? } ?>

		<?
		/******************************************************************************************
					RANDOM DICE 추가부분 
		******************************************************************************************/		
		if($random_message && count($random_message) > 0) { ?>
			<input type="radio" name="random_game" id="random_game_<?=$list_item['wr_id']?>_" value="" checked />
			<label for="random_game_<?=$list_item['wr_id']?>_">랜덤지령 미선택&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<?
			for($rand_index=0; $rand_index < count($random_message); $rand_index++) { 
				$ra = $random_message[$rand_index];
		?>
				<input type="radio" name="random_game" id="random_game_<?=$list_item['wr_id']?>_<?=$ra['id']?>" value="<?=$ra['id']?>" />
				<label for="random_game_<?=$list_item['wr_id']?>_<?=$ra['id']?>"><?=$ra['title']?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<? } 
		}
		/******************************************************************************************
					RANDOM DICE 추가부분 종료 
		******************************************************************************************/	
		?>


			<input type="checkbox" name="game" id="game_<?=$list_item['wr_id']?>" value="dice" />
			<label for="game_<?=$list_item[wr_id]?>">주사위</label>

		<? if($board['bo_use_noname'] && $is_member) { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="wr_noname" id="wr_noname_<?=$list_item['wr_id']?>" value="1" />
			<label for="wr_noname_<?=$list_item[wr_id]?>">익명</label>
		<? } ?>
		</div>

	</div>
	<div class="btn_confirm">
		<button type="submit" class="ui-comment-submit ui-btn">입력</button>
	</div>

	</form>
</aside>
<?
}
?>

