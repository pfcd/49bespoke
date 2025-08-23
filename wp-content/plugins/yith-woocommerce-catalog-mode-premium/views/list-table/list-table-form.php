<?php
/**
 * List table notice template
 *
 * @package YITH\CatalogMode\Views\ListTable
 * @var $table        YITH_YWCTM_Custom_Table The table to display.
 * @var $list_url     string                  The page URL.
 * @var $getted       array                   Page $_GET params.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form id="custom-table" method="GET" action="<?php echo esc_attr( $list_url ); ?>">
	<input type="hidden" name="page" value="<?php echo esc_attr( $getted['page'] ); ?>" />
	<input type="hidden" name="tab" value="<?php echo esc_attr( $getted['tab'] ); ?>" />
	<?php if ( isset( $getted['sub_tab'] ) ) : ?>
		<input type="hidden" name="sub_tab" value="<?php echo esc_attr( $getted['sub_tab'] ); ?>" />
	<?php endif; ?>
	<?php $table->display(); ?>
</form>

