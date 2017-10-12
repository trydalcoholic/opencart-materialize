<form id="callback__modal" class="modal">
	<div class="modal-content">
		<i class="material-icons modal-action modal-close waves-effect waves-circle close-icon">close</i>
		<div class="row"><h4><?php echo $callback_modaltitle; ?></h4></div>
		<div class="row">
			<?php if ($callback_name) { ?>
			<div class="input-field col s12">
				<i class="material-icons prefix">account_circle</i>
				<input id="callback-name" name="callback_name" type="text" class="validate" <?php echo $callback_name_required ? 'required' : ''; ?>>
				<label for="callback-name" <?php echo $callback_name_required ? 'class="required"' : ''; ?>><?php echo $entry_name; ?></label>
			</div>
			<?php } ?>
			<div class="input-field col s12">
				<i class="material-icons prefix">phone</i>
				<input id="callback-telephone" name="callback_telephone" type="tel" class="validate" <?php echo $callback_phonemask ? 'data-inputmask="\'alias\':\'phone\'"' : ''; ?> required>
				<label for="callback-telephone" class="required"><?php echo $entry_telephone; ?></label>
			</div>
			<?php if ($callback_enquiry) { ?>
			<div class="input-field col s12">
				<i class="material-icons prefix">chat</i>
				<textarea id="callback-enquiry" name="callback_enquiry" class="materialize-textarea" data-length="360" <?php echo $callback_enquiry_required ? 'required' : ''; ?>></textarea>
				<label for="callback-enquiry" <?php echo $callback_enquiry_required ? 'class="required"' : ''; ?>><?php echo $entry_enquiry; ?></label>
			</div>
			<?php } ?>
			<?php if ($callback_calltime) { ?>
			<div class="input-field col s12">
				<i class="material-icons prefix">av_timer</i>
				<input type="text" id="callback-calltime" class="timepicker-<?php echo $lang; ?>" name="callback_calltime" value="">
				<label for="callback-calltime" <?php echo $callback_calltime_required ? 'class="required"' : ''; ?>><?php echo $entry_calltime; ?></label>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="modal-footer href-underline">
		<button type="button" id="callback__button" class="btn modal-action waves-effect waves-light red" value="<?php $button_submit; ?>"><?php echo $button_submit; ?></button>
	</div>
</form>
<?php if ($callback_status) { ?>
<button type="button" data-target="callback__modal" id="callback__btn" class="btn-floating btn-large green darken-1 z-depth-4 waves-effect waves-light pulse modal-trigger"><i id="callback__phone-icon" class="material-icons">phone</i></button>
<div id="callback__attract" class="tap-target green lighten-1" data-activates="callback__btn">
	<div class="tap-target-content white-text">
		<i id="callback__attract-close" class="material-icons waves-effect waves-circle right">close</i>
		<h5 class="text-bold"><?php echo $attract_title; ?></h5>
		<p><?php echo $attract_description; ?></p>
	</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	var callbackAttract = $('#callback__attract'),
		callbackPhoneIcon = $('#callback__phone-icon');

	setInterval(function() {
		callbackPhoneIcon.toggleClass('callback-shake');
	}, 2500);

	idleTimer = null;
	idleState = false;
	idleWait = <?php echo $callback_time;?>000;

	$(document).bind('mousemove keydown scroll', function() {
		clearTimeout(idleTimer);

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
					$('input[name=\'callback_telephone\']').val('').blur();
					<?php if ($callback_name) { ?>
					$('input[name=\'callback_name\']').val('').blur();
					<?php } ?>
					<?php if ($callback_enquiry) { ?>
					$('input[name=\'callback_enquiry\']').val('').blur();
					<?php } ?>
					<?php if ($callback_calltime) { ?>
					$('input[name=\'callback_calltime\']').val('').blur();
					<?php } ?>
					$('#callback__modal').modal('close');
				}
			}
		});
	});
});
</script>