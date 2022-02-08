<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function autolink($str, $bo_table, $stx='')
{
	global $g5, $config;

	$str = ' ' . $str;

	$str = str_replace("&#039;", "'", $str);
	$str = str_replace("&#034;", "&quot;", $str);

	
	// 일반링크 설정
	$str = preg_replace(
		'`<a href="([^" ]*)"[^.]*>\S*<\/a>`i',
		'<a href="$1" target="_blank" class="other-site-link">Link URL</a>',
		$str
	);
	$str = substr($str, 1);

	// 해시태그 설정
	$hash_pattern = "/\\#([0-9a-zA-Z가-힣_])([0-9a-zA-Z가-힣_]*)/";
	$str = preg_replace($hash_pattern, '<a href="?bo_table='.$bo_table.'&amp;hash=%23$1$2" class="link_hash_tag">&#35;$1$2</a>', $str);

	// 로그링크 설정
	$log_pattern = "/\\@([0-9])([0-9]*)/";
	$str = preg_replace($log_pattern, '<a href="?bo_table='.$bo_table.'&amp;log=$1$2&amp;single=Y" target="_blank" class="log_link_tag">$1$2</a>', $str);

	// 콜링 설정
	$str = str_replace("[[", "<span class='member_call'>", $str);
	$str = str_replace("]]", "</span>", $str);

	return $str;
}

function get_sql_search_mmb($search_ca_name, $search_field, $search_text, $search_hash, $search_operator='and', $log_num = '', $single_use= '')
{
	global $g5;

	$str = " wr_ing = 0 ";
	if ($search_ca_name) {
		if($str) $str .= " and ";
		$str .= " ca_name = '$search_ca_name' ";
	}

	if($search_hash) {
		if($str) $str .= " and ";
		$str .= "wr_content like '%{$search_hash}%' ";
	}

	if($log_num) { 
		if($str) $str .= " and ";
		$str .= "wr_num >= ".($log_num * -1)." ";

		if($single_use) { 
			if($str) $str .= " and ";
			$str .= "wr_num < ".(($log_num * -1) + 1)." ";
		}
	}

	$search_text = strip_tags(($search_text));
	$search_text = trim(stripslashes($search_text));

	if (!$search_text) {
		if ($search_ca_name || $search_hash || $log_num) {
			return $str;
		} else {
			return '0';
		}
	}

	if ($str)
		$str .= " and ";

	// 쿼리의 속도를 높이기 위하여 ( ) 는 최소화 한다.
	$op1 = "";

	// 검색어를 구분자로 나눈다. 여기서는 공백
	$s = array();
	$s = explode(" ", $search_text);

	// 검색필드를 구분자로 나눈다. 여기서는 +
	$tmp = array();
	$tmp = explode(",", trim($search_field));
	$field = explode("||", $tmp[0]);
	$not_comment = "";
	if (!empty($tmp[1]))
		$not_comment = $tmp[1];

	$str .= "(";
	for ($i=0; $i<count($s); $i++) {
		// 검색어
		$search_str = trim($s[$i]);
		if ($search_str == "") continue;

		// 인기검색어
		insert_popular($field, $search_str);

		$str .= $op1;
		$str .= "(";

		$op2 = "";
		for ($k=0; $k<count($field); $k++) { // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)

			// SQL Injection 방지
			// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
			$field[$k] = preg_match("/^[\w\,\|]+$/", $field[$k]) ? $field[$k] : "wr_subject";

			$str .= $op2;
			switch ($field[$k]) {
				case "mb_id" :
				case "wr_name" :
					$str .= " ( $field[$k] = '$s[$i]' ";
					$str .= " and wr_noname = '0' ) ";
					break;
				case "wr_subject" : 
					if (preg_match("/[a-zA-Z]/", $search_str))
						$str .= "( INSTR(LOWER($field[$k]), LOWER('$search_str')) and wr_noname = '0' )";
					else
						$str .= "( $field[$k] like '%{$search_str}%' and wr_noname = '0' )";

					break;
				case "wr_hit" :
				case "wr_good" :
				case "wr_nogood" :
					$str .= " $field[$k] >= '$s[$i]' ";
					break;
				// 번호는 해당 검색어에 -1 을 곱함
				case "wr_num" :
					$str .= "$field[$k] = ".((-1)*$s[$i]);
					break;
				case "wr_ip" :
				case "wr_password" :
					$str .= "1=0"; // 항상 거짓
					break;
				// LIKE 보다 INSTR 속도가 빠름
				default :
					if (preg_match("/[a-zA-Z]/", $search_str))
						$str .= "INSTR(LOWER($field[$k]), LOWER('$search_str'))";
					else
						$str .= "$field[$k] like '%{$search_str}%'";
					break;
			}
			$op2 = " or ";
		}
		$str .= ")";

		$op1 = " $search_operator ";
	}
	$str .= " ) ";
	if ($not_comment)
		$str .= " and wr_is_comment = '0' ";

	return $str;
}

?>