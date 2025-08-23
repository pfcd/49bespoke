<?php
include_once(DNWOO_ESSENTIAL_PATH . '/includes/modules/base/WooCommon.php');
include_once(DNWOO_ESSENTIAL_PATH . '/includes/modules/base/WooCommonSettings.php');

class DNWooMiniCart extends ET_Builder_Module {

	public $slug       = 'dnwoo_module_minicart';
	public $vb_support = 'on';
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 

	protected $module_credits = array(
		'module_uri' => 'www.divinext.com',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name = esc_html__( 'Mini Cart', 'dnwooe' );
		$this->folder_name = 'et_pb_woo_essential';
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
        $this->main_css_element = '%%order_class%%';
        $this->settings_modal_toggles['general']['toggles']['dnwoo_module_mini_cart'] = esc_html__( 'Mini Cart', 'dnwooe');
        $this->settings_modal_toggles['general']['toggles']['dnwoo_minicart_window_bg'] = array(
            'title'         =>  esc_html__( 'Mini Cart Window Background', 'dnwooe'),
            'priority'      =>  95,
        );
        $this->settings_modal_toggles['general']['toggles']['dnwoo_counter_bg'] = array(
            'title'         =>  esc_html__( 'Counter Background', 'dnwooe'),
            'priority'      =>  90,
        );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_cart_icon_design'] = esc_html__( 'Cart Icon Design', 'dnwooe');

		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_windows'] = array(
            'title' => esc_html__( 'Mini Cart Window', 'dnwooe'),
            // 'priority'	    =>	78,
            'sub_toggles'       => array(
                'dnwoo_mminicart_window_design'   => array(
                    'name' => esc_html__('Design', 'dnwooe')
                ),
                'dnwoo_mminicart_window_font'   => array(
                    'name' => esc_html__('Heading Font', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_product_text'] = array(
            'title' => esc_html__( 'Product Text', 'dnwooe'),
            // 'priority'	    =>	78,
            'sub_toggles'       => array(
                'dnwoo_mminicart_product_name'   => array(
                    'name' => esc_html__('Product Name', 'dnwooe')
                ),
                'dnwoo_mminicart_product_quantity'   => array(
                    'name' => esc_html__('Quantity Font', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_image'] = esc_html__( 'Mini Cart Image', 'dnwooe');
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_button'] = array(
            'title'             =>  esc_html__( 'Button', 'dnwooe'),
            // 'priority'	        =>	78,
            'sub_toggles'       => array(
                'dnwoo_mminicart_vbtn'   => array(
                    'name' => esc_html__('View Button', 'dnwooe')
                ),
                'dnwoo_mminicart_cbtn'   => array(
                    'name' => esc_html__('Checkout Button', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_subtotal'] = array(
            'title'             =>  esc_html__( 'Sub Total', 'dnwooe'),
            // 'priority'	        =>	78,
            'sub_toggles'       => array(
                'dnwoo_subtotal'   => array(
                    'name' => esc_html__('Subtotal', 'dnwooe')
                ),
                'dnwoo_subtotal_price'   => array(
                    'name' => esc_html__('Subtotal Price', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_empty_cart'] = esc_html__( 'Empty Cart', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_count'] = esc_html__( 'Count', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_mminicart_scrollbar'] = esc_html__( 'Scroll Bar', 'dnwooe');

		$this->advanced_fields = array(
            'text'  => false,
            'fonts' => array(
                'minicart_view_button' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo-viewcart',
                        'text_align' => '%%order_class%% .dnwoo-viewcart',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_button',
                    'sub_toggle'  => 'dnwoo_mminicart_vbtn',
                    'font'        => array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '17px'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'minicart_checkout_button' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo-checkout,%%order_class%% .dnwoo-checkout::before',
                        'text_align' => '%%order_class%% .dnwoo-checkout, %%order_class%% .dnwoo-checkout::before',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_button',
                    'sub_toggle'  => 'dnwoo_mminicart_cbtn',
                    'font'        => array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '17px'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                    
                ),
                'minicart_heading_title' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo_mminicart_items_heading',
                        'text_align' => '%%order_class%% .dnwoo_mminicart_items_heading',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_windows',
                    'sub_toggle'  => 'dnwoo_mminicart_window_font',
                    'font'        => array(
						'label' => esc_html__( 'Heading Title Font.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '17px'
                    ),
                    'text_color' => array(
                        'default'   => '#333333'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'minicart_product_name' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo_mminicart_cart_bag .widget_shopping_cart_content .dnwoo-mini-cart-item .woocommerce-mini-cart.cart_list.product_list_widget .woocommerce-mini-cart-item.mini_cart_item a',
                        'text_align' => '%%order_class%% .dnwoo_mminicart_cart_bag .widget_shopping_cart_content .dnwoo-mini-cart-item .woocommerce-mini-cart.cart_list.product_list_widget .woocommerce-mini-cart-item.mini_cart_item a',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_product_text',
                    'sub_toggle'  => 'dnwoo_mminicart_product_name',
                    'font'        => array(
						'label' => esc_html__( 'Product Name Font.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '17px'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'minicart_quantity_price_text' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag .woocommerce-mini-cart .mini_cart_item .quantity',
                        'text_align' => '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag .woocommerce-mini-cart .mini_cart_item .quantity',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_product_text',
                    'sub_toggle'  => 'dnwoo_mminicart_product_quantity',
                    'font'        => array(
						'label' => esc_html__( 'Quantity Font.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '14px'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'text_color' => array(
                        'default'   => '#999999'
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'minicart_subtotal_text' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .woocommerce-mini-cart__total > strong',
                        'text_align' => '%%order_class%% .woocommerce-mini-cart__total > strong',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_subtotal',
                    'sub_toggle'  => 'dnwoo_subtotal',
                    'font'        => array(
						'label' => esc_html__( 'Subtotal Font.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '16px'
                    ),
                    'text_color' => array(
                        'default'   => '#333333'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'dnwoo_mini_cart_subtotal_price_text' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .woocommerce-mini-cart__total .woocommerce-Price-amount',
                        'text_align' => '%%order_class%% .woocommerce-mini-cart__total .woocommerce-Price-amount',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_subtotal',
                    'sub_toggle'  => 'dnwoo_subtotal_price',
                    'font'        => array(
						'label' => esc_html__( 'Subtotal Price Font.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '16px'
                    ),
                    'text_color' => array(
                        'default'   => '#333333'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'dnwoo_mminicart_empty_cart' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .woocommerce-mini-cart__empty-message',
                        'text_align' => '%%order_class%% .woocommerce-mini-cart__empty-message',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_empty_cart',
                    'font'        => array(
						'label' => esc_html__( 'Empty Cart.', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '16px'
                    ),
                    'text_color' => array(
                        'default'   => '#333333'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'dnwoo_mminicart_count_font' => array(
                    'css' => array(
                        'main'       => '%%order_class%% .dnwoo_mmini_cart_count_number',
                        'text_align' => '%%order_class%% .dnwoo_mmini_cart_count_number',
                    ),
                    'toggle_slug' => 'dnwoo_mminicart_count',
                    'font'        => array(
						'label' => esc_html__( 'Count Font', 'dnwooe'),
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'font_size' => array(
                        'default'   => '14px'
                    ),
                    'text_color' => array(
                        'default'   => '#FFFFFF'
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                    'hide_text_align' => true,
                ),
            ),
            'background'            => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css'   => array(
                    'main' => "%%order_class%%",
                    'important' => true,
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%%',
                ),
                'important' => 'all',
            ),
            'borders' => array(
                'default' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '.dnwoo_module_minicart%%order_class%%',
                        ),
                    ),
                ),
				'icon_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon',
							'border_styles' => '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Icon', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cart_icon_design',
                ),
				'vbtn_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo-viewcart',
							'border_styles' => '%%order_class%% .dnwoo-viewcart',
                        ),
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_mminicart_button',
					'sub_toggle'   => 'dnwoo_mminicart_vbtn',
                ),
				'cbtn_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo-checkout',
							'border_styles' => '%%order_class%% .dnwoo-checkout',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Checkout', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_mminicart_button',
					'sub_toggle'   => 'dnwoo_mminicart_cbtn',
                ),
				'minicart_img_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .mini_cart_item .size-woocommerce_thumbnail',
							'border_styles' => '%%order_class%% .mini_cart_item .size-woocommerce_thumbnail',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_mminicart_image',
                ),
				'minicart_window_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_mminicart_cart_bag',
							'border_styles' => '%%order_class%% .dnwoo_mminicart_cart_bag',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Mini Cart Window', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_mminicart_windows',
                    'sub_toggle'   => 'dnwoo_mminicart_window_design',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css'          => array(
                        'main' => '%%order_class%%',
                        'important' => 'all'
                    ),
                ),
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .mini_cart_item .size-woocommerce_thumbnail',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_mminicart_image',
                ),

            ),
            'filters' => array(
                'child_filters_target' => array(
                    'tab_slug' 		=> 'advanced',
                    'toggle_slug' 	=> 'image_settings',
					'label'         => esc_html__( 'Image', 'dnwooe' ),
					'image_grid' => array(
						'css'                 => array(
							'main' => '%%order_class%%',
						),
					),
                ),
            ),
            'max_width' => array(
				'css' => array(
					'main' => "%%order_class%%",
					'module_alignment' => '%%order_class%%',
				),
			),
        );

        $this->custom_css_fields = array(
            'dnwoo_mini_cart' => array(
                'label' => esc_html__('Mini Cart', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_mminicart_wrapper',
            ),
            'dnwoo_mini_cart_counter' => array(
                'label' => esc_html__('Counter', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_mmini_cart_count_number',
            ),
            'dnwoo_mini_cart_item_heading' => array(
                'label' => esc_html__('Mini Cart Item Heading', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_mminicart_items_heading',
            ),
            'dnwoo_mini_cart_item_image' => array(
                'label' => esc_html__('Mini Cart Item Image', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-mini-cart-item .attachment-woocommerce_thumbnail',
            ),
            'dnwoo_mini_cart_item_name' => array(
                'label' => esc_html__('Mini Cart Item Name', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-mini-cart-item ul li a',
            ),
            'dnwoo_mini_cart_subtotal_text' => array(
                'label' => esc_html__('Subtotal Text', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-mini-cart-footer .woocommerce-mini-cart__total strong',
            ),
            'dnwoo_mini_cart_subtotal_price' => array(
                'label' => esc_html__('Subtotal Price', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-mini-cart-footer .woocommerce-mini-cart__total .woocommerce-Price-amount bdi span',
            ),
            'dnwoo_mini_cart_viewcart_button' => array(
                'label' => esc_html__('View Cart Button', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-viewcart',
            ),
            'dnwoo_mini_cart_checkout_button' => array(
                'label' => esc_html__('Checkout Button', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-checkout',
            ),
        );
	}

	public function get_fields() {
		$fields = array(
			'dnwoo_mini_cart_visibility_option' => array(
				'label'            => esc_html__( 'Mini Cart Display', 'dnwooe' ),
				'description'      => esc_html__( 'Choose your Mini Cart.', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'toggle_slug'      => 'dnwoo_module_mini_cart',
				'options'          => array(
					'hover'           => esc_html__( 'Hover', 'dnwooe' ),
					'click'           => esc_html__( 'Click', 'dnwooe' ),
					'fly-out'         => esc_html__( 'Fly Out', 'dnwooe' ),
				),
				'default'          => 'hover',
				'default_on_front' => 'hover',
			),
			'dnwoo_mini_cart_visibility_flyout' => array(
				'label'            => esc_html__( 'Fly Out Left/Right', 'dnwooe' ),
				'description'      => esc_html__( 'Choose your fly out mini cart.', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'toggle_slug'      => 'dnwoo_module_mini_cart',
				'options'          => array(
					'left'           => esc_html__( 'Left', 'dnwooe' ),
					'right'          => esc_html__( 'Right', 'dnwooe' ),
				),
				'default'          => 'left',
				'default_on_front' => 'left',
                'show_if'          => array(
                    'dnwoo_mini_cart_visibility_option' => 'fly-out',
                ),
			),
			'dnwoo_mini_cart_icon' 	  => array(
				'label'               => esc_html__( 'Icon', 'dnwooe' ),
				'description'         => esc_html__( 'Choose an icon to display with your mini cart.', 'dnwooe' ),
				'type'                => 'select_icon',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'     	  => 'dnwoo_module_mini_cart',
				'default'             => '',
				'mobile_options'      => true,
			),
			'dnwoo_mini_cart_title_text_item'  		=> array(
				'label'           	=> esc_html__( 'Title Text', 'dnwooe' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'default'         	=> esc_html__( 'Items Selected', 'dnwooe' ),
				'option_category'   => 'configuration',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'dnwooe' ),
				'toggle_slug'     	=> 'dnwoo_module_mini_cart',
			),
			'dnwoo_icon_size'	=> array(
				'label'           	=> esc_html__( 'Icon Size', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the icon of the mini cart.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_cart_icon_design',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '24px',
				'default_unit'    	=> 'px',
				'range_settings'    => array(
					'min'  => 10,
					'max'  => 32,
					'step' => 1,
				),
				'hover'               => 'tabs',
				'mobile_options'      => true,
			),
			'dnwoo_icon_background_size'	=> array(
				'label'           	=> esc_html__( 'Icon Background Size', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the icon background size of the mini cart.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_cart_icon_design',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '40px',
				'default_unit'    	=> 'px',
				'range_settings'   => array(
					'min'  => 100,
					'max'  => 32,
					'step' => 1,
				),
				'hover'             => 'tabs',
				'mobile_options'      => true,
			),
            'mminicart_alignment' => array(
				'label'           => esc_html__( 'Icon Alignment', 'dnwooe' ),
				'description'     => esc_html__( 'Icon Align to the left, right or center.', 'dnwooe' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnwoo_cart_icon_design',
                'default'         => 'left',
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'dnwoo_icon_color' => array(
                'label'             => esc_html__( 'Icon Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom color for Icon color', 'dnwooe' ),
                'type'              => 'color-alpha',
                'default'           => '#FFFFFF',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
				'toggle_slug'     	=> 'dnwoo_cart_icon_design',
				'mobile_options'    => true,
            ),
			'dnwoo_mminicart_width'	=> array(
				'label'           	=> esc_html__( 'Window Width', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the window width of the mini cart.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_mminicart_windows',
				'sub_toggle'  	   	=> 'dnwoo_mminicart_window_design',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '300',
				'default_unit'    	=> 'px',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 500,
					'step' => 1,
				),
				'hover'             => 'tabs',
				'mobile_options'      => true,
			),
			'dnwoo_mini_cart_image_size'	=> array(
				'label'           	=> esc_html__( 'Minicart Image Size', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the Image size of the mini cart.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_mminicart_image',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '70',
				'default_unit'    	=> 'px',
				'range_settings'   => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'hover'             => 'tabs',
				'mobile_options'      => true,
			),
			'dnwoo_mini_count_size'	=> array(
				'label'           	=> esc_html__( 'Counter Size', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the counter size of the mini cart.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_mminicart_count',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '25',
				'default_unit'    	=> 'px',
				'range_settings'    => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'hover'             => 'tabs',
				'mobile_options'    => true,
			),
            'minicart_remove_btn_color' => array(
                'label'             => esc_html__( 'Remove Button Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom color for remove button color', 'dnwooe' ),
                'default'         	=> '#333333',
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
				'toggle_slug'     	=> 'dnwoo_mminicart_windows',
				'sub_toggle'  	   	=> 'dnwoo_mminicart_window_design',
            ),
            'minicart_item_border_color' => array(
                'label'             => esc_html__( 'Mini Cart Item Border Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom mini cart border color', 'dnwooe' ),
                'default'         	=> 'rgba(0, 0, 0, 0.1)',
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
				'toggle_slug'     	=> 'dnwoo_mminicart_windows',
				'sub_toggle'  	   	=> 'dnwoo_mminicart_window_design',
            ),
		);

        $margin_padding = array(
            'dnwoo_mminicart_viewcartbtn_margin'	=> array(
				'label'           		=> esc_html__('Viewcart Button Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_mminicart_viewcartbtn_padding'	=> array(
				'label'           		=> esc_html__('Viewcart Button Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_mminicart_checkoutbtn_margin'	=> array(
				'label'           		=> esc_html__('Checkout Button Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_mminicart_checkoutbtn_padding'	=> array(
				'label'           		=> esc_html__('Checkout Button Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
        );

        $mini_cart_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_bg_", "Icon Background Color", "dnwoo_cart_icon_design", "advanced", array('default' => '#3042fd'));
        $mini_cart_counter_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_counter_bg_", "Counter Background Color", "dnwoo_mminicart_count", "advanced", array('default' => '#6C4FFF' ));
        $mini_cart_vbtn_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_vbtn_bg_", "View Button Background Color", "dnwoo_mminicart_button", "advanced", array( 'sub_toggle' => 'dnwoo_mminicart_vbtn',));
        $mini_cart_cbtn_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_cbtn_bg_", "Checkout Button Background Color", "dnwoo_mminicart_button", "advanced", array( 'sub_toggle' => 'dnwoo_mminicart_cbtn', 'default' => '#333333' ));
        $mini_cart_window_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_window_bg_", "Mini Cart Window Background", "dnwoo_minicart_window_bg", "general", array( 'default' => '#FFFFFF' ));
        $mini_cart_scrollbar_track_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_scrollbar_track_bg_", "Mini Cart Scrollbar Track", "dnwoo_mminicart_scrollbar", "advanced", array( 'default' => '#f1f1f1' ));
        $mini_cart_scrollbar_thumb_bg_color  = DNWoo_Common::background_fields($this, "mini_cart_scrollbar_thumb_bg_", "Mini Cart Scrollbar Thumb", "dnwoo_mminicart_scrollbar", "advanced", array( 'default' => '#c1c1c1' ));
		
		
		return array_merge(
			$fields,
            $margin_padding,
			$mini_cart_bg_color,
			$mini_cart_counter_bg_color,
			$mini_cart_vbtn_bg_color,
			$mini_cart_cbtn_bg_color,
			$mini_cart_window_bg_color,
			$mini_cart_scrollbar_track_bg_color,
			$mini_cart_scrollbar_thumb_bg_color
		);
	}

	public function render( $attrs, $content, $render_slug ) {

        wp_enqueue_style('dnwoo_module_mini_cart');
		$order_class                       = $this->get_module_order_class($render_slug);
		$multi_view                        = et_pb_multi_view_options($this);
		$dnwoo_mini_cart_title_text_item   = $this->props['dnwoo_mini_cart_title_text_item'];
		$mini_cart_visibility_option       = $this->props['dnwoo_mini_cart_visibility_option'];
		$dnwoo_mini_cart_visibility_flyout = $this->props['dnwoo_mini_cart_visibility_flyout'];
		$dnwoo_icon_size                   = $this->props['dnwoo_icon_size'];
        $dnwoo_mminicart_alignment         = DNWoo_Common::get_alignment("mminicart_alignment", $this, "dnwoo");
       
		//$dnwoo_mminicart_display_options    = $this->props['dnwoo_mminicart_options'];




		$items_number = WC()->cart->get_cart_contents_count();
		$url          = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();

		$mini_cart_icon_css_property = array(
			'selector'    	=> "%%order_class%% .dnwoo_mminicart_wrapper a.dnwoo_mminicart_icon::before",
			'class' 		=> 'et-pb-icon dnwoo_mminicart_icon'
		);
		$mini_cart_icon = DNWoo_Common::get_icon_html_using_psuedo('dnwoo_mini_cart_icon', $this, $render_slug, $mini_cart_icon_css_property, "a");

        // Window Remove Button Color
        $arrow_color_order_class = '%%order_class%% .dnwoo_mminicart .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag .widget_shopping_cart_content .dnwoo-mini-cart-item .woocommerce-mini-cart .woocommerce-mini-cart-item a.remove.remove_from_cart_button';
        $dnwoo_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'minicart_remove_btn_color');
        et_pb_responsive_options()->generate_responsive_css($dnwoo_arrow_color_values, $arrow_color_order_class, 'color', $render_slug, '', 'color');
        
        // Window Item Border Color
        $minicart_item_border_order_class = '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag .woocommerce-mini-cart .mini_cart_item';
        $minicart_item_border_color_values= et_pb_responsive_options()->get_property_values($this->props, 'minicart_item_border_color');
        et_pb_responsive_options()->generate_responsive_css($minicart_item_border_color_values, $minicart_item_border_order_class, 'border-color', $render_slug, '', 'color');

		// Mini Cart Icon start
		$dnwoo_mini_cart_icon_size        = (int) $this->props['dnwoo_icon_size'];
		$dnwoo_mini_cart_icon_size_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_icon_size');
		$dnwoo_mini_cart_icon_size_tablet = isset($dnwoo_mini_cart_icon_size_values['tablet']) ? $dnwoo_mini_cart_icon_size_values['tablet'] : $dnwoo_mini_cart_icon_size;
		$dnwoo_mini_cart_icon_size_phone  = isset($dnwoo_mini_cart_icon_size_values['phone']) ? $dnwoo_mini_cart_icon_size_values['phone'] : $dnwoo_mini_cart_icon_size_tablet;

		ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon:before",
            'declaration' => sprintf('font-size: %1$spx !important ;', $dnwoo_mini_cart_icon_size),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon:before",
            'declaration' => sprintf('font-size: %1$spx !important;', $dnwoo_mini_cart_icon_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon:before",
            'declaration' => sprintf('font-size: %1$spx !important;', $dnwoo_mini_cart_icon_size_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

		// Mini Cart Icon Background Size
		$dnwoo_icon_background_size        = (int) $this->props['dnwoo_icon_background_size'];
		$dnwoo_icon_background_size_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_icon_size');
		$dnwoo_icon_background_size_tablet = isset($dnwoo_icon_background_size_values['tablet']) ? $dnwoo_icon_background_size_values['tablet'] : $dnwoo_icon_background_size;
		$dnwoo_icon_background_size_phone  = isset($dnwoo_icon_background_size_values['phone']) ? $dnwoo_icon_background_size_values['phone'] : $dnwoo_icon_background_size_tablet;

		ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon",
            'declaration' => sprintf('width: %1$spx ;height: %1$spx;', $dnwoo_icon_background_size),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx;', $dnwoo_icon_background_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon",
            'declaration' => sprintf('width: %1$spx ;height: %1$spx;', $dnwoo_icon_background_size_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

		// Mini Cart Window Width start
		$dnwoo_mminicart_width        = (int) $this->props['dnwoo_mminicart_width'];
		$dnwoo_mminicart_width_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_mminicart_width');
		$dnwoo_mminicart_width_tablet = isset($dnwoo_mminicart_width_values['tablet']) ? $dnwoo_mminicart_width_values['tablet'] : $dnwoo_mminicart_width;
		$dnwoo_mminicart_width_phone  = isset($dnwoo_mminicart_width_values['phone']) ? $dnwoo_mminicart_width_values['phone'] : $dnwoo_mminicart_width_tablet;

		ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag",
            'declaration' => sprintf('width: %1$spx ;', $dnwoo_mminicart_width),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag",
            'declaration' => sprintf('width: %1$spx ;', $dnwoo_mminicart_width_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag",
            'declaration' => sprintf('width: %1$spx ;', $dnwoo_mminicart_width_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

		// Mini Cart Count Size start
		$dnwoo_mini_count_size        = (int) $this->props['dnwoo_mini_count_size'];
		$dnwoo_mini_count_size_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_mini_count_size');
		$dnwoo_mini_count_size_tablet = isset($dnwoo_mini_count_size_values['tablet']) ? $dnwoo_mini_count_size_values['tablet'] : $dnwoo_mini_count_size;
		$dnwoo_mini_count_size_phone  = isset($dnwoo_mini_count_size_values['phone']) ? $dnwoo_mini_count_size_values['phone'] : $dnwoo_mini_count_size_tablet;

		ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_count_size),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_count_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_count_size_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

		// Mini Cart Window Image Size start
		$dnwoo_mini_cart_image_size        = (int) $this->props['dnwoo_mini_cart_image_size'];
		$dnwoo_mini_cart_image_size_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_mini_cart_image_size');
		$dnwoo_mini_cart_image_size_tablet = isset($dnwoo_mini_cart_image_size_values['tablet']) ? $dnwoo_mini_cart_image_size_values['tablet'] : $dnwoo_mini_cart_image_size;
		$dnwoo_mini_cart_image_size_phone  = isset($dnwoo_mini_cart_image_size_values['phone']) ? $dnwoo_mini_cart_image_size_values['phone'] : $dnwoo_mini_cart_image_size_tablet;

		ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .mini_cart_item .size-woocommerce_thumbnail",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_cart_image_size),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .mini_cart_item .size-woocommerce_thumbnail",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_cart_image_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .mini_cart_item .size-woocommerce_thumbnail",
            'declaration' => sprintf('width: %1$spx ; height: %1$spx ;', $dnwoo_mini_cart_image_size_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

        ob_start();
        woocommerce_mini_cart();
        $mini_cart_data = ob_get_clean();
		// Mini Cart Icon Color
		$minicart_icon_color_order_class = '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon';
		$minicart_icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_icon_color');
		et_pb_responsive_options()->generate_responsive_css($minicart_icon_color_values, $minicart_icon_color_order_class, 'color', $render_slug, '', 'color');
		
		// Mini Cart Counter Color
		$minicart_counter_color_order_class = '%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number';
		$minicart_counter_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_counter_color');
		et_pb_responsive_options()->generate_responsive_css($minicart_counter_color_values, $minicart_counter_color_order_class, 'color', $render_slug, '', 'color');


		$fly_out_lt = 'left' == $dnwoo_mini_cart_visibility_flyout ? 'dnwoo_fly_out_appear_position_left' : 'dnwoo_fly_out_appear_position';
        $data_vb 	= ('click' == $mini_cart_visibility_option ) ? 'dnwoo_mminicart_zoom_down' : (('fly-out' == $mini_cart_visibility_option)  ? $fly_out_lt .' dnwoo_mminicart_fly_out' : "dnwoo_mminicart_slide_down");


		$fly_out_close_icon =('fly-out' ==  esc_html ($mini_cart_visibility_option)) ? '<div class="dnwoo_mminicart_cart_bag_fly_out_close_icon"></div>' : '';
        $fly_overlay_markup = ('fly-out' == esc_html($mini_cart_visibility_option)) ? '<div class="dnwoo_mminicart_cart_bag_fly_out_overlay"></div>' : '';

		
		$this->apply_css( $render_slug );
		$this->apply_background_css( $render_slug );

        return sprintf( 
            '<div class="dnwoo_mminicart_cart_bag_position_left dnwoo_mminicart %7$s %8$s" data-visibility="%3$s" data-position="%9$s" data-width="%10$s">
                <div class="dnwoo_mminicart_wrapper">     
                    %2$s
                    <span class="dnwoo_mmini_cart_count_number">%1$s</span>
                    <div class="dnwoo_mminicart_cart_bag">
                        <div class="dnwoo_mminicart_items_heading"> 
                            <span class="dnwoo_mminicart_items_heading_text">%1$s</span> <span class="dnwoo_mminicart_items_title_text">%4$s</span></div>
                        <div class="widget_shopping_cart_content">
                            %11$s
                        </div>
                        %5$s
                    </div>
                    %6$s
                </div> 
            </div>', 
            esc_html( $items_number ),
            $mini_cart_icon,
            esc_attr( $mini_cart_visibility_option ),
            esc_html__( $dnwoo_mini_cart_title_text_item),
            wp_kses_post($fly_out_close_icon), // #5
            wp_kses_post($fly_overlay_markup),
            esc_attr( $data_vb ),
            $dnwoo_mminicart_alignment,
            $dnwoo_mini_cart_visibility_flyout, // #9
            $dnwoo_mminicart_width,
            $mini_cart_data
        );
	}

    public function apply_css( $render_slug ) {

        /**
         * Custom Padding Margin Output
         *
        */
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_mminicart_viewcartbtn' => array(
                'selector'  => '%%order_class%% .woocommerce-mini-cart__buttons.buttons .dnwoo-viewcart',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_mminicart_checkoutbtn' => array(
                'selector'  => '%%order_class%% .woocommerce-mini-cart__buttons.buttons .dnwoo-checkout',
                'type'      => array('margin','padding')
            ),
        );

        foreach ($customMarginPadding as $key => $value) {
            if(is_array($value['type'])){
                foreach ($value['type'] as $type) {
                    DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key."_".$type, $value['selector'], $type);
                }
            }else{
                DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key."_".$value['type'], $value['selector'], $value['type']);
            }
        }
    }

	public function apply_background_css( $render_slug ) {
		$gradient_opt = array(
			'mini_cart_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon",
				"hover"   => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_icon:hover",
            ),
			'mini_cart_counter_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number",
				"hover"   => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mmini_cart_count_number:hover",
            ),
			'mini_cart_vbtn_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo-viewcart",
				"hover"   => "%%order_class%% .dnwoo-viewcart:hover",
            ),
			'mini_cart_cbtn_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo-checkout",
				"hover"   => "%%order_class%% .dnwoo-checkout:hover",
            ),
			'mini_cart_window_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag",
				"hover"   => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo_mminicart_cart_bag:hover",
            ),
			'mini_cart_scrollbar_track_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo-mini-cart-item::-webkit-scrollbar-track",
				"hover"   => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo-mini-cart-item::-webkit-scrollbar-track:hover",
            ),
			'mini_cart_scrollbar_thumb_bg_'  => array(
				"desktop" => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo-mini-cart-item::-webkit-scrollbar-thumb",
				"hover"   => "%%order_class%% .dnwoo_mminicart_wrapper .dnwoo-mini-cart-item::-webkit-scrollbar-thumb:hover",
            ),
		);
		DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
	}
    
}

new DNWooMiniCart;