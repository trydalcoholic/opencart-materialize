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
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered">
								<thead class="grey lighten-4">
									<tr>
										<th colspan="2"><small><?php echo $text_order_detail; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:50%;">
											<?php if ($invoice_no) { ?>
											<b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br>
											<?php } ?>
											<b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br>
											<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?>
										</td>
										<td style="width:50%;">
											<?php if ($payment_method) { ?>
											<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br>
											<?php } ?>
											<?php if ($shipping_method) { ?>
											<b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered">
								<thead class="grey lighten-4">
									<tr>
										<th style="width:50%;"><small><?php echo $text_payment_address; ?></small></th>
										<?php if ($shipping_address) { ?>
										<th style="width:50%;"><small><?php echo $text_shipping_address; ?></small></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $payment_address; ?></td>
										<?php if ($shipping_address) { ?>
										<td><?php echo $shipping_address; ?></td>
										<?php } ?>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_name; ?></small></th>
										<th><small><?php echo $column_model; ?></small></th>
										<th><small><?php echo $column_quantity; ?></small></th>
										<th><small><?php echo $column_price; ?></small></th>
										<th><small><?php echo $column_total; ?></small></th>
										<?php if ($products) { ?>
										<th style="width:20%;"><small>&nbsp;</small></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($products as $product) { ?>
									<tr>
										<td>
											<?php echo $product['name']; ?>
											<?php foreach ($product['option'] as $option) { ?>
											<br>
											&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
											<?php } ?>
										</td>
										<td><?php echo $product['model']; ?></td>
										<td><?php echo $product['quantity']; ?></td>
										<td><?php echo $product['price']; ?></td>
										<td><?php echo $product['total']; ?></td>
										<td>
											<?php if ($product['reorder']) { ?>
											<a href="<?php echo $product['reorder']; ?>" title="<?php echo $button_reorder; ?>" class="btn waves-effect waves-light blue"><i class="material-icons">add_shopping_cart</i></a>
											<?php } ?>
											<a href="<?php echo $product['return']; ?>" title="<?php echo $button_return; ?>" class="btn waves-effect waves-light red"><i class="material-icons">cached</i></a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot>
								<?php foreach ($totals as $total) { ?>
									<tr>
										<td colspan="3"></td>
										<td><b><?php echo $total['title']; ?></b></td>
										<td><?php echo $total['text']; ?></td>
										<?php if ($products) { ?>
										<td></td>
										<?php } ?>
									</tr>
								<?php } ?>
								</tfoot>
							</table>
							<?php if ($comment) { ?>
							<table class="bordered centered">
								<thead>
									<tr>
										<th><?php echo $text_comment; ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $comment; ?></td>
									</tr>
								</tbody>
							</table>
							<?php } ?>
							<?php if ($histories) { ?>
							<h3><?php echo $text_history; ?></h3>
							<table class="bordered centered">
								<thead>
									<tr>
										<th><?php echo $column_date_added; ?></th>
										<th><?php echo $column_status; ?></th>
										<th><?php echo $column_comment; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($histories) { ?>
									<?php foreach ($histories as $history) { ?>
									<tr>
										<td><?php echo $history['date_added']; ?></td>
										<td><?php echo $history['status']; ?></td>
										<td><?php echo $history['comment']; ?></td>
									</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td colspan="3"><?php echo $text_no_results; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php } ?>
						</div>
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
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($success) { ?>
				Materialize.toast('<?php echo $success; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_warning) { ?>
				Materialize.toast('<?php echo $error_warning; ?>',7000,'rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>