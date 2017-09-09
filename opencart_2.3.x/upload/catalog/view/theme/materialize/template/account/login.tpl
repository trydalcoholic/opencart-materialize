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
					<div class="row">
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_new_customer; ?></h2>
								<p><strong><?php echo $text_register; ?></strong></p>
								<p><?php echo $text_register_account; ?></p>
								<div class="flex-reverse">
									<a href="<?php echo $register; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
								</div>
							</div>
						</div>
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_returning_customer; ?></h2>
								<p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
								<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
									<div class="input-field">
										<i class="material-icons prefix">email</i>
										<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
										<label for="input-email" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>"><?php echo $entry_email; ?></label>
									</div>
									<div class="input-field">
										<i class="material-icons prefix">lock</i>
										<input type="password" name="password" value="<?php echo $password; ?>" id="input-password">
										<label for="input-password"><?php echo $entry_password; ?></label>
									</div>
									<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
									<div class="flex-reverse">
										<button type="submit" value="<?php echo $button_login; ?>" class="btn waves-effect waves-light red"><?php echo $button_login; ?></button>
									</div>
									<?php if ($redirect) { ?>
									<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
									<?php } ?>
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
				Materialize.toast('<?php echo $success; ?>',7000)
			<?php } ?>
			<?php if ($error_warning) { ?>
				Materialize.toast('<?php echo $error_warning; ?>',7000)
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>