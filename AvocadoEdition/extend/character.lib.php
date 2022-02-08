<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


$character = get_character($member['ch_id']);
if($is_member && ($member['mb_id'] != $character['mb_id'] || $member['ch_id'] == '' || !$character['ch_id'])) {
	$character_sql = "select * from {$g5['character_table']} where mb_id = '{$member['mb_id']}' limit 0, 1";
	$character = sql_fetch($character_sql);
	if($character['ch_id']) { 
		sql_query("update {$g5['member_table']} set ch_id = '{$character['ch_id']}' where mb_id = '{$member['mb_id']}'");
	}
}

if($character['ch_id']) { 
	if($character['ch_search_date']  != G5_TIME_YMD) {
		// 마지막 탐색 일자가 오늘이 아닐 경우
		// 탐색일자 갱신 및 탐색 횟수 초기화
		sql_query("
			update {$g5['character_table']}
					set		ch_search = 0,
							ch_search_date = '".G5_TIME_YMD."'

				where		ch_id = '{$character['ch_id']}'
		");

		$character['ch_search'] = 0;
		$character['ch_search_date'] = G5_TIME_YMD;
	}
}


// 캐릭터 네임 가져오기
function get_character_name($ch_id)
{
	global $g5;
	$character = sql_fetch("select ch_name from {$g5['character_table']} where ch_id = '{$ch_id}'");
	return $character['ch_name'];
}

// 캐릭터 네임 가져오기 (멤버 ID검색으로,대표 캐릭터 가져오기)
function get_member_character_name($mb_id)
{
	global $g5;
	$character = sql_fetch("select ch.ch_name from {$g5['character_table']} ch, {$g5['member_table']} mb where mb.mb_id= '{$mb_id}' and ch.mb_id = mb.mb_id");
	return $character['ch_name'];
}

function get_character_head($ch_id){
	global $g5;
	$ch = sql_fetch("select ch_thumb from {$g5['character_table']} where ch_id = '{$ch_id}'");

	return $ch['ch_thumb'];
}


// 유저 네임 가져오기
function get_member_name($mb_id)
{
	global $g5;
	$member = sql_fetch("select mb_nick from {$g5['member_table']} where mb_id = '{$mb_id}'");
	return $member['mb_nick'];
}

// 캐릭터 기본 정보 가져오기
function get_character($ch_id)
{
	global $g5;
	$character = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}'");
	
	return $character;
}

// 캐릭터 추가 정보 가져오기 (캐릭터 idx, 추가항목 고유코드)
function get_character_info($ch_id, $ar_code)
{
	global $g5;
	$ch = sql_fetch("select av_value from {$g5['value_table']} where ch_id = '{$ch_id}' and ar_code = '{$ar_code}'");
	return $ch['av_value'];
}

function get_character_list($side = '', $class = '', $state = '승인') {
	global $g5;

	$character = array();

	$sql_search = '';
	if($side) { 
		$sql_search .= " and ch_side = '{$side}' ";
	}
	if($class) { 
		$sql_search .= " and ch_class = '{$class}' ";
	}

	$sql_common = "select *
			from	{$g5['character_table']}
			where	ch_state = '{$state}'
					{$sql_search}
			order by ch_id asc";

	$result = sql_query($sql_common);

	for($i=0; $row=sql_fetch_array($result); $i++) {
		$character[] = $row;
	}

	return $character;
}


// 테마 사용 시, 테마 전용으로 사용될 프로필 항목을 임의로 추가하기
function add_profile_article($theme, $code, $name, $type='text', $pice = '', $help = '', $order = '') {
	global $g5;


}

?>