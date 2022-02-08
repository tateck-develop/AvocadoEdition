<?php
$sub_menu = '400420';
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

if ($_POST['act_button'] == "선택수정") {
	
	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		$sql_common = "";

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$lv = sql_fetch("select * from {$g5['status_config_table']} where st_id = '{$_POST['st_id'][$k]}'");
		
		if (!$lv['st_id']) {
			$msg .= $lv['st_id'].' : 기존 자료가 존재하지 않습니다.\\n';
		} else {
			$st_help_str = htmlspecialchars($_POST['st_help'][$k], ENT_QUOTES);

			$sql = " update {$g5['status_config_table']}
						set st_name = '{$_POST['st_name'][$k]}',
							st_max = '{$_POST['st_max'][$k]}',
							st_min = '{$_POST['st_min'][$k]}',
							st_order = '{$_POST['st_order'][$k]}',
							st_use_max = '{$_POST['st_use_max'][$k]}',
							st_help = '{$st_help_str}'
					";
			
			$sql .= "   where st_id = '{$_POST['st_id'][$k]}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	$count = count($_POST['chk']);
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		// 스탯 설정값 제거
		$sql = " delete from {$g5['status_config_table']} where st_id = '{$_POST['st_id'][$k]}' ";
		sql_query($sql);

		$sql = " delete from {$g5['status_table']} where st_id = '{$_POST['st_id'][$k]}' ";
		sql_query($sql);
	}
}

if ($msg)
	alert($msg);
goto_url('./status_list.php?'.$qstr);
?>