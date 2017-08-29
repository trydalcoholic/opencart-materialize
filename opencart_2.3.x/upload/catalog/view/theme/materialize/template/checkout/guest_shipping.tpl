<div class="row">
	<div class="col s12 l6 offset-l3">
		<div class="card-panel z-depth-2">
			<div class="input-field">
				<label for="input-shipping-firstname" class="active text-bold required"><?php echo $entry_firstname; ?></label>
				<input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-shipping-firstname" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-lastname" class="active text-bold required"><?php echo $entry_lastname; ?></label>
				<input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-shipping-lastname" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-company" class="active text-bold"><?php echo $entry_company; ?></label>
				<input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-shipping-company" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-address-1" class="active text-bold required"><?php echo $entry_address_1; ?></label>
				<input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-shipping-address-1" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-address-2" class="active text-bold"><?php echo $entry_address_2; ?></label>
				<input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-shipping-address-2" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-city" class="active text-bold"><?php echo $entry_city; ?></label>
				<input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-shipping-city" class="validate">
			</div>
			<div class="input-field">
				<label for="input-shipping-postcode" class="active text-bold"><?php echo $entry_postcode; ?></label>
				<input type="text" name="postcode" value="<?php echo $postcode; ?>" id="input-shipping-postcode" class="validate">
			</div>
			<div class="section">
				<div class="input-field">
					<select name="country_id" id="input-shipping-country">
						<option value="" disabled selected><?php echo $text_select; ?></option>
						<?php foreach ($countries as $country) { ?>
						<?php if ($country['country_id'] == $country_id) { ?>
						<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<label for="input-shipping-country" class="text-bold required"><?php echo $entry_country; ?></label>
				</div>
			</div>
			<div class="section">
				<div class="input-field">
					<select name="zone_id" id="input-shipping-zone">
					</select>
					<label for="input-shipping-zone" class="text-bold required"><?php echo $entry_zone; ?></label>
				</div>
			</div>
			<div class="flex-reverse">
				<button type="button" value="<?php echo $button_continue; ?>" id="button-guest-shipping" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
			</div>
		</div>
	</div>
</div>
<script>
$('#collapse-shipping-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().find('label').addClass('required');
			} else {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().find('label').removeClass('required');
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
			$('#collapse-shipping-address select[name=\'zone_id\']').html(html);
			$('select').material_select();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#collapse-shipping-address select[name=\'country_id\']').trigger('change');
$('select').material_select();
</script>