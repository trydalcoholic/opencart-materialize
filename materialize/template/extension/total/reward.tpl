<li>
	<div class="collapsible-header grey lighten-5"><i class="material-icons">account_balance_wallet</i><span><?php echo $heading_title; ?></span></div>
	<div class="collapsible-body">
		<div class="input-field">
			<input type="text" name="reward" value="<?php echo $reward; ?>" id="input-reward">
			<label for="input-reward"><?php echo $entry_reward; ?></label>
		</div>
		<div class="flex-reverse">
			<input type="submit" value="<?php echo $button_reward; ?>" id="button-reward" class="btn blue waves-effect waves-light right">
		</div>
	</div>
</li>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('#button-reward').on('click', function() {
			$.ajax({
				url: 'index.php?route=extension/total/reward/reward',
				type: 'post',
				data: 'reward=' + encodeURIComponent($('input[name=\'reward\']').val()),
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