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
						<?php if ($returns) { ?>
						<div style="overflow-x:scroll;">
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_return_id; ?></small></th>
										<th><small><?php echo $column_status; ?></small></th>
										<th><small><?php echo $column_date_added; ?></small></th>
										<th><small><?php echo $column_order_id; ?></small></th>
										<th><small><?php echo $column_customer; ?></small></th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($returns as $return) { ?>
									<tr>
										<td>#<?php echo $return['return_id']; ?></td>
										<td><?php echo $return['status']; ?></td>
										<td><?php echo $return['date_added']; ?></td>
										<td><?php echo $return['order_id']; ?></td>
										<td><?php echo $return['name']; ?></td>
										<td><a href="<?php echo $return['href']; ?>" title="<?php echo $button_view; ?>" class="btn waves-effect waves-light blue"><i class="material-icons">remove_red_eye</i></a></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php echo $results; ?>
						<br>
						<?php echo $pagination; ?>
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