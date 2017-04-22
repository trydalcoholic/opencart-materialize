<div class="collection href-underline z-depth-1">
	<?php if (!$logged) { ?>
	<a href="<?php echo $login; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_login; ?></a>
	<a href="<?php echo $register; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_register; ?></a>
	<a href="<?php echo $forgotten; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_forgotten; ?></a>
	<?php } ?>
	<a href="<?php echo $account; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_account; ?></a>
	<?php if ($logged) { ?>
	<a href="<?php echo $edit; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_edit; ?></a>
	<a href="<?php echo $password; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_password; ?></a>
	<?php } ?>
	<a href="<?php echo $payment; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_payment; ?></a>
	<a href="<?php echo $tracking; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_tracking; ?></a>
	<a href="<?php echo $transaction; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_transaction; ?></a>
	<?php if ($logged) { ?>
	<a href="<?php echo $logout; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_logout; ?></a>
	<?php } ?>
</div>