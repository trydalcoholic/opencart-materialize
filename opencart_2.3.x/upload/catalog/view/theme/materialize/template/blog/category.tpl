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
			<?php $main = 's12 l6'; $goods = 's12'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
			<?php $main = 's12 l9'; $goods = 's12 m6'; ?>
		<?php } else { ?>
			<?php $main = 's12'; $goods = 's12 m6 xl4'; ?>
		<?php } ?>
		<div class="row">
			<?php echo $column_left; ?>
			<div id="content" class="col <?php echo $main; ?> section href-underline">
				<?php echo $content_top; ?>
				<h1><?php echo $heading_title; ?></h1>
					<?php if ($blog_posts) { ?>
						<div class="row masonry" data-columns>
						<?php foreach ($blog_posts as $blog_post) { ?>
							<div class="card blog-card">
								<div class="card-image">
									<div class="blog-image-wrap"><img class="scale transition lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $blog_post['image']; ?>"></div>
									<a class="btn-floating btn-large halfway-fab waves-effect waves-light blue-grey darken-1" href="<?php echo $blog_post['href']; ?>#form-review"><i class="material-icons">comment</i></a>
								</div>
								<div class="card-content blue-grey white-text">
									<a href="<?php echo $blog_post['href']; ?>" class="white-text"><span class="card-title truncate"><?php echo $blog_post['title']; ?></span></a>
								</div>
								<div class="blog-card-tabs">
									<ul class="tabs tabs-fixed-width tabs-swipe blue-grey lighten-5">
										<li class="tab"><a class="waves-effect waves-default" href="#tab-description-card<?php echo $blog_post['blog_post_id']; ?>" class="active"><i class="material-icons">description</i></a></li>
										<li class="tab"><a class="waves-effect waves-default" href="#tab-time-card<?php echo $blog_post['blog_post_id']; ?>"><i class="material-icons">info</i></a></li>
									</ul>
								</div>
								<div class="card-content">
									<div id="tab-description-card<?php echo $blog_post['blog_post_id']; ?>">
										<p><?php echo $blog_post['description']; ?></p>
									</div>
									<div id="tab-time-card<?php echo $blog_post['blog_post_id']; ?>">
										<ul>
											<?php if ($blog_post['author']) { ?>
											<li><span class="text-bold"><?php echo $text_author; ?></span>&nbsp;<?php echo $blog_post['author']; ?></li>
											<?php } ?>
											<li><span class="text-bold"><?php echo $text_published; ?></span>&nbsp;<?php echo date_format($blog_post['published'], 'd.m.Y'); ?></li>
										</ul>
									</div>
								</div>
								<div class="card-action">
									<a href="<?php echo $blog_post['href']; ?>" class="btn-flat waves-effect waves-default"><?php echo $text_read_more; ?></a>
								</div>
							</div>
						<?php } ?>
						</div>
						<?php if ($pagination) { ?>
						<div class="row">
							<?php echo $pagination; ?>
						</div>
						<?php } ?>
					<?php } ?>
					<?php if (!$blog_posts) { ?>
					<div class="card-panel center">
						<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
						<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/search-empty.png" alt="">
					</div>
					<?php } ?>
					<?php if ($description) { ?>
					<div class="card-panel z-depth-1">
						<div class="row valign-wrapper section">
							<?php if ($thumb) { ?>
							<div class="col s4 m2 center">
								<img src="<?php echo $img_loader; ?>" data-src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="responsive-img lazyload">
							</div>
							<div class="col s8 m10">
								<?php echo $description; ?>
							</div>
							<?php } else { ?>
							<div class="col s12">
								<?php echo $description; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				<?php echo $content_bottom; ?>
			</div>
			<?php echo $column_right; ?>
		</div>
	</div>
</main>
<?php echo $footer; ?>