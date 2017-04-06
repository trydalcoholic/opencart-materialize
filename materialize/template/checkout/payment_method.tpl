<div class="row">
	<div class="col s12 l6 offset-l3">
		<div class="card-panel">
		<?php if ($error_warning) { ?>
			<?php echo $error_warning; ?>
		<?php } ?>
		<?php if ($payment_methods) { ?>
			<h4 class="text-bold"><?php echo $text_payment_method; ?></h4>
			<div class="row">
				<div class="col s12">
					<div class="section">
						<?php foreach ($payment_methods as $payment_method) { ?>
							<?php if ($payment_method['code'] == $code || !$code) { ?>
							<?php $code = $payment_method['code']; ?>
								<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" id="<?php echo $payment_method['code']; ?>" class="with-gap">
							<?php } else { ?>
								<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" class="with-gap">
							<?php } ?>
							<label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?><?php if ($payment_method['terms']) { ?>(<?php echo $payment_method['terms']; ?>)<?php } ?></label>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="row">
			<div class="col s12">
				<div class="section">
					<strong><?php echo $text_comments; ?></strong>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<i class="material-icons prefix">&#xE0C9;</i>
				<textarea name="comment" rows="8" class="materialize-textarea"><?php echo $comment; ?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
				<div class="section">
					<?php if ($text_agree) { ?>
					<?php if ($agree) { ?>
					<input type="checkbox" name="agree" value="1" checked="checked" id="agreement" class="filled-in">
					<?php } else { ?>
					<input type="checkbox" name="agree" value="1" id="agreement" class="filled-in">
					<?php } ?>
					<label for="agreement"><?php echo $text_agree; ?></label>
					<div class="col s12"><div class="section"><input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="btn waves-effect waves-light red right" /></div></div>
					<?php } else { ?>
					<div class="col s12"><div class="section"><input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="btn waves-effect waves-light red right" /></div></div>
					<?php } ?>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>