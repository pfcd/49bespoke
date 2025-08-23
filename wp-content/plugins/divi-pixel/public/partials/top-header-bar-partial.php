<?php
namespace DiviPixel;
$menu_style = DIPI_Settings::get_option('menu_styles');
$hide_top_bar = ($menu_style) ? DIPI_Customizer::get_option('hide_top_bar') : false;
$top_bar_text_size = DIPI_Customizer::get_option('top_bar_text_size');
$top_bar_letter_spacing = DIPI_Customizer::get_option('top_bar_letter_spacing');
$top_bar_font = DIPI_Customizer::get_option('top_bar_font');
$top_bar_font_weight = DIPI_Customizer::get_option('top_bar_font_weight');
$top_bar_shadow = DIPI_Customizer::get_option('top_bar_shadow');
$top_bar_shadow_color = DIPI_Customizer::get_option('top_bar_shadow_color');
$top_bar_shadow_offset = DIPI_Customizer::get_option('top_bar_shadow_offset');
$top_bar_shadow_blur = DIPI_Customizer::get_option('top_bar_shadow_blur');
$fixed_mobile_header = DIPI_Settings::get_option('fixed_mobile_header');
$fixed_mobile_header_scroll_offset = DIPI_Customizer::get_option('fixed_mobile_header_scroll_offset');

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();
$divi_fixed_nav = et_get_option( 'divi_fixed_nav', 'on' )
?>
<style>
.dipi-fixed-header #main-header,
.dipi-fixed-header #top-header{position:fixed !important;width:100%;}
</style>

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		window.dipi_apply_hide_top_bar_timer = null;
		window.dipi_apply_hide_top_bar = function () {
			var $mainContent = $('#page-container'),
				$mainHeader = $('#main-header');
			if($mainHeader.length === 0 && $('.et-l--header').length > 0 )
				$mainHeader = $('.et-l--header');
			
			var $topHeader = $('#top-header'),
				$adminBar = $('#wpadminbar'),
				adminBarHeight = $('#wpadminbar').height(),
			 	mainHeaderHiehgt = $mainHeader.height(),
				topBarHeight = 0;
			

			if($topHeader.length > 0)
				topBarHeight = $('#top-header').height();

			var didScroll = false;
			var lastScrollTop = 0;
			var delta = 5;
			if(!$('body').hasClass('admin-bar'))
				adminBarHeight = 0;

				$mainHeader.css('top', adminBarHeight + topBarHeight );
			$topHeader.css('top', adminBarHeight );

			if($mainHeader.css('position') === 'relative'){
				$mainHeader.css('top', 0 );
			}
			
			if(window.innerWidth > <?php echo esc_attr($breakpoint_mobile); ?>){
				<?php if($divi_fixed_nav == 'on' && $hide_top_bar): ?>	
					
					$(window).scroll(function(event){
						didScroll = true;
					});
					clearInterval(window.dipi_apply_hide_top_bar_timer);
					window.dipi_apply_hide_top_bar_timer = setInterval(function() {
						if (didScroll) {
							hideTopBarOnScroll();
							didScroll = false;
						}
					}, 200);
				<?php else: 
					if($divi_fixed_nav != 'on'):?>	
					clearInterval(window.dipi_apply_hide_top_bar_timer);
					$('body').removeClass('dipi-fixed-header');
					$mainContent.css('padding-top', 0 )
				<?php endif;endif; ?>	
				
				return;
			}
			<?php if($fixed_mobile_header): ?>
				function dipi_check_fixed_mobile_header() {
					clearInterval(window.dipi_apply_hide_top_bar_timer);
					if(window.innerWidth <= <?php echo esc_attr($breakpoint_mobile); ?>){
						var container_padding = topBarHeight + mainHeaderHiehgt;
						 
						$mainContent.css('cssText', 'padding-top: ' + container_padding +'px !important;')
						
						$(window).scroll(function(event){
							if (window.pageYOffset > <?php echo esc_attr($fixed_mobile_header_scroll_offset); ?>) {
								$('body').addClass('dipi-fixed-header');
								didScroll = true;
							} else {
								$('body').removeClass('dipi-fixed-header');
							}
						});
						window.dipi_apply_hide_top_bar_timer = setInterval(function() {
							if (didScroll) {
								hasScrolled();
								didScroll = false;
							}
						}, 200);
					} else {
						$mainContent.css("padding-top", "");
						$('body').removeClass('dipi-fixed-header');
					}
				}
				var dipi_check_fixed_mobile_rtime;
				var dipi_check_fixed_mobile_timeout = false;
				var dipi_check_fixed_mobile_delta = 200;
				$(window).resize(function() {
					dipi_check_fixed_mobile_rtime = new Date();
					if (dipi_check_fixed_mobile_timeout === false) {
						dipi_check_fixed_mobile_timeout = true;
						setTimeout(dipi_check_fixed_mobile_resizeend, delta);
					}
				});
				
				function dipi_check_fixed_mobile_resizeend() {
					if (new Date() - dipi_check_fixed_mobile_rtime < dipi_check_fixed_mobile_delta) {
						setTimeout(dipi_check_fixed_mobile_resizeend, dipi_check_fixed_mobile_delta);
					} else {
						dipi_check_fixed_mobile_timeout = false;
						dipi_check_fixed_mobile_header();
					}               
				}
				dipi_check_fixed_mobile_header()
			<?php else: ?>
				$('body').removeClass('dipi-fixed-header');
				clearInterval(window.dipi_apply_hide_top_bar_timer);
			<?php endif; ?>

			function hideTopBarOnScroll(){
				var scrollTop = $(this).scrollTop();
				var adminBarHeight = $('#wpadminbar').height();
				var topBarHeight = 0;
				if($topHeader.length > 0)
					topBarHeight = $('#top-header').height();
				if(Math.abs(lastScrollTop - scrollTop) <= delta){
					return;
				}
				if (scrollTop > lastScrollTop && scrollTop > topBarHeight) { // scroll down
					$('#top-header').css('transform', 'translateY(-' + topBarHeight + 'px)');
					$('#main-header').css('transform', 'translateY(-' + topBarHeight + 'px)');
				} else if(scrollTop + $(window).height() < $(document).height()) {
					$('#top-header').css('transform', 'translateY(0px)');
					$('#main-header').css('transform', 'translateY(0px)');
				}
				lastScrollTop = scrollTop;
			}
			function hasScrolled() {
				var adminBarHeight = $('#wpadminbar').height();
				var topBarHeight = 0;
				if($topHeader.length > 0)
					topBarHeight = $('#top-header').height();
				
					if(!$('body').hasClass('admin-bar'))
						adminBarHeight = 0;
				var scrollTop = $(this).scrollTop();
				
				if(Math.abs(lastScrollTop - scrollTop) <= delta){
					return;
				}
				if (scrollTop > lastScrollTop && scrollTop > topBarHeight) { // scroll down
					if(window.innerWidth > 600)
						adminBarHeight = 0;
					<?php if($hide_top_bar): ?>
						$('#top-header').css('transform', 'translateY(-' + (topBarHeight + adminBarHeight) + 'px)');
						$('#main-header').css('transform', 'translateY(-' + (topBarHeight + adminBarHeight) + 'px)');
					<?php else: ?>
						$('#top-header').css('transform', 'translateY(-' +  adminBarHeight + 'px)');
						$('#main-header').css('transform', 'translateY(-' +  adminBarHeight + 'px)');
					<?php endif; ?>
				} else if(scrollTop + $(window).height() < $(document).height()) {
					$('#top-header').css('transform', 'translateY(0px)');
					$('#main-header').css('transform', 'translateY(0px)');
				}

				lastScrollTop = scrollTop;
			}
		}
		window.dipi_apply_hide_top_bar();
		$(window).on('resize', function(){
			window.dipi_apply_hide_top_bar();
		})
	});
</script>

	<style type="text/css" id="top-header-bar-css">
	@media (max-width: 980px){
		#main-header,
		#top-header{
			transition:transform 0.4s, opacity 0.4s ease-in-out, -webkit-transform 0.4s !important;
		}
	}
	<?php if($menu_style): ?>
		#top-header {
			<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($top_bar_font)), 'html'); ?>
			font-size: <?php echo esc_html($top_bar_text_size); ?>px !important;
			letter-spacing: <?php echo esc_html($top_bar_letter_spacing); ?>px !important;
			<?php if ($top_bar_shadow): ?>
			box-shadow: 0px <?php echo esc_html($top_bar_shadow_offset); ?>px <?php echo esc_html($top_bar_shadow_blur); ?>px <?php echo esc_html($top_bar_shadow_color); ?> !important;
			<?php endif;?>
		}

		#top-header li a,
		#et-info-email,
		#et-info-phone {
			<?php echo esc_html(DIPI_Customizer::print_font_style_option('top_bar_font_style')); ?>
			font-weight: <?php echo esc_html($top_bar_font_weight); ?> !important;
		}
		<?php endif; ?>
	</style>
