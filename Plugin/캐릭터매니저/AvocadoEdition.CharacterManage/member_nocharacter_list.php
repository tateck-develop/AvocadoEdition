<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['member_table']} ";
$sql_search = " where ch_id = '0' and mb_id != '{$config['cf_admin']}' ";

if (!$sst) {
	$sst = "mb_datetime";
	$sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '캐릭터 미등록 회원관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 9;
?>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	캐릭터 미등록 멤버 <?php echo number_format($total_count) ?>명 중,
	<a href="?sst=mb_intercept_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>">차단 <?php echo number_format($intercept_count) ?></a>명,
	<a href="?sst=mb_leave_date&amp;sod=desc&amp;sfl=<?php echo $sfl ?>&amp;stx=<?php echo $stx ?>">탈퇴 <?php echo number_format($leave_count) ?></a>명
</div>

<div class="local_desc01 local_desc">
	<p>
		회원 자료를 완전히 삭제합니다.
	</p>
</div>


<form name="fmemberlist" id="fmemberlist" action="./member_nocharacter_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<thead>
	<tr>
		<th>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th>아이디</a></th>
		<th>이름</a></th>
		<th>생년</a></th>
		<th>보유캐릭터</a></th>
		<th>상태</th>
		<th>권한</th>
		<th>가입일</a></th>
		<th>최종접속</a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$s_mod = '<a href="./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$row['mb_id'].'">수정</a>';
		$leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date('Ymd', G5_SERVER_TIME);
		$intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date('Ymd', G5_SERVER_TIME);
		$mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
		$mb_id = $row['mb_id'];
		$leave_msg = '';
		$intercept_msg = '';
		$intercept_title = '';
		if ($row['mb_leave_date']) {
			$mb_id = $mb_id;
			$leave_msg = '<span class="mb_leave_msg">탈퇴함</span>';
		}
		else if ($row['mb_intercept_date']) {
			$mb_id = $mb_id;
			$intercept_msg = '<span class="mb_intercept_msg">차단됨</span>';
			$intercept_title = '차단해제';
		}
		if ($intercept_title == '')
			$intercept_title = '차단하기';
		$bg = 'bg'.($i%2);
	?>

	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['mb_name']); ?> <?php echo get_text($row['mb_nick']); ?>님</label>
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>

		<td><?php echo $mb_id ?></td>
		<td><?php echo get_text($row['mb_name']); ?></td>
		<td><?php echo get_text($row['mb_birth']); ?></td>
		<td class="txt-left">
		<?
			// 해당 멤버의 캐릭터 검색
			$add_character_str = "";
			$ch_result = sql_query("select ch_name, ch_id from {$g5['character_table']} where mb_id = '{$row['mb_id']}'");
			for($j = 0; $ch = sql_fetch_array($ch_result); $j++) { 
		?>
			<?=$add_character_str?>
			<a href="./character_form.php?w=u&amp;ch_id=<?=$ch['ch_id']?>"><?=$ch['ch_name']?></a>

		<?
				$add_character_str = " / ";
			}
			if($j == 0) { 
		?>
			<span style="color:#bbb;">보유중인 캐릭터가 없습니다.</span>
		<? } ?>
		</td>
		
		<td>
			<?php
			if ($leave_msg || $intercept_msg) echo $leave_msg.' '.$intercept_msg;
			else echo "정상";
			?>
		</td>
		<td>
			<?php echo get_member_level_select("mb_level[$i]", 1, $member['mb_level'], $row['mb_level']) ?>
		</td>
		<td><?php echo substr($row['mb_datetime'],2,8); ?></td>
		<td><?php echo substr($row['mb_today_login'],2,8); ?></td>
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
	<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
	<input type="submit" name="act_button" value="전체삭제" onclick="document.pressed=this.value">
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
		if(!confirm("선택한 자료를 정말 삭제하시겠습니까? 완전삭제시 복구는 불가능합니다.")) {
			return false;
		}
	}
	if(document.pressed == "전체삭제") {
		if(!confirm("캐릭터 미등록 회원 자료를 정말 삭제하시겠습니까? 완전삭제시 복구는 불가능합니다.")) {
			return false;
		}
	}


	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
