// External Dependencies
import React, {Component} from 'react';
import parse from 'html-react-parser';

class DSWCP_WooAccountLogin extends Component {

    static slug = 'ags_woo_account_login';

    render() {
        return ( <div className="woocommerce-MyAccount-content" dangerouslySetInnerHTML={{__html: this.html()}}/> )
    }

    html() {
        return window.DiviWoocommercePagesBuilderData.account_contents.login_html ? window.DiviWoocommercePagesBuilderData.account_contents.login_html : '';
    }

}


export default DSWCP_WooAccountLogin;
