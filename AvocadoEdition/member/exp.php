<?php
include_once('./_common.php');

$ch = get_character($ch_id);
if(!$ch['ch_id']) alert_close("캐릭터 정보를 확인할 수 없습니다.");

$g5['title'] = $ch['ch_name']." ".$config['cf_exp_name']." 획득 내역";
include_once('./_head.sub.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/exp.css">', 0);

$list = array();
$sql_common = " from {$g5['exp_table']} where ch_id = '{$ch['ch_id']}' ";
$sql_order = " order by ch_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

?>

<div id="member_view_point">
	<div class="ui-profile">
		<em>
			<img src="<?=$ch['ch_thumb']?>" />
		</em>
		
		<p class="name txt-point"><?=$ch['ch_name']?></p>
	<? if($config['cf_side_title']) { ?>
		<p><?=$config['cf_side_title']?> : <?=get_side_name($ch['ch_side'])?></p>
	<? } ?>
	<? if($config['cf_class_title']) { ?>
		<p><?=$config['cf_class_title']?> : <?=get_class_name($ch['ch_class'])?></p>
	<? } ?>
		<p><?=$config['cf_exp_name']?> : <?=$ch['ch_exp']?><?=$config['cf_exp_pice']?></p>
	</div>
</div>

<table class="theme-list">
	<thead>
		<tr>
			<th scope="col">일자</th>
			<th scope="col">내용</th>
			<th scope="col"><?=$config['cf_exp_name']?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = " select *
				{$sql_common}
				{$sql_order}
				limit {$from_record}, {$rows} ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$point1 = $point2 = 0;
		if ($row['ex_point'] > 0) {
			$point1 = number_format($row['ex_point']);
			$sum_point1 += $row['ex_point'];
		} else {
			$point2 = number_format($row['ex_point']);
			$sum_point2 += $row['ex_point'];
		}

		$ex_content = $row['ex_content'];
	?>
		<tr>
			<td class="txt-center">
				<?php echo date('Y-m-d', strtotime($row['ex_datetime'])); ?>
			</td>
			<td><?php echo $ex_content; ?></td>
			<td class="txt-right" style="padding-right: 15px;"><?php echo $point1; ?> <?=$config['cf_exp_pice']?></td>
		</tr>
	<?php
	}

	if ($i == 0)
		echo '<tr><td colspan="3" class="empty">자료가 없습니다.</td></tr>';
	else {
		if ($sum_point1 > 0)
			$sum_point1 = "+" . number_format($sum_point1);
		$sum_point2 = number_format($sum_point2);
	}
	?>
	</tbody>
</table>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;ch_id='.$ch_id.'&amp;page='); ?>

<hr class="padding" />


<?php
include_once('./_tail.sub.php');
?>
