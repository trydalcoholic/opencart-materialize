<?php if ($comments) { ?>
<?php foreach ($comments as $comment) { ?>
<div class="card-panel">
	<div class="row valign-wrapper">
		<div class="col s12">
			<span class="flow-text text-bold"><?php echo $comment['author']; ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col s4 m3 l2 center">
			<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/comment.png" alt="" width="175" height="175">
		</div>
		<div class="col s8 m9 l10 grey lighten-3 z-depth-1 comment-body">
			<p class="text-bold"><?php echo $comment['date_added']; ?></p>
			<p class="section"><?php echo $comment['text']; ?></p>
		</div>
	</div>
</div>
<?php } ?>
<?php echo $pagination; ?>
<?php } else { ?>
<div class="card-panel center">
	<p class="flow-text text-bold"><?php echo $text_no_comments; ?></p>
	<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/search-empty.png" alt="">
</div>
<?php } ?>