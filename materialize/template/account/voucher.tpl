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
						<p><?php echo $text_description; ?></p>
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">account_circle</i>
									<input type="text" name="to_name" value="<?php echo $to_name; ?>" id="input-to-name" class="validate">
									<label for="input-to-name"><?php echo $entry_to_name; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">email</i>
									<input type="text" name="to_email" value="<?php echo $to_email; ?>" id="input-to-email" class="validate">
									<label for="input-to-email"><?php echo $entry_to_email; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">account_box</i>
									<input type="text" name="from_name" value="<?php echo $from_name; ?>" id="input-from-name" class="validate">
									<label for="input-from-name"><?php echo $entry_from_name; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">mail_outline</i>
									<input type="text" name="from_email" value="<?php echo $from_email; ?>" id="input-from-email" class="validate">
									<label for="input-from-email"><?php echo $entry_from_email; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">mode_edit</i>
									<label for="input-message"><?php echo $entry_message; ?></label>
									<textarea name="message" cols="40" rows="5" id="input-message" class="materialize-textarea tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $help_message; ?>"><?php echo $message; ?></textarea>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">cake</i>
									<?php foreach ($voucher_themes as $voucher_theme) { ?>
										<?php if ($voucher_theme['voucher_theme_id'] == $voucher_theme_id) { ?>
											<input id="voucher-theme-<?php echo $voucher_theme['voucher_theme_id']; ?>" class="with-gap" type="radio" name="voucher_theme_id" value="<?php echo $voucher_theme['voucher_theme_id']; ?>" checked="checked">
											<label for="voucher-theme-<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></label>
										<?php } else { ?>
											<input id="voucher-theme-<?php echo $voucher_theme['voucher_theme_id']; ?>" class="with-gap" type="radio" name="voucher_theme_id" value="<?php echo $voucher_theme['voucher_theme_id']; ?>">
											<label for="voucher-theme-<?php echo $voucher_theme['voucher_theme_id'] ?>"><?php echo $voucher_theme['name']; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">attach_money</i>
									<input type="text" name="amount" value="<?php echo $amount; ?>" id="input-amount" class="validate tooltipped" size="5" data-position="top" data-delay="50" data-tooltip="<?php echo $help_amount; ?>">
									<label for="input-amount"><?php echo $entry_amount; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<?php if ($agree) { ?>
										<input type="checkbox" name="agree" value="1" class="filled-in" id="text-agree" checked="checked">
									<?php } else { ?>
										<input type="checkbox" name="agree" value="1" class="filled-in" id="text-agree">
									<?php } ?>
									<label class="right" for="text-agree"><?php echo $text_agree; ?></label>
								</div>
							</div>
							<div class="flex-reverse">
								<input type="submit" value="<?php echo $button_continue; ?>" class="btn waves-effect waves-light red">
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
			<?php if ($error_warning) { ?>
				Materialize.toast('<span><i class="material-icons left">warning</i><?php echo $error_warning; ?></span>',7000,'toast-warning rounded')
			<?php } ?>
			<?php if ($error_to_name) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo str_replace('\'','&#39;',$error_to_name); ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($error_to_email) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $error_to_email; ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($error_from_name) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $error_from_name; ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($error_from_email) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $error_from_email; ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($error_theme) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $error_theme; ?></span>',7000,'toast-info rounded')
			<?php } ?>
			<?php if ($error_amount) { ?>
				Materialize.toast('<span><i class="material-icons left">info</i><?php echo $error_amount; ?></span>',7000,'toast-info rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>