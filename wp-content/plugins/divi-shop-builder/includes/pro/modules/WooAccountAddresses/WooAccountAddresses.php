<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Addresses
 *
 */
class DSWCP_WooAccountAddresses extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_addresses';
	public $vb_support 		= 'on';
	protected $endpoint		= 'edit-address';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Addresses', 'divi-shop-builder' );
		$this->icon  = '/';


		$this->settings_modal_toggles = array(
			'advanced'	=> array(
				'toggles' => array(
					'text'   		=> array(
						'title'             => esc_html__( 'Text', 'divi-shop-builder' ),
						'priority'          => 45,
					),
					'billing'   		=> array(
						'title'             => esc_html__( 'Billing Details', 'divi-shop-builder' ),
						'priority'          => 46,
					),
					'shipping' 	   => array(
						'title'             => esc_html__( 'Shipping Details', 'divi-shop-builder' ),
						'priority'          => 47
					),
					'billing_form'   		=> array(
						'title'             => esc_html__( 'Billing Form', 'divi-shop-builder' ),
						'priority'          => 48,
					),
					'shipping_form' 	   => array(
						'title'             => esc_html__( 'Shipping Form', 'divi-shop-builder' ),
						'priority'          => 49
					),
					'edit_button'		=> array(
						'title'             => esc_html__( 'Edit Buttons', 'divi-shop-builder' ),
						'priority'          => 50
					),
					'submit_button'		=> array(
						'title'             => esc_html__( 'Submit Buttons', 'divi-shop-builder' ),
						'priority'          => 51
					)
				)
			)
		);

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->advanced_fields = array(
			'fonts' => array(
				'text'     => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'text'
				),
				'billing_title'		 => array(
					'label'       => esc_html__( 'Billing Title', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .u-column1.woocommerce-Address .woocommerce-Address-title h3",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => '22px',
					),
					'toggle_slug' => 'billing'
				),
				'billing_address'    => array(
					'label'       => esc_html__( 'Billing Address', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .u-column1.woocommerce-Address address",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'billing'
				),
				'shipping_title'     => array(
					'label'       => esc_html__( 'Shipping Title', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .u-column2.woocommerce-Address .woocommerce-Address-title h3",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => '22px',
					),
					'toggle_slug' => 'shipping'
				),
				'shipping_address'   => array(
					'label'       => esc_html__( 'Shipping Address', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .u-column2.woocommerce-Address address",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'shipping'
				),
				'billing_label'     => array(
					'label'       => esc_html__( 'Billing Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .form-row[id^='billing_'] label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'billing_form',
					'toggle_priority' => 10,
				),
				'shipping_label'     => array(
					'label'       => esc_html__( 'Shipping Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .form-row[id^='shipping_'] label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'shipping_form',
					'toggle_priority' => 10,
				)
			),
			'borders' => array(
				'table' => array(
					'label_prefix'	  => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "{$this->main_css_element} table.woocommerce-table--order-downloads",
							'border_radii' 	=> "{$this->main_css_element} table.woocommerce-table--order-downloads"
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
				'td' => array(
					'label_prefix'    => esc_html__( 'Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "{$this->main_css_element} table.woocommerce-table--order-downloads td",
							'border_radii' 	=> "{$this->main_css_element} table.woocommerce-table--order-downloads td"
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'solid',
							'color' => '#eee'
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_style_top' => 'solid',
								'border_color_top' => '#eee',
							),
						)
					),
					'toggle_slug' 	  => 'table_column'
				)
			),
			'button' => array(
				'button_edit' => array(
					'label'          => esc_html__( 'Edit Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'edit_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .woocommerce-Address .woocommerce-Address-title a.edit",
						'important'    => 'all',
					),
					'border_width' => array(
						'default' => '0px'
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .woocommerce-Address .woocommerce-Address-title a.edit",
							'important' => true,
						),
					)
				),
				'button_submit' => array(
					'label'          => esc_html__( 'Submit Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'submit_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .woocommerce-address-fields p button[type='submit']",
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .woocommerce-address-fields p button[type='submit']",
							'important' => true,
						),
					)
				)

			),
			'form_field' => array(
				'billing_fields'         => array(
					'label'           => esc_html__( 'Billing Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'billing_form',
					'toggle_priority' => 60,
					'css'             => array(
						'background_color'       => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
						'main'                   => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
						'background_color_hover' => '%%order_class%% .form-row[id^="billing_"] input.input-text:hover, %%order_class%% .form-row[id^="billing_"] textarea:hover',
						'focus_background_color' => '%%order_class%% .form-row[id^="billing_"] input.input-text:focus, %%order_class%% .form-row[id^="billing_"] textarea:focus',
						'form_text_color'        => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
						'form_text_color_hover'  => '%%order_class%% .form-row[id^="billing_"] input.input-text:hover, %%order_class%% .form-row[id^="billing_"] textarea:hover',
						'focus_text_color'       => '%%order_class%% .form-row[id^="billing_"] input.input-text:focus, %%order_class%% .form-row[id^="billing_"] textarea:focus',
						'placeholder_focus'      => '%%order_class%% .form-row[id^="billing_"] input.input-text:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="billing_"] input.input-text:focus::-moz-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:focus::-moz-placeholder, %%order_class%% .form-row[id^="billing_"] input.input-text:focus:-ms-input-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
						'margin'                 => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
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
						'name'              => 'billing_fields',
						'css'               => array(
							'main' => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'billing_fields'       => array(
							'name'         => 'billing_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
									'border_styles' => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'label_prefix' => esc_html__( 'Billing Fields', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="billing_"] input.input-text:focus, %%order_class%% .form-row[id^="billing_"] textarea:focus',
									'border_styles' => '%%order_class%% .form-row[id^="billing_"] input.input-text:focus, %%order_class%% .form-row[id^="billing_"] textarea:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Billing Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
							),
							'hover'     => array(
								'%%order_class%% .form-row[id^="billing_"] input.input-text:hover, %%order_class%% .form-row[id^="billing_"] textarea:hover',
								'%%order_class%% .form-row[id^="billing_"] input.input-text:hover::-webkit-input-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:hover::-webkit-input-placeholder',
								'%%order_class%% .form-row[id^="billing_"] input.input-text:hover::-moz-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:hover::-moz-placeholder',
								'%%order_class%% .form-row[id^="billing_"] input.input-text:hover:-ms-input-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:hover:-ms-input-placeholder',
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
							'main'      => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
							'padding'   => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
							'margin'    => '%%order_class%% .form-row[id^="billing_"] input.input-text, %%order_class%% .form-row[id^="billing_"] textarea',
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
				'billing_dropdowns'         => array(
					'label'           => esc_html__( 'Billing Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'billing_form',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
						'background_color'       => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
						'background_color_hover' => '%%order_class%% .form-row[id^="billing_"] select:hover, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:hover',
						'focus_background_color' => '%%order_class%% .form-row[id^="billing_"] select:focus, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:focus',
						'form_text_color'        => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single .select2-selection__rendered',
						'form_text_color_hover'  => '%%order_class%% .form-row[id^="billing_"] select:hover, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered',
						'focus_text_color'       => '%%order_class%% .form-row[id^="billing_"] select:focus, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:focus .select2-selection__rendered',
						'placeholder_focus'      => '%%order_class%% .form-row[id^="billing_"] select:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="billing_"] input.input-text:focus::-moz-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:focus::-moz-placeholder, %%order_class%% .form-row[id^="billing_"] input.input-text:focus:-ms-input-placeholder, %%order_class%% .form-row[id^="billing_"] textarea:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
						'margin'                 => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
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
						'name'              => 'billing_dropdowns',
						'css'               => array(
							'main' => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'label_prefix' => esc_html__( 'Billing Fields', 'divi-shop-builder' ),
					),
					'border_styles'   => array(
						'billing_dropdowns'       => array(
							'name'         => 'billing_dropdowns',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
									'border_styles' => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'label_prefix' => esc_html__( 'Billing Dropdowns', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="billing_"] select:focus, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:focus',
									'border_styles' => '%%order_class%% .form-row[id^="billing_"] select:focus, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Billing Dropdowns Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single .select2-selection__rendered',
							),
							'hover'     => array(
								'%%order_class%% .form-row[id^="billing_"] select:hover, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered'
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
							'main'      => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
							'padding'   => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
							'margin'    => '%%order_class%% .form-row[id^="billing_"] select, %%order_class%% .form-row[id^="billing_"] .select2.select2-container .select2-selection--single',
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
				'shipping_fields'         => array(
					'label'           => esc_html__( 'Shipping Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'shipping_form',
					'toggle_priority' => 60,
					'css'             => array(
						'background_color'       => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
						'main'                   => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
						'background_color_hover' => '%%order_class%% .form-row[id^="shipping_"] input.input-text:hover, %%order_class%% .form-row[id^="shipping_"] textarea:hover',
						'focus_background_color' => '%%order_class%% .form-row[id^="shipping_"] input.input-text:focus, %%order_class%% .form-row[id^="shipping_"] textarea:focus',
						'form_text_color'        => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
						'form_text_color_hover'  => '%%order_class%% .form-row[id^="shipping_"] input.input-text:hover, %%order_class%% .form-row[id^="shipping_"] textarea:hover',
						'focus_text_color'       => '%%order_class%% .form-row[id^="shipping_"] input.input-text:focus, %%order_class%% .form-row[id^="shipping_"] textarea:focus',
						'placeholder_focus'      => '%%order_class%% .form-row[id^="shipping_"] input.input-text:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="shipping_"] input.input-text:focus::-moz-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:focus::-moz-placeholder, %%order_class%% .form-row[id^="shipping_"] input.input-text:focus:-ms-input-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
						'margin'                 => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
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
							'main' => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
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
									'border_radii'  => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
									'border_styles' => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'label_prefix' => esc_html__( 'Shipping Fields', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="shipping_"] input.input-text:focus, %%order_class%% .form-row[id^="shipping_"] textarea:focus',
									'border_styles' => '%%order_class%% .form-row[id^="shipping_"] input.input-text:focus, %%order_class%% .form-row[id^="shipping_"] textarea:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Shipping Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
							),
							'hover'     => array(
								'%%order_class%% .form-row[id^="shipping_"] input.input-text:hover, %%order_class%% .form-row[id^="shipping_"] textarea:hover',
								'%%order_class%% .form-row[id^="shipping_"] input.input-text:hover::-webkit-input-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:hover::-webkit-input-placeholder',
								'%%order_class%% .form-row[id^="shipping_"] input.input-text:hover::-moz-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:hover::-moz-placeholder',
								'%%order_class%% .form-row[id^="shipping_"] input.input-text:hover:-ms-input-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:hover:-ms-input-placeholder',
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
							'main'      => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
							'padding'   => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
							'margin'    => '%%order_class%% .form-row[id^="shipping_"] input.input-text, %%order_class%% .form-row[id^="shipping_"] textarea',
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
					'label'           => esc_html__( 'Shipping Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'shipping_form',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
						'background_color'       => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
						'background_color_hover' => '%%order_class%% .form-row[id^="shipping_"] select:hover, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:hover',
						'focus_background_color' => '%%order_class%% .form-row[id^="shipping_"] select:focus, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:focus',
						'form_text_color'        => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single .select2-selection__rendered',
						'form_text_color_hover'  => '%%order_class%% .form-row[id^="shipping_"] select:hover, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered',
						'focus_text_color'       => '%%order_class%% .form-row[id^="shipping_"] select:focus, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:focus .select2-selection__rendered',
						'placeholder_focus'      => '%%order_class%% .form-row[id^="shipping_"] select:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, %%order_class%% .form-row[id^="shipping_"] input.input-text:focus::-moz-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:focus::-moz-placeholder, %%order_class%% .form-row[id^="shipping_"] input.input-text:focus:-ms-input-placeholder, %%order_class%% .form-row[id^="shipping_"] textarea:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
						'margin'                 => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
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
							'main' => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
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
									'border_radii'  => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
									'border_styles' => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single'
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'label_prefix' => esc_html__( 'Shipping Dropdowns', 'divi-shop-builder' )
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .form-row[id^="shipping_"] select:focus, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:focus',
									'border_styles' => '%%order_class%% .form-row[id^="shipping_"] select:focus, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:focus',
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Shipping Dropdowns Focus', 'divi-shop-builder' )
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single .select2-selection__rendered',
							),
							'hover'     => array(
								'%%order_class%% .form-row[id^="shipping_"] select:hover, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered'
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
							'main'      => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
							'padding'   => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
							'margin'    => '%%order_class%% .form-row[id^="shipping_"] select, %%order_class%% .form-row[id^="shipping_"] .select2.select2-container .select2-selection--single',
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
			),
			'link_options' => false
		);

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function get_fields(){
		return array();
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		$button_edit_use_icon = !empty( $this->props['button_edit_use_icon'] ) ? $this->props['button_edit_use_icon'] : 'off';
		if(  $button_edit_use_icon === 'on' && !empty( $this->props['button_edit_icon'] ) ){
			$icon 	   = dswcp_decoded_et_icon( $this->props['button_edit_icon'] );
			$placement = $this->props['button_edit_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .woocommerce-Address .woocommerce-Address-title a.edit::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		$button_submit_use_icon = !empty( $this->props['button_submit_use_icon'] ) ? $this->props['button_submit_use_icon'] : 'off';
		if( $button_submit_use_icon === 'on' && !empty( $this->props['button_submit_icon'] ) ){
			$icon 	   = dswcp_decoded_et_icon( $this->props['button_submit_icon'] );
			$placement = $this->props['button_submit_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .woocommerce-address-fields p button[type='submit']::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		$address_type = get_query_var( get_option( 'woocommerce_myaccount_edit_address_endpoint', 'edit-address' ), false );

		ob_start();

		woocommerce_account_edit_address($address_type);

		return sprintf( '<div class="%s"><div class="%s">%s</div></div>', 'woocommerce', 'woocommerce-MyAccount-content', ob_get_clean() );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'html_output' => $this->render( array(), null, $this->slug ),
			'billing_form' => $this->get_address_form_html( 'billing' ),
			'shipping_form' => $this->get_address_form_html( 'shipping' ),
		);

		$data['account_addresses'] = $locals;

		return $data;
	}

	private function get_address_form_html( $type = 'billing' ){
		ob_start();

		woocommerce_account_edit_address( $type );

		return ob_get_clean();
	}
}

new DSWCP_WooAccountAddresses;