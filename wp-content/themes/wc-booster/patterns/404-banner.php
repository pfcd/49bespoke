<?php
/**
 * Title: 404 Banner
 * Slug: wc-booster/404-banner
 * Categories: wc-booster
 * inserter: no
 *
 * @package WC Booster
 * @since 1.0.0
 */

?>
<!-- wp:group {"tagName":"main","align":"full","style":{"spacing":{"margin":{"top":"70px"},"padding":{"bottom":"60px","right":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull" style="margin-top:70px;padding-right:var(--wp--preset--spacing--40);padding-bottom:60px;padding-left:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"full","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"className":"wp-block-section","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center","orientation":"vertical"}} -->
<div class="wp-block-group alignfull wp-block-section">

<!-- wp:paragraph {"className":"error-icon"} -->
<p class="error-icon"><span class="dashicons dashicons-dismiss"></span></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"extra-large"} -->
<h3 class="wp-block-heading has-extra-large-font-size" style="font-style:normal;font-weight:700"><strong>Ooops.</strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php  esc_html_e( 'We can`t seem find the page you`re looking for..', 'wc-booster' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wp-block-button__link wp-element-button"><?php  esc_html_e( 'Back To Homepage', 'wc-booster' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->
