<?php 
namespace DiviPixel;

/**
 * Custom 404 Page
 *
 * @since 1.0.0
 * @package Divi Pixel
 */

$select_error_page = DIPI_Settings::get_option( 'select_error_page', '-1');
if($select_error_page == '-1' ) {
	return;
}

$hide_header = DIPI_Settings::get_option( 'error_page_header');
?>


<?php if($hide_header): ?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php
		elegant_description();
		elegant_keywords();
		elegant_canonical();
		do_action( 'et_head_meta' );
	?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<script type="text/javascript">
			document.documentElement.className = 'js';
		</script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<div id="page-container">
		<div id="et-main-area">
			<?php do_action( 'et_before_main_content' ); ?>
		</div><!-- #et-main-area -->
	</div><!-- #page-container -->
<?php else: ?>
	<?php get_header(); ?>
<?php endif; ?>


<div id="main-content">
	<article id="post-0" <?php post_class( 'et_pb_post not_found' ); ?>>
		<?php echo do_shortcode('[et_pb_section global_module="' . $select_error_page . '"][/et_pb_section]'); ?>
	</article>
</div>


<?php
if(DIPI_Settings::get_option( 'error_page_footer')) {
	wp_footer();
} else {
	get_footer();
}