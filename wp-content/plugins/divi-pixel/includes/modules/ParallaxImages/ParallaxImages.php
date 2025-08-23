<?php

class DIPI_ParallaxImages extends DIPI_Builder_Module {

    public $slug = 'dipi_parallax_images';
    public $vb_support = 'on';
    public $child_slug = 'dipi_parallax_images_item';
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );
    public function init() {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Parallax Images', 'dipi-divi-pixel');
    }
    public function get_settings_modal_toggles() {
        return [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'parallax_settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                ],
            ] 
            
        ];
    }
    public function get_custom_css_fields_config()     {
        $fields = [];
        return $fields;
    }

    public function get_fields() {
        $fields = [];
        // $fields['pi_height'] = [
        //     'label'             => esc_html__( 'Height', 'dipi-divi-pixel' ),
		// 		'type'           => 'range',
		// 		'tab_slug'       => 'general',
		// 		'toggle_slug'    => 'parallax_settings',
		// 		'default'        => '400px',
		// 		'default_unit'     => 'px',
		// 		'mobile_options' => true,
		// 		'responsive'     => true,
		// 		'range_settings' => array(
		// 			'min'  => '0',
		// 			'max'  => '2000',
		// 			'step' => '10',
        //         )
        // ];
        // yes_no_button active on container only
        $fields['pi_active_on_container'] = [
            'label'             => esc_html__( 'Activate on Container', 'dipi-divi-pixel' ),
                'type'           => 'yes_no_button',
                'tab_slug'       => 'general',
                'toggle_slug'    => 'parallax_settings',
                'options'        => array(
                    'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                    'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                ),
                'default'        => 'off',
        ];

        return $fields;
    }
   
    public function get_advanced_fields_config() {
        $advanced_fields = [];
        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;
 
        

        return $advanced_fields;
    }
    public function apply_css($render_slug) {
        // $this->process_range_field_css( array(
        //     'render_slug' => $render_slug,
        //     'slug'        => 'pi_height',
        //     'type'        => 'height',
        //     'default'     => '400px',
        //     'selector'    => '%%order_class%%',
        //     'important'   => false
        // ) );
    }
    public function render($attrs, $content, $render_slug) {
        wp_enqueue_script('dipi_parallax');
        wp_enqueue_script('dipi_parallax_images');
        $pi_active_on_container = $this->props['pi_active_on_container'] === 'on' ? 'on' : 'off';
        $this->apply_css($render_slug);
        return sprintf('
            <div class="dipi-parallax-images" data-hoveronly="%2$s">
                %1$s
            </div>
        ',  $this->props['content'],
            $pi_active_on_container
        );
    }
}
new DIPI_ParallaxImages;