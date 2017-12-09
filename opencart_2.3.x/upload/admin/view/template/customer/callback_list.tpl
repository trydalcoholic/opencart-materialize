<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" onclick="$('#filter-callback').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-callback').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
		<div class="row">
			<div id="filter-callback" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-filter"></i> <?php echo $text_filter; ?></h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label" for="input-id"><?php echo $column_id; ?></label>
							<input type="text" name="filter_id" value="<?php echo $filter_id; ?>" placeholder="<?php echo $column_id; ?>" id="input-id" class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
							<input type="text" name="filter_telephone" value="<?php echo $filter_telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
							<select name="filter_status" id="input-status" class="form-control">
								<option value=""></option>
								<?php if ($filter_status == '1') { ?>
								<option value="1" selected="selected"><?php echo $text_сalled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_сalled; ?></option>
								<?php } ?>
								<?php if ($filter_status == '0') { ?>
								<option value="0" selected="selected"><?php echo $text_waiting; ?></option>
								<?php } else { ?>
								<option value="0"><?php echo $text_waiting; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
							<input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-ip"><?php echo $entry_ip; ?></label>
							<input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" placeholder="<?php echo $entry_ip; ?>" id="input-ip" class="form-control" />
						</div>
						<div class="form-group">
							<label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
							<div class="input-group date">
								<input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right">
						<button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-md-pull-3 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-callback">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
											<td class="text-center">
												<?php if ($sort == 'id') { ?>
													<a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php if ($sort == 'telephone') { ?>
													<a href="<?php echo $sort_telephone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_telephone; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_telephone; ?>"><?php echo $column_telephone; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php if ($sort == 'name') { ?>
													<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php if ($sort == 'status') { ?>
													<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php if ($sort == 'ip') { ?>
													<a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php if ($sort == 'date_added') { ?>
													<a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
												<?php } else { ?>
													<a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
												<?php } ?>
											</td>
											<td class="text-center"><?php echo $column_action; ?></td>
										</tr>
									</thead>
									<tbody>
									<?php if ($callbacks) { ?>
									<?php foreach ($callbacks as $callback) { ?>
									<tr>
										<td class="text-center">
											<?php if (in_array($callback['id'], $selected)) { ?>
											<input type="checkbox" name="selected[]" value="<?php echo $callback['id']; ?>" checked="checked" />
											<?php } else { ?>
											<input type="checkbox" name="selected[]" value="<?php echo $callback['id']; ?>" />
											<?php } ?>
										</td>
										<td class="text-center"><?php echo $callback['id']; ?></td>
										<td class="text-left"><?php echo $callback['telephone']; ?></td>
										<td class="text-left"><?php echo $callback['name']; ?></td>
										<td class="text-left"><?php echo $callback['status']; ?></td>
										<td class="text-left"><a href="//www.geoiptool.com/en/?IP=<?php echo $callback['ip']; ?>" target="_blank" rel="noopener"><?php echo $callback['ip']; ?></a></td>
										<td class="text-left"><?php echo $callback['date_added']; ?></td>
										<td class="text-center">
											<a href="<?php echo $callback['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
										</td>
									</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
	</div>
</div>
<script type="text/javascript">
$('.table-responsive').on('shown.bs.dropdown', function (e) {
	var t = $(this),
		m = $(e.target).find('.dropdown-menu'),
		tb = t.offset().top + t.height(),
		mb = m.offset().top + m.outerHeight(true),
		d = 20;
	if (t[0].scrollWidth > t.innerWidth()) {
		if (mb + d > tb) {
			t.css('padding-bottom', ((mb + d) - tb));
		}
	} else {
		t.css('overflow', 'visible');
	}
}).on('hidden.bs.dropdown', function () {
	$(this).css({'padding-bottom': '', 'overflow': ''});
});

$('#button-filter').on('click', function() {
	url = 'index.php?route=customer/callback&token=<?php echo $token; ?>';
	var filter_id = $('input[name=\'filter_id\']').val();
	if (filter_id) {
		url += '&filter_id=' + encodeURIComponent(filter_id);
	}
	var filter_telephone = $('input[name=\'filter_telephone\']').val();
	if (filter_telephone) {
		url += '&filter_telephone=' + encodeURIComponent(filter_telephone);
	}
	var filter_status = $('select[name=\'filter_status\']').val();
	if (filter_status !== '') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}
	var filter_name = $('input[name=\'filter_name\']').val();
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	var filter_ip = $('input[name=\'filter_ip\']').val();
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	location = url;
});

$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/callback/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['callback_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}
});

$('.date').datetimepicker({
	pickTime: false
});
</script>
<?php echo $footer; ?> 