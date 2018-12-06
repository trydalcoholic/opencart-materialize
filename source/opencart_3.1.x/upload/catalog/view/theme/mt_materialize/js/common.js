function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

/**
 * @package		Materialize Template
 * @author		Anton Semenov
 * @copyright	Copyright (c) 2017 - 2018, Materialize Template. https://github.com/trydalcoholic/opencart-materialize
 * @license		https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link		https://github.com/trydalcoholic/opencart-materialize
 */

$(document).ready(function() {
	var body = $('body');

	/* Materialize Initialization */
	var dropdownLk = $('#dropdown-lk'),
		btnFilter = $('#btn-sort'),
		btnLimit = $('#btn-limit'),
		modal = $('.modal'),
		tooltipped = $('.tooltipped'),
		tooltippedHtml = $('.tooltipped-html'),
		dropdown = $('.dropdown-trigger'),
		select = $('select'),
		datepicker = $('.datepicker'),
		timepicker = $('.timepicker'),
		collapsible = $('.collapsible'),
		collapsibleExpandable = $('.collapsible.expandable'),
		sidenav = $('.sidenav');

	modal.modal();
	tooltipped.tooltip();
	tooltippedHtml.tooltip({
		html: true
	});
	dropdown.dropdown();
	select.formSelect();
	datepicker.datepicker({
		container: 'body'
	});
	timepicker.timepicker({
		container: 'body'
	});
	collapsible.collapsible();
	collapsibleExpandable.collapsible({
		accordion: false
	});

	dropdownLk.dropdown({
		hover: true,
		coverTrigger: false,
		constrainWidth: false
	});

	btnFilter.dropdown({
		alignment: 'right',
		coverTrigger: false,
		constrainWidth: false
	});

	btnLimit.dropdown({
		alignment: 'right',
		coverTrigger: false,
		constrainWidth: false
	});

	sidenav.sidenav();

	/* Categories menu */
	var category = $('#category'),
		categoryIcon = $('#category-icon'),
		menuWrapper = $('#menu-wrapper'),
		menuOverlay = $('#materialize-menu-overlay'),
		megaMenuContent = $('.materialize-menu-content__item--megamenu-content');

	category.click(function() {
		category.toggleClass('active');
		menuWrapper.toggleClass('active');
		categoryIcon.toggleClass('active');
		menuOverlay.toggleClass('active');

		var leftIndent = megaMenuContent.parent().width(),
			menuHeight = menuWrapper.height();

		megaMenuContent.css({
			'left': leftIndent + 'px',
			'width': 'calc(100% - ' + leftIndent + 'px)',
			'maxWidth': 'calc(100% - ' + leftIndent + 'px)',
			'minHeight': menuHeight + 'px'
		});
	});

	/* Search */
	var searchInput = $('#search-input'),
		searchButton = $('#search-button'),
		searchClear = $('#search-clear');

	searchInput.click(function() {
		$(this).addClass('focus');
	});

	searchClear.click(function() {
		$(this).removeClass('active');
		searchInput.addClass('focus').val('').focus();
	});

	searchButton.on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search',
			value = searchInput.val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	searchInput.on('keydown', function(e) {
		if (e.keyCode === 13) {
			searchButton.trigger('click');
		}
	});

	/* Tracking state changes */
	$(document).click(function(e) {
		/* Menu */
		if (!$(e.target).closest(menuWrapper).length && !$(e.target).closest(category).length && menuWrapper.hasClass('active')) {
			category.toggleClass('active');
			menuWrapper.toggleClass('active');
			categoryIcon.toggleClass('active');
			menuOverlay.toggleClass('active');
		}

		/* Search */
		searchInput.on('keyup', function() {
			if ($(this).val().length > 0) {
				searchClear.addClass('active');
			} else {
				searchClear.removeClass('active');
			}
		});

		if (!$(e.target).closest(searchInput).length && !$(e.target).closest(searchClear).length && searchInput.hasClass('focus')) {
			searchInput.removeClass('focus');
		}
	});

	/* Mobile Menu */
	var mobileMenu = $('#mobilemenu'),
		buttonCart = $('#button-cart'),
		/*btnFixed = $('.fixed-btn-floating__wrapper'),*/
		lastScroll = 0;

	$(window).scroll(function() {
		var scrollTop = $(this).scrollTop();

		if (scrollTop > lastScroll) {
			buttonCart.addClass('materialize-cart-mobilemenu-scroll');
			mobileMenu.addClass('materialize-mobilemenu-scroll');
			/*btnFixed.addClass('fixed-btn-floating__wrapper--scroll');*/
		} else {
			buttonCart.removeClass('materialize-cart-mobilemenu-scroll');
			mobileMenu.removeClass('materialize-mobilemenu-scroll');
			/*btnFixed.removeClass('fixed-btn-floating__wrapper--scroll');*/
		}

		lastScroll = scrollTop;
	});

	// Product List
	var	btnListView = $('#list-view'),
		btnGridView = $('#grid-view');

	btnListView.click(function() {
		var productsList = $('.products-list'),
			contentCard = $('#content .col > .card'),
			btnHalfwayFab = contentCard.find('.halfway-fab');

		productsList.each(function() {
			var productId = $(this).data('product-id'),
				imageId = $('#image-product' + productId),
				imageThumb = imageId.data('hor-image');

			imageId.attr('src', imageThumb);
		});

		contentCard.addClass('horizontal');
		btnHalfwayFab.removeClass('btn-large');

		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	btnGridView.click(function() {
		var productsList = $('.products-list'),
			contentCard = $('#content .col > .card'),
			btnHalfwayFab = contentCard.find('.halfway-fab');

		productsList.each(function() {
			var productId = $(this).data('product-id'),
				imageId = $('#image-product' + productId),
				imageSrc = imageId.data('thumb');

			imageId.attr('src', imageSrc);
		});

		contentCard.removeClass('horizontal');
		btnHalfwayFab.addClass('btn-large');

		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');

		localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') === 'list') {
		btnListView.trigger('click');
	} else {
		btnGridView.trigger('click');
	}

	/* Materialize Filters */
	var materializeFilters = $('#materialize-filters');

	if (materializeFilters.length) {
		var parentWrapFilters = $('#' + materializeFilters.parent().attr('id'));

		$(window).resize(function() {
			positionMaterializeFilters();
		});

		if (window.matchMedia('(max-width: 992px)').matches) {
			positionMaterializeFilters();
		}

		function positionMaterializeFilters() {
			if ((window.matchMedia('(max-width: 992px)').matches) && (materializeFilters.hasClass('sidenav') === false)) {
				body.append(materializeFilters);
				materializeFilters.addClass('sidenav').sidenav({draggable: false});

				console.log('Sidenav active'); /* todo-materialize Remove this */
			} else if ((window.matchMedia('(min-width: 993px)').matches) && (materializeFilters.hasClass('sidenav') === true)) {
				parentWrapFilters.prepend(materializeFilters); /* todo-materialize Return to place, depending on sorting */
				materializeFilters.removeClass('sidenav').sidenav().sidenav('close').removeAttr('style');

				console.log('Sidenav disable'); /* todo-materialize Remove this */
			}
		}
	}
});

// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">check</i>' + json['success'] + '</span>', classes: 'toast-success'});

					setTimeout(function () {
						$('#modal-cart').modal();
					}, 100);

					$('#cart').load('index.php?route=common/cart/info');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (getURLVar('route') === 'checkout/cart' || getURLVar('route') === 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');

					setTimeout(function () {
						$('#modal-cart').modal();
					}, 100);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				if (getURLVar('route') === 'checkout/cart' || getURLVar('route') === 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');

					setTimeout(function () {
						$('#modal-cart').modal().modal('open');
					}, 100);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
};

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				if (getURLVar('route') === 'checkout/cart' || getURLVar('route') === 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
};

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">check</i>' + json['success'] + '</span>', classes: 'toast-success'});
				}

				$('#wishlist-total span').html(json['total']);
				$('#wishlist-total').attr('title', json['total']);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {

	}
};

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					M.toast({html: '<span><i class="material-icons left">check</i>' + json['success'] + '</span>', classes: 'toast-success'});

					$('#compare-total').html(json['total']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {

	}
};

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