<div id="carousel<?php echo $module; ?>" class="slick-carousel card-panel">
	<?php foreach ($banners as $banner) { ?>
	<div>
		<?php if ($banner['link']) { ?>
		<a href="<?php echo $banner['link']; ?>"><img class="responsive-img lazyload" src="catalog/view/theme/materialize/image/ajax-loader.gif" data-src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"></a>
		<?php } else { ?>
		<img class="responsive-img lazyload" src="catalog/view/theme/materialize/image/ajax-loader.gif" data-src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
		<?php } ?>
	</div>
	<?php } ?>
</div>