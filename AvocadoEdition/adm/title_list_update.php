<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


$title_path = G5_DATA_PATH."/title";
$title_url = G5_DATA_URL."/title";

@mkdir($title_path, G5_DIR_PERMISSION);
@chmod($title_path, G5_DIR_PERMISSION);



if ($_POST['act_button'] == "선택수정") {
	for ($i=0; $i<count($_POST['chk']); $i++) {

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$ti = sql_fetch("select * from {$g5['title_table']} where ti_id = '{$_POST['ti_id'][$k]}'");
		
		if (!$ti['ti_id']) {
			$msg .= $ti['ti_id'].' : 타이틀 자료가 존재하지 않습니다.\\n';
		} else {
			$sql_common = "";

			if ($img = $_FILES['ti_img']['name'][$k]) {
				if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
					alert("타이틀 이미지가 gif, jpg, png 파일이 아닙니다.");
				} else {
					
					$prev_file_path = str_replace(G5_URL, G5_PATH, $ti['ti_img']);
					// 기존 데이터 삭제
					@unlink($prev_file_path);

					// 확장자 따기
					$exp = explode(".", $_FILES['ti_img']['name'][$k]);
					$exp = $exp[count($exp)-1];

					$image_name = "tlt_".time().".".$exp;
					upload_file($_FILES['ti_img']['tmp_name'][$k], $image_name, $title_path);
					$sql_common .= " , ti_img = '".$title_url."/".$image_name."' ";
				}
			}

			$sql = " update {$g5['title_table']}
						set ti_title = '{$_POST['ti_title'][$k]}',
							ti_use = '{$_POST['ti_use'][$k]}',
							ti_value = '{$_POST['ti_value'][$k]}'
							{$sql_common}
					where ti_id = '{$ti['ti_id']}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ti = sql_fetch("select * from {$g5['title_table']} where ti_id = '{$_POST['ti_id'][$k]}'");
		if (!$ti['ti_id']) {
			$msg .= $ti['ti_id'].' : 타이틀 자료가 존재하지 않습니다.\\n';
		} else {
			$prev_file_path = str_replace(G5_URL, G5_PATH, $ti['ti_img']);
			// 기존 데이터 삭제
			@unlink($prev_file_path);

			sql_query(" delete from {$g5['title_table']} where ti_id = '{$ti['ti_id']}' ");
			sql_query(" delete from {$g5['title_has_table']} where ti_id = '{$ti['ti_id']}' ");
		}
	}
}

if ($msg) alert($msg);
goto_url('./title_list.php?'.$qstr);
?>
