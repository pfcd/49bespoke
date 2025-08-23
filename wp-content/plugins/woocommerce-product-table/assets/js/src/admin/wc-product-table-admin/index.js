( function( $, window, document, params ) {
    "use strict";

    if ( !window.design_template_options ) {
        window.design_template_options = params.design_defaults_with_options;
        window.design_template_defaults = params.design_template_defaults;
    }

    /**
     * Update template fields
     * 
    * @param {array} templateDefaults 
     */
    function updateTemplateFields( templateDefaults ) {
        for (let field in templateDefaults) {
            if (!templateDefaults.hasOwnProperty(field)) continue;
            // Define the selectors
            let colorSizeSelector = `#wcpt_table_styling\\[${field}\\]\\[color\\]`;
            let sizeSelector = `#wcpt_table_styling\\[${field}\\]\\[size\\]`;
            let genericColorFieldSelector = `.color-field #wcpt_table_styling\\[${field}\\]`;
            // Reset color-size field's size value to default
            if ( $(sizeSelector).length ) {
                $(sizeSelector).val('');
            }
            // Reset color-size field's color value to default
            if ( $(colorSizeSelector).length && templateDefaults[field]['color'] === '' ) {
                $(colorSizeSelector).val('');
                $(colorSizeSelector)
                    .closest('.color-size-field')
                    .find('.wp-color-result')
                    .removeAttr('style');
            }
            // Reset color field's color value to default
            if ( $(genericColorFieldSelector).length && templateDefaults[field] === '' ) {
                $(genericColorFieldSelector).val('');
                $(genericColorFieldSelector)
                    .closest('.color-field')
                    .find('.wp-color-result')
                    .removeAttr('style');
            }
            
            // Update color value for specified fields
            if ( field === 'border_outer' || field === 'border_header' || field === 'border_horizontal_cell' || field === 'border_vertical_cell' || field === 'border_bottom' || field === 'header_font' || field === 'cell_font' || field === 'hyperlink_font' || field === 'button_font' || field === 'disabled_button_font' || field === 'quantity_font' || field === 'text_border' || field === 'dropdown_border' ) {
                $(colorSizeSelector).val(templateDefaults[field]['color']);
                $(colorSizeSelector).wpColorPicker('color', templateDefaults[field]['color']);
            }
           
            if ( field === 'header_bg' || field === 'cell_bg' || field === 'button_bg' || field === 'button_bg_hover' || field === 'button_disabled_bg' || field === 'button_quantity_bg' || field === 'dropdown_background' || field === 'dropdown_font' || field === 'checkboxes_border' || field === 'text_background' || field === 'text_font' ) {
                $(genericColorFieldSelector).val(templateDefaults[field]);
                $(genericColorFieldSelector).wpColorPicker('color', templateDefaults[field]);
            }
            
            // Update the checked state for specific fields
            if ( field == 'cell_backgrounds' || field == 'corner_style' ) {
                $('input[name="wcpt_table_styling['+field+']"][value="'+ templateDefaults[field] +'"]').prop('checked', true);
            }

            if ( $(sizeSelector).length && ( field === 'border_outer' || field === 'border_header' || field === 'border_horizontal_cell' || field === 'border_vertical_cell' || field === 'border_bottom' || field === 'text_border' || field === 'dropdown_border' ) ) {
                $( sizeSelector ).val(templateDefaults[field]['size']);
            }
        }
    }

    /**
     * On changing pre-built templates, update the fields
     */
    $( document ).on( 'change', '.design_templates', function() {
        let template = $( this ).val(),
            templateDefaults = window.design_template_options[template];
            window.skipTemplateChange = true;
        
        updateTemplateFields( templateDefaults );
        
        window.skipTemplateChange = false;
    } );

    
    /**
     * Update size field when color field is changed
     */
    if ($.fn.wpColorPicker) {
        $('.wpt-custom-color-size-field .color-picker').wpColorPicker({
            change: function(event, ui) {
                const allowedFields = [  'wcpt_table_styling[border_header][size]', 'wcpt_table_styling[border_horizontal_cell][size]', 'wcpt_table_styling[border_vertical_cell][size]', 'wcpt_table_styling[border_bottom][size]' ];
                const sizeField = $(event.target).closest('.color-size-field').find('input[type=number]');
                const fieldName = sizeField.attr('name');
                
                if (allowedFields.includes(fieldName) && ( !sizeField.val() || sizeField.val() == '0' )) {
                    sizeField.val('1');
                }
            }
        });
    }

    /**
     * Track changes for color picker and save settings for individual templates
     * 
     * @since 4.1.0
     */
    if ($.fn.wpColorPicker) {
        // Initialize the color picker
        $('.color-picker').wpColorPicker({
            change: function(event, ui) {
                if ( window.skipTemplateChange ) {
                    return;
                }
                // get currently selected theme
                let theme = $('.design_templates:checked').val();
                // selected color
                var selectedColor = ui.color.toString();
                // get the name attribute of the field and extract field option name
                var inputName = $(event.target).attr('name');
                var match = inputName.match(/wcpt_table_styling\[(.*?)\]/);
                var extractedName = match ? match[1] : null;
                // update field value for the template
                if (extractedName && window.design_template_options[theme][extractedName] && window.design_template_options[theme][extractedName].hasOwnProperty('color')) {
                    window.design_template_options[theme][extractedName]['color'] = selectedColor;
                } else if (extractedName) {
                    window.design_template_options[theme][extractedName] = selectedColor;
                }
            }
        });
    }

    /**
     * Track changes for every size input field and save settings for individual templates
     * 
     * @since 4.1.0
     */
    $( document ).on( 'change', '.color-size-field input', function( event ) {
        if ( window.skipTemplateChange ) {
            return;
        }
        let theme = $('.design_templates:checked').val(),
            inputName = $(event.target).attr('name'),
            sizeValue = $(this).val(),
            match = inputName.match(/wcpt_table_styling\[(.*?)\]/),
            extractedName = match ? match[1] : null;
        // update field value for the template
        window.design_template_options[theme][extractedName]['size'] = sizeValue;
    } );

    $( document ).on( 'change', '.wpt_cell_backgrounds_field, .wpt_corner_style_field', function( event ) {
        if ( window.skipTemplateChange ) {
            return;
        }
        let theme = $('.design_templates:checked').val(),
            inputName = $(event.target).attr('name'),
            fieldVal = $(this).val(),
            match = inputName.match(/wcpt_table_styling\[(.*?)\]/),
            extractedName = match ? match[1] : null;
        // update field value for the template
        window.design_template_options[theme][extractedName] = fieldVal;
    } );


    /**
     * Reset the design templates settings to default
     * 
     * @since 4.1.0
     */
    $( document ).on( 'click', 'button[name="reset_design_settings"]', function( e ) {
        e.preventDefault();
        const selectedTheme = $( '.design_templates:checked' ).val();
        const templateDefaults = params.design_template_defaults[selectedTheme];
        
        updateTemplateFields( templateDefaults );
    } );

    $( document ).on( 'click', '[data-open-lightbox="1"]', function() {
        const lightboxImage = $(this).data('lightbox-image');
        const lightboxContainer = $('body');
        lightboxContainer.find('.barn2-lightbox-content').remove();

        const lightboxContent = '<div class="barn2-lightbox-content"><img src="'+lightboxImage+'"/></div>';
        lightboxContainer.append( lightboxContent );

    } );

    // Remove the lightbox on clicking outside the lightbox image
    $( document ).on('click', '.barn2-lightbox-content', function( event ) {
        if (event.target === $(this)[0]) {
            $(this).remove();
        }
    });
    // Toggle child settings.
    var toggleChildSettings = function( $parent, $children ) {
        var show = false;
		var toggleVal = $parent.data( 'toggleVal' );

        if ( 'radio' === $parent.attr( 'type' ) ) {
            show = $parent.prop( 'checked' ) && toggleVal == $parent.val();
        } else if ( 'checkbox' === $parent.attr( 'type' ) ) {
            if ( typeof toggleVal === 'undefined' || 1 == toggleVal ) {
                show = $parent.prop( 'checked' );
            } else {
                show = !$parent.prop( 'checked' );
            }
        } else {
            show = ( toggleVal == $parent.val() );
        }

        $children.toggle( show );
    };

    // Disable lazy load option if variation equals to separate.
    function checkVariationsAndLazyload( el ) {
        if ( el.val() === 'separate' ) {
            $( '.field-lazyload input' ).prop( {
                'checked': false,
                'disabled': true
            } ).trigger( 'change' ).closest( 'td' ).addClass( 'disabled' );

            $( '#lazyload-description-1' ).hide();
            $( '#lazyload-description-2' ).show();

            $( '.field-product_limit' ).closest( 'tr' ).removeClass( 'hidden' );
        } else {
            $( '.field-lazyload input' ).prop( {
                'disabled': false
            } ).trigger( 'change' ).closest( 'td' ).removeClass( 'disabled' );

            $( '#lazyload-description-2' ).hide();
            $( '#lazyload-description-1' ).show();

            if ( $( '.field-lazyload input' ).is(':checked') ) {
                $( '.field-product_limit' ).closest( 'tr' ).addClass( 'hidden' );
            }
        }
    }

    $( function() {

        // Disable lazy load option if variation equals to separate on the wizard.
        window.addEventListener( 'barn2-step-loaded', (e) => {
            if ( e.detail.step === 'performance' ) {
                if ( e.detail.values.variations === 'separate' ) {
                    $( '#lazyload-description-1' ).closest('.components-base-control').addClass( 'disabled' ).find('input').prop( {
                        'checked': false,
                        'disabled': true
                    } ).trigger( 'change' );

                    $( '#lazyload-description-1' ).hide();
                    $( '#lazyload-description-2' ).show();
                } else {
                    $( '#lazyload-description-1' ).closest('.components-base-control').removeClass( 'disabled' ).find('input').prop( {
                        'disabled': false
                    } ).trigger( 'change' );

                    $( '#lazyload-description-2' ).hide();
                    $( '#lazyload-description-1' ).show();
                }
            }
          },
          false
        );

        // Disable lazy load option if variation equals to separate on the edit table.
        wp.hooks.addAction( 'barn2_table_generator_render_fields', 'barn2_table_generator_render_fields', function(){
            checkVariationsAndLazyload( $( '.field-variations select' ) );
        } );
        $( document ).on( 'change', '.field-variations select', function (e) {
            checkVariationsAndLazyload( $( this ) );
        } ) ;
        wp.hooks.addFilter( 'barn2_table_generator_update_table_details', 'barn2_table_generator_update_table_details', function( tableDetails, tableId ){
            tableDetails.settings.lazyload = $( '.field-lazyload input' ).prop('checked');
            return tableDetails;
        } );

        // Toggle child settings.
        $( '.form-table .toggle-parent' ).each( function() {
            var $parent = $( this );
            var $children = $parent.closest( '.form-table' ).find( '.' + $parent.data( 'child-class' ).replace( ' ', ',.') ).closest( 'tr' );

            toggleChildSettings( $parent, $children );

            $parent.on( 'change', function() {
                toggleChildSettings( $parent, $children );
            } );
        } );

        // Display 'Clear cache' button if caching is enabled
        if ( $( '.form-table .cache-toggle' ).length && $( '.form-table .cache-toggle' ).is(':checked') ) {
            $( 'input[name="clear_cache"]' ).addClass( 'display' );
        }

        // Toggle display the 'Clear cache' button on clicking the caching button
        $( '.form-table .cache-toggle' ).on( 'click', function() {
            $( 'input[name="clear_cache"]' ).toggleClass( 'display' );
        } );

        // Clear table cache on clicking the 'Clear Cache' button
        $( document ).on( 'click', 'input[name="clear_cache"]', function( e ) {
            e.preventDefault();
            const button = $( this );

            if ( button.hasClass('ajax-processing') ) {
                return;
            }
            button.addClass('ajax-processing');

            const data = {
                action: 'clear_table_cache',
                nonce: params.ajax_nonce
            };

            // Make AJAX request to clear table caches
            $.ajax( {
                url: params.ajax_url,
                type: 'POST',
                data: data
            } ).done( function( response ) {
                // reload the page on success
                window.location.href = params.settings_page_url;
            } )
        } );

        // Add extra data to the steps to be able to change the wizard titles.
		$( document ).on( 'change','input[name="table_display"]', function (e) {
			$( '.barn2-stepper__steps > .barn2-stepper__step:eq(1) .barn2-stepper__step-label' ).text( Barn2TableGenerator.steps.refine.extra_data[ 'name_' + $( this ).val() ] );
			Barn2TableGenerator.steps.refine.name = Barn2TableGenerator.steps.refine.extra_data[ 'name_' + $( this ).val() ];
			Barn2TableGenerator.steps.refine.title = Barn2TableGenerator.steps.refine.extra_data[ 'title_' + $( this ).val() ];
			Barn2TableGenerator.steps.refine.description = Barn2TableGenerator.steps.refine.extra_data[ 'description_' + $( this ).val() ];
		});


    } );

} )( jQuery, window, document, product_table_admin_params );