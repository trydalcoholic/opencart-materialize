<?php foreach ($blog_blocks as $blog_block) { ?>
	<?php if ($blog_block == 'search') { ?>
		<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_search; ?></h5></li>
			<li class="collection-item">
				<div id="blog-search" class="input-field">
					<input id="search-input-blog" type="search" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $text_search; ?>" required>
					<label id="label-search-blog" class="activator waves-effect waves-circle label-icon label-icon-search" for="search-input-blog"><i class="material-icons">search</i></label>
					<i id="reset-search-blog" class="material-icons">close</i>
				</div>
			</li>
		</ul>
		<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$('#label-search-blog').on('click', function() {
				var url = $('base').attr('href') + 'index.php?route=blog/search';
				var value = $('#search-input-blog').val();
				if (value) {
					url += '&search=' + encodeURIComponent(value);
				}
				location = url;
			});
			$('#blog-search').on('keydown', function(e) {
				if (e.keyCode == 13) {
					$('#label-search-blog').trigger('click');
				}
			});
		});
		</script>
	<?php } ?>
	<?php if ($blog_block == 'categories') { ?>
		<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_category; ?></h5></li>
			<?php foreach ($categories as $category) { ?>
				<?php if ($category['category_id'] == $category_id) { ?>
				<li>
					<a href="<?php echo $category['href']; ?>" class="collapsible-header waves-effect blue-grey-text text-darken-4 text-bold active" onclick="return false;"><?php echo $category['name']; ?></a>
					<?php if ($category['children']) { ?>
					<div class="collapsible-body no-padding">
						<div class="collection">
						<?php foreach ($category['children'] as $child) { ?>
							<?php if ($child['category_id'] == $child_id) { ?>
								<a class="collection-item waves-effect child truncate blue-grey-text text-darken-4 blue-grey lighten-4" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
							<?php } else { ?>
								<a class="collection-item waves-effect child truncate blue-grey-text text-darken-4" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
					<?php } ?>
				</li>
				<?php } else { ?>
				<li>
					<a href="<?php echo $category['href']; ?>" class="collapsible-header waves-effect truncate blue-grey-text text-darken-4 text-bold"><?php echo $category['name']; ?></a>
				</li>
				<?php } ?>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'latest_posts') { ?>
		<ul class="collection collapsible-accordion collection with-header z-depth-1">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_post; ?></h5></li>
			<?php foreach ($latest_posts as $latest_post) { ?>
			<li class="collection-item avatar">
				<a href="<?php echo $latest_post['href']; ?>"><img src="<?php echo $img_loader; ?>" data-src="<?php echo $latest_post['thumb']; ?>" alt="<?php echo $latest_post['name']; ?>" class="circle lazyload"></a>
				<a class="title text-bold truncate" href="<?php echo $latest_post['href']; ?>"><?php echo $latest_post['name']; ?></a>
				<p><?php echo $latest_post['description']; ?><br>
				<?php echo $latest_post['published']; ?>
				</p>
			</li>
			<?php } ?>
		</ul>
	<?php } ?>
<?php } ?>