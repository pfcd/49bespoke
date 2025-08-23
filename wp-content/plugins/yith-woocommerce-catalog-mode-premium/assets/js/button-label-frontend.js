/**
 * Buttons & Labels frontend scripts
 *
 * @package YITH\CatalogMode
 */

jQuery(
	function ( $ ) {

		$( document ).on(
			'click',
			'span.ywctm-custom-button',
			function ( e ) {
				if ( $( this ).parents( 'a' ).length === 1 ) {
					e.preventDefault();
				}
			}
		);

	}
);
