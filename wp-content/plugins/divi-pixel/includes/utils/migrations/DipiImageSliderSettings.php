<?php 
/**
 * since 2.25.1
*/
add_filter( 'et_pb_module_shortcode_attributes', 'dipi_image_gallery_maybe_override_shortcode_attributes' , 30, 6 );
function dipi_image_gallery_maybe_override_shortcode_attributes( $attrs, $unprocessed_attrs, $module_slug, $module_address, $content = '', $maybe_global_presets_migration = false ){
    $dipi_version = '2.25.1';
    if(version_compare(DIPI_VERSION, $dipi_version) < 0) return;
    if($module_slug != 'dipi_image_gallery') return $attrs;
    if(isset($unprocessed_attrs['float_thumbs']) && $unprocessed_attrs['float_thumbs'] == 'on'){
        $attrs['use_float_thumbs'] = 'on';
        $attrs['float_wide'] = 'on';
        $attrs['float_tab'] = 'on';
        $attrs['float_pho'] = 'on';
        $float_hz_placement = isset($unprocessed_attrs['float_thumb_hz_placement'])? $unprocessed_attrs['float_thumb_hz_placement'] : 'center';
        $float_vr_placement = isset($unprocessed_attrs['float_thumb_vr_placement'])? $unprocessed_attrs['float_thumb_vr_placement'] : 'bottom';
        $attrs['float_hz_placement_wide'] = $float_hz_placement;
        $attrs['float_vr_placement_wide'] = $float_vr_placement;
        $attrs['float_hz_placement_tab'] = $float_hz_placement;
        $attrs['float_vr_placement_tab'] = $float_vr_placement;
        $attrs['float_hz_placement_pho'] = $float_hz_placement;
        $attrs['float_vr_placement_pho'] = $float_vr_placement;
    }
    return $attrs;   
}
 