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
						<h2><?php echo $heading_title; ?></h2>
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered">
								<thead class="grey lighten-4">
									<tr>
										<th colspan="2"><small><?php echo $text_return_detail; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:50%;">
											<b><?php echo $text_return_id; ?></b> #<?php echo $return_id; ?><br>
											<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?>
										</td>
										<td style="width:50%;">
											<b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br>
											<b><?php echo $text_date_ordered; ?></b> <?php echo $date_ordered; ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<h3><?php echo $text_product; ?></h3>
							<table class="bordered">
								<thead class="grey lighten-4">
									<tr>
										<th style="width:33.3%;"><small><?php echo $column_product; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_model; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_quantity; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:33.3%;"><?php echo $product; ?></td>
										<td style="width:33.3%;"><?php echo $model; ?></td>
										<td style="width:33.3%;"><?php echo $quantity; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="section" style="overflow-x:scroll;">
							<h3><?php echo $text_reason; ?></h3>
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th style="width:33.3%;"><small><?php echo $column_reason; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_opened; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_action; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $reason; ?></td>
										<td><?php echo $opened; ?></td>
										<td><?php echo $action; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php if ($comment) { ?>
						<div class="section" style="overflow-x:scroll;">
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $text_comment; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $comment; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php } ?>
						<div class="section" style="overflow-x:scroll;">
							<h3><?php echo $text_history; ?></h3>
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th style="width:33.3%;"><small><?php echo $column_date_added; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_status; ?></small></th>
										<th style="width:33.3%;"><small><?php echo $column_comment; ?></small></th>
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
										<td colspan="3" class="text-center"><?php echo $text_no_results; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
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
<?php echo $footer; ?>