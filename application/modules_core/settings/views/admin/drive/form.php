

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/form_management/test_drive_reg');?>">Drive Form Register</a></li>
<li class="active"><a href="">Viewing</a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header">Test Drive Registration</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- full name -->
	<div class="control-group">
	<label class="control-label" for="reg_fullname"><?php echo $this->lang->line('reg_form_fullname'); ?>:</label>
	<div class="controls">
	<input type="text" name="full_name" id="reg_fullname" value="<?php echo $regformobj->full_name; ?>" class="input-medium" disabled />
	</div>
	</div>
	
	<!-- gender -->
	<div class="control-group">
	<label class="control-label" for="reg_gender"><?php echo $this->lang->line('reg_form_gender'); ?>:</label>
	<div class="controls">
	<input type="text" name="gender" id="reg_gender" value="<?php if($regformobj->gender!=''){
		if($regformobj->gender=='1') echo 'Male'; else echo 'Female';
	}?>" class="input-medium" disabled />
	</div>
	</div>
	
	<!-- birthdate -->
	<div class="control-group">
	<label class="control-label" for="reg_birthdate">Birth Date:</label>
	<div class="controls">
	<input type="text" name="birthdate" id="reg_birthdate" value="<?php echo $regformobj->birthdate; ?>" class="input-medium" disabled />
	</div>
	</div>
	
	<!-- company -->
	<div class="control-group">
	<label class="control-label" for="reg_company"><?php echo $this->lang->line('reg_form_company'); ?>:</label>
	<div class="controls">
	<input type="text" name="company" id="reg_company" value="<?php echo $regformobj->company; ?>" class="input-medium" disabled />
	</div>
	</div>
	
	<!-- email -->
	<div class="control-group">
	<label class="control-label" for="reg_email"><?php echo $this->lang->line('reg_form_email'); ?></label>
	<div class="controls">
	<input type="text" id="reg_email" name="form_email" class="input-large" value="<?php echo $regformobj->form_email; ?>" disabled />
	</div>
	</div>
	
	<!-- phone -->
	<div class="control-group">
	<label class="control-label" for="reg_phone"><?php echo $this->lang->line('reg_form_phone'); ?></label>
	<div class="controls">
	<input type="text" id="reg_phone" name="phone" class="input-medium" value="<?php echo $regformobj->phone; ?>" disabled />
	</div>
	</div>
	
	<!-- address -->
	<div class="control-group">
	<label class="control-label" for="reg_address"><?php echo $this->lang->line('reg_form_email'); ?></label>
	<div class="controls">
	<input type="text" id="reg_address" name="address" class="input-large" value="<?php echo $regformobj->address; ?>" disabled />
	</div>
	</div>
	
	<!-- city -->
	<div class="control-group">
	<label class="control-label" for="reg_city"><?php echo $this->lang->line('reg_form_email'); ?></label>
	<div class="controls">
	<input type="text" id="reg_city" name="city" class="input-medium" value="<?php echo $regformobj->city; ?>" disabled />
	</div>
	</div>
	
	<!-- item owner -->
	<div class="control-group">
	<label class="control-label" for="reg_itemowner"><?php echo $this->lang->line('reg_form_itemowner'); ?></label>
	<div class="controls">
	<input type="text" id="reg_itemowner" name="itemowner" class="input-large" value="<?php echo $regformobj->item_owner; ?>" disabled />
	</div>
	</div>
	
	<!-- model register -->
	<div class="control-group">
	<label class="control-label" for="reg_itemregister"><?php echo $this->lang->line('reg_form_modelitem'); ?></label>
	<div class="controls">
	<input type="text" id="reg_itemregister" name="item_registered" class="input-large" value="<?php echo $regformobj->item_registered; ?>" disabled />
	</div>
	</div>
	
	<!-- date received -->
	<div class="control-group">
	<label class="control-label" for="reg_form_date"><?php echo $this->lang->line('reg_form_date'); ?></label>
	<div class="controls">
	<input type="text" id="reg_form_date" name="date_received" class="input-mini" value="<?php echo format_date($regformobj->date_received); ?>" disabled />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="Back" />
	</div>
	
	</div>
	
	</form>
	<!-- / form 1 edit -->