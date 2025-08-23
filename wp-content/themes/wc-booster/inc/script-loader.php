<?php
/**
 * Handle all the scripts here
 * 
 * @since WC Booster 1.0
 */
if( !class_exists( 'WC_Booster_Theme_Script_Loader' ) ){

    class WC_Booster_Theme_Script_Loader{

        public static $instance;

        public static function get_instance() {
            if ( ! self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

    	public function __construct(){
            
            /* load style.css */
            (new WC_Booster_Theme_Script([
                'path' => WC_BOOSTER_DIR,
                'type' => 'unminified'
            ]))->load($this->get_main_style());

            /* load theme-info.css */
            (new WC_Booster_Theme_Script([
                'hook' => 'admin_enqueue_scripts',
                'type' => 'unminified',
                'path' => WC_BOOSTER_DIR
            ]))->load($this->get_theme_info_style());

            add_action( 'init', array( $this, 'init' ) );
    		
    	}

        public function init(){

            $script = new WC_Booster_Theme_Script([
                'path' => WC_BOOSTER_DIR . 'assets',
                'type' => 'unminified'
            ]);

            
            $script->load([
                [
                    'handle' => 'main',
                    'script'  => 'js/main.js',
                    'version' => '1.0.1'
                ],
                [
                    'handle' => 'wc-booster-matchHeight',
                    'script'  => 'js/vendor/matchHeight/matchHeight.js',
                    'version' => '1.0.1'
                ]
            ]);
        }

        public function get_main_style(){
            return array(
                array(
                    'handle' => 'wc-theme-style',
                    'style'  => 'style.css'
                )
            );
        }

        public function get_theme_info_style(){
            return array(
                array(
                    'handle' => 'theme-info',
                    'style'  => 'assets/css/theme-info.css'
                )
            );
        }
    }

    WC_Booster_Theme_Script_Loader::get_instance();
}