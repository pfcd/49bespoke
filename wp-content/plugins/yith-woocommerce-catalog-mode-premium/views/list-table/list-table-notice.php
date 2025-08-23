<?php
/**
 * List table notice template
 *
 * @package YITH\CatalogMode\Views\ListTable
 * @var $message string The message.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="ywctm-notice yith-plugin-fw-animate__appear-from-top ">
	<p><?php echo esc_attr( $message ); ?></p>
	<button type="button" class="notice-dismiss"></button>
</div>

