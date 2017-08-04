<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="card-panel">
	<div class="row valign-wrapper">
		<div class="col s4 m3 l2 center">
			<span class="flow-text text-bold"><?php echo $review['author']; ?></span>
		</div>
		<div class="col s8 m9 l10">
			<div class="rating">
				<hr>
				<div>
					<span class="white">
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<?php if ($review['rating'] < $i) { ?>
							<i class="material-icons">star_border</i>
						<?php } else { ?>
							<i class="material-icons">star</i>
						<?php } ?>
					<?php } ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s4 m3 l2 center">
			<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/comment.png" alt="<?php echo $review['author']; ?> — автор отзыва" width="175" height="175">
		</div>
		<div class="col s8 m9 l10 grey lighten-3 z-depth-1 comment-body">
			<p class="text-bold"><?php echo $review['date_added']; ?></p>
			<p class="section"><?php echo $review['text']; ?></p>
		</div>
	</div>
</div>
<?php } ?>
<?php if ($pagination) { ?>
<div class="row">
<?php echo $pagination; ?>
</div>
<?php } ?>
<?php } else { ?>
<div class="card-panel center">
	<p class="flow-text text-bold"><?php echo $text_no_reviews; ?></p>
	<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/search-empty.png" alt="Ещё никто не оставлял отзывы">
</div>
<?php } ?>