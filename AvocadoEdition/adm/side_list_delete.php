<?php
$sub_menu = '400600';
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

$side_path = G5_DATA_PATH."/side";
$side_url = G5_DATA_URL."/side";

@mkdir($side_path, G5_DIR_PERMISSION);
@chmod($side_path, G5_DIR_PERMISSION);


if ($_POST['act_button'] == "선택수정") {
	
	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		$sql_common = "";

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$si = sql_fetch("select * from {$g5['side_table']} where si_id = '{$_POST['si_id'][$k]}'");
		
		if (!$si['si_id']) {
			$msg .= $si['si_id'].' : 기존 자료가 존재하지 않습니다.\\n';
		} else {

			if ($img = $_FILES['si_img']['name'][$k]) {
				if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
					alert("관련 이미지가 gif, jpg, png 파일이 아닙니다.");
				} else {
					// 기존 데이터 삭제
					$prev_file_path = str_replace(G5_URL, G5_PATH, $si['si_img'][$k]);
					@unlink($prev_file_path);
					
					// 확장자 따기
					$exp = explode(".", $_FILES['si_img']['name'][$k]);
					$exp = $exp[count($exp)-1];

					$image_name = "side_".time().".".$exp;
					upload_file($_FILES['si_img']['tmp_name'][$k], $image_name, $side_path);
					$image_url = $side_url."/".$image_name;

					$sql_common .= " , si_img = '{$image_url}' ";
				}
			}

			$sql = " update {$g5['side_table']}
						set si_name = '{$_POST['si_name'][$k]}',
							si_auth = '{$_POST['si_auth'][$k]}'
							{$sql_common}
					";
			
			$sql .= "   where si_id = '{$_POST['si_id'][$k]}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	$count = count($_POST['chk']);
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		// 소속 내역삭제
		$sql = " delete from {$g5['side_table']} where si_id = '{$_POST['si_id'][$k]}' ";
		sql_query($sql);

		// 소속 아이콘 이미지 삭제
		if($_POST['old_si_img'][$k]) { 
			// 기존 데이터 삭제
			$prev_file_path = str_replace(G5_URL, G5_PATH, $_POST['old_si_img'][$k]);
			@unlink($prev_file_path);
		}
	}
}

if ($msg)
	alert($msg);
goto_url('./side_list.php?'.$qstr);
?>