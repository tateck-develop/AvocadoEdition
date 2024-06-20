<?php
$sub_menu = "100100";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');
include_once(G5_ADMIN_PATH."/config_form_prev.php");

if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '환경설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본환경</a></li>
	<li><a href="#anc_002">게시판기본</a></li>
	<li><a href="#anc_003">회원가입</a></li>
	<li><a href="#anc_010">레이아웃 추가설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
	$userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<input type="hidden" name="cf_cut_name" value="<?php echo $config['cf_cut_name'] ?>" />
<input type="hidden" name="cf_captcha_mp3" value="<?php echo $config['cf_captcha_mp3'] ?>" />
<input type="hidden" name="cf_memo_send_point" value="<?php echo $config['cf_memo_send_point'] ?>" />
<input type="hidden" name="cf_open_modify" value="<?php echo $config['cf_open_modify'] ?>" />
<input type="hidden" name="cf_nick_modify" value="<?php echo $config['cf_nick_modify'] ?>" />
<input type="hidden" name="cf_login_minutes" value="<?php echo $config['cf_login_minutes'] ?>" />
<input type="hidden" name="cf_use_copy_log" value="<?php echo $config['cf_use_copy_log']; ?>" />
<input type="hidden" name="cf_point_term" value="<?php echo $config['cf_point_term']; ?>" />
<input type="hidden" name="cf_analytics" value="<?php echo $config['cf_analytics']; ?>" />
<input type="hidden" name="cf_add_meta" value="<?php echo $config['cf_add_meta']; ?>" />
<input type="hidden" name="cf_syndi_token" value="<?php echo $config['cf_syndi_token']; ?>" />
<input type="hidden" name="cf_syndi_except" value="<?php echo $config['cf_syndi_except']; ?>" />
<input type="hidden" name="cf_flash_extension" value="<?php echo $config['cf_flash_extension']; ?>" />
<input type="hidden" name="cf_read_point" value="<?php echo $config['cf_read_point']; ?>" />
<input type="hidden" name="cf_write_point" value="<?php echo $config['cf_write_point']; ?>" />
<input type="hidden" name="cf_comment_point" value="<?php echo $config['cf_comment_point']; ?>" />
<input type="hidden" name="cf_download_point" value="<?php echo $config['cf_download_point']; ?>" />
<input type="hidden" name="cf_cert_use" value="<?php echo $config['cf_cert_use']; ?>" />
<input type="hidden" name="cf_cert_ipin" value="<?php echo $config['cf_cert_ipin']; ?>" />
<input type="hidden" name="cf_cert_hp" value="<?php echo $config['cf_cert_hp']; ?>" />
<input type="hidden" name="cf_cert_kcb_cd" value="<?php echo $config['cf_cert_kcb_cd']; ?>" />
<input type="hidden" name="cf_cert_kcp_cd" value="<?php echo $config['cf_cert_kcp_cd']; ?>" />
<input type="hidden" name="cf_lg_mid" value="<?php echo $config['cf_lg_mid']; ?>" />
<input type="hidden" name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key']; ?>" />
<input type="hidden" name="cf_cert_limit" value="<?php echo $config['cf_cert_limit']; ?>" />
<input type="hidden" name="cf_cert_req" value="<?php echo $config['cf_cert_req']; ?>" />
<input type="hidden" name="cf_email_po_super_admin" value="<?php echo $config['cf_email_po_super_admin']; ?>" />
<input type="hidden" name="cf_use_homepage" value="<?php echo $config['cf_use_homepage']; ?>" />
<input type="hidden" name="cf_req_homepage" value="<?php echo $config['cf_req_homepage']; ?>" />
<input type="hidden" name="cf_use_addr" value="<?php echo $config['cf_use_addr']; ?>" />
<input type="hidden" name="cf_req_addr" value="<?php echo $config['cf_req_addr']; ?>" />
<input type="hidden" name="cf_use_tel" value="<?php echo $config['cf_use_tel']; ?>" />
<input type="hidden" name="cf_req_tel" value="<?php echo $config['cf_req_tel']; ?>" />
<input type="hidden" name="cf_use_hp" value="<?php echo $config['cf_use_hp']; ?>" />
<input type="hidden" name="cf_req_hp" value="<?php echo $config['cf_req_hp']; ?>" />
<input type="hidden" name="cf_use_signature" value="<?php echo $config['cf_use_signature']; ?>" />
<input type="hidden" name="cf_req_signature" value="<?php echo $config['cf_req_signature']; ?>" />
<input type="hidden" name="cf_use_profile" value="<?php echo $config['cf_use_profile']; ?>" />
<input type="hidden" name="cf_req_profile" value="<?php echo $config['cf_req_profile']; ?>" />

<input type="hidden" name="cf_use_member_icon" value="<?php echo $config['cf_use_member_icon']; ?>" />
<input type="hidden" name="cf_icon_level" value="<?php echo $config['cf_icon_level']; ?>" />
<input type="hidden" name="cf_member_icon_size" value="<?php echo $config['cf_member_icon_size']; ?>" />
<input type="hidden" name="cf_member_icon_width" value="<?php echo $config['cf_member_icon_width']; ?>" />
<input type="hidden" name="cf_member_icon_height" value="<?php echo $config['cf_member_icon_height']; ?>" />


<section id="anc_001">
	<h2 class="h2_frm">기본환경 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
					<td><?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?></td>
					<th>관리자 아이콘</th>
					<td>
						<i class="admin-icon-box">
						<? if(is_file(G5_DATA_PATH."/site/ico_admin")) { ?>
							<img src="<?=G5_DATA_URL?>/site/ico_admin" alt="관리자 아이콘" />
						<? } ?>
						</i>
						<input type="file" name="admin_icon_file" value="" size="50">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cf_admin_email">관리자 메일 주소<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="cf_admin_email" value="<?php echo $config['cf_admin_email'] ?>" id="cf_admin_email" required class="required email frm_input" size="40">
					</td>
					<th scope="row"><label for="cf_admin_email_name">관리자 메일 발송이름<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="cf_admin_email_name" value="<?php echo $config['cf_admin_email_name'] ?>" id="cf_admin_email_name" required class="required frm_input" size="40">
					</td>
				</tr>
			</tbody>
		</table>

		<h3>화폐(포인트) 설정</h3>
		<table>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="cf_use_point">화폐기능 사용</label></th>
					<td>
						<input type="checkbox" name="cf_use_point" value="1" id="cf_use_point" <?php echo $config['cf_use_point']?'checked':''; ?>><label for="cf_use_point"></label>
					</td>
					<th scope="row"><label for="cf_login_point">로그인 시 획득<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="cf_login_point" value="<?php echo $config['cf_login_point'] ?>" id="cf_login_point" required class="required frm_input" size="5"> 점 <span class="red">(1일 1회)</span>
					</td>
				</tr>
			</tbody>
		</table>

		<h3>삭제 기간 설정</h3>
		<table>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="cf_new_del">최근게시물 삭제</label></th>
					<td>
						<?php echo help('설정일이 지난 최근게시물 자동 삭제') ?>
						<input type="text" name="cf_new_del" value="<?php echo $config['cf_new_del'] ?>" id="cf_new_del" class="frm_input" size="5"> 일
					</td>
					<th scope="row"><label for="cf_memo_del">쪽지 삭제</label></th>
					<td>
						<?php echo help('설정일이 지난 쪽지 자동 삭제') ?>
						<input type="text" name="cf_memo_del" value="<?php echo $config['cf_memo_del'] ?>" id="cf_memo_del" class="frm_input" size="5"> 일
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cf_visit_del">접속자로그 삭제</label></th>
					<td>
						<?php echo help('설정일이 지난 접속자 로그 자동 삭제') ?>
						<input type="text" name="cf_visit_del" value="<?php echo $config['cf_visit_del'] ?>" id="cf_visit_del" class="frm_input" size="5"> 일
					</td>
					<th scope="row"><label for="cf_popular_del">인기검색어 삭제</label></th>
					<td>
						<?php echo help('설정일이 지난 인기검색어 자동 삭제') ?>
						<input type="text" name="cf_popular_del" value="<?php echo $config['cf_popular_del'] ?>" id="cf_popular_del" class="frm_input" size="5"> 일
					</td>
				</tr>
			</tbody>
		</table>

		<h3>기본 스킨 설정</h3>
		<table>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="cf_new_rows">최근게시물 라인수</label></th>
					<td>
						<input type="text" name="cf_new_rows" value="<?php echo $config['cf_new_rows'] ?>" id="cf_new_rows" class="frm_input" size="3">
					</td>
					<th scope="row"><label for="cf_page_rows">한페이지당 라인수</label></th>
					<td>
						<input type="text" name="cf_page_rows" value="<?php echo $config['cf_page_rows'] ?>" id="cf_page_rows" class="frm_input" size="3">
					</td>
					<th scope="row"><label for="cf_write_pages">페이지 표시 수<strong class="sound_only">필수</strong></label></th>
					<td><input type="text" name="cf_write_pages" value="<?php echo $config['cf_write_pages'] ?>" id="cf_write_pages" required class="required numeric frm_input" size="3"></td>
				</tr>
				<tr>
					<th scope="row"><label for="cf_new_skin">최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo get_skin_select('new', 'cf_new_skin', 'cf_new_skin', $config['cf_new_skin'], 'required'); ?>
					</td>
					<th scope="row"><label for="cf_search_skin">검색 스킨<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo get_skin_select('search', 'cf_search_skin', 'cf_search_skin', $config['cf_search_skin'], 'required'); ?>
					</td>
					<th scope="row"><label for="cf_connect_skin">접속자 스킨<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo get_skin_select('connect', 'cf_connect_skin', 'cf_connect_skin', $config['cf_connect_skin'], 'required'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cf_faq_skin">FAQ 스킨<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo get_skin_select('faq', 'cf_faq_skin', 'cf_faq_skin', $config['cf_faq_skin'], 'required'); ?>
					</td>
					<th scope="row"><label for="cf_editor">에디터 선택</label></th>
					<td colspan="3">
						<select name="cf_editor" id="cf_editor">
						<?php
						$arr = get_skin_dir('', G5_EDITOR_PATH);
						for ($i=0; $i<count($arr); $i++) {
							if ($i == 0) echo "<option value=\"\">사용안함</option>";
							echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
						}
						?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<h3>접속 제한 설정</h3>
		<table>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
					<td>
						<?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다. 123.123.+ 도 입력 가능. (엔터로 구분)') ?>
						<textarea name="cf_possible_ip" id="cf_possible_ip"><?php echo $config['cf_possible_ip'] ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
					<td>
						<?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음. 123.123.+ 도 입력 가능. (엔터로 구분)') ?>
						<textarea name="cf_intercept_ip" id="cf_intercept_ip"><?php echo $config['cf_intercept_ip'] ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">게시판 기본 설정</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>게시판 기본 설정</caption>
		<colgroup>
			<col class="grid_4">
			<col>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required class="required numeric frm_input" size="3"> 초 지난후 가능</td>
			<th scope="row"><label for="cf_link_target">새창 링크</label></th>
			<td>
				<?php echo help('글내용중 자동 링크되는 타켓을 지정합니다.') ?>
				<select name="cf_link_target" id="cf_link_target">
					<option value="_blank"<?php echo get_selected($config['cf_link_target'], '_blank') ?>>_blank</option>
					<option value="_self"<?php echo get_selected($config['cf_link_target'], '_self') ?>>_self</option>
					<option value="_top"<?php echo get_selected($config['cf_link_target'], '_top') ?>>_top</option>
					<option value="_new"<?php echo get_selected($config['cf_link_target'], '_new') ?>>_new</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_search_part">검색 단위</label></th>
			<td colspan="3"><input type="text" name="cf_search_part" value="<?php echo $config['cf_search_part'] ?>" id="cf_search_part" class="frm_input" size="4"> 건 단위로 검색</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_image_extension">이미지 업로드 확장자</label></th>
			<td>
				<?php echo help('게시판 글작성시 이미지 파일 업로드 가능 확장자. | 로 구분') ?>
				<input type="text" name="cf_image_extension" value="<?php echo $config['cf_image_extension'] ?>" id="cf_image_extension" class="full" size="70">
			</td>
			<th scope="row"><label for="cf_movie_extension">동영상 업로드 확장자</label></th>
			<td>
				<?php echo help('게시판 글작성시 동영상 파일 업로드 가능 확장자. | 로 구분') ?>
				<input type="text" name="cf_movie_extension" value="<?php echo $config['cf_movie_extension'] ?>" id="cf_movie_extension" class="full" size="70">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_filter">단어 필터링</label></th>
			<td colspan="3">
				<?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
				<textarea name="cf_filter" id="cf_filter" rows="7"><?php echo $config['cf_filter'] ?></textarea>
			 </td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_003">
	<h2 class="h2_frm">회원가입 설정</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>회원가입 시 사용할 스킨과 입력 받을 정보 등을 설정할 수 있습니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_4">
			<col>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_member_skin">회원 스킨<strong class="sound_only">필수</strong></label></th>
			<td>
				<?php echo get_skin_select('member', 'cf_member_skin', 'cf_member_skin', $config['cf_member_skin'], 'required'); ?>
			</td>
			<th scope="row"><label for="cf_register_level">회원가입시 권한</label></th>
			<td><?php echo get_member_level_select('cf_register_level', 1, 9, $config['cf_register_level']) ?></td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_register_point">회원가입시 포인트</label></th>
			<td><input type="text" name="cf_register_point" value="<?php echo $config['cf_register_point'] ?>" id="cf_register_point" class="frm_input" size="5"> 점</td>
			<th scope="row" id="th310"><label for="cf_leave_day">회원탈퇴후 삭제일</label></th>
			<td><input type="text" name="cf_leave_day" value="<?php echo $config['cf_leave_day'] ?>" id="cf_leave_day" class="frm_input" size="2"> 일 후 자동 삭제</td>
		</tr>
		
		<tr>
			<th scope="row"><label for="cf_use_recommend">추천인제도 사용</label></th>
			<td colspan="3">
				<input type="checkbox" name="cf_use_recommend" value="1" id="cf_use_recommend" <?php echo $config['cf_use_recommend']?'checked':''; ?>><label for="cf_use_recommend"></label>
				<input type="hidden" name="cf_recommend_point" value="<?php echo $config['cf_recommend_point'] ?>" id="cf_recommend_point" class="frm_input">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
			<td>
				<?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
				<textarea name="cf_prohibit_id" id="cf_prohibit_id" rows="5"><?php echo $config['cf_prohibit_id'] ?></textarea>
			</td>
			<th scope="row"><label for="cf_prohibit_email">입력 금지 메일</label></th>
			<td>
				<?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
				<textarea name="cf_prohibit_email" id="cf_prohibit_email" rows="5"><?php echo $config['cf_prohibit_email'] ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_stipulation">커뮤니티 활동 규칙</label></th>
			<td colspan="3"><textarea name="cf_stipulation" id="cf_stipulation" rows="10"><?php echo $config['cf_stipulation'] ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_privacy">캐릭터생성 유의사항</label></th>
			<td colspan="3"><textarea id="cf_privacy" name="cf_privacy" rows="10"><?php echo $config['cf_privacy'] ?></textarea></td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_010">
	<h2 class="h2_frm">레이아웃 추가설정</h2>
	<?php echo $pg_anchor; ?>
	<div class="local_desc02 local_desc">
		<p>기본 설정된 파일 경로 및 script, css 를 추가하거나 변경할 수 있습니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>레이아웃 추가설정</caption>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_add_script">추가 script, css</label></th>
			<td>
				<?php echo help('HTML의 &lt;/HEAD&gt; 태그위로 추가될 JavaScript와 css 코드를 설정합니다.<br>관리자 페이지에서는 이 코드를 사용하지 않습니다.') ?>
				<textarea name="cf_add_script" id="cf_add_script" style="height:400px;"><?php echo get_text($config['cf_add_script']); ?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<div style="display:none;">
	<section id="anc_005" style="display: none;">
		<h2 class="h2_frm">기본 메일 환경 설정</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>기본 메일 환경 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="cf_email_use">메일발송 사용</label></th>
				<td>
					<?php echo help('체크하지 않으면 메일발송을 아예 사용하지 않습니다. 메일 테스트도 불가합니다.') ?>
					<input type="checkbox" name="cf_email_use" value="1" id="cf_email_use" <?php echo $config['cf_email_use']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_use_email_certify">메일인증 사용</label></th>
				<td>
					<?php echo help('메일에 배달된 인증 주소를 클릭하여야 회원으로 인정합니다.'); ?>
					<input type="checkbox" name="cf_use_email_certify" value="1" id="cf_use_email_certify" <?php echo $config['cf_use_email_certify']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_formmail_is_member">폼메일 사용 여부</label></th>
				<td>
					<?php echo help('체크하지 않으면 비회원도 사용 할 수 있습니다.') ?>
					<input type="checkbox" name="cf_formmail_is_member" value="1" id="cf_formmail_is_member" <?php echo $config['cf_formmail_is_member']?'checked':''; ?>> 회원만 사용
				</td>
			</tr>
			</table>
		</div>
	</section>

	<?php // echo $frm_submit; ?>

	<section id="anc_006" style="display: none;">
		<h2 class="h2_frm">게시판 글 작성 시 메일 설정</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>게시판 글 작성 시 메일 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="cf_email_wr_super_admin">최고관리자</label></th>
				<td>
					<?php echo help('최고관리자에게 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_wr_super_admin" value="1" id="cf_email_wr_super_admin" <?php echo $config['cf_email_wr_super_admin']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_email_wr_group_admin">그룹관리자</label></th>
				<td>
					<?php echo help('그룹관리자에게 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_wr_group_admin" value="1" id="cf_email_wr_group_admin" <?php echo $config['cf_email_wr_group_admin']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_email_wr_board_admin">게시판관리자</label></th>
				<td>
					<?php echo help('게시판관리자에게 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_wr_board_admin" value="1" id="cf_email_wr_board_admin" <?php echo $config['cf_email_wr_board_admin']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_email_wr_write">원글작성자</label></th>
				<td>
					<?php echo help('게시자님께 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_wr_write" value="1" id="cf_email_wr_write" <?php echo $config['cf_email_wr_write']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_email_wr_comment_all">댓글작성자</label></th>
				<td>
					<?php echo help('원글에 댓글이 올라오는 경우 댓글 쓴 모든 분들께 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_wr_comment_all" value="1" id="cf_email_wr_comment_all" <?php echo $config['cf_email_wr_comment_all']?'checked':''; ?>> 사용
				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</section>

	<?php // echo $frm_submit; ?>

	<section id="anc_007" style="display: none;">
		<h2 class="h2_frm">회원가입 시 메일 설정</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>회원가입 시 메일 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="cf_email_mb_super_admin">최고관리자 메일발송</label></th>
				<td>
					<?php echo help('최고관리자에게 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_mb_super_admin" value="1" id="cf_email_mb_super_admin" <?php echo $config['cf_email_mb_super_admin']?'checked':''; ?>> 사용
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_email_mb_member">회원님께 메일발송</label></th>
				<td>
					<?php echo help('회원가입한 회원님께 메일을 발송합니다.') ?>
					<input type="checkbox" name="cf_email_mb_member" value="1" id="cf_email_mb_member" <?php echo $config['cf_email_mb_member']?'checked':''; ?>> 사용
				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</section>

	<?php // echo $frm_submit; ?>


	<section id="anc_009" style="display: none;">
		<h2 class="h2_frm">소셜네트워크서비스(SNS : Social Network Service)</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>소셜네트워크서비스 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="cf_facebook_appid">페이스북 앱 ID</label></th>
				<td>
					<input type="text" name="cf_facebook_appid" value="<?php echo $config['cf_facebook_appid'] ?>" id="cf_facebook_appid" class="frm_input"> <a href="https://developers.facebook.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
				</td>
				<th scope="row"><label for="cf_facebook_secret">페이스북 앱 Secret</label></th>
				<td>
					<input type="text" name="cf_facebook_secret" value="<?php echo $config['cf_facebook_secret'] ?>" id="cf_facebook_secret" class="frm_input" size="35">
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_twitter_key">트위터 컨슈머 Key</label></th>
				<td>
					<input type="text" name="cf_twitter_key" value="<?php echo $config['cf_twitter_key'] ?>" id="cf_twitter_key" class="frm_input"> <a href="https://dev.twitter.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
				</td>
				<th scope="row"><label for="cf_twitter_secret">트위터 컨슈머 Secret</label></th>
				<td>
					<input type="text" name="cf_twitter_secret" value="<?php echo $config['cf_twitter_secret'] ?>" id="cf_twitter_secret" class="frm_input" size="35">
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_googl_shorturl_apikey">구글 짧은주소 API Key</label></th>
				<td>
					<input type="text" name="cf_googl_shorturl_apikey" value="<?php echo $config['cf_googl_shorturl_apikey'] ?>" id="cf_googl_shorturl_apikey" class="frm_input"> <a href="http://code.google.com/apis/console/" target="_blank" class="btn_frmline">API Key 등록하기</a>
				</td>
				<th scope="row"><label for="cf_kakao_js_apikey">카카오 Javascript API Key</label></th>
				<td>
					<input type="text" name="cf_kakao_js_apikey" value="<?php echo $config['cf_kakao_js_apikey'] ?>" id="cf_kakao_js_apikey" class="frm_input"> <a href="http://developers.kakao.com/" target="_blank" class="btn_frmline">앱 등록하기</a>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
	</section>
	<section id="anc_011" style="display: none;">
		<h2 class="h2_frm">SMS</h2>
		<?php echo $pg_anchor ?>

		<div class="tbl_frm01 tbl_wrap">
			<table>
			<caption>SMS 설정</caption>
			<colgroup>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
				<td>
					<select id="cf_sms_use" name="cf_sms_use">
						<option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
						<option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
				<td>
					<?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
					<select id="cf_sms_type" name="cf_sms_type">
						<option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
						<option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_icode_id">아이코드 회원아이디</label></th>
				<td>
					<?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
					<input type="text" name="cf_icode_id" value="<?php echo $config['cf_icode_id']; ?>" id="cf_icode_id" class="frm_input" size="20">
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cf_icode_pw">아이코드 비밀번호</label></th>
				<td>
					<?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
					<input type="password" name="cf_icode_pw" value="<?php echo $config['cf_icode_pw']; ?>" id="cf_icode_pw" class="frm_input">
				</td>
			</tr>
			<tr>
				<th scope="row">요금제</th>
				<td>
					<input type="hidden" name="cf_icode_server_ip" value="<?php echo $config['cf_icode_server_ip']; ?>">
					<?php
						if ($userinfo['payment'] == 'A') {
						   echo '충전제';
							echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
						} else if ($userinfo['payment'] == 'C') {
							echo '정액제';
							echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
						} else {
							echo '가입해주세요.';
							echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
						}
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">아이코드 SMS 신청<br>회원가입</th>
				<td>
					<a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
				</td>
			</tr>
			 <?php if ($userinfo['payment'] == 'A') { ?>
			<tr>
				<th scope="row">충전 잔액</th>
				<td colspan="3">
					<?php echo number_format($userinfo['coin']); ?> 원.
					<a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['cf_icode_id']; ?>&amp;icode_passwd=<?php echo $config['cf_icode_pw']; ?>" target="_blank" class="btn_frmline" onclick="window.open(this.href,'icode_payment', 'scrollbars=1,resizable=1'); return false;">충전하기</a>
				</td>
			</tr>
			<?php } ?>
			</tbody>
			</table>
		</div>
	</section>
</div>

</form>

<script>
$(function(){
	<?php
	if(!$config['cf_cert_use'])
		echo '$(".cf_cert_service").addClass("cf_cert_hide");';
	?>
	$("#cf_cert_use").change(function(){
		switch($(this).val()) {
			case "0":
				$(".cf_cert_service").addClass("cf_cert_hide");
				break;
			default:
				$(".cf_cert_service").removeClass("cf_cert_hide");
				break;
		}
	});

	$(".get_theme_confc").on("click", function() {
		var type = $(this).data("type");
		var msg = "기본환경 스킨 설정";
		if(type == "conf_member")
			msg = "기본환경 회원스킨 설정";

		if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
			return false;

		$.ajax({
			type: "POST",
			url: "./theme_config_load.php",
			cache: false,
			async: false,
			data: { type: type },
			dataType: "json",
			success: function(data) {
				if(data.error) {
					alert(data.error);
					return false;
				}

				var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
				var count = field.length;
				var key;

				for(i=0; i<count; i++) {
					key = field[i];

					if(data[key] != undefined && data[key] != "")
						$("select[name="+key+"]").val(data[key]);
				}
			}
		});
	});
});

function fconfigform_submit(f)
{
	f.action = "./config_form_update.php";
	return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
	// kcb일 때
	if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
		// 실행모듈
		if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
			if(PHP_INT_MAX == 2147483647) // 32-bit
				$exe = G5_OKNAME_PATH.'/bin/okname';
			else
				$exe = G5_OKNAME_PATH.'/bin/okname_x64';
		} else {
			if(PHP_INT_MAX == 2147483647) // 32-bit
				$exe = G5_OKNAME_PATH.'/bin/okname.exe';
			else
				$exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
		}

		echo module_exec_check($exe, 'okname');
	}

	// kcp일 때
	if($config['cf_cert_hp'] == 'kcp') {
		if(PHP_INT_MAX == 2147483647) // 32-bit
			$exe = G5_KCPCERT_PATH . '/bin/ct_cli';
		else
			$exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';

		echo module_exec_check($exe, 'ct_cli');
	}

	// LG의 경우 log 디렉토리 체크
	if($config['cf_cert_hp'] == 'lg') {
		$log_path = G5_LGXPAY_PATH.'/lgdacom/log';

		if(!is_dir($log_path)) {
			echo '<script>'.PHP_EOL;
			echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
			echo '</script>'.PHP_EOL;
		} else {
			if(!is_writable($log_path)) {
				echo '<script>'.PHP_EOL;
				echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
				echo '</script>'.PHP_EOL;
			}
		}
	}
}

include_once ('./admin.tail.php');
?>
