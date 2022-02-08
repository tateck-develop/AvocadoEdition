<? 
include_once('./_common.php');

if($action == "play") { 
?>
<!doctype html>
<html lang="ko">
<head><meta charset="utf-8"></head>
<body>
<iframe id="ytplayer" type="text/html" width="640" height="360" src="http://www.youtube.com/embed?listType=playlist&list=<?=$config['cf_bgm']?>&autoplay=1&disablekb=1&loop=1&playsinline=1&rel=0&origin=<?=G5_URL?>" frameborder="0"/>
</body>
</html>

<? } ?>