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
							<ul class="author-list section">
							<?php foreach ($categories as $category) { ?>
								<li class="waves-effect tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $text_authors_starting; ?> &#34;<?php echo $category['name']; ?>&#34;"><a href="index.php?route=post/author#<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></li>&nbsp;
							<?php } ?>
							</ul>
						</p>
						<?php foreach ($categories as $category) { ?>
							<h2 id="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></h2>
							<hr>
							<?php if ($category['author']) { ?>
								<?php foreach (array($category['author']) as $authors) { ?>
								<div class="row">
									<?php foreach ($authors as $author) { ?>
										<div class="col s6 m4 l3 ">
											<div class="section center tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $text_view_all_posts; ?> &#34;<?php echo $author['name']; ?>&#34;">
											<?php if ($author['image']) { ?>
											<a class="waves-effect waves-light" href="<?php echo $author['href']; ?>"><img class="responsive-img circle lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $author['image']; ?>" alt="<?php echo $author['name']; ?>"></a>
											<br>
											<?php } ?>
											<a class="grey-text text-darken-4 text-bold" href="<?php echo $author['href']; ?>"><?php echo $author['name']; ?></a>
											</div>
										</div>
									<?php } ?>
								</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php } else { ?>
							<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
							<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/img/search-empty.png" alt="">
						<?php } ?>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>