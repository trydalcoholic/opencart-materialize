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
				<?php $main = 's12'; $goods = 's12 m6 l4'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div class="col s12">
					<div class="card-panel z-depth-1">
						<div class="row valign-wrapper section">
							<?php if ($thumb) { ?>
							<div class="col s4 m2 center">
								<img src="<?php echo $img_loader; ?>" data-src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="responsive-img circle lazyload">
							</div>
							<div class="col s8 m10">
								<h1><?php echo $heading_title; ?></h1>
								<?php echo $description; ?>
							</div>
							<?php } else { ?>
							<div class="col s12">
								<h1><?php echo $heading_title; ?></h1>
								<?php echo $description; ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php if ($posts) { ?>
				<div class="col <?php echo $main; ?> section href-underline">
					<?php echo $content_top; ?>
					<ul class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header text-bold arrow-rotate"><?php echo $text_sort; ?></div>
							<div class="collapsible-body white">
								<div class="row">
									<div class="col s6 m6 input-field inline">
										<select id="input-sort" onchange="location = this.value;">
											<?php foreach ($sorts as $sorts) { ?>
											<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
											<option value="<?php echo $sorts['href']; ?>" selected><?php echo $sorts['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold" for="input-sort"><?php echo $text_sort; ?></label>
									</div>
									<div class="col s6 m6 input-field inline">
										<select id="input-limit" onchange="location = this.value;">
											<?php foreach ($limits as $limits) { ?>
											<?php if ($limits['value'] == $limit) { ?>
											<option value="<?php echo $limits['href']; ?>" selected><?php echo $limits['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_limit; ?></label>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div id="content">
						<div class="row masonry" data-columns>
							<?php foreach ($posts as $post) { ?>
							<div class="card blog-card hoverable">
								<div class="card-image">
									<div class="blog-image-wrap"><img class="scale transition lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $post['thumb']; ?>"></div>
									<a class="btn-floating btn-large halfway-fab waves-effect waves-light blue-grey darken-1" href="<?php echo $post['href']; ?>#comment"><i class="material-icons">comment</i></a>
								</div>
								<div class="card-content blue-grey white-text">
									<a href="<?php echo $post['href']; ?>" class="white-text"><span class="card-title truncate"><?php echo $post['name']; ?></span></a>
								</div>
								<div class="blog-card-tabs">
									<ul class="tabs tabs-fixed-width tabs-swipe blue-grey lighten-5">
										<li class="tab"><a class="waves-effect waves-default" href="#tab-description-card<?php echo $post['post_id']; ?>" class="active"><i class="material-icons">description</i></a></li>
										<li class="tab"><a class="waves-effect waves-default" href="#tab-time-card<?php echo $post['post_id']; ?>"><i class="material-icons">info</i></a></li>
									</ul>
								</div>
								<div class="card-content">
									<div id="tab-description-card<?php echo $post['post_id']; ?>">
										<p><?php echo $post['description']; ?></p>
									</div>
									<div id="tab-time-card<?php echo $post['post_id']; ?>">
										<ul>
											<?php if ($post['author']) { ?>
											<li><span class="text-bold"><?php echo $text_author; ?></span>&nbsp;<?php echo $post['author']; ?></li>
											<?php } ?>
											<li><span class="text-bold"><?php echo $text_published; ?></span>&nbsp;<?php echo date_format($post['published'], 'd.m.Y'); ?></li>
										</ul>
									</div>
								</div>
								<div class="card-action">
									<a href="<?php echo $post['href']; ?>" class="btn-flat waves-effect waves-default"><?php echo $text_read_more; ?></a>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php if ($pagination) { ?>
					<div class="row">
						<?php echo $pagination; ?>
					</div>
					<?php } ?>
					<?php echo $content_bottom; ?>
				</div>
				<?php } ?>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>