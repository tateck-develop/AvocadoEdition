<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['title_table']} ";

$sql_search = " where (1) ";
if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		default :
			$sql_search .= " ({$sfl} like '%{$stx}%') ";
			break;
	}
	$sql_search .= " ) ";
}

if (!$sst) {
	$sst  = "ti_id";
	$sod = "desc";
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

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '타이틀 관리';
include_once('./admin.head.php');


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">타이틀 목록</a></li>
	<li><a href="#anc_002">타이틀 등록</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

$colspan = 5;
?>

<section id="anc_001">

	<h2 class="h2_frm">타이틀 목록</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		타이틀 수 <?php echo number_format($total_count) ?>개
	</div>

	<form name="ftitlelist" id="ftitlelist" action="./title_list_update.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="">

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 45px;" />
			<col style="width: 200px;" />
			<col style="width: 200px;" />
			<col />
			<col style="width: 80px;" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th scope="col">
				<label for="chkall" class="sound_only">현재 페이지 타이틀 전체</label>
				<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
			</th>
			<th>이미지</th>
			<th>이미지 수정</th>
			<th>타이틀명</th>
			<th>사용유무</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $ti=sql_fetch_array($result); $i++) {
			$bg = 'bg'.($i%2);
		?>

		<tr class="<?php echo $bg; ?>">
			<td>
				<input type="hidden" name="ti_id[<?php echo $i ?>]" value="<?php echo $ti['ti_id'] ?>" id="ti_id_<?php echo $i ?>">
				<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			</td>
			<td>
				<? if($ti['ti_img']) { ?>
					<img src="<?=$ti['ti_img']?>" />
					<input type="hidden" name="old_ti_img[<?=$i?>]" value="<?=$ti['ti_img']?>" />
				<? } ?>
			</td>
			<td>
				<input type="file" name="ti_img[<?=$i?>]" id="ti_img<?=$i?>" />
			</td>
			<td>
				<input type="text" name="ti_title[<?php echo $i ?>]" value="<?php echo $ti['ti_title'] ?>" class="frm_input" style="width: 98%;">
			</td>
			<td style="text-align: center;">
				<select name="ti_use[<?php echo $i; ?>]">
					<option value="">사용안함</option>
					<option value="Y" <?php echo $ti['ti_use']=='Y'?'selected':''; ?>>사용</option>
				</select>
			</td>
		</tr>

		<?php
		}

		if ($i==0)
			echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<div class="btn_list01 btn_list">
		<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
		<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
	</div>
	</form>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

	<script>
	$(function() {
		$('#ftitlelist').submit(function() {
			if (!is_checked("chk[]")) {
				alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
				return false;
			}
			if(document.pressed == "선택삭제") {
				if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
					return false;
				}
			}

			return true;
		});
	});
	</script>
</section>

<section id="anc_002" style="margin-top: 0; margin-bottom: 50px;">
	<form name="fpointlist2" method="post" id="fpointlist2" action="./title_update.php" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">
	<input type="hidden" name="ch_id" id="ch_id" value="<?=$ch_id?>" />
	<input type="hidden" name="mb_id" value="<?php echo $ch['mb_id'] ?>">

	<h2 class="h2_frm">타이틀 신규 등록</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="ti_title">타이틀 명</label></th>
			<td>
				<input type="text" name="ti_title" value="" id="ti_title" class="frm_input" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ti_img">타이틀 이미지<strong class="sound_only">필수</strong></label></th>
			<td>
				<input type="file" name="ti_img" id="ti_img" />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ti_value">사용유무</label></th>
			<td>
				<select name="ti_use">
					<option value="">사용안함</option>
					<option value="Y" selected>사용</option>
				</select>
			</td>
		</tr>
		</tbody>
		</table>
	</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="등록" class="btn_submit" id="btn_submit">
	</div>

	</form>

</section>



<?php
include_once ('./admin.tail.php');
?>