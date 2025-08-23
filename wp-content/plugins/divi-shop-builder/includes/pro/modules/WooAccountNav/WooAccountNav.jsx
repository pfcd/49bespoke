// External Dependencies
import React, { Component } from 'react';
import $ from 'jquery';

import DSWCP_Modules from '../../../loader';
import DSWCP_WooAccountNavItem from './../WooAccountNavItem/WooAccountNavItem';
import './style.scss';

class DSWCP_WooAccountNav extends Component {

	static slug = 'ags_woo_account_navigation';

	constructor(props) {
		super(props);
		this.processFontIcon = DSWCP_Modules.builderApi.Utils.processFontIcon;
	}

	static css(props) {

		const additionalCss = [];

		const corners = { top: 0, right: 1, bottom: 2, left: 3 };

		if( props.horizontal_align ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul',
				declaration: `justify-content: ${props.horizontal_align};`
			}]);
		}

		if( props.nav_item_padding ){
			const values = props.nav_item_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				if( !values[corners[corner]] ){
					return false;
				}
				additionalCss.push([{
					selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.nav_item_margin ){
			const values = props.nav_item_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				if( !values[corners[corner]] ){
					return false;
				}
				additionalCss.push([{
					selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.nav_item_icon_padding ){
			const values = props.nav_item_icon_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				if( !values[corners[corner]] ){
					return false;
				}
				additionalCss.push([{
					selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.nav_item_icon_margin ){
			const values = props.nav_item_icon_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				if( !values[corners[corner]] ){
					return false;
				}
				additionalCss.push([{
					selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.nav_item_icon_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
				declaration: `background-color:${props.nav_item_icon_bg_color} !important;`
			}]);
		}

		if( props.nav_item_acitve_icon_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:after',
				declaration: `background-color:${props.nav_item_acitve_icon_bg_color} !important;`
			}]);
		}

		if( props.nav_item_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
				declaration: `background-color:${props.nav_item_bg_color} !important;`
			}]);
		}

		if( props.nav_item_bg_color__hover ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li:hover',
				declaration: `background-color:${props.nav_item_bg_color__hover} !important;`
			}]);
		}

		if( props.nav_item_acitve_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active',
				declaration: `background-color:${props.nav_item_acitve_bg_color} !important;`
			}]);
		}

		if( props.nav_item_acitve_bg_color__hover ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active:hover',
				declaration: `background-color:${props.nav_item_acitve_bg_color__hover} !important;`
			}]);
		}

		if( props.hide_bullets === 'none' ){
			additionalCss.push([{
				selector:    '%%order_class%% nav.woocommerce-MyAccount-navigation ul',
				declaration: `list-style-type: none !important;`
			}]);
		}

		return additionalCss;
	}

	render() {

		return (
			<div className="woocommerce">
				<nav className={`woocommerce-MyAccount-navigation ${this.props.type} icon-${this.props.icon_position}`}>
					<ul>
						{this.renderNavItems()}
					</ul>
				</nav>
			</div>
		);
  	}

	renderNavItems(){
		if (this.props.content) {
			return this.props.content.map( ( content, index ) => {
				const newContent = Object.assign({}, content);
				newContent.props = Object.assign({}, content.props);
				newContent.props.attrs = Object.assign(
					{},
					{
						...content.props.attrs,
						item_name: content.props.attrs.item_name ? content.props.attrs.item_name : content.props.attrs.item_title,
						item_title: content.props.attrs.item_name ? content.props.attrs.item_name : content.props.attrs.item_title
					}
				);
				return (
					<DSWCP_WooAccountNavItem key={index} { ...Object.assign( {}, newContent.props.attrs, { index: index } ) } />
				);
			});
		}
	}
}

export default DSWCP_WooAccountNav;
