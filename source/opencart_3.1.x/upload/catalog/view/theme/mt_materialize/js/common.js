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
 * @package		Materialize
 * @author		Anton Semenov
 * @copyright	Copyright (c) 2017 - 2018, Materialize. https://github.com/trydalcoholic/opencart-materialize
 * @license		https://github.com/trydalcoholic/opencart-materialize/blob/master/LICENSE
 * @link		https://github.com/trydalcoholic/opencart-materialize
 */

$(document).ready(function() {
	/* Materialize Initialization */
	var dropdownLk = $('#dropdown-lk'),
		modal = $('.modal'),
		tooltipped = $('.tooltipped');

	modal.modal();
	tooltipped.tooltip();

	dropdownLk.dropdown({
		hover: true,
		coverTrigger: false,
		constrainWidth: false
	});

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
		if (e.keyCode == 13) {
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
	var productsList = $('.products-list'),
		contentCards = $('#content .col'),
		contentCard = $('#content .col > .card'),
		btnListView = $('#list-view'),
		btnGridView = $('#grid-view');

	btnListView.click(function() {
		productsList.each(function() {
			var productId = $(this).attr('id'),
				imageId = $('#image-' + productId),
				imageSrc = imageId.data('thumb'),
				imageThumb = imageId.data('hor-image');

			imageId.attr('src', imageThumb);
		});

		contentCard.addClass('horizontal');

		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	btnGridView.click(function() {
		productsList.each(function() {
			var productId = $(this).attr('id'),
				imageId = $('#image-' + productId),
				imageSrc = imageId.data('thumb'),
				imageThumb = imageId.data('hor-image');

			imageId.attr('src', imageSrc);
		});

		contentCard.removeClass('horizontal');

		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');

		localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		btnListView.trigger('click');
	} else {
		btnGridView.trigger('click');
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
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
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
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
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
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
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