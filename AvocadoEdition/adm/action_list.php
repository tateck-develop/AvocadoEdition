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

$qstr .= "&s_board=".$s_board."&s_date=".$s_date."&e_date=".$e_date;

if(!$s_date) $s_date = date('Y-m-d', strtotime("last Monday"));
if(!$e_date) $e_date = date('Y-m-d', strtotime("next Sunday"));

// 일단 짜는 것 부터 시작하자.
// 회원 정렬 부터 시작한다./


$sql_common = " from {$g5['member_table']} mb LEFT JOIN (select *, count(if(wr_id = wr_parent, wr_id, null)) as wr_log, count(if(wr_id != wr_parent, wr_id, null)) as wr_cm from {$g5['board_new_table']} where bo_table = '{$s_board}' and bn_datetime >= '$s_date' and bn_datetime <= '$e_date' group by mb_id ) bo ON mb.mb_id = bo.mb_id ";
$sql_search = " where mb.mb_level > 1 and mb.mb_leave_date = '' and mb.mb_id != '{$config['cf_admin']}' and mb.ch_id != '' and mb.mb_level > 1 ";

if (!$sst) {
    $sst = "mb.mb_datetime";
    $sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search}";


$row = sql_fetch($sql);
$total_count = $row['cnt'];

if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$page_rows = 20;

$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$g5['title'] = '활동량 관리';
include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');


$sql = " select mb.mb_id, mb.mb_name, mb.ch_id, mb.mb_today_login, mb.mb_error_content, bo.wr_log, bo.wr_cm, mb.mb_error_cnt {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, $page_rows";


$result = sql_query($sql);
$colspan = 10;

?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    총 회원 수 <?php echo number_format($total_count) ?>명
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">

<div class="sch_last" style="float: left; margin-right: 10px;">
	<strong>게시판 지정&nbsp;</strong>
	<select name="s_board">
		<?=$board_select_option?>
	</select>

	&nbsp;&nbsp;&nbsp;

    <strong>기간별검색&nbsp;</strong>
	<input type="text" name="s_date" value="<?=$s_date?>" />
	~
	<input type="text" name="e_date" value="<?=$e_date?>" />
</div>
<input type="submit" class="btn_submit" value="검색">

</form>

<br />

<form name="fmemberlist" id="fmemberlist" action="./action_list_update.php" onsubmit="return fmemberlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<div class="tbl_head01 tbl_wrap">
    <table class="tbl_hover">
    <caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col style="width: 100px;" />
		<col style="width: 100px;" />
		<col style="width: 120px;" />
		<col style="width: 60px;" />
		<col style="width: 60px;" />
		<col style="width: 150px;" />
		<col style="width: 80px;" />
		<col />
		<col style="width: 100px;" />
	</colgroup>
    <thead>
		<tr>
			<th scope="col" rowspan="2" id="mb_list_id"><?php echo subject_sort_link('mb.mb_id', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>아이디</a></th>
			<th scope="col" rowspan="2" id="mb_list_name"><?php echo subject_sort_link('mb.mb_nick', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>닉네임</a></th>
			<th scope="col" rowspan="2">대표캐릭터</th>
			<th><?php echo subject_sort_link('wr_log', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>로그</a></th>
			<th><?php echo subject_sort_link('wr_cm', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>덧글</a></th>
			<th scope="col" rowspan="2"><?php echo subject_sort_link('mb.mb_today_login', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>최종 접속</a></th>
			<th scope="col" rowspan="2"><?php echo subject_sort_link('mb.mb_error_cnt', 's_board='.$s_board.'&s_date='.$s_date.'&e_date='.$e_date) ?>누적경고</a></th>
			<th rowspan="2">경고내용</th>
			<th scope="col" rowspan="2">관리</th>
		</tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
	<input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
    <tr class="<?php echo $bg; ?>">
       <td><?=$row['mb_id']?></td>
	   <td><?=$row['mb_name']?></td>
	   <td><a href="./character_form.php?w=u&amp;ch_id=<?=$row['ch_id']?>" target="_blank"><?=get_character_name($row['ch_id'])?></a></td>
	   <td style="text-align: center;"><?=number_format($row['wr_log'])?></td>
	   <td style="text-align: center;"><?=number_format($row['wr_cm'])?></td>
	   <td style="text-align: center; color: #999;"><?=$row['mb_today_login']?></td>
	   <td style="text-align: center;">
			<input type="text" name="mb_error_cnt[<?php echo $i ?>]" value="<?php echo $row['mb_error_cnt'] ?>" size="3"> 회
	   </td>
	   <td>
			<input type="text" name="mb_error_content[<?php echo $i ?>]" value="<?php echo $row['mb_error_content'] ?>" style="width: 98%;">
			
	   </td>
	   <td style="text-align: center;">
			
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

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>

function fmemberlist_submit(f)
{
    return true;
}
$(function(){
	$('iframe').load(function(){
		var iframeContentWindow = this.contentWindow;  
		var height = iframeContentWindow.document.body.scrollHeight;  
		this.style.height = height + 'px'; 
	});

    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>

<?php
include_once ('./admin.tail.php');
?>
