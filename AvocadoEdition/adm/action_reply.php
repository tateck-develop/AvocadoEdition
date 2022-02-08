<?php
$sub_menu = "200200";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'r');

if(!$s_year) $s_year = date('Y');
if(!$s_month) $s_month = date('m');
$fr_date = $s_year."-".$s_month."-"."01";
$to_date = $s_year."-".$s_month."-"."32";
?>

<style>
	html, body { padding: 0; margin: 0; }
	p { margin: 0; padding: 0 10px; }
	p > a { display: block; position: relative; color: #fff; font-size: 12px; text-decoration: none; border-top: 1px dashed #666; padding: 4px 3px; }
	p:first-child > a { border-top: none; }
	p > a:hover { color: yellow; }
</style>

<?
$reply_count = array();
$reply_index = 0;
$log = sql_query("select mu_id from g5_mmb_upload where mu_datetime > '{$fr_date}' and mu_datetime < '{$to_date}' and (mu_id > '5599' or mu_id < '5370') and (mu_id > '6576' or mu_id < '6369') and mb_id = '{$mb_id}'");


for ($j=0; $row=sql_fetch_array($log); $j++) {
	$log2 = sql_query ("select mu_id from g5_mmb_upload where mu_id < '{$row['mu_id']}' order by mu_id desc limit 0, 3");

	for ($k=0; $row2=sql_fetch_array($log2); $k++) {
		$comment_log = sql_fetch("select mu_id, count(*) as cnt from g5_mmb_comment where mu_id = '{$row2['mu_id']}' and mb_id = '{$mb_id}'");

		if($comment_log['cnt'] == '0') { 
			if($reply_count[$reply_index]['mc_no_count'] == "") $reply_count[$reply_index]['mc_no_count'] = 0;

			if($reply_count[$reply_index]['mu_id'] != $row['mu_id']) { 
				$reply_index++;
				$reply_count[$reply_index]['mu_id'] = $row['mu_id'];
			}
			$reply_count[$reply_index]['mc_no_count']++;
			
		}
	}
}
?>
<? for($i=0; $i < count($reply_count); $i++) { 
	if($reply_count[$i]['mu_id']) { 
?>
<p>
	<a href="/mmb/index.php?mu_id=<?=$reply_count[$i]['mu_id']?>" target="_blank">
		<?=$reply_count[$i]['mu_id']?>번 로그 (<?=3 - $reply_count[$i]['mc_no_count']?>/3)
	</a>
</p>
<? }
} ?>

<?php
include_once ('../tail.sub.php');
?>
