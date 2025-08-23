import React, { Component } from 'react';
import $ from 'jquery';

class AjaxComponent extends Component {

    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            result: null,
            error: null,
            first:true,
        };
    }

    componentDidMount() {
        setTimeout(()=>this.setState({first: false}, () => this._reload(this.props, 'ajax')),250);
    }

    componentWillUnmount() {
        this._abortRunningAjaxCall();
    }

    componentDidUpdate(prevProps) {
        const newProps = this.props;
        const oldProps = prevProps;

        if (!this.props || !prevProps) {
            return;
        }
        if (!!this._shouldReload(oldProps, newProps)) {
            this._reload(newProps,this._shouldReload(oldProps, newProps));

        }
    }

    _shouldReload(oldProps, newProps) {
        throw new Error('You must implement the method _shouldReload(oldProps, newProps)');
    }

    _reloadData(props) {
        throw new Error('You must implement the method _reloadData(props)');
    }


    _reload(props, type = '') {

        const component = this;
        switch (type) {
            case "ajax":
                component.setState({isLoaded: false}, () => {
                    //Cancel running Ajax call if any
                    this._abortRunningAjaxCall();

                    //Make new Ajax call
                    this.ajaxCall = $.ajax({
                        url: window.dswc_woocommerce.ajaxurl,
                        type: 'POST',
                        data: this._reloadData(props),
                        success: function (response) {
                            if (response.success === false) {
                                component.setState({
                                    isLoaded: true,
                                    error: "Error: Failed to load",
                                });
                            } else {
                                console.log(response);
                                component.setState({
                                    isLoaded: true,
                                    result: response,
                                });
                            }
                        },
                        complete: function () {
                            component.ajaxCall = null;
                        }
                    });
                })
                break;
            case "rerender":
                component.setState({isLoaded: false}, () => {
                    component.setState({isLoaded: true});
                });
                break;
            case "default":
            default:
                break;
        }
    }

    _abortRunningAjaxCall() {
        if (this.ajaxCall !== undefined && this.ajaxCall !== null && this.ajaxCall.readyState !== 4) {
            this.ajaxCall.abort();
        }
    }

    _render() {
        throw new Error('You must implement the method _render()');
    }

    render() {
        if (this.state.error) {
            return (<div>{this.state.error.message}</div>);
        } else if (!this.state.isLoaded) {
            return (
                <div
                    className="dss_loading_indicator"
                    style={{
                        height: 100 + 'px',
                        minWidth: 100 + 'px'
                    }}
                >
                    <div className="et-fb-loader-wrapper">
                        <div className="et-fb-loader"/>
                    </div>
                </div>
            );
        } else {
            return this._render();
        }
    }
}

export default AjaxComponent;




