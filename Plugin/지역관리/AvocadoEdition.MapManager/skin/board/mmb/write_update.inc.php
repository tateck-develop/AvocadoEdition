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

	/******************************************************
		위치이동 커맨드 추가
	******************************************************/	
	if($action == 'MAP') { 
		
		// 위치이동 선택 시, 선택한 위치를 이동한다.
		// 이동 지역 정보 받아오기
		$ma = sql_fetch("select * from {$g5['map_table']} where ma_id = '{$re_ma_id}'");
		if($ma['ma_id']) { 
			// 위치정보가 정상적으로 넘어왔을 시
			// 지역 변동내역을 캐릭터 정보에 추가한다.
			$sql = " update {$g5['character_table']}
						set ma_id = '{$ma['ma_id']}'
					  where ch_id = '{$character['ch_id']}' ";
			sql_query($sql);
			$character['ma_id'] = $ma['ma_id'];

			$m_re_type = "F";		// 이벤트 타입 저장
			$event_log_conttent = ""; // 이벤트 로그 내용

			// 이벤트를 검색한다.
			// 이벤트 검색 시작
			$seed = rand(0, 100);

			$me = sql_fetch("
				select *
					from {$g5[map_event_table]}
					where	ma_id = '".$ma['ma_id']."'
						and (me_per_s <= '{$seed}' and me_per_e >= '{$seed}')
						and me_use = '1'
						and (me_replay_cnt = 0 or me_replay_cnt > me_now_cnt)
					order by RAND()
					limit 0, 1
			");
			
			if($me['me_id']) {
				// 이벤트 획득에 성공한 경우, 해당 이벤트를 실행한다.
				// 이벤트 획득 카운터 추가
				$sql = " update {$g5['map_event_table']}
							set me_now_cnt = me_now_cnt+1
						  where me_id = '{$me['me_id']}' ";
				sql_query($sql);

				if($me['me_type'] == '') { 
					// 일반 텍스트 출력
					$m_re_type = "D";

				} else if($me['me_type'] == '아이템') { 
					// 아이템 획득
					$m_re_type = "I";

					// 아이템 획득에 성공한 경우, 해당 아이템을 인벤토리에 삽입
					// 아이템 획득에 성공 시
					$item_result = get_item($me['me_get_item']);
					$inven_sql = " insert into {$g5[inventory_table]}
							set ch_id = '{$character[ch_id]}',
								it_id = '{$item_result[it_id]}',
								it_name = '{$item_result[it_name]}',
								ch_name = '{$character[ch_name]}'";
					sql_query($inven_sql);
					$in_id = mysql_insert_id();
					$event_log_conttent = $item_result[it_name].j($item_result[it_name], '을')." 획득했다!";

				} else if($me['me_type'] == '화폐') { 
					// 소지금 변동
					$m_re_type = "G";
					insert_point($member['mb_id'], $me['me_get_money'], "이벤트 발생!", 'money', time(), '이벤트');

					if($me['me_get_money'] < 0) { 
						$event_log_conttent = ($me['me_get_money'] * -1).$config['cf_money'].j($config['cf_money'], '을')." 잃었다.";
					} else {
						$event_log_conttent = $me['me_get_money'].$config['cf_money'].j($config['cf_money'], '을')." 획득했다!";
					}
				} else if($me['me_type'] == '이동') { 
					// 지역 이동
					$m_re_type = "W";
					$m_map = sql_fetch("select ma_name from {$g5['map_table']} where ma_id = '{$me['me_move_map']}'");

					// 지역 변동내역을 캐릭터 정보에 추가한다.
					$sql = " update {$g5['character_table']}
								set ma_id = '{$me['me_move_map']}'
							  where ch_id = '{$character['ch_id']}' ";
					sql_query($sql);
					$character['ma_id'] = $me['me_move_map'];

					$event_log_conttent = "[".$m_map['ma_name']."] 구역으로 이동되었다!";

				} else if($me['me_type'] == '몬스터') { 
					// 몬스터 출현
					$m_re_type = "M";

					$temp_check = sql_fetch("select * from {$write_table}");
					if(!isset($temp_check['wr_mon_state'])) { 
						sql_query(" ALTER TABLE `{$write_table}` ADD `wr_mon_state` varchar(255) NOT NULL default '' AFTER `wr_10` ");
						sql_query(" ALTER TABLE `{$write_table}` ADD `wr_mon_hp` int(11) NOT NULL default '0' AFTER `wr_10` ");
						sql_query(" ALTER TABLE `{$write_table}` ADD `wr_mon_now_hp` int(11) NOT NULL default '0' AFTER `wr_10` ");
						sql_query(" ALTER TABLE `{$write_table}` ADD `wr_mon_attack` int(11) NOT NULL default '0' AFTER `wr_10` ");
					}
					unset($temp_check);

					// 몬스터 상태 추가
					$customer_sql .= " , wr_mon_state='S', wr_mon_hp='{$me['me_mon_hp']}', wr_mon_now_hp='{$me['me_mon_hp']}', wr_mon_attack='{$me['me_mon_attack']}' ";
				}
			}

			$log = $action."||{$ma['ma_id']}||{$m_re_type}||{$me['me_id']}||{$event_log_conttent}";
			$customer_sql .= " , wr_log = '{$log}' ";
			$customer_sql .= " , ma_id = '{$character['ma_id']}' ";
		}
	}
	if($action == 'MAP_MON') { 
		// 위치 이동 시, 몬스터가 떴을 경우 몬스터 이벤트 처리
		// :: 현재 공격력 산정은 주사위 2개를 굴려서 나오는 합으로 처리 되고 있습니다.
		// 몬스터 공격력
		// 몬스터 hp 체크 - 끝나면 엔딩 표기
		// 유저 HP 체크 (현재 플러그인 배포 버전에서는 hp 처리 하는 부분 제외, 필요 시 추가 커스텀 필요)
		// 몬스터 딜 체크 필요
		$origin = sql_fetch("select * from {$write_table} where wr_id = '{$wr_id}'");
		$mon_hp = $origin['wr_mon_now_hp'];
		$mon_attack = $origin['wr_mon_attack'];
		$mon_state = $origin['wr_mon_state'];

		/*********************************
			공격력 산출 부분
			: 커뮤니티의 공격력 산출 공식에 맞게 변경하세요
		*********************************/
		$dice_attack1 = rand(1, 6);		// 첫번째 주사위
		$dice_attack2 = rand(1, 6);		// 두번째 주사위
		$attack = $dice_attack1 + $dice_attack2;		// 주사위1 + 주사위2 = 공격력

		// $it : 위쪽에서 아이템 사용하기에서 설정 된 사용된 아이템 정보가 들어있는 변수
		// 아이템 효과 : 공격력추가 기능을 설정 시, 공격력이 추가 된 수치를 얻을 수 있음, 추가되는 공격력 수치는 아이템관리-적용값에 설정된 값
		$item_attack = 0;				// 아이템으로 추가 되는 공격력 수치
		if($it['it_type'] == '공격력추가') {
			$item_attack = $it['it_value'];
			$attack += $item_attack; // 기존의 공격력 합산에 아이템 공격력을 추가한다.
		}

		// 최종 몬스터에게 입힌 데미지 산출 공식
		$result_attack = $mon_attack - $attack;		// 몬스터 반격치에서 최종 공격력 수치를 제외한다.

		if($mon_hp < 1) { break; } // 몬스터 HP가 0일 경우 탈출! 

		if($result_attack > 0) {
			// 몬스터의 공격력 > 유저의 공격력

			/****************************************************************************************
				유저의 HP를 차감하는 공식이 추가 되어야 하는 부분

				* 커스텀된 소스를 추가하세요

			****************************************************************************************/

		} else if($result_attack < 0) { 
			// 몬스터의 공격력 < 유저의 공격력

			$mon_hp = $mon_hp + $result_attack;
			if($mon_hp < 0) {
				// 막타일 경우 이벤트 종료 선언
				$mon_hp = 0;
				$mon_state = 'E';
			}
			$sql = " update {$write_table}
					set wr_mon_now_hp = '{$mon_hp}',
						wr_mon_state = '{$mon_state}'
				  where wr_id = '{$wr_id}' ";
			sql_query($sql);
		}

		$log = $action."||{$mon_state}||".$mon_attack."||".$attack."||유저의HP정보||".$dice_attack1."+".$dice_attack2."+".$item_attack;
		$customer_sql .= " , wr_log = '{$log}' ";
	}
	
	/******************************************************
		위치이동 커맨드 추가 종료
	******************************************************/	
}

?>

