<?php
namespace DiviPixel;

// TODO: Refactor this partial. There are unnecessarily many css snippets and everything is a bit cluttered

$archive_btn_padding = DIPI_Customizer::get_option('archive_btn_padding');
$archive_btn_margin = DIPI_Customizer::get_option('archive_btn_margin');
$archive_btn_border_radius = DIPI_Customizer::get_option('archive_btn_border_radius');
$archive_btn_border_width = DIPI_Customizer::get_option('archive_btn_border_width');
?>
<style type="text/css">
	.dipi-read-more-wrap {
		margin-top: <?php echo esc_html($archive_btn_margin); ?>px !important;
	}
	
	.dipi-read-more-button {
	  transition: all .3s ease-in-out;
		border-style: solid;
		border-width: <?php echo esc_html($archive_btn_border_width); ?>px !important;
		border-radius: <?php echo esc_html($archive_btn_border_radius); ?>px !important;
		padding: <?php echo esc_html($archive_btn_padding); ?>px !important;
	}

	.dipi-read-more-button:hover {
	  transition: all .3s ease-in-out;
	}

	.dipi-read-more-button:after {
	  transition: all .3s ease-in-out;
	}

	.dipi-read-more-button:hover:after {
	  transition: all .3s ease-in-out;
	}

</style>

<?php
$archive_btn_icon = DIPI_Customizer::get_option('archive_btn_icon');
$archive_btn_icon_size = DIPI_Customizer::get_option('archive_btn_icon_size');
?>
<style type="text/css">
	
	.et-pb-icon.dipi-read-more-button:after {
		content: '<?php echo esc_html($archive_btn_icon); ?>' !important;
		font-size: <?php echo esc_html($archive_btn_icon_size); ?>px !important;
	  opacity: 1;
	}

	.dipi-button-icon-always {
		padding-right: <?php echo esc_html($archive_btn_padding)+$archive_btn_icon_size; ?>px !important;
	}

	.dipi-button-icon-always:after {
	  opacity: 1;
	  margin-left: 0em;
    padding-left: 5px;
	}

	.dipi-button-icon-onhover:after {
	  opacity: 0 !important;
    padding-left: 5px;
	  margin-left: -1em;
	}

	.dipi-button-icon-onhover:hover:after {
	  opacity: 1 !important;
	  margin-left: 0em;
	}

	.dipi-button-icon-onhover:hover {
		padding-right: <?php echo esc_html($archive_btn_padding)+$archive_btn_icon_size; ?>px !important;
	}

	.dipi-button-icon-hideonhover {
		padding-right: <?php echo esc_html($archive_btn_padding)+$archive_btn_icon_size; ?>px !important;
	}
	
	.dipi-button-icon-hideonhover:after {
	  opacity: 1 !important;
	  margin-left: 0em;
    padding-left: 5px;
	}

	.dipi-button-icon-hideonhover:hover {
		padding-right: <?php echo esc_html($archive_btn_padding); ?>px !important;
	}
	
	.dipi-button-icon-hideonhover:hover:after {
	  opacity: 0 !important;
	  margin-left: -1em;
	}

</style>
<?php 
	$blog_archives_btn_font_select = DIPI_Customizer::get_option('blog_archives_btn_font_select');
	$blog_archives_btn_font_weight = DIPI_Customizer::get_option('blog_archives_btn_font_weight');
    $blog_archives_btn_font_size = DIPI_Customizer::get_option('blog_archives_btn_font_size');
	$blog_archives_btn_text_spacing = DIPI_Customizer::get_option('blog_archives_btn_text_spacing');
	$blog_archives_btn_font_color = DIPI_Customizer::get_option('blog_archives_btn_font_color');
	$blog_archives_btn_font_color_hover = DIPI_Customizer::get_option('blog_archives_btn_font_color_hover');
	$archive_btn_background = DIPI_Customizer::get_option('archive_btn_background');
	$archive_btn_background_hover = DIPI_Customizer::get_option('archive_btn_background_hover');
	$archive_btn_border_color = DIPI_Customizer::get_option('archive_btn_border_color');
	$archive_btn_border_color_hover = DIPI_Customizer::get_option('archive_btn_border_color_hover');
?>
<style type="text/css">
	.dipi-read-more-button {
		 
        <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_archives_btn_font_select)), 'html'); ?>
        font-weight: <?php echo esc_html($blog_archives_btn_font_weight); ?>;
        <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_archives_btn_font_style")); ?>
        font-size: <?php echo esc_html($blog_archives_btn_font_size); ?>px !important;
        letter-spacing: <?php echo esc_html($blog_archives_btn_text_spacing); ?>px !important;
		color: <?php echo esc_html($blog_archives_btn_font_color); ?> !important;
		background-color: <?php echo esc_html($archive_btn_background); ?> !important;
		border-color: <?php echo esc_html($archive_btn_border_color); ?> !important;
	}

	.dipi-read-more-button:hover {
		color: <?php echo esc_html($blog_archives_btn_font_color_hover); ?> !important;
		background-color: <?php echo esc_html($archive_btn_background_hover); ?> !important;
		border-color: <?php echo esc_html($archive_btn_border_color_hover); ?> !important;
	}
</style>
<?php
$archive_btn_shadow = DIPI_Customizer::get_option('archive_btn_shadow');
$archive_btn_shadow_color = DIPI_Customizer::get_option('archive_btn_shadow_color');
$archive_btn_shadow_offset = DIPI_Customizer::get_option('archive_btn_shadow_offset');
$archive_btn_shadow_blur = DIPI_Customizer::get_option('archive_btn_shadow_blur');
$archive_btn_shadow_color_hover = DIPI_Customizer::get_option('archive_btn_shadow_color_hover');
$archive_btn_shadow_offset_hover = DIPI_Customizer::get_option('archive_btn_shadow_offset_hover');
$archive_btn_shadow_blur_hover = DIPI_Customizer::get_option('archive_btn_shadow_blur_hover');
?>
<style type="text/css">
	<?php if($archive_btn_shadow) : ?>
	.dipi-read-more-button {
		box-shadow: 0px <?php echo esc_html($archive_btn_shadow_offset); ?>px <?php echo esc_html($archive_btn_shadow_blur); ?>px <?php echo esc_html($archive_btn_shadow_color); ?> !important;
	}
	.dipi-read-more-button:hover {
		box-shadow: 0px <?php echo esc_html($archive_btn_shadow_offset_hover); ?>px <?php echo esc_html($archive_btn_shadow_blur_hover); ?>px <?php echo esc_html($archive_btn_shadow_color_hover); ?> !important;
	}
	<?php endif; ?>
	
	.dipi-read-more-button-icon-only {
		width: <?php echo esc_html($archive_btn_icon_size + 25); ?>px;
		height: <?php echo esc_html($archive_btn_icon_size + 25); ?>px;
    display: flex;
    align-items: center;
    justify-content: center;
	}
	.dipi-read-more-button-icon-only:after {
		width: <?php echo esc_html($archive_btn_icon_size); ?>px;
		height: <?php echo esc_html($archive_btn_icon_size); ?>px;
    position: relative;    
    display: flex;
    align-items: center;
    justify-content: center;
	}
</style>