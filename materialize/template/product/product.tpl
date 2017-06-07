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
			<?php if ($column_left && $column_right) { ?>
				<?php $main = 's12 m12 l6'; $image = 's12 m6 l12'; $product_info = 's12 m6 l12'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; $image = 's12 m6'; $product_info = 's12 m6'; ?>
			<?php } else { ?>
				<?php $main = 's12'; $image = 's12 m6 xl5'; $product_info = 's12 m6 xl7'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div class="col <?php echo $main; ?>" itemscope itemtype="http://schema.org/Product">
					<meta itemprop="url" content="<?php echo $url_page; ?>">
					<?php if ($thumb_small) { ?>
					<meta itemprop="image" content="<?php echo $popup; ?>">
					<?php } ?>
					<?php echo $content_top; ?>
					<div class="row">
						<div class="col <?php echo $image; ?>">
							<div class="card-panel img-block">
								<?php if ($special) { ?>
								<span class="white-text badge red lighten-1 product-card-badge-percent z-depth-1"><?php echo $text_percent; ?> <b><?php echo $percent_discount; ?>%</b></span>
								<?php } ?>
								<span class="<?php echo $stock_color ?> white-text badge availability"><?php echo $stock; ?></span>
								<?php if ($thumb || $images) { ?>
									<div class="slider-for photo-swipe" itemscope itemtype="http://schema.org/ImageGallery">
									<?php if ($thumb_small) { ?>
										<figure class="waves-effect waves-light" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
											<a href="<?php echo $popup; ?>" itemprop="contentUrl" data-size="<?php echo $popup_size; ?>">
												<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo str_replace($thumb_small_size, $thumb_size, $thumb_small); ?>" itemprop="thumbnail" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
											</a>
											<figcaption class="center" itemprop="caption description"><?php echo $heading_title; ?></figcaption>
										</figure>
									<?php } ?>
									<?php if ($images) { ?>
										<?php foreach ($images as $image) { ?>
										<figure class="waves-effect waves-light" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
											<a href="<?php echo $image['popup']; ?>" itemprop="contentUrl" data-size="<?php echo $popup_size; ?>">
												<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo str_replace($thumb_small_size, $thumb_size, $image['thumb']); ?>" itemprop="thumbnail" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
											</a>
											<figcaption class="center" itemprop="caption description"><?php echo $heading_title; ?></figcaption>
										</figure>
										<?php } ?>
									<?php } ?>
									</div>
									<?php if ($images) { ?>
									<div class="slider-nav">
										<?php if ($thumb_small) { ?>
										<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $thumb_small; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
										<?php } ?>
										<?php foreach ($images as $image) { ?>
										<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
										<?php } ?>
									</div>
									<?php } ?>
							<?php } ?>
							</div>
						</div>
						<div class="col <?php echo $product_info; ?>">
							<div class="card-panel product-info">
								<div class="row">
									<ul class="user-btn">
										<li><button type="button" class="btn-flat no-padding red-text text-lighten-1" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="material-icons activator">favorite</i></button></li>
										<li><button type="button" class="btn-flat no-padding blue-grey-text text-darken-4" onclick="compare.add('<?php echo $product_id; ?>');" title="<?php echo $button_compare; ?>"><i class="material-icons activator dropdown-button">compare_arrows</i></button></li>
									</ul>
									<button type="button" class="btn-flat no-padding blue-grey-text text-darken-4 share-btn" data-activates="side-share"><i class="material-icons">share</i></button>
								</div>
								<h1 class="center" itemprop="name"><?php echo $heading_title; ?></h1>
								<div class="rating">
									<hr>
									<div>
										<?php if ($review_status) { ?>
										<span class="white">
											<?php for ($i = 1; $i <= 5; $i++) { ?>
												<?php if ($rating < $i) { ?>
													<i class="material-icons">star_border</i>
												<?php } else { ?>
													<i class="material-icons">star</i>
												<?php } ?>
											<?php } ?>
										</span>
											<?php if ($rating > 0) { ?>
												<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="hide">
													<meta itemprop="reviewCount" content="<?php echo $reviewCount; ?>">
													<meta itemprop="ratingValue" content="<?php echo $rating; ?>">
													<meta itemprop="worstRating" content="1">
													<meta itemprop="bestRating" content="5">
													<meta itemprop="itemreviewed" content="<?php echo $heading_title; ?>">
												</div>
											<?php } ?>
										<?php } ?>
										<br>
										<a class="blue-grey-text text-darken-3 text-bold" href="#" onclick="$('a[href=\'#tab-review\']').trigger('click');$('html, body').animate({scrollTop:$('a[href=\'#tab-review\']').offset().top-50},1150);return false;" rel="nofollow"><?php echo $reviews; ?></a>
									</div>
								</div>
								<div class="row valign-wrapper">
									<div class="col s8 flow-text" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
										<?php if ($price) { ?>
											<?php if (!$special) { ?>
												<span class="card-price"><?php echo $price; ?></span>
												<meta itemprop="price" content="<?php echo preg_replace('/[^0-9,.]/','',$price); ?>">
											<?php } else { ?>
												<span class="card-price old-price grey-text"><?php echo $price; ?></span>
												<span class="card-price red-text text-darken-2"><?php echo $special; ?></span>
												<meta itemprop="price" content="<?php echo preg_replace('/[^0-9,.]/','',$special); ?>">
											<?php } ?>
										<?php } ?>
										<meta itemprop="pricecurrency" content="<?php echo $pricecurrency;?>">
										<link itemprop="availability" href="<?php echo $stock_status; ?>">
										<?php if ($product_spec && $product_spec != '0000-00-00') { ?>
										<meta itemprop="priceValidUntil" content="<?php echo $product_spec; ?>">
										<?php } ?>
									</div>
									<div class="col s4 center">
										<?php if($manufacturers_img) { ?>
										<a href="<?php echo $manufacturers; ?>" target="_blank"><?php echo ($manufacturers_img) ? '<img class="responsive-img lazyload" src="'.$img_loader.'" data-src="'.$manufacturers_img.'" title="'.$manufacturer.'" alt="'.$manufacturer.'">' : '' ;?></a>
										<?php } ?>
									</div>
								</div>
								<?php if ($product_spec && $product_spec != '0000-00-00') { ?>
								<div class="section center grey lighten-3 end-promotion">
									<span><i class="material-icons left">info</i><?php echo $text_end_promotion; ?> <span class="text-bold"><?php $product_spec = date_create($product_spec); echo date_format($product_spec, 'd.m.Y'); ?></span></span>
								</div>
								<?php } ?>
								<blockquote class="blockquote-note blue-grey lighten-5 z-depth-1">
									<div class="blockquote-icon blue-grey lighten-4 cursor-default">
										<i class="material-icons">chat</i>
									</div>
									<ul>
										<?php if ($manufacturer) { ?>
										<li>
											<span class="text-bold"><?php echo $text_manufacturer; ?></span>
											<a href="<?php echo $manufacturers; ?>" target="_blank"><span itemprop="brand"><?php echo $manufacturer; ?></span></a>
										</li>
										<?php } ?>
										<?php if ($category_products) { ?>
										<li>
											<span class="text-bold"><?php echo $text_category; ?></span>
											<a href="<?php echo $category_products[0]['href']; ?>"><span itemprop="category"><?php echo $category_products[0]['name']; ?></span></a>
										</li>
										<?php } ?>
										<?php if ($weight > 0) { ?>
										<li>
											<span class="text-bold"><?php echo $text_weight; ?></span>
											<?php echo $weight; ?>
										</li>
										<?php } ?>
										<li>
											<span class="text-bold"><?php echo $text_stock; ?></span>
											<span class="<?php echo $stock_color ?>-text text-darken-1 text-bold"><?php echo $stock; ?></span>
										</li>
									</ul>
								</blockquote>
								<ul class="collection z-depth-1">
									<!-- <li class="collection-item">
										<a class="inherit-text" href="/index.php?route=information/information&information_id=6" target="_blank"><span><i class="material-icons blue-grey-text text-darken-4 left">local_shipping</i>Доставим завтра <span class="text-underline">за 150 рублей</span></span></a>
									</li>
									<li class="collection-item">
										<a class="inherit-text" href="#" target="_blank"><span><i class="material-icons blue-grey-text text-darken-4 left">store</i>Самовывоз сегодня <span class="text-underline">бесплатно</span></span></a>
									</li> -->
									<?php if ($price) { ?>
										<?php if ($special) { ?>
										<li class="collection-item">
											<span><i class="material-icons blue-grey-text text-darken-4 left">local_offer</i><?php echo $text_percent; ?> <span class="deep-orange-text text-accent-3 text-bold"><?php echo $percent_discount; ?>%</span></span>
										</li>
										<?php } ?>
										<?php if ($reward) { ?>
										<li class="collection-item">
											<span><i class="material-icons blue-grey-text text-darken-4 left">account_balance_wallet</i><span class="deep-orange-text text-accent-3 text-bold"><?php echo $reward; ?></span> <?php echo $text_bonus_points; ?></span>
										</li>
										<?php } ?>
									<?php } ?>
								</ul>
								<div class="section">
									<h6 class="center"><?php echo $text_payment_method; ?></h6>
									<img class="responsive-img center-block lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/payments.jpg" alt="Оплата наличными и банковскими картами">
								</div>
								<div id="product">
									<?php if ($options) { ?>
										<h3><?php echo $text_option; ?></h3>
										<?php foreach ($options as $option) { ?>
											<?php if ($option['type'] == 'radio') { ?>
											<div class="section" id="input-option<?php echo $option['product_option_id']; ?>">
												<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>"><?php echo $option['name']; ?></label>
												<ul class="product-option">
												<?php foreach ($option['product_option_value'] as $option_value) { ?>
													<li>
													<?php if ($option_value['image']) { ?><img src="<?php echo $img_loader; ?>" data-src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="responsive-img lazyload"><?php } ?>
													<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="<?php echo $option_value['product_option_value_id']; ?>" class="with-gap">
													<label for="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?></label>
													</li>
												<?php } ?>
												</ul>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'checkbox') { ?>
											<div class="section" id="input-option<?php echo $option['product_option_id']; ?>">
												<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>"><?php echo $option['name']; ?></label>
												<ul class="product-option">
													<?php foreach ($option['product_option_value'] as $option_value) { ?>
													<li>
														<?php if ($option_value['image']) { ?>
														<img src="<?php echo $img_loader; ?>" data-src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="responsive-img lazyload">
														<?php } ?>
														<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="<?php echo $option_value['product_option_value_id']; ?>" class="filled-in">
														<label for="<?php echo $option_value['product_option_value_id']; ?>">
															<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>
														</label>
														<?php } ?>
													</li>
												</ul>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'select') { ?>
											<div class="section">
												<div class="input-field">
													<select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="icons">
														<?php foreach ($option['product_option_value'] as $option_value) { ?>
														<option value="<?php echo $option_value['product_option_value_id']; ?>"<?php if($option_value['image']){ ?> class="left circle" data-icon="<?php echo $option_value['image']; ?>"<?php } ?>><?php echo $option_value['name']; ?><?php if ($option_value['price']) { ?>&nbsp;(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>
														</option>
														<?php } ?>
													</select>
													<label for="input-option<?php echo $option['product_option_id']; ?>" class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>"><?php echo $option['name']; ?></label>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'text') { ?>
											<div class="section">
												<div class="input-field">
													<i class="material-icons prefix">textsms</i>
													<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>">
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'textarea') { ?>
											<div class="section">
												<div class="input-field">
													<i class="material-icons prefix">message</i>
													<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?> for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="materialize-textarea"></textarea>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'file') { ?>
											<div class="section">
												<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
												<div class="file-field input-field">
													<button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" class="btn blue-grey lighten-1">
														<i class="material-icons left">cloud_upload</i>
														<span><?php echo $button_upload; ?></span>
														<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>">
													</button>
													<div class="file-path-wrapper">
														<input class="file-path validate" type="text" placeholder="<?php echo $option['name']; ?>">
													</div>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'date') { ?>
											<div class="section">
												<div class="input-field">
													<i class="material-icons prefix">event</i>
													<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<input type="date" name="option[<?php echo $option['product_option_id']; ?>]" placeholder="<?php echo date('d.m.Y'); ?>" value="" id="input-option<?php echo $option['product_option_id']; ?>" class="datepicker-<?php echo $lang; ?>">
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'time') { ?>
											<div class="section">
												<div class="input-field">
													<i class="material-icons prefix">av_timer</i>
													<label class="text-bold<?php echo ($option['required'] ? ' required' : ''); ?>" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<input id="input-option<?php echo $option['product_option_id']; ?>" class="timepicker-<?php echo $lang; ?>" type="time" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo date('H:i'); ?>">
												</div>
											</div>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									<div class="section">
										<label for="input-quantity"><?php echo $entry_qty; ?></label>
										<div class="input-number">
											<button id="quantity-minus" class="btn waves-effect waves-default grey lighten-3 black-text">-</button>
											<input id="input-quantity" type="number" name="quantity" value="<?php echo $minimum; ?>" size="2" min="<?php echo $minimum; ?>">
											<button id="quantity-plus" class="btn waves-effect waves-default grey lighten-3 black-text">+</button>
										</div>
									</div>
									<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
									<?php if ($minimum > 1) { ?>
									<blockquote class="blockquote-note blue-grey lighten-5 center no-padding">
										<div class="section">
											<?php echo $text_minimum; ?>
										</div>
									</blockquote>
									<?php } ?>
									<div class="section">
										<?php if ($add_cart == 1) { ?>
										<button type="button" id="button-cart" class="btn btn-large waves-effect waves-light red href-underline width-max"><i class="material-icons left">add_shopping_cart</i><?php echo $button_cart; ?></button>
										<?php } else { ?>
										<button type="button" id="button-cart" class="btn btn-large href-underline width-max" disabled="disabled"><i class="material-icons left">add_shopping_cart</i><?php echo $button_cart; ?></button>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-panel">
						<ul class="tabs href-underline">
							<li class="tab"><a class="blue-grey-text text-darken-3 text-bold waves-effect waves-default active" href="#description-product" rel="nofollow"><?php echo $tab_description; ?></a></li>
							<?php if ($attribute_groups) { ?>
							<li class="tab"><a class="blue-grey-text text-darken-3 text-bold waves-effect waves-default" href="#tab-specification" rel="nofollow"><?php echo $tab_attribute; ?></a></li>
							<?php } ?>
							<?php if ($customtabs) { ?>
								<?php foreach ($customtabs as $key=>$customtab) { ?>
								<li class="tab"><a class="blue-grey-text text-darken-3 text-bold waves-effect waves-default" href="#tabcustom-<?php echo $key?>" rel="nofollow"><?php echo $customtab['title']; ?></a></li>
								<?php } ?>
							<?php } ?>
							<?php if ($review_status) { ?>
							<li class="tab"><a class="blue-grey-text text-darken-3 text-bold waves-effect waves-default" href="#tab-review" rel="nofollow"><?php echo $tab_review; ?></a></li>
							<?php } ?>
						</ul>
						<div id="description-product" class="section description-product text-justify photo-swipe" itemprop="description">
							<?php echo $description; ?>
						</div>
						<?php if ($attribute_groups) { ?>
						<div id="tab-specification" class="section">
							<ul class="collapsible" data-collapsible="accordion">
							<?php foreach ($attribute_groups as $attribute_group) { ?>
								<li>
									<div class="collapsible-header grey lighten-4 attribute-collapsible"><span class="text-bold truncate"><?php echo $attribute_group['name']; ?></span></div>
									<div class="collapsible-body no-padding">
										<table class="bordered striped centered">
											<tbody>
												<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
												<tr>
													<td><span class="text-bold"><?php echo $attribute['name']; ?></span></td>
													<td><?php echo $attribute['text']; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</li>
							<?php } ?>
							</ul>
						</div>
						<?php } ?>
						<?php if ($customtabs) { ?>
							<?php foreach ($customtabs as $key=>$customtab) { ?>
							<div id="tabcustom-<?php echo $key?>" class="section">
								<?php echo $customtab['description']; ?>
							</div>
						<?php }} ?>
						<?php if ($review_status) { ?>
						<div id="tab-review" class="section">
							<ul class="collapsible" data-collapsible="accordion">
								<li>
									<div class="collapsible-header"><span><i class="material-icons">mode_edit</i><?php echo $text_write; ?></span></div>
									<div class="collapsible-body no-padding">
										<div class="row">
											<div class="col s12 offset-l3 l6">
												<div id="form-review" class="card-panel z-depth-2">
													<?php if ($review_guest) { ?>
													<div class="input-field">
														<i class="material-icons prefix">account_circle</i>
														<input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="validate">
														<label for="input-name"><?php echo $entry_name; ?></label>
													</div>
													<div class="input-field">
														<i class="material-icons prefix">mode_edit</i>
														<textarea name="text" rows="5" id="input-review" class="materialize-textarea"></textarea>
														<label for="input-review"><?php echo $entry_review; ?></label>
														<small><?php echo $text_note; ?></small>
													</div>
													<div class="section">
														<div class="rating-input center">
															<input id="rating-1" type="radio" name="rating" value="1">
															<label for="rating-1"><i class="material-icons">star</i></label>
															<input id="rating-2" type="radio" name="rating" value="2">
															<label for="rating-2"><i class="material-icons">star</i></label>
															<input id="rating-3" type="radio" name="rating" value="3">
															<label for="rating-3"><i class="material-icons">star</i></label>
															<input id="rating-4" type="radio" name="rating" value="4">
															<label for="rating-4"><i class="material-icons">star</i></label>
															<input id="rating-5" type="radio" name="rating" value="5">
															<label for="rating-5"><i class="material-icons">star</i></label>
														</div>
													</div>
													<?php echo $captcha; ?>
													<div class="flex-reverse">
														<button type="button" id="button-review" class="btn waves-effect waves-light red right"><?php echo $button_continue; ?></button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } else { ?>
										<?php echo $text_login; ?>
									<?php } ?>
								</li>
							</ul>
							<div id="review"></div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php echo $column_right; ?>
			</div>
			<?php if ($products) { ?>
			<h3><?php echo $text_related; ?></h3>
			<div class="row slick-goods">
				<?php foreach ($products as $product) { ?>
				<div class="col">
					<div class="card sticky-action large hoverable href-underline">
					<?php if ($product['special']) { ?><span class="white-text badge red lighten-1 percent"><?php echo $text_percent; ?> <?php echo $product['percent_discount']; ?>%</span><?php } ?>
						<div class="card-image">
							<span><i class="material-icons small right activator">more_vert</i></span>
							<a href="<?php echo $product['href']; ?>"><img class="lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></a>
						</div>
						<div class="card-content center-align">
							<span class="card-title"><a href="<?php echo $product['href']; ?>" class="grey-text text-darken-4"><?php echo $product['name']; ?></a></span>
						</div>
						<div class="card-action center-align grey lighten-5">
							<button class="btn btn-floating btn-large waves-effect waves-light red add-cart" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="material-icons">add_shopping_cart</i></button>
							<?php if ($product['price']) { ?>
								<?php if (!$product['special']) { ?>
									<span class="card-price"><?php echo $product['price']; ?></span>
								<?php } else { ?>
									<span class="card-price old-price grey-text"><?php echo $product['price']; ?></span>
									<span class="card-price red-text text-darken-2"><?php echo $product['special']; ?></span>
								<?php } ?>
								<?php if ($product['tax']) { ?>
									<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
								<?php } ?>
							<?php } ?>
							<div class="rating">
								<hr>
								<span class="grey lighten-5">
									<?php if ($product['rating']): { ?>
										<?php for ($i = 1; $i <= 5; $i++) { ?>
											<?php if ($product['rating'] < $i) { ?>
												<i class="material-icons">star_border</i>
											<?php } else { ?>
												<i class="material-icons">star</i>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									<?php else: ?>
										<i class="material-icons">star_border</i>
										<i class="material-icons">star_border</i>
										<i class="material-icons">star_border</i>
										<i class="material-icons">star_border</i>
										<i class="material-icons">star_border</i>
									<?php endif ?>
								</span>
							</div>
							<a href="<?php echo $product['href']; ?>" class="btn waves-effect waves-light red"><?php echo $text_more_detailed; ?></a>
						</div>
						<div class="card-reveal">
							<span class="card-title"><a href="<?php echo $product['href']; ?>" class="grey-text text-darken-4"><?php echo $product['name']; ?></a><i class="material-icons">close</i></span>
							<p><?php echo $product['description']; ?></p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if ($tags) { ?>
			<div class="row">
				<div class="col s12 href-underline">
					<span class="blue-text text-lighten-1"><?php echo $text_tags; ?></span>
					<?php for ($i = 0; $i < count($tags); $i++) { ?>
						<?php if ($i < (count($tags) - 1)) { ?>
						<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>,
						<?php } else { ?>
						<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<?php echo $content_bottom; ?>
		</div>
	</main>
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true"><div class="pswp__bg"></div><div class="pswp__scroll-wrap"><div class="pswp__container"><div class="pswp__item"></div><div class="pswp__item"></div><div class="pswp__item"></div></div><div class="pswp__ui pswp__ui--hidden"><div class="pswp__top-bar"><div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="Закрыть (Esc)"></button><button class="pswp__button pswp__button--share" title="Поделиться"></button><button class="pswp__button pswp__button--fs" title="Включить полноэкранный режим"></button><button class="pswp__button pswp__button--zoom" title="Увеличить/уменьшить"></button><div class="pswp__preloader"><div class="pswp__preloader__icn"><div class="pswp__preloader__cut"><div class="pswp__preloader__donut"></div></div></div></div></div><div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap"><div class="pswp__share-tooltip"></div></div><button class="pswp__button pswp__button--arrow--left" title="Предыдущая (стрелка влево)"></button><button class="pswp__button pswp__button--arrow--right" title="Следующая (стрелка вправо)"></button><div class="pswp__caption"><div class="pswp__caption__center"></div></div></div></div></div>
	<ul id="side-share" class="side-nav href-underline">
		<li>
			<a class="waves-effect waves-default" href="https://vk.com/share.php?url=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="vk" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M7.828 12.526h.957s.288-.032.436-.19c.14-.147.14-.42.14-.42s-.02-1.284.58-1.473c.59-.187 1.34 1.24 2.14 1.788.61.42 1.07.33 1.07.33l2.14-.03s1.12-.07.59-.95c-.04-.07-.3-.65-1.58-1.84-1.34-1.24-1.16-1.04.45-3.19.98-1.31 1.38-2.11 1.25-2.45-.11-.32-.84-.24-.84-.24l-2.4.02s-.18-.02-.31.06-.21.26-.21.26-.38 1.02-.89 1.88C10.27 7.9 9.84 8 9.67 7.88c-.403-.26-.3-1.053-.3-1.62 0-1.76.27-2.5-.52-2.69-.26-.06-.454-.1-1.123-.11-.86-.01-1.585.006-1.996.207-.27.135-.48.434-.36.45.16.02.52.098.71.358.25.337.24 1.09.24 1.09s.14 2.077-.33 2.335c-.33.174-.77-.187-1.73-1.837-.49-.84-.86-1.78-.86-1.78s-.07-.17-.2-.27c-.15-.11-.37-.15-.37-.15l-2.29.02s-.34.01-.46.16c-.11.13-.01.41-.01.41s1.79 4.19 3.82 6.3c1.86 1.935 3.97 1.81 3.97 1.81z"/>
					</svg>
				</span>
				VK
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://www.facebook.com/sharer.php?u=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="facebook" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M15.117 0H.883C.395 0 0 .395 0 .883v14.234c0 .488.395.883.883.883h7.663V9.804H6.46V7.39h2.086V5.607c0-2.066 1.262-3.19 3.106-3.19.883 0 1.642.064 1.863.094v2.16h-1.28c-1 0-1.195.48-1.195 1.18v1.54h2.39l-.31 2.42h-2.08V16h4.077c.488 0 .883-.395.883-.883V.883C16 .395 15.605 0 15.117 0" fill-rule="nonzero"/>
					</svg>
				</span>
				Facebook
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://plus.google.com/share?url=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="googleplus" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M5.09 7.273v1.745h2.89c-.116.75-.873 2.197-2.887 2.197-1.737 0-3.155-1.44-3.155-3.215S3.353 4.785 5.09 4.785c.99 0 1.652.422 2.03.786l1.382-1.33c-.887-.83-2.037-1.33-3.41-1.33C2.275 2.91 0 5.19 0 8s2.276 5.09 5.09 5.09c2.94 0 4.888-2.065 4.888-4.974 0-.334-.036-.59-.08-.843H5.09zm10.91 0h-1.455V5.818H13.09v1.455h-1.454v1.454h1.455v1.455h1.46V8.727H16"/>
					</svg>
				</span>
				Google+
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="odnoklassniki" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M9.67 11.626c.84-.19 1.652-.524 2.4-.993.564-.356.734-1.103.378-1.668-.356-.566-1.102-.737-1.668-.38-1.692 1.063-3.87 1.063-5.56 0-.566-.357-1.313-.186-1.668.38-.356.566-.186 1.312.38 1.668.746.47 1.556.802 2.397.993l-2.31 2.31c-.48.47-.48 1.237 0 1.71.23.236.54.354.85.354.31 0 .62-.118.85-.354L8 13.376l2.27 2.27c.47.472 1.237.472 1.71 0 .472-.473.472-1.24 0-1.71l-2.31-2.31zM8 8.258c2.278 0 4.13-1.852 4.13-4.128C12.13 1.852 10.277 0 8 0S3.87 1.852 3.87 4.13c0 2.276 1.853 4.128 4.13 4.128zM8 2.42c-.942 0-1.71.767-1.71 1.71 0 .942.768 1.71 1.71 1.71.943 0 1.71-.768 1.71-1.71 0-.943-.767-1.71-1.71-1.71z"/>
					</svg>
				</span>
				Odnoklassniki
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://twitter.com/share?url=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="twitter" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M16 3.038c-.59.26-1.22.437-1.885.517.677-.407 1.198-1.05 1.443-1.816-.634.37-1.337.64-2.085.79-.598-.64-1.45-1.04-2.396-1.04-1.812 0-3.282 1.47-3.282 3.28 0 .26.03.51.085.75-2.728-.13-5.147-1.44-6.766-3.42C.83 2.58.67 3.14.67 3.75c0 1.14.58 2.143 1.46 2.732-.538-.017-1.045-.165-1.487-.41v.04c0 1.59 1.13 2.918 2.633 3.22-.276.074-.566.114-.865.114-.21 0-.41-.02-.61-.058.42 1.304 1.63 2.253 3.07 2.28-1.12.88-2.54 1.404-4.07 1.404-.26 0-.52-.015-.78-.045 1.46.93 3.18 1.474 5.04 1.474 6.04 0 9.34-5 9.34-9.33 0-.14 0-.28-.01-.42.64-.46 1.2-1.04 1.64-1.7z" fill-rule="nonzero"/>
					</svg>
				</span>
				Twitter
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://telegram.me/share/url?url=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="telegram" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M12.793 10.69c.57-1.56 2.66-7.49 2.994-9.044.38-1.76-.414-1.93-2.22-1.34-1.805.59-6.435 2.305-7.215 2.582-.78.277-4.573 1.552-5.36 1.932-1.606.862-.825 2.177.97 2.86 5.37 2.577 3.845 1.264 6.242 6.032.493 1.218 1.656 3.293 2.77 1.724.586-.892 1.37-3.52 1.82-4.747z" fill-rule="nonzero"/>
					</svg>
				</span>
				Telegram
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="whatsapp://send?text=<?php echo str_replace(' ', '%20', htmlspecialchars($heading_title)).'%20'.urlencode($url_page); ?>" data-action="share/whatsapp/share" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="whatsapp" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M11.665 9.588c-.2-.1-1.177-.578-1.36-.644-.182-.067-.315-.1-.448.1-.132.197-.514.643-.63.775-.116.13-.232.14-.43.05-.2-.1-.842-.31-1.602-.99-.592-.53-.99-1.18-1.107-1.38-.116-.2-.013-.31.087-.41.09-.09.2-.23.3-.35.098-.12.13-.2.198-.33.066-.14.033-.25-.017-.35-.05-.1-.448-1.08-.614-1.47-.16-.39-.325-.34-.448-.34-.115-.01-.248-.01-.38-.01-.134 0-.35.05-.532.24-.182.2-.696.68-.696 1.65s.713 1.91.812 2.05c.1.13 1.404 2.13 3.4 2.99.476.2.846.32 1.136.42.476.15.91.13 1.253.08.383-.06 1.178-.48 1.344-.95.17-.47.17-.86.12-.95-.05-.09-.18-.14-.38-.23M8.04 14.5h-.01c-1.18 0-2.35-.32-3.37-.92l-.24-.143-2.5.65.67-2.43-.16-.25c-.66-1.05-1.01-2.26-1.01-3.506 0-3.63 2.97-6.59 6.628-6.59 1.77 0 3.43.69 4.68 1.94 1.25 1.24 1.94 2.9 1.94 4.66-.003 3.63-2.973 6.59-6.623 6.59M13.68 2.3C12.16.83 10.16 0 8.03 0 3.642 0 .07 3.556.067 7.928c0 1.397.366 2.76 1.063 3.964L0 16l4.223-1.102c1.164.63 2.474.964 3.807.965h.004c4.39 0 7.964-3.557 7.966-7.93 0-2.117-.827-4.11-2.33-5.608"/>
					</svg>
				</span>
				WhatsApp
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="viber://forward?text=<?php echo str_replace(' ', '%20', htmlspecialchars($heading_title)).'%20'.urlencode($url_page); ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="viber" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M13.874 1.56C13.476 1.194 11.87.027 8.29.01c0 0-4.22-.253-6.277 1.634C.868 2.79.465 4.464.423 6.544.38 8.62.325 12.514 4.08 13.57h.003l-.003 1.612s-.023.652.406.785c.52.16.824-.336 1.32-.87.273-.293.648-.724.932-1.054 2.567.216 4.542-.277 4.766-.35.518-.17 3.45-.544 3.928-4.438.492-4.015-.238-6.553-1.558-7.698zm.435 7.408c-.41 3.25-2.79 3.457-3.22 3.597-.19.06-1.93.492-4.11.35 0 0-1.63 1.96-2.13 2.47-.08.08-.18.11-.24.096-.09-.02-.11-.12-.11-.27l.01-2.67c-.01 0 0 0 0 0-3.18-.89-2.99-4.2-2.95-5.94.03-1.73.36-3.15 1.33-4.11C4.63.91 8.22 1.15 8.22 1.15c3.028.01 4.48.923 4.815 1.23 1.116.955 1.685 3.243 1.27 6.595zM5.16 3.32c.162 0 .307.073.42.207.002.002.387.464.553.69.157.213.367.553.474.743.19.34.07.688-.115.832l-.377.3c-.19.152-.167.436-.167.436s.56 2.105 2.64 2.635c0 0 .283.026.436-.164l.3-.38c.142-.19.49-.31.83-.12.19.1.53.31.744.47.226.16.688.55.69.55.22.18.27.46.12.74v.01c-.154.27-.36.52-.622.76h-.005c-.21.18-.42.28-.63.3-.02 0-.05.01-.09 0-.09 0-.18-.02-.27-.04v-.01c-.32-.09-.85-.32-1.73-.81-.57-.32-1.05-.64-1.46-.97-.21-.17-.43-.36-.65-.58L6.2 8.9l-.02-.02-.02-.02c-.22-.22-.41-.44-.58-.653-.32-.406-.64-.885-.96-1.46-.49-.88-.72-1.41-.81-1.73H3.8c-.03-.09-.05-.18-.04-.27-.01-.04 0-.07 0-.093.02-.2.126-.41.305-.63h.003c.237-.26.492-.47.764-.622.11-.06.22-.09.32-.09h.01zm2.73-.456h.078l.05.002h.013l.06.003h.34l.09.01h.05l.1.01h.02l.07.01h.01l.05.01c.03 0 .05.01.07.01h.06l.05.02.04.01.04.01.02.01h.03l.03.01h.02l.05.01.03.01.03.01.04.01.02.01c.02 0 .04.01.06.01l.03.01.03.01.08.03.04.02.09.04.03.01.03.01.06.03.04.01.02.01.05.02.02.01.04.02.03.01.03.02.04.02.03.02.02.01.04.02.03.02.05.03.03.01.05.03.01.01.03.02.06.05.03.02.03.02.02.01.03.02.05.05.04.03.03.02.01.01.02.01.05.04.03.03.02.02.03.02.03.02.02.01.08.08.04.04.09.09.02.02c.01.01.03.03.04.05l.02.02.11.13.03.04c.01.01.01.02.02.02l.06.09.03.03.06.08.05.08.03.06.04.07.03.06.01.02.02.04.05.1.05.1.02.05c.04.09.07.18.11.28.05.13.09.27.12.42.03.11.05.21.07.32l.02.18.03.2c.01.08.02.17.02.25.01.08.01.16.01.24v.17c0 .01-.005.02-.01.03-.01.02-.02.03-.04.05-.014.01-.033.03-.053.03-.02.01-.04.01-.06.01h-.03c-.02 0-.04-.01-.06-.02-.02-.01-.04-.02-.05-.04-.01-.02-.03-.04-.04-.06-.01-.02-.02-.04-.02-.06V6.9c-.01-.14-.02-.284-.04-.426-.01-.098-.03-.19-.04-.28 0-.05-.01-.098-.02-.14l-.02-.1-.024-.09-.01-.06-.03-.1c-.02-.08-.05-.16-.08-.24-.02-.06-.04-.11-.07-.16l-.02-.05-.09-.18-.02-.03c-.04-.09-.09-.18-.15-.26l-.03-.05H11l-.043-.06c-.036-.06-.076-.11-.12-.16l-.083-.1-.01-.01-.03-.038-.024-.03-.05-.05-.01-.02-.047-.04-.03-.03-.055-.05-.027-.025-.03-.03-.01-.01c-.01-.01-.03-.03-.05-.04L10.33 4l-.02-.01-.04-.03-.05-.04-.03-.024-.02-.01-.04-.036c0-.01-.01-.01-.02-.01l-.02-.02-.01-.01V3.8l-.02-.01-.04-.025-.03-.02-.05-.03-.04-.03-.02-.01-.02-.01H9.8l-.013-.01-.044-.023-.005-.01-.02-.01-.03-.015H9.68l-.03-.01-.017-.01-.03-.01-.007-.007-.02-.01-.035-.02-.02-.01-.06-.02-.05-.02-.09-.01-.03-.02c-.01-.006-.02-.01-.03-.01l-.02-.01c-.02-.007-.03-.01-.05-.02l-.02-.01h-.02l-.04-.02-.02-.01-.03-.01H9c-.005 0-.012-.003-.02-.005h-.06l-.03-.01h-.01l-.03-.01h-.027c-.017-.01-.03-.01-.047-.01l-.006-.01-.04-.01c-.02-.01-.037-.01-.056-.01l-.03-.01-.033-.01-.03-.01-.04-.01H8.5l-.12-.018h-.06l-.078-.01h-.05l-.046-.006h-.02l-.036-.01H7.9l-.007-.01h-.04c-.02 0-.043-.01-.06-.02-.02-.01-.04-.02-.054-.04l-.02-.03c-.02-.02-.02-.04-.03-.06-.01-.02-.01-.04-.01-.06 0-.02 0-.04.01-.06.01-.02.02-.04.04-.05.01-.02.03-.03.05-.04.02-.01.04-.02.06-.02h.04zm.37 1.05l.024.002.04.004c.006 0 .012 0 .02.002.015 0 .03.003.05.004l.04.005.016.01.03.01.032.01.03.01h.02l.028.01.047.01.037.01.018.01h.048l.08.02.03.01.03.01.03.01s.01 0 .01.01l.03.01.03.01.03.01c.01 0 .02.01.03.01.005 0 .01.01.017.01l.043.02h.02l.06.02.033.02.03.02.073.03.04.01.02.02c.03.01.06.03.09.04l.032.02.032.02.033.02c.03.02.054.03.08.05l.02.01.027.02.015.01.05.03.025.02.043.03.02.01.02.01.03.02.04.03c.01.01.015.01.023.02.006.01.01.01.017.02l.022.02.024.02.02.02.03.03.02.02.01.01.06.06.01.01c0 .01.01.02.02.02l.01.01.03.03.02.03.02.02.03.04.03.03.06.08.01.02.04.05.01.02.01.02.01.02.01.02c.01.01.01.02.02.04l.03.05.01.01.02.04.02.03c.01.01.01.02.02.03l.02.03.02.04.02.04.01.03c.01.03.03.05.04.08 0 .01.01.02.01.03l.03.08.04.13c0 .01.01.03.01.04l.03.09.03.12.03.16c.01.05.01.09.02.14.01.08.02.16.02.24l.01.14v.11c0 .01 0 .02-.01.03L10.9 7c-.02.015-.03.03-.05.04-.02.01-.04.02-.06.027-.02.01-.05.01-.07.01-.02 0-.04-.01-.06-.02-.01 0-.02-.01-.03-.014-.02-.01-.04-.026-.05-.044-.02-.02-.03-.04-.03-.06l-.01-.03V6.7c0-.088-.01-.17-.02-.256-.01-.09-.03-.19-.05-.28-.02-.06-.03-.12-.05-.174l-.02-.06-.02-.05-.01-.02-.03-.08-.03-.06-.05-.1-.046-.08v-.01l-.02-.032-.02-.025-.03-.05-.03-.04-.06-.08c-.03-.04-.06-.08-.094-.118-.01-.01-.02-.02-.02-.03l-.02-.02-.01-.01-.02-.01-.02-.018V5l-.08-.076-.05-.045v-.01l-.02-.02-.025-.02-.01-.01c0-.01-.01-.01-.02-.01l-.03-.01-.01-.01-.04-.03-.01-.01-.01-.01c-.008-.01-.015-.01-.02-.01l-.04-.03-.01-.01-.04-.02-.007-.01-.03-.02-.02-.01-.02-.02-.02-.02h-.01c-.02-.02-.04-.03-.07-.04l-.03-.02-.02-.01-.01-.01-.03-.02-.03-.01-.04-.02-.03-.01-.01-.01-.037-.01v-.01l-.06-.02-.04-.02-.02-.01h-.04c-.02-.01-.03-.01-.05-.02H8.8l-.03-.01h-.03l-.03-.01-.02-.01h-.04l-.04-.01-.02-.01h-.11l-.046-.01H8.2l-.03-.01c-.02-.01-.04-.02-.06-.04-.01-.02-.03-.04-.04-.06-.01-.02-.02-.04-.02-.06v-.06c.003-.03.01-.05.02-.07.005-.01.01-.02.02-.03.012-.02.03-.04.05-.05.01-.01.02-.01.03-.02.02-.01.04-.01.06-.01h.04zM8.562 5c.01 0 .02 0 .03.002.01 0 .02 0 .03.002l.034.003c.07.006.142.016.212.03l.07.016.017.005.076.02.04.013.03.01c.03.01.06.03.09.04l.01.01.04.02.06.03.02.01c.01.01.02.01.03.02.01.01.03.02.04.03.04.02.07.05.1.07l.07.06.06.06.04.05.02.02.02.02.03.04.06.09.05.09.04.08.03.07c.03.07.04.13.06.2.02.06.03.13.04.19l.01.1.01.09v.04c0 .03-.01.05-.02.07-.01.02-.03.05-.05.06-.02.02-.04.03-.07.04-.02.01-.04.01-.06.01-.02 0-.04 0-.06-.01l-.07-.03c-.02-.02-.04-.03-.06-.06-.01-.02-.02-.04-.03-.07v-.11l-.01-.07-.01-.08-.01-.07-.01-.04c0-.01-.01-.03-.01-.04-.02-.08-.06-.16-.1-.24l-.04-.04-.03-.04-.03-.03-.01-.02-.05-.04-.04-.04-.04-.03c-.01-.01-.02-.01-.04-.02l-.06-.04-.04-.02-.02-.01h-.01L9 5.54l-.06-.02-.06-.01h-.05L8.8 5.5l-.024-.005h-.03l-.04-.01h-.17l-.01-.05H8.5c-.02-.003-.036-.01-.053-.02-.023-.014-.043-.03-.06-.053-.012-.02-.023-.04-.03-.06-.005-.02-.008-.04-.008-.06 0-.025 0-.05.01-.076s.02-.047.04-.066l.04-.03c.02-.01.04-.02.06-.02L8.54 5h.02z"/>
					</svg>
				</span>
				Viber
			</a>
		</li>
		<li>
			<a class="waves-effect waves-default" href="https://web.skype.com/share?url=<?php echo $url_page; ?>" rel="nofollow" target="_blank">
				<span class="side-share__item">
					<svg class="skype" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
						<path d="M8.035 12.6c-2.685 0-3.885-1.322-3.885-2.313 0-.51.374-.865.89-.865 1.15 0 .85 1.653 2.995 1.653 1.096 0 1.703-.597 1.703-1.208 0-.368-.18-.775-.904-.954l-2.387-.597C4.524 7.833 4.175 6.79 4.175 5.812c0-2.034 1.91-2.798 3.704-2.798 1.65 0 3.6.916 3.6 2.136 0 .523-.46.827-.97.827-.98 0-.8-1.36-2.78-1.36-.98 0-1.53.444-1.53 1.08 0 .636.77.84 1.44.993l1.76.392c1.93.433 2.42 1.566 2.42 2.633 0 1.652-1.27 2.886-3.82 2.886m7.4-3.26l-.02.09-.03-.16c.01.03.03.05.04.08.08-.45.12-.91.12-1.37 0-1.02-.2-2.01-.6-2.95-.38-.9-.93-1.71-1.62-2.4-.7-.69-1.5-1.24-2.4-1.62C10.01.59 9.02.39 8 .39c-.48 0-.964.047-1.43.137l.08.04-.16-.023.08-.016C5.927.183 5.205 0 4.472 0 3.278 0 2.155.466 1.31 1.313.465 2.16 0 3.286 0 4.483c0 .763.195 1.512.563 2.175l.013-.083.028.16-.04-.077c-.076.43-.115.867-.115 1.305 0 1.022.2 2.014.59 2.948.38.91.92 1.72 1.62 2.41.69.7 1.5 1.24 2.4 1.63.93.4 1.92.6 2.94.6.44 0 .89-.04 1.32-.12l-.08-.04.16.03-.09.02c.67.38 1.42.58 2.2.58 1.19 0 2.31-.46 3.16-1.31.84-.84 1.31-1.97 1.31-3.17 0-.76-.2-1.51-.57-2.18" fill-rule="nonzero"/>
					</svg>
				</span>
				Skype
			</a>
		</li>
	</ul>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			// Share side
			$('.share-btn').sideNav({edge:'right'});
			// Photo slider
			$('.slider-for').not('.slick-initialized').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: true,
				fade: true,
				asNavFor: '.slider-nav'
			});
			$('.slider-nav').not('.slick-initialized').slick({
				slidesToShow: 4,
				asNavFor: '.slider-for',
				centerMode: false,
				arrows: false,
				infinite: false,
				focusOnSelect: true
			});
			// Goods slider
			$('.slick-goods').not('.slick-initialized').slick({
				dots: true,
				infinite: true,
				speed: 300,
				autoplay: true,
				autoplaySpeed: 2000,
				slidesToShow: 3,
				slidesToScroll: 3,
				responsive: [
					{
						breakpoint: 921,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 601,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			});
			// Reviews
			$('#review').delegate('.pagination a', 'click', function(e) {
				e.preventDefault();
				$('#review').fadeOut('slow');
				$('#review').load(this.href);
				$('#review').fadeIn('slow');
			});
			$('.rating-input label').hover(function () {
				$(this).addClass('rating-input-active');
				$(this).prevAll('.rating-input label').addClass('rating-input-active');
			},function () {
				$(this).removeClass('rating-input-active');
				$(this).prevAll('.rating-input label').removeClass('rating-input-active');
			});
			$('.rating-input label').click(function(){
				$('.rating-input label').each(function(){
					$(this).removeClass('rating-input-checked');
					$(this).prevAll('.rating-input label').removeClass('rating-input-checked');
				});
				$(this).addClass('rating-input-checked');
				$(this).prevAll('.rating-input label').addClass('rating-input-checked');
			});
			$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');
			$('#button-review').on('click', function() {
				$.ajax({
					url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
					type: 'post',
					dataType: 'json',
					data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
					success: function(json) {
						if (json['error']) {
							Materialize.toast('<i class="material-icons left">warning</i>'+json['error'],7000,'toast-warning rounded');
						}
						if (json['success']) {
							Materialize.toast('<i class="material-icons left">check</i>'+json['success'],7000,'toast-success rounded');
							$('input[name=\'name\']').val('');
							$('textarea[name=\'text\']').val('');
							$('input[name=\'rating\']:checked').prop('checked', false);
							$('input[name=\'captcha\']').val('');
						}
					}
				});
				grecaptcha.reset();
			});
			// Quantity
			$('#quantity-minus').click(function () {
				var $input = $('#input-quantity');
				var count = parseInt($input.val()) - 1;
				count = count < <?php echo $minimum; ?> ? <?php echo $minimum; ?> : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('#quantity-plus').click(function () {
				var $input = $('#input-quantity');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
			// Download file
			$('button[id^=\'button-upload\']').on('click', function() {
				var node = this;
				$('#form-upload').remove();
				$('#modal-loading').remove();
				$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display:none;"><input type="file" name="file"></form><div id="modal-loading" class="modal"><div class="modal-content"><div class="row valign-wrapper"><div class="col s4 m3 center"><div class="preloader-wrapper active"><div class="spinner-layer spinner-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-yellow"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div><div class="col s10 m9"><p id="loading-text" class="flow-text text-bold"><?php echo $text_loading; ?></p></div></div></div></div>');
				$('#form-upload input[name=\'file\']').trigger('click');
				if (typeof timer != 'undefined') {
					clearInterval(timer);
				}
				timer = setInterval(function() {
					if ($('#form-upload input[name=\'file\']').val() != '') {
						clearInterval(timer);
						$('#modal-loading').modal({
							dismissible: false,
							opacity: .7,
							endingTop: '40%',
						}).modal('open');
						$.ajax({
							url: 'index.php?route=tool/upload',
							type: 'post',
							dataType: 'json',
							data: new FormData($('#form-upload')[0]),
							cache: false,
							contentType: false,
							processData: false,
							complete: function() {
								$('#modal-loading').modal('close');
							},
							success: function(json) {
								if (json['error']) {
									Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error"]+'</span>',7000,'toast-warning rounded');
								}
								if (json['success']) {
									Materialize.toast('<span><i class="material-icons left">check</i>'+json["success"]+'</span>',7000,'toast-success rounded');
									$(node).parent().find('input').val(json['code']);
								}
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					}
				}, 500);
			});
			// Add to cart
			$('#button-cart').on('click', function() {
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('#product input[type=\'number\'], #product input[type=\'time\'], #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
					dataType: 'json',
					success: function(json) {
						if (json['error']) {
							if (json['error']['option']) {
								for (i in json['error']['option']) {
									var element = $('#input-option' + i.replace('_', '-'));
									if (element.parent().hasClass('input-group')) {
										Materialize.toast('<span><i class="material-icons left">info</i>'+json["error"]["option"][i]+'</span>',7000,'toast-info rounded');
									} else {
										Materialize.toast('<span><i class="material-icons left">info</i>'+json["error"]["option"][i]+'</span>',7000,'toast-info rounded');
									}
								}
							}
							if (json['error']['recurring']) {
								Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error"]["recurring"]+'</span>',7000,'toast-warning rounded');
							}
						}
						if (json['success']) {
							Materialize.toast('<span><i class="material-icons left">check</i>'+json['success']+'</span>',7000,'toast-success rounded');
							setTimeout(function () {
								$('#cart').html('<i class="material-icons left">shopping_cart</i><small id="cart-total" class="light-blue darken-1 btn-floating pulse z-depth-1">'+json['total']+'</small>');
							}, 100);
							$('#cart').addClass('pulse');
							$('#modal-cart-content').load('index.php?route=common/cart/info .modal-content .container');
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