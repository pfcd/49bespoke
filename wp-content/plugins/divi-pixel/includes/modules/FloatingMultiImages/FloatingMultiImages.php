<?php

class DIPI_FloatingMultiImages extends DIPI_Builder_Module {

  protected $module_credits = array(
    'module_uri' => 'https://divi-pixel.com/modules/floating_multi_images',
    'author' => 'Divi Pixel',
    'author_uri' => 'https://divi-pixel.com',
  );

  public function init() {
    $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
    $this->slug         = 'dipi_floating_multi_images';
    $this->vb_support   = 'on';
    $this->child_slug   = 'dipi_floating_multi_images_child';
    $this->name         = esc_html__('Pixel Floating Images', 'dipi-divi-pixel');
    $this->settings_modal_toggles = [
      'general' => [
        'toggles' => [
          'settings' => esc_html__( 'Settings', 'dipi-divi-pixel' ),
        ],
      ],
      'advanced' => [
        'toggles' => [
        ]
      ]
    ];

  }

  public function get_fields(){
    $fields = [];

    $fields['fmi_height'] = [
      'label'           => esc_html__( 'Height', 'dipi-divi-pixel'),
      'type'            => 'range',
      'option_category' => 'layout',
      'mobile_options'  => true,
      'validate_unit'   => true,
      'default'         => '460px',
      'default_unit'    => 'px',
      'default_on_front'=> '',
      'range_settings'  => [
        'min'  => '1',
        'max'  => '1280',
        'step' => '1',
      ],
      'responsive'      => true,
      'toggle_slug'     => 'settings',
    ];

    return $fields;
  }

  public function get_advanced_fields_config(){
    $advanced_fields = [];

    $advanced_fields["text"] = false;
    $advanced_fields["fonts"] = false;
    $advanced_fields["text_shadow"] = false;
    $advanced_fields["link_options"] = false;

    return $advanced_fields;
  }

    public function render($attrs, $content, $render_slug){

        $fmi_height                   = $this->props['fmi_height'];
        $fmi_height_tablet            = $this->props['fmi_height_tablet'];
        $fmi_height_phone             = $this->props['fmi_height_phone'];
        $fmi_height_last_edited       = $this->props['fmi_height_last_edited'];
        $fmi_height_responsive_status = et_pb_get_responsive_status($fmi_height_last_edited);

        if( '' !== $fmi_height ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-floating-multi-images',
                'declaration' => sprintf( 'height: %1$s !important;', $fmi_height),
            ));
        }

        if( '' !== $fmi_height_tablet && $fmi_height_responsive_status ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-floating-multi-images',
                'declaration' => sprintf( 'height: %1$s !important;', $fmi_height_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if( '' !== $fmi_height_phone && $fmi_height_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-floating-multi-images',
                'declaration' => sprintf( 'height: %1$s !important;', $fmi_height_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $output = sprintf(
            '<div class="dipi-floating-multi-images"> %1$s </div>',
            et_core_sanitized_previously( $this->content )
        );

        return $output;

    }

}

new DIPI_FloatingMultiImages;
