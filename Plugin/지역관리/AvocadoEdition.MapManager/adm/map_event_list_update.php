<?php
$sub_menu = '600300';
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
		$sql = " update {$g5['map_event_table']}
                    set me_type             = '{$_POST['me_type'][$k]}',
                        me_title              = '{$_POST['me_title'][$k]}',
						me_get_hp				= '{$_POST['me_get_hp'][$k]}',
						me_get_money				= '{$_POST['me_get_money'][$k]}',
						me_move_map			= '{$_POST['me_move_map'][$k]}',
						me_mon_hp			= '{$_POST['me_mon_hp'][$k]}',
						me_mon_attack			= '{$_POST['me_mon_attack'][$k]}',
						me_replay_cnt			= '{$_POST['me_replay_cnt'][$k]}',
						me_now_cnt			= '{$_POST['me_now_cnt'][$k]}',
						me_use			= '{$_POST['me_use'][$k]}'
                  where me_id            = '{$_POST['me_id'][$k]}' ";
        sql_query($sql);
	}

} else if ($_POST['act_button'] == "선택삭제") {
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$sql = " delete from {$g5['map_event_table']} where me_id = '{$_POST['me_id'][$k]}'";
		sql_query($sql);
	}
}
goto_url('./map_event_list.php?ma_id='.$ma_id.'&'.$qstr);

?>