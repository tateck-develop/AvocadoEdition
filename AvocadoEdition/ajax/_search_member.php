<?
include_once("./_common.php");


if(!$is_member) { 
	echo "<ul><li class='no-data'>회원만 검색 가능합니다.</li></ul>";
} else {
	if($keyword == "") { 
		echo "<ul><li class='no-data'>키워드를 입력해 주시길 바랍니다.</li></ul>";
	} else {
		echo "<ul>";
		$sql = " select mb_nick, mb_name, mb_id, ch_id from {$g5['member_table']} where mb_name like '%{$keyword}%' and mb_level > 1 order by mb_nick asc";
		$result = sql_query($sql);
		for($i=0; $row = sql_fetch_array($result); $i++) {
			$ch = sql_fetch("select ch_thumb, ch_name from {$g5['character_table']} where ch_id = '{$row['ch_id']}'");
	?>
				<li>
					<a href="#" onclick="select_item('<?=$list_obj?>', '<?=$input_obj?>', '<?=$row['mb_name']?>', '<?=$output_obj?>', '<?=$row['mb_id']?>'); return false;">
						<div class="ui-thumb">
							<img src="<?=$ch['ch_thumb']?>">
						</div>
						<div class="ui-info">
							<p class="point"><strong>대표캐릭명</strong>: <?=$ch['ch_name'] ? $ch['ch_name'] : "보유캐릭터 없음"?></p>
							<p><strong>오너명</strong>: <?=$row['mb_name']?></p>
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