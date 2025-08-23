<?php

class DSWCP_WooCartList extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_cart_list';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Cart List', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

		/**
		 * Toggle Sections of General tab and Design tab
		 *
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content'     => esc_html__( 'Cart Contents', 'divi-shop-builder' ),
					'empty' 	  => esc_html__( 'Empty Cart', 'divi-shop-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'table' 	   => array(
						'title'    => esc_html__( 'Table', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_headings'   => array(
						'title'    => esc_html__( 'Table Headings', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_body'   => array(
						'title'    => esc_html__( 'Table Body', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_links'   => array(
						'title'    => esc_html__( 'Table Links', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'thumbnail'    => array(
						'title'    => esc_html__( 'Product Thumbnail', 'divi-shop-builder' ),
						'priority' => 46,
					),
					'button_remove'   => array(
						'title'    => esc_html__( 'Remove Button', 'divi-shop-builder' ),
						'priority' => 46,
					),
					'button_update_cart'   => array(
						'title'    => esc_html__( 'Update Cart Button', 'divi-shop-builder' ),
						'priority' => 46,
					),
					'button_apply_coupon' => array(
						'title'    => esc_html__( 'Apply Coupon Button', 'divi-shop-builder' ),
						'priority' => 46,
					),
					'quantity_fields'   => array(
						'title'    => esc_html__( 'Quantity Field', 'divi-shop-builder' ),
						'priority' => 47,
					),
					'coupon_fields'   => array(
						'title'    => esc_html__( 'Coupon Code Field', 'divi-shop-builder' ),
						'priority' => 47,
					),
					'empty_cart_text' => array(
						'title'    => esc_html__( 'Empty Cart Text', 'divi-shop-builder' ),
						'priority' => 48,
					),
					'empty_cart_button' => array(
						'title'    => esc_html__( 'Empty Cart Button', 'divi-shop-builder' ),
						'priority' => 48,
					)
				),
			),
		);

		/**
		 * Desing tab extra fields
		 *
		 */
		$this->advanced_fields = array(
			'link_options' => false,
			'text' => false,
			'fonts'          => array(
				'table_headings' => array(
					'label'           => esc_html__( 'Table Headings', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% th',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_headings',
					'font'            => array(
						'default' => '|700|||||||',
					),
				),
				'table_body' => array(
					'label'           => esc_html__( 'Table Body', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% td',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_body',
					'font'            => array(
						'default' => '||||||||',
					),
				),
				'table_links' => array(
					'label'           => esc_html__( 'Table Links', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% td a',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_links',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'empty_cart_text' => array(
					'label' => esc_html__( 'Empty cart text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .cart-empty.woocommerce-info, .woocommerce .ags_woo_notices .cart-empty.woocommerce-info',
						'important' => 'all',
					),
					'toggle_slug'     => 'empty_cart_text',
				),
			),
			'button'         => array(
				'button_update_cart' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'button_update_cart',
					'css'            => array(
						'main'         => '%%order_class%% .cart .actions > button.button',
						'alignment'    => '%%order_class%% .actions',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .actions > button.button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
				'button_apply_coupon' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'button_apply_coupon',
					'css'            => array(
						'main'         => '%%order_class%% .cart .coupon button.button',
						'alignment'    => '%%order_class%% .coupon',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .coupon button.button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
				'button_empty_cart' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'use_alignment'  => true,
					'toggle_slug'    => 'empty_cart_button',
					'css'            => array(
						'main'         => '%%order_class%% .return-to-shop a.button',
						'alignment'    => '%%order_class%% .return-to-shop',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .return-to-shop a.button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
			),
			'form_field'     => array(
				'quantity_fields'         => array(
					'label'           => esc_html__( 'Fields', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'main'                   => '%%order_class%% .quantity input.qty',
						'background_color'       => '%%order_class%% .quantity input.qty',
						'background_color_hover' => '%%order_class%% .quantity input.qty:hover',
						'focus_background_color' => '%%order_class%% .quantity input.qty:focus',
						'form_text_color'        => '%%order_class%% .quantity input.qty',
						'form_text_color_hover'  => '%%order_class%% .quantity input.qty:hover',
						'focus_text_color'       => '%%order_class%% .quantity input.qty:focus',
						'placeholder_focus'      => '%%order_class%% .quantity input.qty:focus::-webkit-input-placeholder, %%order_class%% .quantity input.qty:focus::-moz-placeholder, %%order_class%% .quantity input.qty:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .quantity input.qty',
						'margin'                 => '%%order_class%% .quantity input.qty',
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'      => array(
						'name'              => 'quantity_fields',
						'css'               => array(
							'main' => '%%order_class%% .quantity input.qty',
							'important' => 'all'
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'quantity_fields'       => array(
							'name'         => 'quantity_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .quantity input.qty',
									'border_styles' => '%%order_class%% .quantity input.qty',
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '0px',
									'color' => '',
									'style' => 'none',
									'color' => ''
								),
							)
						),
						'quantity_fields_focus' => array(
							'name'         => 'quantity_fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .quantity input.qty:focus',
									'border_styles' => '%%order_class%% .quantity input.qty:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .quantity input.qty',
							),
							'hover'     => array(
								'%%order_class%% .quantity input.qty:hover',
								'%%order_class%% .quantity input.qty:hover::-webkit-input-placeholder',
								'%%order_class%% .quantity input.qty:hover::-moz-placeholder',
								'%%order_class%% .quantity input.qty:hover:-ms-input-placeholder',
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '20px',
						),
						'line_height' => array(
							'default' => '1em',
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => '%%order_class%% .quantity input.qty',
							'important' => array( 'custom_padding' ),
						),
					),
				),
				'coupon_fields'       => array(
					'label'           => esc_html__( 'Field', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'main'                   => '%%order_class%% table.cart td.actions .coupon input.input-text',
						'background_color'       => '%%order_class%% table.cart td.actions .coupon input.input-text',
						'background_color_hover' => '%%order_class%% table.cart td.actions .coupon input.input-text:hover',
						'focus_background_color' => '%%order_class%% table.cart td.actions .coupon input.input-text:focus',
						'form_text_color'        => '%%order_class%% table.cart td.actions .coupon input.input-text',
						'form_text_color_hover'  => '%%order_class%% table.cart td.actions .coupon input.input-text:hover',
						'focus_text_color'       => '%%order_class%% table.cart td.actions .coupon input.input-text:focus',
						'placeholder_focus'      => '%%order_class%% table.cart td.actions .coupon input.input-text:focus::-webkit-input-placeholder, %%order_class%% table.cart td.actions .coupon input.input-text::-moz-placeholder, %%order_class%% table.cart td.actions .coupon input.input-text:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% table.cart td.actions .coupon input.input-text',
						'margin'                 => '%%order_class%% table.cart td.actions .coupon input.input-text',
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'      => array(
						'name'              => 'coupon_fields',
						'css'               => array(
							'main' 		=> '%%order_class%% table.cart td.actions .coupon input.input-text',
							'important' => 'all'
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'coupon_fields'       => array(
							'name'         => 'coupon_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% table.cart td.actions .coupon input.input-text',
									'border_styles' => '%%order_class%% table.cart td.actions .coupon input.input-text',
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '0px',
									'color' => '',
									'style' => 'none',
									'color' => ''
								),
							),
							'label_prefix' => esc_html__( 'Field', 'divi-shop-builder' ),
						),
						'coupon_fields_focus' => array(
							'name'         => 'coupon_fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% table.cart td.actions .coupon input.input-text:focus',
									'border_styles' => '%%order_class%% table.cart td.actions .coupon input.input-text:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Field Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% table.cart td.actions .coupon input.input-text',
							),
							'hover'     => array(
								'%%order_class%% table.cart td.actions .coupon input.input-text:hover',
								'%%order_class%% table.cart td.actions .coupon input.input-text:hover::-webkit-input-placeholder',
								'%%order_class%% table.cart td.actions .coupon input.input-text:hover::-moz-placeholder',
								'%%order_class%% table.cart td.actions .coupon input.input-text:hover:-ms-input-placeholder',
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '20px',
						),
						'line_height' => array(
							'default' => '1em',
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => '%%order_class%% table.cart td.actions .coupon input.input-text',
							'important' => 'all',
						),
					),
				)
			),
			'borders' => array(
				'default' => array(),
				'table' => array(
					'label'           => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% table.shop_table.cart',
							'border_radii' 	=> '%%order_class%% table.shop_table.cart'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'table',
				),
				'table_headings' => array(
					'label_prefix'    => esc_html__( 'Table Headings', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% table.shop_table.cart th',
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => '||||',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#ebe9eb',
							'style' => 'none',
						)
					),
					'toggle_slug'     => 'table_headings',
				),
				'table_body' => array(
					'label'           => esc_html__( 'Table Body', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% table.shop_table.cart td',
						),
						'important'   => 'all',
					),
					'option_category' => 'border',
					'defaults'  => array(
						'border_radii'  => '||||',
						'border_styles' => array(
							'width' => '0px',
							'color' => '',
							'style' => 'none',
							'color' => ''
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_style_top' => 'solid',
								'border_color_top' => '#eee',
							),
						),
					),
					'toggle_slug'     => 'table_body',
				)
			)
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'cart_table'         => array(
				'label'    => esc_html__( 'Cart Table', 'divi-shop-builder' ),
				'selector' => '%%order_class%% table.cart',
			),
			'cart_table_th'    => array(
				'label'    => esc_html__( 'Cart Table Headings', 'divi-shop-builder' ),
				'selector' => '%%order_class%% table.cart th',
			),
			'cart_table_td'    => array(
				'label'    => esc_html__( 'Cart Table Body', 'divi-shop-builder' ),
				'selector' => '%%order_class%% table.cart td',
			),
			'remove_button'   => array(
				'label'    => esc_html__( 'Remove button', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .product-remove .remove',
			),
			'remove_button_icon' => array(
				'label'    => esc_html__( 'Remove button icon', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .product-remove .remove:after',
			),
			'empty_cart_text' => array(
				'label'    => esc_html__( 'Empty cart text', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-empty.woocommerce-info',
			),
			'empty_cart_button' => array(
				'label'    => esc_html__( 'Empty cart button', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .return-to-shop > .button',
			)
		);

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}


	/**
	 * State/ Content fields to control the table behavior
	 *
	 * @return array
	 *
	 */
	public function get_fields() {
		return array(
			'warning' => array(
				'type'        => 'ags_wc_warning-DSB',
				'toggleVar'   => 'ags_divi_wc_notCartPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module will not function properly on the front end of your website because this is not the assigned Cart page.', 'divi-shop-builder' ),
				'toggle_slug' => 'content'
			),
			'col_remove_state' => array(
				'label'           => esc_html__( 'Remove Product Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "remove product column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_thumbnail_state' => array(
				'label'           => esc_html__( 'Thumbnail Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "thumbnail column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_name_state' => array(
				'label'           => esc_html__( 'Product Name Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "product name column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_price_state' => array(
				'label'           => esc_html__( 'Price Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "price column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_quantity_state' => array(
				'label'           => esc_html__( 'Quantity Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "quantity column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_subtotal_state' => array(
				'label'           => esc_html__( 'Subtotal Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "subtotal column" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_code_state' => array(
				'label'           => esc_html__( 'Show Coupon Code Column', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the "coupon code" from the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_remove_text' => array(
				'label'           => esc_html__( 'Remove Product Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "remove product label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '',
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			/*
			'remove_button_text' => array(
				'label'           => __( 'Remove Button Text', 'divi-shop-builder' ),
				'description' 	  => __( 'Change the "remove button label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'x',
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			*/
			'col_thumbnail_text' => array(
				'label'           => esc_html__( 'Thumbnail Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "thumbnail label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => '',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_name_text' => array(
				'label'           => esc_html__( 'Product Name Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "name label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Product', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_price_text' => array(
				'label'           => esc_html__( 'Unit Price Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "price label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Price', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_quantity_text' => array(
				'label'           => esc_html__( 'Quantity Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "quantity label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Quantity', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'col_subtotal_text' => array(
				'label'           => esc_html__( 'Subtotal Column Name', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "subtotal label" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_code_input_text' => array(
				'label'           => esc_html__( 'Coupon Code Input Placeholder', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify custom short hint that describes the expected value of a coupon code field.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Coupon code', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_code_button_text' => array(
				'label'           => esc_html__( 'Coupon Code Button Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify the "coupon code" button text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Apply coupon', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'update_cart_button_text' => array(
				'label'           => esc_html__( 'Update Cart Button Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify the "update cart" button text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Update cart', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			'thumbnail_size' => array(
				'label'           => esc_html__( 'Product Image Size', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "product image" size', 'divi-shop-builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'thumbnail',
				'default'         => '32px',
				'default_unit'    => 'px',
				'allowed_units'   => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				)
			),
			'remove_button_use_image' => array(
				'label'           => esc_html__( 'Use Image', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Use custom image for "remove button icon"', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'button_remove',
			),
			'remove_button_icon'  => array(
				'label'           => esc_html__( 'Remove Button Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "remove button icon" to custom icon', 'divi-shop-builder' ),
				'type'            => 'select_icon',
				'class'           => array( 'et-pb-font-icon' ),
				'option_category' => 'configuration',
				'default'         => 'M', 				// `M` is x icon
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'button_remove',
				'show_if' 		  => array(
					'remove_button_use_image' => 'off'
				)
			),
			'remove_button_image' => array(
				'label'           => esc_html__( 'Remove Button Image', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "remove button icon" to custom image', 'divi-shop-builder' ),
				'type'            => 'upload',
				'upload_button_text' => esc_html__( 'Upload an image', 'divi-shop-builder' ),
				'choose_text'     => esc_html__( 'Choose an Image', 'divi-shop-builder' ),
				'update_text'     => esc_html__( 'Set As Image', 'divi-shop-builder' ),
				'class'           => array( 'et-pb-font-icon' ),
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'button_remove',
				'show_if' 		  => array(
					'remove_button_use_image' => 'on'
				)
			),
			'remove_button_size' => array(
				'label'           => esc_html__( 'Remove Button Size', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "remove button icon" size', 'divi-shop-builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'button_remove',
				'default'         => '1em',
				'default_unit'    => 'em',
				'allowed_units'   => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				)
			),
			'remove_button_color' => array(
				'label'           => esc_html__( 'Remove Button Color', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "remove button icon" color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_remove',
				'default'        => 'red',
			),
			'empty_cart_text' 	  => array(
				'label'           => esc_html__( 'Empty Cart Text', 'divi-shop-builder' ),
				'default' 		  => esc_html__( 'Your cart is currently empty.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'empty',
			),
			'empty_cart_button_text' => array(
				'label'           => esc_html__( 'Empty Cart Button Text', 'divi-shop-builder' ),
				'default' 		  => esc_html__( 'Return to shop', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'empty',
			),
			'empty_cart_button_url' => array(
				'label'           => esc_html__( 'Empty Cart Button URL', 'divi-shop-builder' ),
				'default' 		  => wc_get_page_permalink( 'shop' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'empty',
			),
			'empty_cart_text_bg_color' => array(
				'label'          => esc_html__( 'Empty Cart Text Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'empty_cart_text',
				'default'        => '#2ea3f2',
			),
			'table_heading_padding' => array(
				'label'           => esc_html__( 'Table Headings Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table headings" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '.857em|.587em|.857em|.587em|on|on',
				'toggle_slug'     => 'table_headings',
			),
			'table_body_padding' => array(
				'label'           => esc_html__( 'Table Body Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table body" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '.857em|.587em|.857em|.587em|on|on',
				'toggle_slug'     => 'table_body',
			),
		);
	}


	/**
	 * Add localized strings of the module
	 *
	 * @param array
	 * @return array
	 */
	public function builder_js_data( $js_data ){
		$locals = array(
			'columns' 		 => dswcp_get_cart_columns(),
			'thumbnail_src'  => wc_placeholder_img_src(),
			'locals' 		 => array(
				'cart_item_name' => esc_html__( 'My Awesome Product', 'divi-shop-builder' ),
				'cart_item_qty' => esc_html__( 'My Awesome Product quantity', 'divi-shop-builder' ),
				'remove_label' => esc_html__( 'Remove this item', 'divi-shop-builder' ),
				'coupon_text' => esc_html__( 'Coupon', 'divi-shop-builder' ),
				'coupon_code' => esc_html__( 'Coupon Code', 'divi-shop-builder' ),
				'apply_coupon' => esc_html__( 'Apply coupon', 'divi-shop-builder' ),
				'update_cart' => esc_html__( 'Update cart', 'divi-shop-builder' ),
				'cart_totals_title' => esc_html__( 'Cart totals', 'divi-shop-builder' ),
				'cart_totals_subtotal' => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'cart_totals_total' => esc_html__( 'Total', 'divi-shop-builder' ),
				'checkout_button' => esc_html__( 'Proceed to checkout', 'divi-shop-builder' ),
			)
		);

		$js_data['cart_list'] = $locals;

		return $js_data;
	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {

		// baild out if cart is not set
		if( ! WC()->cart ){
			return;
		}

		// generate styles for empty cart message
		$this->generate_styles(
			array(
				'type'           => 'color',
				'render_slug'    => $render_slug,
				'base_attr_name' => 'empty_cart_text_bg_color',
				'css_property'   => 'background-color',
				'selector'       => '%%order_class%% .cart-empty.woocommerce-info, .woocommerce .ags_woo_notices .cart-empty.woocommerce-info',
				'important' 	 => true
			)
		);

		if( $this->props['remove_button_size'] !== '1em' ){

			// generate remove button icon/img size styles
			$this->generate_styles(
				array(
					'type'           => 'width',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'remove_button_size',
					'css_property'   => 'width',
					'selector'       => '%%order_class%% .product-remove .remove',
					'important' 	 => true
				)
			);
			$this->generate_styles(
				array(
					'type'           => 'height',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'remove_button_size',
					'css_property'   => 'height',
					'selector'       => '%%order_class%% .product-remove .remove',
					'important' 	 => true
				)
			);
			$this->generate_styles(
				array(
					'type'           => 'font',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'remove_button_size',
					'css_property'   => 'font-size',
					'selector'       => '%%order_class%% .product-remove .remove::after',
					'important' 	 => true
				)
			);
		}

		if( $this->props['remove_button_color'] !== 'red' ){
			$this->generate_styles(
				array(
					'type'           => 'color',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'remove_button_color',
					'css_property'   => 'color',
					'selector'       => '%%order_class%% .product-remove .remove',
					'important' 	 => true
				)
			);

			$this->generate_styles(
				array(
					'type'           => 'color',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'remove_button_color',
					'css_property'   => 'color',
					'selector'       => '%%order_class%% .product-remove .remove:hover',
					'important' 	 => true
				)
			);
		}

		$corners = array(
			'top' 	 => 0,
			'right'  => 1,
			'bottom' => 2,
			'left' 	 => 3
		);

		if( $this->props['table_heading_padding'] !== '.857em|.587em|.857em|.587em|on|on' ){
			$values  = explode( '|', $this->props['table_heading_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% table.shop_table.cart th',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['table_body_padding'] !== '.857em|.587em|.857em|.587em|on|on' ){
			$values  = explode( '|', $this->props['table_body_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% table.shop_table.cart td',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['thumbnail_size'] !== '32px' ){
			$this->generate_styles(
				array(
					'type'           => 'width',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'thumbnail_size',
					'css_property'   => 'width',
					'selector' 		 => '%%order_class%% .product-thumbnail img',
					'important' 	 => true
				)
			);
		}

		$this->setup_woocommerce_cart();

		$multi_view = et_pb_multi_view_options( $this );

		ob_start();

		// woocommerce/templates/cart/cart.php
		?>
		<?php if( WC()->cart && WC()->cart->is_empty() ): ?>

				<?php

				$this->before_empty_cart_render();

				include __DIR__."/templates/cart-empty.php";

				$this->after_empty_cart_render();

				?>

			<?php else: ?>
				<?php do_action( 'woocommerce_before_cart' ); ?>

				<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
						<thead>
							<tr>
								<?php
								foreach( dswcp_get_cart_columns() as $column => $column_text ){

									if( $this->is_hidden( "col_{$column}_state" ) ){
										continue;
									}

									printf(
										'<th class="%1$s" %2$s>%3$s</th>',
										'product-'.esc_html($column),
										et_core_esc_previously(
											$multi_view->render_attrs(
												array(
													'content'        => "{{col_{$column}_text}",
													'visibility' 	 => array(
														"col_{$column}_state" 	 => 'on'
													)
												)
											)
										),
										esc_html($this->props["col_{$column}_text"])
									);
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php do_action( 'woocommerce_before_cart_contents' ); ?>

							<?php
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
									?>
									<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

										<?php if( !$this->is_hidden( 'col_remove_state' ) ): ?>
										<td class="product-remove" <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'remove' ), 'html' ); ?> >
											<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s" %s>%s</a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														'remove',
														/*esc_html( $this->props['remove_button_text'] )*/'',
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() ),
														( $this->props['remove_button_use_image'] !== 'on' || empty( $this->props['remove_button_image'] ) ) && !empty( $this->props['remove_button_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['remove_button_icon'] )).'"' : '',
														$this->props['remove_button_use_image'] === 'on' && !empty( $this->props['remove_button_image'] ) ? '<img src="'.$this->props['remove_button_image'].'" alt="'.esc_html( $this->props['remove_button_text'] ).'" />' : ''
													),
													$cart_item_key
												);
											?>
										</td>
										<?php endif; ?>

										<?php if( !$this->is_hidden( 'col_thumbnail_state' ) ): ?>
										<td class="product-thumbnail" <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'thumbnail' ), 'html' ); ?> >
										<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										if ( ! $product_permalink ) {
											echo $thumbnail; // PHPCS: XSS ok.
										} else {
											printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
										}
										?>
										</td>
										<?php endif; ?>

										<?php if( !$this->is_hidden( 'col_name_state' ) ): ?>
										<td class="product-name" data-title="<?php echo esc_attr( $this->props['col_name_text'] ); ?>" <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'name' ), 'html' ); ?> >
										<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										// Meta data.
										echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'divi-shop-builder' ) . '</p>', $product_id ) );
										}
										?>
										</td>
										<?php endif; ?>

										<?php if( !$this->is_hidden( 'col_price_state' ) ): ?>
										<td class="product-price" data-title="<?php echo esc_attr( $this->props['col_price_text'] ); ?>" <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'price' ), 'html' ); ?> >
											<?php
												echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
											?>
										</td>
										<?php endif; ?>

										<?php if( !$this->is_hidden( 'col_quantity_state' ) ): ?>
										<td class="product-quantity" data-title="<?php echo esc_attr( $this->props['col_quantity_text'] ); ?>"  <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'quantity' ), 'html' ); ?> >
										<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $_product->get_max_purchase_quantity(),
													'min_value'    => '0',
													'product_name' => $_product->get_name(),
												),
												$_product,
												false
											);
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
										?>
										</td>
										<?php endif; ?>

										<?php if( !$this->is_hidden( 'col_subtotal_state' ) ): ?>
										<td class="product-subtotal" data-title="<?php echo esc_attr( $this->props['col_subtotal_text'] ); ?>" <?php echo et_core_intentionally_unescaped( $this->column_multi_view( 'subtotal' ), 'html' ); ?> >
											<?php
												echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
											?>
										</td>
										<?php endif; ?>
									</tr>
									<?php
								}
							}
							?>

							<?php do_action( 'woocommerce_cart_contents' ); ?>

							<tr>
								<td colspan="<?php echo (int) $this->get_visibile_column_count(); ?>" class="actions">

									<?php if ( wc_coupons_enabled() && $this->props['coupon_code_state'] === 'on' ) { ?>
										<div class="coupon" <?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'visibility' => array( 'coupon_code_state' => 'on' ) ) ), 'html' ); ?> >
											<label for="coupon_code" <?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'content' => '{{coupon_code_input_text}}' ) ), 'html' ); ?> >
												<?php echo esc_html( $this->props['coupon_code_input_text'] ); ?>
											</label>
											<input
												type="text" name="coupon_code"
												class="input-text" id="coupon_code"
												value="" placeholder="<?php echo esc_attr( $this->props['coupon_code_input_text'] ); ?>"
												<?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'attrs' => array( 'placeholder' => '{{coupon_code_input_text}}' ) ) ), 'html' ); ?>
											/>
											<button type="submit" class="button <?php echo !empty( $this->props['button_apply_coupon_icon'] ) ? 'et_pb_custom_button_icon' : ''; ?>" name="apply_coupon"
												value="<?php esc_attr_e( 'Apply coupon', 'divi-shop-builder' ); ?>"
												<?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'content' => '{{coupon_code_button_text}}', 'attrs' => array( 'value' => '{{coupon_code_button_text}}' ) ) ), 'html' ); ?>
												<?php echo !empty( $this->props['button_apply_coupon_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['button_apply_coupon_icon'] )).'"' : '' ?>
											>
											<?php echo esc_html( $this->props['coupon_code_button_text'] ); ?>
											</button>
											<?php do_action( 'woocommerce_cart_coupon' ); ?>
										</div>
									<?php } ?>

									<button type="submit" class="button <?php echo !empty( $this->props['button_update_cart_icon'] ) ? 'et_pb_custom_button_icon' : ''; ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'divi-shop-builder' ); ?>"
										<?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'content' => '{{update_cart_button_text}}', 'attrs' => array( 'value' => '{{update_cart_button_text}}' ) ) ), 'html' ); ?>
										<?php echo !empty( $this->props['button_update_cart_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['button_update_cart_icon'] )).'"' : '' ?>
									>
										<?php echo esc_html( $this->props['update_cart_button_text'] ); ?>
									</button>

									<?php do_action( 'woocommerce_cart_actions' ); ?>

									<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
								</td>
							</tr>

							<?php do_action( 'woocommerce_after_cart_contents' ); ?>
						</tbody>
					</table>
					<?php do_action( 'woocommerce_after_cart_table' ); ?>
				</form>

			<?php endif; ?>

		<?php

		return ob_get_clean();
	}


	/**
	 * Helper to check the propery visibility
	 *
	 * @param string
	 * @return boolean
	 */
	private function is_hidden( $prop ){

		$desktop = $this->props[$prop];
		$tablet  = !empty( $this->props["{$prop}_tablet"] ) ? $this->props["{$prop}_tablet"] : 'off';
		$mobile  = !empty( $this->props["{$prop}_mobile"] ) ? $this->props["{$prop}_mobile"] : 'off';

		return $desktop === 'off' && $tablet === 'off' && $mobile === 'off';
	}


	/**
	 * Helper to get column visibility data
	 *
	 * @param string
	 * @return array
	 */
	private function column_multi_view( $col ){
		$multi_view = et_pb_multi_view_options( $this );

		return et_core_esc_previously(
			$multi_view->render_attrs(
				array(
					'attrs' 	 => array(
						'data-title' => "{{col_{$col}_text}}"
					),
					'visibility' => array(
						"col_{$col}_state" => 'on'
					)
				)
			)
		);
	}


	/**
	 * Setup woocommerce cart const and variables
	 *
	 * @see WC_Shortcode_Cart::output
	 */
	private function setup_woocommerce_cart(){

		if( ! WC()->cart ){
			return;
		}

		wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
		
		// woocommerce\includes\shortcodes\class-wc-shortcode-cart.php
		// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended -- wc_get_var is a replacement for isset(); sanitization not needed for nonce value
		$nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) );

		if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) { // WPCS: input var ok.
			WC_Shortcode_Cart::calculate_shipping();

			WC()->cart->calculate_totals();
		}

		do_action( 'woocommerce_check_cart_items' );

		WC()->cart->calculate_totals();
	}

	/**
	 * Remove wc default actions
	 *
	 */
	private function before_empty_cart_render(){
		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
		add_action( 'woocommerce_cart_is_empty', array( $this, 'empty_cart_message' ), 10 );
	}


	/**
	 * Add back wc default actions
	 *
	 */
	private function after_empty_cart_render(){
		remove_action( 'woocommerce_cart_is_empty', array( $this, 'empty_cart_message' ), 10 );
		add_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
	}


	/**
	 * Override wc empty cart message
	 *
	 * @return String
	 */
	public function empty_cart_message(){
		echo sprintf( '<div class="wc-empty-cart-message"><p class="cart-empty woocommerce-info">%s</p></div>', esc_html($this->props['empty_cart_text']) );
	}


	/**
	 * Get only enabled columns count
	 *
	 * @return Int
	 */
	private function get_visibile_column_count(){

		$columns = array_filter( dswcp_get_cart_columns(), function( $column ){
			return !$this->is_hidden( "col_{$column}_state" );
		}, ARRAY_FILTER_USE_KEY );

		return count( $columns );
	}
}

new DSWCP_WooCartList;
