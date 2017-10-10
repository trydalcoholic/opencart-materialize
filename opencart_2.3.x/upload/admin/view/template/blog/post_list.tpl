<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" form="form-post" formaction="<?php echo $copy; ?>" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-post').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo $text_materialize; ?></div>
        <div class="well">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-category"><?php echo $column_category; ?></label>
                <select name="filter_category" id="input-category" class="form-control">
                  <option value="*"></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if ($category['post_count'] >= 1) { ?>
                  <?php if ($category['category_id']==$filter_category) { ?>
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>">&nbsp;&nbsp;<?php echo $category['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-image"><?php echo $entry_image; ?></label>
                <select name="filter_image" id="input-image" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_image) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_image && !is_null($filter_image)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-post">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_category; ?></td>
                  <td class="text-left"><?php if ($sort == 'p.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($posts) { ?>
                <?php foreach ($posts as $post) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($post['post_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $post['post_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $post['post_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($post['image']) { ?>
                    <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $post['name']; ?></td>
                  <td class="text-left">
                    <?php foreach ($categories as $category) { ?>
                    <?php if (in_array($category['category_id'], $post['category'])) { ?>
                    <?php echo $category['name'];?><br>
                    <?php } ?>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $post['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $post['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=blog/post&token=<?php echo $token; ?>';

  var filter_name = $('input[name=\'filter_name\']').val();

  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_category = $('select[name=\'filter_category\']').val();

  if (filter_category != '*') {
    url += '&filter_category=' + encodeURIComponent(filter_category);
  }

  var filter_status = $('select[name=\'filter_status\']').val();

  if (filter_status != '*') {
    url += '&filter_status=' + encodeURIComponent(filter_status);
  }

  var filter_image = $('select[name=\'filter_image\']').val();

  if (filter_image != '*') {
    url += '&filter_image=' + encodeURIComponent(filter_image);
  }

  location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=blog/post/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['post_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
  }
});
//--></script></div>
<?php echo $footer; ?>
