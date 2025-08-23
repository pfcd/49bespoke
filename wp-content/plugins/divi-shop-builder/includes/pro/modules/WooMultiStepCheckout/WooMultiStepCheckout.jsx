// External Dependencies
import React, {
    Component
} from 'react';
import {
    generateStyles
} from '../../../module_dependencies/styles';

import {apply_responsive} from "../../../module_dependencies/ags-responsive";
import './style.scss';

class DSWCP_WooMultiStepCheckout extends Component {

    static slug = 'ags_woo_multi_step_checkout';

    static marginPaddingElements = {
        tabs: '%%order_class%% .dswcp-checkout-steps > li',
        active_tab: '%%order_class%% .dswcp-checkout-steps >  li.dswcp-checkout-step-active',
        tab_link: '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps > li a',
        image: '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-image',
        icon: '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-icon',
        number: '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-number',
        step: '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-inner',
        tabs_container: '%%order_class%%  ul.dswcp-checkout-steps',
    };

    static css(props) {
        const additionalCss = [];

        // * ---- Layout ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'primary_color',
            selector: '%%order_class%%',
            cssProperty: '--ags_woo_multi_step_checkout-accent',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'secondary_color',
            selector: '%%order_class%%',
            cssProperty: '--ags_woo_multi_step_checkout-accent-secondary',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tabs_width',
            selector: '%%order_class%% .dswcp-checkout-steps > li',
            cssProperty: 'flex-basis',
            responsive: true,
            important: true
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tabs_grow',
            selector: '%%order_class%% .dswcp-checkout-steps > li',
            cssProperty: 'flex-grow',
            responsive: true,
            important: true
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tabs_gap',
            selector: '%%order_class%% .dswcp-checkout-steps',
            cssProperty: 'gap',
            responsive: true,
            important: true
        }));

        if (props.tabs_align !== 'default') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'tabs_align',
                selector: '%%order_class%% .dswcp-checkout-steps',
                cssProperty: 'justify-content',
                responsive: true,
                important: true
            }));
        }
        if (props.tabs_link_align !== 'default') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'tabs_link_align',
                selector: '%%order_class%% .dswcp-checkout-steps li a',
                cssProperty: 'justify-content',
                responsive: true,
                important: true
            }));
        }

        if (props.tabs_white_space !== 'off') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'tabs_white_space',
                selector: '%%order_class%% .dswcp-checkout-tab-text',
                cssProperty: 'white-space',
                responsive: true
            }));
        }

        if (props.line_width !== 'off' && (props.nav_type === 'layout-6' || props.nav_type === 'layout-7')) {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'line_width',
                selector: '%%order_class%% .dswcp-checkout-steps li::before',
                cssProperty: 'height',
                responsive: true,
                important: true
            }));
        }

        if (props.line_position && props.line_position !== '' && (props.nav_type === 'layout-6' || props.nav_type === 'layout-7')) {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'line_position',
                selector: '%%order_class%% .dswcp-checkout-steps li::before',
                cssProperty: 'top',
                responsive: true
            }));
        }

        if (props.line_color !== '') {

            const navTypeStyles = {
                'layout-1': { selector: '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps li a', cssProperty: 'border-color', important: false },
                'layout-2': { selector: '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps li a', cssProperty: 'border-color', important: false },
                'layout-3': { selector: '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps li a', cssProperty: 'border-color', important: false },
                'layout-4': { selector: '%%order_class%% .dswcp-checkout-steps.dswcp-checkout-steps-layout-4 li a', cssProperty: 'border-color', important: true },
                'layout-5': { selector: '%%order_class%% .dswcp-checkout-steps.dswcp-checkout-steps-layout-5 li:not(:last-child):after', cssProperty: 'color', important: false },
                'layout-6': { selector: '%%order_class%% .dswcp-checkout-steps li::before', cssProperty: 'background-color', important: true },
                'layout-7': { selector: '%%order_class%% .dswcp-checkout-steps li::before', cssProperty: 'background-color', important: true },
                'layout-8': { selector: '%%order_class%% .dswcp-checkout-steps li.dswcp-checkout-step-active:before,%%order_class%% .dswcp-checkout-steps li:hover:before', cssProperty: 'background-color', important: true },
                'layout-9': { selector: '%%order_class%% .dswcp-checkout-steps li.dswcp-checkout-step-active:before', cssProperty: 'background-color', important: true },
            };

            // Use the nav_type to get the corresponding style configuration
            const styleConfig = navTypeStyles[props.nav_type];

            if (styleConfig) {
                additionalCss.push(generateStyles({
                    attrs: props,
                    name: 'line_color',
                    selector: styleConfig.selector,
                    cssProperty: styleConfig.cssProperty,
                    responsive: false,
                    important: styleConfig.important
                }));
            }
        }

        // * ---- Tabs ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tab_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tab_link_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li a',
            cssProperty: 'background-color',
            responsive: false
        }));


        // * ---- Active Tabs ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'active_tab_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'active_tab_link_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li a',
            cssProperty: 'background-color',
            responsive: false
        }));


        // * ---- Image ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'image_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'image_max_width',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
            cssProperty: 'max-width',
            responsive: true
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'image_max_height',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
            cssProperty: 'max-height',
            responsive: true
        }));

        // * ---- Icon ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'icon_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'icon_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
            cssProperty: 'color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'icon_size',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
            cssProperty: 'font-size',
            responsive: true
        }));


        // * ---- Number ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'number_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-number',
            cssProperty: 'background-color',
            responsive: false
        }));


        // * ---- Step ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'step_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'active_step_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active .dswcp-checkout-tab-inner',
            cssProperty: 'background-color',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'hover_step_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps > li:hover .dswcp-checkout-tab-inner',
            cssProperty: 'background-color',
            responsive: false
        }));


        // * ---- Tabs Container ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tabs_container_bg_color',
            selector: '%%order_class%% .dswcp-checkout-steps',
            cssProperty: 'background-color',
            responsive: false
        }));

        // * ---- Buttons ---- */

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'buttons_align',
            selector: '%%order_class%%__buttons-container .dswcp-checkout-steps-buttons',
            cssProperty: 'justify-content',
            responsive: false,
            important: true
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'buttons_wrapper_max_width',
            selector: '%%order_class%%__buttons-container .dswcp-checkout-steps-buttons',
            cssProperty: 'max-width',
            responsive: false
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'buttons_wrapper_max_width',
            selector: '%%order_class%%__buttons-container .dswcp-checkout-steps-buttons',
            cssProperty: 'max-width',
            responsive: false
        }));


        // <----- Responsive CSS - apply_responsive -------> //

        let additionalCss_ = additionalCss;

        // Paddings and Margins
        for (let elementId in DSWCP_WooMultiStepCheckout.marginPaddingElements) {
            additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_padding', DSWCP_WooMultiStepCheckout.marginPaddingElements[elementId]));
            additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_margin', DSWCP_WooMultiStepCheckout.marginPaddingElements[elementId], 'margin'));
        }

        return additionalCss_;
    }

    render() {
        var stepNum = 0;

        return <>
            <ul className={'dswcp-checkout-steps dswcp-checkout-steps-' + this.props.nav_type + ' et_smooth_scroll_disabled'}>
                {this.props.content && this.props.content.map((child, childNum) => {
					var stepLabel = child.props.attrs.label ? child.props.attrs.label : window.wp.i18n.__('Step 1', 'divi-shop-builder');
                    if (child.props.attrs.tab_type === 'image' && child.props.attrs.image) {
                        var graphic =
                            <span
                                className="dswcp-checkout-tab-image">
										<img
                                            src={child.props.attrs.image}
                                            alt={stepLabel}/>
									</span>;
                    } else if (child.props.attrs.tab_type === 'icon' && child.props.attrs.icon) {
                        var iconData = window.ET_Builder.API.Utils.processIconFontData(child.props.attrs.icon);
                        var graphic =
                            <span
                                className={'dswcp-checkout-tab-icon et-pb-icon' + (iconData && iconData.iconFontFamily === 'FontAwesome' ? ' et-pb-fa-icon' : '')}>
									{window.ET_Builder.API.Utils.processFontIcon(child.props.attrs.icon)}
								</span>;
                    } else {
                        var graphic = null;
                    }

                    var number = child.props.attrs.enable_number === 'off'
                        ? null
                        :
                        <span
                            className="dswcp-checkout-tab-number">{typeof child.props.attrs.number_format === 'string' ? child.props.attrs.number_format.replaceAll(/%d/g, ++stepNum) : ++stepNum}</span>;

                    return <li className={childNum ? null : 'dswcp-checkout-step-active'}>
                        <a href="#">
                            {(this.props.nav_type === 'layout-6' || this.props.nav_type === 'layout-7')
                                ?
                                <span
                                    className="dswcp-checkout-tab-inner">{graphic}{number}</span>
                                : <>{graphic}{number}</>
                            }
                            <span
                                className="dswcp-checkout-tab-text">{stepLabel}</span>
                        </a>
                    </li>;
                })}
            </ul>

            <ul className="dswcp-checkout-errors"></ul>

            <div
                className="et_pb_section dswcp-checkout-section-placeholder">
                <div
                    className="dswcp-checkout-loader">
                    <div
                        className="et_pb_row">
                        <span>{this.props.loader_text}</span>
                    </div>
                </div>
                <div
                    className="dswcp-checkout-section-placeholder-inner">
                    <span>{window.wp.i18n.__('Checkout Content Here', 'divi-shop-builder')}</span>
                </div>
            </div>
			
			<div className={'dswcp-checkout-steps-buttons-container ' + this.props.moduleInfo.orderClassName + '__buttons-container'}>
				<div
					className="dswcp-checkout-steps-buttons et_pb_row">
					<button
						type="button"
						className="et_pb_button dswcp-button-back">{this.props.back_text}</button>
					<button
						type="button"
						className="et_pb_button dswcp-button-continue">{this.props.continue_text}</button>
				</div>
			</div>
        </>;
    }

}

export default DSWCP_WooMultiStepCheckout;
