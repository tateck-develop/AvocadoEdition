<?php
include_once('./_common.php');

$ch = sql_fetch("select * from {$g5['character_table']} where ch_id=".$ch_id);
$mb = get_member($ch['mb_id']);

/** 추가 항목 설정값 가져오기 **/
$ch_ar = array();
$str_secret = " where (1) and ar_theme = '{$config['cf_theme']}' ";

if($member['mb_id'] == $mb['mb_id']) {
	$str_secret .= " and ar_secret != 'H' ";
} else {
	$str_secret .= " and ar_secret = '' ";
}

$ar_result = sql_query("select * from {$g5['article_table']} {$str_secret} order by ar_order asc");
for($i = 0; $row = sql_fetch_array($ar_result); $i++) {
	$ch_ar[$i] = $row;
}

/* --------------------------------------------------------------
	프로필 양식에서 추가한 캐릭터의 데이터를 임의로 뿌리고 싶을 때
	$ch['고유코드'] 로 해당 데이터를 가져올 수 있습니다.
	--
	스탯 설정에서 추가한 캐릭터의 데이터를 임의로 뿌리고 싶을 때
	$변수 = get_status_by_name($ch['ch_id'], 스탯명);
	* $변수['has']	: 현재 캐릭터가 가지고 있는 전체값 (ex. 캐릭터의 최대 HP 값)
	* $변수['drop']	: 현재 캐릭터의 스탯 차감 수치 (ex. 캐릭터의 부상 수치, HP 감소)
	* $변수['now']	: 현재 캐릭터에게 적용되어 있는 값 (ex. 캐릭터의 현재 HP 값 (캐릭터의 원래 HP값 - 부상))
	* $변수['max']	: 입력할 수 있는 최대값
	* $변수['min']	: 필수 최소값
	--
	자동으로 출력 되는게 아닌 임의로 레이아웃을 수정하고 싶을 땐
	위쪽의 설정값 가져 오는 부분을 지우셔도 무방합니다.
	--
------------------------------------------------------------------ */

// --- 캐릭터 별 추가 항목 값 가져오기
$av_result = sql_query("select * from {$g5['value_table']} where ch_id = '{$ch['ch_id']}'");
for($i = 0; $row = sql_fetch_array($av_result); $i++) {
	$ch[$row['ar_code']] = $row['av_value'];
}

// ------- 캐릭터 스탯 정보 가져오기
$status = array();
if($article['ad_use_status']) { 
	$st_result = sql_query("select * from {$g5['status_config_table']} order by st_order asc");
	for($i = 0; $row = sql_fetch_array($st_result); $i++) {
		$status[$i] = get_status($ch['ch_id'], $row['st_id']);
		$status[$i]['name'] = $row['st_name'];
	}
}

// ------- 캐릭터 타이틀 정보 가져오기
$title = array();
if($article['ad_use_title']) { 
	$ti_result = sql_query("select * from {$g5['title_has_table']} th, {$g5['title_table']} ti where th.ti_id = ti.ti_id and th.ch_id = '{$ch['ch_id']}'");
	for($i=0; $row = sql_fetch_array($ti_result); $i++) {
		$title[$i] = $row;
	}
}

// ------- 캐릭터 관계 정보 가져오기
$relation = array();
if($ch['ch_state'] == '승인') {
	$relation_result = sql_query("select * from {$g5['relation_table']} where ch_id='{$ch_id}' order by rm_order asc, rm_id desc");
	for($i=0; $row = sql_fetch_array($relation_result); $i++) {
		$relation[$i] = $row;
	}
}

// ------- 캐릭터 의상 정보 가져오기
if($article['ad_use_closet'] && $article['ad_use_body']) {
	$temp_cl = sql_fetch("select * from {$g5['closthes_table']} where ch_id = '{$ch_id}' and cl_use = '1'");
	if($temp_cl['cl_path']) { 
		$ch['ch_body'] = $temp_cl['cl_path'];
	}
}

$g5['title'] = $ch['ch_name']." 프로필";
include_once(G5_PATH.'/head.php');

if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/member/viewer.skin.php")) {
	include(G5_THEME_PATH."/member/viewer.skin.php");
} else {
	include(G5_PATH."/member/skin/viewer.skin.php");
}

include_once(G5_PATH.'/tail.php');
?>
