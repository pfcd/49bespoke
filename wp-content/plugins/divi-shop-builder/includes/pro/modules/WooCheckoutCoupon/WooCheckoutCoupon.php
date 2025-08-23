<?php
defined( 'ABSPATH' ) || exit;


/**
 * Module class of Woo Checkout Coupon
 *
 */
class DSWCP_WooCheckoutCoupon extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_checkout_coupon';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Checkout Coupon', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

		/**
		 * Toggle Sections of General tab and Design tab
		 *
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content'     => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'coupon_toggle'   => array(
						'title'    => esc_html__( 'Coupon Toggle', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'coupon_content'   => array(
						'title'    => esc_html__( 'Coupon Content', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'apply_coupon_button'   => array(
						'title'    => esc_html__( 'Apply Coupon Button', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'coupon_field'   => array(
						'title'    => esc_html__( 'Coupon Code Field', 'divi-shop-builder' ),
						'priority' => 45,
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
				'coupon_toggle' => array(
					'label'           => esc_html__( 'Coupon Toggle', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-form-coupon-toggle > .woocommerce-info',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '18px',
					),
					'line_height'     => array(
						'default' => '',
					),
					'toggle_slug'     => 'coupon_toggle',
				),
				'coupon_content' => array(
					'label'           => esc_html__( 'Coupon Content', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-form-coupon',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'toggle_slug'     => 'coupon_content',
				),
			),
			'borders' => array(
				'coupon_content'    => array(
					'label'           => esc_html__( 'Coupon Content Border', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon',
							'border_radii' 	=> '%%order_class%% .checkout_coupon.woocommerce-form-coupon'
						),
						'important' => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#d3ced2'
						),
					),
					'toggle_slug'     => 'coupon_content',
				)
			),
			'button'         => array(
				'apply_coupon_button' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'use_alignment'  => true,
					'css'            => array(
						'main'         => '%%order_class%% .checkout_coupon.woocommerce-form-coupon button.button',
						'alignment'    => '%%order_class%% .checkout_coupon.woocommerce-form-coupon > .form-row-last',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .checkout_coupon.woocommerce-form-coupon button.button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'toggle_slug'     => 'apply_coupon_button',
				),
			),
			'form_field'     => array(
				'coupon_field'       => array(
					'label'           => esc_html__( 'Coupon code field', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'main'                   => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
						'background_color'       => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
						'background_color_hover' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover',
						'focus_background_color' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:focus',
						'form_text_color'        => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
						'form_text_color_hover'  => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover',
						'focus_text_color'       => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:focus',
						'placeholder_focus'      => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:focus::-webkit-input-placeholder, %%order_class%% table.cart td.actions .coupon input.input-text::-moz-placeholder, %%order_class%% table.cart td.actions .coupon input.input-text:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
						'margin'                 => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
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
						'name'              => 'coupon_field',
						'css'               => array(
							'main' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'coupon_field'       => array(
							'name'         => 'coupon_field',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
									'border_styles' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
									'defaults'      => array(
										'border_radii'  => 'on|3px|3px|3px|3px',
										'border_styles' => array(
											'width' => '0px',
											'style' => 'none',
										),
									),
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Field', 'divi-shop-builder' ),
						),
						'coupon_field_focus' => array(
							'name'         => 'coupon_field_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
									'border_styles' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Field Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
							),
							'hover'     => array(
								'%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover',
								'%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover::-webkit-input-placeholder',
								'%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover::-moz-placeholder',
								'%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text:hover:-ms-input-placeholder',
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
							'main'      => '%%order_class%% .checkout_coupon.woocommerce-form-coupon input.input-text',
							'important' => array( 'custom_padding' ),
						),
					),
				)
			)
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'coupon_toggle'    => array(
				'label'    => esc_html__( 'Coupon Toggle', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .woocommerce-form-coupon-toggle > .woocommerce-info',
			),
			'coupon_content'    => array(
				'label'    => esc_html__( 'Coupon Content', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .checkout_coupon.woocommerce-form-coupon',
			)
		);
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
				'toggleVar'   => 'ags_divi_wc_notCheckoutPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module may not function properly on the front end of your website because this is not the assigned Checkout page.', 'divi-shop-builder' ),
				'toggle_slug' => 'content'
			),
			'coupon_toggle_model' => array(
				'label'           => esc_html__( 'Show coupon via toggle', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_toggle_title' => array(
				'label'           => esc_html__( 'Coupon toggle title', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Have a coupon?', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
				'show_if' 		  => array( 'coupon_toggle_model' => 'on' )
			),
			'coupon_toggle_text' => array(
				'label'           => esc_html__( 'Coupon toggle clickable text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Click here to enter your code', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
				'show_if' 		  => array( 'coupon_toggle_model' => 'on' )
			),
			'coupon_content_text' => array(
				'label'           => esc_html__( 'Coupon content text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'If you have a coupon code, please apply it below.', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_input_placeholder' => array(
				'label'           => esc_html__( 'Coupon input placeholder', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Coupon code', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_button_text' => array(
				'label'           => esc_html__( 'Apply coupon button text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Apply coupon', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'coupon_toggle_bg_color' => array(
				'label'          => esc_html__( 'Coupon Toggle Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'coupon_toggle',
				'default'        => '#2ea3f2',
			),
		);
	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {

		if (is_admin()) {
			WC()->frontend_includes();
			wc_load_cart();
		}
		
		// to generate toggle background color
		$this->generate_styles(
			array(
				'responsive'     => true,
				'render_slug'    => $render_slug,
				'base_attr_name' => 'coupon_toggle_bg_color',
				'css_property'   => 'background-color',
				'selector'       => '%%order_class%% .woocommerce-form-coupon-toggle > .woocommerce-info',
				'important' 	 => true
			)
		);

		$this->set_module_classes();

		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); // remove wc default coupon
		add_action( 'woocommerce_before_checkout_form', array( $this, 'coupon_template' ) ); // add plugin coupon model

		ob_start();
		do_action( 'woocommerce_before_checkout_form', WC()->checkout() );
		$content = ob_get_clean();

		remove_action( 'woocommerce_before_checkout_form', array( $this, 'coupon_template' ) ); // remove plugin coupon model
		add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' ); // add wc default coupon

		return $content;
	}


	/**
	 * Coupon template hook
	 *
	 */
	public function coupon_template(){

		ob_start();
		include __DIR__.'/templates/form-coupon.php';
		echo et_core_intentionally_unescaped( str_replace('id="coupon_code"', '', ob_get_clean()), 'html' );
	}


	/**
	 * Add module classes to root element
	 *
	 */
	public function set_module_classes(){

		$classes = array();

		if( $this->props['coupon_toggle_model'] === 'off' ){
			$classes[] = 'toggle_model_off';
		}

		if( $this->props['coupon_toggle_model_tablet'] === 'off' ){
			$classes[] = 'toggle_model_tablet_off';
		}

		if( $this->props['coupon_toggle_model_phone'] === 'off' ){
			$classes[] = 'toggle_model_phone_off';
		}

		if( count( $classes ) ){
			$this->add_classname( implode( ' ', $classes ) );
		}

	}
}

new DSWCP_WooCheckoutCoupon;
