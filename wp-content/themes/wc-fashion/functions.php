<?php 
if ( ! function_exists( 'wc_fashion_support' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	function wc_fashion_support() {
		add_editor_style(get_template_directory_uri().'/assets/css/editor.css');
		load_theme_textdomain( 'wc-fashion', get_template_directory() . '/languages' );
		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for post thumbnails
		add_theme_support( 'post-thumbnails' );

	}

endif;
add_action( 'after_setup_theme', 'wc_fashion_support' );

if ( ! function_exists( 'wc_fashion_enqueue_scripts_and_styles' ) ) :
	/**
	 * Enqueue styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wc_fashion_enqueue_scripts_and_styles() {
		$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$version = wp_get_theme()->get('version');
		$template_dir = get_template_directory_uri();
		$template_assets_dir = $template_dir . '/assets';

		// Styles
		$styles = array(
			'wc-fashion-style'         => array(get_stylesheet_uri(), array(), $version),
			'wc-fashion-custom-css'    => array($template_assets_dir . '/css/custom.css', array(), $version),
			'wc-fashion-editor-css'    => array($template_assets_dir . '/css/editor.css', array(), $version),
			'wc-fashion-fontawesome'   => array($template_assets_dir . '/css/font-awesome/css/all.css', array(), "5.15.3")	
		);

		// Scripts
		$scripts = array(
			'wc-fashion-custom'  => array($template_assets_dir . '/js/custom.js', array('jquery'), '1.0.0', true),
		);

		// Enqueue Styles
		foreach ($styles as $handle => $data) {
			list($src, $deps, $ver) = $data;
			wp_enqueue_style($handle, $src, $deps, $ver);
		}

		// Enqueue Scripts
		foreach ($scripts as $handle => $data) {
			list($src, $deps, $ver, $in_footer) = $data;
			wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
		}
	}

endif;

add_action('wp_enqueue_scripts', 'wc_fashion_enqueue_scripts_and_styles');

// admin style
function wc_fashion_admin_styles() {
	wp_enqueue_style(
		'wc-fashion-admin-style',
		get_template_directory_uri() . '/assets/css/theme-info.css',
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'admin_enqueue_scripts', 'wc_fashion_admin_styles' );


/* PreLoader */

add_action( 'wp_body_open', 'wc_fashion_preloader' );

/**
 * Adds the Preloader
 *
 * @since  1.0
 *
 * @package WC Fashion WordPress Theme
 */
 function wc_fashion_preloader() {

 	?>
 	<div id="loader-wrapper">
 		<div id="loader"></div>
 	</div>
 	<?php
 }



function enqueue_dashicons() {
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');


require get_theme_file_path( '/inc/tgm-plugin/tgmpa-hook.php' );

// admin Info
require get_template_directory() . '/class/admin-info.php';
