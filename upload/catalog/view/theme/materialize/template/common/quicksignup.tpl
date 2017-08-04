<div id="modal-login" class="modal white">
	<div class="modal-content">
		<div class="row">
			<ul id="modal-login-tabs" class="tabs href-underline">
				<li class="tab col s6"><a href="#modal-login-tab-login" id="modal-login-tab-login__title" class="blue-grey-text text-darken-3 text-bold waves-effect waves-default"><?php echo $text_returning ?></a></li>
				<li class="tab col s6"><a href="#modal-login-tab-register" class="blue-grey-text text-darken-3 text-bold waves-effect waves-default"><?php echo $text_new_customer ?></a></li>
			</ul>
			<div id="modal-login-tab-login" class="col s12">
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">email</i>
						<input type="email" name="email" value="" id="input-email-login" class="validate">
						<label for="input-email-login" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>"><?php echo $entry_email; ?></label>
					</div>
					<div class="input-field col s12">
						<i class="material-icons prefix">lock</i>
						<input type="password" name="password" value="" id="input-password-login">
						<label for="input-password-login"><?php echo $entry_password; ?></label>
					</div>
				</div>
				<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
				<div class="flex-reverse">
					<button type="submit" value="<?php echo $button_login; ?>" id="btn-login-account" class="btn waves-effect waves-light red"><?php echo $button_login; ?></button>
				</div>
			</div>
			<div id="modal-login-tab-register" class="col s12">
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">person</i>
						<input type="text" name="name" value="" id="input-name-register" class="validate">
						<label for="input-name-register" class="required"><?php echo $entry_name; ?></label>
					</div>
					<div class="input-field col s12">
						<i class="material-icons prefix">email</i>
						<input type="email" name="email" value="" id="input-email-register" class="validate">
						<label for="input-email-register" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>" class="required"><?php echo $entry_email; ?></label>
					</div>
					<div class="input-field col s12">
						<i class="material-icons prefix">lock</i>
						<input type="password" name="password" value="" id="input-password-register" class="validate">
						<label for="input-password-register" class="required"><?php echo $entry_password; ?></label>
					</div>
					<div class="input-field col s12">
						<i class="material-icons prefix">phone</i>
						<input type="tel" name="telephone" value="" id="input-telephone-register" class="validate" placeholder="+7_(___)___-____" data-inputmask="'alias':'phone'">
						<label for="input-telephone-register" class="required"><?php echo $entry_telephone; ?></label>
					</div>
				</div>
				<?php if ($text_agree) { ?>
				<div class="section">
					<input type="checkbox" name="agree" value="1" id="agreement" class="filled-in">
					<label for="agreement"><?php echo $text_agree; ?></label>
					<div class="flex-reverse">
						<button type="button" id="btn-create-account" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
					</div>
				</div>
				<?php } else { ?>
				<div class="flex-reverse">
					<button type="button" id="btn-create-account" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(event) {
	$(document).ready(function() {
		 $('#modal-login').modal({
			ready: function(modal, trigger) {
				$('#modal-login-tab-login__title').trigger('click');
			}
		});
		$('#modal-login-tab-register input').on('keydown', function(e) {
			if (e.keyCode == 13) {
				$('#btn-create-account').trigger('click');
			}
		});
		$('#btn-create-account').click(function() {
			$.ajax({
				url: 'index.php?route=common/quicksignup/register',
				type: 'post',
				data: $('#modal-login-tab-register input[type=\'text\'], #modal-login-tab-register input[type=\'email\'], #modal-login-tab-register input[type=\'password\'], #modal-login-tab-register input[type=\'tel\'], #modal-login-tab-register input[type=\'checkbox\']:checked'),
				dataType: 'json',
				success: function(json) {
					if(json['islogged']){
						window.location.href="index.php?route=account/account";
					}
					if (json['error_name']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error_name"]+'</span>',7000,'toast-warning');
						$('#modal-login-tab-register #input-name-register').focus();
					}
					if (json['error_email']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error_email"]+'</span>',7000,'toast-warning');
						$('#modal-login-tab-register #input-email-register').focus();
					}
					if (json['error_telephone']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error_telephone"]+'</span>',7000,'toast-warning');
						$('#modal-login-tab-register #input-telephone-register').focus();
					}
					if (json['error_password']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error_password"]+'</span>',7000,'toast-warning');
						$('#modal-login-tab-register #input-password-register').focus();
					}
					if (json['error']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error"]+'</span>',7000,'toast-warning');
					}

					if (json['now_login']) {
						$('.modal-login-trigger').before('<li><a class="dropdown-button waves-effect waves-light" href="<?php echo $account; ?>" data-activates="dropdown-top-lk" data-beloworigin="true" data-constrainwidth="false" data-hover="true" rel="nofollow"><?php echo $text_account; ?></a><ul id="dropdown-top-lk" class="dropdown-content"><li><a class="waves-effect" href="<?php echo $account; ?>" rel="nofollow"><?php echo $text_account; ?></a></li><li class="divider"></li><li><a class="waves-effect" href="<?php echo $order; ?>" rel="nofollow"><?php echo $text_order; ?></a></li><li class="divider"></li><li><a class="waves-effect" href="<?php echo $transaction; ?>" rel="nofollow"><?php echo $text_transaction; ?></a></li><li class="divider"></li><li><a class="waves-effect" href="<?php echo $download; ?>" rel="nofollow"><?php echo $text_download; ?></a></li><li class="divider"></li><li><a class="waves-effect" href="<?php echo $logout; ?>" rel="nofollow"><?php echo $text_logout; ?></a></li></ul></li>');
						$('.modal-login-trigger').remove();
					}
					if (json['success']) {
						alert(json['text_message']);
					}
				}
			});
		});
		$('#modal-login-tab-login input').on('keydown', function(e) {
			if (e.keyCode == 13) {
				$('#btn-login-account').trigger('click');
			}
		});
		$('#btn-login-account').click(function() {
			$.ajax({
				url: 'index.php?route=common/quicksignup/login',
				type: 'post',
				data: $('#modal-login-tab-login input[type=\'email\'], #modal-login-tab-login input[type=\'password\']'),
				dataType: 'json',
				success: function(json) {
					if(json['islogged']){
						 window.location.href="index.php?route=account/account";
					}

					if (json['error']) {
						Materialize.toast('<span><i class="material-icons left">warning</i>'+json["error"]+'</span>',7000,'toast-warning');
						$('#modal-login-tab-login #input-email-login').focus();
					}
					if(json['success']){
						loacation();
						$('#modal-login').modal('close');
					}
				}
			});
		});
		function loacation() {
			location.reload();
		}
	});
});
</script>