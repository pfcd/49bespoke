/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import $ from 'jquery';

import DSWCP_WooCartList from './modules/WooCartList/WooCartList';
import DSWCP_WooCartTotals from './modules/WooCartTotals/WooCartTotals';
import DSWCP_WooCheckoutCoupon from './modules/WooCheckoutCoupon/WooCheckoutCoupon';
import DSWCP_WooCheckoutBillingInfo from './modules/WooCheckoutBillingInfo/WooCheckoutBillingInfo';
import DSWCP_WooCheckoutShippingInfo from './modules/WooCheckoutShippingInfo/WooCheckoutShippingInfo';
import DSWCP_WooCheckoutOrderReview from './modules/WooCheckoutOrderReview/WooCheckoutOrderReview';
import DSWCP_WooThankYou from './modules/WooThankYou/WooThankYou';
import DSWCP_WooAccountUserImage from './modules/WooAccountUserImage/WooAccountUserImage';
import DSWCP_WooAccountUserName from './modules/WooAccountUserName/WooAccountUserName';
import DSWCP_WooAccountNav from './modules/WooAccountNav/WooAccountNav';
import DSWCP_WooAccountNavItem from './modules/WooAccountNavItem/WooAccountNavItem';
import DSWCP_WooAccountDashboard from './modules/WooAccountDashboard/WooAccountDashboard';
import DSWCP_WooAccountOrders from './modules/WooAccountOrders/WooAccountOrders';
import DSWCP_WooAccountViewOrder from './modules/WooAccountViewOrder/WooAccountViewOrder';
import DSWCP_WooAccountDownloads from './modules/WooAccountDownloads/WooAccountDownloads';
import DSWCP_WooAccountAddresses from './modules/WooAccountAddresses/WooAccountAddresses';
import DSWCP_WooAccountDetails from './modules/WooAccountDetails/WooAccountDetails';
import DSWCP_WooAccountContent from './modules/WooAccountContent/WooAccountContent';
import DSWCP_WooAccountContentItem from './modules/WooAccountContentItem/WooAccountContentItem';
import DSWCP_WooAccountLogin from './modules/WooAccountLogin/WooAccountLogin';
import DSWCP_WooProductsFilters from './modules/WooProductsFilters/WooProductsFilters';
import DSWCP_WooProductsFilters_child from './modules/WooProductsFilters-child/WooProductsFilters-child';
import DSWCP_WooMiniCart from './modules/WooMiniCart/WooMiniCart';
import DSWCP_WooMultiStepCheckout from './modules/WooMultiStepCheckout/WooMultiStepCheckout';
import DSWCP_WooMultiStepCheckout_child from './modules/WooMultiStepCheckout-child/WooMultiStepCheckout-child';
import DSWCP_WooLoginForm from './modules/WooLoginForm/WooLoginForm';
import DSWCP_WooRegisterForm from './modules/WooRegisterForm/WooRegisterForm';

class DSWCP_Modules_Pro {

	static init() {
		$(window).on('et_builder_api_ready', (event, API) => {
		  API.registerModules([
				DSWCP_WooCartList,
				DSWCP_WooCartTotals,
				DSWCP_WooCheckoutCoupon,
				DSWCP_WooCheckoutBillingInfo,
				DSWCP_WooCheckoutShippingInfo,
				DSWCP_WooCheckoutOrderReview,
				DSWCP_WooThankYou,
				DSWCP_WooAccountUserImage,
				DSWCP_WooAccountUserName,
				DSWCP_WooAccountNav,
				DSWCP_WooAccountNavItem,
				// DSWCP_WooAccountDashboard,
				// DSWCP_WooAccountOrders,
				// DSWCP_WooAccountViewOrder,
				// DSWCP_WooAccountDownloads,
				// DSWCP_WooAccountAddresses,
				// DSWCP_WooAccountDetails,
				DSWCP_WooAccountContent,
				DSWCP_WooAccountContentItem,
				DSWCP_WooAccountLogin,
				DSWCP_WooProductsFilters,
				DSWCP_WooProductsFilters_child,
				DSWCP_WooMiniCart,
				DSWCP_WooMultiStepCheckout,
				DSWCP_WooMultiStepCheckout_child,
				DSWCP_WooLoginForm,
				DSWCP_WooRegisterForm
			]);
		});
	}

}

DSWCP_Modules_Pro.init();

export default DSWCP_Modules_Pro;