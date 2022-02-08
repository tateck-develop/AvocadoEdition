<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$memo_custom_sql = '';

// ******************** 호출 관련, 호출 시 알람테이블에 기재한다. 확인은 Y / N
// 멤버 닉네임 서칭
// -- 치환 문자로 사용될 문자가 본문에 사용 시 지워준다. (오류 방지)
$str = str_replace("||", "", $wr_content);
$str = str_replace("&&", "", $str);

// -- 괄호를 치환한다.
$str = str_replace("[[", "||&&", $str);
$str = str_replace("]]", "&&", $str);

// explode 로 해당 문자만 추출 할 수 있도록 작업한다.
$str = explode("||", $str);
// -- 추출한 배열을 토대로 정규식으로 닉네임을 추출한다.

$call_pattern = "/&&(.*)&&/";
$mb_nick_array = array();

for($i=0; $i < count($str); $i++) { 
	preg_match_all($call_pattern, $str[$i], $matches);
	if($matches[1]) {
		$mb_nick_array[] = $matches[1][0];
	}
}

// 배열 중복값 처리
$mb_nick_array = array_unique($mb_nick_array);


if(count($mb_nick_array) > 0) { 
	// -- 괄호를 치환한다.
	$memo = str_replace("[[", "", $wr_content);
	$memo = str_replace("]]", "", $memo);

	for($i=0; $i < count($mb_nick_array); $i++) { 
		// 회원 정보 있는지 여부 확인
		$memo_search = sql_fetch("select mb_id, mb_name from {$g5['member_table']} where mb_nick = '{$mb_nick_array[$i]}' or  mb_name = '{$mb_nick_array[$i]}'");
		if($memo_search['mb_id']) { 
			// 회원정보가 있을 시, 알람테이블에 저장한다.
			// 저장하기 전에 동일한 정보가 있는지 확인한다.
			// 저장정보 : wr_id / wr_num / bo_table/ mb_id / mb_name / re_mb_id / re_mb_name / ch_side / memo / bc_datetime

			$bc_sql_common = "
				wr_id = '{$temp_wr_id}',
				wr_num = '{$wr_num}',
				bo_table = '{$bo_table}',
				mb_id = '{$member[mb_id]}',
				mb_name = '{$member[mb_nick]}',
				re_mb_id = '{$memo_search['mb_id']}',
				re_mb_name = '{$memo_search['mb_name']}',
				ch_side = '{$character[ch_side]}',
				memo = '{$memo}',
				bc_datetime = '".G5_TIME_YMDHIS."'
			";

			
			// 동일 정보 있는지 확인 - wr_id/ bo_table / re_mb_id 로 판별
			$bc = sql_fetch(" select bc_id from {$g5['call_table']} where wr_id= '{$temp_wr_id}' and bo_table= '{$bo_table}' and re_mb_id = '{$memo_search[mb_id]}' and mb_id = '{$member[mb_id]}' ");
			
			if($bc['bc_id']) { 
				// 정보가 있을 경우
				$sql = " update {$g5['call_table']} set {$bc_sql_common} where bc_id = '{$bc[bc_id]}' ";
				sql_query($sql);
			} else { 
				// 정보가 없을 경우
				$sql = " insert into {$g5['call_table']} set {$bc_sql_common} ";
				sql_query($sql);

				// 회원 테이블에서 알람 업데이트를 해준다.
				// 실시간 호출 알림 기능
				$log_link = G5_BBS_URL."/board.php?bo_table=".$bo_table."&log=".($wr_num * -1);
				$sql = " update {$g5['member_table']} 
							set mb_board_call = '".$member['mb_nick']."',
								mb_board_link = '{$log_link}'
						where mb_id = '".$memo_search['mb_id']."' ";
				sql_query($sql);
			}
		} else { 
			// 회원정보가 없을 시, content 에 해당 닉네임을 블러 처리 하고
			// content 를 업데이트 한다.
			$wr_content = str_replace("[[".$mb_nick_array[$i]."]]", "[[???]]", $wr_content);
			$memo_custom_sql .= " , wr_content = '{$wr_content}' ";
		}
	}
}
// ******************** 호출 관련, 호출 시 해당 멤버에게 쪽지 보내기 기능 종료

if($w != 'cu') {
	$customer_sql = "
		{$memo_custom_sql}
	";

	if($use_item) { 
		$it = sql_fetch("select it.it_type, it.it_use_ever, it.it_name, it.it_id, it.it_value, it.it_content, it.it_content2 from {$g5[item_table]} it, {$g5[inventory_table]} inven where inven.in_id = '{$use_item}' and inven.it_id = it.it_id");

		// 아이템 제거
		if(!$it['it_use_ever']) { 
			// 영구성 아이템이 아닐 시, 사용했을 때 인벤에서 제거한다.
			delete_inventory($use_item);
		}
		
		// 아이템이 뽑기 아이템의 경우 
		if($it['it_type'] == '뽑기') { 
			$seed = rand(0, 100);

			// 템 검색 시작
			$item_result = sql_fetch("
				select re_it_id as it_id
					from {$g5[explorer_table]}
					where	it_id = '".$it['it_id']."'
						and (ie_per_s <= '{$seed}' and ie_per_e >= '{$seed}')
					order by RAND()
					limit 0, 1
			");
			
			if($item_result['it_id']) {
				// 아이템 획득에 성공한 경우, 해당 아이템을 인벤토리에 삽입
				// 아이템 획득에 성공 시
				$item_result['it_name'] = get_item_name($item_result['it_id']);
				$inven_sql = " insert into {$g5[inventory_table]}
						set ch_id = '{$character[ch_id]}',
							it_id = '{$item_result[it_id]}',
							it_name = '{$item_result[it_name]}',
							ch_name = '{$character[ch_name]}'";
				sql_query($inven_sql);
				$in_id = mysql_insert_id();

				$item_log = "S||".$it['it_id']."||".$it['it_name']."||".$item_result['it_id']."||".$item_result['it_name'];
			} else { 
				$item_log = "F||".$it['it_id']."||".$it['it_name'];
			}
		} else {
			// 일반 아이템의 경우, 기본 사용 로그를 반환한다.
			$item_log = "D||".$it['it_id']."||".$it['it_name']."||".$it['it_type']."||".$it['it_value']."||".$it['it_content']."||".$it['it_content2'];
		}
		$customer_sql .= " , wr_item = '{$it[it_id]}', wr_item_log = '{$item_log}'";

	}

	if($game == "dice") {
		// 주사위 굴리기
		$dice1 = rand(1, 6);
		$dice2 = rand(1, 6);
		$customer_sql .= " , wr_dice1 = '{$dice1}',  wr_dice2 = '{$dice2}'";
	}


/******************************************************************************************
	RANDOM DICE 추가부분 
******************************************************************************************/
	if($random_game) {
		// 랜덤 게임 선택 시
		// 랜덤 지령 가져오기
		$random = sql_fetch("select * from {$g5['random_table']} where ra_id = '{$random_game}'");
		$rand_img = nl2br($random['ra_img']);
		$rand_img = explode('<br />', $rand_img);
		$rand_img = array_values(array_filter(array_map('trim',$rand_img)));

		$rand_text = nl2br($random['ra_text']);
		$rand_text = explode('<br />', $rand_text);
		$rand_text = array_values(array_filter(array_map('trim',$rand_text)));

		$rand_img_seed = rand(0, count($rand_img)-1);
		$rand_text_seed = rand(0, count($rand_text)-1);

		$customer_sql .= " , wr_random_dice = '".$rand_img[$rand_img_seed]."||".$rand_text[$rand_text_seed]."' ";

		// 랜덤 다이스 필드가 존재하지 않을 경우
		$temp = sql_fetch("select * from {$write_table}");
		if(!isset($temp['wr_random_dice'])) { 
			sql_query(" ALTER TABLE `{$write_table}` ADD `wr_random_dice` varchar(255) NOT NULL DEFAULT '' AFTER `wr_10` ");
		}
		unset($temp);
	}
/******************************************************************************************
	RANDOM DICE 추가부분 종료
******************************************************************************************/



	$log = "";

	//--------------------------------------------------------
	//	탐색 : 아이템 사용 없이 행위만으로 아이템 획득 가능
	// - 아이템 획득 제한 체크 필요
	//----------------------------------------------------------
	if($action == 'S') {
		
		if($character['ch_search'] < $config['cf_search_count']) {
			// 탐색 횟수가 하루탐색 횟수를 초과하지 않은 경우
			// 주사위 굴리기
			$seed = rand(0, 100);
			
			// 나온 숫자의 구간에 해당하는 아이템 중, 하나를 선택한다.
			$item_result = sql_fetch("
				select it_id, it_name 
					from {$g5['item_table']}
					where
							it_use = 'Y'
						and	it_seeker = '1'
						and (it_seeker_per_s <= '{$seed}' and it_seeker_per_e >= '{$seed}')
					order by RAND()
					limit 0, 1
			");

			if($item_result['it_id']) {
				// 아이템 획득에 성공한 경우, 해당 아이템을 인벤토리에 삽입
				// 아이템 획득에 성공 시
				$inven_sql = " insert into {$g5['inventory_table']}
						set ch_id = '{$character[ch_id]}',
							it_id = '{$item_result[it_id]}',
							it_name = '{$item_result[it_name]}',
							ch_name = '{$character[ch_name]}'";
				sql_query($inven_sql);
				$in_id = mysql_insert_id();

				$log = $action."||S||".$item_result['it_id']."||".$item_result['it_name']."||".$in_id;
			} else { 
				$log = $action."||F";
			}

			// 탐색 횟수 업데이트
			sql_query("
				update {$g5['character_table']}
						set		ch_search = ch_search + 1,
								ch_search_date = '".G5_TIME_YMD."'
					where		ch_id = '{$character['ch_id']}'
			");

			$character['ch_search'] = $character['ch_search'] + 1;
			$customer_sql .= " , wr_log = '{$log}' ";
		}
	}

	//--------------------------------------------------------
	//	조합
	//----------------------------------------------------------
	if($action == 'H') { 
		// 재료 정보 : make_1, make_2, make_3
		$make_1 = sql_fetch("select inven.in_id, it.it_id, it.it_name, it.it_use_ever from {$g5['item_table']} it, {$g5['inventory_table']} inven where it.it_id = inven.it_id and inven.in_id = '{$make_1}'");
		$make_2 = sql_fetch("select inven.in_id, it.it_id, it.it_name, it.it_use_ever from {$g5['item_table']} it, {$g5['inventory_table']} inven where it.it_id = inven.it_id and inven.in_id = '{$make_2}'");
		$make_3 = sql_fetch("select inven.in_id, it.it_id, it.it_name, it.it_use_ever from {$g5['item_table']} it, {$g5['inventory_table']} inven where it.it_id = inven.it_id and inven.in_id = '{$make_3}'");

		$re_item[0] = $make_1[it_id];
		$re_item[1] = $make_2[it_id];
		$re_item[2] = $make_3[it_id];
		sort($re_item);
		$re_item_order = implode("||", $re_item);
		
		$re = sql_fetch("select it_id from {$g5['item_table']}_recepi where re_item_order = '{$re_item_order}' and re_use = '1'");;
		if(!$re[it_id]) {
			// 레시피 조합 실패
			$log = $action."||F||NON||NON||".$re_item_order;
		} else { 
			// 레시피 조합 성공
			$item = get_item($re[it_id]);

			$inven_sql = " insert into {$g5['inventory_table']}
						set ch_id = '{$character[ch_id]}',
							it_id = '{$item[it_id]}',
							it_name = '{$item[it_name]}',
							ch_name = '{$character[ch_name]}'";
			sql_query($inven_sql);
			$in_id = mysql_insert_id();

			$log = $action."||S||".$re[it_id]."||".$item[it_name]."||".$in_id."||".$re_item_order;
		}

		$customer_sql .= " , wr_log = '{$log}' ";

		if(!$make_1['it_use_ever']) { delete_inventory($make_1['in_id']); }
		if(!$make_2['it_use_ever']) { delete_inventory($make_2['in_id']); }
		if(!$make_3['it_use_ever']) { delete_inventory($make_3['in_id']); }
	}
}

?>

