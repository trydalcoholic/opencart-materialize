<form action="<?php echo $action ?>" method="post" id="checkout">
	<?php foreach ($params as $key => $value) { ?>
		<?php if (is_array($value)) { ?>
			<?php foreach ($value as $val) { ?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>">
			<?php } ?>
		<?php } else { ?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
		<?php } ?>
	<?php } ?>
</form>
<div class="flex-reverse">
	<button type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn waves-effect waves-light red"><?php echo $button_confirm; ?></button>
</div>
<script>
$(document).delegate('#button-confirm', 'click', function() {
	$.ajax({
		type: 'get',
		url: '<?php echo $confirm; ?>',
		success: function() {
			document.forms['checkout'].submit();
		}
	});
});
</script>