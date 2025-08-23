/*! @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JSX file) has been modified by Essa Mamdani, Jonathan Hall, and/or others.
This file (or the corresponding source JSX file) was last modified 2020-11-09
*/

import React, { Component } from "react";

class WoocommerceCarouselChild extends Component {
  static slug = "dswc_woocommerce_carousel_child";

  static css(props) {
    const additionalCss = [];


    return additionalCss;
  }

  render() {


    return (
        <div key={this.props.moduleInfo.order} className="dswc_woo_item">
           <h1>{this.props.item}</h1>
        </div>
    );
  }
}

export default WoocommerceCarouselChild;
