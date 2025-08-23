<?php 

/**
 * Migrate Background Gradient Start/End to new Multi-stops format.
 *
 * This migration will take four existing settings and combine them into one
 * new, unified setting:
 *
 * OLD:
 * - background_color_gradient_start: #rrggbb
 * - background_color_gradient_start_position: xx%
 * - background_color_gradient_end: rgba(rr,gg,bb,aa)
 * - background_color_gradient_end_position: xx%
 *
 * NEW:
 * - background_gradient_stops: #rrggbb xx%|rgba(rr,gg,bb,aa) xx%
 *
 * This new format is not limited to only having defined points for gradient
 * start and end. In this way, we can enable unlimited gradient stops in our
 * gradient background settings.
 *
 */
 
    class DIPI_Builder_Module_Settings_Migration_BackgroundGradientStops extends \ET_Builder_Module_Settings_Migration { 
        /**
         * Array of modules to inspect for settings to migrate.
         *
         * Pass attribute and it will return selected modules only. Default return all affected modules.
         *
         * @param string $attr Attribute name.
         *
         * @return array Collection of module types.
         *
         * @since 4.16.0
        */
     
        public $version = '4.16';
        public $add_missing_fields = true;
        public function get_modules ( $attr = '' ) {
            // var_dump("mirgration");
            // die();
            return [
                'dipi_hover_box',
                'dipi_dual_heading',
                'dipi_flip_box',
                'dipi_image_accordion_child',
                'dipi_image_gallery',
                'dipi_image_gallery_child',
                'dipi_masonry_gallery',
                'dipi_scroll_image',
                'dipi_testimonial',
                'dipi_blog_slider'
            ];
        }
        public function get_fields() {
           
            $gradient_stops_fields = [
                'content_hover_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'content_hover_bg_color_gradient_stops' => $this->get_modules( 'dipi_hover_box' ),
                    ),
                ),
                'content_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'content_bg_color_gradient_stops' => $this->get_modules( 'dipi_hover_box' ),
                    ),
                ),
                'item_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'item_bg_color_gradient_stops' => $this->get_modules( 'dipi_testimonial' ),
                    ),
                ),
                'overlay_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_stops' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'image_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'image_bg_color_gradient_stops' => $this->get_modules( 'dipi_image_accordion_child' ),
                    ),
                ),
                'front_side_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'front_side_bg_color_gradient_stops' => $this->get_modules( 'dipi_flip_box' ),
                    ),
                ),
                'back_side_bg_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'back_side_bg_color_gradient_stops' => $this->get_modules( 'dipi_flip_box' ),
                    ),
                ),
                'first_heading_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'first_heading_color_gradient_stops' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'second_heading_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'second_heading_color_gradient_stops' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'background_text_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'background_text_color_gradient_stops' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'fh_reveal_effect_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'fh_reveal_effect_color_gradient_stops' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'sh_reveal_effect_color_gradient_stops'            => array(
                    'affected_fields' => array(
                        'sh_reveal_effect_color_gradient_stops' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                
                //tablet view
                'overlay_bg_color_gradient_stops_tablet'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_stops_tablet' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'item_bg_color_gradient_stops_tablet'            => array(
                    'affected_fields' => array(
                        'item_bg_color_gradient_stops_tablet' => $this->get_modules( 'dipi_testimonial' ),
                    ),
                ),
                
                //phone view
                'overlay_bg_color_gradient_stops_phone'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_stops_phone' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'item_bg_color_gradient_stops_phone'            => array(
                    'affected_fields' => array(
                        'item_bg_color_gradient_stops_phone' => $this->get_modules( 'dipi_testimonial' ),
                    ),
                ),

                //Hover mode
                'overlay_bg_color_gradient_stops__hover'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_stops__hover' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'image_bg_color_gradient_stops__hover'            => array(
                    'affected_fields' => array(
                        'image_bg_color_gradient_stops__hover' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'item_bg_color_gradient_stops__hover'            => array(
                    'affected_fields' => array(
                        'item_bg_color_gradient_stops__hover' => $this->get_modules( 'dipi_testimonial' ),
                    ),
                ),
                
            ];
            $gradient_type_fields = [
                'content_bg_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'content_bg_color_gradient_type' => $this->get_modules( 'dipi_hover_box' ),
                    ),
                ),
                'content_hover_bg_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'content_hover_bg_color_gradient_type' => $this->get_modules( 'dipi_hover_box' ),
                    ),
                ),
                'item_bg_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'item_bg_color_gradient_type' => $this->get_modules( 'dipi_testimonial' ),
                    ),
                ),
                'overlay_bg_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_type' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'image_bg_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'image_bg_color_gradient_type' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'front_side_bg_color_gradient_type' => array(
                    'affected_fields' => array(
                        'front_side_bg_color_gradient_type' => $this->get_modules( 'dipi_flip_box' ),
                    ),
                ),
                'back_side_bg_color_gradient_type' => array(
                    'affected_fields' => array(
                        'back_side_bg_color_gradient_type' => $this->get_modules( 'dipi_flip_box' ),
                    ),
                ),
                'first_heading_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'first_heading_color_gradient_type' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'second_heading_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'second_heading_color_gradient_type' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'background_text_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'background_text_color_gradient_type' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'fh_reveal_effect_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'fh_reveal_effect_color_gradient_type' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),
                'sh_reveal_effect_color_gradient_type'            => array(
                    'affected_fields' => array(
                        'sh_reveal_effect_color_gradient_type' => $this->get_modules( 'dipi_dual_heading' ),
                    ),
                ),

                //tablet view
                'overlay_bg_color_gradient_type_tablet'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_type_tablet' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                
                //phone view
                'overlay_bg_color_gradient_type_phone'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_type_phone' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),

                 //Hover mode
                 'overlay_bg_color_gradient_type__hover'            => array(
                    'affected_fields' => array(
                        'overlay_bg_color_gradient_type__hover' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
                'image_bg_color_gradient_type__hover'            => array(
                    'affected_fields' => array(
                        'image_bg_color_gradient_type__hover' => $this->get_modules( 'dipi_scroll_image' ),
                    ),
                ),
            ];
            return array_merge( $gradient_stops_fields, $gradient_type_fields );
        }
        public function gradientTypeFields() {
            return [
                'content_hover_bg_color_gradient_type',
                'content_bg_color_gradient_type',
                'item_bg_color_gradient_type',
                'overlay_bg_color_gradient_type',
                'image_bg_color_gradient_type',
                'front_side_bg_color_gradient_type',
                'back_side_bg_color_gradient_type',

                'first_heading_color_gradient_type',
                'second_heading_color_gradient_type',
                'background_text_color_gradient_type',
                'fh_reveal_effect_color_gradient_type',
                'sh_reveal_effect_color_gradient_type',
                

                // Tablet View.
                'overlay_bg_color_gradient_type_tablet',
                'item_bg_color_gradient_type_tablet',

                // Phone View.
                'overlay_bg_color_gradient_type_phone',
                'item_bg_color_gradient_type_phone',

                // Hover Mode.
                'overlay_bg_color_gradient_type__hover',
                'image_bg_color_gradient_type__hover',
                'item_bg_color_gradient_type__hover',

                // Sticky Mode.
                
            ];
        }
        public static function existsAndIsNotEmpty( $key, $array ) {
            if ( ! array_key_exists( $key, $array ) ) {
                return false;
            }
    
            return ! empty( $array[ $key ] );
        }
        public function migrateGradientType( $current_value ) {
            switch ( $current_value ) {
                case 'radial':
                    return 'circular';
                default:
                    return 'linear';
            }
        }
        public static function getOldValues($setting, $attrs, $device = '') {
            $old_values = array(
                'start_color'    => '',
                'start_position' => '',
                'end_color'      => '',
                'end_position'   => '',
            );
            $device = (!empty($device)) ? '_' . $device : '';

            if ( self::existsAndIsNotEmpty( $setting . '_gradient_start' . $device, $attrs ) ) {
                $old_values['start_color'] = $attrs[$setting . '_gradient_start' . $device];
            }
            if ( self::existsAndIsNotEmpty( $setting . '_gradient_start_position' . $device, $attrs ) ) {
                $old_values['start_position'] = $attrs[$setting . '_gradient_start_position' . $device];
            }
            if ( self::existsAndIsNotEmpty( $setting . '_gradient_end' . $device, $attrs ) ) {
                $old_values['end_color'] = $attrs[$setting . '_gradient_end' . $device];
            }
            if ( self::existsAndIsNotEmpty( $setting . '_gradient_end_position' . $device, $attrs ) ) {
                $old_values['end_position'] = $attrs[$setting . '_gradient_end_position' . $device];
            }

            return $old_values;
        }
        public function migrateGradientStops( $field_name, $current_value, $attrs ) {

            $fields = [
                'content_hover_bg_color_gradient_stops'
            ];
            // Grab system defaults to insert where needed (due to empty values).
            $default_settings = array(
                'start_color'    => ET_Global_Settings::get_value( 'all_background_gradient_start' ),
                'start_position' => ET_Global_Settings::get_value( 'all_background_gradient_start_position' ),
                'end_color'      => ET_Global_Settings::get_value( 'all_background_gradient_end' ),
                'end_position'   => ET_Global_Settings::get_value( 'all_background_gradient_end_position' ),
            );

            // This array will be populated with values from the old fields.
            $old_values = array(
                'start_color'    => '',
                'start_position' => '',
                'end_color'      => '',
                'end_position'   => '',
            );
            switch ( $field_name ) {
                // Core fields.
                case 'content_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'content_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('content_bg_color', $attrs);
                    break;
                case 'content_hover_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'content_hover_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('content_hover_bg_color', $attrs);
                    break;
                case 'item_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'item_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('item_bg_color', $attrs);
                    break;
                case 'overlay_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'overlay_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('overlay_bg_color', $attrs);
                    break;
                case 'image_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'image_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('image_bg_color', $attrs);
                    break;
                case 'front_side_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'front_side_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('front_side_bg_color', $attrs);
                    break;
                case 'back_side_bg_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'back_side_bg_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('back_side_bg_color', $attrs);
                    break;
                case 'first_heading_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'first_heading_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('first_heading_color', $attrs);
                    break;
                case 'second_heading_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'second_heading_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('second_heading_color', $attrs);
                    break;
                case 'background_text_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'background_text_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('background_text_color', $attrs);
                    break;
                case 'fh_reveal_effect_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'fh_reveal_effect_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('fh_reveal_effect_color', $attrs);
                    break;
                case 'sh_reveal_effect_color_gradient_stops':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'sh_reveal_effect_color_gradient_start', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('sh_reveal_effect_color', $attrs);
                    break;
                
                // tablet fields.    
                case 'overlay_bg_color_gradient_stops_tablet':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'overlay_bg_color_gradient_start_tablet', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('overlay_bg_color', $attrs, 'tablet');
                    break;
                case 'item_bg_color_gradient_stops_tablet':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'item_bg_color_gradient_start_tablet', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('item_bg_color', $attrs, 'tablet');
                    break;
                

                // phone fields.
                case 'overlay_bg_color_gradient_stops_phone':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'overlay_bg_color_gradient_start_phone', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('overlay_bg_color', $attrs, 'phone');
                    break;
                case 'item_bg_color_gradient_stops_phone':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'item_bg_color_gradient_start_phone', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('item_bg_color', $attrs, 'phone');
                    break;
                
                // Hover Mode.
                case 'overlay_bg_color_gradient_stops__hover':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'overlay_bg_color_gradient_start__hover', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('overlay_bg_color', $attrs, '_hover');
                    break;
                case 'image_bg_color_gradient_stops__hover':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'image_bg_color_gradient_start__hover', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('image_bg_color', $attrs, '_hover');
                    break;
                case 'item_bg_color_gradient_stops__hover':
                    // Bail, nothing to process.
                    if ( ! self::existsAndIsNotEmpty( 'item_bg_color_gradient_start__hover', $attrs ) ) {
                        return $current_value;
                    }
                    $old_values = self::getOldValues('item_bg_color', $attrs, '_hover');
                    break;
                // Sticky Mode.
                 
                default:
				// Bail, nothing to process.
				return $current_value;
            }
            // If colors or positions aren't defined, use the system default settings.
            if ( empty( $old_values['start_color'] ) ) {
                $old_values['start_color'] = $default_settings['start_color'];
            }
            if ( empty( $old_values['start_position'] ) ) {
                $old_values['start_position'] = $default_settings['start_position'];
            }
            if ( empty( $old_values['end_color'] ) ) {
                $old_values['end_color'] = $default_settings['end_color'];
            }
            if ( empty( $old_values['end_position'] ) ) {
                $old_values['end_position'] = $default_settings['end_position'];
            }

            // Strip percent signs and round to nearest int for our calculations.
            $pos_start      = round( floatval( $old_values['start_position'] ) );
            $pos_start_unit = trim( $old_values['start_position'], ',. 0..9' );
            $pos_end        = round( floatval( $old_values['end_position'] ) );
            $pos_end_unit   = trim( $old_values['end_position'], ',. 0..9' );

            // Our sliders use percent values, but pixel values might be manually set.
            $pos_units_match = ( $pos_start_unit === $pos_end_unit );

            // If (and ONLY if) both values use the same unit of measurement,
            // adjust the end position value to be no smaller than the start.
            if ( $pos_units_match && $pos_end < $pos_start ) {
                $pos_end = $pos_start;
            }

            // Prepare to receive the new gradient settings.
            $new_values = array(
                'start' => $old_values['start_color'] . ' ' . $pos_start . $pos_start_unit,
                'end'   => $old_values['end_color'] . ' ' . $pos_end . $pos_end_unit,
            );

            // Compile and return the migrated value for the Gradient Stops attribute.
            return implode( '|', $new_values );

        }
        public function migrate(
            $to_field_name,
            $affected_field_value,
            $module_slug,
            $to_field_value,
            $affected_field_name,
            $module_attrs,
            $module_content,
            $module_address
        ) {
            if ( in_array( $affected_field_name, self::gradientTypeFields(), true ) ) {
                // Migrate the gradient type.
                $to_field_value = self::migrateGradientType( $affected_field_value );
            } else {
                // Migrate gradient stops.
                $to_field_value = self::migrateGradientStops( $affected_field_name, $affected_field_value, $module_attrs );
            }
            
            return $to_field_value;
        }
    }
    return new DIPI_Builder_Module_Settings_Migration_BackgroundGradientStops();
