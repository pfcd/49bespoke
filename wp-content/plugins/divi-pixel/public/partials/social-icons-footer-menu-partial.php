<?php
namespace DiviPixel;

include plugin_dir_path(__FILE__) . 'social-icons-partial.php';

$social_links_new_tab = DIPI_Settings::get_option('social_links_new_tab') ? 'target="_blank"' : '';

$footer_social_icon_hover_effect = DIPI_Customizer::get_option('footer_social_icon_hover_effect');
$footer_social_icon_box_class = DIPI_Customizer::get_option('footer_social_icon_box_style') ? 'dipi-social-icon-box-style ' : '';

$dipi_hover_effect_class = '';
if($footer_social_icon_hover_effect == 'zoom') :
	$dipi_hover_effect_class = 'dipi-social-icon-zoom ';
elseif($footer_social_icon_hover_effect == 'slide_up') :
	$dipi_hover_effect_class = 'dipi-social-icon-slideup ';
elseif($footer_social_icon_hover_effect == 'rotate') :
	$dipi_hover_effect_class = 'dipi-social-icon-rotate ';
endif;

?>

<ul id="dipi-footer-menu-social-icons-id" class="dipi-social-icons dipi-footer-menu-social-icons">
<?php foreach($footer_menu_social_icons as $footer_menu_social_icon_value) : ?>
	<li class="dipi-social-icon <?php echo esc_attr($dipi_hover_effect_class); echo esc_attr($footer_social_icon_box_class); ?>dipi-social-<?php echo esc_attr($footer_menu_social_icon_value['title']); ?>">
		<a href="<?php echo esc_url($footer_menu_social_icon_value['url']); ?>" <?php echo esc_attr($social_links_new_tab); ?>>
			<span class="dipi-icon">
				<?php include DIPI_DIR . "public/assets/" . $footer_menu_social_icon_value['icon']; ?>
			</span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>

<script type="text/javascript">
jQuery(function($){
	let footer_icons = $("#dipi-footer-menu-social-icons-id");
	let footer_info = $("#footer-info");
	if(footer_info.length > 0){
		footer_icons.insertAfter(footer_info);
	}else {
		$('#footer-bottom > div').append(footer_icons);
	}
});
</script>