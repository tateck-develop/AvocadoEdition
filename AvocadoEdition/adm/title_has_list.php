<?php
$sub_menu = "400310";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['title_has_table']} ";

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
	$sst  = "hi_id";
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


$g5['title'] = '타이틀 보유현황 관리';
include_once ('./admin.head.php');

$colspan = 6;

if (strstr($sfl, "ch_id"))
	$ch_id = $stx;
else
	$ch_id = "";



$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">타이틀 지급</a></li>
	<li><a href="#anc_002">타이틀 보유 목록</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';


?>

<form name="ftitlelist2" method="post" id="ftitlelist2" action="./title_has_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<section id="anc_001">
		<h2 class="h2_frm">타이틀 지급</h2>
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
						<th scope="row">타이틀 이름</th>
						<td>
							<input type="hidden" name="ti_id" id="ti_id" value="" />
							<input type="text" name="ti_name" value="" id="ti_name" onkeyup="get_ajax_title(this, 'title_list', 'ti_id');" />
							<div id="title_list" class="ajax-list-box"><div class="list"></div></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" id="btn_submit">
	</div>
</form>


<section id="anc_002">
	<h2 class="h2_frm">타이틀 보유 현황</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		전체 <?php echo number_format($total_count) ?> 건
	</div>

	<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
	<label for="sfl" class="sound_only">검색대상</label>
	<select name="sfl" id="sfl">
		<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터 이름</option>
		<option value="it_name"<?php echo get_selected($_GET['sfl'], "ti_title"); ?>>타이틀 이름</option>
	</select>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
	<input type="submit" class="btn_submit" value="검색">
	</form>
	<br />

	<form name="ftitlelist" id="ftitlelist" method="post" action="./title_has_list_delete.php" onsubmit="return ftitlelist_submit(this);">
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
			<col style="width: 80px;" />
			<col style="width: 80px;" />
		</colgroup>
		<thead>
		<tr>
			<th>
				<label for="chkall" class="sound_only">타이틀 내역 전체</label>
				<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
			</th>
			<th>&nbsp;</th>
			<th>소유자</th>
			<th>타이틀 이름</th>
			<th>상태</th>
			<th>사용여부</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bg = 'bg'.($i%2);
			$ti = sql_fetch("select * from {$g5['title_table']} where ti_id = '{$row['ti_id']}'");
			$ch = sql_fetch("select ch_name, ch_title from {$g5['character_table']} where ch_id = '{$row['ch_id']}'");
		?>

		<tr class="<?php echo $bg; ?>">
			<td>
				<input type="hidden" name="hi_id[<?php echo $i ?>]" value="<?php echo $row['hi_id'] ?>" id="hi_id_<?php echo $i ?>">
				<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			</td>
			<td>
				<img src="<?=$ti['ti_img']?>"/>
			</td>
			<td class="txt-left">
				<?php echo get_text($ch['ch_name']); ?>
			</td>
			<td class="txt-left">
				<?php echo get_text($ti['ti_title']); ?>
			</td>
			<td>
				<?=$ch['ch_title'] == $row['ti_id'] ? "착용" : "<span style='color: #cacaca;'>미착용</span>"?>
			</td>

			
			<td>
				<?php echo $row['hi_use'] == '1' ? 'Y' : 'N'?>
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

	</form>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>

</section>


<script>
function ftitlelist_submit(f)
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

$(document).ready(function() {

});

</script>

<?php
include_once ('./admin.tail.php');
?>
