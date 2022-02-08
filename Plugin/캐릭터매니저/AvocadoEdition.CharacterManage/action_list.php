<?php
$sub_menu = "200200";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'r');

$check_member = sql_fetch("select * from {$g5['member_table']} limit 0, 1");
if(!isset($check_member['mb_error_cnt'])) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `mb_error_cnt` int(11) NOT NULL DEFAULT '0' AFTER `mb_10` ", true);
}
if(!isset($check_member['mb_error_content'])) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `mb_error_content` varchar(255) NOT NULL DEFAULT '' AFTER `mb_error_cnt` ", true);
}

if(!isset($config['cf_reply_cnt'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_reply_cnt` int(11) NOT NULL DEFAULT '0' AFTER `cf_10` ", true);
	sql_query("update {$g5['config_table']} set cf_reply_cnt = '3'");
	$config['cf_reply_cnt'] = 3;
}

if($cf_reply_cnt > 0) {
	sql_query("update {$g5['config_table']} set cf_reply_cnt = '{$cf_reply_cnt}'");
	$config['cf_reply_cnt'] = $cf_reply_cnt;
}


if(!$s_board) { 
	$s_board = "free";
}
if (!$sst) {
	$sst = "bo.wr_logs";
	$sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";



$now_board = "";
$search_board_sql = " select bo.bo_table, bo.bo_subject, gr.gr_id, gr.gr_subject from {$g5['board_table']} bo, {$g5['group_table']} gr where bo.gr_id = gr.gr_id order by gr.gr_id asc, bo.bo_subject asc ";
$search_board = sql_query($search_board_sql);
$board_select_option = "";
for($i=0; $row=sql_fetch_array($search_board); $i++) { 
	if(!$s_board) { 
		$s_board = $row['bo_table'];
	}
	if($row['bo_table'] == $s_board) { 
		$s_board_select = "selected";
		$now_board = $row['bo_subject'];
		
	} else { 
		$s_board_select = "";
	}
	$board_select_option .= '<option value="'.$row['bo_table'].'" '.$s_board_select.'>['.$row['gr_subject'].'] '.$row['bo_subject'].'</option>';
}


$write_table = $g5['write_prefix'] . $s_board;

$qstr .= "&s_board=".$s_board."&s_date=".$s_date."&e_date=".$e_date."&check_manner=".$check_manner;

if(!$s_date) $s_date = date('Y-m-d', strtotime("last Monday"));
if(!$e_date) {
	$e_date = date('Y-m-d', strtotime("next Sunday"));
}


// -- 덧글 현황 처리하는 부분부터
// 리플 매너 기록하는 필드를 각 게시판에 추가한다. (없을 경우)
if(!sql_query(" select wr_manner from {$write_table} limit 1 ", false)) {
	$sql = " ALTER TABLE `{$write_table}`  ADD `wr_manner` int(11) NOT NULL , ADD `wr_manner_txt` VARCHAR(255) NOT NULL ";
	sql_query($sql, false);
}
$sql_common = " from {$g5['member_table']} mb
					LEFT JOIN
						(select	*,
								count(if(wr_id = wr_parent, wr_id, null)) as wr_logs,
								count(if(wr_id != wr_parent, wr_id, null)) as wr_cms
							from {$write_table}
							where	wr_datetime >= '$s_date' and
									wr_datetime <= '$e_date'
							group by mb_id
						) bo
					ON mb.mb_id = bo.mb_id ";
$sql_search = " where mb.mb_level > 1 and mb.mb_leave_date = '' and mb.mb_id != '{$config['cf_admin']}' and mb.mb_id NOT LIKE 'test%' and mb.ch_id != '0' ";

if($s_mbid) {
	$sql_search .= " and mb.mb_id = '{$s_mbid}' ";
}

$sql = " select count(*) as cnt {$sql_common} {$sql_search}";


$row = sql_fetch($sql);
$total_count = $row['cnt'];

if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)

if($check_manner == '1') { 
	$page_rows = 10;
} else if($check_manner == '2') { 
	$page_rows = 1000;
} else {
	$page_rows = 20;
}


$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$g5['title'] = '활동량 관리';
include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');


$sql = " select
			mb.mb_id,
			mb.mb_name,
			mb.ch_id,
			mb.mb_today_login,
			mb.mb_error_content,
			bo.wr_logs, bo.wr_cms,
			mb.mb_error_cnt
			
			{$sql_common} {$sql_search} {$sql_order}
			limit {$from_record}, $page_rows";
//echo $sql;
$result = sql_query($sql);
if($check_manner || $check_manner2) { 
	$colspan = 10;
} else {
	$colspan = 9;
}

?>

<style>
.search-box {display:block; position:relative; clear:both; margin:20px 0; padding-right:90px; background:#fafafa; border:1px solid #ddd;}
.search-box .tbl {display:table; width:100%; max-width:100%; table-layout:fixed;}
.search-box .row {display:table-row;}
.search-box .row > * {display:table-cell; vertical-align:middle; padding:10px;}
.search-box .row * {max-width:100% !important;}
.search-box .label {width:100px; text-align:right;}
.search-box .control {position:absolute; top:10px; right:10px; bottom:10px; width:70px; border:none;}
.search-box .control > * {display:block; width:100% !important; height:100% !important;}
</style>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	총 회원 수 <?php echo number_format($total_count) ?>명
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">

<div class="search-box">
	<div class="tbl">
		<div class="row">
			<div class="label">
				<strong>게시판 지정</strong>
			</div>
			<div>
				<select name="s_board">
					<?=$board_select_option?>
				</select>
			</div>
			<div class="label">
				<strong>기간별검색</strong>
			</div>
			<div>
				<input type="text" name="s_date" value="<?=$s_date?>" style="width:100px;" />
				~
				<input type="text" name="e_date" value="<?=$e_date?>" style="width:100px;" />
			</div>
			<div class="label">
				<strong>멤버ID</strong>
			</div>
			<div>
				<input type="text" name="s_mbid" value="<?=$s_mbid?>" style="width:100px;" />
			</div>
		</div>
		<div class="row">
			<div class="label">
				<strong>리플매너</strong>
			</div>
			<div>
				<select name="check_manner">
					<option value="">리플매너 체크하지 않음</option>
					<option value="1" <?=$check_manner == '1' ? "selected" : ""?>>10명씩 검색</option>
					<option value="2" <?=$check_manner == '2' ? "selected" : ""?>>전체 검색 (게시물이 많을 시 속도가 굉장히 느립니다.)</option>
				</select>
			</div>
			<div class="label">
				<strong>로그아래 댓글 수</strong>
			</div>
			<div>
				<input type="text" value="<?=$config['cf_reply_cnt']?>" name="cf_reply_cnt" style="width:30px;" /> 개
			</div>
		</div>
	</div>
	<div class="control">
		<input type="submit" class="btn_submit" value="검색">
	</div>
</div>

</form>

<form name="fmemberlist" id="fmemberlist" action="./action_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<div class="tbl_head01 tbl_wrap" id="actionStateList">
	<table class="tbl_hover">
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 90px;" />
		<col style="width: 100px;" />
		<col style="width: 100px;" />
		<col style="width: 120px;" />
		<col style="width: 60px;" />
		<col style="width: 60px;" />
		<? if($check_manner || $check_manner2) { ?>
		<col style="width: 80px;" />
		<col style="width: 280px;" />
		<? } ?>
		<col style="width: 150px;" />
		<col style="width: 80px;" />
		<col />
	</colgroup>
	<thead>
		<tr>
			<th scope="col" id="mb_idx"><?php echo subject_sort_link('mb.ch_id', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>캐릭터IDX</a></th>
			<th scope="col" id="mb_list_id"><?php echo subject_sort_link('mb.mb_id', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>아이디</a></th>
			<th scope="col" id="mb_list_name"><?php echo subject_sort_link('mb.mb_nick', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>닉네임</a></th>
			<th scope="col"><?php echo subject_sort_link('bo.wr_subject', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>대표캐릭터</a></th>
			<th><?php echo subject_sort_link('wr_logs', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>로그</a></th>
			<th><?php echo subject_sort_link('wr_cms', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>덧글</a></th>
			<? if($check_manner || $check_manner2) { ?>
			<th>리플매너</th>
			<th>리플 미기재 로그</th>
			<? } ?>

			<th scope="col"><?php echo subject_sort_link('mb.mb_today_login', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>최종 접속</a></th>
			<th scope="col"><?php echo subject_sort_link('mb.mb_error_cnt', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>누적경고</a></th>
			<th>경고내용</th>
		</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<tr class="<?php echo $bg; ?>" data-mbid = "<?=$row['mb_id']?>">
		<td>
			<?=$row['ch_id']?>
		</td>
		<td>
			<input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
			<input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			<?=$row['mb_id']?>
		</td>
		<td><?=$row['mb_name']?></td>
		<td><a href="./character_form.php?w=u&amp;ch_id=<?=$row['ch_id']?>" target="_blank"><?=get_character_name($row['ch_id'])?></a></td>
		<td style="text-align: center;"><?=number_format($row['wr_logs'])?></td>
		<td style="text-align: center;"><?=number_format($row['wr_cms'])?></td>
		<? if($check_manner || $check_manner2) { ?>
		<td>
			<div class="manner-state"><span style="color:#ddd;">Loading...</span></div>
		</td>
		<td>
			<div class="manner-link"><span style="color:#ddd;">Loading...</span></div>
		</td>
		<? } ?>
		<td style="text-align: center; color: #999;"><?=$row['mb_today_login']?></td>
		<td style="text-align: center;">
			<input type="text" name="mb_error_cnt[<?php echo $i ?>]" value="<?php echo $row['mb_error_cnt'] ?>" size="3" style="width:50%;"> 회
		</td>
		<td>
			<input type="text" name="mb_error_content[<?php echo $i ?>]" value="<?php echo $row['mb_error_content'] ?>" style="width: 98%;">
			
		</td>
	</tr>

	<?php
	}
	if ($i == 0)
		echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
	?>
	</tbody>
	</table>
</div>

<div class="btn_list01 btn_list">
	<input type="submit" name="act_button" value="일괄수정" onclick="document.pressed=this.value">
</div>

</form>

<?php echo get_paging(20, $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>

function fmemberlist_submit(f)
{
	return true;
}
$(function(){
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });

	<? if($check_manner || $check_manner2) { ?>
	$('#actionStateList tbody tr').each(function() {
		_load_log(this);
	});
	<? } ?>
});



function _load_log(obj) {
	var s_date = '<?=$s_date?>';
	var e_date = '<?=$e_date?>';
	var s_board = '<?=$s_board?>';
	var mb_id = $(obj).attr('data-mbid');

	var sendData = {s_date:s_date, e_date:e_date, s_board:s_board, mb_id:mb_id};
	var url = g5_url + "/adm/action_manner_search.php";

	$.ajax({
		type: 'post'
		, url : url
		, data: sendData
		, dataType:"json"
		, success : function(data) {
			$(obj).find('.manner-state').html(data.state);
			$(obj).find('.manner-link').html(data.link);
		}
	});
}


</script>

<?php
include_once ('./admin.tail.php');
?>
