<?php
/**
 * Title: Feature Category
 * Slug: featured/featured-category
 * Categories: featured
 */
?>
<?php 
	if ( class_exists( 'woocommerce' ) ) { ?>
	  <!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
	  <div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:spacer {"height":"68px"} -->
<div style="height:68px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Popular Category', 'wc-fashion' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html__( 'Clothes for summer', 'wc-fashion' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"3px"} -->
<div style="height:3px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"className":"main-category"} -->
<div class="wp-block-columns main-category"><!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:woocommerce/featured-category {"editMode":false,"showDesc":false} -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:woocommerce/featured-category --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:woocommerce/featured-category {"editMode":false,} -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:woocommerce/featured-category --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:woocommerce/featured-category {"editMode":false,} -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:woocommerce/featured-category --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"35px"} -->
<div style="height:35px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->

	
<?php  }
else { ?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:spacer {"height":"68px"} -->
<div style="height:68px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Popular Category', 'wc-fashion' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html__( 'Clothes for summer', 'wc-fashion' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"3px"} -->
<div style="height:3px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"className":"main-category"} -->
<div class="wp-block-columns main-category"><!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/img/guitar.jpg","id":10169,"dimRatio":50,"isDark":false,"layout":{"type":"default"}} -->
<div class="wp-block-cover is-light"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-10169" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/guitar.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"textColor":"background"} -->
<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color"><?php echo esc_html__( 'Music', 'wc-fashion' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/img/beauty.jpg","id":10172,"dimRatio":50,"isDark":false,"layout":{"type":"default"}} -->
<div class="wp-block-cover is-light"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-10172" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/beauty.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"textColor":"background"} -->
<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color"><?php echo esc_html__( 'Beauty', 'wc-fashion' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"cursor popular-category"} -->
<div class="wp-block-column cursor popular-category"><!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() );?>/assets/img/clothes.jpg","id":10174,"dimRatio":50,"layout":{"type":"default"}} -->
<div class="wp-block-cover"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-10174" alt="" src="<?php echo esc_url( get_template_directory_uri() );?>/assets/img/clothes.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"textColor":"background"} -->
<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color"><?php echo esc_html__( 'Clothing', 'wc-fashion' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"center"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-align-center wp-element-button"><?php echo esc_html__( 'Shop now', 'wc-fashion' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"35px"} -->
<div style="height:35px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->
<?php   
		}