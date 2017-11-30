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
		<nav id="breadcrumbs" class="breadcrumb-wrapper transparent z-depth-0">
			<div class="nav-wrapper breadcrumb-wrap href-underline">
				<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
				<?php $i++ ?>
				<?php if ($i < count($breadcrumbs)) { ?>
				<?php if ($i == 1) {?>
					<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><i class="material-icons">home</i></a>
				<?php } else {?>
					<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><?php echo $breadcrumb['text']; ?></a>
				<?php }?>
				<?php } else { ?>
					<span class="breadcrumb blue-grey-text text-darken-3"><?php echo $breadcrumb['text']; ?></span>
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
			<div class="col <?php echo $main; ?>">
				<?php echo $content_top; ?>
				<div class="card-panel">
					<?php if ($yandex || $google) { ?>
					<div id="map">
						<?php if ($yandex) { ?>
						<a href="//maps.yandex.ru/?text=<?php echo $lat; ?>,<?php echo $lng; ?>" class="btn-floating btn-large halfway-fab waves-effect waves-light blue" title="<?php echo $text_view_map; ?>" target="_blank" rel="noopener"><i class="material-icons">map</i></a>
						<?php } ?>
						<?php if ($google) { ?>
						<a href="//maps.google.com/maps?q=<?php echo $lat; ?>,<?php echo $lng; ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" class="btn-floating btn-large halfway-fab waves-effect waves-light blue" title="<?php echo $text_view_map; ?>" target="_blank" rel="noopener"><i class="material-icons">map</i></a>
						<div id="google-map">
						</div>
						<?php } ?>
					</div>
					<?php } ?>
					<section class="section">
						<h2><?php echo $store; ?></h2>
						<div class="row">
							<div class="col s12 l6">
								<div class="card-panel">
									<ul class="collection no-border">
										<?php if ($image) { ?>
										<li class="collection-item no-border">
											<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>">
										</li>
										<?php } ?>
										<li class="collection-item no-border">
											<address><i class="material-icons left">location_on</i><?php echo $address; ?></address>
										</li>
										<li class="collection-item no-border">
											<span><i class="material-icons left">phone</i><?php echo $telephone; ?></span>
										</li>
										<?php if ($open) { ?>
										<li class="collection-item no-border">
											<p><i class="material-icons left">access_time</i><?php echo $open; ?></p>
										</li>
										<?php } ?>
										<?php if ($comment) { ?>
										<li class="collection-item no-border">
											<p><i class="material-icons left">info</i><?php echo $comment; ?></p>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<div class="col s12 l6">
								<div class="card-panel">
									<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
										<h3><?php echo $text_contact; ?></h3>
										<div class="input-field">
											<i class="material-icons prefix">account_circle</i>
											<input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="validate">
											<label for="input-name"><?php echo $entry_name; ?></label>
										</div>
										<div class="input-field">
											<i class="material-icons prefix">email</i>
											<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
											<label for="input-email" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>"><?php echo $entry_email; ?></label>
										</div>
										<div class="input-field">
											<i class="material-icons prefix">mode_edit</i>
											<textarea name="enquiry" rows="10" id="input-enquiry" class="materialize-textarea"></textarea>
											<label for="input-enquiry"><?php echo $entry_enquiry; ?></label>
										</div>
										<?php echo $captcha; ?>
										<div class="flex-reverse">
											<button class="btn waves-effect waves-light red right" type="submit" value="<?php echo $button_submit; ?>"><?php echo $button_submit; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
				</div>
				<?php echo $content_bottom; ?>
			</div>
			<?php echo $column_right; ?>
		</div>
	</div>
</main>
<?php if ($yandex) { ?><script defer src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script><?php } ?>
<?php if ($google) { ?><script defer src="//maps.googleapis.com/maps/api/js?key=<?php echo $google_api; ?>"></script><?php } ?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	<?php if ($error_name) { ?>
		Materialize.toast('<?php echo $error_name; ?>',4000)
	<?php } ?>
	<?php if ($error_email) { ?>
		Materialize.toast('<?php echo $error_email; ?>',4000)
	<?php } ?>
	<?php if ($error_enquiry) { ?>
		Materialize.toast('<?php echo $error_enquiry; ?>',4000)
	<?php } ?>
	<?php if ($yandex) { ?>
	ymaps.ready(init);

	var myMap, myPlacemark, myPin;

	function init() {
		myMap = new ymaps.Map("map", {
			center: [<?php echo $lat; ?>, <?php echo $lng; ?>],
			zoom: 16,
			controls: []
		});

		myPin = new ymaps.GeoObjectCollection({}, {
			<?php if ($icon_pin) { ?>
			iconLayout: 'default#image',
			iconImageSize: [<?php echo $icon_pin_width; ?>,<?php echo $icon_pin_height; ?>],
			iconImageHref: '<?php echo $icon_pin; ?>'
			<?php } ?>
		});

		myPlacemark = new ymaps.Placemark([<?php echo $lat; ?>, <?php echo $lng; ?>], {
			balloonContent: '<?php echo $map_description; ?>'
		});

		myPin.add(myPlacemark);
		myMap.geoObjects.add(myPin);
	}
	<?php } ?>
	<?php if ($google) { ?>
	google.maps.event.addDomListener(window, 'load', init);

	var element, options, myMap, myPlacemark, infoWindow;

	function init() {
		element = document.getElementById('google-map');
		options = {
			center: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
			zoom: 16
		}

		myMap = new google.maps.Map(element, options);

		myPlacemark = new google.maps.Marker({
			position: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
			map: myMap,
			icon: '<?php echo $icon_pin; ?>'
		});

		infoWindow = new google.maps.InfoWindow({
			content: '<?php echo $map_description; ?>'
		});

		myPlacemark.addListener('click', function() {
			infoWindow.open(myMap, myPlacemark);
		});
	}
	<?php } ?>
});
</script>
<?php echo $footer; ?>