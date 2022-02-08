<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once('./_head.php');

// 내가 쓴 자비란 로그 확인
$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b
	where	a.bo_table = b.bo_table
		and b.bo_type = 'mmb'
		and a.wr_id = a.wr_parent
		and a.mb_id = '{$member['mb_id']}'
";
$sql_order = " order by a.bn_id desc ";

// 전체 갯수 가져오기
$sql = " select count(*) as cnt {$sql_common} ";
$total = sql_fetch($sql);
$total = $total['cnt'];

$rows = 10;
$total_page  = ceil($total / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select a.*, b.bo_subject {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$list = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$tmp_write_table = $g5['write_prefix'].$row['bo_table'];
	if ($row['wr_id'] == $row['wr_parent']) {
		// 원글
		$comment = "";
		$comment_link = "";
		$row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
		$list[$i] = $row2;

		$name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
		// 당일인 경우 시간으로 표시함
		$datetime = substr($row2['wr_datetime'],0,10);
		$datetime2 = $row2['wr_datetime'];
		if ($datetime == G5_TIME_YMD) {
			$datetime2 = substr($datetime2,11,5);
		} else {
			$datetime2 = substr($datetime2,5,5);
		}
	} else {

		// 코멘트
		$comment = '[코] ';
		$comment_link = '#c_'.$row['wr_id'];
		$row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
		$row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
		$list[$i] = $row2;
		$list[$i]['wr_id'] = $row['wr_id'];
		$list[$i]['mb_id'] = $row3['mb_id'];
		$list[$i]['wr_name'] = $row3['wr_name'];
		$list[$i]['wr_email'] = $row3['wr_email'];
		$list[$i]['wr_homepage'] = $row3['wr_homepage'];
		// 당일인 경우 시간으로 표시함
		$datetime = substr($row3['wr_datetime'],0,10);
		$datetime2 = $row3['wr_datetime'];
		if ($datetime == G5_TIME_YMD) {
			$datetime2 = substr($datetime2,11,5);
		} else {
			$datetime2 = substr($datetime2,5,5);
		}
	}
	$list[$i]['gr_id'] = $row['gr_id'];
	$list[$i]['bo_table'] = $row['bo_table'];
	$list[$i]['name'] = $name;
	$list[$i]['comment'] = $comment;
	$list[$i]['href'] = './board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row2['wr_id'].$comment_link;
	$list[$i]['datetime'] = $datetime;
	$list[$i]['datetime2'] = $datetime2;

	$list[$i]['gr_subject'] = $row['gr_subject'];
	$list[$i]['bo_subject'] = $row['bo_subject'];
	$list[$i]['wr_subject'] = $row2['wr_subject'];
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;mb_id=$mb_id&amp;type=$type&amp;page=");

?>



<nav id="tab_list">
	<ul>
		<li>
			<a href="./index.php" class="point">
				나의로그
			</a>
		</li>
		<li class="on">
			<a href="./log_favorite.php">
				관심로그
			</a>
		</li>
	</ul>
</nav>

<i class="style-line horizon"></i>

<div class="mypage-log-list">

<? for ($i=0; $i<count($list); $i++) {
	$bo_subject = cut_str($list[$i]['bo_subject'], 20);
	$ca_name = $list[$i]['ca_name'];
	if($list[$i]['wr_type'] == 'UPLOAD') { 
		// Upload 형태로 로그를 등록 하였을 때
		$thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], 140, 90);
		$image_url = $thumb['src'];
		$image_width = 140;
		$image_height = 90;
	} else if($list[$i]['wr_type'] == 'URL') {
		// URL 형태로 로그를 등록 하였을 때
		$image_url = $list[$i]['wr_url'];
		$image_width = $list[$i]['wr_width'];
		$image_height = $list[$i]['wr_height'];
	}
	$list[$i]['log_num'] = $list[$i]['wr_num'] * -1;
?>
		<dl>
			<dt>
				<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>&amp;log=<?=$list[$i]['log_num']?>">
					<img src="<?=$image_url?>" />
				</a>
			</dt>
			<dd>
<?
// 코멘트 리스트
$sql = " select * from {$g5['write_prefix']}{$list[$i]['bo_table']} where wr_parent = '{$list[$i]['wr_id']}' and wr_subject != '--|UPLOADING|--' order by wr_datetime desc, wr_comment_reply limit 0, 3";
$result = sql_query($sql);
for ($j=0; $row=sql_fetch_array($result); $j++)
{
	$c_list[$j] = $row;
	$tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
	$c_list[$j]['content'] = $row['wr_content'];
	if($j == 0) { echo "<ul class='comemnt-list'>"; }
?>
					<li>
						<p>
						<? if($c_list[$j]['wr_noname']) { ?>
							[ 익명의 누군가 ]
						<? } else { ?>
							[ <?=$c_list[$j]['wr_subject']?>/<?=$c_list[$j]['wr_name']?> ]
						<? } ?>
							<?=htmlspecialchars($c_list[$j]['content'])?>
						</p>
						<p class="con txt-right">
							<span class="date"><?=date('y.m.d H:i', strtotime($c_list[$j]['wr_datetime']))?></span>
						</p>
					</li>
<?
} if($j > 0) { 
	echo "</ul>";
} 
?>
			</dd>
		</dl>
<? } if($i==0) { ?>
		<div class="no-data">
				등록한 로그 내역이 없습니다.
		</div>
<? } ?>
</div>

<i class="style-line horizon"></i>

<?php echo $write_pages ?>





<?php
include_once('./_tail.php');
?>
