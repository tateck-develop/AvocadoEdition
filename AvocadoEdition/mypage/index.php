<?php
include_once('./_common.php');
include_once('./_head.php');
?>


<h2 class="page-title">
	<strong>계정정보</strong>
	<span>My Information</span>
</h2>

<section>
	<table class="theme-form">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<th>오너</th>
				<td>
					<?=$member['mb_nick']?> <? if($member['mb_birth']) { ?>( <?=@number_format($member['mb_birth'])?> 년생 )<? } ?>
				</td>
			</tr>
			<tr>
				<th>E-mail</th>
				<td>
					<?=$member['mb_email']?>
				</td>
			</tr>
			<tr>
				<th>가입일</th>
				<td>
					<?=$member['mb_open_date']?>
				</td>
			</tr>
<? if($member['mb_error_cnt'] > 0) { ?>
			<tr>
				<th>경고내역</th>
				<td>
					<p>
						[ <span style='color: red; font-weight: bold; font-family: "Dotum";'><?=number_format($member['mb_error_cnt'])?></span> ] 회
					</p>
					<?=$member['mb_error_content']?>
				</td>
			</tr>
<? } ?>
		</tbody>
	</table>
	<br />
	<div class="txt-center">
		<a href="<?=G5_BBS_URL?>/member_confirm.php?url=register_form.php" class="ui-btn">정보수정</a>
	</div>
</section>


<h2 class="page-title">
	<strong>호출내역</strong>
	<span>My Calling</span>
</h2>
<section>
	<table class="theme-list">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<thead>
			<tr>
				<th>호출</th>
				<th>내용</th>
			</tr>
		</thead>
		<tbody>
<?
	$sql = " update {$g5['member_table']} 
				set mb_board_call = '',
					mb_board_link = ''
			where mb_id = '".$member['mb_id']."' ";
	sql_query($sql);

	if(!$page) $page= 1;
	
	// 알람 내역을 가져온다
	$row = sql_fetch("select count(*) as cnt from {$g5['call_table']} where re_mb_id = '{$member['mb_id']}'");
	$total_count = $row['cnt'];
	$page_rows = 10;

	$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
	$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

	$sql = " select * from {$g5['call_table']} where re_mb_id = '{$member['mb_id']}' order by bc_datetime desc limit {$from_record}, $page_rows ";
	$result = sql_query($sql);

	for($i = 0; $row = sql_fetch_array($result); $i++) { 
?>

			<tr <?=!$row['bc_check'] ? "class='check'":""?>>
				<td><?=$row['mb_name']?></td>
				<td>
					<p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$row['bo_table']?>&amp;log=<?=$row['wr_num'] * -1?>"><?=$row['memo']?></a>
					</p>
				</td>
			</tr>
<? }
	if($i == 0) { 
?>
			<tr>
				<td colspan="2" class="no-data">
					호출 내역이 존재하지 않습니다.
				</td>
			</tr>
<? } ?>
		</tbody>
	</table>
</section>


<div class="ui-form-layout">

</div>
<?
$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './index.php?page=');

echo $write_pages;
?>
<hr class="padding" />
<div class="txt-center">
	<a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" class="ui-btn etc">탈퇴</a>
</div>

<?php
include_once('./_tail.php');
?>
