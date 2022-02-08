<?php
include_once('./_common.php');

if($url) { 
	$return_url = urldecode($url);
} else {
	$return_url = "./viewer.php?ch_id=".$ch_id;
}

$ch = get_character($ch_id);
if($ch['mb_id'] != $member['mb_id']) { 
	alert("캐릭터 스탯 수정 권한이 없습니다.");
}
// --------------------- 캐릭터 스탯 등록

if(count($st_id) > 0) {
	// 저장되는 스탯 정보가 존재할 시
	for($i=0; $i < count($st_id); $i++) {
		$temp_st_id = $st_id[$i];
		$old_sc = sql_fetch("select * from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$temp_st_id}'");

		if($old_sc['sc_id']) { 
			// 업데이트
			$sql = " update {$g5['status_table']}
						set sc_max = '{$sc_max[$i]}'
						where sc_id = '{$old_sc['sc_id']}'
			";
			sql_query($sql);

		} else {
			// 등록
			$sql = " insert into {$g5['status_table']}
						set		st_id		= '{$st_id[$i]}',
								ch_id		= '{$ch_id}',
								sc_max		= '{$sc_max[$i]}'
			";
			sql_query($sql);
		}
	}
}
goto_url($return_url);
?>
