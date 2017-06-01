<?php echo $header; ?>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [
			<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
			<?php $i++ ?>
			<?php if ($i < count($breadcrumbs)) { ?>
			<?php if ($i == 1) {?>
			<?php } else {?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			},
			<?php }?>
			<?php } else { ?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			}
			<?php }}?>
		]
	}
</script>
	<main>
		<div class="container">
			<nav class="breadcrumb-wrapper transparent z-depth-0">
				<div class="nav-wrapper">
					<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
					<?php $i++ ?>
					<?php if ($i < count($breadcrumbs)) { ?>
					<?php if ($i == 1) {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><i class="material-icons">home</i></a>
					<?php } else {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></a>
					<?php }?>
					<?php } else { ?>
						<span class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></span>
					<?php }}?>
				</div>
			</nav>
			<h1><?php echo $heading_title; ?></h1>
			<?php if ($column_left && $column_right) { ?>
				<?php $main = 's12 l6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; ?>
			<?php } else { ?>
				<?php $main = 's12'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div class="col <?php echo $main; ?> section href-underline">
					<?php echo $content_top; ?>
					 <ul id="accordion" class="collapsible popout" data-collapsible="accordion">
						<li>
							<div class="collapsible-header grey lighten-4 text-bold active"><?php echo $text_checkout_option; ?></div>
							<div id="collapse-checkout-option" class="collapsible-body white"></div>
						</li>
						<?php if (!$logged && $account != 'guest') { ?>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold active"><?php echo $text_checkout_account; ?></div>
							<div id="collapse-payment-address" class="collapsible-body white"></div>
						</li>
						<?php } else { ?>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold"><?php echo $text_checkout_payment_address; ?></div>
							<div id="collapse-payment-address" class="collapsible-body white"></div>
						</li>
						<?php } ?>
						<?php if ($shipping_required) { ?>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold"><?php echo $text_checkout_shipping_address; ?></div>
							<div id="collapse-shipping-address" class="collapsible-body white"></div>
						</li>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold"><?php echo $text_checkout_shipping_method; ?></div>
							<div id="collapse-shipping-method" class="collapsible-body white"></div>
						</li>
						<?php } ?>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold"><?php echo $text_checkout_payment_method; ?></div>
							<div id="collapse-payment-method" class="collapsible-body white"></div>
						</li>
						<li>
							<div class="collapsible-header-disable grey lighten-4 text-bold"><?php echo $text_checkout_confirm; ?></div>
							<div id="collapse-checkout-confirm" class="collapsible-body white"></div>
						</li>
					</ul>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$(document).on('change', 'input[name=\'account\']', function() {
				if ($('#collapse-payment-address').parent().find('div:first')) {
					if (this.value == 'register') {
						$('#collapse-payment-address').parent().find('div:first').html('<?php echo $text_checkout_account; ?>');
					} else {
						$('#collapse-payment-address').parent().find('div:first').html('<?php echo $text_checkout_payment_address; ?>');
					}
				} else {
					if (this.value == 'register') {
						$('#collapse-payment-address').parent().find('div:first').html('<?php echo $text_checkout_account; ?>');
					} else {
						$('#collapse-payment-address').parent().find('div:first').html('<?php echo $text_checkout_payment_address; ?>');
					}
				}
			});

			<?php if (!$logged) { ?>
			$(document).ready(function() {
				$.ajax({
					url: 'index.php?route=checkout/login',
					dataType: 'html',
					success: function(html) {
						$('#collapse-checkout-option').html(html);
						$('#collapse-checkout-option').parent().find('.collapsible-header').html('<?php echo $text_checkout_option; ?>');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
			<?php } else { ?>
			$(document).ready(function() {
			    $.ajax({
			        url: 'index.php?route=checkout/payment_address',
			        dataType: 'html',
			        success: function(html) {
						$('#collapse-checkout-option').parent().removeClass('active');
						$('#collapse-checkout-option').parent().find('.collapsible-header').removeClass('collapsible-header').addClass('collapsible-header-disable');
						$('#collapse-checkout-option').parent().find('.collapsible-body').css('display','');
						$('#collapse-payment-address').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_payment_address; ?>');
						$('#collapse-payment-address').parent().find('.collapsible-body').css('display','block');
						$('#collapse-payment-address').parent().addClass('active');
			            $('#collapse-payment-address').html(html);
						$('html,body').animate({scrollTop:$('#collapse-payment-address').parent().offset().top-50},1150);
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});
			<?php } ?>

			// Checkout
			$(document).delegate('#button-account', 'click', function() {
					$.ajax({
					url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').val(),
					dataType: 'html',
			        success: function(html) {
						$('#collapse-checkout-option').parent().removeClass('active');
						$('#collapse-checkout-option').parent().find('.collapsible-header').removeClass('active');
						$('#collapse-checkout-option').parent().find('.collapsible-body').css('display','');
						$('#collapse-payment-address').parent().find('.collapsible-body').css('display','block');
						$('#collapse-payment-address').parent().addClass('active');
						$('#collapse-payment-address').html(html);
						if ($('input[name=\'account\']:checked').val() == 'register') {
							$('#collapse-payment-address').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_account; ?>');
						} else {
							$('#collapse-payment-address').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_payment_address; ?>');
						}
						$('html,body').animate({scrollTop:$('#collapse-payment-address').parent().offset().top-50},1150);
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Login
			$(document).delegate('#button-login', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/login/save',
			        type: 'post',
			        data: $('#collapse-checkout-option :input'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
							Materialize.toast(json['error']['warning'], 7000, 'rounded');
					   }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Register
			$(document).delegate('#button-register', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/register/save',
			        type: 'post',
			        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address textarea, #collapse-payment-address select'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
							for (i in json['error']) {
								var element = $('#input-payment-' + i.replace('_', '-'));
								if ($(element).parent().hasClass('input-group')) {
									Materialize.toast(json['error']['i'], 7000, 'rounded');
								} else {
									Materialize.toast(json['error']['i'], 7000, 'rounded');
								}
							}
			            } else {
			                <?php if ($shipping_required) { ?>
			                var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').prop('value');
			                if (shipping_address) {
			                    $.ajax({
			                        url: 'index.php?route=checkout/shipping_method',
			                        dataType: 'html',
			                        success: function(html) {
			                            $.ajax({
			                                url: 'index.php?route=checkout/shipping_address',
			                                dataType: 'html',
			                                success: function(html) {
			                                    $('#collapse-shipping-address').html(html);
			                                    $('#collapse-shipping-address').parent().find('div:first').html('<?php echo $text_checkout_shipping_address; ?>');
			                                },
			                                error: function(xhr, ajaxOptions, thrownError) {
			                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                                }
			                            });
										$('#collapse-payment-address').parent().removeClass('active');
										$('#collapse-payment-address').parent().find('div:first').removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-body').css('display','');
										$('#collapse-shipping-method').html(html);
										$('#collapse-shipping-method').parent().find('div:first').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_method; ?>');
										$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','block');
										$('#collapse-shipping-method').parent().addClass('active');
										$('#collapse-payment-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_payment_method; ?>');
										$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
										$('html,body').animate({scrollTop:$('#collapse-shipping-method').parent().offset().top-50},1150);
			                        },
			                        error: function(xhr, ajaxOptions, thrownError) {
			                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                        }
			                    });
			                } else {
			                    $.ajax({
			                        url: 'index.php?route=checkout/shipping_address',
			                        dataType: 'html',
			                        success: function(html) {
										$('#collapse-payment-address').parent().removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-header').removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-body').css('display','');
										$('#collapse-shipping-address').html(html);
										$('#collapse-shipping-address').parent().find('div:first').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_address; ?>');
										$('#collapse-shipping-address').parent().find('.collapsible-body').css('display','block');
										$('#collapse-shipping-address').parent().addClass('active');
										$('#collapse-shipping-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_shipping_method; ?>');
										$('#collapse-payment-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_payment_method; ?>');
										$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
										$('html,body').animate({scrollTop:$('#collapse-shipping-address').parent().offset().top-50},1150);
			                        },
			                        error: function(xhr, ajaxOptions, thrownError) {
			                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                        }
			                    });
			                }
			                <?php } else { ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-shipping-method').parent().removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','');
									$('#collapse-payment-method').html(html);
									$('#collapse-payment-method').parent().find('div:first').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-payment-method').parent().find('.collapsible-body').css('display','block');
									$('#collapse-payment-method').parent().addClass('active');
									$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
									$('html,body').animate({scrollTop:$('#collapse-payment-method').parent().offset().top-50},1150);
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			                <?php } ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_address',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-payment-address').html(html);
									$('#collapse-payment-address').parent().find('div:first').html('<?php echo $text_checkout_payment_address; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Payment Address
			$(document).delegate('#button-payment-address', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/payment_address/save',
			        type: 'post',
			        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
							for (i in json['error']) {
								var element = $('#input-payment-' + i.replace('_', '-'));

								if ($(element).parent()) {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								} else {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								}
							}
			            } else {
			                <?php if ($shipping_required) { ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/shipping_address',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-payment-address').parent().removeClass('active');
									$('#collapse-payment-address').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-payment-address').parent().find('.collapsible-body').css('display','');
									$('#collapse-shipping-address').html(html);
									$('#collapse-shipping-address').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_address; ?>');
									$('#collapse-shipping-address').parent().find('.collapsible-body').css('display','block');
									$('#collapse-shipping-address').parent().addClass('active');
									$('html,body').animate({scrollTop:$('#collapse-shipping-address').parent().offset().top-50},1150);
									$('#collapse-shipping-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_shipping_method; ?>');
									$('#collapse-payment-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			                <?php } else { ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-shipping-method').parent().removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','');
									$('#collapse-payment-method').html(html);
									$('#collapse-payment-method').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-payment-method').parent().find('.collapsible-body').css('display','block');
									$('#collapse-payment-method').parent().addClass('active');
									$('html,body').animate({scrollTop:$('#collapse-payment-method').parent().offset().top-50},1150);
									$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			                <?php } ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_address',
			                    dataType: 'html',
			                    success: function(html) {
			                        $('#collapse-payment-address').html(html);
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Shipping Address
			$(document).delegate('#button-shipping-address', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/shipping_address/save',
			        type: 'post',
			        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
							for (i in json['error']) {
								var element = $('#input-shipping-' + i.replace('_', '-'));
								if ($(element).parent()) {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								} else {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								}
							}
			            } else {
			                $.ajax({
			                    url: 'index.php?route=checkout/shipping_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-shipping-address').parent().removeClass('active');
									$('#collapse-shipping-address').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-shipping-address').parent().find('.collapsible-body').css('display','');
									$('#collapse-shipping-method').html(html);
									$('#collapse-shipping-method').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_method; ?>');
									$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','block');
									$('#collapse-shipping-method').parent().addClass('active');
									$('html,body').animate({scrollTop:$('#collapse-shipping-method').parent().offset().top-50},1150);
									$('#collapse-payment-method').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_confirm; ?>');
			                        $.ajax({
			                            url: 'index.php?route=checkout/shipping_address',
			                            dataType: 'html',
			                            success: function(html) {
			                                $('#collapse-shipping-address').html(html);
			                            },
			                            error: function(xhr, ajaxOptions, thrownError) {
			                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                            }
			                        });
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_address',
			                    dataType: 'html',
			                    success: function(html) {
			                        $('#collapse-payment-address').html(html);
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Guest
			$(document).delegate('#button-guest', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/guest/save',
			        type: 'post',
			        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'][i], 7000, 'rounded');
			                }
							for (i in json['error']) {
								var element = $('#input-payment-' + i.replace('_', '-'));
								if ($(element).parent()) {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								} else {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								}
							}
			            } else {
			                <?php if ($shipping_required) { ?>
			                var shipping_address = $('#collapse-payment-address input[name=\'shipping_address\']:checked').prop('value');
			                if (shipping_address) {
			                    $.ajax({
			                        url: 'index.php?route=checkout/shipping_method',
			                        dataType: 'html',
			                        success: function(html) {
			                            $.ajax({
			                                url: 'index.php?route=checkout/guest_shipping',
			                                dataType: 'html',
			                                success: function(html) {
												$('#collapse-shipping-address').html(html);
												$('#collapse-shipping-address').parent().find('.collapsible-header-disable').html('<?php echo $text_checkout_shipping_address; ?>');
			                                },
			                                error: function(xhr, ajaxOptions, thrownError) {
			                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                                }
			                            });
										$('#collapse-payment-address').parent().removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-header').removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-body').css('display','');
										$('#collapse-shipping-method').html(html);
										$('#collapse-shipping-method').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_method; ?>');
										$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','block');
										$('#collapse-shipping-method').parent().addClass('active');
										$('html,body').animate({scrollTop:$('#collapse-shipping-method').parent().offset().top-50},1150);
										$('#collapse-payment-method').parent().find('div:first').html('<?php echo $text_checkout_payment_method; ?>');
										$('#collapse-checkout-confirm').parent().find('div:first').html('<?php echo $text_checkout_confirm; ?>');
			                        },
			                        error: function(xhr, ajaxOptions, thrownError) {
			                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                        }
			                    });
			                } else {
			                    $.ajax({
			                        url: 'index.php?route=checkout/guest_shipping',
			                        dataType: 'html',
			                        success: function(html) {
										$('#collapse-shipping-address').html(html);
										$('#collapse-payment-address').parent().removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-header').removeClass('active');
										$('#collapse-payment-address').parent().find('.collapsible-body').css('display','');
										$('#collapse-shipping-address').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_address; ?>');
										$('#collapse-shipping-address').parent().find('.collapsible-body').css('display','block');
										$('#collapse-shipping-address').parent().addClass('active');
										$('html,body').animate({scrollTop:$('#collapse-shipping-address').parent().offset().top-50},1150);
										$('#collapse-shipping-method').parent().find('div:first').html('<?php echo $text_checkout_shipping_method; ?>');
										$('#collapse-payment-method').parent().find('div:first').html('<?php echo $text_checkout_payment_method; ?>');
										$('#collapse-checkout-confirm').parent().find('div:first').html('<?php echo $text_checkout_confirm; ?>');
			                        },
			                        error: function(xhr, ajaxOptions, thrownError) {
			                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                        }
			                    });
			                }
			                <?php } else { ?>
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-payment-method').html(html);
									$('#collapse-payment-method').parent().find('div:first').html('<?php echo $text_checkout_payment_method; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			                <?php } ?>
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			// Guest Shipping
			$(document).delegate('#button-guest-shipping', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/guest_shipping/save',
			        type: 'post',
			        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
							for (i in json['error']) {
								var element = $('#input-shipping-' + i.replace('_', '-'));
								if ($(element).parent()) {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								} else {
									Materialize.toast(json['error'][i], 7000, 'rounded');
								}
							}
			            } else {
			                $.ajax({
			                    url: 'index.php?route=checkout/shipping_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-shipping-address').parent().removeClass('active');
									$('#collapse-shipping-address').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-shipping-address').parent().find('.collapsible-body').css('display','');
									$('#collapse-shipping-method').html(html);
									$('#collapse-shipping-method').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_shipping_method; ?>');
									$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','block');
									$('#collapse-shipping-method').parent().addClass('active');
									$('html,body').animate({scrollTop:$('#collapse-shipping-method').parent().offset().top-50},1150);
									$('#collapse-payment-method').parent().find('div:first').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-checkout-confirm').parent().find('div:first').html('<?php echo $text_checkout_confirm; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			$(document).delegate('#button-shipping-method', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/shipping_method/save',
			        type: 'post',
			        data: $('#collapse-shipping-method input[type=\'radio\']:checked, #collapse-shipping-method textarea'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			            	if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
			            } else {
			                $.ajax({
			                    url: 'index.php?route=checkout/payment_method',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-shipping-method').parent().removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-shipping-method').parent().find('.collapsible-body').css('display','');
									$('#collapse-payment-method').html(html);
									$('#collapse-payment-method').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_payment_method; ?>');
									$('#collapse-payment-method').parent().find('.collapsible-body').css('display','block');
									$('#collapse-payment-method').parent().addClass('active');
									$('html,body').animate({scrollTop:$('#collapse-shipping-method').parent().offset().top-50},1150);
									$('#collapse-checkout-confirm').parent().find('div:first').html('<?php echo $text_checkout_confirm; ?>');
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});

			$(document).delegate('#button-payment-method', 'click', function() {
			    $.ajax({
			        url: 'index.php?route=checkout/payment_method/save',
			        type: 'post',
			        data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked, #collapse-payment-method textarea'),
			        dataType: 'json',
			        success: function(json) {
			            if (json['redirect']) {
			                location = json['redirect'];
			            } else if (json['error']) {
			                if (json['error']['warning']) {
								Materialize.toast(json['error']['warning'], 7000, 'rounded');
			                }
			            } else {
			                $.ajax({
			                    url: 'index.php?route=checkout/confirm',
			                    dataType: 'html',
			                    success: function(html) {
									$('#collapse-payment-method').parent().removeClass('active');
									$('#collapse-payment-method').parent().find('.collapsible-header').removeClass('active');
									$('#collapse-payment-method').parent().find('.collapsible-body').css('display','');
									$('#collapse-checkout-confirm').html(html);
									$('#collapse-checkout-confirm').parent().find('.collapsible-header-disable').removeClass('collapsible-header-disable').addClass('collapsible-header active').html('<?php echo $text_checkout_confirm; ?>');
									$('#collapse-checkout-confirm').parent().find('.collapsible-body').css('display','block');
									$('#collapse-checkout-confirm').parent().addClass('active');
								},
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			});
		});
	</script>
<?php echo $footer; ?>