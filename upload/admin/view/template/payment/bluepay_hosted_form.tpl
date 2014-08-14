<?php echo $header; ?><?php echo $menu; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-bluepay-hosted-form" class="btn btn-primary"><i class="fa fa-check-circle"></i> <?php echo $button_save; ?></button>
        <a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a></div>
      <h1><i class="fa fa-credit-card"></i> <?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bluepay-hosted-form" class="form-horizontal">
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-account-name"><?php echo $entry_account_name; ?></label>
        <div class="col-sm-10">
          <input type="text" name="bluepay_hosted_form_account_name" value="<?php echo $bluepay_hosted_form_account_name; ?>" placeholder="<?php echo $entry_account_name; ?>" id="input-account-name" class="form-control" />
          <?php if ($error_account_name) { ?>
          <div class="text-danger"><?php echo $error_account_name; ?></div>
          <?php } ?>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="input-account-id"><?php echo $entry_account_id; ?></label>
        <div class="col-sm-10">
          <input type="text" name="bluepay_hosted_form_account_id" value="<?php echo $bluepay_hosted_form_account_id; ?>" placeholder="<?php echo $entry_account_id; ?>" id="input-account-id" class="form-control" />
          <?php if ($error_account_id) { ?>
          <div class="text-danger"><?php echo $error_account_id; ?></div>
          <?php } ?>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="entry_secret_key"><?php echo $entry_secret_key; ?></label>
        <div class="col-sm-10">
          <input type="text" name="bluepay_hosted_form_secret_key" value="<?php echo $bluepay_hosted_form_secret_key; ?>" placeholder="<?php echo $entry_secret_key; ?>" id="bluepay_hosted_form_secret_key" class="form-control" />
          <?php if ($error_secret_key) { ?>
          <div class="text-danger"><?php echo $error_secret_key; ?></div>
          <?php } ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-test"><?php echo $entry_test; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_test" id="input-test" class="form-control">
            <?php if ($bluepay_hosted_form_test == 'test') { ?>
            <option value="test" selected="selected"><?php echo $text_test; ?></option>
            <?php } else { ?>
            <option value="test"><?php echo $text_test; ?></option>
            <?php } ?>
            <?php if ($bluepay_hosted_form_test == 'live') { ?>
            <option value="live" selected="selected"><?php echo $text_live; ?></option>
            <?php } else { ?>
            <option value="live"><?php echo $text_live; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-transaction"><span data-toggle="tooltip" title="<?php echo $help_transaction; ?>"><?php echo $entry_transaction; ?></span></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_transaction" id="input-transaction" class="form-control">
            <?php if ($bluepay_hosted_form_transaction == 'SALE') { ?>
            <option value="SALE" selected="selected"><?php echo $text_payment; ?></option>
            <?php } else { ?>
            <option value="SALE"><?php echo $text_payment; ?></option>
            <?php } ?>
            <?php if ($bluepay_hosted_form_transaction == 'AUTH') { ?>
            <option value="AUTH" selected="selected"><?php echo $text_authenticate; ?></option>
            <?php } else { ?>
            <option value="AUTH"><?php echo $text_authenticate; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-amex"><?php echo $entry_card_amex; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_amex" id="input-amex" class="form-control">
            <?php if ($bluepay_hosted_form_amex) { ?>
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
        <label class="col-sm-2 control-label" for="input-discover"><?php echo $entry_card_discover; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_discover" id="input-discover" class="form-control">
            <?php if ($bluepay_hosted_form_discover) { ?>
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
        <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
        <div class="col-sm-10">
          <input type="text" name="bluepay_hosted_form_total" value="<?php echo $bluepay_hosted_form_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_order_status_id" id="input-order-status" class="form-control">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $bluepay_hosted_form_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_geo_zone_id" id="input-geo-zone" class="form-control">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $bluepay_hosted_form_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="input-debug"><span data-toggle="tooltip" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?></span></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_debug" id="input-debug" class="form-control">
            <?php if ($bluepay_hosted_form_debug) { ?>
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
        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
        <div class="col-sm-10">
          <select name="bluepay_hosted_form_status" id="input-status" class="form-control">
            <?php if ($bluepay_hosted_form_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>
<?php echo $footer; ?> 