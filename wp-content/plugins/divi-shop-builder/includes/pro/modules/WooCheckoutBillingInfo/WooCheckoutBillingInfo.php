<?php

defined( 'ABSPATH' ) || exit;

use simplehtmldom\HtmlDocument;

/**
 * Module class of Woo Checkout Billing Info
 *
 */
class DSWCP_WooCheckoutBillingInfo extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_checkout_billing_info';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Checkout Billing', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';


		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content' => esc_html__( 'Content', 'divi-shop-builder' ),
					'labels' => esc_html__( 'Fields label', 'divi-shop-builder' )
				),
			),
			'advanced' => array(
				'toggles' => array (
					'billing_heading' 	=> esc_html__( 'Heading', 'divi-shop-builder' ),
					'billing_labels' 	=> esc_html__( 'Labels', 'divi-shop-builder' ),
					'billing_fields' 	=> esc_html__( 'Fields', 'divi-shop-builder' ),
					'billing_dropdowns' => esc_html__( 'Dropdown menus', 'divi-shop-builder' )
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
				'billing_labels'  => array(
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
					'toggle_slug' => 'billing_labels',
					'font'        => array(
						'default' 	=> '|700|||||||',
					)
				),
				'billing_heading' => array(
					'label'           => esc_html__( 'Heading', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% .woocommerce-billing-fields h3',
						'important' => 'all',
					),
					'toggle_slug' => 'billing_heading'
				)
			),
			'form_field' => array(
				'billing_fields'         => array(
					'label'           => esc_html__( 'Fields', 'divi-shop-builder' ),
					'toggle_priority' => 67,
					'css'             => array(
						'background_color'       => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
						'main'                   => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
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
						'name'              => 'billing_fields',
						'css'               => array(
							'main' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
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
				'billing_dropdowns'         => array(
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
						'name'              => 'billing_dropdowns',
						'css'               => array(
							'main' => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'billing_dropdowns'       => array(
							'name'         => 'billing_dropdowns',
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
									'width' => '1px',
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
			'billing_fields_heading' => array(
				'label'    => esc_html__( 'Heading', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .woocommerce-billing-fields h3',
			),
			'billing_fields_labels'  => array(
				'label'    => esc_html__( 'Labels', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row label',
			),
			'billing_fields' 		 => array(
				'label'    => esc_html__( 'Fields', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
			),
			'billing_fields_dropdown'=> array(
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
			'billing_title' 	  => array(
				'label'           => esc_html__( 'Billing title text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Billing details', 'divi-shop-builder'  ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
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
			'phone_label' 		  => array(
				'label'           => esc_html__( 'Phone', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Phone', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			),
			'email_label' 		  => array(
				'label'           => esc_html__( 'Email', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Email address', 'divi-shop-builder'  ),
				'toggle_slug'     => 'labels',
				'mobile_options'  => true
			)
		);
	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {

		if( !WC()->cart || !WC()->customer ){
			return;
		}

		remove_action( 'woocommerce_checkout_billing', array( WC()->checkout(), 'checkout_form_billing' ), 10 ); // remove wc default checkout billing
		add_action( 'woocommerce_checkout_billing', array( $this, 'checkout_billing_template' ) ); // add plugin checkout billing model
		add_filter( 'woocommerce_form_field', array( $this, 'checkout_billing_labels' ), 99, 4 ); // add filter of label override
		add_action( 'wp_print_footer_scripts', array( $this, 'checkout_billing_labels_localized_script' ) ); // override billing label locals

		ob_start();
		do_action( 'woocommerce_checkout_billing', WC()->checkout() );
		$content = ob_get_clean();

		remove_action( 'woocommerce_checkout_billing', array( $this, 'checkout_billing_template' ) ); // remove plugin checkout billing model
		remove_filter( 'woocommerce_form_field', array( $this, 'checkout_billing_labels' ), 99 ); // remove filter of label override
		add_action( 'woocommerce_checkout_billing', array( WC()->checkout(), 'checkout_form_billing' ) ); // add wc default billing

		return $content;
	}


	/**
	 * Coupon template hook
	 *
	 */
	public function checkout_billing_template(){

		ob_start();
		include __DIR__.'/templates/form-billing.php';
		echo et_core_intentionally_unescaped(ob_get_clean(), 'html');
	}


	/**
	 * Override label data
	 *
	 */
	public function checkout_billing_labels( $field, $name, $args, $value  ){

		$name 		= str_replace( 'billing_', '', $name );
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

		$js_data['billing_info'] = $locals;

		return $js_data;
	}


	/**
	 * Override WC Address fields locals
	 *
	 */
	public function checkout_billing_labels_localized_script(){

		$data 	 = WC()->countries->get_country_locale();
		$country = WC()->countries->get_base_country();


		foreach( $data as $code => $local ){
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
		window.ags_address_i18n_params.billing = JSON.stringify(<?php echo wp_json_encode( $data ); ?>);
		</script>
		<?php
	}
}

new DSWCP_WooCheckoutBillingInfo;
