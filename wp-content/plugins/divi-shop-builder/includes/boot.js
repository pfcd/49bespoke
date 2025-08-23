/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-12-08
*/

import $ from 'jquery';
import ReactDOM from 'react-dom';
import Notice from './components/notice/Notice';
import React from 'react';


const CART_MODULES = [
	'ags_woo_cart_list'
];

const CHECKOUT_MODULES = [
	'ags_woo_checkout_coupon',
	'ags_woo_checkout_billing_info',
	'ags_woo_checkout_shipping_info',
	'ags_woo_checkout_order_review'
];

let API = null;
let pluginModules = [];

export const bootstrap = ( api ) => {

	API = api;

	[ ...CART_MODULES, ...CHECKOUT_MODULES ].forEach( ( moduleSlug ) => {

		const moduleData = window.ET_Builder.Frames.app.ETBuilderBackend.modules.find( module => module.label === moduleSlug );
		if( moduleData ) pluginModules.push( moduleData ); // store it for toggle upon mount and unmount

		$(window).on( 'et_fb_module_did_mount_' + moduleSlug, toggleWoocommerceClasses );
		$(window).on( 'et_fb_module_did_mount_' + moduleSlug, removeModuleFromList );
		$(window).on( 'et_fb_module_did_mount_' + moduleSlug, checkForValidCheckoutModules );
		$(window).on( 'et_fb_module_did_update_' + moduleSlug, toggleWoocommerceClasses );
		$(window).on( 'et_fb_module_did_update_' + moduleSlug, checkForValidCheckoutModules );
		$(window).on( 'et_fb_module_will_unmount_' + moduleSlug, addModuleToList );

	});
}

const toggleWoocommerceClasses = function(e, props, prevProp = null){

	const { type } 	 = props;
	const classNames = API.Utils.classnames;

	if( CART_MODULES.includes( type ) ){
		$('body').addClass(
			classNames(
				{
					'woocommerce-cart': !$('body').hasClass('woocommerce-cart'),
					'woocommerce-page': !$('body').hasClass('woocommerce-page')
				}
			)
		);
	}

	if( CHECKOUT_MODULES.includes( type ) ){
		$('body').addClass(
			classNames(
				{
					'woocommerce-checkout': !$('body').hasClass('woocommerce-checkout'),
					'woocommerce-page': !$('body').hasClass('woocommerce-page')
				}
			)
		);
	}

	$('.et_builder_inner_content').addClass( classNames( { 'woocommerce': !$('.et_builder_inner_content').hasClass('woocommerce') } ) );
}


const removeModuleFromList = function( e, props ){

	const module = window.ET_Builder.Frames.app.ETBuilderBackend.modules.find( ( module ) => module.label === props.type );

	if( module ){
		module.is_parent = 'off';
	}
}


const addModuleToList = function( e, props ){

	const module = window.ET_Builder.Frames.app.ETBuilderBackend.modules.find( ( module ) => module.label === props.type );

	if( module ){
		module.is_parent = 'on';
	}
}

const checkForValidCheckoutModules = function( e, props ){

	const checkoutFlowModules = CHECKOUT_MODULES.filter( ( module, i ) => i !== 0 );

	if( !checkoutFlowModules.includes( props.type ) ){
		return;
	}

	const invalids = [];
	const modulesSelectors = checkoutFlowModules.map( ( name ) => ".".concat( name ) ).join( ',' );


	const forms	  = $('form').filter( ( i,  el ) => !$(el).parents(modulesSelectors).length );
	forms.each( function(){

		if( $(this).parents('.et_pb_column').find( modulesSelectors ).length ){
			invalids.push($(this));
			return true;
		}

		const prevRows = $(this).parents('.et_pb_row').prevAll('.et_pb_row').filter( ( i, el ) => $(el).find( modulesSelectors ).length );
		const nextRows = $(this).parents('.et_pb_row').nextAll('.et_pb_row').filter( ( i, el ) => $(el).find( modulesSelectors ).length );

		if( prevRows.length && nextRows.length ){
			invalids.push( $(this) );
			return true;
		}

		const prevSection = $(this).parents('.et_pb_section').prevAll('.et_pb_section').filter( ( i, el ) => $(el).find( modulesSelectors ).length );
		const nextSection = $(this).parents('.et_pb_section').nextAll('.et_pb_section').filter( ( i, el ) => $(el).find( modulesSelectors ).length );

		if( prevSection.length && nextSection.length ){
			invalids.push( $(this) );
		}
	});


	if( !$('#et-fb-app').children('.ags_divi_wc_notices').length ){
		$('#et-fb-app').prepend('<div class="ags_divi_wc_notices" />');
	}

	if( invalids.length ){

		const actions = [];
		actions.push({
			label: window.DiviWoocommercePagesBuilderData.checkout_notice.go_to_button,
			callback: () => {
				window.et_pb_smooth_scroll( $( invalids[0] ), false, 650 );
			}
		});

		const heading = window.DiviWoocommercePagesBuilderData.checkout_notice.heading;
		const content = window.DiviWoocommercePagesBuilderData.checkout_notice.content;

		ReactDOM.render( <Notice heading={heading} content={content} actions={actions} />, $('.ags_divi_wc_notices').get(0) );
	}else{
		ReactDOM.unmountComponentAtNode( $('.ags_divi_wc_notices').get(0) );

	}
}