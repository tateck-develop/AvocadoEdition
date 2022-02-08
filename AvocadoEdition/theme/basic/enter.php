<?
	include_once('./_common.php');
	if($is_member & !$config['cf_open']) {
		goto_url(G5_URL.'/main.php');
	}
	
	/*********** Logo Data ************/
	$logo = get_logo('pc');
	$logo_data = "";
	if($logo)		$logo_data .= "<img src='".$logo."' ";
	if($m_logo)		$logo_data .= "class='only-pc' /><img src='".$m_logo."' class='not-pc'";
	if($logo_data)	$logo_data.= " />";
	/*********************************/
?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="title" content="<?=$g5['title']?>">
	<meta name="keywords" content="<?=$config['cf_site_descript']?>">
	<meta name="description" content="<?=$config['cf_site_descript']?>">

	<meta property="og:title" content="<?=$g5['title']?>">
	<meta property="og:description" content="<?=$config['cf_site_descript']?>">
	<meta property="og:url" content="<?=G5_URL?>">

	<title><?=$g5['title']?></title>

	<link rel="shortcut icon" href="<?=$config['cf_favicon']?>">
	<link rel="icon" href="<?=$config['cf_favicon']?>">
	<link media="all" type="text/css" rel="stylesheet" href="<?=G5_THEME_CSS_URL?>/enter.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>


<div class="wrapper">
	<div class="inner">
		<div class="index-logo">
			<a href="./main.php">
				<?=$logo_data?>
				<p class="txt-default">본 홈페이지는 1920 * 1080 PC를 기준으로 제작되었으며, 크롬 브라우저 이용을 권장합니다.</p>
			</a>
		</div>
	</div>
</div>

<script>

window.onload=function() {
	$('html').addClass('on')
	setTimeout(function() { $('html').addClass('active') }, 800);
};
</script>

</body>
</html>
