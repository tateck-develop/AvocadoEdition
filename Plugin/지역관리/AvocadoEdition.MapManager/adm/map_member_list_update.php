<?php
$sub_menu = "600300";
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'w');

if ($_POST['act_button'] == "선택수정") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		
		// 캐릭터 위치 이동
		sql_query("
			update {$g5['character_table']}
				set		ma_id = '{$_POST['ma_id'][$k]}'
				where	ch_id = '{$_POST['ch_id'][$k]}'
		");
	}

}

if ($msg)
	alert($msg);

goto_url('./map_member_list.php');
?>
