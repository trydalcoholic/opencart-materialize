/**
 * @package     Materialize Template
 * @author      Anton Semenov
 * @copyright   Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license     https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link        https://github.com/trydalcoholic/opencart-materialize
 */

(function($) {
	"use strict";

	let settings = {
		product_grid: 's12 m6',
		page_settings: '',
		contentMTFilter: '#content-mt-filter',
		loader: '<div id="mt-filter-loader" class="loader-wrapper"><div class="showbox"><div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div></div></div>'
	};

	const methods = {
		init: function(options) {
			settings = $.extend(settings, options);

			return this.each(function() {
				let $this = $(this),
					timer = null,
					inputs = $this.find('input, select'),
					keywordInput = $('#mt-filter-keyword');

				inputs.change(function() {
					if (timer) {
						clearTimeout(timer);
					}

					timer = setTimeout(function() {
						let requestData = inputs.filter(function(i, el) {
							return $(el).val() !== '';
						}).serialize();
						let requestDatasadadsdas = inputs.filter(function(i, el) {
							return $(el).val() !== '';
						}).serializeArray();
						console.log(requestDatasadadsdas);

						methods.request(requestData, settings);
					}, 200);
				});

				keywordInput.on('keydown', function(event) {
					if (event.which === 13) {
						keywordInput.change();
					}
				});

				$(document).delegate('.mt-chip__close', 'click', function() {
					let dataClose = $(this).data('mt-filter-id'),
						filterIdClose = $('#' + dataClose + '');

					if (filterIdClose.attr('type') === 'text') {
						filterIdClose.val('').change();
					} else {
						filterIdClose.prop('checked', false).change();
					}
				});
			});
		},
		request: function(data, settings) {
			let contentMtFilter = $(settings['contentMTFilter']);

			return $.ajax({
				url: 'index.php?route=extension/module/mt_filter/filter&' + data + settings['page_settings'] + '&product_grid=' + settings['product_grid'],
				type: 'get',
				dataType: 'json',
				beforeSend: function () {
					$('#mt-filter-loader').remove();

					contentMtFilter.css({
						'opacity': '0.5'
					}).before(settings['loader']);
				},
				success: function (json) {
					setTimeout(function () {
						contentMtFilter.css({
							'opacity': '1'
						}).empty();

						$('#mt-filter-loader').remove();

						contentMtFilter.append(json['products']);
					}, 0); /* todo-materialize This delay is added only to test the preloader */

					methods.setLocation(json['current_location']);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		},
		setLocation: function(location) {
			return history.pushState(null, null, location);
		}
	};

	$.fn.mtFilter = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			return console.error('Method ' + method + ' not found');
		}
	}
})(jQuery);