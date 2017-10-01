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
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
					<?php foreach ($products as $product) { ?>
						<div class="card horizontal">
							<div class="card-image">
								<?php if ($product['thumb']) { ?>
								<a href="<?php echo $product['href']; ?>"><img class="lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" width="75" height="75"></a>
								<?php } ?>
							</div>
							<div class="card-stacked">
								<button type="button" class="btn-floating waves-effect transparent z-depth-0 remove-item" title="<?php echo $button_remove; ?>" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="material-icons black-text">close</i></button>
								<div class="card-content">
									<a href="<?php echo $product['href']; ?>" class="text-bold"><?php echo $product['name']; ?></a> x <?php echo $product['quantity']; ?><?php if (!$product['stock']) { ?><span class="red-text">***</span><?php } ?>
									<br>
									<span class="text-bold"><?php echo $product['total']; ?></span>
									<?php if ($product['reward']) { ?>
										<br>
										<small><?php echo $product['reward']; ?></small>
									<?php } ?>
									<?php if ($product['option']) { ?>
										<?php foreach ($product['option'] as $option) { ?>
										<br>
										<small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
										<?php } ?>
									<?php } ?>
									<?php if ($product['recurring']) { ?>
										<br>
										<span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
									<?php } ?>
									<br>
									<div class="input-filed inline">
										<label for="input-quantity">
											<?php echo $column_quantity; ?>:
											<button id="update-btn" type="submit" title="<?php echo $button_update; ?>" style="display:none;"><i class="material-icons">refresh</i></button>
										</label>
										<input id="input-quantity" class="center" type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" style="max-width:50px;height:inherit;">
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php foreach ($vouchers as $voucher) { ?>
						<div class="card horizontal">
							<div class="card-image">
								<div><img src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/cart-voucher.png" class="lazyload" width="75" height="75"></div>
							</div>
							<div class="card-stacked">
								<button type="button" class="btn-floating transparent z-depth-0 remove-item" title="<?php echo $button_remove; ?>" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i class="material-icons black-text">close</i></button>
								<div class="card-content">
									<?php echo $voucher['description']; ?>
									<br>
									<span class="text-bold"><?php echo $voucher['amount']; ?></span>
									<br>
									<div class="input-filed inline">
										<label for="input-quantity">
											<?php echo $column_quantity; ?>:
											<button id="update-btn" type="submit" title="<?php echo $button_update; ?>" style="display:none;"><i class="material-icons">refresh</i></button>
										</label>
										<input type="text" name="" value="1" size="1" class="center" disabled="disabled" style="max-width:50px;height:inherit;">
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					</form>
					<div class="card-panel">
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
								<div class="table-responsive card-panel">
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
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $attention; ?></span>',7000,'toast-info')
			<?php } ?>
			<?php if ($success) { ?>
				Materialize.toast('<span><i class="material-icons left">check</i><?php echo $success; ?></span>',7000,'toast-success')
			<?php } ?>
			<?php if ($error_warning) { ?>
				Materialize.toast('<span><i class="material-icons left">warning</i><?php echo $error_warning; ?></span>',7000,'toast-warning')
			<?php } ?>
			$('input#input-quantity').change(function() {
				$('#update-btn').trigger('click');
			});
		});
	</script>
<?php echo $footer; ?>