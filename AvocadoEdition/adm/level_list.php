<?php
$sub_menu = "400400";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['level_table']} ";

$sql_search = " where (1) ";

$sql_order = " order by lv_exp desc ";

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

$g5['title'] = $config['cf_rank_name'].'설정 관리';
include_once ('./admin.head.php');

$colspan =7;

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">'.$config['cf_rank_name'].' 설정 목록</a></li>
	<li><a href="#anc_002">'.$config['cf_rank_name'].' 설정 등록</a></li>
</ul>';

?>

<section id="anc_001">
	<h2 class="h2_frm"><?=$config['cf_rank_name']?> 설정 목록</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		전체 <?php echo number_format($total_count) ?> 건
	</div>

	<form name="fpointlist" id="fpointlist" method="post" action="./level_list_update.php" onsubmit="return fpointlist_submit(this);"  enctype="multipart/form-data">
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
			<col style="width: 100px;" />
			<col style="width: 100px;"/>
			<col style="width: 120px;"/>
			<col />
		</colgroup>
		<thead>
		<tr>
			<th scope="col">
				<label for="chkall" class="sound_only"><?=$config['cf_rank_name']?>설정 내역 전체</label>
				<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
			</th>
			<th scope="col"><?=$config['cf_rank_name']?>명</th>
			<th scope="col">요구<?=$config['cf_exp_name']?></th>
			<th scope="col">추가 스텟 포인트</th>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bg = 'bg'.($i%2);
		?>

		<tr class="<?php echo $bg; ?>">
			<td style="text-align: center">
				<input type="hidden" name="lv_id[<?php echo $i ?>]" value="<?php echo $row['lv_id'] ?>" id="lv_id_<?php echo $i ?>">
				<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			</td>
			<td>
				<input type="text" name="lv_name[<?php echo $i ?>]" value="<?php echo $row['lv_name'] ?>" class="frm_input" style="width: 98%;">
			</td>
			<td>
				<input type="text" name="lv_exp[<?php echo $i ?>]" value="<?php echo $row['lv_exp'] ?>" class="frm_input" style="width: 70%;"> exp
			</td>
			<td>
				<input type="text" name="lv_add_state[<?php echo $i ?>]" value="<?php echo $row['lv_add_state'] ?>" class="frm_input" style="width: 50px;">
			</td>

			<td>&nbsp;</td>
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

	</form>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>

</section>


<section id="anc_002">
	<h2 class="h2_frm"><?=$config['cf_rank_name']?> 설정 등록</h2>
	<?php echo $pg_anchor ?>

	<form name="fpointlist2" method="post" id="fpointlist2" action="./level_form_update.php" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 130px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="lv_name"><?=$config['cf_rank_name']?>명<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="lv_name" id="lv_name" class="required frm_input" required></td>
		</tr>
		<tr>
			<th scope="row"><label for="lv_exp">요구<?=$config['cf_exp_name']?><strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="lv_exp" id="lv_exp" class="required frm_input" required></td>
		</tr>
		<tr>
			<th scope="row"><label for="lv_add_state">추가스텟포인트<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="lv_add_state" id="lv_add_state" class="required frm_input"></td>
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
