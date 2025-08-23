// External Dependencies
import React, {Component} from "react";
import {generateStyles} from '../../../module_dependencies/styles';
import {apply_responsive} from "../../../module_dependencies/ags-responsive";

class DSWCP_WooMultiStepCheckout_child extends Component {
    static slug = "ags_woo_multi_step_checkout_child";
    static main_css_element = '%%order_class%%';

    constructor(props) {
        super(props);
    }

    static css(props) {
        const additionalCss = [];
        return additionalCss;
    }

    render() {
		return null;
    }
}

export default DSWCP_WooMultiStepCheckout_child;
