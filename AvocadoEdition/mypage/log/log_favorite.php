<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once('./_head.php');

$sql_common = " from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' ";
$sql_order = " order by ms_id desc ";

$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();

$sql = " select *
			$sql_common
			$sql_order
			limit $from_record, $rows ";
$result = sql_query($sql);

$list = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {

	$list[$i] = $row;

	// 순차적인 번호 (순번)
	$num = $total_count - ($page - 1) * $rows - $i;

	// 게시판 제목
	$sql2 = " select bo_subject from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ";
	$row2 = sql_fetch($sql2);
	if (!$row2['bo_subject']) $row2['bo_subject'] = '[게시판 없음]';

	// 게시물 제목
	$tmp_write_table = $g5['write_prefix'] . $row['bo_table'];
	$sql3 = " select wr_subject, wr_type, wr_name, ch_id, wr_num, wr_url from $tmp_write_table where wr_id = '{$row['wr_id']}' ";
	$row3 = sql_fetch($sql3, FALSE);
	$subject = get_text(cut_str($row3['wr_subject'], 100));
	if (!$row3['wr_subject'])
		$row3['wr_subject'] = '[글 없음]';

	$list[$i]['wr_num'] = $row3['wr_num'];
	$list[$i]['wr_type'] = $row3['wr_type'];
	$list[$i]['wr_url'] = $row3['wr_url'];
	$list[$i]['ca_name'] = $row3['ca_name'];
	$list[$i]['opener_href'] = './board.php?bo_table='.$row['bo_table'];
	$list[$i]['opener_href_wr_id'] = './board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id'];
	$list[$i]['bo_subject'] = $row2['bo_subject'];
	$list[$i]['subject'] = $subject;
	$list[$i]['del_href'] = './scrap_delete.php?ms_id='.$row['ms_id'].'&amp;page='.$page;

	$list[$i]['ch_id'] = $row3['ch_id'];
	$list[$i]['wr_name'] = $row3['wr_name'];
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;mb_id=$mb_id&amp;type=$type&amp;page=");

?>

<div class="top-frame-box none-trans">
	<i class="top-left"></i><i class="top-right"></i><i class="left"></i><i class="right"></i>
	<div class="inner">

		<nav id="tab_list">
			<ul>
				<li>
					<a href="./index.php">
						나의로그
					</a>
				</li>
				<li class="on">
					<a href="./log_favorite.php" class="point">
						관심로그
					</a>
				</li>
			</ul>
		</nav>

		<i class="style-line horizon"></i>

		<div class="mypage-favorite-list">
			<? for ($i=0; $i<count($list); $i++) {
				$bo_subject = cut_str($list[$i]['bo_subject'], 20);
				$ca_name = $list[$i]['ca_name'];
				if($list[$i]['wr_type'] == 'UPLOAD') { 
					// Upload 형태로 로그를 등록 하였을 때
					$thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], 150, 150);
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

				if($list[$i]['subject'] == '--|UPLOADING|--') { 
					$log_name = '???';
				} else {
					if($list[$i]['wr_noname']) {
						$log_name = '익명의 누군가';
					} else {
						$log_name = $list[$i]['subject']." / ".$list[$i]['wr_name'];
					}
				}
			?>

			<dl>
				<dt>
					<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>&amp;log=<?=$list[$i]['log_num']?>">
						<img src="<?=$image_url?>" onerror="$(this).remove();"/>
					</a>
				</dt>
				<dd>
					<?=$log_name?>
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

	</div>
</div>



<?php
include_once('./_tail.php');
?>
