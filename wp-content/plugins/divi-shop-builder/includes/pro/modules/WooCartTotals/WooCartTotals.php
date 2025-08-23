<?php

class DSWCP_WooCartTotals extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_cart_totals';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Cart Totals', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';


		/**
		 * Toggle Sections of General tab and Design tab
		 *
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content'     => esc_html__( 'Cart Totals', 'divi-shop-builder' )
				),
			),
			'advanced' => array(
				'toggles' => array(
					'totals_heading'   => array(
						'title'    => esc_html__( 'Cart Totals Title', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table'   => array(
						'title'    => esc_html__( 'Table', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_headings'   => array(
						'title'    => esc_html__( 'Table Headings', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_body'   => array(
						'title'    => esc_html__( 'Table Body', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_links'   => array(
						'title'    => esc_html__( 'Table Links', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'button_checkout' 	  => array(
						'title'    => esc_html__( 'Proceed to Checkout Button', 'divi-shop-builder' ),
						'priority' => 46,
					),
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
				'table_headings' => array(
					'label'           => esc_html__( 'Table Headings', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% th',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_headings',
					'font'            => array(
						'default' => '|700|||||||',
					),
				),
				'table_body' => array(
					'label'           => esc_html__( 'Table Body', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% td',
						'alignment' => '%%order_class%% td:not(.actions)',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_body',
					'font'            => array(
						'default' => '||||||||',
					),
				),
				'table_links' => array(
					'label'           => esc_html__( 'Table Links', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% td a',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.3em',
					),
					'toggle_slug'     => 'table_links',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'totals_heading' => array(
					'label'           => esc_html__( 'Cart Totals Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .cart_totals > h2',
						'important' => 'all',
					),
					'toggle_slug'     => 'totals_heading',
				)
			),
			'button'         => array(
				'button_checkout' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'use_alignment'  => true,
					'toggle_slug'     => 'button_checkout',
					'css'            => array(
						'main'         => '%%order_class%% .cart-collaterals .wc-proceed-to-checkout a.checkout-button',
						'alignment'    => '%%order_class%% .cart-collaterals .wc-proceed-to-checkout',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .cart-collaterals .wc-proceed-to-checkout a.checkout-button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				)
			),
			'borders' => array(
				'table' => array(
					'label'           => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Table Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% table.shop_table',
							'border_radii' 	=> '%%order_class%% table.shop_table'
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
				'table_headings' => array(
					'label_prefix'    => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_radii'  => '%%order_class%% table.shop_table th',
							'border_styles' => '%%order_class%% table.shop_table th',
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => '||||',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#ebe9eb',
							'style' => 'none',
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_color_top' => '#ebe9eb',
								'border_style_top' => 'solid',
							),
						),
					),
					'toggle_slug'     => 'table_headings',
				),
				'table_body' => array(
					'label'           => esc_html__( 'Table Body', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_radii'  => '%%order_class%% table.shop_table td',
							'border_styles' => '%%order_class%% table.shop_table td',
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => '||||',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#ebe9eb',
							'style' => 'none',
						),
						'composite'     => array(
							'border_top' => array(
								'border_width_top' => '1px',
								'border_color_top' => '#ebe9eb',
								'border_style_top' => 'solid',
							),
						),
					),
					'toggle_slug'     => 'table_body',
				)
			),
			'margin_padding' => array(
				'draggable_padding' => false,
				'css'               => array(
					'padding'   => ".woocommerce %%order_class%%",
					'margin'    => ".woocommerce %%order_class%%",
					'important' => 'all',
				),
			)
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'cart_totals_container'   => array(
				'label'    => esc_html__( 'Cart Totals', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-collaterals .cart_totals',
			),
			'cart_totals_table'   => array(
				'label'    => esc_html__( 'Cart Totals Table', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-collaterals .cart_totals table',
			),
			'cart_totals_table_th'   => array(
				'label'    => esc_html__( 'Cart Totals Table Headings', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-collaterals .cart_totals table th',
			),
			'cart_totals_table_td'   => array(
				'label'    => esc_html__( 'Cart Totals Table Body', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-collaterals .cart_totals table td',
			),
			'cart_totals_button_checkout' => array(
				'label'    => esc_html__( 'Cart Totals Checkout Button', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .cart-collaterals .wc-proceed-to-checkout a.checkout-button',
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
				'toggleVar'   => 'ags_divi_wc_notCartPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module will not function properly on the front end of your website because this is not the assigned Cart page.', 'divi-shop-builder' ),
				'toggle_slug' => 'content'
			),
			'cart_totals_title' => array(
				'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify the "title" text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Cart totals', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			'cart_totals_subtotal_text' => array(
				'label'           => esc_html__( 'Subtotal Text', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify the "subtotal" text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			'cart_totals_total_text' => array(
				'label'           => esc_html__( 'Total Text', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify the "total" text.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Total', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			'table_heading_padding' => array(
				'label'           => esc_html__( 'Table Headings Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table headings" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'table_headings',
			),
			'table_body_padding' => array(
				'label'           => esc_html__( 'Table Body Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table body" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'table_body',
			),
			'checkout_button_text' => array(
				'label'           => esc_html__( 'Proceed To Checkout Button Text', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "proceed to checkout" button text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Proceed to checkout', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true,
			),
			'checkout_button_width' => array(
				'label'           => esc_html__( 'Proceed To Checkout Button Width', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "proceed to checkout" width', 'divi-shop-builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'button_checkout',
				'default'         => '100%',
				'default_unit'    => '%',
				'allowed_units'   => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw', '%' ),
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				)
			)
		);
	}


	/**
	 * Renders the module elements
	 *
	 */
	public function render( $attrs, $content, $render_slug ) {

		// bail out if cart is empty
		if( ( WC()->cart && WC()->cart->is_empty() ) || !WC()->customer ){
			return '';
		}

		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );  // remove wc default cart totals
		remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 ); // remove wc default `proceed to checkout` button
		add_action( 'woocommerce_cart_collaterals', array( $this, 'cart_totals' ), 10 ); // add plugin cart totals
		add_action( 'woocommerce_proceed_to_checkout', array( $this, 'proceed_to_checkout_button' ), 20 ); // add plugin `proceed to checkout` button

		ob_start();

		// woocommerce/templates/cart/cart.php
		do_action( 'woocommerce_before_cart_collaterals' ); ?>
		<div class="cart-collaterals">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>
		<?php do_action( 'woocommerce_after_cart' );

		add_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );  // add back wc default cart totals
		add_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );  // add back wc default `proceed to checkout` button
		remove_action( 'woocommerce_cart_collaterals', array( $this, 'cart_totals' ), 10 ); // remove plugin cart totals
		remove_action( 'woocommerce_proceed_to_checkout', array( $this, 'proceed_to_checkout_button' ), 20 ); // remove plugin `proceed to checkout` button

		return ob_get_clean();
	}


	/**
	 * Cart totals hook
	 *
	 */
	public function cart_totals(){

		$multi_view = et_pb_multi_view_options( $this );

		// generate styles of checkout button width
		if( $this->props['checkout_button_width'] !== '100%' ){
			$this->generate_styles(
				array(
					'type'           => 'width',
					'render_slug'    => $this->slug,
					'base_attr_name' => 'checkout_button_width',
					'css_property'   => 'width',
					'selector'       => '%%order_class%% .cart-collaterals .wc-proceed-to-checkout .checkout-button',
					'important' 	 => true
				)
			);
		}

		$corners = array(
			'top' 	 => 0,
			'right'  => 1,
			'bottom' => 2,
			'left' 	 => 3
		);

		if( $this->props['table_heading_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['table_heading_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .cart-collaterals table.shop_table th',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( $this->props['table_body_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['table_body_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .cart-collaterals table.shop_table td',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		ob_start();
		include __DIR__."/templates/cart-totals.php";
		echo et_core_intentionally_unescaped(ob_get_clean(), 'html');
	}

	/**
	 * Proceed to checkout hook
	 *
	 */
	public function proceed_to_checkout_button(){
		$multi_view = et_pb_multi_view_options( $this );

		ob_start();
		include __DIR__."/templates/proceed-to-checkout-button.php";
		echo et_core_intentionally_unescaped(ob_get_clean(), 'html');
	}
}

new DSWCP_WooCartTotals;
