<?php echo $header; ?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "BreadcrumbList",
	"itemListElement": [
		<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
		<?php $i++ ?>
		<?php if ($i < count($breadcrumbs)) { ?>
		<?php if ($i == 1) {?>
		<?php } else {?>
		{
			"@type": "ListItem",
			"position": <?php echo ($i-1); ?>,
			"item": {
				"@id": "<?php echo $breadcrumb['href']; ?>",
				"name": "<?php echo $breadcrumb['text']; ?>"
			}
		},
		<?php }?>
		<?php } else { ?>
		{
			"@type": "ListItem",
			"position": <?php echo ($i-1); ?>,
			"item": {
				"@id": "<?php echo $breadcrumb['href']; ?>",
				"name": "<?php echo $breadcrumb['text']; ?>"
			}
		}
		<?php }}?>
	]
}
</script>
<?php if ($column_left && $column_right) { ?>
	<?php $main = 's12 m12 l6'; $image = 's12 m6 l12'; ?>
<?php } elseif ($column_left || $column_right) { ?>
	<?php $main = 's12 l9'; $image = 's12 m6'; ?>
<?php } else { ?>
	<?php $main = 's12'; $image = 's12 m6 xl5'; ?>
<?php } ?>
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
		<div class="row">
			<?php echo $column_left; ?>
			<article id="content" class="col <?php echo $main; ?> section href-underline" itemscope itemtype="http://schema.org/Article">
				<meta itemprop="inLanguage" content="<?php echo $lang; ?>">
				<meta itemprop="datePublished" content="<?php echo $meta_published; ?>">
				<meta itemprop="dateModified" content="<?php echo $meta_modified; ?>">
				<meta itemprop="mainEntityOfPage" content="<?php echo $share; ?>">
				<?php echo $content_top; ?>
				<div class="card-panel post-content">
					<div class="post">
						<div class="post-image-block">
							<ul class="post-info z-depth-1 transition">
								<li><?php echo $published; ?><i class="material-icons left">access_time</i></li>
								<li><?php echo $viewed; ?><i class="material-icons left">visibility</i></li>
							</ul>
							<?php if ($post_image) { ?>
							<figure>
								<img class="scale transition responsive-img lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $post_image; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>">
								<figcaption class="card-title truncate"><?php echo $heading_title; ?></figcaption>
							</figure>
							<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
								<meta itemprop="url" content="<?php echo $post_image; ?>">
								<meta itemprop="width" content="<?php echo $post_image_width; ?>">
								<meta itemprop="height" content="<?php echo $post_image_height; ?>">
							</div>
							<?php } ?>
						</div>
						<h1 itemprop="headline"><?php echo $heading_title; ?></h1>
						<div class="section"><div class="divider"></div></div>
						<blockquote class="right blockquote-note blockquote-note-blog no-padding blue-grey lighten-5 z-depth-1" style="width: 50%;">
							<div class="blockquote-icon blue-grey lighten-4 tooltipped share-icon waves-effect waves-circle" data-position="top" data-delay="50" data-tooltip="<?php echo $button_share; ?>" data-activates="side-share"><i class="material-icons">share</i></div>
							<ul class="collection article-info">
								<?php if ($author) { ?>
								<li class="collection-item">
									<div itemprop="author" itemscope itemtype="https://schema.org/Person">
										<a href="<?php echo $author_link; ?>" target="_blank" rel="noopener" class="chip waves-effect blue-grey lighten-4 black-text"><?php if($author_image) { ?><?php echo ($author_image) ? '<img class="lazyload" src="'.$img_loader.'" data-src="'.$author_image.'" title="'.$author.'" alt="'.$author.'">' : '' ;?><?php } ?><span itemprop="name"><?php echo $author; ?></span></a>
										<?php foreach ($post_authors as $author) { ?>,&nbsp;<a href="<?php echo $author['href']; ?>" target="_blank" rel="noopener" class="chip waves-effect blue-grey lighten-4 black-text"><img src="<?php echo $author['image']; ?>" title="<?php echo $author['name']; ?>" alt="<?php echo $author['name']; ?>"><?php echo $author['name']; ?></a><?php } ?>
									</div>
								</li>
								<?php } ?>
								<li class="collection-item">
									<span class="text-bold"><?php echo $text_published; ?>:&nbsp;</span><span class="text-normal"><?php echo $published; ?></span>
								</li>
								<li class="collection-item">
									<span class="text-bold"><?php echo $text_url; ?>:&nbsp;</span><span id="copy-url" class="text-normal" data-clipboard-text="<?php echo $share; ?>"><?php echo $text_copy; ?></span>
								</li>
							</ul>
						</blockquote>
						<section class="text-justify" itemprop="articleBody">
							<?php echo $description; ?>
						</section>
						<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
							<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
								<meta itemprop="url" content="<?php echo $logo; ?>">
								<meta itemprop="width" content="<?php echo $logo_width; ?>">
								<meta itemprop="height" content="<?php echo $logo_height; ?>">
							</div>
							<meta itemprop="name" content="<?php echo $publisher_org; ?>">
						</div>
					</div>
					<div class="post-footer grey lighten-4">
						<?php if ($tags) { ?>
							<span class="blue-text text-lighten-1"><?php echo $text_tags; ?></span>&nbsp;
							<?php for ($i = 0; $i < count($tags); $i++) { ?>
								<?php if ($i < (count($tags) - 1)) { ?>
								<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>,&nbsp;
								<?php } else { ?>
								<a class="chip waves-effect waves-default" href="<?php echo str_replace(' ', '%20', $tags[$i]['href']); ?>" rel="nofollow"><?php echo $tags[$i]['tag']; ?></a>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<?php if ($posts) { ?>
				<h2><?php echo $text_related; ?></h2>
				<div class="row slick-posts">
					<?php foreach ($posts as $post) { ?>
					<div class="col">
						<div class="card blog-card small horizontal hoverable">
							<div class="card-image">
								<img class="lazyload" src="<?php echo $img_loader; ?>" data-src="<?php echo $post['thumb']; ?>">
							</div>
							<div class="card-stacked">
								<div class="card-content">
									<a class="truncate" href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a>
									<p><?php echo $post['description']; ?></p>
								</div>
								<div class="card-action">
									<a href="<?php echo $post['href']; ?>" class="btn-flat waves-effect waves-default"><?php echo $text_read_more; ?></a>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="card-panel">
					<ul class="collapsible" data-collapsible="accordion">
						<li>
							<div class="collapsible-header arrow-rotate"><i class="material-icons left">mode_edit</i><?php echo $text_write; ?></div>
							<div class="collapsible-body no-padding">
								<div class="row">
									<div class="col s12 offset-l2 l8">
										<form id="form-comment" class="card-panel z-depth-2">
											<div class="input-field">
												<i class="material-icons prefix">account_circle</i>
												<input type="text" name="name" id="input-name" class="validate">
												<label for="input-name"><?php echo $entry_name; ?></label>
											</div>
											<div class="input-field">
												<i class="material-icons prefix">email</i>
												<input type="email" name="email" id="input-email" class="validate tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo $help_email; ?>">
												<label for="input-email" data-error="<?php echo $text_email_error; ?>" data-success="<?php echo $text_email_success; ?>"><?php echo $entry_email; ?></label>
											</div>
											<div class="input-field">
												<i class="material-icons prefix">mode_edit</i>
												<textarea name="text" rows="5" id="input-comment" class="materialize-textarea"></textarea>
												<label for="input-comment"><?php echo $entry_comment; ?></label>
												<small><?php echo $text_note; ?></small>
											</div>
											<?php echo $captcha; ?>
											<div class="flex-reverse">
												<button type="button" id="button-comment" class="btn waves-effect waves-light red right"><?php echo $button_continue; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div id="comment"></div>
				</div>
				<?php echo $content_bottom; ?>
			</article>
			<?php echo $column_right; ?>
		</div>
	</div>
	<aside>
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true"><div class="pswp__bg"></div><div class="pswp__scroll-wrap"><div class="pswp__container"><div class="pswp__item"></div><div class="pswp__item"></div><div class="pswp__item"></div></div><div class="pswp__ui pswp__ui--hidden"><div class="pswp__top-bar"><div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="<?php echo $button_pswp_close; ?>"></button><button class="pswp__button pswp__button--share" title="<?php echo $button_share; ?>"></button><button class="pswp__button pswp__button--fs" title="<?php echo $button_pswp_toggle_fullscreen; ?>"></button><button class="pswp__button pswp__button--zoom" title="<?php echo $button_pswp_zoom; ?>"></button><div class="pswp__preloader"><div class="pswp__preloader__icn"><div class="pswp__preloader__cut"><div class="pswp__preloader__donut"></div></div></div></div></div><div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap"><div class="pswp__share-tooltip"></div></div><button class="pswp__button pswp__button--arrow--left" title="<?php echo $button_pswp_prev; ?>"></button><button class="pswp__button pswp__button--arrow--right" title="<?php echo $button_pswp_next; ?>"></button><div class="pswp__caption"><div class="pswp__caption__center"></div></div></div></div></div>
		<ul id="side-share" class="side-nav href-underline">
			<li>
				<a class="waves-effect waves-default" href="https://vk.com/share.php?url=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="vk" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M7.828 12.526h.957s.288-.032.436-.19c.14-.147.14-.42.14-.42s-.02-1.284.58-1.473c.59-.187 1.34 1.24 2.14 1.788.61.42 1.07.33 1.07.33l2.14-.03s1.12-.07.59-.95c-.04-.07-.3-.65-1.58-1.84-1.34-1.24-1.16-1.04.45-3.19.98-1.31 1.38-2.11 1.25-2.45-.11-.32-.84-.24-.84-.24l-2.4.02s-.18-.02-.31.06-.21.26-.21.26-.38 1.02-.89 1.88C10.27 7.9 9.84 8 9.67 7.88c-.403-.26-.3-1.053-.3-1.62 0-1.76.27-2.5-.52-2.69-.26-.06-.454-.1-1.123-.11-.86-.01-1.585.006-1.996.207-.27.135-.48.434-.36.45.16.02.52.098.71.358.25.337.24 1.09.24 1.09s.14 2.077-.33 2.335c-.33.174-.77-.187-1.73-1.837-.49-.84-.86-1.78-.86-1.78s-.07-.17-.2-.27c-.15-.11-.37-.15-.37-.15l-2.29.02s-.34.01-.46.16c-.11.13-.01.41-.01.41s1.79 4.19 3.82 6.3c1.86 1.935 3.97 1.81 3.97 1.81z"/>
						</svg>
					</span>
					VK
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://www.facebook.com/sharer.php?u=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="facebook" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M15.117 0H.883C.395 0 0 .395 0 .883v14.234c0 .488.395.883.883.883h7.663V9.804H6.46V7.39h2.086V5.607c0-2.066 1.262-3.19 3.106-3.19.883 0 1.642.064 1.863.094v2.16h-1.28c-1 0-1.195.48-1.195 1.18v1.54h2.39l-.31 2.42h-2.08V16h4.077c.488 0 .883-.395.883-.883V.883C16 .395 15.605 0 15.117 0" fill-rule="nonzero"/>
						</svg>
					</span>
					Facebook
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://plus.google.com/share?url=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="googleplus" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M5.09 7.273v1.745h2.89c-.116.75-.873 2.197-2.887 2.197-1.737 0-3.155-1.44-3.155-3.215S3.353 4.785 5.09 4.785c.99 0 1.652.422 2.03.786l1.382-1.33c-.887-.83-2.037-1.33-3.41-1.33C2.275 2.91 0 5.19 0 8s2.276 5.09 5.09 5.09c2.94 0 4.888-2.065 4.888-4.974 0-.334-.036-.59-.08-.843H5.09zm10.91 0h-1.455V5.818H13.09v1.455h-1.454v1.454h1.455v1.455h1.46V8.727H16"/>
						</svg>
					</span>
					Google+
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="odnoklassniki" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M9.67 11.626c.84-.19 1.652-.524 2.4-.993.564-.356.734-1.103.378-1.668-.356-.566-1.102-.737-1.668-.38-1.692 1.063-3.87 1.063-5.56 0-.566-.357-1.313-.186-1.668.38-.356.566-.186 1.312.38 1.668.746.47 1.556.802 2.397.993l-2.31 2.31c-.48.47-.48 1.237 0 1.71.23.236.54.354.85.354.31 0 .62-.118.85-.354L8 13.376l2.27 2.27c.47.472 1.237.472 1.71 0 .472-.473.472-1.24 0-1.71l-2.31-2.31zM8 8.258c2.278 0 4.13-1.852 4.13-4.128C12.13 1.852 10.277 0 8 0S3.87 1.852 3.87 4.13c0 2.276 1.853 4.128 4.13 4.128zM8 2.42c-.942 0-1.71.767-1.71 1.71 0 .942.768 1.71 1.71 1.71.943 0 1.71-.768 1.71-1.71 0-.943-.767-1.71-1.71-1.71z"/>
						</svg>
					</span>
					Odnoklassniki
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://twitter.com/share?url=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="twitter" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M16 3.038c-.59.26-1.22.437-1.885.517.677-.407 1.198-1.05 1.443-1.816-.634.37-1.337.64-2.085.79-.598-.64-1.45-1.04-2.396-1.04-1.812 0-3.282 1.47-3.282 3.28 0 .26.03.51.085.75-2.728-.13-5.147-1.44-6.766-3.42C.83 2.58.67 3.14.67 3.75c0 1.14.58 2.143 1.46 2.732-.538-.017-1.045-.165-1.487-.41v.04c0 1.59 1.13 2.918 2.633 3.22-.276.074-.566.114-.865.114-.21 0-.41-.02-.61-.058.42 1.304 1.63 2.253 3.07 2.28-1.12.88-2.54 1.404-4.07 1.404-.26 0-.52-.015-.78-.045 1.46.93 3.18 1.474 5.04 1.474 6.04 0 9.34-5 9.34-9.33 0-.14 0-.28-.01-.42.64-.46 1.2-1.04 1.64-1.7z" fill-rule="nonzero"/>
						</svg>
					</span>
					Twitter
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://telegram.me/share/url?url=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="telegram" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M12.793 10.69c.57-1.56 2.66-7.49 2.994-9.044.38-1.76-.414-1.93-2.22-1.34-1.805.59-6.435 2.305-7.215 2.582-.78.277-4.573 1.552-5.36 1.932-1.606.862-.825 2.177.97 2.86 5.37 2.577 3.845 1.264 6.242 6.032.493 1.218 1.656 3.293 2.77 1.724.586-.892 1.37-3.52 1.82-4.747z" fill-rule="nonzero"/>
						</svg>
					</span>
					Telegram
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="whatsapp://send?text=<?php echo str_replace(' ', '%20', htmlspecialchars($heading_title)).'%20'.urlencode($share); ?>" data-action="share/whatsapp/share" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="whatsapp" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M11.665 9.588c-.2-.1-1.177-.578-1.36-.644-.182-.067-.315-.1-.448.1-.132.197-.514.643-.63.775-.116.13-.232.14-.43.05-.2-.1-.842-.31-1.602-.99-.592-.53-.99-1.18-1.107-1.38-.116-.2-.013-.31.087-.41.09-.09.2-.23.3-.35.098-.12.13-.2.198-.33.066-.14.033-.25-.017-.35-.05-.1-.448-1.08-.614-1.47-.16-.39-.325-.34-.448-.34-.115-.01-.248-.01-.38-.01-.134 0-.35.05-.532.24-.182.2-.696.68-.696 1.65s.713 1.91.812 2.05c.1.13 1.404 2.13 3.4 2.99.476.2.846.32 1.136.42.476.15.91.13 1.253.08.383-.06 1.178-.48 1.344-.95.17-.47.17-.86.12-.95-.05-.09-.18-.14-.38-.23M8.04 14.5h-.01c-1.18 0-2.35-.32-3.37-.92l-.24-.143-2.5.65.67-2.43-.16-.25c-.66-1.05-1.01-2.26-1.01-3.506 0-3.63 2.97-6.59 6.628-6.59 1.77 0 3.43.69 4.68 1.94 1.25 1.24 1.94 2.9 1.94 4.66-.003 3.63-2.973 6.59-6.623 6.59M13.68 2.3C12.16.83 10.16 0 8.03 0 3.642 0 .07 3.556.067 7.928c0 1.397.366 2.76 1.063 3.964L0 16l4.223-1.102c1.164.63 2.474.964 3.807.965h.004c4.39 0 7.964-3.557 7.966-7.93 0-2.117-.827-4.11-2.33-5.608"/>
						</svg>
					</span>
					WhatsApp
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="viber://forward?text=<?php echo str_replace(' ', '%20', htmlspecialchars($heading_title)).'%20'.urlencode($share); ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="viber" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M13.874 1.56C13.476 1.194 11.87.027 8.29.01c0 0-4.22-.253-6.277 1.634C.868 2.79.465 4.464.423 6.544.38 8.62.325 12.514 4.08 13.57h.003l-.003 1.612s-.023.652.406.785c.52.16.824-.336 1.32-.87.273-.293.648-.724.932-1.054 2.567.216 4.542-.277 4.766-.35.518-.17 3.45-.544 3.928-4.438.492-4.015-.238-6.553-1.558-7.698zm.435 7.408c-.41 3.25-2.79 3.457-3.22 3.597-.19.06-1.93.492-4.11.35 0 0-1.63 1.96-2.13 2.47-.08.08-.18.11-.24.096-.09-.02-.11-.12-.11-.27l.01-2.67c-.01 0 0 0 0 0-3.18-.89-2.99-4.2-2.95-5.94.03-1.73.36-3.15 1.33-4.11C4.63.91 8.22 1.15 8.22 1.15c3.028.01 4.48.923 4.815 1.23 1.116.955 1.685 3.243 1.27 6.595zM5.16 3.32c.162 0 .307.073.42.207.002.002.387.464.553.69.157.213.367.553.474.743.19.34.07.688-.115.832l-.377.3c-.19.152-.167.436-.167.436s.56 2.105 2.64 2.635c0 0 .283.026.436-.164l.3-.38c.142-.19.49-.31.83-.12.19.1.53.31.744.47.226.16.688.55.69.55.22.18.27.46.12.74v.01c-.154.27-.36.52-.622.76h-.005c-.21.18-.42.28-.63.3-.02 0-.05.01-.09 0-.09 0-.18-.02-.27-.04v-.01c-.32-.09-.85-.32-1.73-.81-.57-.32-1.05-.64-1.46-.97-.21-.17-.43-.36-.65-.58L6.2 8.9l-.02-.02-.02-.02c-.22-.22-.41-.44-.58-.653-.32-.406-.64-.885-.96-1.46-.49-.88-.72-1.41-.81-1.73H3.8c-.03-.09-.05-.18-.04-.27-.01-.04 0-.07 0-.093.02-.2.126-.41.305-.63h.003c.237-.26.492-.47.764-.622.11-.06.22-.09.32-.09h.01zm2.73-.456h.078l.05.002h.013l.06.003h.34l.09.01h.05l.1.01h.02l.07.01h.01l.05.01c.03 0 .05.01.07.01h.06l.05.02.04.01.04.01.02.01h.03l.03.01h.02l.05.01.03.01.03.01.04.01.02.01c.02 0 .04.01.06.01l.03.01.03.01.08.03.04.02.09.04.03.01.03.01.06.03.04.01.02.01.05.02.02.01.04.02.03.01.03.02.04.02.03.02.02.01.04.02.03.02.05.03.03.01.05.03.01.01.03.02.06.05.03.02.03.02.02.01.03.02.05.05.04.03.03.02.01.01.02.01.05.04.03.03.02.02.03.02.03.02.02.01.08.08.04.04.09.09.02.02c.01.01.03.03.04.05l.02.02.11.13.03.04c.01.01.01.02.02.02l.06.09.03.03.06.08.05.08.03.06.04.07.03.06.01.02.02.04.05.1.05.1.02.05c.04.09.07.18.11.28.05.13.09.27.12.42.03.11.05.21.07.32l.02.18.03.2c.01.08.02.17.02.25.01.08.01.16.01.24v.17c0 .01-.005.02-.01.03-.01.02-.02.03-.04.05-.014.01-.033.03-.053.03-.02.01-.04.01-.06.01h-.03c-.02 0-.04-.01-.06-.02-.02-.01-.04-.02-.05-.04-.01-.02-.03-.04-.04-.06-.01-.02-.02-.04-.02-.06V6.9c-.01-.14-.02-.284-.04-.426-.01-.098-.03-.19-.04-.28 0-.05-.01-.098-.02-.14l-.02-.1-.024-.09-.01-.06-.03-.1c-.02-.08-.05-.16-.08-.24-.02-.06-.04-.11-.07-.16l-.02-.05-.09-.18-.02-.03c-.04-.09-.09-.18-.15-.26l-.03-.05H11l-.043-.06c-.036-.06-.076-.11-.12-.16l-.083-.1-.01-.01-.03-.038-.024-.03-.05-.05-.01-.02-.047-.04-.03-.03-.055-.05-.027-.025-.03-.03-.01-.01c-.01-.01-.03-.03-.05-.04L10.33 4l-.02-.01-.04-.03-.05-.04-.03-.024-.02-.01-.04-.036c0-.01-.01-.01-.02-.01l-.02-.02-.01-.01V3.8l-.02-.01-.04-.025-.03-.02-.05-.03-.04-.03-.02-.01-.02-.01H9.8l-.013-.01-.044-.023-.005-.01-.02-.01-.03-.015H9.68l-.03-.01-.017-.01-.03-.01-.007-.007-.02-.01-.035-.02-.02-.01-.06-.02-.05-.02-.09-.01-.03-.02c-.01-.006-.02-.01-.03-.01l-.02-.01c-.02-.007-.03-.01-.05-.02l-.02-.01h-.02l-.04-.02-.02-.01-.03-.01H9c-.005 0-.012-.003-.02-.005h-.06l-.03-.01h-.01l-.03-.01h-.027c-.017-.01-.03-.01-.047-.01l-.006-.01-.04-.01c-.02-.01-.037-.01-.056-.01l-.03-.01-.033-.01-.03-.01-.04-.01H8.5l-.12-.018h-.06l-.078-.01h-.05l-.046-.006h-.02l-.036-.01H7.9l-.007-.01h-.04c-.02 0-.043-.01-.06-.02-.02-.01-.04-.02-.054-.04l-.02-.03c-.02-.02-.02-.04-.03-.06-.01-.02-.01-.04-.01-.06 0-.02 0-.04.01-.06.01-.02.02-.04.04-.05.01-.02.03-.03.05-.04.02-.01.04-.02.06-.02h.04zm.37 1.05l.024.002.04.004c.006 0 .012 0 .02.002.015 0 .03.003.05.004l.04.005.016.01.03.01.032.01.03.01h.02l.028.01.047.01.037.01.018.01h.048l.08.02.03.01.03.01.03.01s.01 0 .01.01l.03.01.03.01.03.01c.01 0 .02.01.03.01.005 0 .01.01.017.01l.043.02h.02l.06.02.033.02.03.02.073.03.04.01.02.02c.03.01.06.03.09.04l.032.02.032.02.033.02c.03.02.054.03.08.05l.02.01.027.02.015.01.05.03.025.02.043.03.02.01.02.01.03.02.04.03c.01.01.015.01.023.02.006.01.01.01.017.02l.022.02.024.02.02.02.03.03.02.02.01.01.06.06.01.01c0 .01.01.02.02.02l.01.01.03.03.02.03.02.02.03.04.03.03.06.08.01.02.04.05.01.02.01.02.01.02.01.02c.01.01.01.02.02.04l.03.05.01.01.02.04.02.03c.01.01.01.02.02.03l.02.03.02.04.02.04.01.03c.01.03.03.05.04.08 0 .01.01.02.01.03l.03.08.04.13c0 .01.01.03.01.04l.03.09.03.12.03.16c.01.05.01.09.02.14.01.08.02.16.02.24l.01.14v.11c0 .01 0 .02-.01.03L10.9 7c-.02.015-.03.03-.05.04-.02.01-.04.02-.06.027-.02.01-.05.01-.07.01-.02 0-.04-.01-.06-.02-.01 0-.02-.01-.03-.014-.02-.01-.04-.026-.05-.044-.02-.02-.03-.04-.03-.06l-.01-.03V6.7c0-.088-.01-.17-.02-.256-.01-.09-.03-.19-.05-.28-.02-.06-.03-.12-.05-.174l-.02-.06-.02-.05-.01-.02-.03-.08-.03-.06-.05-.1-.046-.08v-.01l-.02-.032-.02-.025-.03-.05-.03-.04-.06-.08c-.03-.04-.06-.08-.094-.118-.01-.01-.02-.02-.02-.03l-.02-.02-.01-.01-.02-.01-.02-.018V5l-.08-.076-.05-.045v-.01l-.02-.02-.025-.02-.01-.01c0-.01-.01-.01-.02-.01l-.03-.01-.01-.01-.04-.03-.01-.01-.01-.01c-.008-.01-.015-.01-.02-.01l-.04-.03-.01-.01-.04-.02-.007-.01-.03-.02-.02-.01-.02-.02-.02-.02h-.01c-.02-.02-.04-.03-.07-.04l-.03-.02-.02-.01-.01-.01-.03-.02-.03-.01-.04-.02-.03-.01-.01-.01-.037-.01v-.01l-.06-.02-.04-.02-.02-.01h-.04c-.02-.01-.03-.01-.05-.02H8.8l-.03-.01h-.03l-.03-.01-.02-.01h-.04l-.04-.01-.02-.01h-.11l-.046-.01H8.2l-.03-.01c-.02-.01-.04-.02-.06-.04-.01-.02-.03-.04-.04-.06-.01-.02-.02-.04-.02-.06v-.06c.003-.03.01-.05.02-.07.005-.01.01-.02.02-.03.012-.02.03-.04.05-.05.01-.01.02-.01.03-.02.02-.01.04-.01.06-.01h.04zM8.562 5c.01 0 .02 0 .03.002.01 0 .02 0 .03.002l.034.003c.07.006.142.016.212.03l.07.016.017.005.076.02.04.013.03.01c.03.01.06.03.09.04l.01.01.04.02.06.03.02.01c.01.01.02.01.03.02.01.01.03.02.04.03.04.02.07.05.1.07l.07.06.06.06.04.05.02.02.02.02.03.04.06.09.05.09.04.08.03.07c.03.07.04.13.06.2.02.06.03.13.04.19l.01.1.01.09v.04c0 .03-.01.05-.02.07-.01.02-.03.05-.05.06-.02.02-.04.03-.07.04-.02.01-.04.01-.06.01-.02 0-.04 0-.06-.01l-.07-.03c-.02-.02-.04-.03-.06-.06-.01-.02-.02-.04-.03-.07v-.11l-.01-.07-.01-.08-.01-.07-.01-.04c0-.01-.01-.03-.01-.04-.02-.08-.06-.16-.1-.24l-.04-.04-.03-.04-.03-.03-.01-.02-.05-.04-.04-.04-.04-.03c-.01-.01-.02-.01-.04-.02l-.06-.04-.04-.02-.02-.01h-.01L9 5.54l-.06-.02-.06-.01h-.05L8.8 5.5l-.024-.005h-.03l-.04-.01h-.17l-.01-.05H8.5c-.02-.003-.036-.01-.053-.02-.023-.014-.043-.03-.06-.053-.012-.02-.023-.04-.03-.06-.005-.02-.008-.04-.008-.06 0-.025 0-.05.01-.076s.02-.047.04-.066l.04-.03c.02-.01.04-.02.06-.02L8.54 5h.02z"/>
						</svg>
					</span>
					Viber
				</a>
			</li>
			<li>
				<a class="waves-effect waves-default" href="https://web.skype.com/share?url=<?php echo $share; ?>" rel="nofollow noopener" target="_blank">
					<span class="side-share__item">
						<svg class="skype" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
							<path d="M8.035 12.6c-2.685 0-3.885-1.322-3.885-2.313 0-.51.374-.865.89-.865 1.15 0 .85 1.653 2.995 1.653 1.096 0 1.703-.597 1.703-1.208 0-.368-.18-.775-.904-.954l-2.387-.597C4.524 7.833 4.175 6.79 4.175 5.812c0-2.034 1.91-2.798 3.704-2.798 1.65 0 3.6.916 3.6 2.136 0 .523-.46.827-.97.827-.98 0-.8-1.36-2.78-1.36-.98 0-1.53.444-1.53 1.08 0 .636.77.84 1.44.993l1.76.392c1.93.433 2.42 1.566 2.42 2.633 0 1.652-1.27 2.886-3.82 2.886m7.4-3.26l-.02.09-.03-.16c.01.03.03.05.04.08.08-.45.12-.91.12-1.37 0-1.02-.2-2.01-.6-2.95-.38-.9-.93-1.71-1.62-2.4-.7-.69-1.5-1.24-2.4-1.62C10.01.59 9.02.39 8 .39c-.48 0-.964.047-1.43.137l.08.04-.16-.023.08-.016C5.927.183 5.205 0 4.472 0 3.278 0 2.155.466 1.31 1.313.465 2.16 0 3.286 0 4.483c0 .763.195 1.512.563 2.175l.013-.083.028.16-.04-.077c-.076.43-.115.867-.115 1.305 0 1.022.2 2.014.59 2.948.38.91.92 1.72 1.62 2.41.69.7 1.5 1.24 2.4 1.63.93.4 1.92.6 2.94.6.44 0 .89-.04 1.32-.12l-.08-.04.16.03-.09.02c.67.38 1.42.58 2.2.58 1.19 0 2.31-.46 3.16-1.31.84-.84 1.31-1.97 1.31-3.17 0-.76-.2-1.51-.57-2.18" fill-rule="nonzero"/>
						</svg>
					</span>
					Skype
				</a>
			</li>
		</ul>
	</aside>
</main>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	// Share side
	$('.share-icon').sideNav({edge:'right'});
	// Image hover
	$('.post-image-block figure').hover(
		function(){$('.post-info').css('opacity','1');},
		function(){$('.post-info').css('opacity','.7');}
	);
	// Clipboard
	var copyUrl = new Clipboard('#copy-url');

	copyUrl.on('success', function(e) {
		Materialize.toast('<span><i class="material-icons left">check</i><?php echo $text_сlipboard_succeess; ?></span>',7000,'toast-success');
	});

	copyUrl.on('error', function(e) {
		Materialize.toast('<span><i class="material-icons left">warning</i><?php echo $text_сlipboard_error; ?></span>',7000,'toast-warning');
	});
	// Comment
	$('#comment').load('index.php?route=blog/post/comment&post_id=<?php echo $post_id; ?>');
	$('#comment').delegate('.pagination a', 'click', function(e) {
		e.preventDefault();
		$('#comment').fadeOut('slow');
		$('#comment').load(this.href);
		$('#comment').fadeIn('slow');
	});

	$('#button-comment').on('click', function() {
		$.ajax({
			url: 'index.php?route=blog/post/write&post_id=<?php echo $post_id; ?>',
			type: 'post',
			dataType: 'json',
			data: $("#form-comment").serialize(),
			success: function(json) {
				if (json['error']) {
					Materialize.toast('<i class="material-icons left">warning</i>'+json['error'],7000,'toast-warning');
				}
				if (json['success']) {
					Materialize.toast('<i class="material-icons left">check</i>'+json['success'],7000,'toast-success');
					$('input[name=\'name\']').val('');
					$('input[name=\'email\']').val('');
					$('textarea[name=\'text\']').val('');
					$('textarea[name=\'text\']').trigger('autoresize');
				}
			}
		});
	});
	// Posts slider
	$('.slick-posts').not('.slick-initialized').slick({
		dots: true,
		infinite: true,
		speed: 300,
		autoplay: true,
		dots: false,
		autoplaySpeed: 5000,
		slidesToShow: 2,
		slidesToScroll: 2,
		responsive: [
			{
				breakpoint: 801,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});
	// Common slider
	$('.blog-slider').not('.slick-initialized').slick({
		lazyLoad: 'ondemand',
		infinite: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: true,
		responsive: [
			{
				breakpoint: 601,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 921,
				settings: {
					slidesToShow: 2
				}
			}
		]
	});
});
</script>
<?php echo $footer; ?>