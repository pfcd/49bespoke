/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';

class Warning extends Component {

  static slug = 'ags_wc_warning';
  pollInterval;
  
  constructor(props) {
	  super(props);
	  this.state = {
		  enabled: this.isEnabled()
	  }
  }
  
  isEnabled() {
	  if (this.props.fieldDefinition.toggleVarsAll) {
		  for ( var i = 0; i < this.props.fieldDefinition.toggleVarsAll.length; ++i ) {
			  if (!window[this.props.fieldDefinition.toggleVarsAll[i]]) {
				  return false;
			  }
		  }
		  return true;
	  }
	  if (this.props.fieldDefinition.toggleVarsAny) {
		  for ( var i = 0; i < this.props.fieldDefinition.toggleVarsAny.length; ++i ) {
			  if (window[this.props.fieldDefinition.toggleVarsAny[i]]) {
				  return true;
			  }
		  }
		  return false;
	  }
	  return this.props.fieldDefinition.toggleVar && window[this.props.fieldDefinition.toggleVar];
  }

  shouldComponentUpdate(newProps, newState) {
	  return this.state.enabled !== newState.enabled;
  }
  
  componentDidMount() {
	  if (this.pollInterval) {
		  clearInterval(this.pollInterval);
	  }
	  var _this = this;
	  this.pollInterval = setInterval( () => {
		  if (_this.isEnabled() !== _this.state.enabled) {
			  _this.setState({ enabled: _this.isEnabled() });
		  }
	  }, 2000 );
  }
  
  componentWillUnmount() {
	  if (this.pollInterval) {
		  clearInterval(this.pollInterval);
	  }
  }

  render() {
	if (!this.state.enabled) {
		return null;
	}
    return <div className={'ags-wc-module-warning' + (this.props.fieldDefinition.className ? ' ' + this.props.fieldDefinition.className : '')}>{this.props.fieldDefinition.warningText}</div>;
  }
}

export default Warning;
