<?php
$sub_menu = '600600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '미궁관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['maze_table']} where ma_subject != '' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$config['cf_page_rows'] = 20;
$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by ma_order limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);



$rank_sql_common = " from {$g5['character_table']} ch, {$g5['member_table']} mb ";
$rank_sql_search = " where ch.ch_state = '승인' and ch.mb_id = mb.mb_id and mb.mb_maze_datetime != '000-00-00 00:00:00' ";
$rank_sst = "mb.mb_maze_datetime asc";
$rank_sql_order = " order by {$rank_sst} {$rank_sod} ";

$rank_sql = " select count(*) as cnt {$rank_sql_common} {$rank_sql_search} {$rank_sql_order} ";
$rank_row = sql_fetch($rank_sql);
$rank_total_count = $rank_row['cnt'];

$rank_rows = 10;
$rank_total_page  = ceil($rank_total_count / $rank_rows);  // 전체 페이지 계산
if ($rank_page < 1) $rank_page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$rank_from_record = ($rank_page - 1) * $rank_rows; // 시작 열을 구함
$rank_sql = " select * {$rank_sql_common} {$rank_sql_search} {$rank_sql_order} limit {$rank_from_record}, {$rank_rows} ";
$rank_result = sql_query($rank_sql);



$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">미궁클리어랭킹</a></li>
	<li><a href="#anc_002">미궁내용목록</a></li>
</ul>';
?>

<section id="anc_001">
	<h2 class="h2_frm">미궁클리어랭킹</h2>
	<?php echo $pg_anchor ?>

	<div class="btn_add01 btn_add">
		<a href="./maze_member_list.php">미궁 진행현황 관리</a>
		<a href="<?=G5_URL?>/maze/index.php">미궁 바로가기</a>
	</div>

	
	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 80px;" />
			<col />
			<col style="width: 100px;" />
			<col style="width: 160px;" />
		</colgroup>
		<thead>
		<tr>
			<th>랭킹</th>
			<th>이름</th>
			<th>현재위치</th>
			<th>클리어타임</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $row=sql_fetch_array($rank_result); $i++) {
			$ch_id = $row['ch_id'];
			$ch_ma = sql_fetch("select * from {$g5['maze_table']} where ma_id = '{$row['mb_maze']}'");
		?>

		<tr class="<?php echo $bg; ?>">
			<td>
				<?=($rank_rows * ($rank_page - 1)) + $i + 1?>
			</td>
			<td class="txt-left"><?php echo get_text($row['ch_name']); ?></td>
			<td>
				<?=$ch_ma['ma_subject']?>
			</td>
			<td>
				<?=$row['mb_maze_datetime']?>
			</td>
		</tr>
	  
		<?php
		}
		if ($i == 0)
			echo "<tr><td colspan=\"4\" class=\"empty_table\">자료가 없습니다.</td></tr>";
		?>
		</tbody>
		</table>
	</div>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $rank_page, $rank_total_page, '?'.$qstr.'&amp;rank_page='); ?>

</section>


<section id="anc_002">
	<h2 class="h2_frm">미궁내용목록</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php if ($page > 1) {?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
		<span>전체 내용 <?php echo $total_count; ?>건</span>
	</div>

	<div class="btn_add01 btn_add">
		<a href="./maze_form.php">미궁 추가</a>
		<a href="<?=G5_URL?>/maze/index.php">미궁 바로가기</a>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 80px;" />
			<col style="width: 300px;" />
			<col style="width: 100px;" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th scope="col">순서</th>
			<th scope="col">제목</th>
			<th scope="col">관리</th>
			<th scope="col"></th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bg = 'bg'.($i%2);
		?>
		<tr class="<?php echo $bg; ?>">
			<td class="td_id"><?php echo $row['ma_order']; ?></td>
			<td><?php echo htmlspecialchars2($row['ma_subject']); ?></td>
			<td class="td_mng">
				<a href="./maze_form.php?w=u&amp;ma_id=<?php echo $row['ma_id']; ?>"><span class="sound_only"><?php echo htmlspecialchars2($row['ma_subject']); ?> </span>수정</a>
				<a href="./maze_formupdate.php?w=d&amp;ma_id=<?php echo $row['ma_id']; ?>" onclick="return delete_confirm(this);"><span class="sound_only"><?php echo htmlspecialchars2($row['ma_subject']); ?> </span>삭제</a>
			</td>
			<td></td>
		</tr>
		<?php
		}
		if ($i == 0) {
			echo '<tr><td colspan="4" class="empty_table">자료가 한건도 없습니다.</td></tr>';
		}
		?>
		</tbody>
		</table>
	</div>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

</section>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
