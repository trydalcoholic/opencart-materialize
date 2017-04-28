<li>
	<div class="collapsible-header grey lighten-5"><i class="material-icons">loyalty</i><span><?php echo $heading_title; ?></span></div>
	<div class="collapsible-body">
		<div class="input-field">
			<input type="text" name="coupon" value="<?php echo $coupon; ?>" id="input-coupon" class="validate">
			<label for="input-coupon"><?php echo $entry_coupon; ?></label>
		</div>
		<div class="flex-reverse">
			<button type="button" value="<?php echo $button_coupon; ?>" id="button-coupon" class="btn blue waves-effect waves-light right"><?php echo $button_coupon; ?></button>
		</div>
	</div>
</li>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('#button-coupon').on('click', function() {
			$.ajax({
				url: 'index.php?route=extension/total/coupon/coupon',
				type: 'post',
				data: 'coupon=' + encodeURIComponent($('input[name=\'coupon\']').val()),
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