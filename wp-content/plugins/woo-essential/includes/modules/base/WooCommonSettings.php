<?php

class WooCommonSettings {
    

    public static function carousel_modal_toggles ($prefix = '') {
        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'                  => esc_html__('Content', 'dnwooe'),
                    'elements'                      => esc_html__('Elements', 'dnwooe'),
                    'display_setting'               => esc_html__( 'Display', 'dnwooe' ),
                    $prefix . '_settings'           => esc_html__('Carousel Settings', 'dnwooe'),
                    $prefix . '_navigation'         => esc_html__( 'Navigation Settings', 'dnwooe'),
                    $prefix . '_carousel'           => esc_html__( 'Effect Settings', 'dnwooe'),
                    'dnwoo_content_bg'              => esc_html__( 'Content Background', 'dnwooe'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    $prefix . '_image_settings'      => esc_html__( 'Image Settings', 'dnwooe'),
                    $prefix . '_arrow_settings'      => esc_html__( 'Navigation Style', 'dnwooe'),
                ),
            ),
        );
    }

    public static function carousel_settings( $prefix = '', $toggle_slug_prefix = '') {
        return array(
			$prefix . '_auto_height' => array(
                'label'           => esc_html__( 'Auto Height', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable this to automatically adjust the height of the images', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_speed'   => array(
                'label'           => esc_html__( 'Speed', 'dnwooe' ),
                'description'     => esc_html__( 'Adjust the speed of the carousel using the slider below (higher the value, the slider will go slowly and lower the value, the slider will go faster)', 'dnwooe' ),                                                
                'type'            => 'range',
                'option_category' => 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'       => '400',
                'fixed_unit'    => '',
                'validate_unit' => false,
                'unitless'      => true,
                'toggle_slug'   => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_centered' => array(
                'label'       => esc_html__( 'Center slide', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable this to have the active image centered', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'     => 'off',
                'toggle_slug' => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_autoplay_show_hide' => array(
                'label'       => esc_html__( 'Autoplay', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to get the autoplay feature', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'affects'         => array(
                    $prefix . '_autoplay_delay',
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_autoplay_delay' => array(
                'label'           => esc_html__('Autoplay Delay', 'dnwooe'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Adjust the autoplay delay in milliseconds (ms)', 'dnwooe' ),
                'default'         => '5000',
                'depends_show_if' => 'on',
                'toggle_slug'     => $toggle_slug_prefix . '_settings',
                'show_if'         => array(
                    $prefix . '_autoplay_show_hide'  => 'on'
                )
            ),
			$prefix . '_breakpoint' => array(
                'label'            => esc_html__('Slides Per View', 'dnwooe'),
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'description'      => esc_html__( 'Place the number of slides you want to view', 'dnwooe' ),
                'default'          => '3',
                'default_on_front' => '3',
                'mobile_options'   => true,
                'responsive'       => true,
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_spacebetween'   => array(
                'label'           => esc_html__( 'Space Between', 'dnwooe' ),
                'type'            => 'range',
                'description'      => esc_html__( 'Adjust the space between the images', 'dnwooe' ),
                'option_category' => 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 0,
                    'max'  => 300,
                ),
                'default'        => '30',
                'fixed_unit'     => '',
                'validate_unit'  => false,
                'unitless'       => true,
                'mobile_options' => true,
                'responsive'     => true,
                'toggle_slug'    => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_grab' => array(
                'label'           => esc_html__( 'Use Grab Cursor', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control grab cursor', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
			$prefix . '_loop' => array(
                'label'       => esc_html__( 'Loop', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to have the slider slide continuously in a loop', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
            $prefix . '_pause_on_hover' => array(
                'label'       => esc_html__( 'Pause On Hover', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable this to have the slider pause when the cursor hovers on top', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'affects'         => array(
                    $prefix . '_autoplay_delay',
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => $toggle_slug_prefix . '_settings'
            ),
            $prefix . '_keyboard_enable' => array(
                'label'           => esc_html__( 'Keyboard Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control keyboard navigation.', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_navigation'
            ),
            $prefix . '_mousewheel_enable' => array(
                'label'           => esc_html__( 'Mousewheel Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control slide using mousewheel.', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_navigation'
            ),
		);
    }

    public static function carousel_effect($prefix = '', $toggle_slug_prefix = '') {
        return array(
            $prefix . '_slide_shadows' => array(
                'label'           => esc_html__( 'Use Slide Shadows', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'When enabled, it adds a shadow to the back of the images in the slide', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'         => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => $toggle_slug_prefix . '_carousel',
            ),
            $prefix . '_slide_rotate'   => array(
                'label'           => esc_html__( 'Slide Rotate', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Use the slider to add a rotation effect', 'dnwooe' ),                                                
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => $toggle_slug_prefix . '_carousel'
            ),
            $prefix . '_slide_stretch'   => array(
                'label'           => esc_html__( 'Slide Stretch', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the slide stretch using the slider below', 'dnwooe' ),                                                
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => $toggle_slug_prefix . '_carousel'
            ),
            $prefix . '_slide_depth'   => array(
                'label'           => esc_html__( 'Slide Depth', 'dnwooe' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the distance of the images from the center to the surface to the bottom of the slider
                ', 'dnwooe' ),                                                
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => $toggle_slug_prefix . '_carousel'
            ),
        );
    }

    public static function carousel_navigation($prefix = '', $toggle_slug_prefix = '') {
        return array (
            $prefix . '_pagination_type'    => array(
                'label'           => esc_html__('Pagination Type', 'dnwooe'),
                'type'            => 'select',
                'description'     => esc_html__( 'Select types for the slider like a bullet, fraction, or progress bar', 'dnwooe' ),
                'option_category' => 'basic_option',
                'options'         => array(
                    "none"        => esc_html__( 'None',  'dnwooe' ),
                    'bullets'     => esc_html__( 'Bullets',  'dnwooe' ),
                    'fraction'    => esc_html__( 'Fraction', 'dnwooe' ),
                    'progressbar' => esc_html__( 'Progress Bar', 'dnwooe' ),
                ),
                'default'     => 'bullets',
                'toggle_slug' => $toggle_slug_prefix . '_navigation'
            ),
            $prefix . '_pagination_bullets' => array(
                'label'       => esc_html__( 'Dynamic Bullets', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Enable to highlight the bullet for the active image', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_navigation',
                'show_if'          => array(
                    $prefix . '_pagination_type' => 'bullets'
                ),
            ),
            $prefix . '_pagination_clickable' => array(
                'label'       => esc_html__( 'Pagination Clickable', 'dnwooe'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Make the pagination type clickable', 'dnwooe' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => $toggle_slug_prefix . '_navigation',
                'show_if'          => array(
                    $prefix . '_pagination_type' => 'bullets'
                ),
            ),
            $prefix . '_arrow_navigation' => array(
                'label'           => esc_html__( 'Use Arrow Navigation', 'dnwooe'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control the slide using arrows', 'dnwooe' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnwooe' ),
                    'off' => esc_html__( 'No', 'dnwooe' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => $toggle_slug_prefix . '_navigation',
            ),
            $prefix . '_arrow_size'   => array(
                'label'           => esc_html__( 'Font Size', 'dnwooe' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '30',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'tab_slug'        => 'advanced',
                'toggle_slug'     => $toggle_slug_prefix . '_arrow_settings',
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
            $prefix . '_arrow_position'   => array(
				'label'           => esc_html__( 'Arrow Position', 'dnwooe'),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of arrow position', 'dnwooe'),
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => $toggle_slug_prefix . '_arrow_settings',
				'options'       	            => array(
                    'default'                   => esc_html__(	'Default', 'dnwooe' ),
					'inner'                     => esc_html__(	'Inner', 'dnwooe' ),
					'outer'                     => esc_html__(	'Outer', 'dnwooe' ),
					'top-left'                  => esc_html__(	'Top Left', 'dnwooe' ),
					'top-center'                => esc_html__(	'Top Center', 'dnwooe' ),
					'top-right'                 => esc_html__(	'Top Right', 'dnwooe' ),
					'bottom-left'               => esc_html__(	'Bottom Left', 'dnwooe' ),
					'bottom-center'             => esc_html__(	'Bottom Center', 'dnwooe' ),
					'bottom-right'              => esc_html__(	'Bottom Right', 'dnwooe' )

				),
				'default' => 'default',
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
            $prefix . '_arrow_color' => array(
                'label'        => esc_html__( 'Arrow Color', 'dnwooe' ),
                'description'  => esc_html__( 'Choose a color for the Arrows', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#fff',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => $toggle_slug_prefix . '_arrow_settings',
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
            $prefix . '_arrow_background_color' => array(
                'label'        => esc_html__( 'Arrow Background Color', 'dnwooe' ),
                'description'  => esc_html__( 'Choose a background color for the Arrows', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => $toggle_slug_prefix . '_arrow_settings',
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
            $prefix . '_dots_color' => array(
                'label'        => esc_html__( 'Dots Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Dots', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#000',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => $toggle_slug_prefix . '_arrow_settings',
                'show_if'      => array(
                    $prefix . '_pagination_type' => 'bullets'
                    )
            ),
            $prefix . '_dots_active_color' => array(
                'label'        => esc_html__( 'Dots Active Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Active Dot', 'dnwooe' ),
                'type'         => 'color-alpha',
                'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => $toggle_slug_prefix . '_arrow_settings',
                'show_if'      => array(
                    $prefix . '_pagination_type' => 'bullets'
                    )
            ),
            $prefix . '_progressbar_fill_color' => array(
                'label'        => esc_html__( 'Progressbar Fill Color', 'dnwooe' ),
                'description'  => esc_html__( 'Select a color for the Progressbar fill color', 'dnwooe' ),
                'type'         => 'color-alpha',
                'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => $toggle_slug_prefix . '_arrow_settings',
                'show_if'      => array(
                    $prefix . '_pagination_type' => 'progressbar'
                )
            ),
            $prefix . '_arrow_margin'	=> array(
				'label'           		=> esc_html__('Arrow Margin', 'dnwooe'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
            $prefix . '_arrow_padding'	=> array(
				'label'           		=> esc_html__('Arrow Padding', 'dnwooe'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
                'show_if'          => array(
                    $prefix . '_arrow_navigation' => 'on',
				),
            ),
        );
    }
}

new WooCommonSettings;