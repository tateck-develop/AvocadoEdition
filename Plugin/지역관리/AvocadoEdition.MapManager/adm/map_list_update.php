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
		$sql = " update {$g5['map_table']}
                    set ma_name             = '{$_POST['ma_name'][$k]}',
                        ma_use              = '{$_POST['ma_use'][$k]}',
						ma_start            = '{$_POST['ma_start'][$k]}',
						ma_top				= '{$_POST['ma_top'][$k]}',
						ma_left				= '{$_POST['ma_left'][$k]}',
						ma_width			= '{$_POST['ma_width'][$k]}',
						ma_height			= '{$_POST['ma_height'][$k]}'
                  where ma_id            = '{$_POST['ma_id'][$k]}' ";
        sql_query($sql);
	}

} else if ($_POST['act_button'] == "선택삭제") {
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$sql = " delete from {$g5['map_table']} where ma_id = '{$_POST['ma_id'][$k]}' ";
		sql_query($sql);
		$sql = " delete from {$g5['map_move_table']} where mf_start = '{$_POST['ma_id'][$k]}' or mf_end = '{$_POST['ma_id'][$k]}'";
		sql_query($sql);
		$sql = " delete from {$g5['map_event_table']} where ma_id = '{$_POST['ma_id'][$k]}'";
		sql_query($sql);
	}
}
goto_url('./map_list.php?'.$qstr);

?>