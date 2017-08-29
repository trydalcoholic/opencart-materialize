<p><?php echo $text_instruction; ?></p>
<p><?php echo $text_printpay; ?></p>
<p><?php echo $text_payment; ?></p>
<?php if ($text_order_history) { ?>
<p><?php echo $text_order_history; ?></p>
<?php } ?>
<p><?php echo $text_payment_comment; ?></p>
<div class="flex-reverse">
	<button type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn waves-effect waves-light red"><?php echo $button_confirm; ?></button>
</div>
<script type="text/javascript">
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/sberbank_transfer/confirm',
		cache: false,
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
</script>