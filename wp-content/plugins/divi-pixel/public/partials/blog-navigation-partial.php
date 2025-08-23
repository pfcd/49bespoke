<?php
namespace DiviPixel;

?>
<div id="dipi-post-navigation" class="et_pb_section et_section_regular dipi-post-nav-section">
	<div class="dipi-post-row et_pb_row">
		<?php if (get_previous_post()): ?>
		<div class="dipi-post-left">
			<?php previous_post_link('%link', '<i class="et-pb-icon">&#x23;</i><span>' . DIPI_Settings::get_option('blog_nav_prev') . '</span>');?>
		</div>
		<?php endif;?>

		<?php if (get_next_post()): ?>
		<div class="dipi-post-right">
			<?php next_post_link('%link', '<span>' . DIPI_Settings::get_option('blog_nav_next') . '</span><i class="et-pb-icon">&#x24;</i>');?>
		</div>
		<?php endif;?>
	</div>
</div>

