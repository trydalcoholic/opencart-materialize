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
		<div class="row">
			<div class="container">
				<nav class="breadcrumb-wrapper transparent z-depth-0">
					<div class="nav-wrapper">
						<div class="row">
							<div class="col s12">
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
						</div>
					</div>
				</nav>
				<h1 class="col s12"><?php echo $heading_title; ?></h1>
				<?php if ($column_left && $column_right) { ?>
					<?php $main = 's12 l6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
					<?php $main = 's12 l9'; ?>
				<?php } else { ?>
					<?php $main = 's12'; ?>
				<?php } ?>
				<?php echo $column_left; ?>
				<div class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<div class="card-panel">
						<h3><?php echo $text_location; ?></h3>
						<div class="row">
							<div class="col s12 l6">
								<ul class="collapsible" data-collapsible="expandable">
									<li>
										<div class="collapsible-header active grey lighten-5 text-medium"><i class="material-icons">location_on</i><?php echo $store; ?></div>
										<div class="collapsible-body">
											<div class="row">
												<div class="col s12 l6">
													<?php if ($image) { ?>
													<img src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>" class="responsive-img">
													<?php } ?>
												</div>
												<div class="col s12 l6">
													<address>
														<?php echo $address; ?>
													</address>
													<?php if ($geocode) { ?>
														<a href="https://maps.google.com/maps?q=<?php echo urlencode($geocode); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank"><?php echo $button_map; ?></a>
													<?php } ?>
												</div>
											</div>
										</div>
									</li>
									<li>
										<div class="collapsible-header active grey lighten-5 text-medium"><i class="material-icons">phone</i><?php echo $text_telephone; ?></div>
										<div class="collapsible-body">
											<p><?php echo $telephone; ?></p>
										</div>
									</li>
									<?php if ($open) { ?>
									<li>
										<div class="collapsible-header active grey lighten-5 text-medium"><i class="material-icons">access_time</i><?php echo $text_open; ?></div>
										<div class="collapsible-body">
											<p><?php echo $open; ?></p>
										</div>
									</li>
									<?php } ?>
									<?php if ($comment) { ?>
									<li>
										<div class="collapsible-header active grey lighten-5 text-medium"><i class="material-icons">access_time</i><?php echo $text_comment; ?></div>
										<div class="collapsible-body">
											<p><?php echo $comment; ?></p>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
							<div class="col s12 l6">
								<div class="card-panel">
									<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
										<div class="row">
											<h3 class="col s12"><?php echo $text_contact; ?></h3>
											<div class="input-field col s12">
												<i class="material-icons prefix">account_circle</i>
												<input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="validate">
												<label for="input-name"><?php echo $entry_name; ?></label>
											</div>
											<div class="input-field col s12">
												<i class="material-icons prefix">email</i>
												<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
												<label for="input-email" data-error="Ошибка при вводе e-mail" data-success="E-mail введён верно"><?php echo $entry_email; ?></label>
											</div>
											<div class="input-field col s12">
												<i class="material-icons prefix">mode_edit</i>
												<textarea name="enquiry" rows="10" id="input-enquiry" class="materialize-textarea"></textarea>
												<label for="input-enquiry"><?php echo $entry_enquiry; ?></label>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<?php echo $captcha; ?>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<input class="btn waves-effect waves-light red right" type="submit" value="<?php echo $button_submit; ?>">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="row">
							<div id="map" style="min-height:360px;"></div>
						</div>
					</div>
				</div>
				<?php echo $column_right; ?>
				<?php if($content_bottom) { ?>
				<div class="col s12">
					<?php echo $content_bottom; ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</main>
	<script async src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
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
			ymaps.ready(init);
			function init() {
				var myMap = new ymaps.Map('map', {
					center: [55.753994, 37.622093],
					zoom: 16,
					controls: []
				});
				ymaps.geocode('<?php echo $address; ?>', {
					results: 1
				}).then(function (res) {
					var firstGeoObject = res.geoObjects.get(0),
					coords = firstGeoObject.geometry.getCoordinates(),
					bounds = firstGeoObject.properties.get('boundedBy');
					myMap.geoObjects.add(firstGeoObject);
					myMap.setBounds(bounds, {
						checkZoomRange: true
					});
				});
			};
		});
	</script>
<?php echo $footer; ?>