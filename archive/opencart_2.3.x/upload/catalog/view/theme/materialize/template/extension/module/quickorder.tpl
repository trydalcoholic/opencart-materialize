<?php if ($module_quickorder_status) { ?>
<form id="quickorder__modal" class="modal white">
	<div class="modal-content">
		<i class="material-icons modal-action modal-close waves-effect waves-circle close-icon">close</i>
		<h4><?php echo $module_quickorder_button; ?> — <?php echo $product_title; ?></h4>
		<div class="row">
			<?php if ($thumb) { ?>
			<div class="col s12 m6 center">
				<figure>
					<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $thumb; ?>" alt="<?php echo $module_quickorder_button; ?> — <?php echo $product_title; ?>">
					<figcaption><?php echo $module_quickorder_button; ?> — <?php echo $product_title; ?></figcaption>
				</figure>
			</div>
			<?php } ?>
			<div class="col s12 <?php echo $thumb ? 'm6' : '' ?>">
				<div class="row">
					<?php if ($module_quickorder_name) { ?>
					<div class="input-field col s12">
						<i class="material-icons prefix">account_circle</i>
						<input id="quickorder-name" name="module_quickorder_name" type="text" class="validate" <?php echo $module_quickorder_name_required ? 'required' : ''; ?>>
						<label for="quickorder-name" <?php echo $module_quickorder_name_required ? 'class="required"' : ''; ?>><?php echo $entry_name; ?></label>
					</div>
					<?php } ?>
					<div class="input-field col s12">
						<i class="material-icons prefix">phone</i>
						<input id="quickorder-telephone" name="module_quickorder_telephone" type="tel" class="validate" <?php echo $module_quickorder_phonemask_status ? 'data-inputmask="\'alias\':\'phone\'"' : ''; ?> required>
						<label for="quickorder-telephone" class="required"><?php echo $entry_telephone; ?></label>
					</div>
					<?php if ($module_quickorder_email) { ?>
					<div class="input-field col s12">
						<i class="material-icons prefix">email</i>
						<input id="quickorder-email" name="module_quickorder_email" type="email" class="validate" <?php echo $module_quickorder_email_required ? 'required' : ''; ?>>
						<label for="quickorder-email" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>" <?php echo $module_quickorder_email_required ? 'class="required"' : ''; ?>><?php echo $entry_email; ?></label>
					</div>
					<?php } ?>
					<?php if ($module_quickorder_enquiry) { ?>
					<div class="input-field col s12">
						<i class="material-icons prefix">chat</i>
						<textarea id="quickorder-enquiry" name="module_quickorder_enquiry" class="materialize-textarea" data-length="360" <?php echo $module_quickorder_enquiry_required ? 'required' : ''; ?>></textarea>
						<label for="quickorder-enquiry" <?php echo $module_quickorder_enquiry_required ? 'class="required"' : ''; ?>><?php echo $entry_enquiry; ?></label>
					</div>
					<?php } ?>
					<?php if ($module_quickorder_calltime) { ?>
					<div class="input-field col s12">
						<i class="material-icons prefix">av_timer</i>
						<input type="text" id="quickorder-calltime" class="timepicker" name="module_quickorder_calltime" value="">
						<label for="quickorder-calltime" <?php echo $module_quickorder_calltime_required ? 'class="required"' : ''; ?>><?php echo $entry_calltime; ?></label>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php if ($text_agree) { ?>
		<div class="row">
			<div class="col s12">
				<?php if ($module_quickorder_agree) { ?>
				<input type="checkbox" name="module_quickorder_agree" value="1" checked="checked" id="agreement-check-quickorder" class="filled-in">
				<?php } else { ?>
				<input type="checkbox" name="module_quickorder_agree" value="1" id="agreement-check-quickorder" class="filled-in">
				<?php } ?>
				<label for="agreement-check-quickorder"><?php echo $text_agree; ?></label>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="quickorder_product_title" value="<?php echo $product_title; ?>">
		<input type="hidden" name="quickorder_product_link" value="<?php echo $product_link; ?>">
		<button type="button" id="quickorder__button" class="btn modal-action waves-effect waves-light red" value="<?php $button_submit; ?>"><?php echo $button_submit; ?></button>
	</div>
</form>
<div class="section">
	<button type="button" data-target="quickorder__modal" id="quickorder__btn" class="btn btn-large waves-effect waves-light width-max modal-trigger <?php echo $module_quickorder_color_btn; ?> <?php echo $module_quickorder_color_btn_text; ?>"><i class="material-icons left">shopping_cart</i><?php echo $module_quickorder_button; ?></button>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	<?php if ($module_quickorder_calltime) { ?>
	$('.timepicker').pickatime({
		default: 'now',
		twelvehour: <?php echo $twelve_hour; ?>,
		donetext: '<?php echo $button_time_done; ?>',
		cleartext: '<?php echo $button_time_clear; ?>',
		canceltext: '<?php echo $button_time_cancel; ?>',
		autoclose: true
	});
	<?php } ?>
	$('#quickorder__button').on('click', function() {
		$.ajax({
			url: 'index.php?route=extension/module/quickorder/send',
			type: 'post',
			dataType: 'json',
			data: $("#quickorder__modal").serialize(),
			success: function(json) {
				if (json['error']) {
					Materialize.toast('<i class="material-icons left">warning</i>'+json['error'],7000,'toast-warning');
				}
				if (json['success']) {
					Materialize.toast('<i class="material-icons left">check</i>'+json['success'],7000,'toast-success');
					$('input[name=\'module_quickorder_telephone\']').val('').blur();
					<?php if ($module_quickorder_name) { ?>
					$('input[name=\'module_quickorder_name\']').val('').blur();
					<?php } ?>
					<?php if ($module_quickorder_email) { ?>
					$('input[name=\'module_quickorder_email\']').val('').blur();
					<?php } ?>
					<?php if ($module_quickorder_enquiry) { ?>
					$('textarea[name=\'module_quickorder_enquiry\']').val('').blur();
					$('textarea[name=\'module_quickorder_enquiry\']').trigger('autoresize');
					<?php } ?>
					<?php if ($module_quickorder_calltime) { ?>
					$('input[name=\'module_quickorder_calltime\']').val('').blur();
					<?php } ?>
					<?php if ($text_agree) { ?>
					$('input[name=\'module_quickorder_agree\']').prop('checked', false);
					<?php } ?>
					$('#quickorder__modal').modal('close');
				}
			}
		});
	});
});
</script>
<?php } ?>