<li>
	<div class="collapsible-header grey lighten-5"><i class="material-icons">card_giftcard</i><span><?php echo $heading_title; ?></span></div>
	<div class="collapsible-body">
		<div class="input-field">
			<input type="text" name="voucher" value="<?php echo $voucher; ?>" id="input-voucher" class="validate">
			<label for="input-voucher"><?php echo $entry_voucher; ?></label>
		</div>
		<div class="flex-reverse">
			<button type="button" value="<?php echo $button_voucher; ?>" id="button-voucher" class="btn blue waves-effect waves-light right"><?php echo $button_voucher; ?></button>
		</div>
	</div>
</li>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('#button-voucher').on('click', function() {
			$.ajax({
				url: 'index.php?route=extension/total/voucher/voucher',
				type: 'post',
				data: 'voucher=' + encodeURIComponent($('input[name=\'voucher\']').val()),
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						Materialize.toast('<i class="material-icons left">check</i>'+json['error'],7000,'toast-warning rounded');
					}
					if (json['redirect']) {
						location = json['redirect'];
					}
				}
			});
		});
	});
</script>