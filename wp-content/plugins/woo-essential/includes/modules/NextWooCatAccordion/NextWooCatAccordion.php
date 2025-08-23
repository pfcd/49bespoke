<?php


class DNWooCatAccordion extends ET_Builder_Module {

	public $slug       = 'dnwoo_cat_accordion';
    protected $next_woocarousel_count = 0 ;
	public $vb_support = 'on';
	public $icon_path = null;
	public $folder_name;
	public $text_shadow;
	public $margin_padding;
	public $_additional_fields_options;


	protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-category-accordion-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

    public function init() {
        $this->name = esc_html__( 'Woo Category Accordion', 'dnwooe' );
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';


        $this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles('dnwoo_cat_accordion');

        $this->settings_modal_toggles['general']['toggles']['accordion_settings'] = esc_html__( 'Accordion Settings', 'dnwooe');
        $this->settings_modal_toggles['general']['toggles']['image_overlay'] = esc_html__( 'Image Overlay', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['product_settings'] = array(
            'title'             =>  esc_html__( 'Category', 'dnwooe'),
            // 'priority'	        =>	78,
            'sub_toggles'       => array(
                'product_name'   => array(
                    'name' => esc_html__('Name', 'dnwooe')
                ),
                'product_count'   => array(
                    'name' => esc_html__('Count', 'dnwooe')
                ),
                'product_desc'   => array(
                    'name' => esc_html__('Description', 'dnwooe')
                )
            ),
            'tabbed_subtoggles' => true,
        );

        $this->advanced_fields          = array(
            'text'      => false,
            'fonts'        => array(
                'name' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_cateaccordion_categories a',
                        'text_align' => '%%order_class%% .dnwoo_cateaccordion_categories',
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
                        'main' => '%%order_class%% .dnwoo_cateaccordion_count',
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
                'desc' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_cateaccordion_description',
                        'important' => 'all'
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle'    => 'product_desc',
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
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_cateaccordion_child',
							'border_styles' => '%%order_class%% .dnwoo_cateaccordion_child',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_accordion_image_settings',
                ),
                'content_wrapper'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_cateaccordion_conent',
							'border_styles' => '%%order_class%% .dnwoo_cateaccordion_conent',
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
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_cateaccordion_child',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_cat_accordion_image_settings',
                ),
                'content_wrapper_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnwoo_cateaccordion_conent',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Product', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'product_settings',
                    'sub_toggle'   => 'product_name'
                ),
            ),
            'height'    => false
        );
        $this->custom_css_fields = array(
            'product_name'   => array(
                'label' => esc_html__('Category Name', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_cateaccordion_categories a',
            ),
            'product_count'   => array(
                'label' => esc_html__('Product Count', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_cateaccordion_count',
            ),
            'product_desc'   => array(
                'label' => esc_html__('Product Description', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_cateaccordion_description',
            ),
            'product_image'   => array(
                'label' => esc_html__('Product Image', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_cateaccordion_child',
            ),
            'content_wrapper'   => array(
                'label' => esc_html__('Content Wrapper', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_cateaccordion_conent',
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
                'default'          => 3,
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
            '__nextwoocatdata'    => array(
                'type'                => 'computed',
                'computed_callback'   => array('DNWooCatAccordion', 'get_products'),
                'computed_depends_on' => array(
                    'hide_empty',
                    'order',
                    'category_number',
                    'include_categories',
                    'orderby',
                    'offset',
                    'thumbnail_size'
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
            'show_product_desc' => array(
                'label'           => esc_html__( 'Show Product Description', 'dnwooe' ),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'on',
                'tab_slug'        => 'general',
                'toggle_slug'     => 'display_setting',
                'description'     => esc_html__( 'Choose whether or not show the product description should be visible.', 'dnwooe' ),
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
				)
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
            'dnwoo_cat_accordion_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_name_margin'	=> array(
				'label'           		=> esc_html__('Category Name Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_name_padding'	=> array(
				'label'           		=> esc_html__('Category Name Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_count_margin'	=> array(
				'label'           		=> esc_html__('Product Count Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_count_padding'	=> array(
				'label'           		=> esc_html__('Product Count Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_desc_margin'	=> array(
				'label'           		=> esc_html__('Product Description Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_desc_padding'	=> array(
				'label'           		=> esc_html__('Product Description Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_image_margin'	=> array(
				'label'           		=> esc_html__('Product Image Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnwoo_cat_accordion_product_image_padding'	=> array(
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
        $opt = array(
            'hover'           		=> 'tabs',
            'description'           => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $content_bg_color    = DNWoo_Common::background_fields($this, "content_", "Background Color", "dnwoo_content_bg", "general", $opt);
        $image_overlay_bg_color    = DNWoo_Common::background_fields($this, "image_overlay_", "Image Overlay Color", "image_overlay", "general", array(
            'description' => esc_html__('Add a background fill color or gradient for the accordion image overlay', 'dnwooe')
        ));

        return array_merge($fields, $show_hide, $accordion, $margin_padding, $content_bg_color, $image_overlay_bg_color);
    }

    public static function get_products() {
        return '';
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}
        wp_enqueue_style('dnwoo_cat_accordion');
        wp_enqueue_script('dnwoo-image-accordion');

        $products_number    = $this->props['category_number'];
        $order              = $this->props['order'];
        $orderby            = $this->props['orderby'];
        $include_categories = $this->props['include_categories'];
        $hide_empty         = $this->props['hide_empty'];
        $offset             = $this->props['offset'];
        $thumbnail_size     = $this->props['thumbnail_size'];
        $show_product_count = "on" == $this->props['show_product_count'];
        $show_product_desc  = "on" == $this->props['show_product_desc'];
        $is_name_stacked    = "on" == $this->props['display_stack'] ? 'dnwoo_product_accordion_grid_stack' : '';

        $accordion_style = $this->props['accordion_style'];
        $expand_last_item = $this->props['expand_last_item'];

        $settings = array(
            'products_number'    => $products_number,
            'order'              => $order,
            'orderby'            => $orderby,
            'include_categories' => $include_categories,
            'hide_empty'         => $hide_empty,
            'offset'             => $offset,
            'thumbnail_size'     => $thumbnail_size,
            'request_from'       => 'frontend'
        );
        $categories = dnwoo_get_category($settings);
        $single_product       = '';
        $demo_image = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDUwMCA1MDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxwYXRoIGZpbGw9IiNFQkVCRUIiIGQ9Ik0wIDBoNTAwdjUwMEgweiIvPgogICAgICAgIDxyZWN0IGZpbGwtb3BhY2l0eT0iLjEiIGZpbGw9IiMwMDAiIHg9IjY4IiB5PSIzMDUiIHdpZHRoPSIzNjQiIGhlaWdodD0iNTY4IiByeD0iMTgyIi8+CiAgICAgICAgPGNpcmNsZSBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBjeD0iMjQ5IiBjeT0iMTcyIiByPSIxMDAiLz4KICAgIDwvZz4KPC9zdmc+Cg==";

        if(count($categories) > 0) {
            foreach ($categories as $key => $value) {
                # code...
                $image = !empty($value->image) ? sprintf('background-image: url(%1$s);', $value->image) : sprintf('background-image: url(%1$s)', $demo_image);
                $count = (!empty($value->count) && $show_product_count) ? sprintf('<span class="dnwoo_cateaccordion_count %2$s">(%1$s)</span>', $value->count, $is_name_stacked) : '';
                $desc = (!empty($value->description) && $show_product_desc) ? sprintf(' <div class="dnwoo_cateaccordion_description">%1$s</div>', $value->description) : '';

                $single_product .= sprintf(
                    '<div onclick="location.href=\'%5$s\';" class="dnwoo_cateaccordion_child" style="%1$s; cursor:pointer;">
                        <div class="dnwoo_cateaccordion_bg"></div>
                        <div class="dnwoo_cateaccordion_child_content_wrapper">
                            <div class="dnwoo_cateaccordion_conent" data-active-on-load="">
                                <div class="dnwoo_cateaccordion_categories">
                                <a href="%5$s">%3$s</a>
                                %2$s</div>
                                %4$s
                            </div>
                        </div>
                    </div>',
                    $image,
                    $count,
                    $value->name,
                    $desc,
                    $value->link
                );
            }
        }

        $this->apply_background_css( $render_slug );
        $this->apply_css( $render_slug );
        $this->apply_spacing_css( $render_slug );
        return sprintf(
            '<div class="dnwoo_cateaccordion">
                <div class="dnwoo_cateaccordion_wrapper" data-accordion-type="%2$s"  data-expand-last-item="%3$s">
                    %1$s
                </div>
            </div>',
            $single_product,
            $accordion_style,
            $expand_last_item
        );
    }

    public function apply_spacing_css( $render_slug ) {
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_cat_accordion_content_wrapper' => array(
                'selector'  => '%%order_class%% .dnwoo_cateaccordion_conent',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_accordion_product_name' => array(
                'selector'  => '%%order_class%% .dnwoo_cateaccordion_categories a',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_accordion_product_count' => array(
                'selector'  => '%%order_class%% .dnwoo_cateaccordion_count',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_accordion_product_desc' => array(
                'selector'  => '%%order_class%% .dnwoo_cateaccordion_description',
                'type'      => array('margin','padding') //
            ),
            'dnwoo_cat_accordion_product_image' => array(
                'selector'  => '%%order_class%% .dnwoo_cateaccordion_child',
                'type'      => array('margin','padding') //
            ),
        );

        DNWoo_Common::apply_spacing($customMarginPadding, $render_slug, $this->props);
    }
    public function apply_css( $render_slug ) {
        $gutter_space_direction = $this->props['accordion_direction'] === "row" ? "right" : "top";
        $css_settings = array(
            // Option slug should be the key
            'accordion_direction'   => array(
                'css'   => 'flex-direction: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_cateaccordion_wrapper",
                ),
            ),
            'accordion_height'   => array(
                'css'   => 'height: %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_cateaccordion_wrapper",
                ),
            ),
            // 'active_image_width'   => array(
            //     'css'   => 'flex: %1$s 0 auto;',
            //     'selector'  => array(
            //         'desktop' => "%%order_class%% .dnwoo_cateaccordion_child.dnwoo-active",
            //     ),
            // ),
            'gutter_space'   => array(
                'css'   => 'margin-' . $gutter_space_direction . ': %1$s !important;',
                'selector'  => array(
                    'desktop' => "%%order_class%% .dnwoo_cateaccordion_child",
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
                'selector'    => '%%order_class%% .dnwoo_cateaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_cateaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnwoo_cateaccordion_child.dnwoo-active',
                'declaration' => sprintf('flex: %1$s 0 auto;', $active_image_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
    }

    public function apply_background_css( $render_slug ) {
        $gradient_opt = array(
            // total slug example = content_bg_color
            'content_'  => array(
                "desktop" => "%%order_class%% .dnwoo_cateaccordion_child .dnwoo_cateaccordion_conent",
                "hover"   => "%%order_class%% .dnwoo_cateaccordion_child .dnwoo_cateaccordion_conent:hover",
            ),
            'image_overlay_'    => array(
                "desktop" => "%%order_class%% .dnwoo_cateaccordion_child:hover .dnwoo_cateaccordion_bg",
            )
        );
        DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }

}
new DNWooCatAccordion;