jQuery( function ( $ ) {
	var file_frame                = [],
		enable_brand_product_page     = $( '#yith_wcbr_enable_brand_detail' ),
		enable_brand_loop             = $( '#yith_wcbr_enable_brand_loop' ),
		product_page_brand_image_size = $( '#yith_wcbr_single_product_brands_size_width' ),
		loop_brand_image_size         = $( '#yith_wcbr_loop_product_brands_size_width' ),
		product_page_content          = $( '#yith_wcbr_single_product_brands_content' ),
		loop_content                  = $( '#yith_wcbr_loop_product_brands_content' ),
		preview_thumbnail             = $( '#product_brand_thumbnail_id' ),
		preview_thumbnail_btn         = $( '#product_brand_thumbnail_upload' ),
		preview_banner                = $( '#product_brand_banner_id' ),
		preview_banner_btn            = $( '#product_brand_banner_upload' );

	//handle preview options
	if ( 0 == preview_thumbnail.val() ) {
		$(this).find( '#product_brand_thumbnail' ).hide();
	} else {
		$(this).find( '#product_brand_thumbnail' ).show();
	}

	preview_thumbnail_btn.on( 'click', function(){
		$( '#product_brand_thumbnail' ).show();
	});

	if ( 0 == preview_banner.val() ) {
		$(this).find( '#product_brand_banner' ).hide();
	} else {
		$(this).find( '#product_brand_banner' ).show();
	}

	preview_banner_btn.on( 'click', function(){
		$( '#product_brand_banner' ).show();
	});

	// handles upload image
	$( '.yith_wcbr_upload_image_button' ).on( 'click', function ( event ) {
		var t  = $( this ),
			id = t.attr( 'id' );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame[ id ] ) {
			file_frame[ id ].open();
			return;
		}

		// Create the media frame.
		file_frame[ id ] = wp.media.frames.downloadable_file = wp.media( {
			title   : yith_wcbr.labels.upload_file_frame_title,
			button  : {
				text: yith_wcbr.labels.upload_file_frame_button
			},
			multiple: false
		} );

		// When an image is selected, run a callback.
		file_frame[ id ].on( 'select', function () {
			attachment = file_frame[ id ].state().get( 'selection' ).first().toJSON();

			t.prev().val( attachment.id );
			t.parent().prev().find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
			t.next().show();
		} );

		// Finally, open the modal.
		file_frame[ id ].open();
	} );

	// handles remove image
	$( '.yith_wcbr_remove_image_button' ).on( 'click', function ( event ) {
		var t = $( this );

		event.preventDefault();

		t.siblings( 'input' ).val( '' );
		t.parent().prev().find( 'img' ).attr( 'src', yith_wcbr.wc_placeholder_img_src );
		t.hide();
		return false;
	} );

	// hide remove button when not needed
	$( '.yith_wcbr_upload_image_id' ).each( function () {
		var t = $( this );

		if ( !t.val() || t.val() == '0' ) {
			t.siblings( '.yith_wcbr_remove_image_button' ).hide();
		}
	} );

	// remove duplicated product_cat thumbnail form
	$( '#product_cat_thumbnail' ).parents( '.form-field' ).remove();

	// handle panel dependencies
	enable_brand_product_page.on( 'change', function () {
		var t = $( this );

		if ( t.val() == 'yes' ) {
			product_page_brand_image_size.parents( 'tr' ).show();
		} else {
			product_page_brand_image_size.parents( 'tr' ).hide();
		}
	} );

	enable_brand_loop.on( 'change', function () {
		var t = $( this );

		if ( t.val() == 'yes' ) {
			loop_brand_image_size.parents( 'tr' ).show();
		} else {
			loop_brand_image_size.parents( 'tr' ).hide();
		}
	} );

	product_page_content.on( 'change', function () {
		var t = $( this );

		if ( t.val() == 'name' ) {
			product_page_brand_image_size.parents( 'tr' ).hide();
		} else {
			product_page_brand_image_size.parents( 'tr' ).show();
		}
	} );

	loop_content.on( 'change', function () {
		var t = $( this );

		if ( t.val() == 'name' ) {
			loop_brand_image_size.parents( 'tr' ).hide();
		} else {
			loop_brand_image_size.parents( 'tr' ).show();
		}
	} );

	// handle panel dependencies on page loads
	$( window ).on( "load", function() {
        if ( 'name' == loop_content.val() ) {
            loop_brand_image_size.parents( 'tr' ).hide();
        }
        if ( 'name' == product_page_content.val() ) {
            product_page_brand_image_size.parents( 'tr' ).hide();
        }
    });

	if ( 'edit-tags-php' === adminpage && 'edit-yith_product_brand' === pagenow ) {
		// Services List Table.
		var form       = $( '#addtag' ),
			submit_btn = form.find( '#submit' );

		var blankState      = $( '.yith-plugin-fw__list-table-blank-state' ),
			blankStateStyle = $( '#yith-wcbr-blank-state-style' ),
			tableBody       = $( '#posts-filter .wp-list-table #the-list' );

		if ( blankState.length && blankStateStyle.length && tableBody.length ) {
			if ( typeof MutationObserver !== 'undefined' ) {
				var removeBlankState = function () {
						blankState.remove();
						blankStateStyle.remove();
						observer.disconnect();
					},
					observer = new MutationObserver( removeBlankState );

				observer.observe( tableBody.get( 0 ), { childList: true } );
			} else {
				var removed = false;
				submit_btn.on( 'click', function () {
					if ( !removed ) {
						blankState.remove();
						blankStateStyle.remove();
						removed = true;
					}
				} );
			}
		}
	}
} );
