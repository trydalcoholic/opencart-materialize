<div class="flex-reverse">
	<button type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn red waves-effect waves-light"><?php echo $button_confirm; ?></button>
</div>
<script>
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/cod/confirm',
		cache: false,
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});</script>