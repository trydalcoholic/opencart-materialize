<footer class="page-footer <?php echo $color_footer.' '.$color_footer_text; ?>">
	<div class="container">
		<div class="row">
			<div class="col l6 s12 <?php echo $color_footer_text; ?>">
				<h5 class="text-bold"><?php echo $footer_title; ?></h5>
				<p><?php echo $footer_description; ?></p>
				<?php if ($footer_contact) { ?>
				<ul class="collection footer-info">
					<li class="collection-item">
						<address><i class="material-icons left">location_on</i><?php echo $address; ?></address>
					</li>
					<li class="collection-item">
						<a class="href-underline inherit-text" href="tel:<?php echo str_replace(array('(',')',' '),'', $telephone);?>"><i class="material-icons left">phone</i><?php echo $telephone; ?></a>
					</li>
					<li class="collection-item">
						<a href="mailto:<?php echo $email; ?>" class="inherit-text"><i class="material-icons left">email</i><?php echo $email; ?></a>
					</li>
					<?php if ($open) { ?>
					<li class="collection-item">
						<span><i class="material-icons left">access_time</i><?php echo $open; ?></span>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<div class="col l5 offset-l1 s12">
				<div class="row">
					<?php if ($informations) { ?>
					<section class="col s6">
						<h5 class="text-bold"><?php echo $text_information; ?></h5>
						<ul>
						<?php foreach ($informations as $information) { ?>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
						<?php } ?>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
						</ul>
					</section>
					<?php } ?>
					<section class="col s6">
						<h5 class="text-bold"><?php echo $text_extra; ?></h5>
						<ul>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
						</ul>
					</section>
				</div>
				<div class="row">
					<section class="col s6">
						<h5 class="text-bold"><?php echo $text_account; ?></h5>
						<ul>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $account; ?>" rel="nofollow"><?php echo $text_account; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $order; ?>" rel="nofollow"><?php echo $text_order; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $wishlist; ?>" rel="nofollow"><?php echo $text_wishlist; ?></a></li>
							<li><a class="<?php echo $color_footer_text; ?>" href="<?php echo $newsletter; ?>" rel="nofollow"><?php echo $text_newsletter; ?></a></li>
						</ul>
					</section>
					<?php if ($social_network) { ?>
					<section class="col s6">
						<h5 class="text-bold"><?php echo $sn_text; ?></h5>
						<ul class="footer-sn">
							<?php if ($facebook) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $facebook; ?>" title="Facebook" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
										<path d="M15.117 0H.883C.395 0 0 .395 0 .883v14.234c0 .488.395.883.883.883h7.663V9.804H6.46V7.39h2.086V5.607c0-2.066 1.262-3.19 3.106-3.19.883 0 1.642.064 1.863.094v2.16h-1.28c-1 0-1.195.48-1.195 1.18v1.54h2.39l-.31 2.42h-2.08V16h4.077c.488 0 .883-.395.883-.883V.883C16 .395 15.605 0 15.117 0" fill-rule="nonzero" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($google) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $google; ?>" title="Google+" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
										<path d="M5.09 7.273v1.745h2.89c-.116.75-.873 2.197-2.887 2.197-1.737 0-3.155-1.44-3.155-3.215S3.353 4.785 5.09 4.785c.99 0 1.652.422 2.03.786l1.382-1.33c-.887-.83-2.037-1.33-3.41-1.33C2.275 2.91 0 5.19 0 8s2.276 5.09 5.09 5.09c2.94 0 4.888-2.065 4.888-4.974 0-.334-.036-.59-.08-.843H5.09zm10.91 0h-1.455V5.818H13.09v1.455h-1.454v1.454h1.455v1.455h1.46V8.727H16" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($instagram) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $instagram; ?>" title="Instagram" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($twitter) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $twitter; ?>" title="Twitter" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($youtube) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $youtube; ?>" title="YouTube" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($vk) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $vk; ?>" title="VK" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.701 18.771h1.437s.433-.047.654-.284c.21-.221.21-.63.21-.63s-.031-1.927.869-2.21c.887-.281 2.012 1.86 3.211 2.683.916.629 1.605.494 1.605.494l3.211-.044s1.682-.105.887-1.426c-.061-.105-.451-.975-2.371-2.76-2.012-1.861-1.742-1.561.676-4.787 1.469-1.965 2.07-3.166 1.875-3.676-.166-.48-1.26-.361-1.26-.361l-3.602.031s-.27-.031-.465.09c-.195.119-.314.391-.314.391s-.572 1.529-1.336 2.82c-1.623 2.729-2.268 2.879-2.523 2.699-.604-.391-.449-1.58-.449-2.432 0-2.641.404-3.75-.781-4.035-.39-.091-.681-.15-1.685-.166-1.29-.014-2.378.01-2.995.311-.405.203-.72.652-.539.675.24.03.779.146 1.064.537.375.506.359 1.636.359 1.636s.211 3.116-.494 3.503c-.495.262-1.155-.28-2.595-2.756-.735-1.26-1.291-2.67-1.291-2.67s-.105-.256-.299-.406c-.227-.165-.557-.225-.557-.225l-3.435.03s-.51.016-.689.24c-.166.195-.016.615-.016.615s2.686 6.287 5.732 9.453c2.79 2.902 5.956 2.715 5.956 2.715l-.05-.055z" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
							<?php if ($odnoklassniki) { ?>
							<li class="footer-sn__item">
								<a class="<?php echo $color_footer_text; ?>" href="<?php echo $odnoklassniki; ?>" title="Odnoklassniki" target="_blank" rel="noopener<?php echo $no_index; ?>">
									<svg class="footer-sn__item-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414">
										<path d="M14.505 17.44a11.595 11.595 0 0 0 3.6-1.49 1.816 1.816 0 0 0-1.935-3.072 7.868 7.868 0 0 1-8.34 0 1.812 1.812 0 0 0-2.502.57 1.813 1.813 0 0 0 .57 2.502 11.526 11.526 0 0 0 3.596 1.49l-3.465 3.465a1.793 1.793 0 0 0 0 2.565c.345.354.81.53 1.275.53.465 0 .93-.176 1.275-.53L12 20.065l3.405 3.405a1.814 1.814 0 0 0 2.565-2.565l-3.465-3.465zM12 12.387a6.2 6.2 0 0 0 6.195-6.192c0-3.416-2.78-6.194-6.195-6.194S5.805 2.779 5.805 6.196A6.201 6.201 0 0 0 12 12.388zm0-8.756a2.569 2.569 0 0 0-2.565 2.565A2.57 2.57 0 0 0 12 8.76a2.569 2.569 0 0 0 2.565-2.565A2.568 2.568 0 0 0 12 3.63z" fill="<?php echo $color_footer_sn; ?>"/>
									</svg>
								</a>
							</li>
							<?php } ?>
						</ul>
					</section>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container <?php echo $color_footer_text; ?>">
			<?php echo $powered; ?>
			<a class="right <?php echo $color_footer_text; ?>" href="//github.com/trydalcoholic/opencart-materialize" target="_blank" rel="noopener">Materialize Template</a>
		</div>
	</div>
</footer>
<button type="button" id="back-to-top" class="btn-floating btn-large scale-transition scale-out z-depth-4 waves-effect waves-light <?php echo $color_btt; ?>"><i class="material-icons <?php echo $color_btt_text; ?>">keyboard_arrow_up</i></button>
<script defer src="catalog/view/theme/materialize/js/script.js"></script>
</body></html>