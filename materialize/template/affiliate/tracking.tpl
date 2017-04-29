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
							<p><?php echo $text_description; ?></p>
							<div class="section">
								<div class="input-field">
									<textarea id="input-code" placeholder="<?php echo $entry_code; ?>" class="materialize-textarea"><?php echo $code; ?></textarea>
									<label class="text-bold" for="input-code"><?php echo $entry_code; ?></label>
								</div>
								<div class="input-field">
									<input type="text" name="product" value="" placeholder="<?php echo $entry_generator; ?>" id="input-generator" class="autocomplete">
									<label class="text-bold tooltipped" for="input-generator" data-position="top" data-tooltip="<?php echo $help_generator; ?>"><?php echo $entry_generator; ?></label>
								</div>
								<div class="input-field">
									<textarea id="input-link" name="link" placeholder="<?php echo $entry_link; ?>" class="materialize-textarea"></textarea>
									<label class="text-bold" for="input-link"><?php echo $entry_link; ?></label>
								</div>
							</div>
						</form>
						<div class="flex-reverse href-underline">
							<a href="<?php echo $continue; ?>" class="btn waves-effect waves-light blue white-text"><?php echo $button_continue; ?></a>
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
			$(document).ready(function() {
				$('input.autocomplete').autocomplete({
					'source': function(request, response) {
						$.ajax({
							url: 'index.php?route=affiliate/tracking/autocomplete&filter_name=' +  encodeURIComponent(request),
							dataType: 'json',
							success: function(json) {
								response($.map(json, function(item) {
									return {
										label: item['name'],
										value: item['link']
									}
								}));
							}
						});
					},
					'select': function(item) {
						$('input[name=\'product\']').val(item['label']);
						$('textarea[name=\'link\']').val(item['value']);
					}
				});
			});
		});
	</script>
<?php echo $footer; ?>