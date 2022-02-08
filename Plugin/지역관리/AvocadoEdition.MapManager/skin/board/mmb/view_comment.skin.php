<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

for ($index=0; $index<count($comment); $index++) {

	$log_comment = $comment[$index];
	$comment_id = $log_comment['wr_id'];

	$content = $log_comment['content'];
	$content = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $content);

	if($log_comment['wr_log'] && !$is_admin) { 
		// 로그 (탐색 / 조합 등의 액션 수행)의 흔적이 있을 경우
		// 관리자가 아니면 삭제 불가
		$is_delete = false;
	}
	
	if($log_comment['wr_id'] != $log_comment['wr_id'] && ($log_comment['is_reply'] || $log_comment['is_edit'] || $log_comment['is_del'])) {
		// 답변, 수정, 삭제가 가능할 경우
		// 또한, 본문의 id와 코멘트의 id가 다를 경우 (같을 경우엔 로그의 상단에 있는 컨트롤을 통해 액션 수행이 가능하다)
		$query_string = str_replace("&", "&amp;", $_SERVER['QUERY_STRING']);
		if($w == 'cu') {
			$sql = " select wr_id, wr_content from $write_table where wr_id = '$indexd' and wr_is_comment = '1' ";
			$cmt = sql_fetch($sql);
			$c_wr_content = $cmt['wr_content'];
		}

		$c_reply_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w_'.$list_item['wr_id'];
		$c_edit_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w_'.$list_item['wr_id'];
	}

	// 캐릭터 정보 출력
	$is_comment_owner = false;
	$comment_owner_front = "";		// 자기 로그 접두문자
	$comment_owner_behind = "";		// 자기 로그 접미문자

	if(!$log_comment['wr_noname']) { 
		if(is_file(G5_DATA_PATH."/site/ico_admin") && $config['cf_admin'] == $log_comment['mb_id']) {
			// 관리자 아이콘이 존재하고, 관리자와 작성자가 동일 할 경우
			// 관리자 아이콘을 출력한다.
			$log_comment['ch_name'] = "<img src='".G5_DATA_URL."/site/ico_admin' alt='관리자' />";
		} else {
			// 캐릭터 정보 로드
			$ch = get_character($log_comment['ch_id']);
			if($ch['ch_id']) {
				// 캐릭터 정보가 존재할 경우, 캐릭터 정보를 추가한다.
				// 캐릭터 링크
				// + 캐릭터 소속 아이콘
				// + 캐릭터 종족 아이콘
				// + 캐릭터 이름
				/*$log_comment['ch_name'] = "
					<a href='".G5_URL."/member/viewer.php?ch_id={$ch['ch_id']}' target='_blank'>
						<i>".get_side_icon($ch['ch_side']).get_class_icon($ch['ch_class'])."</i>
						".get_title_image($log_comment['ti_id'])."
						".($log_comment['wr_subject'] ? $log_comment['wr_subject'] : "GUEST")."
					</a>";*/
				$log_comment['ch_name'] = "
					<a href='".G5_URL."/member/viewer.php?ch_id={$ch['ch_id']}' target='_blank'>
						<i>".get_side_icon($ch['ch_side'])."</i>
						".get_title_image($log_comment['ti_id'])."
						".($ch['ch_name'] ? $ch['ch_name'] : "GUEST")."
					</a>";
			} else {
				// 캐릭터 정보가 존재하지 않을 경우, 빈값을 출력한다.
				$log_comment['ch_name'] = "";
			}
		}

		// 오너 정보 출력
		if($log_comment['mb_id']) {
			$log_comment['name'] = "<a href='".G5_BBS_URL."/memo_form.php?me_recv_mb_id={$log_comment['mb_id']}' class='send_memo'>{$log_comment[wr_name]}</a>";
		} else { 
			$log_comment['name'] = $log_comment[wr_name];
		}

		if(!$list_item['wr_noname'] && $list_item['mb_id'] == $log_comment['mb_id']) { 
			$is_comment_owner = true;
			$comment_owner_front = $owner_front;
			$comment_owner_behind = $owner_behind;
		}
	} else {
		$is_comment_owner = false;
	}

	/******************************************************
		위치이동 커맨드 추가
	******************************************************/	
	$map_info = '';
	if($log_comment['ma_id']) { 
		$ma_name = sql_fetch("select ma_name from {$g5['map_table']} where ma_id = '{$log_comment['ma_id']}'");
		$map_info .= " <span class='ico-map'>위치 : {$ma_name['ma_name']}</span>";
	}
	/******************************************************
		위치이동 커맨드 추가 종료
	******************************************************/	
?>


<div class="item-comment" id="c_<?php echo $comment_id ?>">
	<div class="co-header">
		<? // 로그 작성자와 코멘트 작성자가 동일할 경우, class='owner' 를 추가한다. ?>
		<? if(!$log_comment['wr_noname']) { ?>
		<p <?=$is_comment_owner ? ' class="owner"' : ''?>>
			<?=$comment_owner_front?>
			<strong><?=$log_comment['ch_name']?></strong>
			<span>[<?=$log_comment['name']?>]</span>
			<?=$comment_owner_behind?>
		</p>
		<? } else { ?>
		<p>익명의 누군가</p>
		<? } ?>

		<?
		/******************************************************
			위치이동 커맨드 추가
		******************************************************/	
			echo $map_info;
		/******************************************************
			위치이동 커맨드 추가 종료
		******************************************************/	
		?>

	</div>

	<div class="co-content">
		<div class="original_comment_area">
			<?
				// 액션 로그 정보 가져 오기
				$data_log = $log_comment['wr_log'];
				// 아이템 사용 정보 가져오기
				$item_log = $log_comment['wr_item_log'];

				include($board_skin_path."/_action.data.php");
			
				// 주사위를 굴린 정보가 있을 경우
				if($log_comment['wr_dice1']) {
			?>
			<span class="dice">
				<img src="<?=$board_skin_url?>/img/d<?=$log_comment['wr_dice1']?>.png" />
				<img src="<?=$board_skin_url?>/img/d<?=$log_comment['wr_dice2']?>.png" />
			</span>
			<? } 
				if($log_comment['wr_link1']) {
					// 로그 등록 시 입력한 외부 링크 정보
			?>
				<span class="link-box">
					<? if($log_comment['wr_link1']) { ?>
						<a href="<?=$log_comment['wr_link1']?>" target="_blank" class="link">LINK</a>
					<? } ?>
					<? if($log_comment['wr_link2']) { ?>
						<a href="<?=$log_comment['wr_link2']?>" target="_blank" class="link">LINK</a>
					<? } ?>
				</span>
			<? } 
			// 코멘트 출력 부분
			$log_comment['content'] = autolink($log_comment['content'], $bo_table, $stx); // 자동 링크 및 해시태그, 로그 링크 등 컨트롤 함수
			$log_comment['content'] = emote_ev($log_comment['content']); // 이모티콘 출력 함수
			echo $log_comment['content'];
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
		<span class="date">
			<?=date('Y-m-d H:i:s', strtotime($log_comment['wr_datetime']))?>
		</span>
		<?php if ($log_comment['is_del'])  { ?><a href="<?php echo $log_comment['del_link'];  ?>" onclick="return comment_delete();" class="del">삭제</a><?php } ?>
		<?php if ($log_comment['is_edit']) { ?><a href="<?php echo $c_edit_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', '<?=$list_item[wr_id]?>'); return false;" class="mod">수정</a><?php } ?>
	</div>
</div>
<? } ?>


