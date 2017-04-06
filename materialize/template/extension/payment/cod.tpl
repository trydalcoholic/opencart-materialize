<div class="row">
	<div class="col s12">
		<div class="section">
			<input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn red waves-effect waves-light">
		</div>
	</div>
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