<div class="collection z-depth-1">
	<?php if (!$logged) { ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $login; ?>" rel="nofollow"><?php echo $text_login; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $register; ?>" rel="nofollow"><?php echo $text_register; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $forgotten; ?>" rel="nofollow"><?php echo $text_forgotten; ?></a>
	<?php } ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $account; ?>" rel="nofollow"><?php echo $text_account; ?></a>
	<?php if ($logged) { ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $edit; ?>" rel="nofollow"><?php echo $text_edit; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $password; ?>" rel="nofollow"><?php echo $text_password; ?></a>
	<?php } ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $address; ?>" rel="nofollow"><?php echo $text_address; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $wishlist; ?>" rel="nofollow"><?php echo $text_wishlist; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $order; ?>" rel="nofollow"><?php echo $text_order; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $download; ?>" rel="nofollow"><?php echo $text_download; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $recurring; ?>" rel="nofollow"><?php echo $text_recurring; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $reward; ?>" rel="nofollow"><?php echo $text_reward; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $return; ?>" rel="nofollow"><?php echo $text_return; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $transaction; ?>" rel="nofollow"><?php echo $text_transaction; ?></a>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $newsletter; ?>" rel="nofollow"><?php echo $text_newsletter; ?></a>
	<?php if ($logged) { ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $logout; ?>" rel="nofollow"><?php echo $text_logout; ?></a>
	<?php } ?>
</div>