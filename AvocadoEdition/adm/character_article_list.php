<?php
$sub_menu = "400100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

// 기본항목에 대한 설정값 가져오기
$profile = sql_fetch(" select * from {$g5['article_default_table']} ");

$profile['ad_text_thumb'] = $profile['ad_text_thumb'] ? $profile['ad_text_thumb'] : "두상";
$profile['ad_text_head'] = $profile['ad_text_head'] ? $profile['ad_text_head'] : "흉상";
$profile['ad_text_body'] = $profile['ad_text_body'] ? $profile['ad_text_body'] : "전신";
$profile['ad_text_name'] = $profile['ad_text_name'] ? $profile['ad_text_name'] : "이름";


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본 프로필 양식</a></li>
	<li><a href="#anc_002">추가 프로필 양식</a></li>
	<li><a href="#anc_003">프로필 항목 등록</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

// 추가 항목에 대한 데이터들 가져오기
$sql = " select * from {$g5['article_table']} order by ar_theme asc, ar_order asc";
$result = sql_query($sql);

$g5['title'] = '프로필 양식 관리';
include_once ('./admin.head.php');
?>

<form name="farticle" method="post" action="./character_article_list_update.php" autocomplete="off">

<section id="anc_001">
	<h2 class="h2_frm">기본 프로필 양식</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 120px;">
			<col style="width: 80px;">
			<col />
		</colgroup>
		<tbody>
		<tr>
			<th>기능사용설정</th>
			<td colspan="2">
				<input type="checkbox" name="ad_use_title" value="1" id="ad_use_title" <?=$profile['ad_use_title'] ? "checked" : ""?>/>
				<label for="ad_use_title">타이틀 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_closet" value="1" id="ad_use_closet" <?=$profile['ad_use_closet'] ? "checked" : ""?>/>
				<label for="ad_use_closet">옷장 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_inven" value="1" id="ad_use_inven" <?=$profile['ad_use_inven'] ? "checked" : ""?>/>
				<label for="ad_use_inven">인벤토리 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_money" value="1" id="ad_use_money" <?=$profile['ad_use_money'] ? "checked" : ""?>/>
				<label for="ad_use_money">금액 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_exp" value="1" id="ad_use_exp" <?=$profile['ad_use_exp'] ? "checked" : ""?>/>
				<label for="ad_use_exp">경험치 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_rank" value="1" id="ad_use_rank" <?=$profile['ad_use_rank'] ? "checked" : ""?>/>
				<label for="ad_use_rank">랭킹 사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_use_status" value="1" id="ad_use_status" <?=$profile['ad_use_status'] ? "checked" : ""?>/>
				<label for="ad_use_status">스탯 사용</label>
			</td>
		</tr>

		<tr>
			<th rowspan="2"><input type="text" name="ad_text_thumb" value="<?=$profile['ad_text_thumb']?>" size="13"/></th>
			<td class="bo-right bo-left">사용여부</td>
			<td>
				<input type="checkbox" name="ad_use_thumb" value="1" id="ad_use_thumb" <?=$profile['ad_use_thumb'] ? "checked" : ""?>/>
				<label for="ad_use_thumb">사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_url_thumb" value="1" id="ad_url_thumb" <?=$profile['ad_url_thumb'] ? "checked" : ""?> />
				<label for="ad_url_thumb">외부 이미지 경로로 등록</label>
			</td></tr><tr>
			<td class="bo-right bo-left">도움말</td>
			<td>
				<input type="text" name="ad_help_thumb" value="<?=$profile['ad_help_thumb']?>" size="80" />
			</td>
		</tr>
		<tr>
			<th rowspan="2"><input type="text" name="ad_text_head" value="<?=$profile['ad_text_head']?>" size="13"/></th>
			<td class="bo-right bo-left">사용여부</td>
			<td>
				<input type="checkbox" name="ad_use_head" value="1" id="ad_use_head" <?=$profile['ad_use_head'] ? "checked" : ""?> />
				<label for="ad_use_head">사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_url_head" value="1" id="ad_url_head" <?=$profile['ad_url_head'] ? "checked" : ""?> />
				<label for="ad_url_head">외부 이미지 경로로 등록</label>
			</td></tr><tr>
			<td class="bo-right bo-left">도움말</td>
			<td>
				<input type="text" name="ad_help_head" value="<?=$profile['ad_help_head']?>" size="80" />
			</td>
		</tr>
		<tr>
			<th rowspan="2"><input type="text" name="ad_text_body" value="<?=$profile['ad_text_body']?>" size="13"/></th>
			<td class="bo-right bo-left">사용여부</td>
			<td>
				<input type="checkbox" name="ad_use_body" value="1" id="ad_use_body" <?=$profile['ad_use_body'] ? "checked" : ""?> />
				<label for="ad_use_body">사용</label>
				&nbsp;&nbsp;
				<input type="checkbox" name="ad_url_body" value="1" id="ad_url_body" <?=$profile['ad_url_body'] ? "checked" : ""?> />
				<label for="ad_url_body">외부 이미지 경로로 등록</label>
			</td></tr><tr>
			<td class="bo-right bo-left">도움말</td>
			<td>
				<input type="text" name="ad_help_body" value="<?=$profile['ad_help_body']?>" size="80" />
			</td>
		</tr>
		<tr>
			<th><input type="text" name="ad_text_name" value="<?=$profile['ad_text_name']?>" size="13"/></th>
			<td class="bo-right bo-left">도움말</td>
			<td>
				<input type="hidden" name="ad_use_name" value="1" />
				<input type="text" name="ad_help_name" value="<?=$profile['ad_help_name']?>" size="80" />
			</td>
		</tr>
		
		</tbody>
		</table>
	</div>

</section>
<? echo $frm_submit; ?>


<section id="anc_002">
	<h2 class="h2_frm">추가 프로필 양식</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>항목을 제거하실 시, 고유코드 항목을 지우고 확인을 누르시면 됩니다.</p>
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width:100px;" />
				<col style="width:120px;" />
				<col style="width:120px;" />
				<col style="width:120px;" />
				<col style="width:100px;" />
				<col style="width:120px;" />
				<col />
				<col style="width:100px;" />
				<col style="width:100px;" />
			</colgroup>
			<thead>
				<tr>
					<th>테마</th>
					<th>고유코드</th>
					<th>항목명</th>
					<th>항목타입</th>
					<th>폼크기</th>
					<th>단위/항목</th>
					<th>도움말</th>
					<th>순서</th>
					<th>공개영역</th>
				</tr>
			</thead>
			<tbody>
			<? for($i = 0; $ar = sql_fetch_array($result); $i++) { ?>
				<tr>
					<td>
						<?php echo get_theme_select('theme_dir_'.$i, "ar_theme[$i]", $ar['ar_theme'], " class='full'"); ?>
					</td>
					<td>
						<input type="hidden" name="ar_id[<?=$i?>]" value="<?=$ar['ar_id']?>" />
						<input type="text" name="ar_code[<?=$i?>]" value="<?=$ar['ar_code']?>" class="full" />
					</td>
					<td>
						<input type="text" name="ar_name[<?=$i?>]" value="<?=$ar['ar_name']?>" class="full" />
					</td>
					<td>
						<select name="ar_type[<?=$i?>]" class="full">
							<option value="text"		<?=$ar['ar_type']=="text" ? "selected" : ""?>>한줄 텍스트</option>
							<option value="textarea"	<?=$ar['ar_type']=="textarea" ? "selected" : ""?>>텍스트</option>
							<option value="select"		<?=$ar['ar_type']=="select" ? "selected" : ""?>>단일선택</option>
							<option value="file"		<?=$ar['ar_type']=="file" ? "selected" : ""?>>이미지 업로드</option>
							<option value="url"			<?=$ar['ar_type']=="url" ? "selected" : ""?>>외부이미지 링크</option>
						</select>
					</td>
					<td>
						<input type="text" name="ar_size[<?=$i?>]" value="<?=$ar['ar_size']?>" style="width: 50px;"/> px
					</td>
					<td>
						<input type="text" name="ar_text[<?=$i?>]" value="<?=$ar['ar_text']?>"  class="full"/>
					</td>
					<td>
						<input type="text" name="ar_help[<?=$i?>]" value="<?=$ar['ar_help']?>"  class="full"/>
					</td>
					<td>
						<input type="text" name="ar_order[<?=$i?>]" value="<?=$ar['ar_order']?>"  class="full"/>
					</td>
					<td>
						<select name="ar_secret[<?=$i?>]" class="full">
							<option value="">전체공개</option>
							<option value="S" <?=$ar['ar_secret']=="S" ? "selected" : ""?>>오너+관리자 공개</option>
							<option value="H" <?=$ar['ar_secret']=="H" ? "selected" : ""?>>관리자 공개</option>
						</select>
					</td>
				</tr>
			<? } 
					
			if($i==0){ ?>
				<tr>
					<td colspan="9" class="empty_table">등록된 항목이 없습니다.</td>
				</tr>
			<? } ?>
			</tbody>
		</table>
	</div>
</section>
<? echo $frm_submit; ?>
</form>



<form name="farticle_add" method="post" action="./character_article_update.php" autocomplete="off">

<section id="anc_003">
	<h2 class="h2_frm">프로필 항목 등록</h2>
	<?php echo $pg_anchor ?>
	<div class="local_desc02 local_desc">
		<p>프로필 항목 등록은 하단의 확인을 눌러야만 등록이 됩니다. (기본 프로필 양식 및 추가 프로필 양식의 확인버튼을 클릭 시 내용이 날아갑니다.) </p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 120px;">
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th>테마</th>
					<td>
						<?php echo help("테마 전용 항목을 지정할 경우, 테마가 지정되지 않거나 다른 테마에서는 출력되지 않습니다.") ?>
						<?php echo get_theme_select('theme_dir', "ar_theme", ''); ?>
					</td>
				</tr>
				<tr>
					<th>고유코드</th>
					<td>
						<?php echo help("해당 항목만의 고유코드 영문 및 '_' 문자 만으로 입력해 주시길 바랍니다.") ?>
						<input type="text" name="ar_code" value="" size="30" />
					</td>
				</tr>
				<tr>
					<th>항목명</th>
					<td>
						<input type="text" name="ar_name" value="" size="30" />
					</td>
				</tr>
				<tr>
					<th>항목타입</th>
					<td>
						<select name="ar_type">
							<option value="text">한줄 텍스트</option>
							<option value="textarea">텍스트</option>
							<option value="select">단일선택</option>
							<option value="file">이미지 업로드</option>
							<option value="url">외부이미지 링크</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>폼크기</th>
					<td>
						<?php echo help("입력폼의 가로 사이즈를 지정합니다. (텍스트 타입의 경우, 세로 사이즈)") ?>
						<input type="text" name="ar_size" value="" size="20" />px
					</td>
				</tr>
				<tr>
					<th>단위/항목</th>
					<td>
						<?php echo help("입력폼의 옆에 출력될 단위, 혹은 단일 선택 항목의 경우 선택할 항목을 입력해 주세요.") ?>
						<?php echo help("항목 구분은 '||' 로 해주세요. (ex : 남성||여성)") ?>
						<input type="text" name="ar_text" value="" size="30" />
					</td>
				</tr>
				<tr>
					<th>도움말</th>
					<td>
						<?php echo help("해당 항목에 대한 추가 설명문을 입력해 주세요.") ?>
						<input type="text" name="ar_help" value="" size="80" />
					</td>
				</tr>
				<tr>
					<th>순서</th>
					<td>
						<?php echo help("항목 출력 순서를 작성해주세요. 숫자가 작을수록 먼저 출력됩니다.") ?>
						<input type="text" name="ar_order" value="" size="10" />
					</td>
				</tr>
				<tr>
					<th>공개범위</th>
					<td>
						<select name="ar_secret">
							<option value="">전체공개</option>
							<option value="S">오너+관리자 공개</option>
							<option value="H">관리자 공개</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<? echo $frm_submit; ?>

</form>


<?php
include_once ('./admin.tail.php');
?>
