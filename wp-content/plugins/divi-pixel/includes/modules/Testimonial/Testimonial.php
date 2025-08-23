<?php

class DIPI_Testimonial extends DIPI_Builder_Module
{

    protected $module_credits = [
        'module_uri'  => 'https://divi-pixel.com/modules/testimonial',
        'author'      => 'Divi Pixel',
        'author_uri'  => 'https://divi-pixel.com'
    ];
    static function closing_tags($html) {
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);

        $closedtags = $result[1];
        $len_opened = count($openedtags);

        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
        
    }
    /**
    * Initial
    */
    public function init() 
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_testimonial';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Testimonial', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_testimonial';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'settings'   => esc_html__('Testimonial Settings', 'dipi-divi-pixel'),
                    'review_popup_setting'   => esc_html__('Review Popup Settings', 'dipi-divi-pixel'),
                    'testimonial' => esc_html__('Carousel Settings', 'dipi-divi-pixel'),
                ],
            ],

          'advanced' => [
                'toggles' => [
                    'text'   => array(
                        'title'             => et_builder_i18n( 'Text' ),
                        'priority'          => 45,
                        'tabbed_subtoggles' => true,
                        'bb_icons_support'  => true,
                        'sub_toggles'       => array(
                            'a'     => array(
                                'name' => 'A',
                                'icon' => 'text-link',
                            ),
                            'ul'    => array(
                                'name' => 'UL',
                                'icon' => 'list',
                            ),
                            'ol'    => array(
                                'name' => 'OL',
                                'icon' => 'numbered-list',
                            ),
                            'quote' => array(
                                'name' => 'QUOTE',
                                'icon' => 'text-quote',
                            ),
                        ),
                    ),
                    'header' => array(
                        'title'             => esc_html__( 'Heading Text', 'et_builder' ),
                        'priority'          => 49,
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
                            'h1' => array(
                                'name' => 'H1',
                                'icon' => 'text-h1',
                            ),
                            'h2' => array(
                                'name' => 'H2',
                                'icon' => 'text-h2',
                            ),
                            'h3' => array(
                                'name' => 'H3',
                                'icon' => 'text-h3',
                            ),
                            'h4' => array(
                                'name' => 'H4',
                                'icon' => 'text-h4',
                            ),
                            'h5' => array(
                                'name' => 'H5',
                                'icon' => 'text-h5',
                            ),
                            'h6' => array(
                                'name' => 'H6',
                                'icon' => 'text-h6',
                            ),
                        ),
                    ),
                    'testimonial_item' => esc_html__('Testimonial Item', 'dipi-divi-pixel'),
                    'image' => esc_html__('Image', 'dipi-divi-pixel'),
                    'rating' => esc_html__('Rating', 'dipi-divi-pixel'),
                    'testimonial_text' => [
                        'sub_toggles' => [
                            'testimonial_text' => [
                                'name' => 'Review',
                            ],
                            'testimonial_name' => [
                                'name' => 'Name',
                            ],
                            'company_name' => [
                                'name' => 'Company',
                            ],
                            'readmore' => [
                                'name' => 'Link',
                            ]
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__( 'Testimonial Text', 'dipi-divi-pixel'),
                    ],
                    'review_popup' => esc_html__('Review Popup', 'dipi-divi-pixel'),
                    'review_popup_text' => [
                        'sub_toggles' => [
                            'review_popup_text' => [
                                'name' => 'Review',
                            ],
                            'review_popup_name' => [
                                'name' => 'Name',
                            ],
                            'review_popup_company_name' => [
                                'name' => 'Company',
                            ]
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__( 'Review Popup Text', 'dipi-divi-pixel'),
                    ],
                    'navigation' => esc_html__('Navigation', 'dipi-divi-pixel'),
                    'pagination' => esc_html__('Pagination', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config() 
    {
        
        $fields = [];

        $fields['swiper_container'] = [
            'label'    => esc_html__('Swiper Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-container',
        ];

        $fields['item'] = [
            'label'    => esc_html__('Testimonial Box', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-item',
        ];

        $fields['image'] = [
            'label'    => esc_html__('Profile Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-img',
        ];

        $fields['star_active'] = [
            'label' => esc_html__('Star (Active)', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-star-rating',
        ];

        $fields['star_np_active'] = [
            'label' => esc_html__('Star (Inactive)', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-star-rating-o',
        ];

        $fields['navigation'] = [
            'label'    => esc_html__('Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-arrow-button',
        ];
  
        $fields['testimonial_name'] = [
            'label'    => esc_html__('Testimonial Name', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-name',
        ];

        $fields['testimonial_text'] = [
            'label'    => esc_html__('Testimonial Text', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-testimonial-text',
        ];

        $fields['testimonial_readmore'] = [
            'label'    => esc_html__('Readmore Link', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-open-popup-link',
        ];

        $fields['company'] = [
            'label'    => esc_html__('Company Name', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-company-name',
        ];

        $fields['review_popup_name'] = [
            'label'    => esc_html__('Review Popup Name', 'dipi-divi-pixel'),
            'selector' => '.dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-name',
        ];
        
        $fields['review_popup_text'] = [
            'label'    => esc_html__('Review Popup Text', 'dipi-divi-pixel'),
            'selector' => '.dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-text',
        ];

        $fields['review_popup_company'] = [
            'label'    => esc_html__('Review Popup Company Name', 'dipi-divi-pixel'),
            'selector' => '.dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name > a',
        ];        

        return $fields;
    }

    /**
    * Setting Fields
    */
    public function get_fields() 
    {

        $fields = [];

        $fields["item_align"] = [
            'label' => esc_html__('Content Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'testimonial_item'
        ];

        $fields['total_testimonial'] = [
            'label' => esc_html__( 'Total Testimonials', 'dipi-divi-pixel'),
            'description' => 'Total number of testimonials (excluding post ID’s added to Include Testimonials field). Set 0 to display only posts defined by ID.',
            'type' => 'text',
            'option_category' => 'configuration',
            'default' => '10',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['excluded_post_ids'] = [
            'label' => esc_html__('Exclude Testimonials', 'dipi-faq'),
            'description' => esc_html__('A comma separated list of Testimonial IDs to exclude.', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'computed_affects' => ['__testimonial']
        ];

        $fields['included_post_ids'] = [
            'label' => esc_html__('Include Testimonials', 'dipi-faq'),
            'description' => esc_html__('A comma separated list of Testimonial IDs to include on top of the ones from the selected Testimonials.', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'computed_affects' => ['__testimonial']
        ];
        $fields['remove_empty_html'] = [
            'label' =>  esc_html__('Remove HTML of Empty Element', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];
        $fields['use_hide_img'] = [
            'label' =>  esc_html__('Hide Image', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_hide_rating'] = [
            'label' =>  esc_html__('Hide Rating', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_hide_review'] = [
            'label' =>  esc_html__('Hide Review', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_hide_readmore'] = [
            'label' =>  esc_html__('Hide Readmore Link', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'show_if' => ['use_hide_review' => 'off'],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_hide_company'] = [
            'label' =>  esc_html__('Hide Company', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];
        
        $fields['use_hide_company_link'] = [
            'label' =>  esc_html__('Hide Company Link', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_hide_name'] = [
            'label' =>  esc_html__('Hide Name', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['review_length'] = [
            'label' => esc_html__( 'Show Total Review Words', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '15',
            'show_if' => ['use_hide_review' => 'off'],
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['readmore_text'] = [
            'label' => esc_html__( 'Readmore Link Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__( 'Read More', 'dipi-divi-pixel'),
            'unitless' => true,
            'show_if' => ['use_hide_readmore' => 'off'],
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];
        $fields['orderby']     = [
            'label'            => esc_html__( 'Order By', 'et_builder' ),
            'type'             => 'select',
            'option_category'  => 'configuration',
            'options'          => array(
                'date_desc'  => esc_html__( 'Date: new to old', 'et_builder' ),
                'date_asc'   => esc_html__( 'Date: old to new', 'et_builder' ),
                'title_asc'  => esc_html__( 'Title: a-z', 'et_builder' ),
                'title_desc' => esc_html__( 'Title: z-a', 'et_builder' ),
                'rand'       => esc_html__( 'Random', 'et_builder' ),
            ),
            'toggle_slug'      => 'settings',
            'description'      => esc_html__( 'Here you can adjust the order in which testimonials are displayed.', 'dipi-divi-pixel' ),
            'computed_affects' => [
                '__testimonial'
            ],
            'default_on_front' => 'date_desc',
        ];
        $fields['review_type'] = [
            'label' => esc_html__('Display by Review Type', 'dipi-divi-pixel'),
            'type' => 'multiple_checkboxes',
            'options' => [
                'default' => esc_html__( 'Post Type', 'dipi-divi-pixel' ),
                'facebook'  => esc_html__( 'Facebook', 'dipi-divi-pixel' ),
                'google'  => esc_html__( 'Google', 'dipi-divi-pixel' ),
                'woo'  => esc_html__( 'WooCommerce', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['testimonial_categories'] = [
            'label' => esc_html__( 'Display by Categories', 'dipi-divi-pixel'),
            'type' => 'categories',
            'renderer_options' => [
                'use_terms' => true,
                'term_name' => 'testimonial_cat',
            ],
            'taxonomy_name' => 'testimonial_cat',
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['testimonial_suppress_filters'] = [
            'label' => esc_html__( 'Suppress Filters', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'description'      => esc_html__( 'This option should be disabled when you need to use a filter of other plugins such as WPML', 'dipi-divi-pixel' ),
            'toggle_slug' => 'settings',
            'computed_affects' => [
                '__testimonial'
            ],
        ];

        $fields['use_show_popup_rating'] = [
            'label' =>  esc_html__('Display Rating', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'toggle_slug' => 'review_popup_setting',
        ];

        $fields['use_show_popup_review'] = [
            'label' =>  esc_html__('Display Review', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'toggle_slug' => 'review_popup_setting',
        ];

        $fields['use_show_popup_image'] = [
            'label' =>  esc_html__('Display Image', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'toggle_slug' => 'review_popup_setting',
        ];

        $fields['use_show_popup_company'] = [
            'label' =>  esc_html__('Display Company', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'toggle_slug' => 'review_popup_setting',
        ];

        $fields['use_show_popup_name'] = [
            'label' =>  esc_html__('Display Name', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'on',
            'toggle_slug' => 'review_popup_setting',
        ];

        $fields['rating_size'] = [
            'label' => esc_html__('Rating Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'rating',
            'default' => '22px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 1,
                'min' => 5,
                'max' => 50,
            ],
        ];

        $fields['rating_spacing'] = [
            'label' => esc_html__('Rating Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'rating',
            'default' => '0px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 1,
                'min' => 0,
                'max' => 100,
            ],
        ];

        $fields['rating_color'] = [
            'label' => esc_html__( 'Rating Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'rating',
            'default' => '#ec971f',
        ];

        $fields['empty_rating_color'] = [
            'label' => esc_html__( 'Empty Rating Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'rating',
            'default' => '#ec971f',
        ];

        $fields['columns'] = [
            'label' => esc_html__('Number of Columns', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '4',
            'range_settings' => [
                'min'  => '1',
                'max'  => '10',
                'step' => '1'
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'testimonial'
        ];

        $fields['space_between'] = [
            'label' => esc_html__('Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '50',
            'range_settings' => [
                'min'  => '5',
                'max'  => '100',
                'step' => '1'
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'testimonial'
        ];

        $fields['container_padding'] = [
            'label' => esc_html__('Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '30px|30px|60px|30px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding'
        ];

        $fields['effect'] = [
            'label' => esc_html__( 'Effect', 'dipi-divi-pixel' ),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'coverflow' => esc_html__( 'Coverflow', 'dipi-divi-pixel' ),
                'slide' => esc_html__( 'Slide', 'dipi-divi-pixel' )
            ],
            'default' => 'slide',
            'toggle_slug' => 'testimonial'
        ];

        $fields['rotate'] = [
            'label' => esc_html__( 'Rotate', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings ' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'default' => '50',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'validate_unit'     => true,
            'toggle_slug'     => 'testimonial'
        ];

        $fields['slide_shadows'] = [
            'label' => esc_html__( 'Slide Shadow', 'dipi-divi-pixel' ),
            'type' => 'yes_no_button',
            'options' => [
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                'off' => esc_html__( 'No', 'dipi-divi-pixel' )
            ],
            'default' => 'on',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'toggle_slug' => 'testimonial'
        ];

        $fields["shadow_overlay_color"] = [
            'label' => esc_html__( 'Side Item Shadow Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'testimonial_item'
        ];

        $fields['speed'] = [
            'label' => esc_html__( 'Transition Duration', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings' => [
                'min'  => '1',
                'max'  => '5000',
                'step' => '100'
            ],
            'default' => 500,
            'validate_unit' => false,
            'toggle_slug'   => 'testimonial'
        ];

        $fields['loop'] = [
            'label' => esc_html__( 'Loop', 'dipi-divi-pixel' ),
            'type' => 'yes_no_button',
            'option_category'  => 'configuration',
            'options' => [
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                'off' => esc_html__( 'No', 'dipi-divi-pixel' )
            ],
            'default' => 'off',
            'toggle_slug' => 'testimonial'
        ];

        $fields['autoplay'] = [
            'label' => esc_html__( 'Autoplay', 'dipi-divi-pixel' ),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default'           => 'off',
            'toggle_slug' => 'testimonial'
        ];

        $fields['pause_on_hover'] = [
            'label' =>  esc_html__('Pause on Hover', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel')
            ],
            'show_if' => [
                'autoplay'  => 'on',
            ],
            'toggle_slug'     => 'testimonial',
            'default'           => 'on'
        ];

        $fields['autoplay_speed'] = [
            'label' => esc_html__( 'Autoplay Speed', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
            'min'  => '1',
            'max'  => '10000',
            'step' => '500'
            ),
            'default' => 5000,
            'validate_unit' => false,
            'show_if' => array(
                'autoplay' => 'on',
            ),
            'toggle_slug' => 'testimonial'
        ];

        $fields['navigation'] = [
            'label' =>  esc_html__( 'Navigation', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'testimonial',
            'default' => 'off'
        ];
        $fields['navigation_on_hover'] = [
            'label' =>  esc_html__( 'Show Navigation on Hover', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'testimonial',
            'show_if'   => ['navigation'=>'on'],
            'default' => 'off'
        ];     
        $fields['pagination'] = [
            'label' =>  esc_html__( 'Pagination', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'toggle_slug' => 'testimonial',
            'default' => 'off'
        ];

        $fields['dynamic_bullets'] = [
            'label' =>  esc_html__( 'Dynamic Bullets', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on' => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'carsousel',
            'default'           => 'on'
        ];

        $fields['centered'] = [
            'label' => esc_html__( 'Centered', 'dipi-divi-pixel' ),
            'type' => 'yes_no_button',
            'option_category'  => 'configuration',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default'          => 'off',
            'toggle_slug'     => 'testimonial'
        ];

        $fields['use_navi_prev_icon'] = [
            'label' =>  esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation'
        ];

        $fields['navi_prev_icon'] = [
            'label' => esc_html__( 'Select Previous Nav icon', 'dipi-divi-pixel' ),
            'type'  => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['use_navi_prev_icon' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'navigation'
        ];

        $fields['use_navi_next_icon'] = [
            'label' =>  esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default'   => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation'
        ];

        $fields['navi_next_icon'] = [
            'label' => esc_html__( 'Select Next Nav icon', 'dipi-divi-pixel' ),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' =>['use_navi_next_icon' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation'
        ];

        $fields['navi_size'] = [
            'label' => esc_html__( 'Font Size', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ),
            'default' => 50,
            'validate_unit' => false,
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation',
            'mobile_options' => true,
        ];

       $fields['navi_padding']  = [
            'label' => esc_html__( 'Icon Padding', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'default'       => 10,
            'validate_unit'   => false,
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navi_color']  = [
            'label' => esc_html__( 'Arrow Color', 'dipi-divi-pixel' ),
            'type'  =>  'color-alpha',
            'default'   => et_builder_accent_color(),
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navi_bg_color'] = [
            'label' => esc_html__( 'Arrow Background', 'dipi-divi-pixel' ),
            'type'  =>  'color-alpha',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navi_circle'] = [
            'label' =>  esc_html__( 'Circle Arrow', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'   => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'navigation'
        ];

        $fields['navi_position_left'] = [
            'label' => esc_html__('Left Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66',
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'navigation'
        ];

        $fields['navi_position_right'] = [
            'label' => esc_html__('Right Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66',
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation'
        ];

        $fields['pagi_position'] = [
            'label' => esc_html__('Pagination Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-40',
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'unitless' => true,
            'show_if' => ['pagination' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' =>  'pagination'
        ];

        $fields['pagi_color'] = [
            'label' => esc_html__( 'Pagination Color', 'dipi-divi-pixel' ),
            'type'  =>  'color-alpha',
            'default' => '#d8d8d8',
            'show_if' => ['pagination' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' =>  'pagination'
        ];

        $fields['pagi_active_color'] = [
            'label' => esc_html__( 'Pagination Active Color', 'dipi-divi-pixel' ),
            'type'  =>  'color-alpha',
            'default'   => et_builder_accent_color(),
            'show_if'   => ['pagination' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug' =>  'pagination'
        ];

        $fields['img_width'] = [
            'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '80px',
            'default_unit' => 'px',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'image'
        ];

        $fields['item_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'testimonial_item'
        ];

        $fields['popup_color'] = [
            'label' => esc_html__( 'Popup Background Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'review_popup',
            'show_if' => ['use_hide_readmore' => 'off'],
            'default' => '#fff',
        ];

        $fields['popup_size'] = [
            'label' => esc_html__('Popup Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'review_popup',
            'show_if' => ['use_hide_readmore' => 'off'],
            'default' => '620px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 10,
                'min' => 5,
                'max' => 1000,
            ],
        ];

        $fields['close_icon_bg_color'] = [
            'label' => esc_html__( 'Close Icon Background Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'review_popup',
            'show_if' => ['use_hide_readmore' => 'off'],
            'hover'  => 'tabs',
            'default' => '#000',
        ];

        $fields['close_icon_color'] = [
            'label' => esc_html__( 'Close Icon Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'review_popup',
            'show_if' => ['use_hide_readmore' => 'off'],
            'default' => '#fff',
            'hover'  => 'tabs',
        ];

        $fields['__testimonial'] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_Testimonial', 'get_testimonial'],
            'computed_depends_on' => [
                'total_testimonial',
                'excluded_post_ids',
                'included_post_ids',
                'remove_empty_html',
                'use_hide_img',
                'use_hide_name',
                'use_hide_review',
                'review_length',
                'use_hide_company',
                'use_hide_company_link',
                'use_hide_rating',
                'use_hide_readmore',
                'readmore_text',
                'review_type',
                'testimonial_categories',
                'orderby',
                'testimonial_suppress_filters',
            ],
            'computed_minimum'=> [
                'total_testimonial',
            ] 
        ];

        $additional_options = [];

        $additional_options["item_bg_color"] = [
            'label'             => esc_html__("Background", 'dipi-divi-pixel'),
            'type'              => "background-field",
            'base_name'         => "item_bg",
            'context'           => "item_bg",
            'option_category'   => "layout",
            'custom_color'      => true,
            'default'           => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if'   => "on",
            'tab_slug'          => "advanced",
            'toggle_slug'       => "testimonial_item",
            'background_fields' =>  array_merge(
                ET_Builder_Element::generate_background_options(
                    "item_bg", "gradient", "advanced", "testimonial_item", "item_bg_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "item_bg", "color", "advanced", "testimonial_item", "item_bg_color"
                ),
                ET_Builder_Element::generate_background_options(
                    "item_bg", "image", "advanced", "testimonial_item", "item_bg_image"
                )
            )
        ];


        $additional_options = array_merge(
            $additional_options, 
            $this->generate_background_options( 
                "item_bg", 'skip', "advanced", "testimonial_item", "item_bg_gradient"
            )
        );

        $additional_options = array_merge(
            $additional_options, 
            $this->generate_background_options(
                "item_bg", 'skip', "advanced", "testimonial_item", "item_bg_color"
            )
        );

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "item_bg", 'skip', "advanced", "testimonial_item", "item_bg_image"
            )
        );

        return array_merge($fields, $additional_options);
    }

    /**
    * Advanced Fields
    */
    public function get_advanced_fields_config() 
    {

        $advanced_fields = [];

        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"]       = [
            'link'     => [
                'label'       => et_builder_i18n( 'Link' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} a:not(%%order_class%% .dipi-open-popup-link), .dipi-testimonial-review-popup-open  %%order_class%%-popup a:not(%%order_class%% .dipi-open-popup-link)",
                    'color' => "{$this->main_css_element} .dipi-testimonial-item a:not(%%order_class%% .dipi-open-popup-link), .dipi-testimonial-review-popup-open  %%order_class%%-popup a:not(%%order_class%% .dipi-open-popup-link)",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'a',
            ],
            'ul'       => [
                'label'       => esc_html__( 'Unordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} ul li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ul li",
                    'color'       => "{$this->main_css_element} ul li, {$this->main_css_element} ol li > ul li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ul li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ol li > ul li",
                    'line_height' => "{$this->main_css_element} ul li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ul li",
                    'item_indent' => "{$this->main_css_element} ul, .dipi-testimonial-review-popup-open  %%order_class%%-popup ul",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ul',
            ],
            'ol'       => [
                'label'       => esc_html__( 'Ordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => "{$this->main_css_element} ol li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ol li",
                    'color'       => "{$this->main_css_element} ol li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ol li",
                    'line_height' => "{$this->main_css_element} ol li, .dipi-testimonial-review-popup-open  %%order_class%%-popup ol li",
                    'item_indent' => "{$this->main_css_element} ol, .dipi-testimonial-review-popup-open  %%order_class%%-popup ol",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ol',
            ],
            'quote'    => [
                'label'       => esc_html__( 'Blockquote', 'et_builder' ),
                'css'         => array(
                    'main'  => "{$this->main_css_element} blockquote, .dipi-testimonial-review-popup-open  %%order_class%%-popup blockquote",
                    'color' => "{$this->main_css_element} blockquote, .dipi-testimonial-review-popup-open  %%order_class%%-popup blockquote",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'quote',
            ],
            'header'   => [
                'label'       => esc_html__( 'Heading', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h1, .dipi-testimonial-review-popup-open  %%order_class%%-popup h1",
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h1',
            ],
            'header_2' => [
                'label'       => esc_html__( 'Heading 2', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h2, .dipi-testimonial-review-popup-open  %%order_class%%-popup h2",
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h2',
            ],
            'header_3' => [
                'label'       => esc_html__( 'Heading 3', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h3, .dipi-testimonial-review-popup-open  %%order_class%%-popup h3",
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h3',
            ],
            'header_4' => [
                'label'       => esc_html__( 'Heading 4', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h4, .dipi-testimonial-review-popup-open  %%order_class%%-popup h4",
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h4',
            ],
            'header_5' => [
                'label'       => esc_html__( 'Heading 5', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h5, .dipi-testimonial-review-popup-open  %%order_class%%-popup h5",
                ),
                'font_size'   => array(
                    'default' => '16px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h5',
            ],
            'header_6' => [
                'label'       => esc_html__( 'Heading 6', 'et_builder' ),
                'css'         => array(
                    'main' => "{$this->main_css_element} h6, .dipi-testimonial-review-popup-open  %%order_class%%-popup h6",
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h6',
            ],
        ];
        $advanced_fields["fonts"]["testimonial_name"] = [
            'label'    => esc_html__('Testimonial Name', 'dipi-divi-pixel'),
            'css'      => [
                'main' => "%%order_class%% .dipi-testimonial-name, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-name",
            ],
            'font_size' => [
                'default' => '18px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'testimonial_text',
            'sub_toggle'  => 'testimonial_name'
        ];

        $advanced_fields["fonts"]["testimonial_text"] = [
            'label' => esc_html__('Testimonial Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-testimonial-text, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-text",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'   => '1',
                    'max'   => '3',
                    'step'  => '0.1',
                 ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'testimonial_text',
            'sub_toggle'  => 'testimonial_text'
        ];

        $advanced_fields["fonts"]["company_name"] = [
            'label' => esc_html__('Company Name', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-company-name, %%order_class%% .dipi-company-name > a, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name > a",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1',
                 ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'testimonial_text',
            'sub_toggle'  => 'company_name'
        ];

        $advanced_fields["fonts"]["readmore"] = [
            'label' => esc_html__('Readmore Link', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-open-popup-link",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1',
                 ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'testimonial_text',
            'sub_toggle'  => 'readmore'
        ];

        $advanced_fields["fonts"]["review_popup_name"] = [
            'label'    => esc_html__('Review Popup Name', 'dipi-divi-pixel'),
            'css'      => [
                'main' => ".dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-name",
            ],
            'font_size' => [
                'default' => '18px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'review_popup_text',
            'sub_toggle'  => 'review_popup_name'
        ];

        $advanced_fields["fonts"]["review_popup_text"] = [
            'label' => esc_html__('Review Popup Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi-testimonial-review-popup-open  %%order_class%%-popup div.dipi-testimonial-text",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'   => '1',
                    'max'   => '3',
                    'step'  => '0.1',
                 ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'review_popup_text',
            'sub_toggle'  => 'review_popup_text'
        ];

        $advanced_fields["fonts"]["review_popup_company_name"] = [
            'label' => esc_html__('Review Popup Company Name', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-company-name > a",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1',
                 ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'review_popup_text',
            'sub_toggle'  => 'review_popup_company_name'
        ];

        $advanced_fields["borders"]['default'] = [
            'css' => [
              'main' => [
                    'border_radii' => "%%order_class%% .dipi-testimonial-item",
                    'border_styles' => "%%order_class%% .dipi-testimonial-item",
                ],
            ]
        ];

        $advanced_fields["borders"]["profile_image"] = [
            'css' => [
              'main' => [
                    'border_radii' => "%%order_class%% .dipi-testimonial-img, .dipi-testimonial-review-popup-open %%order_class%%-popup .dipi-testimonial-img",
                    'border_styles' => "%%order_class%% .dipi-testimonial-img, .dipi-testimonial-review-popup-open %%order_class%%-popup .dipi-testimonial-img",
                ],
            ],
            'toggle_slug' => 'image',
        ];


        $advanced_fields["box_shadow"]['default'] = [
            'css' => [
              'main' => "%%order_class%% .dipi-testimonial-item",
            ],
        ];

        $advanced_fields["box_shadow"]["profile_image"] = [
            'css' => [
              'main' => "%%order_class%% .dipi-testimonial-img, .dipi-testimonial-review-popup-open %%order_class%%-popup .dipi-testimonial-img",
            ],
            'toggle_slug' => 'image',
        ];

        $advanced_fields["filters"] = [
            'child_filters_target' => [
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image',
            ]
        ];

        $advanced_fields["button"] = false;

        return $advanced_fields;
    }

    static function get_testimonial($args = array(), $conditional_tags = array(), $current_page = array(), $order_number=0, $order_class='') 
    {
        $defaults = [
            'remove_empty_html' => 'off',
            'use_show_popup_rating' => '',
            'use_show_popup_review' => '',
            'use_show_popup_company' => '',
            'use_show_popup_name' => '',
            'use_show_popup_image' => '',
            'popup_color' => '',
            'popup_size' => '',
            'close_icon_bg_color' => '',
            'close_icon_color' => '',
        ];
        $args = wp_parse_args($args, $defaults);
        $total_testimonial = isset($args['total_testimonial']) ? $args['total_testimonial'] : 10;
        $review_length = isset($args['review_length']) ? $args['review_length'] : 15;
        $remove_empty_html = isset($args['remove_empty_html']) ? $args['remove_empty_html']: 'off';
        $use_hide_img = isset($args['use_hide_img']) ? $args['use_hide_img'] : 'off';
        $use_hide_name = isset($args['use_hide_name']) ? $args['use_hide_name'] : 'off';
        $use_hide_review = isset($args['use_hide_review']) ? $args['use_hide_review'] : 'off';
        $use_hide_company = isset($args['use_hide_company']) ? $args['use_hide_company'] : 'off';
        $use_hide_company_link = isset($args['use_hide_company_link']) ? $args['use_hide_company_link'] : 'off';
        $use_hide_rating = isset($args['use_hide_rating']) ? $args['use_hide_rating'] : 'off';
        $review_type = !empty($args['review_type']) ? $args['review_type'] : '';
        $use_hide_readmore = isset($args['use_hide_readmore']) ? $args['use_hide_readmore'] : 'off';
        $readmore_text = isset($args['readmore_text']) ? $args['readmore_text'] : '';
        $review_type = explode('|', $review_type);
        $review_type_arr = [];
        $testimonial_categories = !empty($args['testimonial_categories']) ? $args['testimonial_categories'] : '';
        $testimonial_suppress_filters = !empty($args['testimonial_suppress_filters']) ? $args['testimonial_suppress_filters'] : 'on';
        $use_show_popup_rating = $args['use_show_popup_rating'];
        $use_show_popup_date = isset($args['use_show_popup_date']) ? $args['use_show_popup_date'] : '';
        $use_show_popup_title = isset($args['use_show_popup_title']) ? $args['use_show_popup_title'] : '';
        $use_show_popup_review = $args['use_show_popup_review'];
        $use_show_popup_company = $args['use_show_popup_company'];
        $use_show_popup_name = $args['use_show_popup_name'];
        $use_show_popup_image = $args['use_show_popup_image'];
        $excluded_post_ids = $args['excluded_post_ids'];
        $included_post_ids = $args['included_post_ids'];

        if(isset($review_type[2]) && 'on' == $review_type[0]) {
            $review_type_arr[0] = 'default';
        } else

        if(isset($review_type[2]) && 'on' == $review_type[1]) {
            $review_type_arr[1] = 'facebook';
        }

        if(isset($review_type[2]) && 'on' == $review_type[2]) {
            $review_type_arr[2] = 'google';
        }

        if(isset($review_type[2]) && 'on' == $review_type[3]) {
            $review_type_arr[3] = 'woo';
        }

        $testimonials_array = [];

        $cpt_args = [
            'post_type' => 'dipi_testimonial',
            'post_status' => 'publish',
            'posts_per_page' =>  -1,
        ];

        if(!empty($testimonial_categories)){
            $cpt_args['tax_query'] = [[
                'taxonomy' => 'testimonial_cat',
                'field' => 'term_id',
                'terms' => explode(",", $testimonial_categories),
                'operator' => 'IN'
            ]];
        }

        switch ( $args['orderby'] ) {
            case 'date_asc':
                $cpt_args['orderby'] = 'date';
                $cpt_args['order']   = 'ASC';
                break;
            case 'title_asc':
                $cpt_args['orderby'] = 'title';
                $cpt_args['order']   = 'ASC';
                break;
            case 'title_desc':
                $cpt_args['orderby'] = 'title';
                $cpt_args['order']   = 'DESC';
                break;
            case 'rand':
                $cpt_args['orderby'] = 'rand';
                break;
            default:
                $cpt_args['orderby'] = 'date';
                $cpt_args['order']   = 'DESC';
                break;
        }

        if ('' !== $args['excluded_post_ids']) {
            $cpt_args['post__not_in'] = explode(",", $args['excluded_post_ids']);
        }

       
        $all_ids =  explode(",", $args['included_post_ids']);
        
        if(count($all_ids) > 0 && !empty($args['included_post_ids'])){
            $total_testimonial = intval($total_testimonial) + count($all_ids);
        }
        
        $included_ids = [];
        foreach($all_ids as $id){
            $included_ids[] = intval(trim($id));
        }
        
        $cpt_args['suppress_filters'] = ($testimonial_suppress_filters === 'on');
     
        $included_testimonials = get_posts([
                'post_type' => 'dipi_testimonial',
                'post__in' =>  $included_ids,
                'orderby' => 'post__in'
            ]
        );
        
        $testimonials = (intval($args['total_testimonial']) !== 0)? get_posts($cpt_args): [];
        
        foreach($included_testimonials as $testimonial) {    
            $testimonials[] = $testimonial;
        }        
         
        foreach($testimonials as $testimonial) {
             
            $feature_image = (has_post_thumbnail($testimonial->ID)) ? wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ), 'full' )[0] : '';
            $review_type = get_post_meta($testimonial->ID, 'testimonial_type' , true);
            
            if(count($review_type_arr) !== 0) if(in_array($testimonial->ID, $included_ids) || in_array($review_type, $review_type_arr))  : else : continue; endif;
            
            $testimonials_array[] = [
                'title' => $testimonial->post_title,
                'content' => $testimonial->post_content,
                'profile_image' => get_post_meta($testimonial->ID, 'profile_image' , true),
                'feature_image' => $feature_image,
                'testimonial_email' => '',
                'testimonial_name' => get_post_meta($testimonial->ID, 'testimonial_name' , true),
                'company_name' => get_post_meta($testimonial->ID, 'company_name' , true),
                'company_link' => get_post_meta($testimonial->ID, 'company_link' , true),
                'testimonial_star' => get_post_meta($testimonial->ID, 'testimonial_star' , true),
                'testimonial_type' => get_post_meta($testimonial->ID, 'testimonial_type' , true),
                'facebook_id' => get_post_meta($testimonial->ID, 'facebook_id' , true)
            ];
        }

        $woo_args = [
            'type' => 'review'
        ];

        $woo_reviews = get_comments($woo_args);

        foreach($woo_reviews as $woo_review) {
            
            if(count($review_type_arr) !== 0) if(in_array('woo', $review_type_arr)) : else : continue; endif;

            if(!empty($testimonial_categories)) continue;

            $testimonials_array[] = [
                'title' => '',
                'content' => $woo_review->comment_content,
                'profile_image' => get_avatar_url($woo_review->comment_author_email),
                'testimonial_email' => $woo_review->comment_author_email,
                'testimonial_name' => $woo_review->comment_author,
                'testimonial_star' => get_comment_meta($woo_review->comment_ID, 'rating', true ),
                'company_name' => '',
                'company_link' => '',
                'testimonial_type' => 'woo',
                'facebook_id' => ''
            ];
        }
          
        ob_start();

        if(is_array($testimonials_array)){

            $loop = 1;

            foreach($testimonials_array as $testimonial_item ){

                $default_image_url = plugins_url('/avatar.png', __FILE__);
                
                $profile_image_url = (!empty($testimonial_item['feature_image'])) ? $testimonial_item['feature_image'] : $default_image_url;
                $profile_image_url = (!empty($testimonial_item['profile_image']) && filter_var($testimonial_item['profile_image'], FILTER_VALIDATE_URL)) ? $testimonial_item['profile_image'] : $profile_image_url;
            
            ?> 

                <div class="dipi-testimonial-item">

                    <?php if('off' == $use_hide_img && !($remove_empty_html === 'on' && empty($profile_image_url))) : ?>
                    <div class="dipi-testimonial-img">
                        <img 
                            src="<?php echo esc_url($profile_image_url); ?>"
                            alt="<?php echo esc_attr($testimonial_item['title']); ?>"
                        >
                    </div>
                    <?php endif; ?>

                    <?php if('off' == $use_hide_rating ) : ?>
                    <div class="dipi-testimonial-rating">
                        <?php 
                            for ( $i = 1; $i <= 5; ++$i ) :
                            if ( $i <= $testimonial_item['testimonial_star'] ) {
                                echo '<span class="dipi-testimonial-star-rating">★</span>';
                            } else {
                                echo '<span class="dipi-testimonial-star-rating-o">☆</span>';
                            }
                        endfor;
                        ?>
                    </div>
                    <?php endif; ?>

                    <?php if('off' == $use_hide_review && !($remove_empty_html === 'on' && empty($testimonial_item['content']))) : ?>
                        <div class="dipi-testimonial-text">
                            <div><?php

                                $review_text = $testimonial_item['content'];
                                 
                                $dipi_limit_html = dipi_limit_length_of_html($review_text, $review_length);
                                $review_text = $dipi_limit_html['text'];
                                $overflow_review = $dipi_limit_html['overflowed'];
                                
                               echo wp_kses_post($review_text);
                            ?></div>
                            <?php if('off' == $use_hide_readmore && $overflow_review) : ?>
                            <a href="#" data-mfp-src="#dipi-review-popup-<?php echo esc_attr($order_number); ?>-<?php echo esc_attr($loop); ?>" class="dipi-open-popup-link"><?php echo esc_html($readmore_text); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if('off' == $use_hide_name && !($remove_empty_html === 'on' && empty($testimonial_item['testimonial_name']))) : ?>
                    <div class="dipi-testimonial-name">
                        <?php echo esc_html($testimonial_item['testimonial_name']); ?>
                    </div>
                    <?php endif; ?>

                    <?php if('off' == $use_hide_company && !($remove_empty_html === 'on' && empty($testimonial_item['company_name']))) : ?>
                    <div class="dipi-company-name">
                        <?php if('on' !== $use_hide_company_link && !empty($testimonial_item['company_link'])) : ?> 
                        <a target="_blank" href="<?php echo esc_url($testimonial_item['company_link']); ?>">
                        <?php endif; ?>
                        <?php echo esc_html($testimonial_item['company_name']); ?>
                        <?php if('on' !== $use_hide_company_link && !empty($testimonial_item['company_link'])) : ?> 
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php

                    $popup_color = $args['popup_color'];
                    $popup_size = $args['popup_size'];
                    $close_icon_bg_color = $args['close_icon_bg_color'];
                    $close_icon_color = $args['close_icon_color'];

                    $popup_styles = 'background:'.$popup_color.'; width:'.$popup_size.';';
                    $popup_close_button_styles = 'background:'.$close_icon_bg_color.'; color:'.$close_icon_color.';';

                    ?>

                    <div id="dipi-review-popup-<?php echo esc_attr($order_number); ?>-<?php echo esc_attr($loop); ?>" style="<?php echo esc_attr($popup_styles); ?>" class="mfp-hide dipi-review-popup-text <?php echo esc_attr($order_class)."-popup"?>">

                    <?php if('on' == $use_show_popup_rating ) : ?>
                        <div class="dipi-testimonial-rating">
                            <?php 
                                for ( $i = 1; $i <= 5; ++$i ) :
                                    if ( $i <= $testimonial_item['testimonial_star'] ) {
                                        echo '<span class="dipi-testimonial-star-rating">★</span>';
                                    } else {
                                        echo '<span class="dipi-testimonial-star-rating-o">☆</span>';
                                    }
                                endfor;
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if('on' == $use_show_popup_review && !($remove_empty_html === 'on' && empty($testimonial_item['content']))) : ?>
                    <div class="dipi-testimonial-text">
                        <?php echo wp_kses_post(self::closing_tags($testimonial_item['content'])); ?>
                    </div>
                    <?php endif; ?>

                    <div class="dipi-review-popup-bottom">

                        <?php if('on' == $use_show_popup_image && !($remove_empty_html === 'on' && empty($profile_image_url))) : ?>
                            <div class="dipi-testimonial-img">
                                <img  src="<?php echo esc_url($profile_image_url); ?>" alt="<?php echo esc_html($testimonial_item['title']); ?>" />
                            </div>
                        <?php endif; ?>
                        <div class="dipi-profile-info">
                            <?php if('on' == $use_show_popup_name && !($remove_empty_html === 'on' && empty($testimonial_item['testimonial_name']))) : ?>
                                <div class="dipi-testimonial-name">
                                    <?php echo esc_html($testimonial_item['testimonial_name']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if('on' == $use_show_popup_company && !($remove_empty_html === 'on' && empty($testimonial_item['company_name']))) : ?>
                                <div class="dipi-company-name">
                                <?php if('on' !== $use_hide_company_link && !empty($testimonial_item['company_link'])) : ?> 
                                <a target="_blank" href="<?php echo esc_url($testimonial_item['company_link']); ?>">
                                <?php endif; ?>
                                <?php echo esc_html($testimonial_item['company_name']); ?>
                                <?php if('on' !== $use_hide_company_link && !empty($testimonial_item['company_link'])) : ?> 
                                </a>
                                <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button title="Close (Esc)" style="<?php echo et_core_intentionally_unescaped(stripslashes($popup_close_button_styles), 'html'); ?>" type="button" class="mfp-close">×</button>
                    </div>

            <?php
            if ($loop++ == $total_testimonial) break;
            }
        } else {
            echo "<div class='dipi-error'>No Testimonial Found!</div>";
        }
                
        wp_reset_postdata();

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
    public function get_custom_style($slug_value, $type, $important)
    {
        return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
    }
    public function apply_custom_style_for_hover(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false
    ) {

        $slug_hover_enabled = isset($this->props[$slug . '__hover_enabled']) ? substr($this->props[$slug . '__hover_enabled'], 0, 2) === "on" : false;
        $slug_hover_value = isset($this->props[$slug . '__hover']) ? $this->props[$slug . '__hover'] : '';

        if (isset($slug_hover_value)
            && !empty($slug_hover_value)
            && $slug_hover_enabled) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_hover_value, $type, $important),
            ));
        }
    }
    /**
    * Render
    */
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_testimonial_public');
        wp_enqueue_style('dipi_swiper');
        wp_enqueue_style('magnific-popup');
        
        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-testimonial-item',
            '%%order_class%% .dipi-testimonial-item:hover',
            'item_bg',
            'item_bg_color'
        );

        $this->_dipi_apply_css($render_slug);
        // $dipi_review_popup_class = $this->get_dipi_review_popup_class();

        $speed           = $this->props['speed'];
        $loop            = $this->props['loop'];
        $centered        = $this->props['centered'];
        $autoplay        = $this->props['autoplay'];
        $autoplay_speed  = $this->props['autoplay_speed'];
        $pause_on_hover  = $this->props['pause_on_hover'];
        $navigation      = $this->props['navigation'];
        $navigation_on_hover = $this->props['navigation_on_hover'];        
        $pagination      = $this->props['pagination'];
        $effect          = $this->props['effect'];
        $rotate          = $this->props['rotate'];
        $dynamic_bullets = $this->props['dynamic_bullets'];
        $order_class     = self::get_module_order_class($render_slug);
        $order_number    = str_replace('_', '', str_replace($this->slug, '', $order_class));

        $options = [];

        $columns                             = $this->dipi_get_responsive_prop('columns');
        
        if($columns['desktop'] === "4" && $columns['tablet'] === "4" && $columns['phone'] === "4") {
            $columns['tablet'] = "2";
            $columns['phone'] = "1";
        }

        $options['data-columnsdesktop']      = esc_attr($columns['desktop']);
        $options['data-columnstablet']       = esc_attr($columns['tablet']);
        $options['data-columnsphone']        = esc_attr($columns['phone']);
        
        $space_between                       = $this->dipi_get_responsive_prop('space_between');
        $options['data-spacebetween']        = esc_attr($space_between['desktop']);
        $options['data-spacebetween_tablet'] = esc_attr($space_between['tablet']);
        $options['data-spacebetween_phone']  = esc_attr($space_between['phone']);
        
        $options['data-loop']                = esc_attr($loop);
        $options['data-speed']               = esc_attr($speed);
        $options['data-navigation']          = esc_attr($navigation);
        $options['data-pagination']          = esc_attr($pagination);
        $options['data-autoplay']            = esc_attr($autoplay);
        $options['data-autoplayspeed']       = esc_attr($autoplay_speed);
        $options['data-pauseonhover']        = esc_attr($pause_on_hover);
        $options['data-effect']              = esc_attr($effect);
        $options['data-rotate']              = esc_attr($rotate);
        $options['data-dynamicbullets']      = esc_attr($dynamic_bullets);
        $options['data-ordernumber']         = esc_attr($order_number);
        $options['data-centered']            = esc_attr($centered);

        $options = implode(
            " ", 
            array_map(
                function($k, $v){
                    return "{$k}='{$v}'";
                }, 
                array_keys($options),
                $options
            )
        );

        $data_next_icon = $this->props['navi_next_icon'];
        $data_prev_icon = $this->props['navi_prev_icon'];
        $data_next_icon = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon( $data_next_icon )));
        $data_prev_icon = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon( $data_prev_icon )));
        $next_icon = 'on' === $this->props['use_navi_next_icon'] ? $data_next_icon : 'data-icon="9"';
        $prev_icon = 'on' === $this->props['use_navi_prev_icon'] ? $data_prev_icon : 'data-icon="8"';

        $navigation = ($this->props['navigation'] == 'on') ? sprintf(
            '<div class="swiper-button-next swiper-arrow-button dipi-button-next-%1$s %4$s" %2$s></div>
            <div class="swiper-button-prev swiper-arrow-button dipi-button-prev-%1$s %4$s" %3$s></div>',
            $order_number,
            $next_icon,
            $prev_icon,
            $navigation_on_hover === "on" ? "show_on_hover" : ""
        ) : '';

        $pagination = ( $this->props['pagination'] == 'on') ? sprintf(
            '<div class="swiper-pagination dipi-pagination-%1$s"></div>',
            $order_number
        ) : '';

        /**
         * Loop
         */
        $output = $this->get_testimonial($this->props, array(), array(), $order_number, $order_class);

        return sprintf(
            '<div class="dipi-testimonial-main" %2$s>
                <div class="swiper-container">
                    <div class="dipi-testimonial-wrapper">
                        %1$s
                    </div>
                </div>
                %3$s
                <div class="swiper-container-horizontal">
                    %4$s
                </div>
            </div>',
            $output,
            $options,
            $navigation,
            $pagination
        );
    }

    /**
    * Custom CSS
    */
    function _dipi_apply_css($render_slug)
    {        
        if('on' === $this->props['use_navi_prev_icon']){
            $this->dipi_generate_font_icon_styles($render_slug, 'navi_prev_icon', '%%order_class%% .swiper-button-prev:after');
        }

        if('on' === $this->props['use_navi_next_icon']){
            $this->dipi_generate_font_icon_styles($render_slug, 'navi_next_icon', '%%order_class%% .swiper-button-next:after');
        }

        $container_class = "%%order_class%% .swiper-container";
        $item_class = "%%order_class%% .dipi-testimonial-item";
        $image_class = "%%order_class%% .dipi-testimonial-img, .dipi-testimonial-review-popup-open %%order_class%%-popup .dipi-testimonial-img";
        $navi_position_left_class = "%%order_class%% .swiper-button-prev, %%order_class%%:hover .swiper-button-prev.swiper-arrow-button.show_on_hover";
        $navi_position_right_class = "%%order_class%% .swiper-button-next, %%order_class%%:hover .swiper-button-next.swiper-arrow-button.show_on_hover";
        $navigation_position_left_area_class      = "%%order_class%% .swiper-button-prev.swiper-arrow-button.show_on_hover:before";
        $navigation_position_right_area_class     = "%%order_class%% .swiper-button-next.swiper-arrow-button.show_on_hover:before";

        $important = false;

        $container_padding = explode('|', $this->props['container_padding']);
        $container_padding_tablet = explode('|', $this->props['container_padding_tablet']);
        $container_padding_phone = explode('|', $this->props['container_padding_phone']);
        $container_padding_last_edited = $this->props['container_padding_last_edited'];
        $container_padding_responsive_status = et_pb_get_responsive_status($container_padding_last_edited);
        $navigation_hover_selector = '%%order_class%% .swiper-arrow-button:hover:after';
        $navigation_hover_bg_selector = '%%order_class%% .swiper-arrow-button:hover';

        if( '' !== $container_padding) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf( 'padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
            ) );
        }

        if( is_array($container_padding_tablet) && count($container_padding_tablet) >= 4 && $container_padding_responsive_status) {            
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf( 
                    'padding-top: %1$s !important; 
                     padding-right:%2$s !important; 
                     padding-bottom:%3$s !important; 
                     padding-left:%4$s !important;', 
                     $container_padding_tablet[0], 
                     $container_padding_tablet[1], 
                     $container_padding_tablet[2], 
                     $container_padding_tablet[3]
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if( is_array($container_padding_phone) && count($container_padding_phone) >= 4 && $container_padding_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf( 'padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%4$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $item_padding = explode('|', $this->props['item_padding']);
        $item_padding_tablet =  explode('|', $this->props['item_padding_tablet']);
        $item_padding_phone  =  explode('|', $this->props['item_padding_phone']);
        $item_padding_last_edited = $this->props['item_padding_last_edited'];
        $item_padding_responsive_status = et_pb_get_responsive_status($item_padding_last_edited);

        if( '' !== $item_padding ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $item_class,
                'declaration' => sprintf( 'padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $item_padding[0], $item_padding[1], $item_padding[2], $item_padding[3]),
            ) );
        }

        if( is_array($item_padding_tablet) && count($item_padding_tablet) >= 4 && $item_padding_responsive_status ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $item_class,
                'declaration' => sprintf( 'padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $item_padding_tablet[0], $item_padding_tablet[1], $item_padding_tablet[2], $item_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if( is_array($item_padding_phone) && count($item_padding_phone) >= 4 && $item_padding_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $item_class,
                'declaration' => sprintf( 'padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $item_padding_phone[0], $item_padding_phone[1], $item_padding_phone[2], $item_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $img_width = $this->props['img_width'];
        $img_width_tablet = ($this->props['img_width_tablet']) ? $this->props['img_width_tablet'] : $img_width;
        $img_width_phone = ($this->props['img_width_phone']) ? $this->props['img_width_phone'] : $img_width_tablet;
        $img_width_last_edited  = $this->props['img_width_last_edited'];
        $img_width_responsive_status = et_pb_get_responsive_status($img_width_last_edited);
        
        if('' !== $img_width) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf( 'width: %1$s !important; height: %1$s !important;', $img_width),
            ));
        }

        if(is_array($img_width_tablet) && count($img_width_tablet) >= 4 && $img_width_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf( 'width: %1$s !important; height: %1$s !important;', $img_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if(is_array($img_width_phone) && count($img_width_phone) >= 4 && $img_width_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf( 'width: %1$s !important; height: %1$s !important;', $img_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $navi_position_left  = $this->props['navi_position_left'];
        $navi_position_left_tablet  = $this->props['navi_position_left_tablet'];
        $navi_position_left_phone  = $this->props['navi_position_left_phone'];
        $navi_position_left_last_edited  = $this->props['navi_position_left_last_edited'];
        $navi_position_left_responsive_status = et_pb_get_responsive_status($navi_position_left_last_edited);


        /* Left navigation area */
        if('' !== $navi_position_left && $navi_position_left < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int)$navi_position_left),
            ) );
        }

        if('' !== $navi_position_left_tablet && $navi_position_left_responsive_status && $navi_position_left_tablet < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf( 'width: %1$spx !important;', -(int)$navi_position_left_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if('' !== $navi_position_left_phone && $navi_position_left_responsive_status && $navi_position_left_phone < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf( 'width: %1$spx !important;', -(int)$navi_position_left_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }


        $navi_position_right = $this->dipi_get_responsive_prop('navi_position_right');
        $navi_position_left = $this->dipi_get_responsive_prop('navi_position_left');
        $css_navi_position_right = array(
            'desktop' =>   $navi_position_right['desktop']. 'px !important;',
            'tablet' => $navi_position_right['tablet']. 'px !important;',
            'phone' => $navi_position_right['phone']. 'px !important;'
            
        );
        et_pb_responsive_options()->generate_responsive_css($css_navi_position_right, $navi_position_right_class, 'right', $render_slug);

        $css_navi_position_left = array(
            'desktop' =>   $navi_position_right['desktop']. 'px !important;',
            'tablet' => $navi_position_right['tablet']. 'px !important;',
            'phone' => $navi_position_right['phone']. 'px !important;'
            
        );
        et_pb_responsive_options()->generate_responsive_css($css_navi_position_left, $navi_position_left_class, 'left', $render_slug);
        
        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => $navi_position_right_class,
            'declaration' => sprintf( 'right: %1$spx !important;', $navi_position_right['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));

        $navi_position_right = $this->props['navi_position_right'];
        $navi_position_right_tablet  = $this->props['navi_position_right_tablet'];
        $navi_position_right_phone  = $this->props['navi_position_right_phone'];
        $navi_position_right_last_edited  = $this->props['navi_position_right_last_edited'];
        $navi_position_right_responsive_status = et_pb_get_responsive_status($navi_position_right_last_edited);

        
        if( '' !== $navi_position_right && $navi_position_right < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf( 'width: %1$spx !important;', -(int)$navi_position_right),
            ));
        }

        if( '' !== $navi_position_right_tablet && $navi_position_right_responsive_status && $navi_position_right_tablet < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf( 'width: %1$spx !important;', -(int)$navi_position_right_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if( '' !== $navi_position_right_phone && $navi_position_right_responsive_status && $navi_position_right_phone < 0) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf( 'width: %1$spx !important;', -(int)$navi_position_right_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        if( '' !== $this->props['navi_color'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
                'declaration' => sprintf('color: %1$s!important;', $this->props['navi_color']),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'navi_color',
            'color',
            $navigation_hover_selector,
            true
        );

        if( '' !== $this->props['navi_bg_color'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => sprintf('background: %1$s!important;', $this->props['navi_bg_color']),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'navi_bg_color',
            'background',
            $navigation_hover_bg_selector,
            true
        );

        $navi_size = $this->props['navi_size'];
        $navi_size_last_edited  = $this->props['navi_size_last_edited'];
        $navi_size_responsive_status = et_pb_get_responsive_status($navi_size_last_edited);

        $navi_size_tablet = $this->dipi_get_responsive_value(
            'navi_size_tablet', 
            $navi_size, 
            $navi_size_responsive_status
        );

        $navi_size_phone = $this->dipi_get_responsive_value(
            'navi_size_phone',
            $navi_size_tablet,
            $navi_size_responsive_status
        );
        if( '' !== $this->props['navi_size'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $navi_size + 20),
            ) );
        }
        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf( 'width: %1$spx !important; height: %1$spx !important;', $navi_size_tablet + 20),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980' )
        ));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf( 'width: %1$spx !important; height: %1$spx !important;', $navi_size_phone + 20),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767' )
        ));
        $this->generate_styles(
            array(
                'base_attr_name' => 'navi_size',
                'selector' => '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
                'css_property' => 'font-size',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'navi_padding',
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'css_property' => 'padding',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        if( 'on' === $this->props['navi_circle'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => 'border-radius: 50% !important;',
            ) );
        }

        if( '' !== $this->props['pagi_color'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-pagination-bullet',
                'declaration' => sprintf(
                    'background: %1$s!important;', $this->props['pagi_color']),
            ) );
        }

        if( '' !== $this->props['pagi_active_color'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'declaration' => sprintf(
                    'background: %1$s!important;', $this->props['pagi_active_color']),
            ) );
        }

        if( '' !== $this->props['pagi_position'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-container-horizontal > .swiper-pagination-bullets, %%order_class%% .swiper-pagination-fraction, %%order_class%% .swiper-pagination-custom',
                'declaration' => sprintf('bottom: %1$spx !important;', $this->props['pagi_position']),
            ) );
        }

        if( '' !== $this->props['rating_size'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .dipi-testimonial-rating, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-rating',
                'declaration' => sprintf('font-size: %1$s !important;', $this->props['rating_size']),
            ) );
        }

        if( '' !== $this->props['rating_spacing'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .dipi-testimonial-rating span:not(:last-of-type), .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-rating span:not(:last-of-type)',
                'declaration' => sprintf('margin-right: %1$s !important;', $this->props['rating_spacing']),
            ) );
        }

        if( '' !== $this->props['rating_color'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .dipi-testimonial-rating .dipi-testimonial-star-rating, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-star-rating',
                'declaration' => sprintf('color: %1$s !important;', $this->props['rating_color'] ),
            ) );
        }

        if( '' !== $this->props['empty_rating_color'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .dipi-testimonial-rating .dipi-testimonial-star-rating-o, .dipi-testimonial-review-popup-open  %%order_class%%-popup .dipi-testimonial-star-rating-o',
                'declaration' => sprintf('color: %1$s !important;', $this->props['empty_rating_color'] ),
            ) );
        }

        if( '' !== $this->props['item_align'] ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-item',
                'declaration' => sprintf('text-align: %1$s !important;', $this->props['item_align'] ),
            ) );
        }

        if('left' == $this->props['item_align']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-img',
                'declaration' => "margin-right: auto !important;",
            ));

        } elseif('center' == $this->props['item_align']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-img',
                'declaration' => "margin: 10px auto !important;",
            ));
        } elseif('right' == $this->props['item_align']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-img',
                'declaration' => "margin-left: auto !important;",
            ));
        }

        $slide_shadows = $this->props['slide_shadows'];
        $shadow_overlay_color = $this->props['shadow_overlay_color'];

        if ( $slide_shadows == 'on' ){
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .swiper-container-3d .swiper-slide-shadow-left',
                'declaration' => 'background-image: -webkit-gradient(linear, right top, left top, from('.$shadow_overlay_color.'), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(right, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(right, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: linear-gradient(to left, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));',
            ) );
            
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .swiper-container-3d .swiper-slide-shadow-right',
                'declaration' => 'background-image: -webkit-gradient(linear, left top, right top, from('.$shadow_overlay_color.'), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(left, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));background-image: -o-linear-gradient(left, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: linear-gradient(to right, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));',
            ) );
            
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .swiper-container-3d .swiper-slide-shadow-top',
                'declaration' => 'background-image: -webkit-gradient(linear, left bottom, left top, from('.$shadow_overlay_color.'), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(bottom, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(bottom, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: linear-gradient(to top, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));',
            ) );
            
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-testimonial-main .swiper-container-3d .swiper-slide-shadow-bottom',
                'declaration' => ' background-image: -webkit-gradient(linear, left top, left bottom, from('.$shadow_overlay_color.'), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(top, '.$shadow_overlay_color.', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(top, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));background-image: linear-gradient(to bottom, '.$shadow_overlay_color.', rgba(0, 0, 0, 0));',
            ) );    
        }

        $this->apply_custom_style_for_hover(
            $render_slug,
            'close_icon_bg_color',
            'background',
            '.mfp-wrap .mfp-container %%order_class%%-popup.dipi-review-popup-text button.mfp-close:hover',
            true
        );
        
        $this->apply_custom_style_for_hover(
            $render_slug,
            'close_icon_color',
            'color',
            '.mfp-wrap.mfp-close-btn-in .mfp-container %%order_class%%-popup button.mfp-close:hover',
            true
        );


    }
}

new DIPI_Testimonial;