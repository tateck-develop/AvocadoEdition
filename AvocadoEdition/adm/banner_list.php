<?php
$sub_menu = '100320';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '메인슬라이드 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['banner_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common
		order by bn_order, bn_id desc
		limit $from_record, $rows  ";
$result = sql_query($sql);

?>

<div class="local_ov01 local_ov">
	등록된 이미지 <?php echo $total_count; ?>개
</div>

<div class="btn_add01 btn_add">
	<a href="./banner_form.php">메인슬라이드 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 50px;" />
			<col style="width: 170px;" />
			<col />
			<col style="width: 130px;" />
			<col style="width: 130px;" />
			<col style="width: 80px;" />
			<col style="width: 80px;" />
		</colgroup>
		<thead>
			<tr>
				<th scope="col" class="bo-right">ID</th>
				<th scope="col">이미지</th>
				<th scope="col">대체텍스트</th>
				<th scope="col">시작일시</th>
				<th scope="col">종료일시</th>
				<th scope="col">출력순서</th>
				<th scope="col">관리</th>
			</tr>
		</thead>
		<tbody>
			<?php
			
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				// 새창 띄우기인지
				$bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';

				$bn_img_obj = "";
				$link_tag = false;
				if($row['bn_img']) {
					if ($row['bn_url'] && $row['bn_url'] != "http://") { $link_tag = true; }

					if($link_tag) $bn_img_obj .= "<a hreef='".$row['bn_url']."' ".$bn_new_win.">";
					$bn_img_obj .= "<img src='".$row['bn_img']."' alt='".$row['bn_alt']."' class='banner-thumb'/>";
					if($link_tag) $bn_img_obj .= "</a>";
				}

				$bn_begin_time = substr($row['bn_begin_time'], 2, 14);
				$bn_end_time   = substr($row['bn_end_time'], 2, 14);

				$bg = 'bg'.($i%2);
			?>

			<tr class="<?php echo $bg; ?>">
				<td><?php echo $row['bn_id']; ?></td>
				<td><?php echo $bn_img_obj; ?></td>
				<td><?php echo $row['bn_alt']; ?></td>
				<td><?php echo $bn_begin_time; ?></td>
				<td><?php echo $bn_end_time; ?></td>
				<td><?php echo $row['bn_order']; ?></td>
				<td>
					<a href="./banner_form.php?w=u&amp;bn_id=<?php echo $row['bn_id']; ?>">수정</a></li>
					<a href="./banner_form_update.php?w=d&amp;bn_id=<?php echo $row['bn_id']; ?>" onclick="return delete_confirm();">삭제</a>
				</td>
			</tr>
			

			<?php
			}
			if ($i == 0) {
			echo '<tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
			}
			?>
		</tbody>
	</table>

</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;position=$position&amp;page="); ?>

<script>
$(function() {
	$(".sbn_img_view").on("click", function() {
		$(this).closest(".td_img_view").find(".sbn_image").slideToggle();
	});
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
