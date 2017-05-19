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
					<h1><?php echo $heading_title; ?><?php if ($weight) { ?>&nbsp;(<?php echo $weight; ?>)<?php } ?></h1>
					<div class="card-panel">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<table class="bordered centered responsive-table product-cart z-depth-1">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_image; ?></small></th>
										<th><small><?php echo $column_name; ?></small></th>
										<th><small><?php echo $column_model; ?></small></th>
										<th><small><?php echo $column_price; ?></small></th>
										<th><small><?php echo $column_total; ?></small></th>
										<th colpsan="3"><small><?php echo $column_quantity; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($products as $product) { ?>
									<tr>
										<td>
											<?php if ($product['thumb']) { ?>
											<a href="<?php echo $product['href']; ?>"><img class="lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></a>
											<?php } ?>
										</td>
										<td>
											<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
											<?php if (!$product['stock']) { ?>
												<span class="red-text">***</span>
											<?php } ?>
											<?php if ($product['reward']) { ?>
												<br>
												<small><?php echo $product['reward']; ?></small>
											<?php } ?>
											<?php if ($product['recurring']) { ?>
												<br>
												<span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
											<?php } ?>
										</td>
										<td>
											<?php echo $product['model']; ?>
										</td>
										<td>
											<?php echo $product['price']; ?>
										</td>
										<td>
											<?php echo $product['total']; ?>
										</td>
										<td style="min-width:200px;">
											<input class="center" type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" style="max-width:100px;">
											<button type="submit" title="<?php echo $button_update; ?>" class="btn-flat no-padding"><i class="material-icons">refresh</i></button>
											<button type="button" title="<?php echo $button_remove; ?>" class="btn-flat no-padding" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="material-icons">remove_shopping_cart</i></button>
										</td>
									</tr>
									<?php } ?>
									<?php foreach ($vouchers as $voucher) { ?>
									<tr>
										<td>
											<img src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/cart-voucher.png" class="lazyload" width="42" height="42">
										</td>
										<td><?php echo $voucher['description']; ?></td>
										<td></td>
										<td></td>
										<td><?php echo $voucher['amount']; ?></td>
										<td style="min-width:200px;">
											<input type="text" name="" value="1" size="1" disabled="disabled" style="max-width:100px;">
											<button type="button" title="<?php echo $button_remove; ?>" class="btn-flat no-padding" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i class="material-icons">remove_shopping_cart</i></button>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</form>
						<?php if ($modules) { ?>
							<h2><?php echo $text_next; ?></h2>
							<p><?php echo $text_next_choice; ?></p>
							<ul class="collapsible collapsible-modules" data-collapsible="accordion">
								<?php foreach ($modules as $module) { ?>
									<?php echo $module; ?>
								<?php } ?>
							</ul>
						<?php } ?>
						<div class="row">
							<div class="col s12 m6 offset-m6 l5 offset-l7">
								<div class="table-responsive">
									<table class="bordered">
										<?php foreach ($totals as $total) { ?>
										<tr>
											<th><?php echo $total['title']; ?>:</th>
											<td><?php echo $total['text']; ?></td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div class="flex-reverse">
							<a href="<?php echo $checkout; ?>" class="btn waves-effect waves-light red right"><?php echo $button_checkout; ?></a>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($attention) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $attention; ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($success) { ?>
				Materialize.toast('<span><i class="material-icons left">check</i><?php echo $success; ?></span>',7000,'toast-success rounded')
			<?php } ?>
			<?php if ($error_warning) { ?>
				Materialize.toast('<span><i class="material-icons left">warning</i><?php echo $error_warning; ?></span>',7000,'toast-warning rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>