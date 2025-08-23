<?php

// Migrate pre 2.15.0 module settings from images to gallery_ids 
add_filter('et_pb_module_shortcode_attributes', function($attrs, $unprocessed_attrs, $module_slug, $_1, $_2, $_3 = false){
  if($module_slug === 'dipi_tile_scroll_item' && empty($attrs['gallery_ids']) && !empty($unprocessed_attrs['images'])){
      $attrs['gallery_ids'] = $unprocessed_attrs['images'];
  }
  return $attrs;
}, 10, 6);

class DIPI_TileScroll_Item extends DIPI_Builder_Module
{
  // Module item's attribute that will be used for module item label on modal
  public $child_title_var = 'admin_label';

  public function init()
  {
      $this->name = esc_html__('Tile Scroll Item', 'dipi-divi-pixel');
      $this->plural = esc_html__('Tile Scroll Items', 'dipi-divi-pixel');
      $this->slug = 'dipi_tile_scroll_item';
      $this->vb_support = 'on';
      $this->main_css_element = '.dipi_tile_scroll %%order_class%%';
      $this->type = 'child';

      // attributes are empty, this default text will be used instead as item label
      $this->advanced_setting_title_text = esc_html__('Tile Scroll Item', 'dipi-divi-pixel');

      $this->settings_modal_toggles = [
        'general'   => [
          'toggles'      => [
            'images' => esc_html__('Images', 'dipi-divi-pixel'),
          ]
        ],
        'advanced' => [
          'toggles'      => [
            'image' => esc_html__('Image', 'dipi-divi-pixel'),
          ]
        ]
      ];


      $this->help_videos = array(
          array(
              'id' => 'XW7HR86lp8U',
              'name' => esc_html__('An introduction to the Tile Scroll Item module', 'dipi-divi-pixel'),
          ),
      );
  }

  public function get_fields()
  {
    $et_accent_color = et_builder_accent_color();

    $fields = [];
    
    $fields["images"] = [
      'label' => esc_html__('Images', 'dipi-divi-pixel'),
      'type' => 'hidden',
      'option_category' => 'basic_option',
      'toggle_slug' => 'images',
      'computed_affects' => array(
        '__gallery',
      ),
    ];
    $fields["gallery_ids"] = [
      'label' => esc_html__('Images', 'dipi-divi-pixel'),
      'type' => 'upload-gallery',
      'option_category' => 'basic_option',
      'toggle_slug' => 'images',
      'computed_affects' => array(
        '__gallery',
      ),
    ];
    $fields["__gallery"] = [
      'type' => 'computed',
      'computed_callback' => array('DIPI_TileScroll_Item', 'render_images'),
      'computed_depends_on' => array(
          'images',
          'gallery_ids',
      ),
      'computed_minimum' => array(
          'gallery_ids',
      ),
    ];

    return $fields;
  }

  public function get_custom_css_fields_config() {
    $fields = [];
    $fields['image'] = [
      'label'    => esc_html__('Image', 'dipi-divi-pixel'),
      'selector' => '%%order_class%% .dipi-tile-scroll__line-img',
    ];
    return $fields;
}
  public function get_advanced_fields_config()
  {
    $advanced_fields = [];
    $advanced_fields['fonts'] = false;
    $advanced_fields['text'] = false;
    $image_selector = '.dipi_tile_scroll %%order_class%%.dipi_tile_scroll_item .dipi-tile-scroll__line-img';
    $advanced_fields['borders']['image'] = [
      'css' => [
          'main' => [
              'border_radii' => $image_selector,
              'border_styles' => $image_selector,
          ],
      ],
      'label_prefix' => et_builder_i18n( 'Image' ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'image',
      'hover'           => 'tabs',
    ];
    $advanced_fields['box_shadow']['default'] = [
          'css' => array(
              'main' => "%%order_class%%",
          ),
      ];
    $advanced_fields['box_shadow']['image'] = [
      'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
      'option_category' => 'layout',
      'tab_slug' => 'advanced',
      'css' => [
          'main' => $image_selector,
          'overlay' => 'inset',
      ],
      'tab_slug' => 'advanced',
      'toggle_slug' => 'image',
      'hover'           => 'tabs',
    ];
    $advanced_fields['max_width'] = [
      'css' => [
        'main' => $image_selector,
      ],
      'label_prefix' => et_builder_i18n( 'Image' ),
      'use_height' => true,
      'use_max_height' => true,
      'use_module_alignment' => false,
      'options' => [
        'width' => [
            'default' => '200px',
            'default_unit'      => 'px',
        ],
      ],
    ];
    $advanced_fields['height'] = [
      'css' => [
        'main' => $image_selector,
      ],
      'label_prefix' => et_builder_i18n( 'Image' ),
      'use_height' => true,
      'use_max_height' => true,
      'options' => [
        'height' => [
            'default' => '200px',
            'default_unit' => '%',
            'range_settings' => [
              'min' => '0',
              'max' => '100',
              'step' => '1',
          ],
        ],
      ],
    ];
    $advanced_fields['margin_padding'] = false; /*[
      'css' => array(
          'margin' => $image_selector,
          'padding' => $image_selector,
          'important' => 'all',
      ),
    ];*/
    return $advanced_fields;
  }
  private function _dipi_apply_css($render_slug)
  {
    $image_selector = '%%order_class%% .dipi-tile-scroll__line-img';
    $image_hover_selector = '%%order_class%% .dipi-tile-scroll__line-img:hover';

  }

  public static function render_images($args = array(), $conditional_tags = array(), $current_page = array())
  {
      $defaults = [
        'images' => '',
        'gallery_ids' => '',
      ];

      $args = wp_parse_args($args, $defaults);

      $attachment_ids = explode(",", $args["gallery_ids"]);
      $items = "";
      foreach ($attachment_ids as $attachment_id) {
          $attachment = wp_get_attachment_image_src($attachment_id, "full");
          if (!$attachment) {
              continue;
          }

          $image = $attachment[0];

          $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

          $items .= sprintf(
              '<div
                class="dipi-tile-scroll__line-img"
                style="background-image:url(%1$s)"
                loading="lazy"
              >
              </div>'
              ,
              $image,
              $image_alt
          );
      }
      return $items;

  }

  public function render($attrs, $content, $render_slug)
  {
    global $child_items_count;
    $order_class = self::get_module_order_class($render_slug);
    $order_number = preg_replace('/[^0-9]/', '', $order_class);
    $this->_dipi_apply_css($render_slug);
    $images = DIPI_TileScroll_Item::render_images($this->props);
    $module_custom_classes = '';
    $link_option_url = $this->props['link_option_url'];
    $link_option_url_new_window = $this->props['link_option_url_new_window'];
    $link_target = ($link_option_url_new_window === 'on') ? 'target="blank"':'';
    $link_start_tag = (!empty($link_option_url)) ? sprintf('a href="%1$s" %2$s', $link_option_url, $link_target): 'div';
    $link_end_tag = (!empty($link_option_url)) ? sprintf('a'):'div';

    $output = sprintf(
      '<%3$s class="dipi_tile_scroll_item_container %2$s">
        %1$s
      </%4$s>
      ',
      $images,
      $order_number % 2 === 0 ? 'even' : 'odd',
      $link_start_tag,
      $link_end_tag
    );
    $child_items_count ++;
    return $output;
  }
}

new DIPI_TileScroll_Item();
