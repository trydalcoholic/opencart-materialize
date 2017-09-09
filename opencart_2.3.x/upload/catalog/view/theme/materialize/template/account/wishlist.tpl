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
			<nav id="breadcrumbs" class="breadcrumb-wrapper transparent z-depth-0">
				<div class="nav-wrapper breadcrumb-wrap href-underline">
					<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
					<?php $i++ ?>
					<?php if ($i < count($breadcrumbs)) { ?>
					<?php if ($i == 1) {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><i class="material-icons">home</i></a>
					<?php } else {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><?php echo $breadcrumb['text']; ?></a>
					<?php }?>
					<?php } else { ?>
						<span class="breadcrumb blue-grey-text text-darken-3"><?php echo $breadcrumb['text']; ?></span>
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
					<?php if ($products) { ?>
						<?php foreach ($products as $product) { ?>
						<div class="card horizontal">
							<div class="card-image">
								<div>
									<?php if ($product['thumb']) { ?>
										<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" width="75" height="75"></a>
									<?php } ?>
								</div>
							</div>
							<div class="card-stacked">
								<a href="<?php echo $product['remove']; ?>" title="<?php echo $button_remove; ?>" class="btn-floating waves-effect transparent z-depth-0 remove-item"><i class="material-icons black-text">close</i></a>
								<div class="card-content">
									<a class="text-bold" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
									<br>
									<span class="text-bold"><?php echo $column_price; ?>: </span><?php if ($product['price']) { ?><?php if (!$product['special']) { ?><?php echo $product['price']; ?><?php } else { ?><b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s><?php } ?><?php } ?>
									<br>
									<span class="text-bold"><?php echo $column_stock; ?>: </span><?php echo $product['stock']; ?>
									<br><br>
									<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" title="<?php echo $button_cart; ?>" class="btn waves-effect waves-light red"><i class="material-icons left">add_shopping_cart</i><?php echo $button_cart; ?></button>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } else { ?>
						<div class="card-panel">
							<p><?php echo $text_empty; ?></p>
						</div>
					<?php } ?>
					<div class="flex-reverse">
						<a href="<?php echo $continue; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>