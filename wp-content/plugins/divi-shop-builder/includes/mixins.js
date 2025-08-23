/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-12
*/

import $ from 'jquery';

/**
 * Method for component unmount
 *
 */
const componentWillUnmount = function(){

	const slug 	= this.props.moduleInfo.type;
	const props = { ...{ type: slug }, ...this.props };

	$(window).trigger( 'et_fb_module_will_unmount_' + slug, [ props ] );
}

// export all the mixins
export default {
	componentWillUnmount
}