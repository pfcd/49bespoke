<?php

class DNWooCatGrid extends ET_Builder_Module {

	public $slug       = 'dnwoo_cat_grid';
    protected $next_woocarousel_count = 0 ;
	public $vb_support = 'on';
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options;
	public $_original_content;


	protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-category-grid-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

    public function init() {
        $this->name = esc_html__( 'Woo Category Grid', 'dnwooe' );
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

        $this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles('dnwoo_cat_grid');

        $this->settings_modal_toggles['advanced']['toggles']['grid_settings'] = esc_html__( 'Grid', 'dnwooe');
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
        $this->settings_modal_toggles['advanced']['toggles']['item_settings'] = esc_html__( 'Category Settings', 'dnwooe');

        $this->advanced_fields = array(
            'text'  => false,
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
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
                        ),
                    ),
                ),
                'cat_single' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_cate_grid_item',
							'border_styles' => '%%order_class%% .dnwoo_product_cate_grid_item',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Category Single', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'item_settings',
                ),
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_product_cate_grid_thumbnail img',
							'border_styles' => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_product_cate_grid_thumbnail img',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_grid_image_settings',
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
            ),
            'box_shadow' => array(
                'default' => array(
                    'css'          => array(
                        'main' => '%%order_class%%',
                        'important' => 'all'
                    ),
                ),
                'cat_single' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_item',
                        'important' => 'all'
                    ),
                    'label' => esc_html__( 'Category Single Box Shadow', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'item_settings',
                ),
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_product_cate_grid_thumbnail img',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_grid_image_settings',
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
                    'toggle_slug' 	=> 'dnwoo_cat_grid_image_settings',
                    'label'         => esc_html__( 'Image', 'dnwooe' ),
                    'cat_grid_image' => array(
                        'css'           => array(
                            'main' 	=> '%%order_class%% .dnwoo_product_cate_grid_item img',
                            'hover' => '%%order_class%%:hover .dnwoo_product_cate_grid_item img',
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
                'label'            => esc_html__('Category Count', 'dnwooe'),
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
                'label'            => esc_html__('Category Offset', 'dnwooe'),
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
            'dnwoo_cat_grid_image_height'	=> array(
				'label'           	=> esc_html__( 'Image Height', 'dnwooe' ),
				'description'     	=> esc_html__( 'Adjust the height of the image within the woocarousel.', 'dnwooe' ),
				'type'            	=> 'range',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnwoo_cat_grid_image_settings',
                'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default_unit'    	=> 'px',
                'default'           => '300px',
                'default_on_front'  => '300px',
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 400,
				),
				'hover'             => 'tabs',
			),
            '__nextwoocatdata'    => array(
                'type'                => 'computed',
                'computed_callback'   => array('DNWooCatGrid', 'get_products'),
                'computed_depends_on' => array(
                    'hide_empty',
                    'thumbnail_size',
                    'order',
                    'category_number',
                    'include_categories',
                    'orderby',
                    'offset'
                ),
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
            'display_stack' => array(
                'label'           => esc_html__( 'Category Name Stacked', 'dnwooe' ),
                'description'     => esc_html__( 'Display product categorey count in the bottom of category name.', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'off',
                'default_on_front'         => 'off',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'display_setting',
            ),
        );

        $margin_padding = array(
            'dnwoo_cat_grid_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_name_margin'	=> array(
				'label'           		=> esc_html__('Category Name Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_name_padding'	=> array(
				'label'           		=> esc_html__('Category Name Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_count_margin'	=> array(
				'label'           		=> esc_html__('Product Count Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_count_padding'	=> array(
				'label'           		=> esc_html__('Product Count Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_image_margin'	=> array(
				'label'           		=> esc_html__('Product Image Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_grid_product_image_padding'	=> array(
				'label'           		=> esc_html__('Product Image Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
        );

        $grid = array(
            'dnwoo_cat_grid_number'	=> array(
				'label'           	=> esc_html__( 'Grid Number', 'dnwooe' ),
				'description'     	=> esc_html__( 'Choose the number which you want to show in grid.', 'dnwooe' ),
				'type'            	=> 'range',
                'tab_slug'          => 'advanced',
				'toggle_slug'     	=> 'grid_settings',
                'fixed_unit'     	=> false,
                'unitless'          => true,
                'default'           => 4,
				'range_settings'    => array(
					'min'  => 1,
					'step' => 1,
					'max'  => 10,
				),
                'mobile_options'   => true,
                'responsive'       => true
			),
            'dnwoo_cat_grid_gap'	=> array(
				'label'           	=> esc_html__( 'Grid Gap', 'dnwooe' ),
				'description'     	=> esc_html__( 'Choose the grid gap.', 'dnwooe' ),
				'type'            	=> 'range',
                'tab_slug'          => 'advanced',
				'toggle_slug'     	=> 'grid_settings',
                'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default_unit'    	=> 'px',
                'default'           => '30px',
                'default_on_front'  => '30px',
				'range_settings'    => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 1000,
				),
                'mobile_options'   => true,
                'responsive'       => true
			),
        );

        $opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $content_bg_color    = DNWoo_Common::background_fields($this, "content_", "Background Color", "dnwoo_content_bg", "general", $opt);
        return array_merge( $fields, $show_hide, $content_bg_color, $margin_padding, $grid );
    }
    public static function get_products() {
        return '';
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}
        wp_enqueue_style('dnwoo_cat_grid');

        $products_number    = $this->props['category_number'];
        $order              = $this->props['order'];
        $orderby            = $this->props['orderby'];
        $include_categories = $this->props['include_categories'];
        $hide_empty         = $this->props['hide_empty'];
        $thumbnail_size     = $this->props['thumbnail_size'];
        $offset             = $this->props['offset'];
        $show_thumbnail     = "on" == $this->props['show_thumbnail'];
        $show_product_count = "on" == $this->props['show_product_count'];
        $is_name_stacked    = "on" == $this->props['display_stack'] ? 'dnwoo_product_cate_grid_stack' : '';

        $settings = array(
            'products_number'    => $products_number,
            'order'              => $order,
            'orderby'            => $orderby,
            'include_categories' => $include_categories,
            'hide_empty'         => $hide_empty,
            'thumbnail_size'     => $thumbnail_size,
            'offset'             => $offset,
            'request_from'       => 'frontend'
        );
        $categories = dnwoo_get_category($settings);
        $post       = '';

        if(count($categories) > 0) {
            foreach ($categories as $key => $value) {
                # code...
                $image = (!empty($value->image) && $show_thumbnail) ? sprintf('<a href="%2$s"><img src="%1$s" alt="%3$s"></a>', $value->image, $value->link, $value->name) : '<div class="dnwoo_cat_no_image"></div>';
                $count = (!empty($value->count) && $show_product_count) ? sprintf('<span class="dnwoo_product_cate_grid_count %2$s">(%1$s)</span>', $value->count, $is_name_stacked) : '';

                $post .= sprintf(
                    '<div class="dnwoo_product_cate_grid_item">
                        <div class="dnwoo_product_cate_grid_item_inner">
                            <div class="dnwoo_product_cate_grid_thumbnail">
                                %1$s
                                <a href="%3$s">
                                    <div class="dnwoo_product_cate_grid_content_inner">
                                        <h3 class="dnwoo_product_cate_grid_title">
                                            %4$s%2$s
                                        </h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>',
                    $image,
                    $count,
                    $value->link,
                    $value->name
                );
            }
        }

        $this->apply_background_css( $render_slug );
        $this->apply_css( $render_slug );
        $this->apply_spacing_css( $render_slug );
        return sprintf(
            '<div class="dnwoo_product_cate_grid_wrapper_layout_one">
                %1$s
            </div>',
            $post
        );
    }

    public function apply_spacing_css( $render_slug ) {
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_cat_grid_content_wrapper' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_content_inner',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_grid_product_name' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_product_cate_grid_title',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_grid_product_count' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_count',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_grid_product_image' => array(
                'selector'  => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one
                .dnwoo_product_cate_grid_thumbnail
                img',
                'type'      => array('margin','padding') //
            ),
        );

        DNWoo_Common::apply_spacing($customMarginPadding, $render_slug, $this->props);
    }

    public function apply_css( $render_slug ) {

        $css_settings  = array(
            // Option slug should be the key
            'dnwoo_cat_grid_gap' => array(
                'css'   => 'grid-gap: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one",
                ),
            ),
            'dnwoo_cat_grid_image_height' => array(
                'css'   => 'height: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_product_cate_grid_thumbnail img, %%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one .dnwoo_cat_no_image",
                ),
            )
        );


        foreach ($css_settings as $key => $value) {
            DNWoo_Common::set_css($key, $value['css'], $value['selector'], $render_slug, $this);
        }
        // Image filter css

        DNWoo_Common::set_image_filter('cat_grid_image', $this, $render_slug);

        //
        $dnwoo_cat_grid_number                   = $this->props["dnwoo_cat_grid_number"];
        $dnwoo_cat_grid_number_responsive_active = isset($this->props["dnwoo_cat_grid_number_last_edited"]) && et_pb_get_responsive_status($this->props["dnwoo_cat_grid_number_last_edited"]);
        $dnwoo_cat_grid_number_tablet            = $dnwoo_cat_grid_number_responsive_active && isset($this->props["dnwoo_cat_grid_number_tablet"]) ? $this->props["dnwoo_cat_grid_number_tablet"] : $dnwoo_cat_grid_number;
        $dnwoo_cat_grid_number_phone             = $dnwoo_cat_grid_number_responsive_active && isset($this->props["dnwoo_cat_grid_number_phone"]) ? $this->props["dnwoo_cat_grid_number_phone"] : 1;

        //Width of grid items
        if ('' !== $dnwoo_cat_grid_number) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one',
                'declaration' => sprintf('grid-template-columns: repeat(%1$s, 1fr) !important;', $dnwoo_cat_grid_number),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one',
                'declaration' => sprintf('grid-template-columns: repeat(%1$s, 1fr) !important;', $dnwoo_cat_grid_number_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_product_cate_grid_wrapper_layout_one',
                'declaration' => sprintf('grid-template-columns: repeat(%1$s, 1fr) !important;', $dnwoo_cat_grid_number_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
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
}
new DNWooCatGrid;