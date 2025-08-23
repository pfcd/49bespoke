/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
Contents of this file (or the corresponding source JS file) have been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
*/

// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from './modules';
import fields from './fields';
import {bootstrap} from './boot';

class DSWCP_Modules {

	static builderApi;

	static init() {
		
		// This is needed because Divi sets the default page type to "cart" otherwise when this plugin is enabled
		// (due to WooCommerce scripts which it enqueues)
		window.wp.hooks.addFilter(
			"et.builder.get.woo.default.page.type",
			"et.builder.get.woo.default.page.type",
			function(pageType) {
				
				if (pageType === 'cart') {
					var frame = document.getElementById("et-fb-app-frame");
					if ( frame && frame.contentWindow.document ) {
						var bodyClasses = frame.contentWindow.document.body.className.split(' ');
						if (bodyClasses.indexOf('woocommerce-cart') === -1) { // not actually the cart page
							return bodyClasses.indexOf('woocommerce-checkout') === -1 ? 'product' : 'checkout';
						}
					}
				}
				
				return pageType;
			},
			99
		);

		$(window).on('et_builder_api_ready', (event, API) => {


			fields.map((field) => {
				field.slug += '-DSB';
			});

			// divi-shop-builder\includes\modules\WooShop\WooShop.jsx
			// woocommerce-carousel-for-divi\includes\modules\WoocommerceCarousel\WoocommerceCarousel.jsx
			if (window.ETBuilderBackend && window.ETBuilderBackend.defaults && window.AGS_Divi_WC_Backend) {

				if( window.AGS_Divi_WC_Backend.shopModuleDefaultContent ){
					window.ETBuilderBackend.defaults.ags_woo_shop_plus = {
						content: window.AGS_Divi_WC_Backend.shopModuleDefaultContent
					};
				}

				if( window.AGS_Divi_WC_Backend.accountNavModuleDefaultContent ){
					window.ETBuilderBackend.defaults.ags_woo_account_navigation = {
						content: window.AGS_Divi_WC_Backend.accountNavModuleDefaultContent
					};
				}

				if( window.AGS_Divi_WC_Backend.accountContentModuleDefaultContent ){
					window.ETBuilderBackend.defaults.ags_woo_account_content = {
						content: window.AGS_Divi_WC_Backend.accountContentModuleDefaultContent
					};
				}
			}

		  DSWCP_Modules.builderApi = API;

		  API.registerModules(modules);
		  API.registerModalFields(fields);
		  bootstrap( API );
		  
		  if (!window.ETBuilderBackendDynamic.requestType || ['et_header_layout', 'et_body_layout', 'et_footer_layout'].indexOf(window.ETBuilderBackendDynamic.requestType) === -1) {
			  window.ags_divi_wc_notIsThemeBuilder = true;
		  }
		});
	}

}

DSWCP_Modules.init();

export default DSWCP_Modules;