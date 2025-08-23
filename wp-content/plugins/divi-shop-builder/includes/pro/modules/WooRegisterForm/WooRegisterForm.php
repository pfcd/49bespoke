<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo Register Form
 *
 */
class DSWCP_WooRegisterForm extends DSWCP_WooLoginRegisterForm {

	public    $slug       = 'ags_woo_register_form';
	public    $vb_support = 'on';
	protected $formType   = 'register';
	protected $accent_color;
	protected $icon;

	public function init() {
		$this->name = esc_html__( 'Register Form', 'divi-shop-builder' );
		$this->icon = '/';

		$this->main_css_element = '%%order_class%%';
		$this->accent_color     = et_builder_accent_color();

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'register_form' => esc_html__( 'Register Form', 'divi-shop-builder' )
				),
			),

			//todo: show_if for toggles; not all settings from $this->advanced_fields are supporting show_if
			'advanced' => array(
				'toggles' => array(
					'text'           => array(
						'title'             => esc_html__( 'Text', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p' => array(
								'name' => 'P',
								'icon' => 'text-left',
							),
							'a' => array(
								'name' => 'A',
								'icon' => 'text-link',
							),
						)
					),
					'title'          => array(
						'title' => esc_html__( 'Title', 'divi-shop-builder' ),
					),
					'label'          => array(
						'title' => esc_html__( 'Label', 'divi-shop-builder' ),
					),
					'input'          => array(
						'title' => esc_html__( 'Inputs', 'divi-shop-builder' ),
					),
					'button'         => array(
						'title' => esc_html__( 'Button', 'divi-shop-builder' ),
					),
					'privacy-policy' => array(
						'title' => esc_html__( 'Privacy Policy', 'divi-shop-builder' ),
					),
					'error'   => array(
						'title' => esc_html__( 'Error', 'divi-shop-builder' ),
					),
				),
			),
		);


		$this->advanced_fields = array(
			'link_options'    => false,
			'text'            => false,
			'fonts'           => array(
				'fonts'   => array(
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
					'sub_toggle'  => 'p'
				),
				'fonts_a' => array(
					'label'       => esc_html__( 'Link', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% a',
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
					'sub_toggle'  => 'a'
				),
				'label'   => array(
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
				'title'   => array(
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
				'privacy' => array(
					'label'       => esc_html__( 'Privacy', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => '%%order_class%% .woocommerce-privacy-policy-text',
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
					'toggle_slug' => 'privacy'
				),
				'error'         => array(
					'label'           => esc_html__( 'Error', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% p.ags_woo_register_form_error',
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
				'default' => array(),
				'error' => array(
					'label'       => esc_html__( 'Error', 'divi-shop-builder' ),
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% p.ags_woo_register_form_error',
							'border_radii'  => '%%order_class%% p.ags_woo_register_form_error'
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
						'main' => 'p.ags_woo_register_form_error',
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
			// Spacing Settings
			// -----------------------------------------------------

			'privacy_margin'  => array(
				'label'           => esc_html__( 'Privacy Policy Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'privacy',
			),
			'privacy_padding' => array(
				'label'           => esc_html__( 'Privacy Policy Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'privacy',
			),
			'title_margin'    => array(
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
			'title_padding'   => array(
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
			'label_margin'    => array(
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
			'label_padding'   => array(
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
			'warning'              => array(
				'type'        => 'ags_wc_warning-DSB',
				'toggleVar'   => 'ags_divi_wc_notRegistrationEnabled',
				'className'   => 'ags-divi-wc-page-warning',
				'toggle_slug'      => 'register_form',
				'warningText' => __( 'This module will not render because the WooCommerce > Settings > Accounts & Privacy > [Allow customers to create an account on the "My account" page] checkbox is not checked.', 'divi-shop-builder' )
			),
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
				'toggle_slug'      => 'register_form',
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
				'toggle_slug'      => 'register_form',
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
				'toggle_slug'      => 'register_form',
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
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'title'                => [
				'label'            => esc_html__( 'Form Title', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the title text', 'divi-shop-builder' ),
				'default'          => __( 'Register', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_title' => 'on'
				)
			],
			'label_username'       => [
				'label'            => esc_html__( 'Username Field Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the username field', 'divi-shop-builder' ),
				'default'          => __( 'Username', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_labels' => 'on'
				)
			],
			'placeholder_username' => [
				'label'            => esc_html__( 'Username Field Placeholder', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the placeholder of the username field', 'divi-shop-builder' ),
				'default'          => __( 'Username', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_placeholders' => 'on'
				)
			],
			'label_email'          => [
				'label'            => esc_html__( 'Email Address Field Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'register_form',
				'description'      => esc_html__( 'Change the label of the email address field', 'divi-shop-builder' ),
				'default'          => __( 'Email address', 'divi-shop-builder' ),
				'computed_affects' => array(
					'__form',
				),
			],
			'placeholder_email'    => [
				'label'            => esc_html__( 'Email Field Placeholder', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the placeholder of the email field', 'divi-shop-builder' ),
				'default'          => __( 'Email address', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
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
				'toggle_slug'      => 'register_form',
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
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
				'show_if'          => array(
					'show_placeholders' => 'on'
				)
			],
			'label_forgot'         => [
				'label'            => esc_html__( 'Lost Password Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the text of the lost password link', 'divi-shop-builder' ),
				'default'          => __( 'Lost your password?', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'label_button'         => [
				'label'            => esc_html__( 'Register Button Label', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Change the label of the register button', 'divi-shop-builder' ),
				'default'          => __( 'Register', 'divi-shop-builder' ),
				'toggle_slug'      => 'register_form',
				'computed_affects' => array(
					'__form',
				),
			],
			'redirect_after_login' => [
				'label'           => esc_html__( 'Login and Redirect', 'divi-shop-builder' ),
				'description'     => esc_html__( 'When enabled, the new user will automatically be logged in after successful registration, and redirected to the specified URL.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'basic_option',
				'default'         => 'on',
				'toggle_slug'     => 'register_form',
			],
			'redirect_url'         => array(
				'label'           => esc_html__( 'Redirect Link URL', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Specify the webpage users are redirected to after successful registration and login. Leaving this blank will revert to the default WooCommerce redirect behaviour.', 'divi-shop-builder' ),
				'toggle_slug'     => 'register_form',
				'show_if'         => array(
					'redirect_after_login' => 'on'
				)
			),

		];


		$addComputedField['__form'] = [
			'type'                => 'computed',
			'computed_callback'   => [ static::CLASS, 'getComputedHtml' ],
			'computed_depends_on' => []
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


		$this->apply_responsive( $props, 'privacy_margin', '%%order_class%% .woocommerce-privacy-policy-text', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'privacy_padding', '%%order_class%% .woocommerce-privacy-policy-text', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'title_padding', '%%order_class%% .ags_login_register_title', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'title_margin', '%%order_class%% .ags_login_register_title', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'label_padding', '%%order_class%% form label', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'label_margin', '%%order_class%% form label', 'margin', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'error_padding', '%%order_class%% p.ags_woo_register_form_error', 'padding', $render_slug, 'custom_margin' );
		$this->apply_responsive( $props, 'error_margin', '%%order_class%% p.ags_woo_register_form_error', 'margin', $render_slug, 'custom_margin' );


		foreach ( $css_props as $css_prop ) {
			self::set_style_esc( $render_slug, $css_prop );
		}
	}


	protected function getStrings() {
		return [
			'Username'      => $this->props['label_username'],
			'Email address' => $this->props['label_email'],
			'Password'      => $this->props['label_password'],
			'Register'      => $this->props['label_button']
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

new DSWCP_WooRegisterForm;