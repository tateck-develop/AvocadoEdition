<?php
$sub_menu = '600600';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$html_title = "미궁";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
	$html_title .= " 수정";
	$readonly = " readonly";

	$sql = " select * from {$g5['maze_table']} where ma_id = '$ma_id' ";
	$ma = sql_fetch($sql);
	if (!$ma['ma_id'])
		alert('등록된 자료가 없습니다.');
}
else
{
	$html_title .= ' 입력';
	$ma['ma_order'] = 0;
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmcontentform" action="./maze_formupdate.php" onsubmit="return frmcontentform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="ma_id" value="<?=$ma['ma_id']?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 50px;">
		<col style="width: 100px;">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="ma_subject">제목</label></th>
		<td colspan="2"><input type="text" name="ma_subject" value="<?php echo htmlspecialchars2($ma['ma_subject']); ?>" id="ma_subject" required class="frm_input required" size="90"></td>
	</tr>
	<tr>
		<th scope="row">내용</th>
		<td colspan="2"><?php echo editor_html('ma_content', get_text($ma['ma_content'], 0)); ?></td>
	</tr>
	<tr>
		<th scope="row"><label for="ma_answer">정답</label></th>
		<td colspan="2" colspan="2"><input type="text" name="ma_answer" value="<?php echo htmlspecialchars2($ma['ma_answer']); ?>" id="ma_answer" class="frm_input" size="90"></td>
	</tr>
	<tr>
		<th rowspan="2">이전버튼</th>
		<td>
			직접등록&nbsp;&nbsp; <input type="file" name="ma_btn_prev_file" value="" size="50">
		</td></tr><tr>
		<td>
			외부경로&nbsp;&nbsp; <input type="text" name="ma_btn_prev" value="<?=$ma['ma_btn_prev']?>" size="50"/>
		</td>
	</tr>
	<tr>
		<th rowspan="2">다음버튼</th>
		<td>
			직접등록&nbsp;&nbsp; <input type="file" name="ma_btn_next_file" value="" size="50">
		</td></tr><tr>
		<td>
			외부경로&nbsp;&nbsp; <input type="text" name="ma_btn_next" value="<?=$ma['ma_btn_next']?>" size="50"/>
		</td>
	</tr>
	<tr>
		<th rowspan="2">배경이미지</th>
		<td>
			직접등록&nbsp;&nbsp; <input type="file" name="ma_background_file" value="" size="50">
		</td></tr><tr>
		<td>
			외부경로&nbsp;&nbsp; <input type="text" name="ma_background" value="<?=$ma['ma_background']?>" size="50"/>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="ma_order">순서</label></th>
		<td colspan="2"><input type="text" name="ma_order" value="<?php echo $ma['ma_order']; ?>" id="ma_order" required class="frm_input required" size="10"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./maze_list.php">목록</a>
</div>

</form>

<script>
function frmcontentform_check(f)
{
	errmsg = "";
	errfld = "";

	<?php echo get_editor_js('ma_content'); ?>
	<?php echo chk_editor_js('ma_content'); ?>

	check_field(f.ma_subject, "제목을 입력하세요.");
	check_field(f.ma_content, "내용을 입력하세요.");

	if (errmsg != "") {
		alert(errmsg);
		errfld.focus();
		return false;
	}
	return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
