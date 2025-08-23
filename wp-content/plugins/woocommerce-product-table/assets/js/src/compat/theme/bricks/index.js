( function( $ ) {

	$( '.wc-product-table' ).on( 'draw.wcpt responsiveDisplay.wcpt', function() {
		// Make +/- quantity buttons work correcly on draw events.
		if ( typeof bricksWooQuantityTriggersFn === 'object' ) {
			bricksWooQuantityTriggersFn.run();
		}
		if ( typeof bricksWooLoopQtyListenerFn === 'object' ) {
			bricksWooLoopQtyListenerFn.run();
		}
	} );

} )( jQuery );