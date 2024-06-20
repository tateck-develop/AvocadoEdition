<?php
if (!defined('_GNUBOARD_')) exit;
$begin_time = get_microtime();
include_once(G5_PATH.'/head.sub.php');

function print_menu1($key, $no){
	global $menu;
	$str = print_menu2($key, $no);
	return $str;
}

function print_menu2($key, $no){
	global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

	$str .= "<div class=\"gnb_2dul\"><ul>";
	for($i=1; $i<count($menu[$key]); $i++) {
		if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
			continue;

		if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
		else $gnb_grp_div = '';

		if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'on';
		else $gnb_grp_style = '';

		$check_gnb_grp_style = "";
		if($menu[$key][$i][0] && isset($sub_menu) && $menu[$key][$i][0] == $sub_menu) {
			$check_gnb_grp_style = "check";
		}

		$str .= '<li class="gnb_2dli '.$check_gnb_grp_style.'"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'" data-text="'.$menu[$key][$i][1].'">'.$menu[$key][$i][1].'</a></li>';

		$auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
	}
	$str .= "</ul></div>";

	return $str;
}
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<div class="adminWrap">

<header class="adminHeader">
	<div class="inner">
		<h1>
			<a href="<?php echo G5_ADMIN_URL ?>"><strong><?=$config['cf_title']?> Management</strong></a>
			<i><?=G5_GNUBOARD_VER?></i>
		</h1>
		<aside>
			<a href="<?php echo G5_BBS_URL ?>/logout.php" ><span class="material-symbols-outlined">logout</span></a>
			<a href="<?=G5_URL?>" target="_blank"><span class="material-symbols-outlined">home</span></a>
			<a href="https://avocado-edition-rout.postype.com/" target="_blank"><span class="material-symbols-outlined">developer_guide</span></a>
		</aside>
	</div>
</header>
<nav class="adminGnbArea auto-horiz">
	<div id="gnb" class="inner">
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
				$current_class = " on";
			$gnb_str .= '<li class="gnb_1dli'.$current_class.'">'.PHP_EOL;
			$gnb_str .=  $href1 . $menu['menu'.$key][0][1] . $href2;
			$gnb_str .=  print_menu1('menu'.$key, 1);
			$gnb_str .=  "</li>";
		}
		$gnb_str .= "</ul>";
		echo $gnb_str;
		?>
	</div>
</nav>
<section class="adminBody">
	<? if($g5['title'] != "관리자메인") { ?>
	<div class="pageTitle">
		<h2><?php echo $g5['title'] ?></h2>
	</div>
	<? } ?>
	<div class="container">
