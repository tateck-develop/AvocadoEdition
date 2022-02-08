<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 지도 이미지는 따로 FTP를 통해 올려 준다.
// : 지도 이미지 경로 - 아보카도 에디션 설치 경로/img/img_map_pannel.png
// : 경로를 변경해주어도 무방하다. 54번 라인의 img 지도 이미지의 경로를 변경

// 맵 정보를 불러온다
$map_sql = "select * from {$g5['map_table']} order by ma_parent asc, ma_name asc ";
$map_result = sql_query($map_sql);

$map_w = 200;		// 지도 원본 가로 사이즈
$map_h = 200;		// 지도 원본 세로 사이즈 크기
?>


<div id="mmb_map_pannel">
	<div class="map-inner" style="max-width: <?=$map_w?>px;">
		<div class="pad">
<? for($i=0; $map = sql_fetch_array($map_result); $i++) {

	// 반응형 대응을 위한 각 위치의 좌표와 영역 크기는 % 로 처리 된다.
	$pos_w = $map['ma_width'] / $map_w * 100;
	$pos_h = $map['ma_height'] / $map_h * 100;

	$pos_t = $map['ma_top'] / $map_w * 100;
	$pos_l = $map['ma_left'] / $map_w * 100;

	$map_class = "";

	if($map['ma_id'] == $character['ma_id']) { 
		// 현재 캐릭터 위치와 동일한 좌표 영역일 경우
		// my 클리스를 추가한다.
		$map_class .=" my";
	}

	// 현재 위치에 있는 캐릭터
	// main 타입의 캐릭터들만 불러온다.
	$cnt = sql_fetch("select count(*) as cnt from {$g5['character_table']} where ch_type='main' and ma_id = '{$map['ma_id']}'");
	$cnt = $cnt['cnt'];

	if($cnt > 0) { 
		// 다른 위치에 존재하는 캐릭터가 있을 경구, other 클래스를 추가한다.
		$map_class .=" other";
	} else {
		$cnt = '';
	}

?>
			<div class="pin <?=$map_class?>" style="top:<?=$pos_t?>%; left:<?=$pos_l?>%; width:<?=$pos_w?>%; height:<?=$pos_h?>%;"><span><?=$cnt?></span></div>

<? } ?>
		</div>
		<img src="<?=G5_IMG_URL?>/img_map_pannel.png" alt="지도 이미지" />
	</div>
</div>

<style>

#mmb_map_pannel							{ position: relative; overflow: hidden; }
#mmb_map_pannel .map-inner				{ display: block; position: relative; margin: 20px auto; }
#mmb_map_pannel .map-inner .pad			{ display: block; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1; }
#mmb_map_pannel .map-inner > img		{ display: block; position: relative; z-index: 0; }
#mmb_map_pannel .map-inner .pin			{ display: block; position: absolute; }
#mmb_map_pannel .map-inner .pin.my		{ background: rgba(172, 34, 188, .8) !important; }
#mmb_map_pannel .map-inner .pin.other	{ background: rgba(18, 108, 138, .8); }
#mmb_map_pannel .map-inner .pin span	{ display: block; position: absolute; top: 50%; left: 0; right: 0; transform: translateY(-50%); font-size: 11px; text-align: center; }

</style>