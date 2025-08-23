<?php
class  AGS_Divi_WC_ModuleShop_Child extends ET_Builder_Module {

	static $TYPES;

	use DSWCP_Module;

	public $slug       = 'ags_woo_shop_plus_child';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name            = esc_html__( 'Woo Shop + Component', 'divi-shop-builder' );
		$this->type            = 'child';
		$this->child_title_var = 'item_title';

		// woocommerce-carousel-for-divi\includes\modules\WoocommerceCarousel-child\WoocommerceCarousel-child.php
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



		self::$TYPES = apply_filters('dswcp_woo_shop_item_types', array(
			'sale-badge'   => esc_html__( 'Sale Badge', 'divi-shop-builder' ),
			'new-badge'   => esc_html__( 'New Badge', 'divi-shop-builder' ),
			'percentage-sale-badge'   => esc_html__( '% off Badge', 'divi-shop-builder' ),
			'image' => esc_html__( 'Featured Image', 'divi-shop-builder' ),
			'title'          => esc_html__( 'Title', 'divi-shop-builder' ),
			'sku'          => esc_html__( 'SKU', 'divi-shop-builder' ),
			'ratings'        => esc_html__( 'Ratings', 'divi-shop-builder' ),
			'price'          => esc_html__( 'Price', 'divi-shop-builder' ),
			'quantity'           => esc_html__( 'Add to cart quantity', 'divi-shop-builder' ),
			'button'           => esc_html__( 'Add to cart', 'divi-shop-builder' ),
			'categories'           => esc_html__( 'Categories', 'divi-shop-builder' ),
			'stock'           => esc_html__( 'Stock', 'divi-shop-builder' ),
			'excerpt'           => esc_html__( 'Description', 'divi-shop-builder' ),
			'attribute'           => sprintf( esc_html__('%s [PRO]', 'divi-shop-builder'), esc_html__( 'Product Attribute', 'divi-shop-builder' ) ),
			'taxonomy'           => sprintf( esc_html__('%s [PRO]', 'divi-shop-builder'), esc_html__( 'Custom Product Taxonomy', 'divi-shop-builder' ) ),
		));
	}


	function get_fields() {

		// Based on woocommerce\includes\admin\meta-boxes\views\html-product-data-attributes.php
		$productAttributes = [];

		// Array of defined attribute taxonomies.
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		
		if ( ! empty($attribute_taxonomies) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				$attribute_taxonomy_name                       = wc_attribute_taxonomy_name($tax->attribute_name);
				$label                                         = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;
				$productAttributes[ $attribute_taxonomy_name ] = $label;
			}
		}

		$custom_taxonomies = array_diff(dswcp_get_product_taxonomies(), array_keys($productAttributes), ['product_cat', 'product_tag']);
		
		$fields = array(

			'item' => array(
				'label'       => esc_html__( 'Choose Item', 'divi-shop-builder' ),
				'type'        => 'select',

				// woocommerce-carousel-for-divi\includes\modules\WoocommerceCarousel-child\WoocommerceCarousel-child.php
				'default'     => 'none',
				'options'     =>  array_merge( array('none' => '-'), self::$TYPES ),

				'description' => esc_html__( 'Choose item to display.', 'divi-shop-builder' ),
			),

			'item_title' => array(
				'label'        => '',
				'type'         => 'ags_divi_wc_value_mapper-DSB',
				'sourceField'  => 'item',
				'valueMap'     => self::$TYPES,
			),
			
			'attribute'                  => array(
				'label'            => esc_html__('Choose Attribute', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_merge(array('none' => '-'), $productAttributes),
				'description'      => esc_html__('Choose an attribute to display.', 'divi-shop-builder'),
				'default'          => 'none',
				'show_if'          => array(
					'item' => 'attribute',
				),
			),
			'taxonomy'                  => array(
				'label'            => esc_html__('Choose Taxonomy', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_merge(array('none' => '-'), array_map('esc_html', array_combine($custom_taxonomies, $custom_taxonomies))),
				'description'      => esc_html__('Choose a taxonomy to display.', 'divi-shop-builder'),
				'default'          => 'none',
				'show_if'          => array(
					'item' => 'taxonomy',
				),
			),
			'separator'            => array(
				'label'            => esc_html__('Separator', 'divi-shop-builder'),
				'description'      => esc_html__('If there are multiple values for the product, specify a separator to use to create a list.', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'default'          => ', ',
				'show_if'          => array(
					'item' => ['attribute', 'taxonomy'],
				),
			),
			'format'       => array(
				'label'            => esc_html__('Display Format', 'divi-shop-builder'),
				'description'      => esc_html__('Customize how the item is displayed. %s will be replaced with the value(s) for the product. For example, Brand: %s.', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'default'          => '%s',
				'show_if'          => array(
					'item' => ['attribute', 'taxonomy'],
				),
			),
		);

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		return '';
	}

	protected function _render_module_wrapper( $output = '', $render_slug = '' ) {
		return $output;
	}
}

new AGS_Divi_WC_ModuleShop_Child();
