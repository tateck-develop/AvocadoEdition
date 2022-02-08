<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
define('_MYPAGE_', true);
$g5['title'] = $member['mb_name']." 마이페이지";
include_once(G5_PATH.'/_head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/mypage.css">', 0);

// 기본 항목 설정 데이터
$ad = $article;
?>

<div class="mypageWrap">
	<div class="mypageInside">
		<nav id="submenu">
			<ul>
				<li><a href="<? echo G5_URL; ?>/mypage/"			><span>계정정보</span></a></li>
				<li><a href="<? echo G5_URL; ?>/mypage/character"	><span>캐릭터</span></a></li>
				<li><a href="<? echo G5_URL; ?>/mypage/log"			><span>로그내역</span></a></li>
			<? if($ad['ad_use_money']) { ?>
				<li><a href="<? echo G5_URL; ?>/mypage/money"		><span><?=$config['cf_money']?>관리</span></a></li>
			<? } ?>
				<li><a href="<? echo G5_URL; ?>/mypage/memo"		><span>우편함</span></a></li>
			</ul>
		</nav>
		<div id="subpage">