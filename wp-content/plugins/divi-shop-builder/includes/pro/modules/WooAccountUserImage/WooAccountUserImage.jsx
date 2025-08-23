// External Dependencies
import React, { Component } from 'react';

class DSWCP_WooAccountUserImage extends Component {

	static slug = 'ags_woo_account_user_image';

	static css(props) {

		const additionalCss = [];

		if( props.align ){
			additionalCss.push([{
				selector:    `%%order_class%%`,
				declaration: `text-align: ${props.align} !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		return (
			<div className="image_wrap">
                <img src={this.userImage()} />
            </div>
		);
  	}

	userImage() {
        return window.DiviWoocommercePagesBuilderData.account_user_image.image;
    }
}

export default DSWCP_WooAccountUserImage;
