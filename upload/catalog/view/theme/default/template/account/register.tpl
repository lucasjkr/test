<?php echo $header; ?>
<ul class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
  <?php } ?>
</ul>
<?php if ($error_warning) { ?>
<div class="alert alert-error"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="row"><?php echo $column_left; ?>
  <div id="content" class="span9"><?php echo $content_top; ?>
    <h1><?php echo $heading_title; ?></h1>
    <p><?php echo $text_account_already; ?></p>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
      <fieldset>
        <legend><?php echo $text_your_details; ?></legend>
        <div class="control-group required">
          <label class="control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
          <div class="controls">
            <input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" />
            <?php if ($error_firstname) { ?>
            <div class="error"><?php echo $error_firstname; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
          <div class="controls">
            <input type="text" name="lastname" value="<?php echo $lastname; ?>" id="input-lastname" />
            <?php if ($error_lastname) { ?>
            <div class="error"><?php echo $error_lastname; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
          <div class="controls">
            <input type="email" name="email" value="<?php echo $email; ?>" id="input-email" />
            <?php if ($error_email) { ?>
            <div class="error"><?php echo $error_email; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
          <div class="controls">
            <input type="tel" name="telephone" value="<?php echo $telephone; ?>" id="input-telephone" />
            <?php if ($error_telephone) { ?>
            <div class="error"><?php echo $error_telephone; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-fax"><?php echo $entry_fax; ?></label>
          <div class="controls">
            <input type="text" name="fax" value="<?php echo $fax; ?>" id="input-fax" />
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $text_your_address; ?></legend>
        <div class="control-group">
          <label class="control-label" for="input-company"><?php echo $entry_company; ?></label>
          <div class="controls">
            <input type="text" name="company" value="<?php echo $company; ?>" id="input-company" />
          </div>
        </div>
        <div class="control-group" style="display: <?php echo (count($customer_groups) > 1 ? 'display' : 'none'); ?>;">
          <div class="control-label"><?php echo $entry_customer_group; ?></div>
          <div class="controls">
            <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
            <label class="radio">
              <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
              <?php echo $customer_group['name']; ?></label>
            <?php } else { ?>
            <label class="radio">
              <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" />
              <?php echo $customer_group['name']; ?></label>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-address-1"><?php echo $entry_address_1; ?></label>
          <div class="controls">
            <input type="text" name="address_1" value="<?php echo $address_1; ?>" id="input-address-1" />
            <?php if ($error_address_1) { ?>
            <div class="error"><?php echo $error_address_1; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input-address-2" for="input-address-2">
          <?php echo $entry_address_2; ?>
          </label>
          <div class="controls">
            <input type="text" name="address_2" value="<?php echo $address_2; ?>" id="input-address-2" />
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-city"><?php echo $entry_city; ?></label>
          <div class="controls">
            <input type="text" name="city" value="<?php echo $city; ?>" id="input-city" />
            <?php if ($error_city) { ?>
            <div class="error"><?php echo $error_city; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-postcode"><?php echo $entry_postcode; ?></label>
          <div class="controls">
            <input type="text" name="postcode" value="<?php echo $postcode; ?>" id="input-postcode" />
            <?php if ($error_postcode) { ?>
            <div class="error"><?php echo $error_postcode; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-country"><?php echo $entry_country; ?></label>
          <div class="controls">
            <select name="country_id" id="input-country">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_country) { ?>
            <div class="error"><?php echo $error_country; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-zone"><?php echo $entry_zone; ?></label>
          <div class="controls">
            <select name="zone_id" id="input-zone">
            </select>
            <?php if ($error_zone) { ?>
            <div class="error"><?php echo $error_zone; ?></div>
            <?php } ?>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $text_your_password; ?></legend>
        <div class="control-group required">
          <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
          <div class="controls">
            <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" />
            <?php if ($error_password) { ?>
            <div class="error"><?php echo $error_password; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="control-group required">
          <label class="control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
          <div class="controls">
            <input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" />
            <?php if ($error_confirm) { ?>
            <div class="error"><?php echo $error_confirm; ?></div>
            <?php } ?>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend><?php echo $text_newsletter; ?></legend>
        <div class="control-group">
          <div class="control-label"><?php echo $entry_newsletter; ?></div>
          <div class="controls">
            <?php if ($newsletter) { ?>
            <label class="radio">
              <input type="radio" name="newsletter" value="1" checked="checked" />
              <?php echo $text_yes; ?></label>
            <label class="radio">
              <input type="radio" name="newsletter" value="0" />
              <?php echo $text_no; ?></label>
            <?php } else { ?>
            <label class="radio">
              <input type="radio" name="newsletter" value="1" />
              <?php echo $text_yes; ?></label>
            <label class="radio">
              <input type="radio" name="newsletter" value="0" checked="checked" />
              <?php echo $text_no; ?></label>
            <?php } ?>
          </div>
        </div>
      </fieldset>
      <?php if ($text_agree) { ?>
      <div class="buttons clearfix">
        <div class="pull-right">
          <?php if ($agree) { ?>
          <?php echo $text_agree; ?>
          <input type="checkbox" name="agree" value="1" checked="checked" />
          <?php } else { ?>
          <?php echo $text_agree; ?>
          <input type="checkbox" name="agree" value="1" />
          <?php } ?>
          <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
        </div>
      </div>
      <?php } else { ?>
      <div class="buttons clearfix">
        <div class="pull-right">
          <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
        </div>
      </div>
      <?php } ?>
    </form>
    <?php echo $content_bottom; ?></div>
  <?php echo $column_right; ?></div>
<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').change(function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}	
	}
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after(' <i class="icon-spinner icon-spin"></i>');
		},
		complete: function() {
			$('.icon-spinner').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#input-postcode').parent().parent().addClass('required');
			} else {
				$('#input-postcode').parent().parent().removeClass('required');
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
    $('.colorbox').colorbox({
        maxWidth: 640,
        width: "85%",
        height: 480
    });
});
//--></script> 
<?php echo $footer; ?>