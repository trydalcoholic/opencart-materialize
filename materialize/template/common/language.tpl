<?php if (count($languages) > 1) { ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
		<a class="dropdown-button" data-activates="language" rel="nofollow">
			<?php foreach ($languages as $language) { ?>
			<?php if ($language['code'] == $code) { ?>
			<img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
			<?php } ?>
			<?php } ?>
			<span class="hide-on-med-and-down"><?php echo $text_language; ?><i class="material-icons right">arrow_drop_down</i></span>
		</a>
		<ul id="language" class="dropdown-content">
			<?php foreach ($languages as $language) { ?>
			<li>
				<a id="<?php echo $language['code']; ?>" class="language-select" rel="nofollow">
					<img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
					<span><?php echo $language['name']; ?></span>
				</a>
			</li>
			<?php } ?>
			</ul>
		<input type="hidden" name="code" value="">
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
	</form>
<?php } ?>