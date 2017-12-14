<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-label" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $text_materialize; ?></div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3></div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-label" class="form-horizontal">
					<div class="form-group required">
						<label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
								<input type="text" name="label_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($label_description[$language['language_id']]) ? $label_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
							</div>
							<?php if (isset($error_name[$language['language_id']])) { ?><div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div><?php } ?>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo $entry_color; ?></label>
						<div class="col-sm-4">
							<select name="label_color" class="selectpicker show-tick">
								<?php foreach ($label_description_colors as $color) { ?>
								<?php if ($color['name'] == $label_color) { ?>
								<option value="<?php echo $color['name']; ?>" selected="selected"><?php echo $color['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $color['name']; ?>"><?php echo $color['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo $entry_color_text; ?></label>
						<div class="col-sm-4">
							<select name="label_color_text" class="selectpicker show-tick">
								<?php foreach ($label_description_colors_text as $color) { ?>
								<?php if ($color['name'] == $label_color_text) { ?>
								<option value="<?php echo $color['name']; ?>" selected="selected"><?php echo $color['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $color['name']; ?>"><?php echo $color['name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="number" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
						</div>
					</div>
				</form>
			</div>
			<div class="panel-footer text-center">
				<a href="//www.opencart.com/index.php?route=marketplace/extension/info&extension_id=30715" target="_blank" rel="noopener"><strong>Materialize Template</strong></a>&nbsp;|&nbsp;
				<i class="fa fa-github"></i>&nbsp;
				<a href="//github.com/trydalcoholic/opencart-materialize" target="_blank" rel="noopener">GitHub</a>&nbsp;|&nbsp;
				<i class="fa fa-twitter"></i>&nbsp;
				<a href="//twitter.com/trydalcoholic" target="_blank" rel="noopener">Twitter</a>&nbsp;|&nbsp;
				<i class="fa fa-paypal"></i>&nbsp;
				<a href="//www.paypal.me/trydalcoholic" target="_blank" rel="noopener">PayPal</a>&nbsp;|&nbsp;
				<i class="fa fa-credit-card"></i>&nbsp;
				<a href="//money.yandex.ru/to/41001413377821" target="_blank" rel="noopener">Yandex.Money</a>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
$('.selectpicker').selectpicker({
	size: 10,
	liveSearch: true,
	iconBase: 'fa',
	tickIcon: 'fa-check'
});
</script>
<?php echo $footer; ?>