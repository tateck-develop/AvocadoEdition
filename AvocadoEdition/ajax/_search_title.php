<?
include_once("./_common.php");


if(!$is_member) { 
	echo "<ul><li class='no-data'>회원만 검색 가능합니다.</li></ul>";
} else {
	if($keyword == "") { 
		echo "<ul><li class='no-data'>키워드를 입력해 주시길 바랍니다.</li></ul>";
	} else {
		echo "<ul>";
		$sql = " select ti_id, ti_title, ti_img from {$g5['title_table']} where ti_title like '%{$keyword}%' order by ti_title asc";
		$result = sql_query($sql);
		for($i=0; $row = sql_fetch_array($result); $i++) {
	?>
				<li>
					<a href="#" onclick="select_item('<?=$list_obj?>', '<?=$input_obj?>', '<?=$row['ti_title']?>', '<?=$output_obj?>', '<?=$row['ti_id']?>'); return false;">
						<div class="ui-thumb">
							<img src="<?=$row['ti_img']?>">
						</div>
						<div class="ui-info">
							<p class="point"><strong>타이틀명</strong>: <?=$row['ti_title']?></p>
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