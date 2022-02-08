<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="member_page">

	<h1 class="member-title">
		<strong>계정 생성 완료</strong>
		<span>《 Complete Community Account 》</span>
	</h1>

	<div class="member-contents register-pannel">

		<section>
			<h2>정보관리 안내</h2>
			<div class="theme-box">
				<p><strong class="txt-point">"<?php echo get_text($mb['mb_name']); ?>"</strong>님의 <strong><?=$config['cf_title']?></strong> 가입을 진심으로 축하합니다.</p>
				<p>회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.</p>
				<p>아이디, 비밀번호 분실시에는 총괄에게 문의해 주시길 바랍니다.</p>
			</div>
		</section>

		<section>
			<h2>캐릭터 생성</h2>
			<div class="theme-box">
				<p>캐릭터 생성은 신청기간 동안 생성하실 수 있습니다.</p>
				<p>로그인 후 <strong>[ <a href="<?=G5_URL?>/mypage/">MY PAGE</a> > <a href="<?=G5_URL?>/mypage/character/">CHARACTER</a> ]</strong> 메뉴를 통해 생성 및 수정 관리를 하실 수 있습니다.</p>
				<p>신청기간이 끝난 뒤에 합격된 캐릭터들은 관리자 승인 후 MEMBER LIST 에 자동으로 등록됩니다.</p>
			</div>
		</section>

		<div class="ui-button-box txt-center">
			<button class="ui-btn point" onclick="location.href='<?=G5_URL?>';">메인화면으로</button>
		</div>
	</div>
</div>
