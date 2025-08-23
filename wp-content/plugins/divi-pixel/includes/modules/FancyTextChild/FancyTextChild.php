<?php

class DIPI_Fancy_Text_Child extends DIPI_Builder_Module {
	
	public function init()
    {
		$this->vb_support                  = 'on';
		$this->name                        = esc_html__('Item', 'dipi-divi-pixel');
		$this->slug                        = 'dipi_fancy_text_child';
		$this->type                        = 'child';
		$this->child_title_var             = 'text';
		$this->advanced_setting_title_text = esc_html__('New Item', 'dipi-divi-pixel');
		$this->settings_text               = esc_html__('Item Settings', 'dipi-divi-pixel');
    }
	
	public function get_settings_modal_toggles()
    {
        $toggles = [];

        $toggles['general'] = [
			'toggles' => [
				'text' => esc_html__('Text', 'dipi-divi-pixel'),
			]
        ];

        return $toggles;
    }

    public function get_fields()
    {
    	$fields = [];

    	$fields['text'] = [
			'label'           => esc_html__('Text', 'dipi-divi-pixel'),
			'type'            => 'text',
			'toggle_slug'     => 'text'
        ];

        return $fields;
    }


    public function get_advanced_fields_config()
    {
        $fields                = [];
        
        $fields["text"]        = false;
        $fields["text_shadow"] = false;
        $fields["fonts"]['font']       = [
            'hide_text_align' => true
        ];
        $fields["borders"]     = false;
        $fields["box_shadow"]  = false;

        return $fields;
    }

    public function render($atts, $content, $function_name) {
        global $text_items;
        $link_option_url            = isset( $this->props['link_option_url'] ) ? $this->props['link_option_url'] : '';
		$link_option_url_new_window = isset( $this->props['link_option_url_new_window'] ) ? $this->props['link_option_url_new_window'] : false;
        $order_class = $this->module_classname( $function_name );
         

        $content = $this->props['text'];
        if(isset($link_option_url) && !empty($link_option_url)){
            $content = sprintf('<a href="%1$s"%3$s>%2$s</a>',
                            esc_url( $link_option_url ),
                            $this->props['text'],
                            ( 'on' === $link_option_url_new_window ? ' target="_blank"' : '' )
			            );
        }

        $text_items[] = sprintf(
            '<div class="%1$s">%2$s</div>',
            $order_class,
            $content
        );
        return;
    }


}

new DIPI_Fancy_Text_Child;