<?php
$sub_menu = '400400';
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
		$lv = sql_fetch("select * from {$g5['level_table']} where lv_id = '{$_POST['lv_id'][$k]}'");
		
		if (!$lv['lv_id']) {
			$msg .= $lv['lv_id'].' : 기존 자료가 존재하지 않습니다.\\n';
		} else {

			$sql = " update {$g5['level_table']}
						set lv_name = '{$_POST['lv_name'][$k]}',
							lv_exp = '{$_POST['lv_exp'][$k]}',
							lv_add_state = '{$_POST['lv_add_state'][$k]}',
							lv_1 = '{$_POST['lv_1'][$k]}',
							lv_2 = '{$_POST['lv_2'][$k]}',
							lv_3 = '{$_POST['lv_3'][$k]}',
							lv_4 = '{$_POST['lv_4'][$k]}',
							lv_5 = '{$_POST['lv_5'][$k]}'
					";
			
			$sql .= "   where lv_id = '{$_POST['lv_id'][$k]}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	$count = count($_POST['chk']);
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		// 레벨 셋팅 내역삭제
		$sql = " delete from {$g5['level_table']} where lv_id = '{$_POST['lv_id'][$k]}' ";
		sql_query($sql);
	}
}

if ($msg)
	alert($msg);
goto_url('./level_list.php?'.$qstr);
?>