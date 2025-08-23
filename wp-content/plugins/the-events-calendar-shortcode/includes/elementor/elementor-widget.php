<?php

// my_custom_elementor_widget.php
use Elementor\Repeater;

class TECS_Elementor_Widget extends \Elementor\Widget_Base {

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
    }

    public function get_script_depends() {
        return apply_filters( 'ecs_elementor_widget_script_depends', [] );
    }

    public function get_name() {
        return 'tecs_widget';
    }

    public function get_title() {
        return __( 'The Events Calendar Shortcode & Block', 'the-events-calendar-shortcode' );
    }

    public function get_icon() {
        return 'elementor-icon-ecs';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'text-domain' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'design_choice',
            [
                'label' => __( 'Design', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => apply_filters( 'ecs_elementor_designs', [
                    '' => __( 'Standard', 'the-events-calendar-shortcode' ),
                ] ),
                'default' => apply_filters( 'ecs_elementor_design_default', '' ),
            ]
        );

        if ( ! defined( 'TECS_VERSION' ) ) {
            $this->add_control(
                'design_choice_pro',
                [
                    'label' => esc_html__( 'Want more designs?', 'the-events-calendar-shortcode' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => sprintf( esc_html__( '%sUpgrade to Pro%s for more designs (including a full calendar view), pagination and a filter bar!', 'the-events-calendar-shortcode' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/the-events-calendar-shortcode/?utm_source=plugin&utm_medium=link&utm_campaign=elementor-block&utm_content=elementor">', '</a>' ) . '<p><a target="_blank" href="https://demo.eventcalendarnewsletter.com/the-events-calendar-shortcode/?utm_source=plugin&utm_medium=link&utm_campaign=elementor-block&utm_content=elementor">' . esc_html__( 'View the demo', 'the-events-calendar-shortcode' ) . '</a></p>',
                    'content_classes' => 'ecs-pro-notice',
                ]
            );
        }

        $this->add_control(
            'limit',
            [
                'label' => __( 'Number of Events', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'condition' => apply_filters( 'ecs_elementor_limit_condition', [] ),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'ASC' => __( 'Ascending', 'the-events-calendar-shortcode' ),
                    'DESC' => __( 'Descending', 'the-events-calendar-shortcode' ),
                ],
                'default' => 'ASC',
            ]
        );

        // Specify whether to show a thumbnail or not, and if so, show the size options
        $this->add_control(
            'thumbnail',
            [
                'label' => __( 'Show thumbnail image', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => apply_filters( 'ecs_elementor_thumbnail_condition', [] ),
            ]
        );

        $this->add_control(
            'thumbnail_dimensions_choice',
            [
                'label' => __( 'Thumbnail Size', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'the-events-calendar-shortcode' ),
                    'width_and_height' => __( 'Width & Height', 'the-events-calendar-shortcode' ),
                    'size' => __( 'Size', 'the-events-calendar-shortcode' ),
                ],
                'default' => 'default',
                'condition' => [
                    'thumbnail' => 'yes',
                    'design_choice!' => 'grouped',
                ],
            ]
        );

        $this->add_control(
            'thumbnail_width',
            [
                'label' => __( 'Thumbnail Width', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '150',
                'condition' => apply_filters( 'ecs_elementor_thumbnail_width_and_height_conditions', [
                    'thumbnail' => 'yes',
                    'thumbnail_dimensions_choice' => 'width_and_height',
                ] ),
            ]
        );

        $this->add_control(
            'thumbnail_height',
            [
                'label' => __( 'Thumbnail Height', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '150',
                'condition' => apply_filters( 'ecs_elementor_thumbnail_width_and_height_conditions', [
                    'thumbnail' => 'yes',
                    'thumbnail_dimensions_choice' => 'width_and_height',
                ] ),
            ]
        );

        $this->add_control(
            'thumbnail_size',
            [
                'label' => __( 'Thumbnail Size', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'condition' => apply_filters( 'ecs_elementor_thumbnail_size_conditions', [
                    'thumbnail' => 'yes',
                    'thumbnail_dimensions_choice' => 'size',
                ] ),
            ]
        );

        $this->add_control(
            'venue',
            [
                'label' => __( 'Show venue information', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'excerpt',
            [
                'label' => __( 'Show excerpt of events', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __( 'Excerpt Length', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '100',
                'condition' => [
                    'excerpt' => 'yes',
                ],
            ]
        );

        if ( ! defined( 'TECS_VERSION' ) ) {
            $this->add_control(
                'excerpt_pro',
                [
                    'label' => esc_html__( 'Want more control over the excerpt?', 'the-events-calendar-shortcode' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => sprintf( esc_html__( '%sUpgrade to Pro%s to show the full description, HTML in your excerpts, and more!', 'the-events-calendar-shortcode' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/the-events-calendar-shortcode/?utm_source=plugin&utm_medium=link&utm_campaign=elementor-block&utm_content=elementor">', '</a>' ),
                    'content_classes' => 'ecs-pro-notice',
                    'condition' => [
                        'excerpt' => 'yes',
                    ],
                ]
            );
        }

        $this->add_control(
            'past',
            [
                'label' => __( 'Show only past events?', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        if ( ! defined( 'TECS_VERSION' ) ) {
            $this->add_control(
                'past_pro',
                [
                    'label' => esc_html__( 'Specify a date range or number of days', 'the-events-calendar-shortcode' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => sprintf( esc_html__( '%sGet more date-related options%s to show events from a specific year, number of days, and even a specific date range.', 'the-events-calendar-shortcode' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/the-events-calendar-shortcode/?utm_source=plugin&utm_medium=link&utm_campaign=elementor-block&utm_content=elementor">', '</a>' ),
                    'content_classes' => 'ecs-pro-notice',
                    'condition' => [
                        'past' => 'yes',
                    ],
                ]
            );
        }

        do_action( 'ecs_elementor_widget_controls_before_advanced', $this );

        $advanced = new Repeater();
        $advanced->add_control(
            'key',
            [
                'label' => __( 'Key', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $advanced->add_control(
            'value',
            [
                'label' => __( 'Value', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__( 'Advanced/Other', 'the-events-calendar-shortcode' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $advanced->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ key }}}',
            ]
        );

        $this->add_control(
            'advanced_description',
            [
                'label' => '',
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => sprintf( esc_html__( '%sView documentation on available options%s where key="value" in the shortcode can be entered in the boxes above.', 'the-events-calendar-shortcode' ), '<a target="_blank" href="https://eventcalendarnewsletter.com/events-calendar-shortcode-pro-options/?utm_source=plugin&utm_medium=link&utm_campaign=block-advanced-help&utm_content=elementor' . ( ! defined( 'TECS_VERSION' ) ? '&free=1' : '' ) . '">', '</a>' ),
                'content_classes' => 'ecs-pro-notice',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $design_choice = $settings['design_choice'];

        $atts = [
            'design' => $design_choice,
            'thumb' => $settings['thumbnail'] === 'yes' ? 'true' : 'false',
            'venue' => $settings['venue'] === 'yes' ? 'true' : 'false',
            'excerpt' => $settings['excerpt'] === 'yes' ? $settings['excerpt_length'] : 'false',
            'past' => $settings['past'] === 'yes' ? 'yes' : null,
            'order' => 'DESC' === $settings['order'] ? 'DESC' : 'ASC',
        ];

        if ( 'calendar' !== $design_choice ) {
            $atts['limit'] = intval( is_numeric( $settings['limit'] ) ? $settings['limit'] : 5 );
        }

        if ( 'yes' === $settings['thumbnail'] ) {
            if ( 'width_and_height' === $settings['thumbnail_dimensions_choice'] ) {
                $atts['thumbwidth'] = intval( is_numeric( $settings['thumbnail_width'] ) ? $settings['thumbnail_width'] : 150 );
                $atts['thumbheight'] = intval( is_numeric( $settings['thumbnail_height'] ) ? $settings['thumbnail_height'] : 150 );
            } else {
                $atts['thumbsize'] = $settings['thumbnail_size'];
            }
        }

        $atts = apply_filters( 'ecs_elementor_widget_atts', $atts, $settings );

        foreach ( $settings['advanced'] as $advanced ) {
            $atts[ $advanced['key'] ] = $advanced['value'];
        }

        echo do_shortcode(
            '[ecs-list-events ' . implode( ' ', array_map( function ( $key, $value ) {
                return esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
            }, array_keys( $atts ), $atts ) ) . ']'
        );
    }

    protected function _content_template() {
        // Define your template variables here
    }
}
