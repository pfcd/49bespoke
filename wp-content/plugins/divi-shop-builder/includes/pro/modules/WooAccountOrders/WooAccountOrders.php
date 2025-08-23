<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Orders
 *
 */
class DSWCP_WooAccountOrders extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_orders';
	public $vb_support 		= 'on';
	protected $endpoint		= 'orders';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Orders', 'divi-shop-builder' );
		$this->icon  = '/';


		$this->settings_modal_toggles = array(
			'advanced'	=> array(
				'toggles' => array(
					'table'   		=> array(
						'title'             => esc_html__( 'Table', 'divi-shop-builder' ),
						'priority'          => 45,
					),
					'table_head' 	=> array(
						'title'             => esc_html__( 'Table Head', 'divi-shop-builder' ),
						'priority'          => 46
					),
					'table_column'  => array(
						'title'             => esc_html__( 'Table Column', 'divi-shop-builder' ),
						'priority'          => 47
					),
					'table_links' 	=> array(
						'title'             => esc_html__( 'Table Links', 'divi-shop-builder' ),
						'priority'          => 48
					),
					'button_view' 	=> array(
						'title'             => esc_html__( 'View Button', 'divi-shop-builder' ),
						'priority'          => 49
					),
					'no_orders' 	=> array(
						'title'             => esc_html__( 'No Orders', 'divi-shop-builder' ),
						'priority'          => 50
					)
				)
			)
		);

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->advanced_fields = array(
			'fonts' => array(
				'th'     => array(
					'label'           => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} table thead th, {$this->main_css_element} table th",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'table_head'
				),
				'td'     => array(
					'label'       => esc_html__( 'Table Column', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} table tbody td",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'table_column'
				),
				'link'     => array(
					'label'       => esc_html__( 'Table Link', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} table a:not(.button)",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'table_links'
				),
				'no_orders' => array(
					'label'       => esc_html__( 'No Orders', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} .woocommerce-Message.woocommerce-Message--info",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'no_orders'
				)
			),
			'borders' => array(
				'table' => array(
					'label_prefix'	  => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => "{$this->main_css_element} table.woocommerce-orders-table",
							'border_radii' 	=> "{$this->main_css_element} table.woocommerce-orders-table"
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
							'border_styles' => "{$this->main_css_element} table.woocommerce-orders-table td.woocommerce-orders-table__cell",
							'border_radii' 	=> "{$this->main_css_element} table.woocommerce-orders-table td.woocommerce-orders-table__cell"
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
				'button_view' => array(
					'label'          => esc_html__( 'View Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'button_view',
					'css'            => array(
						'main'         => "{$this->main_css_element} table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button",
						'alignment'    => "{$this->main_css_element} table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions",
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button",
							'important' => true,
						),
					)
				),
				'button_browser' => array(
					'label'          => esc_html__( 'Browser Products Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'no_orders',
					'css'            => array(
						'main'         => "{$this->main_css_element} .woocommerce-Message.woocommerce-Message--info .button",
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .woocommerce-Message.woocommerce-Message--info .button",
							'important' => true,
						),
					)
				)
			),
			'link_options' => false
		);

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function get_fields(){
		return array(
			'no_orders_bg_color' => array(
				'label'          => esc_html__( 'No orders notice background color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'no_orders',
				'default'        => '',
			),
		);
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		$button_view_use_icon = !empty( $this->props['button_view_use_icon'] ) ? $this->props['button_view_use_icon'] : 'off';
		if( $button_view_use_icon === 'on' && !empty( $this->props['button_view_icon'] ) ){
			$icon = dswcp_decoded_et_icon( et_pb_process_font_icon( $this->props['button_view_icon'] ) );
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button::after",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		$button_browser_use_icon = !empty( $this->props['button_browser_use_icon'] ) ? $this->props['button_browser_use_icon'] : 'off';
		if( $button_browser_use_icon === 'on' && !empty( $this->props['button_browser_icon'] ) ){
			$icon = dswcp_decoded_et_icon( $this->props['button_browser_icon'] );
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .woocommerce-Message.woocommerce-Message--info .button::after",
				'declaration' => "content:  '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		if( !empty( $this->props['no_orders_bg_color'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "{$this->main_css_element} .woocommerce-Message.woocommerce-Message--info",
				'declaration' => "background-color:  {$this->props['no_orders_bg_color']} !important;"
			));
		}

		ob_start();

		woocommerce_account_orders(0);

		return sprintf( '<div class="%s"><div class="%s">%s</div></div>', 'woocommerce', 'woocommerce-MyAccount-content', ob_get_clean() );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'html_output' => $this->render( array(), null, $this->slug )
		);

		$data['account_orders'] = $locals;

		return $data;
	}
}

new DSWCP_WooAccountOrders;