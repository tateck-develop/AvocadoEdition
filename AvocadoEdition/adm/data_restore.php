<?php
$sub_menu = "900500";
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", G5_URL);

$g5['title'] = "디자인 복원하기";
include_once("./admin.head.php");


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">디자인</a></li>
	<li><a href="#anc_002">캐릭터 정보</a></li>
	<li><a href="#anc_003">스탯설정</a></li>
	<li><a href="#anc_004">경험치/포인트</a></li>
</ul>';

function get_bakup_list($cate) {
	global $g5;
	
	$backup_list = '';
	$result = sql_query("select * from {$g5['backup_table']} where ba_cate = '{$cate}' order by ba_id desc");

	$backup_list .= "<option value=''>복원 할 시점을 선택해 주세요.</option>";

	for($i=0; $bak = sql_fetch_array($result); $i++) {
		$backup_list .= "<option value='".$bak['ba_path']."'>복원 - ".$bak['ba_title']."</option>";
	}

	return $backup_list;
}

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="복원하기" class="btn_submit" accesskey="s">
</div>';

?>

<div class="local_desc02 local_desc">
	<p>
		복원파일을 업로드 하여 디자인 설정을 복원합니다.<br />
		이미지 파일은 복원 되지 않습니다. 이미지는 따로 올려주세요.
	</p>
</div>


<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">

<section id="anc_001">
	<h2 class="h2_frm">디자인 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption></caption>
			<colgroup>
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[0]" value="css_config" />
						디자인 설정
					</th>
					<td>
						<select name="ba_path[0]">
							<?=get_bakup_list('css_config')?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[1]" value="content" />
						메인/메뉴 화면
					</th>
					<td>
						<select name="ba_path[1]">
							<?=get_bakup_list('content')?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">캐릭터 정보</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption></caption>
			<colgroup>
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[2]" value="character" />
						캐릭터 기본 정보
					</th>
					<td>
						<select name="ba_path[2]">
							<?=get_bakup_list('character')?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[3]" value="article_value" />
						추가 정보
					</th>
					<td>
						<select name="ba_path[3]">
							<?=get_bakup_list('article_value')?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[4]" value="character_closthes" />
						옷장 정보
					</th>
					<td>
						<select name="ba_path[4]">
							<?=get_bakup_list('character_closthes')?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[5]" value="has_title" />
						타이틀 정보
					</th>
					<td>
						<select name="ba_path[5]">
							<?=get_bakup_list('has_title')?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</section>

<?php echo $frm_submit; ?>

<section id="anc_003">
	<h2 class="h2_frm">스탯 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption></caption>
			<colgroup>
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[6]" value="status" />
						스탯 설정
					</th>
					<td>
						<select name="ba_path[6]">
							<?=get_bakup_list('status')?>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[7]" value="status_character" />
						캐릭터 스탯 정보
					</th>
					<td>
						<select name="ba_path[7]">
							<?=get_bakup_list('status_character')?>
						</select>
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>

</section>

<?php echo $frm_submit; ?>

<section id="anc_004">
	<h2 class="h2_frm">경험치 / 포인트</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption></caption>
			<colgroup>
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[8]" value="exp" />
						경험치 내역
					</th>
					<td>
						<select name="ba_path[8]">
							<?=get_bakup_list('exp')?>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[9]" value="point" />
						포인트(화폐) 내역
					</th>
					<td>
						<select name="ba_path[9]">
							<?=get_bakup_list('point')?>
						</select>
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
	f.action = "./data_restore_update.php";
	return true;
}
</script>

<?php
include_once("./admin.tail.php");
?>
