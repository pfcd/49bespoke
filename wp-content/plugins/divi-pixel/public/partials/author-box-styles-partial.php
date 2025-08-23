<?php
namespace DiviPixel;

// Author Name
$blog_author_name_font_select = DIPI_Customizer::get_option('blog_author_name_font_select');
$blog_author_name_font_weight = DIPI_Customizer::get_option('blog_author_name_font_weight');
$blog_author_name_font_size = DIPI_Customizer::get_option('blog_author_name_font_size');
$blog_author_name_text_spacing = DIPI_Customizer::get_option('blog_author_name_text_spacing');
$blog_author_name_font_color = DIPI_Customizer::get_option('blog_author_name_font_color');

//Section Background
$blog_author_section_background_image = DIPI_Customizer::get_option('blog_author_section_background_image');
$blog_author_section_background_color = DIPI_Customizer::get_option('blog_author_section_background_color');
$blog_author_section_background_image_size = DIPI_Customizer::get_option('blog_author_section_background_image_size');
$blog_author_section_background_image_repeat = DIPI_Customizer::get_option('blog_author_section_background_image_repeat');
$blog_author_section_background_image_position = DIPI_Customizer::get_option('blog_author_section_background_image_position');

?>

<style type="text/css">
.dipi-author-section .dipi-author-right h3 {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_author_name_font_select)), 'html'); ?>
    font-weight: <?php echo esc_html($blog_author_name_font_weight); ?>;
    font-size: <?php echo esc_html($blog_author_name_font_size); ?>px;
    letter-spacing: <?php echo esc_html($blog_author_name_text_spacing); ?>px;
    color: <?php echo esc_html($blog_author_name_font_color); ?>;
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_author_name_font_style")); ?>
}
</style>

<?php
// Author bio
$blog_author_desc_font_select = DIPI_Customizer::get_option('blog_author_desc_font_select');
$blog_author_desc_font_weight = DIPI_Customizer::get_option('blog_author_desc_font_weight');
$blog_author_desc_font_size = DIPI_Customizer::get_option('blog_author_desc_font_size');
$blog_author_desc_text_spacing = DIPI_Customizer::get_option('blog_author_desc_text_spacing');
$blog_author_desc_font_color = DIPI_Customizer::get_option('blog_author_desc_font_color');

?>

<style type="text/css">
#main-content #dipi-author-box.dipi-author-section{
	background-color: <?php echo esc_html($blog_author_section_background_color) ?> !important;
	<?php if ($blog_author_section_background_image && filter_var($blog_author_section_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($blog_author_section_background_image) ?>) !important;
	<?php endif; ?>		
	<?php if ('cover' === $blog_author_section_background_image_size): ?>
	background-size: cover;
	<?php elseif ('fit' === $blog_author_section_background_image_size): ?>
	background-size: contain;
	<?php elseif ('actual' === $blog_author_section_background_image_size): ?>
	background-size: auto auto ;
	<?php endif;?>
	<?php if ('no-repeat' === $blog_author_section_background_image_repeat): ?>
	background-repeat: no-repeat ;
	<?php elseif ('repeat' === $blog_author_section_background_image_repeat): ?>
	background-repeat: repeat ;
	<?php elseif ('repeat-x' === $blog_author_section_background_image_repeat): ?>
	background-repeat: repeat-x;
	<?php elseif ('repeat-y' === $blog_author_section_background_image_repeat): ?>
	background-repeat: repeat-y;
	<?php endif;?>
	<?php if ('top_left' === $blog_author_section_background_image_position): ?>
	background-position-x: left;
    background-position-y: top;
	<?php elseif ('top_center' === $blog_author_section_background_image_position): ?>
	background-position-x: center;
	background-position-y: top;
	<?php elseif ('top_right' === $blog_author_section_background_image_position): ?>
	background-position-x: right;
    background-position-y: top;
	<?php elseif ('center_left' === $blog_author_section_background_image_position): ?>
	background-position-x: left;
    background-position-y: center;
	<?php elseif ('center_center' === $blog_author_section_background_image_position): ?>
	background-position-x: center;
    background-position-y: center;
	<?php elseif ('center_right' === $blog_author_section_background_image_position): ?>
	background-position-x: right;
    background-position-y: center;
	<?php elseif ('bottom_left' === $blog_author_section_background_image_position): ?>
	background-position-x: left;
    background-position-y: bottom;
	<?php elseif ('bottom_center' === $blog_author_section_background_image_position): ?>
	background-position-x: center;
    background-position-y: bottom;
	<?php elseif ('bottom_right' === $blog_author_section_background_image_position): ?>
	background-position-x: right;
    background-position-y: bottom;
	<?php endif;?>
}

.dipi-author-section .dipi-author-right p {
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_author_desc_font_select)), 'html'); ?>
    font-weight: <?php echo esc_html($blog_author_desc_font_weight); ?>;
    font-size: <?php echo esc_html($blog_author_desc_font_size); ?>px;
    letter-spacing: <?php echo esc_html($blog_author_desc_text_spacing); ?>px;
    color: <?php echo esc_html($blog_author_desc_font_color); ?>;
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_author_desc_font_style")); ?>
}
</style>

<?php
// Author Image
$blog_author_image_size = DIPI_Customizer::get_option('blog_author_image_size'); //FIXME: Hier hatten wir einen Defaul Wert von 80, wie machen wir das nun?
$blog_author_image_border_radius = DIPI_Customizer::get_option('blog_author_image_border_radius');
$blog_author_image_border_width = DIPI_Customizer::get_option('blog_author_image_border_width');
$blog_author_image_border_color = DIPI_Customizer::get_option('blog_author_image_border_color');

$blog_author_image_shadow = DIPI_Customizer::get_option('blog_author_image_shadow');
$blog_author_image_shadow_color = DIPI_Customizer::get_option('blog_author_image_shadow_color');
$blog_author_image_shadow_offset = DIPI_Customizer::get_option('blog_author_image_shadow_offset');
$blog_author_image_shadow_blur = DIPI_Customizer::get_option('blog_author_image_shadow_blur');
?>

<style type="text/css">
.dipi-author-section .dipi-author-left img {
    width: <?php echo esc_html($blog_author_image_size); ?>px;
    height: <?php echo esc_html($blog_author_image_size); ?>px;
    border-radius: <?php echo esc_html($blog_author_image_border_radius); ?>px;
    border-width: <?php echo esc_html($blog_author_image_border_width); ?>px;
    border-color: <?php echo esc_html($blog_author_image_border_color); ?>;
    border-style: solid;
    <?php if ($blog_author_image_shadow): ?>
    box-shadow:0px <?php echo esc_html($blog_author_image_shadow_offset); ?>px <?php echo esc_html($blog_author_image_shadow_blur); ?>px <?php echo esc_html($blog_author_image_shadow_color); ?>;
    <?php endif;?>
}

<?php $total_left_width = $blog_author_image_size + 30;?>
.dipi-author-right {
    width: calc(100% - <?php echo esc_html($total_left_width); ?>px);
}

</style>

<?php
// Author box
$blog_author_box_content_alignment = DIPI_Customizer::get_option('blog_author_box_content_alignment');
//Box Background
$blog_author_background_image = DIPI_Customizer::get_option('blog_author_background_image');
$blog_author_background_color = DIPI_Customizer::get_option('blog_author_background_color');
$blog_author_background_image_size = DIPI_Customizer::get_option('blog_author_background_image_size');
$blog_author_background_image_repeat = DIPI_Customizer::get_option('blog_author_background_image_repeat');
$blog_author_background_image_position = DIPI_Customizer::get_option('blog_author_background_image_position');
$blog_author_box_padding = DIPI_Customizer::get_option('blog_author_box_padding');
$blog_author_box_border_radius = DIPI_Customizer::get_option('blog_author_box_border_radius');
$blog_author_box_border = DIPI_Customizer::get_option('blog_author_box_border');
$blog_author_box_border_color = DIPI_Customizer::get_option('blog_author_box_border_color');
?>

<style type="text/css">

	.dipi-author-section .dipi-author-row {
		background-color: <?php echo esc_html($blog_author_background_color); ?>;
		<?php if ($blog_author_background_image && filter_var($blog_author_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($blog_author_background_image) ?>) !important;
		<?php endif; ?>		
		<?php if ('cover' === $blog_author_background_image_size): ?>
		background-size: cover;
		<?php elseif ('fit' === $blog_author_background_image_size): ?>
		background-size: contain;
		<?php elseif ('actual' === $blog_author_background_image_size): ?>
		background-size: auto auto ;
		<?php endif;?>
		<?php if ('no-repeat' === $blog_author_background_image_repeat): ?>
		background-repeat: no-repeat ;
		<?php elseif ('repeat' === $blog_author_background_image_repeat): ?>
		background-repeat: repeat ;
		<?php elseif ('repeat-x' === $blog_author_background_image_repeat): ?>
		background-repeat: repeat-x;
		<?php elseif ('repeat-y' === $blog_author_background_image_repeat): ?>
		background-repeat: repeat-y;
		<?php endif;?>
		<?php if ('top_left' === $blog_author_background_image_position): ?>
		background-position-x: left;
		background-position-y: top;
		<?php elseif ('top_center' === $blog_author_background_image_position): ?>
		background-position-x: center;
		background-position-y: top;
		<?php elseif ('top_right' === $blog_author_background_image_position): ?>
		background-position-x: right;
		background-position-y: top;
		<?php elseif ('center_left' === $blog_author_background_image_position): ?>
		background-position-x: left;
		background-position-y: center;
		<?php elseif ('center_center' === $blog_author_background_image_position): ?>
		background-position-x: center;
		background-position-y: center;
		<?php elseif ('center_right' === $blog_author_background_image_position): ?>
		background-position-x: right;
		background-position-y: center;
		<?php elseif ('bottom_left' === $blog_author_background_image_position): ?>
		background-position-x: left;
		background-position-y: bottom;
		<?php elseif ('bottom_center' === $blog_author_background_image_position): ?>
		background-position-x: center;
		background-position-y: bottom;
		<?php elseif ('bottom_right' === $blog_author_background_image_position): ?>
		background-position-x: right;
		background-position-y: bottom;
		<?php endif;?>
	    padding: <?php echo esc_html($blog_author_box_padding); ?>px;
	    border-radius: <?php echo esc_html($blog_author_box_border_radius); ?>px;
	    border-width: <?php echo esc_html($blog_author_box_border); ?>px;
	    border-color: <?php echo esc_html($blog_author_box_border_color); ?>;
	}

	<?php if ('center' === $blog_author_box_content_alignment): ?>
		.dipi-author-section .dipi-author-row {
	    flex-direction: column !important;
	    text-align: center !important;
			align-items: center;
	  }
	  .dipi-author-left {
		  width: 100% !important;
		  margin-right: 0px !important;
		}
		.dipi-author-right {
			width: 100% !important;
		}

		.dipi-author-section .dipi-author-right h3 {
			padding-top: 30px;
		}

	<?php elseif ('right' === $blog_author_box_content_alignment): ?>
		.dipi-author-section .dipi-author-row {
	    flex-direction: row-reverse !important;
	  }
	  .dipi-author-left {
		  margin-right: 0px !important;
		  margin-left: 30px !important;
		}
	<?php endif;?>

</style>

<?php
// Author box shadow
$blog_author_box_shadow = DIPI_Customizer::get_option('blog_author_box_shadow');
$blog_author_box_shadow_color = DIPI_Customizer::get_option('blog_author_box_shadow_color');
$blog_author_box_shadow_offset = DIPI_Customizer::get_option('blog_author_box_shadow_offset');
$blog_author_box_shadow_blur = DIPI_Customizer::get_option('blog_author_box_shadow_blur');

?>
<style type="text/css">
	.dipi-author-section .dipi-author-row {
		<?php if ($blog_author_box_shadow): ?>
			box-shadow: 0px <?php echo esc_html($blog_author_box_shadow_offset); ?>px <?php echo esc_html($blog_author_box_shadow_blur); ?>px <?php echo esc_html($blog_author_box_shadow_color); ?>;
		<?php endif;?>
	}
</style>
<!-- TODO: Instead of adding the class via JS, we should add it directly via PHP -->
<?php if (is_single()): ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const body = document.body;
		if (body && body.classList.contains('et-tb-has-template') && body.classList.contains('et-tb-has-body')) {
			const author_rows = document.getElementsByClassName('dipi-author-row');
			const len = author_rows !== null ? author_rows.length : 0;
			var i = 0;
			for(i; i < len; i++) {
				author_rows[i].classList.add('et_pb_row'); 
			}
		}
	});
</script>
<?php endif;?>