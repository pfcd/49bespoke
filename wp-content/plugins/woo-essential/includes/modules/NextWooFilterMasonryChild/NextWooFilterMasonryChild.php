<?php

defined( 'ABSPATH' ) || die();

require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooFilterMasonry/core/FilterOptions.php';
use DNWoo_Essential\Includes\Modules\NextWooFilterMasonry\FilterOptions;

class DNWooFilterMasonryChild extends ET_Builder_Module
{

    public $slug = 'dnwoo_filter_masonry_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'attribute_filter';
    public $name;
	public $icon_path;
	public $folder_name;

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-gallery-slider/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Attribute Item', 'dnwooe');
		$this->advanced_setting_title_text = esc_html__( 'Attribute Item', 'dnwooe' );

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'attribute_label' => esc_html__('Attribute Title', 'dnwooe'),
                ),
            )
        );
    }

    public function woo_attribute_list($type=""){
        $result = array();
        if( !class_exists('WooCommerce')){ return $result; }
        foreach ( wc_get_attribute_taxonomies()  as $key => $value) {
            $attribute_name = (($value->attribute_name == 'color') || ($value->attribute_name == 'size') ) ? 'pa_'.$value->attribute_name : $value->attribute_name;
            $result[$attribute_name] = wc_attribute_label($value->attribute_name);
        }
        
        return $result;
    }

    public function get_fields()
    {
        $fields = array(
			'attribute_label' => array(
                'label' => esc_html__('Attribute Label', 'dnwooe'),
                'type' => 'text',
                'default' => '',
                'option_category' => 'configuration',
                'toggle_slug' => 'display_setting'
            ),
			'attributes'                   => array(
				'label'            => esc_html__( 'Select Attributes', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => $this->woo_attribute_list("assoc"),
				'default_on_front' => 'default',
				'description'      => esc_html__( 'Select Attributes', 'dnwooe' ),
				'toggle_slug'      => 'display_setting',
			)
        );

        return $fields;
    }

    public function render($attrs, $content, $render_slug){
        $attribute_label = $this->props['attribute_label'];
        $attributes = $this->props['attributes'];
        $filter_options = new FilterOptions();

        $attributes_html = $filter_options->filter_attribute(
			array(
                'title'=> $attribute_label ,
                'type'=>$attributes,
                'control'=> 'no',
                'show_reset'=> 'no'
		));

        return sprintf('<div class="attribute-wrapper">%1$s</div>'
        , $attributes_html);
    }

}

new DNWooFilterMasonryChild;