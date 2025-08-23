/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';
import get from 'lodash/get';

// Internal Dependencies
import './style.css';

class ChildOrder extends Component {

  static slug = 'ags_wc_child_order';
  
  pollInterval = null;
  
  maybeUpdateValue(props) {
	  
		let childField = get(props.fieldDefinition, 'childField', null);
		
		if (childField !== null) {
			
			let childModules = get(props, 'content', []);
			let value = '';
			
			for ( let i = 0; i < childModules.length; ++i ) {
				let childFieldValue = get(childModules[i].attrs, childField, '');
				if (childFieldValue.length) {	
					if (props.fieldDefinition.paramFields) {
						var params = {};
						for (var j = 0; j < props.fieldDefinition.paramFields.length; ++j) {
							if (childModules[i].attrs.hasOwnProperty(props.fieldDefinition.paramFields[j]) && childModules[i].attrs[ props.fieldDefinition.paramFields[j] ] !== null) {
								params[ props.fieldDefinition.paramFields[j] ] = childModules[i].attrs[ props.fieldDefinition.paramFields[j] ];
							}
						}
						
						if (Object.values(params).length) {
							childFieldValue += '{' + btoa(JSON.stringify(params)) + '}';
						}
					}
					value += (value.length ? ',' : '') + childFieldValue;
				}
			}
			
			if (value !== props.value) {
				props._onChange(props.name, value);
			}
			
		}
  }
  
  componentDidMount() {
	  let thisComponent = this;
	  this.pollInterval = setInterval(function() {
		  thisComponent.maybeUpdateValue(thisComponent.props);
	  }, 500);
	  
  }
  
  componentWillUnmount() {
	  if ( this.pollInterval ) {
		  clearInterval(this.pollInterval);
		  this.pollInterval = null;
	  }
  }

  render() {
    return '';
  }
}

export default ChildOrder;
