<?php

class DSWCP_WooThankYou extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_thank_you';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Thank You', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

		/**
		 * Toggle Sections of General tab and Design tab
		 *
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'debug'		  => array(
						'title'    => esc_html__( 'Test Mode', 'divi-shop-builder' ),
						'priority' => 10,
					),
					'labels'		  => array(
						'title'    => esc_html__( 'Labels', 'divi-shop-builder' ),
						'priority' => 10,
					),
					'not_found'		  => array(
						'title'    => esc_html__( 'Order Not Found', 'divi-shop-builder' ),
						'priority' => 12,
					)
				),
			),
			'advanced' => array(
				'toggles' => array(
					'content_body'   => array(
						'title'             => esc_html__( 'Texts & Links', 'divi-shop-builder' ),
						'priority'          => 10,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'     => array(
								'name' => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'     => array(
								'name' => 'a',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							)
						),
					),
					'content_headings' => array (
						'title'             => esc_html__( 'Headings', 'divi-shop-builder' ),
						'priority'          => 11,
					),
					'thank_you_msg'		  => array(
						'title'    => esc_html__( 'Thank You Message', 'divi-shop-builder' ),
						'priority' => 15,
					),
					'order_details_label' => array(
						'title'    => esc_html__( 'Order Details Labels', 'divi-shop-builder' ),
						'priority' => 20,
					),
					'order_details_value' => array(
						'title'    => esc_html__( 'Order Details Values', 'divi-shop-builder' ),
						'priority' => 25,
					),
					'downloads_title' => array(
						'title'    => esc_html__( 'Downloads Title', 'divi-shop-builder' ),
						'priority' => 26,
					),
					'downloads_table'    => array(
						'title'    => esc_html__( 'Downloads Table', 'divi-shop-builder' ),
						'priority' => 27,
					),
					'downloads_th'   => array(
						'title'    => esc_html__( 'Downloads Table Heading', 'divi-shop-builder' ),
						'priority' => 28,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'main'     => array(
								'name' => 'main',
								'icon_svg' =>  file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'p'     => array(
								'name' => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
						),
					),
					'downloads_td'   => array(
						'title'    => esc_html__( 'Downloads Table Column', 'divi-shop-builder' ),
						'priority' => 37,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'main'     => array(
								'name' => 'main',
								'icon_svg' =>  file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'p'     => array(
								'name' => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'     => array(
								'name' => 'a',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							),
						),
					),
					'downloads_button'   => array(
						'title'    => esc_html__( 'Downloads Button', 'divi-shop-builder' ),
						'priority' => 38,
					),

					'order_details_title' => array(
						'title'    => esc_html__( 'Order Details Title', 'divi-shop-builder' ),
						'priority' => 39,
					),
					'order_details_table'    => array(
						'title'    => esc_html__( 'Order Details Table', 'divi-shop-builder' ),
						'priority' => 40,
					),
					'order_details_th'   => array(
						'title'    => esc_html__( 'Order Details Table Heading', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'order_details_td'   => array(
						'title'    => esc_html__( 'Order Details Table Column', 'divi-shop-builder' ),
						'priority' => 50,
					),
					'billing_title' => array(
						'title'    => esc_html__( 'Billing Address Title', 'divi-shop-builder' ),
						'priority' => 55,
					),
					'shipping_title' => array(
						'title'    => esc_html__( 'Shipping Address Title', 'divi-shop-builder' ),
						'priority' => 60,
					),
					'billing_details' => array(
						'title'    => esc_html__( 'Billing Details', 'divi-shop-builder' ),
						'priority' => 65,
					),
					'shipping_details' => array(
						'title'    => esc_html__( 'Shipping Details', 'divi-shop-builder' ),
						'priority' => 70,
					),
					'not_found_text'		  => array(
						'title'    => esc_html__( 'Order Not Found Text', 'divi-shop-builder' ),
						'priority' => 75,
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
			'text'		   => false,
			'fonts'        => array(
				'content_body'     => array(
					'label'           => esc_html__( '', 'divi-shop-builder' ), // leave empty, text is added by default
					'css'             => array(
						'line_height' => "%%order_class%%",
						'color'       => "%%order_class%%",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'toggle_slug'     => 'content_body',
					'sub_toggle'      => 'p',
					'hide_text_align' => true,
				),
				'content_a'     => array(
					'label'       => esc_html__( 'Link', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "%%order_class%% a"
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'content_body',
					'sub_toggle'  => 'a',
				),
				'content_headings' => array(
					'label'        => esc_html__( '', 'divi-shop-builder' ),
					'css'          => array(
						'main'      => "%%order_class%% h2, %%order_class%% h1, %%order_class%% h3,%%order_class%% h4, %%order_class%% h5, %%order_class%% h6",
						'important' => 'all',
					),
					'header_level' => array(
						'default' => 'h2',
					),
					'toggle_slug'     => 'content_headings',
					'priority' => 2
				),
				'thank_you_msg' => array(
					'label'           => esc_html__( 'Thank You Message', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-notice.woocommerce-thankyou-order-received',
						'important' => 'all',
					),
					'toggle_slug'     => 'thank_you_msg',
				),
				'order_details_label' => array(
					'label'           => esc_html__( 'Label', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"], %%order_class%% .woocommerce-table--order-details thead, %%order_class%% .woocommerce-table--order-details tfoot th',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '.71em',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'toggle_slug'     => 'order_details_label'
				),
				'order_details_value' => array(
					'label'           => esc_html__( 'Value', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"] > strong, %%order_class%% .woocommerce ul.order_details.woocommerce-thankyou-order-details li strong',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '1.4em',
					),
					'line_height'     => array(
						'default' => '1.5em',
					),
					'toggle_slug'     => 'order_details_value'
				),
				'downloads_title' => array(
					'label'           => esc_html__( 'Downloads Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-downloads .woocommerce-order-downloads__title',
						'important' => 'all',
					),
					'toggle_slug'     => 'downloads_title'
				),
				'downloads_th' => array(
					'label'           => esc_html__( 'Downloads Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads thead th',
						'important' => 'all',
					),
					'toggle_slug'     => 'downloads_th',
                    'sub_toggle'      => 'p',

				),
				'downloads_td_p' => array(
					'label'           => esc_html__( 'Table Column Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads td:not(.download-file)',
						'important' => 'all',
					),
					'toggle_slug'     => 'downloads_td',
					'sub_toggle'      => 'p',
				),
				'downloads_td_a' => array(
					'label'           => esc_html__( 'Table Column Link', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads td:not(.download-file) a',
						'important' => 'all',
					),
					'toggle_slug'     => 'downloads_td',
					'sub_toggle'      => 'a',
				),
				'order_details_title' => array(
					'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-details .woocommerce-order-details__title',
						'important' => 'all',
					),
					'toggle_slug'     => 'order_details_title'
				),
				'order_details_th' => array(
					'label'           => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details thead th',
						'important' => 'all',
					),
					'toggle_slug'     => 'order_details_th'
				),
				'order_details_tfoot_th' => array(
					'label'           => esc_html__( 'Table Row heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details tfoot th',
						'important' => 'all',
					),
					'toggle_slug'     => 'order_details_th'
				),
				'order_details_td' => array(
					'label'           => esc_html__( 'Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details thead td ',
						'important' => 'all',
					),
					'toggle_slug'     => 'order_details_td'
				),
				'order_details_link' => array(
					'label'           => esc_html__( 'Table Column Links', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details tbody a',
						'important' => 'all',
					),
					'toggle_slug'     => 'order_details_td'
				),
				'billing_title'	 => array(
					'label'           => esc_html__( 'Billing Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address .woocommerce-column__title',
						'important' => 'all',
					),
					'toggle_slug'     => 'billing_title'
				),
				'shipping_title'	 => array(
					'label'           => esc_html__( 'Shipping Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address .woocommerce-column__title',
						'important' => 'all',
					),
					'toggle_slug'     => 'shipping_title'
				),
				'billing_details'	 => array(
					'label'           => esc_html__( 'Billing Details', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
						'important' => 'all',
					),
					'toggle_slug'     => 'billing_details'
				),
				'shipping_details'	 => array(
					'label'           => esc_html__( 'Shipping Details', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
						'important' => 'all',
					),
					'toggle_slug'     => 'shipping_details'
				),
				'not_found_text' => array(
					'label'           => esc_html__( 'Order Not Found Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% p.woocommerce-thankyou-order-not-found',
						'important' => 'all',
					),
					'toggle_slug'     => 'not_found_text',
				),
			),
			'button' 	   => array(
				'downloads_button' => array (
					'label'          => esc_html__( 'Downloads Button', 'divi-shop-builder' ),
					'css'            => array(
						'main'         => "{$this->main_css_element} .woocommerce-order-downloads a.woocommerce-MyAccount-downloads-file",
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .woocommerce-order-downloads a.woocommerce-MyAccount-downloads-file",
							'important' => true,
						),
					),
					'toggle_slug'     => 'downloads_button',

                )
            ),
			'form_field'   => false,
			'borders'	   => array(
				'order_details' => array(
					'label'           => esc_html__( 'Order Details', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Order Details', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
							'border_radii' 	=> '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'dashed',
							'color' => '#d3ced2'
						),
						'composite'     => array(
							'border_right' => array(
								'border_width_right' => '1px',
								'border_color_right' => '#d3ced2',
								'border_style_right' => 'dashed',
							),
						),
					),
					'toggle_slug'     => 'order_details_label',
				),
				'downloads_table' => array(
					'label'           => esc_html__( 'Downloads Table', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Downloads Table', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce .woocommerce-order-downloads table.woocommerce-table--order-downloads',
							'border_radii' 	=> '%%order_class%% .woocommerce .woocommerce-order-downloads table.woocommerce-table--order-downloads'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '5px',
							'style' => 'none',
							'color' => '#eee'
						)
					),
					'toggle_slug'     => 'downloads_table',
				),
				'downloads_td' => array(
					'label'           => esc_html__( 'Order Details Columns', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Order Details', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads tr td, %%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads tr th',
							'border_radii' 	=> '%%order_class%% ..woocommerce-order-downloads table.woocommerce-table--order-downloads tr td, %%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads tr th'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'dashed',
							'color' => '#d3ced2'
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_color_top' => 'rgba(0,0,0,.1)',
								'border_style_top' => 'solid',
							)
						),
					),
					'toggle_slug'     => 'downloads_td',
					'sub_toggle'      => 'main',
				),
				'order_details_table' => array(
					'label'           => esc_html__( 'Order Details Table', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Order Details Table', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce .woocommerce-order-details table.woocommerce-table--order-details',
							'border_radii' 	=> '%%order_class%% .woocommerce .woocommerce-order-details table.woocommerce-table--order-details'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '5px',
							'style' => 'none',
							'color' => '#eee'
						)
					),
					'toggle_slug'     => 'order_details_table',
				),
				'order_details_td' => array(
					'label'           => esc_html__( 'Order Details Columns', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Order Details', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details tr td, %%order_class%% .woocommerce-order-details table.woocommerce-table--order-details tr th',
							'border_radii' 	=> '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details tr td, %%order_class%% .woocommerce-order-details table.woocommerce-table--order-details tr th'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'dashed',
							'color' => '#d3ced2'
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_color_top' => 'rgba(0,0,0,.1)',
								'border_style_top' => 'solid',
							)
						),
					),
					'toggle_slug'     => 'order_details_td',
				),
				'billing_details' => array(
					'label'           => esc_html__( 'Billing Details Container', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Billing Details Container', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
							'border_radii' 	=> '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address'
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
						'composite'     => array(
							'border_right' => array(
								'border_width_right' => '2px'
							),
							'border_bottom' => array(
								'border_width_bottom' => '2px'
							)
						),
					),
					'toggle_slug'     => 'billing_details',
				),
				'shipping_details' => array(
					'label'           => esc_html__( 'Shipping Details Container', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Shipping Details Container', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
							'border_radii' 	=> '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address'
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
						'composite'     => array(
							'border_right' => array(
								'border_width_right' => '2px'
							),
							'border_bottom' => array(
								'border_width_bottom' => '2px'
							)
						),
					),
					'toggle_slug'     => 'shipping_details',
				),
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
				'toggleVar'   => 'ags_divi_wc_notThankYouPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module will not function properly on the front end of your website because this is not the assigned Thank You page.', 'divi-shop-builder' ),
				'toggle_slug' => 'debug'
			),
			'enable_test_mode'	  => array(
				'label'           => esc_html__( 'Enable Test Mode', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable test mode show dummy order details.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Enable', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Disable', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'debug',
			),
			'order_received_msg'  => array(
				'label'           => esc_html__( 'Order Received Message', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Thank you. Your order has been received." to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Thank you. Your order has been received.',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'order_number_text'   => array(
				'label'           => esc_html__( 'Order Number Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Order Number" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Order Number',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'order_date_text' 	  => array(
				'label'           => esc_html__( 'Order Date Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Date" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Date',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'order_email_text' 	  => array(
				'label'           => esc_html__( 'Order Email Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Email" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Email',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'order_total_text' 	  => array(
				'label'           => esc_html__( 'Order Total Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Total" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Total',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'payment_method_text' => array(
				'label'           => esc_html__( 'Payment Method Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Payment Method" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Payment Method',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'order_details_text' => array(
				'label'           => esc_html__( 'Order Details Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Order details" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Order details',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'billing_address_text' => array(
				'label'           => esc_html__( 'Billing Address Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Billing Address" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Billing Address',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'shipping_address_text' => array(
				'label'           => esc_html__( 'Shipping Address Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Shipping Address" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Shipping Address',
				'toggle_slug'     => 'labels',
				'mobile_options'  => true,
			),
			'thank_you_msg_margin' => array(
				'label'           => esc_html__( 'Thank You Message Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Thank You Message" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|0px|0px|0px|on|on',
				'toggle_slug'     => 'thank_you_msg',
				'priority'		  => 99
			),
			'order_not_found_text' => array(
				'label'           => esc_html__( 'Order Not Found Message', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Change the "Order Not Found Message" to your custom text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Order Not Found', 'divi-shop-builder' ),
				'toggle_slug'     => 'not_found'
			),
			'order_details_labels_padding' => array(
				'label'           => esc_html__( 'Order Details Labels Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Order Details Labels" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|2em|0px|0px|on|on',
				'toggle_slug'     => 'order_details_label',
				'priority'		  => 45
			),
			'order_details_labels_margin' => array(
				'label'           => esc_html__( 'Order Details Labels Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Order Details Labels" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|2em|0px|0px|on|on',
				'toggle_slug'     => 'order_details_label',
				'priority'		  => 46
			),
			'order_details_labels_bg_color' => array(
				'label'          => esc_html__( 'Order Details Labels Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'order_details_label',
				'default'        => '',
				'priority'		 => 50
			),
//			downloads start

			'downloads_table_margin' => array(
				'label'           => esc_html__( 'Downloads Table Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify a custom margin for the downloads table', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|0px|0px|0px|on|on',
				'toggle_slug'     => 'downloads_table',
			),
			'downloads_th_padding' => array(
				'label'           => esc_html__( 'Downloads Table Headings Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Table Heading" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'downloads_th',
				'sub_toggle'      => 'main',
			),
			'downloads_td_padding' => array(
				'label'           => esc_html__( 'Downloads Table Columns Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Table Column" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'downloads_td',
				'sub_toggle'      => 'main',
			),
//          downloads end

			'order_details_table_margin' => array(
				'label'           => esc_html__( 'Order Details Table Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify a custom margin for the order details table', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|0px|0px|0px|on|on',
				'toggle_slug'     => 'order_details_table',
			),
			'order_details_th_padding' => array(
				'label'           => esc_html__( 'Table Headings Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Table Heading" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'order_details_th'
			),
			'order_details_td_padding' => array(
				'label'           => esc_html__( 'Table Columns Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Table Column" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'order_details_td'
			),
			'billing_details_padding' => array(
				'label'           => esc_html__( 'Billing Details Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Billing Details" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '6px|12px|6px|12px|on|on',
				'toggle_slug'     => 'billing_details'
			),
			'billing_details_margin' => array(
				'label'           => esc_html__( 'Billing Details Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Billing Details" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|0px|0px|0px|on|on',
				'toggle_slug'     => 'billing_details',
				'priority'		  => 99
			),
			'shipping_details_padding' => array(
				'label'           => esc_html__( 'Shipping Details Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Shipping Details" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '6px|12px|6px|12px|on|on',
				'toggle_slug'     => 'shipping_details'
			),
			'shipping_details_margin' => array(
				'label'           => esc_html__( 'Shipping Details Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "Shipping Details" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '0px|0px|0px|0px|on|on',
				'toggle_slug'     => 'shipping_details',
				'priority'		  => 99
			),
			'billing_details_bg_color' => array(
				'label'          => esc_html__( 'Billing Details Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'billing_details',
				'default'        => '',
				'priority'		 => 50
			),
			'shipping_details_bg_color' => array(
				'label'          => esc_html__( 'Shipping Details Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'shipping_details',
				'default'        => '',
				'priority'		 => 50
			),


			'title_margin' => array(
				'label'          => esc_html__( 'Title Margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '||||on|on',
				'toggle_slug'     => 'content_headings',
				'priority'		  => 10
			),

			'thankyou_order_details_padding' => array(
				'label'          => esc_html__( 'Order Details Padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '||||on|on',
				'toggle_slug'     => 'order_details_label',
				'priority'		  => 45
			),
		);
	}


	/**
	 * Before render the module
	 *
	 */
	public function before_render(){

		$corners = array(
			'top' 	 => 0,
			'right'  => 1,
			'bottom' => 2,
			'left' 	 => 3
		);

		if( $this->props['thank_you_msg_margin'] !== '0px|0px|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['thank_you_msg_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-notice.woocommerce-thankyou-order-received',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['order_details_labels_padding'] !== '0px|2em|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['order_details_labels_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( $this->props['order_details_labels_margin'] !== '0px|2em|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['order_details_labels_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}
// start downloads

		if( $this->props['downloads_table_margin'] !== '0px|0px|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['downloads_table_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['downloads_th_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['downloads_th_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-downloads .woocommerce-table--order-downloads thead th',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( $this->props['downloads_td_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['downloads_td_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-downloads .woocommerce-table--order-downloads td',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}
// end downloads

		if( !empty( $this->props['order_details_labels_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
				'declaration' => "background-color:{$this->props['order_details_labels_bg_color']} !important;"
			));
		}
		
		if( $this->props['order_details_table_margin'] !== '0px|0px|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['order_details_table_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['order_details_th_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['order_details_th_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details thead th, %%order_class%% .woocommerce-order-details .woocommerce-table--order-details tfoot th',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( $this->props['order_details_td_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['order_details_td_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details td',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( $this->props['billing_details_padding'] !== '6px|12px|6px|12px|on|on' ){
			$values  = explode( '|', $this->props['billing_details_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}
		
		if( $this->props['billing_details_margin'] !== '0px|0px|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['billing_details_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['shipping_details_padding'] !== '6px|12px|6px|12px|on|on' ){
			$values  = explode( '|', $this->props['shipping_details_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}
		
		if( $this->props['shipping_details_margin'] !== '0px|0px|0px|0px|on|on' ){
			$values  = explode( '|', $this->props['shipping_details_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( !empty( $this->props['billing_details_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
				'declaration' => "background-color:{$this->props['billing_details_bg_color']} !important;"
			));
		}

		if( !empty( $this->props['shipping_details_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
				'declaration' => "background-color:{$this->props['shipping_details_bg_color']} !important;"
			));
		}

		if( $this->props['title_margin'] !== '||||on|on' ){
			$values  = explode( '|', $this->props['title_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% h2, %%order_class%% h1, %%order_class%% h3,%%order_class%% h4, %%order_class%% h5, %%order_class%% h6',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}


		if( $this->props['thankyou_order_details_padding'] !== '||||on|on' ){
			$values  = explode( '|', $this->props['thankyou_order_details_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% ul.woocommerce-thankyou-order-details',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

//		if( empty( $this->props['border_style_all_order_details_table'] ) || $this->props['border_style_all_order_details_table'] === 'solid' ){
//			self::set_style_esc( $this->slug, array(
//				'selector' 	  => '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details',
//				'declaration' => "border-style: solid !important;"
//			));
//		}

	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only order display
		global $wp;

		$order_id = !empty( $_GET['order_id'] ) ? (int) $_GET['order_id'] : 0;
		$order 	  = wc_get_order( $order_id );

		if( !$order ){

			if( $this->props['enable_test_mode'] === 'on' ){
				ob_start();
				$this->render_test_mode();
				return ob_get_clean();
			}
			return $this->render_not_found();
		}

		add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'order_received_text' ), 99, 2 );
		add_filter( 'gettext_woocommerce', array( $this, 'order_overview_labels'  ), 99, 3 );

		ob_start();

		$wp->query_vars['order-received'] =  absint( $order_id );
		if (!empty($_GET['key'])) {
			$wp->query_vars['key'] = sanitize_text_field($_GET['key']);
		}

		WC_Shortcode_Checkout::output( array() );

		$output = sprintf( '<div class="woocommerce">%s</div>', ob_get_clean() );

		remove_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'order_received_text' ), 99 );
		remove_filter( 'gettext_woocommerce', array( $this, 'order_overview_labels' ), 99 );

		return $output;
		// phpcs:enable WordPress.Security.NonceVerification.Recommended
	}


	public function order_received_text( $text, $order ){

		if( !empty( $this->props['order_received_msg'] ) ){
			$text = $this->props['order_received_msg'];
		}

		return $text;
	}


	public function order_overview_labels( $translation, $text, $domain ){

		switch( $text ){
			case 'Order number:':
				return $this->props['order_number_text'];
			case 'Date:':
				return $this->props['order_date_text'];
			case 'Email:':
				return $this->props['order_email_text'];
			case 'Total:':
				return $this->props['order_total_text'];
			case 'Payment method:':
				return $this->props['payment_method_text'];
			case 'Order details':
				return $this->props['order_details_text'];
			case 'Billing address':
				return $this->props['billing_address_text'];
			case 'Shipping address':
				return $this->props['shipping_address_text'];
			default:
				return $translation;
		}
	}

	/**
	 * Add localized strings of the module
	 *
	 * @param array
	 * @return array
	 */
	public function builder_js_data( $js_data ){
		$locals = array(
			'locals' 		 => array(
				'item_name' => esc_html__( 'My Awesome Product', 'divi-shop-builder' ),
				'payment_method' => esc_html__( 'Payment Method', 'divi-shop-builder' ),
				'product' => esc_html__( 'Product', 'divi-shop-builder' ),
				'total' => esc_html__( 'Total', 'divi-shop-builder' ),
				'sub_total' => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'shipping' => esc_html__( 'Shipping', 'divi-shop-builder' )
			),
			'date' 	=> wc_format_datetime( new WC_DateTime() ),
			'email' => get_option( 'admin_email' )
		);

		$js_data['thank_you'] = $locals;

		return $js_data;
	}


	public function render_test_mode(){
		include __DIR__.'/templates/demo.php';
	}


	public function render_not_found(){
		ob_start(); ?>

		<div class="woocommerce">
			<div className="woocommerce-order">
				<p class="woocommerce-thankyou-order-not-found">
					<?php echo esc_html($this->props['order_not_found_text']); ?>
				</p>
			</div>
		</div>

		<?php return ob_get_clean();
	}

}

new DSWCP_WooThankYou;
