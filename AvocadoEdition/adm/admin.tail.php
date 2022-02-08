<?php
if (!defined('_GNUBOARD_')) exit;
?>

	</section>
</div>




<!-- <p>실행시간 : <?php echo get_microtime() - $begin_time; ?> -->

<script src="<?php echo G5_ADMIN_URL ?>/admin.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_ADMIN_URL ?>/admin.ajax.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script>
$(function(){
    var hide_menu = false;
    var mouse_event = false;
    var oldX = oldY = 0;

    $(document).mousemove(function(e) {
        if(oldX == 0) {
            oldX = e.pageX;
            oldY = e.pageY;
        }

        if(oldX != e.pageX || oldY != e.pageY) {
            mouse_event = true;
        }
    });

    // 폰트 리사이즈 쿠키있으면 실행
    var font_resize_act = get_cookie("ck_font_resize_act");
    if(font_resize_act != "") {
        font_resize("container", font_resize_act);
    }
	
	$('.gnb_1da').bind('click', function(){
		var gnb_parent = $(this).closest('li');

		if(gnb_parent.hasClass('on')) { 
			
			$('#gnb .on').not('.check').removeClass('on').find('.gnb_2dul').stop().slideUp();
			$('#gnb .check').parents('li').addClass('on').find('.gnb_2dul').stop().slideDown();
		} else { 
			gnb_parent.addClass('on').find('.gnb_2dul').stop().slideDown();
			gnb_parent.siblings().removeClass('on').find('.gnb_2dul').stop().slideUp();
		}
		return false;
	});

	$('#gnb .check').addClass('on').parents('li').addClass('on').find('.gnb_2dul').show();
});

</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>