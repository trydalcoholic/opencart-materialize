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
					<div class="row">
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_new_customer; ?></h2>
								<p><strong><?php echo $text_register; ?></strong></p>
								<p><?php echo $text_register_account; ?></p>
								<a href="<?php echo $register; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
							</div>
						</div>
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_returning_customer; ?></h2>
								<p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
								<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">email</i>
											<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
											<label for="input-email" data-error="Ошибка при вводе e-mail" data-success="E-mail введён верно"><?php echo $entry_email; ?></label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">lock</i>
											<input type="password" name="password" value="<?php echo $password; ?>" id="input-password">
											<label for="input-password"><?php echo $entry_password; ?></label>
											<a class="right" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
										</div>
										<div class="col s12">
											<input type="submit" value="<?php echo $button_login; ?>" class="btn waves-effect waves-light red href-underline" />
											<?php if ($redirect) { ?>
											<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
											<?php } ?>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($success) { ?>
				Materialize.toast('<?php echo $success; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_warning) { ?>
				Materialize.toast('<?php echo $error_warning; ?>',7000,'rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>