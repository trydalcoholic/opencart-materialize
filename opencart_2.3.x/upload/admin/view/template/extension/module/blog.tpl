<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-blog" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $blog_title; ?></h1>
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
		<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo $text_materialize; ?></div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog" class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
							<?php if ($error_name) { ?>
							<div class="text-danger"><?php echo $error_name; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-control">
								<?php if ($status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend><?php echo $text_search; ?></legend>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-search_status"><?php echo $entry_search_status; ?></label>
						<div class="col-sm-10">
							<select name="search_status" id="input-search_status" class="form-control">
								<?php if ($search_status) { ?>
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
						<label class="col-sm-2 control-label" for="input-search_sort_order"><?php echo $entry_search_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="text" name="search_sort_order" value="<?php echo $search_sort_order; ?>" placeholder="<?php echo $entry_search_sort_order; ?>" id="input-search_sort_order" class="form-control" />
						</div>
					</div>
				</fieldset>
				<fieldset>	
					<legend><?php echo $text_category; ?></legend>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-category_status"><?php echo $entry_category_status; ?></label>
						<div class="col-sm-10">
							<select name="category_status" id="input-category_status" class="form-control">
								<?php if ($category_status) { ?>
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
						<label class="col-sm-2 control-label" for="input-category_sort_order"><?php echo $entry_category_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="text" name="category_sort_order" value="<?php echo $category_sort_order; ?>" placeholder="<?php echo $entry_category_sort_order; ?>" id="input-category_sort_order" class="form-control" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend><?php echo $text_recent_post; ?></legend> 
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-post_status"><?php echo $entry_post_status; ?></label>
						<div class="col-sm-10">
							<select name="post_status" id="input-post_status" class="form-control">
								<?php if ($post_status) { ?>
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
						<label class="col-sm-2 control-label" for="input-post_limit"><?php echo $entry_post_limit; ?></label>
						<div class="col-sm-10">
							<input type="text" name="post_limit" value="<?php echo $post_limit; ?>" placeholder="<?php echo $entry_post_limit; ?>" id="input-post_limit" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-post_sort_order"><?php echo $entry_post_sort_order; ?></label>
						<div class="col-sm-10">
							<input type="text" name="post_sort_order" value="<?php echo $post_sort_order; ?>" placeholder="<?php echo $entry_post_sort_order; ?>" id="input-post_sort_order" class="form-control" />
						</div>
					</div>
				</fieldset>
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
				<i class="fa fa-credit-card-alt"></i>&nbsp;
				<a href="//money.yandex.ru/to/41001413377821" target="_blank" rel="noopener">Yandex.Money</a>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>