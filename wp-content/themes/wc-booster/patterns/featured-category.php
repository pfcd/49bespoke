<?php
/**
 * Title: Featured Category
 * Slug: wc-booster/featured-category
 * Categories: wc-booster
 *
 * @package WC Booster
 * @since 1.0.0
 */

?>
<?php 
	if ( class_exists( 'woocommerce' ) ) { ?>

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column -->
	<div class="wp-block-column"><!-- wp:woocommerce/featured-category /--></div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column"><!-- wp:woocommerce/featured-category /--></div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column"><!-- wp:woocommerce/featured-category /--></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->

<?php  }else { ?>

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:columns -->
	<div class="wp-block-columns"><!-- wp:column -->
	<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/images/accessories.png","id":169,"dimRatio":50,"minHeight":400,"contentPosition":"bottom center"} -->
	<div class="wp-block-cover has-custom-content-position is-position-bottom-center" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-169" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/images/accessories.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"textColor":"background"} -->
	<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color" style="font-style:normal;font-weight:700"><?php  esc_html_e( 'Accessories', 'wc-booster' ); ?></h3>
	<!-- /wp:heading --></div></div>
	<!-- /wp:cover --></div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/images/shoes.png","id":1422,"dimRatio":40,"minHeight":400,"contentPosition":"bottom center","isDark":false} -->
	<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-center" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-40 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-1422" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/images/shoes.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"textColor":"background"} -->
	<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color" style="font-style:normal;font-weight:700"><?php  esc_html_e( 'All Styles', 'wc-booster' ); ?></h3>
	<!-- /wp:heading --></div></div>
	<!-- /wp:cover --></div>
	<!-- /wp:column -->

	<!-- wp:column -->
	<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/images/women.png","id":1427,"dimRatio":50,"minHeight":400,"contentPosition":"bottom center","isDark":false} -->
	<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-center" style="min-height:400px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-1427" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/images/women.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"textColor":"background"} -->
	<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color" style="font-style:normal;font-weight:700"><?php  esc_html_e( 'Beauty', 'wc-booster' ); ?></h3>
	<!-- /wp:heading --></div></div>
	<!-- /wp:cover --></div>
	<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->

<?php   
		}
