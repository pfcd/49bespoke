<?php
/**
 * Wrapper class for enqueueing scripts and styles
 *
 * @since WC Booster 1.0
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 */
if( !class_exists( 'WC_Booster_Theme_Script' ) ){
	class WC_Booster_Theme_Script {

		public $scripts = [];

		public $config = [];

		public function __construct( $args ){
			
			$this->path = $args[ 'path' ];

			$defaults = array(
				'hook' => 'wp_enqueue_scripts',
				'type' => 'minified',
				'path' => false
			);

			$this->config = wp_parse_args( $args, $defaults );
			
			add_action( $this->config[ 'hook' ], array( $this, 'enqueue' ) );
		}

		public function load( $scripts ){
			$this->scripts = $scripts;
		}

		public function enqueue() {
			foreach( $this->scripts as $script ) {

				if( isset( $script[ 'handle' ] ) ) {

					if( isset( $script[ 'path' ] ) ){
						$this->config[ 'path' ] = $script[ 'path' ];
					}

					$this->script = $script;
					if( isset( $script[ 'style' ] ) ) {
						$this->enqueue_style();
					}

					if( isset( $script[ 'script' ] ) ) {
						$this->enqueue_script();
					}
				}
			}
		}

		public function get_uri( $type = 'style' ) {
			$src = $this->script[ $type ];

			if( isset( $this->script[ 'absolute' ] ) ){
				return $src;
			}else{

				if( isset( $this->script[ 'minified' ] ) && false == $this->script[ 'minified' ] ){
					return $this->config[ 'path' ] . '/' . $src;
				}
				
				if( 'minified' == $this->config[ 'type' ] ){

					if( 'style' == $type ){
						$src = str_replace( '.css', '.min.css', $src );
					}else{
						$src = str_replace( '.js', '.min.js', $src );
					}
				}

				return $this->config[ 'path' ] . '/' . $src;
			}
		}

		public function get_version() {
			return isset( $this->script[ 'version' ] ) ? $this->script[ 'version' ] : false;
		}

		public function get_dependency() {
			return isset( $this->script[ 'dependency' ] ) ? $this->script[ 'dependency' ] : [];
		}

		public function enqueue_style() {
			$dependency = isset( $this->script[ 'dependency' ] ) ? $this->script[ 'dependency' ] : [];
			wp_enqueue_style( $this->script[ 'handle' ], $this->get_uri(), $this->get_dependency(), $this->get_version() );
		}

		public function enqueue_script() {

			$dependency = isset( $this->script[ 'dependency' ] ) ? $this->script[ 'dependency' ] : [ 'jquery' ];
			$in_footer = isset( $this->script[ 'footer' ] ) ? isset( $this->script[ 'footer' ] ) : false;

			wp_enqueue_script( $this->script[ 'handle' ], $this->get_uri( 'script' ), $dependency, $this->get_version(), $in_footer );

			if ( isset( $this->script[ 'localize' ] ) && count( $this->script[ 'localize' ] ) > 0 ) {
				wp_localize_script( 
					$this->script[ 'handle' ], 
					$this->script[ 'localize' ][ 'key' ], 
					$this->script[ 'localize' ][ 'data' ] 
				);
			}
		}
	}
}