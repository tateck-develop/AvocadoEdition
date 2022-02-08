<?php
$sub_menu = "100250";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '화면 설정';
include_once ('./admin.head.php');

// -- 내용관리의 기능을 통해 메뉴와 메인 내용을 가져온다.
// -- 메뉴 정보 가져오기
$sql = " select * from {$g5['content_table']} where co_id = 'site_menu' ";
$menu_co = sql_fetch($sql);

// -- 메인 정보 가져오기
$sql = " select * from {$g5['content_table']} where co_id = 'site_main' ";
$main_co = sql_fetch($sql);



$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">메뉴 화면 구성</a></li>
	<li><a href="#anc_002">메인 화면 구성</a></li>
	<li><a href="#anc_003">도움말</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>


<form name="fviewerform" id="fviewerform" method="post" onsubmit="return fviewerform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section id="anc_001">
	<h2 class="h2_frm">커뮤니티 메뉴 화면</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">메뉴영역 태그</th>
			<td>
				<?php echo help('메뉴영역에 들어갈 내용을 자유롭게 작성해 주시길 바랍니다.') ?>
				<?php echo editor_html('menu_content', get_text($menu_co['co_content'], 0)); ?>
			</td>
		</tr>
		<tr>
			<th scope="row">모바일 메뉴영역 태그</th>
			<td>
				<?php echo help('메뉴영역에 들어갈 내용을 자유롭게 작성해 주시길 바랍니다. 따로 입력하지 않을 시, PC 메뉴가 출력됩니다.') ?>
				<?php echo editor_html('m_menu_content', get_text($menu_co['co_mobile_content'], 0)); ?>
			</td>
		</tr>

		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">메인화면 구성</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">메인화면 태그</th>
			<td>
				<?php echo help('메인영역에 들어갈 내용을 자유롭게 작성해 주시길 바랍니다.') ?>
				<?php echo editor_html('main_content', get_text($main_co['co_content'], 0)); ?>
			</td>
		</tr>
		<tr>
			<th scope="row">모바일 메인화면 태그</th>
			<td>
				<?php echo help('메인영역에 들어갈 내용을 자유롭게 작성해 주시길 바랍니다. 따로 입력하지 않을 시, PC 메인이 출력됩니다.') ?>
				<?php echo editor_html('m_main_content', get_text($main_co['co_mobile_content'], 0)); ?>
			</td>
		</tr>

		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>



</form>

<section id="anc_003">
	<h2 class="h2_frm">도움말</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>※ 특수 기능 삽입 코드 : 내용 작성 시, 아래의 글자를 입력하면 화면에 해당 기능을 가진 폼이 출력됩니다.</p>
		<p>※ 출력폼 수정을 원할 시, 파일 위치로 가셔서 해당 파일에 작성되어 있는 텍스트 혹은 기능을 수정하셔야 합니다.</p>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 120px;">
				<col style="width: 150px;">
				<col style="width: 230px;">
			</colgroup>
			<thead>
				<tr>
					<th>기능명</th>
					<th>코드문자</th>
					<th>파일위치</th>
					<th>설명</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>로그인 링크</td>
					<td>
						<input type="text" readonly value="{{LOGIN}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.login.php
					</td>
					<td class="txt-left">
						로그인 링크를 출력할 때 사용합니다. 비회원인 상태에서만 출력 되며, 로그인 후에는 출력되지 않습니다.
					</td>
				</tr>
				<tr>
					<td>로그아웃 링크</td>
					<td>
						<input type="text" readonly value="{{LOGOUT}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.logout.php
					</td>
					<td class="txt-left">
						로그아웃 링크를 출력할 때 사용합니다. 회원인 상태에서만 출력 되며, 로그아웃 후에는 출력되지 않습니다.
					</td>
				</tr>
				<tr>
					<td>회원가입 링크</td>
					<td>
						<input type="text" readonly value="{{JOIN}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.join.php
					</td>
					<td class="txt-left">
						회원가입 링크를 출력할 때 사용합니다. 비회원인 상태에서만 출력 되며, 로그인 후에는 출력되지 않습니다.
					</td>
				</tr>
				<tr>
					<td>마이페이지 링크</td>
					<td>
						<input type="text" readonly value="{{MYPAGE}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.mypage.php
					</td>
					<td class="txt-left">
						마이페이지 링크를 출력할 때 사용합니다. 회원인 상태에서만 출력됩니다.
					</td>
				</tr>
				<tr>
					<td>외부로그인</td>
					<td>
						<input type="text" readonly value="{{OUTLOGIN}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						skin/outlogin/basic/outlogin.skin.1.php (로그인 전)<br />
						skin/outlogin/basic/outlogin.skin.2.php (로그인 후)
					</td>
					<td class="txt-left">
						로그인창을 출력할 때 사용합니다. 로그인/로그인 이후 폼이 다르게 출력됩니다.
					</td>
				</tr>
				<tr>
					<td>트위터 타임라인</td>
					<td>
						<input type="text" readonly value="{{TWITTER}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.twitter.php
					</td>
					<td class="txt-left">
						관리자 환경설정에서 설정한 트위터의 타임라인을 출력합니다.
					</td>
				</tr>
				<tr>
					<td>메인 슬라이드</td>
					<td>
						<input type="text" readonly value="{{VISUAL_SLIDE}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.visual.php
					</td>
					<td class="txt-left">
						메인 슬라이드에 등록한 배너 슬라이드를 출력합니다.
					</td>
				</tr>
				<tr>
					<td>배경음악 컨트롤</td>
					<td>
						<input type="text" readonly value="{{BGM}}" style="width: 100%;"/>
					</td>
					<td class="txt-left">
						templete/txt.bgm.php
					</td>
					<td class="txt-left">
						배경음악을 컨트롤 하는 버튼을 출력합니다. 접속기기가 모바일일 경우, 출력되지 않습니다.
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</section>

<script>
function fviewerform_submit(f)
{
	f.action = "./viewer_form_update.php";

	<?php echo get_editor_js("menu_content"); ?>
	<?php echo get_editor_js("m_menu_content"); ?>
	<?php echo get_editor_js('main_content'); ?>
	<?php echo get_editor_js('m_main_content'); ?>

	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>

