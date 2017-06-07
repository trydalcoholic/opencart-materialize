<button type="button" id="cart" data-target="modal-cart" class="btn-floating btn-large waves-effect waves-light waves-circle modal-trigger red z-depth-4">
	<i class="material-icons">shopping_cart</i>
	<small id="cart-total" class="light-blue darken-1 btn-floating z-depth-1"><?php echo $text_items; ?></small>
</button>
<div id="modal-cart" class="modal bottom-sheet modal-fixed-footer">
	<div id="modal-cart-content" class="modal-content">
		<div class="container">
			<h4 class="flow-text text-bold"><?php echo $text_shopping_cart; ?></h4>
			<?php if ($products || $vouchers) { ?>
			<script>
				document.addEventListener("DOMContentLoaded", function(event) {
					$('#cart').addClass('pulse');
					$('#cart-total').addClass('pulse');
				});
			</script>
			<ul class="collection z-depth-2">
				<?php foreach ($products as $product) { ?>
				<li class="collection-item avatar">
					<?php if ($product['thumb']) { ?>
					<a href="<?php echo $product['href']; ?>"><img src="<?php echo $img_loader; ?>" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="circle lazyload"></a>
					<?php } ?>
					<a href="<?php echo $product['href']; ?>"><span class="title"><?php echo $product['name']; ?></span></a> x <?php echo $product['quantity']; ?>
					<p>
						<b><?php echo $product['total']; ?></b>
						<br>
						<?php if ($product['option']) { ?>
						<?php foreach ($product['option'] as $option) { ?>
						<br>
						- <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
						<?php } ?>
						<?php } ?>
						<?php if ($product['recurring']) { ?>
						<br>
						- <small><?php echo $text_recurring; ?>: <?php echo $product['recurring']; ?></small>
						<?php } ?>
					</p>
					<button onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn-flat no-padding secondary-content activator black-text"><i class="material-icons">remove_shopping_cart</i></button>
				</li>
				<?php } ?>
				<?php foreach ($vouchers as $voucher) { ?>
				<li class="collection-item avatar">
					<img src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/cart-voucher.png" class="circle lazyload" width="42" height="42">
					<span class="title text-bold"><?php echo $voucher['description']; ?></span>&nbsp;x&nbsp;1
					<button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn-flat no-padding secondary-content activator black-text"><i class="material-icons">remove_shopping_cart</i></button>
				</li>
				<?php } ?>
				<li class="collection-item">
					<table class="bordered">
						<?php foreach ($totals as $total) { ?>
						<tr>
							<td class="text-right"><strong><?php echo $total['title']; ?></strong></td>
							<td class="text-right"><?php echo $total['text']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</li>
			</ul>
			<?php } else { ?>
			<div class="card-panel">
				<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
				<div class="row">
					<div class="col s4 m3 l2 center">
						<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/cart-empty.png" alt="Пустая корзина" width="128" height="128">
					</div>
					<div class="col s8 m9 l10 grey lighten-3 z-depth-1 comment-body">
						<p><?php echo $text_cat_says; ?></p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="modal-footer grey lighten-3">
		<div class="container">
			<a href="<?php echo $cart; ?>" class="modal-action btn-flat waves-effect waves-light right href-underline" rel="nofollow"><?php echo $text_cart; ?></a>
		</div>
	</div>
</div>