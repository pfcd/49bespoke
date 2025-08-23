<?php


namespace DNWoo_Essential\Includes;

defined( 'ABSPATH' ) || die();

if(! class_exists( 'Dnwoocustomizer')){


class Dnwoocustomizer{

    /**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

    /**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function __construct() {
        add_action('customize_register', array($this, 'dnwoo_customize_settings') );
        add_action('wp_enqueue_scripts', array($this, 'dnwoo_enqueue_mini_cart') );
        add_action('customize_preview_init', array($this, 'dnwoo_enqueue_customize_preview_mini_cart') );
        add_action('customize_controls_enqueue_scripts', array($this, 'dnwoo_customize_controls_enqueue_scripts') );
        
    }

    public function dnwoo_enqueue_mini_cart(){
        wp_enqueue_script('dnwoo-minicart');
        wp_enqueue_style('dnwoo-mini-cart-style', plugin_dir_url(__FILE__) . '../assets/css/mini-cart.css', time());
    }
    
    public function dnwoo_enqueue_customize_preview_mini_cart(){
        wp_enqueue_script('dnwoo-customizer-js', plugin_dir_url(__FILE__) . '../assets/js/customizer.js', array('jquery', 'customize-preview'),time(), true);
    }

    public function dnwoo_customize_controls_enqueue_scripts(){
        wp_enqueue_style('dnwoo-customizer-style',get_stylesheet_uri(), null, time());
        wp_enqueue_script( 'dnwoo-customizer-controls-js', plugin_dir_url(__FILE__) . '../assets/js/customizer-control.js', array( 'jquery' ),time(), true );
        
        $fly_out_lt = 'fly-out' === get_option('dnwoo_data_visibility') ? 'inline-block' : 'none';

        $mini_cart_control_style = <<<EOD
#customize-control-dnwoo_data_vb_fly_out{
    display: {$fly_out_lt};
}
EOD;
        
wp_add_inline_style('dnwoo-customizer-style', $mini_cart_control_style);
    }

    public function dnwoo_customize_settings( $dnwoo_customizer ) {
		$site_domain = get_locale();

		$google_fonts = et_builder_get_fonts(
			array(
				'prepend_standard_fonts' => false,
			)
		);

		$user_fonts = et_builder_get_custom_fonts();

		// combine google fonts with custom user fonts.
		$google_fonts = array_merge( $user_fonts, $google_fonts );

		$et_domain_fonts = array(
			'ru_RU' => 'cyrillic',
			'uk'    => 'cyrillic',
			'bg_BG' => 'cyrillic',
			'vi'    => 'vietnamese',
			'el'    => 'greek',
			'ar'    => 'arabic',
			'he_IL' => 'hebrew',
			'th'    => 'thai',
			'si_lk' => 'sinhala',
			'bn_bd' => 'bengali',
			'ta_lk' => 'tamil',
			'te'    => 'telegu',
			'km'    => 'khmer',
			'kn'    => 'kannada',
			'ml_in' => 'malayalam',
			'ja'    => 'japanese',
			'ko_KR' => 'korean',
			'ml_IN' => 'malayalam',
			'zh_CN' => 'chinese-simplified',
		);

		$font_choices         = array();
		$font_choices['none'] = array(
			'label' => 'Default Theme Font',
		);

		$removed_fonts_mapping = et_builder_old_fonts_mapping();

		foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
			$use_parent_font = false;

			if ( isset( $removed_fonts_mapping[ $google_font_name ] ) ) {
				$parent_font                             = $removed_fonts_mapping[ $google_font_name ]['parent_font'];
				$google_font_properties['character_set'] = $google_fonts[ $parent_font ]['character_set'];
				$use_parent_font                         = true;
			}

			if ( '' !== $site_domain && isset( $et_domain_fonts[ $site_domain ] ) && isset( $google_font_properties['character_set'] ) && false === strpos( $google_font_properties['character_set'], $et_domain_fonts[ $site_domain ] ) ) {
				continue;
			}

			$font_choices[ $google_font_name ] = array(
				'label' => $google_font_name,
				'data'  => array(
					'parent_font'    => $use_parent_font ? $google_font_properties['parent_font'] : '',
					'parent_styles'  => $use_parent_font ? $google_fonts[ $parent_font ]['styles'] : $google_font_properties['styles'],
					'current_styles' => $use_parent_font && isset( $google_fonts[ $parent_font ]['styles'] ) && isset( $google_font_properties['styles'] ) ? $google_font_properties['styles'] : '',
					'parent_subset'  => $use_parent_font && isset( $google_fonts[ $parent_font ]['character_set'] ) ? $google_fonts[ $parent_font ]['character_set'] : '',
					'standard'       => isset( $google_font_properties['standard'] ) && $google_font_properties['standard'] ? 'on' : 'off',
				),
			);
		}

        $dnwoo_customizer->add_panel( 'dnwoo_mini_cart_panel' , array(
            'title'		=> __( 'Divi Mini Cart', 'dnwooe' ),
            'priority'	=> 200,
        ) );
    
        $dnwoo_customizer->add_section('dnwoo_mini_cart',array(
            'title'=> __('Mini Cart Settings', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting( 'dnwoo_data_visibility', array(
            'type'      => 'option',
            'default'   => 'hover',
            'transport' => 'refresh'
        ) );

        $dnwoo_customizer->add_control( 'dnwoo_data_visibility_ctrl', array(
            'label'    => __( 'Mini Cart Display', 'dnwooe' ),
            'section'  => 'dnwoo_mini_cart',
            'settings' => 'dnwoo_data_visibility',
            'type'     => 'select',
            'choices'  => array(
                'hover' => 'Hover',
                'click' => 'Click',
                'fly-out'=> 'Fly Out'
            )
        ) );

        $dnwoo_customizer->selective_refresh->add_partial('dnwoo_mini_cart',array(
            'selector'=>'.dnwoo_minicart_icon',
            'settings'=>'dnwoo_data_visibility',
            'render_callback'=>function(){
                return get_theme_mod('dnwoo_data_visibility');
            }
        ) );
        
        $dnwoo_customizer->add_setting( 'dnwoo_data_vb_fly_out', array(
                'default'           => 'left',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'et_sanitize_left_right',
        )   );

        $dnwoo_customizer->add_control( 'dnwoo_data_vb_fly_out', array(
                'label'   => __( 'Fly Out Left / Right', 'dnwooe' ),
                'section' => 'dnwoo_mini_cart',
                'type'    => 'select',
                'choices' => et_divi_left_right_choices(),
        )   );
        

        $dnwoo_customizer->add_setting('dnwoo_mini_cart_selected_icon',array(
            'default'           => '',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_font_icon',
        ));

        $dnwoo_customizer->add_control(
            new \ET_Divi_Icon_Picker_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_selected_icon',
                array(
                    'label'   => __( 'Select Icon', 'dnwooe' ),
                    'section' => 'dnwoo_mini_cart',
                    'settings' => 'dnwoo_mini_cart_selected_icon',
                    'type'    => 'icon_picker',
                )
            )
        );

        $dnwoo_customizer->add_setting('dnwoo_mini_cart_icon_size', array(
                'default'           => '16',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option( 
            $dnwoo_customizer, 
            'dnwoo_mini_cart_icon_size',
            array(
                    'label'       => __( 'Icon Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );
    
        $dnwoo_customizer->add_setting('dnwoo_mini_cart_icon_color', array(
                'default'           => '#f6f7f7',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_icon_color',
                array(
                    'label'    => __( 'Icon Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart',
                    'settings' => 'dnwoo_mini_cart_icon_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_icon_bg',
            array(
                'default'           => '#3042fd',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
            )
        );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_icon_bg',
                array(
                    'label'    => __( 'Icon Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart',
                    'settings' => 'dnwoo_mini_cart_icon_bg',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_icon_bgbr',
            array(
                'default'           => '50',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_icon_bgbr',
                array(
                    'label'       => __( 'Icon Background Border Radius', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 100,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_count_bg',
            array(
                'default'           => '#6C4FFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
            )
        );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_count_bg',
                array(
                    'label'    => __( 'Count Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart',
                    'settings' => 'dnwoo_mini_cart_count_bg',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_count_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
            )
        );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_count_color',
                array(
                    'label'    => __( 'Count Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart',
                    'settings' => 'dnwoo_mini_cart_count_color',
                )
        )   );

        // Mini Cart Design
        $dnwoo_customizer->add_section('dnwoo_mini_cart_design',array(
            'title'=> __('Mini Cart Design', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_wbg_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_wbg_color',
                array(
                    'label'    => __( 'Mini Cart Window Background', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_wbg_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_window_width',
            array(
                'default'           => '325',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_window_width',
                array(
                    'label'       => __( 'Mini Cart Window Width', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 325,
                        'max'  => 500,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_heading_font_size',
            array(
                'default'           => '20',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_heading_font_size',
                array(
                    'label'       => __( 'Cart Heading Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_heading_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_heading_color',
                array(
                    'label'    => __( 'Cart Heading Font Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_heading_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_image_size',
            array(
                'default'           => '70',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_image_size',
                array(
                    'label'       => __( 'Image Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 200,
                        'step' => 1,
                    ),
                )
        )   );

		$dnwoo_customizer->add_setting(
			'dnwoo_mini_cart_title_text_item',
			array(
                'default'           => __( 'Items Selected', 'dnwooe' ),
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			)
		);

		$dnwoo_customizer->add_control(
			'dnwoo_mini_cart_title_text_item',
			array(
				'label'     => __( 'Title Text', 'dnwooe' ),
				'section'   => 'dnwoo_mini_cart_design',
                'settings'  => 'dnwoo_mini_cart_title_text_item',
				'type'      => 'text',
			)
		);

        $dnwoo_customizer->add_setting(
			'dnwoo_mini_cart_title_font',
			array(
				'default'           => 'none',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_choices',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Select_Option(
				$dnwoo_customizer,
				'dnwoo_mini_cart_title_font',
				array(
					'label'    => __( 'Title Font', 'dnwooe' ),
					'section'  => 'dnwoo_mini_cart_design',
					'settings' => 'dnwoo_mini_cart_title_font',
					'type'     => 'select',
					'choices'  => $font_choices,
				)
			)
		);

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_title_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_title_color',
                array(
                    'label'    => __( 'Title Font Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_title_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_title_font_size',
            array(
                'default'           => '16',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_title_font_size',
                array(
                    'label'       => __( 'Title Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_title_font_size',
            array(
                'default'           => '16',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_title_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_quantity_price_font_color',
            array(
                'default'           => '#999999',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_quantity_price_font_color',
                array(
                    'label'    => __( 'Quantity Price Font Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_quantity_price_font_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_quantity_price_font_size',
            array(
                'default'           => '14',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_quantity_price_font_size',
                array(
                    'label'       => __( 'Quantity Price Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_item_remove_btn_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_item_remove_btn_color',
                array(
                    'label'    => __( 'Item Remove Button Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_item_remove_btn_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_item_border_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_item_border_color',
                array(
                    'label'    => __( 'Mini Cart Item Border Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_item_border_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_subtotal_font_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_subtotal_font_color',
                array(
                    'label'    => __( 'Subtotal Font Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_subtotal_font_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_subtotal_font_size',
            array(
                'default'           => '16',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_subtotal_font_size',
                array(
                    'label'       => __( 'Subtotal Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_subtotal_price_font_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_mini_cart_subtotal_price_font_color',
                array(
                    'label'    => __( 'Subtotal Price Font Color', 'dnwooe' ),
                    'section'  => 'dnwoo_mini_cart_design',
                    'settings' => 'dnwoo_mini_cart_subtotal_price_font_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_subtotal_price_font_size',
            array(
                'default'           => '21',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_subtotal_price_font_size',
                array(
                    'label'       => __( 'Subtotal Price Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_mini_cart_design',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        // View Cart Button

        $dnwoo_customizer->add_section('dnwoo_view_cart_button',array(
            'title'=> __('View Cart Button', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_view_cart_text',array(
                'default'           => __( 'View Cart', 'dnwooe' ),
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_html_input_text',
			)
		);
        $dnwoo_customizer->add_control('dnwoo_view_cart_text',array(
            'label'   => __( 'View Cart Text', 'dnwooe' ),
            'section' => 'dnwoo_view_cart_button',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_cart_bg_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_view_cart_bg_color',
                array(
                    'label'    => __( 'View Button Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_view_cart_button',
                    'settings' => 'dnwoo_view_cart_bg_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_hbg_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_view_hbg_color',
                array(
                    'label'    => __( 'View Button Hover Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_view_cart_button',
                    'settings' => 'dnwoo_view_hbg_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_text_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_view_text_color',
                array(
                    'label'    => __( 'View Button Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_view_cart_button',
                    'settings' => 'dnwoo_view_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_btn_hover_text_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_view_btn_hover_text_color',
                array(
                    'label'    => __( 'View Button Text Hover Color', 'dnwooe' ),
                    'section'  => 'dnwoo_view_cart_button',
                    'settings' => 'dnwoo_view_btn_hover_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_vbr',
            array(
                'default'           => '0',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_view_vbr',
                array(
                    'label'       => __( 'View Button Border Radius', 'dnwooe' ),
                    'section'     => 'dnwoo_view_cart_button',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_view_button_border_color',
            array(
                'default'           => 'rgba(0,0,0,0.2)',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_view_button_border_color',
                array(
                    'label'    => __( 'View Button Border Color', 'dnwooe' ),
                    'section'  => 'dnwoo_view_cart_button',
                    'settings' => 'dnwoo_view_button_border_color',
                )
        )   );

        $dnwoo_customizer->add_setting(
            'dnwoo_view_buttons_font_style',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_style',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Font_Style_Option(
				$dnwoo_customizer,
				'dnwoo_view_buttons_font_style',
				array(
					'label'   => __( 'View Button Font Style', 'dnwooe' ),
					'section' => 'dnwoo_view_cart_button',
					'type'    => 'font_style',
					'choices' => et_divi_font_style_choices(),
				)
			)
		);

        $dnwoo_customizer->add_setting(
			'dnwoo_view_buttons_font',
			array(
				'default'           => 'none',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_choices',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Select_Option(
				$dnwoo_customizer,
				'dnwoo_view_buttons_font',
				array(
					'label'    => __( 'View Buttons Font', 'dnwooe' ),
					'section'  => 'dnwoo_view_cart_button',
					'settings' => 'dnwoo_view_buttons_font',
					'type'     => 'select',
					'choices'  => $font_choices,
				)
			)
		);

        // Checkout Button
        $dnwoo_customizer->add_section('dnwoo_checkout_button',array(
            'title'=> __('Checkout Button', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_checkout_text',array(
            'default'           => __( 'Checkout', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );

        $dnwoo_customizer->add_control('dnwoo_checkout_text',array(
            'label'   => __( 'Checkout Text', 'dnwooe' ),
            'section' => 'dnwoo_checkout_button',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_checkout_bg_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_checkout_bg_color',
                array(
                    'label'    => __( 'Checkout Button Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_checkout_button',
                    'settings' => 'dnwoo_checkout_bg_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_checkout_hbg_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_checkout_hbg_color',
                array(
                    'label'    => __( 'Checkout Button Hover Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_checkout_button',
                    'settings' => 'dnwoo_checkout_hbg_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_checkout_text_color',
            array(
                'default'           => '#FFFFFF',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_checkout_text_color',
                array(
                    'label'    => __( 'Checkout Button Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_checkout_button',
                    'settings' => 'dnwoo_checkout_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_checkout_btn_hover_text_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_checkout_btn_hover_text_color',
                array(
                    'label'    => __( 'Checkout Button Text Hover Color', 'dnwooe' ),
                    'section'  => 'dnwoo_checkout_button',
                    'settings' => 'dnwoo_checkout_btn_hover_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_mini_cart_cbr',
            array(
                'default'           => '0',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_mini_cart_cbr',
                array(
                    'label'       => __( 'Checkout Button Border Radius', 'dnwooe' ),
                    'section'     => 'dnwoo_checkout_button',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_checkout_btn_border_hover_color',
            array(
                'default'           => 'rgba(0,0,0,0.2)',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_checkout_btn_border_hover_color',
                array(
                    'label'    => __( 'Checkout Button Border Hover Color', 'dnwooe' ),
                    'section'  => 'dnwoo_checkout_button',
                    'settings' => 'dnwoo_checkout_btn_border_hover_color',
                )
        )   );

        $dnwoo_customizer->add_setting(
            'dnwoo_checkout_buttons_font_style',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_style',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Font_Style_Option(
				$dnwoo_customizer,
				'dnwoo_checkout_buttons_font_style',
				array(
					'label'   => __( 'Checkout Button Font Style', 'dnwooe' ),
					'section' => 'dnwoo_checkout_button',
					'type'    => 'font_style',
					'choices' => et_divi_font_style_choices(),
				)
			)
		);

        $dnwoo_customizer->add_setting(
			'dnwoo_checkout_buttons_font',
			array(
				'default'           => 'none',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_choices',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Select_Option(
				$dnwoo_customizer,
				'dnwoo_checkout_buttons_font',
				array(
					'label'    => __( 'Checkout Buttons Font', 'dnwooe' ),
					'section'  => 'dnwoo_checkout_button',
					'settings' => 'dnwoo_checkout_buttons_font',
					'type'     => 'select',
					'choices'  => $font_choices,
				)
			)
		);

        // Empty Cart Button

        $dnwoo_customizer->add_section('dnwoo_empty_cart',array(
            'title'=> __('Empty Cart', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_empty_cart_text',array(
                'default'           => __( 'No products in the cart', 'dnwooe' ),
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_html_input_text',
            )
        );
        $dnwoo_customizer->add_control('dnwoo_empty_cart_text',array(
            'label'   => __( 'Empty Cart Text', 'dnwooe' ),
            'section' => 'dnwoo_empty_cart',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_empty_cart_text_color',
            array(
                'default'           => '#333333',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
        )   );
    
        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_empty_cart_text_color',
                array(
                    'label'    => __( 'Empty Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_empty_cart',
                    'settings' => 'dnwoo_empty_cart_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting( 
            'dnwoo_empty_cart_text_font_size',
            array(
                'default'           => '20',
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'et_sanitize_float_number',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Range_Option(
                $dnwoo_customizer,
                'dnwoo_empty_cart_text_font_size',
                array(
                    'label'       => __( 'Empty Cart Font Size', 'dnwooe' ),
                    'section'     => 'dnwoo_empty_cart',
                    'type'        => 'range',
                    'input_attrs' => array(
                        'min'  => 10,
                        'max'  => 32,
                        'step' => 1,
                    ),
                )
        )   );

        $dnwoo_customizer->add_setting(
            'dnwoo_empty_cart_font_style',
			array(
				'default'           => '',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_style',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Font_Style_Option(
				$dnwoo_customizer,
				'dnwoo_empty_cart_font_style',
				array(
					'label'   => __( 'Empty Font Style', 'dnwooe' ),
					'section' => 'dnwoo_empty_cart',
					'type'    => 'font_style',
					'choices' => et_divi_font_style_choices(),
				)
			)
		);

        $dnwoo_customizer->add_setting(
			'dnwoo_empty_cart_font',
			array(
				'default'           => 'none',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'et_sanitize_font_choices',
			)
		);

		$dnwoo_customizer->add_control(
			new \ET_Divi_Select_Option(
				$dnwoo_customizer,
				'dnwoo_empty_cart_font',
				array(
					'label'    => __( 'Emypty Font', 'dnwooe' ),
					'section'  => 'dnwoo_empty_cart',
					'settings' => 'dnwoo_empty_cart_font',
					'type'     => 'select',
					'choices'  => $font_choices,
				)
			)
		);

        // Mini Cart Coupon Code
        
        $dnwoo_customizer->add_section('dnwoo_coupon_code_display',array(
            'title'=> __('Coupon Code Display', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        // Show Coupon Code Display
        $dnwoo_customizer->add_setting('dnwooe_show_coupon_code',array(
            'default'           => '',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_validate_boolean',
        )   );

        $dnwoo_customizer->add_control('dnwooe_show_coupon_code',array(
            'label'   => __( 'Show Coupon', 'dnwooe' ),
            'section' => 'dnwoo_coupon_code_display',
            'type'    => 'checkbox',
        )   );

        // Shipping Fee Display
        $dnwoo_customizer->add_setting('dnwooe_show_shipping_fee',array(
            'default'           => '',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_validate_boolean',
        )   );

        $dnwoo_customizer->add_control('dnwooe_show_shipping_fee',array(
            'label'   => __( 'Show Shipping Fee', 'dnwooe' ),
            'section' => 'dnwoo_coupon_code_display',
            'type'    => 'checkbox',
        )   );

        // Tax Fee Display
        $dnwoo_customizer->add_setting('dnwooe_show_tax_fee',array(
            'default'           => '',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_validate_boolean',
        )   );

        $dnwoo_customizer->add_control('dnwooe_show_tax_fee',array(
            'label'   => __( 'Show Tax Fee', 'dnwooe' ),
            'section' => 'dnwoo_coupon_code_display',
            'type'    => 'checkbox',
        )   );

        // Total Price Display
        $dnwoo_customizer->add_setting('dnwooe_show_total_price',array(
            'default'           => '',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_validate_boolean',
        )   );

        $dnwoo_customizer->add_control('dnwooe_show_total_price',array(
            'label'   => __( 'Show Total Price', 'dnwooe' ),
            'section' => 'dnwoo_coupon_code_display',
            'type'    => 'checkbox',
        )   );

        // Coupon Code Text
        $dnwoo_customizer->add_section('dnwoo_coupon_code',array(
            'title'=> __('Coupon Code Text', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
        $dnwoo_customizer->add_setting('dnwoo_coupon_code_text',array(
            'default'           => __( 'Coupon Code', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_code_text',array(
            'label'   => __( 'Coupon Code Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_code',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_code_text_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_code_text_color',
                array(
                    'label'    => __( 'Coupon Code Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_code',
                    'settings' => 'dnwoo_coupon_code_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_code_icon_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_code_icon_color',
                array(
                    'label'    => __( 'Coupon Code Icon Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_code',
                    'settings' => 'dnwoo_coupon_code_icon_color',
                )
        )   );
        
        // Apply Coupon Button
        $dnwoo_customizer->add_section('dnwoo_apply_button',array(
            'title'=> __('Apply Button', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_placeholder_text',array(
            'default'           => __( 'Enter Coupon Code', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );

        $dnwoo_customizer->add_control('dnwoo_coupon_placeholder_text',array(
            'label'   => __( 'Place Holder Text', 'dnwooe' ),
            'section' => 'dnwoo_apply_button',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_apply_button_text',array(
            'default'           => __( 'Apply', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_apply_button_text',array(
            'label'   => __( 'Apply Text', 'dnwooe' ),
            'section' => 'dnwoo_apply_button',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_apply_button_text_color', array(
            'default'           => '#FFFFFF',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_apply_button_text_color',
                array(
                    'label'    => __( 'Apply Button Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_apply_button',
                    'settings' => 'dnwoo_apply_button_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting('dnwoo_apply_button_bg_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_apply_button_bg_color',
                array(
                    'label'    => __( 'Apply Button Background Color', 'dnwooe' ),
                    'section'  => 'dnwoo_apply_button',
                    'settings' => 'dnwoo_apply_button_bg_color',
                )
        )   );

        // Discount Text
        $dnwoo_customizer->add_section('dnwoo_discoun',array(
            'title'=> __('Discount', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
        $dnwoo_customizer->add_setting('dnwoo_discount_text',array(
            'default'           => __( 'Discount', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_discount_text',array(
            'label'   => __( 'Discount Text', 'dnwooe' ),
            'section' => 'dnwoo_discoun',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_discount_text_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_discount_text_color',
                array(
                    'label'    => __( 'Discount Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_discoun',
                    'settings' => 'dnwoo_discount_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting('dnwoo_discount_price_color', array(
            'default'           => '#E8112B',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_discount_price_color',
                array(
                    'label'    => __( 'Discount Price Color', 'dnwooe' ),
                    'section'  => 'dnwoo_discoun',
                    'settings' => 'dnwoo_discount_price_color',
                )
        )   );
        
        $dnwoo_customizer->add_setting('dnwoo_discount_remove_coupon_color', array(
            'default'           => '#009A34',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_discount_remove_coupon_color',
                array(
                    'label'    => __( 'Remove Coupon Code Color', 'dnwooe' ),
                    'section'  => 'dnwoo_discoun',
                    'settings' => 'dnwoo_discount_remove_coupon_color',
                )
        )   );
        

        // Coupon Message Text
        $dnwoo_customizer->add_section('dnwoo_coupon_message',array(
            'title'=> __('Coupon Message', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
                    // Coupon Message Remove
        $dnwoo_customizer->add_setting('dnwoo_coupon_message_remove_text',array(
            'default'           => __( 'Coupon Removed Successfully.', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_message_remove_text',array(
            'label'   => __( 'Coupon Message Remove Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_message',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_message_remove_text_color', array(
            'default'           => '#777C90',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_message_remove_text_color',
                array(
                    'label'    => __( 'Coupon Message Remove Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_message',
                    'settings' => 'dnwoo_coupon_message_remove_text_color',
                )
        )   );
                    // Coupon Message Empty
        $dnwoo_customizer->add_setting('dnwoo_coupon_message_empty_text',array(
            'default'           => __( 'Coupon Code Empty', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_message_empty_text',array(
            'label'   => __( 'Coupon Message Successfully Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_message',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_message_empty_text_color', array(
            'default'           => '#777C90',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_message_empty_text_color',
                array(
                    'label'    => __( 'Coupon Message Empty Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_message',
                    'settings' => 'dnwoo_coupon_message_empty_text_color',
                )
        )   );
                    // Coupon Message Applied
        $dnwoo_customizer->add_setting('dnwoo_coupon_message_applied_text',array(
            'default'           => __( 'Coupon Code Already Applied', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_message_applied_text',array(
            'label'   => __( 'Coupon Message Applied Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_message',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_message_applied_text_color', array(
            'default'           => '#777C90',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_message_applied_text_color',
                array(
                    'label'    => __( 'Coupon Message Applied Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_message',
                    'settings' => 'dnwoo_coupon_message_applied_text_color',
                )
        )   );
                    // Coupon Message Success
        $dnwoo_customizer->add_setting('dnwoo_coupon_message_success_text',array(
            'default'           => __( 'Coupon applied successfully', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_message_success_text',array(
            'label'   => __( 'Coupon Message Successfully Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_message',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_message_success_text_color', array(
            'default'           => '#777C90',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_message_success_text_color',
                array(
                    'label'    => __( 'Coupon Message Success Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_message',
                    'settings' => 'dnwoo_coupon_message_success_text_color',
                )
        )   );
                    // Coupon Message Invaild
        $dnwoo_customizer->add_setting('dnwoo_coupon_message_invaild_text',array(
            'default'           => __( 'Coupon Code is Invalid!', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_coupon_message_invaild_text',array(
            'label'   => __( 'Coupon Message Invaild Text', 'dnwooe' ),
            'section' => 'dnwoo_coupon_message',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_coupon_message_invaild_text_color', array(
            'default'           => '#777C90',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_coupon_message_invaild_text_color',
                array(
                    'label'    => __( 'Coupon Message Invaild Color', 'dnwooe' ),
                    'section'  => 'dnwoo_coupon_message',
                    'settings' => 'dnwoo_coupon_message_invaild_text_color',
                )
        )   );

        // Shipping Text
        $dnwoo_customizer->add_section('dnwoo_shipping_fee',array(
            'title'=> __('Shipping Fee', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
        $dnwoo_customizer->add_setting('dnwoo_shipping_fee_text',array(
            'default'           => __( 'Shipping Fee', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_shipping_fee_text',array(
            'label'   => __( 'Shipping Text', 'dnwooe' ),
            'section' => 'dnwoo_shipping_fee',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_shipping_fee_text_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_shipping_fee_text_color',
                array(
                    'label'    => __( 'Shipping Fee Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_shipping_fee',
                    'settings' => 'dnwoo_shipping_fee_text_color',
                )
        )   );

        $dnwoo_customizer->add_setting('dnwoo_shipping_icon_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_shipping_icon_color',
                array(
                    'label'    => __( 'Shipping Icon Color', 'dnwooe' ),
                    'section'  => 'dnwoo_shipping_fee',
                    'settings' => 'dnwoo_shipping_icon_color',
                )
        )   );

        // Tax Fee
        $dnwoo_customizer->add_section('dnwoo_tax_fee',array(
            'title'=> __('Tax Fee', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
        $dnwoo_customizer->add_setting('dnwoo_tax_fee_text',array(
            'default'           => __( 'Tax', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_tax_fee_text',array(
            'label'   => __( 'Shipping Text', 'dnwooe' ),
            'section' => 'dnwoo_tax_fee',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_tax_fee_text_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_tax_fee_text_color',
                array(
                    'label'    => __( 'Tax Fee Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_tax_fee',
                    'settings' => 'dnwoo_tax_fee_text_color',
                )
        )   );

        // Total Price
        $dnwoo_customizer->add_section('dnwoo_total_price',array(
            'title'=> __('Total', 'dnwooe'),
            'panel'=> 'dnwoo_mini_cart_panel',
        )   );
        $dnwoo_customizer->add_setting('dnwoo_total_price_text',array(
            'default'           => __( 'Total', 'dnwooe' ),
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'et_sanitize_html_input_text',
        )   );
        $dnwoo_customizer->add_control('dnwoo_total_price_text',array(
            'label'   => __( 'Shipping Text', 'dnwooe' ),
            'section' => 'dnwoo_total_price',
            'type'    => 'text',
        )   );

        $dnwoo_customizer->add_setting('dnwoo_total_price_text_color', array(
            'default'           => '#333333',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
        )   );

        $dnwoo_customizer->add_control(
            new \ET_Divi_Customize_Color_Alpha_Control(
                $dnwoo_customizer,
                'dnwoo_total_price_text_color',
                array(
                    'label'    => __( 'Total Text Color', 'dnwooe' ),
                    'section'  => 'dnwoo_total_price',
                    'settings' => 'dnwoo_total_price_text_color',
                )
        )   );
    }
}
Dnwoocustomizer::get_instance();
}





