<div class="collection href-underline">
	<?php foreach ($informations as $information) { ?>
	<a href="<?php echo $information['href']; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $information['title']; ?></a>
	<?php } ?>
	<a href="<?php echo $contact; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_contact; ?></a>
	<a href="<?php echo $sitemap; ?>" class="collection-item blue-grey-text text-darken-4"><?php echo $text_sitemap; ?></a>
</div>