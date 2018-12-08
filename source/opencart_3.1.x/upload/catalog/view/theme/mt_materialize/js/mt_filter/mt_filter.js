/**
 * @package		Materialize Template
 * @author		Anton Semenov
 * @copyright	Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license		https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link		https://github.com/trydalcoholic/opencart-materialize
 */

(function($) {
	"use strict";

	$.fn.mtFilter = function(options) {
		const settings = $.extend({
			action: '',
			startFilter: false,
			productGrid: 's12 m6',
		}, options);

		return this.each(function() {
			let timer;

			if (options) {
				$.extend(settings, options);
			}

			let mtFilter, inputs, contentMTFilter, slider;

			mtFilter = $(this);

			inputs = $(this).find('.materialize-filters__item--filter-content input, .materialize-filters__item--filter-content select').map(function () {
				return this;
			});

			contentMTFilter = $('#content-mt-filter');
			slider = document.getElementById('slider-prices');

			slider.noUiSlider.on('end', function() {
				startFilter();
			});

			inputs.change(function() {
				startFilter();
			});

			if (options['startFilter'] === true) {
				startFilter();
			}

			function startFilter() {
				clearTimeout(timer);

				timer = setTimeout(function() {
					let productDisplay, form = mtFilter.serializeArray();

					console.log(form);
					/*if (localStorage.getItem('display') === 'list') {
						productDisplay = 'list';
					} else {
						productDisplay = 'grid';
					}

					$.ajax({
						url: 'index.php?route=extension/module/mt_materialize_filter/filter' + options['action'] + '&product_grid=' + options['productGrid'] + '&product_display=' + productDisplay,
						type: 'post',
						data: form,
						dataType: 'json',
						beforeSend: function () {
							contentMTFilter.css({
								'opacity': '0.5',
								'transform': 'translateY(50px)'
							});
							contentMTFilter.before('<div class="loader-wrapper"><div class="showbox"><div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div></div></div>');
						},
						success: function (json) {
							setTimeout(function () {
								contentMTFilter.css({
									'opacity': '1',
									'transform': 'translateY(0)'
								}).empty();
								$('.loader-wrapper').remove();
								contentMTFilter.append(json['products']);
								setLocation(json['current_location']);
							}, 300); /!* todo-materialize This delay is added only to test the preloader *!/

							function setLocation(curLoc) {
								try {
									history.pushState(null, null, curLoc);
									return;
								} catch(e) {}

								location.hash = '#' + curLoc;
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});*/
				}, 200);
			}
		});
	};
})(jQuery);