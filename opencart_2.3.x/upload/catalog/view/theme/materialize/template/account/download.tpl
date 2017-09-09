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
						<?php if ($downloads) { ?>
						<?php foreach ($downloads as $download) { ?>
						<div class="card horizontal">
							<div class="card-image">
								<a href="<?php echo $download['href']; ?>" class="tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $button_download; ?>"><img src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/download-icon.png" class="lazyload" width="75" height="75"></a>
							</div>
							<div class="card-stacked">
								<div class="card-content">
									<a href="<?php echo $download['href']; ?>" class="text-bold"><?php echo $download['name']; ?></a>
									<br>
									<span class="text-bold"><?php echo $column_order_id; ?>:</span> <?php echo $download['order_id']; ?>
									<br>
									<span class="text-bold"><?php echo $column_size; ?>:</span> <?php echo $download['size']; ?>
									<br>
									<span class="text-bold"><?php echo $column_date_added; ?>:</span> <?php echo $download['date_added']; ?>
								</div>
							</div>
						</div>
						<?php } ?>
						<?php echo $pagination; ?>
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