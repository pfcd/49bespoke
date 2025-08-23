<?php 
namespace DiviPixel;

// Logo 
$lp_logo = DIPI_Customizer::get_option('lp_logo');
$lp_logo_width = DIPI_Customizer::get_option('lp_logo_width');
$lp_logo_height = DIPI_Customizer::get_option('lp_logo_height');
$lp_logo_margin = DIPI_Customizer::get_option('lp_logo_margin');

//Background
$lp_background_image = DIPI_Customizer::get_option('lp_background_image');
$lp_background_color = DIPI_Customizer::get_option('lp_background_color');
$lp_form_background_image = DIPI_Customizer::get_option('lp_form_background_image');
$lp_form_background_color = DIPI_Customizer::get_option('lp_form_background_color');
$lp_background_image_size = DIPI_Customizer::get_option('lp_background_image_size');
$lp_background_image_repeat = DIPI_Customizer::get_option('lp_background_image_repeat');

// Form Container
$lp_form_width = DIPI_Customizer::get_option('lp_form_width');
$lp_form_height = DIPI_Customizer::get_option('lp_form_height');
$lp_form_padding = DIPI_Customizer::get_option('lp_form_padding');
$lp_form_border_width = DIPI_Customizer::get_option('lp_form_border_width');
$lp_form_radius = DIPI_Customizer::get_option('lp_form_radius');
$lp_form_border_color = DIPI_Customizer::get_option('lp_form_border_color');

$lp_form_box_shadow = DIPI_Customizer::get_option('lp_form_box_shadow');
$lp_form_box_shadow_color = DIPI_Customizer::get_option('lp_form_box_shadow_color');
$lp_form_box_shadow_offset = DIPI_Customizer::get_option('lp_form_box_shadow_offset');
$lp_form_box_shadow_blur = DIPI_Customizer::get_option('lp_form_box_shadow_blur');

// Input Fields
$lp_form_field_font = DIPI_Customizer::get_option('lp_form_field_font');
$lp_form_field_font_size = DIPI_Customizer::get_option('lp_form_field_font_size');
$lp_form_field_letter_spacing = DIPI_Customizer::get_option('lp_form_field_letter_spacing');
$lp_form_field_text_color = DIPI_Customizer::get_option('lp_form_field_text_color');
$lp_form_field_line_height = DIPI_Customizer::get_option('lp_form_field_line_height');
$lp_form_field_margin = DIPI_Customizer::get_option('lp_form_field_margin');
$lp_form_field_border_width = DIPI_Customizer::get_option('lp_form_field_border_width');
$lp_form_field_radius = DIPI_Customizer::get_option('lp_form_field_radius');
$lp_form_field_padding = DIPI_Customizer::get_option('lp_form_field_padding');
$lp_form_password_eye_button_top = DIPI_Customizer::get_option('lp_form_password_eye_button_top');
$lp_form_field_border_color = DIPI_Customizer::get_option('lp_form_field_border_color');
$lp_form_field_background = DIPI_Customizer::get_option('lp_form_field_background');
$lp_form_field_label_color = DIPI_Customizer::get_option('lp_form_field_label_color');


$lp_form_field_border_color_hover = DIPI_Customizer::get_option('lp_form_field_border_color_hover'); //FIXME: Default was , '#5b9dd9'
$lp_form_field_background_active = DIPI_Customizer::get_option('lp_form_field_background_active');
$lp_form_field_inset_shadow = DIPI_Customizer::get_option('lp_form_field_inset_shadow'); //FIXME: Many shadow field have "false" as default, why?
$lp_form_field_shadow = DIPI_Customizer::get_option('lp_form_field_shadow');
$lp_form_field_shadow_color = DIPI_Customizer::get_option('lp_form_field_shadow_color');
$lp_form_field_shadow_offset = DIPI_Customizer::get_option('lp_form_field_shadow_offset');
$lp_form_field_shadow_blur = DIPI_Customizer::get_option('lp_form_field_shadow_blur');
$lp_form_field_shadow_color_active = DIPI_Customizer::get_option('lp_form_field_shadow_color_active');
$lp_form_field_shadow_offset_active = DIPI_Customizer::get_option('lp_form_field_shadow_offset_active');
$lp_form_field_shadow_blur_active = DIPI_Customizer::get_option('lp_form_field_shadow_blur_active');

// Login Button
$lp_form_btn_font = DIPI_Customizer::get_option('lp_form_btn_font');
$lp_form_btn_font_size = DIPI_Customizer::get_option('lp_form_btn_font_size'); //FIXME: Default was 13
$lp_form_btn_letter_spacing = DIPI_Customizer::get_option('lp_form_btn_letter_spacing');
$lp_form_btn_font_weight = DIPI_Customizer::get_option('lp_form_btn_font_weight');
$lp_form_btn_txt_color = DIPI_Customizer::get_option('lp_form_btn_txt_color');
$lp_form_btn_background = DIPI_Customizer::get_option('lp_form_btn_background');
$lp_form_btn_border_width = DIPI_Customizer::get_option('lp_form_btn_border_width');
$lp_form_btn_border_color = DIPI_Customizer::get_option('lp_form_btn_border_color');
$lp_form_btn_border_radius = DIPI_Customizer::get_option('lp_form_btn_border_radius');
$lp_form_btn_padding = DIPI_Customizer::get_option('lp_form_btn_padding');
// $lp_form_btn_line_height = DIPI_Customizer::get_option('lp_form_btn_line_height'); //FIXME: doesn't exists yet
$lp_form_btn_background_hover = DIPI_Customizer::get_option('lp_form_btn_background_hover');
$lp_form_btn_border_hover = DIPI_Customizer::get_option('lp_form_btn_border_hover');
$lp_form_btn_text_hover = DIPI_Customizer::get_option('lp_form_btn_text_hover');
$lp_form_btn_box_shadow = DIPI_Customizer::get_option('lp_form_btn_box_shadow');
$lp_form_btn_box_shadow_color = DIPI_Customizer::get_option('lp_form_btn_box_shadow_color');
$lp_form_btn_box_shadow_offset = DIPI_Customizer::get_option('lp_form_btn_box_shadow_offset');
$lp_form_btn_box_shadow_blur = DIPI_Customizer::get_option('lp_form_btn_box_shadow_blur');
$lp_form_btn_box_shadow_color_hover = DIPI_Customizer::get_option('lp_form_btn_box_shadow_color_hover');
$lp_form_btn_box_shadow_offset_hover = DIPI_Customizer::get_option('lp_form_btn_box_shadow_offset_hover');
$lp_form_btn_box_shadow_blur_hover = DIPI_Customizer::get_option('lp_form_btn_box_shadow_blur_hover');
$lp_form_btn_text_shadow = DIPI_Customizer::get_option('lp_form_btn_text_shadow');
$lp_form_link_font = DIPI_Customizer::get_option('lp_form_link_font');
$lp_form_link_font_size = DIPI_Customizer::get_option('lp_form_link_font_size');  //FIXME: Default was 13
$lp_form_link_txt_color = DIPI_Customizer::get_option('lp_form_link_txt_color');
$lp_form_link_txt_color_hover = DIPI_Customizer::get_option('lp_form_link_txt_color_hover');

?>

<style type="text/css">
input#jetpack_protect_answer.input {min-width: 70px;}
body.login {
	background-color: <?php echo esc_html($lp_background_color) ?> !important;
	<?php if ($lp_background_image && filter_var($lp_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($lp_background_image) ?>) !important;
	<?php endif; ?>
	<?php if('cover' === $lp_background_image_size) : ?>
	background-size: cover;
	<?php elseif('fit' === $lp_background_image_size) : ?>
	background-size: contain;
	<?php elseif('actual' === $lp_background_image_size) : ?>
	background-size: auto auto;
	<?php endif; ?>
	<?php if('repeat' === $lp_background_image_repeat) : ?>
	background-repeat: repeat;
	<?php elseif('repeat-x' === $lp_background_image_repeat) : ?>
	background-repeat: repeat-x;
	<?php elseif('repeat-y' === $lp_background_image_repeat) : ?>
	background-repeat: repeat-y;
	<?php endif; ?>
}
	
body.login #login h1 a {
	<?php if ($lp_logo && filter_var($lp_logo, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($lp_logo) ?>) !important;
	<?php endif; ?>
	width: <?php echo esc_html($lp_logo_width); ?>px !important;
	height: <?php echo esc_html($lp_logo_height); ?>px !important;
	background-size: contain !important;
	padding-bottom: 10px !important; 
	/* FIXME: Why do we have 10px padding here? It doesn't really make sense. Either make configurable or remove */
	margin-bottom: <?php echo esc_html($lp_logo_margin); ?>px !important;
}

#loginform {
	<?php if ($lp_form_background_image && filter_var($lp_form_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($lp_form_background_image) ?>) !important;
	<?php endif; ?>
	background-color: <?php echo esc_html($lp_form_background_color); ?> !important;
	height: <?php echo esc_html($lp_form_height); ?>px !important;
	padding: <?php echo esc_html($lp_form_padding) ?>px !important;
	border-width: <?php echo esc_html($lp_form_border_width); ?>px !important;
	border-style: solid;
	border-radius: <?php echo esc_html($lp_form_radius); ?>px;
	border-color: <?php echo esc_html($lp_form_border_color); ?> !important;
	<?php if( $lp_form_box_shadow == 1 ) : ?>
	box-shadow: 0px <?php echo esc_html($lp_form_box_shadow_offset); ?>px <?php echo esc_html($lp_form_box_shadow_blur); ?>px <?php echo esc_html($lp_form_box_shadow_color);?>;
	<?php else: ?>
	box-shadow: none;
	<?php endif; ?>
}

#login {
  	width: <?php echo esc_html($lp_form_width); ?>px !important;
}

@media screen and (max-width: 481px){

	#login {
		width: 320px !important;
	}

	#loginform {
		height: auto !important;
		padding: 15px !important;
		margin: 15px !important;
	}

}
	 
.login form .input, 
.login input[type="text"],
.login input[type="password"] {
	<?php if(!empty($lp_form_field_margin)) : ?>
	margin-top: <?php echo esc_html($lp_form_field_margin); ?>px !important;
	margin-bottom: <?php echo esc_html($lp_form_field_margin); ?>px !important;
	<?php endif; ?>
	padding: <?php echo esc_html($lp_form_field_padding); ?>px !important;
	color: <?php echo esc_html($lp_form_field_text_color); ?> !important;
	background: <?php echo esc_html($lp_form_field_background); ?> !important;
	border-style: solid;
	border-width: <?php echo esc_html($lp_form_field_border_width); ?>px !important;
	border-radius: <?php echo esc_html($lp_form_field_radius); ?>px;
	border-color: <?php echo esc_html($lp_form_field_border_color); ?> !important;
	<?php if($lp_form_field_inset_shadow) : ?>
	box-shadow: none;
	<?php endif; ?>
	<?php if($lp_form_field_shadow) : ?>
	box-shadow: 0px <?php echo esc_html($lp_form_field_shadow_offset); ?>px <?php echo esc_html($lp_form_field_shadow_blur); ?>px <?php echo esc_html($lp_form_field_shadow_color);?> !important;
	<?php endif; ?>
	line-height: <?php echo esc_html($lp_form_field_line_height); ?> !important;
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($lp_form_field_font)), 'html'); ?>
	<?php echo esc_html(DIPI_Customizer::print_font_style_option("lp_form_btn_txt_style")); ?>
	font-size: <?php echo esc_html($lp_form_field_font_size); ?>px !important;
	letter-spacing: <?php echo esc_html($lp_form_field_letter_spacing); ?>px !important;		
}

.login .button.wp-hide-pw {
	padding-top: <?php echo esc_html($lp_form_password_eye_button_top); ?>px !important;
}

.login input:-webkit-autofill,
.login input:-webkit-autofill:hover, 
.login input:-webkit-autofill:focus {
	border-style: solid !important;
	border-width: <?php echo esc_html($lp_form_field_border_width); ?>px !important;
	border-color: <?php echo esc_html($lp_form_field_border_color); ?> !important;
	-webkit-text-fill-color: <?php echo esc_html($lp_form_field_border_color); ?>;
	-webkit-box-shadow: 0 0 0px 1000px <?php echo esc_html($lp_form_field_background); ?> inset;
	transition: background-color 5000s ease-in-out 0s;
}


.login form .input:hover, 
.login input[type="text"]:hover,
.login input[type="password"]:hover {
	border-color: <?php echo esc_html($lp_form_field_border_color_hover); ?> !important;
}

input[type=email]:focus,
input[type=password]:focus,
input[type=text]:focus {
	border-color: <?php echo esc_html($lp_form_field_border_color); ?> !important;
	background: <?php echo esc_html($lp_form_field_background_active); ?> !important;
	box-shadow: 0 0 2px <?php echo esc_html($lp_form_field_border_color); ?>;
	<?php if($lp_form_field_shadow) : ?>
	box-shadow: 0px <?php echo esc_html($lp_form_field_shadow_offset_active); ?>px <?php echo esc_html($lp_form_field_shadow_blur_active); ?>px <?php echo esc_html($lp_form_field_shadow_color_active);?> !important;
	<?php endif; ?>
}

.login label {
	color: <?php echo esc_html($lp_form_field_label_color); ?> !important;
}

.wp-core-ui .button-primary {
	display: flex;
	align-items: center;
	justify-content: center;
	transition: all 0.6s ease-in-out;
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($lp_form_btn_font)), 'html'); ?>
	<?php echo esc_html(DIPI_Customizer::print_font_style_option("lp_form_btn_txt_style")); ?>
	background: <?php echo esc_html($lp_form_btn_background); ?> !important;
  	color: <?php echo esc_html($lp_form_btn_txt_color); ?> !important;
	border-color: <?php echo esc_html($lp_form_btn_border_color); ?> !important;
	border-width: <?php echo esc_html($lp_form_btn_border_width); ?>px !important;
  	border-radius: <?php echo esc_html($lp_form_btn_border_radius); ?>px !important;
	font-size: <?php echo esc_html($lp_form_btn_font_size); ?>px !important;
	font-weight: <?php echo esc_html($lp_form_btn_font_weight); ?> !important;
	letter-spacing: <?php echo esc_html($lp_form_btn_letter_spacing); ?>px !important;
	padding: <?php echo esc_html($lp_form_btn_padding); ?>px !important;
	<?php if($lp_form_btn_text_shadow) : ?>
    text-shadow: none !important;
	<?php endif; ?>
	<?php if($lp_form_btn_box_shadow) : ?>
    box-shadow: 0px <?php echo esc_html($lp_form_btn_box_shadow_offset); ?>px <?php echo esc_html($lp_form_btn_box_shadow_blur); ?>px <?php echo esc_html($lp_form_btn_box_shadow_color); ?> !important;
	<?php endif; ?>
	line-height: 0 !important;
}

.wp-core-ui .button-primary.focus,
.wp-core-ui .button-primary.hover,
.wp-core-ui .button-primary:focus,
.wp-core-ui .button-primary:hover,
.wp-core-ui .button-primary:active {
	transition: all 0.6s ease-in-out;
	color: <?php echo esc_html($lp_form_btn_text_hover); ?> !important;
	background: <?php echo esc_html($lp_form_btn_background_hover); ?> !important;
	border-color: <?php echo esc_html($lp_form_btn_border_hover); ?> !important;
	<?php if($lp_form_btn_box_shadow) : ?>
	box-shadow: 0px <?php echo esc_html($lp_form_btn_box_shadow_offset_hover); ?>px <?php echo esc_html($lp_form_btn_box_shadow_blur_hover); ?>px <?php echo esc_html($lp_form_btn_box_shadow_color_hover); ?> !important;
	<?php endif; ?>
}

.login #nav, 
.login #backtoblog {
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($lp_form_link_font)), 'html'); ?>
	font-size: <?php echo esc_html($lp_form_link_font_size); ?>px !important;
}

.login #nav a, 
.login #backtoblog a {
	color: <?php echo esc_html($lp_form_link_txt_color); ?> !important;
}

.login #nav a:hover, .login #backtoblog a:hover {
	color: <?php echo esc_html($lp_form_link_txt_color_hover); ?> !important;
}
</style>
