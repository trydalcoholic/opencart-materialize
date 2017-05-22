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
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
							<div class="input-field">
								<input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="validate">
								<label for="input-firstname" class="required"><?php echo $entry_firstname; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="validate">
								<label for="input-lastname" class="required"><?php echo $entry_lastname; ?></label>
							</div>
							<div class="input-field">
								<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
								<label for="input-email" class="required"><?php echo $entry_email; ?></label>
							</div>
							<div class="input-field">
								<input type="tel" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" class="validate" placeholder="+7_(___)___-____" data-inputmask="'alias':'phone'">
								<label for="input-telephone" class="required"><?php echo $entry_telephone; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="fax" value="<?php echo $fax; ?>" id="input-fax" class="validate">
								<label for="input-fax"><?php echo $entry_fax; ?></label>
							</div>
							<div class="row">
								<div class="col s6">
									<a href="<?php echo $back; ?>" class="btn-flat waves-effect waves-light href-underline"><?php echo $button_back; ?></a>
								</div>
								<div class="col s6">
									<div class="flex-reverse no-padding">
										<input type="submit" value="<?php echo $button_continue; ?>" class="btn waves-effect waves-light red">
									</div>
								</div>
							</div>
						</form>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($error_firstname) { ?>
				Materialize.toast('<?php echo $error_firstname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_lastname) { ?>
				Materialize.toast('<?php echo $error_lastname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_email) { ?>
				Materialize.toast('<?php echo $error_email; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_telephone) { ?>
				Materialize.toast('<?php echo $error_telephone; ?>',7000,'rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>