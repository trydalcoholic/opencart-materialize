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
				<?php $main = 's12 l6'; $goods = 's12'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; $goods = 's12 m6'; ?>
			<?php } else { ?>
				<?php $main = 's12'; $goods = 's12 m6 l4'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div class="col <?php echo $main; ?>">
					<div class="card-panel">
						<?php echo $content_top; ?>
						<?php if ($categories) { ?>
						<p>
							<strong><?php echo $text_index; ?></strong>
							<ul class="manufacturer-list section">
							<?php foreach ($categories as $category) { ?>
								<li class="waves-effect tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $text_manufacturers_starting; ?> &#34;<?php echo $category['name']; ?>&#34;"><a href="index.php?route=product/manufacturer#<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></li>
							<?php } ?>
							</ul>
						</p>
						<?php foreach ($categories as $category) { ?>
							<h2 id="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></h2>
							<hr>
							<?php if ($category['manufacturer']) { ?>
								<?php foreach (array($category['manufacturer']) as $manufacturers) { ?>
								<div class="row">
									<?php foreach ($manufacturers as $manufacturer) { ?>
										<div class="col s6 m4 l3 ">
											<div class="section center tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $text_view_all_products; ?> &#34;<?php echo $manufacturer['name']; ?>&#34;">
											<?php if ($manufacturer['logo']) { ?>
											<a class="waves-effect waves-light" href="<?php echo $manufacturer['href']; ?>"><img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $manufacturer['logo']; ?>" alt="<?php echo $manufacturer['name']; ?>"></a>
											<br>
											<?php } ?>
											<a class="grey-text text-darken-4 text-bold" href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a>
											</div>
										</div>
									<?php } ?>
								</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php } else { ?>
							<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
							<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/img/search-empty.png" alt="Ничего не найдено">
						<?php } ?>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>