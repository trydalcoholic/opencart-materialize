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
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<h2><?php echo $text_your_payment; ?></h2>
							<div class="input-field">
								<input type="text" name="tax" value="<?php echo $tax; ?>" id="input-tax" class="validate">
								<label for="input-tax"><?php echo $entry_tax; ?></label>
							</div>
							<div class="section">
								<div class="input-field">
									<span><?php echo $entry_payment; ?></span>
									<ul>
										<li>
											<?php if ($payment == 'cheque') { ?>
											<input type="radio" name="payment" value="cheque" checked="checked" id="payment-cheque-input" class="with-gap">
											<?php } else { ?>
											<input type="radio" name="payment" value="cheque" id="payment-cheque-input" class="with-gap">
											<?php } ?>
											<label for="payment-cheque-input"><?php echo $text_cheque; ?></label>
										</li>
										<li>
											<?php if ($payment == 'paypal') { ?>
											<input type="radio" name="payment" value="paypal" checked="checked" id="payment-paypal-input" class="with-gap">
											<?php } else { ?>
											<input type="radio" name="payment" value="paypal" id="payment-paypal-input" class="with-gap">
											<?php } ?>
											<label for="payment-paypal-input"><?php echo $text_paypal; ?></label>
										</li>
										<li>
											<?php if ($payment == 'bank') { ?>
											<input type="radio" name="payment" value="bank" checked="checked" id="payment-bank-input" class="with-gap">
											<?php } else { ?>
											<input type="radio" name="payment" value="bank" id="payment-bank-input" class="with-gap">
											<?php } ?>
											<label for="payment-bank-input"><?php echo $text_bank; ?></label>
										</li>
									</ul>
								</div>
							</div>
							<div class="input-field payment" id="payment-cheque">
								<input type="text" name="cheque" value="<?php echo $cheque; ?>" id="input-cheque" class="validate">
								<label for="input-cheque"><?php echo $entry_cheque; ?></label>
							</div>
							<div class="input-field payment" id="payment-paypal">
								<input type="text" name="paypal" value="<?php echo $paypal; ?>" id="input-paypal" class="validate">
								<label for="input-paypal"><?php echo $entry_paypal; ?></label>
							</div>
							<div class="payment" id="payment-bank">
								<div class="input-field">
									<input type="text" name="bank_name" value="<?php echo $bank_name; ?>" id="input-bank-name" class="validate">
									<label for="input-bank-name"><?php echo $entry_bank_name; ?></label>
								</div>
								<div class="input-field">
									<input type="text" name="bank_branch_number" value="<?php echo $bank_branch_number; ?>" id="input-bank-branch-number" class="validate">
									<label for="input-bank-branch-number"><?php echo $entry_bank_branch_number; ?></label>
								</div>
								<div class="input-field">
									<input type="text" name="bank_swift_code" value="<?php echo $bank_swift_code; ?>" id="input-bank-swift-code" class="validate">
									<label for="input-bank-swift-code"><?php echo $entry_bank_swift_code; ?></label>
								</div>
								<div class="input-field">
									<input type="text" name="bank_account_name" value="<?php echo $bank_account_name; ?>" id="input-bank-account-name" class="validate">
									<label for="input-bank-account-name"><?php echo $entry_bank_account_name; ?></label>
								</div>
								<div class="input-field">
									<input type="text" name="bank_account_number" value="<?php echo $bank_account_number; ?>" id="input-bank-account-number" class="validate">
									<label for="input-bank-account-number"><?php echo $entry_bank_account_number; ?></label>
								</div>
							</div>
							<div class="row">
								<div class="col s6">
									<div class="href-underline">
										<a class="btn btn-flat waves-effect waves-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
									</div>
								</div>
								<div class="col s6">
									<div class="flex-reverse no-padding">
										<input type="submit" class="btn waves-effect waves-light blue white-text" value="<?php echo $button_continue; ?>">
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
			$('input[name=\'payment\']').on('change', function() {
				$('.payment').hide();
				$('#payment-' + this.value).show();
			});
			$('input[name=\'payment\']:checked').trigger('change');
		});
	</script>
<?php echo $footer; ?>