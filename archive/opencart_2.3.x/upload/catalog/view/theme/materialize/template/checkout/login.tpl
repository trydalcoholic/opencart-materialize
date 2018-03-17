<div class="row">
	<div class="col s12 m6">
		<div class="card-panel z-depth-2">
			<h2><?php echo $text_new_customer; ?></h2>
			<div class="section">
				<?php if ($account == 'register') { ?>
					<input type="radio" name="account" value="register" checked="checked" id="register" class="with-gap">
					<?php } else { ?>
					<input type="radio" name="account" value="register" id="register" class="with-gap">
				<?php } ?>
				<label for="register"><?php echo $text_register; ?></label><br>
				<?php if ($checkout_guest) { ?>
					<?php if ($account == 'guest') { ?>
					<input type="radio" name="account" value="guest" checked="checked" id="guest" class="with-gap">
					<?php } else { ?>
					<input type="radio" name="account" value="guest" id="guest" class="with-gap">
					<?php } ?>
				<label for="guest"><?php echo $text_guest; ?></label>
				<?php } ?>
			</div>
			<button type="button" value="<?php echo $button_continue; ?>" id="button-account" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
		</div>
	</div>
	<div class="col s12 m6">
		<div class="card-panel z-depth-2">
			<h2><?php echo $text_returning_customer; ?></h2>
			<strong><?php echo $text_i_am_returning_customer; ?></strong>
			<div class="input-field">
				<i class="material-icons prefix">email</i>
				<input type="email" name="email" value="" id="input-email" id="input-email" class="validate">
				<label for="input-email" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>"><?php echo $entry_email; ?></label>
			</div>
			<div class="input-field">
				<i class="material-icons prefix">lock</i>
				<input type="password" name="password" value="" id="input-password">
				<label for="input-password"><?php echo $entry_password; ?></label>
				<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
			</div>
			<div class="flex-reverse">
				<button type="button" value="<?php echo $button_login; ?>" id="button-login" class="btn waves-effect waves-light red"><?php echo $button_login; ?></button>
			</div>
		</div>
	</div>
</div>