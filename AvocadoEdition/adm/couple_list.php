<?php
$sub_menu = "400500";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['couple_table']} ";

$sql_search = " where (1) ";

if (!$sst) {
	$sst  = "co_order";
	$sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
			{$sql_common}
			{$sql_search}
			{$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
			{$sql_common}
			{$sql_search}
			{$sql_order}
			limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$mb = array();

$g5['title'] = '커플 관리';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">커플 목록</a></li>
	<li><a href="#anc_002">커플 추가</a></li>
</ul>';

$colspan = 5;
?>



<form name="fpointlist" id="fpointlist" method="post" action="./couple_list_delete.php" onsubmit="return fpointlist_submit(this);">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<section id="anc_001">
		<h2 class="h2_frm">커플 목록</h2>
		<?php echo $pg_anchor ?>

		<div class="local_ov01 local_ov">
			<?php echo $listall ?>
			전체 <?php echo number_format($total_count) ?> 커플
		</div>

		<div class="tbl_head01 tbl_wrap">
			<table>
				<caption><?php echo $g5['title']; ?> 목록</caption>
				<colgroup>
					<col style="width: 50px;" />
					<col style="width: 120px;" />
					<col style="width: 120px;" />
					<col />
					<col style="width: 50px;" />
				</colgroup>
				<thead>
					<tr>
						<th>
							<label for="chkall" class="sound_only">커플 내역 전체</label>
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th>왼쪽</th>
						<th>오른족</th>
						<th><?php echo subject_sort_link('co_date') ?>사귄날짜</a></th>
						<th><?php echo subject_sort_link('co_order') ?>순서</a></th>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						
						$ch_left = sql_fetch("select ch_thumb, ch_name, ch_id from {$g5['character_table']} where ch_id = '{$row['co_left']}'");
						$ch_right = sql_fetch("select ch_thumb, ch_name, ch_id from {$g5['character_table']} where ch_id = '{$row['co_right']}'");

						$bg = 'bg'.($i%2);
					?>

					<tr class="<?php echo $bg; ?>">
						<td>
							<input type="hidden" name="co_id[<?php echo $i ?>]" value="<?php echo $row['co_id'] ?>" id="co_id_<?php echo $i ?>">
							<label for="chk_<?php echo $i; ?>" class="sound_only">tt</label>
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						</td>
						<td>
							<a href=""><img src="<?=$ch_left['ch_thumb']?>" /></a>
						</td>
						<td>
							<a href=""><img src="<?=$ch_right['ch_thumb']?>" /></a>
						</td>
						<td>
							<?=$row['co_date']?>
						</td>
						<td>
							<?=$row['co_order']?>
						</td>
					</tr>

					<?php
					}
					if ($i == 0)
						echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
					?>
				</tbody>
			</table>
		</div>

		<div class="btn_list01 btn_list">
			<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
		</div>

		<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>

	</section>

</form>



<section id="anc_002">
	<h2 class="h2_frm">커플 추가</h2>
	<?php echo $pg_anchor ?>

<?
	include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
	if (empty($fr_date)) $fr_date = G5_TIME_YMD;
?>

	<form name="fpointlist2" method="post" id="fpointlist2" action="./couple_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 120px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="ch_name_left">왼쪽 캐릭터<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="hidden" name="co_left" id="co_left" value="<?php echo $co_left ?>" />
						<input type="text" name="ch_name_left" value="" id="ch_name_left" onkeyup="get_ajax_character(this, 'character_left_list', 'co_left');" />
						<div id="character_left_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ch_name_right">오른쪽 캐릭터<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="hidden" name="co_right" id="co_right" value="<?php echo $co_right ?>" />
						<input type="text" name="ch_name_right" value="" id="ch_name_right" onkeyup="get_ajax_character(this, 'character_right_list', 'co_right');" />
						<div id="character_right_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="co_order">순서<strong class="sound_only">필수</strong></label></th>
					<td><input type="text" name="co_order" id="co_order" required class="required" style="width: 50px;"></td>
				</tr>
				<tr>
					<th scope="row"><label for="co_date">시작일</label></th>
					<td><input type="text" name="co_date" value="<?php echo $co_date; ?>" id="co_date"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit">
	</div>
	</form>

</section>
<script>
$(function(){
	$("#co_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
<script>
function fpointlist_submit(f)
{
	if (!is_checked("chk[]")) {
		alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택삭제") {
		if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
			return false;
		}
	}

	return true;
}


</script>

<?php
include_once ('./admin.tail.php');
?>
