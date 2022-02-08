<?php
$sub_menu = '400100';
include_once('./_common.php');
check_demo();
auth_check($auth[$sub_menu], 'd');
check_token();

// 기본 프로필 양식 등록
$profile = sql_fetch(" select ad_id from {$g5['article_default_table']} ");

$ad_help_thumb = htmlspecialchars ($ad_help_thumb, ENT_QUOTES);
$ad_help_head = htmlspecialchars ($ad_help_head, ENT_QUOTES);
$ad_help_body = htmlspecialchars ($ad_help_body, ENT_QUOTES);
$ad_help_name = htmlspecialchars ($ad_help_name, ENT_QUOTES);

if($profile['ad_id']) {
	//  업데이트
	$sql = " update {$g5['article_default_table']}
			set ad_use_thumb	= '$ad_use_thumb',
				ad_use_head		= '$ad_use_head',
				ad_use_body		= '$ad_use_body',
				ad_use_name		= '$ad_use_name',
				ad_text_thumb	= '$ad_text_thumb',
				ad_text_head	= '$ad_text_head',
				ad_text_body	= '$ad_text_body',
				ad_text_name	= '$ad_text_name',
				ad_help_thumb	= '$ad_help_thumb',
				ad_help_head	= '$ad_help_head',
				ad_help_body	= '$ad_help_body',
				ad_help_name	= '$ad_help_name',
				ad_url_thumb	= '$ad_url_thumb',
				ad_url_head		= '$ad_url_head',
				ad_url_body		= '$ad_url_body',

				ad_use_title	= '$ad_use_title',
				ad_use_closet	= '$ad_use_closet',
				ad_use_inven	= '$ad_use_inven',
				ad_use_money	= '$ad_use_money',
				ad_use_exp		= '$ad_use_exp',
				ad_use_rank		= '$ad_use_rank',
				ad_use_status	= '$ad_use_status'
	";
	sql_query($sql);

} else {
	// 신규등록
	$sql = " insert into {$g5['article_default_table']}
			set ad_use_thumb	= '$ad_use_thumb',
				ad_use_head		= '$ad_use_head',
				ad_use_body		= '$ad_use_body',
				ad_use_name		= '$ad_use_name',
				ad_text_thumb	= '$ad_text_thumb',
				ad_text_head	= '$ad_text_head',
				ad_text_body	= '$ad_text_body',
				ad_text_name	= '$ad_text_name',
				ad_help_thumb	= '$ad_help_thumb',
				ad_help_head	= '$ad_help_head',
				ad_help_body	= '$ad_help_body',
				ad_help_name	= '$ad_help_name',
				ad_url_thumb	= '$ad_url_thumb',
				ad_url_head		= '$ad_url_head',
				ad_url_body		= '$ad_url_body',

				ad_use_title	= '$ad_use_title',
				ad_use_closet	= '$ad_use_closet',
				ad_use_inven	= '$ad_use_inven',
				ad_use_money	= '$ad_use_money',
				ad_use_exp		= '$ad_use_exp',
				ad_use_rank		= '$ad_use_rank',
				ad_use_status	= '$ad_use_status'
	";

	sql_query($sql);
}
// -------------- 기본 프로필 양식 등록

// 추가 프로필 양식 수정
for($i=0; $i < count($ar_id); $i++) {
	
	$ar = sql_fetch(" select ar_code from {$g5['article_table']} where ar_id = '{$ar_id[$i]}' and ar_theme= '{$ar_theme[$i]}");

	if($ar_code[$i] == '') { 
		
		// 등록된 캐릭터의 항목값 삭제
		 $sql = " delete from {$g5['value_table']} where ar_code = '{$ar['ar_code']}' ";
		sql_query($sql);

		// 등록된 항목 삭제
		 $sql = " delete from {$g5['article_table']} where ar_id = '{$ar_id[$i]}' ";
		sql_query($sql);

	} else {
		
		if($ar['ar_code'] != $ar_code[$i]) {
			// 코드 항목명 변경
			// 등록된 캐릭터 항목값의 항목코드 변경
			$sql = " update {$g5['value_table']}
					set ar_code	= '{$ar_code[$i]}'
					where ar_code = '{$ar['ar_code']}'
			";
			sql_query($sql);
		}

		$ar_help[$i] = htmlspecialchars ($ar_help[$i], ENT_QUOTES);

		//  업데이트
		$sql = " update {$g5['article_table']}
				set ar_code = '{$ar_code[$i]}',
					ar_theme = '{$ar_theme[$i]}',
					ar_name = '{$ar_name[$i]}',
					ar_type = '{$ar_type[$i]}',
					ar_size = '{$ar_size[$i]}',
					ar_text = '{$ar_text[$i]}',
					ar_help = '{$ar_help[$i]}',
					ar_order = '{$ar_order[$i]}',
					ar_secret = '{$ar_secret[$i]}'
				where ar_id = '{$ar_id[$i]}'
		";
		sql_query($sql);
	}
}

goto_url('./character_article_list.php?'.$qstr);
?>