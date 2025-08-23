<?php

class  DSWC_WoocommerceCarousel_Child extends ET_Builder_Module {

	static $TYPES;

	public $slug       = 'dswc_woocommerce_carousel_child';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://gitlab.com/aspengrovestudios/woocommerce-carousel-for-divi',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name            = esc_html__( 'WooCommerce Carousel Component', 'dswc-woocommerce-carousel-for-divi' );
		$this->type            = 'child';
		$this->child_title_var = 'item_title';
		$this->advanced_fields = false;
		
		$this->custom_css_tab = false;
		
		/*
		$this->advanced_fields = array(
			'link_options' => false,
			'background' => false,
			'text' => false,
			'fonts' => false,
			'max_width' => false,
			'height' => false,
			'margin_padding' => false,
			'borders' => false,
			'box_shadow' => false,
			'filters' => false,
			'transform' => false,
			'overflow' => false,
		);
		*/

		self::$TYPES = array(
			'title'   => esc_html__( 'Title', 'dswc-woocommerce-carousel-for-divi' ),
			'badge'   => esc_html__( 'Sale Badge', 'dswc-woocommerce-carousel-for-divi' ),
			'image'   => esc_html__( 'Featured Image', 'dswc-woocommerce-carousel-for-divi' ),
			'ratings' => esc_html__( 'Ratings', 'dswc-woocommerce-carousel-for-divi' ),
			'price'   => esc_html__( 'Price', 'dswc-woocommerce-carousel-for-divi' ),
			'button'  => esc_html__( 'Button', 'dswc-woocommerce-carousel-for-divi' ),
		);
	}

	function get_fields() {
		
		$fields = array(

			'item'       => array(
				'label'       => esc_html__( 'Choose Item', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'none',
				'options'     =>  array_merge( array('none' => '-'), self::$TYPES ),
				'description' => __( 'Choose item to display.', 'dswc-woocommerce-carousel-for-divi' ),
			),

			'item_title' => array(
				'label'       => '',
				'type'        => 'dswc_value_mapper',
				'sourceField' => 'item',
				'valueMap'    => self::$TYPES,
			),
		);

		return $fields;
	}

	public function render( $attrs, $content = null, $render_slug = '' ) {

		$order_class = self::get_module_order_class( $render_slug );
		// main module output
		$output = sprintf(
			'<h1>%1$s</h1>',
			esc_html( $this->props['item'] )
		);

		return $output;
	}

	protected function _render_module_wrapper( $output = '', $render_slug = '' ) {
		return $output;
	}
}

new DSWC_WoocommerceCarousel_Child();
