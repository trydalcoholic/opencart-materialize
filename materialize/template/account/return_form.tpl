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
				<?php echo $content_top; ?>
				<div id="content" class="col <?php echo $main; ?>">
					<div class="card-panel">
						<p class="text-bold"><?php echo $text_description; ?></p>
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<p><?php echo $text_order; ?></p>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">account_circle</i>
									<input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="validate">
									<label for="input-firstname"><?php echo $entry_firstname; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">account_circle</i>
									<input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="validate">
									<label for="input-lastname"><?php echo $entry_lastname; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">phone</i>
									<input type="text" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" class="fvalidate">
									<label for="input-telephone"><?php echo $entry_telephone; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">email</i>
									<input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="fvalidate">
									<label for="input-email"><?php echo $entry_email; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">info</i>
									<input type="text" name="order_id" value="<?php echo $order_id; ?>" id="input-order-id" class="validate">
									<label for="input-order-id"><?php echo $entry_order_id; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<i class="material-icons prefix">date_range</i>
									<input type="date" name="date_ordered" value="<?php echo $date_ordered; ?>" id="input-date-ordered" class="datepicker">
									<label for="input-date-ordered"><?php echo $entry_date_ordered; ?></label>
								</div>
							</div>
							<p><?php echo $text_product; ?></p>
							<div class="row">
								<div class="input-field col s12 l6">
									<input type="text" name="product" value="<?php echo $product; ?>" id="input-product" class="validate">
									<label for="input-product"><?php echo $entry_product; ?></label>
								</div>
								<div class="input-field col s12 l6">
									<input type="text" name="model" value="<?php echo $model; ?>"  id="input-model" class="validate">
									<label for="input-model"><?php echo $entry_model; ?></label>
								</div>
								<div class="input-field col s12">
									<input type="text" name="quantity" value="<?php echo $quantity; ?>" id="input-quantity" class="validate">
									<label for="input-quantity"><?php echo $entry_quantity; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<p><?php echo $entry_reason; ?></p>
									<?php foreach ($return_reasons as $return_reason) { ?>
										<?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
											<input id="voucher-theme-<?php echo $return_reason['return_reason_id']; ?>" class="with-gap" type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" checked="checked">
											<label for="voucher-theme-<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label><br>
										<?php } else { ?>
											<input id="voucher-theme-<?php echo $return_reason['return_reason_id']; ?>" class="with-gap" type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>">
											<label for="voucher-theme-<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label><br>
										<?php } ?>
									<?php } ?>
								</div>
								<div class="input-field col s12">
									<p><?php echo $entry_opened; ?></p>
									<?php if ($opened) { ?>
										<input id="opened" type="radio" name="opened" value="1" class="with-gap" checked="checked">
									<?php } else { ?>
										<input id="opened" type="radio" name="opened" value="1" class="with-gap">
									<?php } ?>
									<label for="opened"><?php echo $text_yes; ?></label>
									<?php if (!$opened) { ?>
										<input id="non-opened" type="radio" name="opened" value="0" class="with-gap" checked="checked">
									<?php } else { ?>
										<input id="non-opened" type="radio" name="opened" value="0" class="with-gap">
									<?php } ?>
									<label for="non-opened"><?php echo $text_no; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<label for="input-comment"><?php echo $entry_fault_detail; ?></label>
									<textarea name="comment" rows="10" id="input-comment" class="materialize-textarea"><?php echo $comment; ?></textarea>
								</div>
							</div>
							<?php echo $captcha; ?>
							<?php if ($text_agree) { ?>
								<div class="row">
									<div class="col s12">
										<?php if ($agree) { ?>
											<input type="checkbox" name="agree" value="1" class="filled-in" id="text-agree" checked="checked">
										<?php } else { ?>
											<input type="checkbox" name="agree" value="1" class="filled-in" id="text-agree">
										<?php } ?>
										<label for="text-agree"><?php echo $text_agree; ?></label>
									</div>
								</div>
								<div class="flex-reverse">
									<input type="submit" value="<?php echo $button_submit; ?>" class="btn waves-effect waves-light red">
								</div>
							<?php } else { ?>
								<div class="flex-reverse">
									<input type="submit" value="<?php echo $button_submit; ?>" class="btn waves-effect waves-light red">
								</div>
							<?php } ?>
						</form>
					</div>
				</div>
				<?php echo $content_bottom; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($error_warning) { ?>
				Materialize.toast('<?php echo $error_warning; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_firstname) { ?>
				Materialize.toast('<?php echo $error_firstname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_lastname) { ?>
				Materialize.toast('<?php echo $error_lastname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_telephone) { ?>
				Materialize.toast('<?php echo $error_telephone; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_email) { ?>
				Materialize.toast('<?php echo $error_email; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_order_id) { ?>
				Materialize.toast('<?php echo $error_order_id; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_product) { ?>
				Materialize.toast('<?php echo $error_product; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_model) { ?>
				Materialize.toast('<?php echo $error_model; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_reason) { ?>
				Materialize.toast('<?php echo $error_reason; ?>',7000,'rounded')
			<?php } ?>
		});
	</script>
<?php echo $footer; ?>