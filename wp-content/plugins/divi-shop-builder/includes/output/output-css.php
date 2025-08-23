<?php
/*
This file contains code based on and/or copied from Divi by Elegant Themes and Divi Switch by WP Zone
*/

header('Content-Type: text/css');
$options_ags = get_option('ags_divi_wc');

$badge = ( isset( $options_ags['new_badge'] ) && isset( $options_ags['new_badge']) === true) ? true : false ;

// New Badge
if ( $badge ) {
?>
ul.products li.product .wc-new-badge {
    background: <?php echo isset( $options_ags['new_badge_color'] ) ? esc_html( et_sanitize_alpha_color( $options_ags['new_badge_color'] ) ) : '#ff0000' ?>;
    color: <?php echo  isset( $options_ags['new_badge_font_color'] ) ? esc_html( et_sanitize_alpha_color( $options_ags['new_badge_font_color'] ) ) : '#ffffff' ?>;
    font-size: <?php echo isset( $options_ags['new_badge_font_size'] ) ? esc_html( $options_ags['new_badge_font_size'] ) . 'px' : '16px' ?>;
    font-family: <?php echo isset( $options_ags['new_badge_font_family'] ) ? esc_html( $options_ags['new_badge_font_family'] )  : 'Open Sans,Arial,sans-serif' ?>;
    border-radius: <?php echo isset( $options_ags['new_badge_radius'] ) ? esc_html( $options_ags['new_badge_radius'] ) . 'px'  : '5px' ?>;
    <?php echo esc_html( et_pb_print_font_style(isset( $options_ags['new_badge_text_transform'] ) ? $options_ags['new_badge_text_transform'] : 'uppercase') ); ?>
} <?php

}


