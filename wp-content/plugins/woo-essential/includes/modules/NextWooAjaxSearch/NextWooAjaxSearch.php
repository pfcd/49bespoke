<?php
class NextWooAjaxSearch extends ET_Builder_Module {
    public $slug = 'dnwoo_ajax_search';
    public $vb_support = 'on';
    protected $use_masonry = false;
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 

    protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-ajax-search-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

    public function init() {
        $this->name = esc_html__('Woo Ajax Search', 'dnwooe');
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'configuration' => esc_html__('Configuration', 'dnwooe'),
                    'search_area' => esc_html__('Search Area', 'dnwooe'),
                    'display' => esc_html__('Display', 'dnwooe'),
                    'category' => esc_html__('Category', 'dnwooe'),
                    'scrollbar' => esc_html__('Scrollbar', 'dnwooe'),
                    'link' => esc_html__('Link', 'dnwooe'),
                )
            ),
            'advanced' => array(
                'toggles' => array(
                    'search_field' => esc_html__( 'Search Field', 'dnwooe' ),
                    'search_result' => array(
                        'title' => esc_html__( 'Search Result Texts', 'dnwooe' ),
                        'sub_toggles' => array(
                            'title' => array(
                                'name' => esc_html__('Title', 'dnwooe'),
                            ),
                            'excerpt' => array(
                                'name' => esc_html__('Excerpt', 'dnwooe'),
                            ),
                            'price' => array(
                                'name' => esc_html__('Price', 'dnwooe'),
                            ),
                            'noresult' => array(
                                'name' => esc_html__('No Result', 'dnwooe'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'search_button' => esc_html__('Search Button', 'dnwooe'),
                    'icons' => array(
                        'title' => esc_html__('Search Icon & Loader', 'dnwooe'),
                        'sub_toggles' => array(
                            'search' => array(
                                'name' => esc_html__('Search Icon', 'dnwooe'),
                            ),
                            'loader' => array(
                                'name' => esc_html__('Loader', 'dnwooe'),
                            )
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'category_section' => array(
                        'title' => esc_html__('Category', 'dnwooe'),
                        'sub_toggles' => array(
                            'selected' => array(
                                'name' => esc_html__('Selected', 'dnwooe'),
                            ),
                            'list' => array(
                                'name' => esc_html__('List', 'dnwooe'),
                            ),
                            'icon' => array(
                                'name' => esc_html__('Icon', 'dnwooe'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'feature_image' => esc_html__('Feature Image', 'dnwooe'),
                    'badge_rating' => array(
                        'title' => esc_html__('Badges & Rating', 'dnwooe'),
                        'sub_toggles' => array(
                            'on_sale' => array(
                                'name' => esc_html__('On Sale', 'dnwooe'),
                            ),
                            'star_rating' => array(
                                'name' => esc_html__('Star Rating', 'dnwooe'),
                            ),
                            'rating_count' => array(
                                'name' => esc_html__('Rating Count', 'dnwooe'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                )
            )
        );

        $this->custom_css_fields = array(
            'search_field' => array(
                'label' => esc_html__('Search Field', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input[type="search"]',
            ),
            'search_result' => array(
                'label' => esc_html__('Search Result Container', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_items',
            ),
            'search_result_item' => array(
                'label' => esc_html__('Search Result Items', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper_inner',
            ),
            'category_selected' => array(
                'label' => esc_html__('Selected Category', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option',
            ),
            'category_icon' => array(
                'label' => esc_html__('Category Arrow Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-custom-select:after',
            ),
            'category_list_box' => array(
                'label' => esc_html__('Category List Box', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-select-options',
            ),
            'category_list' => array(
                'label' => esc_html__('Category List', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-select-options li',
            ),
            'button' => array(
                'label' => esc_html__('Search Button', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_form_searbtn .dnwoo_ajax_search_formcusbtn',
            ),
            'title' => array(
                'label' => esc_html__('Title', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_title',
            ),
            'excerpt' => array(
                'label' => esc_html__('Excerpt', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_des',
            ),
            'featured' => array(
                'label' => esc_html__('Featured Image', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_img img',
            ),
            'price' => array(
                'label' => esc_html__('Price', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_pricewithsalecombined',
            ),
            'on_sale' => array(
                'label' => esc_html__('On Sale Badge', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_content_wrapper .dnwoo_ajax_search_onsale_withprice',
            ),
            'star_rating' => array(
                'label' => esc_html__('Star Rating', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_ratting',
            ),
            'rating_count' => array(
                'label' => esc_html__('Rating Count', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_ratting_count span',
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array(
            'link_options' => false,
            'text' => false,
            'fonts' => array(
                'search_field' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input,%%order_class%% .dnwoo_ajax_search_form_searcharea input::placeholder',
                    ),
                    'toggle_slug' => 'search_field',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'hide_text_color' => true,
                    'font_size' => array(
                        'default' => '16px',
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'title' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_title',
                    ),
                    'font'  => array(
                        'default' => "|700|||||||"
                    ),
                    'text_color' => array(
                        'default' => '#000000'
                    ),
                    'hide_text_align' => true,
                    'toggle_slug' => 'search_result',
                    'sub_toggle' => 'title',
                    'tab_slug' => 'advanced'
                ),
                'excerpt' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_item_des',
                    ),
                    'text_color' => array(
                        'default' => '#777c90'
                    ),
                    'hide_text_align' => true,
                    'toggle_slug' => 'search_result',
                    'sub_toggle' => 'excerpt',
                    'tab_slug' => 'advanced'
                ),
                'price' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_pricewithsalecombined',
                    ),
                    'font'  => array(
                        'default' => "|600|||||||"
                    ),
                    'text_color' => array(
                        'default' => '#000000'
                    ),
                    'hide_text_align' => true,
                    'toggle_slug' => 'search_result',
                    'sub_toggle' => 'price',
                    'tab_slug' => 'advanced'
                ),
                'noresult' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_no_result',
                    ),
                    'toggle_slug' => 'search_result',
                    'sub_toggle' => 'noresult',
                    'tab_slug' => 'advanced'
                ),
                'on_sale' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_onsale_withprice',
                    ),
                    'font_size' => array(
                        'default' => '12px',
                    ),
                    'hide_text_align' => true,
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                        'default' => '1'
                    ),
                    'text_color' => array(
                        'default' => '#161b2d'
                    ),
                    'toggle_slug' => 'badge_rating',
                    'sub_toggle' => 'on_sale',
                    'tab_slug' => 'advanced'
                ),
                'rating_count' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_item_ratting_count span',
                    ),
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_line_height' => true,
                    'toggle_slug' => 'badge_rating',
                    'sub_toggle' => 'rating_count',
                    'tab_slug' => 'advanced'
                ),
                'selected_category' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo-custom-select.active,%%order_class%% .dnwoo-custom-select:active,%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option',
                    ),
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_line_height' => true,
                    'hide_text_color' => true,
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'selected',
                    'tab_slug' => 'advanced'
                ),
                'category_list' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-select-options li',
                    ),
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_line_height' => true,
                    'hide_text_color' => true,
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'list',
                    'tab_slug' => 'advanced'
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%%',
                            'border_styles' => '%%order_class%%',
                        )
                    )
                ),
                'search_field' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input[type=search]',
                            'border_styles' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input[type=search]',
                        ),
                    ),
                    'label_prefix' => esc_html__('Field', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'search_field',
                ),
                'on_sale' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_ajax_search_onsale_withprice',
                            'border_styles' => '%%order_class%% .dnwoo_ajax_search_onsale_withprice',
                        ),
                    ),
                    'label_prefix' => esc_html__('On Sale', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'badge_rating',
                    'sub_toggle' => 'on_sale',
                ),
                'feature_image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_ajax_search_img img',
                            'border_styles' => '%%order_class%% .dnwoo_ajax_search_img img',
                        ),
                    ),
                    'label_prefix' => esc_html__('Feature Image', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'feature_image',
                ),
                'selected_category' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo-custom-select.active,%%order_class%% .dnwoo-custom-select:active,%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option',
                            'border_styles' => '%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo-custom-select.active,%%order_class%% .dnwoo-custom-select:active,%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option',
                        ),
                    ),
                    'defaults'        => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '1px',
							'color' => '#d3d3d3',
							'style' => 'solid',
						),
					),
                    'label_prefix' => esc_html__('Selected Category', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'selected',
                ),
                'category_list' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo-select-options li:not(:last-child)',
                            'border_styles' => '%%order_class%% .dnwoo-select-options li:not(:last-child)',
                        ),
                    ),
                    // 'border_radii' => array(
                    //     'default' => '1px'
                    // ),
                    'label_prefix' => esc_html__('Category List', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'list',
                )
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%%',
                        'important' => 'all',
                    ),
                ),
                'search_field' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Field', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'search_field',
                ),
                'on_sale' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_onsale_withprice',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('On Sale', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'badge_rating',
                    'sub_toggle' => 'on_sale',
                ),
                'feature_image' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_ajax_search_img img',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Feature Image', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'feature_image',
                ),
                'selected_category' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo-custom-select.active,%%order_class%% .dnwoo-custom-select:active,%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option',
                        // 'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Selected Category', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'selected',
                ),
                'category_list' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-select-options li',
                        // 'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Category List', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'category_section',
                    'sub_toggle' => 'list',
                ),
            ),
            'max_width' => array(
                'default' => array(
                    'css' => array(
                        'main' => ""
                    )
                ),
                'extra' => array(
                    'feature_image' => array(
                        'options' => array(
							'width' => array(
								'label'          => esc_html__( 'Featured Image Width', 'dnwooe' ),
								'range_settings' => array(
									'min'  => 1,
									'max'  => 100,
									'step' => 1,
								),
								'hover'          => false,
								'default_unit'   => 'px',
								'default'		 => '85px',
								'default_tablet' => '',
								'default_phone'  => '',
								'tab_slug'       => 'advanced',
								'toggle_slug'    => 'feature_image',
							),
						),
						'use_max_width'        => false,
						'use_module_alignment' => false,
						'css'                  => array(
							'main' => "%%order_class%% .dnwoo_ajax_search_img",
						),
                    )
                )
            ),
            'height' => array(
                'extra' => array(
					'featured_image' => array(
						'options' => array(
							'height' => array(
								'label'          => esc_html__( 'Featured Image Height', 'dnwooe' ),
								'range_settings' => array(
									'min'  => 1,
									'max'  => 100,
									'step' => 1,
								),
								'hover'          => false,
								'default_unit'   => 'px',
								'default'	     => '100%',
								'default_tablet' => '',
								'default_phone'  => '',
								'tab_slug'       => 'advanced',
								'toggle_slug'    => 'feature_image',
							),
						),
						'use_max_height' => false,
						'use_min_height' => false,
						'css'            => array(
							'main' => "%%order_class%% .dnwoo_ajax_search_img",
						),
					),
				),
            ),
            'button'         => array(
                'button' => array(
                    'label'         => esc_html__('Search Button', 'dnwooe'),
                    'css'           => array(
                        'main'      => "%%order_class%% .dnwoo_ajax_search_btn",
                        'important' => true,
                    ),
                    'toggle_slug' => 'search_button',
                    'tab_slug'    => 'advanced',
                    'use_alignment' => false,
                    'custom_button' => true,
                    'hide_icon' => true,
                    'fonts' => array(
                        'css' => array(
                            'main' => '%%order_class%% .dnwoo_ajax_search_formcusbtn .dnwoo_ajax_search_button_text',
                        ),
                    ),
                    'box_shadow'    => array(
                        'css' => array(
                            'main' => '%%order_class%% .dnwoo_ajax_search_btn',
                        ),
                    ),
                    'margin_padding' => array(
                        'css' => array(
                            'margin'      => '%%order_class%% .dnwoo_ajax_search_form_searbtn',
                            'padding'      => '%%order_class%% .dnwoo_ajax_search_form_searbtn button,body #page-container .et_pb_section %%order_class%% .dnwoo_ajax_search_form_searbtn button:hover',
                        ),
                        // 'hover' => false
                    ),
                ),
            ),
        );
        return $advanced_fields;
    }

    public function get_fields() {
        $search_in = array( 
			'title' 				=> esc_html__( 'Title', 'dnwooe' ),
			'content' 				=> esc_html__( 'Content', 'dnwooe' ),
			'excerpt' 				=> esc_html__( 'Excerpt', 'dnwooe' ),
			'product_categories' 	=> esc_html__( 'Product Categories', 'dnwooe' ),
			'product_tags' 			=> esc_html__( 'Product Tags', 'dnwooe' ),
			'custom_taxonomies' 	=> esc_html__( 'Custom Taxonomies', 'dnwooe' ),
			'attributes' 			=> esc_html__( 'Attributes', 'dnwooe' ),
			'sku' 					=> esc_html__( 'SKU', 'dnwooe' ),
		);
		$display_fields = array( 
			'title' 			=> esc_html__( 'Title', 'dnwooe' ),
			'excerpt' 			=> esc_html__( 'Excerpt', 'dnwooe' ),
			'thumbnail' 	    => esc_html__( 'Thumbnail', 'dnwooe' ),
			'product_price' 	=> esc_html__( 'Price', 'dnwooe' ),
			'on_sale' 	        => esc_html__( 'On Sale Badge', 'dnwooe' ),
            'star_rating'       => esc_html__( 'Star Rating', 'dnwooe' ),
			'rating_count' 	    => esc_html__( 'Rating Count', 'dnwooe' ),
		);
        
        $configuration = array(
            'search_placeholder' => array(
                'label'           		=> esc_html__( 'Search Field Placeholder', 'dnwooe' ),
                'type'           		=> 'text',
                'option_category' 		=> 'basic_option',
                'default_on_front' 		=> esc_html__( 'Search', 'dnwooe' ),
                'default'		   		=> esc_html__( 'Search', 'dnwooe' ),
                'toggle_slug'     		=> 'configuration',
                'description'     		=> esc_html__( 'Here you can input the placeholder to be used for the search field.', 'dnwooe' ),
            ),
            'number_of_results' => array(
                'label'           		=> esc_html__( 'Search Result Number', 'dnwooe' ),
                'type'           		=> 'text',
                'option_category' 		=> 'basic_option',
                'default_on_front' 		=> '10',
                'default'		   		=> '10',
                'toggle_slug'     		=> 'configuration',
                'description'     		=> esc_html__( 'Here you can input the number of items to be displayed in the search result. Input -1 for all.', 'dnwooe' ),
            ),
            'orderby' => array(
                'label'            => esc_html__( 'Order by', 'dnwooe' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'post_date' 	=> esc_html__( 'Date', 'dnwooe' ),
                    'post_modified'	=> esc_html__( 'Modified Date', 'dnwooe' ),
                    'post_title'   	=> esc_html__( 'Title', 'dnwooe' ),
                    'post_name'     => esc_html__( 'Slug', 'dnwooe' ),
                    'ID'       		=> esc_html__( 'ID', 'dnwooe' ),
                ),
                'default'          => 'post_date',
                'toggle_slug'      => 'configuration',
                'description'      => esc_html__( 'Here you can choose the order type of your results.', 'dnwooe' ),
            ),
            'order' => array(
                'label'            => esc_html__( 'Order', 'dnwooe' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'DESC' => esc_html__( 'DESC', 'dnwooe' ),
                    'ASC'  => esc_html__( 'ASC', 'dnwooe' ),
                ),
                'default'          => 'DESC',
                'show_if_not'      => array(
                    'orderby' => 'rand',
                ),
                'toggle_slug'      => 'configuration',
                'description'      => esc_html__( 'Here you can choose the order of your results.', 'dnwooe' ),
            ),
            'thumbnail_size' => array(
                'label' => esc_html__('Product Thumbnail Size', 'dnwooe'),
                'description' => esc_html__('Here you can specify the size of product image.', 'dnwooe'),
                'type' => 'select',
                'options' => array(
                    'thumbnail' => esc_html__('Thumbnail', 'dnwooe'),
                    'medium' => esc_html__('Medium', 'dnwooe'),
                    'medium_large' => esc_html__('Medium Large', 'dnwooe'),
                    'full' => esc_html__('Full', 'dnwooe'),
                ),
                'default' => 'thumbnail',
                'option_category' => 'basic_option',
                'toggle_slug' => 'configuration',
            ),
            'no_result_text' => array(
                'label'           		=> esc_html__( 'No Result Text', 'dnwooe' ),
                'description'     		=> esc_html__( 'Here you can input the custom text to be displayed when no results found.', 'dnwooe' ),
                'type'           		=> 'text',
                'option_category' 		=> 'basic_option',
                'default'		   		=> esc_html__( 'No results found', 'dnwooe' ),
                'toggle_slug'     		=> 'configuration',
            ),
        );
        $search_area = array(
            'search_in' => array(
                'label'            		=> esc_html__( 'Search in', 'dnwooe' ),
                'type'             		=> 'multiple_checkboxes',
                'option_category'  		=> 'basic_option',
                'options'				=> $search_in,
                'default'				=> 'on|on|on',
                'default_on_front'		=> 'on|on|on',
                'toggle_slug'      		=> 'search_area',
                'description'      		=> esc_html__( 'Here you can choose where you would like to search in.', 'dnwooe' ),
            ),
        );
        $display = array(
            'show_loader_icon' => array(
                'label'            		=> esc_html__( 'Show Loading Spinner', 'dnwooe' ),
                'description'      		=> esc_html__( 'This will turn the loading spinner on and off while searching.', 'dnwooe' ),
                'type'             		=> 'yes_no_button',
                'option_category'  		=> 'configuration',
                'options'          		=> array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          		=> 'on',
                'toggle_slug'      		=> 'display',
            ),
            'search_icon_option' => array(
                'label' => esc_html__('Show Search Icon & Button', 'dnwooe'),
                'description' => esc_html__('Here you can choose the position where you want to show the search icon & search button.', 'dnwooe'),
                'type' => 'select',
                'options' => array(
                    'none' => esc_html__('None', 'dnwooe'),
                    'icon' => esc_html__('Icon', 'dnwooe'),
                    'button' => esc_html__('Button', 'dnwooe'),
                    'button_icon' => esc_html__('Button with Icon', 'dnwooe'),
                ),
                'default' => 'icon',
                'option_category' => 'basic_option',
                'toggle_slug' => 'display',
            ),
            'search_button_text' => array(
                'label'           		=> esc_html__( 'Search Button Text', 'dnwooe' ),
                'type'           		=> 'text',
                'option_category' 		=> 'basic_option',
                'toggle_slug'     		=> 'display',
                'description'     		=> esc_html__( 'Here you can input the placeholder to be used for the search field.', 'dnwooe' ),
                'show_if'               => array(
                    'search_icon_option' => array('button', 'button_icon'),
                )
            ),
            'display_fields' => array(
                'label'            		=> esc_html__( 'Display Fields', 'dnwooe' ),
                'type'             		=> 'multiple_checkboxes',
                'option_category'  		=> 'basic_option',
                'options'				=> $display_fields,
                'default'				=> 'on|on|on|off',
                'default_on_front'		=> 'on|on|on|off',
                'toggle_slug'      		=> 'display',
                'description'      		=> esc_html__( 'Here you can choose which fields you would like to display in search results.', 'dnwooe' ),
            ),
            'number_of_columns' => array(
                'label'             => esc_html__( 'Number Of Columns', 'dnwooe' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => array(
                    '1'  => esc_html( '1' ),
                    '2'  => esc_html( '2' ),
                    '3'  => esc_html( '3' ),
                    '4'  => esc_html( '4' ),
                    '5'  => esc_html( '5' ),
                ),
                'default'           => '1',
                'mobile_options'	=> true,
                'toggle_slug'       => 'display',
                'description'       => esc_html__( 'Here you can select the number of columns to display result items.', 'dnwooe' ),
            ),
            'column_spacing' => array(
                'label'             => esc_html__( 'Column Spacing', 'dnwooe' ),
                'type'              => 'range',
                'option_category'  	=> 'layout',
                'range_settings'    => array(
                    'min'   => '0',
                    'max'   => '100',
                    'step'  => '1',
                ),
                'fixed_unit'		=> 'px',
                'fixed_range'       => true,
                'validate_unit'		=> true,
                'mobile_options'    => true,
                'default_on_front'  => '15px',
                'toggle_slug'     	=> 'display',
                'description'       => esc_html__( 'Increase or decrease spacing between columns.', 'dnwooe' ),
            ),
            'use_masonry' => array(
                'label'            		=> esc_html__( 'Use Masonry', 'dnwooe' ),
                'type'             		=> 'yes_no_button',
                'option_category'  		=> 'configuration',
                'options'          		=> array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          		=> 'off',
                'show_if_not'      => array(
                    'number_of_columns' => '1',
                ),
                'toggle_slug'      		=> 'display',
                'description'      		=> esc_html__( 'Here you can select whether or not to display the results in masonry design appearance.', 'dnwooe' ),
            ),
        );
        $scrollbar = array(
            'scrollbar' => array(
                'label'             => esc_html__( 'Scrollbar', 'dnwooe' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => array(
                    'default'  	=> esc_html__( 'Show', 'dnwooe' ),
                    'hide' 		=> esc_html__( 'Hide', 'dnwooe' ),
                ),
                'default'           => 'default',
                'toggle_slug'       => 'scrollbar',
                'description'       => esc_html__( 'Here you can select whether to show or hide scrollbar. This is totally depends on the browser, we can not guarantee the result of it.', 'dnwooe' ),
            ),
        );

        $category_section = array(
            'current_category' => array(
                'label'            		=> esc_html__( 'Use Current Category', 'dnwooe' ),
                'description'      		=> esc_html__( 'This will turn the category section on and off.', 'dnwooe' ),
                'type'             		=> 'yes_no_button',
                'option_category'  		=> 'configuration',
                'options'          		=> array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          		=> 'off',
                'toggle_slug'      		=> 'category',
            ),
            'show_category_section' => array(
                'label'            		=> esc_html__( 'Show Category Section', 'dnwooe' ),
                'description'      		=> esc_html__( 'This will turn the category section on and off.', 'dnwooe' ),
                'type'             		=> 'yes_no_button',
                'option_category'  		=> 'configuration',
                'options'          		=> array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          		=> 'off',
                'toggle_slug'      		=> 'category',
                'show_if' => array(
                    'current_category'  => 'off'
                )
            ),
            'category_position' => array(
                'label'            => esc_html__( 'Category Position', 'dnwooe' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'row' 	    => esc_html__( 'Left', 'dnwooe' ),
                    'row-reverse'	    => esc_html__( 'Right', 'dnwooe' ),
                    'column'	    => esc_html__( 'Top', 'dnwooe' ),
                    'column-reverse'	    => esc_html__( 'Bottom', 'dnwooe' ),
                ),
                'default'          => 'row',
                'toggle_slug'      => 'category',
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if' => array(
                    'show_category_section'  => 'on'
                )
            ),
            'include_categories' => array(
                'label' => esc_html__('Include Categories', 'dnwooe'),
                'type' => 'categories',
                'renderer_options' => array(
                    'use_terms' => true,
                    'term_name' => 'product_cat',
                    'field_name' => 'et_pb_include_product_cat',
                ),
                'meta_categories' => array(
                    'all' => esc_html__('All Categories', 'dnwooe'),
                ),
                'toggle_slug' => 'category',
                'description' => esc_html__('Select Categories. If no category is selected, products from all categories will be displayed.', 'dnwooe'),
                'show_if' => array(
                    'current_category'  => 'off'
                )
            ),
        );

        $link = array(
            'link_target' => array(
                'label'            => esc_html__( 'Result Product Link Target', 'dnwooe' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    '_self' 	    => esc_html__( 'In The Same Window', 'dnwooe' ),
                    '_blank'	    => esc_html__( 'In The New Tab', 'dnwooe' ),
                ),
                'default'          => '_self',
                'toggle_slug'      => 'link',
            ),
        );
        $search_field = array(
            'field_text_color' => array(
                'label' => esc_html__('Field Text Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Search Field text', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'search_field',
            ),
            'field_text_focus_color' => array(
                'label' => esc_html__('Field Focus Text Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Search Field text when in focus.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'search_field',
            ),
        );

        $search_result = array(
            'star_rating_color_active' => array(
                'label' => esc_html__('Star Rating Active Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Active Stars.', 'dnwooe'),
                'type' => 'color-alpha',
                'default' => '#f2b01e',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'badge_rating',
                'sub_toggle' => 'star_rating',
            ),
            'star_rating_color' => array(
                'label' => esc_html__('Star Rating Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Star Rating', 'dnwooe'),
                'type' => 'color-alpha',
                'default' => '#ccc',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'badge_rating',
                'sub_toggle' => 'star_rating',
            ),
        );

        $icons = array(
            'search_icon_size' => array(
                'label' => esc_html__('Search Icon Size', 'dnwooe'),
                'description' => esc_html__('Define the search icon size.', 'dnwooe'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icons',
                'sub_toggle' => 'search',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default_unit' => 'px',
                'default' => '15px',
                'default_on_front' => '15px',
                'range_settings' => array(
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                ),
                'mobile_options' => true,
                'responsive' => true,
            ),
            'search_icon_color' => array(
                'label' => esc_html__('Search Icon Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for search icon.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icons',
                'sub_toggle' => 'search',
                'mobile_options' => true,
                'responsive' => true,
            ),
            'loader_icon_size' => array(
                'label' => esc_html__('Loader Icon Size', 'dnwooe'),
                'description' => esc_html__('Define the loader icon size.', 'dnwooe'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icons',
                'sub_toggle' => 'loader',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default_unit' => 'px',
                'default' => '15px',
                'default_on_front' => '15px',
                'range_settings' => array(
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                ),
                'mobile_options' => true,
                'responsive' => true,
            ),
            'loader_icon_color' => array(
                'label' => esc_html__('Loader Icon Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for loader icon.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icons',
                'sub_toggle' => 'loader',
                'mobile_options' => true,
                'responsive' => true,
            ),
            'search_button_position' => array(
                'label'            => esc_html__( 'Search Button Position', 'dnwooe' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'row-reverse'	    => esc_html__( 'Left', 'dnwooe' ),
                    'row' 	    => esc_html__( 'Right', 'dnwooe' ),
                    'column-reverse'	    => esc_html__( 'Top', 'dnwooe' ),
                    'column'	    => esc_html__( 'Bottom', 'dnwooe' ),
                ),
                'default'          => 'row',
                'toggle_slug'      => 'search_button',
                'tab_slug'          => 'advanced',
                'responsive'        => true,
                'mobile_options'    => true,
            ),
        );
        $category_design = array(
            'selected_category_width' => array(
                'label'             => esc_html__( 'Category Section Width', 'dnwooe' ),
                'description'       => esc_html__( 'Increase or decrease category section width.', 'dnwooe' ),
                'type'              => 'range',
                'option_category'  	=> 'layout',
                'range_settings'    => array(
                    'min'   => '0',
                    'max'   => '1000',
                    'step'  => '1',
                ),
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'mobile_options'    => true,
                'default_on_front'  => '170px',
                'toggle_slug'     	=> 'category_section',
                'sub_toggle'     	=> 'selected',
                'tab_slug'     	=> 'advanced',
            ),
            'selected_category_color' => array(
                'label' => esc_html__('Selected Category Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for the selected category.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'category_section',
                'sub_toggle' => 'selected',
                'hover' => 'tabs'
            ),
            'category_list_color' => array(
                'label' => esc_html__('Category List Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for the each category list text.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'category_section',
                'sub_toggle' => 'list',
                'hover' => 'tabs'
            ),
            'category_icon_warning'=> array(
				'type'       => 'warning',
				'value'      => true,
                'display_if' => true,
				'message'    => esc_html__( "These settings will not work in the visual builder, but will work on the frontend page.", 'dnwooe' ),
				'toggle_slug' => 'category_section',
                'sub_toggle' => 'icon',
                'tab_slug' => 'advanced',
			),
            'category_icon_color' => array(
                'label' => esc_html__('Category Icon Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for the each category icon.', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'category_section',
                'sub_toggle' => 'icon',
                'hover' => 'tabs'
            ),
            'category_icon_size' => array(
                'label'             => esc_html__( 'Category Icon Size', 'dnwooe' ),
                'type'              => 'range',
                'option_category'  	=> 'layout',
                'range_settings'    => array(
                    'min'   => '0',
                    'max'   => '100',
                    'step'  => '1',
                ),
                'fixed_unit'		=> 'px',
                'fixed_range'       => true,
                'validate_unit'		=> true,
                'mobile_options'    => true,
                'default_on_front'  => '20px',
                'toggle_slug'     	=> 'category_section',
                'sub_toggle'     	=> 'icon',
                'tab_slug'     	=> 'advanced',
                'description'       => esc_html__( 'Increase or decrease icon size.', 'dnwooe' ),
            ),
        );

        $margin_padding = array(
            'search_field_margin' => array(
                'label' => esc_html__('Search Field Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'search_field_padding' => array(
                'label' => esc_html__('Search Field Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'category_margin' => array(
                'label' => esc_html__('Category Section Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'category_padding' => array(
                'label' => esc_html__('Category Section Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'search_result_margin' => array(
                'label' => esc_html__('Search Result Container Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'search_result_padding' => array(
                'label' => esc_html__('Search Result Container Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'search_result_item_padding' => array(
                'label' => esc_html__('Search Result Item Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'title_margin' => array(
                'label' => esc_html__('Title Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'title_padding' => array(
                'label' => esc_html__('Title Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'excerpt_margin' => array(
                'label' => esc_html__('Excerpt Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'excerpt_padding' => array(
                'label' => esc_html__('Excerpt Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'featured_margin' => array(
                'label' => esc_html__('Featured Image Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'featured_padding' => array(
                'label' => esc_html__('Featured Image Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'on_sale_margin' => array(
                'label' => esc_html__('On Sale Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'on_sale_padding' => array(
                'label' => esc_html__('On Sale Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'price_margin' => array(
                'label' => esc_html__('Price Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'star_rating_margin' => array(
                'label' => esc_html__('Star Rating Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'rating_count_margin' => array(
                'label' => esc_html__('Rating Count Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
        );

        $_common_bg_attr = array(
            'mobile_options' => false,
            'hover' => false,
        );
        $search_result_box_bg       = DNWoo_Common::background_fields($this, "search_result_box_", "Search Result Box Background", "background", "general");
        $search_result_item_bg       = DNWoo_Common::background_fields($this, "search_result_item_", "Search Result Item Background", "background", "general");
        $search_field_bg       = DNWoo_Common::background_fields($this, "search_field_", "Search Field Background", "search_field", "advanced");
        $search_field_focus_bg       = DNWoo_Common::background_fields($this, "search_field_focus_", "Search Field Focus Background", "search_field", "advanced",$_common_bg_attr);
        $on_sale_bg       = DNWoo_Common::background_fields($this, "on_sale_", "On Sale Background", "badge_rating", "advanced", array(
            'sub_toggle' => 'on_sale',
            'default' => '#ffea28'
        ));
        $category_bg       = DNWoo_Common::background_fields($this, "category_", "Category Background", "category_section", "advanced", array(
            'sub_toggle' => 'selected'
        ));
        $category_list_bg       = DNWoo_Common::background_fields($this, "category_list_", "Category List Background", "category_section", "advanced", array(
            'sub_toggle' => 'list',
        ));

        return array_merge($configuration, $search_area, $display, $scrollbar, $category_section, $link, $search_field, $search_result, $icons, $category_design, $margin_padding, $search_result_box_bg,$search_result_item_bg, $search_field_bg, $search_field_focus_bg, $on_sale_bg, $category_bg, $category_list_bg);
    }
    
    public function render( $attrs, $content, $render_slug ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}
        $this->callingStylesAndScripts();

        $placeholder = isset($this->props['search_placeholder']) ? $this->props['search_placeholder'] : '';
        $show_category_section = isset($this->props['show_category_section']) ? $this->props['show_category_section'] : 'off';
        $current_category = (isset($this->props['current_category'])) ? $this->props['current_category'] : 'off';
        $search_container_class = $this->use_masonry ? 'dnwoo_ajax_search_masonry_layoutthree' : 'dnwoo_ajax_search_masonry_layoutone';
        $thumbnail_size = (isset($this->props['thumbnail_size']))? $this->props['thumbnail_size'] : 'thumbnail';
        $no_result_text = isset($this->props['no_result_text']) ? esc_html__($this->props['no_result_text'], 'dnwooe') : '';
        $link_target = isset($this->props['link_target']) ? $this->props['link_target'] : '_self';

        $show_search_button = isset($this->props['search_icon_option']) ? $this->props['search_icon_option'] : '';
        
        if ( 'off' == $current_category ){
            $include_categories = isset($this->props['include_categories']) ? $this->props['include_categories'] : '';
        }else {
            $include_categories = is_product_category() ? (string) get_queried_object_id() : '';
        }
       
        // Search In fields
        $search_fields = array( 'title','content','excerpt','product_categories','product_tags','custom_taxonomies','attributes','sku');
        $search_in = isset($this->props['search_in'])? $this->props['search_in'] : '';
        $search_in = $this->get_processed_checkbox_data_string($search_in, $search_fields);

        // Display Fields
        $display_fields = isset($this->props['display_fields'])? $this->props['display_fields'] : '';

        $allowed_display_fields = array('title', 'excerpt','thumbnail', 'product_price', 'on_sale', 'star_rating', 'rating_count');
        $display_fields = $this->get_processed_checkbox_data_string($display_fields, $allowed_display_fields);
        
        // Order by
        $orderby = isset($this->props['orderby'])? $this->props['orderby'] : '';
        $order = isset($this->props['order'])? $this->props['order'] : 'DESC';
        $number_of_results = isset($this->props['number_of_results'])? $this->props['number_of_results'] : '10';


        $search_icon_inside = (isset($this->props['search_icon_option']) && 'icon' == $show_search_button ) ? '<span class="dnwoo_ajax_search_icon_right dnwoo_ajax_search_icon_inside_input"></span>' : '';
        $search_icon_outside = (isset($this->props['search_icon_option']) && 'button_icon' == $show_search_button ) ? '<span class="dnwoo_ajax_search_icon_right dnwoo_ajax_search_icon_outside_input"></span>' : '';
        $scrollbar = (isset($this->props['scrollbar']) && 'hide' == $this->props['scrollbar']) ? 'dnwoo_ajax_search_result_hide_scrollbar' : '';


        $loading_spinner = (isset( $this->props['show_loader_icon'] ) && 'on' == $this->props['show_loader_icon']) ? '<div class="dnwoo_ajax_search_loader_layout_one"></div>' : '';
        
        $category_data = ('' != $include_categories && 'all' != $include_categories) ? $include_categories : '';
        

        $category_section = '';
        if( 'on' == $show_category_section && 'off' == $current_category) {
            $terms = $this->get_woo_product_categories($category_data);
            $category_section = '<div class="dnwoo_ajax_search_form_option_category"><select name="dnwoo_ajax_product_cats" id="dnwoo_ajax_product_cats" class="dnwoo_ajax_search_option dnwoo_ajax_search_option_frontend"><option value="all">All Categories</option>';

            foreach( $terms as $term ) {
                $category_section .= sprintf('<option value="%1$s">%2$s</option>', $term->term_id, $term->name);
            }

            $category_section .= '</select></div>';
        }
        $button_icon = '&#x55;||divi||400';
        // &#x55;||divi||400
        $data_icon = '';
        $data_icon_class = '';

        $search_button_text = '' != $this->props['search_button_text'] ? sprintf(
            '<span class="dnwoo_ajax_search_button_text %2$s">%1$s</span>', 
            esc_html__( $this->props['search_button_text'], 'dnwooe' ),
            'button_icon' == $show_search_button ? 'dnwoo_ajax_search_mr' : ''
            ) : '';

        $search_button = in_array($show_search_button, array('button', 'button_icon') ) ? sprintf(
            '<div class="dnwoo_ajax_search_form_searbtn">
                <button type="submit" class="dnwoo_ajax_search_formcusbtn dnwoo_ajax_search_btn">%1$s%2$s</button>
            </div>', 
            $search_button_text,
            $search_icon_outside
            ) : '';
            
        $wp_nonce = wp_nonce_field('dnwoo_ajax_search_nonce', 'dnwoo_ajax_search_nonce_field', true, false);
        $this->apply_css( $render_slug );
        $this->apply_background_css( $render_slug );
        $this->apply_spacing( $render_slug );

        return sprintf(
            '<div class="dnwoo_ajax_search_form dnwoo_ajax_search_form_layoutone">
                <form method="post" class="dnwoo_ajax_search_form_customone" data-searchin="%2$s" data-display="%3$s" data-orderby="%4$s" data-order="%5$s" data-searchlimit="%6$s" data-category-status="%12$s" data-category-ids="%13$s" data-current-category="%14$s" data-search-container-class="%15$s" data-no-result-text="%16$s" data-thumbnail-size="%17$s" data-link-target="%18$s" data-search-button="%20$s">
                    <span class="dnwoo_ajax_search_nonce">
                        %7$s
                    </span>
                    <div class="dnwoo_ajax_category_search_field">
                        %10$s
                        <div
                            class="dnwoo_ajax_search_form_searcharea"
                        >
                            <input
                            type="search"
                            class="dnwoo_ajax_search_formsearch"
                            placeholder="%1$s"
                            spellcheck="false"
                            />
                            %8$s
                            %19$s
                        </div>
                    </div>
                    %11$s
                </form>
                <div class="dnwoo_ajax_search_wrapper woocommerce %9$s"></div>
            </div>', 
            $placeholder,
            $search_in,
            $display_fields,
            $orderby,
            $order, #5
            $number_of_results,
            $wp_nonce,
            'icon' == $show_search_button ? $search_icon_inside : '',
            $scrollbar,
            $category_section, #10
            $search_button,
            $show_category_section,
            $category_data,
            $current_category,
            $search_container_class, #15
            $no_result_text,
            $thumbnail_size,
            $link_target,
            $loading_spinner,
            in_array($show_search_button, ['button', 'button_icon']) #20
        );
    }
    
    private function get_woo_product_categories($include_categories) {
        return get_terms( array(
            'taxonomy' => 'product_cat',
            'include' => array_map('intval', explode(',', $include_categories)),
            'hide_empty' => false,
        ) );
    }
    private function get_processed_checkbox_data_array($unprocessed_data, $data_arr) {
        if('' == $unprocessed_data) return array();
        $unprocessed_data = explode('|', $unprocessed_data);
        
        for ($i=0; $i < count($unprocessed_data); $i++) { 
            if( array_key_exists($i, $unprocessed_data) && array_key_exists($i, $data_arr) && $unprocessed_data[$i] == 'on' ) {
                $unprocessed_data[$i] = $data_arr[$i];
            }
            continue;
        }

        // return $unprocessed_data;
        return array_filter($unprocessed_data, function($fields) {
            return !in_array($fields, array('on', 'off'));
        });
    }
    
    private function get_processed_checkbox_data_string($unprocessed_data, $data_arr) {
        $unprocessed_data = $this->get_processed_checkbox_data_array($unprocessed_data, $data_arr);
        return implode('|', $unprocessed_data);
    }
    private function calculate_gutter($spacing, $column_number) {
        return (intval($spacing) - (intval($spacing) / $column_number) );
    }
    public function before_render() {
        $this->use_masonry = (isset($this->props['use_masonry']) && 'on' == $this->props['use_masonry']);
    }
    protected function callingStylesAndScripts() {
        if( $this->use_masonry ) {
            wp_enqueue_script('dnwoo_isotope_frontend');
        }
        wp_enqueue_style('dnwoo_module_ajax_search');
        wp_enqueue_style('dnwoo_module_ajax_search_input');
        if( isset( $this->props['show_category_section'] ) && 'on' == $this->props['show_category_section'] ) {
            wp_enqueue_style('dnwoo_module_ajax_category');
            wp_enqueue_script('dnwoo-ajax-category');
        }
        wp_enqueue_script('dnwoo-ajax-search');
    }

    protected function apply_background_css( $render_slug ) {
        $gradient_opt = array(
            'search_result_box_' => array(
                "desktop" => "%%order_class%% .dnwoo_ajax_search_items",
                "hover" => "%%order_class%% .dnwoo_ajax_search_items:hover",
            ),
            'search_result_item_' => array(
                "desktop" => "%%order_class%% .dnwoo_ajax_search_single_item_wrapper .dnwoo_ajax_search_wrapper_inner",
                "hover" => "%%order_class%% .dnwoo_ajax_search_single_item_wrapper .dnwoo_ajax_search_wrapper_inner:hover",
            ),
            'search_field_' => array(
                "desktop" => "%%order_class%% .dnwoo_ajax_search_form_searcharea input",
                "hover" => "%%order_class%% .dnwoo_ajax_search_form_searcharea input",
            ),
            'search_field_focus_' => array(
                "desktop" => "%%order_class%% .dnwoo_ajax_search_form_searcharea input:focus",
            ),
            'on_sale_' => array(
                "desktop" => "%%order_class%% .dnwoo_ajax_search_onsale_withprice",
                "hover" => "%%order_class%% .dnwoo_ajax_search_onsale_withprice:hover",
            ),
            'category_' => array(
                "desktop" => "%%order_class%% .dnwoo-custom-select,%%order_class%% .dnwoo-custom-select.active,%%order_class%% .dnwoo-custom-select:active",
                "hover" => "%%order_class%% .dnwoo-custom-select:hover, %%order_class%% .dnwoo-custom-select.active:hover, %%order_class%% .dnwoo-custom-select:active:hover",
            ),
            'category_list_' => array(
                "desktop" => "%%order_class%% .dnwoo-select-options li",
                "hover" => "%%order_class%% .dnwoo-select-options li:hover",
            ),
        );
        DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }
    private function apply_css( $render_slug ) {
        $number_of_columns = isset($this->props['number_of_columns']) ? intval( $this->props['number_of_columns'] ) : 1;
        $column_spacing = isset($this->props['column_spacing']) ?  intval($this->props['column_spacing']) : '0';
        $number_of_column_responsive_active = !empty($this->props["number_of_columns_last_edited"]) && et_pb_get_responsive_status($this->props["number_of_columns_last_edited"]);
        $column_spacing_responsive_active = !empty($this->props["column_spacing_last_edited"]) && et_pb_get_responsive_status($this->props["column_spacing_last_edited"]);
        $column_spacing_ms = $this->calculate_gutter($this->props['column_spacing'], $this->props['number_of_columns']);
        $column_sizes = array( 1 => '100%', 2 => '50%', 3 => '33.3333%', 4 => '25%', 5 => '20%');
        
        if( !$this->use_masonry ){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_single_item_wrapper',
                'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$this->props['number_of_columns']], $column_spacing_ms,  $this->props['column_spacing']),
                'media_query' => ET_Builder_Element::get_media_query('min_width_981'),
            ));
            
            if( $this->props['number_of_columns'] > 1 ) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutone .dnwoo_ajax_search_single_item_wrapper:not(:nth-child(%1$sn + %1$s))', $this->props['number_of_columns']),
                    'declaration' => sprintf('margin-right:%1$s;', $this->props['column_spacing']),
                    'media_query' => ET_Builder_Element::get_media_query('min_width_981'),
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_masonry_layoutone
                    .dnwoo_ajax_search_single_item_wrapper:nth-child(%1$sn + 1)', $this->props['number_of_columns']),
                    'declaration' => 'clear:left;',
                    'media_query' => ET_Builder_Element::get_media_query('min_width_981'),
                ));
            }
            
            if( (!empty( $this->props['number_of_columns_tablet'] ) && $number_of_column_responsive_active) || (!empty( $this->props['column_spacing_tablet'] ) && $column_spacing_responsive_active) ) {
                
                $column_number_tablet = $this->props['number_of_columns_tablet'] ? $this->props['number_of_columns_tablet'] : $this->props['number_of_columns'];
                $column_spacing_tablet = $this->props['column_spacing_tablet'] ? $this->props['column_spacing_tablet'] : $this->props['column_spacing'];
                $column_spacing_ms_tablet = $this->calculate_gutter($column_spacing_tablet, $column_number_tablet);
                
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutone .dnwoo_ajax_search_single_item_wrapper',
                    'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$column_number_tablet], $column_spacing_ms_tablet, $column_spacing_tablet),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
                
                if( $column_number_tablet > 1 ) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutone .dnwoo_ajax_search_single_item_wrapper:not(:nth-child(%1$sn + %1$s))', $column_number_tablet),
                        'declaration' => sprintf('margin-right:%1$s !important;', $column_spacing_tablet),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                    ));
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_masonry_layoutone
                        .dnwoo_ajax_search_single_item_wrapper:nth-child(%1$sn + 1)', $column_number_tablet),
                        'declaration' => 'clear:left !important;',
                        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                    ));
                }
            }
            if( (!empty( $this->props['number_of_columns_phone'] ) && $number_of_column_responsive_active) || (!empty( $this->props['column_spacing_phone'] ) && $column_spacing_responsive_active) ) {
                $column_number_phone = $this->props['number_of_columns_phone'] ? $this->props['number_of_columns_phone'] : $this->props['number_of_columns'];
                $column_spacing_phone = $this->props['column_spacing_phone'] ? $this->props['column_spacing_phone'] : $this->props['column_spacing'];
                $column_spacing_ms_phone = $this->calculate_gutter($column_spacing_phone, $column_number_phone);
                
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutone .dnwoo_ajax_search_single_item_wrapper',
                    'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$column_number_phone], $column_spacing_ms_phone, $column_spacing_phone),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
    
                if( $column_number_phone > 1 ) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutone .dnwoo_ajax_search_single_item_wrapper:not(:nth-child(%1$sn + %1$s))', $column_number_phone),
                        'declaration' => sprintf('margin-right:%1$s !important;', $column_spacing_phone),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                    ));
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => sprintf('%%order_class%% .dnwoo_ajax_search_masonry_layoutone
                        .dnwoo_ajax_search_single_item_wrapper:nth-child(%1$sn + 1)', $column_number_phone),
                        'declaration' => 'clear:left !important;',
                        'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                    ));
                }
            }
        }else {
            
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_single_item_wrapper',
                'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$this->props['number_of_columns']],$column_spacing_ms,  $this->props['column_spacing']),
                'media_query' => ET_Builder_Element::get_media_query('min_width_981'),
            ));
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .gutter-sizer',
                'declaration' => "width: {$column_spacing}px;",
                'media_query' => ET_Builder_Element::get_media_query('min_width_981'),
            ]);

            if( (!empty( $this->props['number_of_columns_tablet'] ) && $number_of_column_responsive_active) || (!empty( $this->props['column_spacing_tablet'] ) && $column_spacing_responsive_active) ) {

                $column_number_tablet = $this->props['number_of_columns_tablet'] ? $this->props['number_of_columns_tablet'] : 1;
                $column_spacing_tablet = $this->props['column_spacing_tablet'] ? $this->props['column_spacing_tablet'] : $this->props['column_spacing'];
                
                $masonry_right_spacing_tablet = intval($column_spacing_tablet) - (intval($column_spacing_tablet) / $column_number_tablet);
                $column_spacing_ms_tablet = $this->calculate_gutter($column_spacing_tablet, $column_number_tablet);

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutthree .dnwoo_ajax_search_single_item_wrapper',
                    'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$column_number_tablet], $column_spacing_ms_tablet, $column_spacing_tablet),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
                ET_Builder_Element::set_style($render_slug, [
                    'selector'    => '%%order_class%% .gutter-sizer',
                    'declaration' => "width: {$column_spacing_tablet};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]);
            }
            if( (!empty( $this->props['number_of_columns_phone'] ) && $number_of_column_responsive_active) || (!empty( $this->props['column_spacing_phone'] ) && $column_spacing_responsive_active) ) {

                $column_number_phone = $this->props['number_of_columns_phone'] ? $this->props['number_of_columns_phone'] : 1;
                $column_spacing_phone = $this->props['column_spacing_phone'] ? $this->props['column_spacing_phone'] : $this->props['column_spacing'];
                
                $masonry_right_spacing_phone = intval($column_spacing_phone) - (intval($column_spacing_phone) / $column_number_phone);
                $column_spacing_ms_phone = $this->calculate_gutter($column_spacing_phone, $column_number_phone);


                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_masonry_layoutthree .dnwoo_ajax_search_single_item_wrapper',
                    'declaration' => sprintf('width: calc(%1$s - %2$spx);margin-bottom:%3$s;', $column_sizes[$column_number_phone], $column_spacing_ms_phone, $column_spacing_phone),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
                ET_Builder_Element::set_style($render_slug, [
                    'selector'    => '%%order_class%% .gutter-sizer',
                    'declaration' => "width: {$column_spacing_phone};",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]);
            }
        }
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper .dnwoo_ajax_search_single_item_wrapper',
            'declaration' => sprintf('margin-bottom:%1$s;', $this->props['column_spacing']),
        ));
        $css_settings = array(
            // Option slug should be the key
            'field_text_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_form_searcharea input,%%order_class%% .dnwoo_ajax_search_form_searcharea input::placeholder",
                ),
            ),
            'field_text_focus_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_form_searcharea input:focus,%%order_class%% .dnwoo_ajax_search_form_searcharea input:focus::placeholder",
                ),
            ),
            'star_rating_color_active' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .woocommerce .dnwoo_product_ratting .star-rating:before, %%order_class%% .woocommerce .dnwoo_product_ratting .star-rating span:before,%%order_class%% .woocommerce .dnwoo_product_ratting span:before",
                ),
            ),
            'star_rating_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .woocommerce .star-rating:before",
                ),
            ),
            'search_icon_size' => array(
                'css' => 'font-size: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_icon_right:before",
                ),
            ),
            'search_icon_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_icon_right:before",
                ),
            ),
            'loader_icon_size' => array(
                'css' => 'width: %1$s;height: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_loader_layout_one",
                ),
            ),
            'loader_icon_color' => array(
                'css' => 'border-left-color: %1$s;border-right-color:%1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_loader_layout_one",
                ),
            ),
            'feature_image_width' => array(
                'css' => 'width:calc(100%% - %1$s);',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_content_wrapper",
                ),
            ),
            'selected_category_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo-custom-select, %%order_class%% .dnwoo-custom-select.active, %%order_class%% .dnwoo-custom-select:active",
                    'hover' => "%%order_class%% .dnwoo-custom-select:hover, %%order_class%% .dnwoo-custom-select.active:hover",
                ),
            ),
            'category_list_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo-select-options li",
                    'hover' => "%%order_class%% .dnwoo-select-options li:hover",
                ),
            ),
            'category_icon_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo-custom-select:after",
                    'hover' => "%%order_class%% .dnwoo-custom-select:after::hover",
                ),
            ),
            'category_icon_size' => array(
                'css' => 'font-size: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo-custom-select:after",
                    'hover' => "%%order_class%% .dnwoo-custom-select:after::hover",
                ),
            ),
            'selected_category_width' => array(
                'css' => 'width: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_form_option_category",
                ),
            ),
            'category_position' => array(
                'css' => 'flex-direction: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_form_customone .dnwoo_ajax_category_search_field",
                ),
            ),
            'search_button_position' => array(
                'css' => 'flex-direction: %1$s;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_ajax_search_form_customone",
                ),
            ),
        );

        foreach ($css_settings as $key => $value) {
            DNWoo_Common::set_css($key, $value['css'], $value['selector'], $render_slug, $this);
        }
    }

    protected function apply_spacing( $render_slug ) {
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'search_field' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_form_searcharea input[type="search"]',
                'type' => array('margin', 'padding'), //
            ),
            'search_result' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_items',
                'type' => array('margin', 'padding'), //
            ),
            'search_result_item' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_wrapper_inner',
                'type' => 'padding', //
            ),
            'title' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_title',
                'type' => array('margin', 'padding'), //
            ),
            'excerpt' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_des',
                'type' => array('margin', 'padding'), //
            ),
            'featured' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_img',
                'type' => array('margin', 'padding'), //
            ),
            'price' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_pricewithsalecombined',
                'type' => 'margin', //
            ),
            'on_sale' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_onsale_withprice',
                'type' => array('margin', 'padding'), //
            ),
            'star_rating' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_ratting',
                'type' => 'margin', //
            ),
            'rating_count' => array(
                'selector' => '%%order_class%% .dnwoo_ajax_search_item_ratting_count span',
                'type' => 'margin', //
            ),
        );

        foreach ($customMarginPadding as $key => $value) {
            if (is_array($value['type'])) {
                foreach ($value['type'] as $type) {
                    DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key . "_" . $type, $value['selector'], $type);
                }
            } else {
                DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key . "_" . $value['type'], $value['selector'], $value['type']);
            }
        }

        DNWoo_Common::apply_mp_set_style($render_slug, $this->props, 'category_margin', "%%order_class%% .dnwoo_ajax_search_form_option_category", "margin");
        DNWoo_Common::apply_mp_set_style($render_slug, $this->props, 'category_padding', "%%order_class%% .dnwoo_ajax_search_form_option_category .dnwoo_ajax_search_option_frontend", "padding");
    }
}
new NextWooAjaxSearch;