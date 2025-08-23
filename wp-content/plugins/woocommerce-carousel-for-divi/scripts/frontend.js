/*! @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
Contents of this file (or the corresponding source JSX file) have been modified by Essa Mamdani, Jonathan Hall, Anna Kurowska and/or others.
Contents of this file (or the corresponding source JSX file) were last modified 2020-11-23
*/

window.jQuery(document).ready(function ($) {
    let sliders = $('.dswc.swiper-container').each((key, ele) => {
		
		let $ele = $(ele);
        let options = $ele.data('swiper');
        // options = Object.assign({}, options);
        let swiper = new Swiper(ele,options);
		
		if ( options.autoplay && options.autoplay.pauseOnHover) {
				
			$ele.mouseover(function() {
				swiper.autoplay.stop();
			});
			
			$ele.mouseout(function() {
				swiper.autoplay.start();
			});
		}
		
    });
});
