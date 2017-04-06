<div class="collection with-header">
	<div class="collection-header"><h4><?php echo $heading_title; ?></h4></div>
	<p class="collection-item"><?php echo $text_store; ?></p>
	<?php foreach ($stores as $store) { ?>
	<?php if ($store['store_id'] == $store_id) { ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $store['url']; ?>"><b><?php echo $store['name']; ?></b></a>
	<?php } else { ?>
	<a class="collection-item blue-grey-text text-darken-4" href="<?php echo $store['url']; ?>"><?php echo $store['name']; ?></a>
	<?php } ?>
	<?php } ?>
</div>