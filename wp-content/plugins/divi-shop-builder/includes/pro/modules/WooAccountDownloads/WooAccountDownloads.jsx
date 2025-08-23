// External Dependencies
import React, { Component } from 'react';

import DSWCP_Modules from '../../../loader';
import './style.scss';

class DSWCP_WooAccountDownloads extends Component {

	static slug = 'ags_woo_account_downloads';

	static css(props) {

		const additionalCss = [];

		if( props.button_view_use_icon === 'on' && props.button_view_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_view_icon);
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content table.woocommerce-table--order-downloads td.download-file .button::after',
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.button_browser_use_icon === 'on' && props.button_browser_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_browser_icon);
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .woocommerce-Message.woocommerce-Message--info .button::after',
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.no_downloads_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .woocommerce-Message.woocommerce-Message--info',
				declaration: `background-color:  ${props.no_downloads_bg_color} !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		return (
			<div className="woocommerce-MyAccount-content">
				<div className="downloads-wrapper">
					<div className="woocommerce-Message woocommerce-Message--info woocommerce-info">
						<a className="woocommerce-Button button" href="#"> Browse products </a>
						No downloads available yet.
					</div>
				</div>
				<div className="downloads-wrapper">
					<section className="woocommerce-order-downloads">
						<table
							className="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
							<thead>
							<tr>
								<th className="download-product"><span className="nobr">Product</span></th>
								<th className="download-remaining"><span className="nobr">Downloads remaining</span>
								</th>
								<th className="download-expires"><span className="nobr">Expires</span></th>
								<th className="download-file"><span className="nobr">Download</span></th>
							</tr>
							</thead>

							<tbody>
							<tr>
								<td className="download-product" data-title="Product">
									<a href="#">Awesome Product Name</a></td>
								<td className="download-remaining" data-title="Downloads remaining">
									∞
								</td>
								<td className="download-expires" data-title="Expires">
									Never
								</td>
								<td className="download-file" data-title="Download">
									<a href="#"
									   className="woocommerce-MyAccount-downloads-file button alt">Download</a></td>
							</tr>
							</tbody>
						</table>
					</section>

				</div>
			</div>
		);
  	}

}

export default DSWCP_WooAccountDownloads;
