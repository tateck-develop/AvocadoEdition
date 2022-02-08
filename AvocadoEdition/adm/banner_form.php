<?php
$sub_menu = '100320';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$html_title = '메인슬라이드 ';
$g5['title'] = $html_title.'관리';

if ($w=="u")
{
	$html_title .= ' 수정';
	$sql = " select * from {$g5['banner_table']} where bn_id = '$bn_id' ";
	$bn = sql_fetch($sql);
}
else
{
	$html_title .= ' 입력';
	$bn['bn_url']        = "http://";
	$bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
	$bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fbanner" action="./banner_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">

<div class="tbl_frm01 tbl_wrap">
	<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col style="width: 130px">
			<col style="width: 150px">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th scope="row" rowspan="2">배너 이미지</th>
				<td rowspan="2" class="txt-center bo-right ">
				<? if($bn['bn_img']) { ?>
					<img src="<?=$bn['bn_img']?>" class="prev_thumb" />
				<? } else { ?>
					이미지 없음
				<? } ?>
				</td>
				<td>
					직접등록&nbsp;&nbsp; <input type="file" name="bn_img_file" size="50"/>
				</td></tr><tr>
				<td>
					외부경로&nbsp;&nbsp; <input type="text" name="bn_img" value="<?=$bn['bn_img']?>" size="50"/>
				</td>
			</tr>

			<tr>
				<th scope="row" rowspan="2">배너 모바일 이미지</th>
				<td rowspan="2" class="txt-center bo-right ">
				<? if($bn['bn_img']) { ?>
					<img src="<?=$bn['bn_m_img']?>" class="prev_thumb" />
				<? } else { ?>
					이미지 없음
				<? } ?>
				</td>
				<td>
					직접등록&nbsp;&nbsp; <input type="file" name="bn_m_img_file" size="50"/>
				</td></tr><tr>
				<td>
					외부경로&nbsp;&nbsp; <input type="text" name="bn_m_img" value="<?=$bn['bn_m_img']?>" size="50"/>
				</td>
			</tr>

			<tr>
				<th>대체텍스트</th>
				<td colspan="2">
					<input type="text" name="bn_alt" value="<?php echo $bn['bn_alt']; ?>" size="84">
				</td>
			</tr>

			<tr>
				<th>링크</th>
				<td colspan="2">
					<input type="text" name="bn_url" value="<?php echo $bn['bn_url']; ?>" size="84" />
				</td>
			</tr>

			<tr>
				<th>새창</th>
				<td colspan="2">
					<?php echo help("배너 클릭시 새창을 띄울지를 설정합니다.", 50); ?>
					<select name="bn_new_win">
						<option value="0" <?php echo get_selected($bn['bn_new_win'], 0); ?>>사용안함</option>
						<option value="1" <?php echo get_selected($bn['bn_new_win'], 1); ?>>사용</option>
						<option value="2" <?php echo get_selected($bn['bn_new_win'], 2); ?>>팝업사용</option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="bn_begin_time">시작일시</label></th>
				<td colspan="2">
					<?php echo help("배너 게시 시작일시를 설정합니다."); ?>
					<input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
					<input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
					<label for="bn_begin_chk">오늘</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="bn_end_time">종료일시</label></th>
				<td colspan="2">
					<?php echo help("비쥬얼 게시 종료일시를 설정합니다."); ?>
					<input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
					<input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
					<label for="bn_end_chk">오늘+31일</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="bn_order">출력 순서</label></th>
				<td colspan="2">
					<?php echo help("배너를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다."); ?>
					<?php echo order_select("bn_order", $bn['bn_order']); ?>
				</td>
			</tr>

		</tbody>
	</table>

</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./banner_list.php">목록</a>
</div>

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
