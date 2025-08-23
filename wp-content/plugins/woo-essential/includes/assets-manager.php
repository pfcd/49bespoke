<?php

namespace DNWoo_Essential\Includes;

defined( 'ABSPATH' ) || die();

class AssetsManager {

    /**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

    /**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function __construct() {

        add_action( 'wp_enqueue_scripts', array( $this, 'dnwoo_enqueue_assets' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'dnwoo_admin_enqueue_assets' ) );

    }

    public function get_module_styles() {
        return array(
            'dnwoo_product_carousel' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooCarousel/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_cat_accordion' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooCatAccordion/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_cat_carousel' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooCatCarousel/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_cat_grid' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooCatGrid/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_cat_masonry' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooCatMasonry/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_product_masonry' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooFilterMasonry/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_product_grid' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooGrid/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_product_accordion' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooProductAccordion/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_module_mini_cart' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooMiniCart/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_module_ajax_search_input' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooAjaxSearch/input.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_module_ajax_search' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooAjaxSearch/style.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_module_ajax_category' => array(
                'src'               =>  DNWOO_ESSENTIAL_ICON . 'NextWooAjaxSearch/category.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            // "dnwoo_builder"         => array(
            //     'src'               =>  DNWOO_ESSENTIAL_URL . '/styles/builder-style.min.css',
            //     'version'           =>  DNWOO_ESSENTIAL_VERSION,
            //     'enqueue'           =>  false
            // )
        );
    }

    public function get_styles() {
        return array(
            'dnwoo_swiper-min'      =>  array(
                'src'               =>  DNWOO_ESSENTIAL_ASSETS . 'css/swiper.min.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_magnific-popup'      =>  array(
                'src'               =>  DNWOO_ESSENTIAL_ASSETS . 'css/magnific-popup.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_pagination'      =>  array(
                'src'               =>  DNWOO_ESSENTIAL_ASSETS . 'css/dnwoo.pagination.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
            'dnwoo_quickview_modal'      =>  array(
                'src'               =>  DNWOO_ESSENTIAL_ASSETS . 'css/quickview-modal.css',
                'version'           =>  DNWOO_ESSENTIAL_VERSION,
                'enqueue'           =>  false
            ),
        );
    }

    public function get_scripts() {
        return array(
            'dnwoo_swiper_frontend'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS . 'js/swiper.min.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'             =>  true
            ),
            'dnwoo_imagesloaded'=>  array(
                'src'           =>  DNWOO_ESSENTIAL_ASSETS . 'js/imagesloaded.pkgd.min.js',
                'version'       =>  DNWOO_ESSENTIAL_VERSION,
                'deps'          =>  array( 'jquery' ),
                'enqueue'       =>  false,
                'priority'        =>  false
            ),
            'dnwoo_isotope_frontend'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS . 'js/isotope.min.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-magnific-popup'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/magnific-popup.min.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-isotope-activation'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/isotope-activation.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-image-accordion'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.accordion.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-cat-carousel'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.catCarousel.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-product-carousel'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.productCarousel.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-minicart'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.minicart.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-pagination'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.pagination.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array('jquery'),
                'enqueue'            =>  false,
                'priority'           =>  true
            ),
            'dnwoo-pagination-activation'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.pagination-activation.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array('jquery'),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-ajax-search'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.ajaxSearch.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array('jquery'),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo-ajax-category'  =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS. 'js/dnwoo.ajax-category.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array('jquery'),
                'enqueue'            =>  false,
                'priority'           =>  false
            ),
            'dnwoo_scripts-public'   =>  array(
                'src'                =>  DNWOO_ESSENTIAL_ASSETS . 'js/scripts.js',
                'version'            =>  DNWOO_ESSENTIAL_VERSION,
                'deps'               =>  array( 'jquery' ),
                'enqueue'            =>  true,
                'priority'           =>  true
            )
        );
    }

    public function dnwoo_enqueue_assets() {
        $styles = $this->get_styles();
        $module_styles = $this->get_module_styles();
        $scripts = $this->get_scripts();

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            if ( $style['enqueue'] ) {
                wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
            }elseif ( $style['enqueue'] == false ) {
                wp_register_style( $handle, $style['src'], $deps, $style['version'] );
            }
        }
        
        foreach ( $module_styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            if ( $style['enqueue'] ) {
                wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
            }elseif ( $style['enqueue'] == false ) {
                wp_register_style( $handle, $style['src'], $deps, $style['version'] );
            }
        }

        foreach ($scripts as $handle => $script ) {
            $deps   = isset( $script['deps'] ) ? $script['deps']  : false;
            if ( $script['enqueue'] ) {
                wp_enqueue_script(  $handle, $script['src'], $deps, $script['version'], $script['priority'] );
            }elseif ( $script['enqueue'] == false ) {
                wp_register_script(  $handle, $script['src'], $deps, $script['version'], $script['priority'] );
            }
        }

        if((isset($_GET['et_fb']) && sanitize_text_field($_GET['et_fb']) == '1') || (isset( $_GET['page']) && 'et_theme_builder' === $_GET['page'])):// phpcs:ignore
            $src = DNWOO_ESSENTIAL_URL . '/styles/builder-style.min.css';
            wp_enqueue_style('dnwoo_builder',$src, array(), null, 'all');
        endif;

        wp_localize_script(
            'dnwoo_scripts-public',
            'Woo_Essential',
            array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
        );
    }

    public function dnwoo_admin_enqueue_assets() {

        wp_verify_nonce('dnwoo_admin_module_css');

        global $pagenow;

        if ( ( "admin.php" === $pagenow ) && ( isset( $_GET['page']) && 'et_theme_builder' === $_GET['page'] ) && et_core_is_fb_enabled() ) {
            $src = plugin_dir_url( __FILE__ ) . '../styles/admin-module.css';
            wp_enqueue_style('dnwoo_admin_module_css', $src, array(), null, 'all' );
        }
    }
}
AssetsManager::get_instance();