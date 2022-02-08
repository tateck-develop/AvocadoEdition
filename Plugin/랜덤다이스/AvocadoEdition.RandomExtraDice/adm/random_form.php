<?php
$sub_menu = '600200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$html_title = "랜덤주사위";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
	$sql = " select * from {$g5['random_dice_table']} where ra_id = '$ra_id' ";
	$ra = sql_fetch($sql);
	if (!$ra['ra_id'])
		alert('등록된 자료가 없습니다.');

	$html_title .= "(".$ra['ra_title'].") 수정";
	$readonly = " readonly";
}
else
{
	$html_title .= ' 입력';
}
$g5['title'] = $html_title;

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본정보 설정</a></li>
</ul>
';


$now_board = "";
$search_board_sql = " select bo_table, bo_subject from {$g5['board_table']} where bo_type = 'mmb' order by bo_subject asc ";
$search_board = sql_query($search_board_sql);
$board_select_option = array();
for($i=0; $row=sql_fetch_array($search_board); $i++) { 
	$board_select_option[] = $row;
}



$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./random_list.php?{$qstr}">목록</a>
</div>';


include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmraid_form" action="./random_form_update.php" onsubmit="return frmraid_form_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="ra_id" value="<?php echo $ra_id; ?>">
<input type="hidden" name="token" value="">


<section id="anc_001">
	<h2 class="h2_frm">랜덤주사위 기본 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 120px;">
			<col style="width: 80px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">사용</th>
			<td colspan="2">
				<input type="checkbox" name="ra_use" value="1" <?=$ra['ra_use'] ? "checked" : ""?> />
			</td>
		</tr>
		<tr>
			<th scope="row">출력 게시판</th>
			<td colspan="2">
				<select name="bo_table">
					<? for($j=0; $j < count($board_select_option); $j++) { ?>
						<option value="<?=$board_select_option[$j]['bo_table']?>" <?=$ra['bo_table'] == $board_select_option[$j]['bo_table'] ? "selected" : ""?>>
							<?=$board_select_option[$j]['bo_subject']?>
						</option>
					<? } ?>
				</select>
			</td>
		</tr>

		<tr>
			<th scope="row">랜덤주사위명<strong class="sound_only">필수</strong></th>
			<td colspan="2"><input type="text" name="ra_title" id="ra_title" class="required frm_input" required value="<?=$ra['ra_title']?>"></td>
		</tr>
		<tr>
			<th scope="row">굴림횟수제한</th>
			<td colspan="2">
				<?php echo help("0 : 무제한") ?>
				<input type="text" name="ra_limit" id="ra_limit" class="frm_input" value="<?=$ra['ra_limit'] ? $ra['ra_limit'] : "0"?>" style="width:50px;"> 회&nbsp;&nbsp;

				<input type="checkbox" name="ra_limit_day" id="ra_limit_day" value="1" <?=$ra['ra_limit_day'] ? "checked" : ""?> /> <label for="ra_limit_day">1일초기화</label>
			</td>
		</tr>
		
		<tr>
			<th scope="row">랜덤 이미지</th>
			<td colspan="2">
				<?php echo help("랜덤으로 출력될 주사위 이미지의 경로를 입력해주세요. (여러개 입력 시, 엔터로 구분)") ?>
				<textarea name="ra_img" style="line-height:30px; padding:0 5px; background:url('./img/bak_textarea.jpg') repeat 0 0; background-attachment:local;"><?=$ra['ra_img']?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ra_text">랜덤 텍스트</label></th>
			<td colspan="2">
				<?php echo help("랜덤으로 출력될 텍스트를 입력해주세요. (여러개 입력 시, 엔터로 구분)") ?>
				<div class="local_desc01 local_desc">
					<p>
						&lt;i&gt;&lt;/i&gt; : <span style="display:inline-block; width:12px; height:12px; background:<?=$i_color?>; border:1px solid #000;"></span>&nbsp;&nbsp;&nbsp;
						&lt;em&gt;&lt;/em&gt; : <span style="display:inline-block; width:12px; height:12px; background:<?=$em_color?>; border:1px solid #000;"></span>&nbsp;&nbsp;&nbsp;
						&lt;strong&gt;&lt;/strong&gt; : <span style="display:inline-block; width:12px; height:12px; background:<?=$strong_color?>; border:1px solid #000;"></span>&nbsp;&nbsp;&nbsp;
						{아이템이름} : 아이템 획득&nbsp;&nbsp;&nbsp;
						[숫자] : 상태바 사용시 상태바 증감 설정 (-N ~ N 설정)
					</p>
				</div>
				<textarea name="ra_text" style="height:350px; line-height:30px; padding:0 5px; background:url('./img/bak_textarea.jpg') repeat 0 0; background-attachment:local;"><?=$ra['ra_text']?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row" rowspan="6">상태바</th>
			<td>사용여부</td>
			<td>
				<input type="checkbox" name="ra_progress" value="1" <?=$ra['ra_progress'] ? "checked" : ""?> >
			</td>
		</tr>
		<tr>
			<td>상태바 이름</td>
			<td>
				<input type="text" name="ra_progress_title" class="frm_input" style="width:80%;" value="<?=$ra['ra_progress_title']?>">
			</td>
		</tr>
		<tr>
			<td>최대값</td>
			<td>
				<input type="text" name="ra_progress_max" class="frm_input" style="width:50px;" value="<?=$ra['ra_progress_max']?>">
			</td>
		</tr>
		<tr>
			<td>추가</td>
			<td>
				<input type="text" name="ra_progress_p" class="frm_input" style="width:50px;" value="<?=$ra['ra_progress_p']?>">
			</td>
		</tr>
		<tr>
			<td>감소</td>
			<td>
				<input type="text" name="ra_progress_m" class="frm_input" style="width:50px;" value="<?=$ra['ra_progress_m']?>">
			</td>
		</tr>
		<tr>
			<td>스킨</td>
			<td>
				<?php echo get_skin_select('random', 'ra_skin', "ra_skin", $ra['ra_skin']); ?>
			</td>
		</tr>
		
		</tbody>
		</table>
	</div>
</section>
<? echo $frm_submit; ?>

</form>

<script>
function frmraid_form_check(f)
{
	return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
