<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

$is_page_login = (strstr($_SERVER["REQUEST_URI"], 'login') == "") ? false : true;

if (defined('_INDEX_')) { 
	echo "<script>if(parent && parent!=this) location.href='./main.php';</script>";
} ?>
<!doctype html>
<html lang="ko" class='<?= $is_page_login ? "login" : ""?> <?=$_COOKIE['header_close'] == 'close' ? "close-header" : ""?>'>
<head>
<meta charset="utf-8">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">


<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>

<? if($config['cf_site_img']) { ?>
<link rel="image_src" href="<?=$config['cf_site_img']?>" />
<? } ?>

<meta name="description" content="<?=$config['cf_site_descript']?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?=G5_URL?>" />
<meta name="twitter:title" content="<?php echo $g5_head_title; ?>" />
<meta name="twitter:description" content="<?=$config['cf_site_descript']?>" />

<? if($config['cf_site_img']) { ?>
<meta name="twitter:image" content="<?=$config['cf_site_img']?>" />
<? } ?>

<title><?php echo $g5_head_title; ?></title>
<?
if (defined('G5_IS_ADMIN')) {
	echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css" type="text/css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.layout.css" type="text/css">'.PHP_EOL;
} else {
	echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/default.css" type="text/css">'.PHP_EOL;
	if(!$config['cf_7']) { 
		echo '<link rel="stylesheet" href="'.G5_DATA_URL.'/css/_design.config.css" type="text/css" />';
	}
	echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/style.css" type="text/css">'.PHP_EOL;
}
?>

<? if($config['cf_favicon']) { ?>
<link rel="shortcut icon" href="<?=$config['cf_favicon']?>" type="image/x-icon">
<link rel="icon" href="<?=$config['cf_favicon']?>" type="image/x-icon">
<? } ?>

<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
</script>

<? if(defined('G5_IS_ADMIN')) { ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<? } else { ?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.12.3.min.js"></script>
<? } ?>

<script src="<?php echo G5_JS_URL ?>/jquery.cookie.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.rwdImageMaps.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>

<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>

<script>
if(!parent || parent==this) $('html').addClass('single'); 
</script>
</head>
<body>
