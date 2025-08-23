<?php
defined( 'ABSPATH' ) || exit;


/**
 * Module class of Woo Checkout Coupon
 *
 */
class DSWCP_WooCheckoutOrderReview extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_checkout_order_review';
	public $vb_support = 'on';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	protected $default_hooks = array(
		'woocommerce_checkout_order_review' => array(
			'woocommerce_order_review' => array(
				'priority' => 10,
				'template' => __DIR__.'/templates/review-order.php'
			),
			'woocommerce_checkout_payment' => array(
				'priority' => 20,
				'template' => __DIR__.'/templates/payment.php'
			)
		)
	);

	public function init() {
		$this->name      = esc_html__('Checkout Order', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';


		/**
		 * Toggle Sections of General tab and Design tab
		 *
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'content'     => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'title' 		  => array(
						'title'    => esc_html__( 'Title', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table'   => array(
						'title'    => esc_html__( 'Table', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'table_heading'   => array(
						'title'    => esc_html__( 'Table Headings', 'divi-shop-builder' ),
						'priority' => 45,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'text'     => array(
								'name' => 'text',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'spacing'     => array(
								'name' => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name' => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/border.svg'),
							),
						)
					),
					'table_body' 	   => array(
						'title'    => esc_html__( 'Table Body', 'divi-shop-builder' ),
						'priority' => 45,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'text'     => array(
								'name' => 'text',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory. '/includes/media/icons/typography_text.svg'),
							),
							'spacing'     => array(
								'name' => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name' => 'border',
								'icon_svg' =>  file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/border.svg'),
							),
						)
					),
					'payments' => array(
						'title'    => esc_html__( 'Payments', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'policy' => array(
						'title'    => esc_html__( 'Privacy Policy', 'divi-shop-builder' ),
						'priority' => 45,
					),
					'place_order' => array(
						'title'    => esc_html__( 'Place Order', 'divi-shop-builder' ),
						'priority' => 45,
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
			'text' 		   => false,
			'fonts'         => array(
				'title' 		=> array(
					'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% #order_review_heading',
						'important' => 'all',
					),
					'toggle_slug'     => 'title',
				),
				'table_heading' => array(
					'label'           => esc_html__( 'Table Headings', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% table.shop_table th',
						'important' => 'all',
					),
					'toggle_slug'     => 'table_heading',
                    'sub_toggle' => 'text'
				),
				'table_body' 	=> array(
					'label'           => esc_html__( 'Table Body', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% table.shop_table td',
						'important' => 'all',
					),
					'toggle_slug'     => 'table_body',
					'sub_toggle'      => 'text'
				),
				'payment_title' => array(
					'label'           => esc_html__( 'Payment method title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-checkout-payment .wc_payment_methods .wc_payment_method label',
						'important' => 'all',
					),
					'toggle_slug'     => 'payments',
				),
				'payment_box' 	=> array(
					'label'           => esc_html__( 'Payment description', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-checkout-payment .wc_payment_methods .wc_payment_method .payment_box',
						'important' => 'all',
					),
					'toggle_slug'     => 'payments',
				),
				'privacy_policy' => array(
					'label'           => esc_html__( 'Privacy policy text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-checkout-payment .place-order .woocommerce-terms-and-conditions-wrapper',
						'important' => 'all',
					),
					'toggle_slug'     => 'policy',
				),
				'privacy_link' 	=> array(
					'label'           => esc_html__( 'Privacy policy links', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .woocommerce-checkout-payment .place-order .woocommerce-terms-and-conditions-wrapper a',
						'important' => 'all',
					),
					'toggle_slug'     => 'policy',
				)
			),
			'borders' => array(
				'payments' => array(
					'label'           => esc_html__( 'Payments', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
							'border_radii' 	=> '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment'
						),
						'important' => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => ''
						),
					),
					'toggle_slug' 		=> 'payments'
				),
				'order_review_table' => array(
					'label'           => esc_html__( 'Table', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => '%%order_class%% table.shop_table',
							'border_radii' 	=> '%%order_class%% table.shop_table'
						),
						'important' => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|5px|5px|5px|5px',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#eee'
						),
					),
					'toggle_slug' 		=> 'table'
				),
				'table_heading' => array(
					'label'           => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => '.woocommerce %%order_class%% table.shop_table th',
							'border_radii' 	=> '.woocommerce %%order_class%% table.shop_table th'
						),
						'important' => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0|0|0|0',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug' 		=> 'table_heading',
					'sub_toggle'       => 'border',
				),
				'table_body' => array(
					'label'           => esc_html__( 'Table Heading', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => array(
							'border_styles' => '.woocommerce %%order_class%% table.shop_table td',
							'border_radii' 	=> '.woocommerce %%order_class%% table.shop_table td'
						),
						'important' => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off|0|0|0|0',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
					),
					'toggle_slug' 		=> 'table_body',
					'sub_toggle'       => 'border',
				)
			),
			'button'         => array(
				'place_order_button' => array(
					'label'          => esc_html__( 'Button', 'divi-shop-builder' ),
					'toggle_slug'    => 'place_order',
					'use_alignment'  => true,
					'css'            => array(
						'main'         => '%%order_class%% .woocommerce-checkout-payment #place_order',
						'alignment'    => '%%order_class%% .woocommerce-checkout-payment .form-row.place-order',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .woocommerce-checkout-payment #place_order',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
			),
			'margin_padding' => array(
				'css'               => array(
					'padding'   => '%%order_class%%',
					'margin'    => '%%order_class%%',
					'important' => 'all',
				)
			)
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'order_review_table' 		 => array(
				'label'    => esc_html__( 'Table', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% table.shop_table',
			),
			'order_review_table_heading' => array(
				'label'    => esc_html__( 'Table headings', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% table.shop_table th',
			),
			'order_review_table_body' 	 => array(
				'label'    => esc_html__( 'Table body', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% table.shop_table td',
			),
			'payments' 			 => array(
				'label'    => esc_html__( 'Payments wrapper', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .woocommerce-checkout-payment',
			),
			'payment_methods' 			 => array(
				'label'    => esc_html__( 'Payment methods container', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .woocommerce-checkout-payment ul.wc_payment_methods',
			),
			'payment_method' 			 => array(
				'label'    => esc_html__( 'Payment method', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .woocommerce-checkout-payment ul.wc_payment_methods li.wc_payment_method',
			),
			'place_order_button' 		=> array(
				'label'    => esc_html__( 'Place Order', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .woocommerce-checkout-payment #place_order',
			),
		);

		if( class_exists( 'WooCommerce_Germanized' ) ){
			foreach( $this->default_hooks as $tag => $hooks ){
				if( $tag === 'woocommerce_checkout_order_review' ){
					$this->default_hooks[$tag]['woocommerce_checkout_payment']['priority'] = 10;
					$this->default_hooks[$tag]['woocommerce_order_review']['priority'] 	   = 20;
				}
			}
		}

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
				'toggleVar'   => 'ags_divi_wc_notCheckoutPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module may not function properly on the front end of your website because this is not the assigned Checkout page.', 'divi-shop-builder' ),
				'toggle_slug' => 'content'
			),
			'order_review_heading'=> array(
				'label'           => esc_html__( 'Order review heading', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Your order', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'privacy_policy' 	  => array(
				'label'           => esc_html__( 'Show privacy policy', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content'
			),
			'checkout_policy' 	  => array(
				'label'           => esc_html__( 'Show terms and conditions', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'content'
			),
			'place_order_text' 	  => array(
				'label'           => esc_html__( 'Place order button text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Place order', 'divi-shop-builder' ),
				'toggle_slug'     => 'content',
				'mobile_options'  => true
			),
			'payment_bg' 		  => array(
				'label'           => esc_html__( 'Payments Background', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "payments" background color', 'divi-shop-builder' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'payments',
				'default'         => '#ebe9eb',
			),
			'payment_desc_bg' 	  => array(
				'label'           => esc_html__( 'Payments Description Background', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Change the "payments description" background color', 'divi-shop-builder' ),
				'type'            => 'color-alpha',
				'custom_color'    => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'payments',
				'default'         => '#dfdcde',
			),
			'payment_padding' 	  => array(
				'label'           => esc_html__( 'Payments Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "payment" padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'payments',
			),
			'payment_margin' 	  => array(
				'label'           => esc_html__( 'Payments Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "payment" margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'toggle_slug'     => 'payments',
				'priority'		  => 999
			),
			'table_heading_padding' => array(
				'label'           => esc_html__( 'Order Table Headings Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table headings" padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'table_heading',
                'sub_toggle'  => 'spacing'
			),
			'table_body_padding' => array(
				'label'           => esc_html__( 'Order Table Body Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "table body" padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '9px|12px|9px|12px|on|on',
				'toggle_slug'     => 'table_body',
                'sub_toggle'      => 'spacing'
			),
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

		if( $this->props['payment_bg'] !== '#ebe9eb' ){
			$this->generate_styles(
				array(
					'type'           => 'color',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'payment_bg',
					'css_property'   => 'background-color',
					'selector'       => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
					'important' 	 => true
				)
			);
		}

		if( $this->props['payment_desc_bg'] !== '#dfdcde' ){
			$this->generate_styles(
				array(
					'type'           => 'color',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'payment_desc_bg',
					'css_property'   => 'background-color',
					'selector'       => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment div.payment_box',
					'important' 	 => true
				)
			);

			$this->generate_styles(
				array(
					'type'           => 'color',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'payment_desc_bg',
					'css_property'   => 'border-bottom-color',
					'selector'       => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment div.payment_box::before',
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

		if( !empty( $this->props['payment_padding'] ) && $this->props['payment_padding'] !== '||||false|false' ){
			$values  = explode( '|', $this->props['payment_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( !empty( $this->props['payment_margin'] ) && $this->props['payment_margin'] !== '||||false|false' ){
			$values  = explode( '|', $this->props['payment_margin'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( !empty( $this->props['table_heading_padding'] ) && $this->props['table_heading_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['table_heading_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-checkout-review-order table.woocommerce-checkout-review-order-table th',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		if( !empty( $this->props['table_body_padding'] ) && $this->props['table_body_padding'] !== '9px|12px|9px|12px|on|on' ){
			$values  = explode( '|', $this->props['table_body_padding'] );

			foreach( $corners as $corner => $key ){

				if( !empty( $values[$key] ) ){

					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% .woocommerce-checkout-review-order table.woocommerce-checkout-review-order-table td',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}

			}
		}

		$this->toggle_default_hooks( 'remove' ); //remove wc default hooks
		add_action( 'woocommerce_checkout_order_review', array( $this, 'order_review_template' ) );  // add pluigin order review template

		ob_start();

		$this->trigger_hook();

		$content = ob_get_clean();

		remove_action( 'woocommerce_checkout_order_review', array( $this, 'order_review_template' ) );   // remove plugin templates
		$this->toggle_default_hooks( 'add' ); //add back wc default hooks

		return $content;
	}


	/**
	 * Coupon template hook
	 *
	 */
	public function order_review_template(){

		ob_start();
		if( isset( $this->default_hooks['woocommerce_checkout_order_review'] ) ){
			usort( $this->default_hooks['woocommerce_checkout_order_review'], function( $hook1, $hook2 ){
				return $hook1['priority'] - $hook2['priority'];
			});
			foreach( $this->default_hooks['woocommerce_checkout_order_review'] as $hook ){
				include $hook['template'];
			}
		}

		echo et_core_intentionally_unescaped( ob_get_clean(), 'html' );
	}


	/**
	 * Add localized strings of the module
	 *
	 * @param array
	 * @return array
	 */
	public function builder_js_data( $js_data ){

		$locals = array(
			'payment_methods' 		   => array_fill_keys( array_keys( WC()->payment_gateways()->get_available_payment_gateways() ), true ),
			'checkout_policy_text' 	   => wp_kses_post( wpautop( wc_replace_policy_page_link_placeholders( wc_get_privacy_policy_text( 'checkout' ) ) ) ),
			'terms_and_condition_text' => wc_replace_policy_page_link_placeholders( wc_get_terms_and_conditions_checkbox_text() ),
			'locals' 				   => array(
				'product_th'  	 => esc_html__( 'Product', 'divi-shop-builder' ),
				'subtotal_th' 	 => esc_html__( 'Subtotal', 'divi-shop-builder' ),
				'shipping_th' 	 => esc_html__( 'Shipping', 'divi-shop-builder' ),
				'total_th' 		 => esc_html__( 'Total', 'divi-shop-builder' ),
				'cart_item_name' => esc_html__( 'My Awesome Product', 'divi-shop-builder' ),
				'shipping_name'  => esc_html__( 'My Awesome Shipping Method', 'divi-shop-builder' )
			)
		);

		$js_data['order_review'] = $locals;

		return $js_data;
	}


	private function trigger_hook(){
		
		add_action( 'woocommerce_checkout_terms_and_conditions', array( $this, 'remove_privacy_policy_text' ), 1 );
		add_filter( 'woocommerce_terms_and_conditions_page_id', array( $this, 'remove_terms_and_conditions' ), 99);
		add_filter( 'woocommerce_order_button_html', array( $this, 'place_order_button_html' ), 99 );
		
		// Check cart contents for errors.
		do_action( 'woocommerce_check_cart_items' );

		// Calc totals.
		WC()->cart->calculate_totals();

		$multi_view = et_pb_multi_view_options( $this );

		do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<h3 id="order_review_heading" <?php echo et_core_intentionally_unescaped( $multi_view->render_attrs( array( 'content' => '{{order_review_heading}}' ) ), 'html' ); ?> >
			<?php echo esc_html( $this->props['order_review_heading'] ); ?>
		</h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' );

		remove_action( 'woocommerce_checkout_terms_and_conditions', array( $this, 'remove_privacy_policy_text' ), 1 );
		remove_filter( 'woocommerce_terms_and_conditions_page_id', array( $this, 'remove_terms_and_conditions' ), 99);
		remove_filter( 'woocommerce_order_button_html', array( $this, 'place_order_button_html' ), 99 );
	}

	/**
	 * Remove privacy policy based on instance props or page shortcode
	 *
	 */
	public function remove_privacy_policy_text(){

		if( $this->get_property_value_by_request( 'privacy_policy' ) === 'off' ){
			remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
		}

	}

	/**
	 * Remove terms and conditions based on instance props or page shortcode
	 *
	 */
	public function remove_terms_and_conditions( $page_id ){

		if( $this->get_property_value_by_request( 'checkout_policy' ) === 'off' ){
			return false;
		}

		return $page_id;
	}


	/**
	 * Helper to get term property value
	 *
	 * @return String
	 */
	private function get_property_value_by_request( $term ){

		if( !count( $this->props ) ){

			// wc fragments again adds the policy text/ terms and conditions via ajax
			// so we remove it by checking page shortcode
			// we assume single order review module available per page
			if( defined( 'DOING_AJAX' ) ){

				$post_id = url_to_postid( wp_get_referer() );

				if( $post_id ){
					$post_content = get_post( $post_id )->post_content;

					preg_match_all( '/' . get_shortcode_regex( array( $this->slug ) ) . '/', $post_content, $matches, PREG_SET_ORDER );

					if( count( $matches ) ){
						$attrs = shortcode_parse_atts( reset( $matches )[3] );

						if( is_array( $attrs ) ){
							/**
							 * this is how divi process attributes within _render method
							 *
							 * @see ET_Builder_Element::_render
							 */
							$enabled_dynamic_attributes = $this->_get_enabled_dynamic_attributes( $attrs );
							$attrs 						= $this->_encode_legacy_dynamic_content( $attrs, $enabled_dynamic_attributes );
							$attrs 						= $this->process_dynamic_attrs( $attrs );

							$this->props 				= shortcode_atts( $this->resolve_conditional_defaults( $attrs, $this->slug ), $attrs );
						}
					}
				}
			}
		}

		// return state of the property if set
		return isset( $this->props[$term] ) ? $this->props[$term] : '';
	}


	/**
	 * place order button html by module
	 *
	 */
	public function place_order_button_html( $html ){

		$order_button_text = $this->get_property_value_by_request('place_order_text');

		if( !empty( $order_button_text ) ){
			$multi_view 	   = et_pb_multi_view_options( $this );
			$multi_view_data   = $multi_view->render_attrs(
				array(
					'content' => '{{place_order_text}}',
					'attr' 	  => array(
						'value' 	 => '{{place_order_text}}',
						'data-value' => '{{place_order_text}}'
					)
				)
			);
			return sprintf(
				'<button type="submit" class="button alt %1$s" name="woocommerce_checkout_place_order" id="place_order" value="%2$s" data-value="%2$s" %3$s %4$s>%2$s</button>',
				!empty( $this->props['place_order_button_icon'] ) ? 'et_pb_custom_button_icon' : '',
				esc_html($order_button_text),
				$multi_view_data,
				!empty( $this->props['place_order_button_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['place_order_button_icon'] )).'"' : ''
			);
		}

		return $html;
	}

	private function toggle_default_hooks( $action ){
		foreach( $this->default_hooks as $tag => $hooks ){
			foreach( $hooks as $hook => $data ){
				$priority  = isset( $data['priority'] ) ? $data['priority'] : 10;
				$arg_count = isset( $data['args'] ) ? $data['args'] : 1;
				call_user_func_array( "{$action}_action", array( $tag, $hook, $priority, $arg_count ) );
			}
		}
	}
}

new DSWCP_WooCheckoutOrderReview;
