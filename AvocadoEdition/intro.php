<? 
if (!defined('_GNUBOARD_')) exit;

if(!$_COOKIE['intro_close']) { 
	$sql = " select * from {$g5['intro_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time order by bn_order, bn_id desc ";
	$result = sql_query($sql);
	$intro = array();
	for ($i=0; $row = sql_fetch_array($result); $i++) {
		$intro[$i] = $row;
	}

	if(count($intro) > 0) { 
		add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.intro.css">', 0);
	?>
	<div id="intro_wrap">
	<? for($i=0; $i < count($intro); $i++) { 
		
		
		$link = "\"$(this).fadeOut(500, function() { $(this).remove(); }); return false;\"";

		if($i == count($intro)-1) { 
			// 마지막 링크일 경우
			$link = "$('#intro_wrap').fadeOut(500, function() { $(this).remove(); }); set_cookie('intro_close', 'Y', 24, g5_cookie_domain); $('html').addClass('close-intro'); return false;";
		}

		$bimg_pc = $intro[$i]['bn_img'];
		$bimg_m = $intro[$i]['bn_m_img'];

		$banner_image = "<img src='".$bimg_pc."' alt='".$intro[$i]['bn_alt']."' ";
		if($bimg_m) {
			$banner_image .= "class='only-pc' /><img src='".$bimg_m."' alt='".$intro[$i]['bn_alt']."' class='not-pc'";
		}
		$banner_image .= " />";
	?>
		<div class="intro-item" style="z-index: <?=(count($intro)-$i)?>">
			<a href="#" onclick="<?=$link?>">
				<?=$banner_image?>
			</a>
		</div>
	<? } ?>
	</div>

	<? } 
}
?>
