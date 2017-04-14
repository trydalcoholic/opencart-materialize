<?php if (count($languages) > 1) { ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
		<a class="dropdown-button" data-activates="language" data-beloworigin="true" data-constrainWidth="false" rel="nofollow">
			<?php foreach ($languages as $language) { ?>
			<?php if ($language['code'] == $code) { ?>
			<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" class="lazyload" style="pointer-events:none;">
			<?php } ?>
			<?php } ?>
		</a>
		<ul id="language" class="dropdown-content">
			<?php foreach ($languages as $language) { ?>
			<li>
				<a id="<?php echo $language['code']; ?>" class="language-select" rel="nofollow">
					<img class="flags" src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
					<?php echo $language['name']; ?>
				</a>
			</li>
			<li class="divider"></li>
			<?php } ?>
		</ul>
		<input type="hidden" name="code" value="">
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
	</form>
<?php } ?>