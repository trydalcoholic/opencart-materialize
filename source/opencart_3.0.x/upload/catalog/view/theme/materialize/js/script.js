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

var buttonCart = $('#cart'),
	totalCart = $('#cart-total'),
	modalCartContent = $('#modal-cart-content');

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
						totalCart.html(json['total']);
					}, 100);
					buttonCart.addClass('pulse');
					totalCart.addClass('pulse');
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
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
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key, product_id, quantity, message, cancel) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				setTimeout(function() {
					totalCart.html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');

					M.toast({html: '<span class="toast-undo-remove__text">' + message + '</span><button id="toast-undo-remove__' + key + '" class="btn-flat waves-effect toast-action toast-undo-remove__action cyan-text text-accent-3">' + cancel + '</button>', classes: 'no-padding'});

					$('#toast-undo-remove__' + key + '').click(function() {
						cart.add(product_id, quantity);
						var toastElement = $(this).parent();
						var toastInstance = M.Toast.getInstance(toastElement);
						toastInstance.dismiss();
					});
				}

				if (json['total'] == 0) {
					buttonCart.removeClass('pulse');
					totalCart.removeClass('pulse');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
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
				setTimeout(function () {
					totalCart.html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					modalCartContent.load('index.php?route=common/cart/info #modal-cart-list');
				}
				if (json['total'] == 0) {
					buttonCart.removeClass('pulse');
					totalCart.removeClass('pulse');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
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
					M.toast({html: '<span><i class="material-icons left">info</i>' + json['success'] + '</span>', classes: 'toast-info'});
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
}
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
					$('#compare-btn').removeClass('scale-out');
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
}

$(document).ready(function() {
	var mobileMenu = $('#mobilemenu'),
		cart = $('#cart'),
		btnFixed = $('.fixed-btn-floating__wrapper'),
		lastScroll = 0;

	$(window).scroll(function() {
		var scrollTop = $(this).scrollTop();

		if (scrollTop > lastScroll) {
			cart.addClass('cart-mobilemenu-scroll');
			mobileMenu.addClass('mobilemenu-scroll');
			btnFixed.addClass('fixed-btn-floating__wrapper--scroll');
		} else {
			cart.removeClass('cart-mobilemenu-scroll');
			mobileMenu.removeClass('mobilemenu-scroll');
			btnFixed.removeClass('fixed-btn-floating__wrapper--scroll');
		}

		lastScroll = scrollTop;
	});

	var superfish = $('.sf-menu');

	superfish.superfish({
		hoverClass: 'active',
		delay: 200,
		speed: 'fast',
		cssArrows: false
	});

	var collapsible = $('.collapsible'),
		collapsibleExpandable = $('.collapsible.expandable'),
		tabs = $('.tabs'),
		modal = $('.modal'),
		tooltipped = $('.tooltipped'),
		dropdown = $('.dropdown-trigger'),
		select = $('select');

	collapsible.collapsible();
	collapsibleExpandable.collapsible({
		accordion: false
	});
	tabs.tabs();
	modal.modal();
	tooltipped.tooltip();
	dropdown.dropdown();
	select.formSelect();
	M.updateTextFields();

	var btnSideMenu = $('#btn-side-menu'),
		sideMenu = $('#slide-out'),
		dropdownLk = $('#dropdown-lk');

	btnSideMenu.on('click', function() {
		sideMenu.sidenav();
		sideMenu.load('index.php?route=extension/materialize/common/sidenav');
	});

	dropdownLk.dropdown({
		hover: true,
		coverTrigger: false,
		constrainWidth: false
	});

	var offset = 300,
		scrollTopDuration = 700,
		backToTop = $('#back-to-top');

	$(window).scroll(function(){
		$(this).scrollTop() > offset ? backToTop.removeClass('scale-out') : backToTop.addClass('scale-out');
	});

	backToTop.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({scrollTop:0}, scrollTopDuration);
	});

	var headerNavigation = $('#header-navigation'),
		fixedNavWrapper = $('#fixed-nav-wrapper');

	fixedNavWrapper.height(headerNavigation.outerHeight());

	$(window).resize(function() {
		fixedNavWrapper.height(headerNavigation.outerHeight());
	});

	if (headerNavigation.length) {
		headerNavigation.pushpin({
			top: headerNavigation.offset().top
		});
	}

	var inputSearchHeader = $('#input-search');

	inputSearchHeader.parent().find('label').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search',
			value = inputSearchHeader.val();
		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}
		location = url;
	});

	inputSearchHeader.on('keydown', function(e) {
		if (e.keyCode == 13) {
			inputSearchHeader.parent().find('label').trigger('click');
		}
	});

	var searchClear = $('.search-buttons__clear');

	searchClear.click(function() {searchClear.parent().find('input').val('');});

	$('.gifplay').each(function(el) {
		el += 1;
		var gifPlayImage = $(this).find('.gifplay-image'),
			gifSrc = $(this).find(gifPlayImage).attr('data-src'),
			gifData = $(this).find(gifPlayImage).attr('data-gif'),
			gifPreloader = '<div class="gifplay-preloader-wrapper z-depth-5"><div class="preloader-wrapper active"><div class="spinner-layer spinner-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-yellow"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';

		gifPlayImage.after('<div class="gifplay-button transition scale waves-effect waves-circle waves-darken z-depth-5"></div>')

		var gifPlayButton = $(this).find('.gifplay-button');

		gifPlayButton.click(function() {
			gifPlayImage.attr('src', gifData);
			gifPlayButton.hide();
			gifPlayButton.after(gifPreloader);
			gifPlayImage.on('load', function() {
				$('.gifplay-preloader-wrapper').remove();
			});
			gifPlayImage.addClass('activator');
		});

		gifPlayImage.click(function() {
			gifPlayImage.attr('src', gifSrc);
			gifPlayButton.show();
			gifPlayImage.removeClass('activator');
		});
	});

	$(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function(e) {
		if (e.keyCode == 13) {
			$('#collapse-checkout-option #button-login').trigger('click');
		}
	});

	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				$(this).siblings('.autocomplete-content.dropdown-content').css({
					'opacity': '1',
					'display': 'block'
				});
			}

			// Hide
			this.hide = function() {
				$(this).siblings('.autocomplete-content.dropdown-content').css({
					'opacity': '0',
					'display': 'none'
				});
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li class="waves-effect" data-value="' + json[i]['value'] + '">' + json[i]['img'] + '<span>' + json[i]['label'] + '</span></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('.autocomplete-content.dropdown-content').html(html);
			}

			$(this).after('<ul class="autocomplete-content dropdown-content"></ul>');
			$(this).siblings('.autocomplete-content.dropdown-content').delegate('span', 'click', $.proxy(this.click, this));

		});
	}

	$(document).delegate('.agree', 'click', function(e) {
		e.preventDefault();

		$('#modal-agree').remove();

		var element = this;

		$.ajax({
			url: $(element).attr('href'),
			type: 'get',
			dataType: 'html',
			success: function(data) {
				html  = '<div id="modal-agree" class="modal">';
				html += 	'<div class="modal-content">';
				html += 		'<i class="material-icons modal-action modal-close waves-effect waves-circle close-icon">close</i>';
				html += 		'<h4>' + $(element).text() + '</h4>';
				html += 		'<p>' + data + '</p>';
				html +=		'</div>';
				html += '</div>';
				$('body').append(html);
				$('#modal-agree').modal();
				$('#modal-agree').modal('open');
			}
		});
	});
});