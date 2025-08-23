<?php

$breakpoint_mobile = \DiviPixel\DIPI_Settings::get_mobile_menu_breakpoint();

?>

<script type="text/javascript">

jQuery(document).ready(function ($) {
	if( $('body').hasClass('et_is_customize_preview') ){
		return;
	}

	if( !$('body').hasClass('admin-bar') ){
		return;
	}

	let admin_bar_visible = false;
	let admin_bar_hiding = false;
	let timeout_show_admin_bar = null;
	let timeout_hide_admin_bar = null;

	function show_admin_bar(animated = true){
		animation_duration = animated ? 200 : 0;
		
		$('#wpadminbar').stop().animate({'top': '0px'}, animation_duration);
		$('body').stop().animate({'margin-top': '0px'}, animation_duration);

		// Fix for reading progress bar module
		$(' .dipi-reading-progress-top').stop().animate({'top': '30px'}, animation_duration);

		if($('body').hasClass('et_secondary_nav_enabled') || $('body').hasClass('dipi_secondary_nav_enabled')) {
			$('#top-header').stop().animate({'top': '32px'}, animation_duration);
			var topHeaderHeight = $('#top-header').innerHeight();
			var totalSpace = topHeaderHeight+32;
			$('#main-header').stop().animate({'top': totalSpace+'px'}, animation_duration);
		} else {
			$('#main-header').stop().animate({'top': '32px'}, animation_duration);
		}
	}

	function hide_admin_bar(animated = true){
		admin_bar_hiding = true;
		animation_duration = animated ? 200 : 0;
		
		$('#wpadminbar').stop().animate({'top': '-32px'}, animation_duration);
		$('body').stop().animate({'margin-top': '-32px'}, animation_duration);
		
		// Fix for reading progress bar module 
		$(' .dipi-reading-progress-top').stop().animate({'top': '0px'}, animation_duration);

		if($('body').hasClass('et_secondary_nav_enabled') || $('body').hasClass('dipi_secondary_nav_enabled')) {
			$('#top-header').stop().animate({'top': '0px'}, animation_duration);
			var topHeaderHeight = $('#top-header').innerHeight();
			$('#main-header').stop().animate({'top': topHeaderHeight+'px'}, animation_duration);
		} else {
			$('#main-header').stop().animate({'top': '0px'}, animation_duration);
		}

		setTimeout(function(){
			admin_bar_visible = false;
			admin_bar_hiding = false;
		}, animation_duration);
	}

	function bodyMousemove(e){
		if($("#wpadminbar:hover").length != 0){
			return;
		}

		if( e.clientY < 35 && !admin_bar_visible && !timeout_show_admin_bar){
			timeout_show_admin_bar = setTimeout(function(){
				admin_bar_visible = true;
				show_admin_bar();
			}, 500);
		} 
		
		if (e.clientY >= 35 && admin_bar_visible && !admin_bar_hiding && !timeout_hide_admin_bar){
			timeout_hide_admin_bar = setTimeout(function(){
				hide_admin_bar();
			}, 500);
		} 
		
		if(e.clientY < 35 && timeout_hide_admin_bar){
			clearTimeout(timeout_hide_admin_bar);
			timeout_hide_admin_bar = null;
		}

		if(e.clientY >= 35 && timeout_show_admin_bar){
			clearTimeout(timeout_show_admin_bar);
			timeout_show_admin_bar = null;
		}
	}

	$(window).resize(function(){
		$("body").off('mousemove', bodyMousemove);

		if ($(window).width() <= <?php echo intval($breakpoint_mobile); ?>) {
			admin_bar_visible = true;
			show_admin_bar(false);
			return;
		} 

		$("body").on('mousemove', bodyMousemove);
		
		hide_admin_bar(false);
	});
});

</script>
