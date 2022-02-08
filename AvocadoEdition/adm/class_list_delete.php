<?php
$sub_menu = '400700';
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

$class_path = G5_DATA_PATH."/class";
$class_url = G5_DATA_URL."/class";

@mkdir($class_path, G5_DIR_PERMISSION);
@chmod($class_path, G5_DIR_PERMISSION);


if ($_POST['act_button'] == "선택수정") {
	
	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		$sql_common = "";

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$si = sql_fetch("select * from {$g5['class_table']} where cl_id = '{$_POST['cl_id'][$k]}'");
		
		if (!$si['cl_id']) {
			$msg .= $si['cl_id'].' : 기존 자료가 존재하지 않습니다.\\n';
		} else {

			if ($img = $_FILES['cl_img']['name'][$k]) {
				if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
					alert("관련 이미지가 gif, jpg, png 파일이 아닙니다.");
				} else {
					// 기존 데이터 삭제
					$prev_file_path = str_replace(G5_URL, G5_PATH, $si['cl_img'][$k]);
					@unlink($prev_file_path);
					
					// 확장자 따기
					$exp = explode(".", $_FILES['cl_img']['name'][$k]);
					$exp = $exp[count($exp)-1];

					$image_name = "class_".time().".".$exp;
					upload_file($_FILES['cl_img']['tmp_name'][$k], $image_name, $class_path);
					$image_url = $class_url."/".$image_name;

					$sql_common .= " , cl_img = '{$image_url}' ";
				}
			}

			$sql = " update {$g5['class_table']}
						set cl_name = '{$_POST['cl_name'][$k]}',
							cl_auth = '{$_POST['cl_auth'][$k]}'
							{$sql_common}
					";
			
			$sql .= "   where cl_id = '{$_POST['cl_id'][$k]}' ";
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
		$sql = " delete from {$g5['class_table']} where cl_id = '{$_POST['cl_id'][$k]}' ";
		sql_query($sql);

		// 소속 아이콘 이미지 삭제
		if($_POST['old_cl_img'][$k]) { 
			// 기존 데이터 삭제
			$prev_file_path = str_replace(G5_URL, G5_PATH, $_POST['old_cl_img'][$k]);
			@unlink($prev_file_path);
		}
	}
}

if ($msg)
	alert($msg);
goto_url('./class_list.php?'.$qstr);
?>