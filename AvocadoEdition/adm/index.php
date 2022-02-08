<?php
include_once('./_common.php');

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');

$new_member_rows = 5;
$new_point_rows = 5;
$new_write_rows = 5;

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";

if ($is_admin != 'super')
	$sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
	$sst = "mb_datetime";
	$sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

$colspan = 12;
?>

<section>
	<h2>시스템 페이지 링크 안내</h2>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<tbody>
			<tr>
				<th>멤버목록</th>
				<td><a href="<?=G5_URL?>/member" target="_blank"><?=G5_URL?>/member</a></td>

				<th>신청자목록</th>
				<td><a href="<?=G5_URL?>/member/ready.php" target="_blank"><?=G5_URL?>/member/ready.php</a></td>
			</tr>
			<tr>
				<th>커플목록</th>
				<td><a href="<?=G5_URL?>/couple" target="_blank"><?=G5_URL?>/couple</a></td>
				<th>상점</th>
				<td><a href="<?=G5_URL?>/shop" target="_blank"><?=G5_URL?>/shop</a></td>
			</tr>
			<tr>
				<th>마이페이지</th>
				<td><a href="<?=G5_URL?>/mypage" target="_blank"><?=G5_URL?>/mypage</a></td>
				<th>현재접속자</th>
				<td><a href="<?=G5_BBS_URL?>/current_connect.php" target="_blank"><?=G5_BBS_URL?>/current_connect.php</a></td>
			</tr>
		</tbody>
		</table>
	</div>
	<br />
	<nav class="index-gnb">
		<?php
		$gnb_str = "<ul>";
		foreach($amenu as $key=>$value) {
			$href1 = $href2 = '';
			if ($menu['menu'.$key][0][2]) {
				$href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da" data-text="'. $menu['menu'.$key][0][1].'">';
				$href2 = '</a>';
			} else {
				continue;
			}
			$current_class = "";
			if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
				$current_class = " gnb_1dli_air";
			$gnb_str .= '<li class="gnb_1dli'.$current_class.'">'.PHP_EOL;
			$gnb_str .=  $href1 . $menu['menu'.$key][0][1] . $href2;
			$gnb_str .=  print_menu1('menu'.$key, 1);
			$gnb_str .=  "</li>";
		}
		$gnb_str .= "</ul>";
		echo $gnb_str;
		?>
	</nav>
</section>


<section>
	<h2>신규가입회원 <?php echo $new_member_rows ?>건 목록</h2>
	<div class="local_desc02 local_desc">
		총회원수 <?php echo number_format($total_count) ?>명 중 차단 <?php echo number_format($intercept_count) ?>명, 탈퇴 : <?php echo number_format($leave_count) ?>명
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption>신규가입회원</caption>
		<thead>
		<tr>
			<th scope="col">회원아이디</th>
			<th scope="col">이름</th>
			<th scope="col">닉네임</th>
			<th scope="col">권한</th>
			<th scope="col">소지금</th>
			<th scope="col">수신</th>
			<th scope="col">공개</th>
			<th scope="col">인증</th>
			<th scope="col">차단</th>
			<th scope="col">그룹</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++)
		{
			// 접근가능한 그룹수
			$sql2 = " select count(*) as cnt from {$g5['group_member_table']} where mb_id = '{$row['mb_id']}' ";
			$row2 = sql_fetch($sql2);
			$group = "";
			if ($row2['cnt'])
				$group = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">'.$row2['cnt'].'</a>';

			if ($is_admin == 'group')
			{
				$s_mod = '';
				$s_del = '';
			}
			else
			{
				$s_mod = '<a href="./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$row['mb_id'].'">수정</a>';
				$s_del = '<a href="./member_delete.php?'.$qstr.'&amp;w=d&amp;mb_id='.$row['mb_id'].'&amp;url='.$_SERVER['SCRIPT_NAME'].'" onclick="return delete_confirm(this);">삭제</a>';
			}
			$s_grp = '<a href="./boardgroupmember_form.php?mb_id='.$row['mb_id'].'">그룹</a>';

			$leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date("Ymd", G5_SERVER_TIME);
			$intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date("Ymd", G5_SERVER_TIME);

			$mb_nick = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);

			$mb_id = $row['mb_id'];
			if ($row['mb_leave_date'])
				$mb_id = $mb_id;
			else if ($row['mb_intercept_date'])
				$mb_id = $mb_id;

		?>
		<tr>
			<td class="td_mbid"><?php echo $mb_id ?></td>
			<td class="td_mbname"><?php echo get_text($row['mb_name']); ?></td>
			<td class="td_mbname sv_use"><div><?php echo $mb_nick ?></div></td>
			<td class="td_num"><?php echo $row['mb_level'] ?></td>
			<td><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo number_format($row['mb_point']) ?></a></td>
			<td class="td_boolean"><?php echo $row['mb_mailling']?'예':'아니오'; ?></td>
			<td class="td_boolean"><?php echo $row['mb_open']?'예':'아니오'; ?></td>
			<td class="td_boolean"><?php echo preg_match('/[1-9]/', $row['mb_email_certify'])?'예':'아니오'; ?></td>
			<td class="td_boolean"><?php echo $row['mb_intercept_date']?'예':'아니오'; ?></td>
			<td class="td_category"><?php echo $group ?></td>
		</tr>
		<?php
			}
		if ($i == 0)
			echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<div class="btn_list03 btn_list">
		<a href="./member_list.php">회원 전체보기</a>
	</div>

</section>


<?php
$sql_common = " from {$g5['point_table']} ";
$sql_search = " where (1) ";
$sql_order = " order by po_id desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_point_rows} ";
$result = sql_query($sql);

$colspan = 7;
?>

<section>
	<h2>최근 소지금 발생내역</h2>
	<div class="local_desc02 local_desc">
		전체 <?php echo number_format($total_count) ?> 건 중 <?php echo $new_point_rows ?>건 목록
	</div>

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption>최근 소지금 발생내역</caption>
		<thead>
		<tr>
			<th scope="col">회원아이디</th>
			<th scope="col">이름</th>
			<th scope="col">닉네임</th>
			<th scope="col">일시</th>
			<th scope="col">소지금 내용</th>
			<th scope="col">소지금</th>
			<th scope="col">소지금합</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$row2['mb_id'] = '';
		for ($i=0; $row=sql_fetch_array($result); $i++)
		{
			if ($row2['mb_id'] != $row['mb_id'])
			{
				$sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
				$row2 = sql_fetch($sql2);
			}

			$mb_nick = $row2['mb_nick'];

			$link1 = $link2 = "";
			if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table'])
			{
				$link1 = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$row['po_rel_table'].'&amp;wr_id='.$row['po_rel_id'].'" target="_blank">';
				$link2 = '</a>';
			}
		?>

		<tr>
			<td class="td_mbid"><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
			<td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td>
			<td class="td_name sv_use"><div><?php echo $mb_nick ?></div></td>
			<td class="td_datetime"><?php echo $row['po_datetime'] ?></td>
			<td><?php echo $link1.$row['po_content'].$link2 ?></td>
			<td class="td_numbig"><?php echo number_format($row['po_point']) ?></td>
			<td class="td_numbig"><?php echo number_format($row['po_mb_point']) ?></td>
		</tr>

		<?php
		}

		if ($i == 0)
			echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<div class="btn_list03 btn_list">
		<a href="./point_list.php">소지금내역 전체보기</a>
	</div>
</section>

<?php
include_once ('./admin.tail.php');
?>
