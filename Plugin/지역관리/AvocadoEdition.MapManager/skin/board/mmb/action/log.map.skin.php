<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 1. S : 탐색 (성공여부, 획득아이템 ID, 획득아이템이름, 인벤 ID)

$me_data = sql_fetch("select * from {$g5['map_event_table']} where me_id = '{$data_log[3]}'");
$ma_data = sql_fetch("select * from {$g5['map_table']} where ma_id = '{$data_log[1]}'");
?>

<div class="log-data-box">

<? if($data_log[2] == 'F') { ?>
	<p>
		<?=$ma_data['ma_name']?> 구역으로 이동했다.
	</p>

<? } else { ?>

	<? if($me_data['me_img']) { ?>
	<div style="text-align: center;">
		<img src="<?=$me_data['me_img']?>" />
	</div>
	<? } ?>
	<p>
		<em class="title"><?=$me_data['me_title']?></em><br />
		<?=nl2br($me_data['me_content'])?>
	</p>

	<? if($data_log[2] == 'I') { ?>
		<div class="thumb">
			<img src="<?=get_item_img($me_data['me_get_item'])?>" />
		</div>
	<? } ?>

	<? if($data_log[2] == 'M') { ?>
		<div class="hp-bar">
			<em>
				<i><?=$log_comment['wr_mon_now_hp']?>/<?=$log_comment['wr_mon_hp']?></i>
				<span style="width:<?=$log_comment['wr_mon_now_hp'] ? $log_comment['wr_mon_now_hp']/$log_comment['wr_mon_hp'] * 100 : 0?>%;"></span>
			</em>
		</div>
	<? } ?>
	
	<? if($data_log[4]) { ?>
		<p><?=$data_log[4]?></p>
	<? } ?>

<? } ?>
</div>
<style>
.log-data-box .hp-bar		{ position: relative; line-height: 20px; height: 20px; border: 1px solid rgba(255, 255, 255, .2); border-radius: 4px; overflow: hidden; background: rgba(0, 0, 0, .7); }
.log-data-box .hp-bar i		{ display: block; position: absolute; top: 0; left: 5px; bottom: 0; z-index: 1; }
.log-data-box .hp-bar span	{ display: block; position: absolute; top: 0; left: 0;bottom: 0; width: 0; background: #581212; z-index: 0; }
</style>