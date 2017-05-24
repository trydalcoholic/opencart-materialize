<script async src="//www.google.com/recaptcha/api.js"></script>
<div class="section" style="overflow:auto;">
	<?php if (substr($route, 0, 9) == 'checkout/') { ?>
	<label for="input-payment-captcha"><?php echo $entry_captcha; ?></label>
	<div id="input-payment-captcha" class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
		<?php if ($error_captcha) { ?>
		<script>
			document.addEventListener("DOMContentLoaded", function(event) {
				Materialize.toast('<?php echo $error_captcha; ?>',4000,'rounded')
			});
		</script>
		<?php } ?>
	<?php } else { ?>
	<div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
		<?php if ($error_captcha) { ?>
		<script>
			document.addEventListener("DOMContentLoaded", function(event) {
				Materialize.toast('<?php echo $error_captcha; ?>',4000,'rounded')
			});
		</script>
		<?php } ?>
	<?php } ?>
</div>