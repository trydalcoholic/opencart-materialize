<div class="row">
	<div class="col s12 l6">
		<div id="account" class="card-panel z-depth-2">
			<h4 class="text-bold"><?php echo $text_your_details; ?></h4>
			<br>
			<div class="input-field">
				<label for="input-payment-firstname" class="active text-bold required"><?php echo $entry_firstname; ?></label>
				<input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-payment-firstname" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-lastname" class="active text-bold required"><?php echo $entry_lastname; ?></label>
				<input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-payment-lastname" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-email" class="active text-bold required"><?php echo $entry_email; ?></label>
				<input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-payment-email" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-telephone" class="active text-bold required"><?php echo $entry_telephone; ?></label>
				<input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="+7_(___)___-____" id="input-payment-telephone" class="validate" data-inputmask="'alias':'phone'">
			</div>
			<div class="input-field">
				<label for="input-payment-fax" class="active text-bold"><?php echo $entry_fax; ?></label>
				<input type="text" name="fax" value="<?php echo $fax; ?>" placeholder="<?php echo $entry_fax; ?>" id="input-payment-fax" class="validate">
			</div>
		</div>
	</div>
	<div class="col s12 l6">
		<div id="address" class="card-panel z-depth-2">
			<h4 class="text-bold"><?php echo $text_your_address; ?></h4>
			<br>
			<div class="input-field">
				<label for="input-payment-company" class="active text-bold"><?php echo $entry_company; ?></label>
				<input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-payment-company" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-address-1" class="active text-bold required"><?php echo $entry_address_1; ?></label>
				<input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-payment-address-1" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-address-2" class="active text-bold"><?php echo $entry_address_2; ?></label>
				<input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-payment-address-2" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-city" class="active text-bold required"><?php echo $entry_city; ?></label>
				<input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-payment-city" class="validate">
			</div>
			<div class="input-field">
				<label for="input-payment-postcode" class="active text-bold required"><?php echo $entry_postcode; ?></label>
				<input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-payment-postcode" class="validate">
			</div>
			<div class="section">
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
					<label for="input-payment-country" class="text-bold required"><?php echo $entry_country; ?></label>
				</div>
			</div>
			<div class="section">
				<div class="input-field">
					<select name="zone_id" id="input-payment-zone">
					</select>
					<label for="input-payment-zone" class="text-bold required"><?php echo $entry_zone; ?></label>
				</div>
			</div>
		</div>
	</div>
	<?php if ($captcha) { ?>
	<div class="col s12">
		<?php echo $captcha; ?>
	</div>
	<?php } ?>
	<?php if ($shipping_required) { ?>
	<div class="col s12">
		<div class="section">
			<?php if ($shipping_address) { ?>
			<input type="checkbox" name="shipping_address" value="1" checked="checked" id="shipping_address" class="filled-in">
			<?php } else { ?>
			<input type="checkbox" name="shipping_address" value="1" id="shipping_address" class="filled-in">
			<?php } ?>
			<label for="shipping_address"><?php echo $entry_shipping; ?></label>
		</div>
	</div>
	<?php } ?>
	<div class="col s12">
		<div class="flex-reverse">
			<button type="button" value="<?php echo $button_continue; ?>" id="button-guest" class="btn waves-effect waves-light red"><?php echo $button_continue; ?></button>
		</div>
	</div>
</div>
<script>
$('#collapse-payment-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-payment-address input[name=\'postcode\']').parent().find('label').addClass('required');
			} else {
				$('#collapse-payment-address input[name=\'postcode\']').parent().find('label').removeClass('required');
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
			$('select').material_select();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#collapse-payment-address select[name=\'country_id\']').trigger('change');

$(":input[name='telephone']").inputmask();
$('select').material_select();
</script>