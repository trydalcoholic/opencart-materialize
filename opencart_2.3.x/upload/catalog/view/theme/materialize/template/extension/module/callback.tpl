<form id="callback__modal" class="modal">
	<div class="modal-content">
		<i class="material-icons modal-action modal-close right">close</i>
		<div class="row"><h4><?php echo $heading_title; ?></h4></div>
		<div class="row">
			<div class="input-field col s12">
				<i class="material-icons prefix">account_circle</i>
				<input id="callback-name" name="callback_name" placeholder="<?php echo $entry_name; ?>" type="text" class="validate" required>
				<label class="active" for="callback-name"><?php echo $entry_name; ?></label>
			</div>
			<div class="input-field col s12">
				<i class="material-icons prefix">phone</i>
				<input id="callback-telephone" name="callback_telephone" type="tel" class="validate" placeholder="+7(___)___-____" data-inputmask="'alias':'phone'" required>
				<label class="active" for="callback-telephone"><?php echo $entry_telephone; ?></label>
			</div>
		</div>
	</div>
	<div class="modal-footer href-underline">
		<button type="button" id="callback__button" class="btn modal-action waves-effect waves-light red" value="<?php $button_submit; ?>"><?php echo $button_submit; ?></button>
	</div>
</form>
<?php if ($callback_status == 1) { ?>
<button type="button" data-target="callback__modal" id="callback__btn" class="btn-floating btn-large green darken-1 z-depth-4 waves-effect waves-light pulse modal-trigger"><i id="callback__phone-icon" class="material-icons">phone</i></button>
<div id="callback__attract" class="tap-target green lighten-1" data-activates="callback__btn">
	<div class="tap-target-content white-text">
		<i class="material-icons waves-effect waves-circle right">close</i>
		<h5 class="text-bold"><?php echo $attract_title; ?></h5>
		<p><?php echo $attract_text; ?></p>
	</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	idleTimer = null;
	idleState = false;
	idleWait = 45000;

	var callbackAttract = $('#callback__attract'),
		callbackPhoneIcon = $('#callback__phone-icon');

	setInterval(function() {
		callbackPhoneIcon.toggleClass('callback-shake');
	}, 5000)

	$(document).bind('mousemove keydown scroll', function() {
		clearTimeout(idleTimer);

		if(idleState == true) { 
			callbackAttract.tapTarget('open');
		}

		idleState = false;
		idleTimer = setTimeout(function() { 
			callbackAttract.tapTarget('open');
			idleState = true; 
		}, idleWait);
	});
	$("body").trigger("mousemove");
});
</script>
<?php } ?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {	
	$('#callback__button').on('click', function() {
		$.ajax({
			url: 'index.php?route=extension/module/callback/send',
			type: 'post',
			dataType: 'json',
			data: $("#callback__modal").serialize(),
			success: function(json) {
				if (json['error']) {
					Materialize.toast('<i class="material-icons left">warning</i>'+json['error'],7000,'toast-warning');
				}
				if (json['success']) {
					Materialize.toast('<i class="material-icons left">check</i>'+json['success'],7000,'toast-success');
					$('input[name=\'callback_name\']').val('');
					$('input[name=\'callback_telephone\']').val('');
					$('#callback__modal').modal('close');
				}
			}
		});
	});
});
</script>