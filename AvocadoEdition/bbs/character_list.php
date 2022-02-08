<?php
$sub_menu = "400200";
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

if($sfl != 'ch_state' && $stx != '삭제') {
	$sql_search .= " and ch_state != '삭제' ";
}

if($s_side) { 
	$sql_search .= " and ch_side = '{$s_side}' ";
}

if($s_class) { 
	$sql_search .= " and ch_class = '{$s_class}' ";
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

// 승인대기
$sql = " select count(*) as cnt {$sql_common} where ch_state = '대기' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 수정중
$sql = " select count(*) as cnt {$sql_common} where ch_state = '수정중' {$sql_order} ";
$row = sql_fetch($sql);
$modify_count = $row['cnt'];

// 삭제
$sql = " select count(*) as cnt {$sql_common} where ch_state = '삭제' {$sql_order} ";
$row = sql_fetch($sql);
$del_count = $row['cnt'];

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '캐릭터 관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 8;


/** 세력 정보 **/
$ch_si = array();
if($config['cf_side_title']) {
	$side_result = sql_query("select si_id, si_name from {$g5['side_table']} where si_auth <= '{$member['mb_level']}' order by si_id asc");
	for($i=0; $row = sql_fetch_array($side_result); $i++) { 
		$ch_si[$i]['name'] = $row['si_name'];
		$ch_si[$i]['id'] = $row['si_id'];
	}
}

/** 종족 정보 **/
$ch_cl = array();
if($config['cf_class_title']) {
	$class_result = sql_query("select cl_id, cl_name from {$g5['class_table']} where cl_auth <= '{$member['mb_level']}' order by cl_id asc");
	for($i=0; $row = sql_fetch_array($class_result); $i++) { 
		$ch_cl[$i]['name'] = $row['cl_name'];
		$ch_cl[$i]['id'] = $row['cl_id'];
	}

}

$profile = sql_fetch(" select ad_use_rank from {$g5['article_default_table']} ");
if($profile['ad_use_rank']) {
	$colspan++;
}


?>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	총캐릭터수 <?php echo number_format($total_count) ?>명
	<span style="float: right;">
		<a href="?sfl=ch_state&amp;stx=대기">승인대기 <?php echo number_format($leave_count) ?></a>명 | 
		<a href="?sfl=ch_state&amp;stx=수정중">수정중 <?php echo number_format($modify_count) ?></a>명 | 
		<a href="?sfl=ch_state&amp;stx=삭제">삭제 <?php echo number_format($del_count) ?></a>명
	</span>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>

<?
	if(count($ch_si) > 0) {
?>
<select name="s_side" id="c_side">
	<option value=""><?=$config['cf_side_title']?>선택</option>
<? for($i=0; $i < count($ch_si); $i++) { ?>
	<option value="<?=$ch_si[$i]['id']?>" <?php echo get_selected($_GET['s_side'], $ch_si[$i]['id']); ?>><?=$ch_si[$i]['name']?></option>
<? } ?>
</select>
<? } ?>
<?
	if(count($ch_cl) > 0) {
?>
<select name="s_class" id="c_class">
	<option value=""><?=$config['cf_class_title']?>선택</option>
<? for($i=0; $i < count($ch_cl); $i++) { ?>
	<option value="<?=$ch_cl[$i]['id']?>" <?php echo get_selected($_GET['s_class'], $ch_cl[$i]['id']); ?>><?=$ch_cl[$i]['name']?></option>
<? } ?>
</select>
<? } ?>

<select name="sfl" id="sfl">
	<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터 이름</option>
	<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>오너 아이디</option>
	<option value="ch_state"<?php echo get_selected($_GET['sfl'], "ch_state"); ?>>승인현황</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">
</form>


<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
	<a href="./character_form.php" id="member_add">캐릭터추가</a>
</div>
<?php } ?>

<form name="fmemberlist" id="fmemberlist" action="./character_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
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
		<col />


<? if($profile['ad_use_rank']) { ?>
		<col style="width: 120px;" />
<? } ?>
<? if($config['cf_side_title']) { ?>
		<col style="width: 120px;" />
<? } ?>
<? if($config['cf_class_title']) { ?>
		<col style="width: 120px;" />
<? } ?>
		<col style="width: 80px;" />
		<col style="width: 100px;" />
	</colgroup>
	<thead>
	<tr>
		<th>
			<label for="chkall" class="sound_only">캐릭터 전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th>유형</th>
		<th>이름</th>


<? if($profile['ad_use_rank']) { ?>
		<th>랭킹</th>
<? } ?>
<? if($config['cf_side_title']) { ?>
		<th><?=$config['cf_side_title']?></th>
<? } ?>
<? if($config['cf_class_title']) { ?>
		<th><?=$config['cf_class_title']?></th>
<? } ?>
		<th>상태</th>
		<th>관리</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$ch_id = $row['ch_id'];
		$bg = 'bg'.($i%2);

		$s_mod = '<a href="./character_form.php?'.$qstr.'&amp;w=u&amp;ch_id='.$row['ch_id'].'">수정</a>';
		$s_del = '<a href="javascript:post_delete(\'character_delete.php\', \''.$row['ch_id'].'\');">제거</a>';
	?>

	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="ch_id[<?php echo $i ?>]" value="<?php echo $row['ch_id'] ?>" id="ch_id_<?php echo $i ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['ch_name']); ?>님</label>
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>

		<td>
			<select name="ch_type[<?=$i?>]" class="frm_input">
				<option value="">유형선택</option>
				<option value="main" <?=$row['ch_type'] == "main" ? "selected" : "" ?>>MAIN</option>
				<option value="sub" <?=$row['ch_type'] == "sub" ? "selected" : "" ?>>SUB</option>
				<option value="npc" <?=$row['ch_type'] == "npc" ? "selected" : "" ?>>NPC</option>
			</select>
		</td>

		<td class="txt-left"><?php echo get_text($row['ch_name']); ?></td>


<? if($profile['ad_use_rank']) { ?>
		<td>
			<?=get_rank_name($row['ch_rank'])?>
		</td>
<? } ?>
<? if($config['cf_side_title']) { ?>
		<td>
			<select name="ch_side[<?=$i?>]" class="frm_input">
				<option value=""><?=$config['cf_side_title']?>선택</option>
			<? for($k=0; $k < count($ch_si); $k++) { ?>
				<option value="<?=$ch_si[$k]['id']?>" <?php echo get_selected($row['ch_side'], $ch_si[$k]['id']); ?>><?=$ch_si[$k]['name']?></option>
			<? } ?>
			</select>
		</td>
<? } ?>
<? if($config['cf_class_title']) { ?>
		<td>
			<select name="ch_class[<?=$i?>]" class="frm_input">
				<option value=""><?=$config['cf_class_title']?>선택</option>
			<? for($k=0; $k < count($ch_cl); $k++) { ?>
				<option value="<?=$ch_cl[$k]['id']?>" <?php echo get_selected($row['ch_class'], $ch_cl[$k]['id']); ?>><?=$ch_cl[$k]['name']?></option>
			<? } ?>
			</select>
		</td>
<? } ?>
		<td>
			<select name="ch_state[<?=$i?>]" class="frm_input">
				<option value="수정중">수정중</option>
				<option value="대기" <?=$row['ch_state'] == "대기" ? "selected" : "" ?>>대기</option>
				<option value="승인" <?=$row['ch_state'] == "승인" ? "selected" : "" ?>>승인</option>
				<option value="삭제" <?=$row['ch_state'] == "삭제" ? "selected" : "" ?>>삭제</option>
			</select>
		</td>

		<td><?php echo $s_mod ?>&nbsp;&nbsp;<?php echo $s_del ?></td>
	</tr>
  
	<?php
	}
	if ($i == 0)
		echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
	?>
	</tbody>
	</table>
</div>

<div class="local_desc02 local_desc pos-top">
	<p>선택삭제 - 상태를 삭제로 변경, 차후 문제 시 복구가 가능합니다. / 선택제거 - 캐리터 정보 삭제. 복구 불가능. 캐릭터와 관련된 아이템, 포인트 등의 정보 까지 모두 제거 됩니다.</p>
</div>

<div class="btn_list01 btn_list">
	<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
	<input type="submit" name="act_button" value="선택승인" onclick="document.pressed=this.value">
	<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
	<input type="submit" name="act_button" value="선택제거" onclick="document.pressed=this.value">
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
