<?php

class DNWooProductAccordion extends ET_Builder_Module {

	public $slug       = 'dnwoo_accordion';
    protected $next_woocarousel_count = 0 ;
	public $vb_support = 'on';
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 

	protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-accordion-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

	public function init() {
		$this->name = esc_html__( 'Woo Product Accordion', 'dnwooe' );
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

        $this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles('dnwoo_accordion');
        $this->settings_modal_toggles['general']['toggles']['accordion_settings'] = esc_html__( 'Accordion Settings', 'dnwooe');
        $this->settings_modal_toggles['general']['toggles']['image_settings'] = esc_html__( 'Image Overlay Background', 'dnwooe');

        $this->settings_modal_toggles['advanced']['toggles']['product_settings'] = array(
            'title'             =>  esc_html__( 'Product', 'dnwooe'),
            // 'priority'	        =>	78,
            'sub_toggles'       => array(
                'product_name'   => array(
                    'name' => esc_html__('Name', 'dnwooe')
                ),
                'product_desc'   => array(
                    'name' => esc_html__('Description', 'dnwooe')
                ),
                'product_cat'   => array(
                    'name' => esc_html__('Category', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        $this->settings_modal_toggles['advanced']['toggles']['price_settings'] = array(
            'title'             =>  esc_html__( 'Product Price', 'dnwooe'),
            'sub_toggles'       => array(
                'regular_price'   => array(
                    'name' => esc_html__('Regular Price', 'dnwooe')
                ),
                'new_price'   => array(
                    'name' => esc_html__('New Price', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );

        $this->settings_modal_toggles['advanced']['toggles']['cartbtn'] = array(
            'title'         =>  esc_html__( 'Cart/Select Options Button'),
            'sub_toggles'       => array(
                'addtocart'   => array(
                    'name' => esc_html__('Add to Cart', 'dnwooe')
                ),
                'viewcart'   => array(
                    'name' => esc_html__('View Cart', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );

        $this->settings_modal_toggles['advanced']['toggles']['badge'] = array(
            'title'         =>  esc_html__( 'Badge'),
            'sub_toggles'       => array(
                'sale'   => array(
                    'name' => esc_html__('Sale', 'dnwooe')
                ),
                'outofstock'   => array(
                    'name' => esc_html__('Out of Stock', 'dnwooe')
                ),
                'featured'   => array(
                    'name' => esc_html__('Featued', 'dnwooe')
                ),
            ),
            'tabbed_subtoggles' => true,
        );

        $this->advanced_fields = array(
            'text' => false,
            'fonts' => array(
                'header' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_title'
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_name',
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
                'product_cats' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_categories, %%order_class%% .dnwoo_imgaccordion_categories li a'
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_cat',
                    'font'        => array(
                        'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe')
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
                'desc' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_description'
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_desc',
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
                        'main'      => '%%order_class%% .dnwoo_imgaccordion_child.product_type_variable .dnwoo_imgaccordion_price,%%order_class%% .dnwoo_imgaccordion_child .dnwoo_imgaccordion_price > span,%%order_class%% .dnwoo_imgaccordion_child .dnwoo_imgaccordion_price > del span',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'price_settings',
                    'sub_toggle'  => 'regular_price',
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
                'new_price' => array(
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_imgaccordion_price > ins span',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'price_settings',
                    'sub_toggle'  => 'new_price',
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
                'sale' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_imgaccordion_onsale',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'badge',
                    'sub_toggle'      => 'sale',
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
                'outofstock' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_imgaccordion_outofstock',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'badge',
                    'sub_toggle'    => 'outofstock',
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
                'featured' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .dnwoo_imgaccordion_featured',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'badge',
                    'sub_toggle'    => 'featured',
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
                        'main'      => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'cartbtn',
                    'sub_toggle'  => 'addtocart',
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
                    'hide_text_align' => true,
                    'css' => array(
                        'main'      => '%%order_class%% .added_to_cart',
                        'font'      => "%%order_class%% .added_to_cart",
                        'color'     => "%%order_class%% .added_to_cart",
                        'important' => 'all',
                    ),
                    'toggle_slug'   => 'cartbtn',
                    'sub_toggle'    => 'viewcart',
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
            ),
            'borders' => array(
                'default' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
                        ),
                    ),
                ),
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_child',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_child',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_accordion_image_settings',
                ),
                'text_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_title',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_title',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_name',
                ),
                'desc_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_description',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_description',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Description', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_desc',
                ),
                'addtocart'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
							'border_styles' => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'cartbtn',
                    'sub_toggle'   => 'addtocart'
                ),
                'viewcart'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .added_to_cart',
							'border_styles' => '%%order_class%% .added_to_cart',
                        ),
                    ),
					'label_prefix'  => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'cartbtn',
                    'sub_toggle'    => 'viewcart'
                ),
                'sale_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_onsalestock',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_onsalestock',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'sale'
                ),
                'outofstock_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_outofstock',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_outofstock',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'outofstock'
                ),
                'featured_badge'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_imgaccordion_featrued',
							'border_styles' => '%%order_class%% .dnwoo_imgaccordion_featrued',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Featrued', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'featrued'
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
                        'main' => '%%order_class%% .dnwoo_imgaccordion_child',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_accordion_image_settings',
                ),
                'text_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_title',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_name',
                ),
                'desc_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_description',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Description', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'  => 'product_desc',
                ),
                'addtocart' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug' => 'cartbtn',
                    'sub_toggle'     		=> 'addtocart'
                ),
                'viewcart' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .added_to_cart',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
                    'toggle_slug'=> 'cartbtn',
                    'sub_toggle'     		=> 'viewcart'
                ),
                'sale_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_onsalestock',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'sale'
                ),
                'outofstock_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_outofstock',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'outofstock'
                ),
                'featrued_badge' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_imgaccordion_featrued',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Featrued', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
                    'sub_toggle'    => 'featrued'
                ),
            ),
            'height'    => false
        );
        $this->custom_css_fields = array(
            'product_name'   => array(
                'label' => esc_html__('Product Name', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_title',
            ),
            'product_desc'   => array(
                'label' => esc_html__('Product Description', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_description',
            ),
            'product_price'   => array(
                'label' => esc_html__('Product Price', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_imgaccordion_price',
            ),
            'product_rating'   => array(
                'label' => esc_html__('Product Rating', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_product_ratting>.star-rating',
            ),
            'add_to_cart'   => array(
                'label' => esc_html__('Add To Cart', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_child .add_to_cart_button',
            ),
            'select_variable_products_option'   => array(
                'label' => esc_html__('Select Variable Products Option Button', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_choose_variable_option',
            ),
            'view_cart'   => array(
                'label' => esc_html__('View Cart', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_imgaccordion_child .added_to_cart',
            ),
        );
    }

    public function get_fields() {
        $fields = array(
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
					'__nextwooprodutaccor',
				),
			),
            'hide_out_of_stock' => array(
                'label'            => esc_html__( 'Hide Out of Stock', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Hide out of stock product from the accordion.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooprodutaccor',
                ),
            ),
            'dnwoo_badge_outofstock' => array(
                'label'           => esc_html__( 'Out of stock Product Text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Sold',
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
                'description'      => esc_html__( 'Here you can specify the size of product image.', 'dnwooe' ),
                'type'             => 'select',
                'options'          => array(
                    'full'	=> esc_html__( 'Full', 'dnwooe' ),
                    'woocommerce_thumbnail'	=> esc_html__( 'Woocommerce Thumbnail', 'dnwooe' ),
                    'woocommerce_single'	=> esc_html__( 'Woocommerce Single', 'dnwooe' ),
                ),
                'default'          => 'full',
                'default_on_front' => 'full',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
                'computed_affects' => array(
                    '__nextwooprodutaccor',
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
                    '__nextwooprodutaccor',
                ),
            ),
            'products_number'      => array(
                'label'            => esc_html__('Product Count', 'dnwooe'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__( 'Define the number of product that should be displayed per page.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooprodutaccor',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => 3,
            ),
            'offset'      => array(
                'label'            => esc_html__('Product Offset', 'dnwooe'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__( 'Define the number of product that should be cut down from first.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooprodutaccor',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => '',
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
				'computed_affects' => array( '__nextwooprodutaccor' ),
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
                    'type'          => array( 'latest', 'best_selling', 'top_rated', 'featured', 'product_category' ),
                ),
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Here you can specify the order in which the products will be displayed.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwooprodutaccor',
                )
            ),
            '__nextwooprodutaccor'    => array(
                'type'                => 'computed',
                'computed_callback'   => array('DNWooProductAccordion', 'get_products'),
                'computed_depends_on' => array(
                    'type',
                    'hide_out_of_stock',
                    'thumbnail_size',
                    'order',
                    'products_number',
                    'include_categories',
                    'orderby',
                    'offset',
                    'accordion_style',
                    'expand_last_item'
                ),
            ),
        );

        $show_hide = array(
            'show_add_to_cart' => array(
                'label'           => esc_html__( 'Show Add to Cart', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'on',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'display_setting',
                'description'     => esc_html__( 'Choose whether or not the add to cart button should be visible.', 'dnwooe' ),
            ),
            'dnwoo_show_add_to_cart_text' => array(
                'label'           => esc_html__( 'Add to cart text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Add to cart',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the Badge type text for your product badge.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_add_to_cart' => 'on',
                ),
            ),
            'dnwoo_select_variable_option' => array(
                'label'           => esc_html__( 'Select Variable Option Button Text', 'dnwooe' ),
                'type'            => 'text',
                'default'         => 'Select Options',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the Select Variable Option Button text for variable products.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_add_to_cart' => 'on',
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
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Here you can choose whether the category should be added.', 'dnwooe' ),
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
                'description'      => esc_html__( 'Here you can your featured products badge', 'dnwooe' ),
            ),
            'dnwoo_badge_featured' => array(
                'label'           => esc_html__( 'Featured Product Badge Text', 'dnwooe' ),
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
                'default'         => esc_html__('On Sale', 'dnwooe'),
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Define the Badge type text for your sale product badge.', 'dnwooe' ),
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
                'description'     => esc_html__( 'Define the Badge type text for your percentage product badge.', 'dnwooe' ),
                'toggle_slug'     => 'display_setting',
                'dynamic_content' => 'text',
                'show_if'        => array(
                    'show_badge' => 'percentage',
                ),
            ),
        );

        $accordion = array(
            'accordion_style' => array(
				'label' 			=> esc_html__('Accordion Style', 'dnwooe'),
				'type' 				=> 'select',
				'default' 			=> 'on_hover',
				'options' 			=> array(
					'on_hover' 		=> esc_html__('On Hover', 'dnwooe'),
					'on_click' 		=> esc_html__('On Click', 'dnwooe'),
				),
				'toggle_slug' 		=> 'accordion_settings',
                'computed_affects' => array(
					'__nextwooprodutaccor',
				),
			),
			'expand_last_item'          => array(
                'label'                 => esc_html__('Expand Last Interacted Item.', 'dnwooe'),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__('No', 'dnwooe'),
                    'on'  => esc_html__('Yes', 'dnwooe'),
                ),
				'default'	=> 'off',
                'toggle_slug'           => 'accordion_settings',
				'show_if'	=> array(
					'accordion_style'	=> 'on_hover'
                ),
                'computed_affects' => array(
					'__nextwooprodutaccor',
				),
            ),
			'accordion_direction'	=> array(
				'label' 			=> esc_html__('Accordion Direction', 'dnwooe'),
				'type' 				=> 'select',
				'default' 			=> 'row',
				'mobile_options' 	=> true,
				'options' 			=> array(
					'row' 			=> esc_html__('Horizontal', 'dnwooe'),
					'column' 		=> esc_html__('Vertical', 'dnwooe'),
				),
				'toggle_slug' 		=> 'accordion_settings',
			),
			'accordion_height'=> array(
				'label' 			=> esc_html__('Accordion Height', 'dnwooe'),
				'type' 				=> 'range',
				'default' 			=> '400px',
				'default_unit' 		=> 'px',
				'range_settings' 	=> array(
					'min' => '1',
					'max' => '1200',
					'step' => '1',
				),
				'validate_unit' 	=> true,
				'mobile_options' 	=> true,
				'toggle_slug' 		=> 'accordion_settings',
			),
			'active_image_width'	=> array(
				'label' 				=> esc_html__('Active Image Size', 'dnwooe'),
				'description' 			=> esc_html__('Control how wide or heigh the active image will be in relation to the other images of the accordion.', 'dnwooe'),
				'type' 					=> 'range',
				'default' 				=> '5',
				'unitless' 				=> true,
				'range_settings' 		=> array(
					'min' => '1',
					'max' => '10',
					'step' => '1',
				),
				'mobile_options' 		=> true,
				'responsive'			=> true,
				'validate_unit' 		=> true,
				'toggle_slug' 			=> 'accordion_settings',
			),
			'gutter_space'	=> array(
				'label' 		=> esc_html__('Gutter Space', 'dnwooe'),
				'type' 			=> 'range',
				'default' 		=> '0px',
				'default_unit' 	=> 'px',
				'range_settings' => array(
					'min' => '1',
					'max' => '100',
					'step' => '1',
				),
				'validate_unit' => true,
				'mobile_options' => true,
				'toggle_slug' => 'accordion_settings',
            ),
        );

        $margin_padding = array(
            'dnwoo_accordion_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_name_margin'	=> array(
				'label'           		=> esc_html__('Product Name Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_name_padding'	=> array(
				'label'           		=> esc_html__('Product Name Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_desc_margin'	=> array(
				'label'           		=> esc_html__('Product Description Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_desc_padding'	=> array(
				'label'           		=> esc_html__('Product Description Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_rating_margin'	=> array(
				'label'           		=> esc_html__('Product Rating Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_price_margin'	=> array(
				'label'           		=> esc_html__('Product Price Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_product_price_padding'	=> array(
				'label'           		=> esc_html__('Product Price Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_addtocart_margin'	=> array(
				'label'           		=> esc_html__('Add To Cart Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_addtocart_padding'	=> array(
				'label'           		=> esc_html__('Add To Cart Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_viewcart_margin'	=> array(
				'label'           		=> esc_html__('View Cart Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_viewcart_padding'	=> array(
				'label'           		=> esc_html__('View Cart Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_onsalebadge_padding'	=> array(
				'label'           		=> esc_html__('On Sale Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_onsalebadge_margin'	=> array(
				'label'           		=> esc_html__('On Sale Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_outofstockbadge_padding'	=> array(
				'label'           		=> esc_html__('Out of Stock Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_outofstockbadge_margin'	=> array(
				'label'           		=> esc_html__('Out of Stock Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_featruedbadge_padding'	=> array(
				'label'           		=> esc_html__('Featrued Badge Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_accordion_featruedbadge_margin'	=> array(
				'label'           		=> esc_html__('Featrued Badge Margin', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
        );

        $background_opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $img_overlay_opt = array(
            'description'           => esc_html__('Add an overlay background fill color or gradient on top of the image', 'dnwooe'),
        );

        $sale_badge_bg       = DNWoo_Common::background_fields($this, "sale_badge_", "Background Color", "badge", "advanced", array_merge($background_opt, array(
            'sub_toggle' => 'sale'
        )));
        $outofstock_badge_bg = DNWoo_Common::background_fields($this, "outofstock_badge_", "Background", "badge", "advanced",array_merge($background_opt, array(
            'sub_toggle' => 'outofstock'
        )));
        $featured_badge_bg = DNWoo_Common::background_fields($this, "featured_badge_", "Background", "badge", "advanced",array_merge($background_opt, array(
            'sub_toggle' => 'featured'
        )));
        $addtocart_bg_color  = DNWoo_Common::background_fields($this, "addtocart_", "Background Color", "cartbtn", "advanced",array_merge($background_opt, array(
            'sub_toggle' => 'addtocart'
        )));
        $viewcart_bg_color   = DNWoo_Common::background_fields($this, "viewcart_", "Background Color", "cartbtn", "advanced",array_merge($background_opt, array(
            'sub_toggle' => 'viewcart'
        )));

        $image_overlay_bg    = DNWoo_Common::background_fields($this, "image_overlay_", "Image Overlay Background", "image_settings", "general",$img_overlay_opt);
        $content_bg_color    = DNWoo_Common::background_fields($this, "content_", "Background Color", "dnwoo_content_bg", "general", $background_opt);

        return array_merge( $fields, $show_hide, $accordion, $sale_badge_bg, $featured_badge_bg, $margin_padding, $outofstock_badge_bg, $addtocart_bg_color, $viewcart_bg_color, $image_overlay_bg, $content_bg_color );
    }

    public static function get_products() {
        return '';
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}
        wp_enqueue_style('dnwoo_product_accordion');
        wp_enqueue_script('dnwoo-image-accordion');

        $products_number            			= $this->props['products_number'];
        $product_tag_arr = is_product_tag() ? array( get_queried_object()->slug ) : array();
        $order            			            = $this->props['order'];
        $orderby            			        = $this->props['orderby'];
        $type            			            = $this->props['type'];
        $offset            			            = $this->props['offset'];
        $include_categories            			= $this->props['include_categories'];
        $hide_out_of_stock            			= $this->props['hide_out_of_stock'];
        $dnwoo_badge_outofstock            		= $this->props['dnwoo_badge_outofstock'];
        $thumbnail_size            			    = $this->props['thumbnail_size'];

        $show_rating            				= $this->props['show_rating'];
        $show_price_text            			= $this->props['show_price_text'];
        $show_add_to_cart						= $this->props['show_add_to_cart'];
        $dnwoo_show_add_to_cart_text			= $this->props['dnwoo_show_add_to_cart_text'];
        $show_desc						        = $this->props['show_desc'];
        $show_category						        = $this->props['show_category'];
        $header_level						    = $this->props['header_level'];
        $tag                                    = et_pb_process_header_level($header_level, 'h3'); //if you add tag change option. header_level parent name array must header.

        $show_badge                             = $this->props['show_badge'];
        $dnwoo_badge_sale                       = $this->props['dnwoo_badge_sale'];
        $dnwoo_badge_percentage                 = $this->props['dnwoo_badge_percentage'];

        $show_featured_product                  = $this->props['show_featured_product'];
        $dnwoo_badge_featured                   = $this->props['dnwoo_badge_featured'];

        $accordion_style                        = $this->props['accordion_style'];
        $expand_last_item            			= $this->props['expand_last_item'];

        $settings = array(
            'products_number'    => $products_number,
            'product_tag'        => $product_tag_arr,
            'order'              => $order,
            'orderby'            => $orderby,
            'type'               => $type,
            'offset'             => $offset,
            'current_categories' => (is_product_category() && 'current' === $include_categories) ? (string) get_queried_object_id() : '',
            'include_categories' => $include_categories,
            'hide_out_of_stock'  => $hide_out_of_stock,
            'thumbnail_size'     => $thumbnail_size,
            'request_from'       => 'modified-frontend'
        );

        $products = dnwoo_query_products($settings);
		$single_product = "";
        $demo_image = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsCAYAAAB5fY51AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2d+5Mc13Xfv/d2z8zO7GKBBQiAIEURokWQ4gMUCL4k+SFbkUuOq5ykFNtJrCr/EalK/pO8KhVVnIgq0pafihSRtGzzIVImRUkU+AJBUmYokiANEPuY2Znp7nvzw312z4AmCGCnL/j9UKvdmenpvt2D/s45555zrtBaaxBCSALIRQ+AEEI+LBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIclAwSKEJAMFixCSDBQsQkgyULAIIcmQL3oApM4775zG/3vzTRy9/Xb0et2Z17XWM89Np1PkeQ4hBIQQqKoKk8nEvy6EQJZlyPMOhBQQACaTCbaGQ5RFCSEERqMhRqNtFGWJTp5jOBxhfWMDGxsb2N4eo9frYXt7DCkFlFIAAKUU+v0+qqoCAJRlhaqqUBRTCCmx1OsiyzJ0ux1oDRTTKZTWyPMck8kUSikIIaDtc1kmkWcZur0u+ktLWFlZgRDmeMPRCIhOXUNDQGBl1wr2rq1hbW0Ne/euIc/DP2kp69/HWuva9XPHnkwmWF9fx+bWFsqiRFmW/vVpUWBtbQ8O7N+PwWAAIcSFf6jkkiH0vDuALAStNf7Tf/5vOHbsGE6cOIF+vw8hgPF4gjzPUFYKRVEgkxmqqoIQAjKTEEKiKksIaW6mQb8PpTXKsvKioKoKRVkizzMIGGEbDJaRd3IICPSWesizDBBG0KSU6A8GdgwCUkp0Op1ww2oNpTWKooAUAjLLIASQ53kQDW1ErVIK0BoQAu5fmxCAlAICAuZ/wh+7KAsU0wKj0Qhaa2RZhpWVZQBGYJRSUEoh7+QYDUdYX1/HxsYGNrc27XgkAO3HrZSy79OQUkJrjUpVZnxaoZN3sLyygv5SH3knh7TXUWugqioMh0NsbKxj/dw5/Mf/8O8pWguEFlaL2NjcRL8/wO49a7j7nvsgrWXkrCKtdTAytLEyHALWAImed8JkNcFvPXO72RtQNB6bd4St592m3U4HsMIgBOo3s4a3+mpjB4zISTmzUyEEelkPvV4PK7tW/HO1baKRDQYDXLX/KnM4rc35NywpAFBao6oqqEpBSIEsk5BCRtfTjE9KYQRPwIucUgplWeI7/+fb0FpTsBYIBatFTCdTSJlhMpkaFy6TEFJCCmFcIG1vlPh+0fCWiXmo5yuTf9rc6ue75eK3aicNOnpNzHuvNuYIRBBRKxxKK2tV6fpRzzsAHQQ0EtJ5ouV/ewWzwqgFlFY1F1La90ujqsGanLmW8TEEhNTe4rrqqv0oigK9Xu88gyeXGwpWi1AqfPtnmTRWi3Wb3E0PAEJYa6Zx13tREyHWVbdr4G9KPfMkvLsWi5u2L3iZE8bCqFljSqMSVW08zsrR/r3B2gLMe5RQXgCdINnh+30IKzAzxEZg9FgIc3JSCWh/BgISGiKT0G5f9jjGCoUXu3njd67lYNBHUZQUrAVCwWoRw9EIvV6vJgjmbwEJdzMHN6+J0MbC8VZNww0z965VIyuAsSCZPxtS1tiBc/v8GLUTSkCFvUArcyytjMUkpISxwPyb7HC0OS8t/LlaY6k2bidk3gjyKti4CNpu54TQKZNRcT8v7o5l1dKLprbXQEBACx3F2ICVlV0YjYY2nkYWAQWrRUynU3TyToj3RAJlLJAZeykQxW60MgHxmfkUZ11pFZ7SGs3NPhg7Dh/LMY6j36PWXgRic0krBUjp3VrnuhqxghcHARlEzLmYNYvO/QqWUf0ctRcdJzz+PFU0bune6sYTnaFzwcPBvAWoFOeoFgkFq01oQEjhrSMA3opwlgd0sE5gb0qlde1GVUrZ5+xOvVkSYkJuW0S/4xvYDSgWMyEArZ1IBcslmjiMto1iWe45HdzG2oRBLWZV1awaHcWVmu8tyxKqqrA9HmO4tWXSEQRQTAtMJhMTZFcKeZ5BKWMd9vt9XH31QRw8eBBVpVGUZXC/YVM26vMG9tpqLK8sY2trE8DB83yA5HJDwWoRk+kEeRZ9JM51E26G0M5YFSWEn643FlPNStLaxL6kgPOBhACqSvn91Gb/IivFWCD+FUhnXTiVcztD7D6aF814FKaTKUajEYbDIbSzxgBkeY7dq7tsmkaOfr8HISSm0yk2NjYhM4k8M/lYSimfkwWbhiCEQFVWPn1jqddDnuc4uH8vlq475NMu8jzHrl27ajlZjvF4jLfffhs///nrGG4Nsbm1hV7X5Lu99vrr+NKXvoyVlZVILcPnIIVEWVYX8ImSSw0Fq0Vsbm5idfduk59kA+tAZAkpjddefRUb6+eQZZnNfRKoyhJlVSGTxs/pdDqQQmCpv4QlGxOrlItrAWVVoiwrlPbmN3Em81qWSW+xmVQFI3y6Ut6i6na7yPMM3U4H/f4SSpsqsNTrQWZd7Ftbxa5du9Dpdk3SqDIzbdPpFNvb29EEgoCUAv1+H4PBYCbR83LQ7/dxww034IYbbqg9P51O8cd//Kfo9/uRQSq8i6thLLqdGCM5PxSsFqEqhaUlkyBpgtuyFj+BAEajEb7yld/Enj17FjrWj0Kv18OuXbsWPYy5VErZiYE4ZSK4oAIml0tF8T+y8/DrokUYVyfEo4B60F3YjPLhcLTIYV6ZaGNl1UJ4Ln4oggvqynbIYqBgtQgpJbIsszNoNtYU3UBCwLiCck5OA7koiqKAlNncLHbnkq/tXcP6+sZOD41EULBaxKDfR+aC7i5PqIYJprjiY3Lp2NhY98XWcbVA7BYOBgOURbHAURIKVgvxeVdz9MrM/vFju9T8/B/ewNWHDvnH9TpN819ZFKwjXDD8l98iqqryrVqA2dIbwEytZxSsS87ZM2exe/dqs2bJpGXYJ0ejEXpLSwsYHXHwX36LKIrCCJYvq5lNrpxXkkMuHt/pIc50jcTLptbSwlowFKwWoZT2nRlmCkBs4Lff79ea85FLx7zCJ1dzKGBy1DTjhwuFgtUiirII5S4zr5qAe553UDDwe8kRUkApHSoBdBAwIYUPxrPf5WKhYLWI6bQwyaJAKHyG62Bg/uvkGegXXnpck0GlVE2s4tel4O2yaPgJtAhTqJuHXleufYovBNaQWYaZyDC5aKoq9Jf36PDjBGxefSLZOShYLcJ3TfBdFeqWlBACWim2OLlMKFXviupcQK0VtNI4d+5ckiVRVxIUrBYhbX8p30PKWVJRp5g8z2upDx8Hzp07h3Pnzl3W+FHcb8zXZgM+pqgBnDu3zuZ9C4b2bYsQtjuCx7kjItyo02nxsegYcPLkK3j6mR9hPJ6gPxhgqdfD6dOnMegvYTAY4IYbPoU77zx2ydIMyrK0rXpCkz8RpTEI2+In73QuyfHIR4OC1SKkvznqbonp6W6D7t38ihasJ598Cs/97Hms7d2H226/A3kWlt26+TO3mF5fQuCNN97Af/mv/x2/9ZUv4/Dhwxd93GYraB84BHwB9Pr6OlZb2m3i4wIFq0UU8zoB6Lpr2O32sLG5ubMD2wGKosCDD34Le/buw+e/8MvIbCG4X4SjkcV5/eHrcc211+Jv/vYJ3HzTO/jc5+67qOPHBeUiFqv4OWh0u7OL25Kd48r9qk4Q6VaUAWbiWM5d6XY6qKorr8XJ/d98AJ/6pU/jU4cPo9vpoNPJQ+viyOJ0DQWzLEOv28Xd99yNl14+hVdffe2ijv9BnUTd0TlDuHgoWC3CJSjOLN8VRYFH29vo5FdWHOXRRx/DoWs+gbW1PWblZbseI6JyJL8MWDSTKuz6gsfvugvfe+iRi5qMCDOzUY/52gIVPhxPFggFq1W4Rn3RohMAwi2jMd4e+xWRrwQ2Njbw8slXcd0nPmFcwLltdSJ8YNy0bJaZRCfPccstt+Fv//bRjzyOpaXe7PKH7rFdWejjNjvbRihYLcJ8u4dFH2ZuW9uPPc+yBYzu8vDDHz6No0ePerECQv5TjCtODphtpZCQWYZ9V+3DqVdf+8iioqwohXU26p0TnV1HFgsFq4XU8oBQTyDd3NjE2treHR/T5eKtt9/Gnj17/Eo48fqBzWXIHH4ZMCvs0sa0Pnn9Ybzw4osfaRxVVUWt+uYVQYP93FsABatF+Js0ukHjGSsNjfWNdayuXjlT60rpKHYHQJsFIVRlssuho4aGwEyfdYcUAocOHcLLL5+84DFUVYUsy4z4iUaQ3/0WdnUhslA47dEi8k7HJIYu2dWPQxcms4EGunbtvSuB4XDolyoDjE4rrWwBsrZtot2K0KKWQDuDFbGiuPAZVKXMMU2/fFlb9CNKxbqi899SgZ9Ai+h2OzbjWs/GbOzf2RUUvzp79n3sWrHWos038+4gIlfQrg0YryBUQ5vXpJDI8w42N7cuaBxuJZxMSpv3ZfBH8aVRtLAWDQWrRQz6A2xvj+o3rI4WUr3CEhcn0wmyPKsnxwpElo0VbiFC8nnUUA8IK2K77aZFccH9wsbjMZaWliK3M4qnuf0r1ymDLBK6hC1CZtIv6w6EfuJCCx+M7i/1FjrGS8me3bsx3Br62j3AWVHRRpFgx3V9cOVKtdeB8fYYnc6F/rM2zfucFecLC5wnrjUqpdg4sQXQwmoRg34f4+2xL4J2N4+OVhzu9q4cC2t1dRUbG+tQWnlr0jTKE74kBwiWZry8mXfRIisIMF1bL3R1aaWUF8HwNRFmKsPPJTltchFQsFrEgQP7MRoNIaObFlFAWtug+5VCt9uFzCTKovRiJKQwC8pKEwD3bqB9HnA5U1HelAa00tjc3MRSr3fBCek+921uQoPb5sqY6EgdClaLWF1dRafbnYnVuJWgNzY3sLp79SPte2triD/6X9/Ac8/97NIO+iI5fP0nsb6xgbKsQpDdrcnorsPcciXtr4vWGlWl8ONnn8VvfvmfXXB+pxFEWUuhqM0Q2i8Qd1yyOChYLUJKiZXlAeauoArgzJkz2Lu2dsH7ffPNX+B/f+ObuOvue/D0M8/i9dd/ftFjvVR88Yu/hhdfOIHx9hhVVfm6yeaMYCxO3gzSIb509v2zWFvbg0OHDl7wGKTM0MnzWqzMJKU2iq5pZS0cClbLWOr3EeIoqP3/5ubmBbfofeutt/Gd734P99x7H8bjKe6+5148+vgP8JOfPncZRn/hdDsdfO0P/i1eeukEXnv9dZRFgaqsTMyultahI1dQ+QUjyrLEdDrFj555Gr/921/5iKJSLwWatwefE0fRWigUrJYxnUyjxgDBmjCLUCgsXcDKw6+8cgoPP/J93H3PfRB2xeiqUrjjjs/ixRdP4uGH/7oVLs7S0hK+9gf/Dlcf2IennnoS7773HqaTAmVZGvGqTB97rYxIVZVCVVYoyxLb4wkef+xR/N7vfvUjN9eTUmI8HptE1TmC5GZohaRYLRoKVssYbY98DlZInDS/LuR2eeWVU/jRsz/BsTuPAwDyPPM/Qgh85pZbMRoX+JNv/Vlt9m2R3HXXcXztD/4NtCrw5JNP4B/eeAOT6RTjyQTTaYFpUWA6LTCZTvHeP/4jfvzjn+BHz/w9/vAPv4ZPfOLaj3zc5eVlrK9vmAcN/Ra2R5nWmst8tQDmYbWMyXhiptmlBBSiOsIPzyuvnMLzL7yMW269DVVVIc9z5LbsRCkFJQW0Am644VM4d+4c7r//Afz+7/9rdFowA9nr9fDFX/tV/Nqv/gp+8ORTeO6nP8ZkMoXMMkwnU0gpMBj0ce01h/Cl3/gVXHPNNRd9THdd4NMjQncsDe1nERdvixIKVsuYTqdGsAA/re9Ua1oUtSTLebzzzmk8/8JLuOGXPo2yrJDnGbIsC8W9kNAKgNSQEFhbW8PK8u341p/+Of7Vv/wd9HrtSEwVQuALn/8cvvD5z0Frja2tIbrdzmUbn4xy32xSPZpfE1dSW59UoY3bIsqyxHA49DlXLqbi8rKWeksYDofnff/Zs+/j0ceewKc/fQRlWULa3CXp0gRqDQLN/jMp0e32cNPNt+CBB7+F8WSyMyd7AQghsGvXymUVU9PlNOqMoefkZAnBJn4LhoLVIlx5CBCSGV27EyEE9u5dM8HhOYxG23jo4Udw9OgddjGLei5R3GRL2CQnIYxlkXcy9JeWcMdnj+GBB/4Y29vbl/dEW4ZSytZXR9dsjhW7PBh84BcGufxQsFqEUgpSZN4dzGxfcydYnU4+tzxEa43vPfQwjt91t3cb/eINzXUOAbNPaW9Ql1meG9E6dudxPPTQIztxuq3BXPe455ao9XaHvU5LS0sfuFgFufxQsFqHrk2vx6Hera3h3MLev/u7x3D48A0Yj6coy8q4gdK4ey5Y7LsOQIebUThLy7qeUqDX62F19xoee+yJnTndFjAcjdBbWgqtZWa+Fcxj1zeLLA4KVoswBc6i1tfdpY1qaJw5cxb9fr/2nhPPPw+Z5cg7XRSFWRU6y6SfFXTxL4hQROxcTWnr52LLS0qJqw8dwrv/eBYnTjy/w1dgMWxubGDQH4Qnmt6grVVsJpiSnYeC1SJMvMpOoTdKUKDNDGKcevDee+/hzTffwv4DB1AUBYQQyDLp1/NzP272SwrboE6KmQBzHGGWUuLmm2/Gsz95DqdPv7tj578olNLIsvhWaNQtwpT/DEcjLC8PQBYHBattRDGnuIGf0hqdbgfb2yboXpYlHn30cdx45CZMJgWEgBEqF/OSwltpXqQaQXwZu4yR9eD2dezYnXj4ke/jzTd/sYgrsXMIM0sI1DuL+r5kyhRXj4ajC6o0IJceClaLaK5yDERVhVpj7959eOvttwAADz/yfdx62+0Y20RTb035fUQN8eJCYh9XjroShI6B/jUpjFv52WN34okfPIUf/v3TO3AFFsi8yQz7f67qwFmuZHHw6reIPM99QLzZVkUDuPbaa/HySydx8uQrEEKiKCuTBe7cPy8+bmo++nGPa8uHuR8ReqpHJUEmHpbh9tuP4p3T7+Gxxx7ficuw82iYVs2YF74KF6zDpeoXDgWrRUgp0LGr4sTLWjkLqdfrYWs4xN89+jgOHDyEsixrMauaxRT1koqJ27T4W1G452EXgbBPSxMTyzs5brrpZmyPC9z/zQcwmUx36pLsGLUs9nnXDGZVI7JYKFgtY3W13qDPiZW0Majl5RXs3XeVSfjMMuRZZgUrtBUWkTtYo15LXRMtF+hXSkFHU/fO4sukxOHDh3HrbbfjwQf/BO+++96lP/kFMpkaEa6tjhMpuhBmVR2yWPgJtIxO13yLOynRMNnvUhhL6tM3HsGRI0eQZ2aJduMKmh8nbn4xhQY6aozXxCWRNoutY0ETUqLf7+NzX/gCfvDkUzh16tVLffoLo9bx1BOugpvIIIuFgtUy1s+tmz98SxlrMQkgkyYLPotyrETjxxPHrqL9QTReip8XApm0rlGU6uCSTl0pj9Yat912FKdefQ0vvPDRloZvE871jS1Q35LMbAGtjctOFgsFq2WYFVyCpeQsLKc0LjE0y7KQuoCox/l5Ylc+Fga4QsXaDJh5ur7Yg9mx/aVR205D48YjN+H06ffw9NPPXNZrcrnZtbILwy2z+Gq8eGt8BZVSrelk8XGGgtUyjBUT8qaEbR4Xd/HzeVRC1ly4OIVh/s7h6+TcY59/FaU0xEII2EC8Un5VZredUgqHrrkWo+1J0qK1srKM0fZ23SK1oi5g+8ZXZSv6hX3coWC1kNnFF0w2di3GImoNGOppDA4/6xcSIZtSFlto9Rfgn/fBeL8IRBCtLMtw8ODVOPv+Ol588aWLO/EFked5baLBnZ9fgdsuorprZWUxAyQeClbL6PV6M8mepqe4sjN4Lvvd9Hj3i5DOcQXDgqCzx2mmaNUy3aPgvXsNCKKmY1fSZolff/gwXnv9H/Dssz++TFfm8pK7VXMil9D8MsXoZUkLqw1QsFrGdDq7HLpy6QfaFEgrrWzngChnKkoydXhXL8q7qltpwhc8iyimFYufcQ9lzaKLxQ0ICaY33ngE75/bwKMJJph2OzlE0waNrNeqqlCxU8PCoWC1DOEC7VGzvSyTvlWMgGjEklCvG7T7cWEvZ4HpSLTcclnm/b6dn3c/w1hsVwcZd3eI0CF9QgoBmUlc98lPQsoO/urb30mqO2dvqefF2hFbp6YagJ0aFg0Fq2W4XCkfHLczg272LhQtW5GIhMzPAMIVTBsX0v2OZwSjbAaremH2rxkraxZTm7fU8yO0/VNKiQMHDuCaa6/Dn3zrz5PpXtrtdjGd2iXWGgXoTuTJ4qFgtQwZiYPr5+5FKpo9zGQGmYWkUeeyBWvKuIyxNYXodftgXs3vTCFwM9frfLOQXgSlwK6VFdx66234sz//K5w9e/ZiL8tlJ7Mr5/grIly1gLZCLFAmZDFeqVCwWoZS2rtpAIylZa0pJ1y1PldRdjpgLSuloSrlg8jauobO03QLkroylOYM4YyVhcjKQsP6aL7fruojM4ler4djx+7E/33or3H69OlLeZkuOWVZQdikWHfdTK14qBxn8fPi4SfQMlzwux6Mil4zT/q8qxniGTxttzJ3XhApmEVBNTRwnuxtH7AXmGtRhRlDs5HWasb6ElIgyzPcccdn8dAjf4Mvf+nXcfXVBy/kcsylKEqMx2NsDYd2degSo+0RBAQOHjyAvXv3XvA+NTSqsjKzsALQ7mPwLrCpMCCLhYLVMsqyhOu8XpMJISCcSEQJjVaLPLFLExLkRV3sNKCgIOxd6UWyQW3laV+f6GYeoxlFhM1c3Z1DColOnuPOO4/jO999CP/id34b+/ZduKCcO3cOL718EidPnsJ4PEFZluh2u1jq99Hr9bBic6R++tMTGI9H+PKXv4Rrr/3wq0F3Ox2UVWnPQNeTcIVoXEOyKChYLaOqquDK+TiKRYjgqljXa97MlTQ+pDET0EhEdSU8iNMeAH+bNhJJa/EveyOH/K55uVshGO8C81JKdDo57r3vPvzFX34bv/e7X8XKyvKHuh7vvfceHn7k+wAErr76EG677Si8yQjh6/tcbtihQ9eg1+3goYe/j9tvvxV3Hb/zQx3H1Weac7EIQGhjoeZzFv8gOw9jWC3DJDA6DZlNZGzOYDXx6Q3nCZI3S29CHArwGalwaQ4h3qWqqDRHu1lIEy+rKoVKhR+X4Oqy44EgWncevwvfuP8BTIvZfLMmzz77Yzz8yN/gs8fuxC233o49a3sh3MIa0rbWsTlgZoVrE4Pankxw11334OTJV3H/Nx/AaPRPz1SaLwCEfDN/wcy1yHO6g22AgtU6RC3R0xELWCi0mevJ2VdnM9Vrx4AVK5f2YF09P9MIdywrTD5ZNcqutyU7VVWZWFJVmb+rCmVVoiqrEPyHEa3BoI/jx4/jwQe/9YF5Wj/72Qn84q3TuPW2o7ZhoA75aNGEg5ROtCTyLDerBQmJoizxmVtuxS99+gj+x9f/J048/8IHL9ElBARkZHHW6XW7dAlbAAWrRbjcKfvA/ELkniEI13kSEho7jETJWjtGbJQXpWZSqd9t8zei9Q0jK8vt3y3UYH4qlKUTLiNiTiyEEFhdXcWNNx7B17/+R3NXUj5x4nm8/vM3cN0nr4dWylpQuXHbbLNC6VM/omJwWV81CNDI8w6+8Mu/ih/+8Bk88YOn5lqlQEgnid1df8EFcO7cuo+TkcVBwWoZbvbuQ6UpelGxrlwtu8BaRS7NQWsjHFWcnxWyuX1Hhuh5AJEoRLEddyhXDiTqYqaU+1FeuJyb6BoFru1dw733fQ7fuP8BvHzypB/3mbNncerV13D99Z8CYHqt+/5fvllh5Oq68iK3hJlN/chsSZGUEkorHDt+HL946x1897vfO4+lFWXAussZibrSmnGsFkDBah06KnCuixAQZaaHzf1N60trYuvHCperhausC6fcjxUqpYPr54UL2sdw6kH1YNk4i0fYQHgtm97FupSxvJw7CRhh7veX8MVf/3WcOvVzfPObD+D999/HE0/8AEeO3AylgwsoY9EUiFYGiq4JQuDfdUf1YxQS0BpHjtyE5V278fWv/xGKmRiaru/MfW1Y8VJKnd//JjsGBatluDYyziLx1paOUxidcJnH9ZKb6D8N3+XBiUbtxwXUtQuUu1IeHRaj0NFBgZoIuFWl4/KgaFOT8NoI8COyXFzh9Y1HbsQ9996Hhx/+a5w8eQrTovRB9LgvmIvLiWgc86JK5nVRW/laCvNPfXV1FUfv+Cz+4i+/Pefax6JUn5SQQuB87iTZOShYLSPcFLPxJd+1AQg1g5FVFYhmEqP9OOGq7VcFF66yllYI+Du5DEXA1uiqzURKGz+Cd9PcEJ17Fgqnm/Evt11ZVTh6xzF89atfRZ6bGUAps9Ck0KVKeNESddGORuue9mVOUvhaTK2BvNPFtCjx4osvR5OvEtPJxLq6dSMWQIgtkoVCp7xl+Pwq2KQHihoAABBhSURBVG90Bf+14npjxXeTK1iOMhIaVkcztTS4lf4Vl4elAUDZ3CaXkyQi8Qo7F7o+BikkkDnBtR0gnDsXWUnuHF0wGyY27oVuPJ7YFawjt0+HHDA/aBFl+5vENG9VxqolIaDtdTNjMzWDt9xyK37498/g/fffx+c/fx+EFMFNtGOLO2DMNFAkC4GC1SKEEMjzPNwsgL9B4yB4M1nUiZa9b+3bBITQxl0DUCkNKV16gbGKVGTtuHQJF4+WUtfEap7whQHAlOFoWfcgXezJu3NRyoZLddCyljsmpQyWVLR/GTsDAjBJsSGR1Q/T5ZR5M9BKrxUtIbS9HgrHj9+Fn/3sOezes4qtzS30lga1cxQQ0MKYlC5tgywWClaLqeX9RKLlXC8jULq2jRMvKSWEtpaFEBDCuHtuls55WVqbdAQN+DbBWgFaKCjY3CQAgLKGjQDsTeysNCOORkPiAHjThXNjj5NVta6iGT+7nRecaF/hgR0D3BmY8xR+6hLe3PRJs6Flj4xSRIqyxO1Hj+Lxxx/HxsYGvvJb/9zPgNopBH/8QX+ArTkpGGRnoWC1iKIofIHt3CTFyDWaU21Yix1p2K4POvwtta5pgTFUzE1dVRVcKY+GhlLGQhNCuQMHL86VsAgT+3Euqphj+dXGFk96WnNQOe3T2q/794GLaMTn6QNO4fmmteX354L1EIBfFUijKArcdfe9GA63vHUHxK653bWU9b7vZCFQsFpEVVWhXbElFibtrAkoCNdtweLjW83H1iIRUkTJoeFmNPe1AmCEUinnHlqRagSgzfbaW1dAZAyJ4J7NiKmO/rBjMoZS3UJsvi2cUCRkztoU4X3BkjPjVv6YYazu/S4gr20QXghgbW3Nzyb63fq0kHqZEVkcFKwWEabQZeTZxLErGNcnkoNYqGrxnDn4NADb1yrEvaQXDiFs3aB5EBJGnXsVB/39eOyx52TgN8UXUVA8dhO9oIigkDP65Y4twvF8nEnDxsjq1xLaSLGQQeCdZekWhQVsCkQmvXvqEmBdsi1pBxSsFlFV1fwbPKiTd3O0Ci6UyxHScVx8nm6JSLQid9HupJbj4lyi2CqJhcRZHqJpgvm5u2BJQYTZw1By5E7MxphEFHwPg4iC+MK31UHtaJGfGcWnnOAYlNmDFH6o7nyce+sbJLrurTpk6hvxo4XVBihYLWI4HKHf7/vH5iY1f7sb03UOzWQWTd9HN75zH4Wui5YTqzidwVoq3kqBgNaiJlQ1fAb77BR/7BbWLLLaIHRDcDSa1lRTkpxb60XQnV8kzN6ttbH2OO9MAFCQEEJBahkdSNRc4zjw3zxPZ/Wyr/vioWC1iOl0GtIarIhI5+b5GxGA1qhQIUNmrAEx28gPCG4TEL0oZrdzb/Zi4V3RyP2LXKUQhI8SSt2unMsq9IzoGXdU+niTdw9duoPdKBatmoXnzkO4QdoxuAU2EItMfXMnYDIS92b4rNb7y5YsuTGYSQkK1qKhYLWIza0hgOCKCS2goCHcjWktFBdQViq0Ja7Nvjm0W+bL3HTSPtds0hdi11FZEHy4yBYWOxvHHEvJIKJObFycLU5Oj91YIUMpjzt+ze2NxUrAzEDWXL5Zy7HeaaKe4+UPrTW09ZdVlO7QjAM6QdOALxyPJyfI4qFgtQjThTNSnMhD8bOFEpDW9VFam5bsda/Lu2WheDpyFd1NqJ2OuJsdvsOCy9PyNYI+9mXbryhTTGxu8GAkuRYv5n2N2Ta4122Zjo8TaWib8eVrEePAur0OM5Zi7fxQ0zWXFxYnhjmryyey+skLURtnpUM8q9ftYloUxiWUQWjJ4qBgtYgsk7XWJ3EvK/NtbzK+hRR+sYRYGNx7fNKkFD7oHbtZcb1iuNGNf+YsitAoD5EbJoy1J4wASin9LKErwYnbvEQHrIuJW/hCwwbng9tZs7TicftE08gqg7M8vewi1ikdT1JYoXYiDZj8MV86FLmpLviutUaWZXaZ+i7G4/EFfZ7k0kPBahlOsGqtYWwOkBQCJmwlZpb38mkKzSByg5mZLgEjQvZpV8oT54Npa+ZprSLhQe2GN7V/1o1rHta5XyFmHnYiEOoStQv8ayOKsYXkxg9dt6yisbgDSAFoW4OpFMLJ2c0yKWo1jm5m0LmGsUueaY0KAp1Oju3haOZ6kp2FgtUizEyUbXTn3Lao3QykhPSiFHzBEJg2MR9nLcRLy7ugcpyrVcvtauhYyKhH1B8r4EbgbnhvNUW/Yn3S0WvuiVh4fH8IPSeDPzqouQLaW3bOBjNWl3U1YVI8pNZQUvs20PGajrIh5l7gdTR+Af/FkMmMtYQtgILVIgaDAbZH2+bmsl0F3FS6W55eK2t91DwuJ2JBrHwSpo/9OMcvzK6FaXy3I7N/E+gXUNHso3c14/2jbvHUEldF7GZ9wHJkcJuL5gazqgcrIBq1bhEAfHzPvzc6jlbadx6VsQXo9DJ2Pb07apNZYYQs73Rsb3mySChYLSLPcxRFYTLNZZiuj/On4DQozk8SUYzGiVY8RY8gOnFrl5p76APhCmVlFqXIfGO+yEITxpJT0c61UJAugO1E0I5V2Ij8vLwt7Y7rXmvE2pqGVrAkRciwr6U9ROZdLEq2S0WGqE5TO9GsC7fP+9IhjuaGOZ1SsBYNBatF9Ho9TIvCJjyambi4SZ5LX/D3ogu82xtLu8xuCS8EXiYaLlhswTTr/1wcrVRVfa0+AZtYqmoiqqGhqhDkFyKydtw45uUwWeF1bmCtpc4cYnexZknOQdT+mLNNJGg1a9Fd00wE69Eemy7h4qFgtYg8z+BmzQRgl5EP5SS1Qug458gKRVxTKGwQ/APRqBX1agBO84RoNK1zOVZz9ylqL/jGg6Lu+tUC9kDUmtmUGWVZ5tMn3Pk23+ivwQeJVWy1oaZN9THqINLuOe82Rt8MoRXOHNElOwoFq2V0u51GmYh5PuQRhcC5b2fsrBo7ZW+6M6DmzvmkyoboqVj4gNATS0d5WICZEZR2FtDing+5WiENwmeg+5gZGu9zri1MZ1IpauJhNjlPH/Wm69ig2bWidtxaFvy8AP/sft02MmMe1qKhYLWMLMtqsZPat3xtJgw1KwJAyCcy77CCEQLjTiAgXE6SfV5F6QoiWDoytmIi4WrixEpGLp2A8HWPcTa6AGx+FLzLauLyIf6mEeJI7r3e8opib7XrdB60DfjDu33RRAFmRUvGkwXxda0il5ssDApWC3FZ4z6+pMNjd+O5G1/Y/CwpZS0h0+UymW3jgE0U/4Htd+7yj+zBBRBZeTZK5cXRm1BhvPEt34gNuWC9iqy40NcqLunRvpmgHxtC7aSQwrRJdtaRtTTdbOF8a8mOp5FAWovliTBhUYu9RbE9aa8Di58XDwWrZSwt9VCWJbo9szS6ituaODFxU/vQAEIPp2h6C06mauKEWdHRgM+z8sdw7p3d2sfpvYkW4Q6LaOPoOWHf4spwpM3SF1KgUt7kg/LHFd6a0jpK69ASuuGRmWshIxczxOLcfqWILLboZLx7rEMSbq38KDpP71qz4+jCoWC1jAMHDmBzaxNX9faZJ4KvBp+bab/xMxdo94IR32SAs31iqyUgfG6V8I3s3F6CkLht0bBK4hm9ZnlQHHuqx5PcY+HdKzME5WdCTe6rhoIL+huRUErVYmpeF10FQHz2Dfez3mPMybX2D2pWrICfMKhZkVKg0+mALBYKVss4sH8/Tr7yGvbt3QfYwDqgbVpDlGIAePfQrdjsl9OKA83NjG40Mt1h3amGC6p9s/UodmVFr5Zr5ccTLwfmYlBuuyBOZlfOtGsE/L3bG8W9YqupUvWcKdhs9victa65bq4msp6X5iULElYMhbQJudEK2n57VyZFl3DRULBaxv79+/HYE0/iuk9eB61h2vM660gqbwAAkSWjbSkKZi2dJnMzzAFvqYUupO6GNgJhrBi3BBeASFzCzq315IPiwTE14hNa3bhjxpaYs6J0TSzsOK3V1ZxoMPsLKRx+BjDar7Ti655zOW3CLjqhlIKC7cjQaE8dx7yqqpz9wMiOQsFqGcvLA4y3x5hOzaKeSoUZPVeY7GyO2BULbli0ReQuzsx8AUF05hJC6eftQNqMXbljNvbp4lfuXNR5YkFOtIKghaXj4+iUG5PZBt5tjK9NEEaBUlXeogOASgjkeYaOCH3d3RJo8MJnV8J2aR4AE0dbAAWrZZg+TDlOvfIKOp0OBsvL6OQ5qqrCUr+P5eUVkw+kNZQy3/hZZgp6O7YViorSFADn2ZlFWv1NF0/rzVgtQR5c07/6BtH7Yzcyspicenh31ceoTAuF8ydh6uZwvGDH+5UyttyCM+q2z/PctuvRUGUJAaDb60LKDEpVKMrSCmiwumIzzfRzL/3+O50OpMzOM2ayUwjN9N3WMZ1OcebMWYxGI2xtbaEsjTCNx2NsbGxgPJ7ULIE8z6EqhTzPobXCZDL1opXnOZRSyKTEYHmAsigxtkW8Lsu91+tjdfcqlpeXkee5vdkzL3Qu2B0XTuvIYgGcAdPw5USwmrQ28aRKKUynU0wmE6iqily1UCtpcx0ghMDS0hI6ndx0S4iEzllGUkp0O2bMSmsMh1s4c+YMxtvb0NCYjMcoihJZlqHTyQBYC09rbG4NMZ1OIYTE2toa9u/fj917diPLcps4K7C5sYFTp06hKCa49ZbP4L777r2Mnzz5p6BgfcyZTCY4c+Yszpw5g/WNDSilsLG+gfFkijzL0B/0IaXEcDhEHJ9yrpvWGuPxBDKTyKREt9tBp9MxcSFllgyrlLHqcrtIrNKmM0W32/Uuous2ATh3TKMqS0yLKcqiRFEWgAbKqrK9rCS6nQ6yTCLPM+RZjizPsLZnDw4cOICVFSO+y8vLfnHaeWitMRyN8O7pd/HOO6exvrGOYlpASoksk7hq/34cufFG7N69elk/B/LhoGCRJHDJnXEfe/Lxg4JFCEkGVnMSQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBkoGARQpKBgkUISQYKFiEkGShYhJBk+P/6wth6qlQtggAAAABJRU5ErkJggg==";
        $dataIcon = '<span class="icon_cart et_pb_icon" data-icon=""></span>';
        $selectChooseOptionIcon = '<span class="icon_menu et_pb_icon" data-icon="a"></span>';
        $select_option_text = isset($this->props['dnwoo_select_variable_option']) ? $this->props['dnwoo_select_variable_option'] : '';

        if(count($products) > 0) {
            foreach ($products as $key => $value) {
                # code...
                $image = !empty($value->thumbnail) ? sprintf('background-image: url(%1$s);', $value->thumbnail) : sprintf('background-image: url(%1$s)', $demo_image);

                $product_variant_icon = $this->_add_to_cart($value->ID, $value->get_type, $value->permalink,$show_add_to_cart, $dnwoo_show_add_to_cart_text, $select_option_text, $selectChooseOptionIcon, $dataIcon);

                $description = "on" == $show_desc ? sprintf('<div class="dnwoo_imgaccordion_description">%1$s</div>', $value->post_excerpt) : "";
                $show_star_rating = ( isset( $show_rating ) && 0 < $value->get_rating_count && 'on' === $show_rating ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">'.esc_html__('Rated', 'dnwooe').' <strong class="rating">'.esc_html__('0', 'dnwooe').'</strong> '.esc_html__('out of 5', 'dnwooe').'</span>'.$value->product_rating.'</div></div>' : '');

                $category = "on" === $show_category ? sprintf('<ul class="dnwoo_imgaccordion_categories">%1$s</ul>', $value->category) : '';
                
                $sale_text       =  '' !== $dnwoo_badge_sale ? sprintf('<div class="dnwoo_imgaccordion_onsale">%1$s</div>', esc_html($dnwoo_badge_sale)) : '';

                $percentage_text = '' !== $dnwoo_badge_percentage ? esc_html($dnwoo_badge_percentage) : '';
                $percentage      =  '' !== $value->percentage ?sprintf('<div class="dnwoo_imgaccordion_onsale percent">%1$s %2$s</div>', esc_html($value->percentage), $percentage_text) : '';
                
                
                $on_sale_badge      = ('percentage' == $show_badge && $value->is_on_sale) ? $percentage : (('sale' == $show_badge && $value->is_on_sale) ? $sale_text : '');
                $out_of_stock_badge = 'outofstock' == $value->stock_status && 'off' == $hide_out_of_stock ? sprintf('<div class="dnwoo_imgaccordion_outofstock">%1$s</div>', esc_html($dnwoo_badge_outofstock)) : '';
                $featured_badge     = $value->is_featured && 'outofstock' != $value->stock_status && 'on' == $show_featured_product ? sprintf('<div class="dnwoo_imgaccordion_featured">%1$s</div>', esc_html($dnwoo_badge_featured)) : '';

                $single_product .= sprintf(
                    '<div class="dnwoo_imgaccordion_child woocommerce product_type_%12$s" style="%2$s">
                            <div class="dnwoo_imgaccordion_bg"></div>
                            <div class="dnwoo_imgaccordion_child_content_wrapper">
                                <div class="dnwoo_imgaccordion_conent" data-active-on-load="">
                                    %3$s
                                    <a href="%13$s">
                                        <%11$s class="dnwoo_imgaccordion_title">%1$s</%11$s>
                                    </a>
                                    %6$s
                                    %8$s
                                    %9$s
                                    %10$s
                                    %7$s
                                    <div class="dnwoo_imgaccordion_price">
                                        %4$s
                                    </div>
                                    <div class="dnwoo_imgaccordion_buttons">
                                        %5$s
                                    </div>
                                </div>
                            </div>
                    </div>',
                    $value->post_title,
                    $image,
                    $category,
                    'on' === $show_price_text ? $value->get_price_html : '',
                    'on' === $show_add_to_cart ? $product_variant_icon : '', #5
                    $description,
                    $show_star_rating,
                    $on_sale_badge,
                    $out_of_stock_badge, #9
                    $featured_badge,
                    $tag,
                    $value->get_type,
                    $value->permalink
                );
            }
        }

        $this->apply_css( $render_slug );
        $this->apply_background_css( $render_slug );
        $this->apply_spacing_css( $render_slug );
        return sprintf(
            '<div class="dnwoo_imgaccordion">
                <div class="dnwoo_imgaccordion_wrapper" data-accordion-type="%2$s" data-expand-last-item="%3$s">
                    %1$s
                </div>
            </div>',
            $single_product,
            $accordion_style,
            $expand_last_item
        );
    }

    public function apply_spacing_css( $render_slug ) {
        /**
         * Custom Padding Margin Output
         *
        */
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_accordion_content_wrapper' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_conent',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_accordion_product_name' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_title',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_product_desc' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_description',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_product_rating' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_product_ratting>.star-rating',
                'type'      => 'margin'
            ),
            'dnwoo_accordion_product_price' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_child .dnwoo_imgaccordion_price',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_addtocart' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_child .add_to_cart_button',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_viewcart' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_child .added_to_cart',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_onsalebadge' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_onsale',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_outofstockbadge' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_outofstock',
                'type'      => array('margin','padding')
            ),
            'dnwoo_accordion_featuredbadge' => array(
                'selector'  => '%%order_class%% .dnwoo_imgaccordion_featured',
                'type'      => array('margin','padding')
            ),
        );

        DNWoo_Common::apply_spacing($customMarginPadding, $render_slug, $this->props);
    }

    public function apply_background_css( $render_slug ) {
        $gradient_opt = array(
            // total slug example = sale_badge_color
            'sale_badge_'   => array(
                "desktop" => "%%order_class%%  .dnwoo_imgaccordion_onsale",
                "hover"   => "%%order_class%%  .dnwoo_imgaccordion_onsale:hover",
            ),
            'outofstock_badge_'   => array(
                "desktop" => "%%order_class%% .dnwoo_imgaccordion_outofstock",
                "hover"   => "%%order_class%% .dnwoo_imgaccordion_outofstock:hover",
            ),
            'featured_badge_'   => array(
                "desktop" => "%%order_class%% .dnwoo_imgaccordion_featured",
                "hover"   => "%%order_class%% .dnwoo_imgaccordion_featured:hover",
            ),
            'addtocart_'   => array(
                "desktop" => "%%order_class%%  .add_to_cart_button, %%order_class%%  .dnwoo_choose_variable_option",
                "hover"   => "%%order_class%%  .add_to_cart_button:hover, %%order_class%%  .dnwoo_choose_variable_option:hover",
            ),
            'viewcart_'   => array(
                "desktop" => "%%order_class%% .added_to_cart",
                "hover"   => "%%order_class%% .added_to_cart:hover",
            ),
            'image_overlay_'   => array(
                "desktop" => "%%order_class%% .dnwoo_imgaccordion_child:hover .dnwoo_imgaccordion_bg",
            ),
            'content_'   => array(
                "desktop" => "%%order_class%% .dnwoo_imgaccordion_conent",
                "hover"   => "%%order_class%% .dnwoo_imgaccordion_conent:hover",
            ),
        );
        DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }

    public function apply_css( $render_slug ) {
        $gutter_space_direction = $this->props['accordion_direction'] === "row" ? "right" : "top";
        $css_settings = array(
            // Option slug should be the key
            'accordion_direction'   => array(
                'css'   => 'flex-direction: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_imgaccordion_wrapper",
                ),
            ),
            'accordion_height'   => array(
                'css'   => 'height: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_imgaccordion_wrapper",
                ),
            ),
            'gutter_space'   => array(
                'css'   => 'margin-' . $gutter_space_direction . ': %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_imgaccordion_child",
                ),
            ),
        );
        foreach ($css_settings as $key => $value) {
            DNWoo_Common::set_css($key, $value['css'], $value['selector'], $render_slug, $this);
        }

        $active_image_width                   = $this->props["active_image_width"];
        $active_image_width_responsive_active = isset($this->props["active_image_width_last_edited"]) && et_pb_get_responsive_status($this->props["active_image_width_last_edited"]);
        $active_image_width_tablet            = $active_image_width_responsive_active && $this->props["active_image_width_tablet"] ? $this->props["active_image_width_tablet"] : $active_image_width;
        $active_image_width_phone             = $active_image_width_responsive_active && $this->props["active_image_width_phone"] ? $this->props["active_image_width_phone"] : $active_image_width_tablet;

        // Active image width
        if ('' !== $active_image_width) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_imgaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_imgaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_imgaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
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
            return sprintf('<a href="%1$s" class="dnwoo_imgaccordion_cart_button product_type_variable dnwoo_choose_variable_option">%3$s %2$s</a>',
                $permalink, 
                $select_option_text,
                $chooseOptionIcon
            );
        }
        return sprintf(
            '<a href="%1$s" data-quantity="1" class="dnwoo_imgaccordion_cart_button product_type_%3$s add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button" data-product_id="%2$s">%5$s %4$s</a>',
            sprintf('?add-to-cart=%1$s', $product_id),
            $product_id,
            $product_type,
            'on'=== $show_add_to_cart ? $add_to_cart_text : '',
            $cartIcon
        );
    }
}
new DNWooProductAccordion;