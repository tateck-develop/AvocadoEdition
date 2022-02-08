<?
include_once("./_common.php");


if(!$is_member) { 
	echo "<ul><li class='no-data'>회원만 검색 가능합니다.</li></ul>";
} else {
	if($keyword == "") { 
		echo "<ul><li class='no-data'>키워드를 입력해 주시길 바랍니다.</li></ul>";
	} else {
		echo "<ul>";
		$sql = " select it_img, it_name, it_id, it_content from {$g5['item_table']} where it_name like '%{$keyword}%'";
		
		if($option) { 
			if($option == '뽑기') { 
				$sql .= " and it_type = '{$option}'";
			} else if($option == '레시피') {
				$sql .= " and it_use_recepi = '1'";
			}
		}
		$sql .= "order by it_name asc";
		$result = sql_query($sql);
		for($i=0; $row = sql_fetch_array($result); $i++) {
	?>
				<li>
					<a href="#" onclick="select_item('<?=$list_obj?>', '<?=$input_obj?>', '<?=$row['it_name']?>', '<?=$output_obj?>', '<?=$row['it_id']?>'); return false;">
						<div class="ui-thumb">
							<img src="<?=$row['it_img']?>">
						</div>
						<div class="ui-info">
							<p class="point"><strong>아이템</strong>: <?=$row['it_name']?></p>
							<p><strong>설명</strong>: <?=$row['it_content']?></p>
						</div>
					</a>
				</li>
	<?
		}
		if($i==0) { 
			echo "<li class='no-data'>[ ".$keyword." ]에 대한 검색결과가 존재하지 않습니다.</li>";
		}
		echo "</ul>";
	}
}
?>