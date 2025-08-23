// External Dependencies
import React, { Component } from 'react';
import DSWCP_WooMiniCart_SideCart from './jsx-includes/SideCart'
import DSWCP_WooMiniCart_DropdownCart from './jsx-includes/DropdownCart'

import './style.scss';
import {generateStyles} from "../../../module_dependencies/styles";
import DSWCP_Modules from "../../loader";

import {apply_responsive} from "../../../module_dependencies/ags-responsive";

class DSWCP_WooMiniCart extends Component {

	static slug = 'ags_woo_mini_cart';

	constructor(props) {
		super(props);
		
		if (!window.et_gb.wp.hooks.hasFilter('ags.woo.mini.cart.css.selector', 'wpzone/dsb/mini-cart-css-selector')) {
			window.et_gb.wp.hooks.addFilter('ags.woo.mini.cart.css.selector', 'wpzone/dsb/mini-cart-css-selector', function(selector) {
				return selector.replaceAll(/body \#page\-container(\-bfb)? /g, '');
			});
		}
		if (!window.et_gb.wp.hooks.hasFilter('ags.woo.mini.cart.processed.css.selector', 'wpzone/dsb/mini-cart-css-selector-processed')) {
			window.et_gb.wp.hooks.addFilter('ags.woo.mini.cart.processed.css.selector', 'wpzone/dsb/mini-cart-css-selector-processed', function(selector) {
				if (!window.ETBuilderBackend.css) {
					return selector;
				}
				var prefix = window.ETBuilderBackend.css.wrapperPrefix + ' ' + window.ETBuilderBackend.css.layoutPrefix;
				return selector.split(',').map(function(part) {
					if (part.indexOf(prefix + ' ') !== -1) {
						return ((part.indexOf('.et_pb_button') === -1 && part.indexOf('.dswcp-buttons') === -1) ? '' : part + ',') + part.replace(prefix + ' ', '');
					}
					return part;
				}).join(',');
			});
		}
  	}

	static marginPaddingElements = {
		cart_icon: '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
		cart_icon_count: '%%order_class%% a.dswcp-cart-link .dswcp-count',
		dropdown: '%%order_class%% .dswcp-dropdown-cart',
		dropdown_container: '%%order_class%% .dswcp-dropdown-cart-container',
		side_cart: '%%order_class%% .dswcp-side-cart',
		cart_icon_amount: '%%order_class%% a.dswcp-cart-link .dswcp-amount',
		header: '%%order_class%% .dswcp-side-cart-header, %%order_class%% .dswcp-dropdown-cart-header',
		product: '%%order_class%% .dswcp-dropdown-cart-item, %%order_class%% .dswcp-side-cart-item',
		product_image: '%%order_class%% .dswcp-image-container',
		product_name: '%%order_class%% h3.dswcp-product-name',
		product_remove: '%%order_class%% .dswcp-remove',
		footer: '%%order_class%% .dswcp-side-cart-footer, %%order_class%% .dswcp-dropdown-cart-footer',
		subtotal: '%%order_class%% .dswcp-subtotal',
		typography: '%%order_class%% .dswcp-dropdown-cart-header h2',
		empty_message: '%%order_class%% .dswcp-cart-empty',
		empty_message_p: '%%order_class%% .dswcp-cart-empty p',
		empty_message_icon: '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
		close_button: '%%order_class%% .dswcp-side-cart .dswcp-close, %%order_class%% .dswcp-dropdown-cart .dswcp-close',
	};

	static css(props) {

		const additionalCss = [];

		//CSS
		additionalCss.push([
			{
				selector: '%%order_class%% .dswcp-count',
				declaration: `top: ${props.cart_icon_count_position_top};`
			}
		]);


		if (props.dropdown_direction && props.dropdown_direction === 'right') {
			additionalCss.push([
				{
					selector: '%%order_class%% .dswcp-dropdown-cart-container',
					declaration: `right: unset; left: 0px;`
				}
			]);
		}
		if (props.float_right === 'on') {
			additionalCss.push([
				{
					selector: '%%order_class%% .et_pb_module_inner',
					declaration: `float: right;`
				}
			]);
		}

		// Responsive CSS
		let additionalCss_ = additionalCss;

		if (props.cart_icon_count_position && props.cart_icon_count_position === 'left') {
			additionalCss_.push(generateStyles({
				attrs: props,
				name: 'cart_icon_count_position_left',
				selector: '%%order_class%% .dswcp-count',
				cssProperty: 'left',
				responsive: true
			}));

		}
		if (props.cart_icon_count_position && props.cart_icon_count_position === 'right') {
			additionalCss_.push(generateStyles({
				attrs: props,
				name: 'cart_icon_count_position_right',
				selector: '%%order_class%% .dswcp-count',
				cssProperty: 'right',
				responsive: true
			}));

		}

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'cart_icon_count_bg',
			selector: '%%order_class%% .dswcp-count',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'cart_icon_bg',
			selector: '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'cart_icon_col',
			selector: '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
			cssProperty: 'color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'cart_icon_size',
			selector: '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
			cssProperty: 'font-size',
			responsive: true,
			important: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'cart_icon_line-height',
			selector: '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
			cssProperty: 'line-height',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'dropdown_width',
			selector: '%%order_class%% .dswcp-dropdown-cart',
			cssProperty: 'width',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'dropdown_top_position',
			selector: '%%order_class%% .dswcp-dropdown-cart-container',
			cssProperty: 'top',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'dropdown_min_width',
			selector: '%%order_class%% .dswcp-dropdown-cart',
			cssProperty: 'min-width',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'dropdown_max_width',
			selector: '%%order_class%% .dswcp-dropdown-cart',
			cssProperty: 'max-width',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'dropdown_bg',
			selector: '%%order_class%% .dswcp-dropdown-cart',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'side_cart_width',
			selector: '%%order_class%% .dswcp-side-cart',
			cssProperty: 'width',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'side_cart_bg',
			selector: '%%order_class%% .dswcp-side-cart',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'header_bg',
			selector: '%%order_class%% .dswcp-side-cart-header, %%order_class%% .dswcp-dropdown-cart-header',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'footer_bg',
			selector: '%%order_class%% .dswcp-side-cart-footer, %%order_class%% .dswcp-dropdown-cart-footer',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'product_image_max_width',
			selector:  '%%order_class%% .dswcp-image-container',
			cssProperty: 'max-width',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'remove_icon_size',
			selector: '%%order_class%% .dswcp-remove',
			cssProperty: 'font-size',
			responsive: true,
			important: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'remove_color',
			selector: '%%order_class%% .dswcp-remove',
			cssProperty: 'color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'remove_bg',
			selector: '%%order_class%% .dswcp-remove',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'empty_message_icon_size',
			selector: '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
			cssProperty: 'font-size',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'empty_message_icon_color',
			selector: '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
			cssProperty: 'color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'empty_message_icon_bg',
			selector: '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'empty_message_bg',
			selector: '%%order_class%% .dswcp-cart-empty',
			cssProperty: 'background-color',
			responsive: false
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'close_btn_icon_size',
			selector: '%%order_class%% .dswcp-side-cart .dswcp-close,%%order_class%% .dswcp-dropdown-cart .dswcp-close',
			cssProperty: 'font-size',
			responsive: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'close_btn_icon_color',
			selector: '%%order_class%% .dswcp-close',
			cssProperty: 'color',
			responsive: false,
			hover: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'close_btn_icon_bg',
			selector: '%%order_class%% .dswcp-close',
			cssProperty: 'background-color',
			responsive: false,
			hover: true
		}));

		additionalCss_.push(generateStyles({
			attrs: props,
			name: 'close_btn_bg',
			selector: '%%order_class%% .dswcp-close',
			cssProperty: 'background-color',
			responsive: false,
			hover: true
		}));


		// Paddings and Margins
		for (let elementId in DSWCP_WooMiniCart.marginPaddingElements) {
			additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_padding', DSWCP_WooMiniCart.marginPaddingElements[elementId]));
			additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_margin', DSWCP_WooMiniCart.marginPaddingElements[elementId], 'margin'));
		}

		return additionalCss_;

	}
	
	componentDidMount() {
		window.ags_wc_filters_parentClassPolyfill(
			window.jQuery('.' + this.props.moduleInfo.orderClassName),
			['.et_pb_column'],
			'ags-woo-mini-cart-ancestor',
			'zIndex',
			'3',
			'z-index:3'
		);
	}

	componentWillUnmount() {
		var colClass = window.jQuery('.' + this.props.moduleInfo.orderClassName).closest('.et_pb_column').attr('class');
		if (colClass.substring(0, 10) == 'et-module-') {
			window.jQuery('#dswcp-pcp-' + colClass.substring(0, colClass.indexOf(' '))).remove();
		}
	}
	
	render() {

		return (
			<>
				<a href="#"  className="dswcp-cart-link" title={this.props.label}>

					{(this.props.show_quantity_label === 'on' && this.props.quantity_label_position === 'before') && <span className="dswcp-count-label">{this.props.count_title_plural.replaceAll(/%d/g, 2)} </span>}

					{(this.props.show_amount === 'on' && this.props.amount_position === 'before') && <span className="dswcp-amount" dangerouslySetInnerHTML={{__html: window.DiviWoocommercePagesBuilderData.mini_cart.placeholderTotal}}></span>}


					<span className="dswcp-cart-icon-wrapper">
						<span className={'dswcp-mini-cart-icon dswcp-cart-icon icon-cart_icon_' + parseInt(this.props.icon)}></span>
						<span className="dswcp-label">{this.props.label}</span>
						{this.props.show_count === 'on' && <span className="dswcp-count" title={this.props.count_title_plural.replaceAll(/%d/g, 2)}>2</span>}
					</span>


					{(this.props.show_quantity_label === 'on' && this.props.quantity_label_position === 'after') && <span className="dswcp-count-label">{this.props.count_title_plural.replaceAll(/%d/g, 2)} </span>}

					{(this.props.show_amount === 'on' && this.props.amount_position === 'after') && <span className="dswcp-amount" dangerouslySetInnerHTML={{__html: window.DiviWoocommercePagesBuilderData.mini_cart.placeholderTotal}}></span>}
				</a>
				{
					(this.props._preview === 'sidecart' || this.props._preview === 'sidecart_empty') &&
						window.ReactDOM.createPortal(<DSWCP_WooMiniCart_SideCart parentModuleClassName={this.props.moduleInfo.orderClassName} {...this.props} />, document.body)
				}
				{
					(this.props._preview === 'dropdowncart' || this.props._preview === 'dropdowncart_empty') &&
						<DSWCP_WooMiniCart_DropdownCart {...this.props} />
				}
			</>
		);
  	}

}

export default DSWCP_WooMiniCart;
