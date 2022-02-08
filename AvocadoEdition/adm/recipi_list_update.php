<?php
$sub_menu = '500220';
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'd');
check_token();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

$count = count($_POST['chk']);
if ($_POST['act_button'] == "선택수정") {
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$sql = " update {$g5['recepi_table']}
					set re_use	= '{$_POST['re_use'][$k]}'
				  where re_id   = '{$_POST['re_id'][$k]}' ";
		sql_query($sql);
	}

} else if ($_POST['act_button'] == "선택삭제") {
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$sql = " delete from {$g5['recepi_table']} where re_id = '{$_POST['re_id'][$k]}' ";
		sql_query($sql);
	}
}
goto_url('./recipi_list.php?'.$qstr);

?>