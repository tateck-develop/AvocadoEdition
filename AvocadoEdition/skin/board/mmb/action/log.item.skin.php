<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 아이템 ID / 이름 / 기능 / 값 / 내용 / 효능
?>

<? if($item_log[0] == 'D') { 
	// 일반 템 사용
	IF($item_log[1]) { 
?>
<div class="log-item-box data-item">
	<em>
		<img src="<?=get_item_img($item_log[1])?>" />
	</em>
	<p>
		<span><strong><?=$item_log[2]?></strong><?=j($item_log[2], '을')?> 사용했습니다! (<?=$item_log[6]?>)</span>
	</p>
</div>
<? } } else if($item_log[0] == 'S') { 
	// 뽑기 획득에 성공
?>
<div class="log-item-box data-item">
	<em>
		<img src="<?=get_item_img($item_log[3])?>" />
	</em>
	<p>
		<span><strong><?=$item_log[2]?></strong><?=j($item_log[2], '을')?> 사용해서 <strong><?=$item_log[4]?></strong><?=j($item_log[4], '을')?> 획득하였습니다!</span>
	</p>
</div>

<? } else { 
	// 뽑기 획득에 실패
?>
<div class="log-item-box data-item">
	<em></em>
	<p>
		<span><strong><?=$item_log[2]?></strong><?=j($item_log[2], '을')?> 사용했지만 <strong>아무것도 획득하지 못했습니다</strong>...</span>
	</p>
</div>

<? } ?>
