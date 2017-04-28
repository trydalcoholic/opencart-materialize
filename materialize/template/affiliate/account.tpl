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
						<div class="collection with-header href-underline">
							<div class="collection-header"><h2><?php echo $text_my_account; ?></h2></div>
							<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $edit; ?>"><i class="material-icons left">assignment</i><?php echo $text_edit; ?></a>
							<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $password; ?>"><i class="material-icons left">lock</i><?php echo $text_password; ?></a>
							<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $payment; ?>"><i class="material-icons left">payment</i><?php echo $text_payment; ?></a>
						</div>
						<div class="collection with-header href-underline">
							<div class="collection-header"><h2><?php echo $text_my_tracking; ?></h2></div>
							<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $tracking; ?>"><i class="material-icons left">fingerprint</i><?php echo $text_tracking; ?></a>
						</div>
						<div class="collection with-header href-underline">
							<div class="collection-header"><h2><?php echo $text_my_transactions; ?></h2></div>
							<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $transaction; ?>"><i class="material-icons left">history</i><?php echo $text_transaction; ?></a>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>