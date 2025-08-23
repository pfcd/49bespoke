<?php
namespace DiviPixel;
$blog_author_image_size = DIPI_Customizer::get_option('blog_author_image_size'); 
$blog_author_image_size = $blog_author_image_size ? $blog_author_image_size : 80;
?>
<div id="dipi-author-box" class="dipi-author-section">
	<div class="dipi-author-row">
		<div class="dipi-author-left">
			<?php echo get_avatar( get_the_author_meta('email'), $blog_author_image_size );?>
		</div>
		<div class="dipi-author-right">
			<h3><?php echo esc_html(get_the_author_meta('display_name')); ?></h3>
			<p><?php echo wp_kses_post(get_the_author_meta('description')); ?></p>
		</div>
	 </div>
</div>