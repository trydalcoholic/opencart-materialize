<div class="section">
	<div id="slideshow<?php echo $module; ?>" class="slick-slider">
		<?php foreach ($banners as $banner) { ?>
			<?php if ($banner['link']) { ?>
			<a href="<?php echo $banner['link']; ?>">
				<img class="responsive-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
			</a>
			<?php } else { ?>
				<img class="responsive-img" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
			<?php } ?>
		<?php } ?>
	</div>
</div>