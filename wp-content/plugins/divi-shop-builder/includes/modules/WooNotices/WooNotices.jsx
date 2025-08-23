/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JSX file) has been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
This file (or the corresponding source JSX file) was last modified 2020-11-24
*/

// External Dependencies
import React, { Component } from 'react';
import ReactDom from 'react-dom';
import $ from 'jquery';

// Internal Dependencies
import './style.scss';
import DSWCP_Modules from './../../loader';

class DSWCP_WooNotices extends Component {

	static slug = 'ags_woo_notices';

	constructor(props) {
		super(props);

		this.classnames = DSWCP_Modules.builderApi.Utils.classnames;
		this.processFontIcon 	  = DSWCP_Modules.builderApi.Utils.processFontIcon;
		this.state = {
			noticeType: 'message'
		};
  	}

	static css(props) {
		const additionalCss = [];

		if( props.notice_success_bg_color ){
			additionalCss.push([{
				selector:    '.woocommerce-notices-wrapper .woocommerce-message',
				declaration: `background-color: ${props.notice_success_bg_color} !important;`
			}]);
		}

		if( props.notice_info_bg_color ){
			additionalCss.push([{
				selector:    '.woocommerce-notices-wrapper .woocommerce-info',
				declaration: `background-color: ${props.notice_info_bg_color} !important;`
			}]);
		}

		if( props.notice_error_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-error',
				declaration: `background-color: ${props.notice_error_bg_color} !important;`
			}]);
		}

		return additionalCss;
	}

	render() {

		let buttonIcon = null;
		switch(this.state.noticeType){
			case 'message':
				buttonIcon = this.props.general_notice_button_icon;
				break;
			case 'info':
				buttonIcon = this.props.info_notice_button_icon;
				break;
			case 'error':
				buttonIcon = this.props.error_notice_button_icon;
				break;
		}

    	return (
			<div className="woocommerce">
				<div className="woocommerce-notices-wrapper">
					<div className={this.classnames({ [`woocommerce-${this.state.noticeType}`]: true })}>
						{this.localizedText('notice_message')} <a href="#">{this.localizedText('notice_link')}</a>
						<a href="#" className="button" data-icon={this.processFontIcon(buttonIcon)}>{this.localizedText('notice_button_text')}</a>
					</div>
				</div>
			</div>
    	);
  	}

	componentDidMount() {
		const topDocument = window.ET_Builder.Frames.top.document;
		$(topDocument).on('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));
	}

	onToggleActive(e){
		const topDocument = window.ET_Builder.Frames.top.document;


		if( !$(window.ET_Builder.Frames.app.document).find('.ags_woo_notices.et_fb_editing_enabled:first').length ){
			return;
		}



		setTimeout( () => {
				const node	 = $(topDocument).find('.et-fb-tabs__panel--active .et-fb-form__toggle-opened:first');

				const toggle = node.data('name');
				let type 	 = 'message';

				switch( toggle ){
					case 'notice_info':
						type = 'info';
						break;
					case 'notice_success':
						type = 'message';
						break;
					case 'notice_error':
						type = 'error';
						break;
				}

				this.setState({noticeType: type});
		});
	}

	localizedText( key ){
		const translations = window.DiviWoocommercePagesBuilderData.notices.locals;
		return translations[key] ? translations[key] : '';
	}
}

export default DSWCP_WooNotices;
