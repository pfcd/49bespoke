<?php

add_filter("et_pb_all_fields_unprocessed_dipi_blog_slider", function ($fields_unprocessed) {
    $fields_unprocessed['button_icon']['computed_affects'] = ['__blogposts'];
    $fields_unprocessed['button_use_icon']['computed_affects'] = ['__blogposts'];
    return $fields_unprocessed;
});

// TODO: Why are we using this base class? If it's not 100% required, we should use DIPI_Builder_Module. 
// Apparently we are using the filter_include_categories function from the base module 
// but what does it do? Do we really need it or can we work around it?
class DIPI_Blog_Slider extends DIPI_Builder_Module_Type_PostBased
{

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Blog Slider', 'dipi-divi-pixel');
        $this->plural = esc_html__('Pixel Blog Slider', 'dipi-divi-pixel');
        $this->slug = 'dipi_blog_slider';
        $this->vb_support = 'on';
        $this->main_css_element = '%%order_class%% .dipi_blog_slider';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'elements' => esc_html__('Elements', 'dipi-divi-pixel'),
                    'carousel' => esc_html__('Slider Settings', 'dipi-divi-pixel'),
                ],
            ],

            'advanced' => [
                'toggles' => [
                    'image' => esc_html__('Image', 'dipi-divi-pixel'),
                    'blog_item' => esc_html__('Blog Item', 'dipi-divi-pixel'),
                    'blog_texts' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'body' => [
                                'name' => 'Body',
                            ],
                            'cat' => [
                                'name' => 'Cat',
                            ],
                            'author' => [
                                'name' => 'Author',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Blog Texts', 'dipi-divi-pixel'),
                    ],
                    'blog_date' => esc_html__('Blog Date', 'dipi-divi-pixel'),
                    'navigation' => esc_html__('Navigation', 'dipi-divi-pixel'),
                    'pagination' => esc_html__('Pagination', 'dipi-divi-pixel'),
                ],
            ],

        ];
    }

    /**
     * Utility function to generate font icon styles which is necessary since Divi 4.13.
     * For backwardscompatibility, we only take action if the process_extended_icon is
     * available, which isn't the case in Divi 4.12.
     *
     * @param String $render_slug The modules render slug
     * @param String $property_name The name of the icon property
     * @param String $selector The selector of the element containing the font icon
     * @since 2.5.3
     */
    protected function dipi_generate_font_icon_styles($render_slug, $property_name, $selector)
    {
        if (method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg' => 'icon_font_family',
                    'render_slug' => $render_slug,
                    'base_attr_name' => $property_name,
                    'important' => true,
                    'selector' => $selector,
                    'processor' => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }
    }

    public function dipi_et_late_global_assets_list($assets, $assets_args, $it)
    {
        if (isset($assets['et_icons_all']) && isset($assets['et_icons_fa'])) {
            return $assets;
        }

        if (
            ($this->props['navigation_prev_icon_yn'] === 'on' && strpos($this->props['navigation_prev_icon'], '|fa|') !== false) ||
            ($this->props['navigation_next_icon_yn'] === 'on' && strpos($this->props['navigation_next_icon'], '|fa|') !== false)
        ) {
            $assets_prefix = et_get_dynamic_assets_path();
            $assets['et_icons_fa'] = array(
                'css' => "{$assets_prefix}/css/icons_fa_all.css",
            );
        }

        return $assets;
    }

    public function get_custom_css_fields_config()
    {
        $custom_css_fields = [];

        $custom_css_fields['category'] = [
            'label' => esc_html__('Category', 'dipi-divi-pixel'),
            'selector' => '.dipi-categories, .dipi-categories a',
        ];

        $custom_css_fields['post_content'] = [
            'label' => esc_html__('Post Content', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-post-content',
        ];

        $custom_css_fields['author'] = [
            'label' => esc_html__('Author', 'dipi-divi-pixel'),
            'selector' => '.dipi-author',
        ];

        $custom_css_fields['month'] = [
            'label' => esc_html__('Date Month', 'dipi-divi-pixel'),
            'selector' => '.dipi-month',
        ];

        $custom_css_fields['day'] = [
            'label' => esc_html__('Date Day', 'dipi-divi-pixel'),
            'selector' => '.dipi-day',
        ];

        $custom_css_fields['year'] = [
            'label' => esc_html__('Date Year', 'dipi-divi-pixel'),
            'selector' => '.dipi-year',
        ];

        $custom_css_fields['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '.dipi-entry-title',
        ];

        $custom_css_fields['content'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '.dipi-post-text',
        ];

        $custom_css_fields['button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '.dipi-more-link',
        ];

        $custom_css_fields['post_read_mopre'] = [
            'label' => esc_html__('Button Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-bottom-content',
        ];

        $custom_css_fields['comments'] = [
            'label' => esc_html__('Comments Count', 'dipi-divi-pixel'),
            'selector' => '.dipi-comments',
        ];

        $custom_css_fields['arrow_nav'] = [
            'label' => esc_html__('Arrow Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-arrow-button',
        ];

        $custom_css_fields['arrow_nav_prev'] = [
            'label' => esc_html__('Arrow Navigation Prev', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-prev',
        ];

        $custom_css_fields['arrow_nav_next'] = [
            'label' => esc_html__('Arrow Navigation Next', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-next',
        ];

        $custom_css_fields['arrow_icon'] = [
            'label' => esc_html__('Navigation Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-prev:after',
        ];

        $custom_css_fields['pagination_default'] = [
            'label' => esc_html__('Pagination Default', 'dipi-divi-pixel'),
            'selector' => '.swiper-pagination-bullet',
        ];

        $custom_css_fields['pagination_active'] = [
            'label' => esc_html__('Pagination Active', 'dipi-divi-pixel'),
            'selector' => '.swiper-pagination-bullet-active',
        ];

        $custom_css_fields['active_slide'] = [
            'label' => esc_html__('Active Slide', 'dipi-divi-pixel'),
            'selector' => '.swiper-slide-active',
        ];

        $custom_css_fields['not_active_slides'] = [
            'label' => esc_html__('Not Active Slides', 'dipi-divi-pixel'),
            'selector' => '.dipi-blog-post:not(.swiper-slide-active)',
        ];

        return $custom_css_fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];

        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['link_options'] = false;

        $advanced_fields["box_shadow"]["item"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-blog-post",
            ],
            'toggle_slug' => 'blog_item',
        ];

        $advanced_fields["box_shadow"]["image"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-entry-featured-image-url",
            ],
            'toggle_slug' => 'image',
        ];

        $advanced_fields["borders"]["item"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-blog-post",
                    'border_styles' => "%%order_class%% .dipi-blog-post",
                ],
            ],
            'toggle_slug' => 'blog_item',
        ];

        $advanced_fields["borders"]["image"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-entry-featured-image-url",
                    'border_styles' => "%%order_class%% .dipi-entry-featured-image-url",
                ],
            ],
            'toggle_slug' => 'image',
        ];

        $advanced_fields['fonts']['header'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-entry-title",
                'font' => "%%order_class%% .dipi-entry-title a, %%order_class%% .dipi-entry-title",
                'color' => "%%order_class%% .dipi-entry-title a, %%order_class%% .dipi-entry-title",
                'hover' => "%%order_class%% .dipi-entry-title:hover, %%order_class%% .dipi-entry-title:hover a",
                'color_hover' => "%%order_class%% .dipi-entry-title:hover, %%order_class%% .dipi-entry-title:hover a",
                'important' => 'all',
            ],

            'header_level' => [
                'default' => 'h2',
                'computed_affects' => [
                    '__blogposts',
                ],
            ],
            'toggle_slug' => 'blog_texts',
            'sub_toggle' => 'title',
        ];

        $advanced_fields['fonts']['body'] = [
            'label' => esc_html__('Body', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-post-text",
                'color' => "%%order_class%% .dipi-post-text *, %%order_class%% .dipi-post-text",
                'line_height' => "%%order_class%% .dipi-post-text p",
                'important' => 'all',
            ],
            'toggle_slug' => 'blog_texts',
            'sub_toggle' => 'body',
        ];

        $advanced_fields['fonts']['cat'] = [
            'label' => esc_html__('Cat', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-categories",
                'color' => "%%order_class%% .dipi-categories, %%order_class%% .dipi-categories a",
            ],

            'toggle_slug' => 'blog_texts',
            'sub_toggle' => 'cat',
        ];

        $advanced_fields['fonts']['author'] = [
            'label' => esc_html__('Author', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-author .author, %%order_class%% .dipi-author .author a",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'blog_texts',
            'sub_toggle' => 'author',
        ];

        $advanced_fields['fonts']['date'] = [
            'label' => esc_html__('Date', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-date",
            ],
            'hide_text_align' => true,
            'hide_font_size' => true,
            'hide_line_height' => true,
            'hide_letter_spacing' => true,
            'toggle_slug' => 'blog_date',
        ];

        $advanced_fields['button']["button"] = [
            'label' => esc_html__('Read More', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .et_pb_button.dipi-more-link",
                'important' => true,
            ],
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .et_pb_button.dipi-more-link",
                ],
            ],
            'use_alignment' => true,
        ];

        return $advanced_fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['author_align'] = [
            'label' => esc_html__('Author Alignment', 'dipi-divi-pixel'),
            'type' => 'text_align',
            'options' => et_builder_get_text_orientation_options(['justified']),
            'options_icon' => 'module_align',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_texts',
            'sub_toggle' => 'author',
        ];

        $fields['posts_number'] = [
            'label' => esc_html__('Post Count', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'configuration',
            'computed_affects' => ['__blogposts'],
            'toggle_slug' => 'main_content',
            'default' => 10,
        ];
        $registered_post_types = et_get_registered_post_type_options( false, false );
        $excluded_post_types = array( 'Media', 'Taxonomies', 'Popup Maker');
        
        $dipi_taxonomies_object = get_taxonomies(
            array(),
            'objects'
        );
        $dipi_taxonomies_object = array_filter($dipi_taxonomies_object, function($object){
            $exclude_taxonomies = array(
                'dipi_media_category',
                'layout_pack',
                'layout_type',
                'layout_category',
                'layout_tag',
                'scope',
                'module_width',
                'nav_menu',
                'link_category',
                'post_format',
                'wp_template_part_area',
                'wp_theme'
            );
            return !in_array($object->name, $exclude_taxonomies);
        });
        $dipi_taxonomies_options = array_map(function($object) {
            return array($object->name => $object->label);
        }, $dipi_taxonomies_object);
        $dipi_taxonomies_options = array_merge($dipi_taxonomies_options, 
            array('post_category'=> (object)array('category'=>'Category')));
        $post_types = array_diff( $registered_post_types, $excluded_post_types);
        
        $fields['select_post_type'] = [
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Custom Post Type', 'dipi-divi-pixel' ),
            'type'              => 'select',
            'options'           => $post_types,
            'default'           => 'post',
            'computed_affects' => array(
              '__filterable_grid',
            ),
            'description'       => esc_html__( 'Choose the post type you want to display', 'divi-filter' ),
        ];
        $fields['select_custom_tax'] =[
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Custom Taxonomy', 'dipi-divi-pixel' ),
            'type'              => 'select',
            'options'           => $dipi_taxonomies_options,
            'option_category'   => 'configuration',
            'default'           => 'category',
            'description'       => esc_html__( 'Choose the custom taxonomy that you have made and want to filter', 'dipi-divi-pixel' ),
            'computed_affects' => ['__blogposts'],
        ];
        $computed_depends_on = [];
        foreach($dipi_taxonomies_object as $dipi_tax_object) {
            $include_term_ids = "include_term_ids_of_$dipi_tax_object->name";
            if ($dipi_tax_object->name === "category") {
                $include_term_ids = "include_categories";
            }
            array_push($computed_depends_on, $include_term_ids);
            $fields[$include_term_ids] =[
                'label' => esc_html__("Included $dipi_tax_object->label", 'dipi-divi-pixel'),
                'type' => 'categories',
                'meta_categories' => array(
                    'all' => esc_html__('All', 'dipi-divi-pixel'),
                    'current' => esc_html__('Current', 'dipi-divi-pixel'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'renderer_options' => array(
                    'use_terms' => true,
                    'term_name' => $dipi_tax_object->name,
                ),
                'computed_affects' => ['__blogposts'],
                'show_if'   => array (
                    'select_custom_tax' => $dipi_tax_object->name
                )
            ];
        }
        /*$fields['include_categories'] = [
            'label' => esc_html__('Included Categories', 'dipi-divi-pixel'),
            'type' => 'categories',
            'meta_categories' => array(
                'all' => esc_html__('All Categories', 'dipi-divi-pixel'),
                'current' => esc_html__('Current Category', 'dipi-divi-pixel'),
            ),
            'option_category' => 'basic_option',
            'renderer_options' => array(
                'use_terms' => false,
            ),
            'toggle_slug' => 'main_content',
            'computed_affects' => ['__blogposts'],
        ];*/

        $fields['excluded_posts'] = [
            'label' => esc_html__('Exclude Posts', 'dipi-divi-pixel'),
            'description' => esc_html__('Exclude Posts by listing their IDs here. Use a comma to separate the IDs.', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'computed_affects' => ['__blogposts'],
        ];
        $fields['post_status'] = [
            'toggle_slug'       => 'main_content',
            'option_category'   => 'configuration',
                'label'             => esc_html__( 'Post Status', 'dipi-divi-pixel' ),
                'type'              => 'select',
                'options'           => array(
                'publish' => sprintf( esc_html__( 'Publish', 'dipi-divi-pixel' ) ),
                'pending' => esc_html__( 'Pending', 'dipi-divi-pixel' ),
                'draft' => esc_html__( 'Draft', 'dipi-divi-pixel' ),
                'auto-draft' => esc_html__( 'Auto-draft', 'dipi-divi-pixel' ),
                'future' => esc_html__( 'Future', 'dipi-divi-pixel' ),
                'private' => esc_html__( 'Private', 'dipi-divi-pixel' ),
                'inherit' => esc_html__( 'Inherit', 'dipi-divi-pixel' ),
            ),
            'default' => 'publish',
            'computed_affects' => ['__blogposts'],
            'description'       => esc_html__( 'Choose the status of the posts you want to show.', 'dipi-divi-pixel' ),
        ];
        // $fields['exclude_current_post'] = [
        //     'label' => esc_html__('Exclude Current Post', 'dipi-divi-pixel'),
        //     'description' => esc_html__('If the module is used on a blog post, activate this option to exclude the current post from the slider.', 'dipi-divi-pixel'),
        //     'type' => 'yes_no_button',
        //     'default' => 'off',
        //     'options' => array(
        //         'off' => esc_html__('No', 'dipi-divi-pixel'),
        //         'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        //     ),
        //     'option_category' => 'basic_option',
        //     'toggle_slug' => 'main_content',
        //     'computed_affects' => ['__blogposts'],
        // ];

        $fields['show_thumbnail'] = [
            'label' => esc_html__('Show Featured Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'computed_affects' => ['__blogposts'],
            'toggle_slug' => 'elements',
            'default_on_front' => 'on',
        ];
        $fields['card_clickable'] = [
            'label' => esc_html__('Clickable Card', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'computed_affects' => ['__blogposts'],
            'toggle_slug' => 'elements',
        ];

        $fields['image_clickable'] = [
            'label' => esc_html__('Clickable Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'on',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'show_thumbnail' => 'on',
                'card_clickable' => 'off',
            ],
            'computed_affects' => ['__blogposts'],
            'toggle_slug' => 'elements',
        ];

        $fields['use_thumbnail_height'] = [
            'label' => esc_html__('Featured Image Height', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'show_thumbnail' => 'on',
            ],
            'toggle_slug' => 'elements',
        ];

        $fields['thumbnail_height'] = [
            'label' => esc_html__('Featured Image Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '400px',
            'default_unit' => 'px',
            'mobile_options' => true,
            'show_if' => [
                'show_thumbnail' => 'on',
                'use_thumbnail_height' => 'on',
            ],
            'range_settings' => [
                'min' => '0',
                'max' => '600',
                'step' => '10',
            ],
            'toggle_slug' => 'elements',
        ];
        $fields['use_thumbnails'] = [
            'label' => esc_html__('Use Responsive Thumbnails', 'dipi-divi-pixel'),
            'description' => esc_html__('Whether or not to use custom sized thumbnails on different devices. If this option is disabled, the full size image will be used as thumbnail.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'elements',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'computed_affects' => ['__blogposts'],
        ];

        $fields['image_size'] = [
            'label' => esc_html__('Image Size', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'elements',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
            'mobile_options' => true,
            'computed_affects' => ['__blogposts'],
        ];
        $fields['excerpt_length'] = [
            'label' => esc_html__('Content Length', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '170',
            'toggle_slug' => 'main_content',
            'computed_affects' => ['__blogposts'],
        ];
        $fields['expert_as_raw_html'] = [
            'label' => esc_html__('Content as Raw HTML', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'main_content',
            'default' => 'off',
            'computed_affects' => ['__blogposts'],
        ];
        $shortcode_options_with_rawhtml = array(
            'show' => esc_html__('Show Shortcode', 'et_builder'),
            'et_stripe' => esc_html__('Remove Divi Shortcodes', 'et_builder'),
            'non_et_stripe' => esc_html__('Remove Non-Divi Shortcodes', 'et_builder'),
            'stripe' => esc_html__('Remove Aall Shortcodes', 'et_builder'),
            'render' => esc_html__('Render Shortcodes', 'et_builder'),
        );
        $shortcode_options_without_rawhtml = array(
            'show' => esc_html__('Show Shortcode', 'et_builder'),
            'stripe' => esc_html__('Remove All Shortcodes', 'et_builder'),
            'render' => esc_html__('Render Shortcodes', 'et_builder'),
        );
        $fields['handle_shortcode_with_rawhtml'] = [
            'label' => esc_html__('Handle shortcode', 'et_builder'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => $shortcode_options_with_rawhtml,
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Here you can select how to handle shortcodes', 'dipi-divi-pixel'),
            'computed_affects' => [
                '__blogposts',
            ],
            'default_on_front' => 'show',
            'show_if' => [
                'expert_as_raw_html' => 'on'
            ]
        ];
        $fields['handle_shortcode_without_rawhtml'] = [
            'label' => esc_html__('Handle shortcode', 'et_builder'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => $shortcode_options_without_rawhtml,
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Here you can select how to handle shortcodes', 'dipi-divi-pixel'),
            'computed_affects' => [
                '__blogposts',
            ],
            'default_on_front' => 'show',
            'show_if' => [
                'expert_as_raw_html' => 'off'
            ]
        ];
        $fields['orderby'] = [
            'label' => esc_html__('Order By', 'et_builder'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => array(
                'date_desc' => esc_html__('Date: new to old', 'et_builder'),
                'date_asc' => esc_html__('Date: old to new', 'et_builder'),
                'title_asc' => esc_html__('Title: a-z', 'et_builder'),
                'title_desc' => esc_html__('Title: z-a', 'et_builder'),
                'rand' => esc_html__('Random', 'et_builder'),
            ),
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Here you can adjust the order in which blog posts are displayed.', 'dipi-divi-pixel'),
            'computed_affects' => [
                '__blogposts',
            ],
            'default_on_front' => 'date_desc',
        ];
        $fields['offset_number']   = array(
            'label'            => esc_html__( 'Post Offset Number', 'dipi-divi-pixel' ),
            'type'             => 'text',
            'option_category'  => 'configuration',
            'description'      => esc_html__( 'Choose how many posts you would like to skip. These posts will not be shown in the feed.', 'dipi-divi-pixel' ),
            'toggle_slug'      => 'main_content',
            'computed_affects' => array(
                '__posts',
            ),
            'default'          => 0,
        );

        $fields['show_more'] = [
            'label' => esc_html__('Show Read More Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'elements',
            'default' => 'off',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['show_more_text'] = [
            'label' => esc_html__('Read More Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => 'Read More',
            'show_if' => [
                'show_more' => 'on',
            ],
            'toggle_slug' => 'elements',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['show_author'] = [
            'label' => esc_html__('Show Author', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'elements',
            'default_on_front' => 'on',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['show_date'] = [
            'label' => esc_html__('Show Date', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'affects' => [
                'date_circle_icon',
                'date_circle_color',
                'date_circle_border',
                'date_circle_border_color',
            ],
            'toggle_slug' => 'elements',
            'default_on_front' => 'on',
            'computed_affects' => ['__blogposts'],
        ];

        $fields["date_circle_color"] = [
            'label' => esc_html__('Date Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields["date_circle_icon"] = [
            'label' => esc_html__('Show Circle', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields["date_circle_border"] = [
            'label' => esc_html__('Show Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields["date_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'date_circle_border' => 'on',
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields['date_right_space'] = [
            'label' => esc_html__('Date Right Space', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0px',
            'default_unit' => 'px',
            'default_on_front' => '0px',
            'allowed_units' => array('%', 'px'),
            'range_settings' => [
                'min' => '1',
                'max' => '50',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields['date_top_space'] = [
            'label' => esc_html__('Date Top Space', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0px',
            'default_unit' => 'px',
            'default_on_front' => '0px',
            'allowed_units' => array('%', 'px'),
            'range_settings' => [
                'min' => '1',
                'max' => '50',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'blog_date',
        ];

        $fields['show_categories'] = [
            'label' => esc_html__('Show Categories', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'elements',
            'default_on_front' => 'on',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['show_comments'] = [
            'label' => esc_html__('Show Comment Count', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'elements',
            'default_on_front' => 'off',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['show_excerpt'] = [
            'label' => esc_html__('Show Content', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default_on_front' => 'on',
            'toggle_slug' => 'elements',
            'computed_affects' => ['__blogposts'],
        ];

        $fields['columns'] = [
            'label' => esc_html__('Number of Columns', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '4',
            'default_on_front' => '4',
            'range_settings' => [
                'min' => '1',
                'max' => '12',
                'step' => '1',
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'carousel',
        ];

        $fields['space_between'] = [
            'label' => esc_html__('Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '50',
            'range_settings' => [
                'min' => '5',
                'max' => '100',
                'step' => '1',
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'carousel',
        ];

        $fields['container_padding'] = [
            'label' => esc_html__('Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '30px|30px|30px|30px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];

        $fields['item_padding'] = [
            'label' => esc_html__('Item Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|20px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];

        $fields['effect'] = [
            'label' => esc_html__('Effect', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'coverflow' => esc_html__('Coverflow', 'dipi-divi-pixel'),
                'slide' => esc_html__('Slide', 'dipi-divi-pixel'),
            ],
            'default' => 'slide',
            'toggle_slug' => 'carousel',
        ];

        $fields['slide_shadows'] = [
            'label' => esc_html__('Slide Shadow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'toggle_slug' => 'carousel',
        ];

        $fields["shadow_overlay_color"] = [
            'label' => esc_html__('Slide Item Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
        ];

        $fields['rotate'] = [
            'label' => esc_html__('Rotate', 'dipi-divi-pixel'),
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
            'validate_unit' => true,
            'toggle_slug' => 'carousel',
        ];

        $fields['speed'] = [
            'label' => esc_html__('Transition Duration', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '5000',
                'step' => '100',
            ],
            'default' => 500,
            'validate_unit' => false,
            'toggle_slug' => 'carousel',
        ];

        $fields['loop'] = [
            'label' => esc_html__('Loop', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['autoplay'] = [
            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['pause_on_hover'] = [
            'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'autoplay' => 'on',
            ],
            'toggle_slug' => 'carousel',
            'default' => 'on',
        ];

        $fields['autoplay_speed'] = [
            'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => array(
                'min' => '1',
                'max' => '10000',
                'step' => '500',
            ),
            'default' => 5000,
            'validate_unit' => false,
            'show_if' => array(
                'autoplay' => 'on',
            ),
            'toggle_slug' => 'carousel',
        ];

        $fields['navigation'] = [
            'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'default' => 'off',
        ];
        $fields['navigation_on_hover'] = [
            'label' => esc_html__('Show Navigation on Hover', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'show_if' => ['navigation' => 'on'],
            'default' => 'off',
        ];
        $fields['pagination'] = [
            'label' => esc_html__('Pagination', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'default' => 'off',
        ];

        $fields['dynamic_bullets'] = [
            'label' => esc_html__('Dynamic Bullets', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'default' => 'on',
        ];

        $fields['centered'] = [
            'label' => esc_html__('Centered', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['navigation_prev_icon_yn'] = [
            'label' => esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_prev_icon'] = [
            'label' => esc_html__('Select Previous Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['navigation_prev_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon_yn'] = [
            'label' => esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon'] = [
            'label' => esc_html__('Select Next Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' => ['navigation_next_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'default' => 50,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_padding'] = [
            'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'default' => 10,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_color'] = [
            'label' => esc_html__('Arrow Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => et_builder_accent_color(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
            'mobile_options' => true,
        ];

        $fields['navigation_bg_color'] = [
            'label' => esc_html__('Arrow Background', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
            'mobile_options' => true,
        ];

        $fields['navigation_circle'] = [
            'label' => esc_html__('Circle Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_position_left'] = [
            'label' => esc_html__('Left Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66px',
            'default_on_front' => '-66px',
            'default_unit' => 'px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_position_right'] = [
            'label' => esc_html__('Right Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66px',
            'default_on_front' => '-66px',
            'default_unit' => 'px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['pagination_position'] = [
            'label' => esc_html__('Pagination Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-40',
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'unitless' => true,
            'show_if' => ['pagination' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        $fields['pagination_color'] = [
            'label' => esc_html__('Pagination Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#d8d8d8',
            'show_if' => ['pagination' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        $fields['pagination_active_color'] = [
            'label' => esc_html__('Pagination Active Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => et_builder_accent_color(),
            'show_if' => ['pagination' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        $fields['image_animation'] = [
            'label' => esc_html__('Image Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'none',
            'options' => [
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
                'move-up' => esc_html('Move Up', 'dipi-divi-pixel'),
                'move-down' => esc_html('Move Down', 'dipi-divi-pixel'),
                'move-left' => esc_html('Move Left', 'dipi-divi-pixel'),
                'move-right' => esc_html('Move Right', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'computed_affects' => ['__blogposts'],
        ];
        $computed_depends_on = array_merge(
            $computed_depends_on, 
            [
                'posts_number',
                'include_categories',
                'image_animation',
                'show_thumbnail',
                'card_clickable',
                'image_clickable',
                'show_more',
                'show_more_text',
                'show_author',
                'show_date',
                'show_categories',
                'show_comments',
                'show_excerpt',
                'excerpt_length',
                'expert_as_raw_html',
                'handle_shortcode_with_rawhtml',
                'handle_shortcode_without_rawhtml',
                'header_level',
                'button_icon',
                'button_use_icon',
                'use_thumbnails',
                'image_size',
                'orderby',
                'select_post_type',
                'select_custom_tax',
                'excluded_posts',
                'post_status',
                'offset_number'
                // 'exclude_current_post',
            ]
        );
        $fields['__blogposts'] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_Blog_Slider', 'get_blog_posts'],
            'computed_depends_on' => $computed_depends_on,
            'computed_minimum' => array(
                'posts_number',
            ),
        ];

        $additional_options = [];

        $additional_options = $this->dipi_add_bg_field($additional_options, [ // content_container {old name}
            'name' => 'item',
            'label' => esc_html__('Item Background', 'dipi-divi-pixel'),
            'tab_slug'              => 'advanced',
            'toggle_slug'           => 'blog_item',
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color')
        ]);

        $additional_options = $this->dipi_add_bg_field($additional_options, [ // content_container {old name}
            'name' => 'overlay',
            'label' => esc_html__('Overlay Background', 'dipi-divi-pixel'),
            'tab_slug'              => 'advanced',
            'toggle_slug'           => 'image',
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color')
        ]);

        return array_merge($fields, $additional_options);
    }

    public static function get_blog_posts($args = [], $conditional_tags = [], $current_page = [])
    {
        $defaults = [
            'posts_number' => '',
            'include_categories' => '',
            'image_animation' => '',
            'show_thumbnail' => '',
            'card_clickable' => '',
            'image_clickable' => '',
            'show_author' => '',
            'show_date' => '',
            'show_categories' => '',
            'show_comments' => '',
            'show_excerpt' => '',
            'excerpt_length' => '',
            'expert_as_raw_html' => 'off',
            'handle_shortcode_with_rawhtml' => 'show',
            'handle_shortcode_without_rawhtml' => 'show',
            'header_level' => '',
            'show_more' => '',
            'button_use_icon' => '',
            'button_icon' => '',
            'button_use_icon' => '',
            'image_size' => '',
            'image_size_tablet' => '',
            'image_size_phone' => '',
            'image_size_last_edited' => '',
            'excluded_posts' => '',
            'post_status' => 'publish',
            'offset_number' => 0
            // 'exclude_current_post' => 'off',
        ];

        $args = wp_parse_args($args, $defaults);

        $width = (int) apply_filters('et_pb_blog_image_width', 1080);
        $height = (int) apply_filters('et_pb_blog_image_height', 675);
        $image_size_last_edited = et_pb_get_responsive_status($args['image_size_last_edited']);
        $args['image_size'] = ($args['image_size']) ? $args['image_size'] : [$width, $height];
        $args['image_size_tablet'] = ($image_size_last_edited && isset($args['image_size_tablet']) && $args['image_size_tablet'] !== '') ? $args['image_size_tablet'] : $args['image_size'];
        $args['image_size_phone'] = ($image_size_last_edited && isset($args['image_size_phone']) && $args['image_size_phone'] !== '') ? $args['image_size_phone'] : $args['image_size_tablet'];

        $processed_header_level = et_pb_process_header_level($args['header_level'], 'h2');
        $processed_header_level = esc_html($processed_header_level);

        $query_args = [
            'posts_per_page' => intval($args['posts_number']),
            'post_status' => 'publish',
            'post_type' => 'post',
        ];

        $is_single = et_fb_conditional_tag('is_single', $conditional_tags);
        $post_id = isset($current_page['id']) ? (int) $current_page['id'] : 0;

        $select_post_type = $args['select_post_type'];
        $select_custom_tax = $args['select_custom_tax'];
        if ($select_custom_tax === 'category') {
            $include_term_ids = $args['include_categories'];
        } else {
            $include_term_ids = $args["include_term_ids_of_$select_custom_tax"];
        }
        if ($select_custom_tax === 'category') {
            $query_args['cat'] = implode(',', self::filter_include_categories($include_term_ids, $post_id, $select_custom_tax));
        } else {
            $include_term_ids = self::filter_include_categories($include_term_ids, $post_id, $select_custom_tax);
            if (!empty($include_term_ids)) {
                $tax_query = [
                    [
                        'taxonomy' => $select_custom_tax,
                        'field'    => 'id',
                        'terms'    => $include_term_ids,
                    ]
                ];
                $query_args['tax_query'] = $tax_query;
            }
        }
        $query_args['post_type'] = $select_post_type;        
        $query_args['post_status'] = $args['post_status'];
        $image_animation_class = 'dipi-' . $args['image_animation'];
        switch ($args['orderby']) {
            case 'date_asc':
                $query_args['orderby'] = 'date';
                $query_args['order'] = 'ASC';
                break;
            case 'title_asc':
                $query_args['orderby'] = 'title';
                $query_args['order'] = 'ASC';
                break;
            case 'title_desc':
                $query_args['orderby'] = 'title';
                $query_args['order'] = 'DESC';
                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            default:
                $query_args['orderby'] = 'date';
                $query_args['order'] = 'DESC';
                break;
        }

        $excluded_posts = [];
        if ($args['excluded_posts'] !== '') {
            $excluded_posts = explode(',', $args['excluded_posts']);
        }

        // if($args['exclude_current_post'] === 'on' && et_fb_conditional_tag( 'is_single', $conditional_tags )) {
        if (et_fb_conditional_tag('is_single', $conditional_tags)) {
            $post_id = isset($current_page['id']) ? (int) $current_page['id'] : self::get_current_post_id_reverse();
            $excluded_posts[] = $post_id;
        }

        if (!empty($excluded_posts)) {
            $query_args['post__not_in'] = $excluded_posts;
        }
        if (!empty($excluded_posts)) {
            $query_args['post__not_in'] = $excluded_posts;
        }

        $query_args['offset'] = $args['offset_number'];

        // Get query
        $q = new WP_Query($query_args);

        ob_start();
        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                include dirname(__FILE__) . '/templates/dipi-blog-post.php';
            }
        }

        if (!$posts = ob_get_clean()) {
            $posts = self::get_no_results_template(et_core_esc_previously($processed_header_level));
        }

        return $posts;
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
    public function apply_custom_style(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false,
        $zoom = '',
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
        }
        if ($wrap_func !== '') {
            $slug_value = "$wrap_func($slug_value)";
            $slug_value_tablet = "$wrap_func($slug_value_tablet)";
            $slug_value_phone = "$wrap_func($slug_value_phone)";
        }

        if (isset($slug_value) && !empty($slug_value)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value, $type, $important),
            ));
        }

        if (isset($slug_value_tablet)
            && !empty($slug_value_tablet)
            && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (isset($slug_value_phone)
            && !empty($slug_value_phone)
            && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
    public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
    {
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if (isset($slug_value) && !empty($slug_value)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
            ));
        }

        if (isset($slug_value_tablet) && !empty($slug_value_tablet) && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (isset($slug_value_phone) && !empty($slug_value_phone) && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
    public function dipi_get_image_sizes()
    {
        global $_wp_additional_image_sizes;
        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        foreach ($get_intermediate_image_sizes as $_size) {
            if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
                $sizes[$_size]['width'] = get_option($_size . '_size_w');
                $sizes[$_size]['height'] = get_option($_size . '_size_h');
                $sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                );
            }
        }

        $image_sizes = array(
            'full' => esc_html__('Full Size', 'dipi-divi-pixel'),
        );
        foreach ($sizes as $sizeKey => $sizeValue) {
            $image_sizes[$sizeKey] = sprintf(
                '%1$s (%2$s x %3$s,%4$s cropped)',
                $sizeKey,
                $sizeValue["width"],
                $sizeValue["height"],
                ($sizeValue["crop"] == false ? ' not' : '')

            );
        }

        return $image_sizes;
    }
    private static function get_attachment_image($attachment_id, $image_size, $fallback_url)
    {
        $attachment = wp_get_attachment_image_src($attachment_id, $image_size);
        if ($attachment) {
            return $attachment[0];
        } else {
            return $fallback_url;
        }
    }
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_blog_slider_public');
        wp_enqueue_style('dipi_swiper');
        add_filter('et_late_global_assets_list', [$this, 'dipi_et_late_global_assets_list'], 100, 3);

        $posts_number = $this->props['posts_number'];
        $include_categories = $this->props['include_categories'];
        $show_thumbnail = $this->props['show_thumbnail'];
        $card_clickable = $this->props['card_clickable'];
        $image_clickable = $this->props['image_clickable'];
        $show_author = $this->props['show_author'];
        $show_date = $this->props['show_date'];
        $show_categories = $this->props['show_categories'];
        $show_comments = $this->props['show_comments'];
        $show_excerpt = $this->props['show_excerpt'];
        $excerpt_length = $this->props['excerpt_length'];
        $expert_as_raw_html = $this->props['expert_as_raw_html'];
        $handle_shortcode_with_rawhtml = $this->props['handle_shortcode_with_rawhtml'];
        $handle_shortcode_without_rawhtml = $this->props['handle_shortcode_without_rawhtml'];
        $show_more = $this->props['show_more'];
        $show_more_text = $this->props['show_more_text'];
        $header_level = $this->props['header_level'];
        $image_animation = $this->props['image_animation'];
        $button_use_icon = $this->props['button_use_icon'];
        $button_icon = $this->props['button_icon'];
        $image_size_last_edited = $this->props['image_size_last_edited'];
        $image_size = $this->props['image_size'];
        $image_size_tablet = $this->props['image_size_tablet'];
        $image_size_phone = $this->props['image_size_phone'];
        $orderby = $this->props['orderby'];

        $blog_content = self::get_blog_posts($this->props);

        $columns_desktop = $this->props['columns'];
        $columns_tablet = $this->props['columns_tablet'] ? $this->props['columns_tablet'] : $columns_desktop;
        $columns_phone = $this->props['columns_phone'] ? $this->props['columns_phone'] : $columns_tablet;

        if ($columns_desktop === "4" && $columns_tablet === "4" && $columns_phone === "4") {
            $columns_tablet = "2";
            $columns_phone = "1";
        }

        $space_between = $this->props['space_between'];
        $space_between_tablet = ($this->props['space_between_tablet']) ? $this->props['space_between_tablet'] : $space_between;
        $space_between_phone = ($this->props['space_between_phone']) ? $this->props['space_between_phone'] : $space_between_tablet;

        $speed = $this->props['speed'];
        $loop = $this->props['loop'];
        $centered = $this->props['centered'];
        $autoplay = $this->props['autoplay'];
        $autoplay_speed = $this->props['autoplay_speed'];
        $pause_on_hover = $this->props['pause_on_hover'];
        $navigation = $this->props['navigation'];
        $navigation_on_hover = $this->props['navigation_on_hover'];
        $pagination = $this->props['pagination'];
        $effect = $this->props['effect'];
        $rotate = $this->props['rotate'];
        $dynamic_bullets = $this->props['dynamic_bullets'];
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $slide_shadows = ('on' === $this->props['slide_shadows']) ? esc_attr('true') : esc_attr('false');

        $this->apply_css($render_slug);

        $options = sprintf('
		    data-columnsmobile="%1$s"
		    data-columnstablet="%2$s"
		    data-columnsdesktop="%3$s"
		    data-spacebetween="%4$s"
		    data-loop="%5$s"
		    data-speed="%6$s"
		    data-navigation="%7$s"
		    data-pagination="%8$s"
		    data-autoplay="%9$s"
		    data-autoplayspeed="%10$s"
		    data-pauseonhover="%11$s"
		    data-effect="%12$s"
		    data-rotate="%13$s"
		    data-dynamicbullets="%14$s"
		    data-ordernumber="%15$s"
		    data-centered="%16$s"
		    data-spacebetween_tablet="%17$s"
		    data-spacebetween_phone="%18$s"
		    data-shadow="%19$s"',
            esc_attr($columns_phone),
            esc_attr($columns_tablet),
            esc_attr($columns_desktop),
            esc_attr($space_between),
            esc_attr($loop),
            esc_attr($speed),
            esc_attr($navigation),
            esc_attr($pagination),
            esc_attr($autoplay),
            esc_attr($autoplay_speed), #10
            esc_attr($pause_on_hover),
            esc_attr($effect),
            esc_attr($rotate),
            esc_attr($dynamic_bullets),
            esc_attr($order_number), #15
            esc_attr($centered),
            esc_attr($space_between_tablet),
            esc_attr($space_between_phone),
            esc_attr($slide_shadows)
        );

        $data_next_icon = $this->props['navigation_next_icon'];
        $data_prev_icon = $this->props['navigation_prev_icon'];
        $data_next_icon = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_next_icon)));
        $data_prev_icon = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_prev_icon)));
        $next_icon = 'on' === $this->props['navigation_next_icon_yn'] ? $data_next_icon : 'data-icon="9"';
        $prev_icon = 'on' === $this->props['navigation_prev_icon_yn'] ? $data_prev_icon : 'data-icon="8"';

        $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%% .swiper-button-next:after');
        $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon', '%%order_class%% .swiper-button-prev:after');

        $navigation = ($this->props['navigation'] == 'on') ? sprintf(
            '<div class="swiper-button-next swiper-arrow-button dipi-sbn%1$s %4$s" %2$s></div>
		    <div class="swiper-button-prev swiper-arrow-button dipi-sbp%1$s %4$s" %3$s></div>',
            $order_number,
            $next_icon,
            $prev_icon,
            $navigation_on_hover === "on" ? "show_on_hover" : ""
        ) : '';

        $pagination = ($this->props['pagination'] == 'on') ? sprintf(
            '<div class="swiper-pagination dipi-sp%1$s"></div>',
            $order_number
        ) : '';

        $output = sprintf('
		    <div class="dipi-blog-slider-main preloading" %2$s>
		        <div class="swiper-container">
		            <div class="dipi-blog-slider-wrapper">
		                %1$s
		            </div>
		        </div>
		        %3$s
		        <div class="swiper-container-horizontal">
		            %4$s
		        </div>
		    </div>',
            $blog_content,
            $options,
            $navigation,
            $pagination
        );

        return $output;
    }

    public function apply_css($render_slug)
    {

        $this->_dipi_thumbnail_height($render_slug);

        $show_more = $this->props['show_more'];
        $show_comments = $this->props['show_comments'];
        $button_alignment = $this->props['button_alignment'];
        $navigation_hover_selector = '%%order_class%% .swiper-arrow-button:hover:after';
        $navigation_hover_bg_selector = '%%order_class%% .swiper-arrow-button:hover';

        if (!isset($this->props['border_style_all_image']) || empty($this->props['border_style_all_image'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-entry-featured-image-url",
                'declaration' => "border-style: solid;",
            ]);
        }

        if ($show_more === 'on' && $show_comments === 'on') {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-comments',
                'declaration' => 'position: absolute; right: 0; bottom: 0; transform: translate(-50%, -40%);',
            ));

            if ($button_alignment === 'right') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi-bottom-content',
                    'declaration' => 'padding-right: 65px; ',
                ));
            }
        }

        if ($button_alignment === 'left') {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-bottom-content',
                'declaration' => 'justify-content: flex-start !important;',
            ));

        } elseif ($button_alignment === 'center') {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-bottom-content',
                'declaration' => 'justify-content: center !important;',
            ));

        } else if ($button_alignment === 'right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-bottom-content',
                'declaration' => 'justify-content: flex-end ;',
            ));

        }

        $slide_shadows = $this->props['slide_shadows'];
        $shadow_overlay_color = $this->props['shadow_overlay_color'];

        if ($slide_shadows == 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-left',
                'declaration' => 'background-image: -webkit-gradient(linear, right top, left top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-right',
                'declaration' => 'background-image: -webkit-gradient(linear, left top, right top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));background-image: -o-linear-gradient(left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-top',
                'declaration' => 'background-image: -webkit-gradient(linear, left bottom, left top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-bottom',
                'declaration' => ' background-image: -webkit-gradient(linear, left top, left bottom, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));background-image: linear-gradient(to bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));
        }

        $author_align = $this->props['author_align'];

        if ($author_align == 'left') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-blog-post .dipi-author",
                'declaration' => "justify-content: flex-start;",
            ]);
        }

        if ($author_align == 'right') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-blog-post .dipi-author",
                'declaration' => "justify-content: flex-end;",
            ]);
        }

        if ($author_align == 'center') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-blog-post .dipi-author",
                'declaration' => "justify-content: center;",
            ]);
        }

        $container_class = "%%order_class%% .swiper-container";
        $navigation_position_left_class = "%%order_class%% .swiper-button-prev, %%order_class%%:hover .swiper-button-prev.swiper-arrow-button.show_on_hover";
        $navigation_position_right_class = "%%order_class%% .swiper-button-next, %%order_class%%:hover .swiper-button-next.swiper-arrow-button.show_on_hover";
        $navigation_position_left_area_class = "%%order_class%% .swiper-button-prev.swiper-arrow-button.show_on_hover:before";
        $navigation_position_right_area_class = "%%order_class%% .swiper-button-next.swiper-arrow-button.show_on_hover:before";
        $important = false;

        $container_padding = explode('|', $this->props['container_padding']);
        $container_padding_tablet = explode('|', $this->props['container_padding_tablet']);
        $container_padding_phone = explode('|', $this->props['container_padding_phone']);
        $container_padding_last_edited = $this->props['container_padding_last_edited'];
        $container_padding_responsive_status = et_pb_get_responsive_status($container_padding_last_edited);

        if ('' !== $container_padding) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
            ));
        }

        if ( count($container_padding_tablet) >= 4 && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', 
                $container_padding_tablet[0], $container_padding_tablet[1], $container_padding_tablet[2], $container_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $container_padding_phone && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $item_padding = explode('|', $this->props['item_padding']);
        $item_padding_tablet = explode('|', $this->props['item_padding_tablet']);
        $item_padding_phone = explode('|', $this->props['item_padding_phone']);

        $item_padding_last_edited = $this->props['item_padding_last_edited'];
        $item_padding_responsive_status = et_pb_get_responsive_status($item_padding_last_edited);

        if ('' !== $item_padding) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-blog-post",
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $item_padding[0], $item_padding[1], $item_padding[2], $item_padding[3]),
            ));
        }

        if ('' !== $item_padding_tablet && $item_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-blog-post",
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $item_padding_tablet[0], $item_padding_tablet[1], $item_padding_tablet[2], $item_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $item_padding_phone && $item_padding_responsive_status) {
            $paddint_top = (isset($item_padding_phone[0])) ? sprintf('padding-top: %1$s !important;', $item_padding_phone[0]):'';
            $paddint_right = (isset($item_padding_phone[1])) ? sprintf('padding-right: %1$s !important;', $item_padding_phone[1]):'';
            $paddint_bottom = (isset($item_padding_phone[2])) ? sprintf('padding-bottom: %1$s !important;', $item_padding_phone[2]):'';
            $paddint_left = (isset($item_padding_phone[3])) ? sprintf('padding-left: %1$s !important;', $item_padding_phone[3]):'';
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-blog-post",
                'declaration' => sprintf('%1$s %2$s %3$s %4$s', $paddint_top, $paddint_right, $paddint_bottom, $paddint_left),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
       }

        $navigation_position_left = $this->props['navigation_position_left'];
        $navigation_position_left_tablet = $this->props['navigation_position_left_tablet'];
        $navigation_position_left_phone = $this->props['navigation_position_left_phone'];
        $navigation_position_left_last_edited = $this->props['navigation_position_left_last_edited'];
        $navigation_position_left_responsive_status = et_pb_get_responsive_status($navigation_position_left_last_edited);

        if ('' !== $navigation_position_left) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left),
            ));
        }

        if ('' !== $navigation_position_left_tablet && $navigation_position_left_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        /* Left navigation area */
        if ('' !== $navigation_position_left && $navigation_position_left < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left),
            ));
        }

        if ('' !== $navigation_position_left_tablet && $navigation_position_left_responsive_status && $navigation_position_left_tablet < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status && $navigation_position_left_phone < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        $navigation_position_right = $this->props['navigation_position_right'];
        $navigation_position_right_tablet = $this->props['navigation_position_right_tablet'];
        $navigation_position_right_phone = $this->props['navigation_position_right_phone'];
        $navigation_position_right_last_edited = $this->props['navigation_position_right_last_edited'];
        $navigation_position_right_responsive_status = et_pb_get_responsive_status($navigation_position_right_last_edited);

        if ('' !== $navigation_position_right) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right),
            ));
        }

        if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        if ('' !== $navigation_position_right && $navigation_position_right < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right),
            ));
        }

        if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status && $navigation_position_right_tablet < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status && $navigation_position_right_phone < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $this->apply_custom_style(
            $this->slug,
            'navigation_color',
            'color',
            '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
            true
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_color',
            'color',
            $navigation_hover_selector,
            true
        );

        $this->apply_custom_style(
            $this->slug,
            'navigation_bg_color',
            'background',
            '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            true,
            ''
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_bg_color',
            'background',
            $navigation_hover_bg_selector,
            true
        );

        $this->apply_custom_style(
            $this->slug,
            'navigation_size',
            'width',
            '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            true,
            '',
            'px'
        );
        $this->apply_custom_style(
            $this->slug,
            'navigation_size',
            'height',
            '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            true,
            '',
            'px'
        );
        $this->apply_custom_style(
            $this->slug,
            'navigation_size',
            'font-size',
            '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
            true,
            '',
            'px'
        );

        $this->apply_custom_style(
            $this->slug,
            'navigation_padding',
            'padding',
            '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            true,
            '',
            'px'
        );

        if ('on' == $this->props['navigation_circle']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => 'border-radius: 50% !important;',
            ));
        }

        if ('' !== $this->props['pagination_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination-bullet',
                'declaration' => sprintf(
                    'background: %1$s!important;', $this->props['pagination_color']),
            ));
        }

        if ('' !== $this->props['pagination_active_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'declaration' => sprintf(
                    'background: %1$s !important;', $this->props['pagination_active_color']),
            ));
        }

        if ('' !== $this->props['pagination_position']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-container-horizontal > .swiper-pagination-bullets, %%order_class%% .swiper-pagination-fraction, %%order_class%% .swiper-pagination-custom',
                'declaration' => sprintf(
                    'bottom: %1$spx;',
                    $this->props['pagination_position']),
            ));
        }

        if ('on' == $this->props['date_circle_icon']) {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-date',
                'declaration' => 'border-radius: 100px; ',
            ));

        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi-date',
            'declaration' => sprintf(
                'background-color: %1$s !important; ',
                esc_html($this->props['date_circle_color'])
            ),
        ));

        if ('on' == $this->props['date_circle_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-date',
                'declaration' => sprintf(
                    'border-width:3px; border-style:solid; border-color: %1$s !important;',
                    $this->props['date_circle_border']),
            ));
        }

        $date_right_space = $this->props['date_right_space'];
        $date_right_space_tablet = $this->props['date_right_space_tablet'];
        $date_right_space_phone = $this->props['date_right_space_phone'];
        $date_right_space_last_edited = $this->props['date_right_space_last_edited'];
        $date_right_space_responsive_status = et_pb_get_responsive_status($date_right_space_last_edited);

        if ('' !== $date_right_space) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('right: %1$s !important;', $date_right_space),
            ));
        }

        if ('' !== $date_right_space_tablet && $date_right_space_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('right: %1$s !important;', $date_right_space_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $date_right_space_phone && $date_right_space_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('right: %1$s !important;', $date_right_space_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $date_top_space = $this->props['date_top_space'];
        $date_top_space_tablet = $this->props['date_top_space_tablet'];
        $date_top_space_phone = $this->props['date_top_space_phone'];
        $date_top_space_last_edited = $this->props['date_top_space_last_edited'];
        $date_top_space_responsive_status = et_pb_get_responsive_status($date_top_space_last_edited);

        if ('' !== $date_top_space) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('top: %1$s !important;', $date_top_space),
            ));
        }

        if ('' !== $date_top_space_tablet && $date_top_space_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('top: %1$s !important;', $date_top_space_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $date_top_space_phone && $date_top_space_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-date",
                'declaration' => sprintf('top: %1$s !important;', $date_top_space_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-blog-post .dipi-blog-post-overlay',
            '%%order_class%% .dipi-blog-post:hover .dipi-blog-post-overlay',
            'overlay_bg',
            'overlay_bg_color'
        );

        // Overlay Hover
        if (et_builder_is_hover_enabled("overlay_bg_color", $this->props)) {

            $ob_image_hover = [];
            $ob_style_hover = '';

            if (isset($this->props["overlay_bg_use_color_gradient__hover"]) && 'on' === $this->props["overlay_bg_use_color_gradient__hover"]) {

                $ob_type_hover = isset($this->props["overlay_bg_color_gradient_type__hover"]) ? $this->props["overlay_bg_color_gradient_type__hover"] : 'linear';
                $ob_direction_hover = isset($this->props["overlay_bg_color_gradient_direction__hover"]) ? $this->props["overlay_bg_color_gradient_direction__hover"] : '180deg';
                $ob_direction_radial_hover = isset($this->props["overlay_bg_color_gradient_direction_radial__hover"]) ? $this->props["overlay_bg_color_gradient_direction_radial__hover"] : 'circle';
                $ob_start_hover = isset($this->props["overlay_bg_color_gradient_start__hover"]) ? $this->props["overlay_bg_color_gradient_start__hover"] : '#2b87da';
                $ob_end_hover = isset($this->props["overlay_bg_color_gradient_end__hover"]) ? $this->props["overlay_bg_color_gradient_end__hover"] : '#29c4a9';
                $ob_start_position_hover = isset($this->props["overlay_bg_color_gradient_start_position__hover"]) ? $this->props["overlay_bg_color_gradient_start_position__hover"] : '0%';
                $ob_end_position_hover = isset($this->props["overlay_bg_color_gradient_end_position__hover"]) ? $this->props["overlay_bg_color_gradient_end_position__hover"] : '100%';
                $ob_overlays_image_hover = isset($this->props["overlay_bg_color_gradient_overlays_image__hover"]) ? $this->props["overlay_bg_color_gradient_overlays_image__hover"] : 'off';

                $overlay_direction_hover = $ob_type_hover === 'linear' ? $ob_direction_hover : "circle at {$ob_direction_radial_hover}";
                $overlay_start_position_hover = et_sanitize_input_unit($ob_start_position_hover, false, '%');
                $overlay_end_position_hover = et_sanitize_input_unit($ob_end_position_hover, false, '%');

                $overlay_gradient_bg_hover = "
					{$ob_type_hover}-gradient($overlay_direction_hover,
					{$ob_start_hover}
					{$overlay_start_position_hover},
					{$ob_end_hover}
					{$overlay_end_position_hover}
				)";

                if (!empty($overlay_gradient_bg_hover)) {

                    $ob_image_hover[] = $overlay_gradient_bg_hover;

                }

            }

            if (!empty($ob_image_hover)) {
                if ('on' !== $ob_overlays_image_hover) {
                    $ob_image_hover = array_reverse($ob_image_hover);
                }

                $ob_style_hover .= sprintf(
                    'background-image: %1$s !important;',
                    esc_html(join(', ', $ob_image_hover))
                );
            }

            $ob_color_hover = $this->props["overlay_bg_color__hover"];

            if ('' !== $ob_color_hover) {
                $ob_style_hover .= sprintf(
                    'background-color: %1$s !important; ',
                    esc_html($ob_color_hover)
                );
            }

            if ('' !== $ob_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi-blog-post:hover .dipi-blog-post-overlay',
                    'declaration' => rtrim($ob_style_hover),
                ));
            }

        }

        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-blog-post',
            '%%order_class%% .dipi-blog-post:hover',
            'item_bg',
            'item_bg_color'
        );
    }

    private function _dipi_thumbnail_height($render_slug)
    {
        $thumbnail_height = $this->props['thumbnail_height'];
        $thumbnail_height_tablet = $this->props['thumbnail_height_tablet'] ? $this->props['thumbnail_height_tablet'] : $thumbnail_height;
        $thumbnail_height_phone = $this->props['thumbnail_height_phone'] ? $this->props['thumbnail_height_phone'] : $thumbnail_height_tablet;
        $thumbnail_height_last_edited = $this->props['thumbnail_height_last_edited'];
        $thumbnail_height_responsive_status = et_pb_get_responsive_status($thumbnail_height_last_edited);

        if ('on' === $this->props['use_thumbnail_height']) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% img.wp-post-image',
                'declaration' => "height: {$thumbnail_height} !important;",
            ]);

            if ('' !== $thumbnail_height_tablet && $thumbnail_height_responsive_status) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% img.wp-post-image',
                    'declaration' => "height: {$thumbnail_height_tablet} !important;",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]);
            }

            if ('' !== $thumbnail_height_phone && $thumbnail_height_responsive_status) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% img.wp-post-image',
                    'declaration' => "height: {$thumbnail_height_phone} !important;",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]);
            }
        }
    }

}

new DIPI_Blog_Slider;
