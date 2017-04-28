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
				<div id="content" class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<div class="card-panel">
						<?php if ($products) { ?>
						<div style="overflow-x:scroll;">
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_image; ?></small></th>
										<th><small><?php echo $column_name; ?></small></th>
										<th><small><?php echo $column_model; ?></small></th>
										<th><small><?php echo $column_stock; ?></small></th>
										<th><small><?php echo $column_price; ?></small></th>
										<th><small><?php echo $column_action; ?></small></th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($products as $product) { ?>
									<tr>
										<td>
											<?php if ($product['thumb']) { ?>
											<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></a>
											<?php } ?>
										</td>
										<td><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
										<td><?php echo $product['model']; ?></td>
										<td><?php echo $product['stock']; ?></td>
										<td>
											<?php if ($product['price']) { ?>
											<div class="price">
											<?php if (!$product['special']) { ?>
											<?php echo $product['price']; ?>
											<?php } else { ?>
											<b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
											<?php } ?>
											</div>
											<?php } ?>
										</td>
										<td>
											<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" title="<?php echo $button_cart; ?>" class="btn waves-effect waves-light blue lighten-1"><i class="material-icons">add_shopping_cart</i></button>
											<a href="<?php echo $product['remove']; ?>" title="<?php echo $button_remove; ?>" class="btn waves-effect waves-light red lighten-1"><i class="material-icons">close</i></a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } else { ?>
							<p><?php echo $text_empty; ?></p>
						<?php } ?>
						<div class="flex-reverse">
							<a href="<?php echo $continue; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>