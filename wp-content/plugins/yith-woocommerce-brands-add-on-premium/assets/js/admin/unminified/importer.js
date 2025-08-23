/**
 * Importer JS.
 *
 * @package YITH\Brands\Assets\JS
 */

 jQuery(
	function ($) {
		if ( $( '.ywcbr-import-brands' ).length ) {
            $( '.ywcbr-import-brands' ).closest( 'form' ).attr( 'enctype', 'multipart/form-data' );
        }

        $( '#yith-ywcbr-import-button' ).on( 'click', function(e) {
            e.preventDefault();

            $( '#yith-ywcbr-import-csv' ).trigger('click');
        });

        $( '#yith-ywcbr-import-csv' ).on( 'change', function( e ) {
            var file_name =  document.getElementById( 'yith-ywcbr-import-csv' ).files[0].name;

            if ( file_name !== '' ) {
                $( '.yith-ywcbr-file-name' ).html( file_name );
            }
        });

        $( '.ywcbr-import-brands' ).on( 'click', function( e ) {
            window.onbeforeunload = null;

            e.preventDefault();

            $( '.ywcbr-safe-submit-field' ).val( 'importing_brands' );
            $( this ).closest( 'form' ).submit();
        });

        if ( $( '.yith_wcbr_import_result' ).length ) {
            setTimeout(
                function () {
                    $('.yith_wcbr_import_result').remove();
                },
                3000
            );
        }
	}
);
