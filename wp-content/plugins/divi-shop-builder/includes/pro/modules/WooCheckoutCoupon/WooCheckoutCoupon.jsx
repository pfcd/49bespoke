/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';
import getResponsiveProp from './../Abstracts/Responsive';

// Internal Dependencies
import DSWCP_Modules from '../../../loader';
import Mixins from './../../../mixins';
import './style.scss';

class DSWCP_WooCheckoutCoupon extends Component {

	static slug = 'ags_woo_checkout_coupon';

	constructor(props) {
		super(props);
		this.state = {
			isToggled: true,
		};
		this.getResponsiveProp 	  = getResponsiveProp.bind(this);
		this.processFontIcon 	  = DSWCP_Modules.builderApi.Utils.processFontIcon;
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
  	}

	static css(props){

		const additionalCss = [];

		if( props.coupon_toggle_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-form-coupon-toggle > .woocommerce-info',
				declaration: `background-color: ${props.coupon_toggle_bg_color} !important;`
			}]);
		}

		return additionalCss;
	}

	render() {

    	// woocommerce/templates/checkout/form-coupon.php
    	return (
			<div>
				{ this.getResponsiveProp('coupon_toggle_model') === 'on' &&
				<div className="woocommerce-form-coupon-toggle">
					<div className="woocommerce-info">
						{this.getResponsiveProp('coupon_toggle_title') + ' '}
						<a href="#" onClick={() => this.setState({ isToggled: !this.state.isToggled })} className="showcoupon">{this.getResponsiveProp('coupon_toggle_text')}</a>
					</div>
				</div>
				}
				{ this.isToggled() &&
				<form className="checkout_coupon woocommerce-form-coupon" method="post">
					<p>{this.getResponsiveProp('coupon_content_text')}</p>
					<p className="form-row form-row-first">
						<input type="text" name="coupon_code" className="input-text" placeholder={this.getResponsiveProp('coupon_input_placeholder')} id="coupon_code" />
					</p>
					<p className="form-row form-row-last">
						<button type="submit" className="button" name="apply_coupon" value="Apply coupon" data-icon={this.processFontIcon(this.props.apply_coupon_button_icon)}>{this.getResponsiveProp('coupon_button_text')}</button>
					</p>
					<div className="clear"></div>
				</form>
				}
			</div>
    	);
  	}

	isToggled(){
		return this.getResponsiveProp('coupon_toggle_model') !== 'on' || this.state.isToggled;
	}
}

export default DSWCP_WooCheckoutCoupon;
