<?php
$sub_menu = "400310";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

if(!$ti_id && $ti_name) {
	$ti = sql_fetch("select ti_id from {$g5['title_table']} where ti_title = '{$ti_name}'");
	if(!$ti['ti_id']) {
		alert("해당 타이틀의 정보가 없습니다.");
	}
	$ti_id = $ti['ti_id'];
} else {
	$ti = sql_fetch("select ti_id from {$g5['title_table']} where ti_id = '{$ti_id}'");
}

if(!$ti['ti_id']) { 
	alert("등록된 자료가 없습니다.");
}


if($take_type == 'A') {
	// 전체지급
	$sql_common = " from {$g5['character_table']} ";
	$sql_search = " where ch_state = '승인' ";
	$sql = " select ch_id, ch_name {$sql_common} {$sql_search} ";
	$result = sql_query($sql);

	for($i=0; $ch = sql_fetch_array($result); $i++) { 
		
		// 동일 타이틀 중복 지급 여부 체크
		$m_ti = sql_fetch("select count(*) as cnt from {$g5['title_has_table']} where ti_id = '{$ti_id}' and ch_id = '{$ch['ch_id']}'");

		if(!$m_ti['cnt']) { 
			$sql = " insert into {$g5['title_has_table']}
						set ch_id = '{$ch['ch_id']}',
							ch_name = '{$ch['ch_name']}',
							ti_id = '{$ti['ti_id']}',
							hi_use = '1'";
			sql_query($sql);
		}
	}

} else {
	// 개별지급
	if(!$ch_id && $ch_name) {
		$ch = sql_fetch("select ch_id, ch_name from {$g5['character_table']} where ch_name = '{$ch_name}'");
		$ch_id = $ch['ch_id'];
	} else {
		$ch = sql_fetch("select ch_id, ch_name from {$g5['character_table']} where ch_id = '{$ch_id}'");
	}

	if (!$ch['ch_id'])
		alert('존재하는 캐릭터가 아닙니다.');

	// 동일 타이틀 중복 지급 여부 체크
	$m_ti = sql_fetch("select count(*) as cnt from {$g5['title_has_table']} where ti_id = '{$ti_id}' and ch_id = '{$ch['ch_id']}'");
	if(!$m_ti['cnt']) { 
		$sql = " insert into {$g5['title_has_table']}
					set ch_id = '{$ch['ch_id']}',
						ch_name = '{$ch['ch_name']}',
						ti_id = '{$ti['ti_id']}',
						hi_use = '1'";
		sql_query($sql);
	}

}


goto_url('./title_has_list.php?'.$qstr);
?>
