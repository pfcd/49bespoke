<?php
/**
 * Brand header banner.
 *
 * @author  YITH <plugins@yithemes.com>
 *
 * @package YITH\Brands\Templates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

global $product;

?>

<?php if ( ! empty( $banner ) ) : ?>
	<div class="yith-wcbr-brands-header-wrapper alignwide">
		<?php echo $banner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
<?php endif; ?>
