( function( $ ) {

	function enfoldOnDraw( event, force = false ) {
		if ( $( this ).find( '.cart div.quantity:not(.buttons_added)' ).length !== 0 ) {
			$( this ).find( '.cart div.quantity' ).addClass( 'buttons_added' );
			$( document ).trigger( 'updated_cart_totals' );
		}
	}

	function enfoldEventListeners() {
		$( '.wc-product-table' ).on( 'responsiveDisplay.wcpt draw.wcpt', enfoldOnDraw );
	}

	enfoldEventListeners();

	$( document ).on( 'updated_cart_totals', enfoldEventListeners );

} )( jQuery );