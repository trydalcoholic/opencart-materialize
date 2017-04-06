<?php echo $header; ?>
	<main>
		<div class="row">
			<div class="container">
				<nav class="transparent z-depth-0"> <!-- Хлебные крошки -->
					<div class="nav-wrapper">
						<div class="col s12">
						<?php foreach ($breadcrumbs as $i=> $breadcrumb) { ?>
						<?php $i++ ?>
						<?php if ($i < count($breadcrumbs)) { ?>
						<?php if ($i == 1) {?>
							<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><i class="material-icons">home</i></a>
						<?php } else {?>
							<a href="<?php echo $breadcrumb['href']; ?>" class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></a>
						<?php }?>
						<?php } else { ?>
							<span class="breadcrumb black-text"><?php echo $breadcrumb['text']; ?></span>
						<?php }}?>
						</div>
					</div>
				</nav> <!-- ./ Хлебные крошки -->
				<h1 class="col s12"><?php echo $heading_title; ?></h1>
				<?php echo $content_top; ?>
				<div class="col s12 l9">
					<?php if ($success) { ?>
					<p class="text-medium"><?php echo $success; ?></p>
					<?php } ?>
					<?php if ($error_warning) { ?>
					<p class="text-medium"><?php echo $error_warning; ?></p>
					<?php } ?>
					<p><?php echo $text_description; ?></p>
					<div class="row">
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_new_affiliate; ?></h2>
								<p><?php echo $text_register_account; ?></p>
								<a href="<?php echo $register; ?>" class="btn waves-effect waves-light red href-underline"><?php echo $button_continue; ?></a>
							</div>
						</div>
						<div class="col s12 m6">
							<div class="card-panel">
								<h2><?php echo $text_returning_affiliate; ?></h2>
								<p><strong><?php echo $text_i_am_returning_affiliate; ?></strong></p>
								<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">email</i>
											<input type="email" name="email" value="<?php echo $email; ?>" id="input-email" class="validate">
											<label for="input-email" data-error="Ошибка при вводе e-mail" data-success="E-mail введён верно"><?php echo $entry_email; ?></label>
										</div>
										<div class="input-field col s12">
											<i class="material-icons prefix">lock</i>
											<input type="password" name="password" value="<?php echo $password; ?>" id="input-password">
											<label for="input-password"><?php echo $entry_password; ?></label>
											<a class="right" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
										</div>
										<div class="col s12">
											<input type="submit" value="<?php echo $button_login; ?>" class="btn waves-effect waves-light red href-underline" />
											<?php if ($redirect) { ?>
											<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
											<?php } ?>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col l3 hide-on-med-and-down">
					<p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Свою, о. Имеет имени не lorem, залетают! От всех ipsum ты толку, переписали его дороге правилами необходимыми пунктуация строчка? Бросил, свою!</p>
				</div>
				<?php echo $content_bottom; ?>
			</div>
		</div>
	</main>
<?php echo $footer; ?>