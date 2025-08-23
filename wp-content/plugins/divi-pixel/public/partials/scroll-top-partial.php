<?php
namespace DiviPixel;
	
//Customizer Settings
$btt_custom_text = DIPI_Customizer::get_option('btt_custom_text');
$btt_text_size = DIPI_Customizer::get_option('btt_text_size');
$btt_text_placement = DIPI_Customizer::get_option('btt_text_placement');
$btt_text_letter_spacing = DIPI_Customizer::get_option('btt_text_letter_spacing');
$btt_font = DIPI_Customizer::get_option('btt_font');
$btt_font_weight = DIPI_Customizer::get_option('btt_font_weight');
$btt_icon = DIPI_Customizer::get_option('btt_icon');
$btt_btn_icon_size = DIPI_Customizer::get_option('btt_btn_icon_size');
$btt_btn_border = DIPI_Customizer::get_option('btt_btn_border');
$btt_btn_padding = DIPI_Customizer::get_option('btt_btn_padding');
$btt_hover_anim = DIPI_Customizer::get_option('btt_hover_anim');
$btt_btn_right_margin = DIPI_Customizer::get_option('btt_btn_right_margin');
$btt_btn_bottom_margin = DIPI_Customizer::get_option('btt_btn_bottom_margin');
$btt_btn_background = DIPI_Customizer::get_option('btt_btn_background');
$btt_btn_color = DIPI_Customizer::get_option('btt_btn_color');
$btt_btn_background_hover = DIPI_Customizer::get_option('btt_btn_background_hover');
$btt_btn_color_hover = DIPI_Customizer::get_option('btt_btn_color_hover');
$btt_btn_shadow = DIPI_Customizer::get_option('btt_btn_shadow');
$btt_btn_shadow_color = DIPI_Customizer::get_option('btt_btn_shadow_color');
$btt_btn_shadow_offset = DIPI_Customizer::get_option('btt_btn_shadow_offset');
$btt_btn_shadow_blur = DIPI_Customizer::get_option('btt_btn_shadow_blur');
$btt_btn_shadow_color_hover = DIPI_Customizer::get_option('btt_btn_shadow_color_hover');
$btt_btn_shadow_offset_hover = DIPI_Customizer::get_option('btt_btn_shadow_offset_hover');
$btt_btn_shadow_blur_hover = DIPI_Customizer::get_option('btt_btn_shadow_blur_hover');


if(!$btt_btn_background || '' === $btt_btn_background){
    $btt_btn_background = 'rgba(0,0,0,.4)';
}

if(!$btt_btn_background_hover || '' === $btt_btn_background_hover){
    $btt_btn_background_hover = '#000';
}

?>

<style type="text/css">
.et_pb_scroll_top.et-pb-icon {
    transition: all.3s ease-in-out;
    right: <?php echo esc_html($btt_btn_right_margin); ?>px;
    bottom: <?php echo esc_html($btt_btn_bottom_margin); ?>px;
    background: none;
    padding: 0 !important;
}

.et_pb_scroll_top.et-pb-icon:hover {
    background: none;
}

.et_pb_scroll_top.et-pb-icon .dipi_btt_wrapper {
    background: <?php echo  esc_html($btt_btn_background); ?>;
    color:  <?php echo esc_html($btt_btn_color); ?>;
    font-size: <?php echo esc_html($btt_btn_icon_size); ?>px;
    transition: all.3s ease-in-out;
    border-top-left-radius:<?php echo esc_html($btt_btn_border[0]); ?>px;
    border-top-right-radius:<?php echo esc_html($btt_btn_border[1]); ?>px;
    border-bottom-left-radius:<?php echo esc_html($btt_btn_border[2]); ?>px;
    border-bottom-right-radius:<?php echo esc_html($btt_btn_border[3]); ?>px;
    padding-top: <?php echo esc_html($btt_btn_padding[0]); ?>px;
    padding-right: <?php echo esc_html($btt_btn_padding[1]); ?>px;
    padding-bottom: <?php echo esc_html($btt_btn_padding[2]); ?>px;
    padding-left: <?php echo esc_html($btt_btn_padding[3]); ?>px;
}

.et_pb_scroll_top.et-pb-icon:hover .dipi_btt_wrapper {
    background: <?php echo esc_html($btt_btn_background_hover); ?>;
    color: <?php echo esc_html($btt_btn_color_hover); ?>;
}

<?php if(true === $btt_btn_shadow || 1 == $btt_btn_shadow) : ?>
.et_pb_scroll_top.et-pb-icon .dipi_btt_wrapper {
  box-shadow: 0 <?php echo esc_html($btt_btn_shadow_offset); ?>px <?php echo esc_html($btt_btn_shadow_blur); ?>px <?php echo esc_html($btt_btn_shadow_color); ?>;
}
.et_pb_scroll_top.et-pb-icon:hover .dipi_btt_wrapper {
  box-shadow: 0 <?php echo esc_html($btt_btn_shadow_offset_hover); ?>px <?php echo esc_html($btt_btn_shadow_blur_hover); ?>px <?php echo esc_html($btt_btn_shadow_color_hover); ?>;
}
<?php endif; ?>


.et_pb_scroll_top .dipi_btt_wrapper {
	display: flex;
	align-items: center;
	flex-direction: column;
}

.et_pb_scroll_top .dipi_btt_wrapper:before{
    content: '<?php 
        // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
        echo htmlspecialchars_decode($btt_icon);
        // phpcs:enable
        ?>';
	font-family: ETmodules;
}

.dipi-custom-text .dipi_btt_wrapper:before {
    content: none !important;
}

.et_pb_scroll_top:before {
        content: '2';
}

.et_pb_scroll_top.et-pb-icon.dipi-custom-text .btt_custom_text,
.et_pb_scroll_top.et-pb-icon.dipi-custom-text-icon .btt_custom_text {
	font-size: <?php echo esc_html($btt_text_size); ?>px !important;
	letter-spacing: <?php echo esc_html($btt_text_letter_spacing); ?>px !important;
	font-weight: <?php echo esc_html($btt_font_weight); ?>;
    <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($btt_font)), 'html'); ?>
	<?php echo esc_html(DIPI_Customizer::print_font_style_option("btt_font_style")); ?>
}

.et_pb_scroll_top.et-pb-icon.dipi-custom-text .dipi-text-horizontally,
.et_pb_scroll_top.et-pb-icon.dipi-custom-text-icon .dipi-text-horizontally{
	transform: rotate(0deg);
}

.et_pb_scroll_top.et-pb-icon.dipi-custom-text .dipi-text-vertically,
.et_pb_scroll_top.et-pb-icon.dipi-custom-text-icon .dipi-text-vertically {
    writing-mode: vertical-rl;
	transform: rotate(180deg);
}

.et_pb_scroll_top.et-pb-icon.dipi-custom-text-icon .dipi_btt_wrapper:before {
	margin-bottom: 10px;
}

.et_pb_scroll_top:before {
	content: none !important;
	font-family: none !important;
}

</style>