<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WC Booster
 * @since 1.0.0
 */

define( 'WC_BOOSTER_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'WC_BOOSTER_DIR', trailingslashit( get_template_directory_uri() ) );

if( !class_exists( 'WC_Booster_Theme' ) ){
    class WC_Booster_Theme{

        protected static $instance = null;

        public static function get_instance(){
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct(){

            add_action( 'after_setup_theme', array( $this, 'wc_booster_setup' ) );
            add_filter( 'excerpt_length', array( $this, 'wc_booster_excerpt_length' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'load_dashicons_front_end') );
            add_filter( 'post_thumbnail_html', array( $this, 'wc_booster_fallback_post_thumbnail_html' ), 5, 3 );

            $modules = array( 
                'script',
                'admin-info'
            );

            $this->require( $modules );

            $modules = array( 
                'script-loader',
                'pattern-category'
            );
            $this->require( $modules, 'inc' );

            $modules = array( 
                'tgmpa-hook'
            );
            $this->require( $modules, 'inc/tgm-plugin' );

            add_action('enqueue_block_assets', function (): void {
                wp_enqueue_style('dashicons');
            });

        }

        /**
         * Add theme support.
         */
        public function wc_booster_setup() {

            load_theme_textdomain( 'wc-booster', get_template_directory() . '/languages' );

             // Add support for block styles.
            add_theme_support( 'wp-block-styles' );
            add_theme_support( 'editor-styles' );
            add_editor_style( 'assets/css/style-editor.css' );

        }

        public function wc_booster_excerpt_length( $length ){ 

            $excerpt_length = 20;
            if ( is_admin() ) return $length;
            return $excerpt_length;
        }
        
         /**
         * Set the default image if none exists.
         *
         * @param string $html              The post thumbnail HTML.
         * @param int    $post_id           The post ID.
         * @param int    $post_thumbnail_id The post thumbnail ID.
         * @return html
         */
        public function wc_booster_fallback_post_thumbnail_html( $html, $post_id, $post_thumbnail_id ) {
            if ( empty( $html ) ) {
               $html = '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/default-image.jpg" loading="lazy" alt="' . get_the_title( $post_id ) . '" class="default-img"/>';
            }

            return $html;
        }


        public function require( $files, $base = 'class' ) { 
            foreach( $files as $file ) {
                $path = $base . '/' . $file . '.php';
                require_once get_theme_file_path( $path );
            }
        }

        public function load_dashicons_front_end() {
          wp_enqueue_style( 'dashicons' );
        }

    }
}

if( !function_exists( "wc_booster_theme" ) ){
    function wc_booster_theme(){
        return WC_Booster_Theme::get_instance();
    }
    wc_booster_theme();
}

remove_filter( 'the_content', 'wpautop' );



