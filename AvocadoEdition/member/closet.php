<?php
include_once('./_common.php');
$ch = sql_fetch("select * from {$g5['character_table']} where ch_id=".$ch_id);
if(!$ch['ch_id']) {
	alert("캐릭터 정보가 존재하지 않습니다.");
}

$g5['title'] = $ch['ch_name']." 옷장";

include_once('./_head.sub.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/closet.css">', 0);

$cl = array();
$cl_result = sql_query("select * from {$g5['closthes_table']} where ch_id = '{$ch_id}' order by cl_type desc, cl_id asc");
$str_array_data = "";
$array_data = "";
for($i=0; $row=sql_fetch_array($cl_result); $i++) { 
	$cl[$i] = $row;
	$array_data .= "{$str_array_data}'{$row['cl_subject']}'";
	$str_array_data = ",";
}

?>

<div id="closet_page" class="none-trans">
	<div class="closet-menu theme-box">
		<div class="pager"></div>
	</div>

	<div class="swiper-container">
		<ul class="swiper-wrapper">
	<? for($i=0; $i < count($cl); $i++) { ?>
			<li class="swiper-slide">
				<a href="<?=$cl[$i]['cl_path']?>" onclick="window.open(this.href, 'big_viewer', 'width=500 height=800 menubar=no status=no toolbar=no location=no scrollbars=yes resizable=yes'); return false;" style="background-image:url(<?=$cl[$i]['cl_path']?>);"></a>
			</li>
	<? } ?>
		</ul>
	</div>
</div>

<script src="<?php echo G5_JS_URL ?>/swiper.js"></script>
<script>
var cl_name = [<?=$array_data?>];
$(function() {
	var swiper = new Swiper("#closet_page .swiper-container", {
		loop:true,
		pagination: {
			el: "#closet_page .pager",
			clickable: true,
			renderBullet: function (index, className) {
				return '<span class="' + className + '">' + cl_name[index] + "</span>";
			}
		},
		autoplay: {
			delay: 4500,
			disableOnInteraction: false,
		},
	});
});
</script>

<?php
include_once('./_tail.sub.php');
?>
