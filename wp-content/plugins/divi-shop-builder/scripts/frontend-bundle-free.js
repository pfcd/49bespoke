/*! For licensing and copyright information applicable to the product that this file belongs to, please see ../license.txt. */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 362);
/******/ })
/************************************************************************/
/******/ ({

/***/ 172:
/*!**************************************!*\
  !*** ./node_modules/qs/lib/utils.js ***!
  \**************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var has = Object.prototype.hasOwnProperty;

var hexTable = function () {
  var array = [];

  for (var i = 0; i < 256; ++i) {
    array.push('%' + ((i < 16 ? '0' : '') + i.toString(16)).toUpperCase());
  }

  return array;
}();

var compactQueue = function compactQueue(queue) {
  var obj;

  while (queue.length) {
    var item = queue.pop();
    obj = item.obj[item.prop];

    if (Array.isArray(obj)) {
      var compacted = [];

      for (var j = 0; j < obj.length; ++j) {
        if (typeof obj[j] !== 'undefined') {
          compacted.push(obj[j]);
        }
      }

      item.obj[item.prop] = compacted;
    }
  }

  return obj;
};

var arrayToObject = function arrayToObject(source, options) {
  var obj = options && options.plainObjects ? Object.create(null) : {};

  for (var i = 0; i < source.length; ++i) {
    if (typeof source[i] !== 'undefined') {
      obj[i] = source[i];
    }
  }

  return obj;
};

var merge = function merge(target, source, options) {
  if (!source) {
    return target;
  }

  if (_typeof(source) !== 'object') {
    if (Array.isArray(target)) {
      target.push(source);
    } else if (target && _typeof(target) === 'object') {
      if (options && (options.plainObjects || options.allowPrototypes) || !has.call(Object.prototype, source)) {
        target[source] = true;
      }
    } else {
      return [target, source];
    }

    return target;
  }

  if (!target || _typeof(target) !== 'object') {
    return [target].concat(source);
  }

  var mergeTarget = target;

  if (Array.isArray(target) && !Array.isArray(source)) {
    mergeTarget = arrayToObject(target, options);
  }

  if (Array.isArray(target) && Array.isArray(source)) {
    source.forEach(function (item, i) {
      if (has.call(target, i)) {
        var targetItem = target[i];

        if (targetItem && _typeof(targetItem) === 'object' && item && _typeof(item) === 'object') {
          target[i] = merge(targetItem, item, options);
        } else {
          target.push(item);
        }
      } else {
        target[i] = item;
      }
    });
    return target;
  }

  return Object.keys(source).reduce(function (acc, key) {
    var value = source[key];

    if (has.call(acc, key)) {
      acc[key] = merge(acc[key], value, options);
    } else {
      acc[key] = value;
    }

    return acc;
  }, mergeTarget);
};

var assign = function assignSingleSource(target, source) {
  return Object.keys(source).reduce(function (acc, key) {
    acc[key] = source[key];
    return acc;
  }, target);
};

var decode = function decode(str) {
  try {
    return decodeURIComponent(str.replace(/\+/g, ' '));
  } catch (e) {
    return str;
  }
};

var encode = function encode(str) {
  // This code was originally written by Brian White (mscdex) for the io.js core querystring library.
  // It has been adapted here for stricter adherence to RFC 3986
  if (str.length === 0) {
    return str;
  }

  var string = typeof str === 'string' ? str : String(str);
  var out = '';

  for (var i = 0; i < string.length; ++i) {
    var c = string.charCodeAt(i);

    if (c === 0x2D // -
    || c === 0x2E // .
    || c === 0x5F // _
    || c === 0x7E // ~
    || c >= 0x30 && c <= 0x39 // 0-9
    || c >= 0x41 && c <= 0x5A // a-z
    || c >= 0x61 && c <= 0x7A // A-Z
    ) {
        out += string.charAt(i);
        continue;
      }

    if (c < 0x80) {
      out = out + hexTable[c];
      continue;
    }

    if (c < 0x800) {
      out = out + (hexTable[0xC0 | c >> 6] + hexTable[0x80 | c & 0x3F]);
      continue;
    }

    if (c < 0xD800 || c >= 0xE000) {
      out = out + (hexTable[0xE0 | c >> 12] + hexTable[0x80 | c >> 6 & 0x3F] + hexTable[0x80 | c & 0x3F]);
      continue;
    }

    i += 1;
    c = 0x10000 + ((c & 0x3FF) << 10 | string.charCodeAt(i) & 0x3FF);
    /* eslint operator-linebreak: [2, "before"] */

    out += hexTable[0xF0 | c >> 18] + hexTable[0x80 | c >> 12 & 0x3F] + hexTable[0x80 | c >> 6 & 0x3F] + hexTable[0x80 | c & 0x3F];
  }

  return out;
};

var compact = function compact(value) {
  var queue = [{
    obj: {
      o: value
    },
    prop: 'o'
  }];
  var refs = [];

  for (var i = 0; i < queue.length; ++i) {
    var item = queue[i];
    var obj = item.obj[item.prop];
    var keys = Object.keys(obj);

    for (var j = 0; j < keys.length; ++j) {
      var key = keys[j];
      var val = obj[key];

      if (_typeof(val) === 'object' && val !== null && refs.indexOf(val) === -1) {
        queue.push({
          obj: obj,
          prop: key
        });
        refs.push(val);
      }
    }
  }

  return compactQueue(queue);
};

var isRegExp = function isRegExp(obj) {
  return Object.prototype.toString.call(obj) === '[object RegExp]';
};

var isBuffer = function isBuffer(obj) {
  if (obj === null || typeof obj === 'undefined') {
    return false;
  }

  return !!(obj.constructor && obj.constructor.isBuffer && obj.constructor.isBuffer(obj));
};

module.exports = {
  arrayToObject: arrayToObject,
  assign: assign,
  compact: compact,
  decode: decode,
  encode: encode,
  isBuffer: isBuffer,
  isRegExp: isRegExp,
  merge: merge
};

/***/ }),

/***/ 173:
/*!****************************************!*\
  !*** ./node_modules/qs/lib/formats.js ***!
  \****************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var replace = String.prototype.replace;
var percentTwenties = /%20/g;
module.exports = {
  'default': 'RFC3986',
  formatters: {
    RFC1738: function RFC1738(value) {
      return replace.call(value, percentTwenties, '+');
    },
    RFC3986: function RFC3986(value) {
      return String(value);
    }
  },
  RFC1738: 'RFC1738',
  RFC3986: 'RFC3986'
};

/***/ }),

/***/ 362:
/*!***********************************!*\
  !*** multi ./scripts/frontend.js ***!
  \***********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /usr/src/app/scripts/frontend.js */363);


/***/ }),

/***/ 363:
/*!*****************************!*\
  !*** ./scripts/frontend.js ***!
  \*****************************/
/*! no exports provided */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_qs__ = __webpack_require__(/*! qs */ 364);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_qs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_qs__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_js_cookie__ = __webpack_require__(/*! js-cookie */ 367);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_js_cookie___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_js_cookie__);
/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/
// This script is loaded both on the frontend page and in the Visual Builder.


jQuery(function ($) {
  $(document.body).on('change', 'li.product .qty', function () {
    var addToCartBtn = $(this).parents('.product').find('.add_to_cart_button');
    var qty = parseFloat($(this).val());

    if (!qty || qty < parseFloat($(this).attr('min'))) {
      $(this).val($(this).attr('min')).change();
      return;
    }

    if (addToCartBtn.length) {
      addToCartBtn.attr('data-quantity', parseFloat($(this).val()));
    }
  }).on('updated_wc_div', function () {
    $('.ags_woo_cart_list').each(function () {
      var forms = $(this).find('.woocommerce-cart-form');

      if (forms.length > 1) {
        $(forms[1]).remove();
      }
    });
  }); // submodule-builder\scripts\frontend\scripts.js

  $('.ags_woo_shop_plus').each(function () {
    var $this_el = $(this);
    var icon = $this_el.data('icon') || '';
    var icon_tablet = $this_el.data('icon-tablet') || '';
    var icon_phone = $this_el.data('icon-phone') || '';
    var icon_sticky = $this_el.data('icon-sticky') || '';
    var $overlay = $this_el.find('.et_overlay'); // Set data icon and inline icon class.

    if (icon !== '') {
      $overlay.attr('data-icon', icon).addClass('et_pb_inline_icon');
    }

    if (icon_tablet !== '') {
      $overlay.attr('data-icon-tablet', icon_tablet).addClass('et_pb_inline_icon_tablet');
    }

    if (icon_phone !== '') {
      $overlay.attr('data-icon-phone', icon_phone).addClass('et_pb_inline_icon_phone');
    }

    if (icon_sticky !== '') {
      $overlay.attr('data-icon-sticky', icon_sticky).addClass('et_pb_inline_icon_sticky');
    }
    /*if ($this_el.hasClass('et_pb_shop')) {
      const $shopItems = $this_el.find('li.product');
      const shop_index = $this_el.attr('data-shortcode_index');
      const itemClass  = `et_pb_shop_item_${shop_index}`;
       if ($shopItems.length > 0) {
        $shopItems.each((idx, $item) => {
          $($item).addClass(`${itemClass}_${idx}`);
        });
      }
    }*/

  });

  if ($('.ags_woo_notices').length && $('.ags_woo_checkout_coupon').length) {
    $(document.body).on('applied_coupon_in_checkout', function () {
      var notices = $('.ags_woo_notices');
      notices.find('.woocommerce-notices-wrapper').html('');
      $('.ags_woo_checkout_coupon').find('.woocommerce-error, .woocommerce-info, .woocommerce-message').each(function () {
        if ($(this).parents('.woocommerce-form-coupon-toggle').length) {
          return;
        }

        $(this).appendTo(notices.find('.woocommerce-notices-wrapper'));
      });
    });
  }

  if ($('form .ags_woo_checkout_billing_info').length) {
    $(document.body).on('updated_checkout checkout_error', function () {
      var notices = $('.ags_woo_notices');

      if (notices.length) {
        notices.find('.woocommerce-notices-wrapper').html('');
        notices.append($('.woocommerce-NoticeGroup-checkout'));
      } else {
        $('.woocommerce-NoticeGroup-checkout').prependTo($('form.checkout').find('.et_pb_row').first());
      }
    });
  }

  $('.ags_woo_shop_plus').on('click', 'a.page-numbers', function () {
    var itemName = 'ags_woo_shop_plus_' + et_pb_custom.page_id;
    var value = $(this).parents('.ags_woo_shop_plus').data('shortcode_index');
    localStorage.setItem(itemName, value);
  }).on('click', '.ags_woo_shop_plus_multiview button', function () {
    var view = $(this).hasClass('grid-view') ? 'grid' : 'list';
    var index = $(this).parents('.ags_woo_shop_plus').data('shortcode_index');
    var item_name = 'ags_woo_shop_plus_' + et_pb_custom.page_id + '_' + index;
    __WEBPACK_IMPORTED_MODULE_1_js_cookie___default.a.set(item_name, view, {
      expires: 7
    }); //save for 7 days
  });

  if ($('.ags_woo_shop_plus').length) {
    var queries = __WEBPACK_IMPORTED_MODULE_0_qs___default.a.parse(window.location.search, {
      ignoreQueryPrefix: true,
      plainObjects: true,
      parseArrays: false
    });
    var itemName = 'ags_woo_shop_plus_' + et_pb_custom.page_id;
    var value = localStorage.getItem(itemName);

    if (value !== '' && queries['dsb-product-page'] && queries['dsb-product-page'][value]) {
      et_pb_smooth_scroll($('.ags_woo_shop_plus_' + value));
    }

    localStorage.removeItem(itemName);
  }

  if ($('.ags_woo_checkout_order_review').length && $('.ags_woo_checkout_order_review').hasClass('et_pb_sticky_module')) {
    setInterval(function () {
      $('.ags_woo_checkout_order_review:not(.et_pb_sticky_placeholder) .payment_box:visible').each(function () {
        $(this).closest('.wc_payment_methods').find('.wc_payment_method').not($(this).parent()).removeClass('active');
        $(this).parent().addClass('active');
        var radio = $(this).parent().find('.input-radio');

        if (!radio.prop('checked')) {
          radio.prop('checked', true).change();
        }
      });
    }, 100);
  }

  $(document.body).on('wc_cart_button_updated', function (e, button) {
    var addedToCartBtn = button.next('.added_to_cart');
    var parentEl = button.closest('.ags_woo_shop_plus');

    if (addedToCartBtn.length && parentEl.length) {
      addedToCartBtn.attr('data-icon', button.data('view_cart_icon'));
    }
  });
  $(document.body).on('click', '.ags_woo_shop_plus_multiview button', function () {
    var $this = $(this);

    if ($this.hasClass('active')) {
      return;
    }

    var views = $this.closest('.ags_woo_shop_plus').find('.ags-divi-wc-layout-grid, .ags-divi-wc-layout-list');
    $this.siblings().removeClass('active');
    $this.addClass('active');
    var newView = $this.hasClass('grid-view') ? 'grid' : 'list';
    views.fadeOut(200);
    views.filter('.ags-divi-wc-layout-' + newView).fadeIn(200);
  });
});

/***/ }),

/***/ 364:
/*!**************************************!*\
  !*** ./node_modules/qs/lib/index.js ***!
  \**************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var stringify = __webpack_require__(/*! ./stringify */ 365);

var parse = __webpack_require__(/*! ./parse */ 366);

var formats = __webpack_require__(/*! ./formats */ 173);

module.exports = {
  formats: formats,
  parse: parse,
  stringify: stringify
};

/***/ }),

/***/ 365:
/*!******************************************!*\
  !*** ./node_modules/qs/lib/stringify.js ***!
  \******************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var utils = __webpack_require__(/*! ./utils */ 172);

var formats = __webpack_require__(/*! ./formats */ 173);

var arrayPrefixGenerators = {
  brackets: function brackets(prefix) {
    return prefix + '[]';
  },
  indices: function indices(prefix, key) {
    return prefix + '[' + key + ']';
  },
  repeat: function repeat(prefix) {
    return prefix;
  }
};
var isArray = Array.isArray;
var push = Array.prototype.push;

var pushToArray = function pushToArray(arr, valueOrArray) {
  push.apply(arr, isArray(valueOrArray) ? valueOrArray : [valueOrArray]);
};

var toISO = Date.prototype.toISOString;
var defaults = {
  delimiter: '&',
  encode: true,
  encoder: utils.encode,
  encodeValuesOnly: false,
  serializeDate: function serializeDate(date) {
    return toISO.call(date);
  },
  skipNulls: false,
  strictNullHandling: false
};

var stringify = function stringify(object, prefix, generateArrayPrefix, strictNullHandling, skipNulls, encoder, filter, sort, allowDots, serializeDate, formatter, encodeValuesOnly) {
  var obj = object;

  if (typeof filter === 'function') {
    obj = filter(prefix, obj);
  } else if (obj instanceof Date) {
    obj = serializeDate(obj);
  }

  if (obj === null) {
    if (strictNullHandling) {
      return encoder && !encodeValuesOnly ? encoder(prefix, defaults.encoder) : prefix;
    }

    obj = '';
  }

  if (typeof obj === 'string' || typeof obj === 'number' || typeof obj === 'boolean' || utils.isBuffer(obj)) {
    if (encoder) {
      var keyValue = encodeValuesOnly ? prefix : encoder(prefix, defaults.encoder);
      return [formatter(keyValue) + '=' + formatter(encoder(obj, defaults.encoder))];
    }

    return [formatter(prefix) + '=' + formatter(String(obj))];
  }

  var values = [];

  if (typeof obj === 'undefined') {
    return values;
  }

  var objKeys;

  if (isArray(filter)) {
    objKeys = filter;
  } else {
    var keys = Object.keys(obj);
    objKeys = sort ? keys.sort(sort) : keys;
  }

  for (var i = 0; i < objKeys.length; ++i) {
    var key = objKeys[i];

    if (skipNulls && obj[key] === null) {
      continue;
    }

    if (isArray(obj)) {
      pushToArray(values, stringify(obj[key], generateArrayPrefix(prefix, key), generateArrayPrefix, strictNullHandling, skipNulls, encoder, filter, sort, allowDots, serializeDate, formatter, encodeValuesOnly));
    } else {
      pushToArray(values, stringify(obj[key], prefix + (allowDots ? '.' + key : '[' + key + ']'), generateArrayPrefix, strictNullHandling, skipNulls, encoder, filter, sort, allowDots, serializeDate, formatter, encodeValuesOnly));
    }
  }

  return values;
};

module.exports = function (object, opts) {
  var obj = object;
  var options = opts ? utils.assign({}, opts) : {};

  if (options.encoder !== null && typeof options.encoder !== 'undefined' && typeof options.encoder !== 'function') {
    throw new TypeError('Encoder has to be a function.');
  }

  var delimiter = typeof options.delimiter === 'undefined' ? defaults.delimiter : options.delimiter;
  var strictNullHandling = typeof options.strictNullHandling === 'boolean' ? options.strictNullHandling : defaults.strictNullHandling;
  var skipNulls = typeof options.skipNulls === 'boolean' ? options.skipNulls : defaults.skipNulls;
  var encode = typeof options.encode === 'boolean' ? options.encode : defaults.encode;
  var encoder = typeof options.encoder === 'function' ? options.encoder : defaults.encoder;
  var sort = typeof options.sort === 'function' ? options.sort : null;
  var allowDots = typeof options.allowDots === 'undefined' ? false : options.allowDots;
  var serializeDate = typeof options.serializeDate === 'function' ? options.serializeDate : defaults.serializeDate;
  var encodeValuesOnly = typeof options.encodeValuesOnly === 'boolean' ? options.encodeValuesOnly : defaults.encodeValuesOnly;

  if (typeof options.format === 'undefined') {
    options.format = formats['default'];
  } else if (!Object.prototype.hasOwnProperty.call(formats.formatters, options.format)) {
    throw new TypeError('Unknown format option provided.');
  }

  var formatter = formats.formatters[options.format];
  var objKeys;
  var filter;

  if (typeof options.filter === 'function') {
    filter = options.filter;
    obj = filter('', obj);
  } else if (isArray(options.filter)) {
    filter = options.filter;
    objKeys = filter;
  }

  var keys = [];

  if (_typeof(obj) !== 'object' || obj === null) {
    return '';
  }

  var arrayFormat;

  if (options.arrayFormat in arrayPrefixGenerators) {
    arrayFormat = options.arrayFormat;
  } else if ('indices' in options) {
    arrayFormat = options.indices ? 'indices' : 'repeat';
  } else {
    arrayFormat = 'indices';
  }

  var generateArrayPrefix = arrayPrefixGenerators[arrayFormat];

  if (!objKeys) {
    objKeys = Object.keys(obj);
  }

  if (sort) {
    objKeys.sort(sort);
  }

  for (var i = 0; i < objKeys.length; ++i) {
    var key = objKeys[i];

    if (skipNulls && obj[key] === null) {
      continue;
    }

    pushToArray(keys, stringify(obj[key], key, generateArrayPrefix, strictNullHandling, skipNulls, encode ? encoder : null, filter, sort, allowDots, serializeDate, formatter, encodeValuesOnly));
  }

  var joined = keys.join(delimiter);
  var prefix = options.addQueryPrefix === true ? '?' : '';
  return joined.length > 0 ? prefix + joined : '';
};

/***/ }),

/***/ 366:
/*!**************************************!*\
  !*** ./node_modules/qs/lib/parse.js ***!
  \**************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./utils */ 172);

var has = Object.prototype.hasOwnProperty;
var defaults = {
  allowDots: false,
  allowPrototypes: false,
  arrayLimit: 20,
  decoder: utils.decode,
  delimiter: '&',
  depth: 5,
  parameterLimit: 1000,
  plainObjects: false,
  strictNullHandling: false
};

var parseValues = function parseQueryStringValues(str, options) {
  var obj = {};
  var cleanStr = options.ignoreQueryPrefix ? str.replace(/^\?/, '') : str;
  var limit = options.parameterLimit === Infinity ? undefined : options.parameterLimit;
  var parts = cleanStr.split(options.delimiter, limit);

  for (var i = 0; i < parts.length; ++i) {
    var part = parts[i];
    var bracketEqualsPos = part.indexOf(']=');
    var pos = bracketEqualsPos === -1 ? part.indexOf('=') : bracketEqualsPos + 1;
    var key, val;

    if (pos === -1) {
      key = options.decoder(part, defaults.decoder);
      val = options.strictNullHandling ? null : '';
    } else {
      key = options.decoder(part.slice(0, pos), defaults.decoder);
      val = options.decoder(part.slice(pos + 1), defaults.decoder);
    }

    if (has.call(obj, key)) {
      obj[key] = [].concat(obj[key]).concat(val);
    } else {
      obj[key] = val;
    }
  }

  return obj;
};

var parseObject = function parseObject(chain, val, options) {
  var leaf = val;

  for (var i = chain.length - 1; i >= 0; --i) {
    var obj;
    var root = chain[i];

    if (root === '[]' && options.parseArrays) {
      obj = [].concat(leaf);
    } else {
      obj = options.plainObjects ? Object.create(null) : {};
      var cleanRoot = root.charAt(0) === '[' && root.charAt(root.length - 1) === ']' ? root.slice(1, -1) : root;
      var index = parseInt(cleanRoot, 10);

      if (!options.parseArrays && cleanRoot === '') {
        obj = {
          0: leaf
        };
      } else if (!isNaN(index) && root !== cleanRoot && String(index) === cleanRoot && index >= 0 && options.parseArrays && index <= options.arrayLimit) {
        obj = [];
        obj[index] = leaf;
      } else if (cleanRoot !== '__proto__') {
        obj[cleanRoot] = leaf;
      }
    }

    leaf = obj;
  }

  return leaf;
};

var parseKeys = function parseQueryStringKeys(givenKey, val, options) {
  if (!givenKey) {
    return;
  } // Transform dot notation to bracket notation


  var key = options.allowDots ? givenKey.replace(/\.([^.[]+)/g, '[$1]') : givenKey; // The regex chunks

  var brackets = /(\[[^[\]]*])/;
  var child = /(\[[^[\]]*])/g; // Get the parent

  var segment = brackets.exec(key);
  var parent = segment ? key.slice(0, segment.index) : key; // Stash the parent if it exists

  var keys = [];

  if (parent) {
    // If we aren't using plain objects, optionally prefix keys
    // that would overwrite object prototype properties
    if (!options.plainObjects && has.call(Object.prototype, parent)) {
      if (!options.allowPrototypes) {
        return;
      }
    }

    keys.push(parent);
  } // Loop through children appending to the array until we hit depth


  var i = 0;

  while ((segment = child.exec(key)) !== null && i < options.depth) {
    i += 1;

    if (!options.plainObjects && has.call(Object.prototype, segment[1].slice(1, -1))) {
      if (!options.allowPrototypes) {
        return;
      }
    }

    keys.push(segment[1]);
  } // If there's a remainder, just add whatever is left


  if (segment) {
    keys.push('[' + key.slice(segment.index) + ']');
  }

  return parseObject(keys, val, options);
};

module.exports = function (str, opts) {
  var options = opts ? utils.assign({}, opts) : {};

  if (options.decoder !== null && options.decoder !== undefined && typeof options.decoder !== 'function') {
    throw new TypeError('Decoder has to be a function.');
  }

  options.ignoreQueryPrefix = options.ignoreQueryPrefix === true;
  options.delimiter = typeof options.delimiter === 'string' || utils.isRegExp(options.delimiter) ? options.delimiter : defaults.delimiter;
  options.depth = typeof options.depth === 'number' ? options.depth : defaults.depth;
  options.arrayLimit = typeof options.arrayLimit === 'number' ? options.arrayLimit : defaults.arrayLimit;
  options.parseArrays = options.parseArrays !== false;
  options.decoder = typeof options.decoder === 'function' ? options.decoder : defaults.decoder;
  options.allowDots = typeof options.allowDots === 'boolean' ? options.allowDots : defaults.allowDots;
  options.plainObjects = typeof options.plainObjects === 'boolean' ? options.plainObjects : defaults.plainObjects;
  options.allowPrototypes = typeof options.allowPrototypes === 'boolean' ? options.allowPrototypes : defaults.allowPrototypes;
  options.parameterLimit = typeof options.parameterLimit === 'number' ? options.parameterLimit : defaults.parameterLimit;
  options.strictNullHandling = typeof options.strictNullHandling === 'boolean' ? options.strictNullHandling : defaults.strictNullHandling;

  if (str === '' || str === null || typeof str === 'undefined') {
    return options.plainObjects ? Object.create(null) : {};
  }

  var tempObj = typeof str === 'string' ? parseValues(str, options) : str;
  var obj = options.plainObjects ? Object.create(null) : {}; // Iterate over the keys and setup the new object

  var keys = Object.keys(tempObj);

  for (var i = 0; i < keys.length; ++i) {
    var key = keys[i];
    var newObj = parseKeys(key, tempObj[key], options);
    obj = utils.merge(obj, newObj, options);
  }

  return utils.compact(obj);
};

/***/ }),

/***/ 367:
/*!*************************************************!*\
  !*** ./node_modules/js-cookie/src/js.cookie.js ***!
  \*************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * JavaScript Cookie v2.2.1
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;

(function (factory) {
  var registeredInModuleLoader;

  if (true) {
    !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    registeredInModuleLoader = true;
  }

  if (( false ? "undefined" : _typeof(exports)) === 'object') {
    module.exports = factory();
    registeredInModuleLoader = true;
  }

  if (!registeredInModuleLoader) {
    var OldCookies = window.Cookies;
    var api = window.Cookies = factory();

    api.noConflict = function () {
      window.Cookies = OldCookies;
      return api;
    };
  }
})(function () {
  function extend() {
    var i = 0;
    var result = {};

    for (; i < arguments.length; i++) {
      var attributes = arguments[i];

      for (var key in attributes) {
        result[key] = attributes[key];
      }
    }

    return result;
  }

  function decode(s) {
    return s.replace(/(%[0-9A-Z]{2})+/g, decodeURIComponent);
  }

  function init(converter) {
    function api() {}

    function set(key, value, attributes) {
      if (typeof document === 'undefined') {
        return;
      }

      attributes = extend({
        path: '/'
      }, api.defaults, attributes);

      if (typeof attributes.expires === 'number') {
        attributes.expires = new Date(new Date() * 1 + attributes.expires * 864e+5);
      } // We're using "expires" because "max-age" is not supported by IE


      attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

      try {
        var result = JSON.stringify(value);

        if (/^[\{\[]/.test(result)) {
          value = result;
        }
      } catch (e) {}

      value = converter.write ? converter.write(value, key) : encodeURIComponent(String(value)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
      key = encodeURIComponent(String(key)).replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent).replace(/[\(\)]/g, escape);
      var stringifiedAttributes = '';

      for (var attributeName in attributes) {
        if (!attributes[attributeName]) {
          continue;
        }

        stringifiedAttributes += '; ' + attributeName;

        if (attributes[attributeName] === true) {
          continue;
        } // Considers RFC 6265 section 5.2:
        // ...
        // 3.  If the remaining unparsed-attributes contains a %x3B (";")
        //     character:
        // Consume the characters of the unparsed-attributes up to,
        // not including, the first %x3B (";") character.
        // ...


        stringifiedAttributes += '=' + attributes[attributeName].split(';')[0];
      }

      return document.cookie = key + '=' + value + stringifiedAttributes;
    }

    function get(key, json) {
      if (typeof document === 'undefined') {
        return;
      }

      var jar = {}; // To prevent the for loop in the first place assign an empty array
      // in case there are no cookies at all.

      var cookies = document.cookie ? document.cookie.split('; ') : [];
      var i = 0;

      for (; i < cookies.length; i++) {
        var parts = cookies[i].split('=');
        var cookie = parts.slice(1).join('=');

        if (!json && cookie.charAt(0) === '"') {
          cookie = cookie.slice(1, -1);
        }

        try {
          var name = decode(parts[0]);
          cookie = (converter.read || converter)(cookie, name) || decode(cookie);

          if (json) {
            try {
              cookie = JSON.parse(cookie);
            } catch (e) {}
          }

          jar[name] = cookie;

          if (key === name) {
            break;
          }
        } catch (e) {}
      }

      return key ? jar[key] : jar;
    }

    api.set = set;

    api.get = function (key) {
      return get(key, false
      /* read as raw */
      );
    };

    api.getJSON = function (key) {
      return get(key, true
      /* read as json */
      );
    };

    api.remove = function (key, attributes) {
      set(key, '', extend(attributes, {
        expires: -1
      }));
    };

    api.defaults = {};
    api.withConverter = init;
    return api;
  }

  return init(function () {});
});

/***/ })

/******/ });