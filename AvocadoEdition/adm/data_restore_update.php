<?php
$sub_menu = '900500';
include_once('./_common.php');


for($k = 0; $k < count($ba_cate); $k++) {
	$cate = $ba_cate[$k];
	$file_name = $ba_path[$k];

	if($file_name) { 

		$file = implode('', file($file_name));
		eval("\$file = \"$file\";");
		$f = explode('[[avocado_end]]', $file);

		if(count($f) > 0) { 

			if($cate == 'content') {
				sql_query("delete from {$g5['content_table']} where co_id = 'site_menu' or co_id = 'site_main'");
			} else {
				sql_query("delete from ".G5_TABLE_PREFIX.$cate);
			}

			for ($i=0; $i<count($f); $i++) {
				if (trim($f[$i]) == '') continue;
				sql_query($f[$i], false);
			}
		}

	}
}


goto_url("./data_restore.php");
?>
