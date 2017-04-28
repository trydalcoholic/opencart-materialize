<ul class="collapsible collection with-header z-depth-1" data-collapsible="expandable">
	<li class="collection-header blue-grey white-text"><h5 class="text-bold"><?php echo $heading_title; ?></h5></li>
	<?php foreach ($filter_groups as $filter_group) { ?>
	<li>
		<div class="collapsible-header active text-bold blue-grey lighten-4"><?php echo $filter_group['name']; ?></div>
		<div class="collapsible-body no-padding">
			<ul id="filter-group<?php echo $filter_group['filter_group_id']; ?>" class="collection">
				<?php foreach ($filter_group['filter'] as $filter) { ?>
				<li class="collection-item">
					<?php if (in_array($filter['filter_id'], $filter_category)) { ?>
					<input type="checkbox" class="filled-in" id="filled-in-<?php echo $filter['filter_id']; ?>"  name="filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked">
					<label for="filled-in-<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
					<?php } else { ?>
					<input type="checkbox" class="filled-in" id="filled-in-<?php echo $filter['filter_id']; ?>"  name="filter[]" value="<?php echo $filter['filter_id']; ?>">
					<label for="filled-in-<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
					<?php } ?>
				</li>
				<?php } ?>
			</ul>
		</div>
	</li>
	<?php } ?>
	<li><button type="button" id="button-filter" class="waves-effect waves-light btn blue-grey lighten-1 width-max"><?php echo $button_filter; ?></button></li>
</ul>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('#button-filter').on('click', function() {
			filter = [];
			$('input[name^=\'filter\']:checked').each(function(element) {
				filter.push(this.value);
			});
			location = '<?php echo $action; ?>&filter=' + filter.join(',');
		});
	});
</script>