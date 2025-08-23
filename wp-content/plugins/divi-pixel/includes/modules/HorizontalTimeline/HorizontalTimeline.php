<?php
class DIPI_HorizontalTimeline extends DIPI_Builder_Module {

	public $slug       = 'dipi_horizontal_timeline';
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'dipi_horizontal_timeline_item';

	protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/horizontal-timeline',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
	);

	public function init() 
	{
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__( 'Pixel Horizontal Timeline', 'dipi-divi-pixel' );
		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'card_arrow_settings' => esc_html__('Card Arrow', 'dipi-divi-pixel'),
          'carousel' => esc_html__('Carousel Settings', 'dipi-divi-pixel'),
				),
			),      
			'advanced'   => array(
				'toggles' => array(
          'layout_settings' => esc_html__( 'Layout', 'dipi-divi-pixel' ),
          'ribbon_icon_settings' => esc_html__( 'Timeline Icon', 'dipi-divi-pixel' ),
          'card_arrow_settings' => esc_html__( 'Card Arrow', 'dipi-divi-pixel' ),
          'timeline_line_settings' => esc_html__( 'Timeline Line', 'dipi-divi-pixel' ),
          'timeline_item_text' => [
            'sub_toggles' => [
              'title' => [
                'name' => 'Title',
              ],
              'desc' => [
                  'name' => 'Desc',
              ],
              'ribbon' => [
                  'name' => 'Ribbon',
              ],
            ],
            'tabbed_subtoggles' => true,
            'title' => esc_html__('Timeline Item Text', 'dipi-divi-pixel'),
          ],
          'timeline_item' => esc_html__('Timeline Item', 'dipi-divi-pixel'),
          'navigation' => esc_html__('Navigation', 'dipi-divi-pixel'),
          'pagination' => esc_html__('Pagination', 'dipi-divi-pixel'),
				),
			)
    );
    /**
		 * Filter generated module selector
		 *
		 * @param string $selector Generated selector.
		 * @param string $module   Module name.
		 *
		 * @return string Custom selector.
		 */
		add_filter( 'et_pb_set_style_selector', function ( $selector, $module ) {
			// Bail early if current module is not Horizontal Timeline module.
			if ( 'dipi_horizontal_timeline' !== $module && 'dipi_horizontal_timeline_item' !== $module) {
				return $selector;
			}
	
			return str_replace( '#et-boc .et-l ', '', $selector );
		}, 10, 2 ); 
	}

	public function get_fields() {
    $fields = [];
    $et_accent_color = et_builder_accent_color();
		$start_position = array();
		$start_position['top'] = esc_html__('Top', 'dipi-divi-pixel');
		$start_position['bottom'] = esc_html__('Bottom', 'dipi-divi-pixel');

    $fields['show_card_arrow'] =[
      'label'            => esc_html__( 'Show Card Arrow', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Show Card Arrow', 'dipi-divi-pixel' ),
      'type'             => 'yes_no_button',
      'options'          => array(
        'off' => esc_html__('No', 'dipi-divi-pixel'),
        'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
      ),
      'toggle_slug'      => 'card_arrow_settings',
      'default_on_front' => 'on',
    ];
    $fields['card_arrow_align'] =[
      'label'            => esc_html__( 'Card Arrow Alignment', 'dipi-divi-pixel' ),
      'type'             => 'select',
      'option_category'  => 'layout',
      'options'          => array(
        'start'           => esc_html__( 'Left', 'dipi-divi-pixel' ),
        'center'          => esc_html__( 'Center', 'dipi-divi-pixel' ),
        'end'          => esc_html__( 'Right', 'dipi-divi-pixel' ),
      ),
      'toggle_slug'      => 'card_arrow_settings',
      'description'      => esc_html__( 'Layout', 'dipi-divi-pixel' ),
      'default_on_front' => 'center',
      'default_tablet' => 'center',
      'default_phone' => 'center',
      'default'        => 'phone',
      'show_if'       => [
        'show_card_arrow' => 'on'
      ],
      'responsive'      => false,              
      'mobile_options'   => false,
    ];     
    $fields['columns'] = [
      'label' => esc_html('Number of Columns', 'dipi-divi-pixel'),
      'type' => 'range',
      'default' => '4',
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
        'label' => esc_html('Spacing', 'dipi-divi-pixel'),
        'type' => 'range',
        'default' => '30',
        'range_settings' => [
            'min' => '0',
            'max' => '100',
            'step' => '1',
        ],
        'unitless' => true,
        'mobile_options' => true,
        'responsive' => true,
        'toggle_slug' => 'carousel',
    ];
    $fields['container_padding'] = [
      'label' => esc_html('Container Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'default' => '30px|30px|30px|30px',
      'mobile_options' => true,
      'responsive' => true,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'margin_padding',
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
    $fields["show_lightbox"] = [
        'label' => esc_html__('Open Image in Lightbox', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'default' => 'on',
        'options' => array(
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ),
        'toggle_slug' => 'carousel',
        'description' => esc_html__('Whether or not to show lightbox.', 'dipi-divi-pixel'),
        'mobile_options' => true,
    ];
    $fields['navigation'] = [
        'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'options' => [
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'carousel',
        'mobile_options' => true,
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
        'mobile_options' => true,
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
    $fields['layout'] =[
      'label'            => esc_html__( 'Layout', 'dipi-divi-pixel' ),
      'type'             => 'select',
      'option_category'  => 'layout',
      'options'          => array(
        'top'           => esc_html__( 'Top', 'dipi-divi-pixel' ),
        'bottom'          => esc_html__( 'Bottom', 'dipi-divi-pixel' ),
        'mixed'          => esc_html__( 'Mixed', 'dipi-divi-pixel' )
      ),
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'layout_settings',
      'description'      => esc_html__( 'Layout', 'dipi-divi-pixel' ),
      'default_on_front' => 'mixed',
      'default_tablet' => 'bottom',
      'default_phone' => 'bottom',
      'responsive'      => true,              
      'mobile_options'   => true,
      'hover'           => 'tabs',        
    ];      
    $fields['start_position'] = [
      'label'            => esc_html__( 'Start Position', 'dipi-divi-pixel' ),
      'type'             => 'select',
      'option_category'  => 'layout',
      'options'          => $start_position,
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'layout_settings',
      'description'      => esc_html__( 'Start position of first timeline item', 'dipi-divi-pixel' ),
      'default_on_front' => 'top',
      'mobile_options'   => false,
      'depends_show_if'  => 'mixed',
      'depends_on'       => array(
        'layout',
      ),
    ];

    $fields['line_area_size'] = [
      'label'           => esc_html__( 'Line Area Size ', 'dipi-divi-pixel' ),
      'description'     => esc_html__( 'Adjust the size of the line area.', 'dipi-divi-pixel' ),
      'type'            => 'range',
      'option_category' => 'layout',
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'timeline_line_settings',
      'mobile_options'  => true,
      'sticky'          => true,
      'validate_unit'   => true,
      'default'         => '60px',
      'default_unit'    => 'px',
      'range_settings'  => array(
        'min'  => '0',
        'max'  => '1024',
        'step' => '1',
      ),
      'responsive'      => true,
      'hover'           => 'tabs',
    ];
    $fields['timeline_line_width'] = [
      'label'            => esc_html__( 'Default Line Width', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Increasing the width of the default line will increase its size/thickness.', 'dipi-divi-pixel' ),
      'type'             => 'range',
      'option_category'  => 'configuration',
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'timeline_line_settings',
      'default'          => '2px',
      'default_unit'     => 'px',
      'default_on_front' => '2px',
      'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
      'range_settings'   => array(
        'min'  => '0',
        'max'  => '100',
        'step' => '1',
      ),
      'sticky'           => true,
      'hover'            => 'tabs',
    ];
    $fields['timeline_line_style'] = [
      'label'           => esc_html__( 'Default Line Style', 'dipi-divi-pixel' ),
      'description'     => esc_html__( 'Select the shape of the timeline line.', 'dipi-divi-pixel' ),
      'type'            => 'select',
      'option_category' => 'layout',
      'options'         => et_builder_get_border_styles(),
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'timeline_line_settings',
      'default'         => 'solid',
      'hover'           => 'tabs',
    ];
    $fields['timeline_line_color'] = [
      'default'         => $et_accent_color,
      'label'           => esc_html__( 'Default Line Color', 'dipi-divi-pixel' ),
      'type'            => 'color-alpha',
      'description'     => esc_html__( 'Here you can define a custom color for the default line.', 'dipi-divi-pixel' ),
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'timeline_line_settings',
      'default'         => '#F2F3F3',
      'hover'           => 'tabs',
      'sticky'          => true,
    ];
    $fields['use_active_line'] = [
      'label'            => esc_html__( 'Use Active Line', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Use active line which will be animated while scrolling.', 'dipi-divi-pixel' ),
      'type'             => 'yes_no_button',
      'options'          => array(
        'off' => esc_html__('No', 'dipi-divi-pixel'),
        'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
      ),
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'timeline_line_settings',
      'default_on_front' => 'on',
    ];
    $fields['timeline_active_line_width'] = [
      'label'            => esc_html__( 'Active Line Width', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Increasing the width of the active line will increase its size/thickness.', 'dipi-divi-pixel' ),
      'type'             => 'range',
      'option_category'  => 'configuration',
      'show_if'          => array(
        'use_active_line' => 'on'
      ),
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'timeline_line_settings',
      'default'          => '2px',
      'default_unit'     => 'px',
      'default_on_front' => '2px',
      'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
      'range_settings'   => array(
        'min'  => '0',
        'max'  => '100',
        'step' => '1',
      ),
      'sticky'           => true,
      'hover'            => 'tabs',
    ];
    $fields['timeline_active_line_style'] = [
      'label'           => esc_html__( 'Active Line Style', 'dipi-divi-pixel' ),
      'description'     => esc_html__( 'Select the shape of the active line.', 'dipi-divi-pixel' ),
      'type'            => 'select',
      'option_category' => 'layout',
      'options'         => et_builder_get_border_styles(),
      'show_if'          => array(
        'use_active_line' => 'on'
      ),
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'timeline_line_settings',
      'default'         => 'solid',
      'hover'           => 'tabs',
    ];
    $fields['timeline_active_line_color'] = [
      'default'         => $et_accent_color,
      'label'           => esc_html__( 'Active Line Color', 'dipi-divi-pixel' ),
      'type'            => 'color-alpha',
      'description'     => esc_html__( 'Here you can define a custom color for the active line.', 'dipi-divi-pixel' ),
      'show_if'          => array(
        'use_active_line' => 'on'
      ),
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'timeline_line_settings',
      'default'         => '#2C3D49',
      'hover'           => 'tabs',
      'sticky'          => true,
    ];
    $fields['timeline_active_horizontal_pos'] = [
      'label'            => esc_html__( 'Active Horizontal Position', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Set positions where card will be activated', 'dipi-divi-pixel' ),
      'type'             => 'range',
      'option_category'  => 'configuration',
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'timeline_line_settings',
      'default'          => '50%',
      'default_unit'     => '%',
      'default_on_front' => '50%',
      'allowed_units'    => array( 'px', '%' ),
      'range_settings'   => array(
        'min'  => '0',
        'max'  => '100',
        'step' => '1',
      ),
      'sticky'           => true,
      'hover'            => 'tabs',
    ];
    $fields['card_arrow_size'] = [
      'label'            => esc_html__( 'Card Arrow Size', 'dipi-divi-pixel' ),
      'description'      => esc_html__( 'Card Arrow Size', 'dipi-divi-pixel' ),
      'type'             => 'range',
      'option_category'  => 'configuration',
      'tab_slug'         => 'advanced',
      'toggle_slug'      => 'card_arrow_settings',
      'default'          => '12px',
      'default_unit'     => '12x',
      'default_on_front' => '12px',
      'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
      'range_settings'   => array(
        'min'  => '0',
        'max'  => '500',
        'step' => '1',
      ),
      'mobile_options'   => true,
      'sticky'           => true,
      'hover'            => 'tabs',
      'show_if'          => array(
        'show_card_arrow' => 'on'
      ),
    ];
    $fields['card_arrow_color'] = [
      'default'         => $et_accent_color,
      'label'           => esc_html__( 'Card Arrow Color', 'dipi-divi-pixel' ),
      'type'            => 'color-alpha',
      'description'     => esc_html__( 'Here you can define a custom color for card arrow.', 'dipi-divi-pixel' ),
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'card_arrow_settings',
      'default'         => '#F2F3F3',
      'hover'           => 'tabs',
      'sticky'          => true,
      'show_if'          => array(
        'show_card_arrow' => 'on'
      ),
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
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_prev_icon'] = [
      'label' => esc_html__('Select Previous Nav icon', 'dipi-divi-pixel'),
      'type' => 'select_icon',
      'class' => array('et-pb-font-icon'),
      'default' => '8',
      'show_if' => [
        'navigation' => 'on',
        'navigation_prev_icon_yn' => 'on'
      ],
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
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_next_icon'] = [
      'label' => esc_html__('Select Next Nav icon', 'dipi-divi-pixel'),
      'type' => 'select_icon',
      'class' => array('et-pb-font-icon'),
      'default' => '9',
      'show_if' => [
        'navigation' => 'on',
        'navigation_next_icon_yn' => 'on'
      ],
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
      'default' => 30,
      'validate_unit' => false,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'navigation',
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_padding'] = [
      'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
      'type' => 'range',
      'range_settings' => [
          'min' => '1',
          'max' => '100',
          'step' => '1',
      ],
      'default' => 30,
      'validate_unit' => false,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'navigation',
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_color'] = [
      'label' => esc_html('Arrow Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'default' => et_builder_accent_color(),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'navigation',
      'hover' => 'tabs',
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_bg_color'] = [
      'label' => esc_html('Arrow Background', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'navigation',
      'hover' => 'tabs',
      'show_if' => [
        'navigation' => 'on',
      ],
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
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_position_left'] = [
      'label' => esc_html('Left Navigation Postion', 'dipi-divi-pixel'),
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
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['navigation_position_right'] = [
      'label' => esc_html('Right Navigation Postion', 'dipi-divi-pixel'),
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
      'show_if' => [
        'navigation' => 'on',
      ],
    ];

    $fields['pagination_position'] = [
      'label' => esc_html('Pagination Postion', 'dipi-divi-pixel'),
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
      'label' => esc_html('Pagination Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'default' => '#d8d8d8',
      'show_if' => ['pagination' => 'on'],
      'tab_slug' => 'advanced',
      'toggle_slug' => 'pagination',
    ];

    $fields['pagination_active_color'] = [
      'label' => esc_html('Pagination Active Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'default' => et_builder_accent_color(),
      'show_if' => ['pagination' => 'on'],
      'tab_slug' => 'advanced',
      'toggle_slug' => 'pagination',
    ];

    return $fields;
	}
  public function get_custom_css_fields_config()
  {

      $fields = [];

      $fields['img'] = [
          'label' => esc_html__('Image', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_image',
      ];

      $fields['icon'] = [
          'label' => esc_html__('Icon', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_timeline_font_icon',
      ];

      $fields['title'] = [
          'label' => esc_html__('Title', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_header',
      ];

      $fields['description'] = [
          'label' => esc_html__('Description', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_description',
      ];

      $fields['button'] = [
          'label' => esc_html__('Button', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_button',
      ];

      $fields['navigation'] = [
          'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
          'selector' => 'div%%order_class%%.et_pb_module.dipi_horizontal_timeline div.dipi-carousel-main .swiper-arrow-button',
          
      ];
      
      $fields['prev_main_navigation'] = [
          'label'    => esc_html__('Prev Navigation', 'dipi-divi-pixel'),
          'selector' => 'div%%order_class%%.et_pb_module.dipi_horizontal_timeline div.dipi-carousel-main .swiper-arrow-button.swiper-button-prev',
      ];
      $fields['next_thumbs_navigation'] = [
          'label'    => esc_html__('Next Navigation', 'dipi-divi-pixel'),
          'selector' => 'div%%order_class%%.et_pb_module.dipi_horizontal_timeline div.dipi-carousel-main .swiper-arrow-button.swiper-button-next',
      ];

      $fields['pagination'] = [
          'label' => esc_html__('Pagination', 'dipi-divi-pixel'),
          'selector' => 'div%%order_class%%.et_pb_module.dipi_horizontal_timeline div.dipi-carousel-main .swiper-pagination',
      ];

      $fields['active_slide'] = [
          'label' => esc_html__('Active Slide', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-slide-active',
      ];

      $fields['not_active_slide'] = [
          'label' => esc_html__('Not Active Slides', 'dipi-divi-pixel'),
          'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_horizontal_timeline_item:not(.swiper-slide-active)',
      ];

      return $fields;
  }
  public function get_advanced_fields_config()
  {
      $advanced_fields = [];
      // $advanced_fields['fonts'] = false;
      $advanced_fields['text'] = [
        'css' => [
            'margin' => '%%order_class%%.dipi_horizontal_timeline',
            'padding' => '%%order_class%%.dipi_horizontal_timeline',
        ],
      ];
      $advanced_fields['text_shadow'] = [
        'css' => [
            'margin' => '%%order_class%%.dipi_horizontal_timeline',
            'padding' => '%%order_class%%.dipi_horizontal_timeline',
        ],
      ];

      $advanced_fields['margin_padding'] = [
          'css' => [
              'margin' => '%%order_class%%.dipi_horizontal_timeline',
              'padding' => '%%order_class%%.dipi_horizontal_timeline',
              'important' => 'all',
          ],
      ];


      $advanced_fields["fonts"]["title"] = [
          'label' => esc_html__('Title', 'dipi-divi-pixel'),
          'css' => [
              'main' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_htl_item_header",
          ],
          'font_size' => [
              'default' => '22px',
          ],
          'line_height' => [
              'range_settings' => [
                  'default' => '1em',
                  'min' => '1',
                  'max' => '3',
                  'step' => '0.1',
              ],
          ],
          'important' => 'all',
          'hide_text_align' => true,
          'toggle_slug' => 'timeline_item_text',
          'sub_toggle' => 'title',
      ];

      $advanced_fields["fonts"]["desc"] = [
          'label' => esc_html__('Description', 'dipi-divi-pixel'),
          'css' => [
              'main' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_htl_item_description",
          ],
          'font_size' => [
              'default' => '15px',
          ],
          'line_height' => [
              'range_settings' => [
                  'default' => '1em',
                  'min' => '1',
                  'max' => '3',
                  'step' => '.1',
              ],
          ],
          'important' => 'all',
          'hide_text_align' => true,
          'toggle_slug' => 'timeline_item_text',
          'sub_toggle' => 'desc',
      ];
      $advanced_fields["fonts"]["ribbon"] = [
        'label' => esc_html__('Ribbon Text', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_timeline_ribbon_text",
            'line_height' => "%%order_class%% .dipi_horizontal_timeline_item span.dipi_timeline_ribbon_text",
            'text_align' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_timeline_ribbon_text",
            'text_shadow' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_timeline_ribbon_text",
            'important' => 'all',
        ),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'timeline_item_text',
        'sub_toggle' => 'ribbon',
        'hide_text_align' => true,
      ];
      $advanced_fields['button']["button"] = [
          'label' => esc_html__('Button', 'dipi-divi-pixel'),
          'css' => [
              'main' => "%%order_class%% .dipi_htl_item_button",
              'alignment' => "%%order_class%% .et_pb_button_wrapper",
          ],
          'use_alignment' => false,
          'hide_icon' => true,
          'box_shadow' => [
              'css' => [
                  'main' => "%%order_class%% .dipi_htl_item_button",
                  'important' => true,
              ],
          ],
          'margin_padding' => [
              'css' => [
                  'main' => "%%order_class%% .dipi_htl_item_button",
                  'important' => 'all',
              ],
          ],
      ];

      $advanced_fields["borders"]["default"] = [
          'css' => [
              'main' => [
                  'border_radii' => "%%order_class%%",
                  'border_styles' => "%%order_class%%",
              ],
          ],
      ];

      $advanced_fields["borders"]["item"] = [
          'css' => [
              'main' => [
                  'border_radii' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_htl_item_card",
                  'border_styles' => "%%order_class%% .dipi_horizontal_timeline_item .dipi_htl_item_card",
              ],
          ],
          'toggle_slug' => 'timeline_item',
      ];

      $advanced_fields["box_shadow"]["default"] = [
          'css' => [
              'main' => "%%order_class%%.dipi_horizontal_timeline .dipi_horizontal_timeline_item .dipi_htl_item_card",
              'hover' => '%%order_class%%.dipi_horizontal_timeline .dipi_horizontal_timeline_item:hover .dipi_htl_item_card',
          ],
          'toggle_slug' => 'timeline_item',
      ];

      return $advanced_fields;
  }
  public function get_custom_style($slug_value, $type, $important) {
		return  sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important? ' !important' : '');
	}
	public function get_changed_prop_value($slug, $conv_matrix) {
		if(array_key_exists($this->props[$slug], $conv_matrix))
			$this->props[$slug] =  $conv_matrix[$this->props[$slug]];
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
  public function apply_custom_style_for_phone(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
		}
		if ($wrap_func !== '') {
      $slug_value = "$wrap_func($slug_value)";
      $slug_value_tablet = "$wrap_func($slug_value_tablet)";
      $slug_value_phone = "$wrap_func($slug_value_phone)";
    }

	  if (isset($slug_value_phone)
			&& !empty($slug_value_phone)) {
			ET_Builder_Element::set_style($function_name, array(
				'selector' => $class,
				'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
  }
  
  public function apply_custom_style_for_tablet(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
		}
		if ($wrap_func !== '') {
      $slug_value = "$wrap_func($slug_value)";
      $slug_value_tablet = "$wrap_func($slug_value_tablet)";
      $slug_value_phone = "$wrap_func($slug_value_phone)";
    }

    if (isset($slug_value_tablet)
    && !empty($slug_value_tablet)) {
    ET_Builder_Element::set_style($function_name, array(
      'selector' => $class,
      'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
      'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
    ));
    }
  }
  
  public function apply_custom_style_for_desktop(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
    
    $slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
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
  }

	public function apply_custom_style(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
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
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
  
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
				'media_query' => ET_Builder_Element::get_media_query('max_width_767')
			));
		}
  }
  
  public function get_transition_fields_css_props() {
    $fields               = parent::get_transition_fields_css_props();
    $fields['timeline_line_width'] = array( 'border-width' => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line' );
    $fields['timeline_line_color'] = array( 'border-color' => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line' );
    $fields['timeline_line_style'] = array( 'border-style' => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line' );
    
    return $fields;
  }
  public function get_carousel_content()
  {
      return $this->content;
  }
  public function apply_css($render_slug) {
    $this->apply_custom_margin_padding(
      $render_slug,
      'container_padding',
      'padding',
      '%%order_class%%.dipi_horizontal_timeline .dipi_htl_container'
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'line_area_size',
        'selector'       => '%%order_class%%.dipi_horizontal_timeline .dipi_horizontal_timeline_item .ribbon-ico-wrap, %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_bottom .dipi_horizontal_timeline_item .ribbon-ico-wrap, %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_top .dipi_horizontal_timeline_item .ribbon-ico-wrap',
        'css_property'   => 'height',
        'render_slug'    => $render_slug,
        'type'           => 'range'
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'line_area_size',
        'selector'       => '%%order_class%%.dipi_horizontal_timeline .dipi_horizontal_timeline_item .ribbon-ico-wrap,
              %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_bottom .dipi_horizontal_timeline_item .ribbon-ico-wrap,
              %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_top .dipi_horizontal_timeline_item .ribbon-ico-wrap',
        'css_property'   => 'max-height',
        'render_slug'    => $render_slug,
        'type'           => 'range',
        'important'     => true
      )
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'line_area_size',
      'top',
      '%%order_class%% .dipi_htl_layout_bottom .swiper-arrow-button,
      %%order_class%% .dipi_htl_layout_bottom .dipi-htl-line__active,
      %%order_class%% .dipi_htl_layout_bottom .dipi-htl-line
      ',
      false,
      0.5,
      'px'
	  );
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'line_area_size',
      'top',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .swiper-arrow-button,
      %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-line__active,
      %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-line
      ',
      false,
      0.5,
      'px'
      );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'line_area_size',
      'top',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .swiper-arrow-button,
      div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-line__active,
      div%%order_class%%.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-line
      ',
      true,
      0.5,
      'px'
      );
    
    $this->apply_custom_style(
      $this->slug,
      'line_area_size',
      'bottom',
      '%%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_top .swiper-arrow-button,
      %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_top .dipi-htl-line__active,
      %%order_class%%.dipi_horizontal_timeline .dipi_htl_layout_top .dipi-htl-line',
      false,
      0.5,
      'px'
    );
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'line_area_size',
      'bottom',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .swiper-arrow-button,
      %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-line__active,
      %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-line',
      false,
      0.5,
      'px'
      );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'line_area_size',
      'bottom',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_phone .swiper-arrow-button,
      div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-line__active,
      div%%order_class%%.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-line',
      true,
      0.5,
      'px'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%% .dipi_htl_layout_top .dipi-htl-line
      ',
      false,
      0.5,
      'px',
      'translateY'
    );
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi-htl-line
      ',
      false,
      0.5,
      'px',
      'translateY'
      );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_line_width',
      'transform',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-line
      ',
      true,
      0.5,
      'px',
      'translateY'
    );

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_width',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
				'type'                            => 'range'
			)
    );
    
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_color',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line',
				'css_property'                    => 'border-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color',
			)
    );

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_style',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line',
				'css_property'                    => 'border-style',
				'render_slug'                     => $render_slug,
				'type'                            => 'select'
			)
    );
    /* Active line */
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_width',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line__active',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
				'type'                            => 'range'
			)
    );
    
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_color',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line__active',
				'css_property'                    => 'border-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color'
			)
    );

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_style',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi-htl-line__active',
				'css_property'                    => 'border-style',
				'render_slug'                     => $render_slug,
				'type'                            => 'select'
			)
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%% .dipi_htl_layout_top .dipi-htl-line__active
      ',
      false,
      0.5,
      'px',
      'translateY'
	  );
	
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi-htl-line__active
      ',
      false,
      0.5,
      'px',
      'translateY'
	  );

    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-line__active
      ',
      true,
      0.5,
      'px',
      'translateY'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%% .dipi_htl_layout_bottom .dipi-htl-line
      ',
      false,
      -0.5,
      'px',
      'translateY'
    );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi-htl-line
      ',
      false,
      -0.5,
      'px',
      'translateY'
    );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_line_width',
      'transform',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-line
      ',
      true,
      -0.5,
      'px',
      'translateY'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%% .dipi_htl_layout_bottom .dipi-htl-line__active
      ',
      false,
      -0.5,
      'px',
      'translateY'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi-htl-line__active
      ',
      false,
      -0.5,
      'px',
      'translateY'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-line__active
      ',
      true,
      -0.5,
      'px',
      'translateY'
	  );
    /* Card Arrow */
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_color',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_card-wrap:after',
				'css_property'                    => 'border-bottom-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color'
			)
    );
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_align',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_container',
				'css_property'                    => 'align-items',
				'render_slug'                     => $render_slug,
				'type'                            => 'select'
			)
    );
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_color',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_card-wrap:after',
				'css_property'                    => 'border-top-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color'
			)
    );
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_size',
				'selector'                        => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_item_card-wrap:after',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
        'type'                            => 'range',
        'important'                       => true
			)
    );
    $this->apply_custom_style_for_desktop(
      $this->slug,
      'card_arrow_size',
      'top',
      '%%order_class%% .dipi_htl_layout_bottom .dipi_htl_container .dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%% .dipi_htl_layout_mixed.startpos-bottom .dipi_htl_container .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%% .dipi_htl_layout_mixed.startpos-top .dipi_htl_container .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'card_arrow_size',
      'top',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-bottom .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-top .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'card_arrow_size',
      'top',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       div%%order_class%%.et_pb_module.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       div%%order_class%%.et_pb_module.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_phone.startpos-bottom .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       div%%order_class%%.et_pb_module.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_phone.startpos-top .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      true,
      -1,
      'px'
    );
    
    $this->apply_custom_style_for_desktop(
      $this->slug,
      'card_arrow_size',
      'bottom',
      '%%order_class%% .dipi_htl_layout_top .dipi_htl_container .dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%% .dipi_htl_layout_mixed.startpos-bottom .dipi_htl_container .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%% .dipi_htl_layout_mixed.startpos-top .dipi_htl_container .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'card_arrow_size',
      'bottom',
      '%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-bottom .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       %%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-top .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'card_arrow_size',
      'bottom',
      'div%%order_class%%.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
      div%%order_class%%.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       div%%order_class%%.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-bottom .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
       div%%order_class%%.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-top .dipi_htl_container .dipi-htl-items .dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
      ',
      true,
      -1,
      'px'
	  );
    /* Carousel Styling */
    $container_class = "%%order_class%% .dipi_htl_container";
    $navigation_position_left_class = "%%order_class%% .swiper-button-prev, %%order_class%%:hover .swiper-button-prev.swiper-arrow-button.show_on_hover";
    $navigation_position_right_class = "%%order_class%% .swiper-button-next, %%order_class%%:hover .swiper-button-next.swiper-arrow-button.show_on_hover";
    $navigation_position_left_area_class = "%%order_class%% .swiper-button-prev.swiper-arrow-button.show_on_hover:before";
    $navigation_position_right_area_class = "%%order_class%% .swiper-button-next.swiper-arrow-button.show_on_hover:before";

    $important = false;

    $navigation_hover_selector = '%%order_class%%.dipi_horizontal_timeline .swiper-arrow-button:hover:after';
    $navigation_hover_bg_selector = '%%order_class%%.dipi_horizontal_timeline .swiper-arrow-button:hover';

    if(!isset($this->props['border_style_all_item']) || empty($this->props['border_style_all_item'])) {
        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_carousel_child",
            'declaration' => "border-style: solid;"
        ]);
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
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_left_class,
            'declaration' => sprintf('left: %1$s !important;', $navigation_position_left_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    /* Left navigation area */
    if ('' !== $navigation_position_left && $navigation_position_left < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_left_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left)
        ));
    }

    if ('' !== $navigation_position_left_tablet && $navigation_position_left_responsive_status && $navigation_position_left_tablet < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_left_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status && $navigation_position_left_phone < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_left_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
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
            'declaration' => sprintf('right: %1$s !important;', $navigation_position_right)
        ));
    }

    if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_right_class,
            'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_right_class,
            'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    if ('' !== $navigation_position_right && $navigation_position_right < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_right_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right)
        ));
    }

    if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status && $navigation_position_right_tablet < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_right_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status && $navigation_position_right_phone < 0) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_position_right_area_class,
            'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    if ('' !== $this->props['navigation_color']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
            'declaration' => sprintf('color: %1$s!important;', $this->props['navigation_color'])
        ));
    }

    $navigation_class = "%%order_class%%  .swiper-arrow-button";
    $navigation = $this->props['navigation'];
    $navigation_tablet = $this->props['navigation_tablet'];
    $navigation_phone = $this->props['navigation_phone'];
    $navigation_last_edited = $this->props['navigation_last_edited'];
    $navigation_responsive_status = et_pb_get_responsive_status($navigation_last_edited);

    if ('' !== $navigation) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_class,
            'declaration' => sprintf(
                'display: %1$s !important;', 
                $navigation === "on" ? "flex" : "none"
            ),
        ));
    }

    if ('' !== $navigation_tablet && $navigation_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_class,
            'declaration' => sprintf(
                'display: %1$s !important;', 
                $navigation_tablet === "on" ? "flex" : "none"
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $navigation_phone && $navigation_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $navigation_class,
            'declaration' => sprintf(
                'display: %1$s !important;',
                $navigation_phone=== "on" ? "flex" : "none")
            ,
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    $pagination_class = "%%order_class%%  .swiper-pagination";
    $pagination = $this->props['pagination'];
    $pagination_tablet = $this->props['pagination_tablet'];
    $pagination_phone = $this->props['pagination_phone'];
    $pagination_last_edited = $this->props['pagination_last_edited'];
    $pagination_responsive_status = et_pb_get_responsive_status($pagination_last_edited);

    if ('' !== $pagination) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $pagination_class,
            'declaration' => sprintf(
                'display: %1$s !important;', 
                $pagination === "on" ? "block" : "none"
            )
        ));
    }

    if ('' !== $pagination_tablet && $pagination_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $pagination_class,
            'declaration' => sprintf(
                'display: %1$s !important;', 
                $pagination_tablet === "on" ? "block" : "none"
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
    }

    if ('' !== $pagination_phone && $pagination_responsive_status) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $pagination_class,
            'declaration' => sprintf(
                'display: %1$s !important;',
                $pagination_phone=== "on" ? "block" : "none")
            ,
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    $this->apply_custom_style_for_hover(
        $render_slug,
        'navigation_color',
        'color',
        $navigation_hover_selector,
        true
    );
    if ('' !== $this->props['navigation_bg_color']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf('background: %1$s!important;', $this->props['navigation_bg_color'])
        ));
    }

    $this->apply_custom_style_for_hover(
        $render_slug,
        'navigation_bg_color',
        'background',
        $navigation_hover_bg_selector,
        true
    );

    if ('' !== $this->props['navigation_size']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf(
                'width: %1$spx !important; height: %1$spx !important;',
                $this->props['navigation_size'])
        ));
    }

    if ('' !== $this->props['navigation_size']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
            'declaration' => sprintf('font-size: %1$spx !important;', $this->props['navigation_size'])
        ));
    }

    if ('' !== $this->props['navigation_padding']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf(
                'padding: %1$spx !important;',
                $this->props['navigation_padding'])
        ));
    }

    if ('on' == $this->props['navigation_circle']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => 'border-radius: 50% !important;'
        ));
    }

    if ('' !== $this->props['pagination_color']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-pagination-bullet',
            'declaration' => sprintf(
                'background: %1$s!important;', $this->props['pagination_color'])
        ));
    }

    if ('' !== $this->props['pagination_active_color']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .swiper-pagination-bullet.swiper-pagination-bullet-active',
            'declaration' => sprintf(
                'background: %1$s!important;', $this->props['pagination_active_color'])
        ));
    }

    if ('' !== $this->props['pagination_position']) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi_htl_container-horizontal > .swiper-pagination-bullets, %%order_class%% .swiper-pagination-fraction, %%order_class%% .swiper-pagination-custom',
            'declaration' => sprintf(
                'bottom: %1$spx !important;',
                $this->props['pagination_position'])
        ));
    }


    ET_Builder_Element::set_style($render_slug, array(
        'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi-carousel-main .dipi_htl_container-3d .swiper-slide-shadow-left',
        'declaration' => 'background-image: none'
    ));

    ET_Builder_Element::set_style($render_slug, array(
        'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi-carousel-main .dipi_htl_container-3d .swiper-slide-shadow-right',
        'declaration' => 'background-image: none'
    ));

    ET_Builder_Element::set_style($render_slug, array(
        'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi-carousel-main .dipi_htl_container-3d .swiper-slide-shadow-top',
        'declaration' => 'background-image: none'
    ));

    ET_Builder_Element::set_style($render_slug, array(
        'selector' => '%%order_class%%.dipi_horizontal_timeline .dipi-carousel-main .dipi_htl_container-3d .swiper-slide-shadow-bottom',
        'declaration' => 'background-image: none'
    ));

  }
	public function render( $attrs, $content, $render_slug ) {
    wp_enqueue_script('dipi_horizontal_timeline_public');
    wp_enqueue_style('dipi_swiper');
    wp_enqueue_style('magnific-popup');

    $this->apply_css($render_slug);
    $get_carousel_content = $this->get_carousel_content();
    $speed = $this->props['speed'];
    $loop = $this->props['loop'];
    $centered = $this->props['centered'];
    $autoplay = $this->props['autoplay'];
    $autoplay_speed = $this->props['autoplay_speed'];
    $pause_on_hover = $this->props['pause_on_hover'];
    $timeline_active_horizontal_pos = $this->props['timeline_active_horizontal_pos'];
    $navigation = $this->props['navigation'];
    $navigation_values = et_pb_responsive_options()->get_property_values($this->props, 'navigation');
    $navigation_tablet = !empty($navigation_values['tablet']) ? $navigation_values['tablet'] : $navigation;
    $navigation_phone = !empty($navigation_values['phone']) ? $navigation_values['phone'] : $navigation_tablet;
    $navigation_on_hover = $this->props['navigation_on_hover'];
    $pagination = $this->props['pagination'];
    $dynamic_bullets = $this->props['dynamic_bullets'];
    $order_class = self::get_module_order_class($render_slug);
    $order_number = str_replace('_', '', str_replace($this->slug, '', $order_class));
    $data_next_icon = $this->props['navigation_next_icon'];
    $data_prev_icon = $this->props['navigation_prev_icon'];
    
    $show_lightbox = $this->props['show_lightbox'];
    $show_lightbox_values = et_pb_responsive_options()->get_property_values($this->props, 'show_lightbox');

    $show_lightbox_tablet = isset($show_lightbox_values['tablet']) && !empty($show_lightbox_values['tablet']) ? $show_lightbox_values['tablet'] : $show_lightbox;
    $show_lightbox_phone = isset($show_lightbox_values['phone']) && !empty($show_lightbox_values['phone']) ? $show_lightbox_values['phone'] : $show_lightbox_tablet;

    $show_lightboxclasses = ($show_lightbox === 'on') ? 'show_lightbox' : 'hide_lightbox';
    if (!empty($show_lightbox_tablet)) {
        $show_lightboxclasses .= ($show_lightbox_tablet === 'on') ? ' show_lightbox_tablet' : ' hide_lightbox_tablet';
    }
    if (!empty($show_lightbox_phone)) {
        $show_lightboxclasses .= ($show_lightbox_phone === 'on') ? ' show_lightbox_phone' : ' hide_lightbox_phone';
    }

    $options = [];

    $columns = $this->dipi_get_responsive_prop('columns');
    if ($columns['desktop'] === "4" && $columns['tablet'] === "4" && $columns['phone'] === "4") {
        $columns['tablet'] = "2";
        $columns['phone'] = "1";
    }
    $options['data-columnsdesktop'] = esc_attr($columns['desktop']);
    $options['data-columnstablet'] = esc_attr($columns['tablet']);
    $options['data-columnsphone'] = esc_attr($columns['phone']);

    $space_between = $this->dipi_get_responsive_prop('space_between');
    $options['data-spacebetween'] = esc_attr($space_between['desktop']);
    $options['data-spacebetween_tablet'] = esc_attr($space_between['tablet']);
    $options['data-spacebetween_phone'] = esc_attr($space_between['phone']);

    $options['data-loop'] = esc_attr($loop);
    $options['data-speed'] = esc_attr($speed);
    $options['data-navigation'] = esc_attr($navigation);
    $options['data-navigation_t'] = esc_attr($navigation_tablet);
    $options['data-navigation_m'] = esc_attr($navigation_phone);
    $options['data-pagination'] = esc_attr($pagination);
    $options['data-autoplay'] = esc_attr($autoplay);
    $options['data-autoplayspeed'] = esc_attr($autoplay_speed);
    $options['data-pauseonhover'] = esc_attr($pause_on_hover);
    $options['data-act_horizontal_pos'] = esc_attr($timeline_active_horizontal_pos);
    $options['data-dynamicbullets'] = esc_attr($dynamic_bullets);
    $options['data-ordernumber'] = esc_attr($order_number);
    $options['data-centered'] = esc_attr($centered);
    

    $next_icon_render = 'data-icon="9"';
    if ('on' === $this->props['navigation_next_icon_yn']) {
        $next_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_next_icon)));
        $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%%.dipi_horizontal_timeline .swiper-button-next:after');
    }

    $prev_icon_render = 'data-icon="8"';
    if ('on' === $this->props['navigation_prev_icon_yn']) {
        $prev_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_prev_icon)));
        $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon', '%%order_class%%.dipi_horizontal_timeline .swiper-button-prev:after');
    }

    $navigation = sprintf(
        '<div class="swiper-button-next swiper-arrow-button dipi-sbn%1$s %4$s" %2$s></div>
            <div class="swiper-button-prev swiper-arrow-button dipi-sbp%1$s %4$s" %3$s></div>
            ',
        $order_number,
        $next_icon_render,
        $prev_icon_render,
        $navigation_on_hover === "on" ? "show_on_hover" : ""
    );

    $pagination = sprintf(
        '<div class="swiper-pagination dipi-sp%1$s"></div>',
        $order_number
    );

    
    $start_position                    = $this->props['start_position'];
    $use_active_line				           = $this->props['use_active_line'];
    $line_area_size                    = $this->props['line_area_size'];
    $line_area_size_values             = et_pb_responsive_options()->get_property_values( $this->props, 'line_area_size' ); 
    $show_card_arrow                   = $this->props['show_card_arrow'];
    $timline_line_html =  '<div class="dipi-htl-line"></div>';
    $timline_active_line_html = '';
    if ($use_active_line == "on") {
      $timline_active_line_html ='<div class="dipi-htl-line__active"></div>';
    }
    
	  $layout_last_edited = $this->props['layout_last_edited'];
    $layout_responsive_active = et_pb_get_responsive_status($layout_last_edited);
    $layout = ($this->props['layout']) ? $this->props['layout'] : '';
    $layout_tablet = ($layout_responsive_active && isset($this->props['layout_tablet']) && $this->props['layout_tablet'] !== '') ? $this->props['layout_tablet'] : 'bottom';
    $layout_phone = ($layout_responsive_active && isset($this->props['layout_phone']) && $this->props['layout_phone'] !== '') ? $this->props['layout_phone'] : 'bottom';

    $card_arrow_align              = isset( $this->props['card_arrow_align'] ) ? $this->props['card_arrow_align'] : '';
    $card_arrow_align_tablet       = isset( $this->props['card_arrow_align_tablet'] ) ? $this->props['card_arrow_align_tablet'] : '';
    $card_arrow_align_phone        = isset( $this->props['card_arrow_align_phone'] ) ? $this->props['card_arrow_align_phone'] : '';
    $card_arrow_align_last_edited  = isset( $this->props['card_arrow_align_last_edited'] ) ? $this->props['card_arrow_align_last_edited'] : '';
    $options['data-layout'] = esc_attr($layout);
    $options['data-layout_t'] = esc_attr($layout_tablet) ;
    $options['data-layout_m'] = esc_attr($layout_phone);
    $options['data-card_arrow_align'] = esc_attr($card_arrow_align);

    $options = implode(
        " ",
        array_map(
            function ($k, $v) {
                return "{$k}='{$v}'";
            },
            array_keys($options),
            $options
        )
    );

    $module_custom_classes = ' dipi_htl_custom_classes';
    $module_custom_classes .= $this->get_text_orientation_classname();
		$module_custom_classes .= sprintf( ' dipi_htl_layout_%1$s', esc_attr( $layout ) );

    if ( ! empty( $layout_tablet ) ) {
			$module_custom_classes .=  " dipi_htl_layout_{$layout_tablet}_tablet" ;
		} else {
      $module_custom_classes .=  " dipi_htl_layout_bottom_tablet" ;
    }

		if ( ! empty( $layout_phone ) ) {
			$module_custom_classes .=  " dipi_htl_layout_{$layout_phone}_phone" ;
		} else {
      $module_custom_classes .=  " dipi_htl_layout_bottom_phone" ;
    }
    
    if ( ! empty( $start_position ) ) {
			$module_custom_classes .=  " startpos-{$start_position}" ;
    }
    
    if ($show_card_arrow == 'on') {
      $module_custom_classes .= " dipi_timeline_show-card-arrow" ;
    }
    
    if ( ! empty( $card_arrow_align) ) {
			$module_custom_classes .=  " dipi_timeline_card_arrow_{$card_arrow_align}" ;
		} 
    if ( ! empty( $card_arrow_align_tablet ) ) {
			$module_custom_classes .=  " dipi_timeline_card_arrow_{$card_arrow_align_tablet}_tablet" ;
		} 

		if ( ! empty( $card_arrow_align_phone ) ) {
			$module_custom_classes .=  " dipi_timeline_card_arrow_{$card_arrow_align_phone}_phone" ;
		} 
    //$this->wrapper_settings = array(
      // 'parallax_background'     => '',
      // 'video_background'        => '',
      // 'attrs'                   => array(),
      //  'inner_attrs'             => array(
      //  'class' => "dipi_htl_container",
      //),
		//);
		return sprintf('
      <div class="dipi-carousel-main %5$s %8$s" %2$s>
        <div class="dipi_htl_container">
          <div class="dipi-htl-items">
            %1$s
            %6$s
            %7$s
          </div>
        </div>
        %3$s
        <div class="dipi_htl_container-horizontal">
          %4$s
        </div>
      </div>',
      $get_carousel_content,
      $options,
      $navigation,
      $pagination,
      $show_lightboxclasses,
      $timline_line_html, #6
      $timline_active_line_html,
      $module_custom_classes
		);
	}

}

new DIPI_HorizontalTimeline;

