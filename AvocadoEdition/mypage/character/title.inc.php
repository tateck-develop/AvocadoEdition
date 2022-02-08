<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

/* 보유중인 타이틀 정보 */
$ti_result = sql_query("select ti_id from {$g5['title_has_table']} where ch_id = '{$ch['ch_id']}'");
$ti = array();
$ti_index = 0;
for($i=0; $ti_row = sql_fetch_array($ti_result); $i++) {
	$ti_info = get_title($ti_row['ti_id']);
	if($ti_info['ti_id']) { 
		$ti[$ti_index] = $ti_info;
		$ti_index++;
	}
	
}

if(count($ti) > 0) { ?>

<div class="title-list">
<? for($i=0; $i < count($ti); $i++) { ?>
	<img src="<?=$ti[$i]['ti_img']?>" />
<? } ?>
</div>

<? if($ch['mb_id'] == $member['mb_id']) { 
	// 캐릭터 소유주와 접속자의 정보가 동일 할 때
	// 타이틀 변경
?>

<hr class="line" />
타이틀 변경 : 
<select onchange="fn_save_title(this.value, '<?=$ch['ch_id']?>');">
	<option value="">타이틀 없음</option>
<? for($i=0; $i < count($ti); $i++) { ?>
	<option value="<?=$ti[$i]['ti_id']?>" <?=$ti[$i]['ti_id'] == $ch['ch_title'] ? "selected" : ""?>><?=$ti[$i]['ti_title']?></option>
<? } ?>
</select>

<? }

} else { 
		echo "<div class='no-data'>보유중인 타이틀이 없습니다.</div>";
}
?>