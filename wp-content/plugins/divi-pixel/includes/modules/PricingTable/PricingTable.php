<?php

class DIPI_PricingTable extends DIPI_Builder_Module
{

    public $slug = 'dipi_pricing_table';
    public $vb_support = 'on';
    public $child_slug = 'dipi_pricing_table_item';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Pricing Table', 'dipi-divi-pixel');
    }

    public function get_fields() {
        $fields = [];
        $fields['use_animation'] = [
            'label'           => esc_html__( 'Use Animation', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug' => 'pt_animation',
            'tab_slug'    => 'general',
            
        ];
        $fields['items_animation'] = [
            'label'   => esc_html__('Items Animation', 'dipi-divi-pixel'),
            'type'    => 'select',
            'default' => 'fadeInUpShort',
            'options' => array(
                'fadeIn'                => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'       => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort'      => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort'         => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort'       => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort'           => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort'         => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort'     => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort'    => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort'       => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort'     => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort'          => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort'          => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort'     => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort'         => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel')
            ),
            'toggle_slug' => 'pt_animation',
            'tab_slug'    => 'general',
            'show_if'     => ['use_animation' => 'on']
        ];
        
        $fields['use_animation_delay'] = [
            'label'           => esc_html__( 'Use Animation Delay', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug' => 'pt_animation',
            'tab_slug'    => 'general',
            'show_if'     => ['use_animation' => 'on']
        ];
        
        $fields['items_animation_delay'] = [
            'label'        => esc_html__( 'Animation Delay', 'dipi-divi-pixel' ),
            'type'         => 'range',
            'default'      => '200ms',
            'default_unit' => 'ms',
            'range_settings' => array(
                'min'  => '0',
                'max'  => '2000',
                'step' => '100',
            ),
            'mobile_options' => true,
            'responsive'     => true,
            'toggle_slug' => 'pt_animation',
            'tab_slug'    => 'general' ,
            'show_if'     => [
                'use_animation' => 'on',
                'use_animation_delay' => 'on'
            ]
        ];

        return $fields;
    }
 
    public function get_settings_modal_toggles()
    {
        $toggles = [];

        $toggles['general'] = [
            'toggles' => [
                'pt_animation' => esc_html__('Animations', 'dipi-divi-pixel')
            ]       
        ];

        return $toggles;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
 
        return $fields;
    }
  
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
      
        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_style('magnific-popup');
        wp_enqueue_script('magnific-popup');

        $contents = et_core_sanitized_previously($this->content);
        $use_animation = (isset($this->props['use_animation']) && !empty($this->props['use_animation'])) ? $this->props['use_animation'] : 'off';
       
        if($use_animation === 'on') {
            
            wp_enqueue_script('dipi_pricing_table');
        }

        if($use_animation == 'off') {
            return $contents;
        }

        if($use_animation == 'on') {
            
            $items_animation = (isset($this->props['items_animation']) && !empty($this->props['items_animation'])) ? $this->props['items_animation'] : 'fadeIn';
            $use_animation_delay = (isset($this->props['use_animation_delay']) && !empty($this->props['use_animation_delay'])) ? $this->props['use_animation_delay'] : 'off';
            $animation_delay = (isset($this->props['items_animation_delay']) && !empty($this->props['items_animation_delay'])) ? $this->props['items_animation_delay'] : '200ms';

             
            return sprintf('
                    <div 
                        class="dipi-pt-animation" 
                        style="opacity:0" 
                        data-animation="%2$s" 
                        data-use-delay="%3$s"
                        data-delay="%4$s"
                    >
                        %1$s
                    </div>',
                    $contents,
                    $items_animation,
                    $use_animation_delay,
                    $animation_delay
            );
        }
    }
}

new DIPI_PricingTable;
