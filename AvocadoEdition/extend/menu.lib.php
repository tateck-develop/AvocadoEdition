<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 메뉴 클래스, 단계, 게시판 정보, 내용 정보, 기타 키워드, 메뉴타켓
function get_menu($class, $depth, $bo_table = '', $co_id = '', $keyword = '', $target=""){
	global $g5; 

	$menu_result = '';
	$menu_depth = 0;

	if(!$keyword) { $keyword = $_SERVER['REQUEST_URI']; }

	switch($depth) { 
		case '1' : 
			$menu_depth = 2;
		break;
		case '2' : 
			$menu_depth = 4;
		break;
		default:
			$menu_depth = 2;
		break;
	}

	if($menu_depth == 2) { 
		$menu_result = '<div class="'.$class.'"><ul>';
		// 1차 메뉴호출
		$sql = " select *
				from {$g5['menu_table']}
				where length(me_code) = '2'
				order by me_order, me_id ";
		$result = sql_query($sql, false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if($target) { 
				$row['me_target'] = $target;
			}

			if($row['me_target'] == 'self') { $row['me_target'] = ''; }
			else if($row['me_target'] == 'blank') $row['me_target'] = '_blank';

			$menu_result .= '<li><a href="'.$row['me_link'].'" target="'.$row['me_target'].'">'.$row['me_name'].'</a></li>';
		}
		$menu_result .= "</ul></div>";

	} else { 
		// 2차 메뉴 호출
		// 현재 메뉴의 위치 확인
		$pa_code = '';
		$now_code = '';
		$sql_where = '';

		if($bo_table) { 
			$sql_where = "me_link LIKE '%bo_table={$bo_table}%'";
		} else if($co_id) { 
			$sql_where = "me_link LIKE '%co_id={$co_id}%'";
		} else if($keyword) { 
			$sql_where = "me_link LIKE '%{$keyword}%'";
		}
		
		$pa_result = sql_fetch("select substring(me_code, 1, 2) as me_pa_code, me_code from {$g5['menu_table']} where {$sql_where} order by length(me_code) desc limit 0, 1");

		$pa_code = $pa_result['me_pa_code'];
		$now_code = $pa_result['me_code'];

		//메뉴호출
		$sql = " select *
				from {$g5['menu_table']}
				where length(me_code) = '4'
						and substring(me_code, 1, 2) = '{$pa_code}'
				order by me_order, me_id ";
		$result = sql_query($sql, false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if($i == 0) $menu_result = '<div class="'.$class.'"><ul>';
			if($row['me_target'] == 'self') { $row['me_target'] = ''; }
			else if($row['me_target'] == 'blank') $row['me_target'] = '_blank';

			if($row['me_code'] == $now_code)
				$class = 'on';
			else 
				$class = '';

			$menu_result .= '<li class="'.$class.'"><a href="'.$row['me_link'].'" target="'.$row['me_target'].'">'.$row['me_name'].'</a></li>';
		}

		if($i > 0)
			$menu_result .= "</ul></div>";
	}

	return $menu_result; // 메뉴 출력
}
?>