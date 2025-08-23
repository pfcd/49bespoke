// External Dependencies
import React, {Component} from "react";
import './style.scss';
import {generateStyles} from "../../../module_dependencies/styles";
import {apply_responsive} from "../../../module_dependencies/ags-responsive";

class DSWCP_WooLoginForm extends Component {
    static slug = "ags_woo_login_form";
    static main_css_element = '%%order_class%%';

    constructor(props) {
        super(props);
    }

    static css(props) {

        const additionalCss = [];

        if (props.input_placeholder_color) {
            additionalCss.push(generateStyles({
                attrs: props,
                selector: '%%order_class%% input[type="email"]::placeholder,%%order_class%% input[type="password"]::placeholder, %%order_class%% input[type="text"]::placeholder',
                cssProperty: 'color',
                name: 'input_placeholder_color',
                responsive: false,
            }));
        }

        if ('on' === props.checkbox_style_enable) {

            additionalCss.push([
                {
                    selector: '%%order_class%% form label.woocommerce-form__label-for-checkbox',
                    declaration: `display : flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;position: relative;`
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form label.woocommerce-form__label-for-checkbox span:before',
                    declaration: `content : "";  position : absolute; top : 50%; left : 0; -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;`
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form label.woocommerce-form__label-for-checkbox input[type=checkbox]',
                    declaration: `padding : 0; margin : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;`
                }
            ]);
            additionalCss.push([
                {
                    selector: '%%order_class%% form label.woocommerce-form__label-for-checkbox input:checked + span:before',
                    declaration: `content : "\\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center;`
                }
            ]);

            additionalCss.push(generateStyles({
                attrs: props,
                selector: '%%order_class%% label.woocommerce-form__label-for-checkbox span:before',
                cssProperty: 'background-color',
                name: 'checkbox_background_color',
                responsive: false,
            }));


            additionalCss.push(generateStyles({
                attrs: props,
                selector: '%%order_class%% label.woocommerce-form__label-for-checkbox input:checked + span:before',
                cssProperty: 'color',
                name: 'checkbox_checked_color',
                responsive: false,
            }));

            additionalCss.push(generateStyles({
                attrs: props,
                selector: '%%order_class%% label.woocommerce-form__label-for-checkbox input:checked + span:before',
                cssProperty: 'background-color',
                name: 'checkbox_checked_background_color',
                responsive: false,
            }));

        }

        // Responsive CSS
        let additionalCss_ = additionalCss;

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'remember_padding', '%%order_class%% .woocommerce-form-login__rememberme', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'remember_margin', '%%order_class%% .woocommerce-form-login__rememberme', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_padding', '%%order_class%% .ags_login_register_title', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_margin', '%%order_class%% .ags_login_register_title', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'label_padding', '%%order_class%% form label', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'label_margin', '%%order_class%% form label', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'lost_password_padding', '%%order_class%% .lost_password', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'lost_password_margin', '%%order_class%% .lost_password', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'error_padding', '%%order_class%% p.ags_woo_login_form_error', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'error_margin', '%%order_class%% p.ags_woo_login_form_error', 'margin'));

        return additionalCss_;

    }

    render() {
        return (
            <div dangerouslySetInnerHTML={{__html: this.props.__form}}></div>
        );
    }
}

export default DSWCP_WooLoginForm;
