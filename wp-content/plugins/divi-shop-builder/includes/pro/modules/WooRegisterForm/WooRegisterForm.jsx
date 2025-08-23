// External Dependencies
import React, {Component} from "react";
import './style.scss';
import {generateStyles} from "../../../module_dependencies/styles";
import {apply_responsive} from "../../../module_dependencies/ags-responsive";

class DSWCP_WooRegisterForm extends Component {
    static slug = "ags_woo_register_form";
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

        // Responsive CSS
        let additionalCss_ = additionalCss;

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'privacy_margin', '%%order_class%% .woocommerce-privacy-policy-text', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'privacy_padding', '%%order_class%% .woocommerce-privacy-policy-text', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_padding', '%%order_class%% .ags_login_register_title', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'title_margin', '%%order_class%% .ags_login_register_title', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'label_padding', '%%order_class%% form label', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'label_margin', '%%order_class%% form label', 'margin'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'error_padding', '%%order_class%% p.ags_woo_register_form_error', 'padding'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'error_margin', '%%order_class%% p.ags_woo_register_form_error', 'margin'));

        return additionalCss_;

    }

    render() {
        return (
            <div dangerouslySetInnerHTML={{__html: this.props.__form}}></div>
        );
    }
}

export default DSWCP_WooRegisterForm;
