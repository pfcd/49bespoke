<?php 
namespace DiviPixel;

$lp_form_width = DIPI_Customizer::get_option('lp_form_width');

?>

<style type="text/css" id="dipi-wp-auth-check">
#wp-auth-check-wrap #wp-auth-check {
  width: calc(<?php echo esc_html($lp_form_width); ?>px + 60px) !important;	
  margin-left: -<?php echo esc_html(($lp_form_width + 60)/2); ?>px !important;	
}

@media screen and (max-width: 481px){
	#wp-auth-check-wrap #wp-auth-check {
    left: 0 !important;	
		width: 100% !important;	
    height: 100% !important;
		margin: 0 !important;
	}
}

</style>