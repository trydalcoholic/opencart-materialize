<h4><?php echo $text_captcha; ?></h4>
<?php if (substr($route, 0, 9) == 'checkout/') { ?>
	<div class="input-field">
		<input type="text" name="captcha" id="input-payment-captcha">
		<label for="input-payment-captcha"><?php echo $entry_captcha; ?></label>
		<img src="index.php?route=extension/captcha/basic_captcha/captcha" alt="">
	</div>
<?php } else { ?>
	<div class="input-field">
		<input type="text" name="captcha" id="input-captcha">
		<label for="input-captcha"><?php echo $entry_captcha; ?></label>
		<img src="index.php?route=extension/captcha/basic_captcha/captcha" alt="">
		<?php if ($error_captcha) { ?><script>document.addEventListener("DOMContentLoaded", function(event) {Materialize.toast(<?php echo $error_captcha; ?>,4000)});</script><?php } ?>
	</div>
<?php } ?>