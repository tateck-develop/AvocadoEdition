<?php
$sub_menu = "500210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

/** 획득 아이템 설정 등록 **/
$sql_common = "";

if(!$it_id && $it_name) {
	$it = sql_fetch("select it_id, it_type from {$g5['item_table']} where it_name = '{$it_name}'");
	if($it['it_type'] != '뽑기') {
		alert("해당 아이템은 뽑기 기능이 설정되지 않은 아이템입니다.");
	}
	
	$it_id = $it['it_id'];
}
if(!$re_it_id && $re_it_name) {
	$it = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$re_it_name}'");
	$re_it_id = $it['it_id'];
}


$sql = " insert into {$g5['explorer_table']}
			set it_id = '{$it_id}',
				re_it_id = '{$re_it_id}',
				ie_per_s = '{$ie_per_s}',
				ie_per_e = '{$ie_per_e}',
				ma_id = '{$ma_id}',
				ie_1 = '{$ie_1}',
				ie_2 = '{$ie_2}',
				ie_3 = '{$ie_3}',
				ie_4 = '{$ie_4}',
				ie_5 = '{$ie_5}'
		";
sql_query($sql);

goto_url('./explorer_list.php?sch_it_id='.$sch_it_id.'&'.$qstr);
?>
