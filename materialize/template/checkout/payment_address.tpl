<?php if ($addresses) { ?>
<p>
	<input type="radio" name="payment_address" value="existing" checked="checked" id="existing_payment_address" class="with-gap">
	<label for="existing_payment_address"><?php echo $text_address_existing; ?></label>
	<div id="payment-existing" class="input-field">
		<select name="address_id">
		<?php foreach ($addresses as $address) { ?>
			<?php if ($address['address_id'] == $address_id) { ?>
			<option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
				<?php } else { ?>
			<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
			<?php } ?>
		<?php } ?>
		</select>
	</div>
	<br>
	<input type="radio" name="payment_address" value="new" id="new_payment_address" class="with-gap">
	<label for="new_payment_address"><?php echo $text_address_new; ?></label>
</p>
<?php } ?>
<div id="payment-new" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>;" class="section">
	<div class="input-field">
		<input type="text" name="firstname" value="" id="input-payment-firstname" class="validate">
		<label for="input-payment-firstname" class="active required"><?php echo $entry_firstname; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="lastname" value="" id="input-payment-lastname" class="validate">
		<label for="input-payment-lastname" class="active required"><?php echo $entry_lastname; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="company" value="" placeholder="<?php echo $entry_company; ?>" id="input-payment-company" class="validate">
		<label for="input-payment-company"><?php echo $entry_company; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="address_1" value="" id="input-payment-address-1" class="validate">
		<label for="input-payment-address-1" class="required"><?php echo $entry_address_1; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="address_2" value="" id="input-payment-address-2" class="validate">
		<label for="input-payment-address-2"><?php echo $entry_address_2; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="city" value="" id="input-payment-city" class="validate">
		<label for="input-payment-city" class="required"><?php echo $entry_city; ?></label>
	</div>
	<div class="input-field">
		<input type="text" name="postcode" value="" id="input-payment-postcode" class="validate">
		<label for="input-payment-postcode" class="required"><?php echo $entry_postcode; ?></label>
	</div>
	<div class="input-field">
		<select name="country_id" id="input-payment-country">
			<option value="" disabled selected><?php echo $text_select; ?></option>
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] == $country_id) { ?>
			<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>
			<?php } ?>
		</select>
		<label for="input-payment-country" class="required"><?php echo $entry_country; ?></label>
	</div>
	<div class="col s12">
		<label for="input-payment-zone" class="required"><?php echo $entry_zone; ?></label>
		<select name="zone_id" id="input-payment-zone" class="browser-default">
		</select>
	</div>
</div>
<div class="flex-reverse">
	<input type="button" value="<?php echo $button_continue; ?>" id="button-payment-address" class="btn waves-effect waves-light red right">
</div>
<script>
$('input[name=\'payment_address\']').on('change', function() {
	if (this.value == 'new') {
		$('#payment-existing').hide();
		$('#payment-new').show();
	} else {
		$('#payment-existing').show();
		$('#payment-new').hide();
	}
});
$('#collapse-payment-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-payment-address input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#collapse-payment-address input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#collapse-payment-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#collapse-payment-address select[name=\'country_id\']').trigger('change');
$('select').material_select();
</script>