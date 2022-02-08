<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$banner_skin_url.'/style.css">', 0);

if (count($banner) > 0) {
?>
<div class="ban-basic siwperslider">
	<div class="swiper-container">
	
		<ul class="swiper-wrapper">
		<?php for ($i=0; $i<count($banner); $i++) {
			$bn = $banner[$i];

			$bimg_pc = $bn['bn_img'];
			$bimg_m = $bn['bn_m_img'];

			$banner_image = "<img src='".$bimg_pc."' alt='".$bn['bn_alt']."' ";
			if($bimg_m) {
				$banner_image .= "class='only-pc' /><img src='".$bimg_m."' alt='".$bn['bn_alt']."' class='not-pc'";
			}
			$banner_image .= " />";

			// 주소
			$is_link = true;
			if($bn['bn_url'] == 'http://' || $bn['bn_url'] == 'https://' || $bn['bn_url'] == '#') {
				$is_link = false;
			}

			// 새창 띄우기인지
			$bn_new_win = '';
			
			if($bn['bn_new_win'] == '1') {
				$bn_new_win = ' target="_blank"';
			}
			if($bn['bn_new_win'] == '2') {
				$bn_new_win = ' onclick=\'window.open("'.$bn['bn_url'].'", "popup", "width=1020, height=800");\'';
				$bn['bn_url'] = '#';
			}
		?>
			<li class="swiper-slide">
			<?php
				if($is_link) { echo "<a href='".$bn['bn_url']."' {$bn_new_win}>"; }
				echo $banner_image;
				if($is_link) { echo "</a>"; }
			?>
			</li>
		<?php }  ?>
		</ul>

	</div>
	<div class="control">
		<button type="button" class="swiper-button-prev nav txt-default"></button>
		<button type="button" class="swiper-button-next nav txt-default"></button>
	</div>
	<div class="swiper-pagination"></div>
</div>

<script src="<?=G5_JS_URL?>/swiper.js"></script>
<script>
if($('.ban-basic.siwperslider').find('li').length > 1) {
	var effect = "<?=$effect?>";
	var speed = "<?=$speed?>";
	var start = "<?=$start?>";
	var mode = "<?=$mode?>";
	var control = "<?=$control?>";
	var a_spped = "<?=$animationspeed?>";

	if(typeof(effect) == 'undefined' || !effect) { effect = 'slide'; }
	if(typeof(speed) == 'undefined' || !speed) { speed = 3000; }
	if(typeof(start) == 'undefined' || !start) { start = false; }
	if(typeof(mode) == 'undefined' || !mode) { mode = 'default'; }
	if(typeof(control) == 'undefined' || !control) { control = true; }
	if(typeof(a_spped) == 'undefined' || !a_spped) { a_spped = 700; }

	var swiper = new Swiper(".ban-basic.siwperslider .swiper-container", {
		<? if($start) { ?>
			autoplay: {
				delay: speed,
				disableOnInteraction: false,
			},
		<? } ?>
		effect: effect,
		<? if($control) { ?>
		navigation: {
			nextEl: ".ban-basic.siwperslider .swiper-button-prev",
			prevEl: ".ban-basic.siwperslider .swiper-button-next",
		},
		<? } ?>
		pagination: {
			el: ".ban-basic.siwperslider .swiper-pagination"
		}
	});
}

</script>
<? } ?>