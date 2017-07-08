<form action="<?php echo $action; ?>" method="post" id="checkout">
  <input type="hidden" name="operation_xml" value="<?php echo $xml; ?>">
  <input type="hidden" name="signature" value="<?php echo $signature; ?>">
  <div class="flex-reverse">
  	<button type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn waves-effect waves-light red"></button>
  </div>
</form>
<script type="text/javascript">
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/liqpay/confirm',
		cache: false,
		success: function() {
			document.forms['checkout'].submit();
		}
	});
});
</script>