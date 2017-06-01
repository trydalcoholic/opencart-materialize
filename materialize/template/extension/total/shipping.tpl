<li>
	<div class="collapsible-header grey lighten-5"><i class="material-icons">local_shipping</i><span><?php echo $heading_title; ?></span></div>
	<div class="collapsible-body">
		<p><?php echo $text_shipping; ?></p>
		<div class="section">
			<div class="input-field">
				<select name="country_id" id="input-country">
					<option value=""><?php echo $text_select; ?></option>
					<?php foreach ($countries as $country) { ?>
					<?php if ($country['country_id'] == $country_id) { ?>
					<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
				<label for="input-country" class="required"><?php echo $entry_country; ?></label>
			</div>
		</div>
		<div class="section">
			<div class="input-field">
				<select name="zone_id" id="input-zone">
				</select>
				<label for="input-zone" class="required"><?php echo $entry_zone; ?></label>
			</div>
		</div>
		<div class="section">
			<div class="input-field">
				<label for="input-postcode"><?php echo $entry_postcode; ?></label>
				<input type="text" name="postcode" value="<?php echo $postcode; ?>" id="input-postcode" class="validate">
			</div>
		</div>
		<div class="flex-reverse">
			<button type="button" id="button-quote" class="btn blue waves-effect waves-light right"><?php echo $button_quote; ?></button>
		</div>
	</div>
</li>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('#button-quote').on('click', function() {
			$.ajax({
				url: 'index.php?route=extension/total/shipping/quote',
				type: 'post',
				data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						if (json['error']['warning']) {
							Materialize.toast('<i class="material-icons left">check</i>'+json['error']['warning'],7000,'toast-warning rounded');
						}
						if (json['error']['country']) {
							Materialize.toast('<i class="material-icons left">check</i>'+json['error']['country'],7000,'toast-warning rounded');
						}
						if (json['error']['zone']) {
							Materialize.toast('<i class="material-icons left">check</i>'+json['error']['zone'],7000,'toast-warning rounded');
						}
						if (json['error']['postcode']) {
							Materialize.toast('<i class="material-icons left">check</i>'+json['error']['postcode'],7000,'toast-warning rounded');
						}
					}

					if (json['shipping_method']) {
						$('#modal-shipping').remove();

						html  = '<div id="modal-shipping" class="modal">';
						html += '	<div class="modal-content">';
						html += '		<h4 class="text-bold"><?php echo $text_shipping_method; ?></h4>';

						for (i in json['shipping_method']) {
							if (!json['shipping_method'][i]['error']) {
								for (j in json['shipping_method'][i]['quote']) {
									html += '';
									if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
										html += '<input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" id="radio-'+json['shipping_method'][i]['quote'][j]['code']+'" class="with-gap">';
									} else {
										html += '<input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="radio-'+json['shipping_method'][i]['quote'][j]['code']+'" class="with-gap">';
									}
									html += '<label for="radio-'+json['shipping_method'][i]['quote'][j]['code']+'">' + json['shipping_method'][i]['quote'][j]['title'] + ' - ' + json['shipping_method'][i]['quote'][j]['text'] + '</label><br>';
								}
							} else {
								Materialize.toast('<i class="material-icons left">check</i>'+json['shipping_method'][i]['error'],7000,'toast-warning rounded');
							}
						}

						html += '	</div>';
						html += '	<div class="modal-footer">';
						html += '		<button type="button" class="btn-flat waves-effect waves-default modal-action modal-close"><?php echo $button_cancel; ?></button>';

						<?php if ($shipping_method) { ?>
						html += '		<input type="button" value="<?php echo $button_shipping; ?>" id="button-shipping" class="btn-flat waves-effect waves-default modal-action">';
						<?php } else { ?>
						html += '		<input type="button" value="<?php echo $button_shipping; ?>" id="button-shipping" class="btn-flat waves-effect waves-default modal-action" disabled="disabled">';
						<?php } ?>

						html += '	</div>';
						html += '</div>';

						$('body').append(html);


						$('input[name=\'shipping_method\']').on('change', function() {
							$('#button-shipping').prop('disabled', false);
						});
						$('#modal-shipping').modal();
						$('#modal-shipping').modal('open');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$(document).delegate('#button-shipping', 'click', function() {
			$.ajax({
				url: 'index.php?route=extension/total/shipping/shipping',
				type: 'post',
				data: 'shipping_method=' + encodeURIComponent($('input[name=\'shipping_method\']:checked').val()),
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						Materialize.toast('<i class="material-icons left">check</i>'+json['error'],7000,'toast-warning rounded');
					}
					if (json['redirect']) {
						location = json['redirect'];
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('select[name=\'country_id\']').on('change', function() {
			$.ajax({
				url: 'index.php?route=extension/total/shipping/country&country_id=' + this.value,
				dataType: 'json',
				success: function(json) {
					if (json['postcode_required'] == '1') {
						$('input[name=\'postcode\']').parent().find('label').addClass('required');
					} else {
						$('input[name=\'postcode\']').parent().find('label').removeClass('required');
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

					$('select[name=\'zone_id\']').html(html);
					$('select').material_select();
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		$('select[name=\'country_id\']').trigger('change');
		$('select').material_select();
	});
</script>