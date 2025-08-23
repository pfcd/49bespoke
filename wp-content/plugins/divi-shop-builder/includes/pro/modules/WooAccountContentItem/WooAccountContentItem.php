<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Avatar
 *
 */
class DSWCP_WooAccountContentItem extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug            = 'ags_woo_account_content_item';
	public $vb_support      = 'on';
	public $type            = 'child';
	public $child_title_var = 'item_title';
	protected $icon;
	// public $advanced_fields = false;
	// public $custom_css_tab  = false;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Content Item', 'divi-shop-builder' );
		$this->icon = 'G';

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'login_forms_layout'   => array(
						'title'             => esc_html__( 'Layout', 'divi-shop-builder' )
					),
					'login_form_text'   => array(
						'title'             => esc_html__( 'Login Form Text', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'     => array(
								'name' => 'P',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'     => array(
								'name' => 'A',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							),
							'h2'    => array(
								'name' => 'h2',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_heading.svg'),
							)
						)
					),
					'login_form_labels'   => array(
						'title'             => esc_html__( 'Login Form Labels', 'divi-shop-builder' )
					),
					'login_form_fields'   => array(
						'title'             => esc_html__( 'Login Form Fields', 'divi-shop-builder' )
					),
					'login_form_button'   => array(
						'title'             => esc_html__( 'Login Form Button', 'divi-shop-builder' ),
					),
					'login_form_wrapper'   => array(
						'title'             => esc_html__( 'Login Form Wrapper', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name' => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'border'    => array(
								'name' => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/border.svg'),
							),
							'background'    => array(
								'name' => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/background_colors.svg'),
							)
						)
					),
					'register_form_text'   => array(
						'title'             => esc_html__( 'Register Form Text', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'  => array(
								'name' => 'P',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'  => array(
								'name' => 'A',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							),
							'h2' => array(
								'name' => 'h2',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_heading.svg'),
							)
						)
					),
					'register_form_labels'   => array(
						'title'             => esc_html__( 'Register Form Labels', 'divi-shop-builder' )
					),
					'register_form_fields'   => array(
						'title'             => esc_html__( 'Register Form Fields', 'divi-shop-builder' )
					),
					'register_form_button'   => array(
						'title'             => esc_html__( 'Register Form Button', 'divi-shop-builder' ),
					),
					'register_form_wrapper'   => array(
						'title'             => esc_html__( 'Register Form Wrapper', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name' => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name' => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/border.svg'),
							),
							'background' => array(
								'name' => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/background_colors.svg'),
							)
						)
					),
					'lost_password_form_text'   => array(
						'title'             => esc_html__( 'Lost Password Form Text', 'divi-shop-builder' ),
					),
					'lost_password_form_labels'   => array(
						'title'             => esc_html__( 'Lost Password Form Labels', 'divi-shop-builder' )
					),
					'lost_password_form_fields'   => array(
						'title'             => esc_html__( 'Lost Password Form Fields', 'divi-shop-builder' )
					),
					'lost_password_form_button'   => array(
						'title'             => esc_html__( 'Lost Password Form Button', 'divi-shop-builder' ),
					),
					'lost_password_form_wrapper'   => array(
						'title'             => esc_html__( 'Lost Password Form Wrapper', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name' => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'border'    => array(
								'name' => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/border.svg'),
							),
							'background'    => array(
								'name' => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/background_colors.svg'),
							)
						)
					),
					'login_border' => array(
						'title' => esc_html__( 'Border', 'divi-shop-builder' ),
					),
					'dashboard_text'                    => array(
						'title'             => esc_html__( 'Dashboard Text', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'      => array(
								'name' => 'P',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'      => array(
								'name' => 'A',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							),
							'strong' => array(
								'name' => 'STRONG',
								'icon' => 'text-bold',
							)
						)
					),
					'account_details_labels'            => array(
						'title' => esc_html__( 'Account Details Labels', 'divi-shop-builder' )
					),
					'account_details_fields'            => array(
						'title' => esc_html__( 'Account Details Fields', 'divi-shop-builder' )
					),
					'account_details_dropdowns'         => array(
						'title' => esc_html__( 'Account Details Dropdowns', 'divi-shop-builder' )
					),
					'account_details_buttons'           => array(
						'title' => esc_html__( 'Account Details Buttons', 'divi-shop-builder' )
					),
					'downloads_table'                   => array(
						'title' => esc_html__( 'Downloads Table', 'divi-shop-builder' )
					),
					'downloads_table_head'              => array(
						'title' => esc_html__( 'Downloads Table Head', 'divi-shop-builder' )
					),
					'downloads_table_column'            => array(
						'title' => esc_html__( 'Downloads Table Column', 'divi-shop-builder' )
					),
					'downloads_table_link'              => array(
						'title' => esc_html__( 'Downloads Table Link', 'divi-shop-builder' )
					),
					'downloads_no_items'                => array(
						'title' => esc_html__( 'Downloads No Items', 'divi-shop-builder' )
					),
					'downloads_buttons_download'        => array(
						'title' => esc_html__( 'Downloads Buttons', 'divi-shop-builder' )
					),
					'downloads_buttons_browse'          => array(
						'title' => esc_html__( 'Browse Products Buttons', 'divi-shop-builder' )
					),
					'orders_table'                      => array(
						'title' => esc_html__( 'Orders Table', 'divi-shop-builder' )
					),
					'orders_table_head'                 => array(
						'title' => esc_html__( 'Orders Table Head', 'divi-shop-builder' )
					),
					'orders_table_column'               => array(
						'title' => esc_html__( 'Orders Table Column', 'divi-shop-builder' )
					),
					'orders_table_link'                 => array(
						'title' => esc_html__( 'Orders Table Link', 'divi-shop-builder' )
					),
					'orders_no_items'                   => array(
						'title' => esc_html__( 'Orders No Items', 'divi-shop-builder' )
					),
					'orders_buttons'                    => array(
						'title' => esc_html__( 'Orders View Buttons', 'divi-shop-builder' )
					),
					'orders_buttons_browse'             => array(
						'title' => esc_html__( 'Orders Browse Buttons', 'divi-shop-builder' )
					),
					'orders_buttons_download'           => array(
						'title' => esc_html__( 'Orders Download Buttons', 'divi-shop-builder' )
					),
					'orders_buttons_order'              => array(
						'title' => esc_html__( 'Order Again Button', 'divi-shop-builder' )
					),
					'orders_pagination_buttons'         => array(
						'title' => esc_html__( 'Order Pagination Buttons', 'divi-shop-builder' )
					),
					'address_text'                      => array(
						'title' => esc_html__( 'Address Text', 'divi-shop-builder' )
					),
					'address_billing_title'             => array(
						'title' => esc_html__( 'Billing Address Title', 'divi-shop-builder' )
					),
					'address_billing_form_title'        => array(
						'title' => esc_html__( 'Billing Address Form Title', 'divi-shop-builder' )
					),
					'address_shipping_title'            => array(
						'title' => esc_html__( 'Shipping Address Title', 'divi-shop-builder' )
					),
					'address_shipping_form_title'       => array(
						'title' => esc_html__( 'Shipping Address Form Title', 'divi-shop-builder' )
					),
					'address_billing'                   => array(
						'title' => esc_html__( 'Billing Address', 'divi-shop-builder' )
					),
					'address_shipping'                  => array(
						'title' => esc_html__( 'Shipping Address', 'divi-shop-builder' )
					),
					'address_billing_label'             => array(
						'title' => esc_html__( 'Billing Address Labels', 'divi-shop-builder' )
					),
					'address_shipping_label'            => array(
						'title' => esc_html__( 'Shipping Address Labels', 'divi-shop-builder' )
					),
					'address_billing_field'             => array(
						'title' => esc_html__( 'Billing Address Fields', 'divi-shop-builder' )
					),
					'address_shipping_field'            => array(
						'title' => esc_html__( 'Shipping Address Fields', 'divi-shop-builder' )
					),
					'address_buttons'                   => array(
						'title' => esc_html__( 'Address Buttons', 'divi-shop-builder' )
					),
					'address_billing_save_button'       => array(
						'title' => esc_html__( 'Billing Address Save Button', 'divi-shop-builder' )
					),
					'address_shipping_save_button'      => array(
						'title' => esc_html__( 'Shipping Address Save Button', 'divi-shop-builder' )
					),
					'address_billing_shipping_wrappers' => array(
						'title' => esc_html__( 'Billing/Shipping Wrappers', 'divi-shop-builder' )
					),
					'view_order_text'                   => array(
						'title' => esc_html__( 'View Order Text', 'divi-shop-builder' )
					),
					'view_order_details'                => array(
						'title' => esc_html__( 'View Order Details', 'divi-shop-builder' )
					),
					'view_order_table_head'             => array(
						'title' => esc_html__( 'View Order Table Head', 'divi-shop-builder' )
					),
					'view_order_table_column'           => array(
						'title' => esc_html__( 'View Order Table Column', 'divi-shop-builder' )
					),
					'view_order_table_footer'           => array(
						'title' => esc_html__( 'View Order Table Footer', 'divi-shop-builder' )
					),
					'view_order_billing'                => array(
						'title' => esc_html__( 'View Order Billing', 'divi-shop-builder' )
					),
					'view_order_shipping'               => array(
						'title' => esc_html__( 'View Order Shipping', 'divi-shop-builder' )
					),
				)
			),
		);

		$this->advanced_fields = array(
			'fonts'        => array(

				// login form start
				'login_form_text'     => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-login p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'login_form_text',
					'sub_toggle' 	  => 'p',
				),
				'login_form_link'     => array(
					'label'           => esc_html__( 'Link', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-login a",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'login_form_text',
					'sub_toggle' 	  => 'a',
				),
				'login_form_h2'     => array(
					'label'           => esc_html__( 'Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper h2, {$this->main_css_element} .login-wrapper .col-1 h2",
					),
					'toggle_slug'     => 'login_form_text',
					'sub_toggle' 	  => 'h2',
				),
				'login_form_labels'     => array(
					'label'       => esc_html__( 'Login Form Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'login_form_labels',
				),
				// login form settings end

				// register form start
				'register_form_text'     => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-register p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'register_form_text',
					'sub_toggle' 	  => 'p',
				),
				'register_form_link'     => array(
					'label'           => esc_html__( 'Link', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-register a",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'register_form_text',
					'sub_toggle' 	  => 'a',
				),
				'register_form_h2'     => array(
					'label'           => esc_html__( 'Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper .col-2 h2",
					),
					'toggle_slug'     => 'register_form_text',
					'sub_toggle' 	  => 'h2',
				),
				'register_form_labels'     => array(
					'label'       => esc_html__( 'Register Form Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'register_form_labels',
				),
				// register form settings end

				// lost password form start
				'lost_password_form_text'     => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'lost_password_form_text',
					'sub_toggle' 	  => 'p',
				),
				'lost_password_form_labels'     => array(
					'label'       => esc_html__( 'Lost Password Form Labels', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword label",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'lost_password_form_labels',
				),
				// lost password form settings end

				// dashboard font settings start
				'dashboard_text'               => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dashboard-wrapper p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'dashboard_text',
					'sub_toggle'      => 'p',
				),
				'dashboard_link'               => array(
					'label'           => esc_html__( 'Link', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dashboard-wrapper a",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'dashboard_text',
					'sub_toggle'      => 'a',
				),
				'dashboard_strong'             => array(
					'label'           => esc_html__( 'Bold', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .dashboard-wrapper strong",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'dashboard_text',
					'sub_toggle'      => 'strong',
				),
				// dashboard fonts settings end

				// account details fonts settings start
				'account_details_labels'       => array(
					'label'           => esc_html__( 'Labels', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-account-wrapper .form-row label",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'account_details_labels',
					'toggle_priority' => 10,
				),
				// account details fonts settings end

				// account downloads fonts settings start
				'downloads_th'                 => array(
					'label'           => esc_html__( 'Downloads Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .downloads-wrapper table thead th, {$this->main_css_element} table th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'downloads_table_head',
				),
				'downloads_td'                 => array(
					'label'           => esc_html__( 'Downloads Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .downloads-wrapper table tbody td",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'downloads_table_column',
				),
				'downloads_table_link'         => array(
					'label'           => esc_html__( 'Table Link', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .downloads-wrapper table a:not(.button)",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'downloads_table_link',
				),
				'downloads_no_items'           => array(
					'label'           => esc_html__( 'No Downloads', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => "{$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info",
						'important' => array( 'size', 'font-size' ),
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info",
							'important' => true,
						),
					),
					'toggle_slug'     => 'downloads_no_items',
				),
				// account downloads fonts settings end

				// account orders fonts settings start
				'orders_th'                    => array(
					'label'           => esc_html__( 'Orders Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table.woocommerce-MyAccount-orders thead th, {$this->main_css_element} table th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'orders_table_head',
				),
				'orders_td'                    => array(
					'label'           => esc_html__( 'Orders Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table.woocommerce-MyAccount-orders tbody td",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'orders_table_column'
				),
				'orders_table_link'            => array(
					'label'           => esc_html__( 'Orders Table Link', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table.woocommerce-MyAccount-orders a:not(.button)",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'orders_table_link',
				),
				'orders_no_items'              => array(
					'label'           => esc_html__( 'No Orders', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .orders-wrapper .woocommerce-Message.woocommerce-Message--info",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'orders_no_items',
				),
				// account orders fonts settings end

				// account address fonts settings start
				'address_text'                 => array(
					'label'           => esc_html__( 'Address Text', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-address-wrapper p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'address_text',
				),
				'address_billing_title'        => array(
					'label'           => esc_html__( 'Billing Title', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-address-wrapper .u-column1.woocommerce-Address .woocommerce-Address-title h3",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '22px',
					),
					'toggle_slug'     => 'address_billing_title',
				),
				'address_billing_form_title'   => array(
					'label'           => esc_html__( 'Billing Form Title', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-billing-wrapper form > h3",
					),
					'toggle_slug'     => 'address_billing_form_title',
				),
				'address_billing'              => array(
					'label'           => esc_html__( 'Billing Address', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-address-wrapper .u-column1.woocommerce-Address address",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'address_billing',
				),
				'address_shipping_title'       => array(
					'label'           => esc_html__( 'Shipping Title', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-address-wrapper .u-column2.woocommerce-Address .woocommerce-Address-title h3",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '22px',
					),
					'toggle_slug'     => 'address_shipping_title',
				),
				'address_shipping_form_title'  => array(
					'label'           => esc_html__( 'Shipping Form Title', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-shipping-wrapper form > h3",
					),
					'toggle_slug'     => 'address_shipping_form_title',
				),
				'address_shipping'             => array(
					'label'           => esc_html__( 'Shipping Address', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-address-wrapper .u-column2.woocommerce-Address address",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'address_shipping',
				),
				'address_billing_label'        => array(
					'label'           => esc_html__( 'Billing Address Labels', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] label",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'address_billing_label',
				),
				'address_shipping_label'       => array(
					'label'           => esc_html__( 'Shipping Address Labels', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] label",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'address_shipping_label',
				),
				// account address fonts settings end

				// account view order fonts settings start
				'view_order_text'              => array(
					'label'           => esc_html__( 'Order Message', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper p:not(address > p)",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_text',
				),
				'view_order_details'           => array(
					'label'           => esc_html__( 'Order Details Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details .woocommerce-order-details__title",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '26px',
					),
					'toggle_slug'     => 'view_order_details',
				),
				'view_order_table_head'        => array(
					'label'           => esc_html__( 'Order Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table thead th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_head',
				),
				'view_order_table_column'      => array(
					'label'           => esc_html__( 'Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table td",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_column',
				),
				'view_order_table_link'        => array(
					'label'           => esc_html__( 'Table Links', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table td a",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_column',
				),
				'view_order_table_strong'      => array(
					'label'           => esc_html__( 'Table Column Bold', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table td strong",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_column',
				),
				'view_order_table_foot_head'   => array(
					'label'           => esc_html__( 'Table Footer Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table tfoot th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_footer',
				),
				'view_order_table_foot_column' => array(
					'label'           => esc_html__( 'Table Footer Column', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-order-details table tfoot td",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_table_footer',
				),
				'view_order_billing_heading'   => array(
					'label'           => esc_html__( 'Billing Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address h2",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '26px',
					),
					'toggle_slug'     => 'view_order_billing',
				),
				'view_order_billing_address'   => array(
					'label'           => esc_html__( 'Billing Address', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_billing',
				),
				'view_order_shipping_heading'  => array(
					'label'           => esc_html__( 'Shipping Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address h2",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '26px',
					),
					'toggle_slug'     => 'view_order_shipping',
				),
				'view_order_shipping_address'  => array(
					'label'           => esc_html__( 'Shipping Address', 'divi-shop-builder' ),
					'css'             => array(
						'main' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'view_order_shipping',
				),
				// account view order fonts settings end
			),
			'borders' => array(
				//login
				'login' => array(
					'label_prefix'	  => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "$this->main_css_element",
							'border_radii' 	=> "$this->main_css_element"
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'login_border',
				),
				'login_form' => array(
					'label_prefix'	  => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "$this->main_css_element form.woocommerce-form-login",
							'border_radii' 	=> "$this->main_css_element form.woocommerce-form-login"
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'login_form_wrapper',
					'sub_toggle'      => 'border',
				),
				// Register
				'register_form' => array(
					'label_prefix'	  => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "$this->main_css_element form.woocommerce-form-register",
							'border_radii' 	=> "$this->main_css_element form.woocommerce-form-register"
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'register_form_wrapper',
					'sub_toggle'      => 'border'
				),
				// lost password form
				'lost_password_form' => array(
					'label_prefix'	  => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "$this->main_css_element form.woocommerce-ResetPassword",
							'border_radii' 	=> "$this->main_css_element form.woocommerce-ResetPassword"
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'lost_password_form_wrapper',
					'sub_toggle'      => 'border',
				),
				// account downloads border settings start
				'downloads_table'                   => array(
					'label_prefix'    => esc_html__( 'Downloads Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads",
							'border_radii'  => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads"
						),
						'important' => 'all',
					),
					'defaults'        => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'downloads_table'
				),
				'downloads_table_td'                => array(
					'label_prefix'    => esc_html__( 'Downloads Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td",
							'border_radii'  => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td"
						),
						'important' => 'all',
					),
					'defaults'        => array(
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
					'toggle_slug'     => 'downloads_table_column',
				),
				// account downloads border settings end

				// account orders border settings start
				'orders_table'                      => array(
					'label_prefix'    => esc_html__( 'Orders Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table",
							'border_radii'  => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table"
						),
						'important' => 'all',
					),
					'defaults'        => array(
						'border_radii'  => 'on|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'orders_table'
				),
				'orders_table_td'                   => array(
					'label_prefix'    => esc_html__( 'Orders Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table td.woocommerce-orders-table__cell",
							'border_radii'  => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table td.woocommerce-orders-table__cell"
						),
						'important' => 'all',
					),
					'defaults'        => array(
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
					'toggle_slug'     => 'orders_table_column'
				),
				// account orders border settings end

				// view order border settings start
				'view_order_billing'                => array(
					'label_prefix'    => esc_html__( 'Billing Border', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address",
							'border_radii'  => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address"
						),
						'important' => 'all',
					),
					'defaults'        => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
						'composite'     => array(
							'border_bottom' => array(
								'border_width_bottom' => '2px',
								'border_style_bottom' => 'solid',
								'border_color_bottom' => '#eee',
							),
							'border_right'  => array(
								'border_width_right' => '2px',
								'border_style_right' => 'solid',
								'border_color_right' => '#eee',
							),
						)
					),
					'toggle_slug'     => 'view_order_billing'
				),
				'view_order_shipping'               => array(
					'label_prefix'    => esc_html__( 'Shipping Border', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address",
							'border_radii'  => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address"
						),
						'important' => 'all',
					),
					'defaults'        => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
						'composite'     => array(
							'border_bottom' => array(
								'border_width_bottom' => '2px',
								'border_style_bottom' => 'solid',
								'border_color_bottom' => '#eee',
							),
							'border_right'  => array(
								'border_width_right' => '2px',
								'border_style_right' => 'solid',
								'border_color_right' => '#eee',
							),
						)
					),
					'toggle_slug'     => 'view_order_shipping',
				),
				// view order border settings end

				//addresses start
				'address_billing_shipping_wrappers' => array(
					'label_prefix'    => esc_html__( 'Billing/Shipping Borders', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address",
							'border_radii'  => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address"
						),
						'important' => 'all',
					),
					'defaults'        => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug'     => 'address_billing_shipping_wrappers',
				)

				//addresses end
			),
			'button'       => array(
				// login form
				'login_form_button' => array(
					'label'          => esc_html__( 'Login Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'login_form_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .login-wrapper .woocommerce-form-login__submit",
						'alignment'    => "{$this->main_css_element} .login-wrapper .woocommerce-form-login__submit",
						'important'    => 'all',
					),
					// doesn't work for child modules
					'text_size' => array (
						'default' => 14
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .login-wrapper .woocommerce-form-login__submit",
							'important' => true,
						),
					),
					'margin_padding' => array (
						'css' => array (
							'important' => 'padding'
						)
					),
				),
				// register
				'register_form_button' => array(
					'label'          => esc_html__( 'Register Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'register_form_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .login-wrapper .woocommerce-form-register__submit",
						'alignment'    => "{$this->main_css_element} .login-wrapper .woocommerce-form-register__submit",
						'important'    => 'all',
					),
					// doesn't work for child modules
					'text_size' => array (
						'default' => 14
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .login-wrapper .woocommerce-form-register__submit",
							'important' => true,
						),
					),
					'margin_padding' => array (
						'css' => array (
							'important' => 'padding'
						)
					),
				),
				// lost password form
				'lost_password_form_button' => array(
					'label'          => esc_html__( 'Lost Password Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'lost_password_form_button',
					'css'            => array(
						'main'         => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword button.button",
						'alignment'    => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword button.button",
						'important'    => 'all',
					),
					// doesn't work for child modules
					'text_size' => array (
						'default' => 14
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword button.button",
							'important' => true,
					),
				),
					'margin_padding' => array (
						'css' => array (
							'important' => 'padding'
						)
					),
				),

				// account details submit settings start
				'account_details_submit'       => array(
					'label'           => esc_html__( 'Submit Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'account_details_buttons',
					'css'             => array(
						'main'      => ".woocommerce {$this->main_css_element} .edit-account-wrapper .woocommerce-EditAccountForm.edit-account p button[type='submit']",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'label'   => esc_html__( 'Submit Button Box Shadow', 'divi-shop-builder' ),
						'css'     => array(
							'main'      => "{$this->main_css_element} .edit-account-wrapper .woocommerce-EditAccountForm.edit-account p button[type='submit']",
							'important' => true,
						),
						'show_if' => array(
							'custom_account_details_submit' => 'on',
						)
					),
				),
				// account details submit settings end

				// account downloads button settings start
				'downloads_button_view'        => array(
					'label'           => esc_html__( 'Download Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'downloads_buttons_download',
					'css'             => array(
						'main'      => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td.download-file .button",
						'alignment' => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td.download-file",
						'important' => 'all',
					),
					// doesn't work for child modules
					'text_size'       => array(
						'default' => 14
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td.download-file .button",
							'important' => true,
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'important' => 'padding'
						)
					),
				),
				'downloads_button_browse'      => array(
					'label'           => esc_html__( 'Browse Products Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'downloads_buttons_browse',
					'css'             => array(
						'main'      => "{$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info .button",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info .button",
							'important' => true,
						),
					),
					// doesn't work for child modules
					'text_size'       => array(
						'default' => 14
					),
					'margin_padding'  => array(
						'css' => array(
							'important' => 'padding'
						)
					),
				),
				// account downloads button settings end

				// account orders button settings start
				'orders_button_view'           => array(
					'label'           => esc_html__( 'Orders View Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'orders_buttons',
					'css'             => array(
						'main'      => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button",
						'alignment' => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button",
							'important' => true,
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button",
							'important' => 'all'
						)
					),
					'icon'            => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button::after",
							'important' => 'all'
						)
					),
					'font_size'       => array(
						'default' => '14px',
					)
				),
				'orders_button_browse'         => array(
					'label'           => esc_html__( 'Orders Browse Products Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'orders_buttons_browse',
					'css'             => array(
						'main'      => "{$this->main_css_element} .orders-wrapper .woocommerce-Message.woocommerce-Message--info .button",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css'     => array(
							'main'      => "{$this->main_css_element} .orders-wrapper .woocommerce-Message.woocommerce-Message--info .button",
							'important' => true,
						),
						'show_if' => array(
							'custom_orders_button_browse' => 'on',
							'item'                        => 'orders'
						)
					),
					'margin_padding'  => [
						'css' => [
							'important' => 'all'
						]
					]
				),
				'orders_button_download'       => array(
					'label'           => esc_html__( 'Download Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'orders_buttons_download',
					'css'             => array(
						'main'      => ".woocommerce {$this->main_css_element} .view-order-wrapper .button.woocommerce-MyAccount-downloads-file",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .view-order-wrapper .button.woocommerce-MyAccount-downloads-file",
							'important' => true,
						),
					),
					'margin_padding'  => [
						'css' => [
							'important' => 'all'
						]
					]
				),
				'orders_button_order'          => array(
					'label'           => esc_html__( 'Order Again Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'orders_buttons_order',
					'css'             => array(
						'main'      => ".woocommerce {$this->main_css_element} .view-order-wrapper .order-again .button",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .view-order-wrapper .order-again .button",
							'important' => true,
						),
					)
				),
				'orders_pagination_buttons'    => array(
					'label'           => esc_html__( 'Order Pagination Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'orders_pagination_buttons',
					'css'             => array(
						'main' => ".woocommerce {$this->main_css_element} .orders-wrapper .woocommerce-pagination .woocommerce-button.button",

						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => ".woocommerce {$this->main_css_element} .orders-wrapper .woocommerce-pagination .woocommerce-button.button",
							'important' => true,
						),
					)
				),
				// account orders button settings end

				// account address button settings start
				'address_button_edit'          => array(
					'label'           => esc_html__( 'Addresses Edit Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'address_buttons',
					'css'             => array(
						'main'      => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address .woocommerce-Address-title a.edit",
						'important' => 'all',
					),
					'border_width'    => array(
						'default' => '0px'
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address .woocommerce-Address-title a.edit",
							'important' => true,
						),
					)
				),
				'address_billing_button_save'  => array(
					'label'           => esc_html__( 'Billing Save Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'address_billing_save_button',
					'css'             => array(
						'main'      => "{$this->main_css_element} .edit-billing-wrapper .woocommerce-address-fields p button[type='submit']",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .edit-billing-wrapper .woocommerce-address-fields p button[type='submit']",
							'important' => true,
						),
					)
				),
				'address_shipping_button_save' => array(
					'label'           => esc_html__( 'Shipping Save Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'address_shipping_save_button',
					'css'             => array(
						'main'      => "{$this->main_css_element} .edit-shipping-wrapper .woocommerce-address-fields p button[type='submit']",
						'important' => 'all',
					),
					'box_shadow'      => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .edit-shipping-wrapper .woocommerce-address-fields p button[type='submit']",
							'important' => true,
						),
					)
				)
				// account address button settings end
			),
			'form_field'   => array(
				// login & register forms start
				'login_form_fields'         => array(
					'label'           => esc_html__( 'Login Form Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'login_form_fields',
					'css'             => array(
						'background_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
						'main'                   => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
						'background_color_hover' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:hover",
						'focus_background_color' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus",
						'form_text_color'        => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
						'form_text_color_hover'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:hover",
						'focus_text_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus",
						'placeholder_focus'      => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus::-moz-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
						'margin'                 => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
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
						'name'              => 'login_form_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'	=> array(
							'item' => 'login'
						)
					),
					'border_styles'   => array(
						'login_form_fields'       => array(
							'name'         => 'login_form_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
									'border_styles' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text"
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'off|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '',
								),
							),
							'fields_after'    => array(
								'use_login_form_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_login_form_fields_focus",
										"border_styles_login_form_fields_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'login_form_fields',
									'default_on_front' => 'off',
									'show_if'	=> array(
										'item' => 'login'
									)
								),
							),
							'label_prefix' => esc_html__( 'Login Forms Fields', 'divi-shop-builder' ),
							'show_if'	=> array(
								'item' => 'login'
							),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
							),
							'hover'     => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:hover",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text:focus::-moz-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-textt:focus:-ms-input-placeholder",
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
							'main'      => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
							'padding'   => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
							'margin'    => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login input.input-text",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin' => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if' => array( 'item' => 'login' )
				),
				'register_form_fields'         => array(
					'label'           => esc_html__( 'Register Form Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'register_form_fields',
					'css'             => array(
						'background_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
						'main'                   => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
						'background_color_hover' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:hover",
						'focus_background_color' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus",
						'form_text_color'        => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
						'form_text_color_hover'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:hover",
						'focus_text_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus",
						'placeholder_focus'      => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus::-moz-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
						'margin'                 => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
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
						'name'              => 'register_form_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if' => array( 'item' => 'login', 'is_woo_myaccount_registration_enabled' => 'yes' )
					),
					'border_styles'   => array(
						'register_form_fields'       => array(
							'name'         => 'register_form_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
									'border_styles' => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text"
								),
								'important' => 'all',
							),
							'defaults'      => array(
								'border_radii'  => 'off|0px|0px|0px|0px',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => ''
								),
							),
							'fields_after'    => array(
								'use_register_form_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_register_form_fields_focus",
										"border_styles_register_form_fields_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'register_form_fields',
									'default_on_front' => 'off'
								),
							),
							'label_prefix' => esc_html__( 'Register Form Fields', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
							),
							'hover'     => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:hover",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text:focus::-moz-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-textt:focus:-ms-input-placeholder",
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
							'main'      => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
							'padding'   => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
							'margin'    => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register input.input-text",
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
				'lost_password_form_fields'         => array(
					'label'           => esc_html__( 'Lost Password Form Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'lost_password_form_fields',
					'css'             => array(
						'background_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
						'main'                   => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
						'background_color_hover' => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:hover",
						'focus_background_color' => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus",
						'form_text_color'        => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
						'form_text_color_hover'  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:hover",
						'focus_text_color'       => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus",
						'placeholder_focus'      => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus::-moz-placeholder, {$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
						'margin'                 => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
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
						'name'              => 'lost_password_form_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'	=> array(
							'item' => 'login'
					)
					),
					'border_styles'   => array(
						'lost_password_form_fields'       => array(
							'name'         => 'lost_password_form_fields',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
									'border_styles' => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text"
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
							'fields_after'    => array(
								'use_lost_password_form_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_lost_password_form_fields_focus",
										"border_styles_lost_password_form_fields_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'lost_password_form_fields',
									'default_on_front' => 'off',
									'show_if'	=> array(
										'item' => 'login'
									)
								),
							),
							'label_prefix' => esc_html__( 'Login Forms Fields', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
							),
							'hover'     => array(
								"{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:hover",
								"{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text:focus::-moz-placeholder",
								"{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-textt:focus:-ms-input-placeholder",
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
							'main'      => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
							'padding'   => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
							'margin'    => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword input.input-text",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin' => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if' => array( 'item' => 'login' )
				),
				// login & register forms end

				// account details field & dropdown settings start
				'account_details_fields'     => array(
					'label'           => esc_html__( 'Account Details Fields', 'divi-shop-builder' ),
					'toggle_slug'     => 'account_details_fields',
					'toggle_priority' => 60,
					'css'             => array(
						'background_color'       => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
						'main'                   => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
						'background_color_hover' => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:hover, {$this->main_css_element} .edit-account-wrapper .form-row textarea:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:hover, {$this->main_css_element} .edit-account-wrapper .form-row textarea:hover",
						'focus_text_color'       => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus",
						'placeholder_focus'      => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus::-moz-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
						'margin'                 => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
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
						'name'              => 'account_details_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'           => array(
							'item' => 'edit-account'
						)
					),
					'border_styles'   => array(
						'account_details_fields' => array(
							'name'            => 'account_details_fields',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
									'border_styles' => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_account_details_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_account_details_fields_focus",
										"border_styles_account_details_fields_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'account_details_fields',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-account'
									)
								),
							),
							'label_prefix'    => esc_html__( 'Account Details Fields', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:hover, {$this->main_css_element} .edit-account-wrapper .form-row textarea:hover",
								"{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus::-moz-placeholder",
								"{$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus:focus:-ms-input-placeholder",
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
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
							'padding'   => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
							'margin'    => "{$this->main_css_element} .edit-account-wrapper .form-row input.input-text, {$this->main_css_element} .edit-account-wrapper .form-row textarea",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'         => array( 'item' => 'edit-account' )
				),
				'account_details_dropdowns'  => array(
					'label'           => esc_html__( 'Account Details Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'account_details_dropdowns',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
						'background_color'       => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
						'background_color_hover' => "{$this->main_css_element} .edit-account-wrapper .form-row select:hover, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-account-wrapper .form-row select:focus, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single .select2-selection__rendered",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-account-wrapper .form-row select:hover, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered",
						'focus_text_color'       => "{$this->main_css_element} .edit-account-wrapper .form-row select:focus, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
						'placeholder_focus'      => "{$this->main_css_element} .edit-account-wrapper .form-row select:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus::-moz-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-account-wrapper .form-row textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
						'margin'                 => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
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
						'name'              => 'account_details_dropdowns',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'           => array(
							'item' => 'edit-account'
						)
					),
					'border_styles'   => array(
						'account_details_dropdowns' => array(
							'name'            => 'account_details_dropdowns',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
									'border_styles' => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_account_details_dropdowns_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_account_details_dropdowns_focus",
										"border_styles_account_details_dropdowns_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'account_details_dropdowns',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-account'
									)
								),
							),
							'label_prefix'    => esc_html__( 'Account Details Dropdowns', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-account-wrapper .form-row select:hover, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single:hover .select2-selection__rendered"
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
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
							'padding'   => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
							'margin'    => "{$this->main_css_element} .edit-account-wrapper .form-row select, {$this->main_css_element} .edit-account-wrapper .form-row .select2.select2-container .select2-selection--single",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'         => array( 'item' => 'edit-account' )
				),
				// account details field & dropdown settings end

				// account addresses field & dropdown settings start
				'address_billing_fields'     => array(
					'label'          => esc_html__( 'Billing Address Fields', 'divi-shop-builder' ),
					'toggle_slug'    => 'address_billing_field',
					'css'            => array(
						'background_color'       => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
						'main'                   => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
						'background_color_hover' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:focus, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover",
						'focus_text_color'       => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:focus, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:focus",
						'placeholder_focus'      => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:focus::-webkit-input-placeholder, {$this->main_css_element} .form-row[id^='billing_'] input.input-text:focus::-moz-placeholder, {$this->main_css_element} .form-row[id^='billing_'] textarea:focus::-moz-placeholder, {$this->main_css_element} .form-row[id^='billing_'] input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .form-row[id^='billing_'] textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
						'margin'                 => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
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
						'name'              => 'address_billing_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'           => array(
							'item' => 'edit-address'
						)
					),
					'border_styles'  => array(
						'address_billing_fields' => array(
							'name'            => 'address_billing_fields',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
									'border_styles' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_address_billing_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_address_billing_field_focus",
										"border_styles_address_billing_field_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'address_billing_field',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-address'
									)
								),
							),
							'label_prefix'    => esc_html__( 'Billing Address Fields', 'divi-shop-builder' ),
						),
					),
					'font_field'     => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover",
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover::-webkit-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover::-webkit-input-placeholder",
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover::-moz-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover::-moz-placeholder",
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:hover:-ms-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:hover:-ms-input-placeholder",
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
					'margin_padding' => array(
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
							'padding'   => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
							'margin'    => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'        => array( 'item' => 'edit-address' )
				),
				'address_billing_dropdowns'  => array(
					'label'           => esc_html__( 'Billing Address Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'address_billing_field',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
						'background_color'       => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
						'background_color_hover' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:focus, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single .select2-selection__rendered",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered",
						'focus_text_color'       => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:focus, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
						'placeholder_focus'      => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:focus::-moz-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
						'margin'                 => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
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
						'name'              => 'address_billing_dropdowns',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'label_prefix'      => esc_html__( 'Billing Address Dropdowns', 'divi-shop-builder' ),
						'show_if'           => array(
							'item' => 'edit-address'
						)
					),
					'border_styles'   => array(
						'address_billing_dropdowns' => array(
							'name'            => 'address_billing_dropdowns',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
									'border_styles' => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_address_billing_dropdowns_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_address_billing_field_focus",
										"border_styles_address_billing_field_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'address_billing_field',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-address'
									)
								),
							),
							'label_prefix'    => esc_html__( 'Billing Address Dropdowns', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single .select2-selection__rendered",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select:hover, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered"
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
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
							'padding'   => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
							'margin'    => "{$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] select, {$this->main_css_element} .edit-billing-wrapper .form-row[id^='billing_'] .select2.select2-container .select2-selection--single",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'         => array( 'item' => 'edit-address' )
				),
				'address_shipping_fields'    => array(
					'label'          => esc_html__( 'Shipping Address Fields', 'divi-shop-builder' ),
					'toggle_slug'    => 'address_shipping_field',
					'css'            => array(
						'background_color'       => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
						'main'                   => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
						'background_color_hover' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover",
						'focus_text_color'       => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus",
						'placeholder_focus'      => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus::-moz-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
						'margin'                 => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
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
						'name'              => 'address_shipping_fields',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'           => array(
							'item' => 'edit-address'
						)
					),
					'border_styles'  => array(
						'address_shipping_fields' => array(
							'name'            => 'address_shipping_fields',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
									'border_styles' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_address_shipping_fields_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_address_shipping_field_focus",
										"border_styles_address_shipping_field_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'address_shipping_field',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-address'
									)
								),
							),
							'label_prefix'    => esc_html__( 'Shipping Address Fields', 'divi-shop-builder' ),
						)
					),
					'font_field'     => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover",
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover::-webkit-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover::-webkit-input-placeholder",
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover::-moz-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover::-moz-placeholder",
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:hover:-ms-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:hover:-ms-input-placeholder",
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
					'margin_padding' => array(
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-shipping-wrapper  .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
							'padding'   => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
							'margin'    => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'        => array( 'item' => 'edit-address' )
				),
				'address_shipping_dropdowns' => array(
					'label'           => esc_html__( 'Shipping Address Dropdowns', 'divi-shop-builder' ),
					'toggle_slug'     => 'address_shipping_field',
					'toggle_priority' => 60,
					'css'             => array(
						'main'                   => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
						'background_color'       => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
						'background_color_hover' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:hover",
						'focus_background_color' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:focus, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:focus",
						'form_text_color'        => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single .select2-selection__rendered",
						'form_text_color_hover'  => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered",
						'focus_text_color'       => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:focus, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:focus .select2-selection__rendered",
						'placeholder_focus'      => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:focus::-webkit-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus::-moz-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus::-moz-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] input.input-text:focus:-ms-input-placeholder, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] textarea:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
						'margin'                 => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
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
						'name'              => 'address_shipping_dropdowns',
						'css'               => array(
							'main' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
						'show_if'           => array(
							'item' => 'edit-address'
						)
					),
					'border_styles'   => array(
						'address_shipping_dropdowns' => array(
							'name'            => 'address_shipping_dropdowns',
							'css'             => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
									'border_styles' => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single"
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'on|3px|3px|3px|3px',
								'border_styles' => array(
									'width' => '1px',
									'style' => 'solid',
									'color' => '#bbb'
								),
							),
							'fields_after'    => array(
								'use_address_shipping_dropdowns_focus_border_color' => array(
									'label'            => esc_html__( 'Use Focus Borders', 'divi-shop-builder' ),
									'description'      => esc_html__( 'Enabling this option will add borders to input fields when focused.', 'divi-shop-builder' ),
									'type'             => 'yes_no_button',
									'option_category'  => 'color_option',
									'options'          => array(
										'off' => __( 'No' , 'divi-shop-builder' ),
										'on'  => __( 'Yes' , 'divi-shop-builder' ),
									),
									'affects'          => array(
										"border_radii_address_shipping_field_focus",
										"border_styles_address_shipping_field_focus",
									),
									'tab_slug'         => 'advanced',
									'toggle_slug'      => 'address_shipping_field',
									'default_on_front' => 'off',
									'show_if'          => array(
										'item' => 'edit-address'
									)
								)
							),
							'label_prefix'    => esc_html__( 'Shipping Address Dropdowns', 'divi-shop-builder' ),
						)
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single .select2-selection__rendered",
							),
							'hover'     => array(
								"{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select:hover, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single:hover .select2-selection__rendered"
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
						'css'            => array(
							'main'      => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
							'padding'   => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
							'margin'    => "{$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] select, {$this->main_css_element} .edit-shipping-wrapper .form-row[id^='shipping_'] .select2.select2-container .select2-selection--single",
							'important' => 'all'
						),
						'custom_padding' => array(
							'default' => '15px|15px|15px|15px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					),
					'show_if'         => array( 'item' => 'edit-address' )
				),
				// account addresses field & dropdown settings end
			),
			'link_options' => false,
			'text'         => false,
		);
	}

	public function get_fields() {

		$menu_items = wc_get_account_menu_items();
		$keys       = array_keys( $menu_items );
		$default    = reset( $keys );
		$woo_enable_myaccount_registration  = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );

		if( count( $menu_items ) ){
			$menu_items = array_slice( $menu_items, 0, count( $menu_items ) - 1, true ) + array(
					'login' => __( 'Login, Register, Lost Password', 'divi-shop-builder' ),
				);
		}

		return array(
			'item'                                => array(
				'label'           => esc_html__( 'Content Item', 'divi-shop-builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $menu_items,
				'description'     => esc_html__( 'Choose which type of navigation view you would like to display.', 'divi-shop-builder' ),
				'toggle_slug'     => 'main_content',
				'default'         => $default,
				'affects'         => array(
					//login form
					'login_form_text_font',
					'login_form_text_text_align',
					'login_form_text_text_color',
					'login_form_text_font_size',
					'login_form_text_letter_spacing',
					'login_form_text_line_height',
					'login_form_text_text_shadow_style',
					'login_form_link_font',
					'login_form_link_text_align',
					'login_form_link_text_color',
					'login_form_link_font_size',
					'login_form_link_letter_spacing',
					'login_form_link_line_height',
					'login_form_link_text_shadow_style',
					'login_form_h2_font',
					'login_form_h2_text_align',
					'login_form_h2_text_color',
					'login_form_h2_font_size',
					'login_form_h2_letter_spacing',
					'login_form_h2_line_height',
					'login_form_h2_text_shadow_style',
					'login_form_labels_font',
					'login_form_labels_text_align',
					'login_form_labels_text_color',
					'login_form_labels_font_size',
					'login_form_labels_letter_spacing',
					'login_form_labels_line_height',
					'login_form_labels_text_shadow_style',
					//register form
					'register_form_text_font',
					'register_form_text_text_align',
					'register_form_text_text_color',
					'register_form_text_font_size',
					'register_form_text_letter_spacing',
					'register_form_text_line_height',
					'register_form_text_text_shadow_style',
					'register_form_link_font',
					'register_form_link_text_align',
					'register_form_link_text_color',
					'register_form_link_font_size',
					'register_form_link_letter_spacing',
					'register_form_link_line_height',
					'register_form_link_text_shadow_style',
					'register_form_h2_font',
					'register_form_h2_text_align',
					'register_form_h2_text_color',
					'register_form_h2_font_size',
					'register_form_h2_letter_spacing',
					'register_form_h2_line_height',
					'register_form_h2_text_shadow_style',
					'register_form_labels_font',
					'register_form_labels_text_align',
					'register_form_labels_text_color',
					'register_form_labels_font_size',
					'register_form_labels_letter_spacing',
					'register_form_labels_line_height',
					'register_form_labels_text_shadow_style',
					//lost password form
					'lost_password_form_text_font',
					'lost_password_form_text_text_align',
					'lost_password_form_text_text_color',
					'lost_password_form_text_font_size',
					'lost_password_form_text_letter_spacing',
					'lost_password_form_text_line_height',
					'lost_password_form_text_text_shadow_style',
					'lost_password_form_labels_font',
					'lost_password_form_labels_text_align',
					'lost_password_form_labels_text_color',
					'lost_password_form_labels_font_size',
					'lost_password_form_labels_letter_spacing',
					'lost_password_form_labels_line_height',
					'lost_password_form_labels_text_shadow_style',
					//dashboard
					'dashboard_link_font',
					'dashboard_link_text_align',
					'dashboard_link_text_color',
					'dashboard_link_font_size',
					'dashboard_link_letter_spacing',
					'dashboard_link_line_height',
					'dashboard_link_text_shadow_style',

					'dashboard_text_font',
					'dashboard_text_text_align',
					'dashboard_text_text_color',
					'dashboard_text_font_size',
					'dashboard_text_letter_spacing',
					'dashboard_text_line_height',
					'dashboard_text_text_shadow_style',
					'dashboard_link_font',
					'dashboard_link_text_align',
					'dashboard_link_text_color',
					'dashboard_link_font_size',
					'dashboard_link_letter_spacing',
					'dashboard_link_line_height',
					'dashboard_link_text_shadow_style',
					'dashboard_strong_font',
					'dashboard_strong_text_align',
					'dashboard_strong_text_color',
					'dashboard_strong_font_size',
					'dashboard_strong_letter_spacing',
					'dashboard_strong_line_height',
					'dashboard_strong_text_shadow_style',
					'account_details_labels_font',
					'account_details_labels_text_align',
					'account_details_labels_text_color',
					'account_details_labels_font_size',
					'account_details_labels_letter_spacing',
					'account_details_labels_line_height',
					'account_details_labels_text_shadow_style',
					'custom_account_details_submit',
					'account_details_submit_text_shadow_style',
					'box_shadow_style_account_details_submit',
					'downloads_th_font',
					'downloads_th_text_align',
					'downloads_th_text_color',
					'downloads_th_font_size',
					'downloads_th_letter_spacing',
					'downloads_th_line_height',
					'downloads_th_text_shadow_style',
					'downloads_td_font',
					'downloads_td_text_align',
					'downloads_td_text_color',
					'downloads_td_font_size',
					'downloads_td_letter_spacing',
					'downloads_td_line_height',
					'downloads_td_text_shadow_style',
					'downloads_table_link_font',
					'downloads_table_link_text_align',
					'downloads_table_link_text_color',
					'downloads_table_link_font_size',
					'downloads_table_link_letter_spacing',
					'downloads_table_link_line_height',
					'downloads_table_link_text_shadow_style',
					'downloads_no_items_font',
					'downloads_no_items_text_align',
					'downloads_no_items_text_color',
					'downloads_no_items_font_size',
					'downloads_no_items_letter_spacing',
					'downloads_no_items_line_height',
					'downloads_no_items_text_shadow_style',
					'orders_th_font',
					'orders_th_text_align',
					'orders_th_text_color',
					'orders_th_font_size',
					'orders_th_letter_spacing',
					'orders_th_line_height',
					'orders_th_text_shadow_style',
					'orders_td_font',
					'orders_td_text_align',
					'orders_td_text_color',
					'orders_td_font_size',
					'orders_td_letter_spacing',
					'orders_td_line_height',
					'orders_td_text_shadow_style',
					'orders_table_link_font',
					'orders_table_link_text_align',
					'orders_table_link_text_color',
					'orders_table_link_font_size',
					'orders_table_link_letter_spacing',
					'orders_table_link_line_height',
					'orders_table_link_text_shadow_style',
					'orders_no_items_font',
					'orders_no_items_text_align',
					'orders_no_items_text_color',
					'orders_no_items_font_size',
					'orders_no_items_letter_spacing',
					'orders_no_items_line_height',
					'orders_no_items_text_shadow_style',
					'address_text_font',
					'address_text_text_align',
					'address_text_text_color',
					'address_text_font_size',
					'address_text_letter_spacing',
					'address_text_line_height',
					'address_text_text_shadow_style',
					'address_billing_title_font',
					'address_billing_title_text_align',
					'address_billing_title_text_color',
					'address_billing_title_font_size',
					'address_billing_title_letter_spacing',
					'address_billing_title_line_height',
					'address_billing_title_text_shadow_style',
					'address_billing_font',
					'address_billing_text_align',
					'address_billing_text_color',
					'address_billing_font_size',
					'address_billing_letter_spacing',
					'address_billing_line_height',
					'address_billing_text_shadow_style',
					'address_shipping_title_font',
					'address_shipping_title_text_align',
					'address_shipping_title_text_color',
					'address_shipping_title_font_size',
					'address_shipping_title_letter_spacing',
					'address_shipping_title_line_height',
					'address_shipping_title_text_shadow_style',
					'address_shipping_font',
					'address_shipping_text_align',
					'address_shipping_text_color',
					'address_shipping_font_size',
					'address_shipping_letter_spacing',
					'address_shipping_line_height',
					'address_shipping_text_shadow_style',
					'address_billing_label_font',
					'address_billing_label_text_align',
					'address_billing_label_text_color',
					'address_billing_label_font_size',
					'address_billing_label_letter_spacing',
					'address_billing_label_line_height',
					'address_billing_label_text_shadow_style',
					'address_shipping_label_font',
					'address_shipping_label_text_align',
					'address_shipping_label_text_color',
					'address_shipping_label_font_size',
					'address_shipping_label_letter_spacing',
					'address_shipping_label_line_height',
					'address_shipping_label_text_shadow_style',
					'view_order_text_font',
					'view_order_text_text_align',
					'view_order_text_text_color',
					'view_order_text_font_size',
					'view_order_text_letter_spacing',
					'view_order_text_line_height',
					'view_order_text_text_shadow_style',
					'view_order_details_font',
					'view_order_details_text_align',
					'view_order_details_text_color',
					'view_order_details_font_size',
					'view_order_details_letter_spacing',
					'view_order_details_line_height',
					'view_order_details_text_shadow_style',
					'view_order_table_head_font',
					'view_order_table_head_text_align',
					'view_order_table_head_text_color',
					'view_order_table_head_font_size',
					'view_order_table_head_letter_spacing',
					'view_order_table_head_line_height',
					'view_order_table_head_text_shadow_style',
					'view_order_table_column_font',
					'view_order_table_column_text_align',
					'view_order_table_column_text_color',
					'view_order_table_column_font_size',
					'view_order_table_column_letter_spacing',
					'view_order_table_column_line_height',
					'view_order_table_column_text_shadow_style',
					'view_order_table_link_font',
					'view_order_table_link_text_align',
					'view_order_table_link_text_color',
					'view_order_table_link_font_size',
					'view_order_table_link_letter_spacing',
					'view_order_table_link_line_height',
					'view_order_table_link_text_shadow_style',
					'view_order_table_strong_font',
					'view_order_table_strong_text_align',
					'view_order_table_strong_text_color',
					'view_order_table_strong_font_size',
					'view_order_table_strong_letter_spacing',
					'view_order_table_strong_line_height',
					'view_order_table_strong_text_shadow_style',
					'view_order_table_foot_head_font',
					'view_order_table_foot_head_text_align',
					'view_order_table_foot_head_text_color',
					'view_order_table_foot_head_font_size',
					'view_order_table_foot_head_letter_spacing',
					'view_order_table_foot_head_line_height',
					'view_order_table_foot_head_text_shadow_style',
					'view_order_table_foot_column_font',
					'view_order_table_foot_column_text_align',
					'view_order_table_foot_column_text_color',
					'view_order_table_foot_column_font_size',
					'view_order_table_foot_column_letter_spacing',
					'view_order_table_foot_column_line_height',
					'view_order_table_foot_column_text_shadow_style',
					'view_order_billing_heading_font',
					'view_order_billing_heading_text_align',
					'view_order_billing_heading_text_color',
					'view_order_billing_heading_font_size',
					'view_order_billing_heading_letter_spacing',
					'view_order_billing_heading_line_height',
					'view_order_billing_heading_text_shadow_style',
					'view_order_billing_address_font',
					'view_order_billing_address_text_align',
					'view_order_billing_address_text_color',
					'view_order_billing_address_font_size',
					'view_order_billing_address_letter_spacing',
					'view_order_billing_address_line_height',
					'view_order_billing_address_text_shadow_style',
					'view_order_shipping_heading_font',
					'view_order_shipping_heading_text_align',
					'view_order_shipping_heading_text_color',
					'view_order_shipping_heading_font_size',
					'view_order_shipping_heading_letter_spacing',
					'view_order_shipping_heading_line_height',
					'view_order_shipping_heading_text_shadow_style',
					'view_order_shipping_address_font',
					'view_order_shipping_address_text_align',
					'view_order_shipping_address_text_color',
					'view_order_shipping_address_font_size',
					'view_order_shipping_address_letter_spacing',
					'view_order_shipping_address_line_height',
					'view_order_shipping_address_text_shadow_style',
					'address_billing_form_title_font',
					'address_billing_form_title_text_align',
					'address_billing_form_title_text_color',
					'address_billing_form_title_font_size',
					'address_billing_form_title_letter_spacing',
					'address_billing_form_title_line_height',
					'address_billing_form_title_text_shadow_style',
					'address_shipping_form_title_font',
					'address_shipping_form_title_text_align',
					'address_shipping_form_title_text_color',
					'address_shipping_form_title_font_size',
					'address_shipping_form_title_letter_spacing',
					'address_shipping_form_title_line_height',
					'address_shipping_form_title_text_shadow_style',
				)
			),
			'item_title'                          => array(
				'label'       => '',
				'type'        => 'ags_divi_wc_value_mapper-DSB',
				'sourceField' => 'item',
				'valueMap'    => $menu_items,
				'toggle_slug' => 'main_content'
			),

			'is_woo_myaccount_registration_enabled' => array(
				'type'     => 'hidden',
				'tab_slug' => 'general',
				'default'  => $woo_enable_myaccount_registration ? 'yes' : 'no',
			),

			'login_forms_layout' => array(
				'label'             => esc_html__( 'Forms Width', 'divi-shop-builder' ),
				'type'            => 'select',
				'options'           => array(
					'fullwidth' => esc_html__( 'Fullwidth', 'divi-shop-builder' ),
					'columns'  => esc_html__( '2 Column', 'divi-shop-builder' ),
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'login_forms_layout',
				'default'        => 'columns',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),

			// login form
			'login_form_bg_color' => array(
				'label'          => esc_html__( 'Login Form Wrapper Background', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'login_form_wrapper',
				'sub_toggle'     => 'background',
				'default'        => '',
				'show_if'		 => array(
					'item'	=> 'login'
				)
			),
			'login_form_padding' => array(
				'label'           => esc_html__( 'Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '20px|20px|20px|20px|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'login_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login'
				)
			),
			'login_form_margin' => array(
				'label'           => esc_html__( 'Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '2em|0|2em|0|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'login_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login'
				)
			),
			// register form
			'register_form_bg_color' => array(
				'label'          => esc_html__( 'Form Wrapper Background', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'register_form_wrapper',
				'sub_toggle'     => 'background',
				'default'        => '',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),
			'register_form_padding' => array(
				'label'           => esc_html__( 'Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '20px|20px|20px|20px|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'register_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),
			'register_form_margin' => array(
				'label'           => esc_html__( 'Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '2em|0|2em|0|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'register_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),
			// lost password form
			'warning_login'            => array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'message'    => sprintf( '<h4 style="font-size: 14px; margin-top:10px;">%s</h4>',
					esc_html__( 'Login, Register, Lost Password views will be displayed for unlogged users.', 'divi-shop-builder' )
				),
				'toggle_slug'     => 'main_content',
			),

			'lost_password_form_bg_color' => array(
				'label'          => esc_html__( 'Form Wrapper Background', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'lost_password_form_wrapper',
				'sub_toggle'     => 'background',
				'default'        => '',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),
			'lost_password_form_padding' => array(
				'label'           => esc_html__( 'Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '0|0|0|0|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'lost_password_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),
			'lost_password_form_margin' => array(
				'label'           => esc_html__( 'Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '0|0|0|0|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'lost_password_form_wrapper',
				'sub_toggle'      => 'spacing',
				'show_if'		 => array(
					'item'	=> 'login',
				)
			),

			'downloads_no_items_bg_color'         => array(
				'label'        => esc_html__( 'No downloads notice background color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'downloads_no_items',
				'default'      => '',
				'show_if'      => array(
					'item' => 'downloads'
				)
			),
			'orders_no_items_bg_color'            => array(
				'label'        => esc_html__( 'No orders notice background color', 'divi-shop-builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'orders_no_items',
				'default'      => '',
				'show_if'      => array(
					'item' => 'orders'
				)
			),
			'view_order_text_margin'              => array(
				'label'          => esc_html__( 'Order Details Text Margin', 'divi-shop-builder' ),
				'type'           => 'custom_margin',
				'description'    => esc_html__( 'Set custom margin for the text "Order #0000 was placed on [date] and is currently [stats]" that appears at the top of the View Order page.', 'divi-shop-builder' ),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'view_order_text',
				'mobile_options' => true,
				'show_if'        => array(
					'item' => 'orders'
				)
			),
			'billing_address_padding'             => array(
				'label'           => esc_html__( 'Billing Address Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '6px|12px|6px|12px|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'view_order_billing',
				'show_if'         => array(
					'item' => 'orders'
				)
			),
			'billing_address_margin'              => array(
				'label'           => esc_html__( 'Billing Address Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'view_order_billing',
				'show_if'         => array(
					'item' => 'orders'
				)
			),
			'billing_address_background'          => array(
				'label'          => esc_html__( 'Billing Address Background Color', 'divi-shop-builder' ),
				'description'    => esc_html__( 'Pick a color to use for the Billing Address.', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'view_order_billing',
				'hover'          => 'tabs',
				'mobile_options' => false,
				'sticky'         => true,
				'show_if'        => array(
					'item' => 'orders'
				)
			),
			'shipping_address_padding'            => array(
				'label'           => esc_html__( 'Shipping Address Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '6px|12px|6px|12px|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'view_order_shipping',
				'show_if'         => array(
					'item' => 'orders'
				)
			),
			'shipping_address_margin'             => array(
				'label'           => esc_html__( 'Shipping Address Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'view_order_shipping',
				'show_if'         => array(
					'item' => 'orders'
				)
			),
			'shipping_address_background'         => array(
				'label'          => esc_html__( 'Shipping Address Background Color', 'divi-shop-builder' ),
				'description'    => esc_html__( 'Pick a color to use for the Shipping Address.', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'view_order_shipping',
				'hover'          => 'tabs',
				'mobile_options' => false,
				'sticky'         => true,
				'show_if'        => array(
					'item' => 'orders'
				)
			),
			'address_billing_shipping_padding'    => array(
				'label'           => esc_html__( 'Billing Address Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'default'         => '6px|12px|6px|12px|false|false',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'address_billing_shipping_wrappers',
				'show_if'         => array(
					'item' => 'edit-address'
				)
			),
			'address_billing_shipping_margin'     => array(
				'label'           => esc_html__( 'Billing Address Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => false,
				'responsive'      => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'address_billing_shipping_wrappers',
				'show_if'         => array(
					'item' => 'edit-address'
				)
			),
			'address_billing_shipping_background' => array(
				'label'          => esc_html__( 'Billing Address Background Color', 'divi-shop-builder' ),
				'description'    => esc_html__( 'Pick a color to use for the Billing Address.', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'address_billing_shipping_wrappers',
				'hover'          => 'tabs',
				'mobile_options' => false,
				'sticky'         => true,
				'show_if'        => array(
					'item' => 'edit-address'
				)
			),
		);
	}

	public function render( $attrs, $content, $render_slug ) {

		global $wp;

		//Fix default text size

		//		if( ! empty($this->props['custom_orders_button_view']) && $this->props['custom_orders_button_view'] === 'on' && empty($this->props['orders_button_view_text_size']) ) {
		//			self::set_style_esc( $this->slug, array(
		//				'selector' 	  => "{$this->main_css_element} .view-order-wrapper > p:first-of-type",
		//				'declaration' => "margin: {$value};"
		//			));
		//		}

		// Order Text Margin
		if ( ! empty( $this->props['view_order_text_margin'] ) ) {
			$value = explode( '|', $this->props['view_order_text_margin'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
		} else {
			$value = '20px';
		}
		self::set_style_esc( $this->slug, array(
			'selector'    => "{$this->main_css_element} .view-order-wrapper > p:first-of-type",
			'declaration' => "margin: {$value};"
		) );


		// Billing Margin
		if ( ! empty( $this->props['billing_address_margin'] ) ) {
			$value = explode( '|', $this->props['billing_address_margin'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address",
				'declaration' => "margin: {$value};"
			) );
		}

		// Billing Padding
		if ( ! empty( $this->props['billing_address_padding'] ) ) {
			$value = explode( '|', $this->props['billing_address_padding'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address",
				'declaration' => "padding: {$value};"
			) );
		}

		// Billing Background
		if ( ! empty( $this->props['billing_address_background'] ) ) {
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address",
				'declaration' => "background-color: {$this->props['billing_address_background']};"
			) );
		}

		// Shipping Padding
		if ( ! empty( $this->props['shipping_address_padding'] ) ) {
			$value = explode( '|', $this->props['shipping_address_padding'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address",
				'declaration' => "padding: {$value};"
			) );
		}
		// Shipping Margin
		if ( ! empty( $this->props['shipping_address_margin'] ) ) {
			$value = explode( '|', $this->props['shipping_address_margin'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address",
				'declaration' => "margin: {$value};"
			) );
		}

		// Shipping Background
		if ( ! empty( $this->props['shipping_address_background'] ) ) {
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address",
				'declaration' => "background-color: {$this->props['shipping_address_background']};"
			) );
		}

		// Address Billing Margin
		if ( ! empty( $this->props['address_billing_shipping_margin'] ) ) {
			$value = explode( '|', $this->props['address_billing_shipping_margin'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address",
				'declaration' => "margin: {$value};"
			) );
		}

		// Address Billing Padding
		if ( ! empty( $this->props['address_billing_shipping_padding'] ) ) {
			$value = explode( '|', $this->props['address_billing_shipping_padding'] );
			$value = ( $value[0] ? $value[0] : 0 ) . ' ' . ( $value[1] ? $value[1] : 0 ) . ' ' . ( $value[2] ? $value[2] : 0 ) . ' ' . ( $value[3] ? $value[3] : 0 );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address",
				'declaration' => "padding: {$value};"
			) );
		}

		// Address Billing Background
		if ( ! empty( $this->props['address_billing_shipping_background'] ) ) {
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address",
				'declaration' => "background-color: {$this->props['address_billing_shipping_background']};"
			) );
		}

		$button_view_use_icon = ! empty( $this->props['downloads_button_view_use_icon'] ) ? $this->props['downloads_button_view_use_icon'] : 'off';
		if ( $button_view_use_icon === 'on' && ! empty( $this->props['downloads_button_view_icon'] ) ) {
			$icon = dswcp_decoded_et_icon( $this->props['downloads_button_view_icon'] );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .downloads-wrapper table.woocommerce-table--order-downloads td.download-file .button::after",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		$button_browse_use_icon = ! empty( $this->props['downloads_button_browse_use_icon'] ) ? $this->props['downloads_button_browse_use_icon'] : 'off';
		if ( $button_browse_use_icon === 'on' && ! empty( $this->props['downloads_button_browse_icon'] ) ) {
			$icon = dswcp_decoded_et_icon( $this->props['downloads_button_browse_icon'] );
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info .button::after",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		if ( ! empty( $this->props['downloads_no_items_bg_color'] ) ) {
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .downloads-wrapper .woocommerce-Message.woocommerce-Message--info",
				'declaration' => "background-color:  {$this->props['downloads_no_items_bg_color']} !important;"
			) );
		}

		if ( ! $this->_can_render() ) {
			return '';
		}

		/*switch( $this->props['item'] ){
			case 'edit-address':
				$content = $this->get_edit_address_output();
				break;
			case 'edit-account':
				$content = $this->get_edit_account_output();
				break;
			case 'downloads':
				$content = $this->downloads_output();
				break;
			case 'orders':
				$content = $this->orders_output();
				break;
			default:
				if ( has_action('woocommerce_account_'.$this->props['item'].'_endpoint') ) {
					ob_start();
					do_action('woocommerce_account_'.$this->props['item'].'_endpoint');
					$content = ob_get_clean();
				} else {
					$content = $this->dashboard_output();
				}
				break;
		}*/
		
		if ( isset( $attrs['item'] ) && $attrs['item'] === 'login' && ( ! is_user_logged_in() || isset( $wp->query_vars['lost-password'] ) ) ) {
			$itemContent = $this->login_output();
		} else if ( ! empty( $wp->query_vars ) ) {
			
			
			foreach ( $wp->query_vars as $key => $value ) {
				if ( 'pagename' === $key ) {
					continue;
				}

				switch ( $key ) {
					case 'edit-address':
						$itemContent = $this->get_edit_address_output();
						break;
					case 'edit-account':
						$itemContent = $this->get_edit_account_output();
						break;
					case 'downloads':
						$itemContent = $this->downloads_output();
						break;
					case 'orders':
						$itemContent = $this->orders_output();
						break;
					case 'view-order':
						$itemContent = $this->orders_output();
						break;
					default:
						if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
							ob_start();
							do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
							$itemContent = ob_get_clean();
						}
						break;
				}

			}
		}
		
		if (!isset($itemContent)) {
			$itemContent = $this->dashboard_output();
		}

		return sprintf( '<div class="woocommerce-MyAccount-content">%s</div>', $itemContent );
	}

	protected function _render_module_wrapper( $output = '', $render_slug = '' ) {
		if ( ! $this->_can_render() ) {
			return '';
		}

		return parent::_render_module_wrapper( $output, $render_slug );
	}

	protected function _can_render() {


		$endpoint = ! empty( $this->props['item'] ) && $this->props['item'] !== 'dashboard' ? $this->props['item'] : '';

		switch ( $endpoint ) {
			case 'orders':
				if ( get_query_var( 'view-order', false ) ) {
					$endpoint = 'view-order';
				}
				break;

			case 'subscriptions':
				if ( get_query_var( 'view-subscription', false ) ) {
					$endpoint = 'view-subscription';
				}
				break;

			case 'payment-methods':
				if ( get_query_var( 'add-payment-method', false ) !== false ) {
					$endpoint = 'add-payment-method';
				} else if ( get_query_var( 'delete-payment-method', false ) !== false ) {
					$endpoint = 'delete-payment-method';
				} else if ( get_query_var( 'set-default-payment-method', false ) !== false ) {
					$endpoint = 'set-default-payment-method';
				}
				break;
				
			case 'login':
				if ( get_query_var( 'lost-password', false ) !== false ) {
					$endpoint = 'lost-password';
				}
				break;
		}

		return ( $endpoint === 'lost-password' || is_user_logged_in() === ($endpoint !== 'login') )
					&& dswcp_is_account_endpoint( $endpoint === 'login' ? '' : $endpoint );
	}
	
	public static function setFieldShowIf($field) {
		// Add condition for register form
		if ( isset($field['toggle_slug']) ) {
			
			if (empty($field['show_if'])) {
				$field['show_if'] = [];
			}
			
			switch ($field['toggle_slug']) {
				
				case 'register_form_text':
				case 'register_form_labels':
				case 'register_form_fields':
				case 'register_form_button':
				case 'register_form_wrapper':
				case 'login_forms_layout':
					$field['show_if'][ 'is_woo_myaccount_registration_enabled' ] = 'yes';
					// no break
				case 'login_form_text':
				case 'login_form_labels':
				case 'login_form_fields':
				case 'login_form_button':
				case 'login_form_wrapper':
				case 'lost_password_form_text':
				case 'lost_password_form_labels':
				case 'lost_password_form_fields':
				case 'lost_password_form_button':
				case 'lost_password_form_wrapper':
				case 'login_border':
					$field['show_if'][ 'item' ] = 'login';
					break;
					
				case 'dashboard_text':
					$field['show_if'][ 'item' ] = 'dashboard';
					break;
				
				case 'account_details_labels':
				case 'account_details_fields':
				case 'account_details_dropdowns':
				case 'account_details_buttons':
					$field['show_if'][ 'item' ] = 'edit-account';
					break;
				
				case 'downloads_table':
				case 'downloads_table_head':
				case 'downloads_table_column':
				case 'downloads_table_link':
				case 'downloads_no_items':
				case 'downloads_buttons_download':
				case 'downloads_buttons_browse':
					$field['show_if'][ 'item' ] = 'downloads';
					break;
				
				case 'orders_table':
				case 'orders_table_head':
				case 'orders_table_column':
				case 'orders_table_link':
				case 'orders_no_items':
				case 'orders_buttons':
				case 'orders_buttons_browse':
				case 'orders_buttons_download':
				case 'orders_buttons_order':
				case 'orders_pagination_buttons':
				case 'view_order_text':
				case 'view_order_details':
				case 'view_order_table_head':
				case 'view_order_table_column':
				case 'view_order_table_footer':
				case 'view_order_billing':
				case 'view_order_shipping':
					$field['show_if'][ 'item' ] = 'orders';
					break;
				
				case 'address_text':
				case 'address_billing_title':
				case 'address_billing_form_title':
				case 'address_shipping_title':
				case 'address_shipping_form_title':
				case 'address_billing':
				case 'address_shipping':
				case 'address_billing_label':
				case 'address_shipping_label':
				case 'address_billing_field':
				case 'address_shipping_field':
				case 'address_buttons':
				case 'address_billing_save_button':
				case 'address_shipping_save_button':
				case 'address_billing_shipping_wrappers':
					$field['show_if'][ 'item' ] = 'edit-address';
					break;
					
			}
			
			
			return $field;
		}
		
		return null;
	}
	
	protected function _add_borders_fields() {
		// Borders fields may not support show_if when using the option template
		add_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
		parent::_add_borders_fields();
		remove_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
	}
	
	public static function _false() {
		return false;
	}

	/**
	 * Override parent method to setup conditional text shadow fields
	 * {@see parent::_set_fields_unprocessed}
	 *
	 * @param Array fields array
	 */
	protected function _set_fields_unprocessed( $fields ) {

		if ( ! is_array( $fields ) ) {
			return;
		}

		$template            = ET_Builder_Module_Helper_OptionTemplate::instance();
		$text_shadow_factory = ET_Builder_Module_Fields_Factory::get( 'TextShadow' );
		$newFields = [];

		foreach ( $fields as $field => $definition ) {
			if ( ($definition === 'text_shadow' || $definition === 'box_shadow') && $template->is_enabled() && $template->has( $definition ) ) {

					$data          = $template->get_data( $field );
					$setting       = end( $data );

				$settingWithShowIf = self::setFieldShowIf($setting);
				$new_definition    = $settingWithShowIf ? ET_Builder_Module_Fields_Factory::get($definition === 'box_shadow' ? 'BoxShadow' : 'TextShadow')->get_fields($settingWithShowIf) : null;
				if ($new_definition ) {
				$field      = array_keys( $new_definition )[0];
				$definition = array_values( $new_definition )[0];
				}

			} else {
				$definitionWithShowIf = self::setFieldShowIf($definition);
				$definition = $definitionWithShowIf ? $definitionWithShowIf : $definition;
			}
			
			$newFields[$field] = $definition;
		}
		
		return parent::_set_fields_unprocessed($newFields);
	}

	private function get_edit_address_output() {

		$button_edit_use_icon = ! empty( $this->props['address_button_edit_use_icon'] ) ? $this->props['address_button_edit_use_icon'] : 'off';
		if ( $button_edit_use_icon === 'on' && ! empty( $this->props['address_button_edit_icon'] ) ) {
			$icon      = dswcp_decoded_et_icon( $this->props['address_button_edit_icon'] );
			$placement = $this->props['address_button_edit_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-address-wrapper .woocommerce-Address .woocommerce-Address-title a.edit::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		$button_billing_use_icon = ! empty( $this->props['address_billing_button_save_use_icon'] ) ? $this->props['address_billing_button_save_use_icon'] : 'off';
		if ( $button_billing_use_icon === 'on' && ! empty( $this->props['address_billing_button_save_icon'] ) ) {
			$icon      = dswcp_decoded_et_icon( $this->props['address_billing_button_save_icon'] );
			$placement = $this->props['address_billing_button_save_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-billing-wrapper .woocommerce-address-fields p button[type='submit']::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		$button_shipping_use_icon = ! empty( $this->props['address_shipping_button_save_use_icon'] ) ? $this->props['address_shipping_button_save_use_icon'] : 'off';
		if ( $button_shipping_use_icon === 'on' && ! empty( $this->props['address_shipping_button_save_icon'] ) ) {
			$icon      = dswcp_decoded_et_icon( $this->props['address_shipping_button_save_icon'] );
			$placement = $this->props['address_shipping_button_save_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-shipping-wrapper .woocommerce-address-fields p button[type='submit']::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		$address_type  = get_query_var( get_option( 'woocommerce_myaccount_edit_address_endpoint', 'edit-address' ), false );
		$wrapper_class = $address_type === false || empty( $address_type ) ? 'edit-address-wrapper' : "edit-{$address_type}-wrapper";

		ob_start();

		woocommerce_account_edit_address( $address_type );

		return sprintf( '<div class="%s">%s</div>', $wrapper_class, ob_get_clean() );
	}


	private function get_edit_account_output() {

		$button_submit_use_icon = ! empty( $this->props['account_details_submit_use_icon'] ) ? $this->props['account_details_submit_use_icon'] : 'off';
		if ( $button_submit_use_icon === 'on' && ! empty( $this->props['account_details_submit_icon'] ) ) {
			$icon      = dswcp_decoded_et_icon( $this->props['account_details_submit_icon'] );
			$placement = $this->props['account_details_submit_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .edit-account-wrapper .woocommerce-EditAccountForm.edit-account p button[type='submit']::{$placement}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		ob_start();

		woocommerce_account_edit_account();

		return sprintf( '<div class="%s">%s</div>', 'edit-account-wrapper', ob_get_clean() );
	}


	private function downloads_output() {

		ob_start();

		woocommerce_account_downloads();

		return sprintf( '<div class="%s">%s</div>', 'downloads-wrapper', ob_get_clean() );
	}


	private function orders_output() {

		$button_view_use_icon = ! empty( $this->props['orders_button_view_use_icon'] ) ? $this->props['orders_button_view_use_icon'] : 'off';
		if ( $button_view_use_icon === 'on' && ! empty( $this->props['orders_button_view_icon'] ) ) {
			$icon     = dswcp_decoded_et_icon( et_pb_process_font_icon( $this->props['orders_button_view_icon'] ) );
			$position = $this->props['orders_button_view_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button::{$position}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		$button_browser_use_icon = ! empty( $this->props['orders_button_browse_use_icon'] ) ? $this->props['orders_button_browse_use_icon'] : 'off';
		if ( $button_browser_use_icon === 'on' && ! empty( $this->props['orders_button_browse_icon'] ) ) {
			$icon     = dswcp_decoded_et_icon( $this->props['orders_button_browse_icon'] );
			$position = $this->props['orders_button_browse_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .orders-wrapper .woocommerce-Message.woocommerce-Message--info .button::{$position}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			) );
		}

		if ( ! empty( $this->props['orders_no_items_bg_color'] ) ) {
			self::set_style_esc( $this->slug, array(
				'selector'    => "{$this->main_css_element} .orders-wrapper .woocommerce-Message.woocommerce-Message--info",
				'declaration' => "background-color: {$this->props['orders_no_items_bg_color']} !important;"
			) );
		}

		$is_view_order = ! empty( get_query_var( 'view-order', 0 ) );

		ob_start();

		if ( $is_view_order ) {
			woocommerce_account_view_order( absint( get_query_var( 'view-order', 0 ) ) );
		} else {
			//woocommerce_account_orders(0);

			//phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidatedNotSanitized
			$page_url  = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$final_url = explode( '/', $page_url );

			if ( isset( $final_url ) ) {
				array_pop( $final_url );
				$pageID = end( $final_url );
				if ( $pageID == 'orders' ) {
					woocommerce_account_orders( 1 );
				} else {
					woocommerce_account_orders( (int) $pageID );
				}
			}
		}

		return sprintf( '<div class="%s">%s</div>', $is_view_order ? 'view-order-wrapper' : 'orders-wrapper', ob_get_clean() );

	}


	private function dashboard_output() {

		ob_start();

		wc_get_template(
			'myaccount/dashboard.php',
			array(
				'current_user' => get_user_by( 'id', get_current_user_id() ),
			)
		);

		return sprintf( '<div class="%s">%s</div>', 'dashboard-wrapper', ob_get_clean() );
	}

	private function login_output() {
		// Login Forms layout
		if('fullwidth' === $this->props['login_forms_layout']) {
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper .col2-set .col-1, {$this->main_css_element} .login-wrapper .col2-set .col-2",
				'declaration' => "width: 100%; float: none;"
			));
		}

		// Login Form Background
		if( !empty( $this->props['login_form_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login",
				'declaration' => "background-color:  {$this->props['login_form_bg_color']} !important;"
			));
		}

		// Login Form Margin
		if ( !empty($this->props['login_form_margin'])) {
			$value = explode( '|', $this->props['login_form_margin'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);
		}
		self::set_style_esc( $this->slug, array(
			'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login",
			'declaration' => "margin: {$value};"
		));

		// Login Form Padding
 		if ( !empty($this->props['login_form_padding'])) {
			$value = explode( '|', $this->props['login_form_padding'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);

			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-login",
				'declaration' => "padding: {$value};"
			));

	    }


		// Register Form Background
		if( !empty( $this->props['register_form_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register",
				'declaration' => "background-color:  {$this->props['register_form_bg_color']} !important;"
			));
		}

		// Register Form Margin
		if ( !empty($this->props['register_form_margin'])) {
			$value = explode( '|', $this->props['register_form_margin'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);
		}
		self::set_style_esc( $this->slug, array(
			'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register",
			'declaration' => "margin: {$value};"
		));

		// Register Form Padding
		if ( !empty($this->props['register_form_padding'])) {
			$value = explode( '|', $this->props['register_form_padding'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);
		}
		self::set_style_esc( $this->slug, array(
			'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-form-register",
			'declaration' => "padding: {$value};"
		));

		// Lost Password Form Background
		if( !empty( $this->props['lost_password_form_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword",
				'declaration' => "background-color:  {$this->props['lost_password_form_bg_color']} !important;"
			));
		}

		// Lost Password Form Margin
		if ( !empty($this->props['lost_password_form_margin'])) {
			$value = explode( '|', $this->props['lost_password_form_margin'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);
		}
		self::set_style_esc( $this->slug, array(
			'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword",
			'declaration' => "margin: {$value};"
		));

		// Lost Password Form Padding
		if ( !empty($this->props['lost_password_form_padding'])) {
			$value = explode( '|', $this->props['lost_password_form_padding'] );
			$value = ( $value[0] ? $value[0] : 0).' '.( $value[1] ? $value[1] : 0).' '.( $value[2] ? $value[2] : 0).' '.( $value[3] ? $value[3] : 0);
		}
		self::set_style_esc( $this->slug, array(
			'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword",
			'declaration' => "padding: {$value};"
		));

		$login_form_button_use_icon = !empty( $this->props['login_form_button_use_icon'] ) ? $this->props['login_form_button_use_icon'] : 'off';
		if( $login_form_button_use_icon === 'on' && !empty( $this->props['login_form_button_icon'] ) ){
			$icon = dswcp_decoded_et_icon( et_pb_process_font_icon( $this->props['login_form_button_icon'] ) );
			$position = $this->props['login_form_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-login__submit::{$position}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		$register_form_button_use_icon = !empty( $this->props['register_form_button_use_icon'] ) ? $this->props['register_form_button_use_icon'] : 'off';
		if( $register_form_button_use_icon === 'on' && !empty( $this->props['register_form_button_icon'] ) ){
			$icon = dswcp_decoded_et_icon( et_pb_process_font_icon( $this->props['register_form_button_icon'] ) );
			$position = $this->props['register_form_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper .woocommerce-form-register__submit::{$position}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		$lost_password_form_button_use_icon = !empty( $this->props['lost_password_form_button_use_icon'] ) ? $this->props['lost_password_form_button_use_icon'] : 'off';
		if( $lost_password_form_button_use_icon === 'on' && !empty( $this->props['lost_password_form_button_icon'] ) ){
			$icon = dswcp_decoded_et_icon( et_pb_process_font_icon( $this->props['lost_password_form_button_icon'] ) );
			$position = $this->props['lost_password_form_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .login-wrapper form.woocommerce-ResetPassword button.button::{$position}",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		return sprintf( '<div class="%s">%s</div>', 'login-wrapper', do_shortcode('[woocommerce_my_account]') );
	}

}

new DSWCP_WooAccountContentItem;