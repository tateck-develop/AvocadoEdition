<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once('../_head.php');

if(!$ad['ad_use_money']) alert("사용할 수 없는 페이지 입니다.");
?>
<h2 class="page-title">
	<strong><?=$config['cf_money']?> 관리</strong>
	<span>Money Information</span>
</h2>