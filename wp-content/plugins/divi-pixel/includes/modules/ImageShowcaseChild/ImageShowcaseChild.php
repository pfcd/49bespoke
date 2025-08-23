<?php
class DIPI_ImageShowcaseChild extends DIPI_Builder_Module
{
    public function init() {
        $this->name                        = esc_html__('Pixel Image Showcase', 'dipi-divi-pixel');
        $this->plural                      = esc_html__('Pixel Image Showcase', 'dipi-divi-pixel');
        $this->slug                        = 'dipi_image_showcase_child';
        $this->vb_support                  = 'on';
        $this->type                        = 'child';
        $this->child_title_var             = 'title';
        $this->advanced_setting_title_text = esc_html__('New Image', 'dipi-divi-pixel');
        $this->settings_text               = esc_html__('Image Settings', 'dipi-divi-pixel');
        $this->main_css_element            = '%%order_class%% swiper-slide';
        $this->add_classname('swiper-slide');

    }
    public function get_settings_modal_toggles() {
        return [
            'general' => [
                'toggles' => [
                    'mockup_screen' => esc_html__('Image', 'dipi-divi-pixel')
                ],
            ]
        ];
    }
    public function get_fields()
    {
        $fields = [];
        $fields['title'] = [
            'label'       => esc_html__('Label', 'dipi-divi-pixel'),
            'description' => esc_html__('The label used to identify this item in the parent module.', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'mockup_screen',
        ];

        $fields['bg_img'] = [
            'type'               => 'upload',
            'hide_metadata'      => true,
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug'        => 'mockup_screen',
            'dynamic_content' => 'image'
        ];

        $fields["img_alt"] = [
            'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug'        => 'mockup_screen',
            'dynamic_content' => 'text'
        ];
        return $fields;
    }

    public function get_advanced_fields_config() {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = false;
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['background'] = false;
        $advanced_fields['max_width'] = false;
        $advanced_fields['box_shadow'] = false;
        $advanced_fields['transform'] = false;
        $advanced_fields["borders"]["default"] = [
            'css' => [
              'main' => [
                    'border_radii' => "%%order_class%% .et_pb_module_inner img",
                    'border_styles' => "%%order_class%% .et_pb_module_inner img",
                ],
            ],
        ];

        $advanced_fields["filters"] = [
            'css' => [
              'main' => "%%order_class%%",
            ],
        ];

        $advanced_fields["image"] = [
            'css' => [
              'main' => "%%order_class%% .et_pb_module_inner img",
            ],
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug) {
        $target = $this->props['link_option_url_new_window'] == 'on' ? 'target="blank"' : '';

        if(empty($this->props['link_option_url'])){
            return sprintf( '<img src="%1$s" alt="%2$s" />',
                $this->props['bg_img'],
                $this->props['img_alt']
            );
        } else {
            return sprintf( '<a href="%1$s" %2$s><img src="%3$s" alt="%4$s" /></a>',
                $this->props['link_option_url'],
                $target,
                $this->props['bg_img'],
                $this->props['img_alt']
            );
        }
    }
}
new DIPI_ImageShowcaseChild;
