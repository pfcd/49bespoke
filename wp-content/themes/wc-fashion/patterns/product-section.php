<?php
/**
 * Title: Feature Section
 * Slug: featured/product-section
 * Categories: featured
 */
?>
<?php 
	if ( class_exists( 'woocommerce' ) ) { ?>
	 
<!-- wp:group {"style":{"color":{"background":"#f8f8ff"}},"layout":{"type":"default"}} -->
<div class="wp-block-group has-background" style="background-color:#f8f8ff"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:spacer {"height":"68px"} -->
<div style="height:68px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Our Products', 'wc-fashion' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html__( 'Trending Fashion Styles', 'wc-fashion' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"3px"} -->
<div style="height:3px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:template-part {"slug":"recent-product","theme":"wc-fashion","area":"uncategorized"} /-->

<!-- wp:spacer {"height":"11px"} -->
<div style="height:11px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'GO TO SHOP', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:spacer {"height":"39px"} -->
<div style="height:39px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
	
<?php  }
else { ?>
<!-- wp:group {"style":{"color":{"background":"#f8f8ff"}},"layout":{"type":"default"}} -->
<div class="wp-block-group has-background" style="background-color:#f8f8ff"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:spacer {"height":"68px"} -->
    <div style="height:68px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
    <div class="wp-block-group"><!-- wp:heading {"textAlign":"center"} -->
    <h2 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Our Products', 'wc-fashion' ); ?></h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center"><?php echo esc_html__( 'Trending Fashion Styles', 'wc-fashion' ); ?></p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"3px"} -->
    <div style="height:3px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:columns {"verticalAlignment":null} -->
    <div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"top"} -->
    <div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:image {"id":10239,"sizeSlug":"full","linkDestination":"none"} -->
    <figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/cola.jpg" alt="" class="wp-image-10239"/></figure>
    <!-- /wp:image -->
    
    <!-- wp:heading {"textAlign":"center","level":4} -->
    <h4 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Ring', 'wc-fashion' ); ?></h4>
    <!-- /wp:heading -->
    
    <!-- wp:buttons -->
    <div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
    <div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Add to Cart', 'wc-fashion' ); ?></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:group --></div>
    <!-- /wp:column -->
    
    <!-- wp:column {"verticalAlignment":"top"} -->
    <div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:image {"id":10239,"sizeSlug":"full","linkDestination":"none"} -->
    <figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/shoe.jpg" alt="" class="wp-image-10239"/></figure>
    <!-- /wp:image -->
    
    <!-- wp:heading {"textAlign":"center","level":4} -->
    <h4 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Shoe', 'wc-fashion' ); ?></h4>
    <!-- /wp:heading -->
    
    <!-- wp:buttons -->
    <div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
    <div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Add to Cart', 'wc-fashion' ); ?></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:group --></div>
    <!-- /wp:column -->
    
    <!-- wp:column {"verticalAlignment":"top"} -->
    <div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:image {"id":10239,"sizeSlug":"full","linkDestination":"none"} -->
    <figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/gold.jpg" alt="" class="wp-image-10239"/></figure>
    <!-- /wp:image -->
    
    <!-- wp:heading {"textAlign":"center","level":4} -->
    <h4 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Flower', 'wc-fashion' ); ?></h4>
    <!-- /wp:heading -->
    
    <!-- wp:buttons -->
    <div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
    <div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Add to Cart', 'wc-fashion' ); ?></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:group --></div>
    <!-- /wp:column -->
    
    <!-- wp:column {"verticalAlignment":"top"} -->
    <div class="wp-block-column is-vertically-aligned-top"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group"><!-- wp:image {"id":10239,"sizeSlug":"full","linkDestination":"none"} -->
    <figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/chair.jpg" alt="" class="wp-image-10239"/></figure>
    <!-- /wp:image -->
    
    <!-- wp:heading {"textAlign":"center","level":4} -->
    <h4 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Chair', 'wc-fashion' ); ?></h4>
    <!-- /wp:heading -->
    
    <!-- wp:buttons -->
    <div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
    <div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Add to Cart', 'wc-fashion' ); ?></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:group --></div>
    <!-- /wp:column --></div>
    <!-- /wp:columns -->
    
    <!-- wp:spacer {"height":"11px"} -->
    <div style="height:11px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->
    
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button -->
    <div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'GO TO SHOP', 'wc-fashion' ); ?></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons -->
    
    <!-- wp:spacer {"height":"39px"} -->
    <div style="height:39px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer --></div>
    <!-- /wp:group --></div>
    <!-- /wp:group -->
    
<?php   
		}