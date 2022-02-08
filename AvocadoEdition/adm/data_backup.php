<?php
$sub_menu = "900400";
include_once("./_common.php");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.", G5_URL);

$g5['title'] = "데이터 백업지점 설정";
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

	$result = sql_query("select * from {$g5['backup_table']} where ba_cate = '{$cate}'");

	for($i=0; $bak = sql_fetch_array($result); $i++) {
		if($i == 0) { $border = ""; } else {
			$border = "border-top: 1px dashed #e1e1e1;";
		}
		$backup_list .= "<p style='line-height: 3.0em; {$border}'>
			백업 - ".$bak['ba_title']."&nbsp;&nbsp;
			<a href='./data_backup_delete.php?ba_id=".$bak['ba_id']."' style='color: #29c7ca;'>삭제</a>
		</p>";
	}

	return $backup_list;
}

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="전체 백업" class="btn_submit" accesskey="s">
</div>';


?>

<div class="local_desc02 local_desc">
	<p>
		현재 사이트에 적용된 각 DB 데이터를 백업 합니다.<br />
		이미지 파일은 백업 되지 않습니다. 이미지는 따로 백업 받아 주세요.
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
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[0]" value="css_config" />
						디자인 설정
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=css_config" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('css_config')?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[1]" value="content" />
						메인/메뉴 화면
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=content" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('content')?>
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
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[2]" value="character" />
						캐릭터 기본 정보
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=character" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('character')?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[3]" value="article_value" />
						추가 정보
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=article_value" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('article_value')?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[4]" value="character_closthes" />
						옷장 정보
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=character_closthes" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('character_closthes')?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[5]" value="has_title" />
						타이틀 정보
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=has_title" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('has_title')?>
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
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[6]" value="status" />
						스탯 설정
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=status" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('status')?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[7]" value="status_character" />
						캐릭터 스탯 정보
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=status_character" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('status_character')?>
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
				<col style="width: 130px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[8]" value="exp" />
						경험치 내역
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=exp" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('exp')?>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<input type="hidden" name="ba_cate[9]" value="point" />
						포인트(화폐) 내역
					</th>
					<td class="bo-right bo-left txt-center btn_confirm">
						<a href="./data_backup_update.php?category=point" class="btn_submit">개별 백업</a>
					</td>
					<td>
						<?=get_bakup_list('point')?>
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
	f.action = "./data_backup_update.php";
	return true;
}
</script>

<?php
include_once("./admin.tail.php");
?>
