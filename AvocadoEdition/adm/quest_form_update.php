<?php
$sub_menu = "600100";
include_once('./_common.php');

if ($w == 'u') check_demo();
auth_check($auth[$sub_menu], 'w');
check_token();


$sql_common = " qu_type		= '{$qu_type}',
				si_id		= '{$si_id}',
				qu_title	= '{$qu_title}',
				qu_sdate	= '{$qu_sdate}',
				qu_edate	= '{$qu_edate}',
				qu_image	= '{$qu_image}'";


if($w == '') { 
	$sql = " insert into {$g5['quest_table']}
				set {$sql_common}";
	sql_query($sql);
} else {
	$qu = sql_fetch("select qu_id from {$g5['quest_table']} where qu_id = '{$qu_id}'");

	if(!$qu['qu_id']) {
		alert("퀘스트 정보가 존재하지 않습니다.");
	}
	$sql = " update {$g5['quest_table']}
				set {$sql_common}
				where qu_id = '{$qu['qu_id']}'";
	sql_query($sql);

}
goto_url('./quest_list.php?'.$qstr, false);
?>
