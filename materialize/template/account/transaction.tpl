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
		<div class="row">
			<div class="container">
				<nav class="breadcrumb-wrapper transparent z-depth-0">
					<div class="nav-wrapper">
						<div class="row">
							<div class="col s12">
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
						</div>
					</div>
				</nav>
				<h1 class="col s12"><?php echo $heading_title; ?></h1>
				<?php if ($column_left && $column_right) { ?>
					<?php $main = 's12 l6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
					<?php $main = 's12 l9'; ?>
				<?php } else { ?>
					<?php $main = 's12'; ?>
				<?php } ?>
				<?php echo $column_left; ?>
				<div id="content" class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<div class="card-panel">
						<div style="overflow-x:scroll;">
							<table class="bordered centered">
								<thead class="grey lighten-4">
									<tr>
										<th><small><?php echo $column_date_added; ?></small></th>
										<th><small><?php echo $column_description; ?></small></th>
										<th><small><?php echo $column_amount; ?></small></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($transactions) { ?>
									<?php foreach ($transactions as $transaction) { ?>
									<tr>
										<td>#<?php echo $transaction['date_added']; ?></td>
										<td><?php echo $transaction['description']; ?></td>
										<td><?php echo $transaction['amount']; ?></td>
									</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td colspan="5"><?php echo $text_empty; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col s12"><?php echo $pagination; ?></div>
							<div class="col s12"><?php echo $results; ?></div>
						</div>
						<div class="row">
							<div class="col s12">
								<div class="section">
									<a href="<?php echo $continue; ?>" class="btn waves-effect waves-light red right href-underline"><?php echo $button_continue; ?></a>
								</div>
							</div>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>