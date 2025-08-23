<?php

class DNWooCatCarousel extends ET_Builder_Module {

	public $slug       = 'dnwoo_cat_carousel';
    protected $next_woocarousel_count = 0 ;
	public $vb_support = 'on';
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 


    protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-category-carousel-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

    public function init() {
        $this->name = esc_html__( 'Woo Category Carousel', 'dnwooe' );
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

        $this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles('dnwoo_cat_carousel');

        $this->settings_modal_toggles['advanced']['toggles']['product_settings'] = array(
            'title'             =>  esc_html__( 'Category', 'dnwooe'),
            // 'priority'	        =>	78,
            'sub_toggles'       => array(
                'product_name'   => array(
                    'name' => esc_html__('Name', 'dnwooe')
                ),
                'product_count'   => array(
                    'name' => esc_html__('Count', 'dnwooe')
                )
            ),
            'tabbed_subtoggles' => true,
        );

        $this->advanced_fields = array(
            'text' => false,
            'fonts'        => array(
                'name' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_title',
                        'text_align' => '%%order_class%% .dnwoo_product_cate_grid_title',
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'    => 'product_name',
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
                'count' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_count',
                        'important' => 'all'
                    ),
                    'hide_text_align'   => true,
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'    => 'product_count',
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
            'borders'   => array(
                'default' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .swiper-slide',
							'border_styles' => '%%order_class%% .swiper-slide',
                        ),
                    ),
                ),
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_cate_grid_carousel_layout_one .dnwoo_product_cate_grid_thumbnail img',
							'border_styles' => '%%order_class%% .dnwoo_product_cate_grid_carousel_layout_one .dnwoo_product_cate_grid_thumbnail img',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_carousel_image_settings',
                ),
                'content_wrapper'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
							'border_styles' => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Content Wrapper', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'product_settings',
                    'sub_toggle'   => 'product_name'
                ),
                'arrow'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next',
							'border_styles'  => '%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Arrow', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_carousel_arrow_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .swiper-slide',
                        'important' => 'all'
                    ),
                ),
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_carousel_layout_one .dnwoo_product_cate_grid_thumbnail img',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_carousel_image_settings',
                ),
                'content_wrapper_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Product', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'product_settings',
                    'sub_toggle'   => 'product_name'
                ),
            ),
            'filters' => array(
                'child_filters_target' => array(
                    'tab_slug' 		=> 'advanced',
                    'toggle_slug' 	=> 'dnwoo_cat_carousel_image_settings',
                    'label'         => esc_html__( 'Image', 'dnwooe' ),
                    'cat_carousel_image' => array(
                        'css'           => array(
                            'main' 	=> '%%order_class%% .swiper-slide .dnwoo_product_cate_grid_item_inner img',
                            'hover' => '%%order_class%% .swiper-slide:hover .dnwoo_product_cate_grid_item_inner img',
                        ),
                    )
                ),
            ),
            'height'    => false
        );
        $this->custom_css_fields = array(
            'product_name'   => array(
                'label' => esc_html__('Category Name', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_cate_grid_title',
            ),
            'product_count'   => array(
                'label' => esc_html__('Product Count', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_cate_grid_count',
            ),
            'content_wrapper'   => array(
                'label' => esc_html__('Content Wrapper', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
            )
        );
    }

    public function get_fields() {

        $fields = array(
            'show_sub_categories' => array(
				'label'            => esc_html__( 'Show Sub Categories', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Here you can choose whether the sub categories will be shown or not.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwoocatdata',
                ),
            ),
            'hide_empty' => array(
                'label'            => esc_html__( 'Hide Empty Category', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Hide empty category from the loop.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwoocatdata',
                ),
            ),
            'thumbnail_size' => array(
                'label'            => esc_html__( 'Thumbnail Size', 'dnwooe' ),
                'description'      => esc_html__( 'Here you can specify the size of category image.', 'dnwooe' ),
                'type'             => 'select',
                'options'          => array(
                    'full'	=> esc_html__( 'Full', 'dnwooe' ),
                    'woocommerce_thumbnail'	=> esc_html__( 'Woocommerce Thumbnail', 'dnwooe' ),
                    'woocommerce_single'	=> esc_html__( 'Woocommerce Single', 'dnwooe' ),
                ),
                'default'          => 'woocommerce_thumbnail',
                'default_on_front' => 'woocommerce_thumbnail',
                'show_if'      	   => array(
                    'show_thumbnail' => 'on',
                ),
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
                'computed_affects' => array(
                    '__nextwoocatdata',
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
                ),
                'toggle_slug'      => 'main_content',
                'description'      => esc_html__( 'Select Categories. If no category is selected, products from all categories will be displayed.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwoocatdata',
                ),
            ),
            'category_number'      => array(
                'label'            => esc_html__('Category Count', 'dnwoo-divi-essential'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__( 'Define the number of category that should be displayed per page.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwoocatdata',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => 10,
            ),
            'offset'      => array(
                'label'            => esc_html__('Category Offset', 'dnwoo-divi-essential'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__( 'Define the number of category that should be cut down from first.', 'dnwooe' ),
                'computed_affects' => array(
                    '__nextwoocatdata',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => '',
            ),
            'order'                  => array(
				'label'            => esc_html__( 'Sorted By', 'dnwoo-divi-essential' ),
				'description'      => esc_html__( 'Choose how your posts should be sorted.', 'dnwoo-divi-essential' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'default'          => 'ASC',
				'options'          => array(
					'ASC'  => esc_html__( 'Ascending', 'dnwoo-divi-essential' ),
					'DESC' => esc_html__( 'Descending', 'dnwoo-divi-essential' ),
				),
				'default_on_front' => 'ASC',
				'computed_affects' => array( '__nextwoocatdata' ),
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
                    '__nextwoocatdata',
                )
            ),
            'dnwoo_cat_carousel_image_height'	=> array(
				'label'           	=> esc_html__( 'Image Height', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the height of the image within the woocarousel.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_cat_carousel_image_settings',
                'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'           => '300px',
                'default_on_front'  => '300px',
				'default_unit'    	=> 'px',
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 400,
				),
				'hover'             => 'tabs',
			),

            '__nextwoocatdata'    => array(
                'type'                => 'computed',
                'computed_callback'   => array('DNWooCatCarousel', 'get_products'),
                'computed_depends_on' => array(
                    'hide_empty',
                    'order',
                    'category_number',
                    'include_categories',
                    'orderby',
                    'thumbnail_size',
                    'offset'
                ),
            ),
        );

        $margin_padding = array(
            'dnwoo_cat_carousel_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_name_margin'	=> array(
				'label'           		=> esc_html__('Category Name Margin', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_name_padding'	=> array(
				'label'           		=> esc_html__('Category Name Padding', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_count_margin'	=> array(
				'label'           		=> esc_html__('Product Count Margin', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_count_padding'	=> array(
				'label'           		=> esc_html__('Product Count Padding', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_image_margin'	=> array(
				'label'           		=> esc_html__('Category Image Margin', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_carousel_product_image_padding'	=> array(
				'label'           		=> esc_html__('Category Image Padding', 'dnwoo-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
        );

        $show_hide = array(
            'show_product_count' => array(
                'label'           => esc_html__( 'Show Product Count', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'on',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'display_setting',
                'description'     => esc_html__( 'Choose whether or not show the product count number should be visible.', 'dnwooe' ),
            ),
            'display_stack' => array(
                'label'            => esc_html__( 'Category Name Stacked', 'dnwooe' ),
                'description'      => esc_html__( 'Show product count in the bottom of product category name.', 'dnwooe' ),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'display_setting',
            ),
            'show_thumbnail' => array(
                'label'           => esc_html__( 'Show Image', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'on',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'display_setting',
                'description'     => esc_html__( 'Choose whether or not show the product image should be visible.', 'dnwooe' ),
            ),
        );

        $opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        // $img_overlay_opt = array(
        //     'description'           => esc_html__('Add an overlay background fill color or gradient on top of the image', 'dnwooe'),
        // );
        $content_bg_color    = DNWoo_Common::background_fields($this, "content_", "Background Color", "dnwoo_content_bg", "general", $opt);
        // $image_overlay_bg    = DNWoo_Common::background_fields($this, "image_overlay_", "Image Overlay Background", "dnwoo_cat_carousel_image_settings", "advanced",$img_overlay_opt);

        $wooCarousel_settings        = WooCommonSettings::carousel_settings('dnwoo_cat_carousel', 'dnwoo_cat_carousel');
        $wooCarousel_effect_settings = WooCommonSettings::carousel_effect('dnwoo_cat_carousel', 'dnwoo_cat_carousel');
        $wooCarousel_navigation      = WooCommonSettings::carousel_navigation('dnwoo_cat_carousel', 'dnwoo_cat_carousel');
        return array_merge(
            $fields,
            $show_hide,
            $wooCarousel_settings,
            $wooCarousel_effect_settings,
            $wooCarousel_navigation,
            $margin_padding,
            $content_bg_color
        );
    }

    public static function get_products() {
        return '';
    }
    public function callingScriptAndStyles() {
        wp_enqueue_style('dnwoo_cat_carousel');
        wp_enqueue_script('dnwoo-cat-carousel');
        wp_script_is( 'dnext_isotope', 'enqueued' ) ? wp_enqueue_script( 'dnext_isotope' ) : wp_enqueue_script( 'dnwoo_swiper_frontend' );
		wp_style_is( 'dnext_swiper-min', 'enqueued' ) ? wp_enqueue_style( 'dnext_swiper-min') : wp_enqueue_style( 'dnwoo_swiper-min' );
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}

        $this->callingScriptAndStyles();

        $products_number    = $this->props['category_number'];
        $order              = $this->props['order'];
        $orderby            = $this->props['orderby'];
        $thumbnail_size     = $this->props['thumbnail_size'];
        $include_categories = $this->props['include_categories'];
        $hide_empty         = $this->props['hide_empty'];
        $offset             = $this->props['offset'];
        $show_thumbnail     = "on" == $this->props['show_thumbnail'];
        $show_product_count = "on" == $this->props['show_product_count'];
        $is_name_stacked    = "on" == $this->props['display_stack'] ? 'dnwoo_product_cate_grid_stack' : '';
        // slider options
        $auto_height                               = $this->props['dnwoo_cat_carousel_auto_height'];
        $speed                                     = $this->props['dnwoo_cat_carousel_speed'];
        $centered                                  = $this->props['dnwoo_cat_carousel_centered'];
        $autoplay_show_hide                        = $this->props['dnwoo_cat_carousel_autoplay_show_hide'];
        $autoplay_delay                            = $this->props['dnwoo_cat_carousel_autoplay_delay'];
        $grab                                      = $this->props['dnwoo_cat_carousel_grab'];
        $loop                                      = $this->props['dnwoo_cat_carousel_loop'];
        $keyboard_enable                           = $this->props['dnwoo_cat_carousel_keyboard_enable'];
        $mousewheel_enable                         = $this->props['dnwoo_cat_carousel_mousewheel_enable'];
        $pause_on_hover                            = $this->props['dnwoo_cat_carousel_pause_on_hover'];
        $slide_shadow                              = $this->props['dnwoo_cat_carousel_slide_shadows'];
        $slide_rotate                              = $this->props['dnwoo_cat_carousel_slide_rotate'];
        $slide_stretch                             = $this->props['dnwoo_cat_carousel_slide_stretch'];
        $slide_depth                               = $this->props['dnwoo_cat_carousel_slide_depth'];
        $dnwoo_cat_carousel_breakpoint             = $this->props['dnwoo_cat_carousel_breakpoint'];
        $dnwoo_cat_carousel_breakpoint_tablet      = $this->props['dnwoo_cat_carousel_breakpoint_tablet'];
        $dnwoo_cat_carousel_breakpoint_phone       = $this->props['dnwoo_cat_carousel_breakpoint_phone'];
        $dnwoo_cat_carousel_breakpoint_last_edited = $this->props['dnwoo_cat_carousel_breakpoint_last_edited'];
        if ( '' !== $dnwoo_cat_carousel_breakpoint_tablet || '' !== $dnwoo_cat_carousel_breakpoint_phone || '' !== $dnwoo_cat_carousel_breakpoint ) {
			$is_responsive = et_pb_get_responsive_status( $dnwoo_cat_carousel_breakpoint_last_edited );

			$carousel_breakpoint_show_values = array(
				'desktop' => $dnwoo_cat_carousel_breakpoint,
				'tablet'  => $is_responsive ? $dnwoo_cat_carousel_breakpoint_tablet : '',
				'phone'   => $is_responsive ? $dnwoo_cat_carousel_breakpoint_phone : '',
			);
        }
        $dnwoo_cat_carousel_spacebetween              = $this->props['dnwoo_cat_carousel_spacebetween'];
        $dnwoo_cat_carousel_spacebetween_tablet       = $this->props['dnwoo_cat_carousel_spacebetween_tablet'];
        $dnwoo_cat_carousel_spacebetween_phone        = $this->props['dnwoo_cat_carousel_spacebetween_phone'];
        $dnwoo_cat_carousel_spacebetween_last_edited  = $this->props['dnwoo_cat_carousel_spacebetween_last_edited'];

		if ( '' !== $dnwoo_cat_carousel_spacebetween_tablet || '' !== $dnwoo_cat_carousel_spacebetween_phone || '' !== $dnwoo_cat_carousel_spacebetween ) {
			$is_responsive = et_pb_get_responsive_status( $dnwoo_cat_carousel_spacebetween_last_edited );

			$carousel_spacebetween_values = array(
				'desktop' => $dnwoo_cat_carousel_spacebetween,
				'tablet'  => $is_responsive ? $dnwoo_cat_carousel_spacebetween_tablet : '',
				'phone'   => $is_responsive ? $dnwoo_cat_carousel_spacebetween_phone : '',
			);
        }
        $pagination_type         = $this->props['dnwoo_cat_carousel_pagination_type'];
        $pagination_bullets      = $pagination_type === 'bullets' ? $this->props['dnwoo_cat_carousel_pagination_bullets'] : "off";
        $pagination_clickable    = $pagination_type === 'bullets' ? $this->props['dnwoo_cat_carousel_pagination_clickable'] : "false";

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
            data-mouse="%23$s"
            ',
			esc_attr( $auto_height ),
			esc_attr( $speed ),
			esc_attr( $centered ),
			esc_attr( $autoplay_show_hide ),
			esc_attr( $autoplay_delay ), // #5
			esc_attr( $dnwoo_cat_carousel_breakpoint ),
			'' !== $carousel_breakpoint_show_values['tablet'] ? esc_attr( $carousel_breakpoint_show_values['tablet'] ) : 1,
			'' !== $carousel_breakpoint_show_values['phone'] ? esc_attr( $carousel_breakpoint_show_values['phone'] ) : 1,
			esc_attr( $dnwoo_cat_carousel_spacebetween ),
            '' !== $carousel_spacebetween_values['tablet'] ? esc_attr( $carousel_spacebetween_values['tablet'] ) : 1,
            '' !== $carousel_spacebetween_values['phone'] ? esc_attr( $carousel_spacebetween_values['phone'] ) : 1,
			esc_attr( $grab ),// #12
			esc_attr( $loop ),
			esc_attr( $keyboard_enable ),
            esc_attr( $pagination_type ),
            esc_attr( $pagination_bullets ),
            esc_attr( $pagination_clickable ),
            esc_attr( $pause_on_hover ),
            esc_attr( $slide_shadow ),
            esc_attr( $slide_rotate ),
            esc_attr( $slide_stretch ),
            esc_attr( $slide_depth ),
            esc_attr( $mousewheel_enable )
		);

        // PAGINATION CLASSES
        $pagination_class = "swiper-pagination ";
        if( $pagination_type === "bullets" && $pagination_bullets === "on"){
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-bullets-dynamic mt-10";
        }else if($pagination_type === "bullets") {
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets mt-10";
        }else if($pagination_type === "fraction") {
            $pagination_class .= "swiper-pagination-fraction";
        }else if($pagination_type === "progressbar") {
            $pagination_class .= "swiper-pagination-progressbar";
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        $position_container  = "";
        $arrow_position_string = $this->props['dnwoo_cat_carousel_arrow_position'];
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

        $arrow_top_bottom = substr($arrow_position_string, 0,3) === "top" ? "arrow-position-top" : "arrow-position-bottom";

        if(substr($arrow_position_string, -strlen("left")) === "left") {
            $arrow_left_right_center = "multi-position-button-left";
        }elseif(substr($arrow_position_string, -strlen("center")) === "center") {
            $arrow_left_right_center = "multi-position-button-center";
        }elseif(substr($arrow_position_string, -strlen("right")) === "right") {
            $arrow_left_right_center = "multi-position-button-right";
        }

        if("off" !== $this->props['dnwoo_cat_carousel_arrow_navigation']) {
            if($arrow_position_string === 'inner'){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_cat_carousel_arrows_inner_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnwoo_cat_carousel_arrows_inner_right" data-icon="next"></div>'
                );
            }else if($arrow_position_string === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_cat_carousel_arrows_outer_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnwoo_cat_carousel_arrows_outer_right" data-icon="next"></div>'
                );
            }elseif($arrow_position_string === "default"){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnwoo_cat_carousel_arrows_default_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnwoo_cat_carousel_arrows_default_right" data-icon="next"></div>'
                );
            }elseif(in_array($arrow_position_string, $arrow_position)) {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-container multi-position-button-container %1$s">
                        <div class="swiper-button-prev multi-position-button" data-icon="prev"></div>
                        <div class="swiper-button-next multi-position-button" data-icon="next"></div>
                    </div>',
                    $arrow_left_right_center
                );
            }
        }

        $settings = array(
            'products_number'    => $products_number,
            'order'              => $order,
            'orderby'            => $orderby,
            'include_categories' => $include_categories,
            'hide_empty'         => $hide_empty,
            'offset'             => $offset,
            'thumbnail_size'     => $thumbnail_size,
            'show_sub_categories' => $this->props['show_sub_categories'],
            'request_from'       => 'frontend'
        );
        $categories = dnwoo_get_category($settings);

        $post = '';

        if(count($categories) > 0) {
            $post .= '<div class="swiper-wrapper">';
            foreach ($categories as $key => $value) {
                $image = (!empty($value->image) && $show_thumbnail) ? sprintf('<a href="%2$s"><img src="%1$s" alt="%3$s"></a>', $value->image, $value->link, $value->name) : '<div class="dnwoo_cat_no_image"></div>';
                $count = (!empty($value->count) && $show_product_count) ? sprintf('<span class="dnwoo_product_cate_grid_count %2$s">(%1$s)</span>', $value->count, $is_name_stacked) : '';
                $post .= sprintf(
                    '<div class="swiper-slide dnwoo_product_cate_grid_carousel_layout_one">
                        <div class="dnwoo_product_cate_grid_item_inner">
                            <div class="dnwoo_product_cate_grid_thumbnail">
                                %1$s
                            </div>
                            <a href="%2$s">
                                <div class="dnwoo_product_cate_grid_content">
                                    <div class="dnwoo_product_cate_grid_content_inner">
                                        <h3 class="dnwoo_product_cate_grid_title">
                                        %3$s%4$s
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>',
                    $image,
                    $value->link,
                    $value->name,
                    $count
                );
            }
            $post .= '</div>';
        }

        $this->apply_spacing_css( $render_slug );
        $this->apply_background_css( $render_slug );
        $this->apply_css( $render_slug );

        return sprintf(
            '<div class="dnwoo_cat_carousel_container %5$s %6$s">
                <div class="swiper-container dnwoo_product_cate_grid_carousel_active mb-30" %2$s>
                    %1$s
                    <div class="%3$s"></div>
                </div>
                %4$s
            </div>',
            $post,
            $slide_option,
            $pagination_class,
            $arrowsClass,
            $position_container, // 5
            $arrow_top_bottom
        );
    }

    public function apply_spacing_css( $render_slug ) {
        $customMarginPadding = array(
            // option slug and array key should be same
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_cat_carousel_content_wrapper' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_carousel_product_name' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_title a',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_carousel_product_count' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_count',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_carousel_product_image' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_carousel_layout_one
                .dnwoo_product_cate_grid_thumbnail
                img',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_carousel_arrow' => array(
                'selector'  => '%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev',
                'type'      => array('margin','padding') //
            ),
        );

        DNWoo_Common::apply_spacing($customMarginPadding, $render_slug, $this->props);
    }

    public function apply_background_css( $render_slug ) {
        // Content Background
        $content_bg_color = array(
            'color_slug' => 'content_bg_color',
        );
        $use_color_gradient = $this->props['content_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'content_bg_color_gradient_type',
            "gradient_direction"      => 'content_bg_color_gradient_direction',
            "radial"                  => 'content_bg_color_gradient_direction_radial',
            "gradient_start"          => 'content_bg_color_gradient_start',
            "gradient_end"            => 'content_bg_color_gradient_end',
            "gradient_start_position" => 'content_bg_color_gradient_start_position',
            "gradient_end_position"   => 'content_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'content_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnwoo_product_cate_grid_content_inner",
            "hover"   => "%%order_class%% .dnwoo_product_cate_grid_content_inner:hover",
        );
        DNWoo_Common::apply_bg_css($render_slug, $this, $content_bg_color, $use_color_gradient, $gradient, $css_property);
    }

    public function apply_css( $render_slug ) {
        // item image width start
        $image_hieght_css_property = 'height: %1$s !important;';
        $image_hieght_css_selector = array(
            'desktop' => "%%order_class%% .dnwoo_product_cate_grid_carousel_layout_one .dnwoo_product_cate_grid_thumbnail img, %%order_class%% .dnwoo_product_cate_grid_carousel_layout_one .dnwoo_cat_no_image",
        );
        DNWoo_Common::set_css("dnwoo_cat_carousel_image_height", $image_hieght_css_property, $image_hieght_css_selector, $render_slug, $this);
        // item image width end

        // Image filter css
        DNWoo_Common::set_image_filter('cat_carousel_image', $this, $render_slug);

        // Arrow Color
        $arrow_color_order_class = '%%order_class%% .swiper-button-prev:after,%%order_class%% .swiper-button-next:after';
		$dnwoo_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_cat_carousel_arrow_color');
		et_pb_responsive_options()->generate_responsive_css($dnwoo_arrow_color_values, $arrow_color_order_class, 'color', $render_slug, '', 'color');

        // Arrow BG Color
        $arrow_bg_order_class = '%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next';
		$dnwoo_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnwoo_cat_carousel_arrow_background_color');
		et_pb_responsive_options()->generate_responsive_css($dnwoo_arrow_color_values, $arrow_bg_order_class, 'background-color', $render_slug, '', 'background-color');

        // wooCarousel ARROW COLOR END

        // wooCarousel ARROW SIZE START
        $dnwoo_cat_carousel_arrow_size = (int) $this->props['dnwoo_cat_carousel_arrow_size'];
        $arrow_width = $dnwoo_cat_carousel_arrow_size+10;
        $dnwoo_cat_carousel_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnwoo_cat_carousel_arrow_size));
        $dnwoo_cat_carousel_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => $dnwoo_cat_carousel_arrow_size_style,
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnwoo_cat_carousel_arrow_background_width_height,
        ) );
        // wooCarousel ARROW SIZE END

        // DOTS COLOR START
        $dnwoo_cat_carousel_dots_color        = $this->props['dnwoo_cat_carousel_dots_color'];
        $dnwoo_cat_carousel_dots_active_color = $this->props['dnwoo_cat_carousel_dots_active_color'];

        $dnwoo_cat_carousel_dots_color        = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_cat_carousel_dots_color));
        $dnwoo_cat_carousel_dots_active_color = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_cat_carousel_dots_active_color));


        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
        'declaration' => $dnwoo_cat_carousel_dots_color,
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
        'declaration' => $dnwoo_cat_carousel_dots_active_color,
        ) );

        // PROGRESSBAR FILL COLOR START
        $dnwoo_cat_carousel_progressbar_color = $this->props['dnwoo_cat_carousel_progressbar_fill_color'];
        $dnwoo_cat_carousel_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnwoo_cat_carousel_progressbar_color));
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnwoo_cat_carousel_progressbar_color_style,
        ) );
    }
}

new DNWooCatCarousel;