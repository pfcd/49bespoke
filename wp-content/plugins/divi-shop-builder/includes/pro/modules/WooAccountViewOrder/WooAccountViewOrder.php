<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account View Order
 *
 */
class DSWCP_WooAccountViewOrder extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_view_order';
	public $vb_support 		= 'on';
	protected $endpoint		= 'view-order';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account View Order', 'divi-shop-builder' );
		$this->icon  = '/';


		$this->settings_modal_toggles = array(
			'advanced'	=> array(
				'toggles' => array(
					'text'   		=> array(
						'title'             => esc_html__( 'Text', 'divi-shop-builder' ),
						'priority'          => 43,
					),
					'order_details'   		=> array(
						'title'             => esc_html__( 'Order Details', 'divi-shop-builder' ),
						'priority'          => 44,
					),
					'table'   		=> array(
						'title'             => esc_html__( 'Table', 'divi-shop-builder' ),
						'priority'          => 45,
					),
					'table_head' 	   => array(
						'title'             => esc_html__( 'Table Head', 'divi-shop-builder' ),
						'priority'          => 46
					),
					'table_column' => array(
						'title'             => esc_html__( 'Table Column', 'divi-shop-builder' ),
						'priority'          => 47
					),
					'table_links' => array(
						'title'             => esc_html__( 'Table Links', 'divi-shop-builder' ),
						'priority'          => 48
					),
					'table_footer' 	   => array(
						'title'             => esc_html__( 'Table Footer', 'divi-shop-builder' ),
						'priority'          => 49
					),
					'billing' => array(
						'title'             => esc_html__( 'Billing Address', 'divi-shop-builder' ),
						'priority'          => 50
					),
					'shipping' => array(
						'title'             => esc_html__( 'Shipping Address', 'divi-shop-builder' ),
						'priority'          => 51
					)
				)
			)
		);

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->advanced_fields = array(
			'fonts' => array(
				'text'     => array(
					'label'           => esc_html__( 'Order Message', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} p:not(address > p)",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'text'
				),
				'order_details'     => array(
					'label'       => esc_html__( 'Order Details Heading', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .woocommerce-order-details .woocommerce-order-details__title",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => '26px',
					),
					'toggle_slug' => 'order_details'
				),
				'table_head'     => array(
					'label'           => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table thead th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_head'
				),
				'table_column'     => array(
					'label'           => esc_html__( 'Table Column', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table td",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_column'
				),
				'table_link'     => array(
					'label'           => esc_html__( 'Table Links', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table td a",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_column'
				),
				'table_strong'     => array(
					'label'           => esc_html__( 'Table Column Bold', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table td strong",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_column'
				),
				'table_foot_head'     => array(
					'label'           => esc_html__( 'Table Footer Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table tfoot th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_footer'
				),
				'table_foot_column'     => array(
					'label'           => esc_html__( 'Table Footer Column', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-order-details table tfoot td",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_footer'
				),
				'billing_heading'     => array(
					'label'           => esc_html__( 'Billing Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--billing-address h2",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '26px',
					),
					'toggle_slug'     => 'billing'
				),
				'billing_address'     => array(
					'label'           => esc_html__( 'Billing Address', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--billing-address address",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'billing',
				),
				'shipping_heading'     => array(
					'label'           => esc_html__( 'Shipping Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--shipping-address h2",
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'font_size'       => array(
						'default' => '26px',
					),
					'toggle_slug'     => 'shipping'
				),
				'shipping_address'     => array(
					'label'           => esc_html__( 'Shipping Address', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--shipping-address address",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'shipping'
				),
			),
			'borders' => array(
				'billing' => array(
					'label_prefix'	  => esc_html__( 'Billing Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--billing-address address",
							'border_radii' 	=> "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--billing-address address"
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
							'border_bottom' => array(
								'border_width_bottom' => '2px',
								'border_style_bottom' => 'solid',
								'border_color_bottom' => '#eee',
							),
							'border_right' => array(
								'border_width_right' => '2px',
								'border_style_right' => 'solid',
								'border_color_right' => '#eee',
							),
						)
					),
					'toggle_slug'     => 'billing',
				),
				'shipping' => array(
					'label_prefix'	  => esc_html__( 'Shipping Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--shipping-address address",
							'border_radii' 	=> "{$this->main_css_element} .woocommerce-customer-details .woocommerce-column--shipping-address address"
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
							'border_bottom' => array(
								'border_width_bottom' => '2px',
								'border_style_bottom' => 'solid',
								'border_color_bottom' => '#eee',
							),
							'border_right' => array(
								'border_width_right' => '2px',
								'border_style_right' => 'solid',
								'border_color_right' => '#eee',
							),
						)
					),
					'toggle_slug'     => 'shipping',
				)
			),
			'text' => array(
				'use_text_orientation' => false
			),
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

		ob_start();

		woocommerce_account_view_order( absint( get_query_var( 'view-order', 0 ) ) );

		return sprintf( '<div class="%s">%s</div>', 'woocommerce-MyAccount-content', ob_get_clean() );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'i18n' => array(
				'order_placed' => sprintf(
					/* translators: 1: order number 2: order date 3: order status */
					esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'divi-shop-builder' ),
					'<mark class="order-number">123</mark>',
					'<mark class="order-date">' . wc_format_datetime( new WC_DateTime() ) . '</mark>',
					'<mark class="order-status">Processing</mark>'
				),
				'order_details' => esc_html__( 'Order details', 'divi-shop-builder' ),
				'product' => esc_html__( 'Product', 'divi-shop-builder' ),
				'total' => esc_html__( 'Total', 'divi-shop-builder' ),
				'product_name' => esc_html__( 'My Awesome Product', 'divi-shop-builder' ),
				'subtotal' => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'shipping' => esc_html__( 'Shipping', 'divi-shop-builder' ),
				'payment_method' => esc_html__( 'Payment method', 'divi-shop-builder' ),
				'billing' => esc_html__( 'Billing address', 'divi-shop-builder' ),
				'shipping' => esc_html__( 'Shipping address', 'divi-shop-builder' ),
			)
		);

		$data['account_view_order'] = $locals;

		return $data;
	}
}

new DSWCP_WooAccountViewOrder;