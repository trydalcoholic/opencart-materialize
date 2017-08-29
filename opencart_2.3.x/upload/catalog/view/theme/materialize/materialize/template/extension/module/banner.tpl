<div id="banner<?php echo $module; ?>"  class="slick-banner card-panel">
	<?php foreach ($banners as $banner) { ?>
	<div>
		<?php if ($banner['link']) { ?>
		<a href="<?php echo $banner['link']; ?>"><img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"></a>
		<?php } else { ?>
		<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
		<?php } ?>
	</div>
	<?php } ?>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('.slick-banner').not('.slick-initialized').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			speed: 300,
			autoplay: true
		});
	});
</script>