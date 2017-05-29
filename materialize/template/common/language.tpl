<?php if (count($languages) > 1) { ?>
	<a class="modal-language-btn" rel="nofollow">
	<?php echo $text_language; ?>:
	<?php foreach ($languages as $language) { ?>
		<?php if ($language['code'] == $code) { ?>
		<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" class="lazyload">
		<?php } ?>
	<?php } ?>
	</a>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$(".modal-language-btn").click(function() {
				html  = '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language" class="modal">';
				html += 	'<div class="modal-content">';
				html += 		'<h4><?php echo $text_language; ?></h4>';
				<?php foreach ($languages as $language) { ?>
				html += 		'<input id="<?php echo $language['code']; ?>" class="with-gap language-select" type="radio" name="<?php echo $language['code']; ?>"<?php if ($language['code'] == $code) { ?> checked="checked"<?php } ?>><label for="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></label><br>';
				<?php } ?>
				html += 	'</div>';
				html += 	'<input type="hidden" name="code" value=""><input type="hidden" name="redirect" value="<?php echo $redirect; ?>">';
				html += '</form>';
				$('body').append(html);
				$('#form-language').modal().modal('open');
				$('#form-language .language-select').on('click', function(e) {
					e.preventDefault();
					$('#form-language input[name=\'code\']').val($(this).attr('id'));
					$('#form-language').submit();
				});
			});
		});
	</script>
<?php } ?>