<?php
$sub_menu = "300700";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['emoticon_table']} ";

$sql_search = " where (1) ";

if (!$sst) {
	$sst  = "me_id";
	$sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
			{$sql_common}
			{$sql_search}
			{$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 18;
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

$g5['title'] = '이모티콘 관리';
include_once ('./admin.head.php');

$colspan = 9;

$po_expire_term = '';
if($config['cf_point_term'] > 0) {
	$po_expire_term = $config['cf_point_term'];
}

?>

<h2 class="h2_frm">이모티콘 목록</h2>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	전체 <?php echo number_format($total_count) ?> 건
</div>

<form name="fpointlist" id="fpointlist" method="post" action="./emoticon_list_update.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 50px;" />
		<col style="width: 120px;"/>
		<col  />
		<col style="width: 50px;" />
		<col style="width: 120px;"/>
		<col  />
		<col style="width: 50px;" />
		<col style="width: 120px;"/>
		<col  />
	</colgroup>
	<thead>
	<tr>
		<th scope="col">
			<label for="chkall" class="sound_only">이모티콘 내역 전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th scope="col">이미지</th>
		<th scope="col">명령어</th>

		<th scope="col">&nbsp;</th>
		<th scope="col">이미지</th>
		<th scope="col">명령어</th>

		<th scope="col">&nbsp;</th>
		<th scope="col">이미지</th>
		<th scope="col">명령어</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'bg'.($i%2);
	?>

<? if($i % 3 == 0) { 
	if($i == 0) { echo "</tr>"; }
?>
	<tr class="<?php echo $bg; ?>">
<? } ?>
	
		<td style="text-align: center">
			<input type="hidden" name="me_id[<?php echo $i ?>]" value="<?php echo $row['me_id'] ?>" id="me_id_<?php echo $i ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>
		<td style="text-align: center"><?php echo "<img src='".G5_URL."{$row['me_img']}' alt='{$row['me_text']}'>"; ?></td>
		<td class="txt-left"><?php echo $row['me_text']; ?></td>
	<?php
	}

	if ($i == 0)
		echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
	
	if($i%3) {
		for($j = 0; $j < 3-($i%3); $j++) {
			echo "<td></td><td></td><td></td>";
		}
	}

	if($i > 0) { echo "</tr>"; }
	?>
	</tbody>
	</table>
</div>

<div class="btn_list01 btn_list">
	<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>

<section id="point_mng">
	<h2 class="h2_frm">이모티콘 등록</h2>

	<form name="fpointlist2" method="post" id="fpointlist2" action="./emoticon_form_update.php" autocomplete="off" enctype="multipart/form-data">
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
			<th scope="row"><label for="me_text">이모티콘 명령어<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="me_text" id="me_text" class="required frm_input" required></td>
		</tr>
		<tr>
			<th scope="row"><label for="me_img">이미지<strong class="sound_only">필수</strong></label></th>
			<td><input type="file" name="me_img" id="me_img"></td>
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
