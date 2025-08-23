<?php


class DNWooCarousel extends ET_Builder_Module {
	public $slug       = 'dnwoo_carousel';
    protected $next_woocarousel_count = 0 ;
	public $vb_support = 'on';
	public $icon_path = null;
    public $folder_name; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 


	protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-carousel-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

	public function init() {
		$this->name = esc_html__( 'Woo Product Carousel', 'dnwooe' );
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content'                 => esc_html__('Content', 'dnwooe'),
                    'elements'                     => esc_html__('Elements', 'dnwooe'),
                    'display_setting'              => esc_html__( 'Display', 'dnwooe' ),
                    'dnwoo_woocarousel_settings'   => esc_html__('Carousel Settings', 'dnwooe'),
                    'dnwoo_woocarousel_navigation' => esc_html__( 'Navigation Settings', 'dnwooe'),
                    'dnwoo_woocarousel_carousel'   => esc_html__( 'Effect Settings', 'dnwooe'),
                    'dnwoo_content_bg'             => esc_html__( 'Content Background', 'dnwooe'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnwoo_woocarousel_image_settings'      => esc_html__( 'Image Settings', 'dnwooe'),
                    'dnwoo_woocarousel_product_font'	=> array(
						'title'		=>	esc_html__( 'Product Texts', 'dnwooe' ),
                        'sub_toggles'            => array(
                            'dnwoo_woocarousel_text_settings'   => array(
                                'name' => esc_html__( 'Title', 'dnwooe' )
                            ),
                            'dnwoo_woocarousel_desc_settings'   => array(
                                'name' => esc_html__( 'Description', 'dnwooe' )
                            ),
                            'dnwoo_woocarousel_product_cats'   => array(
                                'name' => esc_html__( 'Category', 'dnwooe' )
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
                    'dnwoo_woocarousel_price_text_settings' => array(
                        'title' => esc_html__( 'Price Text', 'dnwooe'),
                        'sub_toggles' => array(
                            'regular_price' => array(
                                'name' => 'Regular Price'
                            ),
                            'new_price' => array(
                                'name' => 'New Price'
                            ),
                        ),
                        'tabbed_subtoggles' => true
                    ),
                    'dnwoo_woocarousel_addtocardbtn'     => array(
                        'title'         => esc_html__( 'Add to Cart/Select Option', 'dnwooe'),
                        'sub_toggles'   => array(
                            'button'    => array(
                                'name'  => esc_html__('Button', 'dnwooe'),
                            ),
                            'icon'      => array(
                                'name'  => esc_html__('Icon', 'dnwooe'),
                            )
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'dnwoo_woocarousel_viewcartbtn'         => array(
                        'title'                 => esc_html__( 'View Cart', 'dnwooe'),
                        'tabbed_subtoggles'     =>true,
                        'sub_toggles'           => array(
                            'button' => array(
                                'name' => esc_html__('Button', 'dnwooe'),
                            ),
                            'icon' => array(
                                'name' => esc_html__('Icon', 'dnwooe'),
                            )
                        )
                    ),
                    'dnwoo_woocarousel_wishlist'            => esc_html__( 'Wishlist', 'dnwooe'),
                    'dnwoo_woocarousel_compare'             => esc_html__( 'Compare', 'dnwooe'),
                    'dnwoo_woocarousel_quickviewicon'       => esc_html__( 'Quick View', 'dnwooe'),

                    'dnwoo_woocarousel_quickviewpopupbox'         => array(
                        'title'                 => esc_html__( 'Quick View Pop Up Box', 'dnwooe'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'quickviewpopupbox_title' => array(
                                'name' => esc_html__('Title', 'dnwooe')
                            ),
                            'quickviewpopupbox_desc' => array(
                                'name' => esc_html__('Desc', 'dnwooe')
                            ),
                            'quickviewpopupbox_price' => array(
                                'name' => esc_html__('Price', 'dnwooe')
                            ),
                            'quickviewpopupbox_btn' => array(
                                'name' => esc_html__('Button', 'dnwooe')
                            ),
                            'quickviewpopupbox_meta' => array(
                                'name' => esc_html__('Meta', 'dnwooe')
                            )
                        ),
                    ),
                    
                    'dnwoo_woocarousel_quickbox_popup_box_bg'       => esc_html__( 'Quick Box Popup Background', 'dnwooe'),
                    'dnwoo_woocarousel_quickbox_popup_box_arrow'    => esc_html__( 'Quick Box Popup Arrow', 'dnwooe'),
                    'quickview_popup_box_close_btn'                 => esc_html__('Quick Box Popup Close Button', 'dnwooe'),
                    'dnwoo_woocarousel_sale_badge'          => esc_html__( 'Sale Badge', 'dnwooe'),
                    'dnwoo_woocarousel_outofstock_badge'    => esc_html__( 'Out of Stock Badge', 'dnwooe'),
                    'dnwoo_woocarousel_featured_badge'      => esc_html__( 'Featured Badge', 'dnwooe'),
                    'dnwoo_woocarousel_arrow_settings'      => esc_html__( 'Navigation', 'dnwooe'),
                    'dnwoo_woocarousel_rating_settings'     => esc_html__( 'Rating', 'dnwooe'),
                ),
            ),
        );

        $this->advanced_fields = array(
            'text'  => false,
            'fonts' => array(
                'product_cats' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_categories ul, %%order_class%% .dnwoo_product_categories ul li a, %%order_class%% .dnwoo_product_categories ul li, %%order_class%% .dnwoo_product_carousel_categories ul, %%order_class%% .dnwoo_product_carousel_categories ul li, %%order_class%% .dnwoo_product_carousel_categories ul li a'
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_product_cats',
                    'font'        => array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                        'default' => "|||on|||||",
                    ),
                    'font_size' => array(
                        'default' => "12px",
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
                'header' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_title'
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_text_settings',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                    'header_level' => array(
						'default' => 'h3',
					),
                ),
                'desc' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_details p, %%order_class%% .dnwoo_product_categories p'
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_desc_settings',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'regular_price' => array(
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_product_carousel_container del .woocommerce-Price-amount, %%order_class%% .dnwoo_single_price del, %%order_class%% .dnwoo_single_price del span,  %%order_class%% .dnwoo_single_price > span, %%order_class%% .dnwoo_product_carousel.product_type_variable .dnwoo_single_price, %%order_class%% .dnwoo_product_carousel.product_type_variable .dnwoo_single_price span',
                        'text_align' => '%%order_class%% .dnwoo_product_carousel .dnwoo_single_price',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_price_text_settings',
                    'sub_toggle'  => 'regular_price',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the price texts', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the price text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'new_price' => array(
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_single_price > ins span',
                        'important' => 'all',
                    ),
                    'hide_text_align'   => true,
                    'toggle_slug' => 'dnwoo_woocarousel_price_text_settings',
                    'sub_toggle'  => 'new_price',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'sale_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-onsale',
                        'font'      => "%%order_class%% .dnwoo-onsale",
                        'color'     => "%%order_class%% .dnwoo-onsale",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_sale_badge',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'outofstock_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-stockout',
                        'font'      => "%%order_class%% .dnwoo-stockout",
                        'color'     => "%%order_class%% .dnwoo-stockout",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_outofstock_badge',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'featured_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-featured',
                        'font'      => "%%order_class%% .dnwoo-featured",
                        'color'     => "%%order_class%% .dnwoo-featured",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_featured_badge',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'add_to_card' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_carousel_choose_variable_option',
                        'text_align'=> '%%order_class%% .dnwoo_product_Wrap',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'button',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_btn' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-quick-btn',
                        'font'      => "%%order_class%% .dnwoo-quick-btn",
                        'text_align'=> '%%order_class%% .dnwoo-quick-btn',
                        'color'     => "%%order_class%% .dnwoo-quick-btn",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle'  => 'button',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_title' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-product-summery .product-title',
                        'font'      => "%%order_class%% .dnwoo-product-summery .product-title",
                        'text_align'=> '%%order_class%% .dnwoo-product-summery .product-title',
                        'color'     => "%%order_class%% .dnwoo-product-summery .product-title",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_quickviewpopupbox',
                    'sub_toggle'  => 'quickviewpopupbox_title',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_desc' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-product-summery .product-description',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_quickviewpopupbox',
                    'sub_toggle'  => 'quickviewpopupbox_desc',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_price' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-product-summery .product-price span, %%order_class%% .dnwoo-product-summery .woocommerce-variation.single_variation',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_quickviewpopupbox',
                    'sub_toggle'  => 'quickviewpopupbox_price',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_meta' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
                        'font'      => "%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a",
                        'text_align'=> '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
                        'color'     => "%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_quickviewpopupbox',
                    'sub_toggle'  => 'quickviewpopupbox_meta',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'view_cart' => array(
                    'css' => array(
                        'main'      => '%%order_class%% .added_to_cart',
                        'font'      => "%%order_class%% .added_to_cart",
                        'color'     => "%%order_class%% .added_to_cart",
                        'important' => 'all',
                    ),
                    'toggle_slug'=> 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'button',
                    'font'=> array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment '=> array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height'=> array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'addtocarticon' => array(
                    'css' => array(
                        'main'      => "%%order_class%% .icon_cart,%%order_class%% .icon_menu.dnwoo_carousel_choose_variable_option_icon",
                        'important' => 'all',
                    ),
                    'text_color'       => array(
						'label' => esc_html__( 'Icon Color', 'dnwooe' ),
					),
                    'font_size'        => array(
						'label' => esc_html__( 'Font Size', 'dnwooe' ),
					),
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'icon',
                    'hide_font'=> true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow'  => true,
                    'hide_line_height' => true,
                ),
                'viewcarticon' => array(
                    'css' => array(
                        'main'      => "%%order_class%% .dnwoo_carousel_social_icon_wrap a.added_to_cart, %%order_class%% .dnwoo_carousel_social_icon_wrap a.added_to_cart::before",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'icon',
                    'hide_font'=> true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow'  => true,
                    'hide_line_height' => true,
                ),
                'quickviewicon' => array(
                    'css' => array(
                        'main'      => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_quickview",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_quickviewicon',
                    'sub_toggle'  => 'icon',
                    'hide_font'=> true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow'  => true,
                    'hide_line_height' => true,
                ),
                'wishlisticon' => array(
                    'css' => array(
                        'main'      => "%%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-wishlist-btn::before",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_wishlist',
                    'sub_toggle'  => 'icon',
                    'hide_font'=> true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow'  => true,
                    'hide_line_height' => true,
                ),
                'compareicon' => array(
                    'css' => array(
                        'main'      => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_compare, %%order_class%% .dnwoo_carousel_social_icon_wrap .icon_compare::before",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'dnwoo_woocarousel_compare',
                    'sub_toggle'  => 'icon',
                    'hide_font'=> true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow'  => true,
                    'hide_line_height' => true,
                ),
            ),
            'background'            => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css'   => array(
                    'main' => "%%order_class%% .dnwoo_woocarousel_container .swiper-slide",
                    'important' => true,
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnwoo_product_carousel_container',
                ),
                'important' => 'all',
            ),
            'borders' => array(
                'default' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_carousel_container',
							'border_styles' => '%%order_class%% .dnwoo_product_carousel_container',
                        ),
                    ),
                ),
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_imgwrap',
							'border_styles' => '%%order_class%% .dnwoo_product_imgwrap',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_image_settings',
                ),
                'text_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_title',
							'border_styles' => '%%order_class%% .dnwoo_product_title',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_text_settings',
                ),
                'desc_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_details p',
							'border_styles' => '%%order_class%% .dnwoo_product_details p',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Description', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_desc_settings',
                ),
                'addtocart'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_carousel_choose_variable_option',
							'border_styles' => '%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_carousel_choose_variable_option',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'button',
                ),
                'addtocarticon'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_cart,%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_menu.dnwoo_carousel_choose_variable_option_icon',
							'border_styles' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_cart,%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_menu.dnwoo_carousel_choose_variable_option_icon',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Add to Cart Icon', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'icon',
                ),
                'viewcart'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .added_to_cart',
							'border_styles' => '%%order_class%% .added_to_cart',
                        ),
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'button',
                ),
                'viewcarticon'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .woocommerce .dnwoo_carousel_social_icon_wrap li a.added_to_cart',
							'border_styles' => '%%order_class%% .woocommerce .dnwoo_carousel_social_icon_wrap li a.added_to_cart',
                        ),
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'icon',
                ),
                'wishlisticon'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-wishlist-btn',
							'border_styles' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-wishlist-btn',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Wishlist', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_wishlist',
                ),
                'compareicon'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-compare-btn',
							'border_styles' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-compare-btn',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Compare', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_compare',
                ),
                'quickviewicon'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-quickview',
							'border_styles' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-quickview',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Quick View', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_quickviewicon',
                ),
                'sale_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo-onsale',
							'border_styles' => '%%order_class%% .dnwoo-onsale',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_sale_badge',
                ),
                'outofstock_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo-stockout',
							'border_styles' => '%%order_class%% .dnwoo-stockout',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_outofstock_badge',
                ),
                'featured_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo-featured',
							'border_styles' => '%%order_class%% .dnwoo-featured',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Featured Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_featured_badge',
                ),
                'nav_arrow'   => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                            'border_styles' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Arrow', 'dnwooe' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
                ),
                'quickview_popup_arrow'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
							'border_styles' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
                        ),
                    ),
					'label_prefix' => esc_html__( '', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_quickbox_popup_box_arrow',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_carousel_container',
                        'important' => 'all'
                    ),
                ),
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_imgwrap',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_image_settings',
                ),
                'text_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_title',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_text_settings',
                ),
                'desc_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_details p',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Description', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_product_font',
                    'sub_toggle'  => 'dnwoo_woocarousel_desc_settings',
                ),
                'addtocart' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_carousel_choose_variable_option',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'button',
                ),
                'addtocarticon' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_cart,%%order_class%% .dnwoo_carousel_social_icon_wrap li a.icon_menu.dnwoo_carousel_choose_variable_option_icon',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_addtocardbtn',
                    'sub_toggle'  => 'icon',
                ),
                'viewcart' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .added_to_cart',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'button',
                ),
                'viewcarticon' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.added_to_cart',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_viewcartbtn',
                    'sub_toggle'  => 'icon',
                ),
                'wishlisticon' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-wishlist-btn',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Wishlist', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_wishlist',
                ),
                'compareicon' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-product-compare-btn',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Compare', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_compare',
                ),
                'quickviewicon' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_carousel_social_icon_wrap li a.dnwoo-quickview',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Quick View', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'dnwoo_woocarousel_quickviewicon',
                ),
                'sale_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo-onsale',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_sale_badge'
                ),
                'outofstock_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo-stockout',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_outofstock_badge'
                ),
                'featured_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo-featured',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Featured Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_woocarousel_featured_badge'
                ),
            ),
            'filters' => array(
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnwoo_woocarousel_image_settings',
                    'image_carousel' => array(
                        'css' => array(
                            'main' => '%%order_class%% .swiper-slide .img-fluid',
                            'hover' => '%%order_class%% .swiper-slide:hover .img-fluid',
                        ),
                    ),
                ),
            ),
            'max_width' => array(
				'css' => array(
					'main' => "%%order_class%%.dnwoo_carousel",
					'module_alignment' => '%%order_class%%.dnwoo_carousel.et_pb_module',
				),
			),
        );

        $this->custom_css_fields = array(
            'product_image'   => array(
                'label' => esc_html__('Product Image', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_image_container',
            ),
            'product_name'   => array(
                'label' => esc_html__('Product Name', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo_product_title',
            ),
            'product_desc'   => array(
                'label' => esc_html__('Product Description', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo_product_details p',
            ),
            'product_price'   => array(
                'label' => esc_html__('Product Price', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo_single_price',
            ),
            'product_rating'   => array(
                'label' => esc_html__('Product Rating', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo_product_ratting>.star-rating',
            ),
            'add_to_cart'   => array(
                'label' => esc_html__('Add To Cart', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .ajax_add_to_cart',
            ),
            'select_option_button'   => array(
                'label' => esc_html__('Select Variable Option Button', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo_carousel_choose_variable_option',
            ),
            'view_cart'   => array(
                'label' => esc_html__('View Cart', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .added_to_cart',
            ),
            'wishlist_icon'   => array(
                'label' => esc_html__('Wishlist Icon', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo-product-wishlist-btn',
            ),
            'compare_icon'   => array(
                'label' => esc_html__('Compare Icon', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo-product-compare-btn',
            ),
            'quickview_icon'   => array(
                'label' => esc_html__('Quick View Icon', 'dnwooe'),
                'selector' => '%%order_class%% .swiper-slide .dnwoo-quickview',
            ),
        );
	}

	public function get_fields() {

        $fields = array(
            'next_woo_carousel_layouts' => array(
				'label'            => esc_html__( 'Select Layout', 'dnwooe' ),
				'description'      => esc_html__( 'Choose your posts layout.', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'options'          => array(
					'one'           => esc_html__( 'Layout 1', 'dnwooe' ),
					'two'           => esc_html__( 'Layout 2', 'dnwooe' ),
					'three'         => esc_html__( 'Layout 3', 'dnwooe' ),
					'four'          => esc_html__( 'Layout 4', 'dnwooe' ),
					'five'          => esc_html__( 'Layout 5', 'dnwooe' ),
					'six'           => esc_html__( 'Layout 6', 'dnwooe' ),
				),
                'default'          => 'one',
				'default_on_front' => 'one',
				'computed_affects' => array( '__nextwooproductcarousel' ),
			),
            'type'                => array(
				'label'            => esc_html__( 'Product View Type', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'default'          => esc_html__( 'Default (Menu ordering + name)', 'dnwooe' ),
					'latest'           => esc_html__( 'Latest Products', 'dnwooe' ),
					'featured'         => esc_html__( 'Featured Products', 'dnwooe' ),
					'sale'             => esc_html__( 'Sale Products', 'dnwooe' ),
					'best_selling'     => esc_html__( 'Best Selling Products', 'dnwooe' ),
					'top_rated'        => esc_html__( 'Top Rated Products', 'dnwooe' ),
					'product_category' => esc_html__( 'Product Category', 'dnwooe' ),
				),
				'default_on_front' => 'default',
				'description'      => esc_html__( 'Choose which type of product view you would like to display.', 'dnwooe' ),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__nextwooproductcarousel',
				),
			),
            'hide_out_of_stock' => array(
                'label'            => esc_html__( 'Hide Out of Stock Products', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Hide out of stock products from the loop.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooproductcarousel',
                ),
            ),
            'dnwoo_badge_outofstock' => array(
                'label'           => esc_html__( 'Out of stock Product Text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Out of Stock',
                'option_category'  => 'configuration',
                'description'     => esc_html__( 'Define the Out of stock product text for your badge.', 'dnwooe' ),
                'toggle_slug'      => 'main_content',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'hide_out_of_stock' => 'off',
                ),
            ),
            'thumbnail_size' => array(
                'label'            => esc_html__( 'Thumbnail Size', 'dnwooe' ),
                'description'      => esc_html__( 'Here you can specify the size of category image.', 'dnwooe' ),
                'type'             => 'select',
                'options'          => array(
                    'full'	                => esc_html__( 'Full', 'dnwooe' ),
                    'woocommerce_thumbnail'	=> esc_html__( 'Woocommerce Thumbnail', 'dnwooe' ),
                    'woocommerce_single'	=> esc_html__( 'Woocommerce Single', 'dnwooe' ),
                ),
                'default'          => 'full',
                'default_on_front' => 'full',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
                'computed_affects' => array(
                    '__nextwooproductcarousel',
                ),
            ),
            'include_categories'    => array(
                'label'             => esc_html__( 'Include Categories', 'dnwooe' ),
                'type'              => 'categories',
                'renderer_options'  => array(
                    'use_terms'     => true,
                    'term_name'     => 'product_cat',
                    'field_name'    => 'et_pb_include_product_cat',
                ),
                'meta_categories'  => array(
                    'all'     => esc_html__('All Categories', 'dnwooe'),
                    'current' => esc_html__( 'Current Category', 'dnwooe' ),
                ),
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Select Categories. If no category is selected, products from all categories will be displayed.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooproductcarousel',
                ),
            ),
            'products_number'      => array(
                'label'            => esc_html__('Product Count', 'dnwooe'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__( 'Define the number of products that should be displayed per page.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooproductcarousel',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => 10,
            ),
            'order'                  => array(
				'label'            => esc_html__( 'Sorted By', 'dnwooe' ),
				'description'      => esc_html__( 'Choose how your posts should be sorted.', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'default'          => 'ASC',
				'options'          => array(
					'ASC'  => esc_html__( 'Ascending', 'dnwooe' ),
					'DESC' => esc_html__( 'Descending', 'dnwooe' ),
				),

				'default_on_front' => 'ASC',
				'computed_affects' => array( '__nextwooproductcarousel' ),
			),
            'orderby' => array(
                'label'             => esc_html__( 'Order by', 'dnwooe' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => array(
                    'date'     	    => esc_html__( 'Date', 'dnwooe' ),
                    'modified'	    => esc_html__( 'Modified Date', 'dnwooe' ),
                    'title'    	    => esc_html__( 'Title', 'dnwooe' ),
                    'name'     	    => esc_html__( 'Slug', 'dnwooe' ),
                    'ID'       	    => esc_html__( 'ID', 'dnwooe' ),
                    'rand'     	    => esc_html__( 'Random', 'dnwooe' ),
                    'none'     	    => esc_html__( 'None', 'dnwooe' ),
                ),
                'default'           => 'date',
                'show_if_not'       => array(
                    'type'          => array(
                        'latest',
                        'best_selling',
                        'top_rated',
                        'featured',
                        'product_category'
                    ),
                ),
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Here you can specify the order in which the products will be displayed.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooproductcarousel',
                ),
            ),
            'dnwoo_image_height'	=> array(
				'label'           	=> esc_html__( 'Image Height', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the height of the image within the woocarousel.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_woocarousel_image_settings',
                'allowed_units'   	=> array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '300px',
				'default_unit'    	=> 'px',
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 400,
				),
				'hover'             => 'tabs',
			),
            'quickviewpopupbox_arrow_color' => array(
                'label'             => esc_html__( 'Quick View Arrow Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom color for Quick View Arrow', 'dnwooe' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnwoo_woocarousel_quickbox_popup_box_arrow',
            ),
            'quickviewpopupbox_closebtn_color' => array(
                'label' => esc_html__('Quick View Arrow Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Quick View close button', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'quickview_popup_box_close_btn',
            ),
            '__nextwooproductcarousel'    => array(
                'type'                => 'computed',
                'computed_callback'   => array('DNWooCarousel', 'get_products'),
                'computed_depends_on' => array(
                    'next_woo_carousel_layouts',
                    'type',
                    'posts_number',
                    'products_number',
                    'order',
                    'include_categories',
                    'orderby',
                    'hide_out_of_stock',
                    'thumbnail_size',
                ),
            ),
        );

        $rating = array(
            'rating_alignment' => array(
				'label'           => esc_html__( 'Alignment', 'dnwooe' ),
				'description'     => esc_html__( 'Align to the left, right or center.', 'dnwooe' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnwoo_woocarousel_rating_settings',
                'default'         => 'left',
				'mobile_options'  => true,
				'responsive'	  => true,
                'show_if'     => array(
                    'show_rating' => 'on',
                )
			),
            'rating_active_color' => array(
                'label'             => esc_html__( 'Active Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom color for active rating star', 'dnwooe' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnwoo_woocarousel_rating_settings',
                'show_if'           => array(
                    'show_rating' => 'on',
                )
            ),
            'rating_inactive_color' => array(
                'label'             => esc_html__( 'Inactive Color', 'dnwooe' ),
                'description'       => esc_html__( 'Here you can define a custom color for nonactive rating star', 'dnwooe' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnwoo_woocarousel_rating_settings',
                'show_if'           => array(
                    'show_rating' => 'on',
                )
            ),
        );

        $background_opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $desc_opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );

        $sale_badge_bg       = DNWoo_Common::background_fields($this, "sale_badge_", "Background Color", "dnwoo_woocarousel_sale_badge", "advanced", $background_opt);
        $outofstock_badge_bg = DNWoo_Common::background_fields($this, "outofstock_badge_", "Background", "dnwoo_woocarousel_outofstock_badge", "advanced",$desc_opt);
        $featured_badge_bg   = DNWoo_Common::background_fields($this, "featured_badge_", "Background", "dnwoo_woocarousel_featured_badge", "advanced",$desc_opt);
        $addtocart_bg_color  = DNWoo_Common::background_fields($this, "addtocard_", "Background Color", "dnwoo_woocarousel_addtocardbtn", "advanced", array_merge( $desc_opt, array( 'sub_toggle' => 'button' ) ));
        $viewcart_bg_color   = DNWoo_Common::background_fields($this, "viewcart_", "Background Color", "dnwoo_woocarousel_viewcartbtn", "advanced",array_merge( $desc_opt, array( 'sub_toggle' => 'button' ) ));
        $content_bg_color    = DNWoo_Common::background_fields($this, "content_", "Background Color", "dnwoo_content_bg", "general", $desc_opt);

        $addtocarticon_bg  = DNWoo_Common::background_fields($this, "addtocarticon_", "Add to Cart Icon Background", "dnwoo_woocarousel_addtocardbtn", "advanced", array_merge($desc_opt, array( 'sub_toggle'  => 'icon')));
        $viewcarticon_bg  = DNWoo_Common::background_fields($this, "viewcarticon_", "View Cart Icon Background", "dnwoo_woocarousel_viewcartbtn", "advanced", array_merge($desc_opt, array( 'sub_toggle'  => 'icon')));
        $wishlisticon_bg   = DNWoo_Common::background_fields($this, "wishlisticon_", "Wish List Icon Background", "dnwoo_woocarousel_wishlist", "advanced", $desc_opt);
        $addcompareicon_bg = DNWoo_Common::background_fields($this, "addcompareicon_", "Add Comapare Background", "dnwoo_woocarousel_compare", "advanced", $desc_opt);
        $quickviewicon_bg  = DNWoo_Common::background_fields($this, "quickviewicon_", "Quick View Background", "dnwoo_woocarousel_quickviewicon", "advanced", array_merge( $desc_opt, array( 'sub_toggle' => 'icon' ) ));
        $quickviewpopupbtn_bg   = DNWoo_Common::background_fields($this, "quickviewbtn_", "Add to cart btn Background", "dnwoo_woocarousel_quickviewpopupbox", "advanced", array_merge( $desc_opt, array( 'sub_toggle' => 'quickviewpopupbox_btn' ) ));
        $quickviewpopup_viewcart_btn_bg   = DNWoo_Common::background_fields($this, "quickview_view_cart_btn_", "View Cart btn Background", "dnwoo_woocarousel_quickviewpopupbox", "advanced", array_merge( $desc_opt, array( 'sub_toggle' => 'quickviewpopupbox_btn' ) ));
        $quickviewpopup_bg      = DNWoo_Common::background_fields($this, "quickviewpopupbg_", "Quick View Pop up Box Background", "dnwoo_woocarousel_quickbox_popup_box_bg", "advanced", $desc_opt);
        $quickviewpopuparrow    = DNWoo_Common::background_fields($this, "quickviewpopuparrow_", "Quick View Pop up Box Arrow", "dnwoo_woocarousel_quickbox_popup_box_arrow", "advanced", $desc_opt);
        $quickviewpopup_close_btn    = DNWoo_Common::background_fields($this, "quickviewpopup_close_btn_", "Quick View Pop up Box close button", "quickview_popup_box_close_btn", "advanced", $desc_opt);

        $image_overlay_bg  = DNWoo_Common::background_fields($this, "image_overlay_", "Image Overlay Background", "dnwoo_woocarousel_image_settings", "advanced", array(
            'hover'           		=> false,
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        ));


		$woocarousel_settings =  array(
			'dnwoo_auto_height' => array(
                'label'           => esc_html__( 'Auto Height', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable this to automatically adjust the height of the images', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_speed'   => array(
                'label'           => esc_html__( 'Speed', 'dnwooe' ),
                'description'     => esc_html__( 'Adjust the speed of the carousel using the slider below (higher the value, the slider will go slowly and lower the value, the slider will go faster)', 'dnwooe' ),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'       => '400',
                'fixed_unit'    => '',
                'validate_unit' => false,
                'unitless'      => true,
                'toggle_slug'   => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_centered' => array(
                'label'       => esc_html__( 'Center slide', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable this to have the active image centered', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'     => 'off',
                'toggle_slug' => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_autoplay_show_hide' => array(
                'label'       => esc_html__( 'Autoplay', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to get the autoplay feature', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'affects'         => array(
                    'dnwoo_woocarousel_autoplay_delay',
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_autoplay_delay' => array(
                'label'           => esc_html__('Autoplay Delay', 'dnwooe'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Adjust the autoplay delay in milliseconds (ms)', 'dnwooe' ),
                'default'         => '5000',
                'depends_show_if' => 'on',
                'toggle_slug'     => 'dnwoo_woocarousel_settings',
                'show_if'         => array(
                    'dnwoo_woocarousel_autoplay_show_hide'  => 'on'
                )
            ),
			'dnwoo_woocarousel_breakpoint' => array(
                'label'            => esc_html__('Slides Per View', 'dnwooe'),
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'description'      => esc_html__( 'Place the number of slides you want to view', 'dnwooe' ),
                'default'          => '3',
                'default_on_front' => '3',
                'mobile_options'   => true,
                'responsive'       => true,
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_spacebetween'   => array(
                'label'           => esc_html__( 'Space Between', 'dnwooe' ),
                'type'            => 'range',
                'description'      => esc_html__( 'Adjust the space between the images', 'dnwooe' ),
                'option_category' => 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 0,
                    'max'  => 300,
                ),
                'default'        => '30',
                'fixed_unit'     => '',
                'validate_unit'  => false,
                'unitless'       => true,
                'mobile_options' => true,
                'responsive'     => true,
                'toggle_slug'    => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_grab' => array(
                'label'           => esc_html__( 'Use Grab Cursor', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control grab cursor', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
			'dnwoo_woocarousel_loop' => array(
                'label'       => esc_html__( 'Loop', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to have the slider slide continuously in a loop', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
            'dnwoo_woocarousel_pause_on_hover' => array(
                'label'       => esc_html__( 'Pause On Hover', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable this to have the slider pause when the cursor hovers on top', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'affects'         => array(
                    'dnwoo_woocarousel_autoplay_delay',
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_settings'
            ),
            'dnwoo_woocarousel_keyboard_enable' => array(
                'label'           => esc_html__( 'Keyboard Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control keyboard navigation.', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnwoo_woocarousel_navigation'
            ),
            'dnwoo_woocarousel_mousewheel_enable' => array(
                'label'           => esc_html__( 'Mousewheel Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control slide using mousewheel.', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnwoo_woocarousel_navigation'
            ),
		);

        $woocarousel_effect = array(
            'dnwoo_woocarousel_slide_shadows' => array(
                'label'           => esc_html__( 'Use Slide Shadows', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'When enabled, it adds a shadow to the back of the images in the slide', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_carousel',
            ),
            'dnwoo_woocarousel_slide_rotate'   => array(
                'label'           => esc_html__( 'Slide Rotate', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Use the slider to add a rotation effect', 'dnwooe' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnwoo_woocarousel_carousel'
            ),
            'dnwoo_woocarousel_slide_stretch'   => array(
                'label'           => esc_html__( 'Slide Stretch', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the slide stretch using the slider below', 'dnwooe' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnwoo_woocarousel_carousel'
            ),
            'dnwoo_woocarousel_slide_depth'   => array(
                'label'           => esc_html__( 'Slide Depth', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the distance of the images from the center to the surface to the bottom of the slider
                ', 'dnwooe' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnwoo_woocarousel_carousel'
            ),
        );

        $pagination = array(
            'dnwoo_woocarousel_pagination_type'    => array(
                'label'           => esc_html__('Pagination Type', 'dnwooe'),
                'type'            => 'select',
                'description'     => esc_html__( 'Select types for the slider like a bullet, fraction, or progress bar', 'dnwooe' ),
                'option_category' => 'basic_option',
                'options'         => array(
                    "none"        => esc_html__( 'None',  'dnwooe' ),
                    'bullets'     => esc_html__( 'Bullets',  'dnwooe' ),
                    'fraction'    => esc_html__( 'Fraction', 'dnwooe' ),
                    'progressbar' => esc_html__( 'Progress Bar', 'dnwooe' ),
                ),
                'default'     => 'bullets',
                'toggle_slug' => 'dnwoo_woocarousel_navigation'
            ),
            'dnwoo_woocarousel_pagination_bullets' => array(
                'label'       => esc_html__( 'Dynamic Bullets', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to highlight the bullet for the active image', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnwoo_woocarousel_navigation',
                'show_if'          => array(
                    'dnwoo_woocarousel_pagination_type' => 'bullets'
                ),
            ),
            'dnwoo_woocarousel_pagination_clickable' => array(
                'label'       => esc_html__( 'Pagination Clickable', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Make the pagination type clickable', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnwoo_woocarousel_navigation',
                'show_if'          => array(
                    'dnwoo_woocarousel_pagination_type' => 'bullets'
                ),
            ),
        );

        $navigation    = array (
            'dnwoo_woocarousel_arrow_navigation' => array(
                'label'           => esc_html__( 'Use Arrow Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control the slide using arrows', 'dnwooe' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnwoo_woocarousel_navigation',
            ),
            'dnwoo_woocarousel_arrow_size'   => array(
                'label'           => esc_html__( 'Font Size', 'dnwooe' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '30',
                'fixed_unit'      => '',
                'mobile_options'  => true,
                'validate_unit'   => false,
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnwoo_woocarousel_arrow_settings',
                'show_if'          => array(
                    'dnwoo_woocarousel_arrow_navigation' => 'on',
				),
            ),
            'dnwoo_woocarousel_arrow_position'   => array(
				'label'           => esc_html__( 'Arrow Position', 'dnwooe'),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of arrow position', 'dnwooe'),
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnwoo_woocarousel_arrow_settings',
				'options'       	            => array(
                    'default'                   => esc_html__(	'Default', 'dnwooe' ),
					'inner'                     => esc_html__(	'Inner', 'dnwooe' ),
					'outer'                     => esc_html__(	'Outer', 'dnwooe' ),
					'top-left'                  => esc_html__(	'Top Left', 'dnwooe' ),
					'top-center'                => esc_html__(	'Top Center', 'dnwooe' ),
					'top-right'                 => esc_html__(	'Top Right', 'dnwooe' ),
					'bottom-left'               => esc_html__(	'Bottom Left', 'dnwooe' ),
					'bottom-center'             => esc_html__(	'Bottom Center', 'dnwooe' ),
					'bottom-right'              => esc_html__(	'Bottom Right', 'dnwooe' )

				),
				'default' => 'default',
                'show_if'          => array(
                    'dnwoo_woocarousel_arrow_navigation' => 'on',
				),
            ),
            'dnwoo_woocarousel_arrow_color' => array(
                'label'        => esc_html__( 'Arrow Color', 'dnwooe' ),
                'description'  => esc_html__( 'Choose a color for the Arrows', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#fff',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
            ),
            'dnwoo_woocarousel_arrow_background_color' => array(
                'label'        => esc_html__( 'Arrow Background Color', 'dnwooe' ),
                'description'  => esc_html__( 'Choose a background color for the Arrows', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
            ),
            'dnwoo_woocarousel_dots_color' => array(
                'label'        => esc_html__( 'Dots Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Dots', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#000',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
                'show_if'      => array(
                    'dnwoo_woocarousel_pagination_type' => 'bullets'
                )
            ),
            'dnwoo_woocarousel_dots_active_color' => array(
                'label'        => esc_html__( 'Dots Active Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Active Dot', 'dnwooe' ),
                'type'         => 'color-alpha',
                'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
                'show_if'      => array(
                    'dnwoo_woocarousel_pagination_type' => 'bullets'
                    )
            ),
            'dnwoo_woocarousel_progressbar_fill_color' => array(
                'label'        => esc_html__( 'Progressbar Fill Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Progressbar fill color', 'dnwooe' ),
                'type'         => 'color-alpha',
                'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnwoo_woocarousel_arrow_settings',
                'show_if'      => array(
                    'dnwoo_woocarousel_pagination_type' => 'progressbar'
                )
            ),
            'dnwoo_woocarousel_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_name_margin'	=> array(
				'label'           		=> esc_html__('Product Name Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_name_padding'	=> array(
				'label'           		=> esc_html__('Product Name Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_desc_margin'	=> array(
				'label'           		=> esc_html__('Product Description Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_desc_padding'	=> array(
				'label'           		=> esc_html__('Product Description Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_cate_margin' => array(
                'label' => esc_html__('Product Category Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_woocarousel_cate_padding' => array(
                'label' => esc_html__('Product Category Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_woocarousel_product_rating_margin'	=> array(
				'label'           		=> esc_html__('Product Rating Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_price_margin'	=> array(
				'label'           		=> esc_html__('Product Price Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_product_price_padding'	=> array(
				'label'           		=> esc_html__('Product Price Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_addtocart_margin'	=> array(
				'label'           		=> esc_html__('Add To Cart Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_addtocart_padding'	=> array(
				'label'           		=> esc_html__('Add To Cart Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_viewcart_margin'	=> array(
				'label'           		=> esc_html__('View Cart Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_viewcart_padding'	=> array(
				'label'           		=> esc_html__('View Cart Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_arrow_margin'	=> array(
				'label'           		=> esc_html__('Arrow Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_arrow_padding'	=> array(
				'label'           		=> esc_html__('Arrow Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_sale_margin'	=> array(
				'label'           		=> esc_html__('Sale Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_woocarousel_sale_padding'	=> array(
				'label'           		=> esc_html__('Sale Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            )
        );

        $show_hide = array(
            'show_add_to_cart_icon' => array(
				'label'           => esc_html__( 'Add to cart Icon', 'dnwooe' ),
				'description'     => esc_html__( 'Choose whether or not the add to cart Icon should be visible.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
			),
			'show_wish_list_icon' => array(
				'label'           => esc_html__( 'Wish List Icon', 'dnwooe' ),
				'description'     => esc_html__( 'Choose whether or not the wish list Icon should be visible.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
			),
			'show_add_compare_icon' => array(
				'label'           => esc_html__( 'Add Compare Icon', 'dnwooe' ),
				'description'     => esc_html__( 'Choose whether or not the add compare should be visible.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
			),
			'show_quickview_icon' => array(
				'label'           => esc_html__( 'Quick View Icon', 'dnwooe' ),
				'description'     => esc_html__( 'Choose whether or not the quick view should be visible.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
			),
            'show_add_to_cart_btn' => array(
				'label'           => esc_html__( 'Add to cart Button', 'dnwooe' ),
				'description'     => esc_html__( 'Choose whether or not the add to cart button should be visible.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
                'show_if'          => array(
					'next_woo_carousel_layouts' => array( 'five', 'six' ),
				),
			),
            'dnwoo_show_add_to_cart_text' => array(
                'label'           => esc_html__( 'Add to cart text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Add To Cart',
                'option_category' => 'configuration',
                'description'     => esc_html__( 'Define the Badge type text for your product badge.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_add_to_cart_btn' => 'on',
                    'next_woo_carousel_layouts' => array( 'five', 'six' ),
                ),
            ),
            'dnwoo_select_option_text' => array(
                'label'           => esc_html__( 'Select Option Button Text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Select Option',
                'option_category' => 'configuration',
                'description'     => esc_html__( 'Define the Badge type text for your product badge.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_add_to_cart_btn' => 'on',
                    'next_woo_carousel_layouts' => array( 'five', 'six' ),
                ),
            ),
            'show_price_text' => array(
                'label'           => esc_html__( 'Show Price', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'on',
				'option_category'  => 'configuration',
                'toggle_slug'     => 'display_setting',
                'description'     => esc_html__( 'Choose whether or not the add to cart button should be visible.', 'dnwooe' ),
            ),
            'show_rating'       => array(
				'label'            => esc_html__( 'Show Star Rating', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default' => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Here you can choose whether the star rating should be added.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
			),
            'show_desc'       => array(
				'label'            => esc_html__( 'Show Description', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Here you can choose whether the description should be added.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
			),
            'show_category'       => array(
				'label'            => esc_html__( 'Show Category', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
                'default' => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Here you can choose whether the categories should be added.', 'dnwooe' ),
			),
            'show_featured_product'=> array(
                'label'            => esc_html__( 'Featured Product Badge', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => et_builder_i18n( 'On' ),
                    'off' => et_builder_i18n( 'Off' ),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'display_setting',
                'description'      => esc_html__( 'Here you can show your featured product badge', 'dnwooe' ),
            ),
            'dnwoo_badge_featured' => array(
                'label'           => esc_html__( 'Featured Product Text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Hot',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the featured product text for your badge featured.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_featured_product' => 'on',
                ),
            ),
            'show_badge'     => array(
                'label'           => esc_html__( 'Sale Badge Type', 'dnwooe' ),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'none'       => esc_html__( 'None', 'dnwooe' ),
                    'sale'       => esc_html__( 'Sale', 'dnwooe' ),
                    'percentage' => esc_html__( 'Percentage', 'dnwooe' ),
                ),
                'default'        => 'sale',
                'description'    => esc_html__( 'Turn badge on and off.', 'dnwooe' ),
                'toggle_slug'    => 'display_setting',
                'mobile_options' => true,
                'hover'          => 'tabs',
            ),
            'dnwoo_badge_sale' => array(
                'label'           => esc_html__( 'Sale Badge type text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Sale',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the Badge type text for your product badge sale.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_badge' => 'sale',
                ),
            ),
            'dnwoo_badge_percentage' => array(
                'label'           => esc_html__( 'Percentage Badge type text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'off',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the Badge type text for your product badge percentage.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_badge' => 'percentage',
                ),
            ),
        );

		return array_merge(
            $fields,
            $rating,
            $sale_badge_bg,
            $outofstock_badge_bg,
            $featured_badge_bg,
            $addtocart_bg_color,
            $viewcart_bg_color,
            $content_bg_color,
            $addtocarticon_bg,
            $viewcarticon_bg,
            $wishlisticon_bg,
            $addcompareicon_bg,
            $quickviewicon_bg,
            $image_overlay_bg,
            $woocarousel_settings,
            $woocarousel_effect,
            $navigation,
            $pagination,
            $show_hide,
            $quickviewpopupbtn_bg,
            $quickviewpopup_viewcart_btn_bg,
            $quickviewpopup_bg,
            $quickviewpopuparrow,
            $quickviewpopup_close_btn
        );
	}

    public static function get_products() {
        return '';
    }
    public function callingScriptAndStyles() {
        wp_enqueue_style('dnwoo_product_carousel');
        wp_enqueue_style('dnwoo_quickview_modal');
        wp_enqueue_script('dnwoo-product-carousel');
        wp_script_is( 'dnext_isotope', 'enqueued' ) ? wp_enqueue_script( 'dnext_isotope' ) : wp_enqueue_script( 'dnwoo_swiper_frontend' );
        wp_script_is( 'magnific-popup', 'enqueued' ) ? wp_enqueue_script( 'magnific-popup' ) : wp_enqueue_script( 'dnwoo-magnific-popup');
		wp_style_is( 'dnext_swiper-min', 'enqueued' ) ? wp_enqueue_style( 'dnext_swiper-min') : wp_enqueue_style( 'dnwoo_swiper-min' );
        wp_enqueue_style('dnwoo_magnific-popup');
    }

	public function render( $attrs, $content, $render_slug ) {
        
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}
        
        $this->callingScriptAndStyles();
        $order_class                            = self::get_module_order_class($render_slug);

        $multi_view								= et_pb_multi_view_options($this);
        $layout            			            = $this->props['next_woo_carousel_layouts'];
        $products_number            			= $this->props['products_number'];
        $order            			            = $this->props['order'];
        $orderby            			        = $this->props['orderby'];
        $type            			            = $this->props['type'];
        $product_tag_arr = is_product_tag() ? array( get_queried_object()->slug ) : array();

        $search = isset( $_GET['s'] ) && !empty( wp_verify_nonce( sanitize_text_field($_GET['s']), 'dnwoo_carousel' )  ) ? wp_verify_nonce( sanitize_text_field($_GET['s']), 'dnwoo_carousel' )  : '';
        
        $include_categories            			= $this->props['include_categories'];
        $dnwoo_image_height            			= $this->props['dnwoo_image_height'];
        $hide_out_of_stock            			= $this->props['hide_out_of_stock'];
        $thumbnail_size            			    = $this->props['thumbnail_size'];

        $show_rating            				= $this->props['show_rating'];
        $show_price_text            			= $this->props['show_price_text'];
        $show_add_to_cart_icon					= $this->props['show_add_to_cart_icon'];
        $show_wish_list_icon					= $this->props['show_wish_list_icon'];
        $show_add_compare_icon					= $this->props['show_add_compare_icon'];
        $show_quickview_icon					= $this->props['show_quickview_icon'];
        $show_add_to_cart_btn					= $this->props['show_add_to_cart_btn'];
        $dnwoo_show_add_to_cart_text			= $this->props['dnwoo_show_add_to_cart_text'];
        $select_option_text						= $this->props['dnwoo_select_option_text'];   
        $show_desc						        = $this->props['show_desc'];
        $show_category						    = $this->props['show_category'];
        $header_level						    = $this->props['header_level'];

        $auto_height							= $this->props['dnwoo_auto_height'];
        $dnwoo_woocarousel_speed				= $this->props['dnwoo_woocarousel_speed'];
        $dnwoo_woocarousel_centered				= $this->props['dnwoo_woocarousel_centered'];
        $autoplay_show_hide                 	= $this->props['dnwoo_woocarousel_autoplay_show_hide'];
        $dnwoo_woocarousel_autoplay_delay		= $this->props['dnwoo_woocarousel_autoplay_delay'];
        $dnwoo_woocarousel_grab					= $this->props['dnwoo_woocarousel_grab'];
        $dnwoo_woocarousel_loop					= $this->props['dnwoo_woocarousel_loop'];
        $dnwoo_woocarousel_keyboard_enable		= $this->props['dnwoo_woocarousel_keyboard_enable'];
        $pause_on_hover                         = $this->props['dnwoo_woocarousel_pause_on_hover'];

        $slide_shadow = $this->props['dnwoo_woocarousel_slide_shadows'];
        $slide_rotate = $this->props['dnwoo_woocarousel_slide_rotate'];
        $slide_stretch = $this->props['dnwoo_woocarousel_slide_stretch'];
        $slide_depth = $this->props['dnwoo_woocarousel_slide_depth'];

        $dnwoo_woocarousel_breakpoint				= $this->props['dnwoo_woocarousel_breakpoint'];
        $dnwoo_woocarousel_breakpoint_tablet      	= $this->props['dnwoo_woocarousel_breakpoint_tablet'];
        $dnwoo_woocarousel_breakpoint_phone       	= $this->props['dnwoo_woocarousel_breakpoint_phone'];
        $dnwoo_woocarousel_breakpoint_last_edited 	= $this->props['dnwoo_woocarousel_breakpoint_last_edited'];

		if ( '' !== $dnwoo_woocarousel_breakpoint_tablet || '' !== $dnwoo_woocarousel_breakpoint_phone || '' !== $dnwoo_woocarousel_breakpoint ) {
			$is_responsive = et_pb_get_responsive_status( $dnwoo_woocarousel_breakpoint_last_edited );

			$carousel_breakpoint_show_values = array(
				'desktop' => $dnwoo_woocarousel_breakpoint,
				'tablet'  => $is_responsive ? $dnwoo_woocarousel_breakpoint_tablet : '',
				'phone'   => $is_responsive ? $dnwoo_woocarousel_breakpoint_phone : '',
			);
        }


		$dnwoo_woocarousel_spacebetween              = $this->props['dnwoo_woocarousel_spacebetween'];
        $dnwoo_woocarousel_spacebetween_tablet       = $this->props['dnwoo_woocarousel_spacebetween_tablet'];
        $dnwoo_woocarousel_spacebetween_phone        = $this->props['dnwoo_woocarousel_spacebetween_phone'];
        $dnwoo_woocarousel_spacebetween_last_edited  = $this->props['dnwoo_woocarousel_spacebetween_last_edited'];

		if ( '' !== $dnwoo_woocarousel_spacebetween_tablet || '' !== $dnwoo_woocarousel_spacebetween_phone || '' !== $dnwoo_woocarousel_spacebetween ) {
			$is_responsive = et_pb_get_responsive_status( $dnwoo_woocarousel_spacebetween_last_edited );

			$carousel_spacebetween_values = array(
				'desktop' => $dnwoo_woocarousel_spacebetween,
				'tablet'  => $is_responsive ? $dnwoo_woocarousel_spacebetween_tablet : '',
				'phone'   => $is_responsive ? $dnwoo_woocarousel_spacebetween_phone : '',
			);
        }

        $dnwoo_woocarousel_pagination_type         = $this->props['dnwoo_woocarousel_pagination_type'];
        $dnwoo_woocarousel_pagination_bullets      = $dnwoo_woocarousel_pagination_type === 'bullets' ? $this->props['dnwoo_woocarousel_pagination_bullets'] : "off";
        $dnwoo_woocarousel_pagination_clickable    = $dnwoo_woocarousel_pagination_type === 'bullets' ? $this->props['dnwoo_woocarousel_pagination_clickable'] : "false";

        // PAGINATION CLASSES
        $progress_bar_margin_bottom = $dnwoo_woocarousel_pagination_type === "progressbar" ? 'mt-10' : '';
        $pagination_class = "swiper-pagination ";
        if( $dnwoo_woocarousel_pagination_type === "bullets" && $dnwoo_woocarousel_pagination_bullets === "on"){
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-bullets-dynamic mt-10";
        }else if($dnwoo_woocarousel_pagination_type === "bullets") {
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets mt-10";
        }else if($dnwoo_woocarousel_pagination_type === "fraction") {
            $pagination_class .= "swiper-pagination-fraction mt-10";
        }else if($dnwoo_woocarousel_pagination_type === "progressbar") {
            $pagination_class .= "swiper-pagination-progressbar";
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        $position_container  = "";
        $arrow_position_string = $this->props['dnwoo_woocarousel_arrow_position'];
        $arrow_position = array(
            'top-left',
            'top-center',
            'top-right',
            'bottom-left',
            'bottom-center',
            'bottom-right'
        );

        if(in_array($arrow_position_string, $arrow_position)) {
            $position_container = "multi-position-container";
        }

        $arrow_top_bottom = substr($arrow_position_string, 0, 3) === "top" ? "arrow-position-top" : "arrow-position-bottom";

        if(substr($arrow_position_string, -strlen("left")) === "left") {
            $arrow_left_right_center = "multi-position-button-left";
        }elseif(substr($arrow_position_string, -strlen("center")) === "center") {
            $arrow_left_right_center = "multi-position-button-center";
        }elseif(substr($arrow_position_string, -strlen("right")) === "right") {
            $arrow_left_right_center = "multi-position-button-right";
        }

        if("off" !== $this->props['dnwoo_woocarousel_arrow_navigation']) {
            if($arrow_position_string === 'inner'){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_woocarousel_arrows_inner_left" data-icon="4"></div>
                    <div class="swiper-button-next dnwoo_woocarousel_arrows_inner_right" data-icon="5"></div>'
                );
            }else if($arrow_position_string === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_woocarousel_arrows_outer_left" data-icon="4"></div>
                    <div class="swiper-button-next dnwoo_woocarousel_arrows_outer_right" data-icon="5"></div>'
                );
            }elseif($arrow_position_string === "default"){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_woocarousel_arrows_default_left" data-icon="4"></div>
                    <div class="swiper-button-next dnwoo_woocarousel_arrows_default_right" data-icon="5"></div>'
                );
            }elseif(in_array($arrow_position_string, $arrow_position)) {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-container multi-position-button-container %1$s">
                        <div class="swiper-button-prev multi-position-button" data-icon="4"></div>
                        <div class="swiper-button-next multi-position-button" data-icon="5"></div>
                    </div>',
                    $arrow_left_right_center
                );
            }
        }

        // wooCarousel ARROW COLOR
        // Arrow Color
        $arrow_color_order_class = '%%order_class%% .swiper-button-prev:after,%%order_class%% .swiper-button-next:after';
		$dnwoo_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_woocarousel_arrow_color');
		et_pb_responsive_options()->generate_responsive_css($dnwoo_arrow_color_values, $arrow_color_order_class, 'color', $render_slug, '', 'color');
        
        // Quick View Arrow Color
        $quick_view_arrow_color_order_class = '%%order_class%% .product-images .swiper-button-next:after, %%order_class%% .product-images .swiper-button-prev:after';
		$quick_view_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'quickviewpopupbox_arrow_color');
		et_pb_responsive_options()->generate_responsive_css($quick_view_arrow_color_values, $quick_view_arrow_color_order_class, 'color', $render_slug, '', 'color');
        
        // Quick View Pop up Close Button
        $this->generate_styles(
            array(
                'base_attr_name' => 'quickviewpopupbox_closebtn_color',
                'selector' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%% .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close',
                'hover_selector' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover',
                'css_property' => 'color',
                'render_slug' => $render_slug,
                'important' => true,
                'type' => 'color',
            )
        );
        // Arrow BG Color
        $arrow_bg_order_class = '%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next';
		$dnwoo_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_woocarousel_arrow_background_color');
		et_pb_responsive_options()->generate_responsive_css($dnwoo_arrow_color_values, $arrow_bg_order_class, 'background-color', $render_slug, '', 'background-color');

        // wooCarousel ARROW COLOR END

        // wooCarousel ARROW SIZE START
        $dnwoo_woocarousel_arrow_size = (int) $this->props['dnwoo_woocarousel_arrow_size'];
        $arrow_width = $dnwoo_woocarousel_arrow_size+10;
        //$dnwoo_woocarousel_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnwoo_woocarousel_arrow_size));

        $dnwoo_woocarousel_arrow_size_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_woocarousel_arrow_size');
        $dnwoo_woocarousel_arrow_size_tablet = isset($dnwoo_woocarousel_arrow_size_values['tablet']) ? $dnwoo_woocarousel_arrow_size_values['tablet'] : $dnwoo_woocarousel_arrow_size;
        $dnwoo_woocarousel_arrow_size_phone  = isset($dnwoo_woocarousel_arrow_size_values['phone']) ? $dnwoo_woocarousel_arrow_size_values['phone'] : $dnwoo_woocarousel_arrow_size_tablet;

        $dnwoo_woocarousel_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => sprintf('font-size: %1$spx', $dnwoo_woocarousel_arrow_size),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => sprintf('font-size: %1$spx', $dnwoo_woocarousel_arrow_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => sprintf('font-size: %1$spx', $dnwoo_woocarousel_arrow_size_phone),
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnwoo_woocarousel_arrow_background_width_height,
        ) );
        // wooCarousel ARROW SIZE END

        // DOTS COLOR START
        $dnwoo_woocarousel_dots_color        = $this->props['dnwoo_woocarousel_dots_color'];
        $dnwoo_woocarousel_dots_active_color = $this->props['dnwoo_woocarousel_dots_active_color'];

        $dnwoo_woocarousel_dots_color        = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_woocarousel_dots_color));
        $dnwoo_woocarousel_dots_active_color = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_woocarousel_dots_active_color));


        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
        'declaration' => $dnwoo_woocarousel_dots_color,
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
        'declaration' => $dnwoo_woocarousel_dots_active_color,
        ) );

        // PROGRESSBAR FILL COLOR START
        $dnwoo_woocarousel_progressbar_color = $this->props['dnwoo_woocarousel_progressbar_fill_color'];
        $dnwoo_woocarousel_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_woocarousel_progressbar_color));
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnwoo_woocarousel_progressbar_color_style,
        ) );

        // Progressbar fill color end

        // item image width start
        $image_hieght_css_property = 'height: %1$s !important;';
        $image_hieght_css_selector = array(
            'desktop' => "%%order_class%% .dnwoo_product_imgwrap img",
            'hover' => "%%order_class%% .dnwoo_product_imgwrap img:hover",
        );
        DNWoo_Common::set_css("dnwoo_image_height", $image_hieght_css_property, $image_hieght_css_selector, $render_slug, $this);

        // star-rating alignment 
        $rating_css_property = 'justify-content: %1$s !important;';
        $rating_css_selector = array(
            'desktop' => "%%order_class%% .dnwoo_product_ratting",
        );
        DNWoo_Common::set_css("rating_alignment", $rating_css_property, $rating_css_selector, $render_slug, $this);
        
        
        
        // star-rating inactive color 
        $rating_inactive_color_css_property = 'color: %1$s !important;';
        $rating_inactive_color_css_selector = array(
            'desktop' => "%%order_class%% .woocommerce .dnwoo_product_carousel .dnwoo_product_ratting .star-rating:before,%%order_class%% .woocommerce .dnwoo_product_carousel .dnwoo_product_ratting .star-rating:before",
        );
        DNWoo_Common::set_css("rating_inactive_color", $rating_inactive_color_css_property, $rating_inactive_color_css_selector, $render_slug, $this);

         // star-rating active color 
        $rating_active_color_css_property = 'color: %1$s !important;';
        $rating_active_color_css_selector = array(
            'desktop' => "%%order_class%% .woocommerce .dnwoo_product_carousel .dnwoo_product_ratting span:before,%%order_class%% .woocommerce .dnwoo_product_carousel .dnwoo_product_ratting span:before",
        );
        DNWoo_Common::set_css("rating_active_color", $rating_active_color_css_property, $rating_active_color_css_selector, $render_slug, $this);
        
        // item image width end
        // Image filter css
        DNWoo_Common::set_image_filter('image_carousel', $this, $render_slug);

        

        $settings = array(
            'products_number'    => $products_number,
            'product_tag'        => $product_tag_arr,
            'order'              => $order,
            'orderby'            => $orderby,
            'type'               => $type,
            'current_categories' => (is_product_category() && 'current' === $include_categories) ? (string) get_queried_object_id() : '',
            'include_categories' => $include_categories,
            'hide_out_of_stock'  => $hide_out_of_stock,
            'thumbnail_size'     => $thumbnail_size,
            'request_from'       => 'frontend',
            'search'             => $search
        );

		$products            = dnwoo_query_products($settings);

        $single_products = '';
        if ( $products->have_posts() ) {
			$counter = 1;
			$single_products = sprintf('<div class="swiper-wrapper %1$s">', $progress_bar_margin_bottom);
			while ( $products->have_posts() ) {
                $products->the_post();
                $product_id   = get_the_ID();
                $product      = wc_get_product( $product_id );
                $thumbnail    = get_the_post_thumbnail_url( $product_id, $thumbnail_size);
                $permalink    = get_permalink( $product_id );
                $product_type = esc_attr( $product->get_type() );
                $demo_image = "data:image/png;base64,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";
                $dataIcon  = 'data-icon=""';
                $chooseSelectOptionIcon= 'data-icon="a"';

                $product_rating = wc_get_rating_html($product->get_average_rating(), $product->get_rating_count());

                $add_to_cart_icon = $this->_add_to_cart_icon($product_id, $product_type, $permalink, $dataIcon, $chooseSelectOptionIcon);


                $product_variant = $add_to_cart_btn = $this->_add_to_cart($product_id, $product_type, $permalink,$show_add_to_cart_btn, $dnwoo_show_add_to_cart_text, $select_option_text, $chooseSelectOptionIcon, $dataIcon);


				$single_products .= '<div class="swiper-slide"><div class="woocommerce">';
                
				if ( file_exists( get_stylesheet_directory() . '/NextWooCarousel/layouts/layout-'.$layout.'.php' ) ) {
					include get_stylesheet_directory() . '/NextWooCarousel/layouts/layout- '.$layout.'.php';
				} elseif ( file_exists( plugin_dir_path( __FILE__ ) . 'layouts/layout-'.$layout.'.php' ) ) {
					include ( plugin_dir_path( __FILE__ ) . 'layouts/layout-'.$layout.'.php' );
				}
				$single_products .= 	'</div></div> <!-- swiper-slide dnwoo_product_carousel -->';
				
                $counter++;
			}
            $single_products .= '</div>';
			wp_reset_postdata();

		}
        
        $this->apply_css($render_slug);
        $this->apply_background_css( $render_slug );

		$slide_option = sprintf(
			'data-autoheight="%1$s"
			data-speed="%2$s"
			data-center="%3$s"
			data-autoplay="%4$s"
			data-delay="%5$s"
			data-breakpoints="%6$s|%7$s|%8$s"
			data-spacebetween="%9$s|%10$s|%11$s"
			data-grab-cursor="%12$s"
			data-loop="%13$s"
			data-keyboardenable="%14$s",
            data-pagination-type="%15$s"
            data-pagination-bullets="%16$s"
            data-clickable="%17$s"
            data-pauseonhover="%18$s"
            data-shadow="%19$s"
            data-rotate="%20$s"
            data-stretch="%21$s"
            data-depth="%22$s"
            ',
			esc_attr( $auto_height ),
			esc_attr( $dnwoo_woocarousel_speed ),
			esc_attr( $dnwoo_woocarousel_centered ),
			esc_attr( $autoplay_show_hide ),
			esc_attr( $dnwoo_woocarousel_autoplay_delay ), // #5
			esc_attr( $dnwoo_woocarousel_breakpoint ),
			'' !== $carousel_breakpoint_show_values['tablet'] ? esc_attr( $carousel_breakpoint_show_values['tablet'] ) : 1,
			'' !== $carousel_breakpoint_show_values['phone'] ? esc_attr( $carousel_breakpoint_show_values['phone'] ) : 1,
			esc_attr( $dnwoo_woocarousel_spacebetween ),
            '' !== $carousel_spacebetween_values['tablet'] ? esc_attr( $carousel_spacebetween_values['tablet'] ) : 1,
            '' !== $carousel_spacebetween_values['phone'] ? esc_attr( $carousel_spacebetween_values['phone'] ) : 1,
			esc_attr( $dnwoo_woocarousel_grab ),// #12
			esc_attr( $dnwoo_woocarousel_loop ),
			esc_attr( $dnwoo_woocarousel_keyboard_enable ),
            esc_attr( $dnwoo_woocarousel_pagination_type ),
            esc_attr( $dnwoo_woocarousel_pagination_bullets ),
            esc_attr( $dnwoo_woocarousel_pagination_clickable ),
            esc_attr( $pause_on_hover ),
            esc_attr( $slide_shadow ),
            esc_attr( $slide_rotate ),
            esc_attr( $slide_stretch ),
            esc_attr( $slide_depth )
		);
		
        $output = sprintf(
			'<div class="dnwoo_woocarousel_container %5$s %6$s">
				<div class="swiper-container dnwoo_product_carousel_frontend dnwoo_product_carousel_active mb-30" %3$s>
					%1$s
                    <div class="%4$s"></div>
				</div>
                %2$s
			</div>',
			$single_products,
			$arrowsClass,
			$slide_option,
            $pagination_class,
            $position_container, // 5
            $arrow_top_bottom
		);
		
        return $output;
	}

    public function apply_css($render_slug) {

        /**
         * Custom Padding Margin Output
         *
        */
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_woocarousel_content_wrapper' => array(
                'selector'  => '%%order_class%% .swiper-slide .dnwoo_product_details_wrap, %%order_class%% .swiper-slide .dnwoo_product_content',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_woocarousel_product_name' => array(
                'selector'  => '%%order_class%% .swiper-slide .dnwoo_product_title',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_product_desc' => array(
                'selector'  => '%%order_class%% .swiper-slide .dnwoo_product_details p',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_cate' => array(
                'selector'  => '%%order_class%% .dnwoo_product_carousel_categories, %%order_class%% .dnwoo_product_categories ul',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_product_rating' => array(
                'selector'  => '%%order_class%% .swiper-slide .dnwoo_product_ratting>.star-rating',
                'type'      => 'margin'
            ),
            'dnwoo_woocarousel_product_price' => array(
                'selector'  => '%%order_class%% .swiper-slide .dnwoo_product_price .dnwoo_single_price',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_addtocart' => array(
                'selector'  => '%%order_class%% .swiper-slide .add_to_cart_button',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_viewcart' => array(
                'selector'  => '%%order_class%% .swiper-slide .added_to_cart',
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_arrow' => array(
                'selector'  => "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev",
                'type'      => array('margin','padding')
            ),
            'dnwoo_woocarousel_sale' => array(
                'selector'  => "%%order_class%% .dnwoo_product_carousel .dnwoo-onsale",
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
            'sale_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo-onsale",
                "hover"   => "%%order_class%% .dnwoo-onsale:hover",
            ),
            'outofstock_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo-stockout",
                "hover"   => "%%order_class%% .dnwoo-stockout:hover",
            ),
            'featured_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo-featured",
                "hover"   => "%%order_class%% .dnwoo-featured:hover",
            ),
            'addtocard_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_carousel_choose_variable_option",
                "hover"   => "%%order_class%% .dnwoo_product_addtocart:hover,%%order_class%% .dnwoo_carousel_choose_variable_option:hover",
            ),
            'viewcart_' => array(
                "desktop" => "%%order_class%% .added_to_cart",
                "hover"   => "%%order_class%% .added_to_cart:hover",
            ),
            'content_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_details_container, %%order_class%% .dnwoo_product_overlay_content, %%order_class%% .dnwoo_product_content, %%order_class%% .dnwoo_product_categories",
                "hover"   => "%%order_class%% .dnwoo_product_details_container:hover, %%order_class%% .dnwoo_product_overlay_content:hover, %%order_class%% .dnwoo_product_content:hover, %%order_class%% .dnwoo_product_categories:hover",
            ),
            'addtocarticon_' => array(
                "desktop" => "%%order_class%% .icon_cart,%%order_class%% .dnwoo_carousel_choose_variable_option_icon.icon_menu",
                "hover"   => "%%order_class%% .icon_cart:hover,%%order_class%% .dnwoo_carousel_choose_variable_option_icon.icon_menu:hover, %%order_class%% .dnwoo_carousel_social_icon_wrap a.added_to_cart:hover",
            ),
            'viewcarticon_'  => array(
				"desktop" => "%%order_class%% .dnwoo_carousel_social_icon_wrap .added_to_cart",
				"hover"   => "%%order_class%% .dnwoo_carousel_social_icon_wrap .added_to_cart:hover",
			),
            'wishlisticon_'  => array(
				"desktop" => "%%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-action-btn",
				"hover"   => "%%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-wishlist-btn:hover, %%order_class%% .dnwoo_carousel_social_icon_wrap .dnwoo-product-action-btn:hover",
			),
            'addcompareicon_'  => array(
				"desktop" => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_compare",
				"hover"   => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_compare:hover",
			),
            'quickviewicon_'  => array(
				"desktop" => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_quickview",
				"hover"   => "%%order_class%% .dnwoo_carousel_social_icon_wrap .icon_quickview:hover",
			),
            'image_overlay_'  => array(
				"desktop" => "%%order_class%% .dnwoo_product_imgwrap .dnwoo_product_image_container::before",
			),
            'quickviewbtn_'  => array(
				"desktop" => "%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button",
				"hover"   => "%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button:hover",
			 ),
            'quickview_view_cart_btn_'  => array(
				"desktop" => "%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward",
				"hover"   => "%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward:hover",
			 ),
			'quickviewpopupbg_'  => array(
				"desktop" => ".dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%",
				"hover"   => ".dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%:hover",
			 ),
			'quickviewpopuparrow_'  => array(
				"desktop" => "%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev",
				"hover"   => "%%order_class%% .product-images .swiper-button-next:hover, %%order_class%% .product-images .swiper-button-prev:hover",
			 ),
             'quickviewpopup_close_btn_'  => array(
                "desktop" => ".dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close",
                "hover"   => ".dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover",
            ),
        );
        DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }


    /*
    * _product_btn function
    *
    *   @param int $product_id
    *   @param string $product_type
    *   @param string $permalink
    *   @param string $show_add_to_cart
    *   @param string $add_to_cart_text
    *   @param string $select_option_text
    *   @param string $chooseOptionIcon
    *   @param string $cartIcon
    */
    public function _add_to_cart($product_id, $product_type, $permalink,$show_add_to_cart, $add_to_cart_text, $select_option_text, $chooseOptionIcon, $cartIcon) {
        if( 'variable' === $product_type ) {
            return sprintf('<a href="%1$s" class="product_type_variable dnwoo_carousel_choose_variable_option">
                <span class="icon_menu_btn" %3$s></span> %2$s
            </a>', 
                $permalink, 
                $select_option_text,
                $chooseOptionIcon
            );
        }
        return sprintf(
            '<a href="%1$s" data-quantity="1" class="dnwoo_viewcart dnwoo_product_addtocart product_type_%3$s add_to_cart_button ajax_add_to_cart" data-product_id="%2$s"><span class="icon_cart_btn" %5$s></span>%4$s</a>',
            'variable' == $product_type ? $permalink : sprintf('?add-to-cart=%1$s', $product_id),
            $product_id,
            $product_type,
            'on'=== $show_add_to_cart ? $add_to_cart_text : '',
            $cartIcon
        );
    }

    public function _add_to_cart_icon($product_id, $product_type, $permalink, $cartIcon, $chooseOptionIcon) {
        if( 'variable' === $product_type ) {
            return sprintf('<a href="%2$s" data-quantity="1" class="product_type_variable dnwoo_carousel_choose_variable_option_icon icon_menu" %1$s></a>',
            $chooseOptionIcon,
            esc_url( $permalink) 
            );
        }

        return sprintf(
            '<a href="%1$s" class="product_type_%3$s add_to_cart_button ajax_add_to_cart icon_cart" data-product_id="%2$s" %4$s></a>',
            sprintf('?add-to-cart=%1$s', $product_id),
            $product_id,
            $product_type,
            $cartIcon
        );
    }
}

new DNWooCarousel;