<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
	<li class="collection-header blue-grey white-text"><h5><?php echo $heading_title; ?></h5></li>
	<?php foreach ($categories as $category) { ?>
		<?php if ($category['category_id'] == $category_id) { ?>
		<li>
			<a href="<?php echo $category['href']; ?>" class="collapsible-header blue-grey-text text-darken-4 text-bold active" onclick="return false;" rel="nofollow"><?php echo $category['name']; ?></a>
			<?php if ($category['children']) { ?>
			<div class="collapsible-body no-padding">
				<div class="collection">
				<?php foreach ($category['children'] as $child) { ?>
					<?php if ($child['category_id'] == $child_id) { ?>
						<a class="collection-item child truncate blue-grey-text text-darken-4 blue-grey lighten-4" href="<?php echo $child['href']; ?>" rel="nofollow"><?php echo $child['name']; ?></a>
					<?php } else { ?>
						<a class="collection-item child truncate blue-grey-text text-darken-4" href="<?php echo $child['href']; ?>" rel="nofollow"><?php echo $child['name']; ?></a>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
			<?php } ?>
		</li>
		<?php } else { ?>
		<li>
			<a href="<?php echo $category['href']; ?>" class="collapsible-header truncate blue-grey-text text-darken-4 text-bold" rel="nofollow"><?php echo $category['name']; ?></a>
		</li>
		<?php } ?>
	<?php } ?>
</ul>