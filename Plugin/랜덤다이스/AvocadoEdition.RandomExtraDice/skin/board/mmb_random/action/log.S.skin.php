<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 1. S : 탐색 (성공여부, 획득아이템 ID, 획득아이템이름, 인벤 ID)
?>

<div class="log-item-box data-S">
	
	<? if($data_log[1] == 'S') { ?>
		<em>
			<img src="<?=get_item_img($data_log[2])?>" />
		</em>
		<p>
			<span>탐색하여 <strong><?=$data_log[3]?></strong><?=j($data_log[3], '을')?> 획득했습니다!</span>
		</p>
	<? } else { ?>
		<em></em>
		<p>
			탐색했지만 아무것도 얻지 못했습니다.
		</p>
	<? } ?>
</div>