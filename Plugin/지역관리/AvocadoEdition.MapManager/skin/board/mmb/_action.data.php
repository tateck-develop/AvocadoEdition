<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

/*
LOG HashGuide

- 로그타입
1. S : 탐색 (성공여부, 획득아이템 ID, 획득아이템이름, 인벤 ID)
2. A : 공격 (상대 ID, 상대 두상, 데미지)
3. D : 방어 (상대 ID, 상대 두상, 방어율)
4. U : 강화 (성공여부, 원래강화레벨, 현재강화레벨)
5. H : 조합 (성공여부, 결과 아이템 ID, 인벤 ID, 조합 아이템 ID)
*/

$data_log = explode("||", $data_log);
$log_type = $data_log[0];

$item_log = explode("||", $item_log);

if($log_type == 'S') { 
	/** 탐색 로그 출력 **/
	include($board_skin_path."/action/log.seeker.skin.php");
}
if($log_type == 'H') { 
	/** 조합 로그 출력 **/
	include($board_skin_path."/action/log.handmade.skin.php");
}

/******************************************************
		위치이동 커맨드 추가
******************************************************/	
if($log_type == 'MAP') { 
	/** 맵 로그 출력 **/
	include($board_skin_path."/action/log.map.skin.php");
}
if($log_type == 'MAP_MON') { 
	/** 맵 몬스터 이벤트 출력 **/
	include($board_skin_path."/action/log.map_mon.skin.php");
}
/******************************************************
		위치이동 커맨드 추가 종료
******************************************************/	


if($item_log[0]) { 
	/** 아이템 사용시 **/
	include($board_skin_path."/action/log.item.skin.php");
}

?>