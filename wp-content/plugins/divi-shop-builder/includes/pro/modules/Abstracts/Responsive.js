/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-12
*/

/**
 * get property value by current response view
 *
 * @param {String} prop
 * @param {String} defaultVal
 * @returns {String}
 */
const getResponsiveProp = function( prop, defaultVal = '' ){

	const view = window.ET_Builder.Frames.app.ET_Builder.API.State.View_Mode;

	let value;

	if( view.isTablet() ){
		// checks if state is set for the tablet or assign the main view
		value = typeof( this.props[`${prop}_tablet`] ) !== 'undefined' ? this.props[`${prop}_tablet`] : this.props[prop];
	}else if( view.isPhone() ){
		// checks if state is set for the mobile or assign the parent views by descending order ( phone ->tablet -> desktop )
		value = typeof( this.props[`${prop}_phone`] ) !== 'undefined' ?
			this.props[`${prop}_phone`] : typeof( this.props[`${prop}_tablet`] ) !== 'undefined' ?
				this.props[`${prop}_tablet`] : this.props[prop];
	}else{
		value = this.props[prop];
	}

	return value ? value : defaultVal;
}

export default getResponsiveProp;