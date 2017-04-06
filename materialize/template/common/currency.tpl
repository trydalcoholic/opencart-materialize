<?php if (count($currencies) > 1) { ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency">
		<a class="dropdown-button" data-activates="currency" rel="nofollow">
			<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
				<strong><?php echo $currency['symbol_left']; ?></strong>
				<?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
				<strong><?php echo $currency['symbol_right']; ?></strong>
				<?php } ?>
			<?php } ?>
			<span class="hide-on-med-and-down"><?php echo $text_currency; ?><i class="material-icons right">arrow_drop_down</i></span>
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