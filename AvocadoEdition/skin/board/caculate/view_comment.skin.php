<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

for ($index=0; $index<count($comment); $index++) {

	$log_comment = $comment[$index];
	$comment_id = $log_comment['wr_id'];

	$content = $log_comment['content'];
	$content = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $content);

	
	if($log_comment['wr_id'] != $log_comment['wr_id'] && ($log_comment['is_reply'] || $log_comment['is_edit'] || $log_comment['is_del'])) {
		// 답변, 수정, 삭제가 가능할 경우
		// 또한, 본문의 id와 코멘트의 id가 다를 경우 (같을 경우엔 로그의 상단에 있는 컨트롤을 통해 액션 수행이 가능하다)
		$query_string = str_replace("&", "&amp;", $_SERVER['QUERY_STRING']);
		if($w == 'cu') {
			$sql = " select wr_id, wr_content from $write_table where wr_id = '$indexd' and wr_is_comment = '1' ";
			$cmt = sql_fetch($sql);
			$c_wr_content = $cmt['wr_content'];
		}

		$c_reply_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w_'.$data['wr_id'];
		$c_edit_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w_'.$data['wr_id'];
	}

	if($index == 0) { 
		echo '<div class="comment-box">';
	}
?>


<div class="theme-box" id="c_<?php echo $comment_id ?>">
	<div class="co-content">
		<div class="original_comment_area">
			<?
				if (strstr($log_comment['wr_option'], "secret")) { 
					if($log_comment['mb_id'] == $member['mb_id'] || $is_admin) { 
						echo '<span class="secret" style="color: #ff5b00;">[비밀글]</span><br />';
						// 코멘트 출력 부분
						$log_comment['content'] = autolink($log_comment['content'], $bo_table, $stx); // 자동 링크 및 해시태그, 로그 링크 등 컨트롤 함수
						echo $log_comment['content'];
					} else {
						echo '<span>비밀글입니다.</span>';
					}
				} else { 
					// 코멘트 출력 부분
					$log_comment['content'] = autolink($log_comment['content'], $bo_table, $stx); // 자동 링크 및 해시태그, 로그 링크 등 컨트롤 함수
					echo $log_comment['content'];
				}
			?>
		</div>
		<? if($log_comment['is_edit']) { ?>
		<div class="modify_area" id="save_comment_<?php echo $comment_id ?>">
			<textarea id="save_co_comment_<?php echo $comment_id ?>"><?php echo get_text($log_comment['content1'], 0) ?></textarea>
			<button type="button" class="mod_comment ui-btn" onclick="modify_commnet('<?php echo $comment_id ?>'); return false;">수정</button>
		</div>
		<? } ?>
	</div>

	<div class="co-footer">
		<div class="f-box">
			<?php if ($log_comment['is_del'])  { ?><a href="<?php echo $log_comment['del_link'];  ?>" onclick="return comment_delete();" class="del">삭제</a><?php } ?>
			<?php if ($log_comment['is_edit']) { ?><a href="<?php echo $c_edit_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', '<?=$data['wr_id']?>'); return false;" class="mod">수정</a><?php } ?>
			<span class="date">
				<?=date('Y-m-d H:i:s', strtotime($log_comment['wr_datetime']))?>
			</span>
		</div>
	</div>
</div>
<? }

if($index > 0) { 
	echo '</div>';
}
	
?>


