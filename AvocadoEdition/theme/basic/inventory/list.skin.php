<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>


<ul class="inventory-list">
<? 
for($i=0; $i < count($inven_list); $i++) { ?>
	<li class="box-line bak">
<? if($inven_list[$i]['in_id']){ ?>
		<a href="#<?=$inven_list[$i]['in_id']?>" class="inven-open-popup" data-idx="<?=$inven_list[$i]['in_id']?>" data-type="">
			<img src="<?=$inven_list[$i]['it_img']?>" />
		<? if($inven_list[$i]['cnt'] > 1) { ?>
			<i class="count"><?=$inven_list[$i]['cnt']?></i>
		<? } ?>
		<? if($inven_list[$i]['se_ch_id'] != '') { ?>
			<i class="present"></i>
		<? } ?>
		</a>
<? } ?>
	</li>
<? } 

if($i == 0) { 
?>
	<li class="no-data">
		보유중인 아이템이 없습니다.
	</li>
<? } ?>
</ul>
