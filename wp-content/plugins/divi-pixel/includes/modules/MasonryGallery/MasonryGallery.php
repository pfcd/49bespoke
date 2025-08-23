<?php

// Migrate pre 2.15.0 module settings from images to gallery_ids 
add_filter('et_pb_module_shortcode_attributes', function($attrs, $unprocessed_attrs, $module_slug, $_1, $_2, $_3 = false){
    if($module_slug === 'dipi_masonry_gallery' && empty($attrs['gallery_ids']) && !empty($unprocessed_attrs['images'])){
        $attrs['gallery_ids'] = $unprocessed_attrs['images'];
    }
    return $attrs;
}, 10, 6);

/**
 * TODO:
 * -Pagination
 * -Setting to allow sorting images by title (a-z, z-a, random)
 * -Setting to apply box shadow to images
 */

class DIPI_MasonryGallery extends DIPI_Builder_Module
{
    private static $vendor_prefix = 'dipi';
    public $slug = 'dipi_masonry_gallery';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/masonry-gallery',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
    {
        $slug_value = $this->props[$slug];
        $slug_value_tablet = $this->props[$slug . '_tablet'];
        $slug_value_phone = $this->props[$slug . '_phone'];
        $slug_value_last_edited = $this->props[$slug . '_last_edited'];
        $slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

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

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Masonry Gallery', 'dipi-divi-pixel');
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'images' => esc_html__('Images', 'dipi-divi-pixel'),
                    'pagination' => esc_html__('Pagination', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                    'overlay_animation' => array(
                        'title' => esc_html__('Overlay Animation', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'icon' => [
                                'name' => 'Icon',
                            ],
                            'title' => [
                                'name' => 'Title',
                            ],
                            'caption' => [
                                'name' => 'Caption',
                            ],
                        ],
                    ),
                    'grid' => esc_html__('Grid', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'pagination_btn'  => [
                        'title' =>  esc_html__('Pagination Button', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'
                         => [
                            'normal' => [
                                'name' => 'Normal',
                            ],
                            'active' => [
                                'name' => 'Active',
                            ],
                        ],
                    ],
                    'load_more' => esc_html__('Load More', 'dipi-divi-pixel'),
                    'grid' => esc_html__('Grid', 'dipi-divi-pixel'),
                    'grid_items' => esc_html__('Grid Items', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                    'text_group' => array(
                        'title' => esc_html__('Overlay Text', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'caption' => [
                                'name' => 'Caption',
                            ],
                        ],
                    ),
                ],
            ],
        ];
        $this->custom_css_fields = array(
            'overlay_icon' => array(
                'label' => esc_html__('Overlay Icon', 'dipi-divi-pixel'),
                'selector' => '.dipi-mansonry-gallery-icon',
            ),
            'overlay_title' => array(
                'label' => esc_html__('Overlay Title', 'dipi-divi-pixel'),
                'selector' => '.dipi-mansonry-gallery-title',
            ),
            'overlay_caption' => array(
                'label' => esc_html__('Overlay Caption', 'dipi-divi-pixel'),
                'selector' => '.dipi-mansonry-gallery-caption',
            ),
        );
    }

    public function get_fields()
    {
        $et_accent_color = et_builder_accent_color();

        $fields = [];

        $fields["images"] = [
            'label' => esc_html__('Gallery Images', 'dipi-divi-pixel'),
            'type' => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'computed_affects' => array(
                '__gallery',
            ),
        ];
        
        $fields["gallery_ids"] = [
            'label' => esc_html__('Gallery Images', 'dipi-divi-pixel'),
            'type' => 'upload-gallery',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'computed_affects' => array(
                '__gallery',
            ),
        ];

        $fields['gallery_orderby'] = array(
            'label' => esc_html__('Order By', 'dipi-divi-pixel'),
            'type' => $this->is_loading_bb_data() ? 'hidden' : 'select',
            'default' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'date_asc' => esc_html__('Date ASC', 'dipi-divi-pixel'),
                'date_desc' => esc_html__('Date DESC', 'dipi-divi-pixel'),
                'title_asc' => esc_html__('Title ASC', 'dipi-divi-pixel'),
                'title_desc' => esc_html__('Title DESC', 'dipi-divi-pixel'),
                'rand' => esc_html__('Random', 'dipi-divi-pixel')
            ),
            'class' => array('et-pb-gallery-ids-field'),
            'computed_affects' => array(
                '__gallery',
            ),
            'toggle_slug' => 'images',
        );

        $fields["horizontal_order_direction"] = [
            'label' => esc_html__('Horizontal Order Direction', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'images',
             'computed_affects' => array(
                '__gallery',
            )
        ];





        $fields['pagination_type'] = [
            'label' => esc_html__('Pagination Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'numbered_pagination' => esc_html__('Numbered Pagination', 'dipi-divi-pixel'),
                'load_more' => esc_html__('Load More', 'dipi-divi-pixel'),
                'infinite_scroll' => esc_html__('Infinite Scroll', 'dipi-divi-pixel'),
            ],
            'default' => 'none',
            'toggle_slug' => 'pagination',
            'description' => esc_html__("Define the type of pagination.", 'dipi-divi-pixel'),
            'computed_affects' => ['__gallery'],
            'mobile_options' => true,
        ];
        $fields['image_count'] = [
            'label' => esc_html__('Image Count', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'unitless' => true,
            'default' => '-1',
            'range_settings' => array(
                'min' => '-1',
                'max' => '50',
                'step' => '1',
            ),
            'toggle_slug' => 'pagination',
            'description' => esc_html__("Define the number of images that should be displayed.", 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
            'mobile_options' => true,
            'show_if' => [
                'pagination_type' => 'none'
            ]
        ];
        
        $fields['images_per_page'] = [
            'label' => esc_html__('Images Per Page', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'unitless' => true,
            'default' => '10',
            'range_settings' => array(
                'min' => '1',
                'max' => '50',
                'step' => '1',
            ),
            'toggle_slug' => 'pagination',
            'description' => esc_html__("Define the number of images that should be displayed on a page.", 'dipi-divi-pixel'),
            'computed_affects' => ['__gallery'],
            'show_if_not' => [
                'pagination_type' => 'none'
            ]
        ];
        $fields["prev_btn_text"] = [
            'label'       => esc_html__('Prev Button Text', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'pagination',
            'default' => 'Prev',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'pagination_type' => ['numbered_pagination']
            ]
        ];

        $fields["next_btn_text"] = [
            'label'       => esc_html__('Next Button Text', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'pagination',
            'default' => 'Next',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'pagination_type' => ['numbered_pagination']
            ]
        ]; 
        $fields["load_more_text"] = [
            'label'       => esc_html__('Load More Text', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'pagination',
            'default' => 'Load More',
            'dynamic_content' => 'text',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'pagination_type' => ['load_more','infinite_scroll']
            ]
        ]; 
        $fields['infinite_scroll_viewport'] = [
            'label'           => esc_html__( 'Infinite Scrolling Viewport', 'dipi-divi-pixel' ),
            'description' => esc_html__('Load more images when scrolled this amount. Shouldn\'t be larger than 50% of screen height', 'dipi-divi-pixel'),
            'type'            => 'range',
            'range_settings'  => [
                'min'  => 0,
                'max'  => 50,
                'step' => 1,
            ],
            'default'             => '25%',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'validate_unit'       => true,
            'fixed_range'         => true,
            'reset_animation'     => true,
            'toggle_slug' => 'pagination',
            'show_if' => [
                'pagination_type' => 'infinite_scroll'
            ]
        ]; 















        $fields["use_media_link"] = [
            'label' => esc_html__('Use Image Link', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'images',
            'description' => esc_html__('Open custom URL when image is clicked.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
            'mobile_options' => true,
        ];
        $fields["show_lightbox"] = [
            'label' => esc_html__('Show Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'images',
            'description' => esc_html__('Whether or not to show lightbox.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
            'mobile_options' => true,
            'show_if' => [
                'use_media_link' => 'off',
            ],
        ];
        $fields["title_in_lightbox"] = [
            'label' => esc_html__('Show Image Title in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'images',
            'description' => esc_html__('Whether or not to show the image title in the lightbox. The title is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'use_media_link' => 'off',
                'show_lightbox' => 'on',
            ],
        ];

        $fields["caption_in_lightbox"] = [
            'label' => esc_html__('Show Image Caption in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'images',
            'description' => esc_html__('Whether or not to show the image caption in the lightbox. The caption is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'use_media_link' => 'off',
                'show_lightbox' => 'on',
            ],
        ];

        $fields["use_overlay"] = [
            'label' => esc_html__('Use Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'overlay',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'computed_affects' => array(
                '__gallery',
            ),
            'mobile_options' => true,
        ];
        $fields["overlay_align_horizontal"] = [
            'label' => esc_html__('Horizontal Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'flex-start' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];

        $fields["overlay_align_vertical"] = [
            'label' => esc_html__('Vertical Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'flex-start' => esc_html__('Top', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields["icon_in_overlay"] = [
            'label' => esc_html__('Show Icon in Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay',
            'description' => esc_html__('Whether or not to show the Icon in the Overlay. The title is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
        ];

        $fields['hover_icon'] = array(
            'label' => esc_html__('Overlay Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'configuration',
            'class' => array('et-pb-font-icon'),
            'option_category' => 'configuration',
            'default' => '',
            'toggle_slug' => 'overlay',
            'show_if' => [
                'icon_in_overlay' => 'on',
            ],
            'computed_affects' => array(
                '__gallery',
            ),
        );

        $fields["title_in_overlay"] = [
            'label' => esc_html__('Show Image Title in Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay',
            'description' => esc_html__('Whether or not to show the image title in the Overlay. The title is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
        ];

        $fields["caption_in_overlay"] = [
            'label' => esc_html__('Show Image Caption in Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay',
            'description' => esc_html__('Whether or not to show the image caption in the lightbox. The caption is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'computed_affects' => array(
                '__gallery',
            ),
        ];
        $fields["icon_animation"] = [
            'label' => esc_html__('Icon Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'fadeInUp',
            'options' => [
                'fadeIn' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeft' => esc_html__('Fade In Left', 'dipi-divi-pixel'),
                'fadeInRight' => esc_html__('Fade In Right', 'dipi-divi-pixel'),
                'fadeInUp' => esc_html__('Fade In Up', 'dipi-divi-pixel'),
                'fadeInDown' => esc_html__('Fade In Down', 'dipi-divi-pixel'),
                'zoomIn' => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceIn' => esc_html__('Bounce In', 'dipi-divi-pixel'),
                'bounceInLeft' => esc_html__('Bounce In Left', 'dipi-divi-pixel'),
                'bounceInRight' => esc_html__('Bounce In Right', 'dipi-divi-pixel'),
                'bounceInUp' => esc_html__('Boune In Up', 'dipi-divi-pixel'),
                'bounceInDown' => esc_html__('BouneIn Down', 'dipi-divi-pixel'),
                'flipInX' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInY' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBox' => esc_html__('JackInThe Box', 'dipi-divi-pixel'),
                'rotateIn' => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeft' => esc_html__('RotateInDownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeft' => esc_html__('RotateInUpLeft', 'dipi-divi-pixel'),
                'rotateInDownRight' => esc_html__('RotateInDownRight', 'dipi-divi-pixel'),
                'rotateInUpRight' => esc_html__('RotateInUpRight', 'dipi-divi-pixel'),
            ],
            'sub_toggle' => 'title',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'use_overlay' => 'on',
            ],
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'icon',
        ];
        $fields["title_animation"] = [
            'label' => esc_html__('Title Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'fadeInUp',
            'options' => [
                'fadeIn' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeft' => esc_html__('Fade In Left', 'dipi-divi-pixel'),
                'fadeInRight' => esc_html__('Fade In Right', 'dipi-divi-pixel'),
                'fadeInUp' => esc_html__('Fade In Up', 'dipi-divi-pixel'),
                'fadeInDown' => esc_html__('Fade In Down', 'dipi-divi-pixel'),
                'zoomIn' => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceIn' => esc_html__('Bounce In', 'dipi-divi-pixel'),
                'bounceInLeft' => esc_html__('Bounce In Left', 'dipi-divi-pixel'),
                'bounceInRight' => esc_html__('Bounce In Right', 'dipi-divi-pixel'),
                'bounceInUp' => esc_html__('Boune In Up', 'dipi-divi-pixel'),
                'bounceInDown' => esc_html__('BouneIn Down', 'dipi-divi-pixel'),
                'flipInX' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInY' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBox' => esc_html__('JackInThe Box', 'dipi-divi-pixel'),
                'rotateIn' => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeft' => esc_html__('RotateInDownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeft' => esc_html__('RotateInUpLeft', 'dipi-divi-pixel'),
                'rotateInDownRight' => esc_html__('RotateInDownRight', 'dipi-divi-pixel'),
                'rotateInUpRight' => esc_html__('RotateInUpRight', 'dipi-divi-pixel'),
            ],
            'sub_toggle' => 'title',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'use_overlay' => 'on',
            ],
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'title',
        ];
        $fields['icon_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '100ms',
            'default_on_front' => '0ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'icon',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];

        $fields['icon_speed'] = [
            'label' => esc_html__('Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '600ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'icon',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields['title_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '100ms',
            'default_on_front' => '100ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'title',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];

        $fields['title_speed'] = [
            'label' => esc_html__('Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '600ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'title',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields["caption_animation"] = [
            'label' => esc_html__('Caption Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'fadeInUp',
            'options' => [
                'fadeIn' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeft' => esc_html__('Fade In Left', 'dipi-divi-pixel'),
                'fadeInRight' => esc_html__('Fade In Right', 'dipi-divi-pixel'),
                'fadeInUp' => esc_html__('Fade In Up', 'dipi-divi-pixel'),
                'fadeInDown' => esc_html__('Fade In Down', 'dipi-divi-pixel'),
                'zoomIn' => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceIn' => esc_html__('Bounce In', 'dipi-divi-pixel'),
                'bounceInLeft' => esc_html__('Bounce In Left', 'dipi-divi-pixel'),
                'bounceInRight' => esc_html__('Bounce In Right', 'dipi-divi-pixel'),
                'bounceInUp' => esc_html__('Boune In Up', 'dipi-divi-pixel'),
                'bounceInDown' => esc_html__('BouneIn Down', 'dipi-divi-pixel'),
                'flipInX' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInY' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBox' => esc_html__('JackInThe Box', 'dipi-divi-pixel'),
                'rotateIn' => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeft' => esc_html__('RotateInDownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeft' => esc_html__('RotateInUpLeft', 'dipi-divi-pixel'),
                'rotateInDownRight' => esc_html__('RotateInDownRight', 'dipi-divi-pixel'),
                'rotateInUpRight' => esc_html__('RotateInUpRight', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'caption',
            'computed_affects' => array(
                '__gallery',
            ),
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields['caption_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '400ms',
            'default_on_front' => '400ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'caption',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];

        $fields['caption_speed'] = [
            'label' => esc_html__('Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '600ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'overlay_animation',
            'sub_toggle' => 'caption',
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields["columns"] = [
            'label' => esc_html__('Columns', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'grid',
            'tab_slug' => 'advanced',
            'default' => '4',
            'range_settings' => array(
                'min' => '1',
                'max' => '10',
                'step' => '1',
            ),
            'mobile_options' => true,
            'responsive' => true,
            'unitless' => true,
            'computed_affects' => array(
                '__gallery',
            ),
        ];

        $fields["gutter"] = [
            'label' => esc_html__('Gutter', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'toggle_slug' => 'grid',
            'tab_slug' => 'advanced',
            'default' => '10',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
            'responsive' => true,
            'unitless' => true,
            'computed_affects' => array(
                '__gallery',
            ),
        ];

        $fields["show_overflow"] = [
            'label' => esc_html__('Show Overflow', 'dipi-divi-pixel'),
            'description' => esc_html__('Hide or show the overflow of the module. Useful if you want to use box shadows on the images but be aware that too much gutter can cause weird effects on mobiles due to the extra margin of the module. In this case, you should set the overflow of the row or section to hidden.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'layout',
            'toggle_slug' => 'grid',
            'tab_slug' => 'advanced',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];

        $fields["overlay_bg_color"] = [
            'label' => esc_html__('Overlay Color', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "overlay_bg",
            'context' => "overlay_bg",
            'custom_color' => true,
            'default' => 'rgba(21,2,42,0.3)',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'hover' => 'tabs',
            'mobile_options' => true,
            'responsive' => true,
            'background_fields' => array_merge(

                ET_Builder_Element::generate_background_options(
                    'overlay_bg',
                    'gradient',
                    "advanced",
                    "overlay",
                    "overlay_bg_gradient"
                ),

                ET_Builder_Element::generate_background_options(
                    "overlay_bg",
                    "color",
                    "advanced",
                    "overlay",
                    "overlay_bg_color"
                )
            ),
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];

        $fields['overlay_icon_color'] = [
            'label' => esc_html__(' Overlay Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'tab_slug' => 'advanced',
            'default' => '',
            'show_if' => [
                'use_overlay' => 'on',
            ],
            'toggle_slug' => 'overlay',
            'description' => esc_html__('Color of the overlay icon. The overlay icon is centered horizontally and vertically over the image.', 'dipi-divi-pixel'),
        ];
        $fields['overlay_icon_use_circle'] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'description' => esc_html__('Here you can choose whether icon set above should display within a circle.', 'dipi-divi-pixel'),
            'default' => 'off',
            'show_if' => [
                'use_overlay' => 'on',
            ],
            'computed_affects' => array(
                '__gallery',
            ),
        ];
        $fields['overlay_icon_circle_color'] = [
            'default' => $et_accent_color,
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom color for the icon circle.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_overlay' => 'on',
                'overlay_icon_use_circle' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'hover' => 'tabs',
            'sticky' => true,
            'default' => '#F2F3F3',
        ];
        $fields['overlay_icon_use_circle_border'] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'layout',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose whether if the icon circle border should display.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_overlay' => 'on',
                'overlay_icon_use_circle' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'default_on_front' => 'off',
            'computed_affects' => array(
                '__gallery',
            ),
        ];
        $fields['overlay_icon_circle_border_color'] = [
            'default' => $et_accent_color,
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom color for the icon circle border.', 'dipi-divi-pixel'),
            'show_if' => array(
                'use_overlay' => 'on',
                'overlay_icon_use_circle_border' => 'on',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'hover' => 'tabs',
            'sticky' => true,
            'default' => '#000',
        ];
        $fields['overlay_icon_use_icon_font_size'] = [
            'label' => esc_html__('Use Icon Font Size', 'dipi-divi-pixel'),
            'description' => esc_html__('If you would like to control the size of the icon, you must first enable this option.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'font_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_overlay' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'default_on_front' => 'off',
        ];
        $fields['overlay_icon_font_size'] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'description' => esc_html__('Control the size of the icon by increasing or decreasing the font size.', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'font_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'default' => '96px',
            'default_unit' => 'px',
            'default_on_front' => '',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => array(
                'min' => '1',
                'max' => '120',
                'step' => '1',
            ),
            'show_if' => [
                'use_overlay' => 'on',
                'overlay_icon_use_icon_font_size' => 'on',
            ],
            'mobile_options' => true,
            'sticky' => true,
            'responsive' => true,
            'hover' => 'tabs',
        ];
        $fields["__gallery"] = [
            'type' => 'computed',
            'computed_callback' => array('DIPI_MasonryGallery', 'render_images'),
            'computed_depends_on' => array(
                'images',
                'image_count',
                'gallery_ids',
                'pagination_type',
                'images_per_page',
                'prev_btn_text',
                'next_btn_text',
                'load_more_text',
                'show_lightbox',
                'title_in_lightbox',
                'caption_in_lightbox',
                'icon_in_overlay',
                'title_in_overlay',
                'caption_in_overlay',
                'overlay_icon_use_circle',
                'overlay_icon_use_circle_border',
                'gallery_orderby',
                'hover_icon',
                'use_overlay',
                'icon_animation',
                'title_animation',
                'caption_animation',
                'image_animation',
                'grid_animation',
                'grid_animation_delay',
                'grid_animation_speed',
                'horizontal_order_direction',
            ),
            'computed_minimum' => array(
                'gallery_ids',
            ),
        ];

        $fields['use_thumbnails'] = [
            'label' => esc_html__('Use Responsive Thumbnails', 'dipi-divi-pixel'),
            'description' => esc_html__('Whether or not to use custom sized thumbnails on different devices. If this option is disabled, the full size image will be used as thumbnail.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];

        $fields['image_size_desktop'] = [
            'label' => esc_html__('Image Size (Desktop)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];

        $fields['image_size_tablet'] = [
            'label' => esc_html__('Image Size (Tablet)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];

        $fields['image_size_phone'] = [
            'label' => esc_html__('Image Size (Phone)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];
        $fields['grid_animation'] = array(
            'label' => esc_html__('Grid Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'fadeIn'  => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'  => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort'    => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort'  => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort'       => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort'  => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
            ),
            'default' => 'none',
            'toggle_slug' => 'grid',
            'computed_affects' => array(
                '__gallery',
            ),
        );
        $fields['grid_animation_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '0ms',
            'default_on_front' => '0ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'grid',
            'computed_affects' => array(
                '__gallery',
            ),
             
        ];
        $fields['grid_animation_speed'] = [
            'label' => esc_html__('Grid Animation Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '1000ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'grid',
            'computed_affects' => array(
                '__gallery',
            ),
        ];
        $fields['fix_lazy'] = [
            'label' => esc_html__('Fix Lazy Loading Images', 'ds-suit-material'),
            'description' => esc_html__('Whether or not to use apply a fix for lazy loading images. Only activate this setting, if you encounter issues with the gallery in combination with lazy loading images plugins like Jetpack.', 'ds-suit'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'grid',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'ds-suit-material'),
                'on' => esc_html__('On', 'ds-suit-material'),
            ),
        ];
        $fields['overlay_padding'] = [
            'label' => __('Overlay Padding', 'et_builder'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Overlay.', 'et_builder'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
            'default' => '30px|30px|30px|30px',
            'mobile_options' => true,
        ];
        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image",
                "overlay_bg_gradient"
            )
        );
        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image",
                "overlay_bg_color"
            )
        );

        $fields['image_animation'] = array(
            'label' => esc_html__('Image Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'zoom-in' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                'zoom-out' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                'move-up' => esc_html__('Move Up', 'dipi-divi-pixel'),
                'move-down' => esc_html__('Move Down', 'dipi-divi-pixel'),
                'move-left' => esc_html__('Move Left', 'dipi-divi-pixel'),
                'move-right' => esc_html__('Move Right', 'dipi-divi-pixel'),
                'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
            ),
            'default' => 'none',
            'computed_affects' => array(
                '__gallery',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'grid_items',
        );

        $fields['image_animation_speed'] = [
            'label' => esc_html__('Image Animation Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '500ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'grid_items',
        ];

        $fields['pagination_btn_margin'] = [
            'label' => __('Margin', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['pagination_btn_padding'] = [
            'label' => __('Padding', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
            'default' => '5px|12px|5px|12px',
            'mobile_options' => true,
        ];
        $fields['pagination_active_btn_margin'] = [
            'label' => __('Margin', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['pagination_active_btn_padding'] = [
            'label' => __('Padding', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
            'default' => '5px|12px|5px|12px',
            'mobile_options' => true,
        ];
        $fields['load_more_margin'] = [
            'label' => __('Margin', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'load_more',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['load_more_padding'] = [
            'label' => __('Padding', 'et_builder'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'load_more',
            'default' => '5px|12px|5px|12px',
            'mobile_options' => true,
        ];
        $fields['pagination_btn_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'default'        => 'transparent',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
        ];
        $fields['pagination_active_btn_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'default'        => '#ff4200',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
        ];
        $fields['load_more_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'default'        => 'transparent',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug' => 'load_more',
            'sub_toggle' => 'active',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $pagination_btn_normal_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn";
        $pagination_btn_normal_hover_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn:hover";
        $pagination_btn_active_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn.active";
        $pagination_btn_active_hover_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn.active:hover";
        $load_more_selector = "%%order_class%% .dipi-loadmore-btn";
        $load_more_hover_selector = "%%order_class%% .dipi-loadmore-btn:hover";

        $advanced_fields = [];

        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"]["header"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-mansonry-gallery-title",
                'hover' => "%%order_class%%:hover .dipi-mansonry-gallery-title",
            ],
            'header_level' => [
                'default' => 'h4',
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'text_group',
            'sub_toggle' => 'title',
        ];
        $advanced_fields["fonts"]["caption"] = [
            'label' => esc_html__('Caption', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-mansonry-gallery-caption",
                'hover' => "%%order_class%%:hover .dipi-mansonry-gallery-caption",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'text_group',
            'sub_toggle' => 'caption',
        ];
        $advanced_fields["fonts"]["pagination_btn_normal"] = [
            'css' => [
                'main' => $pagination_btn_normal_selector,
                'hover' => $pagination_btn_normal_hover_selector,
            ],
            /*'hide_text_align' => false,*/
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
            'show_if' => [
                'pagination_type' => 'numbered_pagination'
            ]
        ];
        $advanced_fields["fonts"]["pagination_btn_active"] = [
            'css' => [
                'main' => $pagination_btn_active_selector,
                'hover' => $pagination_btn_active_hover_selector,
            ],
            'hide_text_align' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
            'show_if' => [
                'pagination_type' => 'numbered_pagination'
            ]
        ];
        $advanced_fields["fonts"]["load_more"] = [
            'css' => [
                'main' => $load_more_selector,
                'hover' => $load_more_hover_selector,
            ],
            'hide_text_align' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'load_more',
            'show_if' => [
                'pagination_type' => ['load_more','infinite_scroll']
            ]
        ];
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%",
                    'border_styles' => "%%order_class%%",
                ],
            ],
        ];
        $advanced_fields["borders"]["pagination_btn_normal"] = [
            'css' => [
                'main' => [
                    'border_radii' => $pagination_btn_normal_selector,
                    'border_styles' => $pagination_btn_normal_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
        ];
        $advanced_fields["borders"]["pagination_btn_active"] = [
            'css' => [
                'main' => [
                    'border_radii' => $pagination_btn_active_selector,
                    'border_styles' => $pagination_btn_active_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
        ];
        $advanced_fields["borders"]["load_more"] = [
            'css' => [
                'main' => [
                    'border_radii' => $load_more_selector,
                    'border_styles' => $load_more_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'load_more',
        ];
        $advanced_fields["borders"]["grid_item"] = [
            'label_prefix' => esc_html__('Grid Item', 'dipi-divi-pixel'),
            'toggle_slug' => 'grid_items',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .grid .grid-item.et_pb_gallery_image",
                    'border_styles' => "%%order_class%% .grid .grid-item.et_pb_gallery_image",
                ],
            ],
        ];

        $advanced_fields["box_shadow"]["images"] = [
            'label' => esc_html__('Grid Item Box Shadow', 'dipi-divi-pixel'),
            'toggle_slug' => 'grid_items',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => "%%order_class%% .grid .grid-item.et_pb_gallery_image",
            ],
        ];
        $advanced_fields["box_shadow"]["pagination_normal"] = [
            'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'normal',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => $pagination_btn_normal_selector,
                'hover' => $pagination_btn_normal_hover_selector,
            ],
        ];
        $advanced_fields["box_shadow"]["pagination_btn_active"] = [
            'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
            'toggle_slug' => 'pagination_btn',
            'sub_toggle' => 'active',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => $pagination_btn_active_selector,
                'hover' => $pagination_btn_active_hover_selector,
            ],
        ];
        $advanced_fields["box_shadow"]["load_more"] = [
            'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
            'toggle_slug' => 'load_more',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => $load_more_selector,
                'hover' => $load_more_hover_selector,
            ],
        ];
        $advanced_fields['margin_padding'] = [
            'css' => [
                'important' => 'all',
            ],
        ];

        return $advanced_fields;
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

    public static function render_images($args = array(), $conditional_tags = array(), $current_page = array())
    {
        $defaults = [
            'images' => '',
            'gallery_ids' => '',
            'gallery_orderby' => '',
            'title_in_lightbox' => 'off',
            'caption_in_lightbox' => 'off',
            'icon_in_overlay' => 'on',
            'title_in_overlay' => 'off',
            'caption_in_overlay' => 'off',
            'use_media_link' => 'off',
            'use_overlay' => 'off',
            'hover_icon' => '',
            'image_size_desktop' => 'full',
            'image_size_tablet' => 'full',
            'image_size_phone' => 'full',
            'image_animation' => 'none',
            'image_count' => '-1',
            'image_count_tablet' => '',
            'image_count_phone' => '',
            'image_count_last_edited' => '',
            'fix_lazy' => ''
        ];

        $args = wp_parse_args($args, $defaults);

        $icon_animation = $args['icon_animation'];
        $title_animation = $args['title_animation'];
        $caption_animation = $args['caption_animation'];
        $grid_animation = $args['grid_animation'];
        $use_media_link = $args['use_media_link'];
        $use_overlay = $args['use_overlay'];
        $use_overlay_values = et_pb_responsive_options()->get_property_values($args, 'use_overlay');
        $use_overlay_tablet = isset($use_overlay_values['tablet']) ? $use_overlay_values['tablet'] : '';
        $use_overlay_phone = isset($use_overlay_values['phone']) ? $use_overlay_values['phone'] : '';

        $show_overlay_classes = ($use_overlay === 'on') ? 'show_overlay' : 'hide_overlay';
        if (!empty($use_overlay_tablet)) {
            $show_overlay_classes .= ($use_overlay_tablet === 'on') ? ' show_overlay_tablet' : ' hide_overlay_tablet';
        }
        if (!empty($use_overlay_phone)) {
            $show_overlay_classes .= ($use_overlay_phone === 'on') ? ' show_overlay_phone' : ' hide_overlay_phone';
        }

        $show_lightbox = $args['show_lightbox'];
        $show_lightbox_values = et_pb_responsive_options()->get_property_values($args, 'show_lightbox');

        $show_lightbox_tablet = isset($show_lightbox_values['tablet']) && !empty($show_lightbox_values['tablet']) ? $show_lightbox_values['tablet'] : $show_lightbox;
        $show_lightbox_phone = isset($show_lightbox_values['phone']) && !empty($show_lightbox_values['phone']) ? $show_lightbox_values['phone'] : $show_lightbox_tablet;

        $show_lightboxclasses = ($show_lightbox === 'on') ? 'show_lightbox' : 'hide_lightbox';
        if (!empty($show_lightbox_tablet)) {
            $show_lightboxclasses .= ($show_lightbox_tablet === 'on') ? ' show_lightbox_tablet' : ' hide_lightbox_tablet';
        }
        if (!empty($show_lightbox_phone)) {
            $show_lightboxclasses .= ($show_lightbox_phone === 'on') ? ' show_lightbox_phone' : ' hide_lightbox_phone';
        }
        $data = ( $args['horizontal_order_direction'] === 'on') ? 'data-horizontal="on"' : '';
        $use_media_link_class = $args['use_media_link'] === 'on' ? 'use_media_link' : '';
        $image_count = $args['image_count'];
        $image_count_tablet = $args['image_count_tablet'];
        $image_count_phone = $args['image_count_phone'];
        $image_count_last_edited = $args['image_count_last_edited'];
        $image_count_responsive_active = et_pb_get_responsive_status($image_count_last_edited);

        $pagination_type = $args['pagination_type'];
        $images_per_page = $args['images_per_page'];
        $load_more_text = $args['load_more_text'];
        $prev_btn_text = $args['prev_btn_text'];
        $next_btn_text = $args['next_btn_text'];
        
        $items = [
            '<div class="grid-sizer"></div>',
            '<div class="gutter-sizer"></div>',
        ];

        $attachment_ids = explode(",", $args["gallery_ids"]);

        $post_count = count($attachment_ids);
        $pages = (int)(($post_count  - 1) / $images_per_page) + 1;
        $pagination_html = '';
        $pagination_pages = '';

        if (($pagination_type === 'numbered_pagination') &&  ((int)$pages > 1)) {
            $prev_pagination_html = "<span class='dipi-pagination-btn' data-page='prev'>$prev_btn_text</span>";
            $next_pagination_html = "<span class='dipi-pagination-btn' data-page='next'>$next_btn_text</span>";
            $pagination_html .= $prev_pagination_html;
            for ($pageIndex = 1; $pageIndex <= $pages ; $pageIndex++) {
                $one_pagination_html = sprintf(
                    '<span class="dipi-pagination-btn dipi-pagination-btn-%1$s %2$s" data-page="%1$s">
                        %1$s
                    </span>',
                    $pageIndex,
                    $pageIndex == 1 ? 'active' : ''
                );
                $pagination_html.= $one_pagination_html;
            }
            $pagination_html .= $next_pagination_html;
        }
        if ($pagination_type === 'load_more' && ((int)$pages > 1)) {
            $pagination_html =sprintf(
                '<span class="dipi-loadmore-btn" data-page="1">
                    %1$s
                </span>
                ',
                $load_more_text
            );
        }
        if ($pagination_type === 'infinite_scroll' && ((int)$pages > 1)) {
            $pagination_html =sprintf(
                '<span class="dipi-loadmore-btn watch_end_of_grid" data-page="1">
                    %1$s
                </span>
                ',
                $load_more_text
            );
        }

        if ($pagination_html) {
            $pagination_html = sprintf( '
                <div class="dipi-pagination" data-page-count="%2$s">
                    %1$s
                </div>',
                $pagination_html,
                $pages
            );
        }
        $overlay_output = '';

        $overlay_icon_classes[] = 'dipi-mansonry-gallery-icon';
        $overlay_icon_use_circle = $args['overlay_icon_use_circle'];
        $overlay_icon_use_circle_border = $args['overlay_icon_use_circle_border'];
        if ('on' === $overlay_icon_use_circle) {
            $overlay_icon_classes[] = 'dipi-mansonry-gallery-icon-circle';
        }

        if ('on' === $overlay_icon_use_circle && 'on' === $overlay_icon_use_circle_border) {
            $overlay_icon_classes[] = 'dipi-mansonry-gallery-icon-circle-border';
        }

        $data_icon = '' !== $args['hover_icon'] ? sprintf(
            ' data-icon="%1$s"',
            esc_attr(et_pb_process_font_icon($args['hover_icon'])),
            esc_attr($args['hover_icon'])
        ) : 'data-no-icon';

        if ($use_media_link === 'on') {
            $media_link_url_meta_field = self::$vendor_prefix === 'ds' ? 'ds_masonry_gallery_media_link_url' : 'media_link_url';
            $media_link_target_meta_field = self::$vendor_prefix === 'ds' ? 'ds_masonry_gallery_media_link_target' : 'media_link_target';
        }

        $att_ids = [];
        $gallery_orderby = explode('_', $args['gallery_orderby']);
        if($gallery_orderby[0] === 'none') {
            $att_ids = $attachment_ids;
        }
        if($gallery_orderby[0] !== 'none') {
            $query_args = array( 
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post__in' =>  $attachment_ids,
                'posts_per_page' => '-1'
            );
            
            $query_args['orderby'] = $gallery_orderby[0];
            
            if(count($gallery_orderby) > 1) {
                $query_args['order'] = strtoupper($gallery_orderby[1]);
            }  
            
            $attachments_posts = get_posts($query_args);
            if ($attachments_posts) {
                foreach ( $attachments_posts as $attachment ) { 
                    $att_ids[] =  $attachment->ID;
                }
            }  
        }

        foreach ($att_ids as $img_index=>$attachment_id) {
            $attachment = wp_get_attachment_image_src($attachment_id, "full");
            if (!$attachment) {
                continue;
            }

            $image = $attachment[0];

            $image_desktop_url = DIPI_MasonryGallery::get_attachment_image($attachment_id, $args['image_size_desktop'], $image);
            $image_tablet_url = DIPI_MasonryGallery::get_attachment_image($attachment_id, $args['image_size_tablet'], $image);
            $image_phone_url = DIPI_MasonryGallery::get_attachment_image($attachment_id, $args['image_size_phone'], $image);

            $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title($attachment_id);

            $a_open_tag = '';
            $a_close_tag = '';
            if ($use_media_link === 'on') {
                $media_link_url = get_post_meta($attachment_id, $media_link_url_meta_field, true);
                $media_link_target = get_post_meta($attachment_id, $media_link_target_meta_field, true);

                if (!isset($media_link_target)) {
                    $media_link_target = '0';
                }

                $a_open_tag = sprintf('<a href="%1$s" target="%2$s">',
                    $media_link_url,
                    $media_link_target === '0' ? '_self' : '_blank'
                );
                $a_close_tag = '</a>';
            }

            $icon_html = '';
            if ('on' === $args["icon_in_overlay"]) {
                $icon_html = sprintf(
                    '<div class="et-pb-icon %1$s %3$s animated %4$s"%2$s></div>',
                    ('' !== $args['hover_icon'] ? ' et_pb_inline_icon' : ''),
                    'on' === $args["icon_in_overlay"] ? $data_icon : '',
                    implode(' ', $overlay_icon_classes),
                    $icon_animation
                );
            }

            $title_html = '';
            if ('on' === $args["title_in_overlay"] && '' !== $image_title) {
                $title_html = sprintf(
                    '<h4 class="dipi-mansonry-gallery-title animated %2$s">
                        %1$s
                    </h4>',
                    $image_title,
                    $title_animation
                );
            }

            $caption = wp_get_attachment_caption($attachment_id);
            $caption_html = '';
            if ('on' === $args["caption_in_overlay"] && '' !== $caption) {
                $caption_html = sprintf(
                    '<div class="dipi-mansonry-gallery-caption animated %2$s">
                        %1$s
                    </div>',
                    $caption,
                    $caption_animation
                );
            }

            $overlay_output = sprintf(
                '<span class="dipi_masonry_gallery_overlay background"></span>
                <span class="dipi_masonry_gallery_overlay background-hover"></span>
                <span class="dipi_masonry_gallery_overlay content" style="transition-duration: 0ms;">
                    %1$s
                    %2$s
                    %3$s
                </span>',
                $icon_html,
                $title_html,
                $caption_html
            );
            $item_class = '';
            if ($pagination_type === 'none') {
                if ((int)$image_count >=0 && $img_index >= (int)$image_count) {
                    $item_class = 'hidden';
                }
                if ($image_count_responsive_active) {
                    if ((int)$image_count_tablet >= 0 && $img_index >=(int)$image_count_tablet) {
                        $item_class .= ' tablet_hidden';
                    } else {
                        $item_class .=" tablet_show";
                    }
                    if ((int)$image_count_phone >= 0 && $img_index >=(int)$image_count_phone) {
                        $item_class .= ' phone_hidden';
                    } else {
                        $item_class .=" phone_show";
                    }
                }
            } else {
                $page = (int)($img_index  / $images_per_page) + 1;
                $item_class = 'page-'.$page;
                if ( $page  !== 1) {
                    $item_class.=' hidden';
                }
                $data_page = 'data-page='.$page;
                $pagination_pages='data-pages='.$pages;
            }
            $items[] = sprintf(
                '<div class="grid-item et_pb_gallery_image %13$s">
                       %10$s
                        <div class="img-container dipi-mg-animation dipi-mg-%12$s" href="%1$s"%4$s%5$s>
                            <img src="%1$s"
                                alt="%2$s"
                                srcset="%9$s 768w, %8$s 980w, %7$s 1024w"
                                sizes="(max-width: 768px) 768px, (max-width: 980px) 980px, 1024px"
                            />
                            %6$s
                        </div>
                    %11$s
                </div>',
                $image,
                $image_alt,
                $image_title,
                'on' === $args["title_in_lightbox"] ? " data-title='$image_title'" : '',
                'on' === $args["caption_in_lightbox"] ? " data-caption='" . htmlspecialchars(wp_get_attachment_caption($attachment_id)) . "'" : '', #5
                et_core_esc_previously($overlay_output),
                $image_desktop_url,
                $image_tablet_url,
                $image_phone_url,
                $a_open_tag, #10
                $a_close_tag,
                $args['image_animation'],
                $item_class
            );
        }
        return sprintf('
            <div
                class="dipi_masonry_gallery_container animated %11$s"
                %9$s
                data-count="%10$s"
                data-anim="%11$s"
            >
                <div class="grid %3$s %4$s %5$s" data-lazy="%2$s" %6$s>
                    %1$s
                </div>
                %7$s
            </div>
            ',
            implode("", $items),
            $args["fix_lazy"] === 'on' ? esc_attr("true") : esc_attr("false"),
            $show_lightboxclasses,
            $show_overlay_classes,
            $use_media_link_class, #5
            $data,
            $pagination_html,
            $pages,
            $pagination_pages,
            $post_count, #10
            $grid_animation
        );
        
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_masonry_gallery_public');
        wp_enqueue_style('dipi_animate');
        wp_enqueue_style('magnific-popup');
        $this->dipi_apply_css($render_slug);
        $config = [
            'infinite_scroll_viewport' => $this->props['infinite_scroll_viewport'],
        ];

        $render_images_html =  DIPI_MasonryGallery::render_images($this->props);

        return sprintf(
            '<div class="dipi_masonry_gallery_wrapper" data-config="%2$s">
                %1$s
            </div>
             ',
             $render_images_html,
             esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8'))
        );
    }

    public function dipi_apply_css($render_slug)
    {
        $gallery_item_grid_selector =  "%%order_class%% .dipi_masonry_gallery_container, %%order_class%% .dipi_masonry_gallery_container .grid";
        if('on' === $this->props['icon_in_overlay']){
            $this->dipi_generate_font_icon_styles($render_slug, 'hover_icon', '%%order_class%% .dipi-mansonry-gallery-icon:before');
        }

        $columns = $this->props["columns"];
        $columns_responsive_active = isset($this->props["columns_last_edited"]) && et_pb_get_responsive_status($this->props["columns_last_edited"]);
        $columns_tablet = $columns_responsive_active && $this->props["columns_tablet"] ? $this->props["columns_tablet"] : $columns;
        $columns_phone = $columns_responsive_active && $this->props["columns_phone"] ? $this->props["columns_phone"] : $columns_tablet;

        $gutter = $this->props["gutter"];
        $gutter_responsive_active = isset($this->props["gutter_last_edited"]) && et_pb_get_responsive_status($this->props["gutter_last_edited"]);
        $gutter_tablet = $gutter_responsive_active && $this->props["gutter_tablet"] ? $this->props["gutter_tablet"] : $gutter;
        $gutter_phone = $gutter_responsive_active && $this->props["gutter_phone"] ? $this->props["gutter_phone"] : $gutter_tablet;

        $pagination_btn_normal_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn";
        $pagination_btn_normal_hover_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn:hover";
        $pagination_btn_active_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn.active";
        $pagination_btn_active_hover_selector = "%%order_class%% .dipi-pagination .dipi-pagination-btn.active:hover";
        $load_more_selector = "%%order_class%% .dipi-loadmore-btn";
        $load_more_hover_selector = "%%order_class%% .dipi-loadmore-btn:hover";

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .img-container.dipi-mg-animation:hover img',
            'declaration' => "transition-duration: " . intval($this->props["image_animation_speed"]) / 1000 . "s;",
        ]);

        //Pagination
        $this->dipi_apply_custom_style(
            $render_slug,
            'pagination_btn_bg_color',
            'background-color',
            $pagination_btn_normal_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'pagination_active_btn_bg_color',
            'background-color',
            $pagination_btn_active_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'load_more_bg_color',
            'background-color',
            $load_more_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'pagination_btn_margin',
            'margin',
            $pagination_btn_normal_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'pagination_btn_padding',
            'padding',
            $pagination_btn_normal_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'pagination_active_btn_margin',
            'margin',
            $pagination_btn_active_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'pagination_active_btn_padding',
            'padding',
            $pagination_btn_active_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'load_more_margin',
            'margin',
            $load_more_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'load_more_padding',
            'padding',
            $load_more_selector
        );
        //Width of grid items
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
            'declaration' => "width: calc((100% - ({$columns} - 1) * {$gutter}px) / {$columns});",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
            'declaration' => "width: calc((100% - ({$columns_tablet} - 1) * {$gutter_tablet}px) / {$columns_tablet});",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-sizer, %%order_class%% .grid-item',
            'declaration' => "width: calc((100% - ({$columns_phone} - 1) * {$gutter_phone}px) / {$columns_phone});",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        //Gutter of grid items
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-item',
            'declaration' => "margin-bottom: {$gutter}px;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-item',
            'declaration' => "margin-bottom: {$gutter_tablet}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid-item',
            'declaration' => "margin-bottom: {$gutter_phone}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .gutter-sizer',
            'declaration' => "width: {$gutter}px;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .gutter-sizer',
            'declaration' => "width: {$gutter_tablet}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .gutter-sizer',
            'declaration' => "width: {$gutter_phone}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        //Remove gutter from outer grid
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid',
            'declaration' => "margin-bottom: -{$gutter}px;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid',
            'declaration' => "margin-bottom: -{$gutter_tablet}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .grid',
            'declaration' => "margin-bottom: -{$gutter_phone}px;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        if ('on' === $this->props["show_overflow"]) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_masonry_gallery, %%order_class%%.dipi_masonry_gallery .grid-item',
                'declaration' => "overflow: visible !important;",
            ]);
        }

        $this->dipi_apply_custom_style(
            $render_slug,
            'grid_animation_speed',
            'animation-duration',
            $gallery_item_grid_selector
        );

        $this->dipi_apply_custom_style(
            $render_slug,
            'grid_animation_delay',
            'animation-delay',
            $gallery_item_grid_selector 
        );

        if ('on' === $this->props["use_overlay"]) {
            $overlay_bg_image = [];
            $overlay_bg_style = '';
            $use_overlay_bg_gradient = $this->props["overlay_bg_use_color_gradient"];
            $overlay_bg_type = $this->props["overlay_bg_color_gradient_type"];
            $overlay_bg_direction = $this->props["overlay_bg_color_gradient_direction"];
            $overlay_bg_direction_radial = $this->props["overlay_bg_color_gradient_direction_radial"];
            $overlay_bg_start = $this->props["overlay_bg_color_gradient_start"];
            $overlay_bg_end = $this->props["overlay_bg_color_gradient_end"];
            $overlay_bg_start_position = $this->props["overlay_bg_color_gradient_start_position"];
            $overlay_bg_end_position = $this->props["overlay_bg_color_gradient_end_position"];
            $overlay_bg_overlays_image = $this->props["overlay_bg_color_gradient_overlays_image"];
            $overlay_icon_use_circle = $this->props['overlay_icon_use_circle'];
            $overlay_icon_use_circle_border = $this->props['overlay_icon_use_circle_border'];
            $overlay_icon_use_icon_font_size = $this->props['overlay_icon_use_icon_font_size'];
            $overlay_icon_selector = '%%order_class%%.dipi_masonry_gallery .grid .grid-item .dipi_masonry_gallery_overlay .dipi-mansonry-gallery-icon';
            $overlay_icon_circle_selector = '%%order_class%%.dipi_masonry_gallery .grid .grid-item .dipi_masonry_gallery_overlay .dipi-mansonry-gallery-icon.dipi-mansonry-gallery-icon-circle';
            $overlay_selector = '%%order_class%%.dipi_masonry_gallery .grid .grid-item .dipi_masonry_gallery_overlay.content';
            $overlay_selector_background = '%%order_class%%.dipi_masonry_gallery .grid .grid-item .dipi_masonry_gallery_overlay.background';
            $icon_delay = $this->props['icon_delay'];
            $icon_speed = $this->props['icon_speed'];
            $title_delay = $this->props['title_delay'];
            $title_speed = $this->props['title_speed'];
            $caption_delay = $this->props['caption_delay'];
            $caption_speed = $this->props['caption_speed'];
            $hover_icon_selector = "%%order_class%%.dipi_masonry_gallery .grid .grid-item:hover .dipi_masonry_gallery_overlay .dipi-mansonry-gallery-icon";
            $hover_title_selector = "%%order_class%%.dipi_masonry_gallery .grid .grid-item:hover .dipi_masonry_gallery_overlay .dipi-mansonry-gallery-title";
            $hover_caption_selector = "%%order_class%%.dipi_masonry_gallery .grid .grid-item:hover .dipi_masonry_gallery_overlay .dipi-mansonry-gallery-caption";

            $this->set_background_css($render_slug, '%%order_class%% .grid .grid-item .dipi_masonry_gallery_overlay.background', '%%order_class%% .grid .grid-item .dipi_masonry_gallery_overlay.background-hover', 'overlay_bg', 'overlay_bg_color');

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_icon_selector,
                'declaration' => "animation-duration: {$icon_speed} !important;",
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_icon_selector,
                'declaration' => "animation-delay: {$icon_delay} !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_title_selector,
                'declaration' => "animation-duration: {$title_speed} !important;",
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_title_selector,
                'declaration' => "animation-delay: {$title_delay} !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_caption_selector,
                'declaration' => "animation-duration: {$caption_speed} !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $hover_caption_selector,
                'declaration' => "animation-delay: {$caption_delay} !important;",
            ]);

            $this->apply_custom_margin_padding(
                $render_slug,
                'overlay_padding',
                'padding',
                $overlay_selector
            );

            $text_align_style = sprintf(
                'text-align: %1$s !important;',
                $this->props['overlay_align_horizontal'] === 'flex-start' ? 'left' :
                ($this->props['overlay_align_horizontal'] === 'flex-end' ? 'right' : 'center')
            );
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $overlay_selector,
                'declaration' => $text_align_style,
            ));
            $this->generate_styles(
                array(
                    'base_attr_name' => 'overlay_align_horizontal',
                    'selector' => $overlay_selector,
                    'css_property' => 'align-items',
                    'render_slug' => $render_slug,
                    'type' => 'select',
                )
            );

            $this->generate_styles(
                array(
                    'base_attr_name' => 'overlay_align_vertical',
                    'selector' => $overlay_selector,
                    'css_property' => 'justify-content',
                    'render_slug' => $render_slug,
                    'type' => 'select',
                )
            );

            // Overlay Icon
            if ('off' !== $overlay_icon_use_icon_font_size) {
                $this->generate_styles(
                    array(
                        'base_attr_name' => 'overlay_icon_font_size',
                        'selector' => $overlay_icon_selector,
                        'css_property' => 'font-size',
                        'render_slug' => $render_slug,
                        'type' => 'range',
                    )
                );
            }
            $this->generate_styles(
                array(
                    'base_attr_name' => 'overlay_icon_color',
                    'selector' => $overlay_icon_selector,
                    'css_property' => 'color',
                    'render_slug' => $render_slug,
                    'type' => 'color',
                )
            );

            if ('on' === $overlay_icon_use_circle) {
                $this->generate_styles(
                    array(
                        'base_attr_name' => 'overlay_icon_circle_color',
                        'selector' => $overlay_icon_circle_selector,
                        'css_property' => 'background-color',
                        'render_slug' => $render_slug,
                        'type' => 'color',
                    )
                );

                if ('on' === $overlay_icon_use_circle_border) {
                    $this->generate_styles(
                        array(
                            'base_attr_name' => 'overlay_icon_circle_border_color',
                            'selector' => $overlay_icon_circle_selector,
                            'css_property' => 'border-color',
                            'render_slug' => $render_slug,
                            'type' => 'color',
                        )
                    );
                }
            }
        }
    }
}

new DIPI_MasonryGallery;
