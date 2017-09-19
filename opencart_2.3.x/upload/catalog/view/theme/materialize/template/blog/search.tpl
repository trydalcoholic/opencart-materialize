<?php echo $header; ?>
	<main>
		<div class="container">
			<nav id="breadcrumbs" class="breadcrumb-wrapper transparent z-depth-0">
				<div class="nav-wrapper breadcrumb-wrap href-underline">
					<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
					<?php $i++ ?>
					<?php if ($i < count($breadcrumbs)) { ?>
					<?php if ($i == 1) {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><i class="material-icons">home</i></a>
					<?php } else {?>
						<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb waves-effect black-text"><?php echo $breadcrumb['text']; ?></a>
					<?php }?>
					<?php } else { ?>
						<span class="breadcrumb blue-grey-text text-darken-3"><?php echo $breadcrumb['text']; ?></span>
					<?php }}?>
				</div>
			</nav>
			<?php if ($column_left && $column_right) { ?>
				<?php $main = 's12 l6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
				<?php $main = 's12 l9'; ?>
			<?php } else { ?>
				<?php $main = 's12'; ?>
			<?php } ?>
			<div class="row">
				<?php echo $column_left; ?>
				<div id="content" class="col <?php echo $main; ?> section href-underline">
					<?php echo $content_top; ?>
					<h1><?php echo $heading_title; ?></h1>
					<ul class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header text-bold arrow-rotate"><?php echo $entry_search; ?></div>
							<div class="collapsible-body white">
								<div class="row">
									<div class="col s6 input-field">
										<input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search">
										<label class="text-bold"><?php echo $text_searched; ?></label>
									</div>
									<div class="col s6 input-field">
										<select name="category_id" class="form-control">
											<option value="0"><?php echo $text_category; ?></option>
											<?php foreach ($categories as $category_1) { ?>
												<?php if ($category_1['category_id'] == $category_id) { ?>
													<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
												<?php } ?>
												<?php foreach ($category_1['children'] as $category_2) { ?>
													<?php if ($category_2['category_id'] == $category_id) { ?>
														<option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
													<?php } ?>
													<?php foreach ($category_2['children'] as $category_3) { ?>
														<?php if ($category_3['category_id'] == $category_id) { ?>
															<option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
														<?php } else { ?>
															<option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_refine; ?></label>
									</div>
									<div class="col s12">
										<div class="row">
											<div class="col s12 m6 switch">
												<div class="row">
													<div class="col s8">
														<span class="text-bold"><?php echo $entry_description; ?>:</span>
													</div>
													<div class="col s4">
														<label>
															<?php if ($description) { ?>
															<input type="checkbox" name="description" value="1" checked="checked" id="search-in-description">
															<?php } else { ?>
															<input type="checkbox" name="description" value="1" id="search-in-description">
															<?php } ?>
															<span class="lever"></span>
														</label>
													</div>
												</div>
												<div class="row">
													<div class="col s8">
														<span class="text-bold"><?php echo $text_sub_category; ?>:</span>
													</div>
													<div class="col s4">
														<label>
															<?php if ($sub_category) { ?>
															<input type="checkbox" name="sub_category" value="1"  checked="checked">
															<?php } else { ?>
															<input type="checkbox" name="sub_category" value="1">
															<?php } ?>
															<span class="lever"></span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="flex-reverse">
											<button type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn waves-effect waves-light red"><?php echo $button_search; ?></button>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<?php if ($posts) { ?>
					<ul class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header text-bold arrow-rotate"><?php echo $text_sort; ?></div>
							<div class="collapsible-body white">
								<div class="row">
									<div class="col s6 m6 input-field inline">
										<select id="input-sort" onchange="location = this.value;">
											<?php foreach ($sorts as $sorts) { ?>
											<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
											<option value="<?php echo $sorts['href']; ?>" selected><?php echo $sorts['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_sort; ?></label>
									</div>
									<div class="col s6 m6 input-field inline">
										<select id="input-limit" onchange="location = this.value;">
											<?php foreach ($limits as $limits) { ?>
											<?php if ($limits['value'] == $limit) { ?>
											<option value="<?php echo $limits['href']; ?>" selected><?php echo $limits['text']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<label class="text-bold"><?php echo $text_limit; ?></label>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="row masonry" data-columns>
						<?php foreach ($posts as $post) { ?>
						<div class="card blog-card hoverable">
							<div class="card-image">
								<div class="blog-image-wrap"><img class="scale transition lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $post['thumb']; ?>"></div>
								<a class="btn-floating btn-large halfway-fab waves-effect waves-light blue-grey darken-1" href="<?php echo $post['href']; ?>#comment"><i class="material-icons">comment</i></a>
							</div>
							<div class="card-content blue-grey white-text">
								<a href="<?php echo $post['href']; ?>" class="white-text"><span class="card-title truncate"><?php echo $post['name']; ?></span></a>
							</div>
							<div class="blog-card-tabs">
								<ul class="tabs tabs-fixed-width tabs-swipe blue-grey lighten-5">
									<li class="tab"><a class="waves-effect waves-default" href="#tab-description-card<?php echo $post['post_id']; ?>" class="active"><i class="material-icons">description</i></a></li>
									<li class="tab"><a class="waves-effect waves-default" href="#tab-time-card<?php echo $post['post_id']; ?>"><i class="material-icons">info</i></a></li>
								</ul>
							</div>
							<div class="card-content">
								<div id="tab-description-card<?php echo $post['post_id']; ?>">
									<p><?php echo $post['description']; ?></p>
								</div>
								<div id="tab-time-card<?php echo $post['post_id']; ?>">
									<ul>
										<?php if ($post['author']) { ?>
										<li><span class="text-bold"><?php echo $text_author; ?>:</span>&nbsp;<?php echo $post['author']; ?></li>
										<?php } ?>
										<li><span class="text-bold"><?php echo $text_published; ?></span>&nbsp;<?php echo $post['published']; ?></li>
									</ul>
								</div>
							</div>
							<div class="card-action">
								<a href="<?php echo $post['href']; ?>" class="btn-flat waves-effect waves-default"><?php echo $text_read_more; ?></a>
							</div>
						</div>
						<?php } ?>
					</div>
					<?php if ($pagination) { ?>
					<div class="row">
						<?php echo $pagination; ?>
					</div>
					<?php } ?>
					<?php } else { ?>
						<div class="card-panel center">
							<p class="flow-text text-bold"><?php echo $text_empty; ?></p>
							<img class="responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="catalog/view/theme/materialize/image/search-empty.png" alt="">
						</div>
					<?php } ?>
					<?php echo $content_bottom; ?>
				</div>
				<?php echo $column_right; ?>
			</div>
		</div>
	</main>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$('#button-search').bind('click', function() {
				url = 'index.php?route=blog/search';
				var search = $('#content input[name=\'search\']').prop('value');
				if (search) {
					url += '&search=' + encodeURIComponent(search);
				}
				var category_id = $('#content select[name=\'category_id\']').prop('value');
				if (category_id > 0) {
					url += '&category_id=' + encodeURIComponent(category_id);
				}
				var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');
				if (sub_category) {
					url += '&sub_category=true';
				}
				var filter_description = $('#content input[name=\'description\']:checked').prop('value');
				if (filter_description) {
					url += '&description=true';
				}
				location = url;
			});
			$('#content input[name=\'search\']').bind('keydown', function(e) {
				if (e.keyCode == 13) {
					$('#button-search').trigger('click');
				}
			});
			$('select[name=\'category_id\']').on('change', function() {
				if (this.value == '0') {
					$('input[name=\'sub_category\']').prop('disabled', true);
				} else {
					$('input[name=\'sub_category\']').prop('disabled', false);
				}
			});
			$('select[name=\'category_id\']').trigger('change');
		});
	</script>
<?php echo $footer; ?>