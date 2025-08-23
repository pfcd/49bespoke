<?php 
namespace DiviPixel;
// Footer Social Icons
$footer_social_icon_hover_effect = DIPI_Customizer::get_option('footer_social_icon_hover_effect');
$footer_social_icon_color = DIPI_Customizer::get_option('footer_social_icon_color');
$footer_social_icon_hover_color = DIPI_Customizer::get_option('footer_social_icon_hover_color');
$footer_social_icon_size = DIPI_Customizer::get_option('footer_social_icon_size');
$footer_social_icon_padding = DIPI_Customizer::get_option('footer_social_icon_padding');
$footer_social_icon_box_style = DIPI_Customizer::get_option('footer_social_icon_box_style');
$footer_social_icon_box_radius = DIPI_Customizer::get_option('footer_social_icon_box_radius');
$footer_social_icon_box_background = DIPI_Customizer::get_option('footer_social_icon_box_background');
$footer_social_icon_box_background_hover = DIPI_Customizer::get_option('footer_social_icon_box_background_hover');
$footer_social_icon_shadow = DIPI_Customizer::get_option('footer_social_icon_shadow'); //FIXME: Default was false
$footer_social_icon_shadow_color = DIPI_Customizer::get_option('footer_social_icon_shadow_color');
$footer_social_icon_shadow_offset = DIPI_Customizer::get_option('footer_social_icon_shadow_offset');
$footer_social_icon_shadow_blur = DIPI_Customizer::get_option('footer_social_icon_shadow_blur');
$footer_social_icon_spacing = DIPI_Customizer::get_option('footer_social_icon_spacing');


$footer_bottom_center = DIPI_Customizer::get_option('footer_bottom_center');
$footer_menu_underline = DIPI_Customizer::get_option('footer_menu_underline');
?>

<style type="text/css" id="dipi-footer-social-icons-styles">

	.et-social-icons {
		display: none !important;
	}

	#footer-bottom .et-social-icons {
		display: flex;
		align-items: center;
		justify-content: center;
		padding-top: <?php echo esc_attr($footer_social_icon_spacing); ?>px;
		padding-bottom: <?php echo esc_attr($footer_social_icon_spacing); ?>px;
	}

	#footer-bottom .et-social-icon a {
		transition: all .5s ease-in-out;
		font-size: <?php echo esc_attr($footer_social_icon_size); ?>px;
		color: <?php echo esc_attr($footer_social_icon_color); ?>;
	}

  	#footer-bottom .et-social-icons li {
		padding: <?php echo esc_attr($footer_social_icon_padding); ?>px;
		display: flex;
		align-items: center;
		justify-content: center;
	}

  #footer-bottom .et-social-icon a:hover,
  #footer-bottom .et-social-icon:hover a {
  	opacity: 1;
  	transition: all .5s ease-in-out;
    color: <?php echo esc_attr($footer_social_icon_hover_color); ?>;
  }

<?php if (1 == $footer_social_icon_box_style): ?>
	#footer-bottom .dipi-social-icon-box {
	height: calc(<?php echo esc_attr($footer_social_icon_size); ?>px + 30px);
	width: calc(<?php echo esc_attr($footer_social_icon_size); ?>px + 30px);
		border-radius: <?php echo esc_attr($footer_social_icon_box_radius); ?>%;
		background-color: <?php echo esc_attr($footer_social_icon_box_background); ?>;
		<?php if ($footer_social_icon_shadow): ?>
			box-shadow: 0px <?php echo esc_attr($footer_social_icon_shadow_offset); ?>px <?php echo esc_attr($footer_social_icon_shadow_blur); ?>px <?php echo esc_attr($footer_social_icon_shadow_color); ?>;
		<?php endif;?>
	}

	#footer-bottom .dipi-social-icon-box:hover {
		transition: all .5s ease-in-out;
		background-color: <?php echo esc_attr($footer_social_icon_box_background_hover); ?>
	}
<?php endif;?>
</style>

<script type="text/javascript">
	<?php if ('zoom' === $footer_social_icon_hover_effect): ?>
		jQuery(document).ready(function($) {
			$('#footer-bottom .et-social-icons li').addClass('dipi-social-icon-zoom');
		});
	<?php elseif ('slide_up' === $footer_social_icon_hover_effect): ?>
		jQuery(document).ready(function($) {
			$('#footer-bottom .et-social-icons li').addClass('dipi-social-icon-slideup');
		});
	<?php elseif ('rotate' === $footer_social_icon_hover_effect): ?>
		jQuery(document).ready(function($) {
			$('#footer-bottom .et-social-icons li').addClass('dipi-social-icon-rotate');
		});
	<?php elseif ('ripple' === $footer_social_icon_hover_effect): ?>
		jQuery(document).ready(function($) {
			$('#footer-bottom .et-social-icons li').addClass('dipi-social-icon-ripple');
		});
	<?php endif?>

	<?php if ($footer_social_icon_box_style): ?>
		jQuery(document).ready(function($) {
			$('#footer-bottom .et-social-icons li').addClass('dipi-social-icon-box');
		});
	<?php endif;?>

  <?php if ($footer_menu_underline): ?>
  	jQuery(document).ready(function($) {
			$('.bottom-nav a').addClass('dipi-hover-underline-animation');
		});
  <?php endif;?>

	<?php if (!$footer_bottom_center): ?>
		jQuery(document).ready(function($) {
			var $iconHeight = $('#footer-bottom .et-social-icons li').innerHeight();
			$('#footer-info').css( "height", $iconHeight);
		});
  <?php endif;?>
</script>
