<?php echo $header; ?>
<?php function getUrl() {$url = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] : 'https://'.$_SERVER["SERVER_NAME"];$url .= $_SERVER["REQUEST_URI"];return $url;}?>
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
					<meta itemprop="url" content="<?php echo getUrl(); ?>">
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
									<button type="button" class="btn-flat no-padding blue-grey-text text-darken-4 share-btn" data-target="modal-share"><i class="material-icons">share</i></button>
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
											<?php $reviewCount = preg_replace('~\D+~','',$reviews); ?>
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
												<meta itemprop="price" content="<?php echo preg_replace('~\D+~','',$price); ?>">
											<?php } else { ?>
												<span class="card-price old-price grey-text"><?php echo $price; ?></span>
												<span class="card-price red-text text-darken-2"><?php echo $special; ?></span>
												<meta itemprop="price" content="<?php echo preg_replace('~\D+~','',$special); ?>">
											<?php } ?>
										<?php } ?>
										<meta itemprop="pricecurrency" content="RUB">
									</div>
									<div class="col s4 center">
										<?php if($manufacturers_img) { ?>
										<a href="<?php echo $manufacturers; ?>" target="_blank"><?php echo ($manufacturers_img) ? '<img class="responsive-img lazyload" src="'.$img_loader.'" data-src="'.$manufacturers_img.'" title="'.$manufacturer.'" alt="'.$manufacturer.'">' : '' ;?></a>
										<?php } ?>
									</div>
								</div>
								<?php if ($product_spec && $product_spec != '0000-00-00') { ?>
								<div class="section center grey lighten-3 end-promotion">
									<span><i class="material-icons left">info</i><?php echo $text_end_promotion; ?>
									<span class="text-bold">
									<?php
										$product_spec = date_create($product_spec);
										echo date_format($product_spec, 'd.m.Y');
									?>
									</span>
									</span>
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
									<li class="collection-item">
										<a class="inherit-text" href="/index.php?route=information/information&information_id=6" target="_blank"><span><i class="material-icons blue-grey-text text-darken-4 left">local_shipping</i>Доставим завтра <span class="text-underline">за 150 рублей</span></span></a>
									</li>
									<li class="collection-item">
										<a class="inherit-text" href="#" target="_blank"><span><i class="material-icons blue-grey-text text-darken-4 left">store</i>Самовывоз сегодня <span class="text-underline">бесплатно</span></span></a>
									</li>
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
										<br>
										<?php foreach ($options as $option) { ?>
											<?php if ($option['type'] == 'radio') { ?>
											<div id="input-option<?php echo $option['product_option_id']; ?>">
												<div class="section">
													<label<?php echo ($option['required'] ? ' class="required"' : ''); ?>><?php echo $option['name']; ?></label>
													<ul class="product-option">
														<?php foreach ($option['product_option_value'] as $option_value) { ?>
														<li>
															<?php if ($option_value['image']) { ?>
																<img src="<?php echo $img_loader; ?>" data-src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="responsive-img">
															<?php } ?>
															<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="<?php echo $option_value['product_option_value_id']; ?>"  class="with-gap">
															<label for="<?php echo $option_value['product_option_value_id']; ?>">
																<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>
															</label>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'checkbox') { ?>
											<div id="input-option<?php echo $option['product_option_id']; ?>">
												<div class="section">
													<label<?php echo ($option['required'] ? ' class="required"' : ''); ?>><?php echo $option['name']; ?></label>
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
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'select') { ?>
											<div class="input-field">
												<select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="icons">
													<?php foreach ($option['product_option_value'] as $option_value) { ?>
													<option value="<?php echo $option_value['product_option_value_id']; ?>"<?php if($option_value['image']){ ?> class="left circle" data-icon="<?php echo $option_value['image']; ?>"<?php } ?>><?php echo $option_value['name']; ?><?php if ($option_value['price']) { ?>&nbsp;(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>
													</option>
													<?php } ?>
												</select>
												<label for="input-option<?php echo $option['product_option_id']; ?>"<?php echo ($option['required'] ? ' class="required"' : ''); ?>><?php echo $option['name']; ?></label>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'text') { ?>
											<div class="input-field">
												<div class="section">
													<i class="material-icons prefix">textsms</i>
													<label<?php echo ($option['required'] ? ' class="required"' : ''); ?> for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>">
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'textarea') { ?>
											<div class="input-field">
												<div class="section">
													<i class="material-icons prefix">message</i>
													<label<?php echo ($option['required'] ? ' class="required"' : ''); ?> for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="materialize-textarea"></textarea>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'file') { ?>
											<div class="file-field input-field">
												<div class="section">
													<label<?php echo ($option['required'] ? ' class="required"' : ''); ?> for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
													<br>
													<button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" class="btn blue-grey lighten-1">
														<i class="material-icons left">cloud_upload</i>
														<span><?php echo $button_upload; ?></span>
														<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>">
													</button>
													<div class="file-path-wrapper">
														<input class="file-path validate" type="text" placeholder="<?php echo $option['name']; ?>">
													</div>
													<br><br>
												</div>
											</div>
											<?php } ?>
											<?php if ($option['type'] == 'date') { ?>
											<div class="input-field section">
												<i class="material-icons prefix">event</i>
												<label<?php echo ($option['required'] ? ' class="required"' : ''); ?> for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
												<input type="date" name="option[<?php echo $option['product_option_id']; ?>]" placeholder="<?php echo date('d.m.Y'); ?>" value="" id="input-option<?php echo $option['product_option_id']; ?>" class="datepicker">
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
												<?php $attribute_group['attribute']; ?>
												<?php foreach ($attribute_group['attribute'] as $i => $attribute) { ?>
												<tr>
													<td><?php echo $attribute['name']; ?></td>
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
				<div class="col s12">
					<span class="blue-text text-lighten-1"><?php echo $text_tags; ?></span>
					<?php for ($i = 0; $i < count($tags); $i++) { ?>
						<?php if ($i < (count($tags) - 1)) { ?>
						<a href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>"><span class="chip waves-effect waves-default"><?php echo $tags[$i]['tag']; ?></span></a>,
						<?php } else { ?>
						<a href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>"><span class="chip waves-effect waves-default"><?php echo $tags[$i]['tag']; ?></span></a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
			<?php echo $content_bottom; ?>
		</div>
	</main>
	<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true"><div class="pswp__bg"></div><div class="pswp__scroll-wrap"><div class="pswp__container"><div class="pswp__item"></div><div class="pswp__item"></div><div class="pswp__item"></div></div><div class="pswp__ui pswp__ui--hidden"><div class="pswp__top-bar"><div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="Закрыть (Esc)"></button><button class="pswp__button pswp__button--share" title="Поделиться"></button><button class="pswp__button pswp__button--fs" title="Включить полноэкранный режим"></button><button class="pswp__button pswp__button--zoom" title="Увеличить/уменьшить"></button><div class="pswp__preloader"><div class="pswp__preloader__icn"><div class="pswp__preloader__cut"><div class="pswp__preloader__donut"></div></div></div></div></div><div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap"><div class="pswp__share-tooltip"></div></div><button class="pswp__button pswp__button--arrow--left" title="Предыдущая (стрелка влево)"></button><button class="pswp__button pswp__button--arrow--right" title="Следующая (стрелка вправо)"></button><div class="pswp__caption"><div class="pswp__caption__center"></div></div></div></div></div>
	<div id="modal-share" class="modal bottom-sheet">
		<div id="modal-share-content" class="modal-content white">
			<div class="container center">
				<h4><?php echo $heading_title; ?></h4>
				<div class="row">
					<div class="col s3 l2 center">
						<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $thumb_small; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
					</div>
					<div class="col s9 l10 grey lighten-3 z-depth-1 comment-body">
						<p>Поделись ссылкой со своими друзьями или сохрани у себя на страничке в твоей любимой социальной сети :)</p>
						<p><div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,viber,whatsapp,skype,telegram"></div></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			// Отзывы
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
			// Количество
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
			// Добавление в корзину
			$('#button-cart').on('click', function() {
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('#product input[type=\'number\'], #product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
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
	<script async src="//yastatic.net/share2/share.js"></script>
<?php echo $footer; ?>