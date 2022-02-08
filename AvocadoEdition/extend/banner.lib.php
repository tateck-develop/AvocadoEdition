<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 배너출력
// 스킨, 슬라이드 이펙트(slide/fade), 슬라이드 속도, 자동재생 여부(true/false), 슬라이드 방향 (default/alter), 컨트롤 출력여부(true/false), 애니메이션 속도
function display_banner($skin='', $start=true, $effect='slide', $speed='3000', $mode='default', $control=true, $animationspeed='700')
{
	global $g5;


	
	if (!$skin_dir) $skin_dir = 'basic';

	$banner_skin_path = G5_SKIN_PATH.'/banner/'.$skin_dir;
	$banner_skin_url  = G5_SKIN_URL.'/banner/'.$skin_dir;

	$cache_fwrite = false;
	if(G5_USE_CACHE) {
		$cache_file = G5_DATA_PATH."/cache/banner-{$skin_dir}.php";

		if(!file_exists($cache_file)) {
			$cache_fwrite = true;
		} else {
			if($cache_time > 0) {
				$filetime = filemtime($cache_file);
				if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
					@unlink($cache_file);
					$cache_fwrite = true;
				}
			}

			if(!$cache_fwrite)
				include($cache_file);
		}
	}

	if(!G5_USE_CACHE || $cache_fwrite) {
		$banner = array();

		$sql = " select * from {$g5['banner_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time order by bn_order, bn_id desc ";
		$result = sql_query($sql);
		for ($i=0; $row = sql_fetch_array($result); $i++) {
			$banner[$i] = $row;
		}

		if($cache_fwrite) {
			$handle = fopen($cache_file, 'w');
			$cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;?>";
			fwrite($handle, $cache_content);
			fclose($handle);
		}
	}


	ob_start();
	include $banner_skin_path.'/banner.skin.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

?>