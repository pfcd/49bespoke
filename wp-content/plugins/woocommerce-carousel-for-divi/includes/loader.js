/*! @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
Contents of this file (or the corresponding source JSX file) have been modified by Essa Mamdani, Jonathan Hall, and/or others.
Contents of this file (or the corresponding source JSX file) were last modified 2020-11-14
*/

// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from './modules';
import fields from './fields';

$(window).on('et_builder_api_ready', (event, API) => {

	// woocommerce-carousel-for-divi\includes\modules\WoocommerceCarousel\WoocommerceCarousel.jsx
	if (window.ETBuilderBackend && window.ETBuilderBackend.defaults && window.DSWCWoocommerceCarouselBackend && window.DSWCWoocommerceCarouselBackend.defaultContent) {
		window.ETBuilderBackend.defaults.dswc_woocommerce_carousel = {
			content: window.DSWCWoocommerceCarouselBackend.defaultContent
		};
	}
	
  API.registerModules(modules);
  API.registerModalFields(fields);
});
