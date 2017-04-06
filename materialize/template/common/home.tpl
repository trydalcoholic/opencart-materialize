<?php echo $header; ?>
	<main>
		<div class="container">
			<div class="row">
				<?php if ($column_left && $column_right) { ?>
					<?php $main = 's12 l6'; $goods = 's12'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
					<?php $main = 's12 l9'; $goods = 's12 m6'; ?>
				<?php } else { ?>
					<?php $main = 's12'; $goods = 's12 m6 l4'; ?>
				<?php } ?>
				<?php echo $column_left; ?>
				<div class="col <?php echo $main; ?>">
					<?php echo $content_top; ?>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>