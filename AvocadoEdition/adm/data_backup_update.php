<?php
$sub_menu = "900400";
include_once("./_common.php");

function backup_tables($host,$user,$pass,$name,$tables = '*', $is_viewer = false) {
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);

	//get all of the tables
	if($tables == '*') {
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result)) {
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}

	foreach($tables as $table) {
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);

		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result)) {
				
				if($is_viewer && $row[0] != 'site_menu' && $row[0] != 'site_main') { 
					continue;
				}

				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ")[[avocado_end]]\n";
			}
		}
		$return.="\n\n\n";
	}

	$tables_code = str_replace(",", "_", $tables[0]);
	$tables_code = str_replace("*", "", $tables_code);

	$file_name = G5_ADMIN_PATH.'/backup/'.'data_backup_'.$tables_code.'_'.date('Ymd_His').'.sql';

	$handle = fopen($file_name,'w+');
	fwrite($handle,$return);
	fclose($handle);

	return $file_name;
}




if(!$category) {
	for($i = 0; $i < count($ba_cate); $i++) { 
		$category = $ba_cate[$i];
		$is_viewer = false;
		if($category == 'content') { $is_viewer = true; }
		$file_name = backup_tables(G5_MYSQL_HOST,G5_MYSQL_USER,G5_MYSQL_PASSWORD,G5_MYSQL_DB, G5_TABLE_PREFIX.$category, $is_viewer);
		$filepath = $file_name;

		$sql_common = " ba_cate            = '{$category}',
					ba_title            = '".date('Ymd_His', strtotime(G5_TIME_YMDHIS))."',
					ba_path            = '{$filepath}' ";

		$sql = " insert into {$g5['backup_table']}
				set $sql_common ";
		sql_query($sql);
	}

} else {
	$is_viewer = false;
	if($category == 'content') { $is_viewer = true; }
	$file_name = backup_tables(G5_MYSQL_HOST,G5_MYSQL_USER,G5_MYSQL_PASSWORD,G5_MYSQL_DB, G5_TABLE_PREFIX.$category, $is_viewer);
	$filepath = $file_name;

	$sql_common = " ba_cate            = '{$category}',
				ba_title            = '".date('Ymd_His', strtotime(G5_TIME_YMDHIS))."',
				ba_path            = '{$filepath}' ";

	$sql = " insert into {$g5['backup_table']}
			set $sql_common ";
	sql_query($sql);
}

goto_url('./data_backup.php');


?>