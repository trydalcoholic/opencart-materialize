	<footer class="page-footer blue-grey darken-3">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text text-bold"><?php echo $name; ?></h5>
					<p class="grey-text text-lighten-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea itaque, facere dignissimos aliquam eaque velit at iure cupiditate quam ipsam in assumenda unde quae id fuga dolores reprehenderit laborum totam.</p>
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
				<a class="grey-text text-lighten-4 right" href="https://github.com/trydalcoholic/opencart-materialize" target="_blank" rel="noopener">Materialize Template</a>
			</div>
		</div>
	</footer>
	<button type="button" id="back-to-top" class="btn-floating btn-large scale-transition scale-out red z-depth-4 waves-effect waves-light"><i class="material-icons">keyboard_arrow_up</i></button>
	<script defer src="catalog/view/theme/materialize/js/script.js"></script>
</body>
</html>