<? 
@include_once('./_common.php');

// CSS 설정 가져오기
$css_sql = sql_query("select * from {$g5['css_table']}");
$css = array();
for($i=0; $cs = sql_fetch_array($css_sql); $i++) {
	$css[$cs['cs_name']][0] = $cs['cs_value'];
	$css[$cs['cs_name']][1] = $cs['cs_etc_1'];
	$css[$cs['cs_name']][2] = $cs['cs_etc_2'];
	$css[$cs['cs_name']][3] = $cs['cs_etc_3'];
	$css[$cs['cs_name']][4] = $cs['cs_etc_4'];
	$css[$cs['cs_name']][5] = $cs['cs_etc_5'];
	$css[$cs['cs_name']][6] = $cs['cs_etc_6'];
	$css[$cs['cs_name']][7] = $cs['cs_etc_7'];
	$css[$cs['cs_name']][8] = $cs['cs_etc_8'];
	$css[$cs['cs_name']][9] = $cs['cs_etc_9'];
	$css[$cs['cs_name']][10] = $cs['cs_etc_10'];
}

$tab_width = 1024;

?>
@charset "utf-8";
/***************************************************************
	Design Manager Setting Style: 자동생성 CSS
---------------------------------------------------------------
	- 최종 수정일 : <?=date('Y-m-d H:i:s')."\n"?>
***************************************************************/

<?/**************************************************************
	폰트 기본 색상 지정
***************************************************************/?>

<? if($css['color_default'][0]) { ?>
body,
.txt-default	{ color: <?=$css['color_default'][0]?>; }
<? } ?>
<? if($css['color_point'][0]) { ?>
a,
.txt-point	{ color: <?=$css['color_point'][0]?>; }
<? } ?>


<?/**************************************************************
	기본 사이트 배경 설정
	-
	모바일 기준 : width 1000px
***************************************************************/?>
@media all and (min-width: <?=($tab_width + 1)?>px) { 
	html.single:before	{
	<? if($css['background'][0]) { ?>
	background-image: url('<?=$css['background'][0]?>');
	<? } if($css['background'][1]) { ?>
	background-color: <?=$css['background'][1]?>;
	<? } if($css['background'][2]) { ?>
	background-repeat: <?=$css['background'][2]?>;
	<? } if($css['background'][3]) { ?>
	background-position: <?=$css['background'][3]?>;
	<? } if($css['background'][4]) { ?>
	background-size: <?=$css['background'][4]?>;
	<? } if($css['background'][5]) { ?>
	background-attachment: <?=$css['background'][5]?>;
	<? } ?>
	}
}

@media all and (max-width: <?=$tab_width?>px) {
	html.single:before	{
	<? if($css['m_background'][0]) { ?>
	background-image: url('<?=$css['m_background'][0]?>');
	<? } else { ?>
	background-image: none;
	<? } if($css['m_background'][1]) { ?>
	background-color: <?=$css['m_background'][1]?>;
	<? } if($css['m_background'][2]) { ?>
	background-repeat: <?=$css['m_background'][2]?>;
	<? } if($css['m_background'][3]) { ?>
	background-position: <?=$css['m_background'][3]?>;
	<? } if($css['m_background'][4]) { ?>
	background-size: <?=$css['m_background'][4]?>;
	<? } if($css['m_background'][5]) { ?>
	background-attachment: <?=$css['m_background'][5]?>;
	<? } ?>
	}
}


<?/**************************************************************
	HEADER / GNB STYLE
***************************************************************/?>
@media all and (min-width: <?=($tab_width + 1)?>px) { 
	#header	{
	<? if($css['header_background'][0]) { ?>
	background-image: url('<?=$css['header_background'][0]?>');
	<? } if($css['header_background'][1]) { ?>
	background-color: <?=$css['header_background'][1]?>;
	<? } if($css['header_background'][2]) { ?>
	background-repeat: <?=$css['header_background'][2]?>;
	<? } if($css['header_background'][3]) { ?>
	background-position: <?=$css['header_background'][3]?>;
	<? } if($css['header_background'][4]) { ?>
	background-size: <?=$css['header_background'][4]?>;
	<? } if($css['header_background'][5]) { ?>
	background-attachment: <?=$css['header_background'][5]?>;
	<? } ?>
	}

	#gnb	{
	<? if($css['menu_background'][0]) { ?>
	background-image: url('<?=$css['menu_background'][0]?>');
	<? } if($css['menu_background'][1]) { ?>
	background-color: <?=$css['menu_background'][1]?>;
	<? } if($css['menu_background'][2]) { ?>
	background-repeat: <?=$css['menu_background'][2]?>;
	<? } if($css['menu_background'][3]) { ?>
	background-position: <?=$css['menu_background'][3]?>;
	<? } if($css['menu_background'][4]) { ?>
	background-size: <?=$css['menu_background'][4]?>;
	<? } if($css['menu_background'][5]) { ?>
	background-attachment: <?=$css['menu_background'][5]?>;
	<? } ?>
	}

	#gnb_control_box	{ display: none; }
}

@media all and (max-width: <?=$tab_width?>px) {

	#header	{
	<? if($css['m_header_background'][0]) { ?>
	background-image: url('<?=$css['m_header_background'][0]?>');
	<? } if($css['m_header_background'][1]) { ?>
	background-color: <?=$css['m_header_background'][1]?>;
	<? } if($css['m_header_background'][2]) { ?>
	background-repeat: <?=$css['m_header_background'][2]?>;
	<? } if($css['m_header_background'][3]) { ?>
	background-position: <?=$css['m_header_background'][3]?>;
	<? } if($css['m_header_background'][4]) { ?>
	background-size: <?=$css['m_header_background'][4]?>;
	<? } if($css['m_header_background'][5]) { ?>
	background-attachment: <?=$css['m_header_background'][5]?>;
	<? } ?>
	}

	#gnb	{
	<? if($css['m_menu_background'][0]) { ?>
	background-image: url('<?=$css['m_menu_background'][0]?>');
	<? } if($css['m_menu_background'][1]) { ?>
	background-color: <?=$css['m_menu_background'][1]?>;
	<? } if($css['m_menu_background'][2]) { ?>
	background-repeat: <?=$css['m_menu_background'][2]?>;
	<? } if($css['m_menu_background'][3]) { ?>
	background-position: <?=$css['m_menu_background'][3]?>;
	<? } if($css['m_menu_background'][4]) { ?>
	background-size: <?=$css['m_menu_background'][4]?>;
	<? } if($css['m_menu_background'][5]) { ?>
	background-attachment: <?=$css['m_menu_background'][5]?>;
	<? } ?>
	}

	#gnb_control_box	{
	display: block;
	}
}


<? if($css['use_header'][0] == 'N') { 
/****************************************************
	헤더 사용 여부 설정
*****************************************************/ ?>
#header,
#footer	{ display: none !important; }
#body	{ margin: 0 !important; }
<? } ?>

<? if($css['menu_pos'][0] == 'left') { 
/****************************************************
	메뉴 좌측 레이아웃 설정
*****************************************************/ ?>
#body	{ margin-left: <?=$css['menu_width'][0]?>px; }
#header	{
	position: fixed;
	top: 0;
	left: 0;
	bottom: 0;
	overflow-y: auto;
	width: <?=$css['menu_width'][0]?>px;
	
}
#logo	{
	padding:20px 0;
	text-align: center;
}


<? } else if($css['menu_pos'][0] == 'top') {
/****************************************************
	메뉴 상단 레이아웃 설정
*****************************************************/ ?>

#header	{
	position: relative;
	margin: 0;
	padding: 0;
	clear: both;
	height: <?=$css['menu_height'][0]?>px;
}
#header .fix-layout	{ height: 100%; }
#logo	{
	display: block;
	position: absolute;
	top: 50%;
	left: 0%;
	transform: translateY(-50%);
}
<? } ?>

/*#gnb	{ float: right; }*/
#gnb,
#gnb *	{
	color: <?=$css['menu_text'][0]?>;
	font-size: <?=$css['menu_text'][1]?>px;
}
#gnb a:hover {
	color: <?=$css['menu_text'][2]?>;
	font-size: <?=$css['menu_text'][3]?>px;
}



<?/**************************************************************
	스크롤 / 마우스 드래그 블록 색상 지정
***************************************************************/?>

<?/*** Scroll Style ***************/?>
<? if($css['color_bak'][0]) { ?>
*::-webkit-scrollbar-track	{ background-color: <?=$css['color_bak'][0]?>; }
<? } if($css['color_point'][0]) { ?>
*::-webkit-scrollbar-thumb	{ background: <?=$css['color_point'][0]?>; }
<? } ?>

<?/*** Block Style ***************/?>
<? if($css['color_point'][0]) { ?>
* { outline-color: <?=$css['color_point'][0]?>; }
::selection	{ background:<?=$css['color_point'][0]?>; }
::-moz-selection	{ background:<?=$css['color_point'][0]?>; }
::-webkit-selection	{ background:<?=$css['color_point'][0]?>; }
<? } ?>

<? if($css['color_bak'][0]) { ?>
::selection	{ color:<?=$css['color_bak'][0]?>; }
::-moz-selection	{ color:<?=$css['color_bak'][0]?>; }
::-webkit-selection	{ color:<?=$css['color_bak'][0]?>; }
<? } ?>



<?/**************************************************************
	버튼 색상 지정
***************************************************************/?>

.ui-btn	{
	color:	<?=$css['btn_default'][0]?>;
	background:	<?=$css['btn_default'][1]?>;
	border-color:	<?=$css['btn_default'][2]?>;
}
.ui-btn:hover	{
	color:	<?=$css['btn_default'][3]?>;
	background:	<?=$css['btn_default'][4]?>;
	border-color:	<?=$css['btn_default'][5]?>;
}

.ui-btn.point	{
	color:	<?=$css['btn_point'][0]?>;
	background:	<?=$css['btn_point'][1]?>;
	border-color:	<?=$css['btn_point'][2]?>;
}
.ui-btn.point:hover	{
	color:	<?=$css['btn_point'][3]?>;
	background:	<?=$css['btn_point'][4]?>;
	border-color:	<?=$css['btn_point'][5]?>;
}

.ui-btn.etc	{
	color:	<?=$css['btn_etc'][0]?>;
	background:	<?=$css['btn_etc'][1]?>;
	border-color:	<?=$css['btn_etc'][2]?>;
}
.ui-btn.etc:hover	{
	color:	<?=$css['btn_etc'][3]?>;
	background:	<?=$css['btn_etc'][4]?>;
	border-color:	<?=$css['btn_etc'][5]?>;
}
.swiper-pagination-bullet-active {background:	<?=$css['btn_point'][4]?>;}

<?/**************************************************************
	페이징 스타일 설정
***************************************************************/?>

.pg_wrap .pg_page	{
	color:	<?=$css['btn_default'][0]?>;
	background:	<?=$css['btn_default'][1]?>;
	border-color:	<?=$css['btn_default'][2]?>;
}
.pg_wrap .pg_page:hover	{
	color:	<?=$css['btn_default'][3]?>;
	background:	<?=$css['btn_default'][4]?>;
	border-color:	<?=$css['btn_default'][5]?>;
}

.pg_wrap .pg_current,
.pg_wrap .pg_current:hover	{
	color:	<?=$css['btn_point'][0]?>;
	background:	<?=$css['btn_point'][1]?>;
	border-color:	<?=$css['btn_point'][2]?>;
}




<?/**************************************************************
	이퀄라이저 설정
***************************************************************/?>

.bar-equalizer i	{
<? if($css['equalizer'][0]) { ?>
	background: <?=$css['equalizer'][0]?>;
<? } if($css['equalizer'][1]) { ?>
	-webkit-box-shadow: 0px 0px 3px 0px <?=$css['equalizer'][1]?>;
	-moz-box-shadow: 0px 0px 3px 0px <?=$css['equalizer'][1]?>;
	box-shadow: 0px 0px 3px 0px <?=$css['equalizer'][1]?>;
<? } ?>
}


<?/**************************************************************
	스테이터스바 설정
***************************************************************/?>

.status-bar dd p	{
	background: <?=$css['color_default'][0]?>;
}
.status-bar dd p span	{
	background: <?=$css['color_point'][0]?>;
	opacity: .5;
}
.status-bar dd p sup	{
	background: <?=$css['color_point'][0]?>;
}
.status-bar dd p i	{
	color: <?=$css['color_bak'][0]?>;
}


<?/**************************************************************
	구분선 설정
***************************************************************/?>

hr.line	{
	background: <?=$css['color_point'][0]?>;
}



<?/**************************************************************
	인풋 타입
***************************************************************/?>

.form-input,
input[type="file"],
input[type="text"],
input[type="number"],
input[type="password"],
textarea,
select	{
	color:	<?=$css['input_bak'][1]?>;
	background:	<?=$css['input_bak'][0]?>;
	border-color:	<?=$css['input_bak'][2]?>;
	
	<? if($css['input_bak'][3]) { ?>border-top-left-radius:<?=$css['input_bak'][3]?>px;<? } ?>
	<? if($css['input_bak'][4]) { ?>border-top-right-radius:<?=$css['input_bak'][4]?>px;<? } ?>
	<? if($css['input_bak'][5]) { ?>border-bottom-right-radius:<?=$css['input_bak'][5]?>px;<? } ?>
	<? if($css['input_bak'][6]) { ?>border-bottom-left-radius:<?=$css['input_bak'][6]?>px;<? } ?>
}

::-webkit-input-placeholder {
	color: <?=$css['input_bak'][1]?>;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
	color: <?=$css['input_bak'][1]?>;
	opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
	color: <?=$css['input_bak'][1]?>;
	opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
	color: <?=$css['input_bak'][1]?>;
}


*::-webkit-input-placeholder	{ color:#000; } 
textarea:-moz-placeholder, input:-moz-placeholder	{ color:#000; }
input:-webkit-autofill,
textarea:-webkit-autofill,
select:-webkit-autofill {
  background-color: <?=$css['input_bak'][0]?> !important;
  color: <?=$css['input_bak'][1]?>;
}



<?/**************************************************************
	비쥬얼 슬라이드 설정
***************************************************************/?>

.flex-control-paging a	{ background: <?=$css['color_default'][0]?>; }
.flex-control-paging a.flex-active	{ background: <?=$css['color_point'][0]?>; }



<?/**************************************************************
	기본 박스 설정
***************************************************************/?>

.theme-box	{
<? if($css['box_style'][0]) { ?>
	background-color: <?=$css['box_style'][0]?>;
<? } if($css['box_style'][2]) { ?>
	border: 1px solid <?=$css['box_style'][2]?>;
<? } if($css['box_style'][1]) { ?>
	color: <?=$css['box_style'][1]?>;
<? } ?>
	<? if($css['box_style'][3]) { ?>border-top-left-radius:<?=$css['box_style'][3]?>px;<? } ?>
	<? if($css['box_style'][4]) { ?>border-top-right-radius:<?=$css['box_style'][4]?>px;<? } ?>
	<? if($css['box_style'][5]) { ?>border-bottom-right-radius:<?=$css['box_style'][5]?>px;<? } ?>
	<? if($css['box_style'][6]) { ?>border-bottom-left-radius:<?=$css['box_style'][6]?>px;<? } ?>
}
.theme-box.no-link a	{
<? if($css['box_style'][1]) { ?>
	color: <?=$css['box_style'][1]?>;
<? } ?>
}


<?/**************************************************************
	인벤토리 팝업 설정 (기본 박스와 스타일을 함께 합니다)
***************************************************************/?>

.inven-popup-viewer {
<? if($css['box_style'][0]) { ?>
	background-color: <?=$css['box_style'][0]?>;
<? } if($css['box_style'][2]) { ?>
	border: 1px solid <?=$css['box_style'][2]?>;
<? } if($css['box_style'][1]) { ?>
	color: <?=$css['box_style'][1]?>;
<? } ?>
}



<? /****************************************************
	트위터 색상 설정
*****************************************************/ ?>

.timeline-Tweet:before { border-top-color: <?=$css['color_bak'][0]?>; }
.TweetAuthor-name	{ color: <?=$css['color_point'][0]?>; }



<?/**************************************************************
	서브메뉴 출력
***************************************************************/?>

#submenu	{
	background-color:	<?=$css['sub_menu'][0]?>;
	color:	<?=$css['sub_menu'][1]?>;
<? 
	$css['sub_menu']['border'] = explode("||", $css['sub_menu'][5]);
	for($i=0; $i < count($css['sub_menu']['border']); $i++) {
	if($css['sub_menu']['border'][$i]) { ?>
	border-<?=$css['sub_menu']['border'][$i]?>-color:	<?=$css['sub_menu'][2]?>;
	border-<?=$css['sub_menu']['border'][$i]?>-style:	<?=$css['sub_menu'][3]?>;
	border-<?=$css['sub_menu']['border'][$i]?>-width: <?=$css['sub_menu'][4]?>px;
<? } } ?>
}
#submenu a	{
	color: <?=$css['sub_menu'][1]?>;
}
#submenu a:hover	{
	color: <?=$css['sub_menu'][6]?>;
}



<?/**************************************************************
	테이블 설정
***************************************************************/?>

.theme-list,
.theme-form	{
	background-color:	<?=$css['board_table'][0]?>;
	color:	<?=$css['board_table'][1]?>;
<? 
	$css['board_table']['border'] = explode("||", $css['board_table'][5]);
	for($i=0; $i < count($css['board_table']['border']); $i++) {
	if($css['board_table']['border'][$i]) { ?>
	border-<?=$css['board_table']['border'][$i]?>-color:	<?=$css['board_table'][2]?>;
	border-<?=$css['board_table']['border'][$i]?>-style:	<?=$css['board_table'][3]?>;
	border-<?=$css['board_table']['border'][$i]?>-width: <?=$css['board_table'][4]?>px;
<? } } ?>
}

/*** Form Area ***/
.theme-form th	{
	background-color:	<?=$css['form_header'][0]?>;
	color:	<?=$css['form_header'][1]?>;
<? 
	$css['form_header']['border'] = explode("||", $css['form_header'][5]);
	for($i=0; $i < count($css['form_header']['border']); $i++) {
	if($css['form_header']['border'][$i]) { ?>
	border-<?=$css['form_header']['border'][$i]?>-color:	<?=$css['form_header'][2]?>;
	border-<?=$css['form_header']['border'][$i]?>-style:	<?=$css['form_header'][3]?>;
	border-<?=$css['form_header']['border'][$i]?>-width:	<?=$css['form_header'][4]?>px;
<? } } ?>
}
.theme-form td	{
	background-color:	<?=$css['form_body'][0]?>;
	color:	<?=$css['form_body'][1]?>;
<? 
	$css['form_body']['border'] = explode("||", $css['form_body'][5]);
	for($i=0; $i < count($css['form_body']['border']); $i++) {
	if($css['form_body']['border'][$i]) { ?>
	border-<?=$css['form_body']['border'][$i]?>-color:	<?=$css['form_body'][2]?>;
	border-<?=$css['form_body']['border'][$i]?>-style:	<?=$css['form_body'][3]?>;
	border-<?=$css['form_body']['border'][$i]?>-width:	<?=$css['form_body'][4]?>px;
<? } } ?>
}

/*** List Area ***/
.theme-list th	{
	background-color:	<?=$css['list_header'][0]?>;
	color:	<?=$css['list_header'][1]?>;
<? 
	$css['list_header']['border'] = explode("||", $css['list_header'][5]);
	for($i=0; $i < count($css['list_header']['border']); $i++) {
	if($css['list_header']['border'][$i]) { ?>
	border-<?=$css['list_header']['border'][$i]?>-color:	<?=$css['list_header'][2]?>;
	border-<?=$css['list_header']['border'][$i]?>-style:	<?=$css['list_header'][3]?>;
	border-<?=$css['list_header']['border'][$i]?>-width:	<?=$css['list_header'][4]?>px;
<? } } ?>
}
.theme-list td	{
	background-color:	<?=$css['list_body'][0]?>;
	color:	<?=$css['list_body'][1]?>;
<? 
	$css['list_body']['border'] = explode("||", $css['list_body'][5]);
	for($i=0; $i < count($css['list_body']['border']); $i++) {
	if($css['list_body']['border'][$i]) { ?>
	border-<?=$css['list_body']['border'][$i]?>-color:	<?=$css['list_body'][2]?>;
	border-<?=$css['list_body']['border'][$i]?>-style:	<?=$css['list_body'][3]?>;
	border-<?=$css['list_body']['border'][$i]?>-width:	<?=$css['list_body'][4]?>px;
<? } } ?>
}



<?/**************************************************************
	탭 설정
***************************************************************/?>

#tab_list { border-color: <?=$css['btn_point'][2]?>; }



<?/**************************************************************
	인벤토리 설정
***************************************************************/?>

.inventory-list a {
	/*border: 1px solid <?=$css['color_point'][0]?>;*/

	border: 1px solid <?=$css['color_point'][0]?>;
}
.inventory-list a i	{
	/*
	background: <?=$css['color_point'][0]?>;
	color: <?=$css['color_bak'][0]?>;
	*/

	border: 1px solid <?=$css['color_point'][0]?>;
	background: rgba(0, 0, 0, .7);
	color: #fff;
}




<?/**************************************************************
	로드비 게시판 설정
***************************************************************/?>

#load_log_board	{
	<? if($css['mmb_contain_bak'][0]) { ?>
	background-image: url('<?=$css['mmb_contain_bak'][0]?>');
	<? } if($css['mmb_contain_bak'][1]) { ?>
	background-color: <?=$css['mmb_contain_bak'][1]?>;
	<? } if($css['mmb_contain_bak'][2]) { ?>
	background-repeat: <?=$css['mmb_contain_bak'][2]?>;
	<? } if($css['mmb_contain_bak'][3]) { ?>
	background-position: <?=$css['mmb_contain_bak'][3]?>;
	<? } if($css['mmb_contain_bak'][4]) { ?>
	background-size: <?=$css['mmb_contain_bak'][4]?>;
	<? } if($css['mmb_contain_bak'][5]) { ?>
	background-attachment: <?=$css['mmb_contain_bak'][5]?>;
	<? } ?>
}

.board-notice	{
	<? if($css['mmb_notice'][0]) { ?>
	background-color: <?=$css['mmb_notice'][0]?>;
	<? } if($css['mmb_notice'][1]) { ?>
	color: <?=$css['mmb_notice'][1]?>;
	<? } 
	$css['mmb_notice']['border'] = explode("||", $css['mmb_notice'][5]);
	for($i=0; $i < count($css['mmb_notice']['border']); $i++) {
	if($css['mmb_notice']['border'][$i]) { ?>
	border-<?=$css['mmb_notice']['border'][$i]?>-color:	<?=$css['mmb_notice'][2]?>;
	border-<?=$css['mmb_notice']['border'][$i]?>-style:	<?=$css['mmb_notice'][3]?>;
	border-<?=$css['mmb_notice']['border'][$i]?>-width: <?=$css['mmb_notice'][4]?>px;
	<? } } ?>
}

#log_list	{
	<? if($css['mmb_list'][0]) { ?>
	background-color: <?=$css['mmb_list'][0]?>;
	<? } if($css['mmb_list'][1]) { ?>
	color: <?=$css['mmb_list'][1]?>;
	<? } 
	$css['mmb_list']['border'] = explode("||", $css['mmb_list'][5]);
	for($i=0; $i < count($css['mmb_list']['border']); $i++) {
	if($css['mmb_list']['border'][$i]) { ?>
	border-<?=$css['mmb_list']['border'][$i]?>-color:	<?=$css['mmb_list'][2]?>;
	border-<?=$css['mmb_list']['border'][$i]?>-style:	<?=$css['mmb_list'][3]?>;
	border-<?=$css['mmb_list']['border'][$i]?>-width: <?=$css['mmb_list'][4]?>px;
	<? } } ?>
}
<?
$is_item_area = false;
?>
#log_list .item	{
	<? if($css['mmb_list_item'][0]) { $is_item_area = true; ?>
	background-color: <?=$css['mmb_list_item'][0]?>;
	<? } if($css['mmb_list_item'][1]) { ?>
	color: <?=$css['mmb_list_item'][1]?>;
	<? } 
	$css['mmb_list_item']['border'] = explode("||", $css['mmb_list_item'][5]);
	for($i=0; $i < count($css['mmb_list_item']['border']); $i++) {
	if($css['mmb_list_item']['border'][$i]) { $is_item_area = true; ?>
	border-<?=$css['mmb_list_item']['border'][$i]?>-color:	<?=$css['mmb_list_item'][2]?>;
	border-<?=$css['mmb_list_item']['border'][$i]?>-style:	<?=$css['mmb_list_item'][3]?>;
	border-<?=$css['mmb_list_item']['border'][$i]?>-width: <?=$css['mmb_list_item'][4]?>px;
	<? } } ?>

	<? if($css['mmb_list_item'][6]) { ?>
	margin-bottom: <?=$css['mmb_list_item'][6]?>px !important;
	<? } ?>
}

#log_list .item .item-inner .ui-pic	{
	<? if($css['mmb_log'][0]) { ?>
	background-color: <?=$css['mmb_log'][0]?>;
	<? } if($css['mmb_log'][1]) { ?>
	color: <?=$css['mmb_log'][1]?>;
	<? } 
	$css['mmb_log']['border'] = explode("||", $css['mmb_log'][5]);
	for($i=0; $i < count($css['mmb_log']['border']); $i++) {
	if($css['mmb_log']['border'][$i]) { ?>
	border-<?=$css['mmb_log']['border'][$i]?>-color:	<?=$css['mmb_log'][2]?>;
	border-<?=$css['mmb_log']['border'][$i]?>-style:	<?=$css['mmb_log'][3]?>;
	border-<?=$css['mmb_log']['border'][$i]?>-width: <?=$css['mmb_log'][4]?>px;
	<? } } ?>
}

<?
$is_comment_area = false;
?>

#log_list .item .item-inner .item-comment	{
	<? if($css['mmb_reply_item'][0]) { $is_comment_area = true; ?>
	background-color: <?=$css['mmb_reply_item'][0]?>;
	<? } if($css['mmb_reply_item'][1]) { ?>
	color: <?=$css['mmb_reply_item'][1]?>;
	<? } 
	$css['mmb_reply_item']['border'] = explode("||", $css['mmb_reply_item'][5]);
	for($i=0; $i < count($css['mmb_reply_item']['border']); $i++) {
	if($css['mmb_reply_item']['border'][$i]) { $is_comment_area = true; ?>
	border-<?=$css['mmb_reply_item']['border'][$i]?>-color:	<?=$css['mmb_reply_item'][2]?>;
	border-<?=$css['mmb_reply_item']['border'][$i]?>-style:	<?=$css['mmb_reply_item'][3]?>;
	border-<?=$css['mmb_reply_item']['border'][$i]?>-width: <?=$css['mmb_reply_item'][4]?>px;
	<? } } ?>
	<? if($css['mmb_reply_item'][6]) { ?>
	margin-bottom: <?=$css['mmb_reply_item'][6]?>px !important;
	<? } ?>
}


#log_list .item .item-inner	.ui-comment	{
	<? if($css['mmb_reply'][0]) { $is_comment_area = true; ?>
	background-color: <?=$css['mmb_reply'][0]?>;
	<? } if($css['mmb_reply'][1]) { ?>
	color: <?=$css['mmb_reply'][1]?>;
	<? } 
	$css['mmb_reply']['border'] = explode("||", $css['mmb_reply'][5]);
	for($i=0; $i < count($css['mmb_reply']['border']); $i++) {
	if($css['mmb_reply']['border'][$i]) { $is_comment_area = true; ?>
	border-<?=$css['mmb_reply']['border'][$i]?>-color:	<?=$css['mmb_reply'][2]?>;
	border-<?=$css['mmb_reply']['border'][$i]?>-style:	<?=$css['mmb_reply'][3]?>;
	border-<?=$css['mmb_reply']['border'][$i]?>-width: <?=$css['mmb_reply'][4]?>px;
	<? } } ?>

	<? if($is_item_area && $is_comment_area) { ?>
	padding-left: 15px;
	padding-right: 15px;
	<? } ?>
}


#log_list .item .item-inner .co-header p,
#log_list .item .item-inner .co-header p a	{
	<? if($css['mmb_name'][0]) { ?>
	color: <?=$css['mmb_name'][0]?>;
	<? } ?>
	<? if($css['mmb_name'][1]) { ?>
	font-size: <?=$css['mmb_name'][1]?>px;
	<? } ?>
}

#log_list .item .item-inner .co-header p.owner,
#log_list .item .item-inner .co-header p.owner a	{
	<? if($css['mmb_owner_name'][0]) { ?>
	color: <?=$css['mmb_owner_name'][0]?>;
	<? } ?>
	<? if($css['mmb_owner_name'][1]) { ?>
	font-size: <?=$css['mmb_owner_name'][1]?>px;
	<? } ?>
}

#log_list .item .item-inner .co-footer .date	{
	<? if($css['mmb_datetime'][0]) { ?>
	color: <?=$css['mmb_datetime'][0]?>;
	<? } ?>
	<? if($css['mmb_datetime'][1]) { ?>
	font-size: <?=$css['mmb_datetime'][1]?>px;
	<? } ?>
}
#log_list .item .item-inner .co-content .other-site-link	{
	<? if($css['mmb_link'][0]) { ?>
	color: <?=$css['mmb_link'][0]?>;
	<? } ?>
}
#log_list .item .item-inner .co-content .link_hash_tag	{
	<? if($css['mmb_hash'][0]) { ?>
	color: <?=$css['mmb_hash'][0]?>;
	<? } ?>
}
#log_list .item .item-inner .co-content .log_link_tag	{
	<? if($css['mmb_log_ank'][0]) { ?>
	color: <?=$css['mmb_log_ank'][0]?>;
	<? } ?>
}
#log_list .item .item-inner .co-content .member_call	{
	<? if($css['mmb_call'][0]) { ?>
	color: <?=$css['mmb_call'][0]?>;
	<? } ?>
}