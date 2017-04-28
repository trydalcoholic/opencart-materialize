<?php echo $header; ?>
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [
			<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
			<?php $i++ ?>
			<?php if ($i < count($breadcrumbs)) { ?>
			<?php if ($i == 1) {?>
			<?php } else {?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			},
			<?php }?>
			<?php } else { ?>
			{
				"@type": "ListItem",
				"position": <?php echo ($i-1); ?>,
				"item": {
					"@id": "<?php echo $breadcrumb['href']; ?>",
					"name": "<?php echo $breadcrumb['text']; ?>"
				}
			}
			<?php }}?>
		]
	}
</script>
	<main>
		<div class="container">
			<nav class="breadcrumb-wrapper transparent z-depth-0">
				<div class="nav-wrapper">
					<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
					<?php $i++ ?>
					<?php if ($i < count($breadcrumbs)) { ?>
					<?php if ($i == 1) {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><i class="material-icons">home</i></a>
					<?php } else {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></a>
					<?php }?>
					<?php } else { ?>
						<span class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></span>
					<?php }}?>
				</div>
			</nav>
			<h1><?php echo $heading_title; ?></h1>
			<?php if ($column_left && $column_right) { ?>
				<?php $main = 's12 l6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; ?>
			<?php } else { ?>
				<?php $main = 's12'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div id="content" class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<div class="card-panel">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
							<h2><?php echo $text_edit_address; ?></h2>
							<div class="input-field">
								<input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="validate">
								<label for="input-firstname" class="required"><?php echo $entry_firstname; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" class="validate">
								<label for="input-lastname" class="required"><?php echo $entry_lastname; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="company" value="<?php echo $company; ?>" id="input-company" class="validate">
								<label for="input-company"><?php echo $entry_company; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="address_1" value="<?php echo $address_1; ?>" id="input-address-1" class="validate">
								<label for="input-address-1" class="required"><?php echo $entry_address_1; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="address_2" value="<?php echo $address_2; ?>" id="input-address-2" class="validate">
								<label for="input-address-2"><?php echo $entry_address_2; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="city" value="<?php echo $city; ?>" id="input-city" class="validate">
								<label for="input-city" class="required"><?php echo $entry_city; ?></label>
							</div>
							<div class="input-field">
								<input type="text" name="postcode" value="<?php echo $postcode; ?>" id="input-postcode" class="validate">
								<label for="input-postcode" class="required"><?php echo $entry_postcode; ?></label>
							</div>
							<div class="input-field">
								<select name="country_id" id="input-country">
									<option value="" disabled selected><?php echo $text_select; ?></option>
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
							<label for="input-zone" class="required"><?php echo $entry_zone; ?></label>
							<select name="zone_id" id="input-zone" class="browser-default">
							</select>
						</form>
					</div>
					<div class="card-panel">
						<h2><?php echo $entry_default; ?></h2>
						<div class="section">
							<?php if ($default) { ?>
								<input type="radio" name="default" value="1" checked="checked" id="default-yes" class="with-gap">
								<label for="default-yes"><?php echo $text_yes; ?></label>

								<input type="radio" name="default" value="0" id="default-no" class="with-gap">
								<label for="default-no"><?php echo $text_no; ?></label>
							<?php } else { ?>
								<input type="radio" name="default" value="1" id="default-yes" class="with-gap">
								<label for="default-yes"><?php echo $text_yes; ?></label>

								<input type="radio" name="default" value="0" checked="checked" id="default-no" class="with-gap">
								<label for="default-no"><?php echo $text_no; ?></label>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col s6">
								<a href="<?php echo $back; ?>" class="btn-flat waves-effect waves-light left href-underline"><?php echo $button_back; ?></a>
							</div>
							<div class="col s6">
								<div class="flex-reverse no-padding">
									<input type="submit" value="<?php echo $button_continue; ?>" class="btn waves-effect waves-light red">
								</div>
							</div>
						</div>
					</div>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			<?php if ($error_firstname) { ?>
				Materialize.toast('<?php echo $error_firstname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_lastname) { ?>
				Materialize.toast('<?php echo $error_lastname; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_address_1) { ?>
				Materialize.toast('<?php echo $error_address_1; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_city) { ?>
				Materialize.toast('<?php echo $error_city; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_postcode) { ?>
				Materialize.toast('<?php echo $error_postcode; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_country) { ?>
				Materialize.toast('<?php echo $error_country; ?>',7000,'rounded')
			<?php } ?>
			<?php if ($error_zone) { ?>
				Materialize.toast('<?php echo $error_zone; ?>',7000,'rounded')
			<?php } ?>
			$('select[name=\'country_id\']').on('change', function() {
				$.ajax({
					url: 'index.php?route=account/account/country&country_id=' + this.value,
					dataType: 'json',
					success: function(json) {
						if (json['postcode_required'] == '1') {
							$('input[name=\'postcode\']').parent().parent().addClass('required');
						} else {
							$('input[name=\'postcode\']').parent().parent().removeClass('required');
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
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
			$('select[name=\'country_id\']').trigger('change');
		});
	</script>
<?php echo $footer; ?>