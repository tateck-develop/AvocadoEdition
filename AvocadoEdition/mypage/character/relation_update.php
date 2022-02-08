<?php
include_once('./_common.php');

$ch = get_character($ch_id);
if($ch['mb_id'] != $member['mb_id']) { 
	alert("등록권한이 없습니다.");
}

if($w == '') { 
	// 신규 입력
	if(!$_POST['re_ch_id']) { 
		$re_ch = sql_fetch("select * from {$g5['character_table']} where ch_name = '{$search_re_ch_name}'");
		$_POST['re_ch_id'] = $re_ch['ch_id'];
	}

	$sql = " insert into {$g5['relation_table']}
				set ch_id = '{$_POST['ch_id']}',
					re_ch_id = '{$_POST['re_ch_id']}',
					rm_like = '{$_POST['rm_like']}',
					rm_link = '{$_POST['rm_link']}',
					rm_order = '{$_POST['rm_order']}',
					rm_memo = '{$_POST['rm_memo']}'";
	sql_query($sql);

} else if($w == 'u') { 
	// 수정사항
	$sql = " update {$g5['relation_table']}
				set rm_like = '{$_POST['rm_like']}',
					rm_link = '{$_POST['rm_link']}',
					rm_order = '{$_POST['rm_order']}',
					rm_memo = '{$_POST['rm_memo']}'
				where rm_id = '{$_POST['rm_id']}'
				";
	sql_query($sql);

}

goto_url('./viewer.php?ch_id='.$ch_id);
?>
