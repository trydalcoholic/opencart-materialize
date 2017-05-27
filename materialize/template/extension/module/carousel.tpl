<div id="carousel<?php echo $module; ?>" class="slick-carousel card-panel">
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
		$('.slick-carousel').not('.slick-initialized').slick({
			infinite: true,
			slidesToShow: 6,
			slidesToScroll: 3,
			dots: true,
			infinite: true,
			speed: 300,
			autoplay: true,
			lazyLoad: 'ondemand',
			responsive: [
				{
					breakpoint: 460,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3
					}
				},
				{
					breakpoint: 1240,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4
					}
				},
			]
		});
	});
</script>