/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';
import parse from 'html-react-parser';
import getResponsiveProp from './../Abstracts/Responsive';
import $ from 'jquery';

// Internal Dependencies
import Mixins from './../../../mixins';
import './style.scss';

class DSWCP_WooCheckoutBillingInfo extends Component {

	static slug = 'ags_woo_checkout_billing_info';

	constructor(props) {
		super(props);
		this.getResponsiveProp 	  = getResponsiveProp.bind(this);
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
  	}

	render() {

    	// woocommerce/templates/checkout/form-billing.php
    	return (
			<form onSubmit={(e) => e.preventDefault()} className="checkout woocommerce-checkout">
				<div className="woocommerce-billing-fields">
					<h3>{this.getResponsiveProp('billing_title')}</h3>
					<div className="woocommerce-billing-fields__field-wrapper">
						<p className="form-row form-row-first">
							<label>{this.getResponsiveProp('first_name_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text" />
							</span>
						</p>
						<p className="form-row form-row-last">
							<label>{this.getResponsiveProp('last_name_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text" />
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('company_label')} (optional)</label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text" />
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('country_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<select className="country_to_state country_select">
									{
										Object.keys( this.getCountries() ).map( ( value ) =>
											<option key={value} value={value}>{parse( this.getCountries()[value] )}</option>
										)
									}
								</select>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('address_1_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text" placeholder="House number and street name"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label className="screen-reader-text"></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text" placeholder="Apartment, suite, unit, etc. (optional)"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('city_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('state_label')} (optional)</label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('postcode_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('phone_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text"/>
							</span>
						</p>
						<p className="form-row form-row-wide">
							<label>{this.getResponsiveProp('email_label')} <abbr className="required" title="required">*</abbr></label>
							<span className="woocommerce-input-wrapper">
								<input type="text" className="input-text"/>
							</span>
						</p>
					</div>
				</div>
			</form>
    	);
  	}

	isToggled(){
		return this.getResponsiveProp('coupon_toggle_model') !== 'on' || this.state.isToggled;
	}

	getCountries(){
		return window.DiviWoocommercePagesBuilderData.billing_info.countries;
	}

	componentDidMount(){
		// for some reason checkout script doesnt work
		// therefore we trigger it manually
		window.jQuery('.country_select').selectWoo();
	}
}

export default DSWCP_WooCheckoutBillingInfo;
