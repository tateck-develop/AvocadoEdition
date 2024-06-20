<?php
$sub_menu = "500220";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['recepi_table']} ";

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
	$sst  = "re_id";
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


$g5['title'] = '레시피 관리';
include_once ('./admin.head.php');

$colspan = 11;


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">레시피 목록</a></li>
	<li><a href="#anc_002">레시피 정보 입력</a></li>
</ul>';


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>


<form name="fpointlist" id="fpointlist" method="post" action="./recipi_list_update.php" onsubmit="return fpointlist_submit(this);">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<section id="anc_001">
		<h2 class="h2_frm">레시피 목록</h2>
		<?php echo $pg_anchor ?>

		<div class="local_ov01 local_ov">
			<?php echo $listall ?>
			전체 <?php echo number_format($total_count) ?> 건
		</div>

		<div class="tbl_head01 tbl_wrap">
			<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<colgroup>
				<col style="width: 45px;" />
				<col style="width: 80px;" />
				<col style="width: 120px;" />
				<col style="width: 80px;" />
				<col style="width: 120px;" />
				<col style="width: 80px;" />
				<col style="width: 120px;" />
				<col style="width: 80px;" />
				<col style="width: 120px;" />
				<col style="width: 50px;" />
				<col />
			</colgroup>
			<thead>
			<tr>
				<th scope="col">
					<label for="chkall" class="sound_only">레시피정보 전체</label>
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				<th scope="col" colspan="2" class="bo-left bo-right">재료01</th>
				<th scope="col" colspan="2" class="bo-right">재료02</th>
				<th scope="col" colspan="2" class="bo-right">재료03</th>
				<th scope="col" colspan="2" class="bo-right">조합결과</th>
				<th scope="col" class="bo-right">사용</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$bg = 'bg'.($i%2);
				$re_item = explode("||", $row['re_item_order']);
				$re_item = array_filter($re_item);
				sort($re_item);
			?>

			<tr class="<?php echo $bg; ?>">
				<td class="td_chk">
					<input type="hidden" name="re_id[<?php echo $i ?>]" value="<?php echo $row['re_id'] ?>" id="re_id_<?php echo $i ?>">
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
				</td>
				<td>
				<?
					$img_url = get_item_img($re_item[0]);
					if($img_url) {
						echo "<img src='".$img_url."' style='width: 30px;' />";
					}
				?>
				</td>
				<td>
					<?=get_item_name($re_item[0])?>
				</td>
				<td>
				<?
					$img_url = get_item_img($re_item[1]);
					if($img_url) {
						echo "<img src='".$img_url."' style='width: 30px;' />";
					}
				?>
				</td>
				<td>
					<?=get_item_name($re_item[1])?>
				</td>
				<td>
				<?
					$img_url = get_item_img($re_item[2]);
					if($img_url) {
						echo "<img src='".$img_url."' style='width: 30px;' />";
					}
				?>
				</td>
				<td>
					<?=get_item_name($re_item[2])?>
				</td>
				<td>
				<?
					$img_url = get_item_img($row['it_id']);
					if($img_url) {
						echo "<img src='".$img_url."' style='width: 30px;' />";
					}
				?>
				</td>
				<td>
					<?=get_item_name($row['it_id'])?>
				</td>
				<td style="Text-align: center;">
					<input type="checkbox" name="re_use[<?php echo $i ?>]" value="1" id="re_use_<?php echo $i ?>" <?php echo $row['re_use']?"checked":"" ?>>
				</td>
				<td></td>
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
			<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
			<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
		</div>

		<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>

	</section>
</form>



<form name="fpointlist2" method="post" id="fpointlist2" action="./recipi_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<section id="anc_002">
		<h2 class="h2_frm">레시피 정보 입력</h2>
		<?php echo $pg_anchor ?>

		<div class="local_desc02 local_desc">
			<p>재료 선택 시, [ 아이템 속성 > 레시피 재료 ] 설정이 되어 있는 아이템만 검색됩니다. </p>
		</div>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<colgroup>
				<col style="width: 50px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">사용</th>
					<th scope="row">재료 01</th>
					<th scope="row">재료 02</th>
					<th scope="row">재료 03</th>
					<th scope="row">결과</th>
				</tr>
				<tr>
					<td><input type="checkbox" name="re_use" value="1" id="re_use" checked /></td>
					<td>
						<input type="hidden" name="re_item1" id="re_item1" value="" />
						<input type="text" name="re_item1_name" value="" id="re_item1_name" size="50" onkeyup="get_ajax_item(this, 'item_01_list', 're_item1', '레시피');" />
						<div id="item_01_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
					<td>
						<input type="hidden" name="re_item2" id="re_item2" value="" />
						<input type="text" name="re_item2_name" value="" id="re_item2_name" size="50" onkeyup="get_ajax_item(this, 'item_02_list', 're_item2', '레시피');" />
						<div id="item_02_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
					<td>
						<input type="hidden" name="re_item3" id="re_item3" value="" />
						<input type="text" name="re_item3_name" value="" id="re_item3_name" size="50" onkeyup="get_ajax_item(this, 'item_03_list', 're_item3', '레시피');" />
						<div id="item_03_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
					<td>
						<input type="hidden" name="it_id" id="it_id" value="" />
						<input type="text" name="it_name" value="" id="it_name" size="50" onkeyup="get_ajax_item(this, 'item_result_list', 'it_id');" />
						<div id="item_result_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
					
				</tr>
			</tbody>
			</table>
		</div>
	</section>
	<?=$frm_submit?>

</form>


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
