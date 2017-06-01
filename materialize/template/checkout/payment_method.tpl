<div class="row">
	<div class="col s12 l6 offset-l3">
		<div class="card-panel">
			<?php if ($payment_methods) { ?>
				<h4 class="text-bold"><?php echo $text_payment_method; ?></h4>
				<div class="section">
					<?php foreach ($payment_methods as $payment_method) { ?>
						<?php if ($payment_method['code'] == $code || !$code) { ?>
						<?php $code = $payment_method['code']; ?>
							<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" id="<?php echo $payment_method['code']; ?>" class="with-gap">
						<?php } else { ?>
							<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" class="with-gap">
						<?php } ?>
						<label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?><?php if ($payment_method['terms']) { ?>(<?php echo $payment_method['terms']; ?>)<?php } ?></label><br>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="section">
				<strong><?php echo $text_comments; ?></strong>
				<div class="input-field">
					<i class="material-icons prefix">comment</i>
					<textarea name="comment" rows="8" class="materialize-textarea"><?php echo $comment; ?></textarea>
				</div>
			</div>
			<div class="section">
				<?php if ($text_agree) { ?>
				<?php if ($agree) { ?>
				<input type="checkbox" name="agree" value="1" checked="checked" id="agreement" class="filled-in">
				<?php } else { ?>
				<input type="checkbox" name="agree" value="1" id="agreement" class="filled-in">
				<?php } ?>
				<label for="agreement"><?php echo $text_agree; ?></label>
				<div class="flex-reverse">
					<button type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
				</div>
				<?php } else { ?>
				<div class="flex-reverse">
					<button type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		<?php if ($error_warning) { ?>
			Materialize.toast('<i class="material-icons left">warning</i><?php echo $error_warning; ?>',7000,'toast-warning rounded')
		<?php } ?>
	});
</script>