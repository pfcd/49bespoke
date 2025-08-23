// External Dependencies
import React, { Component } from 'react';

import DSWCP_Modules from '../../../loader';
import './style.scss';

class DSWCP_WooAccountOrders extends Component {

	static slug = 'ags_woo_account_orders';

	static css(props) {

		const additionalCss = [];

		if( props.button_view_use_icon === 'on' && props.button_view_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_view_icon);
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button::after',
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

		if( props.no_orders_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .woocommerce-Message.woocommerce-Message--info',
				declaration: `background-color:  ${props.no_orders_bg_color} !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		return (
			<div className="woocommerce-MyAccount-content">
				<div className="orders-wrapper">
					<div
						className="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
						<a className="woocommerce-Button button" href="#">Browse products</a>
						No order has been made yet.
					</div>
					<table
						className="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
						<thead>
						<tr>
							<th className="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
								<span className="nobr">Order</span>
							</th>
							<th className="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
								<span className="nobr">Date</span>
							</th>
							<th className="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
								<span className="nobr">Status</span>
							</th>
							<th className="woocommerce-orders-table__header woocommerce-orders-table__header-order-total">
								<span className="nobr">Total</span>
							</th>
							<th className="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
								<span className="nobr">Actions</span>
							</th>
						</tr>
						</thead>
						<tbody>
						<tr className="woocommerce-orders-table__row woocommerce-orders-table__row--status-pending order">
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
								data-title="Order">
								<a href="#">#211 </a>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
								data-title="Date">
								<time dateTime="2022-01-21T19:32:13+00:00">January 21, 2022</time>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
								data-title="Status">
								Pending payment
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
								data-title="Total">
                  <span className="woocommerce-Price-amount amount"><span
					  className="woocommerce-Price-currencySymbol">$</span>1.00</span> for 1 item
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
								data-title="Actions">
								<a href="#"	className="woocommerce-button button pay">Pay</a>
								<a href="#" className="woocommerce-button button view">View</a>
								<a href="#"	className="woocommerce-button button cancel">Cancel</a>
							</td>
						</tr>
						<tr className="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order">
								<a href="#"> #50 </a>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date">
								<time dateTime="2021-09-08T13:03:45+00:00">September 8, 2021</time>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Status">
								Completed
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
								data-title="Total">
                  <span className="woocommerce-Price-amount amount"><span
					  className="woocommerce-Price-currencySymbol">$</span>0.00</span> for 1 item
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
								data-title="Actions">
								<a href="#" className="woocommerce-button button view">View</a>
							</td>
						</tr>
						<tr className="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
								data-title="Order">
								<a href="#">#49 </a>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
								data-title="Date">
								<time dateTime="2021-09-08T13:02:15+00:00">September 8, 2021</time>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
								data-title="Status">
								Processing
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
								data-title="Total">
								<span className="woocommerce-Price-amount amount"><span className="woocommerce-Price-currencySymbol">$</span>0.00</span> for 1 item
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
								data-title="Actions">
								<a href="#"className="woocommerce-button button view">View</a>
							</td>
						</tr>
						<tr className="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
								data-title="Order">
								<a href="#">
									#26 </a>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
								data-title="Date">
								<time dateTime="2021-09-07T18:30:46+00:00">September 7, 2021</time>
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
								data-title="Status">
								Completed
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total" data-title="Total">
							  <span className="woocommerce-Price-amount amount"><span className="woocommerce-Price-currencySymbol">$</span>12.00</span> for 1 item
							</td>
							<td className="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Actions">
								<a href="#" className="woocommerce-button button view">View</a>
							</td>
						</tr>
						</tbody>
					</table>
					<div className="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
						<a className="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="#">Previous</a>
						<a className="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="#">Next</a>
					</div>
				</div>
			</div>
		);
	}

}

export default DSWCP_WooAccountOrders;
