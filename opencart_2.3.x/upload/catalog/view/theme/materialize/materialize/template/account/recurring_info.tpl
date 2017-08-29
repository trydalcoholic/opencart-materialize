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
										<th colspan="2"><small><?php echo $text_recurring_detail; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:50%;">
											<b><?php echo $text_order_recurring_id; ?></b> #<?php echo $order_recurring_id; ?><br>
											<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br>
											<b><?php echo $text_status; ?></b> <?php echo $status; ?><br>
											<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?>
										</td>
										<td style="width:50%;">
											<b><?php echo $text_order_id; ?></b> <a href="<?php echo $order; ?>">#<?php echo $order_id; ?></a><br>
											<b><?php echo $text_product; ?></b> <a href="<?php echo $product; ?>"><?php echo $product_name; ?></a><br>
											<b><?php echo $text_quantity; ?></b> <?php echo $product_quantity; ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $text_description; ?></small></th>
										<th><small><?php echo $text_reference; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:50%;"><?php echo $recurring_description; ?></td>
										<td style="width:50%;"><?php echo $reference; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<h3><?php echo $text_transaction; ?></h3>
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_date_added; ?></small></th>
										<th><small><?php echo $column_type; ?></small></th>
										<th><small><?php echo $column_amount; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($transactions) { ?>
									<?php foreach ($transactions as $transaction) { ?>
									<tr>
										<td><?php echo $transaction['date_added']; ?></td>
										<td><?php echo $transaction['type']; ?></td>
										<td><?php echo $transaction['amount']; ?></td>
									</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td colspan="3"><?php echo $text_no_results; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="flex-reverse">
							<a href="<?php echo $continue; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
						</div>
					</div>
					<?php echo $recurring; ?>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>