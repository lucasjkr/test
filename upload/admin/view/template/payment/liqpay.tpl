<?php echo $header; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-error"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="box-heading">
      <h1><i class="icon-edit"></i> <?php echo $heading_title; ?></h1>
    </div>
    <div class="box-content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="buttons"><a onclick="$('#form').submit();" class="btn"><i class="icon-ok"></i> <?php echo $button_save; ?></a> <a href="<?php echo $cancel; ?>" class="btn"><i class="icon-remove"></i> <?php echo $button_cancel; ?></a></div>
        <div class="control-group">
          <label class="control-label" for="input-name"><span class="required">*</span> <?php echo $entry_merchant; ?></label>
          <div class="controls">
            <input type="text" name="liqpay_merchant" value="<?php echo $liqpay_merchant; ?>" />
            <?php if ($error_merchant) { ?>
            <span class="error"><?php echo $error_merchant; ?></span>
            <?php } ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><span class="required">*</span> <?php echo $entry_signature; ?></label>
          <div class="controls">
            <input type="text" name="liqpay_signature" value="<?php echo $liqpay_signature; ?>" />
            <?php if ($error_signature) { ?>
            <span class="error"><?php echo $error_signature; ?></span>
            <?php } ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_type; ?></label>
          <div class="controls">
            <select name="liqpay_type">
              <?php if ($liqpay_type == 'liqpay') { ?>
              <option value="liqpay" selected="selected"><?php echo $text_pay; ?></option>
              <?php } else { ?>
              <option value="liqpay"><?php echo $text_pay; ?></option>
              <?php } ?>
              <?php if ($liqpay_type == 'card') { ?>
              <option value="card" selected="selected"><?php echo $text_card; ?></option>
              <?php } else { ?>
              <option value="card"><?php echo $text_card; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_total; ?></label>
          <div class="controls">
            <input type="text" name="liqpay_total" value="<?php echo $liqpay_total; ?>" /> <span class="help-block"><?php echo $help_total; ?></span>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_order_status; ?></label>
          <div class="controls">
            <select name="liqpay_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $liqpay_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_geo_zone; ?></label>
          <div class="controls">
            <select name="liqpay_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $liqpay_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_status; ?></label>
          <div class="controls">
            <select name="liqpay_status">
              <?php if ($liqpay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-name"><?php echo $entry_sort_order; ?></label>
          <div class="controls">
            <input type="text" name="liqpay_sort_order" value="<?php echo $liqpay_sort_order; ?>" class="input-mini" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>