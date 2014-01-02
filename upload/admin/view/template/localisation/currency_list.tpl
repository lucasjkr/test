<?php echo $header; ?>
<div class="page-header">
  <div class="container">
    <div class="pull-right"><a href="<?php echo $insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $button_insert; ?></a>
      <button type="button" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-currency').submit() : false;"><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></button>
    </div>
    <h1><i class="fa fa-bars fa-lg"></i> <?php echo $heading_title; ?></h1>
  </div>
</div>
<div id="content" class="container">
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
  <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-currency">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <td width="1" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
            <td class="text-left"><?php if ($sort == 'title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
              <?php } ?></td>
            <td class="text-left"><?php if ($sort == 'code') { ?>
              <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php if ($sort == 'value') { ?>
              <a href="<?php echo $sort_value; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_value; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_value; ?>"><?php echo $column_value; ?></a>
              <?php } ?></td>
            <td class="text-left"><?php if ($sort == 'date_modified') { ?>
              <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($currencies) { ?>
          <?php foreach ($currencies as $currency) { ?>
          <tr>
            <td class="text-center"><?php if (in_array($currency['currency_id'], $selected)) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $currency['currency_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $currency['currency_id']; ?>" />
              <?php } ?></td>
            <td class="text-left"><?php echo $currency['title']; ?></td>
            <td class="text-left"><?php echo $currency['code']; ?></td>
            <td class="text-right"><?php echo $currency['value']; ?></td>
            <td class="text-left"><?php echo $currency['date_modified']; ?></td>
            <td class="text-right"><a href="<?php echo $currency['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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
<?php echo $footer; ?> 