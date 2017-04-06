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
						<div class="row">
							<div class="col s12 xl6">
								<div class="collection with-header href-underline">
									<div class="collection-header"><h2><?php echo $text_my_account; ?></h2></div>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $edit; ?>"><?php echo $text_edit; ?><i class="material-icons left">assignment</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $password; ?>"><?php echo $text_password; ?><i class="material-icons left">lock</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $address; ?>"><?php echo $text_address; ?><i class="material-icons left">home</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?><i class="material-icons left">favorite</i></a>
								</div>
							</div>
							<div class="col s12 xl6">
								<div class="collection with-header href-underline">
									<div class="collection-header"><h2><?php echo $text_my_orders; ?></h2></div>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $order; ?>"><?php echo $text_order; ?><i class="material-icons left">history</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $download; ?>"><?php echo $text_download; ?><i class="material-icons left">file_download</i></a>
									<?php if ($reward) { ?>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $reward; ?>"><?php echo $text_reward; ?><i class="material-icons left">account_balance_wallet</i></a>
									<?php } ?>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $return; ?>"><?php echo $text_return; ?><i class="material-icons left">cached</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?><i class="material-icons left">payment</i></a>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?><i class="material-icons left">receipt</i></a>
								</div>
							</div>
							<?php if ($credit_cards) { ?>
							<div class="col s12 xl6">
								<div class="collection with-header href-underline">
									<div class="collection-header"><h2><?php echo $text_credit_card; ?></h2></div>
									<?php foreach ($credit_cards as $credit_card) { ?>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $credit_card['href']; ?>"><?php echo $credit_card['name']; ?></a>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
							<div class="col s12 xl6">
								<div class="collection with-header href-underline">
									<div class="collection-header"><h2><?php echo $text_my_newsletter; ?></h2></div>
									<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?><i class="material-icons left">add_alert</i></a>
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