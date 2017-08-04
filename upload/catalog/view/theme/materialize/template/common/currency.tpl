<?php if (count($currencies) > 1) { ?>
	<a class="modal-currency-btn" rel="nofollow">
		<?php echo $text_currency; ?>:
		<?php foreach ($currencies as $currency) { ?>
			<?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
				<?php echo $currency['symbol_left']; ?>
			<?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
				<?php echo $currency['symbol_right']; ?>
			<?php } ?>
		<?php } ?>
	</a>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$(".modal-currency-btn").click(function() {
				html  = '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency" class="modal">';
				html += 	'<div class="modal-content">';
				html += 		'<h4><?php echo $text_currency; ?></h4>';
				<?php foreach ($currencies as $currency) { ?>
					<?php if ($currency['symbol_left']) { ?>
				html += '<input class="with-gap currency-select" name="<?php echo $currency['code']; ?>" type="radio" id="<?php echo $currency['code']; ?>"<?php if ($currency['code'] == $code) { ?> checked="checked"<?php } ?>><label for="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></label><br>';
					<?php } else { ?>
				html += '<input class="with-gap currency-select" name="<?php echo $currency['code']; ?>" type="radio" id="<?php echo $currency['code']; ?>"<?php if ($currency['code'] == $code) { ?> checked="checked"<?php } ?>><label for="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></label><br>';
					<?php } ?>
				<?php } ?>
				html += 	'</div>';
				html += 	'<input type="hidden" name="code" value=""><input type="hidden" name="redirect" value="<?php echo $redirect; ?>">';
				html += '</form>';
				$('body').append(html);
				$('#form-currency').modal().modal('open');
				$('#form-currency .currency-select').on('click', function(e) {
					e.preventDefault();
					$('#form-currency input[name=\'code\']').val($(this).attr('name'));
					$('#form-currency').submit();
				});
			});
		});
	</script>
<?php } ?>