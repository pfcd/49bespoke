<?php
class DIPI_Breadcrumbs extends DIPI_Builder_Module
{

    public $slug = 'dipi_breadcrumbs';
    protected static $rendering = false;
    public $separator = '';
    public $schema_item_list = '';
    public $schema_item_list_element = '';
    public $schema_item = '';
    public $schema_item_name = '';
    public $schema_item_position = '';
    public $schema_item_position_content = 1;

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/breadcrumbs',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Breadcrumbs', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_breadcrumbs';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'post_type' => esc_html__('Post Type Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'home_icon' => esc_html__('Home Icon', 'dipi-divi-pixel'),
                    'item_style' => esc_html__('Item Style', 'dipi-divi-pixel'),
                    'active_item_style' => esc_html__('Active Item Style', 'dipi-divi-pixel'),
                    'hover_item_style' => esc_html__('Hover Item Style', 'dipi-divi-pixel'),
                    'separator' => esc_html__('Separator', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        $fields['bc_items'] = array(
            'label' => esc_html__('Breadcrumbs Items', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-item',
        );

        $fields['bc_items_link'] = array(
            'label' => esc_html__('Breadcrumbs Items Link', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-item a',
        );

        $fields['bc_home'] = array(
            'label' => esc_html__('Home Element', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-home',
        );

        $fields['bc_home_link'] = array(
            'label' => esc_html__('Home Element Link', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-home a',
        );

        $fields['bc_current_item'] = array(
            'label' => esc_html__('Current Item', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-current',
        );

        $fields['bc_separator'] = array(
            'label' => esc_html__('Separator', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-breadcrumb-separator',
        );

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];
        $fields["hide_home"] = [
            'label' => esc_html__('Hide Homepage', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default_on_front' => 'off',
            'toggle_slug' => 'settings',
        ];
        $fields["bc_custom_home"] = [
            'label' => esc_html__('Enable Custom Homepage', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default_on_front' => 'off',
            'toggle_slug' => 'settings',
            'show_if' => [
                'hide_home' => 'off'
            ]
        ];
        $post_types = get_post_types(array(
            'public' => true,
        ), 'objects');
        $post_types_options = [];
        foreach ($post_types as $post_type) {
            $post_types_options[$post_type->name] = $post_type->label;
        }

        $fields["bc_home_text"] = [
            'label' => esc_html__('Homepage Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'show_if' => [
                'hide_home' => 'off',
                'bc_custom_home' => 'on'
            ]
        ];

        $fields["bc_home_url"] = [
            'label' => esc_html__('Homepage Url', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'show_if' => [
                'hide_home' => 'off',
                'bc_custom_home' => 'on'
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["bc_home_icon"] = [
            'label' => esc_html__('Display Home Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'hide_home' => 'off',
            ],
        ];

        $fields["bc_home_size"] = [
            'label' => esc_html__('Home Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '16px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'show_if' => [
                'hide_home' => 'off',
                'bc_home_icon' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'home_icon',
        ];

        $fields["bc_home_color"] = [
            'label' => esc_html__('Home Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'hover' => 'tabs',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'home_icon',
            'show_if' => [
                'hide_home' => 'off',
                'bc_home_icon' => 'on'
            ],
        ];

        $fields['bc_separator'] = [
            'label' => esc_html__('Separator', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                'icon' => esc_html__('Icon', 'dipi-divi-pixel'),
                'symbol' => esc_html__('Symbol', 'dipi-divi-pixel'),
            ],
            'default' => 'icon',
            'toggle_slug' => 'settings',
        ];


        // FIXME: Looks like there is a bug in Divi preventing icons from being saved when show_if or depends_on is used
        $fields["bc_separator_icon"] = [
            'label' => esc_html__('Separator Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '$',
            // 'option_category'    => 'button',
            // 'depends_show_if'    => 'icon',
            // 'depends_on'         => [
            //     'bc_separator'
            // ],
            // 'show_if' => [
            //     'bc_separator' => 'icon',
            // ],
            'toggle_slug' => 'separator',
            'tab_slug' => 'advanced',
        ];

        $fields["bc_separator_sysmbol"] = [
            'label' => esc_html__('Separator Symbol', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'symbol',
            'depends_on' => [
                'bc_separator',
            ],
            'toggle_slug' => 'settings',
        ];
        $fields['bc_items_alignment'] = [
            'label' => esc_html__('Breadcrumbs Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                'dipi-bc-left' => esc_html__('Left', 'dipi-divi-pixel'),
                'dipi-bc-center' => esc_html__('Center', 'dipi-divi-pixel'),
                'dipi-bc-right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'default' => 'dipi-bc-left',
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];
        $fields['bc_post_type'] = [
            'label' => esc_html__('Post Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => $post_types_options,
            'default' => 'post',
            'toggle_slug' => 'post_type',
        ];

        $fields["bc_is_post_type_root"] = [
            'label' => esc_html__('Use Custom Post Type Base Url', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default_on_front' => 'off',
            'toggle_slug' => 'post_type',
        ];

        $fields['bc_post_type_root'] = [
            'label' => esc_html__('Post Type Base Url', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'post_type',
            'depends_show_if' => 'on',
            'depends_on' => [
                'bc_is_post_type_root',
            ],

        ];

        $fields['bc_post_type_label'] = [
            'label' => esc_html__('Post Type Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'post_type',
        ];

        foreach ($post_types_options as $post_type => $label) {
            $taxonomies = get_object_taxonomies($post_type, 'objects');
            $taxonomies_options = [];
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->name == 'post_format') {
                    continue;
                }

                $taxonomies_options[$taxonomy->name] = $taxonomy->label;
            }
            if (count($taxonomies_options)) {
                $fields['bc_' . $post_type . '_taxonomy'] = [
                    'label' => esc_html__('Taxonomy to Track', 'dipi-divi-pixel'),
                    'type' => 'select',
                    'option_category' => 'configuration',
                    'options' => $taxonomies_options,
                    'default' => array_keys($taxonomies_options)[0],
                    'show_if' => [
                        'bc_post_type' => $post_type,
                    ],
                    'toggle_slug' => 'post_type',
                ];
            }
        }

        $fields["bc_schema"] = [
            'label' => esc_html__('Schema Markup', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields["bc_separator_size"] = [
            'label' => esc_html__('Separator Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '16px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
        ];

        $fields["bc_separator_color"] = [
            'label' => esc_html__('Separator Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#2c3d49',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
        ];

        $fields["bc_separator_space"] = [
            'label' => esc_html__('Separator Space', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '5px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
        ];

        $fields["bc_item_bg_color"] = [
            'label' => esc_html__('Background Color', 'et_builder'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style',
        ];

        $fields['bc_item_padding'] = [
            'label' => esc_html__('Item Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'option_category' => 'basic_option',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style',
        ];

        $fields["bc_active_item_color"] = [
            'label' => esc_html__('Background Color', 'et_builder'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'active_item_style',
        ];

        $fields['bc_active_item_padding'] = [
            'label' => esc_html__('Active Item Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'option_category' => 'basic_option',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'active_item_style',
        ];

        $fields["bc_hover_item_bg_color"] = [
            'label' => esc_html__('Background Color', 'et_builder'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hover_item_style',
        ];

        $fields["__breadcrumbs"] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_Breadcrumbs', 'render_breadcrumbs'],
            'computed_depends_on' => [
                'hide_home',
                'bc_custom_home',
                'bc_home_text',
                'bc_home_url',
                'bc_home_icon',
                'bc_separator',
                'bc_separator_icon',
                'bc_separator_sysmbol',
            ],
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];

        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields["borders"]["items"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-breadcrumb-item a",
                    'border_styles' => "%%order_class%% .dipi-breadcrumb-item a",
                ],
            ],
            'toggle_slug' => 'item_style',
        ];

        $advanced_fields["borders"]["hover"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-breadcrumb-item:hover a",
                    'border_styles' => "%%order_class%% .dipi-breadcrumb-item:hover a",
                ],
            ],
            'toggle_slug' => 'hover_item_style',
        ];

        $advanced_fields["borders"]["active"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-breadcrumb-current",
                    'border_styles' => "%%order_class%% .dipi-breadcrumb-current",
                ],
            ],
            'toggle_slug' => 'active_item_style',
        ];

        $advanced_fields["box_shadow"]["items"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-breadcrumb-item a",
            ],
            'toggle_slug' => 'item_style',
        ];

        $advanced_fields["box_shadow"]["hover"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-breadcrumb-item:hover a",
            ],
            'toggle_slug' => 'hover_item_style',
        ];

        $advanced_fields["box_shadow"]["active"] = [
            'css' => [
                'main' => "$this->main_css_element .dipi-breadcrumb-current",
            ],
            'toggle_slug' => 'active_item_style',
        ];

        $advanced_fields["fonts"]["items"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-breadcrumb-item, %%order_class%% .dipi-breadcrumb-item a",
            ],
            'font_size' => [
                'default' => '12px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'item_style',
        ];

        $advanced_fields["fonts"]["hover"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-breadcrumb-item:hover a",
            ],
            'font_size' => [
                'default' => '12px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'hover_item_style',
        ];

        $advanced_fields["fonts"]["active"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-breadcrumb-current, %%order_class%% .dipi-breadcrumb-current span",
                'important' => 'all',
            ],
            'font_size' => [
                'default' => '12px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'active_item_style',
        ];

        return $advanced_fields;
    }
    public static function home_icon($args) {
        $bc_home_icon = (isset($args['bc_home_icon'])) ? $args['bc_home_icon'] : '';
        if($bc_home_icon == 'on') {
            echo sprintf('<span class="et-pb-icon dipi-home-icon"></span>') ;
        } else {
            echo '';
        }
    }
    public static function separator($args) {
        $bc_separator = (isset($args['bc_separator'])) ? $args['bc_separator'] : 'icon';
        $bc_separator_icon = (isset($args['bc_separator_icon'])) ? $args['bc_separator_icon'] : '';
        $bc_separator_sysmbol = (isset($args['bc_separator_sysmbol'])) ? $args['bc_separator_sysmbol'] : '';

        if ($bc_separator == 'icon') {
            echo sprintf(
                '<li class="dipi-breadcrumb-separator">
                    <span class="et-pb-icon dipi-separator-icon">%1$s</span>
                </li>',
                esc_attr(et_pb_process_font_icon($bc_separator_icon))
            );
        } else {
            echo sprintf(
                '<li class="dipi-breadcrumb-separator">
                    <span class="dipi-separator-symbol">%1$s</span>
                </li>',
                esc_attr($bc_separator_sysmbol)
            );
        }
        

    }
    public static function render_breadcrumbs($args = array(), $conditional_tags = array(), $current_page = array())
    {
        $hide_home = (isset($args['hide_home'])) ? $args['hide_home'] : 'off';
        $bc_custom_home = (isset($args['bc_custom_home'])) ? $args['bc_custom_home'] : 'off';
        $bc_home_text = (isset($args['bc_home_text'])) ? $args['bc_home_text'] : '';
        $bc_home_url = (isset($args['bc_home_url'])) ? $args['bc_home_url'] : '';
        $bc_separator = (isset($args['bc_separator'])) ? $args['bc_separator'] : 'icon';
        $bc_separator_icon = (isset($args['bc_separator_icon'])) ? $args['bc_separator_icon'] : '';
        $bc_separator_sysmbol = (isset($args['bc_separator_sysmbol'])) ? $args['bc_separator_sysmbol'] : '';
        $is_home = et_fb_conditional_tag('is_home', $conditional_tags);
        $is_front_page = et_fb_conditional_tag('is_front_page', $conditional_tags);
        $is_single = et_fb_conditional_tag('is_single', $conditional_tags);

        $post_id = isset($current_page['id']) ? (int) $current_page['id'] : 0;
        $page_object = get_post($post_id);
        $is_page = isset($page_object->post_type) && 'page' === $page_object->post_type;

        $_post = get_post($post_id);
        $parent_id = get_post($_post->post_parent);
        $bc_home_icon = (isset($args['bc_home_icon'])) ? $args['bc_home_icon'] : '';

        if ($bc_separator == 'icon') {
            $separator = sprintf(
                '<li class="dipi-breadcrumb-separator">
                    <span class="et-pb-icon dipi-separator-icon">%1$s</span>
                </li>',
                esc_attr(et_pb_process_font_icon($bc_separator_icon))
            );
        } else {
            $separator = sprintf(
                '<li class="dipi-breadcrumb-separator">
                    <span class="dipi-separator-symbol">%1$s</span>
                </li>',
                esc_attr($bc_separator_sysmbol)
            );
        }

        if (self::$rendering) {
            return '';
        }

        self::$rendering = true;

        $home_icon = $bc_home_icon == 'on' ? '<span class="et-pb-icon dipi-home-icon"></span>' : '';

        ob_start();

        ?>

        <?php if ($is_home || $is_front_page): ?>
            <?php if ($hide_home !== 'on'): ?>
            <li class="dipi-breadcrumb-item dipi-breadcrumb-home">
                <?php if ($bc_custom_home == 'on'): ?>
                    <a href="<?php echo esc_url($bc_home_url); ?>">
                        <span>
                            <?php self::home_icon($args); ?>
                            <?php echo esc_html($bc_home_text); ?>
                        </span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url(get_home_url()); ?>">
                        <span>
                            <?php self::home_icon($args); ?>
                            <?php echo esc_html(bloginfo('name')); ?>
                        </span>
                    </a>
                <?php endif;?>
            </li>
            <?php endif; ?>
        <?php

        else:

            $position = 0;

            ?>
                <?php if ($hide_home !== 'on'): ?>
		            <li class="dipi-breadcrumb-item dipi-breadcrumb-home">
		                <?php if ($bc_custom_home == 'on'): ?>
		                    <a href="<?php echo esc_url($bc_home_url); ?>">
		                        <span>
                                    <?php self::home_icon($args); ?>
		                            <?php echo esc_html($bc_home_text); ?>
		                        </span>
		                    </a>
		                <?php else: ?>
                            <a href="<?php echo esc_url(get_home_url()); ?>">
                                <span>
                                    <?php self::home_icon($args); ?>
                                    <?php echo esc_html(bloginfo('name')); ?>
                                </span>
                            </a>
                        <?php endif;?>
                    </li>
                    <?php self::separator($args); ?>
                <?php endif; ?>
            <?php if ($is_page && !$parent_id): ?>
            <li class="dipi-breadcrumb-item dipi-breadcrumb-current">
                <span><?php echo esc_html(get_the_title($post_id)); ?></span>
            </li>

            <?php elseif ($is_page && $parent_id):

            $parents = get_post_ancestors($post_id);

            foreach (array_reverse($parents) as $pageID):

                $position += 1;

                // if($position > 2) echo $separator;

                ?>

				                <li class="dipi-breadcrumb-item">
				                    <span>
				                        <a href="<?php esc_url(the_permalink($pageID));?>">
				                            <?php echo esc_html(get_the_title($pageID)); ?>
				                        </a>
				                    </span>
				                </li>

                            <?php self::separator($args); ?>
                            <?php endforeach; ?>

		                <li class="dipi-breadcrumb-item dipi-breadcrumb-current">
		                    <span>
		                        <?php echo esc_html(get_the_title($post_id)); ?>
		                    </span>
		                </li>

		            <?php else: ?>

                <li class="dipi-breadcrumb-item dipi-breadcrumb-current">
                    <span>
                        <?php echo esc_html(get_the_title($post_id)); ?>
                    </span>
                </li>

                <?php

        endif;

        endif;

        $breadcrumb = ob_get_contents();

        ob_end_clean();

        self::$rendering = false;

        $output = sprintf(
            '<ul> %1$s </ul>',
            $breadcrumb
        );

        return $output;

    }

    private function schema_item_position_meta()
    {
        echo sprintf(
            '<meta itemprop="position" content="%1$s"/>', 
            esc_html($this->schema_item_position_content)
        );
        $this->schema_item_position_content++;
    }

    public function calc_separtator($render_slug)
    {

        $bc_separator = $this->props['bc_separator'];
        $bc_separator_icon = $this->props['bc_separator_icon'];
        $bc_separator_sysmbol = $this->props['bc_separator_sysmbol'];
        $bc_separator_size = $this->props['bc_separator_size'];
        $bc_separator_color = $this->props['bc_separator_color'];
        $bc_separator_space = $this->props['bc_separator_space'];

        
        if ($bc_separator == 'icon') {
            $this->separator = sprintf(
                '<li class="dipi-breadcrumb-separator">
                <span class="et-pb-icon dipi-separator-icon">%1$s</span>
                </li>',
                esc_attr(et_pb_process_font_icon($bc_separator_icon))
            );
            $this->dipi_generate_font_icon_styles($render_slug, 'bc_separator_icon', '%%order_class%% .et-pb-icon.dipi-separator-icon');
        } else {
            $this->separator = sprintf(
                '<li class="dipi-breadcrumb-separator">
                    <span class="dipi-separator-symbol">%1$s</span>
                </li>',
                esc_attr($bc_separator_sysmbol)
            );
        }
    }

    public function render($attrs, $content, $render_slug)
    {
        $hide_home = $this->props['hide_home'];
        $bc_custom_home = $this->props['bc_custom_home'];

        $bc_home_text = $this->props['bc_home_text'];
        $bc_home_url = $this->props['bc_home_url'];
        $bc_home_size = $this->props['bc_home_size'];
        $bc_home_color = $this->props['bc_home_color'];
        $bc_home_icon = $this->props['bc_home_icon'];
        $bc_hover_home_color = isset($this->props['bc_home_color__hover']) ? $this->props['bc_home_color__hover'] : $bc_home_color;

        $bc_separator = $this->props['bc_separator'];
        $bc_separator_icon = $this->props['bc_separator_icon'];
        $bc_separator_sysmbol = $this->props['bc_separator_sysmbol'];
        $bc_separator_size = $this->props['bc_separator_size'];
        $bc_separator_color = $this->props['bc_separator_color'];
        $bc_separator_space = $this->props['bc_separator_space'];

        $bc_item_bg_color = $this->props['bc_item_bg_color'];
        $bc_hover_item_bg_color = $this->props['bc_hover_item_bg_color'];
        $bc_active_item_color = $this->props['bc_active_item_color'];
        $bc_schema = $this->props['bc_schema'];
        $bc_post_type = $this->props['bc_post_type'];
        $bc_post_type_label = $this->props['bc_post_type_label'];
        $bc_post_type_root = $this->props['bc_post_type_root'];
        $bc_post_taxonomy = isset($this->props['bc_' . $bc_post_type . '_taxonomy']) ? $this->props['bc_' . $bc_post_type . '_taxonomy'] : null;
        $bc_is_post_type_root = $this->props['bc_is_post_type_root'];
        $bc_items_alignment = $this->props['bc_items_alignment'];
        $this->calc_separtator($render_slug);
        $this->dipi_apply_css($render_slug);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-separator-icon, %%order_class%% .dipi-separator-symbol',
            'declaration' => "font-size: {$bc_separator_size};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-separator-icon, %%order_class%% .dipi-separator-symbol',
            'declaration' => "color: {$bc_separator_color};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-separator-icon, %%order_class%% .dipi-separator-symbol',
            'declaration' => "margin-right: {$bc_separator_space}; margin-left: {$bc_separator_space};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumb-home .dipi-home-icon',
            'declaration' => "font-size: {$bc_home_size};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-home-icon, %%order_class%% .dipi-home-icon:before",
            'declaration' => "color: {$bc_home_color} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumb-home:hover .dipi-home-icon, %%order_class%% .dipi-breadcrumb-home:hover .dipi-home-icon:before',
            'declaration' => "color: {$bc_hover_home_color} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumb-item a',
            'declaration' => "background-color: {$bc_item_bg_color};",
        ]);

        $bc_item_padding = explode('|', $this->props['bc_item_padding']);
        $bc_item_padding_tablet = explode('|', $this->props['bc_item_padding_tablet']);
        $bc_item_padding_phone = explode('|', $this->props['bc_item_padding_phone']);
        $bc_item_padding_last_edited = $this->props['bc_item_padding_last_edited'];
        $bc_item_padding_responsive_status = et_pb_get_responsive_status($bc_item_padding_last_edited);

        if (!empty($bc_item_padding) && count($bc_item_padding) > 1) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-breadcrumb-item:not(.dipi-breadcrumb-current) a",
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $bc_item_padding[0], $bc_item_padding[1], $bc_item_padding[2], $bc_item_padding[3]),
            ));
        }

        if (!empty($bc_item_padding_tablet) && count($bc_item_padding_tablet) > 1 && $bc_item_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-breadcrumb-item:not(.dipi-breadcrumb-current) a",
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $bc_item_padding_tablet[0], $bc_item_padding_tablet[1], $bc_item_padding_tablet[2], $bc_item_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (!empty($bc_item_padding_phone) && count($bc_item_padding_phone) > 1 && $bc_item_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-breadcrumb-item:not(.dipi-breadcrumb-current) a",
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%4$s !important; padding-left:%4$s !important;', $bc_item_padding_phone[0], $bc_item_padding_phone[1], $bc_item_padding_phone[2], $bc_item_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $bc_active_item_padding = explode('|', $this->props['bc_active_item_padding']);
        $bc_active_item_padding_tablet = explode('|', $this->props['bc_active_item_padding_tablet']);
        $bc_active_item_padding_phone = explode('|', $this->props['bc_active_item_padding_phone']);
        $bc_active_item_padding_last_edited = $this->props['bc_active_item_padding_last_edited'];
        $bc_active_item_padding_responsive_status = et_pb_get_responsive_status($bc_active_item_padding_last_edited);

        if (!empty($bc_active_item_padding) && count($bc_active_item_padding) > 1) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-breadcrumb-current',
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $bc_active_item_padding[0], $bc_active_item_padding[1], $bc_active_item_padding[2], $bc_active_item_padding[3]),
            ));
        }

        if (!empty($bc_active_item_padding_tablet) && count($bc_active_item_padding_tablet) > 1 && $bc_active_item_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-breadcrumb-current',
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $bc_active_item_padding_tablet[0], $bc_active_item_padding_tablet[1], $bc_active_item_padding_tablet[2], $bc_active_item_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (!empty($bc_active_item_padding_phone) && count($bc_active_item_padding_phone) > 1 && $bc_active_item_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-breadcrumb-current',
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%4$s !important; padding-left:%4$s !important;', $bc_active_item_padding_phone[0], $bc_active_item_padding_phone[1], $bc_active_item_padding_phone[2], $bc_active_item_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumb-item:hover a',
            'declaration' => "background-color: {$bc_hover_item_bg_color}!important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumb-current',
            'declaration' => "background-color: {$bc_active_item_color}!important;",
        ]);

        global $post;

        $post_id = get_the_ID();
        $parent_id = ($post) ? $post->post_parent : '';

        if (self::$rendering) {
            return '';
        }

        self::$rendering = true;
        if ('on' == $bc_schema):
            $this->schema_item_list = 'itemscope itemtype=https://schema.org/BreadcrumbList';
            $this->schema_item_list_element = 'itemprop=itemListElement itemscope itemtype=https://schema.org/ListItem';
            $this->schema_item = 'itemprop=item';
            $this->schema_item_name = 'itemprop=name';
            $this->schema_item_position = '<meta itemprop="position" content="%1$s"/>';
        endif;

        ob_start();

        ?>

        <?php if (is_home() || is_front_page()): ?>
            <?php if ($hide_home !== 'on') : ?>
                <li <?php echo esc_attr($this->schema_item_list_element); ?> class="dipi-breadcrumb-item dipi-breadcrumb-home">

                    <?php if ($bc_custom_home == 'on'): ?>

                        <a <?php echo esc_attr($this->schema_item); ?> href="<?php echo esc_url($bc_home_url); ?>">
                            <span <?php echo esc_attr($this->schema_item_name); ?>>
                                <?php self::home_icon($this->props); ?>
                                <?php echo esc_html($bc_home_text); ?>
                            </span>
                        </a>

                    <?php else: ?>

                        <a href="<?php echo esc_url(get_home_url()); ?>">
                            <span <?php echo esc_attr($this->schema_item_name); ?>>
                                <?php self::home_icon($this->props); ?>
                                <?php echo esc_html(bloginfo('name')); ?>
                            </span>
                        </a>

                    <?php endif;?>
                    <?php $this->schema_item_position_meta();?>
                </li>
            <?php endif; ?>

        <?php else: ?>
            <?php $position = 0;?>
                <?php if ($hide_home !== 'on') : ?>
                    <li <?php echo esc_attr($this->schema_item_list_element); ?> class="dipi-breadcrumb-item dipi-breadcrumb-home">

                        <?php if ($bc_custom_home == 'on'): ?>

                            <a <?php echo esc_attr($this->schema_item); ?> href="<?php echo esc_url($bc_home_url); ?>">
                                <span <?php echo esc_attr($this->schema_item_name); ?> >
                                    <?php self::home_icon($this->props); ?>
                                    <?php echo esc_html($bc_home_text); ?>
                                </span>
                            </a>

                        <?php else: ?>
                            <a <?php echo esc_attr($this->schema_item); ?> href="<?php echo esc_url(get_home_url()); ?>">
                                <span <?php echo esc_attr($this->schema_item_name); ?>>
                                    <?php self::home_icon($this->props); ?>
                                    <?php echo bloginfo('name'); ?>
                                </span>
                            </a>

                        <?php endif;?>
                        <?php $this->schema_item_position_meta();?>
                    </li>

                    <?php self::separator($this->props); ?>
                <?php endif; ?>
            <?php

        if (is_single() && $post->post_type == $bc_post_type):

            if (isset($bc_post_type_root) && !empty($bc_post_type_root) && $bc_is_post_type_root == 'on') {
                $archive_link = $bc_post_type_root;
            } else {
                $archive_link = get_post_type_archive_link($bc_post_type);
            }

            if ($archive_link) {
                $post_type = get_post_type_object($bc_post_type);
                $label = $post_type->labels->name;
                if (!empty($bc_post_type_label)) {
                    $label = $bc_post_type_label;
                }

                $this->breadcrumbs_node($label, $archive_link, true);
            }

            if (isset($bc_post_taxonomy) && !empty($bc_post_taxonomy)) {
                $post_term = $this->get_post_primary_category(get_the_ID(), $bc_post_taxonomy);
                if (isset($post_term) && !empty($post_term)) {
                    $this->breadcrumbs_term_node($post_term, $bc_post_taxonomy);
                }
            }
        endif;

        if (is_archive()) {
            $queried_object = get_queried_object();
            if ($queried_object instanceof WP_Term) {
                $taxonomy = $queried_object->taxonomy;
                if ($taxonomy == $bc_post_taxonomy) {

                    if (isset($bc_post_type_root) && !empty($bc_post_type_root) && $bc_is_post_type_root == 'on') {
                        $archive_link = $bc_post_type_root;
                    } else {
                        $archive_link = get_post_type_archive_link($bc_post_type);
                    }

                    if ($archive_link) {
                        $post_type = get_post_type_object($bc_post_type);
                        $label = $post_type->label;
                        if (!empty($bc_post_type_label)) {
                            $label = $bc_post_type_label;
                        }

                        $this->breadcrumbs_node($label, $archive_link, true);
                    }
                }
                $this->breadcrumbs_term_node($queried_object, $taxonomy, true);
            } else {
                $title = is_category() ? $queried_object->name : $queried_object->labels->name;
                $this->breadcrumbs_node($title, '', false);
            }
        }

        if (is_page() && !$parent_id): // page without parent
            $this->breadcrumbs_node(get_the_title($post_id), '', false);
        elseif (is_page() && $parent_id): // page with parent
            $parents = get_post_ancestors(get_the_ID());
            foreach (array_reverse($parents) as $pageID):
                $position += 1;
                $this->breadcrumbs_node(get_the_title($pageID), get_page_link($pageID), true);
            endforeach;

            $this->breadcrumbs_node(get_the_title($post_id), '', false);
        elseif (is_single()):
            $this->breadcrumbs_node(get_the_title($post_id), '', false);
        endif;

        if (is_404()) {
            $this->breadcrumbs_node(wp_title('', false), '', false);
        }
        endif;

        $breadcrumb = ob_get_contents();

        ob_end_clean();

        self::$rendering = false;

        $output = sprintf(
            '<div class="dipi-breadcrumbs %3$s">
                <ul %2$s>
                    %1$s
                </ul>
            </div>',
            $breadcrumb,
            $this->schema_item_list,
            $bc_items_alignment
        );
        return $output;
    }

    public function get_post_primary_category($post_id, $term = 'category')
    {
        $return = array();

        if (class_exists('WPSEO_Primary_Term')) {
            // Show Primary category by Yoast if it is enabled & set
            $wpseo_primary_term = new WPSEO_Primary_Term($term, $post_id);
            $primary_term = get_term($wpseo_primary_term->get_primary_term());

            if (!is_wp_error($primary_term)) {
                $return['primary_category'] = $primary_term;
            }
        }

        if (empty($return['primary_category'])) {
            $categories_list = get_the_terms($post_id, $term);
            if (empty($return['primary_category']) && !empty($categories_list)) {
                $return['primary_category'] = $categories_list[0]; //get the first category
            } else {
                return null;
            }
        }

        return $return['primary_category'];
    }

    public function breadcrumbs_node($label, $link = '', $render_sep = false)
    {

        ?>

            <li <?php echo esc_attr($this->schema_item_list_element); ?> class="dipi-breadcrumb-item <?php echo !$render_sep ? 'dipi-breadcrumb-current' : ''; ?>">

                <?php if (!empty($link)): ?>
                <a <?php echo esc_attr($this->schema_item); ?> href="<?php echo esc_url($link); ?>">
                <?php endif;?>

                <span <?php echo esc_attr($this->schema_item_name); ?>>
                    <?php echo wp_kses_post($label); ?>
                </span>

                <?php if (!empty($link)): ?>
                </a>
                <?php endif;?>

                <?php $this->schema_item_position_meta();?>
            </li>
        <?php
        if ($render_sep) {
            self::separator($this->props);
        }
    }

    public function breadcrumbs_term_node($term, $taxonomy, $is_archive = false)
    {
        if (isset($term->parent) && !empty($term->parent)) {
            $parent_term = get_term_by('id', $term->parent, $taxonomy);
            $this->breadcrumbs_term_node($parent_term, $taxonomy);
        }
        if ($is_archive) {
            $this->breadcrumbs_node($term->name, '', false);
        } else {
            $this->breadcrumbs_node($term->name, get_term_link($term->slug, $taxonomy), true);
        }

    }
    private function dipi_bc_items_align($bc_align)
    {
        $flex_align = 'flex-start';
        switch ($bc_align) {
            case 'dipi-bc-left':
                $flex_align = 'flex-start';
                break;
            case 'dipi-bc-center':
                $flex_align = 'center';
                break;
            case 'dipi-bc-right':
                $flex_align = 'flex-end';
                break;
            default:
                $flex_align = 'flex-start';
                break;
        }
        return $flex_align;
    }
    public function dipi_apply_css($render_slug)
    {
        $bc_items_alignment = $this->props["bc_items_alignment"];
        $bc_items_alignment_responsive_active = isset($this->props["bc_items_alignment_last_edited"]) && et_pb_get_responsive_status($this->props["bc_items_alignment_last_edited"]);
        $bc_items_alignment_tablet = $this->props["bc_items_alignment_tablet"];
        $bc_items_alignment_phone = $this->props["bc_items_alignment_phone"];

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-breadcrumbs > ul',
            'declaration' => "justify-content: " . $this->dipi_bc_items_align($bc_items_alignment) . ";",
        ]);
        if ('' !== $bc_items_alignment_tablet && $bc_items_alignment_responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-breadcrumbs > ul',
                'declaration' => "justify-content: " . $this->dipi_bc_items_align($bc_items_alignment_tablet) . ";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        }
        if ('' !== $bc_items_alignment_phone && $bc_items_alignment_responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-breadcrumbs > ul',
                'declaration' => "justify-content: " . $this->dipi_bc_items_align($bc_items_alignment_phone) . ";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

    }
}

new DIPI_Breadcrumbs;