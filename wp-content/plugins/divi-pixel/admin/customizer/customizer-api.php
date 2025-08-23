<?php

namespace DiviPixel;

class DIPI_Customizer_API
{
    /**
     * Settings prefix
     *
     * @since 1.8.0
     * @var array
     */
    protected $settings_prefix = 'dipi_';

    protected $panels = [];
    protected $sections = [];
    public $fields = [];
    private $font_choices;

    private static $instance = null;


    /**
     * Settings API instance
     *
     * @since 1.0.0
     * @return DIPI_Settings_API
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function include_icon($icon){
        echo '<div class="dipi-icon">';
        include plugin_dir_path(__FILE__) . "../assets/" . $icon . ".svg";
        echo '</div>';
    }


    public function customizer_controls_enqueue_scripts(){
        wp_enqueue_script("dipi_customizer_js", plugins_url('admin/customizer/js/customizer.js', constant('DIPI_PLUGIN_FILE')), ["jquery"], "1.0.0", false);
    }

    public function customize_register($wp_customize)
    {
        require_once plugin_dir_path(__FILE__) . 'class-customizer-divipixel-panel.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-divipixel-section.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-range-value-control.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-toggle-control.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-heading-control.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-quad-control.php';
        require_once plugin_dir_path(__FILE__) . 'class-customizer-font-style.php';
        
        wp_enqueue_style("dipi_font", plugins_url('dist/admin/css/dipi-font.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_customizer", plugins_url('admin/customizer/css/customizer.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');

        
        

        //Add Divi Pixel Options Panels
        foreach (DIPI_Customizer::instance()->get_panels() as $panel_id => $panel) {
            $options = [
                'title' => $panel['label'],
            ];

            if(isset($panel['description'])) {
                $options['description'] = $panel['description'];
            }

            if(isset($panel['priority'])) {
                $options['priority'] = $panel['priority'];
            }

            if(isset($panel['icon'])) {
                $options['icon'] = $panel['icon'];
            }

            $wp_customize->add_panel(new \Custmoizer_DiviPixel_Panel($wp_customize, $this->settings_prefix . $panel_id, $options));
            // $wp_customize->add_panel($this->set1tings_prefix . $panel_id, $options);
            //$wp_customize->add_panel(new \Custmoizer_DiviPixel_Panel($wp_customize, "dipi_customizer_panel_{$panel_id}", $options));
        }

        //Iterate over all sections and add the section as well as all the fields for each section
        foreach (DIPI_Customizer::instance()->get_sections() as $section_id => $section) {

            $section_options = [
                'title' => $section['label'],
                // 'panel' => $this->settings_prefix . $section['panel'],
                // 'priority' => $section['priority'], //TODO: implement priority or use default
                // 'capability' => 'edit_theme_options',
                // 'theme_supports' => '', // Rarely needed.
                // 'description_hidden' => true,
            ];
            if(isset($section['panel'])) {
                $section_options['panel'] = $this->settings_prefix . $section['panel'];
            }

            if(isset($section['priority'])) {
                $section_options['priority'] = $section['priority'];
            }

            if(isset($section['description'])) {
                $section_options['description'] = $section['description'];
            }

            if(isset($section['icon'])) {
                $section_options['icon'] = $section['icon'];
            }
            
            if(isset($section['description_hidden'])) {
                $section_options['description_hidden'] = $section['description_hidden'];
            }
            
            $wp_customize->add_section(new \Custmoizer_DiviPixel_Section($wp_customize, "dipi_customizer_section_{$section_id}" , $section_options));
            

            //Register all the settings fields
            foreach (DIPI_Customizer::instance()->get_fields() as $field_id => $field) {
                if (!isset($field['section']) || $field['section'] !== $section_id) {
                    continue;
                }

                $this->add_setting($wp_customize, $field_id, $field);
                $this->add_control($wp_customize, $section_id, $field_id, $field);
            }
        }
    }

    private function add_setting($wp_customize, $field_id, $field)
    {
        $prefix = DIPI_Customizer::settings_prefix();
        $setting_id = "{$prefix}{$field_id}";
        $setting_options = [
            'type' => 'option',
            'capability' => 'manage_options',
        ];

        if (isset($field['default'])) {
            $setting_options['default'] = $field['default'];
        }

        switch ($field['type']) {
            case 'border_radii':
            case 'padding':
            case 'margin':
                \Customizer_Quad_Control::add_settings($wp_customize, $setting_id, $setting_options);
                return;
            case 'font_weight':
                if(!isset($setting_options['default'])){
                    $setting_options['default'] = '400';
                }
                break;
            case 'checkbox':
                $setting_options['sanitize_callback'] = [$this, 'sanitize_checkbox'];
                break;
        }
        
        //Add the setting
        $wp_customize->add_setting($setting_id, $setting_options);
    }

    private function add_control($wp_customize, $section_id, $field_id, $field)
    {
        $prefix = DIPI_Customizer::settings_prefix();
        $control_id = "{$prefix}{$field_id}";
        $control_options = [
            'section' => "dipi_customizer_section_{$section_id}",
            'settings' => $control_id,
            'label' => $field['label'],
        ];

        if (isset($field['description'])) {
            $control_options['description'] = $field['description'];
        }
        
        if (isset($field['active_callback'])) {
            $control_options['active_callback'] = $field['active_callback'];
        }

        if (isset($field['cta'])) {
            $control_options['cta'] = $field['cta'];
        }

        if(isset($field['icon'])) {
            $control_options['icon'] = $field['icon'];
        }

        switch ($field['type']) {
            case 'select':
                $control_options['type'] = 'select';
                $control_options['choices'] = $field['options'];
                $wp_customize->add_control($control_id, $control_options);
                break;
            case 'color':
                $wp_customize->add_control(new \ET_Divi_Customize_Color_Alpha_Control($wp_customize, $control_id, $control_options));
                break;
            case 'range':
                $control_options['type'] = 'dipi-range-value';
                $control_options['input_attrs'] = $field['input_attrs'];
                $wp_customize->add_control(new \Customizer_Range_Value_Control($wp_customize, $control_id, $control_options));
                break;
            case 'checkbox':
                $control_options['type'] = 'light';
                $wp_customize->add_control(new \Customizer_Toggle_Control($wp_customize, $control_id, $control_options));
                break;
            case 'heading':
                $wp_customize->add_control(new \Customizer_Heading_Control($wp_customize, $control_id, $control_options));
                break;
            case 'font_style':
                $control_options['choices'] = et_divi_font_style_choices();
                $control_options['type'] = 'font_style';
                $wp_customize->add_control(new \Customizer_Font_Style($wp_customize, $control_id, $control_options));
                break;
            case 'font_weight':
                $control_options['type'] = 'dipi-range-value';
                $control_options['input_attrs'] = [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100,
                ];
                $wp_customize->add_control(new \Customizer_Range_Value_Control($wp_customize, $control_id, $control_options));
                break;
            case 'font':
                $control_options['type'] = 'select';
                $control_options['choices'] = $this->font_choices();
                $wp_customize->add_control(new \ET_Divi_Select_Option($wp_customize, $control_id, $control_options));
                break;
            case 'upload':
                $wp_customize->add_control(new \WP_Customize_Upload_Control($wp_customize, $control_id, $control_options));
                break;
            case 'divi_icon':
                $control_options['type'] = 'icon_picker';
                $wp_customize->add_control(new \ET_Divi_Icon_Picker_Option($wp_customize, $control_id, $control_options));
                break;
            case 'border_radii':
                $control_options["labels"] = [
                    esc_html__('Top-Left', 'dipi-divi-pixel'),
                    esc_html__('Top-Right', 'dipi-divi-pixel'),
                    esc_html__('Bottom-Left', 'dipi-divi-pixel'),
                    esc_html__('Bottom-Right', 'dipi-divi-pixel'),
                ];
                $control_options["columns"] = 2;
                $wp_customize->add_control(new \Customizer_Quad_Control($wp_customize, $control_id, $control_options));
                break;    
                case 'padding':
                case 'margin':
                $control_options["labels"] = [
                    esc_html__('Top', 'dipi-divi-pixel'),
                    esc_html__('Right', 'dipi-divi-pixel'),
                    esc_html__('Bottom', 'dipi-divi-pixel'),
                    esc_html__('Left', 'dipi-divi-pixel'),
                ];
                $control_options["columns"] = 4;
                $wp_customize->add_control(new \Customizer_Quad_Control($wp_customize, $control_id, $control_options));
                break;    
            case 'text':
            default:
                $control_options['type'] = 'text';
                $wp_customize->add_control(new \WP_Customize_Upload_Control($wp_customize, $control_id, $control_options));
                break;
                //TODO: more callbacks for different types
        }
    }

    private function font_choices(){
        if(isset($this->font_choices)){
            return $this->font_choices;
        }

        $site_domain = get_locale();

        $google_fonts = function_exists("et_builder_get_fonts") ? et_builder_get_fonts( array(
            'prepend_standard_fonts' => false,
        ) ) : [];

        $user_fonts = function_exists("et_builder_get_custom_fonts") ? et_builder_get_custom_fonts() : [];

        // combine google fonts with custom user fonts
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
        );

        $font_choices = array();
        $font_choices['none'] = array(
            'label' => 'Default Theme Font'
        );

        $removed_fonts_mapping = function_exists("et_builder_old_fonts_mapping") ? et_builder_old_fonts_mapping() : [];

        foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
            $use_parent_font = false;

            if ( isset( $removed_fonts_mapping[ $google_font_name ] ) ) {
                $parent_font = $removed_fonts_mapping[ $google_font_name ]['parent_font'];
                $google_font_properties['character_set'] = $google_fonts[ $parent_font ]['character_set'];
                $use_parent_font = true;
            }

            if ( '' !== $site_domain && isset( $et_domain_fonts[$site_domain] ) && isset( $google_font_properties['character_set'] ) && false === strpos( $google_font_properties['character_set'], $et_domain_fonts[$site_domain] ) ) {
                continue;
            }

            $font_choices[ $google_font_name ] = array(
                'label' => $google_font_name,
                'data'  => array(
                    'parent_font'    => $use_parent_font ? $google_font_properties['parent_font'] : '',
                    'parent_styles'  => $use_parent_font ? $google_fonts[$parent_font]['styles'] : $google_font_properties['styles'],
                    'current_styles' => $use_parent_font && isset( $google_fonts[$parent_font]['styles'] ) && isset( $google_font_properties['styles'] ) ? $google_font_properties['styles'] : '',
                    'parent_subset'  => $use_parent_font && isset( $google_fonts[$parent_font]['character_set'] ) ? $google_fonts[$parent_font]['character_set'] : '',
                    'standard'       => isset( $google_font_properties['standard'] ) && $google_font_properties['standard'] ? 'on' : 'off',
                )
            );
        }

        $this->font_choices = $font_choices;
        return $this->font_choices;
    }

    public function sanitize_checkbox($input)
    {
        return isset($input) && $input ? 'on' : 'off';
    }
}
