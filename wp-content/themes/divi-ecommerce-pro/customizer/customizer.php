<?php
/*
 * Contains code copied from and/or based on Divi
 * See the license.txt file in the root directory for more information and licenses
 *
 * This file was modified by Dominika Rauk;
 * Last modified 2020-12-09
 */

add_action('customize_controls_enqueue_scripts', 'divi_ecommerce_pro_customizer_css');

function divi_ecommerce_pro_customizer_css() {
    wp_enqueue_style('dsdep-customizer-controls-styles', get_stylesheet_directory_uri() . '/customizer/customizer.css');
}

/*
 * Add new section to customizer
 */

function divi_ecommerce_pro_customize_register($wp_customize) {

    // Create panel
    $wp_customize->add_panel('dsdep_child_theme_customizer', array(
        'title'    => esc_html__('Divi Ecommerce Pro Settings', 'divi-ecommerce-pro'),
        'priority' => 2,
    ));

    // Create sections

    // Color scheme
    $wp_customize->add_section('dsdep_colors', array(
        'title'       => esc_html__('Color Scheme', 'divi-ecommerce-pro'),
        'panel'       => 'dsdep_child_theme_customizer',
        'priority'    => 1,
        'description' => esc_html__('Color settings will be applied to your Divi Child Theme color scheme.', 'divi-ecommerce-pro'),
    ));

    // Buttons
    $wp_customize->add_section('dsdep_buttons', array(
        'title'    => esc_html__('Buttons Settings', 'divi-ecommerce-pro'),
        'panel'    => 'dsdep_child_theme_customizer',
        'priority' => 2,
    ));

    $wp_customize->add_section('dsdep_primary_button', array(
        'title'       => esc_html__('Primary Button Color Scheme', 'divi-ecommerce-pro'),
        'panel'       => 'dsdep_child_theme_customizer',
        'priority'    => 3,
        'description' => esc_html__('Color settings below will be applied to primary buttons.', 'divi-ecommerce-pro'),
    ));

    $wp_customize->add_section('dsdep_secondary_button', array(
        'title'       => esc_html__('Secondary Button Color Scheme', 'divi-ecommerce-pro'),
        'panel'       => 'dsdep_child_theme_customizer',
        'priority'    => 4,
        'description' => esc_html__('Color settings below will be applied to secondary buttons.', 'divi-ecommerce-pro'),
    ));

    $wp_customize->add_section('dsdep_outline_button', array(
        'title'       => esc_html__('Outline Button Color Scheme', 'divi-ecommerce-pro'),
        'panel'       => 'dsdep_child_theme_customizer',
        'priority'    => 5,
        'description' => esc_html__('Color settings below will be applied to outline buttons.', 'divi-ecommerce-pro'),
    ));

    $wp_customize->add_section('dsdep_border', array(
        'title'    => esc_html__('Border Settings', 'divi-ecommerce-pro'),
        'panel'    => 'dsdep_child_theme_customizer',
        'priority' => 6,
    ));

    // --------------------------------------------------------------------------------------- //
    //                                       Color Scheme
    // --------------------------------------------------------------------------------------- //

    // Primary Accent Color
    $wp_customize->add_setting('dsdep_main_accent_color', array(
        'default'           => '#006AFF',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_main_accent_color',
        array(
            'label'    => esc_html__('Main Accent', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_main_accent_color'
        )
    ));

    // Primary Accent Hover Color
    $wp_customize->add_setting('dsdep_main_hover_accent_color', array(
        'default'           => '#0055cc',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_main_hover_accent_color',
        array(
            'label'    => esc_html__('Main Accent Hover Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_main_hover_accent_color'
        )
    ));

    // Second Accent Color
    $wp_customize->add_setting('dsdep_second_accent_color', array(
        'default'           => '#FCD800',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_second_accent_color',
        array(
            'label'    => esc_html__('Second Accent', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_second_accent_color'
        )
    ));

    // Second Accent Hover Color
    $wp_customize->add_setting('dsdep_second_accent_hover_color', array(
        'default'           => '#e8c700',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_second_accent_hover_color',
        array(
            'label'    => esc_html__('Second Accent Hover Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_second_accent_hover_color'
        )
    ));

    // Light Grey Color
    $wp_customize->add_setting('dsdep_light_grey_color', array(
        'default'           => '#F6F6F6',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_light_grey_color',
        array(
            'label'    => esc_html__('Light grey color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_light_grey_color'
        )
    ));

    // Dark Grey Color
    $wp_customize->add_setting('dsdep_dark_grey_color', array(
        'default'           => '#232323',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_dark_grey_color',
        array(
            'label'    => esc_html__('Dark grey color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_dark_grey_color'
        )
    ));

    // Font Color
    $wp_customize->add_setting('dsdep_font_color', array(
        'default'           => '#757575',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_font_color',
        array(
            'label'    => esc_html__('Body Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_font_color'
        )
    ));

    // Second Accent Color
    $wp_customize->add_setting('dsdep_headers_color', array(
        'default'           => '#232323',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_headers_color',
        array(
            'label'    => esc_html__('Header Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_headers_color'
        )
    ));

    // Box Shadow Color
    $wp_customize->add_setting('dsdep_box_shadow_color_primary', array(
        'default'           => 'rgba(41,100,216,0.2)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_box_shadow_color_primary',
        array(
            'label'    => esc_html__('Primary Box Shadow', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_box_shadow_color_primary'
        )
    ));

    // Box Shadow Color
    $wp_customize->add_setting('dsdep_box_shadow_color_secondary', array(
        'default'           => 'rgba(0,0,0,0.08)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_box_shadow_color_secondary',
        array(
            'label'    => esc_html__('Secondary Box Shadow', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_colors',
            'settings' => 'dsdep_box_shadow_color_secondary'
        )
    ));

    // --------------------------------------------------------------------------------------- //
    //                                      Buttons
    // --------------------------------------------------------------------------------------- //

    // General buttons settings

    // Border Radius
    $wp_customize->add_setting('dsdep_buttons_border_width', array(
        'default'           => '2',
        'type'              => 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new ET_Divi_Range_Option(
        $wp_customize, 'dsdep_buttons_border_width', array(
            'label'       => esc_html__('Border width', 'divi-ecommerce-pro'),
            'section'     => 'dsdep_buttons',
            'settings'    => 'dsdep_buttons_border_width',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 10,
                'step' => 1
            ),
        )
    ));

    // Border Radius
    $wp_customize->add_setting('dsdep_buttons_border_radius', array(
        'default'           => '6',
        'type'              => 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new ET_Divi_Range_Option(
        $wp_customize, 'dsdep_buttons_border_radius', array(
            'label'       => esc_html__('Border radius', 'divi-ecommerce-pro'),
            'section'     => 'dsdep_buttons',
            'settings'    => 'dsdep_buttons_border_radius',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 50,
                'step' => 1
            ),
        )
    ));

    // Primary Button Color Scheme
    $wp_customize->add_setting('dsdep_primary_button_text_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_text_color',
        array(
            'label'    => esc_html__('Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_primary_button_border_color', array(
        'default'           => '#006aff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_border_color',
        array(
            'label'    => esc_html__('Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_primary_button_background_color', array(
        'default'           => '#006aff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_background_color',
        array(
            'label'    => esc_html__('Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_background_color'
        )
    ));

    $wp_customize->add_setting('dsdep_primary_button_hover_text_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_hover_text_color',
        array(
            'label'    => esc_html__('Hover Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_hover_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_primary_button_hover_border_color', array(
        'default'           => '#0055cc',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_hover_border_color',
        array(
            'label'    => esc_html__('Hover Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_hover_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_primary_button_hover_background_color', array(
        'default'           => '#0055cc',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_primary_button_hover_background_color',
        array(
            'label'    => esc_html__('Hover Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_primary_button',
            'settings' => 'dsdep_primary_button_hover_background_color'
        )
    ));

    // Secondary Button Color Scheme
    $wp_customize->add_setting('dsdep_secondary_button_text_color', array(
        'default'           => '#232323',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_text_color',
        array(
            'label'    => esc_html__('Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_secondary_button_border_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_border_color',
        array(
            'label'    => esc_html__('Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_secondary_button_background_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_background_color',
        array(
            'label'    => esc_html__('Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_background_color'
        )
    ));

    $wp_customize->add_setting('dsdep_secondary_button_hover_text_color', array(
        'default'           => '#006aff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_hover_text_color',
        array(
            'label'    => esc_html__('Hover Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_hover_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_secondary_button_hover_border_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_hover_border_color',
        array(
            'label'    => esc_html__('Hover Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_hover_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_secondary_button_hover_background_color', array(
        'default'           => '#fff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_secondary_button_hover_background_color',
        array(
            'label'    => esc_html__('Hover Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_secondary_button',
            'settings' => 'dsdep_secondary_button_hover_background_color'
        )
    ));

    // Outline Button Color Scheme
    $wp_customize->add_setting('dsdep_outline_button_text_color', array(
        'default'           => '#232323',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_text_color',
        array(
            'label'    => esc_html__('Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_outline_button_border_color', array(
        'default'           => 'rgba(117,117,117,0.16)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_border_color',
        array(
            'label'    => esc_html__('Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_outline_button_background_color', array(
        'default'           => 'rgba(0,0,0,0)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_background_color',
        array(
            'label'    => esc_html__('Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_background_color'
        )
    ));

    $wp_customize->add_setting('dsdep_outline_button_hover_text_color', array(
        'default'           => '#232323',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_hover_text_color',
        array(
            'label'    => esc_html__('Hover Text Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_hover_text_color'
        )
    ));

    $wp_customize->add_setting('dsdep_outline_button_hover_border_color', array(
        'default'           => '#006aff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_hover_border_color',
        array(
            'label'    => esc_html__('Hover Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_hover_border_color'
        )
    ));

    $wp_customize->add_setting('dsdep_outline_button_hover_background_color', array(
        'default'           => 'rgba(0,0,0,0)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_outline_button_hover_background_color',
        array(
            'label'    => esc_html__('Hover Background Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_outline_button',
            'settings' => 'dsdep_outline_button_hover_background_color'
        )
    ));

    // --------------------------------------------------------------------------------------- //
    //                                      Border
    // --------------------------------------------------------------------------------------- //

    // Border color
    $wp_customize->add_setting('dsdep_light_border_color', array(
        'default'           => '#EFEFEF',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_light_border_color',
        array(
            'label'    => esc_html__('Light Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_border',
            'settings' => 'dsdep_light_border_color'
        )
    ));

    // Border color
    $wp_customize->add_setting('dsdep_dark_border_color', array(
        'default'           => 'rgba(117,117,117,0.16)',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new ET_Divi_Customize_Color_Alpha_Control(
        $wp_customize,
        'dsdep_dark_border_color',
        array(
            'label'    => esc_html__('Dark Border Color', 'divi-ecommerce-pro'),
            'section'  => 'dsdep_border',
            'settings' => 'dsdep_dark_border_color'
        )
    ));

    // Border Radius
    $wp_customize->add_setting('dsdep_border_radius', array(
        'default'           => '6',
        'type'              => 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new ET_Divi_Range_Option(
        $wp_customize, 'dsdep_border_radius', array(
            'label'       => esc_html__('General border radius (px)', 'divi-ecommerce-pro'),
            'section'     => 'dsdep_border',
            'settings'    => 'dsdep_border_radius',
            'type'        => 'range',
            'description' => esc_html__('General border radius applied to form elements, cards, boxes etc.', 'divi-ecommerce-pro'),
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 50,
                'step' => 1
            ),
        )
    ));

    // Border Radius
    $wp_customize->add_setting('dsdep_form_border_radius', array(
        'default'           => '6',
        'type'              => 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new ET_Divi_Range_Option(
        $wp_customize, 'dsdep_form_border_radius', array(
            'label'       => esc_html__('Form border radius (px)', 'divi-ecommerce-pro'),
            'section'     => 'dsdep_border',
            'settings'    => 'dsdep_form_border_radius',
            'type'        => 'range',
            'description' => esc_html__('General border radius applied to form elements, cards, boxes etc.', 'divi-ecommerce-pro'),
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 50,
                'step' => 1
            ),
        )
    ));

}

add_action('customize_register', 'divi_ecommerce_pro_customize_register');

/*
 * Output  custom settings CSS Style
 */

function divi_ecommerce_pro_customize_css() {

    /* ============================= */

    $main_accent = get_theme_mod('dsdep_main_accent_color', '#006AFF');
    $main_hover_accent = get_theme_mod('dsdep_main_hover_accent_color', '#0055cc');
    $second_accent = get_theme_mod('dsdep_second_accent_color', '#fcd800');
    $second_hover_accent = get_theme_mod('dsdep_second_hover_accent_color', '#e8c700');
    $light_grey = get_theme_mod('dsdep_light_grey_color', '#f6f6f6');
    $dark_grey = get_theme_mod('dsdep_dark_grey_color', '#232323');
    $font_color = get_theme_mod('dsdep_font_color', '#757575');
    $headers_color = get_theme_mod('dsdep_headers_color', '#232323');
    $primary_shadow = get_theme_mod('dsdep_box_shadow_color_primary', 'rgba(41,100,216,0.2)');
    $second_shadow = get_theme_mod('dsdep_box_shadow_color_secondary', 'rgba(0,0,0,0.08)');
    $light_border_color = get_theme_mod('dsdep_light_border_color', '#efefef');
    $dark_border_color = get_theme_mod('dsdep_dark_border_color', 'rgba(117,117,117,0.16)');

    $primary_button_text_color = get_theme_mod('dsdep_primary_button_text_color', '#fff');
    $primary_button_bg_color = get_theme_mod('dsdep_primary_button_background_color', '#006aff');
    $primary_button_border_color = get_theme_mod('dsdep_primary_button_border_color', '#006aff');
    $primary_button_hover_text_color = get_theme_mod('dsdep_primary_button_hover_text_color', '#fff');
    $primary_button_hover_bg_color = get_theme_mod('dsdep_primary_button_hover_background_color', '#0055cc');
    $primary_button_hover_border_color = get_theme_mod('dsdep_primary_button_hover_border_color', '#0055cc');

    $secondary_button_text_color = get_theme_mod('dsdep_secondary_button_text_color', '#232323');
    $secondary_button_bg_color = get_theme_mod('dsdep_secondary_button_background_color', '#fff');
    $secondary_button_border_color = get_theme_mod('dsdep_secondary_button_border_color', '#fff');
    $secondary_button_hover_text_color = get_theme_mod('dsdep_secondary_button_hover_text_color', '#006aff');
    $secondary_button_hover_bg_color = get_theme_mod('dsdep_secondary_button_hover_background_color', '#fff');
    $secondary_button_hover_border_color = get_theme_mod('dsdep_secondary_button_hover_border_color', '#fff');

    $outline_button_text_color = get_theme_mod('dsdep_outline_button_text_color', '#232323');
    $outline_button_bg_color = get_theme_mod('dsdep_outline_button_background_color', 'rgba(0,0,0,0)');
    $outline_button_border_color = get_theme_mod('dsdep_outline_button_border_color', 'rgba(117,117,117,0.16)');
    $outline_button_hover_text_color = get_theme_mod('dsdep_outline_button_hover_text_color', '#232323');
    $outline_button_hover_bg_color = get_theme_mod('dsdep_outline_button_hover_background_color', 'rgba(0,0,0,0)');
    $outline_button_hover_border_color = get_theme_mod('dsdep_outline_button_hover_border_color', '#006AFF');

    /* ============================= */

    ?>
    <style type="text/css">
        /* Box shadow primary */
        .dsdep-shadow-primary, .dsdep-module-button-shadow-primary .et_pb_button, .dsdep-my-account .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-checkout .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-my-account .woocommerce .woocommerce-MyAccount-content p:last-of-type button, .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, #et-boc .et-l .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, .user-logged-out .dsdep-my-account form.woocommerce-ResetPassword button, .user-logged-out .dsdep-my-account form.woocommerce-form-login button, .user-logged-out .dsdep-my-account form.woocommerce-form-register button, .woocommerce nav.woocommerce-pagination span.current, .et-db #et-boc nav.woocommerce-pagination span.current, .dsdep-reviews #reviews #respond input[type=submit], .dsdep-woo-tabs .et_pb_tab_content #reviews #respond input[type=submit], wp-pagenavi span.current, .xoo-wsc-basket, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, ol.commentlist .comment.bypostauthor .comment_avatar img, #commentform .form-submit .et_pb_button {
            box-shadow : 0 7px 50px 0 <?php esc_html_e($primary_shadow);?> !important;
        }

        /* Box shadow second */
        .dsdep-shadow-second, .dsdep-module-button-shadow-second .et_pb_button, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et_mobile_menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et_mobile_menu, .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li img, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li img, .et-db #et-boc .et-l #sidebar ul.product_list_widget li img, .et-db #et-boc .et-l #sidebar ul.cart_list li img, .dsdep-blog .et_pb_post .post-content a.more-link, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-content a.more-link, .dsdep-add-to-cart button.button, .et-db #et-boc .et-l .dsdep-add-to-cart button.button, .woocommerce.et-db #et-boc .et-l .woocommerce-error, .woocommerce-page .woocommerce-error, .woocommerce .woocommerce-error, .woocommerce-page.et-db #et-boc .et-l .woocommerce-error, .woocommerce.et-db #et-boc .et-l .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-info, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info, .woocommerce.et-db #et-boc .et-l .woocommerce-message, .woocommerce-page .woocommerce-message, .woocommerce .woocommerce-message, .woocommerce-page.et-db #et-boc .et-l .woocommerce-message, #add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box, .remodal, .tinv-modal .tinv-modal-inner, ol.commentlist .comment .comment_avatar img {
            box-shadow : 0 7px 50px 0 <?php esc_html_e($second_shadow);?> !important;
        }

        /* Light Border Color */
        .dsdep-border-color-light, .dsdep-heading-with-line.line-light h1:after, .dsdep-heading-with-line.line-light h2:after, .dsdep-heading-with-line.line-light h3:after, .dsdep-heading-with-line.line-light h4:after, .dsdep-heading-with-line.line-light h5:after, .dsdep-heading-with-line.line-light h6:after, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et_mobile_menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et_mobile_menu, #sidebar .et_pb_widget.widget_search input[type=text], #sidebar .et_pb_widget.widget_search input[type=search], #sidebar .et_pb_widget.widget_product_search input[type=text], #sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li:not(:last-child), .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li:not(:last-child), .et-db #et-boc .et-l #sidebar ul.product_list_widget li:not(:last-child), .et-db #et-boc .et-l #sidebar ul.cart_list li:not(:last-child), .dsdep-blog .et_pb_post, .et-db #et-boc .et-l .dsdep-blog .et_pb_post, .dsdep-woo-tabs ul.et_pb_tabs_controls:after, .et-db #et-boc .et-l .dsdep-woo-tabs ul.et_pb_tabs_controls:after, .dsdep-optin input, .dsdep-optin select, .et-db #et-boc .et-l .dsdep-optin input, .et-db #et-boc .et-l .dsdep-optin select, .dsdep-optin textarea, .et-db #et-boc .et-l .dsdep-optin textarea, .dsdep-search input[type=text], .dsdep-search input[type=search], .et-db #et-boc .et-l .dsdep-search input[type=text], .et-db #et-boc .et-l .dsdep-search input[type=search], .dsdep-contact-form input, .dsdep-contact-form p input, .et-db #et-boc .et-l .dsdep-contact-form input, .et-db #et-boc .et-l .dsdep-contact-form p input, .dsdep-contact-form textarea, .dsdep-contact-form p textarea, .et-db #et-boc .et-l .dsdep-contact-form textarea, .et-db #et-boc .et-l .dsdep-contact-form p textarea, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-arrow-next, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-arrow-prev, .dsdep-slider.et_pb_slider .et-pb-arrow-next, .dsdep-slider.et_pb_slider .et-pb-arrow-prev, .dsdep-woo-images .woocommerce-product-gallery .woocommerce-product-gallery__image img, .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .woocommerce-product-gallery__image img, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img, .dsdep-add-to-cart .variations select, .et-db #et-boc .et-l .dsdep-add-to-cart .variations select, .dsdep-add-to-cart input.qty, .et-db #et-boc .et-l .dsdep-add-to-cart input.qty, #et-boc .et-l .woocommerce input.text, #et-boc .et-l .woocommerce input.input-text, #et-boc .et-l .woocommerce input.title, #et-boc .et-l .woocommerce input[type=email], #et-boc .et-l .woocommerce input[type=number], #et-boc .et-l .woocommerce input[type=password], #et-boc .et-l .woocommerce input[type=tel], #et-boc .et-l .woocommerce input[type=text], #et-boc .et-l .woocommerce input[type=url], #et-boc .et-l .woocommerce select, #et-boc .et-l .woocommerce .select2-container--default .select2-selection--single, #et-boc .et-l .woocommerce textarea, .woocommerce-cart table.cart td.actions .coupon input.input-text, .woocommerce table.shop_table th, .woocommerce table.shop_table td, .woocommerce-order-received .woocommerce-order ul.woocommerce-order-overview li strong, .dsdep-my-account .woocommerce .woocommerce-Addresses .u-column1:before, .dsdep-my-account .woocommerce table.woocommerce-orders-table tbody td, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads tbody td, .dsdep-checkout .woocommerce table.woocommerce-orders-table tbody td, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads tbody td, .dsdep-cart table.shop_table, #et-boc .et-l .dsdep-cart table.shop_table, .dsdep-cart table.shop_table tbody tr td, #et-boc .et-l .dsdep-cart table.shop_table tbody tr td, .dsdep-cart table.shop_table td.product-thumbnail img, #et-boc .et-l .dsdep-cart table.shop_table td.product-thumbnail img, .woocommerce ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a, .et_pb_wc_related_products ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a, .woocommerce ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a.tinvwl_add_to_wishlist_button, .et_pb_wc_related_products ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a .tinvwl_add_to_wishlist_button, .woocommerce .quantity .qty, .xoo-wsc-container .xoo-wsc-product, .xoo-wsc-container .xoo-wsc-footer, .remodal, .remodal #wcqv_contend .product .images .thumbnail img, .remodal #wcqv_contend .product .product_meta, .remodal #wcqv_contend input.text, .remodal #wcqv_contend input.input-text, .remodal #wcqv_contend input.title, .remodal #wcqv_contend input[type=email], .remodal #wcqv_contend input[type=password], .remodal #wcqv_contend input[type=tel], .remodal #wcqv_contend input[type=text], .remodal #wcqv_contend select, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-thumbnail img, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-thumbnail img, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, ol.commentlist .comment .comment_avatar img, #commentform input[type=text], #commentform input[type=email], #commentform input[type=url], #commentform textarea {
            border-color : <?php esc_html_e($light_border_color);?> !important;
        }

        /* Dark Border Color */
        .dsdep-border-color-dark, .dsdep-heading-with-line.line-dark h1:after, .dsdep-heading-with-line.line-dark h2:after, .dsdep-heading-with-line.line-dark h3:after, .dsdep-heading-with-line.line-dark h4:after, .dsdep-heading-with-line.line-dark h5:after, .dsdep-heading-with-line.line-dark h6:after, #sidebar .et_pb_widget.widget_tag_cloud .tagcloud a, .dsdep-sidebar .et_pb_widget.widget_tag_cloud .tagcloud a, #sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a, .dsdep-sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a, #sidebar .et_pb_widget.widget_recent_comments ul li:not(:last-child):before, #sidebar .et_pb_widget.widget_recent_entries ul li:not(:last-child):before, .dsdep-sidebar .et_pb_widget.widget_recent_comments ul li:not(:last-child):before, .dsdep-sidebar .et_pb_widget.widget_recent_entries ul li:not(:last-child):before, #sidebar .et_pb_widget.widget_search input[type=text], #sidebar .et_pb_widget.widget_search input[type=search], #sidebar .et_pb_widget.widget_product_search input[type=text], #sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et_pb_widget.widget_categories ul li:not(:last-child):before, .et_pb_widget.widget_archive ul li:not(:last-child):before, .et_pb_widget.widget_product_categories ul li:not(:last-child):before, .et_pb_widget.woocommerce-widget-layered-nav ul li:not(:last-child):before, .dsdep-widgettitle, .dsdep-sidebar .widgettitle, #sidebar .widgettitle, .dsdep-accordion .et_pb_toggle, .et-db #et-boc .et-l .dsdep-accordion .et_pb_toggle, .dsdep-social-icons .et_pb_social_icon a.icon, .et-db #et-boc .et-l .dsdep-social-icons .et_pb_social_icon a.icon, .dsdep-testimonial .et_pb_testimonial_description, .et-db #et-boc .et-l .dsdep-testimonial .et_pb_testimonial_description, .dsdep-optin input, .dsdep-optin select, .et-db #et-boc .et-l .dsdep-optin input, .et-db #et-boc .et-l .dsdep-optin select, .dsdep-optin textarea, .et-db #et-boc .et-l .dsdep-optin textarea, .dsdep-search input[type=text], .dsdep-search input[type=search], .et-db #et-boc .et-l .dsdep-search input[type=text], .et-db #et-boc .et-l .dsdep-search input[type=search], .dsdep-contact-form input, .dsdep-contact-form p input, .et-db #et-boc .et-l .dsdep-contact-form input, .et-db #et-boc .et-l .dsdep-contact-form p input, .dsdep-contact-form textarea, .dsdep-contact-form p textarea, .et-db #et-boc .et-l .dsdep-contact-form textarea, .et-db #et-boc .et-l .dsdep-contact-form p textarea, #et-boc .et-l .woocommerce input[type=checkbox]:before, .woocommerce ul.products li.product .sep, .et_pb_wc_related_products ul.products li.product .sep, .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, #et-boc .et-l .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, #commentform input[type=text], #commentform input[type=email], #commentform input[type=url], #commentform textarea {
            border-color : <?php esc_html_e($dark_border_color);?> !important;
        }

        #et-boc .et-l .woocommerce input[type=radio], #add_payment_method #payment ul.payment_methods input[type=radio], .woocommerce-cart #payment ul.payment_methods input[type=radio], .woocommerce-checkout #payment ul.payment_methods input[type=radio] {
            box-shadow : inset 0 0 0 2px <?php esc_html_e($dark_border_color);?> !important;
        }

        /* Body Text Color */
        .dsdep-font-color, #sidebar .et_pb_widget.widget_search input[type=text], #sidebar .et_pb_widget.widget_search input[type=search], #sidebar .et_pb_widget.widget_product_search input[type=text], #sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-optin input, .dsdep-optin select, .et-db #et-boc .et-l .dsdep-optin input, .et-db #et-boc .et-l .dsdep-optin select, .dsdep-optin textarea, .et-db #et-boc .et-l .dsdep-optin textarea, .dsdep-search input[type=text], .dsdep-search input[type=search], .et-db #et-boc .et-l .dsdep-search input[type=text], .et-db #et-boc .et-l .dsdep-search input[type=search], .dsdep-contact-form input, .dsdep-contact-form p input, .et-db #et-boc .et-l .dsdep-contact-form input, .et-db #et-boc .et-l .dsdep-contact-form p input, .dsdep-contact-form textarea, .dsdep-contact-form p textarea, .et-db #et-boc .et-l .dsdep-contact-form textarea, .et-db #et-boc .et-l .dsdep-contact-form p textarea, .dsdep-add-to-cart .variations select, .et-db #et-boc .et-l .dsdep-add-to-cart .variations select, .dsdep-add-to-cart .woocommerce-variation-price .price del, .et-db #et-boc .et-l .dsdep-add-to-cart .woocommerce-variation-price .price del, .dsdep-add-to-cart input.qty, .et-db #et-boc .et-l .dsdep-add-to-cart input.qty, #et-boc .et-l .woocommerce input.text, #et-boc .et-l .woocommerce input.input-text, #et-boc .et-l .woocommerce input.title, #et-boc .et-l .woocommerce input[type=email], #et-boc .et-l .woocommerce input[type=number], #et-boc .et-l .woocommerce input[type=password], #et-boc .et-l .woocommerce input[type=tel], #et-boc .et-l .woocommerce input[type=text], #et-boc .et-l .woocommerce input[type=url], #et-boc .et-l .woocommerce select, #et-boc .et-l .woocommerce .select2-container--default .select2-selection--single, #et-boc .et-l .woocommerce textarea, .woocommerce-cart table.cart td.actions .coupon input.input-text, .woocommerce table.shop_table thead tr th, .dsdep-my-account .woocommerce .woocommerce-order-details table.shop_table thead th, .woocommerce-order-received .woocommerce-order-details table.shop_table thead th, .woocommerce-order-received .woocommerce-order ul.woocommerce-order-overview li, .dsdep-checkout .woocommerce .dsdep-checkout-order table.shop_table thead th, .dsdep-checkout .woocommerce-page .dsdep-checkout-order table.shop_table thead th, .woocommerce ul.products li.product .price del, .et_pb_wc_related_products ul.products li.product .price del, .woocommerce nav.woocommerce-pagination a.page-numbers, .et-db #et-boc nav.woocommerce-pagination a.page-numbers, .woocommerce .quantity .qty, .wp-pagenavi a.page, .remodal #wcqv_contend input.text, .remodal #wcqv_contend input.input-text, .remodal #wcqv_contend input.title, .remodal #wcqv_contend input[type=email], .remodal #wcqv_contend input[type=password], .remodal #wcqv_contend input[type=tel], .remodal #wcqv_contend input[type=text], .remodal #wcqv_contend select, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, #commentform input[type=text], #commentform input[type=email], #commentform input[type=url], #commentform textarea {
            color : <?php esc_html_e($font_color);?> !important;
        }

        /* Header Text Color */
        .dsdep-heading-color, #sidebar .et_pb_widget.widget_recent_comments ul li a, #sidebar .et_pb_widget.widget_recent_entries ul li a, .dsdep-sidebar .et_pb_widget.widget_recent_comments ul li a, .dsdep-sidebar .et_pb_widget.widget_recent_entries ul li a, .et_pb_widget.widget_categories ul li a, .et_pb_widget.widget_archive ul li a, .et_pb_widget.widget_product_categories ul li a, .et_pb_widget.woocommerce-widget-layered-nav ul li a, .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li span.product-title, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li span.product-title, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li a:not(.remove), .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li a, .et-db #et-boc .et-l #sidebar ul.product_list_widget li span.product-title, .et-db #et-boc .et-l #sidebar ul.cart_list li span.product-title, .et-db #et-boc .et-l #sidebar ul.cart_list li a:not(.remove), .et-db #et-boc .et-l #sidebar ul.product_list_widget li a, .dsdep-accordion .et_pb_toggle.et_pb_toggle_close .et_pb_toggle_title, .et-db #et-boc .et-l .dsdep-accordion .et_pb_toggle.et_pb_toggle_close .et_pb_toggle_title, .dsdep-testimonial .et_pb_testimonial_author, .et-db #et-boc .et-l .dsdep-testimonial .et_pb_testimonial_author, .dsdep-woo-tabs ul.et_pb_tabs_controls li.et_pb_tab_active a, .dsdep-woo-tabs ul.et_pb_tabs_controls li a:hover, .et-db #et-boc .et-l .dsdep-woo-tabs ul.et_pb_tabs_controls li.et_pb_tab_active a, .et-db #et-boc .et-l .dsdep-woo-tabs ul.et_pb_tabs_controls li a:hover, .dsdep-add-to-cart .woocommerce-variation-price .price, .et-db #et-boc .et-l .dsdep-add-to-cart .woocommerce-variation-price .price, #et-boc .et-l .woocommerce label, .woocommerce.et-db #et-boc .et-l .woocommerce-error, .woocommerce-page .woocommerce-error, .woocommerce .woocommerce-error, .woocommerce-page.et-db #et-boc .et-l .woocommerce-error, .woocommerce.et-db #et-boc .et-l .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-info, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info, .woocommerce.et-db #et-boc .et-l .woocommerce-message, .woocommerce-page .woocommerce-message, .woocommerce .woocommerce-message, .woocommerce-page.et-db #et-boc .et-l .woocommerce-message, .dsdep-my-account .woocommerce .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a, .woocommerce-order-received .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a, .woocommerce-order-received .woocommerce-order .woocommerce-thankyou-order-received, .woocommerce-order-received .woocommerce-order ul.woocommerce-order-overview li strong, .dsdep-checkout .woocommerce .dsdep-checkout-order table.shop_table tbody td.woocommerce-table__product-name a, .dsdep-checkout .woocommerce-page .dsdep-checkout-order table.shop_table tbody td.woocommerce-table__product-name a, .dsdep-my-account .woocommerce-MyAccount-navigation ul li a, .woocommerce ul.products li.product .price, .et_pb_wc_related_products ul.products li.product .price, .dsdep-reviews #reviews .commentlist .meta .woocommerce-review__author, .dsdep-woo-tabs .et_pb_tab_content #reviews .commentlist .meta .woocommerce-review__author, .dsdep-reviews #reviews #respond .comment-reply-title, .dsdep-woo-tabs .et_pb_tab_content #reviews #respond .comment-reply-title, .woocommerce span.onsale, .xoo-wsc-container .xoo-wsc-product .xoo-wsc-sum-col .xoo-wsc-pname a, .xoo-wsc-basket .xoo-wsc-bki, .remodal #wcqv_contend .product .price .woocommerce-Price-amount, .remodal .remodal-close {
            color : <?php esc_html_e($headers_color);?> !important;
        }

        /* Light Grey Color */
        .dsdep-background-color-light, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter .price_label span, .et-boc #sidebar .woocommerce.widget_price_filter .price_label span, .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls, .et-db #et-boc .et-l .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls, .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls:before, .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls:after, .et-db #et-boc .et-l .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls:before, .et-db #et-boc .et-l .dsdep-woo-tabs.dsdep-woo-tab-with-background ul.et_pb_tabs_controls:after, .dsdep-my-account .woocommerce .woocommerce-order-details, .woocommerce-order-received .woocommerce-order-details, .dsdep-checkout .woocommerce .dsdep-checkout-order, .dsdep-checkout .woocommerce-page .dsdep-checkout-order, .dsdep-my-account .woocommerce-MyAccount-navigation {
            background-color : <?php esc_html_e($light_grey);?> !important;
        }

        .dsdep-link-color-light a, .dsdep-link-hover-color-light a:hover, .dsdep-color-light, .dsdep-heading-color-light h1, .dsdep-heading-color-light h2, .dsdep-heading-color-light h3, .dsdep-heading-color-light h4, .dsdep-heading-color-light h5, .dsdep-heading-color-light h6 {
            color : <?php esc_html_e($light_grey);?> !important;
        }

        /* Dark Grey Color */
        .dsdep-background-color-dark {
            background-color : <?php esc_html_e($dark_grey);?> !important;
        }

        .dsdep-link-color-dark a, .dsdep-link-hover-color-dark a:hover, .dsdep-color-dark, .dsdep-heading-color-dark h1, .dsdep-heading-color-dark h2, .dsdep-heading-color-dark h3, .dsdep-heading-color-dark h4, .dsdep-heading-color-dark h5, .dsdep-heading-color-dark h6, .dsdep-checklist.checklist-dark ul li:before, .et-db #et-boc .et-l .dsdep-menuPrimary .et-menu-nav li.mega-menu > ul > li > a:first-child, .et-db #et-boc .et-l .dsdep-menuSecondary .et-menu-nav li.mega-menu > ul > li > a:first-child, .dsdep-blog .et_pb_post .post-meta, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-meta, .dsdep-blog .et_pb_post .post-meta .author a, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-meta .author a {
            color : <?php esc_html_e($dark_grey);?> !important;
        }

        /* Second Color */
        .dsdep-background-color-second, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter .ui-slider .ui-slider-range, .et-boc #sidebar .woocommerce.widget_price_filter .ui-slider .ui-slider-range, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter .ui-slider .ui-slider-handle, .et-boc #sidebar .woocommerce.widget_price_filter .ui-slider .ui-slider-handle, .woocommerce span.onsale {
            background-color : <?php esc_html_e($second_accent);?> !important;
        }

        .dsdep-button-underline-second, .et_pb_button.dsdep-button-underline-second, body.et-db #et-boc .dsdep-button-underline-second.et_pb_button, body .dsdep-button-underline-second.et_pb_button, .dsdep-module-button-underline-second .et_pb_button, .dsdep-link-color-second a, .dsdep-link-hover-color-second a:hover, .dsdep-color-second, .dsdep-heading-color-second h1, .dsdep-heading-color-second h2, .dsdep-heading-color-second h3, .dsdep-heading-color-second h4, .dsdep-heading-color-second h5, .dsdep-heading-color-second h6, .dsdep-checklist.checklist-secondary ul li:before, .dsdep-testimonial.has-rating .et_pb_testimonial_description_inner:after, .et-db #et-boc .et-l .dsdep-testimonial.has-rating .et_pb_testimonial_description_inner:after, .woocommerce .star-rating span:before, .woocommerce p.stars a:hover, .woocommerce p.stars.selected a, .woocommerce p.stars.selected a:not(.active)::before {
            color : <?php esc_html_e($second_accent);?> !important;
        }

        .dsdep-border-color-second {
            border-color : <?php esc_html_e($second_accent);?> !important;
        }

        /* Second Hover Color */
        .dsdep-button-underline-second:hover, .et_pb_button.dsdep-button-underline-second:hover, body.et-db #et-boc .dsdep-button-underline-second.et_pb_button:hover, body .dsdep-button-underline-second.et_pb_button:hover, .dsdep-module-button-underline-second .et_pb_button:hover {
            color : <?php esc_html_e($second_hover_accent);?> !important;
        }

        /* Main Color */
        .dsdep-background-color-primary, .dsdep-social-icons .et_pb_social_icon a.icon:hover, .et-db #et-boc .et-l .dsdep-social-icons .et_pb_social_icon a.icon:hover, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-controllers a:hover, .dsdep-slider.et_pb_slider .et-pb-controllers a:hover, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-controllers a.et-pb-active-control, .dsdep-slider.et_pb_slider .et-pb-controllers a.et-pb-active-control, .woocommerce ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a:hover, .et_pb_wc_related_products ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a:hover, .woocommerce ul.products li.product .button.add_to_cart_button:hover, .woocommerce ul.products li.product .button.ajax_add_to_cart.added:hover, .woocommerce ul.products li.product .button.ajax_add_to_cart.loading:hover, .woocommerce ul.products li.product .product_type_variable.button:hover, .woocommerce ul.products li.product.outofstock .button:hover, .woocommerce nav.woocommerce-pagination span.current, .et-db #et-boc nav.woocommerce-pagination span.current, .woocommerce span.new-badge, .wp-pagenavi span.current, .xoo-wsc-container .xoo-wsc-header, .xoo-wsc-basket .xoo-wsc-items-count, .dsdep-wishlist .tinv-wishlist .social-buttons ul li a:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist .social-buttons ul li a:hover {
            background-color : <?php esc_html_e($main_accent);?> !important;
        }

        .dsdep-button-underline-primary, .et_pb_button.dsdep-button-underline-primary, body.et-db #et-boc .dsdep-button-underline-primary.et_pb_button, body .dsdep-button-underline-primary.et_pb_button, .dsdep-module-button-underline-primary .et_pb_button, .dsdep-link-color-primary a, .dsdep-link-hover-color-primary a:hover, .dsdep-color-primary, .dsdep-heading-color-primary h1, .dsdep-heading-color-primary h2, .dsdep-heading-color-primary h3, .dsdep-heading-color-primary h4, .dsdep-heading-color-primary h5, .dsdep-heading-color-primary h6, .dsdep-checklist ul li:before, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu > li.menu-item > a:hover, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu > li.menu-item > a:hover, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu li.menu-item-has-children > a:after, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu li.menu-item-has-children > a:after, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu ul.sub-menu li a:hover, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu ul.sub-menu li a:hover, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu ul.sub-menu li.current-menu-item a, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu ul.sub-menu li.current-menu-item a, .dsdep-footer-widget-menu ul.menu li.current-menu-item a, .dsdep-footer-widget-menu ul.menu li a:hover, #sidebar .et_pb_widget.widget_recent_comments ul li a:hover, #sidebar .et_pb_widget.widget_recent_entries ul li a:hover, .dsdep-sidebar .et_pb_widget.widget_recent_comments ul li a:hover, .dsdep-sidebar .et_pb_widget.widget_recent_entries ul li a:hover, #sidebar .et_pb_widget.widget_search form:before, #sidebar .et_pb_widget.widget_product_search form:before, .dsdep-sidebar .et_pb_widget.widget_search form:before, .dsdep-sidebar .et_pb_widget.widget_product_search form:before, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search form:before, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search form:before, .et_pb_widget.widget_categories ul li a:hover, .et_pb_widget.widget_archive ul li a:hover, .et_pb_widget.widget_product_categories ul li a:hover, .et_pb_widget.woocommerce-widget-layered-nav ul li a:hover, .et_pb_widget.widget_categories ul li.current-cat a, .et_pb_widget.widget_archive ul li.current-cat a, .et_pb_widget.widget_product_categories ul li.current-cat a, .et_pb_widget.woocommerce-widget-layered-nav ul li.current-cat a, .dsdep-sidebar .widget_shopping_cart .total .amount, .woocommerce .widget_shopping_cart .total .amount, .woocommerce.widget_shopping_cart .total .amount, .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li span.product-title:hover, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li span.product-title:hover, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li a:not(.remove):hover, .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li a:hover, .et-db #et-boc .et-l #sidebar ul.product_list_widget li span.product-title:hover, .et-db #et-boc .et-l #sidebar ul.cart_list li span.product-title:hover, .et-db #et-boc .et-l #sidebar ul.cart_list li a:not(.remove):hover, .et-db #et-boc .et-l #sidebar ul.product_list_widget li a:hover, .dsdep-accordion .et_pb_toggle .et_pb_toggle_title:before, .et-db #et-boc .et-l .dsdep-accordion .et_pb_toggle .et_pb_toggle_title:before, .dsdep-accordion .et_pb_toggle:before, .et-db #et-boc .et-l .dsdep-accordion .et_pb_toggle:before, .dsdep-social-icons .et_pb_social_icon a.icon, .et-db #et-boc .et-l .dsdep-social-icons .et_pb_social_icon a.icon, .dsdep-blog .et_pb_post .entry-title:hover, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .entry-title:hover, .dsdep-blog .et_pb_post .post-meta .author a:hover, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-meta .author a:hover, .dsdep-search form.et_pb_searchform:before, .et-db #et-boc .et-l .dsdep-search form.et_pb_searchform:before, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-arrow-next, .et-db #et-boc .et-l .dsdep-slider.et_pb_slider .et-pb-arrow-prev, .dsdep-slider.et_pb_slider .et-pb-arrow-next, .dsdep-slider.et_pb_slider .et-pb-arrow-prev, .woocommerce.et-db #et-boc .et-l .woocommerce-info a, .woocommerce.et-db #et-boc .et-l .woocommerce-info a.button, .woocommerce-page .woocommerce-info a, .woocommerce-page .woocommerce-info a.button, .woocommerce .woocommerce-info a, .woocommerce .woocommerce-info a.button, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info a, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info a.button, .woocommerce.et-db #et-boc .et-l .woocommerce-info:before, .woocommerce-page .woocommerce-info:before, .woocommerce .woocommerce-info:before, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info:before, .woocommerce.et-db #et-boc .et-l .woocommerce-info a.button.wc-forward, .woocommerce.et-db #et-boc .et-l .woocommerce-info a.woocommerce-Button, .woocommerce-page .woocommerce-info a.button.wc-forward, .woocommerce-page .woocommerce-info a.woocommerce-Button, .woocommerce .woocommerce-info a.button.wc-forward, .woocommerce .woocommerce-info a.woocommerce-Button, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info a.button.wc-forward, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info a.woocommerce-Button, .dsdep-my-account .woocommerce mark, .woocommerce-order-received mark, .dsdep-my-account .woocommerce .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a:hover, .woocommerce-order-received .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a:hover, .dsdep-checkout .woocommerce .dsdep-checkout-order table.shop_table tbody td.woocommerce-table__product-name a:hover, .dsdep-checkout .woocommerce-page .dsdep-checkout-order table.shop_table tbody td.woocommerce-table__product-name a:hover, .dsdep-my-account .woocommerce-MyAccount-navigation ul li a:hover, .dsdep-my-account .woocommerce-MyAccount-navigation ul li.is-active a, .dsdep-my-account .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-number a, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-number a, .dsdep-checkout .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-number a, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-number a, .dsdep-my-account .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-actions a.woocommerce-button, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-actions a.woocommerce-button, .dsdep-checkout .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-actions a.woocommerce-button, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-actions a.woocommerce-button, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads a.woocommerce-MyAccount-downloads-file, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads a.woocommerce-MyAccount-downloads-file, .dsdep-cart table.shop_table td.product-name a:hover, #et-boc .et-l .dsdep-cart table.shop_table td.product-name a:hover, .woocommerce ul.products li.product .woocommerce-loop-product__title:hover, .et_pb_wc_related_products ul.products li.product .woocommerce-loop-product__title:hover, .woocommerce ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a, .et_pb_wc_related_products ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a, .woocommerce ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a.tinvwl_add_to_wishlist_button:before, .et_pb_wc_related_products ul.products li.product .divi-ecommerce-pro-shop-buttons-wrapper a.tinvwl_add_to_wishlist_button:before, .woocommerce ul.products li.product .button.add_to_cart_button, .woocommerce ul.products li.product .button.ajax_add_to_cart.added, .woocommerce ul.products li.product .button.ajax_add_to_cart.loading, .woocommerce ul.products li.product .product_type_variable.button, .woocommerce ul.products li.product.outofstock .button, .woocommerce nav.woocommerce-pagination a.page-numbers:hover, .et-db #et-boc nav.woocommerce-pagination a.page-numbers:hover, .woocommerce nav.woocommerce-pagination a.page-numbers.next, .woocommerce nav.woocommerce-pagination a.page-numbers.prev, .et-db #et-boc nav.woocommerce-pagination a.page-numbers.next, .et-db #et-boc nav.woocommerce-pagination a.page-numbers.prev, .dsdep-cart-contents:hover, .dsdep-cart-contents:before, .wp-pagenavi a.page:hover, .wp-pagenavi .nextpostslink, .wp-pagenavi .previouspostslink, .wp-pagenavi a.last, .wp-pagenavi a.first, .wp-pagenavi .nextpostslink:hover, .wp-pagenavi .previouspostslink:hover, .wp-pagenavi a.last:hover, .wp-pagenavi a.first:hover, .xoo-wsc-container .xoo-wsc-product .xoo-wsc-sum-col .xoo-wsc-pname a:hover, .xoo-wsc-basket:hover .xoo-wsc-bki, .remodal .remodal-close:hover, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-name a:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-name a:hover, .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, #et-boc .et-l .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, .tinvwl-after-add-to-cart .tinvwl_add_to_wishlist_button:hover, .widget_wishlist_products_counter a.wishlist_products_counter:hover, .wishlist_products_counter:hover, .wishlist_products_counter:before, ol.commentlist .comment.bypostauthor .comment_postinfo span.fn, ol.commentlist .comment .comment-reply-link {
            color : <?php esc_html_e($main_accent);?> !important;
        }

        .dsdep-border-color-primary, #sidebar .et_pb_widget.widget_tag_cloud .tagcloud a:hover, .dsdep-sidebar .et_pb_widget.widget_tag_cloud .tagcloud a:hover, #sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a:hover, .dsdep-sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a:hover, #sidebar .et_pb_widget.widget_search input[type=text]:focus, #sidebar .et_pb_widget.widget_search input[type=search]:focus, #sidebar .et_pb_widget.widget_product_search input[type=text]:focus, #sidebar .et_pb_widget.widget_product_search input[type=search]:focus, .dsdep-sidebar .et_pb_widget.widget_search input[type=text]:focus, .dsdep-sidebar .et_pb_widget.widget_search input[type=search]:focus, .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text]:focus, .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search]:focus, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=text]:focus, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=search]:focus, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text]:focus, .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search]:focus, .dsdep-widgettitle:before, .dsdep-sidebar .widgettitle:before, #sidebar .widgettitle:before, .dsdep-testimonial .et_pb_testimonial_portrait, .et-db #et-boc .et-l .dsdep-testimonial .et_pb_testimonial_portrait, .dsdep-woo-tabs ul.et_pb_tabs_controls li.et_pb_tab_active a, .dsdep-woo-tabs ul.et_pb_tabs_controls li a:hover, .et-db #et-boc .et-l .dsdep-woo-tabs ul.et_pb_tabs_controls li.et_pb_tab_active a, .et-db #et-boc .et-l .dsdep-woo-tabs ul.et_pb_tabs_controls li a:hover, .dsdep-optin input:focus, .dsdep-optin select:focus, .et-db #et-boc .et-l .dsdep-optin input:focus, .et-db #et-boc .et-l .dsdep-optin select:focus, .dsdep-optin textarea:focus, .et-db #et-boc .et-l .dsdep-optin textarea:focus, .dsdep-search input[type=text]:focus, .dsdep-search input[type=search]:focus, .et-db #et-boc .et-l .dsdep-search input[type=text]:focus, .et-db #et-boc .et-l .dsdep-search input[type=search]:focus, .dsdep-contact-form input:focus, .dsdep-contact-form p input:focus, .et-db #et-boc .et-l .dsdep-contact-form input:focus, .et-db #et-boc .et-l .dsdep-contact-form p input:focus, .dsdep-contact-form textarea:focus, .dsdep-contact-form p textarea:focus, .et-db #et-boc .et-l .dsdep-contact-form textarea:focus, .et-db #et-boc .et-l .dsdep-contact-form p textarea:focus, .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img.flex-active, .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img:hover, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img.flex-active, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img:hover, .dsdep-add-to-cart .variations select:focus, .et-db #et-boc .et-l .dsdep-add-to-cart .variations select:focus, .dsdep-add-to-cart input.qty:focus, .et-db #et-boc .et-l .dsdep-add-to-cart input.qty:focus, #et-boc .et-l .woocommerce input.text:focus, #et-boc .et-l .woocommerce input.input-text:focus, #et-boc .et-l .woocommerce input.title:focus, #et-boc .et-l .woocommerce input[type=email]:focus, #et-boc .et-l .woocommerce input[type=number]:focus, #et-boc .et-l .woocommerce input[type=password]:focus, #et-boc .et-l .woocommerce input[type=tel]:focus, #et-boc .et-l .woocommerce input[type=text]:focus, #et-boc .et-l .woocommerce input[type=url]:focus, #et-boc .et-l .woocommerce select:focus, #et-boc .et-l .woocommerce .select2-container--default .select2-selection--single:focus, #et-boc .et-l .woocommerce textarea:focus, #et-boc .et-l .woocommerce input[type=checkbox]:not(:disabled):hover:after, #et-boc .et-l .woocommerce input[type=checkbox]:not(:disabled):hover:before, .woocommerce-cart table.cart td.actions .coupon input.input-text:focus, .dsdep-reviews #reviews .commentlist .avatar, .dsdep-woo-tabs .et_pb_tab_content #reviews .commentlist .avatar, .woocommerce .quantity .qty:focus, .remodal #wcqv_contend .product .images .thumbnail:hover img, .remodal #wcqv_contend input.text:focus, .remodal #wcqv_contend input.input-text:focus, .remodal #wcqv_contend input.title:focus, .remodal #wcqv_contend input[type=email]:focus, .remodal #wcqv_contend input[type=password]:focus, .remodal #wcqv_contend input[type=tel]:focus, .remodal #wcqv_contend input[type=text]:focus, .remodal #wcqv_contend select:focus, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list input[type=checkbox]:not(:disabled):hover:after, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list input[type=checkbox]:not(:disabled):hover:after, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list input[type=checkbox]:not(:disabled):hover:before, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list input[type=checkbox]:not(:disabled):hover:before, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select:focus, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select:focus, ol.commentlist .comment.bypostauthor .comment_avatar img, #commentform input[type=text]:focus, #commentform input[type=email]:focus, #commentform input[type=url]:focus, #commentform textarea:focus, .dsdep-categories-list li a:hover, .dsdep-categories-list li.current-cat a, .blog .dsdep-categories-list .cat-item-all a {
            border-color : <?php esc_html_e($main_accent);?> !important;
        }

        #et-boc .et-l .woocommerce input[type=radio]:checked, #add_payment_method #payment ul.payment_methods input[type=radio]:checked, .woocommerce-cart #payment ul.payment_methods input[type=radio]:checked, .woocommerce-checkout #payment ul.payment_methods input[type=radio]:checked {
            box-shadow : inset 0 0 0 2px <?php esc_html_e($main_accent);?> !important;
        }

        /* Main Hover Color */
        .et_pb_button.dsdep-button-underline-primary:hover, body.et-db #et-boc .dsdep-button-underline-primary.et_pb_button:hover, body .dsdep-button-underline-primary.et_pb_button:hover, .dsdep-module-button-underline-primary .et_pb_button:hover, .dsdep-my-account .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-number a:hover, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-number a:hover, .dsdep-checkout .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-number a:hover, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-number a:hover, .dsdep-my-account .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-actions a.woocommerce-button:hover, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-actions a.woocommerce-button:hover, .dsdep-checkout .woocommerce table.woocommerce-orders-table td.woocommerce-orders-table__cell-order-actions a.woocommerce-button:hover, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads td.woocommerce-orders-table__cell-order-actions a.woocommerce-button:hover, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads a.woocommerce-MyAccount-downloads-file:hover, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads a.woocommerce-MyAccount-downloads-file:hover, .woocommerce nav.woocommerce-pagination a.page-numbers.next:hover, .woocommerce nav.woocommerce-pagination a.page-numbers.prev:hover, .et-db #et-boc nav.woocommerce-pagination a.page-numbers.next:hover, .et-db #et-boc nav.woocommerce-pagination a.page-numbers.prev:hover, ol.commentlist .comment .comment-reply-link:hover {
            color : <?php esc_html_e($main_hover_accent);?> !important;
        }

        /* Radius */
        .dsdep-borderRadius, .dsdep-borderRadiusImage img, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuPrimary ul.et_mobile_menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et-menu ul.sub-menu, .et-db #et-boc .et-l .dsdep-menuSecondary ul.et_mobile_menu, #sidebar .et_pb_widget.widget_tag_cloud .tagcloud a, .dsdep-sidebar .et_pb_widget.widget_tag_cloud .tagcloud a, #sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a, .dsdep-sidebar .et_pb_widget.widget_product_tag_cloud .tagcloud a, .dsdep-sidebar .widget_shopping_cart a.remove, .woocommerce .widget_shopping_cart a.remove, .woocommerce.widget_shopping_cart a.remove, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter .price_label span, .et-boc #sidebar .woocommerce.widget_price_filter .price_label span, .et-db #et-boc .et-l .dsdep-sidebar ul.product_list_widget li img, .et-db #et-boc .et-l .dsdep-sidebar ul.cart_list li img, .et-db #et-boc .et-l #sidebar ul.product_list_widget li img, .et-db #et-boc .et-l #sidebar ul.cart_list li img, .dsdep-social-icons .et_pb_social_icon a.icon, .et-db #et-boc .et-l .dsdep-social-icons .et_pb_social_icon a.icon, .dsdep-blog .et_audio_content, .dsdep-blog .et_main_video_container, .dsdep-blog .et_pb_slider, .dsdep-blog .et_pb_image_container, .dsdep-blog .post_format-post-format-quote .et_quote_content, .dsdep-blog:not(.et_pb_blog_grid_wrapper) .entry-featured-image-url, .et-db #et-boc .et-l .dsdep-blog .et_audio_content, .et-db #et-boc .et-l .dsdep-blog .et_main_video_container, .et-db #et-boc .et-l .dsdep-blog .et_pb_slider, .et-db #et-boc .et-l .dsdep-blog .et_pb_image_container, .et-db #et-boc .et-l .dsdep-blog .post_format-post-format-quote .et_quote_content, .et-db #et-boc .et-l .dsdep-blog:not(.et_pb_blog_grid_wrapper) .entry-featured-image-url, .dsdep-blog .et_pb_post, .et-db #et-boc .et-l .dsdep-blog .et_pb_post, .dsdep-testimonial .et_pb_testimonial_description, .et-db #et-boc .et-l .dsdep-testimonial .et_pb_testimonial_description, .dsdep-woo-images .woocommerce-product-gallery .woocommerce-product-gallery__image img, .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .woocommerce-product-gallery__image img, .et-db #et-boc .et-l .dsdep-woo-images .woocommerce-product-gallery .flex-control-thumbs img, .woocommerce.et-db #et-boc .et-l .woocommerce-error, .woocommerce-page .woocommerce-error, .woocommerocommerce-error, .woocommerce-page.et-db #et-boc .et-l .woocommerce-error, .woocommerce.et-db #et-boc .et-l .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-info, .woocommerce-page.et-db #et-boc .et-l .woocommerce-info, .woocommerce.et-db #et-boc .et-l .woocommerce-message, .woocommerce-page .woocommerce-message, .woocommerce .woocommerce-message, .woocommerce-page.et-db #et-boc .et-l .woocommerce-message, .dsdep-my-account .woocommerce .woocommerce-order-details, .woocommerce-order-received .woocommerce-order-details, .dsdep-checkout .woocommerce .dsdep-checkout-order, .dsdep-checkout .woocommerce-page .dsdep-checkout-order, #add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box, .dsdep-my-account .woocommerce-MyAccount-navigation .dsdep-my-account .woocommerce table.woocommerce-orders-table tbody tr:first-child td:first-child, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads tbody tr:first-child td:first-child, .dsdep-checkout .woocommerce table.woocommerce-orders-table tbody tr:first-child td:first-child, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads tbody tr:first-child td:first-child, .dsdep-my-account .woocommerce table.woocommerce-orders-table tbody tr:first-child td:last-child, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads tbody tr:first-child td:last-child, .dsdep-checkout .woocommerce table.woocommerce-orders-table tbody tr:first-child td:last-child, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads tbody tr:first-child td:last-child, .dsdep-my-account .woocommerce table.woocommerce-orders-table tbody tr:last-child td:first-child, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads tbody tr:last-child td:first-child, .dsdep-checkout .woocommerce table.woocommerce-orders-table tbody tr:last-child td:first-child, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads tbody tr:last-child td:first-child, .dsdep-my-account .woocommerce table.woocommerce-orders-table tbody tr:last-child td:last-child, .dsdep-my-account .woocommerce table.woocommerce-table--order-downloads tbody tr:last-child td:last-child, .dsdep-checkout .woocommerce table.woocommerce-orders-table tbody tr:last-child td:last-child, .dsdep-checkout .woocommerce table.woocommerce-table--order-downloads tbody tr:last-child td:last-child, .dsdep-cart table.shop_table, #et-boc .et-l .dsdep-cart table.shop_table, .dsdep-cart table.shop_table td.product-thumbnail img, #et-boc .et-l .dsdep-cart table.shop_table td.product-thumbnail img, .woocommerce ul.products li.product .et_shop_image img, .et_pb_wc_related_products ul.products li.product .et_shop_image img, .woocommerce nav.woocommerce-pagination span.current, .woocommerce nav.woocommerce-pagination a.page-numbers, .et-db #et-boc nav.woocommerce-pagination span.current, .et-db #et-boc nav.woocommerce-pagination a.page-numbers, .wp-pagenavi span.current, .wp-pagenavi a, .wp-pagenavi .nextpostslink, .wp-pagenavi .previouspostslink, .xoo-wsc-container .xoo-wsc-product .xoo-wsc-img-col img, .xoo-wsc-basket, .remodal, .remodal #wcqv_contend .product .images .thumbnail img, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-thumbnail img, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-thumbnail img, .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, #et-boc .et-l .dsdep-wishlist .tinv-wishlist .social-buttons ul li a, .tinv-modal .tinv-modal-inner {
            border-radius : <?php esc_html_e(get_theme_mod('dsdep_border_radius', 6));?>px !important;
        }

        #commentform textarea, #et-boc .et-l .woocommerce textarea, .dsdep-optin textarea, .et-db #et-boc .et-l .dsdep-optin textarea, .dsdep-contact-form textarea, .dsdep-contact-form p textarea, .et-db #et-boc .et-l .dsdep-contact-form textarea, .et-db #et-boc .et-l .dsdep-contact-form p textarea, #sidebar .et_pb_widget.widget_search input[type=text], #sidebar .et_pb_widget.widget_search input[type=search], #sidebar .et_pb_widget.widget_product_search input[type=text], #sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_search input[type=search], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=text], .et-db #et-boc .et-l .dsdep-sidebar .et_pb_widget.widget_product_search input[type=search], .dsdep-optin input, .dsdep-optin select, .et-db #et-boc .et-l .dsdep-optin input, .et-db #et-boc .et-l .dsdep-optin select, .dsdep-search input[type=text], .dsdep-search input[type=search], .et-db #et-boc .et-l .dsdep-search input[type=text], .et-db #et-boc .et-l .dsdep-search input[type=search], .dsdep-contact-form input, .dsdep-contact-form p input, .et-db #et-boc .et-l .dsdep-contact-form input, .et-db #et-boc .et-l .dsdep-contact-form p input, .dsdep-add-to-cart .variations select, .et-db #et-boc .et-l .dsdep-add-to-cart .variations select, .dsdep-add-to-cart input.qty, .et-db #et-boc .et-l .dsdep-add-to-cart input.qty, #et-boc .et-l .woocommerce input.text, #et-boc .et-l .woocommerce input.input-text, #et-boc .et-l .woocommerce input.title, #et-boc .et-l .woocommerce input[type=email], #et-boc .et-l .woocommerce input[type=number], #et-boc .et-l .woocommerce input[type=password], #et-boc .et-l .woocommerce input[type=tel], #et-boc .et-l .woocommerce input[type=text], #et-boc .et-l .woocommerce input[type=url], #et-boc .et-l .woocommerce select, #et-boc .et-l .woocommerce .select2-container--default .select2-selection--single, .woocommerce-cart table.cart td.actions .coupon input.input-text, .woocommerce .quantity .qty, .remodal #wcqv_contend input.text, .remodal #wcqv_contend input.input-text, .remodal #wcqv_contend input.title, .remodal #wcqv_contend input[type=email], .remodal #wcqv_contend input[type=password], .remodal #wcqv_contend input[type=tel], .remodal #wcqv_contend input[type=text], .remodal #wcqv_contend select, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot select, #commentform input[type=text], #commentform input[type=email], #commentform input[type=url] {
            border-radius : <?php esc_html_e(get_theme_mod('dsdep_form_border_radius', 6));?>px !important;
        }

        /*
         * Buttons
         */

        /* general button */
        .dsdep-button-primary, .et_pb_button.dsdep-button-primary, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-primary, body.et-db #et-boc .dsdep-button-primary.et_pb_button, body .dsdep-button-primary.et_pb_button, .dsdep-module-button-primary .et_pb_button, .dsdep-button-second, .et_pb_button.dsdep-button-second, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-second, body.et-db #et-boc .dsdep-button-second.et_pb_button, body .dsdep-button-second.et_pb_button, .dsdep-module-button-second .et_pb_button, .dsdep-button-outline, .et_pb_button.dsdep-button-outline, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-outline, body.et-db #et-boc .dsdep-button-outline.et_pb_button, body .dsdep-button-outline.et_pb_button, .dsdep-module-button-outline .et_pb_button, .dsdep-sidebar .widget_shopping_cart a.button, .woocommerce .widget_shopping_cart a.button, .woocommerce.widget_shopping_cart a.button, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter button.button, .et-boc #sidebar .woocommerce.widget_price_filter button.button, .dsdep-blog .et_pb_post .post-content a.more-link, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-content a.more-link, .dsdep-add-to-cart button.button, .et-db #et-boc .et-l .dsdep-add-to-cart button.button, #et-boc .et-l .woocommerce .woocommerce-Button, #et-boc .et-l .woocommerce input[type=submit], #et-boc .et-l .woocommerce button.button, .dsdep-checkout .woocommerce #payment #place_order, .dsdep-checkout .woocommerce-page #payment #place_order, .dsdep-my-account .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-checkout .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-cart table.shop_table thead th button.button, .dsdep-cart table.shop_table td.actions button.button, #et-boc .et-l .dsdep-cart table.shop_table thead th button.button, #et-boc .et-l .dsdep-cart table.shop_table td.actions button.button, .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, #et-boc .et-l .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, .dsdep-cart p.return-to-shop a.button.wc-backward, #et-boc .et-l .dsdep-cart p.return-to-shop a.button.wc-backward, .dsdep-reviews #reviews #respond input[type=submit], .dsdep-woo-tabs .et_pb_tab_content #reviews #respond input[type=submit], .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-cart, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-continue, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-checkout, .remodal #wcqv_contend .product .cart .button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply], #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply], .tinv-modal .tinvwl-buttons-group button.tinvwl_button_view, .tinv-modal .tinvwl-buttons-group button.tinvwl_button_close, #commentform .form-submit .et_pb_button {
            border-radius : <?php esc_html_e(get_theme_mod('dsdep_buttons_border_radius', 6));?>px !important;
            border-width  : <?php esc_html_e(get_theme_mod('dsdep_buttons_border_width', 2));?>px !important;
        }

        /* primary button */
        .dsdep-button-primary, .et_pb_button.dsdep-button-primary, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-primary, body.et-db #et-boc .dsdep-button-primary.et_pb_button, body .dsdep-button-primary.et_pb_button, .dsdep-module-button-primary .et_pb_button, .dsdep-add-to-cart button.button, .et-db #et-boc .et-l .dsdep-add-to-cart button.button, #et-boc .et-l .woocommerce .woocommerce-Button, #et-boc .et-l .woocommerce input[type=submit], #et-boc .et-l .woocommerce button.button, .dsdep-checkout .woocommerce #payment #place_order, .dsdep-checkout .woocommerce-page #payment #place_order, .dsdep-my-account .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-checkout .woocommerce .woocommerce-order-details .order-again a.button, .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, #et-boc .et-l .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-checkout, .remodal #wcqv_contend .product .cart .button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button, .tinv-modal .tinvwl-buttons-group button.tinvwl_button_view {
            border-color     : <?php esc_html_e($primary_button_border_color );?> !important;
            color            : <?php esc_html_e($primary_button_text_color );?> !important;
            background-color : <?php esc_html_e($primary_button_bg_color );?> !important;
        }

        .dsdep-button-primary:hover, .et_pb_button.dsdep-button-primary:hover, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-primary:hover, body.et-db #et-boc .dsdep-button-primary.et_pb_button:hover, body .dsdep-button-primary.et_pb_button:hover, .dsdep-module-button-primary .et_pb_button:hover, .dsdep-add-to-cart button.button:hover, .et-db #et-boc .et-l .dsdep-add-to-cart button.button:hover, #et-boc .et-l .woocommerce .woocommerce-Button:hover, #et-boc .et-l .woocommerce input[type=submit]:hover, #et-boc .et-l .woocommerce button.button:hover, .dsdep-checkout .woocommerce #payment #place_order:hover, .dsdep-checkout .woocommerce-page #payment #place_order:hover, .dsdep-my-account .woocommerce .woocommerce-order-details .order-again a.button:hover, .dsdep-checkout .woocommerce .woocommerce-order-details .order-again a.button:hover, .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button:hover, #et-boc .et-l .dsdep-cart .cart_totals .wc-proceed-to-checkout a.button:hover, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-checkout:hover, .remodal #wcqv_contend .product .cart .button:hover, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button:hover, .tinv-modal .tinvwl-buttons-group button.tinvwl_button_view:hover {
            border-color     : <?php esc_html_e($primary_button_hover_border_color );?> !important;
            color            : <?php esc_html_e($primary_button_hover_text_color );?> !important;
            background-color : <?php esc_html_e($primary_button_hover_bg_color );?> !important;
        }

        /* secondary button */
        .dsdep-button-second, .et_pb_button.dsdep-button-second, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-second, body.et-db #et-boc .dsdep-button-second.et_pb_button, body .dsdep-button-second.et_pb_button, .dsdep-module-button-second .et_pb_button, .dsdep-blog .et_pb_post .post-content a.more-link, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-content a.more-link, .dsdep-reviews #reviews #respond input[type=submit], .dsdep-woo-tabs .et_pb_tab_content #reviews #respond input[type=submit], .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button, #commentform .form-submit .et_pb_button {
            border-color     : <?php esc_html_e($secondary_button_border_color );?> !important;
            color            : <?php esc_html_e($secondary_button_text_color );?> !important;
            background-color : <?php esc_html_e($secondary_button_bg_color );?> !important;
        }

        .dsdep-button-second:hover, .et_pb_button.dsdep-button-second:hover, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-second:hover, body.et-db #et-boc .dsdep-button-second.et_pb_button:hover, body .dsdep-button-second.et_pb_button:hover, .dsdep-module-button-second .et_pb_button:hover, .dsdep-blog .et_pb_post .post-content a.more-link:hover, .et-db #et-boc .et-l .dsdep-blog .et_pb_post .post-content a.more-link:hover, .dsdep-reviews #reviews #respond input[type=submit]:hover, .dsdep-woo-tabs .et_pb_tab_content #reviews #respond input[type=submit]:hover, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button:hover, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action button:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list td.product-action a.button:hover, #commentform .form-submit .et_pb_button:hover {
            border-color     : <?php esc_html_e($secondary_button_hover_border_color );?> !important;
            color            : <?php esc_html_e($secondary_button_hover_text_color );?> !important;
            background-color : <?php esc_html_e($secondary_button_hover_bg_color );?> !important;
        }

        /* outline button */
        .dsdep-button-outline, .et_pb_button.dsdep-button-outline, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-outline, body.et-db #et-boc .dsdep-button-outline.et_pb_button, body .dsdep-button-outline.et_pb_button, .dsdep-module-button-outline .et_pb_button, .dsdep-sidebar .widget_shopping_cart a.button, .woocommerce .widget_shopping_cart a.button, .woocommerce.widget_shopping_cart a.button, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter button.button, .et-boc #sidebar .woocommerce.widget_price_filter button.button, .dsdep-cart table.shop_table thead th button.button, .dsdep-cart table.shop_table td.actions button.button, #et-boc .et-l .dsdep-cart table.shop_table thead th button.button, #et-boc .et-l .dsdep-cart table.shop_table td.actions button.button, .dsdep-cart p.return-to-shop a.button.wc-backward, #et-boc .et-l .dsdep-cart p.return-to-shop a.button.wc-backward, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-cart, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-continue, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply], #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply], .tinv-modal .tinvwl-buttons-group button.tinvwl_button_close {
            border-color     : <?php esc_html_e($outline_button_border_color );?> !important;
            color            : <?php esc_html_e($outline_button_text_color );?> !important;
            background-color : <?php esc_html_e($outline_button_bg_color );?> !important;
        }

        .dsdep-button-outline:hover, .et_pb_button.dsdep-button-outline:hover, body.et-db #et-boc .et-l .et_pb_button.dsdep-button-outline:hover, body.et-db #et-boc .dsdep-button-outline.et_pb_button:hover, body .dsdep-button-outline.et_pb_button:hover, .dsdep-module-button-outline .et_pb_button:hover, .dsdep-sidebar .widget_shopping_cart a.button:hover, .woocommerce .widget_shopping_cart a.button:hover, .woocommerce.widget_shopping_cart a.button:hover, .et-boc .dsdep-sidebar .woocommerce.widget_price_filter button.button:hover, .et-boc #sidebar .woocommerce.widget_price_filter button.button:hover, .dsdep-cart table.shop_table thead th button.button:hover, .dsdep-cart table.shop_table td.actions button.button:hover, #et-boc .et-l .dsdep-cart table.shop_table thead th button.button:hover, #et-boc .et-l .dsdep-cart table.shop_table td.actions button.button:hover, .dsdep-cart p.return-to-shop a.button.wc-backward:hover, #et-boc .et-l .dsdep-cart p.return-to-shop a.button.wc-backward:hover, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-cart:hover, .xoo-wsc-container .xoo-wsc-footer a.xoo-wsc-ft-btn-continue:hover, .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply]:hover, #et-boc .et-l .dsdep-wishlist .tinv-wishlist table.tinvwl-table-manage-list tfoot button[value=product_apply]:hover, .tinv-modal .tinvwl-buttons-group button.tinvwl_button_close:hover {
            border-color     : <?php esc_html_e($outline_button_hover_border_color );?> !important;
            color            : <?php esc_html_e($outline_button_hover_text_color );?> !important;
            background-color : <?php esc_html_e($outline_button_hover_bg_color );?> !important;
        }
    </style>
    <?php
}

add_action('wp_head', 'divi_ecommerce_pro_customize_css');

// close php tag
?>