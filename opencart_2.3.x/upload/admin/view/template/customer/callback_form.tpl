<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
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
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-callback">
			<div class="row">
				<div id="callback-data" class="col-sm-12 col-md-4 col-md-push-8">
					<div id="post-data">
						<div class="panel panel-default">
							<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-sliders"></i> <?php echo $tab_data; ?></h3></div>
							<div class="panel-body">
								<div class="form-group">
									<label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
									<select name="status" id="input-status" class="form-control">
										<?php if ($status) { ?>
										<option value="1" selected="selected"><?php echo $text_сalled; ?></option>
										<option value="0"><?php echo $text_waiting; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_сalled; ?></option>
										<option value="0" selected="selected"><?php echo $text_waiting; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?>:</label>
									<div class="">
										<input type="text" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" id="input-date-added" class="form-control" disabled/>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="text-right">
									<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
									<button type="submit" form="form-callback" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-8 col-md-pull-4">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3></div>
						<div class="panel-body form-horizontal">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
								<?php if ($callback_id) { ?>
								<li><a href="#tab-history" data-toggle="tab"><?php echo $tab_history; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-general">
									<fieldset>
										<legend><?php echo $text_account; ?></legend>
										<div class="form-group required">
											<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?>:</label>
											<div class="col-sm-10">
												<input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
												<?php if ($error_telephone) { ?>
												<div class="text-danger"><?php echo $error_telephone; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?>:</label>
											<div class="col-sm-10">
												<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
												<?php if ($error_name) { ?>
												<div class="text-danger"><?php echo $error_name; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?>:</label>
											<div class="col-sm-10">
												<textarea name="enquiry" rows="5" placeholder="<?php echo $entry_enquiry; ?>" id="input-enquiry" class="form-control" style="min-height:100px;resize:vertical;"><?php echo $enquiry; ?></textarea>
												<?php if ($error_enquiry) { ?>
												<div class="text-danger"><?php echo $error_enquiry; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-call-time"><?php echo $entry_call_time; ?>:</label>
											<div class="col-sm-5">
												<div class="input-group time">
													<input type="text" name="call_time" value="<?php echo $call_time; ?>" placeholder="<?php echo $entry_call_time; ?>" data-date-format="HH:mm" id="input-call-time" class="form-control" />
													<span class="input-group-btn">
													<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</span>
												</div>
											</div>
										</div>
									</fieldset>
									<?php if ($callback_id) { ?>
									<br>
									<fieldset>
										<legend><?php echo $text_info; ?></legend>
										<div class="table-responsive">
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<td class="text-left"><b><?php echo $entry_ip; ?></b> </td>
														<td class="text-right"><b><?php echo $entry_order_page; ?></b></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-left"><a href="//www.geoiptool.com/en/?IP=<?php echo $ip; ?>" target="_blank" rel="noopener"><?php echo $ip; ?></a></td>
														<td class="text-right"><a href="<?php echo $order_page; ?>" target="_blank" rel="noopener"><?php echo $order_page; ?></a></td>
													</tr>
												</tbody>
											</table>
										</div>
									</fieldset>
									<?php } ?>
								</div>			 
								<?php if ($callback_id) { ?>
								<div class="tab-pane" id="tab-history">
									<fieldset>
										<legend><?php echo $text_history; ?></legend>
										<div id="history"></div>
									</fieldset>
									<br />
									<fieldset>
										<legend><?php echo $text_history_add; ?></legend>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
											<div class="col-sm-10">
												<textarea name="comment" rows="8" placeholder="<?php echo $entry_comment; ?>" id="input-comment" class="form-control" style="min-height:100px;resize:vertical;"></textarea>
											</div>
										</div>
									</fieldset>
									<div class="text-right">
										<button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_history_add; ?></button>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="panel-footer text-center">
							<i class="fa fa-opencart"></i>&nbsp;
							<a href="//goo.gl/bjyFAW" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" title="<b>Materialize Template</b>" data-content="<?php echo $appeal_marketplace; ?>"><strong>Materialize Template</strong></a>&nbsp;|&nbsp;
							<i class="fa fa-github"></i>&nbsp;
							<a href="//goo.gl/VAM4ww" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" title="<b>GitHub</b>" data-content="<?php echo $appeal_github; ?>">GitHub</a>&nbsp;|&nbsp;
							<i class="fa fa-twitter"></i>&nbsp;
							<a href="//goo.gl/yG1AGS" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" title="<b>Twitter</b>" data-content="<?php echo $appeal_twitter; ?>">Twitter</a>&nbsp;|&nbsp;
							<i class="fa fa-paypal"></i>&nbsp;
							<a href="//goo.gl/Ry4CeM" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" title="<b>PayPal</b>" data-content="<?php echo $appeal_paypal; ?>">PayPal</a>&nbsp;|&nbsp;
							<i class="fa fa-credit-card"></i>&nbsp;
							<a href="//goo.gl/1C4gKu" target="_blank" rel="noopener" class="dotted materialize-appeal__popover" title="<b>Yandex.Money</b>" data-content="<?php echo $appeal_yandex_money; ?>">Yandex.Money</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$('.time').datetimepicker({
	pickDate: false,
	icons: {
		time: "fa fa-clock-o",
		date: "fa fa-calendar",
		up: "fa fa-arrow-up",
		down: "fa fa-arrow-down"
	}
});

$('#history').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#history').load(this.href);
});

$('#history').load('index.php?route=customer/callback/history&token=<?php echo $token; ?>&callback_id=<?php echo $callback_id; ?>');

$('#button-history').on('click', function(e) {
	e.preventDefault();

	$.ajax({
		url: 'index.php?route=customer/callback/addhistory&token=<?php echo $token; ?>&callback_id=<?php echo $callback_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'comment=' + encodeURIComponent($('#tab-history textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-history').button('loading');
		},
		complete: function() {
			$('#button-history').button('reset');
		},
		success: function(json) {
			$('.alert-dismissible').remove();

			if (json['error']) {
				 $('#tab-history').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#tab-history').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#history').load('index.php?route=customer/callback/history&token=<?php echo $token; ?>&callback_id=<?php echo $callback_id; ?>');

				$('#tab-history textarea[name=\'comment\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
</script> 
<?php echo $footer; ?>