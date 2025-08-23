<?php
/**
 * Title: Recent Products
 * Slug: wc-booster/recent-products
 * Categories: wc-booster
 *
 * @package WC Booster
 * @since 1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0px","right":"0","bottom":"0px","left":"var:preset|spacing|40"},"margin":{"top":"0px","bottom":"0px"},"blockGap":"0"}},"className":"wc-recent-products","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull wc-recent-products" style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-right:0;padding-bottom:0px;padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} -->
<h3 class="wp-block-heading has-text-align-center" style="font-style:normal;font-weight:700"><?php  esc_html_e( 'Recent Product', 'wc-booster' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"45px","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<div style="margin-top:0;margin-bottom:0;height:45px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"},"fontSize":"upper-heading"} -->
<div class="wp-block-group has-upper-heading-font-size" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:woocommerce/product-new {"columns":4,"rows":2,"alignButtons":true,"contentVisibility":{"image":true,"title":true,"price":true,"rating":false,"button":true}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->