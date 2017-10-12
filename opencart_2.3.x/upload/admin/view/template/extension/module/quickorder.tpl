<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-quickorder" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>&nbsp;
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $quickorder_title; ?></h1>
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
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3></div>
			<div class="panel-body">
				<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo $text_materialize; ?></div>
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-quickorder" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-action-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="quickorder_status" id="input-action-status" class="form-control">
								<?php if ($quickorder_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<fieldset>
						<legend><?php echo $text_popup; ?></legend>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left" style="width: 70%;"><?php echo $entry_fields; ?></td>
									<td class="text-center" style="width: 15%;"><?php echo $entry_status; ?></td>
									<td class="text-center" style="width: 15%;"><?php echo $entry_required; ?></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-left"><?php echo $text_name; ?></td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_name) { ?>
												<input type="checkbox" name="quickorder_name" id="quickorder-name" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_name" id="quickorder-name" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_name_required) { ?>
												<input type="checkbox" name="quickorder_name_required" id="quickorder-name-required" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_name_required" id="quickorder-name-required" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td class="text-left"><?php echo $text_email; ?></td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_email) { ?>
												<input type="checkbox" name="quickorder_email" id="quickorder-email" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_email" id="quickorder-email" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_email_required) { ?>
												<input type="checkbox" name="quickorder_email_required" id="quickorder-email-required" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_email_required" id="quickorder-email-required" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td class="text-left"><?php echo $text_enquiry; ?></td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_enquiry) { ?>
												<input type="checkbox" name="quickorder_enquiry" id="quickorder-enquiry" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_enquiry" id="quickorder-enquiry" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_enquiry_required) { ?>
												<input type="checkbox" name="quickorder_enquiry_required" id="quickorder-enquiry-required" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_enquiry_required" id="quickorder-enquiry-required" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td class="text-left"><?php echo $text_call_time; ?></td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_calltime) { ?>
												<input type="checkbox" name="quickorder_calltime" id="quickorder-calltime" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_calltime" id="quickorder-calltime" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="checkbox">
											<label>
												<?php if ($quickorder_calltime_required) { ?>
												<input type="checkbox" name="quickorder_calltime_required" id="quickorder-calltime-required" class="quickorder-checkbox" value="1" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="quickorder_calltime_required" id="quickorder-calltime-required" class="quickorder-checkbox" value="1" />
												<?php } ?>
											</label>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</fieldset>
					<br>
					<div class="tab-pane">
						<ul class="nav nav-tabs" id="language">
							<?php foreach ($languages as $language) { ?>
							<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($languages as $language) { ?>
							<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="quickorder_modaltitle<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_modaltitle; ?>"><?php echo $entry_title; ?>:</span></label>
									<div class="col-sm-10">
										<input type="text" name="quickorder_modaltitle<?php echo $language['language_id']; ?>" placeholder="<?php echo $help_modaltitle; ?>" id="quickorder_modaltitle<?php echo $language['language_id']; ?>" value="<?php echo isset(${'quickorder_modaltitle' . $language['language_id']}) ? ${'quickorder_modaltitle' . $language['language_id']} : ''; ?>" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="quickorder_button<?php echo $language['language_id']; ?>"><?php echo $entry_button; ?>:</label>
									<div class="col-sm-10">
										<input type="text" name="quickorder_button<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_button; ?>" id="quickorder_button<?php echo $language['language_id']; ?>" value="<?php echo isset(${'quickorder_button' . $language['language_id']}) ? ${'quickorder_button' . $language['language_id']} : ''; ?>" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="quickorder_success<?php echo $language['language_id']; ?>"><?php echo $entry_success; ?>:</label>
									<div class="col-sm-10">
										<input type="text" name="quickorder_success<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_success; ?>" id="quickorder_success<?php echo $language['language_id']; ?>" value="<?php echo isset(${'quickorder_success' . $language['language_id']}) ? ${'quickorder_success' . $language['language_id']} : ''; ?>" class="form-control" />
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<br>
					<fieldset>
						<legend><?php echo $text_settings; ?></legend>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-phonemask-status"><?php echo $entry_phonemask; ?></label>
							<div class="col-sm-10">
								<select name="quickorder_phonemask" id="input-phonemask-status" class="form-control">
									<?php if ($quickorder_phonemask) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="quickorder-agreement"><span data-toggle="tooltip" title="<?php echo $help_checkout; ?>"><?php echo $entry_checkout; ?></span></label>
							<div class="col-sm-10">
								<select name="quickorder_agreement" id="quickorder-agreement" class="form-control">
									<option value="0"><?php echo $text_none; ?></option>
									<?php foreach ($informations as $information) { ?>
									<?php if ($information['information_id'] == $quickorder_agreement) { ?>
									<option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#language a:first').tab('show');

	var inputStatus = $("#input-action-status"),
		checkboxName = $("#quickorder-name"),
		checkboxEmail = $("#quickorder-email"),
		checkboxEnquiry = $("#quickorder-enquiry"),
		checkboxCalltime = $("#quickorder-calltime"),
		checkboxNameRequired = $("#quickorder-name-required"),
		checkboxEmailRequired = $("#quickorder-email-required"),
		checkboxEnquiryRequired = $("#quickorder-enquiry-required"),
		checkboxCalltimeRequired = $("#quickorder-calltime-required"),
		quickorderCheckbox = $(".quickorder-checkbox");

	if (checkboxName.prop("checked")) {
		checkboxNameRequired.attr("disabled", false);
	} else {
		checkboxNameRequired.attr("disabled", true);
		checkboxNameRequired.removeAttr("checked");
		checkboxNameRequired.parent().parent().addClass("disabled");
	}
	if (checkboxEmail.prop("checked")) {
		checkboxEmailRequired.attr("disabled", false);
	} else {
		checkboxEmailRequired.attr("disabled", true);
		checkboxEmailRequired.removeAttr("checked");
		checkboxEmailRequired.parent().parent().addClass("disabled");
	}
	if (checkboxEnquiry.prop("checked")) {
		checkboxEnquiryRequired.attr("disabled", false);
	} else {
		checkboxEnquiryRequired.attr("disabled", true);
		checkboxEnquiryRequired.removeAttr("checked");
		checkboxEnquiryRequired.parent().parent().addClass("disabled");
	}
	if (checkboxCalltime.prop("checked")) {
		checkboxCalltimeRequired.attr("disabled", false);
	} else {
		checkboxCalltimeRequired.attr("disabled", true);
		checkboxCalltimeRequired.removeAttr("checked");
		checkboxCalltimeRequired.parent().parent().addClass("disabled");
	}

	quickorderCheckbox.on("click", function() {
		if (checkboxName.prop("checked")) {
			checkboxNameRequired.attr("disabled", false);
			checkboxNameRequired.parent().parent().removeClass("disabled");
		} else {
			checkboxNameRequired.attr("disabled", true);
			checkboxNameRequired.removeAttr("checked");
			checkboxNameRequired.parent().parent().addClass("disabled");
		}
		if (checkboxEmail.prop("checked")) {
			checkboxEmailRequired.attr("disabled", false);
			checkboxEmailRequired.parent().parent().removeClass("disabled");
		} else {
			checkboxEmailRequired.attr("disabled", true);
			checkboxEmailRequired.removeAttr("checked");
			checkboxEmailRequired.parent().parent().addClass("disabled");
		}
		if (checkboxEnquiry.prop("checked")) {
			checkboxEnquiryRequired.attr("disabled", false);
			checkboxEnquiryRequired.parent().parent().removeClass("disabled");
		} else {
			checkboxEnquiryRequired.attr("disabled", true);
			checkboxEnquiryRequired.removeAttr("checked");
			checkboxEnquiryRequired.parent().parent().addClass("disabled");
		}
		if (checkboxCalltime.prop("checked")) {
			checkboxCalltimeRequired.attr("disabled", false);
			checkboxCalltimeRequired.parent().parent().removeClass("disabled");
		} else {
			checkboxCalltimeRequired.attr("disabled", true);
			checkboxCalltimeRequired.removeAttr("checked");
			checkboxCalltimeRequired.parent().parent().addClass("disabled");
		}
	});

	if (inputStatus.val() == 0) {$('.quickorder-settings').hide();}

	inputStatus.change(function(){
		if (inputStatus.val() == 0) {$('.quickorder-settings').hide();}
		if (inputStatus.val() == 1) {$('.quickorder-settings').show();}
	});
</script>
<?php echo $footer; ?> 