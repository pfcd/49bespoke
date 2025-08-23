<?php
/**
 * Title: Latest Blogs
 * Slug: wc-booster/latest-blogs
 * Categories: wc-booster
 *
 * @package WC Booster
 * @since 1.0.0
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0"}},"className":"wp-block-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide wp-block-section" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}}} -->
<h3 class="wp-block-heading has-text-align-center" style="font-style:normal;font-weight:700"><?php  esc_html_e( 'Latest Blogs', 'wc-booster' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"45px"} -->
<div style="height:45px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:query {"queryId":23,"query":{"perPage":"3","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"layout":{"type":"constrained"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"var:preset|spacing|20"},"border":{"radius":"0px"}},"className":"blog-description-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group blog-description-section" style="border-radius:0px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"height":"250px","style":{"border":{"radius":"0px"}}} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","orientation":"horizontal"}} -->
<div class="wp-block-group"><!-- wp:post-date /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","separator":""} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"600","lineHeight":1.4}}} /-->

<!-- wp:post-excerpt {"textAlign":"left","moreText":"Read More","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->