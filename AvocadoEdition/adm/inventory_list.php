<?php
$sub_menu = "500300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['inventory_table']} ";

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
	$sst  = "in_id";
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

$g5['title'] = '아이템 보유현황 관리';
include_once ('./admin.head.php');

$colspan = 8;

if (strstr($sfl, "ch_id"))
	$ch_id = $stx;
else
	$ch_id = "";


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">아이템 지급</a></li>
	<li><a href="#anc_002">아이템 보유 목록</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>

<form name="fpointlist2" method="post" id="fpointlist2" action="./inventory_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">
	<input type="hidden" name="it_rel" value="SYSTEM" />

	<section id="anc_001">
		<h2 class="h2_frm">캐릭터 아이템 지급</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
				<colgroup>
					<col style="width: 120px;">
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">지급유형</th>
						<td>
							<input type="radio" id="take_type_01" name="take_type" value="P" checked onclick="if(document.getElementById('take_type_01').checked) $('#take_member_name').show();"/>
							<label for="take_type_01">개별지급</label>
							&nbsp;&nbsp;
							<input type="radio" id="take_type_02" name="take_type" value="A" onclick="if(document.getElementById('take_type_02').checked) $('#take_member_name').hide();"/>
							<label for="take_type_02">전체지급</label>
						</td>
					</tr>
					<tr id="take_member_name">
						<th scope="row">캐릭터 이름</th>
						<td>
							<?php echo help('개별지급 시 입력') ?>
							<input type="hidden" name="ch_id" id="ch_id" value="" />
							<input type="text" name="ch_name" value="" id="ch_name" onkeyup="get_ajax_character(this, 'character_list', 'ch_id');" />
							<div id="character_list" class="ajax-list-box"><div class="list"></div></div>
						</td>
					</tr>
					<tr>
						<th scope="row">아이템 이름</th>
						<td>
							<input type="hidden" name="it_id" id="it_id" value="" />
							<input type="text" name="it_name" value="" id="it_name" onkeyup="get_ajax_item(this, 'item_list', 'it_id');" />
							<input type="text" name="item_count" value="" style="width:50px;"/>개
							<div id="item_list" class="ajax-list-box"><div class="list"></div></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</section>

	<?=$frm_submit?>
</form>

<section id="anc_002">
	<h2 class="h2_frm">아이템 보유 현황</h2>
	<?php echo $pg_anchor ?>

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

	<form name="fitemlist" id="fitemlist" method="post" action="./inventory_list_delete.php" onsubmit="return fitemlist_submit(this);">
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
					<col style="width: 120px;" />
					<col style="width: 80px;" />
					<col style="width: 180px;" />
					<col style="width: 120px;" />
					<col />
				</colgroup>
				<thead>
					<tr>
						<th scope="col">
							<label for="chkall" class="sound_only">소지품 내역 전체</label>
							<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
						</th>
						<th scope="col">소유자</a></th>
						<th scope="col" colspan="2">아이템 이름</a></th>
						<th scope="col">보낸사람</th>
						<th scope="col">메모</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $row=sql_fetch_array($result); $i++) {
						$bg = 'bg'.($i%2);
						$it = get_item($row['it_id']);
					?>

					<tr class="<?php echo $bg; ?>">
						<td>
							<input type="hidden" name="in_id[<?php echo $i ?>]" value="<?php echo $row['in_id'] ?>" id="in_id_<?php echo $i ?>">
							<label for="chk_<?php echo $i; ?>" class="sound_only">내역</label>
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						</td>
						<td class="txt-left"><?php echo get_text($row['ch_name']); ?></td>
						<td>
						<? if($it['it_img']) { ?>
							<img src="<?=$it['it_img']?>" style="max-width: 30px;"/>
						<? } else { ?>
							이미지 없음
						<? } ?>
						</td>
						<td class="txt-left">
							<?php echo get_text($row['it_name']); ?>
						</td>
						<td class="txt-left"><?=$row['se_ch_name']?></td>
						<td class="txt-left"><?php echo $row['in_memo'] ?></td>
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

</section>


<script>
function fitemlist_submit(f)
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
