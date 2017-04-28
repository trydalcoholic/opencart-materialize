<?php echo $header; ?>
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
				<?php $main = 's12 l6'; $goods = 's12'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; $goods = 's12 m6'; ?>
			<?php } else { ?>
				<?php $main = 's12'; $goods = 's12 m6 l4'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div id="content" class="col <?php echo $main; ?> section href-underline">
					<?php echo $content_top; ?>
					<h1><?php echo $heading_title; ?></h1>
					<ul class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header text-bold"><label for="input-search"><?php echo $entry_search; ?></label><i class="material-icons right">arrow_drop_down</i></div>
							<div class="collapsible-body white">
								<div class="row">
									<div class="col s6 input-field">
										<input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search">
										<label class="text-bold"><?php echo $text_searched; ?></label>
									</div>
									<div class="col s6 input-field">
										<select name="category_id" class="form-control">
											<option value="0"><?php echo $text_category; ?></option>
											<?php foreach ($categories as $category_1) { ?>
												<?php if ($category_1['category_id'] == $category_id) { ?>
												<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_refine; ?></label>
									</div>
									<div class="col s12">
										<div class="row">
											<div class="col s12 m6 switch">
												<div class="section">
													<span class="text-bold"><?php echo $entry_description; ?>:</span><br>
													<label>
														<span><?php echo $text_no; ?></span>
														<?php if ($description) { ?>
														<input type="checkbox" name="description" value="1" checked="checked" id="search-in-description">
														<?php } else { ?>
														<input type="checkbox" name="description" value="1" id="search-in-description">
														<?php } ?>
														<span class="lever"></span>
														<span><?php echo $text_yes; ?></span>
													</label>
												</div>
											</div>
											<div class="col s12 m6 switch">
												<div class="section">
													<span class="text-bold"><?php echo $text_sub_category; ?>:</span><br>
													<label>
														<span><?php echo $text_no; ?></span>
														<?php if ($sub_category) { ?>
														<input type="checkbox" name="sub_category" value="1"  checked="checked">
														<?php } else { ?>
														<input type="checkbox" name="sub_category" value="1">
														<?php } ?>
														<span class="lever"></span>
														<span><?php echo $text_yes; ?></span>
													</label>
												</div>
											</div>
										</div>
										<input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn waves-effect waves-light red right">
									</div>
								</div>
							</div>
						</li>
					</ul>
					<?php if ($products) { ?>
					<ul class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header text-bold"><?php echo $text_sort_short; ?><i class="material-icons right">arrow_drop_down</i></div>
							<div class="collapsible-body white">
								<div class="row">
									<div class="col s6 m6 input-field inline">
										<select id="input-sort" onchange="location = this.value;">
											<?php foreach ($sorts as $sorts) { ?>
											<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
											<option value="<?php echo $sorts['href']; ?>" selected><?php echo $sorts['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_sort; ?></label>
									</div>
									<div class="col s6 m6 input-field inline">
										<select id="input-limit" onchange="location = this.value;">
											<?php foreach ($limits as $limits) { ?>
											<?php if ($limits['value'] == $limit) { ?>
											<option value="<?php echo $limits['href']; ?>" selected><?php echo $limits['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_limit; ?></label>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="row">
						<?php foreach ($products as $product) { ?>
						<div class="col <?php echo $goods; ?>">
							<div class="card sticky-action large hoverable">
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
					<?php if ($pagination) { ?>
					<div class="row">
						<?php echo $pagination; ?>
					</div>
					<?php } ?>
					<?php } else { ?>
						<div class="card-panel center">
							<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
							<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/search-empty.png" alt="Ничего не найдено">
						</div>
					<?php } ?>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$('#button-search').bind('click', function() {
				url = 'index.php?route=product/search';
				var search = $('#content input[name=\'search\']').prop('value');
				if (search) {
					url += '&search=' + encodeURIComponent(search);
				}
				var category_id = $('#content select[name=\'category_id\']').prop('value');
				if (category_id > 0) {
					url += '&category_id=' + encodeURIComponent(category_id);
				}
				var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');
				if (sub_category) {
					url += '&sub_category=true';
				}
				var filter_description = $('#content input[name=\'description\']:checked').prop('value');
				if (filter_description) {
					url += '&description=true';
				}
				location = url;
			});
			$('#content input[name=\'search\']').bind('keydown', function(e) {
				if (e.keyCode == 13) {
					$('#button-search').trigger('click');
				}
			});
			$('select[name=\'category_id\']').on('change', function() {
				if (this.value == '0') {
					$('input[name=\'sub_category\']').prop('disabled', true);
				} else {
					$('input[name=\'sub_category\']').prop('disabled', false);
				}
			});
			$('select[name=\'category_id\']').trigger('change');
		});
	</script>
<?php echo $footer; ?>