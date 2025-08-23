<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo Login Form
 *
 */
class DSWCP_WooLoginForm extends DSWCP_WooLoginRegisterForm {
	use DSWCP_Module;

	public    $slug       = 'ags_woo_login_form';
	public    $vb_support = 'on';
	protected $formType   = 'login';
	protected $accent_color;
	protected $icon;

	public function init() {
		$this->name             = esc_html__( 'Login Form', 'divi-shop-builder' );
		$this->icon             = '/';
		$this->main_css_element = '%%order_class%%';
		$this->accent_color     = et_builder_accent_color();

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'login_form' => esc_html__( 'Login Form', 'divi-shop-builder' )
				),
			),

			'advanced' => array(
				'toggles' => array(
					'link_options'  => false,
					'text'          => array(
						'title' => esc_html__( 'Text', 'divi-shop-builder' ),
					),
					'title'         => array(
						'title' => esc_html__( 'Title', 'divi-shop-builder' ),
					),
					'label'         => array(
						'title' => esc_html__( 'Label', 'divi-shop-builder' ),
					),
					'input'         => array(
						'title' => esc_html__( 'Inputs', 'divi-shop-builder' ),
					),
					'button'        => array(
						'title' => esc_html__( 'Button', 'divi-shop-builder' ),
					),
					'checkbox'      => array(
						'title' => esc_html__( 'Checkbox', 'divi-shop-builder' ),
					),
					'lost_password' => array(
						'title' => esc_html__( 'Lost Password', 'divi-shop-builder' ),
					),
					'remember_me'   => array(
						'title' => esc_html__( 'Remember Me', 'divi-shop-builder' ),
					),
					'error'   => array(
						'title' => esc_html__( 'Error', 'divi-shop-builder' ),
					),
				),
			),
		);

		$this->advanced_fields = array(
			'link_options'    => true,
			'text'            => false,
			'fonts'           => array(
				'fonts'         => array(
					'label'       => esc_html__( 'Fonts', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%%',
						'important' => 'all',
					),
					'font_size'   => array(
						'default' => '',
					),
					'line_height' => array(
						'default' => '',
					),
					'font'        => array(
						'default' => '||||||||',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'text',
				),
				'label'         => array(
					'label'           => esc_html__( 'Label', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% form label',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'label',
					'depends_show_if' => array(
						'show_labels' => 'on'
					)
				),
				'lost_password' => array(
					'label'       => esc_html__( 'Lost Password Link', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% form .lost_password a',
						'important' => 'all',
					),
					'font_size'   => array(
						'default' => '',
					),
					'line_height' => array(
						'default' => '',
					),
					'font'        => array(
						'default' => '||||||||',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'lost_password'
				),
				'remember_me'   => array(
					'label'       => esc_html__( 'Remember Me Text', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% form .woocommerce-form-login__rememberme span',
						'important' => 'all',
					),
					'font_size'   => array(
						'default' => '',
					),
					'line_height' => array(
						'default' => '',
					),
					'font'        => array(
						'default' => '||||||||',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'remember_me'
				),
				'title'         => array(
					'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% h1,%%order_class%% h2,%%order_class%% h3,%%order_class%% h4,%%order_class%% h5,%%order_class%% h6',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'header_level'    => array(
						'default' => 'h2',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'title',
					'depends_show_if' => array(
						'show_title' => 'on'
					)
				),
				'error'         => array(
					'label'           => esc_html__( 'Error', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% p.ags_woo_login_form_error',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'error'
				),
			),
			'button'          => array(
				'buttons' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'css'            => array(
						'main'      => ' %%order_class%% .et_pb_button',
						'important' => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .et_pb_button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'button',
				),
			),
			'form_field'      => array(
				'input' => array(
					'label'          => esc_html__( 'Input Field', 'divi-shop-builder' ),
					'css'            => array(
						'main'                   => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'background_color'       => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'background_color_hover' => '%%order_class%% input[type="email"]:hover,%%order_class%% input[type="password"]:hover, %%order_class%% input[type="text"]:hover',
						'focus_background_color' => '%%order_class%% input[type="email"]:focus,%%order_class%% input[type="password"]:focus, %%order_class%% input[type="text"]:focus',
						'form_text_color'        => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'form_text_color_hover'  => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'focus_text_color'       => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'placeholder_focus'      => '%%order_class%% input[type="email"]:focus::-webkit-input-placeholder,%%order_class%% input[type="password"]:focus::-webkit-input-placeholder, %%order_class%% input[type="text"]:focus::-webkit-input-placeholder,%%order_class%% input[type="email"]:focus::-moz-placeholder,%%order_class%% input[type="password"]:focus::-moz-placeholder, %%order_class%% input[type="text"]:focus::-moz-placeholder, %%order_class%% input[type="email"]:focus:-ms-input-placeholder,%%order_class%% input[type="password"]:focus:-ms-input-placeholder, %%order_class%% input[type="text"]:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
						'margin'                 => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
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
					'box_shadow'     => array(
						'name'              => 'input',
						'css'               => array(
							'main'      => '%%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
							'important' => 'all'
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'  => array(
						'input'       => array(
							'name'     => 'input',
							'css'      => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
									'border_styles' => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
								),
								'important' => 'all',
							),
							'defaults' => array(
								'border_radii'  => 'off||||',
								'border_styles' => array(
									'width' => '',
									'style' => '',
									'color' => ''
								),
							)
						),
						'input_focus' => array(
							'name'         => 'quantity_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% input[type="email"]:focus,%%order_class%% input[type="password"]:focus, %%order_class%% input[type="text"]:focus',
									'border_styles' => '%%order_class%% input[type="email"]:focus,%%order_class%% input[type="password"]:focus, %%order_class%% input[type="text"]:focus',
								),
								'important' => 'all',
							),
							'defaults'     => array(
								'border_radii'  => 'off||||',
								'border_styles' => array(
									'width' => '',
									'style' => '',
									'color' => ''
								),
							),
							'label_prefix' => esc_html__( 'Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'     => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
							),
							'hover'     => array(
								'%%order_class%% input[type="email"]:hover,%%order_class%% input[type="password"]:hover, %%order_class%% input[type="text"]:hover',
								'%%order_class%% input[type="email"]:hover::-webkit-input-placeholder,%%order_class%% input[type="password"]:hover::-webkit-input-placeholder,%%order_class%% input[type="text"]:hover::-webkit-input-placeholder',
								'%%order_class%% input[type="email"]:hover::-moz-placeholder,%%order_class%% input[type="password"]:hover::-moz-placeholder,%%order_class%% input[type="text"]:hover::-moz-placeholder',
								'%%order_class%% input[type="email"]:hover:-ms-input-placeholder,%%order_class%% input[type="password"]:hover:-ms-input-placeholder,%%order_class%% input[type="text"]:hover:-ms-input-placeholder',
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '14px',
						),
						'line_height' => array(
							'default' => '1em',
						),
					),
					'margin_padding' => array(
						'css' => array(
							'main'      => '%%order_class%% input[type="email"],%%order_class%% input[type="password"], %%order_class%% input[type="text"]',
							'important' => array( 'custom_padding' ),
						),
					),
					'toggle_slug'    => 'input',
				),
			),
			'borders'         => array(
				'default'  => array(),
				'checkbox' => array(
					'label'       => esc_html__( 'Border Checkbox', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% form label.woocommerce-form__label-for-checkbox span:before',
							'border_radii'  => '%%order_class%% form label.woocommerce-form__label-for-checkbox span:before'
						),
						'important' => 'all',
					),
					'defaults'    => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'checkbox',
					'show_if'     => array(
						'checkbox_style_enable' => 'on'
					)
				),
				'error' => array(
					'label'       => esc_html__( 'Error', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% p.ags_woo_login_form_error',
							'border_radii'  => '%%order_class%% p.ags_woo_login_form_error'
						),
//						'important' => 'all',
					),
					'defaults'    => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'error'
				),
			),
			'box_shadow'      => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%%'
					),
				),
				'error' => array(
					'name'              => 'error',
					'css'               => array(
						'main' => 'p.ags_woo_login_form_error',
					),
					'default_on_fronts' => array(
						'color'    => '',
						'position' => '',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'error'
				),
			),
			'background'      => array(
				'label'                => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'use_background_color' => true,
				'options'              => array(
					'background_color'     => array(
						'depends_show_if' => 'on',
						'default'         => '#fff',
					),
					'use_background_color' => array(
						'default' => 'on',
					),
				),
				'css'                  => array(
					'main' => '%%order_class%%',
				),
			),
			'position_fields' => array(
				'default' => 'relative',
			),
		);
	}

	public function get_fields() {

		$design_fields = array(

			'input_placeholder_color' => array(
				'label'        => esc_html__( 'Placeholder Text Color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'input',
				'show'         => array( 'show_placeholders' => 'on' )
			),

			// -----------------------------------------------------
			// Checkbox Settings
			// -----------------------------------------------------

			'checkbox_style_enable'             => array(
				'label'           => esc_html__( 'Custom Checkbox Styles', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'checkbox',
			),
			'checkbox_checked_color'            => array(
				'label'        => esc_html__( 'Checked Color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => $this->accent_color,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'checkbox',
				'show_if'      => array(
					'checkbox_style_enable' => 'on',
				),
			),
			'checkbox_checked_background_color' => array(
				'label'        => esc_html__( 'Checked Background Color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'checkbox',
				'show_if'      => array(
					'checkbox_style_enable' => 'on',
				),
			),
			'checkbox_background_color'         => array(
				'label'        => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'checkbox',
				'show_if'      => array(
					'checkbox_style_enable' => 'on',
				),
			),

			// -----------------------------------------------------
			// Spacing Settings
			// -----------------------------------------------------

			'remember_margin'       => array(
				'label'           => esc_html__( 'Remember Me Link Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'remember_me',
				'show_if'         => array(
					'checkbox_style_enable' => 'on',
				),
			),
			'remember_padding'      => array(
				'label'           => esc_html__( 'Remember Me Link Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'remember_me',
				'show_if'         => array(
					'checkbox_style_enable' => 'on',
				),
			),
			'title_margin'          => array(
				'label'           => esc_html__( 'Title Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'title',
				'show_if'         => array(
					'show_title' => 'on',
				),
			),
			'title_padding'         => array(
				'label'           => esc_html__( 'Title Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'title',
				'show_if'         => array(
					'show_title' => 'on',
				),
			),
			'label_margin'          => array(
				'label'           => esc_html__( 'Label Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'label',
				'show_if'         => array(
					'show_labels' => 'on',
				),
			),
			'label_padding'         => array(
				'label'           => esc_html__( 'Label Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'label',
				'show_if'         => array(
					'show_labels' => 'on',
				),
			),
			'lost_password_margin'  => array(
				'label'           => esc_html__( 'Lost Password Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'lost_password',
				'show_if'         => array(
					'show_labels' => 'on',
				),
			),
			'lost_password_padding' => array(
				'label'           => esc_html__( 'Lost Password Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'lost_password',
				'show_if'         => array(
					'show_labels' => 'on',
				),
			),
			'error_margin'          => array(
				'label'           => esc_html__( 'Error Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'error'
			),
			'error_padding'         => array(
				'label'           => esc_html__( 'Error Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'error'
			),
		);

		$addComputedField = [

			'enable_test_mode'		=> array(
				'label'           => esc_html__( 'Enable Test Mode', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show the form on the frontend for logged in users', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Enable', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Disable', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'      => 'login_form',
			),
			'show_title'           => [
				'label'            => esc_html__( 'Show Title', 'divi-shop-builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'show_labels'          => [
				'label'            => esc_html__( 'Show Labels', 'divi-shop-builder' ),
				'description'      => esc_html__( 'The "Show Labels" setting for a login form displays text labels such as "Username" and "Password" next to each input field, enhancing clarity and accessibility for users.', 'divi-shop-builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'show_placeholders'    => [
				'label'            => esc_html__( 'Show Placeholders', 'divi-shop-builder' ),
				'description'      => esc_html__( 'The "Show Placeholders" setting adds descriptive text inside each input field, like "Enter Username" or "Enter Password," guiding users on what information to input, and disappears when they start typing.', 'divi-shop-builder' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'redirect_after_login' => [
				'label'           => esc_html__( 'Redirect After Login', 'divi-shop-builder' ),
				'description'     => esc_html__( ' When enabled, this setting displays a field for entering a URL, where users will be automatically redirected after successfully logging in. WooCommerce might restrict redirection to external websites.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'basic_option',
				'default'         => 'on',
				'toggle_slug'     => 'login_form',
			],
			'title'                => [
				'label'            => esc_html__( 'Form Title', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the title text', 'divi-shop-builder' ),
				'default'          => __( 'Login', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_title' => 'on'
				)
			],
			'label_username'       => [
				'label'            => esc_html__( 'Username/email Field Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the username/email field', 'divi-shop-builder' ),
				'default'          => __( 'Username or email address', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_labels' => 'on'
				)
			],
			'placeholder_username' => [
				'label'            => esc_html__( 'Username/email Field Placeholder', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the placeholder of the username/email field', 'divi-shop-builder' ),
				'default'          => __( 'Username or email address', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_placeholders' => 'on'
				)
			],
			'label_password'       => [
				'label'            => esc_html__( 'Password Field Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the password field', 'divi-shop-builder' ),
				'default'          => __( 'Password', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_labels' => 'on'
				)
			],
			'placeholder_password' => [
				'label'            => esc_html__( 'Password Placeholder Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the placeholder of the password field', 'divi-shop-builder' ),
				'default'          => __( 'Password', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_placeholders' => 'on'
				)
			],
			'label_remember'       => [
				'label'            => esc_html__( 'Remember Me Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the remember me checkbox', 'divi-shop-builder' ),
				'default'          => __( 'Remember me', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'label_forgot'         => [
				'label'            => esc_html__( 'Lost Password Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the text of the lost password link', 'divi-shop-builder' ),
				'default'          => __( 'Lost your password?', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'label_button'         => [
				'label'            => esc_html__( 'Login Button Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the login button', 'divi-shop-builder' ),
				'default'          => __( 'Log in', 'divi-shop-builder' ),
				'toggle_slug'      => 'login_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'redirect_url'         => array(
				'label'           => esc_html__( 'Redirect Link URL', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Specify the webpage users are redirected to after successful login. WooCommerce might restrict redirection to external websites.', 'divi-shop-builder' ),
				'toggle_slug'     => 'login_form',
				'show_if'         => array(
					'redirect_after_login' => 'on'
				)
			),

		];

		$addComputedField['__form'] = [
			'type'                => 'computed',
			'computed_callback'   => [ static::CLASS, 'getComputedHtml' ],
			'computed_depends_on' => [ 'title_level' ]
		];

		foreach ( $addComputedField as $fieldId => $field ) {
			if ( ! empty( $field['computed_affects'] ) ) {
				$addComputedField['__form']['computed_depends_on'][] = $fieldId;
			}
		}

		return array_merge( $design_fields, $addComputedField );
	}

	protected function css( $render_slug ) {

		$props     = $this->props;
		$css_props = [];


		if ( isset( $props['input_placeholder_color'] ) ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% input[type="email"]::placeholder,%%order_class%% input[type="password"]::placeholder, %%order_class%% input[type="text"]::placeholder',
					'declaration' => sprintf( 'color:%s;', esc_attr( $props['input_placeholder_color'] ) ),
				)
			);
		}

		// Checkboxes
		if ( 'on' === $props['checkbox_style_enable'] ) {

			$css_prop = array(
				array(
					'selector'    => '%%order_class%% form label.woocommerce-form__label-for-checkbox',
					'declaration' => 'display : flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;position: relative;',
				),
				array(
					'selector'    => '%%order_class%% form label.woocommerce-form__label-for-checkbox span:before',
					'declaration' => 'content : "";  position : absolute; top : 50%; left : 0; -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;',
				),
				array(
					'selector'    => '%%order_class%% form label.woocommerce-form__label-for-checkbox input[type=checkbox]',
					'declaration' => 'padding : 0; margin : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;',
				),
				array(
					'selector'    => '%%order_class%% form label.woocommerce-form__label-for-checkbox input:checked + span:before',
					'declaration' => 'content : "\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center;',
				)
			);

			$css_props = array_merge( $css_props, $css_prop );

			if ( isset( $props['checkbox_background_color'] ) ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% label.woocommerce-form__label-for-checkbox span:before',
						'declaration' => sprintf( 'background-color:%s;', esc_attr( $props['checkbox_background_color'] ) ),
					)
				);
			}

			if ( isset( $props['checkbox_checked_color'] ) ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% label.woocommerce-form__label-for-checkbox input:checked + span:before',
						'declaration' => sprintf( 'color :%s;', esc_attr( $props['checkbox_checked_color'] ) ),
					)
				);
			}

			if ( isset( $props['checkbox_checked_background_color'] ) ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% label.woocommerce-form__label-for-checkbox input:checked + span:before',
						'declaration' => sprintf( 'background-color:%s;', esc_attr( $props['checkbox_checked_background_color'] ) ),
					)
				);
			}
		}

		$this->apply_responsive( $props, 'remember_padding', '%%order_class%% .woocommerce-form-login__rememberme', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'remember_margin', '%%order_class%% .woocommerce-form-login__rememberme', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'title_padding', '%%order_class%% .ags_login_register_title', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'title_margin', '%%order_class%% .ags_login_register_title', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'label_padding', '%%order_class%% form label', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'label_margin', '%%order_class%% form label', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'lost_password_padding', '%%order_class%% .lost_password', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'lost_password_margin', '%%order_class%% .lost_password', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'error_padding', '%%order_class%% p.ags_woo_login_form_error', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'error_margin', '%%order_class%% p.ags_woo_login_form_error', 'margin', $render_slug, 'custom_margin' );


		foreach ( $css_props as $css_prop ) {
			self::set_style_esc( $render_slug, $css_prop );
		}
	}


	protected function getStrings() {
		return [
			'Username or email address' => $this->props['label_username'],
			'Password'                  => $this->props['label_password'],
			'Remember me'               => $this->props['label_remember'],
			'Lost your password?'       => $this->props['label_forgot'],
			'Log in'                    => $this->props['label_button']
		];
	}

	public static function _false() {
		return false;
	}

	protected function _add_borders_fields() {
		add_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
		parent::_add_borders_fields();
		remove_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
	}

	protected function _set_fields_unprocessed($fields) {

		if ( ! is_array($fields) ) {
			return;
		}

		$template            = ET_Builder_Module_Helper_OptionTemplate::instance();
		$newFields           = [];

		foreach ( $fields as $field => $definition ) {
			if ( ($definition === 'text_shadow' || $definition === 'box_shadow') && $template->is_enabled() && $template->has( $definition ) ) {

				$data    = $template->get_data($field);
				$setting = end($data);

				$settingWithShowIf = self::setFieldShowIf($setting);
				$new_definition    = $settingWithShowIf ? ET_Builder_Module_Fields_Factory::get($definition === 'box_shadow' ? 'BoxShadow' : 'TextShadow')->get_fields($settingWithShowIf) : null;

				if ( $new_definition ) {
					$field      = array_keys($new_definition)[0];
					$definition = array_values($new_definition)[0];
				}

			} else {
				$definitionWithShowIf = self::setFieldShowIf($definition);
				$definition           = $definitionWithShowIf ? $definitionWithShowIf : $definition;
			}

			$newFields[ $field ] = $definition;
		}

		return parent::_set_fields_unprocessed($newFields);
	}

	public static function setFieldShowIf($field) {
		if ( isset($field['toggle_slug']) ) {

			switch ( $field['toggle_slug'] ) {
				case 'title':
					$showIf = ['show_title' => 'on'];
					break;
				case 'label':
					$showIf = ['show_labels' => 'on'];
					break;
			}

			if (isset($showIf)) {
				if ( empty($field['show_if']) ) {
					$field['show_if'] = $showIf;
				} else {
					$field['show_if'] = array_merge($field['show_if'], $showIf);
				}
			}

			return $field;
		}

		return null;
	}
}

new DSWCP_WooLoginForm;