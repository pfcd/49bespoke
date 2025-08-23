/*!@license
This file includes code from range-slider, with or without modifications
https://github.com/slawomir-zaziablo/range-slider
range-slider is licensed under the following license.
Unmodified source code can be found at ../../sources/range-slider/src/js/rSlider.js

MIT License

Copyright (c) 2017 Slawomir Zaziablo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

(function() {
	
jQuery(document).ready(function($) {
	var star = String.fromCharCode(57395);
	var starEmpty = String.fromCharCode(57393);
	
	var shopSerial = 0, productsCountSerial = {};

	window.ags_wc_filters_isInVisualBuilder = $(document.body).hasClass('et-fb');

	var $shopModule = $('.ags-wc-filters-target:visible:first');
	var applyFiltersTimeout = {};
	$(".ags-wc-filters-button-apply").click(function() {
		window.ags_wc_filters_applyFilters( $(this).closest('.ags_woo_products_filters') );
	});
	
	$(window).on('resize', function() {
		var $newShopModule = $('.ags-wc-filters-target:visible:first');
		if (( $shopModule.length || $newShopModule.length ) && !$shopModule.is($newShopModule)) {
			$shopModule = $newShopModule;
			onUrlChanged();
		}
		
		$('.ags-wc-filters-row .ags-wc-filters-sections').css('margin-left', null);
	});

	$(document.body).on('click', function(ev) {
		var $hideParent = $(ev.target).closest('.ags-wc-filters-hide-on-click');
		$('.ags-wc-filters-hide-on-click').not($hideParent).hide();
		
		if (!ev.isTrigger && !$(ev.target).closest('.ags-wc-filters-row .ags-wc-filters-section:not(ags-wc-filters-section-toggle-closed)').length) {
			$('.ags-wc-filters-row .ags-wc-filters-section').addClass('ags-wc-filters-section-toggle-closed');
		}
	});
	
	if (!window.ags_wc_filters_isInVisualBuilder) {
		$(document).on('click', '.ags-wc-filters-section-title.ags-wc-filters-section-toggle', function(ev) {
			var $section = $(this).parent().toggleClass('ags-wc-filters-section-toggle-closed');
			$(this).closest('.ags-wc-filters-row').find('.ags-wc-filters-section').not($section).addClass('ags-wc-filters-section-toggle-closed');
		});
	}
	
	window.ags_wc_filters_maybeToggleNoOptionsMessage = function($filter) {
		var $list = $filter.find('.ags-wc-filters-list:first');
		if ($list.length) {
			if ($list.children(':not(.ags-wc-filters-hidden)').length) {
				$filter.find('.ags-wc-filters-no-options').remove();
			} else if (!$filter.has('.ags-wc-filters-no-options').length) {
				var $filterTitle = $filter.find('h4').clone();
				$filterTitle.children().remove();
				
				$('<div>')
					.addClass('ags-wc-filters-no-options')
					.text(
						$filter.closest('div[data-no-options-text]').attr('data-no-options-text').replace('%s', $filterTitle.text())
					)
					.appendTo($filter.find('.ags-wc-filters-section-inner:first'));
			}
		}
	}
	
	if (window.ags_wc_filters_aliases) {
		ags_wc_filters_set_aliases(window.ags_wc_filters_aliases);
	}
	
	window.ags_wc_filters_parentClassPolyfill = function($modules, parentSelectors, className, cssProp, cssValue, cssString) {
		$modules.each(function() {
			for (var i = 0; i < parentSelectors.length; ++i) {
				var $parent = $(this).closest(parentSelectors[i]);
				if ($parent.length) {
					if (!window.getComputedStyle || window.getComputedStyle($parent[0])[cssProp] !== cssValue) {
						var parentClass = $parent.attr('class');
						if (parentClass.substring(0, 10) === 'et-module-') {
							var moduleClass = parentClass.substring(0, parentClass.indexOf(' '));
							if (moduleClass) {
								$('<style>').attr('id', 'dswcp-pcp-' + moduleClass).text('.' + moduleClass + '{' + cssString + '}').appendTo(document.head);
							}
						} else {
							$parent.addClass(className);
						}
					}
				}
			}
		});
	}
	
	ags_wc_filters_parentClassPolyfill(
		$('.ags_woo_mini_cart'),
		['.et_pb_column'],
		'ags-woo-mini-cart-ancestor',
		'zIndex',
		'3',
		'z-index:3'
	);
	
	window.ags_wc_filters_initFilters = function($filters) {

		var displayType = window.ags_wc_filters_getDisplayType($filters);
		var $filtersContainer = $filters.closest('.ags_woo_products_filters');
		var $applyButton = $filtersContainer.find(".ags-wc-filters-button-apply:first");

		var $filtersRow = $filtersContainer.closest('.et_pb_row')[0];

		if (window.ags_wc_filters_isInVisualBuilder) {
			$filtersRow.style.zIndex = "10";
		} else {
			$filtersRow.style.zIndex = "3";
		}

		switch (displayType) {
			case 'checkboxes_list':
			case 'radio_buttons':
			case 'colors':
			case 'images':
				$filters.find('.ags-wc-filters-list:first :checkbox, .ags-wc-filters-list:first :radio').change( function(ev) {
					if (!$applyButton.length && !ev.isTrigger) {
						window.ags_wc_filters_applyFilters($filtersContainer);
					}
				});
				break;

			case 'dropdown_single_select':
				/*-------------single select start---------------*/

				$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-active a").click(function() {
					$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options").toggle();
					return false;
				});

				$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a").click(function(ev) {
					var label = jQuery(this).attr('data-label');

					$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a").removeClass("ags-wc-filters-active");
					jQuery(this).addClass("ags-wc-filters-active");
					var $active = $filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-active a span").text(label);
					$active.html( window.ags_wc_filters_processOptionLabel($active.html()) );
					$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options").hide();

					if (!$applyButton.length && !ev.isTrigger) {
						window.ags_wc_filters_applyFilters($filtersContainer);
					}
					
					return false;
				});

				/*-------------single select end---------------*/
				break;

			case 'dropdown_multi_select':
				/*-------------multi select start--------------*/

				$filters.find(".ags-wc-filters-dropdown-multi .ags-wc-filters-active span").click(function(ev) {
					$filters.find(".ags-wc-filters-dropdown-multi-options").toggle();
					ev.stopPropagation();
				});

				$filters.find(".ags-wc-filters-dropdown-multi-options li input").change(function(ev) {
					var $checkbox = $(this);
					$checkbox.closest('li').toggleClass('ags-wc-filters-active', $checkbox.prop('checked'));

					var sel = $filters.find('.ags-wc-filters-list:first :checked').map(function(_, el) {
						return jQuery(el).attr("data-label");
					}).get();
					if(sel.length === 0){
						$filters.find(".ags-wc-filters-dropdown-multi > .ags-wc-filters-active span").text( $filters.find('.ags-wc-filters-dropdown-multi:first').attr('data-placeholder-text') );
					} else{
						$filters.find(".ags-wc-filters-dropdown-multi > .ags-wc-filters-active span").text(sel.join(', '));
					}

					if (!$applyButton.length && !ev.isTrigger) {
						window.ags_wc_filters_applyFilters($filtersContainer);
					}
				});

				/*--------------multi select end ------------*/
				break;

			case 'search':
				function populateSearchSuggestions($container, data) {
					if (data.length) {
						var $suggestionsList = $container.find('.ags-wc-filters-search-suggestions:first').empty();
						if (!$suggestionsList.length) {
							var $suggestionsList = jQuery('<ul class="ags-wc-filters-search-suggestions">').appendTo(
								jQuery('<div class="ags-wc-filters-search-suggestions-container ags-wc-filters-hide-on-click">')
									.append('<div class="ags-wc-filters-dropdown-toggle"></div>')
									.appendTo($container)
							);
						}

						for (var i = 0; i < data.length; ++i) {
							jQuery('<li>').append(
								jQuery('<a>').attr({
									href: data[i].link,
									target: '_blank'
								}).text(data[i].label)
							).appendTo($suggestionsList);
						}

						$suggestionsList.parent().show();
					} else {
						$container.children('.ags-wc-filters-search-suggestions-container:first').hide();
					}
				}

				if ( window.ags_wc_filters_isInVisualBuilder && $filters.has('.ags-wc-filters-search-with-suggestions').length ) {
					populateSearchSuggestions(
						$filters.find('.ags-wc-filters-search-container:first'),
						[
							{
								// translators: placeholder product
								label: wp.i18n.__('Product One', 'divi-shop-builder'),
								link: '#'
							},
							{
								// translators: placeholder product
								label: wp.i18n.__('Product Two', 'divi-shop-builder'),
								link: '#'
							}
						]
					);

					$filters.find('.ags-wc-filters-search-suggestions-container:first').hide().removeClass('ags-wc-filters-hide-on-click').find('a').click(function() {
						return false;
					});
				}

				$filters.find('input[type="search"]:first')
					.on( 'input', function(ev) {
						if (!$applyButton.length && !ev.isTrigger) {
							window.ags_wc_filters_applyFiltersThrottled($filtersContainer);
						}
					})
					.on( 'focus input', function(ev) {
						var $field = jQuery(this);
						var $container = $field.closest('.ags-wc-filters-search-container');

						if ( !ev.isTrigger && !window.ags_wc_filters_isInVisualBuilder && $container.hasClass('ags-wc-filters-search-with-suggestions') ) {

							var query = $field.val();

							var suggestionsTimeout;
							if (suggestionsTimeout) {
								clearTimeout(suggestionsTimeout);
							}

							if (query) {
								suggestionsTimeout = setTimeout(function() {
									suggestionsTimeout = null;
									$.post(
										DiviWoocommercePagesFrontendData.ajaxUrl,
										{
											action: 'ags_wc_filters_search_suggestions',
											query: query
										},
										function(response) {
											if (response.success && response.data) {
												populateSearchSuggestions($container, response.data);
											}
										},
										'json'
									);
								}, 200);
							} else {
								$field.siblings('.ags-wc-filters-search-suggestions-container:first').hide();
							}
						}
					});

				break;

			case 'number_range':
				var $slider = $filters.find('.ags-wc-filters-slider:first');
				var $minInput = $filters.find('input[type="number"]:first');
				var $maxInput = $filters.find('input[type="number"]:last');
				
				if ($filters.attr('data-ags-wc-filters-real-query-var') === 'shopPrice') {
					var $queryPriceRange = $shopModule.find('.ags-divi-wc-query-price-range:first');
					if ($queryPriceRange.length) {
						if (!$minInput.attr('data-min-default')) {
							$minInput.attr({
								'data-min-default': $minInput.attr('min'),
								'data-max-default': $minInput.attr('max')
							});
						}
						
						var range = [];
						for (var i = 0; i < 2; ++i) {
							var bound = i ? 'max' : 'min';
							var mode = $minInput.attr('data-' + bound + '-mode');
							if (!$queryPriceRange.attr('data-' + bound) || mode == 'always') {
								range[i] = $minInput.attr('data-' + bound + '-default');
							} else {
								range[i] = Math.floor($queryPriceRange.attr('data-' + bound));
								switch (mode) {
									case 'min':
										range[i] = Math.max( $minInput.attr('data-' + bound + '-default'), range[i] );
										break;
									case 'max':
										range[i] = Math.min( $minInput.attr('data-' + bound + '-default'), range[i] );
										break;
								}
							}
						}
						
						$minInput.add($maxInput).attr({
							min: range[0],
							max: range[1]
						});
					}
				}

				if ($slider.length) {

					$slider.siblings('.rs-container').remove();

					var minValue = parseInt($minInput.attr('min'));
					var maxValue = parseInt($minInput.attr('max'));
					
					var sliderOptions = {
						target: $slider[0],
						values: {
							min: minValue,
							max: maxValue
						},
						step: 1,
						range: true,
						scale: false,
						labels: false,
						tooltip: $minInput.hasClass('ags-wc-filters-hidden'),
						onChange: function(val) {
							if (!slider.hadFirstOnChange) {
								slider.hadFirstOnChange = true;
								return;
							}

							slider.isInOnChange = true;
							val = val.split(',');

							$minInput.val( parseInt(val[0]) === minValue ? '' : val[0] );
							$maxInput.val( parseInt(val[1]) === maxValue ? '' : val[1] ).trigger('input');

							if (!$applyButton.length) {
								window.ags_wc_filters_applyFiltersThrottled($filtersContainer);
							}
							slider.isInOnChange = false;
						}

					};
					
					var currencySymbol = $slider.closest('.ags-wc-filters-number-range-container').attr('data-currency-symbol');
					if (currencySymbol) {
						sliderOptions.valuePrefix = currencySymbol;
					}

					var currentFromValue = $minInput.val();
					var currentToValue = $maxInput.val();

					if (currentFromValue.length || currentToValue.length) {
						sliderOptions.set = [
							currentFromValue.length ? parseInt(currentFromValue) : minValue,
							currentToValue.length ? parseInt(currentToValue) : maxValue
						];
					}

					var slider = new rSlider(sliderOptions);

					slider.setValues2 = function(from, to) {
						slider.setValues(from, to);
						clearTimeout(slider.timeout);
					}
				}

				$filters.find('input[type="number"]').on( 'input', function(ev) {

					var $container = jQuery(this).closest('.ags-wc-filters-number-range-container');
					var min = $container.find('input[type="number"]:first').val();
					var max = $container.find('input[type="number"]:last').val();

					if ($slider.length && !slider.isInOnChange) {
						slider.setValues2(
							min.length ? parseInt(min) : minValue,
							max.length ? parseInt(max) : maxValue
						);
					}

					if (!$applyButton.length && !ev.isTrigger) {
						window.ags_wc_filters_applyFiltersThrottled($filtersContainer);
					}

				});
				break;

			case 'stars':
				var $control = $filters.find('.ags-wc-filters-stars-control:first');
				var $stars = $control.find('.ags-wc-filters-stars:first');

				$stars.children()
					.click(function(ev) {
						var value = jQuery(this).index() + 1;

						$stars.children(':lt(' + value + ')').removeClass('ags-wc-filters-star-empty').addClass('ags-wc-filters-star-filled');
						$stars.children(':gt(' + ( value - 1 ) + ')').removeClass('ags-wc-filters-star-filled').addClass('ags-wc-filters-star-empty');

						$control.attr( 'data-value', value + ($control.hasClass('ags-wc-filters-stars-control-only') ? '' : '+') );

						if (!$applyButton.length && !ev.isTrigger) {
							window.ags_wc_filters_applyFilters($filtersContainer);
						}
					})
					.hover(function() {
						var value = jQuery(this).index() + 1;

						$stars.children(':lt(' + value + ')').addClass( 'ags-wc-filters-star-hover' );
						$stars.children(':gt(' + ( value - 1 ) + ')').removeClass( 'ags-wc-filters-star-hover' );
					});

				$stars.mouseout(function() {
					$stars.children().removeClass('ags-wc-filters-star-hover');
				});

				break;
		}
	}
	
	window.ags_wc_filters_processOptionLabel = function(label) {
		// Wrap stars
		var firstStar = label.indexOf(star);

		if (label[firstStar + 4] === starEmpty || label[firstStar + 4] === star) {
			label = ( firstStar > 0 ? label.substring(0, firstStar - 1) + ( label[firstStar - 1] === ' ' ? '&nbsp;' : label[firstStar - 1] ) : '' )
					+ '<span class="ags-wc-filters-stars">'
					+ label.substring(firstStar, firstStar + 5)
								.replaceAll(new RegExp(star, 'g'), '<span class="ags-wc-filters-star-filled">' + star + '</span>')
								.replaceAll(new RegExp(starEmpty, 'g'), '<span class="ags-wc-filters-star-empty">' + star + '</span>')
					+ '</span>'
					+ (label.length > firstStar + 5 ? ( label[firstStar + 5] === ' ' ? '&nbsp;' : label[firstStar + 5] ) : '')
					+ label.substring(firstStar + 6);
		}

		return label;
	}

	window.ags_wc_filters_applyFiltersThrottled = function($filters) {
		var orderClass = $filters[0].className.match(/ags_woo_products_filters_[0-9]+/)[0];

		if (applyFiltersTimeout[orderClass]) {
			clearTimeout(applyFiltersTimeout[orderClass]);
		}

		applyFiltersTimeout[orderClass] = setTimeout(function() {
			delete applyFiltersTimeout[orderClass];
			window.ags_wc_filters_applyFilters($filters);
		}, 200);
	}

	window.ags_wc_filters_applyFilters = function($filters, url, extraData, cb, noResetPaging) {
		// Don't allow filters to be applied in the VB
		if (window.ags_wc_filters_isInVisualBuilder) {
			return false;
		}

		var queryString = '', query = {};
		var $selectedData = $filters.find('.ags-wc-filters-selected:first').empty();
		var dirtyProductCounts = [];
		var filteredCategories = null;

		function addToSelectedFilters(queryVar, valueId, valueText, valueTextIsHtml) {
			var $selected = jQuery('<p class="ags-wc-filters-selected-inner">')
				.attr('data-filter', queryVar + ':' + valueId);
			if (valueTextIsHtml) {
				$selected.html(valueText);
			} else {
				$selected.text(valueText);
			}
			$selected
				.prepend('<span class="ags-wc-filters-remove">x&nbsp;</span>')
				.html( window.ags_wc_filters_processOptionLabel($selected.html()) )
				.appendTo($selectedData.not(':has([data-filter="' + queryVar + ':' + valueId + '"])'));
		}

		var skipParams = ['add-to-cart'];

		$filters.find('.ags-wc-filters-section').each(function() {
			var activeCount = 0;
			
			skipParams.push($(this).attr('data-ags-wc-filters-query-var'));

			var $section = $(this);
			var queryVar = $section.attr('data-ags-wc-filters-query-var');
			var realQueryVar = $section.attr('data-ags-wc-filters-real-query-var');
			var dynamicProductCounts = $section.attr('data-ags-wc-filters-dynamic-product-counts');
			var hideZeroCount = $section.hasClass('ags-wc-filters-hide-zero-count');

			var displayType = window.ags_wc_filters_getDisplayType($section);

			switch (displayType) {
				case 'dropdown_single_select':
					var $sel = $section.find('.ags-wc-filters-dropdown-single-options:first .ags-wc-filters-active:not([data-id="all"]):first');
					if ($sel.length) {
						if (realQueryVar !== 'shopOrder') {
							addToSelectedFilters(queryVar, $sel.attr('data-id'), $sel.attr('data-label'));
						}
						sel = $sel.attr('data-id').toString();

						if (realQueryVar === 'shopOrder' && sel === 'menu_order') {
							sel = '';
						}
						
												if (realQueryVar === 'shopOrder' && sel === 'menu_order') {
							sel = '';
						}

						
						activeCount = 1;
					}

					if (dynamicProductCounts || hideZeroCount || $section.attr('data-condition') === 'notempty') {
						$section.find('.ags-wc-filters-dropdown-single-options:first a').each(function() {
							var $option = $(this);
							dirtyProductCounts.push({
								parent: '#' + $option.attr('id'),
								filter: dynamicProductCounts ? dynamicProductCounts : realQueryVar,
								value: $option.attr('data-id')
							});
						});
					}

					break;
				case 'dropdown_multi_select':
				case 'checkboxes_list':
				case 'radio_buttons':
				case 'colors':
				case 'images':
					var sel = $section.find('.ags-wc-filters-list:first :checked:not([value="all"])')
								.each(function() {
									var $option = $(this);
									addToSelectedFilters(queryVar, $option.val(), (displayType === 'colors' || displayType === 'images' ? $option.siblings('label:first').attr('title') : $option.attr('data-label')));
								})
								.map(function() {
									return $(this).val();
								})
								.get();
					
					activeCount = sel.length;
					
					if ( dynamicProductCounts || hideZeroCount || $section.attr('data-condition') === 'notempty' ) {
						$section.find('.ags-wc-filters-list:first input').each(function() {
							var $option = $(this);

							dirtyProductCounts.push({
								parent: 'label[for="' + $option.attr('id') + '"]',
								filter: dynamicProductCounts ? dynamicProductCounts : realQueryVar,
								value: $option.val()
							});
						});
					}

					break;
				case 'search':
					var sel = $section.find('input[type="search"]:first').val().trim();
					if (sel) {
						addToSelectedFilters(queryVar, sel, '"' + sel + '"');
						activeCount = 1;
					}
					break;
				case 'number_range':
					var $minField = $section.find('input[type="number"]:first');
					var min = $minField.val();
					var max = $section.find('input[type="number"]:last').val();

					if ((min || max) && (parseInt(min) !== parseInt($minField.attr('min')) || parseInt(max) !== parseInt($minField.attr('max')))) {
						min = min.length ? parseInt(min) : '';
						max = max.length ? parseInt(max) : '';

						var sel = min + '-' + max;
						var currencySymbol = $section.find('.ags-wc-filters-number-range-container').attr('data-currency-symbol');
						if (!currencySymbol) {
							currencySymbol = '';
						}

						if (!min) {
							var labelTemplate = 'max';
						} else if (!max) {
							var labelTemplate = 'min';
						} else {
							var labelTemplate = 'min-max';
						}
						
						var label = $filters.find('.ags-wc-filters-sections:first').parent().attr('data-range-text-' + labelTemplate);
						
						if (label) {
							label = label.replace('%filter%', $section.find('.ags-wc-filters-section-title h4:first').text());
							
							if (labelTemplate !== 'max') {
								label = label.replace('%min%', currencySymbol + min);
							}
							
							if (labelTemplate !== 'min') {
								label = label.replace('%max%', currencySymbol + max);
							}
						}

						addToSelectedFilters(queryVar, sel, label);
						activeCount = 1;
					} else {
						var sel = null;
					}

					break;
				case 'stars':
					var $control = $section.find('.ags-wc-filters-stars-control:first').clone();
					$control.find('.ags-wc-filters-star-hover').removeClass('ags-wc-filters-star-hover');
					var sel = $control.attr('data-value');

					if (sel === '0') {
						sel = null;
					} else {
						addToSelectedFilters(queryVar, sel, $control.html(), true);
						activeCount = 1;
					}

					break;

			}


			if(sel) {
				if (sel.length) {
					var queryVar = $section.attr('data-ags-wc-filters-query-var');
					if (!query[queryVar]) {
						query[queryVar] = [];
					}
					if (typeof sel === 'object') {
						query[queryVar] = query[queryVar].concat(sel);
					} else {
						query[queryVar].push(sel);
					}
				}
					
				if (realQueryVar === 'shopCategory') {
					filteredCategories = sel;
				}
			}
			
			$section.find('.ags-wc-filters-title-active-count:first').text( activeCount ? '(' + activeCount + ')' : '' );

		});

		if ($selectedData.has('*').length) {
			$selectedData.closest('.ags-wc-filters-selected-outer').show();
		} else {
			$selectedData.closest('.ags-wc-filters-selected-outer').hide();
		}
		
		if (url !== false) {
		
			for (var queryVar in query) {
				var uniqueValues = [];
				for (var i = 0; i < query[queryVar].length; ++i) {
					if (uniqueValues.indexOf(query[queryVar][i]) === -1) {
						uniqueValues.push(query[queryVar][i]);
					}
				}
				
				queryString += (queryString ? '&' : '') + queryVar + '=' + uniqueValues.map(encodeURIComponent).join('&' + queryVar + '=');
			}
			

			var shop_url = url ? url : location.href;
			var hashIndex = shop_url.indexOf('#');
			if (hashIndex === -1) {
				var shopUrlAnchor = '';
			} else {
				var shopUrlAnchor = shop_url.substring(hashIndex);
				shop_url = shop_url.substring(0, hashIndex);
			}

			var queryIndex = shop_url.indexOf('?');
			if (queryIndex !== -1) {
				var query = shop_url.substring(queryIndex + 1).split('&');
				var newQuery = [];
				for (var i = 0; i < query.length; ++i) {
					query[i] = query[i].split('=');
					if ( skipParams.indexOf(query[i][0]) === -1 && ( url || noResetPaging || query[i][0].substring(0, 8) !== 'shopPage' ) ) {
						newQuery.push( query[i].join('=') );
					}
				}

				shop_url = shop_url.substring(0, queryIndex) + (newQuery.length ? '?' + newQuery.join('&') : '');
			}

			if (queryString) {
				shop_url += (shop_url.indexOf('?') === -1 ? '?' : '&') + queryString;
			}
			
			shop_url = shop_url + shopUrlAnchor;

			var currentUrl = $shopModule.attr('data-shop-url');
			if (!currentUrl) {
				currentUrl = window.location.href;
			}
			var urlChanged = !areUrlsEquivalent(shop_url, currentUrl, true);
			
			if (urlChanged || !$shopModule.hasClass('ags-woo-shop-ajax-loaded')) {
				if (urlChanged) {
					window.history.pushState('', document.title, shop_url);
				}
				loadShopAjax($shopModule, extraData, cb);
			}
			
			if (url !== false) {
				var $filtersModule = $filters.closest('.ags_woo_products_filters').addBack('.ags_woo_products_filters');
				clearAllFilters( $('.ags_woo_products_filters').not( $filtersModule ) );
				onUrlChanged(null, null, $filtersModule);
			}
			
			if ( filteredCategories ) {
				$filters.find('.ags-wc-filters-section[data-condition="category"]').each(function() {
					var $this = $(this);
					var conditionCategories = $this.attr('data-condition-categories').split(',');
					var show = false;
					
					for (var i = 0; i < conditionCategories.length; ++i) {
						if (filteredCategories.indexOf(conditionCategories[i]) !== -1) {
							show = true;
							break;
						}
					}
					
					var $thisModule = $this.closest('.ags_woo_products_filters_child');
					
					if (!show && !$thisModule.hasClass('ags-wc-filters-hidden')) {
						clearAllFilters( $filters, true, $this );
					}
					$thisModule.toggleClass('ags-wc-filters-hidden', !show);	
					
				});
			}
		
		}

		if (dirtyProductCounts.length) {
			var filtersIndex = 'f' + $('.ags_woo_products_filters').index($filters);
			if (!productsCountSerial[filtersIndex]) {
				productsCountSerial[filtersIndex] = 0;
			}
		    var requestSerial = ++productsCountSerial[filtersIndex];
			$.post(
				getAjaxUrl(true),
				{
					ags_wc_filters_product_counts: JSON.stringify(dirtyProductCounts),
					forPost: $shopModule.attr('data-post-id')
				},
				function(response) {
					if (requestSerial === productsCountSerial[filtersIndex]) {
					
					for (var i = 0; i < response.length; ++i) {
						if (response[i].parent) {
							var count = parseInt(response[i].count);
							var $parent = $(response[i].parent);
							var $section = $parent.closest('.ags-wc-filters-section');
							var isHidden = false;
							if ($section.hasClass('ags-wc-filters-hide-zero-count')) {
								$parent.closest('li').toggleClass('ags-wc-filters-hidden', !count);
								isHidden = !count;
								window.ags_wc_filters_maybeToggleNoOptionsMessage($section);
							}
							if (!isHidden && $section.attr('data-ags-wc-filters-dynamic-product-counts')) {
								$parent.find('.ags-wc-filters-product-count').text(response[i].count);
							}
						}
					}
					
					$filters.find('.ags-wc-filters-section[data-condition="notempty"]').each(function() {
						var $this = $(this);
						var filter = $this.attr('data-ags-wc-filters-dynamic-product-counts');
						if (!filter) {
							filter = $this.attr('data-ags-wc-filters-real-query-var')
						}
						
						if (filter) {
							var show = true;
							for (var i = 0; i < response.length; ++i) {
								if (response[i].filter === filter) {
									if (parseInt(response[i].count)) {
										show = true;
										break;
									} else {
										show = false;
									}
								}
							}
							
							var $thisModule = $this.closest('.ags_woo_products_filters_child');
							
							if (!show && !$thisModule.hasClass('ags-wc-filters-hidden')) {
								clearAllFilters( $filters, true, $this );
							}
							$thisModule.toggleClass('ags-wc-filters-hidden', !show);	
						}
					});
					
					}
				},
				'json'
			);
		}
	}
	
	function areUrlsEquivalent(url1, url2, ignorePagination) {
		if (url1[0] === '/') {
			url1 = window.location.protocol + '//' + window.location.host + (window.location.port ? ':' + window.location.port : '') + url1;
		}
		
		if (url2[0] === '/') {
			url2 = window.location.protocol + '//' + window.location.host + (window.location.port ? ':' + window.location.port : '') + url2;
		}
		
		// Strip anchor portion
		var url1Anchor = url1.indexOf('#');
		if (url1Anchor !== -1) {
			url1 = url1.substring(0, url1Anchor);
		}
		var url2Anchor = url2.indexOf('#');
		if (url2Anchor !== -1) {
			url2 = url2.substring(0, url2Anchor);
		}
		
		var urlQ = url1.indexOf('?');
		var url2Q = url2.indexOf('?');
		
		if (ignorePagination && (urlQ !== -1 || url2Q !== -1)) {
			var paginationPattern = /([\?&])shopPage\=[0-9]+(&?)/g;
			function replacePaginationParam(param, before, after) {
				return after ? before : '';
			}
			
			if (urlQ !== -1) {
				url1 = url1.substring(0, urlQ) + url1.substring(urlQ).replaceAll(paginationPattern, replacePaginationParam);
				urlQ = url1.indexOf('?');
			}
			
			if (url2Q !== -1) {
				url2 = url2.substring(0, url2Q) + url2.substring(url2Q).replaceAll(paginationPattern, replacePaginationParam);
				url2Q = url2.indexOf('?');
			}
		}
		
		
		if (urlQ !== url2Q) {
			return false;
		}
		
		if (urlQ === -1) {
			return url1 === url2;
		}
		
		if (url1.substring(0, urlQ) !== url2.substring(0, urlQ)) {
			return false;
		}
		
		var url1QParts = url1.substring(urlQ + 1).split('&');
		var url2QParts = url2.substring(urlQ + 1).split('&');
		
		if (url1QParts.length !== url2QParts.length) {
			return false;
		}
		
		for (var i = 0; i < url1QParts.length; ++i) {
			if (url2QParts.indexOf(url1QParts[i]) === -1) {
				return false;
			}
		}
		
		return true;
	}

	function getAjaxUrl(realQueryVars) {
		var url = window.location.href;

		// Process duplicate GET variables
		var queryStartPos = url.indexOf('?');
		var hashStartPos = url.indexOf('#');
		if (queryStartPos !== -1) {
			var query = url.substring(queryStartPos + 1, hashStartPos === -1 ? url.length : hashStartPos).split('&');
			var fields = {};
			for (var i = 0; i < query.length; ++i) {
				query[i] = query[i].split('=');
				
				if ( realQueryVars ) {
					var $rqvElement = $('.ags-wc-filters-section[data-ags-wc-filters-real-query-var][data-ags-wc-filters-query-var="' + query[i][0].replaceAll(/"/g, '') + '"]');
					if ( $rqvElement.length ) {
						query[i][0] = $rqvElement.attr('data-ags-wc-filters-real-query-var');
					}
				}
				
				if ( fields[ query[i][0] ] ) {
					fields[ query[i][0] ].push( [ query[i][1] ] );
				} else {
					fields[ query[i][0] ] = [ query[i][1] ];
				}
			}

			for (fieldName in fields) {
				fields[fieldName] = fieldName + '=' + fields[fieldName].join('%2C'); // comma
			}

			url = url.substring(0, queryStartPos + 1) + Object.values(fields).join('&') + (hashStartPos === -1 ? '' : url.substring(hashStartPos));
		}

		return url;
	}

	function loadShopAjax($shop, extraData, cb) {
		if (!$shop.length) {
			return;
		}
		
		if (!extraData) {
			extraData = [];
		}
		
		var $body = $shop.closest('body');
		
		var notices = $body.find('.ags_woo_notices').get().map(function(elem) {
			return elem.className.split(' ').filter(function(className) {
				return className.indexOf('ags_woo_notices_') === 0;
			})[0];
		});
		
		notices = notices.map(function(value) {
			return {
				name: 'ags_wc_filters_ajax_notices[]',
				value: value
			}
		});
		
		var dataToSend = [
			{
				name: 'ags_wc_filters_ajax_shop',
				value: $shop[0].className.split(' ').filter(function(className) {
					return className.indexOf('ags_woo_shop_plus_') === 0;
				})[0]
			}
		].concat(notices)
		.concat(extraData);
		
		var newShopUrl = getAjaxUrl();
		$shopModule.attr('data-shop-url', newShopUrl);
		
		var requestSerial = ++shopSerial;

		$.ajax({
			type: 'POST',
			dataType: 'text',
			url: newShopUrl,
			data: dataToSend,
			beforeSend: function (response) {
			  $shop.addClass('ags-woo-shop-loading');
			},
			success: function(response) {
				if (requestSerial === shopSerial) {
				
				var responseStart = response.indexOf('/*agsdsb-json-start*/');
				response = (responseStart === -1) ? null : JSON.parse(response.substring(responseStart + 21));
				
				if (response) {
					if (response.dswcpRedirect) {
						window.location.href = response.dswcpRedirect;
						return;
					}
					
					for (shopId in response.shop) {
						addOrderSelectHandler(
							$body.find('.' + shopId).html(response.shop[shopId]).removeClass('ags-woo-shop-loading').addClass('ags-woo-shop-ajax-loaded')
						);
					}
					
					$('.ags-wc-filters-sections .ags-wc-filters-section[data-ags-wc-filters-query-var="shopPrice"]').each(function() {
						ags_wc_filters_initFilters( $(this) ); // re-init price filters
					});
					
					if (response.notices) {
						for (noticeId in response.notices) {
							$body.find('.' + noticeId).html(response.notices[noticeId]);
						}
					}
				}
				
				  if (cb) {
					  cb(response);
				  }
				
			   }
			},
			error: function(err) {
				$shop.removeClass('ags-woo-shop-loading');
				if (cb) {
					cb();
				}
			}
		});
	}
	
	function addOrderSelectHandler($container) {
		var shopOrderVar = encodeURIComponent($container.attr('data-shop-order-var'));
		
		$container.find('select.orderby').change(function(ev) {
			ev.originalEvent.stopPropagation();
			var $field = $(this);
			var $shop = $field.closest('.ags-wc-filters-section').length ? $shopModule : $field.closest('.ags_woo_shop_plus');
			var fieldValue = $field.val();
			
			var newHref = new RegExp('([\?&]' + shopOrderVar + '\=)').test(window.location.search)
							? window.location.href.replace(new RegExp('([\?&]' + shopOrderVar + '\=)([^&]*)'), (fieldValue === 'menu_order' ? '' : '$1' + fieldValue.replaceAll(/\$/g, '$$')))
							: window.location.href.substring(0, window.location.href.length - window.location.hash.length) + (fieldValue === 'menu_order' ? '' : (window.location.href.indexOf('?') === -1 ? '?' : '&') + shopOrderVar + '=' + fieldValue) + window.location.hash
			
			if (newHref !== window.location.href) {
				window.history.pushState(
					null,
					document.title,
					newHref
				);
				
				loadShopAjax( $shop );
			}
			
			return false;
		});
	}

	if (!window.ags_wc_filters_isInVisualBuilder) {
		addOrderSelectHandler(
			$('.ags-divi-wc-shop-ajax').on('click', 'a', function() {
				var $link = $(this);

				if ($link.hasClass('add_to_cart_button') && $link.attr('href').indexOf('add-to-cart=') !== -1 && !$link.hasClass('wcpa_has_options') ) {
					var extraData = [];
					extraData = $link.closest('.product').find(':input').serializeArray();
					var linkParts = $link.attr('href').split('?');
					if (linkParts.length === 2) {
						var queryParts = linkParts[1].split('&');
						for (var i = 0; i < queryParts.length; ++i) {
							var queryPair = {};
							var equalsPos = queryParts[i].indexOf('=');
							extraData.push({
								name: equalsPos ? queryParts[i].substring(0, equalsPos) : queryParts[i],
								value: equalsPos ? queryParts[i].substring(equalsPos + 1) : ''
							});
						}
					}
					loadShopAjax( $link.closest('.ags-divi-wc-shop-ajax'), extraData, function(response) {
						window.jQuery(document.body).trigger('added_to_cart', [ response && response['wc-fragments'] ? response['wc-fragments'] : {}, response && response['wc-cart-hash'] ? response['wc-cart-hash'] : '' ]);
					} );
					return false;
				}

				if ($link.closest('.woocommerce-pagination').length) {
					var $shop = $link.closest('.ags-divi-wc-shop-ajax');
					
					var moduleIndex = $('.ags_woo_shop_plus').index($shop.closest('.ags_woo_shop_plus'));
					var pageVar = 'shopPage' + (moduleIndex ? moduleIndex + 1 : '');
					var linkHref = $link.attr('href');
					
					var pageNumResult = new RegExp('[\?&]' + pageVar + '\=([0-9]+)').exec(linkHref);
					var pageNum = pageNumResult ? pageNumResult[1] : null;
					
					window.history.pushState(
						null,
						document.title,
						new RegExp('([\?&]' + pageVar + '\=)').test(window.location.search)
							? window.location.href.replace(new RegExp('([\?&]' + pageVar + '\=)([^&]*)'), (pageNum ? '$1' + pageNum : ''))
							: window.location.href.substring(0, window.location.href.length - window.location.hash.length) + (pageNum ? (window.location.href.indexOf('?') === -1 ? '?' : '&') + pageVar + '=' + pageNum : '') + window.location.hash
							);
					loadShopAjax( $shop, null, function() {
						if (window.et_pb_smooth_scroll) {
							window.et_pb_smooth_scroll( $shop );
						}
					} );
					return false;
				}

				if ($link.closest('.categories').length) {
					var filterUrl = $link.attr('data-filter-url');
					if (filterUrl && $('.ags-wc-filters-section[data-ags-wc-filters-query-var="shopCategory"]:not(.ags-wc-filters-children-hide):first').length ) {
						var $shop = $link.closest('.ags-divi-wc-shop-ajax');
						window.history.pushState( null, document.title, decodeURIComponent(filterUrl) );
						onUrlChanged(null, function() {
							if (window.et_pb_smooth_scroll) {
								window.et_pb_smooth_scroll( $shop );
							}
						});
						return false;
					}
				}

			})
		);
	}

	/*---------------Apply Ajax End-----------------*/

   function onUrlChanged(ev, cb, noApplyFilters, noResetPaging) {

	   if (ev) {
		$('.ags-wc-filters-sections').each(function() {
			clearAllFilters($(this));
		});
	   }
		
		var queryVars = $('.ags-wc-filters-section[data-ags-wc-filters-query-var]').get().map(function(e) {
			return $(e).attr('data-ags-wc-filters-query-var');
		});
		
		var queryPairs = window.location.search.substring(1).split('&');
		var filteringSettings = {};

		for (var i = 0; i < queryPairs.length; ++i) {
			for (var j = 0; j < queryVars.length; ++j) {
				if (queryPairs[i].substring(0, queryVars[j].length + 1) === queryVars[j] + '=') {
					var queryVar = queryVars[j];
					var catPara = decodeURIComponent( queryPairs[i].substring(queryVar.length + 1) );
					
					if (filteringSettings[queryVar]) {
						filteringSettings[queryVar].push(catPara);
					} else {
						filteringSettings[queryVar] = [catPara];
					}
					
					break;
				}
			}
		}

		for ( queryVar in filteringSettings ) {

			var catArray = filteringSettings[queryVar];
			if(catArray.length){

				var changed = false;

				$('.ags-wc-filters-section[data-ags-wc-filters-query-var="' + queryVar + '"]').each(function() {

					$filters = $(this);

					switch (window.ags_wc_filters_getDisplayType($filters)) {
						case 'checkboxes_list':
						case 'dropdown_multi_select':
						case 'colors':
						case 'images':
							var $activeCheckboxes = $filters.find(".ags-wc-filters-list:first :checkbox[value='" + catArray[0] + "']");
							for (var i = 1; i < catArray.length; ++i) {
								$activeCheckboxes = $activeCheckboxes.add( $filters.find(".ags-wc-filters-list:first :checkbox[value='" + catArray[i] + "']") );
							}

							changed = $filters.find(".ags-wc-filters-list:first :checkbox:checked").not($activeCheckboxes).prop('checked', false).change().length || changed;
							changed = $activeCheckboxes.not(':checked').prop('checked', true).change().length || changed;
							break;
						case 'radio_buttons':
							changed = $filters.find(".ags-wc-filters-list:first :radio[value='" + catArray[0] + "']:not(:checked)").prop('checked', true).change().length || changed;
							break;
						case 'dropdown_single_select':
							changed = $filters.find('.ags-wc-filters-dropdown-single-options:first a[data-id="' + catArray[0] + '"]:not(.ags-wc-filters-active):first').click().length || changed;
							break;
						case 'search':
							$filters.find('input[type="search"]:first').val( catArray[0] ).trigger('input');
							break;
						case 'number_range':
							catArray = catArray[0].split('-');
							$filters.find('input[type="number"]:first').val( catArray[0] );
							$filters.find('input[type="number"]:last').val( catArray[1] ).trigger('input');
							break;
						case 'stars':
							if ( ( catArray[0].length === 2 ? catArray[0][1] === '+' : catArray[0].length === 1 ) && catArray[0][0] >= 1 && catArray[0][0] <= 5) {
								$filters.find('.ags-wc-filters-stars:first span:eq(' + (catArray[0][0] - 1) + ')').click();
							}
							break;

					}
				});

			}

		}
		
		var limitedApply = typeof noApplyFilters === 'object';
		if (!noApplyFilters || limitedApply) {
			var $applyFilters = $('.ags_woo_products_filters');
			if (limitedApply) {
				$applyFilters = $applyFilters.not(noApplyFilters);
			}
			$applyFilters.each(function() {
				// Note: this is the only case of more than one argument to this function
				window.ags_wc_filters_applyFilters( $(this), limitedApply ? false : null, null, cb, noResetPaging );
			});
		}
	}

	if (!window.ags_wc_filters_isInVisualBuilder) {
		$(window).on('popstate', onUrlChanged);

		$(".ags-wc-filters-button-clear").click(function() {
			clearAllFilters( $(this).closest('.ags_woo_products_filters'), true );
		});
	}

		function clearAllFilters($filtersContainer, apply, filters) {
			$filtersContainer.find('.ags-wc-filters-section').filter(filters ? filters : '*').each(function() {
				var $filters = $(this);

				switch (window.ags_wc_filters_getDisplayType($filters)) {
					case 'radio_buttons':
						var $allOption = $filters.find("input[value='all']:first");
						if (!$allOption.prop('checked')) {
							$allOption.prop('checked', true).change();
							if (apply) {
								window.ags_wc_filters_applyFilters($filtersContainer);
							}
						}
						break;
					case 'dropdown_single_select':
						$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a").removeClass("ags-wc-filters-active");
						var $defaultOption = $filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a[data-id='all']:first");
						if (!$defaultOption.length) {
							$defaultOption = $filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li:first a");
						}
						$defaultOption.addClass("ags-wc-filters-active");
						$filters.find(".ags-wc-filters-dropdown-single .ags-wc-filters-active a span").text($defaultOption.attr('data-label'));
						$filters.closest('.ags_woo_products_filters').find('.ags-wc-filters-selected:first .ags-wc-filters-selected-inner[data-filter^="' + $filters.attr('data-ags-wc-filters-query-var') + ':"]').remove();
						if (apply) {
							window.ags_wc_filters_applyFilters($filtersContainer);
						}
						break;
					case 'dropdown_multi_select':
					case 'checkboxes_list':
					case 'colors':
					case 'images':
						var changed = false;
						$filters.find(".ags-wc-filters-list:first :checkbox").each(function(index) {
							if($(this).prop('checked') === true){
								$(this).prop('checked', false).change();
								changed = true;
							}
						});
						if (changed && apply) {
							window.ags_wc_filters_applyFilters($filtersContainer);
						}
						$filters.find(".ags-wc-filters-active span").text( $filters.find('.ags-wc-filters-dropdown-multi:first').attr('data-placeholder-text') );
						break;
					case 'search':
						var $search = $filters.find('input[type="search"]:first');

						if ($search.val()) {
							$search.val('').trigger('input');
							if (apply) {
								window.ags_wc_filters_applyFilters($filtersContainer);
							}
						}
						break;

					case 'number_range':
						var $min = $filters.find('input[type="number"]:first');
						var $max = $filters.find('input[type="number"]:last');

						if ($min.val() || $max.val()) {
							$min.val('');
							$max.val('').trigger('input');
							if (apply) {
								window.ags_wc_filters_applyFilters($filtersContainer);
							}
						}
						break;

					case 'stars':
						var $control = $filters.find('.ags-wc-filters-stars-control:first');
						var hadValue = parseInt($control.attr('data-value')) !== 0;

						if (hadValue) {
							$control
								.attr('data-value', 0)
								.find('.ags-wc-filters-stars:first > span')
								.removeClass('ags-wc-filters-star-filled')
								.addClass('ags-wc-filters-star-empty');
							$filters.closest('.ags_woo_products_filters').find('.ags-wc-filters-selected:first .ags-wc-filters-selected-inner[data-filter^="' + $filters.attr('data-ags-wc-filters-query-var') + ':"]').remove();
							if (apply) {
								window.ags_wc_filters_applyFilters($filtersContainer);
							}
						}
						break;
				}
			});
		}
		
		
		$('.ags_woo_products_filters .ags-wc-filters-filter-clear').on('click', function() {
			clearAllFilters( $(this).closest('.ags_woo_products_filters'), true, $(this).closest('.ags-wc-filters-section') );
			return false;
		});

		$('.ags_woo_products_filters').find('.ags-wc-filters-selected:first').on('click', '.ags-wc-filters-remove', function() {
			if (window.ags_wc_filters_isInVisualBuilder) {
				return false;
			}

			var $selectedItem = $(this).parent();
			var filter = $selectedItem.attr('data-filter').split(':');
			var $filtersContainer = $selectedItem.closest('.ags_woo_products_filters');
			var $filters = $filtersContainer.find('.ags-wc-filters-section[data-ags-wc-filters-query-var="' + filter[0] + '"]');

			switch ( window.ags_wc_filters_getDisplayType( $filters ) ) {
				case 'dropdown_multi_select':
				case 'checkboxes_list':
				case 'colors':
				case 'images':
					$filters.find('.ags-wc-filters-list:first input[value="' + filter[1] + '"]').prop('checked', false).change();
					break;

				case 'dropdown_single_select':
					$filters.find('.ags-wc-filters-dropdown-single-options:first a[data-id="all"]:first').click();
					break;

				case 'radio_buttons':
					$filters.find('.ags-wc-filters-list:first input[value="all"]').prop('checked', true).change();
					break;

				case 'search':
					$filters.find('input[type="search"]:first').val('').trigger('input');
					break;

				case 'number_range':
					$filters.find('input[type="number"]:first').val('');
					$filters.find('input[type="number"]:last').val('').trigger('input');
					break;

				case 'stars':
					var $control = $filters.find('.ags-wc-filters-stars-control:first');
					var emptyStar = $control.attr('data-star-empty');

					$control
						.attr('data-value', 0)
						.find('.ags-wc-filters-stars:first > span')
						.removeClass('ags-wc-filters-star-filled')
						.addClass('ags-wc-filters-star-empty');

					break;

			}

			if (!$filtersContainer.has('.ags-wc-filters-button-apply').length) {
				window.ags_wc_filters_applyFilters($filtersContainer);
			}

			$selectedItem.remove();

		});


	$('.ags-wc-filters-section').each(function() {
		var $section = $(this);
		window.ags_wc_filters_initFilters($section);
		window.ags_wc_filters_maybeToggleNoOptionsMessage($section);
	});

	$(window).on('et_builder_api_ready', function(ev, api) {

		var filterShopModules = [];

		function findShopFilteringModules(shortcodes) {
			for (var i = 0; i < shortcodes.length; ++i) {

				if (shortcodes[i].type === 'ags_woo_shop_plus') {
					if (shortcodes[i].attrs.filter_target === 'on') {
						filterShopModules.push(shortcodes[i]._key);
					}
				} else if (typeof shortcodes[i].content === 'object') {
					findShopFilteringModules(shortcodes[i].content);
				}
			}
		}

		var activeTogglePollInterval = null;

		window.et_gb.wp.hooks.addFilter(
			'et.builder.store.action.dispatched',
			'ags-wc-filters',
			function(action) {

				switch ( action.actionType ) {
					case 'MODULE_EDIT_SETTINGS_CHANGE':
						if ( action.module.props.type === 'ags_woo_shop_plus' && action.setting === 'filter_target') {
							var index = filterShopModules.indexOf(action.module.props._key);
							if (action.newValue === 'on') {
								if (index === -1) {
									filterShopModules.push(action.module.props._key);
								}
							} else if (index !== -1) {
								filterShopModules.splice(index, 1);
							}
							window.ags_wc_filters_noShopFilteringModule = !filterShopModules.length;
							window.ags_wc_filters_multipleShopFilteringModules = filterShopModules.length > 1;
						}
						break;
					case 'ET_SET_ROOT_MOUNTED':
						findShopFilteringModules(ETBuilderBackend.shortcodeObject);
						window.ags_wc_filters_noShopFilteringModule = !filterShopModules.length;
						window.ags_wc_filters_multipleShopFilteringModules = filterShopModules.length > 1;
						break;
				}

				return action;

			}
		);

		window.et_gb.wp.hooks.addAction(
			'et.builder.store.module.settings.open',
			'ags-wc-filters',
			function(module) {
				if ( activeTogglePollInterval ) {
					try {
					window.clearInterval(activeTogglePollInterval);
					} catch (ex) { }
					activeTogglePollInterval = null;
				}
				window.jQuery('.et_pb_module[data-agswc-active-toggle]').attr('data-agswc-active-toggle', null);

				if ( module.props && module.props.type && module.props.type.substring(0, 8) === 'ags_woo_' ) {
					var activeKey = module.props._key;
					var activeToggle = null;
					activeTogglePollInterval = window.setInterval(function() {
						var newActiveToggle = window.et_gb.jQuery('.et-fb-tabs__panel--active:first .et-fb-form__toggle-opened:first').attr('data-name');
						if (newActiveToggle !== activeToggle || !window.jQuery('.et-module-' + activeKey + '[data-agswc-active-toggle]').length) {
							activeToggle = newActiveToggle;
							window.jQuery('.et-module-' + activeKey).attr('data-agswc-active-toggle', activeToggle ? activeToggle : null);
						}
					}, 500);
				}
				
			}
		);

		window.et_gb.wp.hooks.addAction(
			'et.builder.store.module.settings.close',
			'ags-wc-filters',
			function(module) {
				if ( activeTogglePollInterval ) {
					window.clearInterval(activeTogglePollInterval);
					activeTogglePollInterval = null;
				}
				window.jQuery('.et_pb_module[data-agswc-active-toggle]').attr('data-agswc-active-toggle', null);
			}
		);
	});
	

	if (!window.ags_wc_filters_isInVisualBuilder) {
		// Initial page load
		onUrlChanged(null, null, [], true);
	}

	// Prevent other things from interfering with the multi-step checkout navigation
	$('.dswcp-checkout-steps a').on('click', function(ev) {
		location.hash = $(this).attr('href');
		return false;
	});
	

	var hiddenSteps = $('.dswcp-checkout-steps').attr('data-hidden-steps');
	if (hiddenSteps) {
		$( hiddenSteps ).hide();
	}
	var $initialStep = $('.dswcp-checkout-steps li:first').addClass('dswcp-checkout-step-active');
	$('.dswcp-checkout-steps li:not(.dswcp-checkout-step-active)').each(function() {
		$( $(this).attr('data-selector') ).hide();
	});
	
	var $buttons = $('.dswcp-checkout-steps-buttons-container:first').insertAfter( $initialStep.attr('data-selector') );
	$buttons.find('.dswcp-button-back').hide();
	
	function showLoader($targetModule) {
		$('.dswcp-checkout-loader').prependTo($targetModule);
	}
	
	function hideLoader() {
		$('.dswcp-checkout-loader').appendTo('.ags_woo_multi_step_checkout');
	}
	

	if (location.hash && $('.dswcp-checkout-steps li a[href="' + location.hash + '"]').length) {
		// Don't allow loading the page with a step pre-selected
		location.hash = '';
	}
	
	var handleHashChange = true;
	$(window).on('hashchange', function(ev) {
		if (!handleHashChange) {
			handleHashChange = true;
			return;
		}
		
		if (location.hash) {
			var $newStep = $('.dswcp-checkout-steps li:has(a[href="' + location.hash + '"]):first');
		} else if (ev.originalEvent && ev.originalEvent.oldURL && ev.originalEvent.oldURL.indexOf('#') !== -1 && $('.dswcp-checkout-steps li a[href="#' + ev.originalEvent.oldURL.split('#').pop() + '"]:first').length) {
			var $newStep = $('.dswcp-checkout-steps li:first');
		} else {
			return;
		}
		
		var $currentStep = $('.dswcp-checkout-steps .dswcp-checkout-step-active:first');
		var $currentSection = $( $currentStep.attr('data-selector') );
		var $newSection = $( $newStep.attr('data-selector') );
		
		
		var goToNewStep = function() {
			$currentStep.removeClass('dswcp-checkout-step-active');
			$currentSection.hide();
			$newStep.addClass('dswcp-checkout-step-active');
			
			var $submitButton = $newSection.find('button#place_order');
			var $continueButton = $buttons.find('.dswcp-button-continue');
			if ($submitButton.length) {
				$continueButton.attr('data-original-content', $continueButton.html()).html( $submitButton.html() ).attr('type', 'submit');
				$submitButton.hide();
			} else if ($continueButton.attr('type') === 'submit') {
				$continueButton.attr('type', 'button').html( $continueButton.attr('data-original-content') );
			}
			
			$newSection.show();
			
			$buttons.insertAfter($newSection);
			$buttons.find('.dswcp-button-back').toggle($newStep.prev().length > 0);
			
			hideLoader();
		};

		if (!$('.ags_woo_notices:visible .woocommerce-notices-wrapper').empty().length) {
			$('.ags_woo_multi_step_checkout .dswcp-checkout-steps').next('.woocommerce-notices-wrapper').empty();
		}

		if ($currentStep.length && $currentStep.index() < $newStep.index() && $currentSection.has(':input').length) {
		
			showLoader($currentSection);
			
			$.post(
				woocommerce_params.ajax_url,
				{
					action: 'dswcp_validate_checkout_step',
					fields: $currentSection.find(':input').serialize()
				},
				function(response) {
					if (response.success || !response.data) {
						goToNewStep();
					} else {
						var $notices = $('.ags_woo_notices:visible .woocommerce-notices-wrapper').first();
						if (!$notices.length) {
							var $steps = $('.ags_woo_multi_step_checkout .dswcp-checkout-steps');
							$notices = $steps.next('.woocommerce-notices-wrapper');
							if (!$notices.length) {
								$notices = $('<div>').addClass('woocommerce-notices-wrapper').insertAfter($steps);
							}
						}
						$notices.empty().append(response.data);
						handleHashChange = false;
						location.hash = $currentStep.children('a').attr('href');
						if (window.et_pb_smooth_scroll) {
							window.et_pb_smooth_scroll( $notices );
						}
						hideLoader();
					}
				}
			).fail(function() {
				goToNewStep(); // ignore validation failure for now
			});
			
		} else {
			goToNewStep();
		}
	});
	
	$(document).on('focus blur', '.ags_woo_mini_cart .et_pb_module_inner > a', function(ev) {
		$(this).closest('.ags_woo_mini_cart').toggleClass('dswcp-focus', ev.type === 'focusin');
	});
	
	$(document).on('click', '.ags_woo_mini_cart .et_pb_module_inner > a', function() {
		var $cartLink = $(this).trigger('blur'), $miniCart = $cartLink.closest('.ags_woo_mini_cart');
		var isMobile = $(window).outerWidth() <= 980;
		switch ( $cartLink.closest('.ags_woo_mini_cart').attr(isMobile ? 'data-action-click-mobile' : 'data-action-click') ) {
			case 'sidecart':
				var sideCartId = $miniCart.attr('data-side-cart-id');
				if (sideCartId) {
					var $sideCart = $('#' + sideCartId);
					if ($sideCart.hasClass('dswcp-show-side-cart')) {
						$sideCart.addClass('dswcp-closing-side-cart');
						$sideCart.removeClass('dswcp-show-side-cart dswcp-show-side-cart-click');
						setTimeout( function() { $sideCart.removeClass('dswcp-closing-side-cart'); }, 400 );
					} else {
						$sideCart.addClass('dswcp-show-side-cart dswcp-show-side-cart-click');
					}
				}
				return false;
			case 'dropdowncart':
				if (!isMobile){
					$miniCart.closest('.ags_woo_mini_cart').toggleClass('dswcp-show-dropdown');
				}
				return false;
		}
	});
	
	var miniCartTouchStart = null;
	
	function updateCart($module, actionParameters, skipSideCart, cb) {
		$module.addClass('ags_woo_mini_cart_updating');
		if (!skipSideCart) {
			var sideCartId = $module.attr('data-side-cart-id');
			if (sideCartId) {
				var $sideCart = $('#' + sideCartId);
				var sideCartClassNames = $sideCart.attr('class');
				$sideCart.addClass('ags_woo_mini_cart_updating').prepend(
					$('<div>').addClass('dswcp-side-cart-overlay').append($('<span>').text($module.attr('data-loading-text')))
				);
			}
		}
		$('<div>').addClass('dswcp-dropdown-cart-overlay').append($('<span>').text($module.attr('data-loading-text'))).prependTo(
			$module.find('.dswcp-dropdown-cart:first')
		);
		$.post(
			woocommerce_params.ajax_url,
			Object.assign({
				action: 'dswcp_update_cart',
				cartConfig: $module.attr('data-update-cart-config'),
				sideCartId: skipSideCart ? '' : sideCartId,
				_ajax_nonce: $module.attr('data-update-cart-nonce'),
			}, actionParameters ? actionParameters : {}),
			function(response) {
				if (response.success && response.data && response.data.html) {
					if (!skipSideCart && sideCartId) {
						$('#' + sideCartId).remove();
					}
					var $target = $module.find('.et_pb_module_inner:first');
					$target.html(response.data.html);
					$module.removeClass('ags_woo_mini_cart_updating');
					if (!skipSideCart && sideCartId) {
						$('#' + sideCartId).attr('class', null).attr('class', sideCartClassNames);
					}
					if (cb) {
						cb();
					}
				} else {
					location.reload();
				}
			},
			'json'
		).fail(function() { location.reload(); });
	}
	
	$('.ags_woo_mini_cart:has(.dswcp-needs-update)').each(function() {
		updateCart($(this));
	});
	
	if (!window.ags_wc_filters_isInVisualBuilder) {
		
		$(document).on('change', '.dswcp-side-cart .dswcp-quantity', function() {
			var $field = $(this);
			var moduleId = $field.closest('.dswcp-side-cart').attr('id');
			if (moduleId) {
				moduleId = moduleId.substring(0, moduleId.length - 11);
				var $module = $('.' + moduleId + ':first');
			}
			if (!moduleId || !$module.length) {
				return;
			}
			updateCart($module, { cartAction: 'update-quantity', item: $field.closest('[data-cart-item-key]').attr('data-cart-item-key'), quantity: $field.val() }, false, function() {
				$(document.body).trigger('updated_wc_div', {_dswcp_skip: $module});
			});
		});
		
		$(document).on('click', '.ags_woo_mini_cart .dswcp-remove, .dswcp-side-cart .dswcp-remove', function() {
			var $field = $(this);
			var $module = $field.closest('.ags_woo_mini_cart');
			if (!$module.length) {
				var moduleId = $field.closest('.dswcp-side-cart').attr('id');
				if (moduleId) {
					moduleId = moduleId.substring(0, moduleId.length - 11);
					$module = $('.' + moduleId + ':first');
				}
			}
			if (!$module.length) {
				return;
			}
			updateCart($module, { cartAction: 'item-remove', item: $field.closest('[data-cart-item-key]').attr('data-cart-item-key') }, false, function() {
				$(document.body).trigger('removed_from_cart', {_dswcp_skip: $module});
			});
		});
		
		$(document.body).on('added_to_cart removed_from_cart updated_wc_div wc_cart_emptied', function(ev, params) {
			var $miniCarts = $('.et_pb_module.ags_woo_mini_cart');
			if (params && params._dswcp_skip) {
				$miniCarts = $miniCarts.not(params._dswcp_skip);
			}
			$miniCarts.each(function() { updateCart( $(this), null, params && params._dswcp_skip && params._dswcp_skip.attr('data-side-cart-id') && params._dswcp_skip.attr('data-side-cart-id') === $(this).attr('data-side-cart-id') ); });
		});
	
	}
		
	$(document).on('click', '.dswcp-side-cart .dswcp-close', function() {
		var $sideCart = $(this).closest('.dswcp-side-cart');
		$sideCart.addClass('dswcp-closing-side-cart').removeClass('dswcp-show-side-cart dswcp-show-side-cart-click');
		setTimeout( function() { $sideCart.removeClass('dswcp-closing-side-cart') }, 500 );
	});
	
	$(document).on('click', '.ags_woo_mini_cart .dswcp-dropdown-cart .dswcp-close', function() {
		$(this).closest('.ags_woo_mini_cart').removeClass('dswcp-show-dropdown');
	});
	
	$(document).on('click', '.dswcp-button-continue[type="button"]', function() {
		location.hash = $('.dswcp-checkout-steps .dswcp-checkout-step-active:first').next().children('a').attr('href');
	});
	
	$(document).on('click', '.dswcp-button-back', function() {
		location.hash = $('.dswcp-checkout-steps .dswcp-checkout-step-active:first').prev().children('a').attr('href');
	});
	
	
	$(document).on('touchstart', '.dswcp-side-cart', function(ev) {
		if (ev.originalEvent.touches.length === 1) {
			miniCartTouchStart = ev.originalEvent.touches[0].clientX;
			$(this).addClass('dswcp-dragging');
		}
	});
	
	$(document).on('touchmove', function(ev) {
		if (miniCartTouchStart !== null) {
			$('.dswcp-side-cart.dswcp-dragging').css('right', ev.originalEvent.touches[0].clientX - miniCartTouchStart > 0 ? (miniCartTouchStart - ev.originalEvent.touches[0].clientX) + 'px' : null);
		}
	});
	
	$(document).on('touchend', function(ev) {
		if (miniCartTouchStart !== null) {
			miniCartTouchStart = null;
			var $sideCart = $('.dswcp-side-cart.dswcp-dragging');
			var willClose = parseInt($sideCart.css('right')) * -2 >= $sideCart.width();
			
			if (willClose) {
				$sideCart.addClass('dswcp-closing-side-cart').removeClass('dswcp-show-side-cart');
				setTimeout( function() { $sideCart.removeClass('dswcp-closing-side-cart'); }, 400 );
			}
			
			$sideCart.removeClass('dswcp-dragging').css('right', '');
		}
		
	});
	
	$(document).on('click', '.ags-wc-filters-expand-hierarchy .ags-wc-filters-has-children > label a', function(ev) {
		$(this).parent().parent().toggleClass('ags-wc-filters-expanded');
		ev.preventDefault();
	});
	
	$(document).on('click', '.dswcp-palette a', function() {
		var $li = $(this).parent();
		$(this).closest('.dswcp-attribute-color').find('select').val( $li.attr('data-value') ).trigger('change');
		$li.siblings().removeClass('dswcp-active');
		$li.addClass('dswcp-active');
		return false;
	});
	
	$('.dswcp-attribute-color select').each(function() {
		$(this).closest('.dswcp-attribute-color').find('.dswcp-palette li[data-value="' + $(this).val() + '"]').trigger('click');
	});
	
	$(document).on('mousedown', '.ags-wc-filters-row .ags-wc-filters-sections', function(ev) {
		if (!$(ev.target).closest('.ags-wc-filters-section-inner-wrapper').length) {
			var $sections = $(this);
			var $row = $sections.parent();
			var startPos = ev.clientX;
			var startMargin = parseInt($sections.css('margin-left'));
			
			function onMove(ev) {
				$sections.css('margin-left', (Math.min( startMargin + Math.max(ev.clientX - startPos, $row.width() - $sections.width()), 0)) + 'px');
			}
			
			function onUp() {
				$sections.off('mousemove', onMove);
				$(document).off('mouseup', onUp);
			}
			
			$sections.on('mousemove', onMove);
			
			$(document).on('mouseup', onUp);
			
		}
	});
	
});

!function(){"use strict";var t=function(t){this.input=null,this.inputDisplay=null,this.slider=null,this.sliderWidth=0,this.sliderLeft=0,this.pointerWidth=0,this.pointerR=null,this.pointerL=null,this.activePointer=null,this.selected=null,this.scale=null,this.step=0,this.tipL=null,this.tipR=null,this.timeout=null,this.valRange=!1,this.values={start:null,end:null},this.conf={target:null,values:null,set:null,range:!1,width:null,scale:!0,labels:!0,tooltip:!0,step:null,disabled:!1,onChange:null,valuePrefix:''},this.cls={container:"rs-container",background:"rs-bg",selected:"rs-selected",pointer:"rs-pointer",scale:"rs-scale",noscale:"rs-noscale",tip:"rs-tooltip"};for(var i in this.conf)t.hasOwnProperty(i)&&(this.conf[i]=t[i]);this.init()};t.prototype.init=function(){return"object"===typeof this.conf.target?this.input=this.conf.target:this.input=document.getElementById(this.conf.target.replace("#","")),this.input?(this.inputDisplay=getComputedStyle(this.input,null).display,this.input.style.display="none",this.valRange=!(this.conf.values instanceof Array),!this.valRange||this.conf.values.hasOwnProperty("min")&&this.conf.values.hasOwnProperty("max")?this.createSlider():console.log("Missing min or max value...")):console.log("Cannot find target element...")},t.prototype.createSlider=function(){return this.slider=i("div",this.cls.container),this.slider.innerHTML='<div class="rs-bg"></div>',this.selected=i("div",this.cls.selected),this.pointerL=i("div",this.cls.pointer,["dir","left"]),(this.conf.scale&&(this.scale=i("div",this.cls.scale))),this.conf.tooltip&&(this.tipL=i("div",this.cls.tip),this.tipR=i("div",this.cls.tip),this.pointerL.appendChild(this.tipL)),this.slider.appendChild(this.selected),(this.conf.scale&&this.slider.appendChild(this.scale)),this.slider.appendChild(this.pointerL),this.conf.range&&(this.pointerR=i("div",this.cls.pointer,["dir","right"]),this.conf.tooltip&&this.pointerR.appendChild(this.tipR),this.slider.appendChild(this.pointerR)),this.input.parentNode.insertBefore(this.slider,this.input.nextSibling),this.conf.width&&(this.slider.style.width=parseInt(this.conf.width)+"px"),this.sliderLeft=this.slider.getBoundingClientRect().left,this.sliderWidth=this.slider.clientWidth,this.pointerWidth=this.pointerL.clientWidth,this.conf.scale||this.slider.classList.add(this.cls.noscale),this.setInitialValues()},t.prototype.setInitialValues=function(){if(this.disabled(this.conf.disabled),this.valRange&&(this.conf.values=s(this.conf)),this.values.start=0,this.values.end=this.conf.range?this.conf.values.length-1:0,this.conf.set&&this.conf.set.length&&n(this.conf)){var t=this.conf.set;this.conf.range?(this.values.start=this.conf.values.indexOf(t[0]),this.values.end=this.conf.set[1]?this.conf.values.indexOf(t[1]):null):this.values.end=this.conf.values.indexOf(t[0])}return this.createScale()},t.prototype.createScale=function(t){this.step=this.sliderWidth/(this.conf.values.length-1);if(this.conf.scale){for(var e=0,s=this.conf.values.length;e<s;e++){var n=i("span"),l=i("ins");n.appendChild(l),this.scale.appendChild(n),n.style.width=e===s-1?0:this.step+"px",this.conf.labels?l.innerHTML=this.conf.values[e]:0!==e&&e!==s-1||(l.innerHTML=this.conf.valuePrefix+this.conf.values[e]),l.style.marginLeft=l.clientWidth/2*-1+"px"}}return this.addEvents()},t.prototype.updateScale=function(){this.step=this.sliderWidth/(this.conf.values.length-1);for(var t=this.slider.querySelectorAll("span"),i=0,e=t.length;i<e;i++)t[i].style.width=this.step+"px";return this.setValues()},t.prototype.addEvents=function(){var t=this.slider.querySelectorAll("."+this.cls.pointer),i=this.slider.querySelectorAll("span");e(document,"mousemove touchmove",this.move.bind(this)),e(document,"mouseup touchend touchcancel",this.drop.bind(this));for(var s=0,n=t.length;s<n;s++)e(t[s],"mousedown touchstart",this.drag.bind(this));for(var s=0,n=i.length;s<n;s++)e(i[s],"click",this.onClickPiece.bind(this));return window.addEventListener("resize",this.onResize.bind(this)),this.setValues()},t.prototype.drag=function(t){if(t.preventDefault(),!this.conf.disabled){var i=t.target.getAttribute("data-dir");return"left"===i&&(this.activePointer=this.pointerL),"right"===i&&(this.activePointer=this.pointerR),this.slider.classList.add("sliding")}},t.prototype.move=function(t){if(this.activePointer&&!this.conf.disabled){var i=("touchmove"===t.type?t.touches[0].clientX:t.pageX)-this.sliderLeft-this.pointerWidth/2;return(i=Math.round(i/this.step))<=0&&(i=0),i>this.conf.values.length-1&&(i=this.conf.values.length-1),this.conf.range?(this.activePointer===this.pointerL&&(this.values.start=i),this.activePointer===this.pointerR&&(this.values.end=i)):this.values.end=i,this.setValues()}},t.prototype.drop=function(){this.activePointer=null},t.prototype.setValues=function(t,i){var e=this.conf.range?"start":"end";return this.conf.values.indexOf(t)>-1&&(this.values[e]=this.conf.values.indexOf(t)),i&&this.conf.values.indexOf(i)>-1&&(this.values.end=this.conf.values.indexOf(i)),this.conf.range&&this.values.start>this.values.end&&(this.values.start=this.values.end),this.pointerL.style.left=this.values[e]*this.step-this.pointerWidth/2+"px",this.conf.range?(this.conf.tooltip&&(this.tipL.innerHTML=this.conf.valuePrefix+this.conf.values[this.values.start],this.tipR.innerHTML=this.conf.valuePrefix+this.conf.values[this.values.end]),this.input.value=this.conf.values[this.values.start]+","+this.conf.values[this.values.end],this.pointerR.style.left=this.values.end*this.step-this.pointerWidth/2+"px"):(this.conf.tooltip&&(this.tipL.innerHTML=this.conf.values[this.values.end]),this.input.value=this.conf.values[this.values.end]),this.values.end>this.conf.values.length-1&&(this.values.end=this.conf.values.length-1),this.values.start<0&&(this.values.start=0),this.selected.style.width=(this.values.end-this.values.start)*this.step+"px",this.selected.style.left=this.values.start*this.step+"px",this.onChange()},t.prototype.onClickPiece=function(t){if(!this.conf.disabled){var i=Math.round((t.clientX-this.sliderLeft)/this.step);return i>this.conf.values.length-1&&(i=this.conf.values.length-1),i<0&&(i=0),this.conf.range&&i-this.values.start<=this.values.end-i?this.values.start=i:this.values.end=i,this.slider.classList.remove("sliding"),this.setValues()}},t.prototype.onChange=function(){var t=this;this.timeout&&clearTimeout(this.timeout),this.timeout=setTimeout(function(){if(t.conf.onChange&&"function"===typeof t.conf.onChange)return t.conf.onChange(t.input.value)},500)},t.prototype.onResize=function(){return this.sliderLeft=this.slider.getBoundingClientRect().left,this.sliderWidth=this.slider.clientWidth,this.updateScale()},t.prototype.disabled=function(t){this.conf.disabled=t,this.slider.classList[t?"add":"remove"]("disabled")},t.prototype.getValue=function(){return this.input.value},t.prototype.destroy=function(){this.input.style.display=this.inputDisplay,this.slider.remove()};var i=function(t,i,e){var s=document.createElement(t);return i&&(s.className=i),e&&2===e.length&&s.setAttribute("data-"+e[0],e[1]),s},e=function(t,i,e){for(var s=i.split(" "),n=0,l=s.length;n<l;n++)t.addEventListener(s[n],e)},s=function(t){var i=[],e=t.values.max-t.values.min;if(!t.step)return console.log("No step defined..."),[t.values.min,t.values.max];for(var s=0,n=e/t.step;s<n;s++)i.push(t.values.min+s*t.step);return i.indexOf(t.values.max)<0&&i.push(t.values.max),i},n=function(t){return!t.set||t.set.length<1?null:t.values.indexOf(t.set[0])<0?null:!t.range||!(t.set.length<2||t.values.indexOf(t.set[1])<0)||null};window.rSlider=t}();

})();

function ags_wc_filters_getDisplayType($filters) {
	if ( $filters.has('.ags-wc-filters-checkbox-list').length ) {
		return 'checkboxes_list';
	}
	if ( $filters.has('.ags-wc-filters-radio-button-list').length || $filters.has('.ags-wc-filters-tagcloud').length ) {
		return 'radio_buttons';
	}
	if ( $filters.has('.ags-wc-filters-dropdown-single').length ) {
		return 'dropdown_single_select';
	}
	if ( $filters.has('.ags-wc-filters-dropdown-multi').length ) {
		return 'dropdown_multi_select';
	}
	if ( $filters.has('.ags-wc-filters-search-container').length ) {
		return 'search';
	}
	if ( $filters.has('.ags-wc-filters-number-range-container').length ) {
		return 'number_range';
	}
	if ( $filters.has('.ags-wc-filters-stars-control').length ) {
		return 'stars';
	}
	if ( $filters.has('.ags-wc-filters-colors').length ) {
		return 'colors';
	}
	if ( $filters.has('.ags-wc-filters-images').length ) {
		return 'images';
	}
}

function ags_wc_filters_set_aliases(aliases) {
	
	window.jQuery('.ags-wc-filters-section[data-ags-wc-filters-query-var]').each(function() {
		var queryVar = window.jQuery(this).attr('data-ags-wc-filters-query-var');
		if (queryVar.substring(0, 14) === 'shopAttribute_') {
			var realQueryVar = 'shopAttribute';
		} else if (queryVar.substring(0, 13) === 'shopTaxonomy_') {
			var realQueryVar = 'shopTaxonomy';
		} else {
			var realQueryVar = queryVar;
		}
		
		var alias = aliases[ realQueryVar ];
		if (alias) {
			if (realQueryVar === 'shopAttribute' || realQueryVar === 'shopTaxonomy') {
				alias = alias.replaceAll(/%s/g, queryVar.substring(realQueryVar.length + 1));
			}
			window.jQuery(this).attr('data-ags-wc-filters-query-var', alias);
		}
	});
	
	delete window.ags_wc_filters_aliases;
	
}
