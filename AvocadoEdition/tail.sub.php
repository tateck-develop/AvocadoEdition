<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

unset($ch);
unset($mb);
unset($row);
unset($row2);
unset($character);
unset($member);

if(!defined('G5_IS_ADMIN') && defined('G5_THEME_PATH') && is_file(G5_THEME_PATH.'/tail.sub.php')) {
	require_once(G5_THEME_PATH.'/tail.sub.php');
	return;
}
?>


</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>