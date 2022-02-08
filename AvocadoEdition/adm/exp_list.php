<?php
$sub_menu = "400410";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['exp_table']} ";

$sql_search = " where (1) ";


if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		case 'mb_name' : 
			$temp_mb = sql_fetch("select mb_id, mb_10 from {$g5['member_table']} where mb_nick = '{$stx}'");
			$sql_search .= " (ch_id = '{$temp_mb['mb_10']}') ";
			break;
		default :
			$sql_search .= " ({$sfl} like '%{$stx}%') ";
			break;
	}
	$sql_search .= " ) ";
}

if (!$sst) {
	$sst  = "ex_id";
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

$mb = array();
if ($sfl == 'mb_id' && $stx)
	$mb = get_member($stx);

$g5['title'] = $config['cf_exp_name'].' 관리';
include_once ('./admin.head.php');

$colspan = 7;


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">'.$config['cf_exp_name'].' 지급/회수</a></li>
	<li><a href="#anc_002">'.$config['cf_exp_name'].' 내역</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
?>


<form name="fpointlist2" method="post" id="fpointlist2" action="./exp_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<section id="anc_001">
		<h2 class="h2_frm"><?=$config['cf_exp_name']?> 지급/회수</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
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
						<th scope="row"><label for="ch_name">캐릭터 이름<strong class="sound_only">필수</strong></label></th>
						<td>
							<input type="hidden" name="ch_id" id="ch_id" value="" />
							<input type="text" name="ch_name" value="" id="ch_name" onkeyup="get_ajax_character(this, 'character_list', 'ch_id');" />
							<div id="character_list" class="ajax-list-box"><div class="list"></div></div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="ex_content">지급 내용<strong class="sound_only">필수</strong></label></th>
						<td><input type="text" name="ex_content" id="ex_content" required class="required frm_input" size="80"></td>
					</tr>
					<tr>
						<th scope="row"><label for="ex_point"><?=$config['cf_exp_name']?><strong class="sound_only">필수</strong></label></th>
						<td><input type="text" name="ex_point" id="ex_point" required class="required frm_input"></td>
					</tr>
				</tbody>
			</table>
		</div>

	</section>
	
	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit">
	</div>
</form>


<section id="anc_002">
	<h2 class="h2_frm"><?=$config['cf_exp_name']?> 내역</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		전체 <?php echo number_format($total_count) ?> 건
		<?php
		if (isset($mb['mb_id']) && $mb['mb_id']) {
			echo '&nbsp;(' . $mb['mb_id'] .' 님 골드 합계 : ' . number_format($mb['mb_point']) . '점)';
		} else {
			$row2 = sql_fetch(" select sum(ex_point) as sum_point from {$g5['exp_table']} ");
			echo '&nbsp;(전체 합계 '.number_format($row2['sum_point']).'점)';
		}
		?>
	</div>

	<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
	<label for="sfl" class="sound_only">검색대상</label>
	<select name="sfl" id="sfl">
		<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터이름</option>
		<option value="mb_name"<?php echo get_selected($_GET['sfl'], "mb_name"); ?>>오너이름</option>
		<option value="ex_content"<?php echo get_selected($_GET['sfl'], "ex_content"); ?>>내용</option>
	</select>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
	<input type="submit" class="btn_submit" value="검색">
	</form>
	<br />

	<form name="fpointlist" id="fpointlist" method="post" action="./exp_list_delete.php" onsubmit="return fpointlist_submit(this);">
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
			<col style="width: 45px;" />
			<col style="width: 100px;" />
			<col style="width: 150px;" />
			<col />
			<col style="width: 100px;" />
			<col style="width: 100px;" />
			<col style="width: 100px;" />
		</colgroup>
		<thead>
		<tr>
			<th>
				<label for="chkall" class="sound_only"><?=$config['cf_exp_name']?> 지급 내역 전체</label>
				<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
			</th>
			<th>오너명</th>

			<th>캐릭터 이름</th>
			<th>지급 내용</th>
			<th><?=$config['cf_exp_name']?></th>
			<th>일시</th>
			<th><?=$config['cf_exp_name']?> 합계</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bg = 'bg'.($i%2);
			$ch = get_character($row['ch_id']);
		?>

		<tr class="<?php echo $bg; ?>">
			<td>
				<input type="hidden" name="ch_id[<?php echo $i ?>]" value="<?php echo $row['ch_id'] ?>" id="ch_id_<?php echo $i ?>">
				<input type="hidden" name="ex_id[<?php echo $i ?>]" value="<?php echo $row['ex_id'] ?>" id="ex_id_<?php echo $i ?>">
				<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['ex_content'] ?> 내역</label>
				<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			</td>
			
			<td><?=get_member_name($ch['mb_id'])?></td>

			<td><a href="?sfl=ch_name&amp;stx=<?php echo $row['ch_name'] ?>"><?php echo $row['ch_name'] ?></a></td>
			<td class="txt-left"><?php echo $row['ex_content'] ?></td>
			<td><?php echo number_format($row['ex_point']) ?></td>
			<td><?php echo $row['ex_datetime'] ?></td>
			<td><?php echo number_format($row['ex_ch_exp']) ?></td>
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
