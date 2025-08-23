<?php

class DIPI_GravityFormsStyler extends DIPI_Builder_Module
{

    public $slug = 'dipi_gravity_forms_styler';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/before-after',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Gravity Forms Styler', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_gravity_forms_styler .dipi_gf_styler_wrapper';

        /**
		 * Filter generated module selector
		 *
		 * @param string $selector Generated selector.
		 * @param string $module   Module name.
		 *
		 * @return string Custom selector.
		 */
		add_filter( 'et_pb_set_style_selector', function ( $selector, $module ) {
			// Bail early if current module is not Timeline module.
			if ( 'dipi_gravity_forms_styler' !== $module) {
				return $selector;
			}
	
			return str_replace('body #page-container ', '', str_replace( 'body #page-container .et_pb_section ', '', $selector ));
		}, 10, 2 ); 

    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'form_settings' => esc_html__('Form Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'form_title_text' => esc_html__('Form Title Text', 'dipi-divi-pixel'),
                    'form_desc_text' => esc_html__('Form Description Text', 'dipi-divi-pixel'),
                    'pagination' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'cur_page' => [
                                'name' => 'Current Page'
                            ],
                            'count' => [
                                'name' => 'Count'
                            ]
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Pagination', 'dipi-divi-pixel'),
                    ],
                    'progress_bar' => [
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Progress Bar', 'dipi-divi-pixel'),
                        'sub_toggles' => [
                            'progress_bar' => [
                                'name' => 'Progress Bar'
                            ],
                            'active' => [
                                'name' => 'Active Bar'
                            ],
                            'label' => [
                                'name' => 'Label'
                            ]
                        ]
                    ],
                    'field_container' => esc_html__('Field Container', 'dipi-divi-pixel'),
                    'field_label' => esc_html__('Field Label', 'dipi-divi-pixel'),
                    'field_sub_label' => esc_html__('Field Sub Label', 'dipi-divi-pixel'),
                    'required_field_indicator_text' => esc_html__('Required Field Indicator Text', 'dipi-divi-pixel'),
                    'field_description' => esc_html__('Field Description', 'dipi-divi-pixel'),
                    'input_container' => esc_html__('Input Container', 'dipi-divi-pixel'),
                    'input_field' => [
                        'title' => esc_html__('Input Field', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'general' => [
                                'name' => 'General'
                            ],
                            'focus' => [
                                'name' => 'Focus'
                            ],

                        ]
                    ],
                    'focus_field' => esc_html__('Focus Field', 'dipi-divi-pixel'),
                    'textarea_field' => esc_html__('Textarea/Multi Select Field', 'dipi-divi-pixel'),
                    'select_field' => [
                        'title' => esc_html__('Select Field', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'select' => [
                                'name' => 'Select'
                            ],
                            'option' => [
                                'name' => 'Dropdown'
                            ],
                            'arrow' => [
                                'name' => 'Arrow'
                            ]
                        ]
                    ],
                    'checkbox_radio_field' => [
                        'title' => esc_html__('Checkbox/Radio Field', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'container' => [
                                'name' => 'Container'
                            ],
                            'one_option' => [
                                'name' => 'One Option'
                            ],
                            'button' => [
                                'name' => 'Button'
                            ],
                            'label' => [
                                'name' => 'Label'
                            ],
                        ]
                    ],
                    'section_field' => [
                        'title' => esc_html__('Section Field', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'container' => [
                                'name' => 'Container'
                            ],
                            'title' => [
                                'name' => 'Title'
                            ],
                            'desc' => [
                                'name' => 'Description'
                            ],
                        ]
                    ] ,
                    'html_field' => esc_html__('HTML Field', 'dipi-divi-pixel'),
                    'consent_field' => [
                        'title' => esc_html__('Consent Field', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'container' => [
                                'name' => 'Container'
                            ],
                           
                            'button' => [
                                'name' => 'Button'
                            ],
                            'label' => [
                                'name' => 'Label'
                            ],
                        ]
                    ],
                    'confirm_message' => esc_html__('Confirm Message', 'dipi-divi-pixel'),
                    /*'form_buttons' => [
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Buttons', 'dipi-divi-pixel'),
                        'sub_toggles' => [
                            'all' => [
                                'name' => 'All'
                            ],
                            'submit' => [
                                'name' => 'Submit'
                            ],
                            'prev' => [
                                'name' => 'Prev'
                            ],
                            'next' => [
                                'name' => 'Next'
                            ]
                        ]
                    ],*/
                    'placeholder' => esc_html__('Placeholder', 'dipi-divi-pixel'),
                    'heading' => [
                        'title' => esc_html__('Heading Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
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
                    ]
                ],
            ],
        ];
    }

    public function get_fields()
    {
        $fields = [];
        $fields['gf_form_id'] = [
            'label' => esc_html__('Choose Gravity Form', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => dipi_get_gravity_forms(),
            'default' => 0,
            'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a>', __('Select a Gravity form to style. If you didn\'t create a form yet, '),
                admin_url('?page=gf_edit_forms'), __('Click here')),
            'toggle_slug' => 'form_settings',
            'option_category' => 'basic_option',
            'computed_affects' => [
                '__gravity_form',
            ],
        ];
        $fields['__gravity_form'] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_GravityFormsStyler', 'get_gravity_form'],
            'computed_depends_on' => [
                'gf_form_id',
                'tabindex',
                'field_values',
            ],
            'computed_minimum' => [
                'gf_form_id',
            ],
        ];
        $fields['form_title'] = [
            'label' => esc_html__('Form Title', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                'hide' => esc_html__('Hide', 'dipi-divi-pixel'),
                'gf_title' => esc_html__('Gravity Form Title', 'dipi-divi-pixel')
            ],
            'mobile_options' => true,
            'responsive' => true,
            'default' => 'gf_title',
            'toggle_slug' => 'form_settings',
        ];
        $fields['form_desc'] = [
            'label' => esc_html__('Form Description', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                'hide' => esc_html__('Hide', 'dipi-divi-pixel'),
                'gf_desc' => esc_html__('Gravity Form Description', 'dipi-divi-pixel')
            ],
            'mobile_options' => true,
            'responsive' => true,
            'default' => 'gf_desc',
            'toggle_slug' => 'form_settings',
        ];
        $fields['use_ajax'] = [
            'label'           => esc_html__( 'Use Ajax', 'dipi-divi-pixel' ),
            'description' => __('Use Ajax For multi-page Forms.', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'default'         => 'off',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug' => 'form_settings',
        ];
        $fields["tabindex"] = [
            'label' => esc_html__('Tab Index', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Specify the starting tab index for the fields of this form.', 'dipi-divi-pixel'),
            'toggle_slug' => 'form_settings',
            'computed_affects' => [
                '__gravity_form',
            ],
        ];
        $fields["field_values"] = [
            'label' => esc_html__('Default field values', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Specify the default field values. See also dynamically populating a field in Gravity form\'s documentation', 'dipi-divi-pixel'),
            'toggle_slug' => 'form_settings',
            'computed_affects' => [
                '__gravity_form',
            ],
        ];
        $fields['form_title_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Form Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'form_title_text',
            'mobile_options' => true,
        ];
        $fields['form_title_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Form Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'form_title_text',
            'mobile_options' => true,
        ];
        $fields['form_desc_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'form_desc_text',
            'mobile_options' => true,
        ];
        $fields['form_desc_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Form Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'form_desc_text',
            'mobile_options' => true,
        ];
        $fields['progress_bar_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'progress_bar',
            'sub_toggle'  => 'progress_bar',
        ];
        $fields['progress_bar_active_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'progress_bar',
            'sub_toggle'  => 'active',
        ];
        $fields['progress_bar_label_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'progress_bar',
            'sub_toggle'  => 'label',
        ];
        $fields['field_container_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_container',
            'mobile_options' => true,
        ];
        $fields['field_container_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_container',
            'mobile_options' => true,
        ];
        $fields['field_container_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'field_container',
        ];
        $fields['field_description_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_description',
            'mobile_options' => true,
        ];
        $fields['field_description_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_description',
            'mobile_options' => true,
        ];
        /*$fields['input_container_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_container',
            'mobile_options' => true,
        ];
        $fields['input_container_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Input Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_container',
            'mobile_options' => true,
        ];
        $fields['input_container_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'input_container',
        ];*/
        $fields['input_field_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Input Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_field',
            'sub_toggle'  => 'general',
            'mobile_options' => true,
        ];
        $fields['input_field_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Input Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'general',
            'mobile_options' => true,
        ];
        $fields['input_field_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'input_field',
            'sub_toggle'  => 'general'
        ];
        // Textarea Field
        $fields['textarea_field_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Textarea Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'textarea_field',
            'mobile_options' => true,
        ];
        $fields['textarea_field_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Textarea Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'textarea_field',
            'mobile_options' => true,
        ];
        $fields['textarea_field_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'textarea_field',
        ];

        //Select Field
        $fields['select_field_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Select Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'select',
            'mobile_options' => true,
        ];
        $fields['select_field_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Select Field.', 'dipi-divi-pixel'),
            'default' => '8px|8px|8px|8px',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'select',
            'mobile_options' => true,
        ];
        $fields['select_field_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'select',
        ];

        //Select Arrow
        $fields['use_custom_select_arrow'] = [
            'label'           => esc_html__( 'Use Custom Style for Arrow', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'default'         => 'off',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'arrow',
        ];
        $fields['select_arrow_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Select Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'arrow',
            'mobile_options' => true,
            'show_if' => [
                'use_custom_select_arrow' => "on"
            ]
        ];
        $fields['select_arrow_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Select Field.', 'dipi-divi-pixel'),
            'default' => '0px|8px|0px|8px',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'arrow',
            'mobile_options' => true,
            'show_if' => [
                'use_custom_select_arrow' => "on"
            ]
        ];
        $fields['select_arrow_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'arrow',
            'show_if' => [
                'use_custom_select_arrow' => "on"
            ]
        ];
        $fields["select_arrow_use_icon"] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'tab_slug'       => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'arrow',
            'show_if' => [
                'use_custom_select_arrow' => "on"
            ]
        ];
        $fields["select_arrow_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => ['et-pb-font-icon'],
            'default' => '&#xf078;||fa||900',
            'tab_slug'       => 'advanced',
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'arrow',
            'show_if' => [
                'use_custom_select_arrow' => "on",
                'select_arrow_use_icon' => "on"
            ],
            'mobile_options' => true,
        ];
        $fields['select_arrow_icon_color'] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
            'tab_slug'       => 'advanced',
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'arrow',
            'show_if' => [
                'use_custom_select_arrow' => "on",
                'select_arrow_use_icon' => "on"
            ],
        ];
        $fields["select_arrow_icon_size"] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '1em',
            'default_unit' => '1em',
            'default_on_front' => '1em',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                'min' => '1',
                'max' => '150',
                'step' => '1',
            ],
            'hover' => 'tabs',
            'validate_unit' => true,
            'tab_slug'       => 'advanced',
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'arrow',
            'show_if' => [
                'use_custom_select_arrow' => "on",
                'select_arrow_use_icon' => "on"
            ],
        ];
        $fields['select_option_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'select_field',
            'sub_toggle' => 'option'
        ];
        $fields['checkbox_radio_container_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Checkbox/Radio Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_container_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Checkbox/Radio Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_container_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'checkbox_radio_field',
		    'sub_toggle' => 'container',
        ];
        // Checkbox/Radio One Option
        $fields['checkbox_radio_one_option_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Checkbox/Radio Option.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'one_option',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_one_option_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Checkbox/Radio Option.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'one_option',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_one_option_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'checkbox_radio_field',
		    'sub_toggle' => 'one_option',
        ];
        //Checkbox/Radio button
        $fields['checkbox_radio_button_size'] = [
            'label'             => esc_html__( 'Size', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'checkbox_radio_field',
            'sub_toggle'        => 'button',
            'validate_unit'     => true,
            'allowed_units'     => array( 'px' ),
            'range_settings'    => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
        ];
        $fields['checkbox_radio_button_color'] = [
            'label'             => esc_html__( 'Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'       => 'checkbox_radio_field',
            'sub_toggle'        => 'button',
        ];
        //Checkbox/Radio Label
        $fields['checkbox_radio_label_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Checkbox/Radio Label.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'label',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_label_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Checkbox/Radio Label.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'checkbox_radio_field',
		    'sub_toggle' => 'label',
            'mobile_options' => true,
        ];
        $fields['checkbox_radio_label_bg_color'] = [
            'label'          => esc_html__( 'Background Label', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'checkbox_radio_field',
		    'sub_toggle' => 'label',
        ];
        //Section
        $fields['section_field_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Section Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'section_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['section_field_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Section Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'section_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['section_field_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'section_field',
            'sub_toggle' => 'container'
        ];
        //HTML Field
        $fields['html_field_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of HTML Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'html_field',
            'mobile_options' => true,
        ];
        $fields['html_field_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of HTML Field.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'html_field',
            'mobile_options' => true,
        ];
        $fields['html_field_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'html_field',
        ];
        $fields['consent_field_container_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Consent Field Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'consent_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['consent_field_container_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Consent Field Container.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'consent_field',
		    'sub_toggle' => 'container',
            'mobile_options' => true,
        ];
        $fields['consent_field_container_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'consent_field',
		    'sub_toggle' => 'container',
        ];
      
        //Consent Field button
        $fields['consent_field_button_size'] = [
            'label'             => esc_html__( 'Size', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'consent_field',
            'sub_toggle'        => 'button',
            'validate_unit'     => true,
            'allowed_units'     => array( 'px' ),
            'range_settings'    => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
        ];
        $fields['consent_field_button_color'] = [
            'label'             => esc_html__( 'Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'       => 'consent_field',
            'sub_toggle'        => 'button',
        ];
        //Consent Field Label
        $fields['consent_field_label_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Consent Field Label.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'consent_field',
		    'sub_toggle' => 'label',
            'mobile_options' => true,
        ];
        $fields['consent_field_label_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Consent Field Label.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'consent_field',
		    'sub_toggle' => 'label',
            'mobile_options' => true,
        ];
        $fields['consent_field_label_bg_color'] = [
            'label'          => esc_html__( 'Background Label', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'consent_field',
		    'sub_toggle' => 'label',
        ];
        $fields['confirm_message_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Confirm Message.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'confirm_message',
            'mobile_options' => true,
        ];
        $fields['confirm_message_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Confirm Message.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'confirm_message',
            'mobile_options' => true,
        ];
        $fields['confirm_message_bg_color'] = [
            'label'          => esc_html__( 'Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'confirm_message',
        ];
        return $fields;
    }
    public static function get_gravity_form($args = [], $conditional_tags = [], $current_page = []) {
        $args = wp_parse_args($args, [
            'gf_form_id' => 0,
            'use_ajax' => 'false',
            'tabindex' => '',
            'field_values' => ''
        ]);
        $form_id = intval($args['gf_form_id']);
        $tabindex_attr = '';
        if (!empty($args['tabindex'])) {
            $tabindex_attr = sprintf('tabindex="%1$s"', $args['tabindex']);
        }
        $field_values_attr = '';
        if (!empty($args['field_values'])) {
            $field_values_attr = sprintf('field_values="%1$s"', $args['field_values']);
        }
        if ($form_id === 0) {
            return sprintf('<div class="alert">
                    No form selected.
                    <br>
                    Please select a form form the dropdown list of \'Choose Gravity Form\'.
                </div>');
        }
        // Prevent Form Hiding Conditional Fields In Visual Editor If Conditional Fields
        if (function_exists('et_builder_is_frontend') && !et_builder_is_frontend()) {
            add_filter('gform_has_conditional_logic', function ($has_conditional_logic, $form) {
                return false;
            }, 10, 2);
        }
        // Form Shortcode
        $gf_shortcode = sprintf('[gravityform id="%1$s" title="on" description="on" ajax="%2$s" %3$s %4$s]',
            $form_id,
            ($args['use_ajax'] === "on" ? "true" : "false"),
            $tabindex_attr,
            $field_values_attr
        );
        $form_output = sprintf('<div class="dipi_gf_styler_wrapper clearfix">%1$s</div>',
            do_shortcode($gf_shortcode)
        );
        return  $form_output;
    }
    public function get_advanced_fields_config()
    {
        $form_title_selector = "%%order_class%% .gform_title";
        $form_title_hover_selector = "%%order_class%%:hover .gform_title";
        $form_desc_selector = "%%order_class%% .gform_description";
        $form_desc_hover_selector = "%%order_class%%:hover .gform_description";
        $pagination_title_selector = "%%order_class%% .gform_wrapper .gf_progressbar_title";
        $pagination_cur_page_selector = "%%order_class%% .gform_wrapper .gf_step_current_page";
        $pagination_count_selector = "%%order_class%% .gform_wrapper .gf_step_page_count";
        $progressbar_selector = "%%order_class%% .gform_wrapper .gf_progressbar";
        $progressbar_active_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage";
        $progressbar_label_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage span";
        $field_label_selector = "%%order_class%% .gform_wrapper .gfield_label";
        $field_sub_label_selector = "%%order_class%% .ginput_complex.ginput_container > span > label,
        %%order_class%% .ginput_complex .ginput_container_time > label
        "; //"%%order_class%% .gform_wrapper .gfield_sub_label";
        $required_field_indicator_selector = "%%order_class%% .gform_wrapper .gfield_required";
        $fileupolad_desc_selector ="%%order_class%% .ginput_container_fileupload .gform_fileupload_rules";
        $field_desc_selector = "%%order_class%% .gform_wrapper .gfield_description, $field_sub_label_selector, $fileupolad_desc_selector";
        $field_container_selector = "%%order_class%% .gform_wrapper .gfield";
        $input_container_selector = "%%order_class%% .gform_wrapper .ginput_container";
        $time_selector = "%%order_class%% .gform_wrapper .ginput_container_time.gfield_time_ampm select";
        $address_country_selector = "%%order_class%% .gform_wrapper .ginput_address_country select";
        $address_country_option_selector = "%%order_class%% .gform_wrapper .ginput_address_country select option";
        $multi_select_selector="%%order_class%% .gform_wrapper .ginput_container_multiselect select";
        $input_field_selector = $time_selector.","."%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input)";
        $input_field_focus_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input):focus";
        $focus_field_selector = "%%order_class%% .gform_wrapper .gfield input:focus,
            %%order_class%% .gform_wrapper .gfield textarea:focus,
            %%order_class%% .gform_wrapper .gfield select:focus
        ";
        $placeholder_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input)::placeholder,
        %%order_class%% .gform_wrapper .gfield textarea.textarea::placeholder
            ";
        $textarea_field_selector =  $multi_select_selector.", "."%%order_class%% .gform_wrapper .gfield textarea.textarea";
        $select_field_selector = $address_country_selector.", "."%%order_class%% .gform_wrapper .gfield .ginput_container_select select.gfield_select";
        $select_option_selector = $address_country_option_selector.","."%%order_class%% .gform_wrapper .gfield .ginput_container_select select.gfield_select option";
        $consent_field_container_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent";
        $consent_field_button_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent input[type=checkbox]";
        $consent_field_label_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent .gfield_consent_label";
        $checkbox_radio_container_selector = $consent_field_container_selector.", "."%%order_class%% .gform_wrapper .gfield .gfield_checkbox,%%order_class%% .gform_wrapper .gfield .gfield_radio";
        $checkbox_radio_one_option_selector = "%%order_class%% .gform_wrapper .gfield .gchoice";
        $checkbox_radio_button_selector = $consent_field_button_selector.", "."%%order_class%% .gform_wrapper .gfield .gchoice .gfield-choice-input";
        $checkbox_radio_label_selector = $consent_field_label_selector.", "."%%order_class%% .gform_wrapper .gfield  .gchoice > label";
        $section_selector = "%%order_class%% .gform_wrapper .gfield.gsection";
        $section_title_selector = "%%order_class%% .gform_wrapper .gfield.gsection  .gsection_title";
        $section_desc_selector = "%%order_class%% .gform_wrapper .gfield.gsection  .gsection_description";
        $html_field_selector = "%%order_class%% .gform_wrapper .gfield.gfield_html";
        
        $gf_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer button,
            %%order_class%% .gform_wrapper .gform_page_footer input[type=button], 
            %%order_class%% .gform_wrapper .gform_page_footer input[type=submit],
            %%order_class%% .gform_wrapper .gform_footer button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button], 
            %%order_class%% .gform_wrapper .gform_footer input[type=submit],
            %%order_class%% .gform_wrapper .dipi_gf_submit_button
        ";
        $gf_submit_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=submit].button.gform_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=submit],
            %%order_class%% .gform_wrapper .gform_footer input[type=submit].button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=submit],
            %%order_class%% .gform_wrapper .dipi_gf_submit_button
            ";
        $gf_prev_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=button].button.gform_previous_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=button].dipi_gf_prev_button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button].button.gform_previous_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=button].dipi_gf_prev_button.gform_button
        ";
        $gf_next_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=button].button.gform_next_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=button].dipi_gf_next_button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button].button.gform_next_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=button].dipi_gf_next_button.gform_button
        ";
        $confirm_msg_selector = "%%order_class%% .gform_confirmation_wrapper  .gform_confirmation_message";
        $advanced_fields = [];
        $advanced_fields["fonts"]["text"] = [
            'label' => esc_html__('Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%%",
                'hover' => "%%order_class%%:hover",
            ],
            'toggle_slug' => 'text',
        ];
        $advanced_fields["fonts"]["form_title"] = [
            'label' => esc_html__('Form Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => $form_title_selector,
                'hover' => $form_title_hover_selector,
            ],
            'toggle_slug' => 'form_title_text',
        ];
       
        $advanced_fields["fonts"]["form_desc"] = [
            'label' => esc_html__('Form Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => $form_desc_selector,
                'hover' => $form_desc_hover_selector,
            ],
            'toggle_slug' => 'form_desc_text',
        ];
        $advanced_fields["fonts"]["pagination_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => $pagination_title_selector,
            ],
            'toggle_slug' => 'pagination',
            'sub_toggle' => 'title',
        ];
        $advanced_fields["fonts"]["pagination_cur_page"] = [
            'label' => esc_html__('Current Page', 'dipi-divi-pixel'),
            'css' => [
                'main' => $pagination_cur_page_selector,
            ],
            'toggle_slug' => 'pagination',
            'sub_toggle' => 'cur_page',
        ];
        $advanced_fields["fonts"]["pagination_count"] = [
            'label' => esc_html__('Count', 'dipi-divi-pixel'),
            'css' => [
                'main' => $pagination_count_selector,
            ],
            'toggle_slug' => 'pagination',
            'sub_toggle' => 'count',
        ];
        $advanced_fields["fonts"]["progressbar_label"] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $progressbar_label_selector,
            ],
            'toggle_slug' => 'progress_bar',
            'sub_toggle' => 'label',
        ];
        $advanced_fields["fonts"]["field_label"] = [
            'label' => esc_html__('Field Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $field_label_selector,
            ],
            'toggle_slug' => 'field_label',

        ];
        /*$advanced_fields["fonts"]["field_sub_label"] = [
            'label' => esc_html__('Field Sub Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $field_sub_label_selector,
            ],
            'toggle_slug' => 'field_sub_label',

        ];*/

        $advanced_fields["fonts"]["required_field_indicator"] = [
            'label' => esc_html__('Required Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $required_field_indicator_selector,
            ],
            'toggle_slug' => 'required_field_indicator_text',
        ];
        $advanced_fields["fonts"]["field_description"] = [
            'label' => esc_html__('Field Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => $field_desc_selector,
            ],
            'toggle_slug' => 'field_description',
        ];
        $advanced_fields["fonts"]["input_field"] = [
            'label' => esc_html__('Input Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $input_field_selector,
            ],
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'general'
        ];
        $advanced_fields["fonts"]["input_field_focus"] = [
            'label' => esc_html__('Focused Input Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $input_field_focus_selector,
            ],
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'focus'
        ];
        $advanced_fields["fonts"]["input_field_placeholder"] = [
            'label' => esc_html__('Input Placeholder Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $placeholder_selector,
            ],
            'toggle_slug' => 'placeholder',
        ];
        $advanced_fields["fonts"]["textarea_field"] = [
            'label' => esc_html__('Textarea Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $textarea_field_selector,
            ],
            'toggle_slug' => 'textarea_field',
        ];
        $advanced_fields["fonts"]["select_field"] = [
            'label' => esc_html__('Select Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $select_field_selector,
            ],
            /*'hide_line_height' => true,*/
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'select'
        ];
        $advanced_fields["fonts"]["select_dropdown_field"] = [
            'label' => esc_html__('Dropdown Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $select_option_selector,
            ],
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'option'
        ];
        $advanced_fields["fonts"]["checkbox_radio_label"] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $checkbox_radio_label_selector,
            ],
            'toggle_slug' => 'checkbox_radio_field',
            'sub_toggle' => 'label'
        ];
        $advanced_fields["fonts"]["section_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => $section_title_selector,
            ],
            'toggle_slug' => 'section_field',
            'sub_toggle' => 'title'
        ];
        $advanced_fields["fonts"]["section_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => $section_desc_selector,
            ],
            'toggle_slug' => 'section_field',
            'sub_toggle' => 'desc'
        ];
        $advanced_fields["fonts"]["html_field"] = [
            'label' => esc_html__('HTML Field', 'dipi-divi-pixel'),
            'css' => [
                'main' => $html_field_selector,
            ],
            'toggle_slug' => 'html_field',
        ];
        $advanced_fields["fonts"]["confirm_msg"] = [
            'label' => esc_html__('Confirm Message', 'dipi-divi-pixel'),
            'css' => [
                'main' => $confirm_msg_selector,
            ],
            'toggle_slug' => 'confirm_message',
        ];
        $advanced_fields["fonts"]["header"] = [
            'label' => esc_html__('Heading', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h1",
            ),
            'font_size' => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h1',
        ];
        $advanced_fields["fonts"]["header_2"] = [
            'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h2",
            ),
            'font_size' => array(
                'default' => '26px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h2',
        ];
        $advanced_fields["fonts"]["header_3"] = [
            'label' => esc_html__('Heading 3', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h3",
            ),
            'font_size' => array(
                'default' => '22px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h3',
        ];
        $advanced_fields["fonts"]["header_4"] = [
            'label' => esc_html__('Heading 4', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h4",
            ),
            'font_size' => array(
                'default' => '18px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h4',
        ];
        $advanced_fields["fonts"]["header_5"] = [
            'label' => esc_html__('Heading 5', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h5",
            ),
            'font_size' => array(
                'default' => '16px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h5',
        ];
        $advanced_fields["fonts"]["header_6"] = [
            'label' => esc_html__('Heading 6', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .gform_wrapper h6",
            ),
            'font_size' => array(
                'default' => '14px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h6',
        ];
        $advanced_fields["fonts"]["consent_field_label"] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $consent_field_label_selector,
            ],
            'toggle_slug' => 'consent_field',
            'sub_toggle' => 'label'
        ];
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "{$this->main_css_element}",
                    'border_styles' => "{$this->main_css_element}",
                ],
            ],
        ];
        $advanced_fields["borders"]["focus_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $focus_field_selector,
                    'border_styles' => $focus_field_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'focus_field',
        ];

        $advanced_fields["borders"]["input_field_focus"] = [
            'css' => [
                'main' => [
                    'border_radii' => $input_field_focus_selector,
                    'border_styles' => $input_field_focus_selector
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'focus'
        ];
        
        $advanced_fields["borders"]["progress_bar"] = [
            'css' => [
                'main' => [
                    'border_radii' => $progressbar_selector,
                    'border_styles' => $progressbar_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_bar',
            'sub_toggle' => 'progress_bar',
        ];
        $advanced_fields["borders"]["progress_active_bar"] = [
            'css' => [
                'main' => [
                    'border_radii' => $progressbar_active_selector,
                    'border_styles' => $progressbar_active_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_bar',
            'sub_toggle' => 'active',
        ];
        $advanced_fields["borders"]["field_container"] = [
            'css' => [
                'main' => [
                    'border_radii' => $field_container_selector,
                    'border_styles' => $field_container_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_container',
        ];
        $advanced_fields["borders"]["field_container"] = [
            'css' => [
                'main' => [
                    'border_radii' => $field_container_selector,
                    'border_styles' => $field_container_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'field_container',
        ];
        /*$advanced_fields["borders"]["input_container"] = [
            'css' => [
                'main' => [
                    'border_radii' => $input_container_selector,
                    'border_styles' => $input_container_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_container',
        ];*/
        $advanced_fields["borders"]["input_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $input_field_selector,
                    'border_styles' => $input_field_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'general'
        ];
        $advanced_fields["borders"]["textarea_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $textarea_field_selector,
                    'border_styles' => $textarea_field_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'textarea_field',
        ];
        $advanced_fields["borders"]["select_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $select_field_selector,
                    'border_styles' => $select_field_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'select'
        ];
        $advanced_fields["borders"]["section_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $section_selector,
                    'border_styles' => $section_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'section_field',
            'sub_toggle' => 'container'
        ];
        $advanced_fields["borders"]["html_field"] = [
            'css' => [
                'main' => [
                    'border_radii' => $html_field_selector,
                    'border_styles' => $html_field_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'html_field',
        ];
        $advanced_fields["borders"]["confirm_msg"] = [
            'css' => [
                'main' => [
                    'border_radii' => $confirm_msg_selector,
                    'border_styles' => $confirm_msg_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'confirm_message',
        ];
        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "{$this->main_css_element}",
            ],
        ];
        $advanced_fields["box_shadow"]["input_field_focus"] = [
            'css' => [
                'main' =>  $input_field_focus_selector,
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'focus'
        ];
        $advanced_fields["box_shadow"]["focus_field"] = [
            'css' => [
                'main' =>  $focus_field_selector
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'focus_field',
        ];
        
        $advanced_fields["box_shadow"]["field_container"] = [
            'css' => [
                'main' => $field_container_selector,
            ],
            'toggle_slug' => 'field_container',
        ];
        /*$advanced_fields["box_shadow"]["input_container"] = [
            'css' => [
                'main' => $input_container_selector,
            ],
            'toggle_slug' => 'input_container',
        ];*/
        $advanced_fields["box_shadow"]["input_field"] = [
            'css' => [
                'main' => $input_field_selector,
            ],
            'toggle_slug' => 'input_field',
            'sub_toggle' => 'general'
        ];
        $advanced_fields["box_shadow"]["textarea_field"] = [
            'css' => [
                'main' => $textarea_field_selector,
            ],
            'toggle_slug' => 'textarea_field',
        ];
        $advanced_fields["box_shadow"]["select_field"] = [
            'css' => [
                'main' => $select_field_selector,
            ],
            'toggle_slug' => 'select_field',
            'sub_toggle' => 'select'
        ];
        $advanced_fields["box_shadow"]["section_field"] = [
            'css' => [
                'main' => $section_selector,
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'section_field',
            'sub_toggle' => 'container'
        ];
        $advanced_fields["box_shadow"]["html_field"] = [
            'css' => [
                'main' => $html_field_selector,
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'html_field',
        ];
        $advanced_fields["box_shadow"]["confirm_msg"] = [
            'css' => [
                'main' => $confirm_msg_selector,
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'confirm_message',
        ];
        $advanced_fields['button']["all"] = [
            'label' => esc_html__('All Buttons', 'dipi-divi-pixel'),
            'css' => [
                'main' => $gf_button_selector,
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => $gf_button_selector,
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => $gf_button_selector,
                ],
            ],
            /*'toggle_slug' => 'form_buttons',
            'sub_toggle' => 'all'*/
        ];
        $advanced_fields['button']["submit"] = [
            'label' => esc_html__('Submit Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => $gf_submit_button_selector,
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => $gf_submit_button_selector,
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => $gf_submit_button_selector,
                ],
            ],
            /*'toggle_slug' => 'form_buttons',
            'sub_toggle' => 'submit'*/
        ];
        $advanced_fields['button']["prev"] = [
            'label' => esc_html__('Prev Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => $gf_prev_button_selector,
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => $gf_prev_button_selector,
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => $gf_prev_button_selector,
                ],
            ],
            /*'toggle_slug' => 'form_buttons',
            'sub_toggle' => 'prev'*/
        ];
        $advanced_fields['button']["next"] = [
            'label' => esc_html__('Next Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => $gf_next_button_selector,
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => $gf_next_button_selector,
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => $gf_next_button_selector,
                ],
            ],
            /*'toggle_slug' => 'form_buttons',
            'sub_toggle' => 'next'*/
        ];
        return $advanced_fields;
    }

    public function get_custom_css_fields_config(){
        $fields = [];
        $form_title_selector = "%%order_class%% .gform_title";
        $form_title_hover_selector = "%%order_class%%:hover .gform_title";
        $form_desc_selector = "%%order_class%% .gform_description";
        $form_desc_hover_selector = "%%order_class%%:hover .gform_description";
        $pagination_title_selector = "%%order_class%% .gform_wrapper .gf_progressbar_title";
        $pagination_cur_page_selector = "%%order_class%% .gform_wrapper .gf_step_current_page";
        $pagination_count_selector = "%%order_class%% .gform_wrapper .gf_step_page_count";
        $progressbar_wrapper_selector = "%%order_class%% .gf_progressbar_wrapper";
        $progressbar_selector = "%%order_class%% .gform_wrapper .gf_progressbar";
        $progressbar_active_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage";
        $progressbar_label_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage span";
        $field_container_selector = "%%order_class%% .gform_wrapper .gfield";
        $field_label_selector = "%%order_class%% .gform_wrapper .gfield_label";
        $field_sub_label_selector = "%%order_class%% .ginput_complex.ginput_container > span > label";
        $required_field_indicator_selector = "%%order_class%% .gform_wrapper .gfield_required";
        $fileupolad_desc_selector ="%%order_class%% .ginput_container_fileupload .gform_fileupload_rules";
        $field_desc_selector = "%%order_class%% .gform_wrapper .gfield_description, $field_sub_label_selector, $fileupolad_desc_selector";
        $field_container_selector = "%%order_class%% .gform_wrapper .gfield";
        $input_container_selector = "%%order_class%% .gform_wrapper .ginput_container";
        $time_selector = "%%order_class%% .gform_wrapper .ginput_container_time.gfield_time_ampm select";
        $address_country_selector = "%%order_class%% .gform_wrapper .ginput_address_country select";
        $address_country_container_selector = "%%order_class%% .gform_wrapper .ginput_address_country";
        $address_country_arrow_selector = "%%order_class%% .gform_wrapper .ginput_address_country:after";
        $multi_select_selector="%%order_class%% .gform_wrapper .ginput_container_multiselect select";
        $input_field_selector = $time_selector.","."%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input)";
        $input_field_focus_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input):focus";
        $focus_field_selector = "%%order_class%% .gform_wrapper .gfield input:focus,
            %%order_class%% .gform_wrapper .gfield textarea:focus,
            %%order_class%% .gform_wrapper .gfield select:focus
        ";
        $placeholder_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input)::placeholder,
        %%order_class%% .gform_wrapper .gfield textarea.textarea::placeholder
            ";
        $textarea_field_selector = $multi_select_selector.","."%%order_class%% .gform_wrapper .gfield textarea.textarea";
        $select_field_selector = $address_country_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select select.gfield_select";
        $select_container_selector = $address_country_container_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select";
        $select_arrow_selector = $address_country_arrow_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select:after";
        $select_option_selector = "%%order_class%% .gform_wrapper .gfield select.gfield_select option";
        $section_selector = "%%order_class%% .gform_wrapper .gfield.gsection";
        $section_title_selector = "%%order_class%% .gform_wrapper .gfield.gsection  .gsection_title";
        $section_desc_selector = "%%order_class%% .gform_wrapper .gfield.gsection  .gsection_description";
        $html_field_selector = "%%order_class%% .gform_wrapper .gfield.gfield_html";
        $consent_field_container_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent";
        $consent_field_button_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent input[type=checkbox]";
        $consent_field_label_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent .gfield_consent_label";
        $checkbox_radio_container_selector = $consent_field_container_selector.", "."%%order_class%% .gform_wrapper .gfield .gfield_checkbox,%%order_class%% .gform_wrapper .gfield .gfield_radio";
        $checkbox_radio_one_option_selector = "%%order_class%% .gform_wrapper .gfield .gchoice";
        $checkbox_radio_button_selector = $consent_field_button_selector.", "."%%order_class%% .gform_wrapper .gfield .gchoice .gfield-choice-input";
        $checkbox_radio_label_selector = $consent_field_label_selector.", "."%%order_class%% .gform_wrapper .gfield  .gchoice > label";
        $gf_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer button,
            %%order_class%% .gform_wrapper .gform_page_footer input[type=button], 
            %%order_class%% .gform_wrapper .gform_page_footer input[type=submit],
            %%order_class%% .gform_wrapper .gform_footer button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button], 
            %%order_class%% .gform_wrapper .gform_footer input[type=submit],
            %%order_class%% .gform_wrapper .dipi_gf_submit_button
        ";
        $gf_submit_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=submit].button.gform_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=submit],
            %%order_class%% .gform_wrapper .gform_footer input[type=submit].button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=submit],
            %%order_class%% .gform_wrapper .dipi_gf_submit_button
            ";
        $gf_prev_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=button].button.gform_previous_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=button].dipi_gf_prev_button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button].button.gform_previous_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=button].dipi_gf_prev_button.gform_button
        ";
        $gf_next_button_selector = "%%order_class%% .gform_wrapper .gform_page_footer input[type=button].button.gform_next_button,
            %%order_class%% .gform_wrapper .gform_page_footer button[type=button].dipi_gf_next_button.gform_button,
            %%order_class%% .gform_wrapper .gform_footer input[type=button].button.gform_next_button,
            %%order_class%% .gform_wrapper .gform_footer button[type=button].dipi_gf_next_button.gform_button
        ";
        $confirm_msg_selector = "%%order_class%% .gform_confirmation_wrapper .gform_confirmation_message";

        $fields['gf_button_selector'] = [
            'label' => esc_html__('All Buttons', 'dipi-divi-pixel'),
            'selector' => $gf_button_selector,
        ];
        $fields['gf_submit_button_selector'] = [
            'label' => esc_html__('Submit Button', 'dipi-divi-pixel'),
            'selector' => $gf_submit_button_selector,
        ];
        $fields['gf_prev_button_selector'] = [
            'label' => esc_html__('Prev Button', 'dipi-divi-pixel'),
            'selector' => $gf_prev_button_selector,
        ];
        $fields['gf_next_button_selector'] = [
            'label' => esc_html__('Next Button', 'dipi-divi-pixel'),
            'selector' => $gf_next_button_selector,
        ];
        $fields['form_heading'] = [
            'label' => esc_html__('Form Heading', 'dipi-divi-pixel'),
            'selector' => '.gform_heading',
        ];
        $fields['form_title_selector'] = [
            'label' => esc_html__('Form Title', 'dipi-divi-pixel'),
            'selector' => $form_title_selector
        ];
        $fields['form_title_hover_selector'] = [
            'label' => esc_html__('Form Title on Hover', 'dipi-divi-pixel'),
            'selector' => $form_title_hover_selector
        ];
        $fields['form_desc_selector'] = [
            'label' => esc_html__('Form Description', 'dipi-divi-pixel'),
            'selector' => $form_desc_selector
        ];
        $fields['form_desc_hover_selector'] = [
            'label' => esc_html__('Form Description on Hover', 'dipi-divi-pixel'),
            'selector' => $form_desc_hover_selector
        ];

        $fields['pagination_title_selector'] = [
            'label' => esc_html__('Pagination Title', 'dipi-divi-pixel'),
            'selector' => $pagination_title_selector
        ];
        $fields['pagination_cur_page_selector'] = [
            'label' => esc_html__('Pagination Current Page', 'dipi-divi-pixel'),
            'selector' => $pagination_cur_page_selector
        ];
        $fields['pagination_count_selector'] = [
            'label' => esc_html__('Pagination Count', 'dipi-divi-pixel'),
            'selector' => $pagination_count_selector
        ];
        $fields['progressbar_wrapper_selector'] = [
            'label' => esc_html__('Progress bar Wrapper', 'dipi-divi-pixel'),
            'selector' => $progressbar_wrapper_selector
        ];
        $fields['progressbar_selector'] = [
            'label' => esc_html__('Progress bar', 'dipi-divi-pixel'),
            'selector' => $progressbar_selector
        ];
        $fields['progressbar_active_selector'] = [
            'label' => esc_html__('Active Progress Bar', 'dipi-divi-pixel'),
            'selector' => $progressbar_active_selector,
        ];
        $fields['progressbar_label_selector'] = [
            'label' => esc_html__('Progressbar Label', 'dipi-divi-pixel'),
            'selector' => $progressbar_label_selector,
        ];
        $fields['field_container_selector'] = [
            'label' => esc_html__('Field Container', 'dipi-divi-pixel'),
            'selector' => $field_container_selector,
        ];
        $fields['field_label_selector'] = [
            'label' => esc_html__('Field Label', 'dipi-divi-pixel'),
            'selector' => $field_label_selector,
        ];
        $fields['field_sub_label_selector'] = [
            'label' => esc_html__('Field Sub Label', 'dipi-divi-pixel'),
            'selector' => $field_sub_label_selector,
        ];
        $fields['required_field_indicator_selector'] = [
            'label' => esc_html__('Required Field', 'dipi-divi-pixel'),
            'selector' => $required_field_indicator_selector,
        ];
        $fields['fileupolad_desc_selector'] = [
            'label' => esc_html__('File upload Description', 'dipi-divi-pixel'),
            'selector' => $fileupolad_desc_selector,
        ];
        $fields['field_desc_selector'] = [
            'label' => esc_html__('Field Description', 'dipi-divi-pixel'),
            'selector' => $field_desc_selector,
        ];
        $fields['field_container_selector'] = [
            'label' => esc_html__('Field Container', 'dipi-divi-pixel'),
            'selector' => $field_container_selector,
        ];
        $fields['input_container_selector'] = [
            'label' => esc_html__('Input Container', 'dipi-divi-pixel'),
            'selector' => $input_container_selector,
        ];
        $fields['time_selector'] = [
            'label' => esc_html__('Time', 'dipi-divi-pixel'),
            'selector' => $time_selector,
        ];
        $fields['address_country_selector'] = [
            'label' => esc_html__('Address Country', 'dipi-divi-pixel'),
            'selector' => $address_country_selector,
        ];
        $fields['address_country_container_selector'] = [
            'label' => esc_html__('Address Country Container', 'dipi-divi-pixel'),
            'selector' => $address_country_container_selector,
        ];
        $fields['address_country_arrow_selector'] = [
            'label' => esc_html__('Address Country Arrow', 'dipi-divi-pixel'),
            'selector' => $address_country_arrow_selector,
        ];
        $fields['multi_select_selector'] = [
            'label' => esc_html__('Multi Select', 'dipi-divi-pixel'),
            'selector' => $multi_select_selector,
        ];
        $fields['input_field_selector'] = [
            'label' => esc_html__('Input Field', 'dipi-divi-pixel'),
            'selector' => $input_field_selector,
        ];
        $fields['input_field_focus_selector'] = [
            'label' => esc_html__('Input Focus Field', 'dipi-divi-pixel'),
            'selector' => $input_field_focus_selector,
        ];
        $fields['focus_field_selector'] = [
            'label' => esc_html__('Focus Field', 'dipi-divi-pixel'),
            'selector' => $focus_field_selector,
        ];
        $fields['placeholder_selector'] = [
            'label' => esc_html__('Placeholder', 'dipi-divi-pixel'),
            'selector' => $placeholder_selector,
        ];
        $fields['textarea_field_selector'] = [
            'label' => esc_html__('Textarea Field', 'dipi-divi-pixel'),
            'selector' => $textarea_field_selector,
        ];
        $fields['select_field_selector'] = [
            'label' => esc_html__('Select Field', 'dipi-divi-pixel'),
            'selector' => $select_field_selector,
        ];
        $fields['select_container_selector'] = [
            'label' => esc_html__('Select Container', 'dipi-divi-pixel'),
            'selector' => $select_container_selector,
        ];
        $fields['select_arrow_selector'] = [
            'label' => esc_html__('Select Arrow', 'dipi-divi-pixel'),
            'selector' => $select_arrow_selector,
        ];
        $fields['select_option_selector'] = [
            'label' => esc_html__('Select Option', 'dipi-divi-pixel'),
            'selector' => $select_option_selector,
        ];
        $fields['section_selector'] = [
            'label' => esc_html__('Section', 'dipi-divi-pixel'),
            'selector' => $section_selector,
        ];
        $fields['section_title_selector'] = [
            'label' => esc_html__('Section Title', 'dipi-divi-pixel'),
            'selector' => $section_title_selector,
        ];
        $fields['section_desc_selector'] = [
            'label' => esc_html__('Section Description', 'dipi-divi-pixel'),
            'selector' => $section_desc_selector,
        ];
        $fields['html_field_selector'] = [
            'label' => esc_html__('Html Field', 'dipi-divi-pixel'),
            'selector' => $html_field_selector,
        ];
        $fields['consent_field_container_selector'] = [
            'label' => esc_html__('Consent Field Container', 'dipi-divi-pixel'),
            'selector' => $consent_field_container_selector,
        ];
        $fields['consent_field_button_selector'] = [
            'label' => esc_html__('Consent Field Button', 'dipi-divi-pixel'),
            'selector' => $consent_field_button_selector,
        ];
        $fields['consent_field_label_selector'] = [
            'label' => esc_html__('Consent Field Label', 'dipi-divi-pixel'),
            'selector' => $consent_field_label_selector,
        ];
        $fields['checkbox_radio_container_selector'] = [
            'label' => esc_html__('Checkbox Radio Container', 'dipi-divi-pixel'),
            'selector' => $checkbox_radio_container_selector,
        ];
        $fields['checkbox_radio_one_option_selector'] = [
            'label' => esc_html__('Checkbox Radio One Option', 'dipi-divi-pixel'),
            'selector' => $checkbox_radio_one_option_selector,
        ];
        $fields['checkbox_radio_button_selector'] = [
            'label' => esc_html__('Checkbox Radio Button', 'dipi-divi-pixel'),
            'selector' => $checkbox_radio_button_selector,
        ];
        $fields['checkbox_radio_label_selector'] = [
            'label' => esc_html__('Checkbox Radio Label', 'dipi-divi-pixel'),
            'selector' => $checkbox_radio_label_selector,
        ];
        $fields['confirm_msg_selector'] = [
            'label' => esc_html__('Confirm Message', 'dipi-divi-pixel'),
            'selector' => $confirm_msg_selector,
        ];

        
        return $fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_gravity_forms_styler_public');
        $config = htmlspecialchars(json_encode($this->dipi_gravity_forms_styler()));
        $gf_output = $this->get_gravity_form($this->props, array(), array());
        $this->dipi_apply_css($render_slug);

        return sprintf(
            '<div class="dipi_gf_styler_container" data-config="%1$s">
                %2$s
            </div>',
            $config,
            $gf_output
        );
    }

    public function dipi_gravity_forms_styler()
    {
        return [
            "custom_all" => $this->props["custom_all"],
            "all_use_icon" => $this->props["all_use_icon"],
            "all_icon"     => $this->props["all_icon"],
            "all_icon_tablet"     => $this->props["all_icon_tablet"],
            "all_icon_phone"     => $this->props["all_icon_phone"],
            "all_icon_last_edited" => $this->props["all_icon_last_edited"], 
            "custom_next" => $this->props["custom_next"],
            "next_use_icon" => $this->props["next_use_icon"],
            "next_icon"     => $this->props["next_icon"],
            "next_icon_tablet"     => $this->props["next_icon_tablet"],
            "next_icon_phone"     => $this->props["next_icon_phone"],
            "next_icon_last_edited" => $this->props["next_icon_last_edited"],
            "custom_prev" => $this->props["custom_prev"],
            "prev_use_icon" => $this->props["prev_use_icon"],
            "prev_icon"     => $this->props["prev_icon"],
            "prev_icon_tablet"     => $this->props["prev_icon_tablet"],
            "prev_icon_phone"     => $this->props["prev_icon_phone"],
            "prev_icon_last_edited" => $this->props["prev_icon_last_edited"],
            "custom_submit" => $this->props["custom_submit"],
            "submit_use_icon" => $this->props["submit_use_icon"],
            "submit_icon"     => $this->props["submit_icon"],
            "submit_icon_tablet"     => $this->props["submit_icon_tablet"],
            "submit_icon_phone"     => $this->props["submit_icon_phone"],
            "submit_icon_last_edited" => $this->props["submit_icon_last_edited"],
            "use_custom_select_arrow" => $this->props["use_custom_select_arrow"],
            "select_arrow_use_icon" => $this->props["select_arrow_use_icon"],
            "select_arrow_icon_last_edited" =>  isset($this->props["select_arrow_icon_last_edited"]) ? $this->props["select_arrow_icon_last_edited"] : "",
            "select_arrow_icon"     => $this->props["select_arrow_icon"],
            "select_arrow_icon_tablet"     => $this->props["select_arrow_icon_tablet"],
            "select_arrow_icon_phone"     => $this->props["select_arrow_icon_phone"], 
        ];
    }

    public function dipi_apply_css($render_slug){
        $form_title = $this->props["form_title"];
        $form_title_responsive_active = isset($this->props["form_title_last_edited"]) && et_pb_get_responsive_status($this->props["form_title_last_edited"]);
        $form_title_tablet = $form_title_responsive_active && $this->props["form_title_tablet"] ? $this->props["form_title_tablet"] : $form_title;
        $form_title_phone = $form_title_responsive_active && $this->props["form_title_phone"] ? $this->props["form_title_phone"] : $form_title_tablet;
        
        $form_desc = $this->props["form_desc"];
        $form_desc_responsive_active = isset($this->props["form_desc_last_edited"]) && et_pb_get_responsive_status($this->props["form_desc_last_edited"]);
        $form_desc_tablet = $form_desc_responsive_active && $this->props["form_desc_tablet"] ? $this->props["form_desc_tablet"] : $form_desc;
        $form_desc_phone = $form_desc_responsive_active && $this->props["form_desc_phone"] ? $this->props["form_desc_phone"] : $form_desc_tablet;
        $use_custom_select_arrow = $this->props["use_custom_select_arrow"];
        $select_arrow_use_icon = $this->props["select_arrow_use_icon"];
        $form_title_selector = "%%order_class%% .gform_title";
        $form_desc_selector = "%%order_class%% .gform_description";
        $progressbar_selector = "%%order_class%% .gform_wrapper .gf_progressbar";
        $progressbar_active_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage";
        $progressbar_label_selector = "%%order_class%% .gform_wrapper .gf_progressbar .gf_progressbar_percentage span";
        $field_container_selector = "%%order_class%% .gform_wrapper .gfield";
        $field_sub_label_selector = "%%order_class%% .ginput_complex.ginput_container > span > label";
        $fileupolad_desc_selector ="%%order_class%% .ginput_container_fileupload .gform_fileupload_rules";
        $field_desc_selector = "%%order_class%% .gform_wrapper .gfield_description, $field_sub_label_selector, $fileupolad_desc_selector";
        $input_container_selector = "%%order_class%% .gform_wrapper .ginput_container";
        $time_selector = "%%order_class%% .gform_wrapper .ginput_container_time.gfield_time_ampm select";
        $address_country_selector = "%%order_class%% .gform_wrapper .ginput_address_country select";
        $address_country_container_selector = "%%order_class%% .gform_wrapper .ginput_address_country";
        $address_country_arrow_selector = "%%order_class%%.dipi_gravity_forms_styler .gform_wrapper .ginput_container_address .ginput_address_country:after";
        $multi_select_selector="%%order_class%% .gform_wrapper .ginput_container_multiselect select";
        $input_field_selector = $time_selector.","."%%order_class%% .gform_wrapper .gfield .ginput_container input:not(.gfield-choice-input)";
        $textarea_field_selector = $multi_select_selector.","."%%order_class%% .gform_wrapper .gfield textarea.textarea";
        $select_field_selector = $address_country_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select select.gfield_select";
        $select_container_selector = $address_country_container_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select";
        $select_arrow_selector = $address_country_arrow_selector.", %%order_class%% .gform_wrapper .gfield .ginput_container_select:after";
        $select_option_selector = "%%order_class%% .gform_wrapper .gfield select.gfield_select option";
        $section_selector = "%%order_class%% .gform_wrapper .gfield.gsection";
        $html_field_selector = "%%order_class%% .gform_wrapper .gfield.gfield_html";
        $consent_field_container_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent";
        $consent_field_button_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent input[type=checkbox]";
        $consent_field_label_selector = "%%order_class%% .gform_wrapper .gfield .ginput_container_consent .gfield_consent_label";
        $checkbox_radio_container_selector = $consent_field_container_selector.", "."%%order_class%% .gform_wrapper .gfield .gfield_checkbox,%%order_class%% .gform_wrapper .gfield .gfield_radio";
        $checkbox_radio_one_option_selector = "%%order_class%% .gform_wrapper .gfield .gchoice";
        $checkbox_radio_button_selector = $consent_field_button_selector.", "."%%order_class%% .gform_wrapper .gfield .gchoice .gfield-choice-input";
        $checkbox_radio_label_selector = $consent_field_label_selector.", "."%%order_class%% .gform_wrapper .gfield  .gchoice > label";
        $confirm_msg_selector = "%%order_class%% .gform_confirmation_wrapper .gform_confirmation_message";

        // Form Heading(Title and Description)
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $form_title_selector,
            'declaration' => "display: ".($form_title ==='hide' ? 'none' : 'block').";",
        ]);
        if ($form_title_responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $form_title_selector,
                'declaration' => "display: ".($form_title_tablet ==='hide' ? 'none' : 'block').";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $form_title_selector,
                'declaration' => "display: ".($form_title_phone ==='hide' ? 'none' : 'block').";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $form_desc_selector,
            'declaration' => "display: ".($form_desc ==='hide' ? 'none' : 'block').";",
        ]);
        if ($form_desc_responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $form_desc_selector,
                'declaration' => "display: ".($form_desc_tablet ==='hide' ? 'none' : 'block').";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $form_desc_selector,
                'declaration' => "display: ".($form_desc_phone ==='hide' ? 'none' : 'block').";",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'form_title_margin',
            'margin',
            $form_title_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'form_title_padding',
            'padding',
            $form_title_selector 
        );

        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'form_desc_margin',
            'margin',
            $form_desc_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'form_desc_padding',
            'padding',
            $form_desc_selector 
        );
        // Progress Bar
        $this->dipi_apply_custom_style(
            $render_slug,
            'progress_bar_bg_color',
            'background-color',
            $progressbar_selector,
            true
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'progress_bar_active_bg_color',
            'background-color',
            $progressbar_active_selector,
            true
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'progressbar_label_line_height',
            'height',
            $progressbar_selector,
            true
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'progressbar_label_line_height',
            'height',
            $progressbar_active_selector,
            true
        );
        
        $this->dipi_apply_custom_style(
            $render_slug,
            'progress_bar_label_bg_color',
            'background-color',
            $progressbar_label_selector
        );
        // Field Container
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'field_container_margin',
            'margin',
            $field_container_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'field_container_padding',
            'padding',
            $field_container_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'field_container_bg_color',
            'background-color',
            $field_container_selector
        );
        // Field Description
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'field_description_margin',
            'margin',
            $field_desc_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'field_description_padding',
            'padding',
            $field_desc_selector
        );
        /*// Input Container
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'input_container_margin',
            'margin',
            $input_container_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'input_container_padding',
            'padding',
            $input_container_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'input_container_bg_color',
            'background-color',
            $input_container_selector
        );*/
        // Input Field
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'input_field_margin',
            'margin',
            $input_field_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'input_field_padding',
            'padding',
            $input_field_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'input_field_bg_color',
            'background-color',
            $input_field_selector
        );
        // Textarea Field
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'textarea_field_margin',
            'margin',
            $textarea_field_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'textarea_field_padding',
            'padding',
            $textarea_field_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'textarea_field_bg_color',
            'background-color',
            $textarea_field_selector
        );
        // Select Field
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'select_field_margin',
            'margin',
            $select_field_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'select_field_padding',
            'padding',
            $select_field_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'select_field_bg_color',
            'background-color',
            $select_field_selector
        );
        $select_field_padding = $this->props["select_field_padding"];
        $select_field_padding_responsive_active = isset($this->props["select_field_padding_last_edited"]) && et_pb_get_responsive_status($this->props["select_field_padding_last_edited"]);
        $select_field_padding_tablet = $select_field_padding_responsive_active && $this->props["select_field_padding_tablet"] ? $this->props["select_field_padding_tablet"] : $select_field_padding;
        $select_field_padding_phone = $select_field_padding_responsive_active && $this->props["select_field_padding_phone"] ? $this->props["select_field_padding_phone"] : $select_field_padding_tablet;
        $select_field_padding = explode('|', $select_field_padding);
        $select_field_padding_tablet = explode('|', $select_field_padding_tablet);
        $select_field_padding_phone = explode('|', $select_field_padding_phone);

        $select_field_line_height = $this->props["select_field_line_height"];
        
        $select_field_line_height_responsive_active = isset($this->props["select_field_line_height_last_edited"]) && et_pb_get_responsive_status($this->props["select_field_line_height_last_edited"]);
        $select_field_line_height_tablet = $select_field_line_height_responsive_active && $this->props["select_field_line_height_tablet"] ? $this->props["select_field_line_height_tablet"] : $select_field_line_height;
        $select_field_line_height_phone = $select_field_line_height_responsive_active && $this->props["select_field_line_height_phone"] ? $this->props["select_field_line_height_phone"] : $select_field_line_height_tablet;


        ET_Builder_Element::set_style($render_slug, [
            'selector' => $select_field_selector,
            'declaration' => "height: calc(" .$select_field_line_height." + ". $select_field_padding[0]. " + ". $select_field_padding[2]. ");",
        ]);
        if ($select_field_padding_responsive_active || $select_field_line_height_responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $select_field_selector,
                'declaration' => "height: calc(" .$select_field_line_height_tablet." + ". $select_field_padding_tablet[0]. " + ". $select_field_padding_tablet[2]. ");",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $select_field_selector,
                'declaration' => "height: calc(" .$select_field_line_height_phone." + ". $select_field_padding_phone[0]. " + ". $select_field_padding_phone[2]. ");",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        // Select Arrow
        if ($use_custom_select_arrow === "on") {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $select_field_selector,
                'declaration' => "-webkit-appearance: none;-moz-appearance: none;appearance: none;background-image: none;",
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $select_arrow_selector,
                'declaration' => "content: ' ';",
            ]);
            $this->dipi_apply_custom_margin_padding(
                $render_slug,
                'select_arrow_margin',
                'margin',
                $select_arrow_selector 
            );
            $this->dipi_apply_custom_margin_padding(
                $render_slug,
                'select_arrow_padding',
                'padding',
                $select_arrow_selector
            );
            $this->dipi_apply_custom_style(
                $render_slug,
                'select_arrow_bg_color',
                'background-color',
                $select_arrow_selector
            );
            if ($select_arrow_use_icon === "on") {
                $this->dipi_generate_font_icon_styles($render_slug, 'select_arrow_icon', $select_arrow_selector);
                $this->dipi_apply_custom_style(
                    $render_slug,
                    'select_arrow_icon_color',
                    'color',
                    $select_arrow_selector
                );
                $this->dipi_apply_custom_style(
                    $render_slug,
                    'select_arrow_icon_size',
                    'font-size',
                    $select_arrow_selector
                );
                
            }
            
        } else {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $select_arrow_selector,
                'declaration' => "background-image:none",
            ]);
        }
        $this->dipi_apply_custom_style(
            $render_slug,
            'select_option_bg_color',
            'background-color',
            $select_option_selector
        );
        // Checkbox/Radio Container
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_container_margin',
            'margin',
            $checkbox_radio_container_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_container_padding',
            'padding',
            $checkbox_radio_container_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_container_bg_color',
            'background-color',
            $checkbox_radio_container_selector
        );
        // Checkbox/Radio Option
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_one_option_margin',
            'margin',
            $checkbox_radio_one_option_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_one_option_padding',
            'padding',
            $checkbox_radio_one_option_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_one_option_bg_color',
            'background-color',
            $checkbox_radio_one_option_selector
        );
        // Checkbox/Radio Button
        
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_button_size',
            'width',
            $checkbox_radio_button_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_button_size',
            'height',
            $checkbox_radio_button_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_button_color',
            'accent-color',
            $checkbox_radio_button_selector,
            true
        );

        // Checkbox/Radio Label
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_label_margin',
            'margin',
            $checkbox_radio_label_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'checkbox_radio_label_padding',
            'padding',
            $checkbox_radio_label_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'checkbox_radio_label_bg_color',
            'background-color',
            $checkbox_radio_label_selector
        );
        // Section Field
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'section_field_margin',
            'margin',
            $section_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'section_field_padding',
            'padding',
            $section_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'section_field_bg_color',
            'background-color',
            $section_selector
        );
        // HTML Field
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'html_field_margin',
            'margin',
            $html_field_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'html_field_padding',
            'padding',
            $html_field_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'html_field_bg_color',
            'background-color',
            $html_field_selector
        );
        // Consent_Field Container
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'consent_field_container_margin',
            'margin',
            $consent_field_container_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'consent_field_container_padding',
            'padding',
            $consent_field_container_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'consent_field_container_bg_color',
            'background-color',
            $consent_field_container_selector
        );
        
        // Consent_Field Button
        
        $this->dipi_apply_custom_style(
            $render_slug,
            'consent_field_button_size',
            'width',
            $consent_field_button_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'consent_field_button_size',
            'height',
            $consent_field_button_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'consent_field_button_color',
            'accent-color',
            $consent_field_button_selector,
            true
        );
        // Consent_Field Label
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'consent_field_label_margin',
            'margin',
            $consent_field_label_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'consent_field_label_padding',
            'padding',
            $consent_field_label_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'consent_field_label_bg_color',
            'background-color',
            $consent_field_label_selector
        );
        // Confirm Message
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'confirm_message_margin',
            'margin',
            $confirm_msg_selector 
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'confirm_message_padding',
            'padding',
            $confirm_msg_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'confirm_message_bg_color',
            'background-color',
            $confirm_msg_selector
        );
    }
}

new DIPI_GravityFormsStyler;
