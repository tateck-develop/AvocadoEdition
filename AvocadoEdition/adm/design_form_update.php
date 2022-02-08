<?php
$sub_menu = "100300";
include_once('./_common.php');

$site_style_path = G5_DATA_PATH."/site";
$site_style_url = G5_DATA_URL."/site";

@mkdir($site_style_path, G5_DIR_PERMISSION);
@chmod($site_style_path, G5_DIR_PERMISSION);


for($i=0; $i < count($cs_name); $i++) {
	
	$de = sql_fetch("select * from {$g5['css_table']} where cs_name = '{$cs_name[$i]}'");

	if(is_array($cs_etc_1[$i]))		$cs_etc_1[$i] = "||".implode("||", $cs_etc_1[$i])."||";
	if(is_array($cs_etc_2[$i]))		$cs_etc_2[$i] = "||".implode("||", $cs_etc_2[$i])."||";
	if(is_array($cs_etc_3[$i]))		$cs_etc_3[$i] = "||".implode("||", $cs_etc_3[$i])."||";
	if(is_array($cs_etc_4[$i]))		$cs_etc_4[$i] = "||".implode("||", $cs_etc_4[$i])."||";
	if(is_array($cs_etc_5[$i]))		$cs_etc_5[$i] = "||".implode("||", $cs_etc_5[$i])."||";
	if(is_array($cs_etc_6[$i]))		$cs_etc_6[$i] = "||".implode("||", $cs_etc_6[$i])."||";
	if(is_array($cs_etc_7[$i]))		$cs_etc_7[$i] = "||".implode("||", $cs_etc_7[$i])."||";
	if(is_array($cs_etc_8[$i]))		$cs_etc_8[$i] = "||".implode("||", $cs_etc_8[$i])."||";
	if(is_array($cs_etc_9[$i]))		$cs_etc_9[$i] = "||".implode("||", $cs_etc_9[$i])."||";
	if(is_array($cs_etc_10[$i]))	$cs_etc_10[$i] = "||".implode("||", $cs_etc_10[$i])."||";

	// 이미지 등록 시, 이미지를 업로드한 뒤 - 해당 이미지 경로를 삽입
	if ($_FILES['cs_value_file']['name'][$i]) {
		// 확장자 따기
		$exp = explode(".", $_FILES['cs_value_file']['name'][$i]);
		$exp = $exp[count($exp)-1];

		$image_name = "design_".$cs_name[$i].".".$exp;
		upload_file($_FILES['cs_value_file']['tmp_name'][$i], $image_name, $site_style_path);
		$cs_value[$i] = $site_style_url."/".$image_name;
	}
	


	if($de['cs_id']) { 
		// 수정
		$sql = " update {$g5['css_table']}
					set cs_value	= '{$cs_value[$i]}',
						cs_descript	= '{$cs_descript[$i]}',
						cs_etc_1	= '{$cs_etc_1[$i]}',
						cs_etc_2	= '{$cs_etc_2[$i]}',
						cs_etc_3	= '{$cs_etc_3[$i]}',
						cs_etc_4	= '{$cs_etc_4[$i]}',
						cs_etc_5	= '{$cs_etc_5[$i]}',
						cs_etc_6	= '{$cs_etc_6[$i]}',
						cs_etc_7	= '{$cs_etc_7[$i]}',
						cs_etc_8	= '{$cs_etc_8[$i]}',
						cs_etc_9	= '{$cs_etc_9[$i]}',
						cs_etc_10	= '{$cs_etc_10[$i]}'
					where cs_id = '{$de['cs_id']}'
		";
		sql_query($sql);

	} else {
		// 입력
		$sql = " insert into {$g5['css_table']}
					set cs_name		= '{$cs_name[$i]}',
						cs_value	= '{$cs_value[$i]}',
						cs_descript	= '{$cs_descript[$i]}',
						cs_etc_1	= '{$cs_etc_1[$i]}',
						cs_etc_2	= '{$cs_etc_2[$i]}',
						cs_etc_3	= '{$cs_etc_3[$i]}',
						cs_etc_4	= '{$cs_etc_4[$i]}',
						cs_etc_5	= '{$cs_etc_5[$i]}',
						cs_etc_6	= '{$cs_etc_6[$i]}',
						cs_etc_7	= '{$cs_etc_7[$i]}',
						cs_etc_8	= '{$cs_etc_8[$i]}',
						cs_etc_9	= '{$cs_etc_9[$i]}',
						cs_etc_10	= '{$cs_etc_10[$i]}'";
		sql_query($sql);
	}
}



// CSS 설정 파일 생성
$css_data_path = G5_DATA_PATH."/css";
$css_data_url = G5_DATA_URL."/css";

@mkdir($css_data_path, G5_DIR_PERMISSION);
@chmod($css_data_path, G5_DIR_PERMISSION);

$file = '../'.G5_DATA_DIR.'/css/_design.config.css';
$file_path = $css_data_path.'/_design.config.css';
unlink($file_path);
$f = @fopen($file, 'a');

ob_start();
include("./design_form_css.php");
$css = ob_get_contents();
ob_end_flush();
fwrite($f,$css);
fclose($f);
@chmod($file, G5_FILE_PERMISSION);


goto_url('./design_form.php', false);
?>