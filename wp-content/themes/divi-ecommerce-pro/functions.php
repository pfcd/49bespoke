<?php
/*
 * Based on code copied from and/or based on Divi and WooCommerce
 * See the license.txt file in the root directory for more information and licenses
 *
 */

update_option ('agstheme_divi-ecommerce-pro_license_key_status', 'valid');
update_option ('agstheme_divi-ecommerce-pro_license_key', '*********');
update_option ('agstheme_divi-ecommerce-pro_license_key_expiry', '2550450570');


define('AGS_THEME_DIRECTORY', dirname(__FILE__) . '/');
define('AGS_THEME_VERSION', wp_get_theme()->get('Version'));

/**
 * Load translations for Divi Ecommerce Pro
 */

function divi_ecommerce_pro_setup() {
    $path = get_stylesheet_directory() . '/languages';
    load_child_theme_textdomain('divi-ecommerce-pro', $path);
}

add_action('after_setup_theme', 'divi_ecommerce_pro_setup');

/* Include AGS admin functions */
include(AGS_THEME_DIRECTORY . '/admin/admin-functions.php');

include(AGS_THEME_DIRECTORY . '/admin/update-footer.php');

/**
 * Enqueue child theme stylesheets
 */

function divi_ecommerce_pro_configuration() {
    // Stylesheets
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_deregister_style('divi-style');
    wp_enqueue_style('divi-style', get_stylesheet_uri(), array(), AGS_THEME_VERSION);

    wp_enqueue_style('child-theme-style', get_stylesheet_directory_uri() . '/scss/app.css');
    wp_enqueue_style('customizer-style', get_stylesheet_directory_uri() . '/customizer/customizer.css');

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('mobile-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js');
}

add_action('wp_enqueue_scripts', 'divi_ecommerce_pro_configuration');

/**
 * WooCommerce hooks & functions
 */

if (class_exists('Woocommerce')) {
    require_once(AGS_THEME_DIRECTORY . '/woocommerce/wc-function-hooks.php');
}

/**
 *  Add child theme color scheme
 *  Create new tab in wordpress customizer
 */

@include(AGS_THEME_DIRECTORY . 'customizer/customizer.php');

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
    @include(AGS_THEME_DIRECTORY . '/customizer/woocommerce-customizer.php');
}

/**
 * Register WooCommerce Sidebar
 */

function divi_ecommerce_pro_register_sidebars() {
    register_sidebar(
        array(
            'id'            => 'diviecommercepro-woo-sidebar',
            'name'          => esc_html__('WooCommerce Sidebar', 'divi-ecommerce-pro'),
            'description'   => esc_html__('This is the WooCommerce shop sidebar', 'divi-ecommerce-pro'),
            'before_widget' => '<div id="%1$s" class="et_pb_widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widgettitle">',
            'after_title'   => '</h4>',
        )
    );
}

add_action('widgets_init', 'divi_ecommerce_pro_register_sidebars');

/**
 *  Breadcrumbs template
 *
 * Shortcode:
 * [navxt-breadcrumbs]
 */

function divi_ecommerce_pro_breadcrumbs() {
    ob_start();

    if (function_exists('bcn_display')) {
        echo '<div class="navxt-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
        bcn_display();
        echo '</div>';
    }

    return ob_get_clean();
}

/**
 * Post categories list
 *
 * Shortcode:
 * [dsdep-blog-categories]
 */

function divi_ecommerce_pro_categories_list() {
    ob_start();

    echo '<ul class="dsdep-categories-list">';
    wp_list_categories(array(
        'orderby'         => 'name',
        'hide_empty'      => true,
        'title_li'        => '',
        'show_option_all' => esc_html__('All news', 'divi-ecommerce-pro'),
    ));
    echo '</ul>';

    return ob_get_clean();
}

/**
 * Registration of shortcodes
 */
add_action('init', 'divi_ecommerce_pro_register_shortcodes');

function divi_ecommerce_pro_register_shortcodes() {
    add_shortcode('navxt-breadcrumbs', 'divi_ecommerce_pro_breadcrumbs');
    add_shortcode('dsdep-blog-categories', 'divi_ecommerce_pro_categories_list');
}

/**
 * Add custom body classes
 */

function divi_ecommerce_pro_custom_body_classes($classes) {
    if (!is_user_logged_in()) {
        $classes[] = 'user-logged-out';
    }
    return $classes;
}

add_filter('body_class', 'divi_ecommerce_pro_custom_body_classes');

/* --------------------------------------------------
 * Hide category product count in product archives *
 ------------------------------------------------- */
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );

/* --------------------------------------------------
 * turn off blocks in widgets *
 ------------------------------------------------- */
add_filter( 'use_widgets_block_editor', '__return_false' );
