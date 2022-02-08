<?php
$sub_menu = "100200";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '커뮤니티 설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본설정</a></li>
	<li><a href="#anc_002">기능설정</a></li>
	<li><a href="#anc_003">기타항목설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section id="anc_001">
	<h2 class="h2_frm">커뮤니티 기본환경 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>홈페이지 기본환경 설정</caption>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">공개설정</th>
			<td>
				<input type="checkbox" name="cf_open" value="1" id="cf_open" <?php echo $config['cf_open']?'checked':''; ?>>
				<label for="cf_open">사이트공개</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_1" value="1" id="cf_1" <?php echo $config['cf_1']?'checked':''; ?>>
				<label for="cf_1">계정생성 가능</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_2" value="1" id="cf_2" <?php echo $config['cf_2']?'checked':''; ?>>
				<label for="cf_2">캐릭터생성 가능</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_3" value="1" id="cf_3" <?php echo $config['cf_3']?'checked':''; ?>>
				<label for="cf_3">캐릭터수정 가능</label>
			</td>
		</tr>
		<tr>
			<th scope="row">홈페이지 제목</th>
			<td><input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required" size="40"></td>
		</tr>
		<tr>
			<th>사이트설명</th>
			<td>
				<input type="text" name="cf_site_descript" value="<?php echo $config['cf_site_descript'] ?>" size="50" />
			</td>
		</tr>
		<tr>
			<th rowspan="2">파비콘</th>
			<td>
				<?php echo help('파비콘 확장자는 ico 로 등록해 주셔야 적용됩니다.') ?>
				직접등록&nbsp;&nbsp; <input type="file" name="cf_favicon_file" value="" size="50">
			</td></tr><tr>
			<td>
				외부경로&nbsp;&nbsp; <input type="text" name="cf_favicon" value="<?=$config['cf_favicon']?>" size="50"/>
			</td>
		</tr>
		<tr>
			<th rowspan="2">사이트이미지</th>
			<td>
				<?php echo help('사이트 링크 추가시, SNS에서 미리보기로 뜨는 썸네일 이미지를 등록합니다. 290px * 160px 파일로 업로드해 주시길 바랍니다.') ?>
				직접등록&nbsp;&nbsp; <input type="file" name="cf_site_img_file" value="" size="50">
			</td></tr><tr>
			<td>
				외부경로&nbsp;&nbsp; <input type="text" name="cf_site_img" value="<?=$config['cf_site_img']?>" size="50"/>
			</td>
		</tr>
		
		<tr>
			<th scope="row"><label for="site_back">배경음악</label></th>
			<td>
				<?php echo help('유튜브 재생목록 아이디 (https://www.youtube.com/watch?list=재생목록고유아이디) 를 입력해 주세요.') ?>
				<input type="text" name="cf_bgm" value="<?php echo $config['cf_bgm'] ?>" id="cf_bgm" size="50">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_twitter">트위터 위젯</label></th>
			<td>
				<?php echo help('트위터 아이디를 입력해 주세요.') ?>
				<input type="text" name="cf_twitter" value="<?php echo $config['cf_twitter'] ?>" id="cf_twitter"  size="40" />
			</td>
		</tr>
		<tr>
			<th scope="row">기능설정</th>
			<td>
				<input type="checkbox" name="cf_4" value="1" id="cf_4" <?php echo $config['cf_4']?'checked':''; ?>>
				<label for="cf_4">탐색사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_6" value="1" id="cf_6" <?php echo $config['cf_6']?'checked':''; ?>>
				<label for="cf_6">탐색 수행 가능</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="cf_5" value="1" id="cf_5" <?php echo $config['cf_5']?'checked':''; ?>>
				<label for="cf_5">조합(레시피)사용</label>
			</td>
		</tr>
		<tr>
			<th scope="row">기타설정</th>
			<td>
				<?php echo help('디자인 관리 사용을 하시면, 기본 디자인 + 관리자 디자인 설정을 사용하실 수 있습니다.') ?>
				<?php echo help('직접 디자인 수정을 원하신다면, 디자인 관리 사용하지 않음에 체크 하세요.') ?>
				<input type="checkbox" name="cf_7" value="1" id="cf_7" <?php echo $config['cf_7']?'checked':''; ?>>
				<label for="cf_7">디자인 관리 사용하지 않음</label>
				
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>


<section id="anc_002">
	<h2 class="h2_frm">기능 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">캐릭터 최대 생성 갯수</th>
			<td>		
				<input type="text" name="cf_character_count" value="<?php echo get_text($config['cf_character_count']) ?>" id="cf_character_count" size="10">
			</td>
		</tr>
		<tr>
			<th scope="row">최초 스탯 포인트</th>
			<td>
				<?php echo help('스탯 사용 설정 시, 캐릭터가 최초로 획득하는 스탯 포인트를 설정합니다.') ?>
				<input type="text" name="cf_status_point" value="<?php echo get_text($config['cf_status_point']) ?>" id="cf_status_point" size="10">
			</td>
		</tr>
		<tr>
			<th scope="row">하루 탐색 횟수</th>
			<td>		
				<input type="text" name="cf_search_count" value="<?php echo get_text($config['cf_search_count']) ?>" id="cf_search_count" size="10">
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_003">
	<h2 class="h2_frm">기타 항목명 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 150px;">
			<col style="width: 100px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row" rowspan="2"><?=$config['cf_money']?> 설정</th>
			<td>명칭</td>
			<td>		
				<input type="text" name="cf_money" value="<?php echo get_text($config['cf_money']) ?>" id="cf_money" size="30">
			</td>
		</tr>
		<tr>
			<td>단위</td>
			<td>		
				<input type="text" name="cf_money_pice" value="<?php echo get_text($config['cf_money_pice']) ?>" id="cf_money_pice" size="30">
			</td>
		</tr>

		<tr>
			<th scope="row" rowspan="2"><?=$config['cf_exp_name']?> 설정</th>
			<td>명칭</td>
			<td>		
				<input type="text" name="cf_exp_name" value="<?php echo get_text($config['cf_exp_name']) ?>" id="cf_exp_name" size="30">
			</td>
		</tr>
		<tr>
			<td>단위</td>
			<td>		
				<input type="text" name="cf_exp_pice" value="<?php echo get_text($config['cf_exp_pice']) ?>" id="cf_exp_pice" size="30">
			</td>
		</tr>

		<tr>
			<th scope="row"><?=$config['cf_rank_name']?> 설정</th>
			<td>명칭</td>
			<td>		
				<input type="text" name="cf_rank_name" value="<?php echo get_text($config['cf_rank_name']) ?>" id="cf_rank_name" size="30">
			</td>
		</tr>

		<tr>
			<th scope="row"><?=$config['cf_side_title']?> (선택A)설정</th>
			<td>명칭</td>
			<td>
				<?php echo help('명칭이 입력되지 않을 시, 프로필에 출력되지 않습니다.') ?>
				<input type="text" name="cf_side_title" value="<?php echo get_text($config['cf_side_title']) ?>" id="cf_side_title" size="30">
			</td>
		</tr>
		<tr>
			<th scope="row"><?=$config['cf_class_title']?> (선택B)설정</th>
			<td>명칭</td>
			<td>
				<?php echo help('명칭이 입력되지 않을 시, 프로필에 출력되지 않습니다.') ?>
				<input type="text" name="cf_class_title" value="<?php echo get_text($config['cf_class_title']) ?>" id="cf_class_title" size="30">
			</td>
		</tr>
		<tr>
			<th scope="row">상점 카테고리</th>
			<td>-</td>
			<td>
				<?php echo help('카테고리 구분은 || 를 사용합니다. ex) 일반||프로필수정||기타') ?>
				<input type="text" name="cf_shop_category" value="<?php echo get_text($config['cf_shop_category']) ?>" id="cf_shop_category" size="100">
			</td>
		</tr>
		<tr>
			<th scope="row">아이템 기능</th>
			<td>-</td>
			<td>
				<?php echo help('기능 구분은 || 를 사용합니다. ex) 일반||프로필수정||아이템추가') ?>
				<input type="text" name="cf_item_category" value="<?php echo get_text($config['cf_item_category']) ?>" id="cf_item_category" size="100">
			</td>
		</tr>

		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>


</form>

<script>
function fconfigform_submit(f)
{
	f.action = "./community_form_update.php";
	<?php echo get_editor_js("cf_menu_text"); ?>
	<?php echo get_editor_js("cf_mobile_menu_text"); ?>
	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
