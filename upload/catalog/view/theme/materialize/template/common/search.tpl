<div id="search" class="input-field">
	<input id="search-input" class="autocomplete" type="search" name="search" value="<?php echo $search; ?>">
	<label class="activator waves-effect waves-circle label-icon label-icon-search" for="search-input"><i class="material-icons">search</i></label>
	<i id="reset-search" class="material-icons">close</i>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$(document).ready(function() {
			$('input[name=\'search\']').autocomplete({
				'source': function(request, response) {
					$.ajax({
						url: 'index.php?route=common/search/autocomplete&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(json) {
							response($.map(json, function(item) {
								return {
									label: item['name'],
									img: item['img'],
									value: item['product_id']
								}
							}));
						}
					});
				},
				'select': function(item) {
					window.location = "<?php echo $product_path; ?>&product_id="+item['value'];
				}
			});
		});
	});
</script>