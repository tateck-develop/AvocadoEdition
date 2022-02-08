<?php
include_once('./_common.php');
include_once('./_head.php');

$sql = "select
			MAX(me_id) as me_id,
			COUNT(me_id) as count,
			if(me_recv_mb_id = '{$member['mb_id']}', me_send_mb_id, me_recv_mb_id) as mb_id
		from {$g5['memo_table']}
		where	me_send_mb_id = '{$member['mb_id']}'
			OR	me_recv_mb_id = '{$member['mb_id']}'
		group by mb_id
		order by me_id desc";
$result = sql_query($sql);

$total = sql_num_rows($result);
$rows = 5;
$total_page  = ceil($total / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql .= " limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$write_page = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?type=');

?>


<div class="ui-list-control">
	<a href="javascript:location.reload();" class="ui-btn small">REFRESH</a>
	<a href="./memo_form.php" class="ui-btn small point">WRITE</a>
</div>

<div class="ui-chatting-memo">
<?
	for($i=0; $row = sql_fetch_array($result); $i++) {
		$me = sql_fetch("select * from {$g5['memo_table']} where me_id = '{$row['me_id']}'");
		$total = $row['count'];
		$mb = get_member($row['mb_id']);
		$ch = get_character($mb['ch_id']);

?>
	<div class="message-item index you">
		<div class="thumb">
		<? if($ch['ch_thumb']){?>
			<img src="<?=$ch['ch_thumb']?>" />
		<? } ?>
		</div>
		<div class="detail theme-box">
			<h3>
				<strong><?=$mb['mb_name']?>&nbsp;</strong>
			</h3>
			<div class="info">
				<span class="date">
					<strong class="not-mo"><?=$me['me_send_datetime']?></strong>
					<strong class="only-mo"><?=date('m-d H:i', strtotime($me['me_send_datetime']))?></strong>
				</span>
				<? if($me['me_read_datetime'] == '0000-00-00 00:00:00' && $me['me_send_mb_id'] != $member['mb_id']) { ?>
				<i class="ico-new">N</i>
				<? } ?>
				<i class="ico-total ui-btn point">T</i>
				<span class="total-text">
					<?=$total?>
				</span>
			</div>
			<div class="text no-link theme-box <? if($me['me_send_mb_id'] == $member['mb_id']) { ?> mine<? } ?>">
				<a href="./memo_view.php?re_mb_id=<?=$row['mb_id']?>">
					<? if($me['me_send_mb_id'] == $member['mb_id']) { ?>
					ME ▶
					<? } ?>
					<?php echo conv_subject($me['me_memo'], 120, '...'); ?>
				</a>
			</div>
		</div>
	</div>
<? } ?>
</div>

<?=$write_page?>

<hr class="padding" />
<hr class="padding" />

<?
include_once('./_tail.php');
?>
