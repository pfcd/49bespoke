<?php 
namespace DiviPixel;

	
$read_more_button_text = DIPI_Settings::get_option('read_more_button_text');
$dipi_blog_read_more_text = '';

if(DIPI_Settings::get_option('read_more_button')) { 
    $dipi_blog_read_more_text = (!empty( $read_more_button_text )) ? $read_more_button_text : esc_html__('Read More', 'dipi-divi-pixel');;
} else {
    $dipi_blog_read_more_text = esc_html__('View Full Post', 'dipi-divi-pixel');
}

$archive_btn_enable_icon = DIPI_Customizer::get_option('archive_btn_enable_icon');
$archive_btn_alignment = DIPI_Customizer::get_option('archive_btn_alignment');
$archive_btn_hover_effect = DIPI_Customizer::get_option('archive_btn_hover_effect');
$read_more_button_style = DIPI_Settings::get_option('read_more_button_style');

?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	const et_pb_post_selector = `body.archive article.et_pb_post,
		body.blog article.et_pb_post`

	$(et_pb_post_selector).each(function() {
		
		var dipi_permalink = $(this).find('.entry-title').find('a').attr('href');
		$(this).find(".more-link").remove()

		<?php if('only_text' == $read_more_button_style) : ?>
		
			var dipi_readmore_button_only_text = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="dipi-read-more-button dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?> "><?php echo esc_html($dipi_blog_read_more_text); ?></a></div>';
		
			$(dipi_readmore_button_only_text).appendTo($(this));
		
		<?php elseif('text_icon' == $read_more_button_style) : ?>
		
			var dipi_readmore_button_icon_text = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="et-pb-icon dipi-read-more-button dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?> dipi-button-icon-<?php echo esc_attr($archive_btn_enable_icon); ?>"><?php echo esc_html($dipi_blog_read_more_text); ?></a></div>';
		
			$(dipi_readmore_button_icon_text).appendTo($(this));
		
		<?php elseif('only_icon' == $read_more_button_style) : ?>
			
			var dipi_readmore_button_only_icon = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="et-pb-icon dipi-read-more-button dipi-read-more-button-icon-only dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?>"></a></div>';
			
			$(dipi_readmore_button_only_icon).appendTo($(this));

		<?php endif; ?>
		
	});

	const et_pb_module_posts_selector = `
		.et_pb_module.et_pb_posts .et_pb_ajax_pagination_container article.et_pb_post,
		.et_pb_module.et_pb_blog_grid_wrapper .et_pb_ajax_pagination_container article.et_pb_post`
	
	function blogModuleButtonStyle(){
		$(et_pb_module_posts_selector).each(function() {
			
			var dipi_permalink = $(this).find('.entry-title').find('a').attr('href');
			let read_more_button = $(this).find(".more-link")

			if (read_more_button.length > 0) {
				read_more_button.remove()

				<?php if('only_text' == $read_more_button_style) : ?>
				
					var dipi_readmore_button_only_text = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="dipi-read-more-button dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?> "><?php echo esc_html($dipi_blog_read_more_text); ?></a></div>';
				
					$(dipi_readmore_button_only_text).appendTo($(this));
				
				<?php elseif('text_icon' == $read_more_button_style) : ?>
				
					var dipi_readmore_button_icon_text = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="et-pb-icon dipi-read-more-button dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?> dipi-button-icon-<?php echo esc_attr($archive_btn_enable_icon); ?>"><?php echo esc_html($dipi_blog_read_more_text); ?></a></div>';
				
					$(dipi_readmore_button_icon_text).appendTo($(this));
				
				<?php elseif('only_icon' == $read_more_button_style) : ?>
					
					var dipi_readmore_button_only_icon = '<div class="dipi-read-more-wrap dipi-button-<?php echo esc_attr($archive_btn_alignment); ?>"><a href="'+dipi_permalink+'" class="et-pb-icon dipi-read-more-button dipi-read-more-button-icon-only dipi-button-<?php echo esc_attr($archive_btn_hover_effect); ?>"></a></div>';
					
					$(dipi_readmore_button_only_icon).appendTo($(this));

				<?php endif; ?>
			}
		});
	}
	
	blogModuleButtonStyle();
	let observer = new MutationObserver(blogModuleButtonStyle);
	document.querySelectorAll('.et_pb_posts').forEach(function(node){
		observer.observe(node, {
			childList: true
		});
	})
});
</script>