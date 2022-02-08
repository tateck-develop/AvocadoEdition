<?php
$sub_menu = "500400";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['order_table']} o ";

$sql_search = " where (1) ";

if ($stx) {
	if($sfl == 'ch_name') { 
		$sql_common .= ", {$g5['character_table']} c ";
		$sql_search .= " and  c.ch_name like '%{$stx}%' and c.ch_id = o.ch_id ";
	} else if($sfl == 'it_name') { 
		$sql_common .= ", {$g5['item_table']} i ";
		$sql_search .= " and  i.it_name like '%{$stx}%' and i.it_id = o.it_id ";
	}
}

if (!$sst) {
	$sst  = "o.or_id";
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

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$ch = array();
if ($sfl == 'ch_id' && $stx)
	$ch = get_member($stx);

$g5['title'] = '아이템 구매 기록';
include_once ('./admin.head.php');

$colspan = 5;

?>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	전체 <?php echo number_format($total_count) ?> 건
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
	<label for="sfl" class="sound_only">검색대상</label>
	<select name="sfl" id="sfl">
		<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터 이름</option>
		<option value="it_name"<?php echo get_selected($_GET['sfl'], "it_name"); ?>>아이템 이름</option>
	</select>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
	<input type="submit" class="btn_submit" value="검색">
</form>
<br />
<form name="forderlist" id="forderlist" method="post" action="./order_list_delete.php" onsubmit="return forderlist_submit(this);">
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
				<col style="width: 150px;" />
				<col style="width: 150px;" />
				<col />
				<col style="width: 120px;" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">
						<label for="chkall" class="sound_only">아이템 전체</label>
						<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
					</th>
					<th scope="col">구매캐릭터</th>
					<th scope="col">구매회원</th>
					<th scope="col">아이템</th>
					<th scope="col">구매일</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$bg = 'bg'.($i%2);
					$it = get_item($row['it_id']);
					$ch = get_character($row['ch_id']);
					$mb = get_member($row['mb_id']);
				?>

				<tr class="<?php echo $bg; ?>">
					<td>
						<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						<input type="hidden" name="or_id[<?php echo $i ?>]" value="<?php echo $row['or_id'] ?>" />
					</td>
					<td><?php echo get_text($ch['ch_name']); ?></td>
					<td><?php echo get_text($mb['mb_nick']); ?></td>
					<td>
						<img src="<?=$it['it_img']?>" style="max-width: 30px;"/>
						<?php echo get_text($it['it_name']); ?>
					</td>
					<td><?php echo ($row['or_datetime'] == '0000-00-00 00:00:00') ? '' : $row['or_datetime'] ?></td>
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

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>



<script>
function forderlist_submit(f)
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
