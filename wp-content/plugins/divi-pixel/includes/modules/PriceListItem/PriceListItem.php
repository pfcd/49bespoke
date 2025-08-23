<?php

// Migrate pre 2.15.0 module settings from images to gallery_ids 
add_filter('et_pb_module_shortcode_attributes', function($attrs, $unprocessed_attrs, $module_slug, $_1, $_2, $_3 = false){
    if($module_slug === 'dipi_price_list_item' && empty($attrs['gallery_ids']) && !empty($unprocessed_attrs['images'])){
        $attrs['gallery_ids'] = $unprocessed_attrs['images'];
    }
    return $attrs;
  }, 10, 6);

class DIPI_PriceListItem extends DIPI_Builder_Module
{

    public $slug = 'dipi_price_list_item';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'admin';
	
	public function init()
    {
        $this->name = esc_html__('Pixel Price List', 'dipi-divi-pixel');
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'lightbox' => esc_html__('Lightbox', 'dipi-divi-pixel'),
                ],
            ],

             'advanced' => [
                'toggles' => [
                    'text' => [
                        'title' => esc_html__('Text', 'et_builder'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                                'icon' => 'title',
                            ],
                            'price' => [
                                'name' => 'Price',
                                'icon' => 'price',
                            ],
                            'description' => [
                                'name' => 'Description',
                                'icon' => 'description',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
  
    public function get_fields()
    {
        return array(
            
            'title' => array(
                'label' => esc_html__('Title', 'dipi-divi-pixel'),
                'type' => 'text',
                'description' => esc_html__('The title of the item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content',
                'default'    => esc_html__('Title', 'dipi-divi-pixel'),
            ),

            'price' => array(
                'label' => esc_html__('Price', 'dipi-divi-pixel'),
                'type' => 'text',
                'description' => esc_html__('The price of the item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content',
                'default'    => esc_html__('$9.95', 'dipi-divi-pixel'),
            ),
            'price_prefix' => array(
                'label' => esc_html__('Price Prefix', 'dipi-divi-pixel'),
                'type' => 'text',
                'description' => esc_html__('The price of the item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content'
            ),
            'price_suffix' => array(
                'label' => esc_html__('Price Suffix', 'dipi-divi-pixel'),
                'type' => 'text',
                'description' => esc_html__('The price of the item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content'
            ),

            'content' => array(
                'label' => esc_html__('Description', 'dipi-divi-pixel'),
                'type' => 'tiny_mce',
                'description' => esc_html__('The (optional) description for this item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content',
            ),

            'image' => array(
                'label' => esc_html__('Image', 'dipi-divi-pixel'),
                'type' => 'upload',
                'description' => esc_html__('The (optional) image for this item.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content',
                'upload_button_text' => esc_attr__('Upload Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Choose Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Image', 'dipi-divi-pixel'),
                'hide_metadata' => true,
            ),
            'img_alt' => array(
                'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
                'type'        => 'text',
                'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
                'toggle_slug' => 'content',
            ),
            'images' => array(
                'label' => esc_html__('Gallery Images For Lightbox', 'dipi-divi-pixel'),
                'type' => 'hidden',
                'option_category' => 'basic_option',
                'toggle_slug' => 'lightbox',
            ),
            'gallery_ids' => array(
                'label' => esc_html__('Gallery Images For Lightbox', 'dipi-divi-pixel'),
                'type' => 'upload-gallery',
                'option_category' => 'basic_option',
                'toggle_slug' => 'lightbox',
            ),
        );
    }
    static function render_gallery($args = array(), $conditional_tags = array(), $current_page = array())
    {
        $defaults = [
            'images' => '',
            'gallery_ids' => '',
            'gallery_orderby' => '',
            'title_in_lightbox' => 'off',
            'caption_in_lightbox' => 'off',
            'icon_in_overlay'    => 'on',
            'title_in_overlay'  => 'off',
            'caption_in_overlay'    => 'off',
            'use_overlay' => 'off',
            'hover_icon' => '',
            'image_size_desktop' => 'full',
            'image_size_tablet' => 'full',
            'image_size_phone' => 'full',
        ];

        $args = wp_parse_args($args, $defaults);
        

        $items = [];


        $attachment_ids = explode(",", $args["gallery_ids"]);

        //Check which image sizes to use
        
        foreach ($attachment_ids as $attachment_id) {
            $attachment = wp_get_attachment_image_src($attachment_id, "full");
            if(!$attachment){
                continue;
            }

            $image = $attachment[0];
            $image_title = get_the_title($attachment_id);

            $items[] = sprintf(
                '<div class="dipi-pricelist-gallery-item" href="%1$s"%2$s%3$s>
                 </div>',
                $image,
                " data-title='$image_title'" ,
                " data-caption='" . htmlspecialchars(wp_get_attachment_caption($attachment_id)) . "'"
            );
        }
        return implode("", $items);
    }

    private static function get_attachment_image($attachment_id, $image_size, $fallback_url)
    {
        $attachment = wp_get_attachment_image_src($attachment_id, $image_size);
        if ($attachment) {
            return $attachment[0];
        } else {
            return $fallback_url;
        }
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['filters'] = false;

        $advanced_fields['fonts']['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'title',
            'line_height' => array(
                'range_settings' => array(
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ),
            ),
            'header_level' => [
                'default' => 'h2',
            ],
            'font_size' => array(
                'default' => '22px',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '.dipi_price_list .dipi_price_list_item%%order_class%% .dipi_price_list_title',
            ),
        ];

        $advanced_fields['fonts']['price'] = [
            'label' => esc_html__('Price', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'price',
            'line_height' => array(
                'range_settings' => array(
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '1',
                ),
            ),
            'font_size' => array(
                'default' => '22px',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '.dipi_price_list .dipi_price_list_item%%order_class%% .dipi_price_list_price',
            ),
        ];

        $advanced_fields['fonts']['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'description',
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '16px',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '.dipi_price_list .dipi_price_list_item%%order_class%% .dipi_price_list_content',
            ),
        ];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'important' => 'all',
            ],
        ];

        return $advanced_fields;
	}
    private function _render_main_image()
    {
        if ($this->props["image"]) {
            $img_alt = $this->props['img_alt'];
            $image = $this->props["image"];
            $attachment_id = attachment_url_to_postid($image);
            $image_title = get_the_title($attachment_id);
            $parent_module = self::get_parent_modules('page')['dipi_price_list'];
            $srcset = "";
            if ($parent_module->shortcode_atts['use_thumbnails'] === "on") {
                $image_desktop_url = DIPI_PriceListItem::get_attachment_image($attachment_id, $parent_module->shortcode_atts['image_size_desktop'], $image);
                $image_tablet_url = DIPI_PriceListItem::get_attachment_image($attachment_id, $parent_module->shortcode_atts['image_size_tablet'], $image);
                $image_phone_url = DIPI_PriceListItem::get_attachment_image($attachment_id, $parent_module->shortcode_atts['image_size_phone'], $image);
                $srcset = sprintf('srcset="%3$s 768w, %2$s 980w, %1$s 1024w"
                    sizes="(max-width: 768px) 768px, (max-width: 980px) 980px, 1024px"',
                    $image_desktop_url,
                    $image_tablet_url,
                    $image_phone_url
                );
            }
            
            return sprintf(
                '<img class="dipi_price_list_img"
                    src="%1$s"
                    %4$s
                    alt="%2$s"
                    title="%3$s"/>',
                $image,
                $img_alt,
                $image_title,
                $srcset
            );
        } else {
            return "";
        }
    }
    public function _render_image() {
        $gallery_items = DIPI_PriceListItem::render_gallery($this->props);
        
        if (!$this->props['image'] || "" === $this->props['image']){
            return;
        } else {
            
            if (empty($gallery_items)) {
                $output = sprintf(
                    '<div class="dipi_price_list_image_wrapper dipi_price_list_empty_gallery" href="%1$s">
                        %2$s
                    </div>',
                    $this->props['image'],
                    $this->_render_main_image()
                 );
            } else {
                $output = sprintf(
                    '<div class="dipi_price_list_image_wrapper dipi_price_list_gallery_wrapper" href="%1$s">
                        <div class="dipi-pricelist-gallery-item" href="%1$s">
                            %2$s
                        </div>
                        <div class="dipi_price_list_gallery">
                            %3$s
                        </div>
                    </div>',
                    $this->props['image'],
                    $this->_render_main_image(),
                    $gallery_items
                );
            }

            return $output;

        }
    }

    public function render( $attrs, $content, $render_slug ) {
        
        $title_level = $this->props['title_level'] ? $this->props['title_level'] : 'h2';

		$output = sprintf(
			'<div class="dipi_price_list_item_wrapper">
                %1$s
        		<div class="dipi_price_list_text_wrapper">
        			<div class="dipi_price_list_header">
        				<%5$s class="dipi_price_list_title">%2$s</%5$s>
                        <div class="dipi_price_list_separator"></div>
        				<div class="dipi_price_list_price"><span class="dipi_price_list_prefix_price">%6$s</span>%3$s<span class="dipi_price_list_suffix_price">%7$s</span></div>
        			</div>
        			<div class="dipi_price_list_content">
                        %4$s
        			</div>
        		</div>
        	</div>',
        	$this->_render_image(), // #1
        	$this->props['title'],
            $this->props['price'],
            $this->process_content($this->props['content']),
            esc_attr($title_level), // #5
            $this->props['price_prefix'], // #6
            $this->props['price_suffix'] // #7
        );

        return $output;
    }
    
    public function apply_css($render_slug) {
        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => "%%order_class%% .dipi_price_list_separator",
            'declaration' => "border-bottom-style: 'dotted';",
        ));
    }

}
new DIPI_PriceListItem;