<?php if (count($currencies) > 1) { ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency">
		<a class="dropdown-button" data-activates="currency" data-beloworigin="true" data-constrainWidth="false" rel="nofollow">
			<span class="hide-on-med-and-down" style="pointer-events:none;"><?php echo $text_currency; ?>:</span>
			<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
				<strong style="pointer-events:none;"><?php echo $currency['symbol_left']; ?></strong>
				<?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
				<strong style="pointer-events:none;"><?php echo $currency['symbol_right']; ?></strong>
				<?php } ?>
			<?php } ?>
		</a>
		<ul id="currency" class="dropdown-content">
		<?php foreach ($currencies as $currency) { ?>
			<?php if ($currency['symbol_left']) { ?>
			<li><a id="<?php echo $currency['code']; ?>" class="currency-select" rel="nofollow"><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></a></li>
			<?php } else { ?>
			<li><a id="<?php echo $currency['code']; ?>" class="currency-select" rel="nofollow"><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></a></li>
			<?php } ?>
		<?php } ?>
		</ul>
		<input type="hidden" name="code" value="">
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
	</form>
<?php } ?>