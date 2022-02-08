<?php
if (!defined('_GNUBOARD_')) exit;
$begin_time = get_microtime();
include_once(G5_PATH.'/head.sub.php');

function print_menu1($key, $no)
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no)
{
    global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

    $str .= "<ul class=\"gnb_2dul\">";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

		$check_gnb_grp_style = "";
		if($menu[$key][$i][0] && isset($sub_menu) && $menu[$key][$i][0] == $sub_menu) {
			$check_gnb_grp_style = "check";
		}

        $str .= '<li class="gnb_2dli '.$check_gnb_grp_style.'"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'" data-text="'.$menu[$key][$i][1].'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}
?>

<script>
var tempX = 0;
var tempY = 0;

function imageview(id, w, h)
{

    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}
</script>

<div id="wrap">

<header id="header">
	<div id="admin_prof">
		<h1>
			<a href="<?php echo G5_ADMIN_URL ?>"><img src="<?=G5_ADMIN_URL?>/img/logo.png" alt="Avocado Edition" /></a>
			<i><?=G5_GNUBOARD_VER?></i>
		</h1>
		<p>
			<a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>" class="name">
				<?=$member['mb_name']?>
			</a>
			<a href="<?php echo G5_BBS_URL ?>/logout.php" class="logout">로그아웃</a>
		</p>
	</div>

	 <nav id="gnb">
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

</header>


<section id="wrapper">

	<aside id="page_top">
		<h2><?php echo $g5['title'] ?></h2>

		<a href="<?=G5_URL?>" class="ico-home" target="_blank">
			커뮤니티
		</a>
		<a href="http://bytheallspark.cafe24.com/" class="ico-dev" target="_blank">
			아보카도 솔루션
		</a>
	</aside>

	<div id="container">
