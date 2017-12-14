<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-label').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
		<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $text_materialize; ?></div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3></div>
			<div class="panel-body">
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-label">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="text-left">
										<?php if ($sort == 'mld.name') { ?>
										<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
										<?php } ?>
									</td>
									<td class="text-right">
										<?php if ($sort == 'ml.sort_order') { ?>
										<a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
										<?php } else { ?>
										<a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
										<?php } ?>
									</td>
									<td class="text-right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($labels) { ?>
								<?php foreach ($labels as $label) { ?>
								<tr>
									<td class="text-center">
										<?php if (in_array($label['label_id'], $selected)) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $label['label_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $label['label_id']; ?>" />
										<?php } ?>
									</td>
									<td class="text-left"><?php echo $label['name']; ?></td>
									<td class="text-right"><?php echo $label['sort_order']; ?></td>
									<td class="text-right"><a href="<?php echo $label['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
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
<?php echo $footer; ?>