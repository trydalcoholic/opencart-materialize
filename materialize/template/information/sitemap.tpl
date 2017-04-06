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
				<?php echo $content_top; ?>
				<div class="col s12 m6">
					<ul>
					<?php foreach ($categories as $category_1) { ?>
					<li><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
					<?php if ($category_1['children']) { ?>
					<ul>
					<?php foreach ($category_1['children'] as $category_2) { ?>
					<li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
					<?php if ($category_2['children']) { ?>
					<ul>
					<?php foreach ($category_2['children'] as $category_3) { ?>
					<li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
					<?php } ?>
					</ul>
					<?php } ?>
					</li>
					<?php } ?>
					</ul>
					<?php } ?>
					</li>
					<?php } ?>
					</ul>
				</div>
				<div class="col s12 m6">
					<ul>
					<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
					<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
					<ul>
					<li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
					<li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
					<li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
					<li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
					<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
					</ul>
					</li>
					<li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
					<li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
					<li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
					<li><?php echo $text_information; ?>
					<ul>
					<?php foreach ($informations as $information) { ?>
					<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
					<?php } ?>
					<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
					</ul>
					</li>
					</ul>
				</div>
				<?php echo $content_bottom; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>