<?php

defined( 'ABSPATH' ) || exit;

use simplehtmldom\HtmlDocument;

/**
 * Module class of Woo Checkout Shipping Info
 *
 */
class DSWCP_WooCheckoutShippingInfo extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_checkout_shipping_info';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Checkout Shipping', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';


		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content' => esc_html__( 'Content', 'divi-shop-builder' ),
					'labels'  => esc_html__( 'Fields label', 'divi-shop-builder' )
				),
			),
			'advanced' => array(
				'toggles' => array (
					'shipping_heading' 	 => esc_html__( 'Heading', 'divi-shop-builder' ),
					'shipping_labels' 	 => esc_html__( 'Labels', 'divi-shop-builder' ),
					'shipping_fields' 	 => esc_html__( 'Fields', 'divi-shop-builder' ),
					'shipping_dropdowns' => esc_html__( 'Dropdown menus', 'divi-shop-builder' )
				)
			)
		);

		/**
		 * Desing tab extra fields
		 *
		 */
		$this->advanced_fields = array(
			'text' 		 => false,
			'fonts'          => array(
				'shipping_labels'  => array(
					'label'           => esc_html__( 'Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '.woocommerce %%order_class%% .form-row label',
						'important' => 'all',
					),
					'font_size'   => array(
						'default' 	=> '14px',
					),
					'line_height' => array(
						'default' 	=> '1.3em',
					),
					'toggle_slug' => 'shipping_labels',
					'font'        => array(
						'default' 	=> '|700|||||||',
					)
				),
				'shipping_heading' => array(
					'label'           => esc_html__( 'Heading', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% .woocommerce-shipping-fields h3',
						'important' => 'all',
					),
					'toggle_slug' => 'shipping_heading'
				)
			),
			'form_field' => array(
				'shipping_fields'         => array(
					'label'           => esc_html__( 'Fields', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'main'                   => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						'background_color'       => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						'background_color_hover' => '.woocommerce %%order_class%% .form-row input.input-text:hover, .woocommerce %%order_class%% .form-row textarea:hover',
						'focus_background_color' => '.woocommerce %%order_class%% .form-row input.input-text:focus, .woocommerce %%order_class%% .form-row textarea:focus',
						'form_text_color'        => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						'form_text_color_hover'  => '.woocommerce %%order_class%% .form-row input.input-text:hover, .woocommerce %%order_class%% .form-row textarea:hover',
						'focus_text_color'       => '.woocommerce %%order_class%% .form-row input.input-text:focus, .woocommerce %%order_class%% .form-row textarea:focus',
						'placeholder_focus'      => '.woocommerce %%order_class%% .form-row input.input-text:focus::-webkit-input-placeholder, .woocommerce %%order_class%% .form-row textarea:focus::-webkit-input-placeholder, .woocommerce %%order_class%% .form-row input.input-text:focus::-moz-placeholder, .woocommerce %%order_class%% .form-row textarea:focus::-moz-placeholder, .woocommerce %%order_class%% .form-row input.input-text:focus:-ms-input-placeholder, .woocommerce %%order_class%% .form-row textarea:focus:-ms-input-placeholder',
						'padding'                => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						'margin'                 => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
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
						'name'              => 'shipping_fields',
						'css'               => array(
							'main' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'shipping_fields'       => array(
							'name'         => 'shipping_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
									'border_styles' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'label_prefix' => esc_html__( 'Fields', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '.woocommerce %%order_class%% .form-row input.input-text:focus, .woocommerce %%order_class%% .form-row textarea:focus',
									'border_styles' => '.woocommerce %%order_class%% .form-row input.input-text:focus, .woocommerce %%order_class%% .form-row textarea:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
							),
							'hover'     => array(
								'.woocommerce %%order_class%% .form-row input.input-text:hover, .woocommerce %%order_class%% .form-row textarea:hover',
								'.woocommerce %%order_class%% .form-row input.input-text:hover::-webkit-input-placeholder, .woocommerce %%order_class%% .form-row textarea:hover::-webkit-input-placeholder',
								'.woocommerce %%order_class%% .form-row input.input-text:hover::-moz-placeholder, .woocommerce %%order_class%% .form-row textarea:hover::-moz-placeholder',
								'.woocommerce %%order_class%% .form-row input.input-text:hover:-ms-input-placeholder, .woocommerce %%order_class%% .form-row textarea:hover:-ms-input-placeholder',
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '14px',
						),
						'line_height' => array(
							'default' => 'normal',
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
							'padding'   => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
							'margin'    => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin' => array(
							'default' => '0|0|0|0|false|false',
						),
					),
				),
				'shipping_dropdowns'         => array(
					'label'           => esc_html__( 'Fields', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'main'                   => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
						'background_color'       => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
						'background_color_hover' => '.woocommerce %%order_class%% .form-row select:hover, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:hover',
						'focus_background_color' => '.woocommerce %%order_class%% .form-row select:focus, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:focus',
						'form_text_color'        => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single .select2-selection__rendered',
						'form_text_color_hover'  => '.woocommerce %%order_class%% .form-row select:hover, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered',
						'focus_text_color'       => '.woocommerce %%order_class%% .form-row select:focus, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:focus .select2-selection__rendered',
						'placeholder_focus'      => '.woocommerce %%order_class%% .form-row select:focus::-webkit-input-placeholder, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, .woocommerce %%order_class%% .form-row input.input-text:focus::-moz-placeholder, .woocommerce %%order_class%% .form-row textarea:focus::-moz-placeholder, .woocommerce %%order_class%% .form-row input.input-text:focus:-ms-input-placeholder, .woocommerce %%order_class%% .form-row textarea:focus:-ms-input-placeholder',
						'padding'                => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
						'margin'                 => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
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
						'name'              => 'shipping_dropdowns',
						'css'               => array(
							'main' => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'shipping_dropdowns'       => array(
							'name'         => 'shipping_dropdowns',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
									'border_styles' => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							)
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '.woocommerce %%order_class%% .form-row select:focus, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:focus',
									'border_styles' => '.woocommerce %%order_class%% .form-row select:focus, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:focus',
								),
								'important' => 'all',
							)
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single .select2-selection__rendered',
							),
							'hover'     => array(
								'.woocommerce %%order_class%% .form-row select:hover, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered'
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '14px',
						),
						'line_height' => array(
							'default' => 'normal',
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
							'padding'   => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
							'margin'    => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin' => array(
							'default' => '0|0|0|0|false|false',
						),
					),
				),
			)
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'shipping_fields_heading' => array(
				'label'    => esc_html__( 'Heading', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .woocommerce-shipping-fields h3',
			),
			'shipping_fields_labels'  => array(
				'label'    => esc_html__( 'Labels', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row label',
			),
			'shipping_fields' 		 => array(
				'label'    => esc_html__( 'Fields', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
			),
			'shipping_fields_dropdown'=> array(
				'label'    => esc_html__( 'Dropdowns', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
			),
		);

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}


	/**
	 * State/ Content fields to control the form behavior
	 *
	 * @return array
	 *
	 */
	public function get_fields() {
		return array(
			'warning' => array(
				'type'        => 'ags_wc_warning-DSB',
				'toggleVar'   => 'ags_divi_wc_notCheckoutPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module may not function properly on the front end of your website because this is not the assigned Checkout page.', 'divi-shop-builder' ),
				'toggle_slug' => 'content'
			),
			'shipping_title' 	  => array(
				'label'           => esc_html__( 'Shipping title text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Ship to a different address?', 'divi-shop-builder'  ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'shipping_toggled' 	  => array(
				'label'           => esc_html__( 'Shipping title toggled', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'show_order_notes' 	  => array(
				'label'           => esc_html__( 'Show order notes?', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content'
			),
			'first_name_label'    => array(
				'label'           => esc_html__( 'First Name', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'First name', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'last_name_label'     => array(
				'label'           => esc_html__( 'Last Name', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Last name', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'company_label' 	  => array(
				'label'           => esc_html__( 'Company', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Company name', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'country_label' 	  => array(
				'label'           => esc_html__( 'Country', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Country / Region', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'address_1_label' 	  => array(
				'label'           => esc_html__( 'Address 1', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Street address', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'city_label' 	  	  => array(
				'label'           => esc_html__( 'City', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Town / City', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'state_label' 	  	  => array(
				'label'           => esc_html__( 'State', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'State / County', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'postcode_label' 	  => array(
				'label'           => esc_html__( 'Postcode', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Postcode / ZIP', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'order_comments_label'=> array(
				'label'           => esc_html__( 'Order Notes', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Order notes', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
		);
	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {

		/**
		 * Checked attribute is considered as non-safe attribute in et_core_esc_attr function
		 * Therefore we use it only for our module to make sure it doesnt work outside
		 * Will remove it after rendering
		 *
		 * @see Function et_core_esc_attr
		 *
		 */
		add_filter( 'et_core_esc_attr', array( $this, 'set_checked_attrs_to_et_core_esc_attr' ), 10, 3 );

		remove_action( 'woocommerce_checkout_shipping', array( WC()->checkout(), 'checkout_form_shipping' ), 10 ); // remove wc default checkout shipping
		add_action( 'woocommerce_checkout_shipping', array( $this, 'checkout_shipping_template' ) ); // add plugin checkout shipping model
		add_filter( 'woocommerce_form_field', array( $this, 'checkout_shipping_labels' ), 99, 4 ); // add filter of label override
		add_filter( 'woocommerce_enable_order_notes_field', array( $this, 'checkout_shipping_order_notes' ), 99 ); // add filter of order notes
		add_filter( 'woocommerce_ship_to_different_address_checked', array( $this, 'checkout_shipping_toggled' ), 99 ); // add filter of shipping toggle
		add_action( 'wp_print_footer_scripts', array( $this, 'checkout_shipping_labels_localized_script' ) ); // override shipping label locals

		ob_start();
		do_action( 'woocommerce_checkout_shipping', WC()->checkout() );
		$content = ob_get_clean();

		remove_action( 'woocommerce_checkout_shipping', array( $this, 'checkout_shipping_template' ) ); // remove plugin checkout shipping model
		remove_filter( 'woocommerce_form_field', array( $this, 'checkout_shipping_labels' ), 99 ); // remove filter of label override
		remove_filter( 'woocommerce_enable_order_notes_field', array( $this, 'checkout_shipping_order_notes' ), 99 ); // remove filter of order notes
		remove_filter( 'woocommerce_ship_to_different_address_checked', array( $this, 'checkout_shipping_toggled' ), 99 ); // remove filter of shipping toggle
		add_action( 'woocommerce_checkout_shipping', array( WC()->checkout(), 'checkout_form_shipping' ) ); // add wc default shipping
		remove_filter( 'et_core_esc_attr', array( $this, 'set_checked_attrs_to_et_core_esc_attr' ), 10 ); // remove checked attribute filter

		return $content;
	}


	/**
	 * Coupon template hook
	 *
	 */
	public function checkout_shipping_template(){

		if( !WC()->cart || !WC()->customer ){
			return;
		}

		ob_start();
		include __DIR__.'/templates/form-shipping.php';
		echo et_core_intentionally_unescaped( ob_get_clean(), 'html' );
	}


	/**
	 * Override label data
	 *
	 */
	public function checkout_shipping_labels( $field, $name, $args, $value  ){

		$name 		= str_replace( 'shipping_', '', $name );
		$multi_view = et_pb_multi_view_options( $this );
		$attributes = $multi_view->render_attrs( array( 'content' => "{{{$name}_label}} {$this->get_abbr_html($field)}" ) );

		if( !empty( $this->props["{$name}_label"] ) ){
			$field = str_replace( $args['label'], $this->props["{$name}_label"], $field );
		}

		if( !empty( $attributes ) ){
			$field = str_replace( '<label', '<label ' . $attributes, $field );
		}

		return $field;
	}


	/**
	 * Override WC Address fields locals
	 *
	 */
	public function checkout_shipping_labels_localized_script(){

		$data 	 = WC()->countries->get_country_locale();
		$country = WC()->countries->get_base_country();


		foreach( $data as $code => $local ){
			if( !in_array( $code, array( 'default', $country ) ) ){
				continue;
			}

			foreach( $data[$code] as $name => $field ){

				if( !empty( $this->props["{$name}_label"] ) && isset( $data[$code][$name]['label'] ) ){
					$data[$code][$name]['label'] = $this->props["{$name}_label"];
				}
			}
		}
		?>
		<script type="text/javascript">
		if( !window.ags_address_i18n_params ){
			window.ags_address_i18n_params = {};
		}
		window.ags_address_i18n_params.shipping = JSON.stringify(<?php echo wp_json_encode( $data ); ?>);
		</script>
		<?php
	}

	/**
	 * Pluck the abbr tag from the woocommerce field
	 *
	 * @return String
	 *
	 */
	private function get_abbr_html( $field ){

		$dom 		= new HtmlDocument();
		$field_html = $dom->load( $field );

		$abbr 		= $field_html->find('label abbr', 0);

		if( $abbr ){
			return $abbr->outertext;
		}

		return "";
	}

	/**
	 * Localized data for the module
	 *
	 * @return Array
	 *
	 */
	public function builder_js_data( $js_data ){

		$locals = array(
			'countries' => array_merge( array( 'default' => esc_html( 'Select a country / region&hellip;' ) ), WC()->countries->get_countries() )
		);

		$js_data['shipping_info'] = $locals;

		return $js_data;
	}


	public function checkout_shipping_order_notes( $visibility ){
		return $this->props['show_order_notes'] === 'on';
	}


	public function checkout_shipping_toggled( $toggled ){
		return $this->props['shipping_toggled'] === 'on';
	}

	public function set_checked_attrs_to_et_core_esc_attr( $allowed_attrs_default, $attr_key, $attr_value ){

		if( $attr_key === 'checked' ){
			$allowed_attrs_default['checked'] = 'esc_attr';
		}

		return $allowed_attrs_default;
	}
}

new DSWCP_WooCheckoutShippingInfo;
