<div class="row">
	<div class="col s12 l6 offset-l3">
		<div class="card-panel">
			<?php if ($error_warning) { ?>
				<?php echo $error_warning; ?>
			<?php } ?>
			<?php if ($shipping_methods) { ?>
				<h4 class="text-bold"><?php echo $text_shipping_method; ?></h4>
				<div class="section">
				<?php foreach ($shipping_methods as $shipping_method) { ?>
					<?php if (!$shipping_method['error']) { ?>
					<?php foreach ($shipping_method['quote'] as $quote) { ?>
						<?php if ($quote['code'] == $code || !$code) { ?>
						<?php $code = $quote['code']; ?>
							<input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked" id="<?php echo $quote['code']; ?>" class="with-gap">
						<?php } else { ?>
							<input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" class="with-gap">
						<?php } ?>
							<label for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></label><br>
						<?php } ?>
					<?php } else { ?>
						<?php echo $shipping_method['error']; ?>
					<?php } ?>
				<?php } ?>
				</div>
			<?php } ?>
			<div class="section">
				<strong><?php echo $text_comments; ?></strong>
				<div class="input-field">
					<i class="material-icons prefix">message</i>
					<textarea name="comment" rows="8" class="materialize-textarea"></textarea>
				</div>
			</div>
			<div class="flex-reverse">
				<button type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
			</div>
		</div>
	</div>
</div>