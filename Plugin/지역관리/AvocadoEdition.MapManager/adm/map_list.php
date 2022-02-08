<?php
$sub_menu = "600300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['map_table']} ";
$sql_order = " order by ma_parent asc, ma_id asc ";

$sql = " select count(*) as cnt
			{$sql_common}
			{$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];


$sql = " select *
			{$sql_common}
			{$sql_order}";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';


$g5['title'] = '지역 관리';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_003">지역사용설정</a></li>
	<li><a href="#anc_001">지역리스트</a></li>
	<li><a href="#anc_002">지역정보 입력</a></li>
</ul>';

$colspan = 13;
?>

<style>
.full_input {width:100% !important;}
</style>

<section id="anc_003" >
	<h2 class="h2_frm">지역 사용 설정</h2>
	<?php echo $pg_anchor ?>

	<form name="fmapconfiglist" method="post" id="fmapconfiglist" action="./map_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">
	<input type="hidden" name="type" value="CONFIG">

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 100px;">
			<col style="width: 100px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_use_map">지역 기능</label></th>
			<td>
				<input type="checkbox" name="cf_use_map" value="1" id="cf_use_map" <? if($config['cf_use_map']) { ?>checked<? } ?>>
				<label for="cf_use_map">사용</label>
			</td>
			<td style="vertical-align: middle;">
				<fieldset class="btn_add" style="float: none; text-align: left; margin: 0;">
					<input type="submit" value="설정" class="btn_submit" style="height: 25px; padding: 0 20px;">
				</fieldset>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	</form>
</section>

<section id="anc_001">

<h2 class="h2_frm">지역 목록 보기</h2>
<?php echo $pg_anchor ?>

<div class="local_ov01 local_ov" style="margin-top: 0;">
	<?php echo $listall ?>
	전체 <?php echo number_format($total_count) ?> 건
</div>

<div class="btn_add01 btn_add">
	<a href="./map_member_list.php">캐릭터 위치 관리</a>
</div>

<form name="fpointlist" id="fpointlist" method="post" action="./map_list_update.php" onsubmit="return fpointlist_submit(this);">
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
		<col style="width: 45px" />
		<col style="width: 55px" />
		<col style="width: 45px" />
		<col style="width: 170px;" />
		<col style="width: 45px;" />
		<col style="width: 45px;" />
		<col style="width: 80px;" />
		<col style="width: 80px;" />
		<col style="width: 80px;" />
		<col style="width: 80px;"/>
		
		<col style="width: 100px;"/>
		<col style="width: 100px;"/>

		<col />
	</colgroup>
	<thead>
	<tr>
		<th scope="col">
			<label for="chkall" class="sound_only">지역정보 전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th>IDX</th>
		<th scope="col" colspan="2">지역명</th>
		<th scope="col">사용</th>
		<th scope="col">시작</th>
		<th>X</th>
		<th>Y</th>
		<th>W</th>
		<th>H</th>
		<th scope="col">통행관리</th>
		<th scope="col">이벤트관리</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'bg'.($i%2);

		$is_parent = true;
		if($row['ma_parent'] != $row['ma_id']) $is_parent = false;

	?>

	<tr class="<?php echo $bg; ?>">
		<td class="td_chk">
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>
		<td class="td_chk">
			<input type="text" name="ma_id[<?php echo $i ?>]" value="<?php echo $row['ma_id'] ?>" id="ma_id_<?php echo $i ?>" readonly class="full_input">
		</td>
		<? if(!$is_parent) { ?>
		<td>
			┗…
		</td>
		<td>
		<? } else { ?>
		<td colspan="2">
		<? } ?>
			<input type="text" name="ma_name[<?php echo $i ?>]" value="<?php echo get_text($row['ma_name']) ?>" id="ma_name_<?php echo $i ?>" required class="required frm_input full_input" size="20">
		</td>

		<td style="Text-align: center;">
			<input type="checkbox" name="ma_use[<?php echo $i ?>]" value="1" id="ma_use_<?php echo $i ?>" <?php echo $row['ma_use']?"checked":"" ?>>
		</td>
		<td style="Text-align: center;">
			<input type="checkbox" name="ma_start[<?php echo $i ?>]" value="1" id="ma_start_<?php echo $i ?>" <?php echo $row['ma_start']?"checked":"" ?>>
		</td>

		<td>
			<input type="text" name="ma_left[<?php echo $i ?>]" value="<?php echo get_text($row['ma_left']) ?>" class="frm_input full_input">
		</td>
		<td>
			<input type="text" name="ma_top[<?php echo $i ?>]" value="<?php echo get_text($row['ma_top']) ?>" class="frm_input full_input">
		</td>
		<td>
			<input type="text" name="ma_width[<?php echo $i ?>]" value="<?php echo get_text($row['ma_width']) ?>" class="frm_input full_input">
		</td>
		<td>
			<input type="text" name="ma_height[<?php echo $i ?>]" value="<?php echo get_text($row['ma_height']) ?>" class="frm_input full_input">
		</td>

		<td>
			<? if($row['ma_id'] == $row['ma_parent']) { ?>
				<a href="./map_move_list.php?ma_id=<?=$row['ma_id']?>">통행설정</a>
			<? } ?>
		</td>
		<td>
		<?
			// 이벤트 카운터 검색
			$me_cnt = sql_fetch("select count(me_id) as cnt from {$g5['map_event_table']} where ma_id = '{$row['ma_id']}'");
			$me_cnt = $me_cnt['cnt'];
		?>
			<a href="./map_event_list.php?ma_id=<?=$row['ma_id']?>">이벤트설정 (<?=$me_cnt?>)</a>
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

</form>

</section>


<section id="anc_002" >
	<h2 class="h2_frm">지역 정보 입력</h2>
	<?php echo $pg_anchor ?>

	<form name="fpointlist2" method="post" id="fpointlist2" action="./map_update.php" autocomplete="off">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="ma_parent">지역 정보</label></th>
			<td>
				<select id="ma_parent" name="ma_parent">
					<option value="">상위지역</option>
				<?
					$pa_sql = "select ma_id, ma_name from {$g5['map_table']} where ma_parent = ma_id order by ma_id asc";
					$pa_result = sql_query($pa_sql);

					for($i=0; $row = sql_fetch_array($pa_result); $i++) { 
				?>
					<option value="<?=$row['ma_id']?>"  <?=get_cookie("co_ma_parent") == $row['ma_id'] ? "selected" : ""?>><?=$row['ma_name']?></option>
				<? } ?>
				</select>
				<input type="text" name="ma_name" value="" id="ma_name" class="required frm_input" required placeholder=" 지역명 입력">
				&nbsp;&nbsp;
				<input type="checkbox" name="ma_use" value="1" id="ma_use" checked>
				<label for="ma_use">사용여부</label>
			</td>
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
