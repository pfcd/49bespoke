<?php
namespace DiviPixel;
 
// Widget Title
$archive_sidebar_font_select = DIPI_Customizer::get_option('archive_sidebar_font_select');
$archive_sidebar_font_weight = DIPI_Customizer::get_option('archive_sidebar_font_weight');
$archive_sidebar_font_weight = DIPI_Customizer::get_option('archive_sidebar_font_weight');
$archive_sidebar_font_size = DIPI_Customizer::get_option('archive_sidebar_font_size');
$archive_sidebar_text_spacing = DIPI_Customizer::get_option('archive_sidebar_text_spacing');
$archive_sidebar_font_color = DIPI_Customizer::get_option('archive_sidebar_font_color');
$archive_sidebar_title_background_color = DIPI_Customizer::get_option('archive_sidebar_title_background_color');
$archive_sidebar_widget_title_padding = DIPI_Customizer::get_option('archive_sidebar_widget_title_padding');
$archive_sidebar_widget_title_spacing = DIPI_Customizer::get_option('archive_sidebar_widget_title_spacing');

// Widgets
$archive_sidebar_background_color = DIPI_Customizer::get_option('archive_sidebar_background_color');
$archive_sidebar_widget_padding = DIPI_Customizer::get_option('archive_sidebar_widget_padding');
$archive_sidebar_widget_spacing = DIPI_Customizer::get_option('archive_sidebar_widget_spacing');
$archive_sidebar_widget_shadow = DIPI_Customizer::get_option('archive_sidebar_widget_shadow');
$archive_sidebar_widget_shadow_color = DIPI_Customizer::get_option('archive_sidebar_widget_shadow_color');
$archive_sidebar_widget_shadow_offset = DIPI_Customizer::get_option('archive_sidebar_widget_shadow_offset');
$archive_sidebar_widget_shadow_blur = DIPI_Customizer::get_option('archive_sidebar_widget_shadow_blur');

// Search Widgets 
$archive_sidebar_search_background = DIPI_Customizer::get_option('archive_sidebar_search_background');
$archive_sidebar_search_color = DIPI_Customizer::get_option('archive_sidebar_search_color');
$archive_sidebar_search_padding = DIPI_Customizer::get_option('archive_sidebar_search_padding');
$archive_sidebar_search_btn_padding = DIPI_Customizer::get_option('archive_sidebar_search_btn_padding');
$archive_sidebar_search_btn_width = DIPI_Customizer::get_option('archive_sidebar_search_btn_width');
$archive_sidebar_search_radius = DIPI_Customizer::get_option('archive_sidebar_search_radius');
$archive_sidebar_search_border_color = DIPI_Customizer::get_option('archive_sidebar_search_border_color');
$archive_sidebar_search_border_width = DIPI_Customizer::get_option('archive_sidebar_search_border_width');
$archive_sidebar_search_button_background = DIPI_Customizer::get_option('archive_sidebar_search_button_background');
$archive_sidebar_search_button_color = DIPI_Customizer::get_option('archive_sidebar_search_button_color');
$archive_sidebar_search_fullwidth = DIPI_Customizer::get_option('archive_sidebar_search_fullwidth');


?>
<style type="text/css" id="custom-sidebar-styles-css">

div[class^='et_pb_sidebar_'].et_pb_widget_area h3:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area h4:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area h5:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area h6:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area h2:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area h1:first-of-type,
div[class^='et_pb_sidebar_'].et_pb_widget_area .widget-title,
div[class^='et_pb_sidebar_'].et_pb_widget_area .widgettitle,
.et_pb_widget .wp-block-group__inner-container > h2,
.et_pb_widget .widgettitle,
.et_pb_widget form > label{
    <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($archive_sidebar_font_select)), 'html'); ?>
    font-weight: <?php echo esc_html($archive_sidebar_font_weight); ?> !important;
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("archive_sidebar_font_style")); ?>
    font-size: <?php echo esc_html($archive_sidebar_font_size); ?>px !important;
    letter-spacing: <?php echo esc_html($archive_sidebar_text_spacing); ?>px !important;
    color: <?php echo esc_html($archive_sidebar_font_color); ?> !important;
    background-color: <?php echo esc_html($archive_sidebar_title_background_color); ?>;
    padding-top: <?php echo esc_html($archive_sidebar_widget_title_padding[0]); ?>px !important;
    padding-right: <?php echo esc_html($archive_sidebar_widget_title_padding[1]); ?>px !important;
    padding-bottom: <?php echo esc_html($archive_sidebar_widget_title_padding[2]); ?>px !important;
    padding-left: <?php echo esc_html($archive_sidebar_widget_title_padding[3]); ?>px !important;
    display:block;
    line-height: 1.7em;
    margin-bottom: <?php echo esc_html($archive_sidebar_widget_title_spacing) ?>px !important;
}
.et_pb_widget {
    margin-bottom: <?php echo esc_html($archive_sidebar_widget_spacing); ?>px !important;  
    background-color: <?php echo esc_html($archive_sidebar_background_color); ?>;  
    padding-top: <?php echo esc_html($archive_sidebar_widget_padding[0]); ?>px !important;
    padding-right: <?php echo esc_html($archive_sidebar_widget_padding[1]); ?>px !important;
    padding-bottom: <?php echo esc_html($archive_sidebar_widget_padding[2]); ?>px !important;
    padding-left: <?php echo esc_html($archive_sidebar_widget_padding[3]); ?>px !important;
}
 .et_pb_widget{
    <?php if((bool)$archive_sidebar_widget_shadow): ?>
        box-shadow: <?php echo sprintf('0 %1$spx %2$spx %3$s',
            esc_html($archive_sidebar_widget_shadow_offset),
            esc_html($archive_sidebar_widget_shadow_blur),
            esc_html($archive_sidebar_widget_shadow_color ));
        endif;
    ?>;
 }
 
.et_pb_widget .searchform  input[name='s']::placeholder { color: <?php echo esc_html($archive_sidebar_search_color) ?>; opacity: .7;  }
.et_pb_widget .searchform  input[name='s']:-ms-input-placeholder { color: <?php echo esc_html($archive_sidebar_search_color) ?>; opacity: .7;  }
.et_pb_widget .searchform  input[name='s']::-ms-input-placeholder { color: <?php echo esc_html($archive_sidebar_search_color) ?>; opacity: .7;  }


.widget_search  input[name='s']{display:block;}

.widget_search  input[name='s']{
    background-color: <?php echo esc_html($archive_sidebar_search_background) ?>;
    color: <?php echo esc_html($archive_sidebar_search_color) ?>;
    height: 100% !important;
    padding-top: <?php echo esc_html($archive_sidebar_search_padding[0]); ?>px !important;
    padding-right: <?php echo esc_html($archive_sidebar_search_padding[1]); ?>px !important;
    padding-bottom: <?php echo esc_html($archive_sidebar_search_padding[2]); ?>px !important;
    padding-left: <?php echo esc_html($archive_sidebar_search_padding[3]); ?>px !important;
    border: <?php echo esc_html($archive_sidebar_search_border_width) ?>px solid <?php echo esc_html($archive_sidebar_search_border_color) ?> !important;
}
.wp-block-search .wp-block-search__button,
.widget_search input#searchsubmit
{
    min-width: <?php echo esc_html($archive_sidebar_search_btn_width) ?>px;
    width: <?php echo esc_html($archive_sidebar_search_btn_width) ?>px;
    height: 100% !important;
    padding-top: <?php echo esc_html($archive_sidebar_search_btn_padding[0]); ?>px !important;
    padding-right: <?php echo esc_html($archive_sidebar_search_btn_padding[1]); ?>px !important;
    padding-bottom: <?php echo esc_html($archive_sidebar_search_btn_padding[2]); ?>px !important;
    padding-left: <?php echo esc_html($archive_sidebar_search_btn_padding[3]); ?>px !important;
    border: <?php echo esc_html($archive_sidebar_search_border_width) ?>px solid <?php echo esc_html($archive_sidebar_search_border_color) ?> !important;
}
.widget_search #searchsubmit,
.wp-block-search .wp-block-search__button,
.widget_search input[name='s']{
        border-radius: <?php echo esc_html($archive_sidebar_search_radius); ?>px !important;
}
.wp-block-search .wp-block-search__button,
.widget_search #searchsubmit{
    background: <?php echo esc_html($archive_sidebar_search_button_background); ?>;
    color: <?php echo esc_html($archive_sidebar_search_button_color); ?> !important;
}

<?php if($archive_sidebar_search_fullwidth): ?>
    .wp-block-search__inside-wrapper{
        flex-direction: column;
    }
    .wp-block-search__inside-wrapper .wp-block-search__button {
        margin: 10px 0 0;
    }
<?php endif; ?>
</style>