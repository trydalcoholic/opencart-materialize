<?php foreach ($blog_blocks as $blog_block) { ?>
	<?php if ($blog_block == 'search') { ?>
		<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_search; ?></h5></li>
			<li class="collection-item">
				<div id="blog-search" class="input-field">
					<input id="search-input-blog" type="search" name="filter_title" value="<?php echo $filter_title; ?>" placeholder="<?php echo $text_search; ?>" required>
					<label id="label-search-blog" class="activator waves-effect waves-circle label-icon label-icon-search" for="search-input-blog"><i class="material-icons">search</i></label>
					<i id="reset-search-blog" class="material-icons">close</i>
				</div>
			</li>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'categories') { ?>
		<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_category; ?></h5></li>
			<?php foreach ($categories as $category) { ?>
				<?php if ($category['blog_category_id'] == $blog_category_id) { ?>
				<li><a href="<?php echo $category['href']; ?>" class="collapsible-header waves-effect truncate blue-grey-text text-darken-4 text-bold active"><?php echo $category['name']; ?></a></li>
				<?php } else { ?>
				<li><a href="<?php echo $category['href']; ?>" class="collapsible-header waves-effect truncate blue-grey-text text-darken-4 text-bold"><?php echo $category['name']; ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'archives') { ?>
		<ul class="collapsible collapsible-accordion collection with-header z-depth-1" data-collapsible="accordion">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_archive; ?></h5></li>
			<?php foreach ($archives as $archive) { ?>
				<?php if ($archive['date_added'] == $date_added) { ?>
				<li><a href="<?php echo $archive['href']; ?>" class="collapsible-header waves-effect truncate blue-grey-text text-darken-4 text-bold active"><?php echo $archive['title']; ?></a></li>
				<?php } else { ?>
				<li><a href="<?php echo $archive['href']; ?>" class="collapsible-header waves-effect truncate blue-grey-text text-darken-4 text-bold"><?php echo $archive['title']; ?></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'recent_posts') { ?>
		<ul class="collection collapsible-accordion collection with-header z-depth-1">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_post; ?></h5></li>
			<?php foreach ($recent_posts as $recent_post) { ?>
			<li class="collection-item avatar">
				<a href="<?php echo $recent_post['href']; ?>"><img src="<?php echo $recent_post['image']; ?>" alt="<?php echo $recent_post['title']; ?>" class="circle"></a>
				<a class="title text-bold truncate" href="<?php echo $recent_post['href']; ?>"><?php echo $recent_post['title']; ?></a>
				<p><?php echo $recent_post['description']; ?><br>
				<?php echo date_format($recent_post['date_added'], 'd.m.Y'); ?>
				</p>
			</li>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'recent_comments') { ?>
		<ul class="collection collapsible-accordion collection with-header z-depth-1">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_comment; ?></h5></li>
			<?php foreach ($recent_comments as $recent_comment) { ?>
			<li class="collection-item">
				<a class="title text-bold truncate" href="<?php echo $recent_comment['href']; ?>"><?php echo $recent_comment['title']; ?></a>
				<p><?php echo $recent_comment['text']; ?><br>
				<?php echo $recent_comment['author']; ?><br>
				<?php echo date_format($recent_comment['date_added'], 'd.m.Y'); ?>
				</p>
			</li>
			<?php } ?>
		</ul>
	<?php } ?>
	<?php if ($blog_block == 'tags') { ?>
		<?php if ($tags) { ?>
		<ul class="collection collapsible-accordion collection with-header z-depth-1">
			<li class="collection-header blue-grey white-text"><h5><?php echo $heading_tag; ?></h5></li>
			<li class="collection-item">
				<?php for ($i = 1; $i < count($tags); $i++) { ?>
					<?php if ($i < (count($tags) - 1)) { ?>
					<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>,&nbsp;
					<?php } else { ?>
					<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>
					<?php } ?>
				<?php } ?>
			</li>
		</ul>
		<?php } ?>
	<?php } ?>
<?php } ?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	$('#blog-search input[type=\'search\']').parent().find('label').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=blog/category';
		var filter_title = $('#blog-search input[name=\'filter_title\']').val();
		if (filter_title) {
			url += '&filter_title=' + encodeURIComponent(filter_title);
		}
		location = url;
	});
	$('#blog-search input[type=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('#blog-search input[name=\'filter_title\']').parent().find('label').trigger('click');
		}
	});
});
</script>