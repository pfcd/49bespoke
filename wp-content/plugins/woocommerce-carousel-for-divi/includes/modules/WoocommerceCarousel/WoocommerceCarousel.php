<?php

class DSWC_WoocommerceCarousel extends ET_Builder_Module {

	public         $slug                  = 'dswc_woocommerce_carousel';
	public         $vb_support            = 'on';
	private static $allowedTitleTags      = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'strong' );
	private static $marginPaddingElements = array( // update in JSX too

	   'title'  => array(
	       'selector'        => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc_title',
	       'default_margin'  => '0px|0px|10px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   ),
	   'image'  => array(
	       'selector'        => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc-featured-image',
	       'default_margin'  => '0px|0px|10px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   ),
	   'rating' => array(
	       'selector'        => '%%order_class%% .swiper-slide.dswc_item_wrapper .star_rating_module_wrapper',
	       'default_margin'  => '0px|0px|10px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   ),
	   'price'  => array(
	       'selector'        => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc_price',
	       'default_margin'  => '0px|0px|10px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   ),
	   'sale_badge' => array(
	       'selector'        => '%%order_class%% .swiper-slide.dswc_item_wrapper .sale_badge span',
	       'default_margin'  => '0px|0px|10px|0px',
	       'default_padding' => '6px|18px|6px|18px'
	   ),
	   'arrow' => array(
	       'selector'        => '%%order_class%% .prev_icon, %%order_class%% .next_icon',
	       'default_margin'  => '0px|0px|0px|0px',
	       'default_padding' => '10px|10px|10px|10px'
	   ),
	   'pagination' => array(
	       'selector'        => '%%order_class%% .swiper-pagination',
	       'default_margin'  => '0px|0px|0px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   ),
	   'view_cart' => array(
	       'selector'        => '%%order_class%% .dswc_buttons_wrapper .added_to_cart',
	       'default_margin'  => '0px|0px|0px|0px',
	       'default_padding' => '0px|0px|0px|0px'
	   )
	);

	protected $module_credits = array(
		'module_uri' => 'https://gitlab.com/aspengrovestudios/woocommerce-carousel-for-divi/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name       = esc_html__( 'Woo Carousel', 'dswc-woocommerce-carousel-for-divi' );
		$this->child_slug = 'dswc_woocommerce_carousel_child';
		$this->icon_path  = plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->child_item_text        = esc_html__( 'WooCommerce Carousel Components', 'dswc-woocommerce-carousel-for-divi' );
		$this->main_css_element       = '%%order_class%%.dswc';
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'controls' => array(
						'title' => esc_html__( 'WooCommerce Slides Control', 'dswc-woocommerce-carousel-for-divi' ),
					),
					'settings' => array(
						'title' => esc_html__( 'WooCommerce Display Control', 'dswc-woocommerce-carousel-for-divi' ),
					),
				),
			),

			'advanced' => array(
				'toggles' => array(
					'dswc_title'      => esc_html__( 'Title', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_price'      => esc_html__( 'Price', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_sale_badge' => esc_html__( 'Sale Badge', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_image'      => esc_html__( 'Image', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_rating'     => esc_html__( 'Star Rating', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_arrow'      => esc_html__( 'Arrows', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_pagination' => esc_html__( 'Controller/Pagination', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_buttons'    => esc_html__( 'Buttons', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_view_cart'  => esc_html__( 'View Cart Link', 'dswc-woocommerce-carousel-for-divi' ),
					'dswc_no_record'  => esc_html__( 'No Record Text', 'dswc-woocommerce-carousel-for-divi' ),

				),
			),
		);

		$this->custom_css_fields = array(
			'title_wrapper_custom_css'      => array(
				'label'    => esc_html__( 'Title Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_item_wrapper ',
			),
			'title_custom_css'              => array(
				'label'    => esc_html__( 'Title', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_item_wrapper .dswc_title a',
			),
			'sale_badge_custom_css'         => array(
				'label'    => esc_html__( 'Sale Badge Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .sale_badge',
			),
			'sale_badge_span_custom_css'    => array(
				'label'    => esc_html__( 'Sale Badge', 'et_builder' ),
				'selector' => '%%order_class%% .sale_badge span',
			),
			'star_ratings_custom_css'       => array(
				'label'    => esc_html__( 'Star Rating Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .star_rating_module_wrapper',
			),
			'star_ratings_span_custom_css'  => array(
				'label'    => esc_html__( 'Star Rating', 'et_builder' ),
				'selector' => '%%order_class%% .star_rating_module_wrapper .star-rating ',
			),
			'price_custom_css'              => array(
				'label'    => esc_html__( 'Price Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_price',
			),
			'price_amount_custom_css'       => array(
				'label'    => esc_html__( 'Price Amount', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_price .amount',
			),
			'price_regular_custom_css'      => array(
				'label'    => esc_html__( 'Price Regular', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_price del',
			),
			'price_sale_custom_css'         => array(
				'label'    => esc_html__( 'Price Sale', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_price ins',
			),
			'price_symbol_custom_css'       => array(
				'label'    => esc_html__( 'Price Symbol', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_price .amount',
			),
			'img_before_custom_css'         => array(
				'label'    => esc_html__( 'Featured Image Before', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc-featured-image img:before',
			),
			'img_custom_css'                => array(
				'label'    => esc_html__( 'Featured Image', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc-featured-image img',
			),
			'img_wrapper_custom_css'        => array(
				'label'    => esc_html__( 'Featured Image Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc-featured-image',
			),
			'button_custom_css'             => array(
				'label'    => esc_html__( 'Button Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_et_pb_button_module_wrapper',
			),
			'button_a_custom_css'           => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_et_pb_button_module_wrapper a.et_bt_add_to_cart',
			),
			'button_a_hover_custom_css'     => array(
				'label'    => esc_html__( 'Button Hover', 'et_builder' ),
				'selector' => '%%order_class%% .dswc_et_pb_button_module_wrapper a.et_bt_add_to_cart:hover',
			),
			'slides_custom_css'             => array(
				'label'    => esc_html__( 'Slides', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-slide.dswc_item_wrapper',
			),
			'nav_custom_css'                => array(
				'label'    => esc_html__( 'Arrow Navigation', 'et_builder' ),
				'selector' => '%%order_class%%  .prev_icon,%%order_class%%  .next_icon',
			),
			'nav_prev_custom_css'           => array(
				'label'    => esc_html__( 'Arrow Prev Navigation', 'et_builder' ),
				'selector' => '%%order_class%%  .prev_icon',
			),
			'nav_next_custom_css'           => array(
				'label'    => esc_html__( 'Arrow Next Navigation', 'et_builder' ),
				'selector' => '%%order_class%%  .next_icon',
			),
			'pagination_wrapper_custom_css' => array(
				'label'    => esc_html__( 'Controller/Pagination Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-pagination',
			),
			'pagination_custom_css'         => array(
				'label'    => esc_html__( 'Controller/Pagination Bullet', 'et_builder' ),
				'selector' => '%%order_class%% .swiper-pagination .swiper-pagination-bullet',
			),

		);

		$this->advanced_fields = array(
			'max_width' => array(
				'css' => array(
					'main' => '%%order_class%%.et_pb_module'
				)
			),
			'fonts'     => array(
				'no_record'  => array(
					'label'       => esc_html__( 'Title Text', 'dswc-woocommerce-carousel-for-divi' ),
					'css'         => array(
						'main' => ' %%order_class%% .dswc_no_record',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_no_record',
				),
				'title'      => array(
					'label'       => esc_html__( 'Title', 'dswc-woocommerce-carousel-for-divi' ),
					'css'         => array(
						'main' => ' %%order_class%% .dswc_item_wrapper .dswc_title',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_title',
				),
				'view_cart'      => array(
					'label'       => esc_html__( 'View Cart', 'dswc-woocommerce-carousel-for-divi' ),
					'css'         => array(
						'main' => '%%order_class%% .dswc_buttons_wrapper .added_to_cart',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_view_cart',
				),
				'sale_badge' => array(
					'label'       => esc_html__( 'Sale Badge', 'dswc-woocommerce-carousel-for-divi' ),
					'css'         => array(
						'main' => '%%order_class%% .sale_badge span',
					),
					'line_height' => array(
						'default' => '1em',
					),

					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_sale_badge',
				),

				'price' => array(
					'label'       => esc_html__( 'Price Text', 'dswc-woocommerce-carousel-for-divi' ),
					'css'         => array(
						'main' => '%%order_class%% .dswc_price',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => '18px',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_price',
				),
			),

			'button' => array(
				'add_cart_button' => array(
					'label' => esc_html__( 'Button', 'dswc-woocommerce-carousel-for-divi' ),
					'css'   => array(
						'main'      => '%%order_class%% .dswc_et_pb_button_module_wrapper a.et_bt_add_to_cart',
						'alignment' => '%%order_class%% .dswc_et_pb_button_module_wrapper',
					),

					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),

					'no_rel_attr'   => true,
					'use_alignment' => true,
					'box_shadow'    => false,
				),
			),

			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
					'main'      => '%%order_class%% .swiper-slide.dswc_item_wrapper',
				),
			),

			'background' => array(
				'label' => esc_html__( 'Background Color', 'dswc-woocommerce-carousel-for-divi' ),
				'css'   => array(
					'main' => '%%order_class%% .swiper-slide.dswc_item_wrapper',
				),
			),

			'borders' => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .swiper-slide.dswc_item_wrapper',
							'border_styles' => '%%order_class%% .swiper-slide.dswc_item_wrapper',
						),
					),
				),

				'product_image'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .swiper-slide.dswc_item_wrapper img,%%order_class%% .swiper-slide.dswc_item_wrapper:hover .dswc-featured-image:before',
							'border_styles' => '%%order_class%% .swiper-slide.dswc_item_wrapper img',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_image',
				),
				'arrow_border_style' => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%%  .prev_icon,%%order_class%%  .next_icon',
							'border_styles' => '%%order_class%%  .prev_icon,%%order_class%%  .next_icon',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_arrow',
				),
			),

			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .swiper-slide.dswc_item_wrapper',
					),
				),

				'box_shadow_image' => array(
					'css' => array(
						'main' => '%%order_class%% .swiper-slide.dswc_item_wrapper img',
					),

					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dswc_image',
				),
			),

			'link_options' => false,
			'text'         => false,
		);

	}


	public function get_fields() {
		$fields = array(
			// For woocommerce data fetch properties
			'is_rtl'   => array(
				'type'     => 'hidden',
				'tab_slug' => 'general',
				'default'  => is_rtl() ? '1' : '0',
			),
			'currency' => array(
				'type'     => 'hidden',
				'tab_slug' => 'general',
				'default'  => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$',
			),

			'product_view_type'    => array(
				'label'       => esc_html__( 'Product View Type', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'recent_products',
				'options'     => array(
					'recent_products'       => esc_html__( 'Recent Products', 'dswc-woocommerce-carousel-for-divi' ),
					'featured_products'     => esc_html__( 'Featured Products', 'dswc-woocommerce-carousel-for-divi' ),
					//'sale_products'         => esc_html__( 'Sale Products', 'dswc-woocommerce-carousel-for-divi' ),
					'best_selling_products' => esc_html__( 'Best Selling Products', 'dswc-woocommerce-carousel-for-divi' ),
					'top_rated_products'    => esc_html__( 'Top Rated Products', 'dswc-woocommerce-carousel-for-divi' ),
					'products_category'     => esc_html__( 'Products Category', 'dswc-woocommerce-carousel-for-divi' ),
					'products_tag'     => esc_html__( 'Products Tag', 'dswc-woocommerce-carousel-for-divi' ),
					'all_products'          => esc_html__( 'All Products', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( 'Chose your product view type.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'products_category'    => array(
				'label'            => esc_html__( 'Category', 'dswc-woocommerce-carousel-for-divi' ),
				'type'             => 'categories',
				'option_category'  => 'basic_option',
				'taxonomy_name'    => 'product_cat',
				'meta_categories'  => array(
					'all' => esc_html__( 'All Categories', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'renderer_options' => array(
					'use_terms' => true,
					'term_name' => 'product_cat',
				),
				'show_if'          => array( 'product_view_type' => 'products_category' ),
				'description'      => esc_html__( 'Category.', 'dswc-woocommerce-carousel-for-divi' ),
				'default' => 'all'
			),
			'products_tag'    => array(
				'label'            => esc_html__( 'Tag', 'dswc-woocommerce-carousel-for-divi' ),
				'type'             => 'categories',
				'option_category'  => 'basic_option',
				'taxonomy_name'    => 'product_tag',
				'meta_categories'  => array(
					'all' => esc_html__( 'All Tags', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'renderer_options' => array(
					'use_terms' => true,
					'term_name' => 'product_tag',
				),
				'show_if'          => array( 'product_view_type' => 'products_tag' ),
				'description'      => esc_html__( 'Show products with this product tag.', 'dswc-woocommerce-carousel-for-divi' ),
				'default' => 'all'
			),
			'product_count'        => array(
				'label'          => esc_html__( 'Product Count', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'default'        => '6',
				'unitless'       => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'description'    => esc_html__( 'Product Count', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'sort_by'              => array(
				'label'       => esc_html__( 'Sort By', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'Date',
				'options'     => array(
					'date'  => esc_html__( 'Date', 'dswc-woocommerce-carousel-for-divi' ),
					'price' => esc_html__( 'Price', 'dswc-woocommerce-carousel-for-divi' ),
					'rand'  => esc_html__( 'Random', 'dswc-woocommerce-carousel-for-divi' ),
					'stock' => esc_html__( 'Stock Available', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( 'Choose sort by.', 'dswc-woocommerce-carousel-for-divi' ),
				'show_if'     => array(
					'product_view_type' => array(
						'featured_products',
						'products_category',
						'products_tag',
						'all_products'
					)
				),
			),
			'sort_dir'             => array(
				'label'       => esc_html__( 'Sort Direction', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'DESC',
				'options'     => array(
					'DESC' => esc_html__( 'Descending', 'dswc-woocommerce-carousel-for-divi' ),
					'ASC'  => esc_html__( 'Ascending', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
				'show_if'     => array(
					'product_view_type' => array(
						'featured_products',
						'products_category',
						'products_tag',
						'all_products'
					)
				),
			),
			'title_tag'            => array(
				'label'       => esc_html__( 'HTML Tag', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'h3',
				'options'     => array(
					'h1'     => 'h1',
					'h2'     => 'h2',
					'h3'     => 'h3',
					'h4'     => 'h4',
					'h5'     => 'h5',
					'h6'     => 'h6',
					'p'      => 'p',
					'strong' => 'strong',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_title',
				'description' => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
			),
			// Swiper configure properties
			'column_layout'        => array(
				'label'          => esc_html__( 'Column Layout', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'default'        => '3',
				'mobile_options' => true,
				'responsive'     => true,
				'unitless'       => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '6',
					'step' => '1',
				),
				'description'    => esc_html__( 'Column Layout.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'slide_by'             => array(
				'label'          => esc_html__( 'Slide by number of slide(s)', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'default'        => '1',
				'unitless'       => true,
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '12',
					'step' => '1',
				),
				'description'    => esc_html__( 'adjust the number of slides to slide by on each rotation.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'slide_center'         => array(
				'label'       => esc_html__( 'Active Center Slide', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( 'Center slide would be active.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'space_between'        => array(
				'label'          => esc_html__( 'Space Between slides', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'default'        => '10',
				'mobile_options' => true,
				'responsive'     => true,
				'unitless'       => true,
				'description'    => esc_html__( 'adjust space between each slide.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'equal_height'         => array(
				'label'       => esc_html__( 'Equal Height', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( 'Equal Height', 'dswc-woocommerce-carousel-for-divi' ),
			),

			'slide_elements_position'  => array(
				'label'       => esc_html__( 'Slide Elements Alignment', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'default' => esc_html__( 'Default', 'dswc-woocommerce-carousel-for-divi' ),
					'center' => esc_html__( 'Center', 'dswc-woocommerce-carousel-for-divi' ),
					'space-between' => esc_html__( 'Space Between', 'dswc-woocommerce-carousel-for-divi' ),
					'space-around' => esc_html__( 'Space Around', 'dswc-woocommerce-carousel-for-divi' ),
					'space-evenly' => esc_html__( 'Space Evenly', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'default',
				'show_if'         => array(
					'equal_height' => 'on'
				)
			),
			'loop'                 => array(
				'label'           => esc_html__( 'Loop', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'default'         => 'off',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description'     => esc_html__( 'Loop.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'mousewheel'           => array(
				'label'           => esc_html__( 'Mouse wheel', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'default'         => 'on',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description'     => esc_html__( 'Enables navigation through slides using mouse wheel.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'autoplay'             => array(
				'label'           => esc_html__( 'Autoplay', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'default'         => 'off',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description'     => esc_html__( 'Move the Slider Automatically', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'auto_speed'           => array(
				'label'           => esc_html__( 'Autoplay Speed (ms)', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'range',
				'default'         => '5000',
				'unitless'        => true,
				'range_settings'  => array(
					'min'  => '500',
					'max'  => '10000',
					'step' => '500',
				),
				'show_if'         => array(
					'autoplay' => 'on',
				),
				'description'     => esc_html__( 'Autoplay Speed', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'pause_slider'         => array(
				'label'           => esc_html__( 'Pause Autoplay on Mouse Hover', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'default'         => 'off',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'show_if'         => array(
					'autoplay' => 'on',
				),
				'description'     => esc_html__( 'Pause Autoplay on Mouse Hover.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			//          temporary disabled

			//			'stop_slider_touch'    => array(
			//				'label'           => esc_html__( 'Stop Autoplay on User Touch Interaction', 'dswc-woocommerce-carousel-for-divi' ),
			//				'type'            => 'yes_no_button',
			//				'default'         => 'off',
			//				'options'         => array(
			//					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
			//					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
			//				),
			//				'show_if'         => array(
			//					'autoplay' => 'on',
			//				),
			//				'description'     => esc_html__( 'Stop Autoplay on User Touch Interaction.', 'dswc-woocommerce-carousel-for-divi' ),
			//			),
			'show_arrow'           => array(
				'label'           => esc_html__( 'Show Arrow', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'default'         => 'on',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),

				'description' => esc_html__( 'Show/Hide Arrow', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'out_of_stock'         => array(
				'label'           => esc_html__( 'Display out of stock products?', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'default'         => 'on',
				'options'         => array(
					'off' => esc_html__( 'Off', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'On', 'dswc-woocommerce-carousel-for-divi' ),
				),

				'description' => esc_html__( 'Display/hide out of stock', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'show_controls'        => array(
				'label'           => esc_html__( 'Show Controls/Pagination', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'default'         => 'on',
				'options'         => array(
					'off' => esc_html__( 'No', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dswc-woocommerce-carousel-for-divi' ),
				),

				'description' => esc_html__( 'Show/Hide Controls', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'pagination_bg_color'  => array(
				'label'       => esc_html__( 'Pagination Background Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'color-alpha',
				'default'     => et_builder_accent_color(),
				'description' => esc_html__( 'Here you can define a custom background color for pagination dot.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_pagination',
				'show_if'     => array(
					'show_controls' => 'on',
				),
			),

			'pagination_position'  => array(
				'label'       => esc_html__( 'Position', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'absolute' => esc_html__( 'Absolute', 'dswc-woocommerce-carousel-for-divi' ),
					'relative' => esc_html__( 'Relative', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'absolute',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_pagination',
				'show_if'     => array(
					'show_controls' => 'on',
				),
			),
			'buttons_position'  => array(
				'label'       => esc_html__( 'Buttons Position', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'default' => esc_html__( 'Default', 'dswc-woocommerce-carousel-for-divi' ),
					'center' => esc_html__( 'Center', 'dswc-woocommerce-carousel-for-divi' ),
					'flex-start' => esc_html__( 'Left', 'dswc-woocommerce-carousel-for-divi' ),
					'space-between' => esc_html__( 'Space Between', 'dswc-woocommerce-carousel-for-divi' ),
					'space-around' => esc_html__( 'Space Around', 'dswc-woocommerce-carousel-for-divi' ),
					'space-evenly' => esc_html__( 'Space Evenly', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'default',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_buttons'
			),

			'add_cart_button_text' => array(
				'label'       => esc_html__( 'Button Text', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Read More', 'dswc-woocommerce-carousel-for-divi' ),
				'description' => esc_html__( 'Add to Cart Button Text', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'button_action'        => array(
				'label'           => esc_html__( 'Primary Button Action', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'cart' => esc_html__( 'Add to cart', 'dswc-woocommerce-carousel-for-divi' ),
					'view' => esc_html__( 'View product page', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'view',
				'description'     => esc_html__( 'If you select "Add to Cart", the button\'s primary function will be to add the product to the customer\'s cart. If the product is out of stock, not purchasable, or not a simple product type, the customer will be redirected to the product page instead. Since the customer is redirected to the cart page when the product is added to cart, you may want to set the link target to open a new tab when using the "Add to cart" setting.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'button_ajax'          => array(
				'label'           => esc_html__( 'AJAX Add to Cart Button', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'default'         => 'off',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'show_if'         => array(
					'button_action' => 'cart',
				),
				'description'     => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'title_action'         => array(
				'label'           => esc_html__( 'Title Click Action', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'cart' => esc_html__( 'Add to cart', 'dswc-woocommerce-carousel-for-divi' ),
					'view' => esc_html__( 'View product page', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'view',
				'description'     => esc_html__( 'If you select "Add to Cart", the title link function will be to add the product to the customer\'s cart. If the product is out of stock, not purchasable, or not a simple product type, the customer will be redirected to the product page instead. Since the customer is redirected to the cart page when the product is added to cart, you may want to set the link target to open a new tab when using the "Add to cart" setting.', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'image_action'         => [
				'label'           => esc_html__( 'Image Click Action', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'cart' => esc_html__( 'Add to cart', 'dswc-woocommerce-carousel-for-divi' ),
					'view' => esc_html__( 'View product page', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'view',
				'description'     => esc_html__( 'If you select "Add to Cart", the image link function will be to add the product to the customer\'s cart. If the product is out of stock, not purchasable, or not a simple product type, the customer will be redirected to the product page instead. Since the customer is redirected to the cart page when the product is added to cart, you may want to set the link target to open a new tab when using the "Add to cart" setting.', 'dswc-woocommerce-carousel-for-divi' ),
			],
			'link_target'          => array(
				'label'           => esc_html__( 'Link Target', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'In The Same Window', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'In The New Tab', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'default'         => 'off',
				'description'     => esc_html__( 'Link Target', 'dswc-woocommerce-carousel-for-divi' ),
			),

			// Navigation Setting
			'icon_size'            => array(
				'label'          => esc_html__( 'Icon Size', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dswc_arrow',
				'mobile_options' => true,
				'responsive'     => true,
				'default'        => '20px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
			),
			'prev_icon'            => array(
				'label'           => esc_html__( 'Select Prev Icon', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select_icon',
				'option_category' => 'basic_option',

				'default'     => '4',
				'class'       => array( 'et-pb-font-icon' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_arrow',
				'description' => esc_html__( 'Select Previous Icon', 'dswc-woocommerce-carousel-for-divi' ),
				'show_if'     => array(
					'show_arrow' => 'on',
				),
			),
			'next_icon'            => array(
				'label'           => esc_html__( 'Select Next Icon', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select_icon',
				'option_category' => 'basic_option',
				'default'         => '5',
				'class'           => array( 'et-pb-font-icon' ),
				'description'     => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_arrow',
				'show_if'         => array(
					'show_arrow' => 'on',
				),
			),
			'arrow_icon_color'     => array(
				'label'       => esc_html__( 'Icon Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'color-alpha',
				'default'     => '#fff',
				'description' => esc_html__( 'Here you can define a custom color for your icon.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_arrow',
				'show_if'     => array(
					'show_arrow' => 'on',
				),
			),
			'arrow_pos'            => array(
				'label'           => esc_html__( 'Arrow Vertical Position', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select',
				'default'         => 'center',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_arrow',
				'options'         => array(
					'center' => esc_html__( 'Center', 'dswc-woocommerce-carousel-for-divi' ),
					'bottom' => esc_html__( 'Bottom', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'show_if'         => array(
					'show_arrow' => 'on',
				),

				'description' => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
			),
			'arrows_outside'       => array(
				'label'           => esc_html__( 'Show Arrows Outside Carousel', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'yes_no_button',
				'default'         => 'off',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_arrow',
				'options'         => array(
					'off' => esc_html__( 'No', 'dswc-woocommerce-carousel-for-divi' ),
					'on'  => esc_html__( 'Yes', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'show_if'         => array(
					'show_arrow' => 'on',
				),

				'description' => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
			),

			'arrow_icon_bg_color'   => array(
				'label'       => esc_html__( 'Background Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'color-alpha',
				'default'     => et_builder_accent_color(),
				'description' => esc_html__( 'Here you can define a custom color for your icon.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_arrow',
				'show_if'     => array(
					'show_arrow' => 'on',
				),
			),
			/*
			'arrow_padding'          => array(
				'label'           => esc_html__( 'Arrow Padding', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_arrow',
				'mobile_options'  => true,
				'responsive'      => true,
				'default' => '10px|10px|10px|10px', // also update in apply_responsive function call if changed
				'show_if'         => array(
					'show_arrow' => 'on',
				),
			),
			*/

			// badge_background
			'sale_badge_background' => array(
				'label'       => esc_html__( 'Sale Badge Background Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'color-alpha',
				'default'     => et_builder_accent_color(),
				'description' => esc_html__( 'Here you can define a custom color for your sale badge.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_sale_badge',

			),

			'sale_badge_pos' => array(
				'label'       => esc_html__( 'Position', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'select',
				'default'     => 'no_overlay',
				'options'     => array(
					'no_overlay' => esc_html__( 'Don\'t overlay on product image', 'dswc-woocommerce-carousel-for-divi' ),
					'overlay_tl' => esc_html__( 'Overlay on product image - top left', 'dswc-woocommerce-carousel-for-divi' ),
					'overlay_tr' => esc_html__( 'Overlay on product image - top right', 'dswc-woocommerce-carousel-for-divi' ),
					'overlay_bl' => esc_html__( 'Overlay on product image - bottom left', 'dswc-woocommerce-carousel-for-divi' ),
					'overlay_br' => esc_html__( 'Overlay on product image - bottom right', 'dswc-woocommerce-carousel-for-divi' ),
				),
				'description' => esc_html__( '', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dswc_sale_badge',
			),

			'sale_badge_text'     => array(
				'label'       => esc_html__( 'Sale Badge Text', 'dswc-woocommerce-carousel-for-divi' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Sale', 'dswc-woocommerce-carousel-for-divi' ),
				'description' => esc_html__( 'Set text that will be displayed for the Sale Badge. Default: Sale', 'dswc-woocommerce-carousel-for-divi' ),
			),

			// Image overlay setting
			'image_overlay_color' => array(
				'label'           => esc_html__( 'Overlay Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'color-alpha',
				'default'         => 'rgba(0,0,0,0.36)',
				'description'     => esc_html__( 'Here you can define a custom color for your overlay.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_image',
			),

			// star rating setting
			'star_icon'           => array(
				'label'           => esc_html__( 'Star Rating Icon', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'select_icon',
				'option_category' => 'basic_option',
				//'default'         => '4',
				'class'           => array( 'et-pb-font-icon' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_rating',
				'description'     => esc_html__( 'Select an icon to use for the star rating display.', 'dswc-woocommerce-carousel-for-divi' ),
			),

			'rating_align' => array(
				'label'           => esc_html__( 'Alignment', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'dswc-woocommerce-carousel-for-divi' ),
						'icon'  => 'align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'dswc-woocommerce-carousel-for-divi' ),
						'icon'  => 'align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'dswc-woocommerce-carousel-for-divi' ),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'left',
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_rating',
			),

			'rating_color_active' => array(
				'label'           => esc_html__( 'Star Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'color-alpha',
				'default'         => et_builder_accent_color(),
				'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_rating',
			),
			'rating_color'        => array(
				'label'           => esc_html__( 'Placeholder Star Color', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'color-alpha',
				'default'         => '#cccccc',
				'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dswc-woocommerce-carousel-for-divi' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_rating',
			),
			'rating_size'         => array(
				'label'          => esc_html__( 'Size', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dswc_rating',
				'default'        => '17px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
			),
			'rating_spacing'      => array(
				'label'          => esc_html__( 'Star Spacing (em)', 'dswc-woocommerce-carousel-for-divi' ),
				'type'           => 'range',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dswc_rating',
				'default'        => 0.2,
				'unitless'       => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '5',
					'step' => '0.01',
				),
			),
		);

		foreach ( self::$marginPaddingElements as $elementId => $params ) {


			$fields[ $elementId . '_padding' ] = array(
				'label'           => esc_html__( 'Padding', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $params['default_padding'],
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_' . $elementId,
			);

			$fields[ $elementId . '_margin' ] = array(
				'label'           => esc_html__( 'Margin', 'dswc-woocommerce-carousel-for-divi' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $params['default_margin'],
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dswc_' . $elementId,
			);

		}

		return $fields;
	}

	private function doRender( $value, $product, $allItems, $force = false ) {
		$links = [];
		foreach ( [ 'button', 'image', 'title' ] as $linkType ) {

			switch ( $this->props[ $linkType . '_action' ] ) {
				case 'cart':
					$_product = wc_get_product( $product['id'] );
					// woocommerce\includes\class-wc-embed.php
					if ( $_product->is_type( 'simple' ) && $_product->is_purchasable() && $_product->is_in_stock() ) {
						$canAddToCart       = true;
						$links[ $linkType ] = add_query_arg( 'add-to-cart', $product['id'], wc_get_cart_url() );
						break;
					}
				// no break
				default:
					$links[ $linkType ] = get_permalink( $product['id'] ) ? get_permalink( $product['id'] ) : '#';
			}
		}

		switch ( $value ) {
			case 'title':
				return sprintf(
					'<%1$s class="dswc_title"><a %2$s href="%3$s">%4$s</a></%1$s>',
					in_array( $this->props['title_tag'], self::$allowedTitleTags ) ? $this->props['title_tag'] : 'h3',
					$this->props['link_target'] === 'on' ? 'target="_blank"' : '',
					esc_url( $links['title'] ),
					esc_html( $product['name'] )
				);
			case 'badge':
				if ( $product['sale'] && ( ( isset( $this->props['sale_badge_pos'] ) && $this->props['sale_badge_pos'] === 'no_overlay' ) || $force ) ) {
					return sprintf(
						'<div class="sale_badge dswc_badge_%1$s"><span>%2$s</span></div>',
						esc_attr( $this->props['sale_badge_pos'] ),
						isset( $this->props['sale_badge_text'] ) && $this->props['sale_badge_text'] !== '' ? esc_attr( $this->props['sale_badge_text'] ) : esc_html__( 'Sale', 'woocommerce-carousel-for-divi' )

					);
				}

				return '';
			case 'image':

				// woocommerce-carousel-for-divi\includes\modules\WoocommerceCarousel\WoocommerceCarousel.jsx
				$badges = '';
				if ( isset( $this->props['sale_badge_pos'] ) && $this->props['sale_badge_pos'] !== 'no_overlay' ) {
					foreach ( $allItems as $item ) {
						if ( $item === 'badge' ) {
							$badges .= $this->doRender( $item, $product, $allItems, true );
						}
					}
				}


				return sprintf( '<a %3$s href="%1$s"><span class="dswc-featured-image">%4$s%2$s</span></a>', esc_url( $links['image'] ), $product['image_html'], $this->props['link_target'] === 'on' ? 'target="_blank"' : '', $badges );
			case 'ratings':
				$product = wc_get_product( $product['id'] );

				// woocommerce-carousel-for-divi\woocommerce-carousel-for-divi.php
				return '<div class="star_rating_module_wrapper">' . wc_get_rating_html( $product->get_average_rating() ) . '</div>';
			case 'price':
				$product = wc_get_product( $product['id'] );
				$price   = $product ? $product->get_price_html() : '';

				return '<div class="dswc_price">' . $price . '</div>';
			case 'button':
				$classNames = [ 'et_bt_add_to_cart' ];

				if ( $this->props['button_ajax'] == 'on' && ! empty( $canAddToCart ) ) {
					$classNames[] = 'add_to_cart_button';
					$classNames[] = 'ajax_add_to_cart';
				}

				// Render Button
				$button = $this->render_button(
					array(
						'button_classname' => $classNames,
						'button_text'      => $this->props['add_cart_button_text'],
						'button_url'       => $links['button'],
						'custom_icon'      => esc_attr( et_pb_process_font_icon( $this->props['add_cart_button_icon'] ) ),
						'has_wrapper'      => false,
						'url_new_window'   => $this->props['link_target']
					)
				);

				if ( $this->props['button_ajax'] == 'on' && ! empty( $canAddToCart ) ) {
					$button = str_replace(
						' class="',
						' data-product_id="' . ( (int) $product['id'] ) . '" class="',
						$button
					);
				}

				// Render module output
				return sprintf(
					'<div class="dswc_buttons_wrapper"><div class="dswc_et_pb_button_module_wrapper dswc_et_pb_button_%2$s_wrapper">
				%1$s
			</div></div>',
					$button,
					$this->render_count()
				);
			default:
				return '';

		}
	}

	private function get_swiper_params( $order_class ) {
		$swiper_params = array(
			//'slidesPerView'      => (int) $this->props['column_layout'],
			//'spaceBetween'      => (int) $this->props['space_between'],
			'centeredSlides'     => 'on' === $this->props['slide_center'],
			'autoHeight'         => 'on' === $this->props['equal_height'],
			'breakpointsInverse' => true,
			'loop'               => 'on' === $this->props['loop'],
			'grabCursor'         => true,
			'mousewheel'         => 'on' === $this->props['mousewheel'],
			'rtl'                => $this->props['is_rtl'] > 0,
			'breakpoints'        => array(
				0   => array(
					'slidesPerView'  => $this->props['column_layout_phone'] ? $this->props['column_layout_phone'] : $this->props['column_layout'],
					'spaceBetween'   => $this->props['space_between_phone'] ? $this->props['space_between_phone'] : $this->props['space_between'],
					'slidesPerGroup' => $this->props['slide_by_phone'] ? $this->props['slide_by_phone'] : $this->props['slide_by'],
				),
				768 => array(
					'slidesPerView'  => $this->props['column_layout_tablet'] ? $this->props['column_layout_tablet'] : $this->props['column_layout'],
					'spaceBetween'   => $this->props['space_between_tablet'] ? $this->props['space_between_tablet'] : $this->props['space_between'],
					'slidesPerGroup' => $this->props['slide_by_tablet'] ? $this->props['slide_by_tablet'] : $this->props['slide_by'],
				),
				980 => array(
					'slidesPerView'  => $this->props['column_layout'],
					'spaceBetween'   => $this->props['space_between'],
					'slidesPerGroup' => $this->props['slide_by'],
				),
			),
		);
		if ( 'on' === $this->props['show_arrow'] ) {
			$swiper_params['navigation'] = array(
				'nextEl' => '.' . $order_class . ' .next_icon',
				'prevEl' => '.' . $order_class . ' .prev_icon',
			);
		}
		if ( 'on' === $this->props['show_controls'] ) {
			$swiper_params['pagination'] = array(
				'el'        => '.swiper-pagination',
				'type'      => 'bullets',
				'clickable' => true,
			);
		}
		if ( 'on' === $this->props['autoplay'] ) {
			$swiper_params['autoplay'] = array(
				'delay'        => (int) $this->props['auto_speed'],
				'pauseOnHover' => 'on' === $this->props['pause_slider'],
				//				'disableOnInteraction' => 'on' === $this->props['stop_slider_touch']
			);
		}

		return wp_json_encode( $swiper_params );
	}

	private function get_slider_products( $content ) {

		$products = DS_Woo_Carousel::get_products( $this->props );

		$html = '';
		preg_match_all( '/item="(?<match>\w+)"/m', $content, $matches, PREG_PATTERN_ORDER );

		if ( isset( $matches['match'] ) ) {
			foreach ( $products as $key => $product ) {
				$html .= '<div class="dswc_item_wrapper swiper-slide">';
				foreach ( $matches['match'] as $v ) {
					$html .= $this->doRender( $v, $product, $matches['match'] );
				}
				$html .= '</div>';
			}
		}

		return $html;

	}

	private function apply_responsive( $value, $selector, $css, $render_slug, $type, $default = null, $important = false ) {

		$dswc_last_edited       = $this->props[ $value . '_last_edited' ];
		$dswc_responsive_active = et_pb_get_responsive_status( $dswc_last_edited );

		switch ( $type ) {
			case 'custom_margin':

				$dswc_array = array(
					'desktop' => $value,
					'tablet'  => $dswc_responsive_active ? $value . '_tablet' : '',
					'phone'   => $dswc_responsive_active ? $value . '_phone' : '',
				);

				$default = $default ? explode( '|', $default ) : array( '0px', '0px', '0px', '0px' );

				foreach ( $dswc_array as $key => &$item ) {
					if ( $item ) {

						$item = $this->props[ $item ];

						$itemArr = explode( '|', $item );

						$item = array();
						for ( $i = 0; $i < 4; ++ $i ) {
							$item[ $i ] = $itemArr[ $i ] ? $itemArr[ $i ] : $default[ $i ];
						}
						$item = trim( implode( ' ', $item ) );
					}
				}


				break;
			default:

				$re          = array( '|', 'true', 'false' );
				$dswc        = trim( str_replace( $re, ' ', $this->props[ $value ] ) );
				$dswc_tablet = trim( str_replace( $re, ' ', $this->props[ $value . '_tablet' ] ) );
				$dswc_phone  = trim( str_replace( $re, ' ', $this->props[ $value . '_phone' ] ) );

				$dswc_array = array(
					'desktop' => $dswc,
					'tablet'  => $dswc_responsive_active ? $dswc_tablet : '',
					'phone'   => $dswc_responsive_active ? $dswc_phone : '',
				);
		}


		et_pb_responsive_options()->generate_responsive_css( $dswc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type );

	}

	private function css( $render_slug ) {

		$props = $this->props;
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $props['pagination_bg_color'] )
				),
			)
		);

		if ( isset( $props['pagination_position'] ) && $props['pagination_position'] === 'relative') {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .swiper-pagination',
					'declaration' => sprintf(
						'position: %1$s;',
						esc_attr( $props['pagination_position'] )
					),
				)
			);
		}
		if ( isset( $props['buttons_position'] ) && $props['buttons_position'] !== 'default') {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswc_et_pb_button_module_wrapper',
					'declaration' => sprintf(
						'display: flex; align-items: center; justify-content: %1$s;',
						esc_attr( $props['buttons_position'] )
					),
				)
			);
		}

		if ( isset( $props['slide_elements_position'] ) && $props['slide_elements_position'] !== 'default') {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswc_item_wrapper',
					'declaration' => sprintf(
						'display: flex; flex-direction: column; justify-content: %1$s;',
						esc_attr( $props['slide_elements_position'] )
					),
				)
			);
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .prev_icon,%%order_class%%  .next_icon',
				'declaration' => sprintf(
					'font-family: ETmodules;
					content: attr(data-icon);
					speak: none;
					font-weight: 400;
					-webkit-font-feature-settings: normal;
					font-feature-settings: normal;
					font-variant: normal;
					text-transform: none;
					line-height: 1;
					-webkit-font-smoothing: antialiased;
					font-style: normal;
					display: inline-block;
					-webkit-box-sizing: border-box;
					box-sizing: border-box;
					position: absolute;
					z-index: 99999;
					cursor: pointer;
					color: %1$s;background-color: %2$s;%3$s;',
					esc_html( $props['arrow_icon_color'] ),
					esc_html( $props['arrow_icon_bg_color'] ),
					$props['arrow_pos'] === 'center' ? 'top: 45%;' : 'bottom: 0%;'
				),
			)
		);
		if ( '' === $props['border_style_all'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .swiper-slide.dswc_item_wrapper',
					'declaration' => 'border-style: solid;',
				)
			);
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .next_icon.swiper-button-disabled,%%order_class%% .prev_icon.swiper-button-disabled',
				'declaration' => 'display: none;',
			)
		);

		/*
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .prev_icon',
				'declaration' => 'left: 0;',
			)
		);
		*/

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .next_icon',
				'declaration' => 'right:0;',
			)
		);


		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%%.dswc_arrows_outside .prev_icon',
				'declaration' => 'left: -25px',
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%%.dswc_arrows_outside .next_icon',
				'declaration' => 'right: -25px;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .dswc_item_wrapper img',
				'declaration' => 'border-style: solid;',
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .swiper-slide.dswc_item_wrapper:hover .dswc-featured-image:before',
				'declaration' => sprintf(
					'background-color: %1$s;',
					$props['image_overlay_color']
				),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .swiper-slide.dswc_item_wrapper .star_rating_module_wrapper',
				'declaration' => sprintf( 'text-align:%1$s;', $props['rating_align'] ),
			)
		);

		if ( isset( $props['star_icon'] ) ) {
			$starIcon = et_pb_process_font_icon( $props['star_icon'] );
		}

		if ( empty( $starIcon ) ) {
			$starIcon = '\\e033';
		} else if ( substr( $starIcon, 0, 7 ) == '&amp;#x' && substr( $starIcon, - 1 ) == ';' ) {
			$starIcon = '\\' . substr( $starIcon, 7, - 1 );
		} else {
			$starIcon = html_entity_decode( html_entity_decode( $starIcon ) );
		}

		if ( ! isset( $props['rating_spacing'] ) ) {
			$props['rating_spacing'] = 0.2;
		}

		if ( ! isset( $props['rating_size'] ) ) {
			$props['rating_size'] = '20px';
		}

		$totalWidthEm = 5 + ( $props['rating_spacing'] * 4 );

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .star_rating_module_wrapper',
				'declaration' => sprintf( 'font-size:%1$s;', $props['rating_size'] ),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .star_rating_module_wrapper .star-rating::before, %%order_class%% .star_rating_module_wrapper .star-rating span::before',
				'declaration' => sprintf( '
					content: "%1$s%1$s%1$s%1$s%1$s"!important;
					font-size: %2$s;
					letter-spacing: %3$Fem;
				', $starIcon, $props['rating_size'], $props['rating_spacing'] ),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .star_rating_module_wrapper .star-rating span::before',
				'declaration' => sprintf( 'color:%s;', $props['rating_color_active'] ),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .star_rating_module_wrapper .star-rating::before',
				'declaration' => sprintf( 'color:%s!important;', $props['rating_color'] ),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .star_rating_module_wrapper .star-rating',
				'declaration' => sprintf( 'width:%sem;', $totalWidthEm ),
			)
		);


		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .swiper-slide.dswc_item_wrapper .sale_badge span',
				'declaration' => sprintf( 'background-color:%1$s;', $props['sale_badge_background'] ),
			)
		);

		// $this->apply_responsive( 'arrow_padding', '%%order_class%%  .prev_icon,%%order_class%%  .next_icon', 'padding', $render_slug, 'custom_margin', '10px|10px|10px|10px' );
		$this->apply_responsive( 'icon_size', '%%order_class%%  .prev_icon,%%order_class%%  .next_icon', 'font-size', $render_slug, 'font_size' );

		foreach ( self::$marginPaddingElements as $elementId => $params ) {
			$this->apply_responsive( $elementId . '_padding', $params['selector'], 'padding', $render_slug, 'custom_margin', $params['default_padding'] );
			$this->apply_responsive( $elementId . '_margin', $params['selector'], 'margin', $render_slug, 'custom_margin', $params['default_margin'] );
		}

	}

	/**
	 * @param array  $attrs
	 * @param null   $content
	 * @param string $render_slug
	 *
	 * @return string
	 */
	public function render(
		$attrs, $content = null, $render_slug = ''
	) {
		$this->css( $render_slug );

		$order_class  = ET_Builder_Element::get_module_order_class( $render_slug );
		$module_class = $order_class . ' woocommerce';

		if ( $this->props['arrows_outside'] == 'on' ) {
			$module_class .= ' dswc_arrows_outside';
		}

		$woocommerce_data = $this->get_slider_products( $content );

		return $woocommerce_data ? sprintf(
			'<div class="%3$s">
				<div class="dswc swiper-container" %1$s data-swiper=\'%2$s\'>
					<div class="dswc-swiper-wrapper swiper-wrapper">
      					%4$s
				    </div>	
					%5$s
				</div>
				%6$s
			</div>',
			is_rtl() ? 'dir="rtl"' : '',
			esc_attr( $this->get_swiper_params( $order_class ) ),
			esc_html( $module_class ),
			$woocommerce_data,
			'on' === $this->props['show_controls'] ? '<div class="swiper-pagination"></div>' : '',
			'on' === $this->props['show_arrow'] ? '<span class="prev_icon">' . esc_html( et_pb_process_font_icon( $this->props['prev_icon'] ) ) . '</span><span class="next_icon">' . esc_html( et_pb_process_font_icon( $this->props['next_icon'] ) ) . '</span>' : ''
		) : '<h1 class="dswc_no_record">' . esc_html__( 'No results to display.', 'dswc-woocommerce-carousel-for-divi' ) . '</h1>';
	}

	public function add_new_child_text() {
		return esc_html__( 'Add New Item', 'dswc-woocommerce-carousel-for-divi' );
	}

	/**
	 * Override parent method to set up conditional text shadow fields
	 * {@see parent::_set_fields_unprocessed}
	 *
	 * @param Array fields array
	 */
	protected function _set_fields_unprocessed( $fields ) {

		if ( ! is_array( $fields ) ) {
			return;
		}

		unset($fields['view_cart_text_align']);
		unset($fields['view_cart_text_align_tablet']);
		unset($fields['view_cart_text_align_phone']);
		unset($fields['view_cart_text_align_last_edited']);


		return parent::_set_fields_unprocessed( $fields );
	}

}

new DSWC_WoocommerceCarousel();
