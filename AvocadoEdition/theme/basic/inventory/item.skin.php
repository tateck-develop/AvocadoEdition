<?php
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
	<div class="item-content-box">
		<div class="default">
			<?=$in['it_content']?>
		</div>
	<? if($in['it_content2']) { ?>
		<div class="effect">
			<?=$in['it_content2']?>
		</div>
	<? }?>
	<? if($in['se_ch_name']) { ?>
		<div class="memo">
			<? if($in['in_memo']) { ?><p><?=$in['in_memo']?></p><? } ?>
			<p style="text-align: right;">By. <?=$in['se_ch_name']?></p>
		</div>
	<? }?>
	</div>
</div>
<div class="control-box">
<? if($is_mine) { ?>
	<ul>
		<? if($in['it_use_sell']) { ?>
			<li><a href="javascript:fn_inven_link_event('<?=$in['in_id']?>', 'sell');" data-idx="<?=$in['in_id']?>" data-type="sell" class="ui-style-btn">판매하기</a></li>
		<? }?>
		<? if($in['it_use_able']) { ?>
			<li><a href="javascript:fn_inven_link_event('<?=$in['in_id']?>', 'use');" data-idx="<?=$in['in_id']?>" data-type="use" class="ui-style-btn">사용하기</a></li>
		<? } ?>
		<? if(!$in['it_has']) { ?>
			<li><a href="javascript:fn_inven_link_event('<?=$in['in_id']?>', 'take');" data-idx="<?=$in['in_id']?>" data-type="take" class="ui-style-btn">선물하기</a></li>
		<? } ?>
	</ul>
<? } ?>
</div>