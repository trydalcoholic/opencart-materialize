<section class="section href-underline">
	<h2><?php echo $heading_title; ?></h2>
	<div class="row">
		<?php foreach ($products as $product) { ?>
		<div class="col s12 m6 xl4">
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
</section>