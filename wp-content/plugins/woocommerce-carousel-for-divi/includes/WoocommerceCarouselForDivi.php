<?php

class DSWC_WoocommerceCarouselForDivi extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'dswc-woocommerce-carousel-for-divi';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = DS_Woo_Carousel::PLUGIN_SLUG;

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = DS_Woo_Carousel::PLUGIN_VERSION;

	/**
	 * DSWC_WoocommerceCarouselForDivi constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name =  DS_Woo_Carousel::PLUGIN_SLUG, $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
		add_action( 'wp_ajax_dswc_woocommerce_products_list', array( $this, 'dswc_woocommerce_products_list' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dswc_enqueue_scripts' ) );
		wp_enqueue_style( 'dswc-swiper-css', DSWC_URL . '/styles/swiper.min.css' );
	}

	public function dswc_enqueue_scripts() {
		wp_enqueue_script( 'dswc-swiper-js', DSWC_URL . '/scripts/swiper.min.js' );
		$variables = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'dswc_woocommerce_nonce' )
		);
		wp_localize_script( 'dswc-swiper-js', 'dswc_woocommerce', $variables );
		wp_enqueue_script('wc-add-to-cart');
	}

	public function dswc_woocommerce_products_list() {
		if ( ! check_ajax_referer( 'dswc_woocommerce_nonce', 'nonce', false ) ) {
			wp_send_json_error( 'Invalid security token sent.' );
		}
		$products = DS_Woo_Carousel::get_products( $_POST );
		wp_send_json( compact( 'products' ) );
	}
}

new DSWC_WoocommerceCarouselForDivi();
