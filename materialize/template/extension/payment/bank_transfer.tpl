<h2><?php echo $text_instruction; ?></h2>
<p><b><?php echo $text_description; ?></b></p>
<p><?php echo $bank; ?></p>
<p><?php echo $text_payment; ?></p>
<div class="flex-reverse">
	<button type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn waves-effect waves-light red"><?php echo $button_confirm; ?></button>
</div>
<script type="text/javascript">
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/bank_transfer/confirm',
		cache: false,
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
</script>