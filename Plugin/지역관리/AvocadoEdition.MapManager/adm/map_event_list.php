<?php
$sub_menu = "600300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();


$ma = sql_fetch("select * from {$g5['map_table']} where ma_id = '{$ma_id}'");

if(!$ma['ma_id']) { 
	alert("지역정보를 확인할 수 없습니다.");
}


$sql_common = " from {$g5['map_event_table']} where ma_id = '{$ma_id}' ";
$sql_order = " order by me_id asc";

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


$ma_sql = "select ma_id, ma_name from {$g5['map_table']} order by ma_id asc";
$ma_result = sql_query($ma_sql);
for($i=0; $maps = sql_fetch_array($ma_result); $i++) { 
	$map_list[$i]['name'] = $maps['ma_name'];
	$map_list[$i]['id'] = $maps['ma_id'];
}


$g5['title'] = "[ ".$ma['ma_name']." ] 지역 이벤트 관리";
include_once ('./admin.head.php');

$colspan = 11;
?>

<section id="anc_001">

<div class="local_ov01 local_ov" style="margin-top: 0;">
	<?php echo $listall ?>
	전체 <?php echo number_format($total_count) ?> 건
</div>

<div class="btn_add01 btn_add">
	<a href="./map_list.php" id="bo_add">지역관리</a>
	<a href="./map_event_form.php?ma_id=<?=$ma_id?>" id="bo_add">이벤트 추가</a>
</div>

<form name="fpointlist" id="fpointlist" method="post" action="./map_event_list_update.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="ma_id" value="<?php echo $ma_id ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">
<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 45px" />
		<col />

		<col style="width: 80px;" />
		<col style="width: 80px;" />
		<col style="width: 80px;"/>
		
		<col style="width: 100px;"/>
		<col style="width: 100px;"/>

		<col style="width: 80px;"/>
		<col style="width: 80px;"/>

		<col style="width: 80px;"/>
		<col style="width: 80px;"/>
	</colgroup>
	<thead>
	<tr>
		<th scope="col" rowspan="2">
			<label for="chkall" class="sound_only">이벤트 정보 전체</label>
			<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
		</th>
		<th scope="col" class="bo-left bo-no-bottom">종류</th>
		
		<th scope="col" rowspan="2" scope="col" class="bo-left">아이템<br />획득</th>
		<th scope="col" rowspan="2" class="bo-left">화폐변동</th>
		<th scope="col" rowspan="2" class="bo-left">이동지역</th>

		<th scope="col" colspan="2" class="bo-left">몬스터</th>
		
		
		<th scope="col" colspan="2" class="bo-left">이벤트획득구간</th>
		
		<th scope="col" rowspan="2" class="bo-left">사용여부</th>
		<th scope="col" rowspan="2" class="bo-left">관리</th>
	</tr>
	<tr>
		<th scope="col">이벤트명</th>

		<th scope="col" class="bo-left">몬스터HP</th>
		<th scope="col" class="bo-left">몬스터공격력</th>

		<th scope="col" class="bo-left">획득개수</th>
		<th scope="col" class="bo-left">현재획득</th>
	</tr>

	</thead>
	<tbody>
	<?php
	for ($i=0; $me=sql_fetch_array($result); $i++) {
		$bg = 'bg'.($i%2);

	?>

	<tr class="<?php echo $bg; ?>">
		<td class="td_chk">
			<input type="hidden" name="me_id[<?php echo $i ?>]" value="<?php echo $me['me_id'] ?>" id="me_id_<?php echo $i ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
		</td>
		<td>
			<select name="me_type[<?php echo $i ?>]" class="full_input">
				<option value="" <?=$me['me_type'] == '' ? 'selected' : ''?>>일반</option>
				<option value="아이템" <?=$me['me_type'] == '아이템' ? 'selected' : ''?>>아이템획득</option>
				<option value="화폐" <?=$me['me_type'] == '화폐' ? 'selected' : ''?>>화폐변동</option>
				<option value="이동" <?=$me['me_type'] == '이동' ? 'selected' : ''?>>지역이동</option>
				<option value="몬스터" <?=$me['me_type'] == '몬스터' ? 'selected' : ''?>>몬스터공격</option>
			</select>
			<input type="text" name="me_title[<?php echo $i ?>]" value="<?php echo get_text($me['me_title']) ?>" class="frm_input full_input">
		</td>

		<td style="Text-align: center;">
			<? if($me['me_get_item']) { ?>
				<img src="<?=get_item_img($me['me_get_item'])?>" style="max-width: 50px;" />
			<? } else { ?>
				-
			<? } ?>
		</td>

		<td>
			<input type="text" name="me_get_money[<?php echo $i ?>]" value="<?php echo get_text($me['me_get_money']) ?>" class="frm_input full_input">
		</td>
		<td>
			<select name="me_move_map[<?php echo $i ?>]" class="frm_input full_input">
				<option value="">-</option>
			<? for($k=0; $k < count($map_list); $k++) { ?>
				<option value="<?=$map_list[$k]['id']?>" <?php echo get_selected($map_list[$k]['id'], $me['me_move_map']); ?>><?=$map_list[$k]['name']?></option>
			<? } ?>
			</select>
		</td>
		<td>
			<input type="text" name="me_mon_hp[<?php echo $i ?>]" value="<?php echo get_text($me['me_mon_hp']) ?>" class="frm_input full_input">
		</td>
		<td>
			<input type="text" name="me_mon_attack[<?php echo $i ?>]" value="<?php echo get_text($me['me_mon_attack']) ?>" class="frm_input full_input">
		</td>

		<td>
			<input type="text" name="me_replay_cnt[<?php echo $i ?>]" value="<?php echo get_text($me['me_replay_cnt']) ?>" class="frm_input full_input">
		</td>
		<td>
			<input type="text" name="me_now_cnt[<?php echo $i ?>]" value="<?php echo get_text($me['me_now_cnt']) ?>" class="frm_input full_input">
		</td>

		<td>
			<input type="checkbox" name="me_use[<?php echo $i ?>]" value="1" <?=$me['me_use'] == '1'? "checked" : ""?>/>
		</td>

		<td>
			<a href="./map_event_form.php?w=u&amp;me_id=<?=$me['me_id']?>">수정</a>
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
	<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
	<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
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
