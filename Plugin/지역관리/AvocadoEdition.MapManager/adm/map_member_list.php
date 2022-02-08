<?php
$sub_menu = "600300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['character_table']} ";

$sql_search = " where (1) ";
if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		default :
			$sql_search .= " ({$sfl} like '{$stx}%') ";
			break;
	}
	$sql_search .= " ) ";
}


if (!$sst) {
	$sst = "ch_type asc";
	$sod = "";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 50;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '캐릭터별 위치 관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
$colspan = 4;

/** 지역 정보 **/
$ma_sql = "select ma_id, ma_name from {$g5['map_table']} order by ma_id asc";
$ma_result = sql_query($ma_sql);
for($i=0; $map = sql_fetch_array($ma_result); $i++) { 
	$ma[$i]['name'] = $map['ma_name'];
	$ma[$i]['id'] = $map['ma_id'];
}

?>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	총캐릭터수 <?php echo number_format($total_count) ?>명
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
	<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터 이름</option>
	<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>오너 아이디</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>

<div class="btn_add01 btn_add">
	<a href="./map_list.php">지역 관리</a>
</div>


<form name="fmemberlist" id="fmemberlist" action="./map_member_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">


<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 50px;" />
		<col style="width: 100px;" />
		<col style="width: 200px;" />
		<col />
	</colgroup>
	<thead>
	<tr>
		<th>
			<label for="chkall" class="sound_only">캐릭터 전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th>유형</th>
		<th>이름</th>

		<th>위치</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$ch_id = $row['ch_id'];
		$bg = 'bg'.($i%2);
	?>

	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="ch_id[<?php echo $i ?>]" value="<?php echo $row['ch_id'] ?>" id="ch_id_<?php echo $i ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['ch_name']); ?>님</label>
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>

		<td>
			<?=$row['ch_type']?>
		</td>

		<td class="txt-left"><?php echo get_text($row['ch_name']); ?></td>

		<td>
			<select name="ma_id[<?=$i?>]" style="width: 100%;">
				<option value="">위치 미지정</option>
			<? for($k=0; $k < count($ma); $k++) { ?>
				<option value="<?=$ma[$k]['id']?>" <?php echo get_selected($row['ma_id'], $ma[$k]['id']); ?>><?=$ma[$k]['name']?></option>
			<? } ?>
			</select>
		</td>

	</tr>
  
	<?php
	}
	if ($i == 0)
		echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
	?>
	</tbody>
	</table>
</div>
<div class="btn_list01 btn_list">
	<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
</div>

</form>



<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>
function fmemberlist_submit(f)
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
