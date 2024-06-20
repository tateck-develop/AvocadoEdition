<?php
include_once('./_common.php');
$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
?>
<?php
include_once('./_common.php');

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
?>

<section>
	<h2>시스템 페이지</h2>
	<div class="tbl_frm01 tbl_wrap">
		<table>
		<tbody>
			<tr>
				<th style="width:120px;">멤버목록</th>
				<td><a href="<?=G5_URL?>/member" target="_blank"><?=G5_URL?>/member</a></td>
				<th style="width:120px;">신청자목록</th>
				<td><a href="<?=G5_URL?>/member/ready.php" target="_blank"><?=G5_URL?>/member/ready.php</a></td>
				<th style="width:120px;">커플목록</th>
				<td><a href="<?=G5_URL?>/couple" target="_blank"><?=G5_URL?>/couple</a></td>
			</tr>
			<tr>
				<th>상점</th>
				<td><a href="<?=G5_URL?>/shop" target="_blank"><?=G5_URL?>/shop</a></td>
				<th>마이페이지</th>
				<td><a href="<?=G5_URL?>/mypage" target="_blank"><?=G5_URL?>/mypage</a></td>
				<th>현재접속자</th>
				<td><a href="<?=G5_BBS_URL?>/current_connect.php" target="_blank"><?=G5_BBS_URL?>/current_connect.php</a></td>
			</tr>
		</tbody>
		</table>
	</div>
</section>
<section>
	<h2>관리자 메뉴</h2>
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
			$gnb_str .= '<li class="gnb_1dli'.$current_class.'"><div>'.PHP_EOL;
			$gnb_str .=  $href1 . $menu['menu'.$key][0][1] . $href2;
			$gnb_str .=  print_menu1('menu'.$key, 1);
			$gnb_str .=  "</div></li>";
		}
		$gnb_str .= "</ul>";
		echo $gnb_str;
		?>
	</nav>
</section>

<?php
include_once ('./admin.tail.php');
?>
