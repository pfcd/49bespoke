<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Details
 *
 */
class DSWCP_WooAccountDetails extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_details';
	public $vb_support 		= 'on';
	protected $endpoint		= 'edit-account';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Details', 'divi-shop-builder' );
		$this->icon  = '/';


		$this->settings_modal_toggles = array(
			'advanced'	=> array(
				'toggles' => array(
					'details_labels'   	=> array(
						'title'             => esc_html__( 'Account Details Labels', 'divi-shop-builder' ),
						'priority'          => 48,
					),
					'details_fields'   	=> array(
						'title'             => esc_html__( 'Account Details Fields', 'divi-shop-builder' ),
						'priority'          => 48,
					),
					'submit_button'   	=> array(
						'title'             => esc_html__( 'Submit Button', 'divi-shop-builder' ),
						'priority'          => 48,
					)
				)
			)
		);

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->advanced_fields = array(
			'fonts'	 => array(
				'labels'     => array(
					'label'       => esc_html__( 'Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .form-row label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'details_labels',
					'toggle_priority' => 10,
				),
			),
			'button' => array(
				'button_submit' => array(
					'label'          => esc_html__( 'Submit Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'submit_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .woocommerce-EditAccountForm.edit-account p button[type='submit']",
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .woocommerce-EditAccountForm.edit-account p button[type='submit']",
							'important' => true,
						),
					)
				)

			),
			'form_field' => array(
				'fields'         => array(
					'label'           => esc_html__( 'Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'details_fields',
					'toggle_priority' => 60,
					'css'             => array(
						'background_color'       => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
						'main'                   => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
						'background_color_hover' => "{$this->main_css_element} .form-row input.input-text:hover, {$this->main_css_element} .form-row textarea:hover",
						'focus_background_color' => "{$this->main_css_element} .form-row input.input-text:focus, {$this->main_css_element} .form-row textarea:focus",
						'form_text_color'        => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
						'form_text_color_hover'  => "{$this->main_css_element} .form-row input.input-text:hover, {$this->main_css_element} .form-row textarea:hover",
						'focus_text_color'       => "{$this->main_css_element} .form-row input.input-text:focus, {$this->main_css_element} .form-row textarea:focus",
						'placeholder_focus'      => "{$this->main_css_element} .form-row input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row textarea:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .form-row textarea:focus::-moz-placeholder, {$this->main_css_element} .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .form-row textarea:focus:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
						'margin'                 => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
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
						'name'              => 'fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'fields'       => array(
							'name'         => 'fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
									'border_styles' => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea"
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
							'label_prefix' => esc_html__( 'Fields', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_styles' => "{$this->main_css_element} .form-row input.input-text:focus, {$this->main_css_element} .form-row textarea:focus",
									'border_radii'  => "{$this->main_css_element} .form-row input.input-text:focus, {$this->main_css_element} .form-row textarea:focus",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
							),
							'hover'     => array(
								"{$this->main_css_element} .form-row input.input-text:hover, {$this->main_css_element} .form-row textarea:hover",
								"{$this->main_css_element} .form-row input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row textarea:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .form-row textarea:focus::-moz-placeholder",
								"{$this->main_css_element} .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .form-row textarea:focus:focus:-ms-input-placeholder",
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
							'main'      => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
							'padding'   => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
							'margin'    => "{$this->main_css_element} .form-row input.input-text, {$this->main_css_element} .form-row textarea",
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
				'dropdowns'         => array(
					'label'           => esc_html__( 'Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'details_fields',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
						'background_color'       => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
						'background_color_hover' => "{$this->main_css_element} .form-row select:hover, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:hover",
						'focus_background_color' => "{$this->main_css_element} .form-row select:focus, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:focus",
						'form_text_color'        => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single .select2-selection__rendered",
						'form_text_color_hover'  => "{$this->main_css_element} .form-row select:hover, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered",
						'focus_text_color'       => "{$this->main_css_element} .form-row select:focus, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
						'placeholder_focus'      => "{$this->main_css_element} .form-row select:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .form-row textarea:focus::-moz-placeholder, {$this->main_css_element} .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .form-row textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
						'margin'                 => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
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
						'name'              => 'dropdowns',
						'css'               => array(
							'main' => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'label_prefix' => esc_html__( 'Fields', 'divi-shop-builder' ),
					),
					'border_styles'   => array(
						'dropdowns'       => array(
							'name'         => 'dropdowns',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
									'border_styles' => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single"
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
							'label_prefix' => esc_html__( 'Dropdowns', 'divi-shop-builder' ),
						),
						'fields_focus' => array(
							'name'         => 'fields_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .form-row select:focus, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
									'border_styles' => "{$this->main_css_element} .form-row select:focus, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__( 'Dropdowns Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
							),
							'hover'     => array(
								"{$this->main_css_element} .form-row select:hover, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered"
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
							'main'      => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
							'padding'   => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
							'margin'    => "{$this->main_css_element} .form-row select, {$this->main_css_element} .form-row .select2.select2-container .select2-selection--single",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin' => array(
							'default' => '0|0|0|0|false|false',
						),
					),
				)
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

		$button_submit_use_icon = !empty( $this->props['button_submit_use_icon'] ) ? $this->props['button_submit_use_icon'] : 'off';
		if( $button_submit_use_icon === 'on' && !empty( $this->props['button_submit_icon'] ) ){
			$icon 	   = dswcp_decoded_et_icon( $this->props['button_submit_icon'] );
			$placement = $this->props['button_submit_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .woocommerce-EditAccountForm.edit-account p button[type='submit']::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		ob_start();

		woocommerce_account_edit_account();

		return sprintf( '<div class="%s"><div class="%s">%s</div></div>', 'woocommerce', 'woocommerce-MyAccount-content', ob_get_clean() );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'output' => $this->render( array(), null, $this->slug )
		);

		$data['account_details'] = $locals;

		return $data;
	}

}

new DSWCP_WooAccountDetails;