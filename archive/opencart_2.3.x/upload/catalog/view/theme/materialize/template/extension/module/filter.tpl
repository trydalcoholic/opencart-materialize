<ul class="collapsible collection with-header z-depth-1" data-collapsible="expandable">
	<li class="collection-header blue-grey white-text"><h5 class="text-bold"><?php echo $heading_title; ?></h5></li>
	<?php foreach ($filter_groups as $filter_group) { ?>
	<li>
		<div class="collapsible-header active text-bold blue-grey lighten-4 arrow-rotate"><?php echo $filter_group['name']; ?></div>
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
</ul>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$("input[name^=\'filter\']").change(function() {
			filter = [];
			$('input[name^=\'filter\']:checked').each(function(element) {
				filter.push(this.value);
			});
			href = '<?php echo $action; ?>&filter=' + filter.join(',');
			div = ' #content';
			load_href = href + div;
			$(div).load(load_href, function() {
				$(this).children(':first').unwrap();
			});
			setLocation(href);
			return false;
		});
		function setLocation(curLoc){
			try {
				history.pushState(null, null, curLoc);
				return;
			} catch(e) {}
			location.hash = '#' + curLoc;
		}
	});
</script>