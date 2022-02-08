<?php
$sub_menu = "100280";
define('_THEME_PREVIEW_', true);
include_once('./_common.php');

$theme_dir = get_theme_dir();

if(!$theme || !in_array($theme, $theme_dir))
    alert_close('테마가 존재하지 않거나 올바르지 않습니다.');

$info = get_theme_info($theme);

$arr_mode = array('index', 'list', 'view', 'shop', 'ca_list', 'item');
$mode = isset($_GET['mode']) ? substr(strip_tags($_GET['mode']), 0, 20) : '';

if(!in_array($mode, $arr_mode))
    $mode = 'index';

if((defined('G5_COMMUNITY_USE') && G5_COMMUNITY_USE === false) || $mode == 'shop' || $mode == 'ca_list' || $mode == 'item')
    define('_SHOP_', true);

$qstr_index   = '&amp;mode=index';
$qstr_list    = '&amp;mode=list';
$qstr_view    = '&amp;mode=view';

$conf = sql_fetch(" select cf_theme from {$g5['config_table']} ");
$name = get_text($info['theme_name']);
if($conf['cf_theme'] != $theme) {
    if($tconfig['set_default_skin'])
        $set_default_skin = 'true';
    else
        $set_default_skin = 'false';

    $btn_active = '<li><button type="button" class="theme_sl theme_active" data-theme="'.$theme.'" '.'data-name="'.$name.'" data-set_default_skin="'.$set_default_skin.'">테마적용</button></li>';
} else {
    $btn_active = '';
}

$g5['title'] = get_text($info['theme_name']).' 테마 미리보기';
require_once(G5_PATH.'/head.sub.php');
?>

<link rel="stylesheet" href="<?php echo G5_ADMIN_URL; ?>/css/theme.css">
<script src="<?php echo G5_ADMIN_URL; ?>/theme.js"></script>

<section id="preview_item">
    <ul>
        <li><a href="./theme_preview.php?theme=<?php echo $theme.$qstr_index; ?>">인덱스 화면</a></li>
        <li><a href="./theme_preview.php?theme=<?php echo $theme.$qstr_list; ?>">멤버란</a></li>
        <li><a href="./theme_preview.php?theme=<?php echo $theme.$qstr_view; ?>">프로필</a></li>
        <?php echo $btn_active; ?>
    </ul>
</section>

<section id="preview_content">
    <?php
    switch($mode) {
        case 'list':
            include(G5_PATH.'/member/index.php');
            break;
        case 'view':
            include(G5_PATH.'/member/viewer.php');
            break;
        default:
            include(G5_PATH.'/main.php');
            break;
    }
    ?>
</section>

<?php
require_once(G5_PATH.'/tail.sub.php');