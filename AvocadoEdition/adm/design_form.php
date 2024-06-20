<?php
$sub_menu = "100300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql = "ALTER TABLE {$g5['css_table']} CHANGE  `cs_value`  `cs_value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
sql_query($sql);

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '디자인 설정';
include_once ('./admin.head.php');

$design_result = sql_query("select * from {$g5['css_table']}");
$de = array();
for($i=0; $row = sql_fetch_array($design_result); $i++) {
	$de[$row['cs_name']] = $row;
}

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">화면</a></li>
	<li><a href="#anc_002">메뉴</a></li>
	<li><a href="#anc_003">버튼</a></li>
	<li><a href="#anc_006">테이블(게시판)</a></li>
	<li><a href="#anc_004">로드비 디자인</a></li>
	<li><a href="#anc_005">기타</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

// 폰트 입력용 CSS 추가
if(!isset($config['cf_add_fonts'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_add_fonts` text NOT NULL AFTER `cf_sms_use` ", true);
}

// 디자인 css 버전 처리용
if(!isset($config['cf_css_version'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_css_version` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

if($config['cf_add_fonts']) {
	$config['cf_add_fonts'] = get_text($config['cf_add_fonts'], 0);
}

$css_index = 0;
$editor_list = array();
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section id="anc_001">
	<h2 class="h2_frm">화면 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>헤더사용
						<input type="text" name="cs_name[<?=$css_index?>]" value="use_header" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<?php echo help('로고 및 메뉴 영역 사용에 대한 선택입니다. 내용만 출력하실 경우 사용하지 않음을 선택해 주세요.') ?>
						<select name="cs_value[<?=$css_index?>]">
							<option value="">사용</option>
							<option value="N" <?=$de['use_header']['cs_value'] == 'N' ? "selected" : ""?>>사용하지 않음</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
		<br />
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="2" class="design-th">
						<em><?=$css_index?></em>로고
						<input type="text" name="cs_name[<?=$css_index?>]" value="logo" readonly class="full" />
					</th>
					<td rowspan="2" class="bo-right bo-left txt-center">
						<? if($de['logo']['cs_value']) { ?>
							<img src="<?=$de['logo']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['logo']['cs_value']?>" size="50"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" class="design-th">
						<em><?=$css_index?></em>모바일로고
						<input type="text" name="cs_name[<?=$css_index?>]" value="m_logo" readonly class="full" />
					</th>
					<td rowspan="2" class="bo-right bo-left txt-center">
						<? if($de['m_logo']['cs_value']) { ?>
							<img src="<?=$de['m_logo']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['m_logo']['cs_value']?>" size="50"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" class="design-th">
						<em><?=$css_index?></em>배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['background']['cs_value']) { ?>
							<img src="<?=$de['background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" class="design-th">
						<em><?=$css_index?></em>헤더배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="header_background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['header_background']['cs_value']) { ?>
							<img src="<?=$de['header_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['header_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['header_background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['header_background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['header_background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['header_background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['header_background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['header_background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['header_background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['header_background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['header_background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['header_background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['header_background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['header_background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['header_background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['header_background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['header_background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['header_background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;

						고정&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">스크롤</option>
							<option value="fixed"		<?=$de['header_background']['cs_etc_5'] == 'fixed' ? "selected" : ""?>>고정</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" class="design-th">
						<em><?=$css_index?></em>모바일 배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="m_background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['m_background']['cs_value']) { ?>
							<img src="<?=$de['m_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['m_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['m_background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['m_background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['m_background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['m_background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['m_background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['m_background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['m_background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['m_background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['m_background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['m_background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['m_background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['m_background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['m_background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['m_background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['m_background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['m_background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" class="design-th">
						<em><?=$css_index?></em>모바일 헤더배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="m_header_background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['m_header_background']['cs_value']) { ?>
							<img src="<?=$de['m_header_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['m_header_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['m_header_background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['m_header_background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['m_header_background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['m_header_background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['m_header_background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['m_header_background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['m_header_background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['m_header_background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['m_header_background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['m_header_background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['m_header_background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['m_header_background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['m_header_background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['m_header_background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['m_header_background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['m_header_background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;

						고정&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">스크롤</option>
							<option value="fixed"		<?=$de['m_header_background']['cs_etc_5'] == 'fixed' ? "selected" : ""?>>고정</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">메뉴 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>메뉴위치
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_pos" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<select name="cs_value[<?=$css_index?>]">
							<option value="left">좌측</option>
							<option value="top" <?=$de['menu_pos']['cs_value'] == 'top' ? "selected" : ""?>>상단</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>가로사이즈
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_width" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['menu_width']['cs_value']?>" size="10"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>세로사이즈
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_height" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						<input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['menu_height']['cs_value']?>" size="10"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>메뉴배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['menu_background']['cs_value']) { ?>
							<img src="<?=$de['menu_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['menu_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['menu_background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['menu_background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['menu_background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['menu_background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['menu_background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['menu_background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['menu_background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['menu_background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['menu_background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['menu_background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['menu_background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['menu_background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['menu_background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['menu_background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['menu_background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['menu_background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;

						고정&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">스크롤</option>
							<option value="fixed"		<?=$de['menu_background']['cs_etc_5'] == 'fixed' ? "selected" : ""?>>고정</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

				

				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>모바일 메뉴배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="m_menu_background" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['m_menu_background']['cs_value']) { ?>
							<img src="<?=$de['m_menu_background']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['m_menu_background']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['m_menu_background']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['m_menu_background']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['m_menu_background']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['m_menu_background']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['m_menu_background']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['m_menu_background']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['m_menu_background']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['m_menu_background']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['m_menu_background']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['m_menu_background']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['m_menu_background']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['m_menu_background']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['m_menu_background']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['m_menu_background']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['m_menu_background']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['m_menu_background']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;

						고정&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">스크롤</option>
							<option value="fixed"		<?=$de['m_menu_background']['cs_etc_5'] == 'fixed' ? "selected" : ""?>>고정</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>폰트색상
						<input type="text" name="cs_name[<?=$css_index?>]" value="menu_text" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						일반상태
					</td>
					<td>
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['menu_text']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['menu_text']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트크기&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['menu_text']['cs_etc_1']?>" size="5"/> px

					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						마우스 오버
					</td>
					<td>
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['menu_text']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['menu_text']['cs_etc_2']?>" />
						&nbsp;&nbsp;
						폰트크기&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['menu_text']['cs_etc_3']?>" size="5"/> px
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_006">
	<h2 class="h2_frm">테이블(게시판)디자인</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>전체테이블
						<input type="text" name="cs_name[<?=$css_index?>]" value="board_table" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['board_table']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['board_table']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['board_table']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['board_table']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['board_table']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['board_table']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['board_table']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['board_table']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['board_table']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_board_table" value="top" <?=strstr($de['board_table']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_board_table">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_board_table" value="bottom" <?=strstr($de['board_table']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_board_table">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_board_table" value="left" <?=strstr($de['board_table']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_board_table">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_board_table" value="right" <?=strstr($de['board_table']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_board_table">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>목록 : 제목
						<input type="text" name="cs_name[<?=$css_index?>]" value="list_header" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['list_header']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_header']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_header']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_header']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['list_header']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['list_header']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['list_header']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['list_header']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['list_header']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_list_header" value="top" <?=strstr($de['list_header']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_list_header">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_list_header" value="bottom" <?=strstr($de['list_header']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_list_header">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_list_header" value="left" <?=strstr($de['list_header']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_list_header">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_list_header" value="right" <?=strstr($de['list_header']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_list_header">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>목록 : 내용
						<input type="text" name="cs_name[<?=$css_index?>]" value="list_body" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['list_body']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_body']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_body']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['list_body']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['list_body']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['list_body']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['list_body']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['list_body']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['list_body']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_list_body" value="top" <?=strstr($de['list_body']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_list_body">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_list_body" value="bottom" <?=strstr($de['list_body']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_list_body">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_list_body" value="left" <?=strstr($de['list_body']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_list_body">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_list_body" value="right" <?=strstr($de['list_body']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_list_body">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>양식 : 제목
						<input type="text" name="cs_name[<?=$css_index?>]" value="form_header" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['form_header']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_header']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_header']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_header']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['form_header']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['form_header']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['form_header']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['form_header']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['form_header']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_form_header" value="top" <?=strstr($de['form_header']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_form_header">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_form_header" value="bottom" <?=strstr($de['form_header']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_form_header">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_form_header" value="left" <?=strstr($de['form_header']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_form_header">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_form_header" value="right" <?=strstr($de['form_header']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_form_header">우</label>
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>양식 : 내용
						<input type="text" name="cs_name[<?=$css_index?>]" value="form_body" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['form_body']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_body']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_body']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['form_body']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['form_body']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['form_body']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['form_body']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['form_body']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['form_body']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_form_body" value="top" <?=strstr($de['form_body']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_form_body">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_form_body" value="bottom" <?=strstr($de['form_body']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_form_body">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_form_body" value="left" <?=strstr($de['form_body']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_form_body">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_form_body" value="right" <?=strstr($de['form_body']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_form_body">우</label>
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_003">
	<h2 class="h2_frm">버튼 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>기본버튼
						<input type="text" name="cs_name[<?=$css_index?>]" value="btn_default" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						일반상태
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['btn_default']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_value']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_etc_2']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						마우스 오버
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_3']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_etc_3']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_4']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_etc_4']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_5']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_default']['cs_etc_5']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_12']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_13']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_14']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_default']['cs_etc_15']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>포인트버튼
						<input type="text" name="cs_name[<?=$css_index?>]" value="btn_point" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						일반상태
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['btn_point']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_value']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_etc_2']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						마우스 오버
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_3']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_etc_3']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_4']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_etc_4']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_5']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_point']['cs_etc_5']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_12']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_13']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_14']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_point']['cs_etc_15']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>기타버튼
						<input type="text" name="cs_name[<?=$css_index?>]" value="btn_point" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						일반상태
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_value']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_etc_2']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						마우스 오버
					</td>
					<td>
						텍스트색상&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_3']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_etc_3']?>" />
						&nbsp;&nbsp;

						배경색상&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_4']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_etc_4']?>" />
						&nbsp;&nbsp;

						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_5']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['btn_etc']['cs_etc_5']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_12[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_12']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_13[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_13']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_14[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_14']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_15[<?=$css_index?>]" value="<?=$de['btn_etc']['cs_etc_15']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_004">
	<h2 class="h2_frm">로드 게시판 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="3" scope="row" class="design-th">
						<em><?=$css_index?></em>전체 배경
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_contain_bak" readonly class="full" />
					</th>
					<td rowspan="3" class="bo-right bo-left txt-center">
						<? if($de['mmb_contain_bak']['cs_value']) { ?>
							<img src="<?=$de['mmb_contain_bak']['cs_value']?>" class="prev_thumb"/>
						<? } else { ?>
						이미지 미등록
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="cs_value_file[<?=$css_index?>]" value="" size="50">
					</td></tr><tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_contain_bak']['cs_value']?>" size="50"/>				
					</td></tr><tr>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_contain_bak']['cs_etc_1']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_contain_bak']['cs_etc_1']?>" />
						&nbsp;&nbsp;

						배경반복&nbsp;&nbsp;
						<select name="cs_etc_2[<?=$css_index?>]">
							<option value="">반복</option>
							<option value="no-repeat" <?=$de['mmb_contain_bak']['cs_etc_2'] == 'no-repeat' ? "selected" : ""?>>반복없음</option>
							<option value="repeat-x"  <?=$de['mmb_contain_bak']['cs_etc_2'] == 'repeat-x' ? "selected" : ""?>>가로반복</option>
							<option value="repeat-y"  <?=$de['mmb_contain_bak']['cs_etc_2'] == 'repeat-y' ? "selected" : ""?>>세로반복</option>
						</select>
						&nbsp;&nbsp;

						배경위치&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]">
							<option value="">왼쪽 상단</option>
							<option value="left middle"		<?=$de['mmb_contain_bak']['cs_etc_3'] == 'left middle' ? "selected" : ""?>>왼쪽 중단</option>
							<option value="left bottom"		<?=$de['mmb_contain_bak']['cs_etc_3'] == 'left bottom' ? "selected" : ""?>>왼쪽 하단</option>

							<option value="center top"		<?=$de['mmb_contain_bak']['cs_etc_3'] == 'center top' ? "selected" : ""?>>중간 상단</option>
							<option value="center center"	<?=$de['mmb_contain_bak']['cs_etc_3'] == 'center center' ? "selected" : ""?>>중간 중단</option>
							<option value="center bottom"	<?=$de['mmb_contain_bak']['cs_etc_3'] == 'center bottom' ? "selected" : ""?>>중간 하단</option>

							<option value="right top"		<?=$de['mmb_contain_bak']['cs_etc_3'] == 'right top' ? "selected" : ""?>>오른쪽 상단</option>
							<option value="right middle"	<?=$de['mmb_contain_bak']['cs_etc_3'] == 'right middle' ? "selected" : ""?>>오른쪽 중단</option>
							<option value="right bottom"	<?=$de['mmb_contain_bak']['cs_etc_3'] == 'right bottom' ? "selected" : ""?>>오른쪽 하단</option>
						</select>
						&nbsp;&nbsp;

						배경크기&nbsp;&nbsp;
						<select name="cs_etc_4[<?=$css_index?>]">
							<option value="">원본크기</option>
							<option value="contain"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'contain' ? "selected" : ""?>>맞춤</option>
							<option value="cover"		<?=$de['mmb_contain_bak']['cs_etc_4'] == 'cover' ? "selected" : ""?>>꽉참</option>
							<option value="100% 100%"	<?=$de['mmb_contain_bak']['cs_etc_4'] == '100% 100%' ? "selected" : ""?>>늘이기</option>
						</select>
						&nbsp;&nbsp;

						고정&nbsp;&nbsp;
						<select name="cs_etc_5[<?=$css_index?>]">
							<option value="">스크롤</option>
							<option value="fixed"		<?=$de['mmb_contain_bak']['cs_etc_5'] == 'fixed' ? "selected" : ""?>>고정</option>
						</select>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>공지사항
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_notice" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_notice']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_notice']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_notice']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_notice']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_notice']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_notice']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_notice']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_notice']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_notice']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_notice']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_notice']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_notice" value="top" <?=strstr($de['mmb_notice']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_notice">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_notice" value="bottom" <?=strstr($de['mmb_notice']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_notice">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_notice" value="left" <?=strstr($de['mmb_notice']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_notice">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_notice" value="right" <?=strstr($de['mmb_notice']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_notice">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>접속자 카운터
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_counter" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						<a href="https://whos.amung.us/getstarted/" target="_blank" class="btn_">Whos Link</a>
					</td>
					<td>
						<textarea name="cs_value[<?=$css_index?>]" style="height:90px;"><?=$de['mmb_counter']['cs_value']?></textarea>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>리스트영역
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_list" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_list']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_list']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_list']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_list']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_list']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_list" value="top" <?=strstr($de['mmb_list']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_list">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_list" value="bottom" <?=strstr($de['mmb_list']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_list">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_list" value="left" <?=strstr($de['mmb_list']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_list">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_list" value="right" <?=strstr($de['mmb_list']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_list">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>로그 <br /><span class="red">이미지 + 코멘트</span>
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_list_item" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list_item']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list_item']['cs_etc_1']?>" />
						&nbsp;&nbsp;
						하단여백&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_6']?>" size="10"/> px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_list_item']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_list_item']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_list_item']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_list_item']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_list_item']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_list_item']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_list_item" value="top" <?=strstr($de['mmb_list_item']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_list_item">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_list_item" value="bottom" <?=strstr($de['mmb_list_item']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_list_item">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_list_item" value="left" <?=strstr($de['mmb_list_item']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_list_item">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_list_item" value="right" <?=strstr($de['mmb_list_item']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_list_item">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>이미지
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_log" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_value']?>" size="10"/>	
						<input type="color" class="color-preview" value="<?=$de['mmb_log']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_1']?>" size="10"/>	
						<input type="color" class="color-preview" value="<?=$de['mmb_log']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_log']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_log']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_log']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_log']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_log']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_log']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_log" value="top" <?=strstr($de['mmb_log']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_log">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_log" value="bottom" <?=strstr($de['mmb_log']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_log">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_log" value="left" <?=strstr($de['mmb_log']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_log">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_log" value="right" <?=strstr($de['mmb_log']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_log">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>코멘트
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_reply" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply']['cs_etc_1']?>" />
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_reply']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_reply']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_reply']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_reply']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_reply']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_reply" value="top" <?=strstr($de['mmb_reply']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_reply">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_reply" value="bottom" <?=strstr($de['mmb_reply']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_reply">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_reply" value="left" <?=strstr($de['mmb_reply']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_reply">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_reply" value="right" <?=strstr($de['mmb_reply']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_reply">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>개별코멘트
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_reply_item" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트/여백
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply_item']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply_item']['cs_etc_1']?>" />
						&nbsp;&nbsp;
						하단여백&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_6']?>" size="10"/> px
					</td></tr><tr>
					<td class="bo-right bo-left txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_reply_item']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['mmb_reply_item']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['mmb_reply_item']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['mmb_reply_item']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['mmb_reply_item']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['mmb_reply_item']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_mmb_reply_item" value="top" <?=strstr($de['mmb_reply_item']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_mmb_reply_item">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_mmb_reply_item" value="bottom" <?=strstr($de['mmb_reply_item']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_mmb_reply_item">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_mmb_reply_item" value="left" <?=strstr($de['mmb_reply_item']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_mmb_reply_item">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_mmb_reply_item" value="right" <?=strstr($de['mmb_reply_item']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_mmb_reply_item">우</label>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「작성자」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_name" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_name']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_name']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트크기&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_name']['cs_etc_1']?>" size="5"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「작성자」<br /><span class="red">원글 작성자</span>
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_owner_name" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_owner_name']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트크기&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_1']?>" size="5"/> px
						&nbsp;&nbsp;
						접두문자&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_2']?>" size="5"/>
						&nbsp;&nbsp;
						접미문자&nbsp;&nbsp; <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['mmb_owner_name']['cs_etc_3']?>" size="5"/>
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「날짜」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_datetime" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_datetime']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_datetime']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트크기&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['mmb_datetime']['cs_etc_1']?>" size="5"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「외부링크」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_link" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_link']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_link']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「멤버호출」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_call" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_call']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_call']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「로그링크」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_log_ank" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_log_ank']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_log_ank']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>「해시태그」
						<input type="text" name="cs_name[<?=$css_index?>]" value="mmb_hash" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['mmb_hash']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['mmb_hash']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_005">
	<h2 class="h2_frm">기타 디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="local_desc02 local_desc">
		<p>다양한 디자인을 적용하기 위해선 직접 HTML / CSS 파일을 수정해 주시길 바랍니다.</p>
	</div>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>홈페이지 기본환경 설정</caption>
			<colgroup>
				<col style="width: 140px;">
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>기본색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_default" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['color_default']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['color_default']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>전경색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_bak" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['color_bak']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['color_bak']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>강조색
						<input type="text" name="cs_name[<?=$css_index?>]" value="color_point" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						색상코드&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['color_point']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['color_point']['cs_value']?>" />
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th scope="row" rowspan="2" class="design-th">
						<em><?=$css_index?></em>입력폼
						<input type="text" name="cs_name[<?=$css_index?>]" value="input_bak" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['input_bak']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['input_bak']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['input_bak']['cs_etc_1']?>" />
						&nbsp;&nbsp;
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['input_bak']['cs_etc_2']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_3']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_4']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_5']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['input_bak']['cs_etc_6']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				
				<tr>
					<th scope="row" rowspan="2" class="design-th">
						<em><?=$css_index?></em>기본박스
						<input type="text" name="cs_name[<?=$css_index?>]" value="box_style" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['box_style']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['box_style']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['box_style']['cs_etc_1']?>" />
						&nbsp;&nbsp;
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['box_style']['cs_etc_2']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						모서리 라운드
					</td>
					<td>
						좌측상단 <input type="text" name="cs_etc_3[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_3']?>" size="3"/> px
						&nbsp;&nbsp;
						우측상단 <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_4']?>" size="3"/> px
						&nbsp;&nbsp;
						우측하단 <input type="text" name="cs_etc_5[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_5']?>" size="3"/> px
						&nbsp;&nbsp;
						좌측하단 <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['box_style']['cs_etc_6']?>" size="3"/> px
					</td>
				</tr <? $css_index++; ?>>

				<tr>
					<th scope="row" class="design-th">
						<em><?=$css_index?></em>이퀄라이저
						<input type="text" name="cs_name[<?=$css_index?>]" value="equalizer" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						-
					</td>
					<td>
						막대색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['equalizer']['cs_value']?>" size="8"/>
						<input type="color" class="color-preview" value="<?=$de['equalizer']['cs_value']?>" />
						&nbsp;&nbsp;
						외부광선&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['equalizer']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['equalizer']['cs_etc_1']?>" />
					</td>
				</tr <? $css_index++; ?>>
				<tr>
					<th rowspan="2" scope="row" class="design-th">
						<em><?=$css_index?></em>서브메뉴
						<input type="text" name="cs_name[<?=$css_index?>]" value="sub_menu" readonly class="full" />
					</th>
					<td class="bo-right bo-left txt-center">
						배경/폰트
					</td>
					<td>
						배경색상&nbsp;&nbsp; <input type="text" name="cs_value[<?=$css_index?>]" value="<?=$de['sub_menu']['cs_value']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['sub_menu']['cs_value']?>" />
						&nbsp;&nbsp;
						폰트색상&nbsp;&nbsp; <input type="text" name="cs_etc_1[<?=$css_index?>]" value="<?=$de['sub_menu']['cs_etc_1']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['sub_menu']['cs_etc_1']?>" />
						&nbsp;&nbsp;
						오버색상&nbsp;&nbsp; <input type="text" name="cs_etc_6[<?=$css_index?>]" value="<?=$de['sub_menu']['cs_etc_6']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['sub_menu']['cs_etc_6']?>" />
					</td></tr><tr>
					<td class="bo-right txt-center">
						라인
					</td>
					<td>
						라인색상&nbsp;&nbsp; <input type="text" name="cs_etc_2[<?=$css_index?>]" value="<?=$de['sub_menu']['cs_etc_2']?>" size="10"/>
						<input type="color" class="color-preview" value="<?=$de['sub_menu']['cs_etc_2']?>" />
						&nbsp;&nbsp;

						라인타입&nbsp;&nbsp;
						<select name="cs_etc_3[<?=$css_index?>]" style="width: 84px;">
							<option value="">라인없음</option>
							<option value="solid" <?=$de['sub_menu']['cs_etc_3'] == 'solid' ? "selected" : ""?>>실선</option>
							<option value="dotted" <?=$de['sub_menu']['cs_etc_3'] == 'dotted' ? "selected" : ""?>>점선</option>
							<option value="dashed" <?=$de['sub_menu']['cs_etc_3'] == 'dashed' ? "selected" : ""?>>대쉬선</option>
							<option value="double" <?=$de['sub_menu']['cs_etc_3'] == 'double' ? "selected" : ""?>>이중선</option>
						</select>
						&nbsp;&nbsp;

						라인굵기&nbsp;&nbsp; <input type="text" name="cs_etc_4[<?=$css_index?>]" value="<?=$de['sub_menu']['cs_etc_4']?>" size="5"/> px
						&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_1_sub_menu" value="top" <?=strstr($de['sub_menu']['cs_etc_5'], 'top') ? "checked" : ""?> />
						<label for="cs_etc_5_1_sub_menu">상&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_2_sub_menu" value="bottom" <?=strstr($de['sub_menu']['cs_etc_5'], 'bottom') ? "checked" : ""?> />
						<label for="cs_etc_5_2_sub_menu">하&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_3_sub_menu" value="left" <?=strstr($de['sub_menu']['cs_etc_5'], 'left') ? "checked" : ""?> />
						<label for="cs_etc_5_3_sub_menu">좌&nbsp;</label>

						<input type="checkbox" name="cs_etc_5[<?=$css_index?>][]" id="cs_etc_5_4_sub_menu" value="right" <?=strstr($de['sub_menu']['cs_etc_5'], 'right') ? "checked" : ""?> />
						<label for="cs_etc_5_4_sub_menu">우</label>
					</td>
				</tr <? $css_index++; ?>>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>


</form>

<script>
function fconfigform_submit(f)
{
	f.action = "./design_form_update.php";
	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
