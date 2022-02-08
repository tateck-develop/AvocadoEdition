<?php
$sub_menu = "600600";
include_once('./_common.php');

check_demo();

if (!count($_POST['chk']) && $_POST['act_button'] != '일괄지급') {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

if ($_POST['act_button'] == "선택수정") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ch = get_character($_POST['ch_id'][$k]);
		
		// 미궁진행도 체크
		sql_query("
			update {$g5['member_table']}
				set		mb_maze = '{$_POST['mb_maze'][$k]}'
				where		mb_id = '{$ch['mb_id']}'
		");
	}

}

if ($msg)
	alert($msg);

goto_url('./maze_member_list.php');
?>
