// External Dependencies
import React, { Component } from 'react';

class DSWCP_WooAccountUserName extends Component {

	static slug = 'ags_woo_account_user_name';

	static css(props) {

		const additionalCss = [];

		return additionalCss;
	}

	render() {
		return (
			<div className="username-wrapper" dangerouslySetInnerHTML={{__html: this.usernameHTML()}}></div>
		);
  	}

	userImage() {
        return window.DiviWoocommercePagesBuilderData.account_user_name.image;
    }

	userName(type) {
		const userData = window.DiviWoocommercePagesBuilderData.account_user_name.user_data;
		return userData[type] ? userData[type] : '';
	}

	usernameHTML(){
		return [
			this.props.before ? `<span className="before">${this.props.before}</span>` : '',
			this.userName(this.props.format) ? `<span className="username">${this.userName(this.props.format)}</span>`: '',
			this.props.after ? `<span className="after">${this.props.after}</span>` : ''
		].filter(text => !!text).join(' ');
	}
}

export default DSWCP_WooAccountUserName;
