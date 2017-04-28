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
			<h1><?php echo $heading_title; ?></h1>
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
					<?php if ($products) { ?>
					<div class="card-panel" style="overflow-x:scroll;">
						<table class="bordered striped centered">
							<thead>
								<tr>
									<th colspan="<?php echo count($products) + 1; ?>" style="text-align:left;"><strong><?php echo $text_product; ?></strong></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><b><?php echo $text_name; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><a href="<?php echo $product['href']; ?>" rel="nofollow" target="_blank"><strong><?php echo $product['name']; ?></strong></a></td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_image; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td>
									<?php if ($product['thumb']) { ?>
										<img src="<?php echo $img_loader; ?>" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="responsive-img lazyload">
									<?php } ?>
									</td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_price; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td>
									<?php if ($product['price']) { ?>
										<?php if (!$product['special']) { ?>
											<?php echo $product['price']; ?>
										<?php } else { ?>
										<strike><?php echo $product['price']; ?></strike> <?php echo $product['special']; ?>
										<?php } ?>
									<?php } ?>
									</td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_model; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['model']; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_manufacturer; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['manufacturer']; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_availability; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['availability']; ?></td>
									<?php } ?>
								</tr>
								<?php if ($review_status) { ?>
								<tr>
									<td><b><?php echo $text_rating; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td>
										<div class="rating">
											<span>
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
										<small><?php echo $product['reviews']; ?></small>
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
								<tr>
									<td><b><?php echo $text_summary; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['description']; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_weight; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['weight']; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td><b><?php echo $text_dimension; ?></b></td>
									<?php foreach ($products as $product) { ?>
									<td><?php echo $product['length']; ?> x <?php echo $product['width']; ?> x <?php echo $product['height']; ?></td>
									<?php } ?>
								</tr>
							</tbody>
							<?php foreach ($attribute_groups as $attribute_group) { ?>
							<thead>
								<tr>
									<td colspan="<?php echo count($products) + 1; ?>" style="text-align:left;"><strong><?php echo $attribute_group['name']; ?></strong></td>
								</tr>
							</thead>
							<?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
							<tbody>
								<tr>
									<td><?php echo $attribute['name']; ?></td>
									<?php foreach ($products as $product) { ?>
									<?php if (isset($product['attribute'][$key])) { ?>
									<td><?php echo $product['attribute'][$key]; ?></td>
									<?php } else { ?>
									<td></td>
									<?php } ?>
									<?php } ?>
								</tr>
							</tbody>
							<?php } ?>
							<?php } ?>
							<tr>
								<td></td>
								<?php foreach ($products as $product) { ?>
								<td>
									<button type="button" value="<?php echo $button_cart; ?>" class="btn waves-effect waves-light blue" title="<?php echo $button_cart; ?>" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="material-icons">add_shopping_cart</i></button>
									<a href="<?php echo $product['remove']; ?>" class="btn waves-effect waves-light red" title="<?php echo $button_remove; ?>"><i class="material-icons">delete_sweep</i></a>
								</td>
								<?php } ?>
							</tr>
						</table>
					</div>
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
<?php echo $footer; ?>