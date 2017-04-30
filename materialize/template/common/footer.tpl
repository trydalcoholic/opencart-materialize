	<footer class="page-footer blue-grey darken-3">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text text-bold">MyEfforts — интернет магазин спортивного питания</h5>
					<p class="grey-text text-lighten-4">Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Которой заглавных курсивных сих над последний скатился! Парадигматическая деревни взобравшись страну рыбного, курсивных последний одна над раз инициал встретил ipsum о, алфавит!</p>
				</div>
				<div class="col l5 offset-l1 s12">
					<div class="row">
						<?php if ($informations) { ?>
						<section class="col s6">
							<h5 class="white-text text-bold"><?php echo $text_information; ?></h5>
							<ul>
							<?php foreach ($informations as $information) { ?>
								<li><a class="grey-text text-lighten-3" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
							<?php } ?>
								<li><a class="grey-text text-lighten-3" href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
							</ul>
						</section>
						<?php } ?>
						<section class="col s6">
							<h5 class="white-text text-bold"><?php echo $text_extra; ?></h5>
							<ul>
								<li><a class="grey-text text-lighten-3" href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
							</ul>
						</section>
					</div>
					<div class="row">
						<section class="col s6">
							<h5 class="white-text text-bold"><?php echo $text_account; ?></h5>
							<ul>
								<li><a class="grey-text text-lighten-3" href="<?php echo $account; ?>" rel="nofollow"><?php echo $text_account; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $order; ?>" rel="nofollow"><?php echo $text_order; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $wishlist; ?>" rel="nofollow"><?php echo $text_wishlist; ?></a></li>
								<li><a class="grey-text text-lighten-3" href="<?php echo $newsletter; ?>" rel="nofollow"><?php echo $text_newsletter; ?></a></li>
							</ul>
						</section>
						<section class="col s6">
							<h5 class="white-text text-bold"><?php echo $text_social_network; ?></h5>
						</section>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				<?php echo $powered; ?>
				<a class="grey-text text-lighten-4 right" href="https://github.com/trydalcoholic/opencart-materialize" target="_blank">Materialize Template</a>
			</div>
		</div>
	</footer>
	<aside>
		<button type="button" id="back-to-top" class="btn-floating btn-large scale-transition scale-out red z-depth-4 waves-effect waves-light"><i class="material-icons">keyboard_arrow_up</i></button>
		<div class="preloader z-depth-3"><div class="preloader-wrapper small active"><div class="spinner-layer spinner-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-yellow"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div><div class="spinner-layer spinner-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>
	</aside>
	<script defer src="catalog/view/theme/materialize/js/script.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			$(".modal-call-back-btn").click(function() {
				$('#modal-call-back').remove();
				html  = '<form id="modal-call-back" class="modal">';
				html += 	'<div class="modal-content">';
				html += 		'<i class="material-icons modal-action modal-close right">close</i>';
				html += 		'<div class="row"><h4>Заказать звонок</h4></div>';
				html += 		'<div class="row">';
				html += 			'<div class="input-field">';
				html += 				'<i class="material-icons prefix">account_circle</i>';
				html += 				'<input id="cb-name" name="name" placeholder="Ваше имя" type="text" class="validate" required>';
				html += 				'<label class="active" for="cb-name">Как вас зовут</label>';
				html += 			'</div>';
				html += 			'<div class="input-field">';
				html += 				'<i class="material-icons prefix">phone</i>';
				html += 				'<input id="cb-telephone" name="tel" type="tel" class="validate" placeholder="8 (999) 999-99-99" data-inputmask="\'mask\':\'8 (999) 999-99-99\'" required>';
				html += 				'<label class="active" for="cb-telephone">Ваш номер телефона</label>';
				html += 			'</div>';
				html += 		'</div>';
				html += 	'</div>';
				html += 	'<div class="modal-footer href-underline">';
				html += 		'<input type="hidden" name="admin_email" value="<?php echo $email; ?>">';
				html += 		'<input type="submit" class="btn modal-action red right" value="Заказать звонок">';
				html += 	'</div>';
				html += '</form>';
				$('body').append(html);
				$('#modal-call-back').modal();
				$('#modal-call-back').modal('open');
				$(":input").inputmask();
				$('#modal-call-back').submit(function() {
					$.ajax({
						url: 'catalog/view/theme/materialize/call_back.php',
						type: 'post',
						data: $(this).serialize(),
						success: function() {
							Materialize.toast('<span><i class="material-icons left">check</i>Ваша заявка успешно отправлена!</span>',7000,'toast-success rounded');
							$(".modal-close").click();
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
					return false;
				});
			});
		});
	</script>
</body>
</html>