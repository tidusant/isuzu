

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/form_management/contacter');?>">Contacts</a></li>
<li class="active"><a href="">Viewing</a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header">Contact Information</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- full name -->
	<div class="control-group">
	<label class="control-label" for="reg_fullname"><?php echo $this->lang->line('reg_form_fullname'); ?>:</label>
	<div class="controls">
	<input type="text" name="fullname" id="reg_fullname" value="<?php echo $contactformobj->fullname; ?>" class="input-medium" disabled />
	</div>
	</div>
	
	<?php if($contactformobj->company!='') {?>
	<!-- company -->
	<div class="control-group">
	<label class="control-label" for="reg_company"><?php echo $this->lang->line('reg_form_company'); ?>:</label>
	<div class="controls">
	<input type="text" name="company" id="reg_company" value="<?php echo $contactformobj->company; ?>" class="input-medium" disabled />
	</div>
	</div>
	<?php }?>
	
	<!-- email -->
	<div class="control-group">
	<label class="control-label" for="reg_email"><?php echo $this->lang->line('reg_form_email'); ?></label>
	<div class="controls">
	<input type="text" id="reg_email" name="email" class="input-large" value="<?php echo $contactformobj->email; ?>" disabled />
	</div>
	</div>
	
	<!-- phone -->
	<div class="control-group">
	<label class="control-label" for="reg_phone"><?php echo $this->lang->line('reg_form_phone'); ?></label>
	<div class="controls">
	<input type="text" id="reg_phone" name="phone" class="input-medium" value="<?php echo $contactformobj->phone; ?>" disabled />
	</div>
	</div>
	
	<?php if($contactformobj->fax!='') {?>
	<!-- fax -->
	<div class="control-group">
	<label class="control-label" for="reg_fax">Fax</label>
	<div class="controls">
	<input type="text" id="reg_fax" name="fax" class="input-large" value="<?php echo $contactformobj->fax; ?>" disabled />
	</div>
	</div>
	<?php }
	
	if($contactformobj->address!='') {?>
	<!-- address -->
	<div class="control-group">
	<label class="control-label" for="reg_address"><?php echo $this->lang->line('reg_form_address'); ?></label>
	<div class="controls">
	<input type="text" id="reg_address" name="address" class="input-medium" value="<?php echo $contactformobj->address; ?>" disabled />
	</div>
	</div>
	<?php }?>
	
	
	<!-- subject -->
	<div class="control-group">
	<label class="control-label" for="reg_subject"><?php echo $this->lang->line('reg_form_subject'); ?></label>
	<div class="controls">
	<input type="text" id="reg_subject" name="subject" style="width:400px;" class="input-xlarge" value="<?php echo $contactformobj->subject;?>" disabled />
	</div>
	</div>
	
	
	<!-- content -->
	<div class="control-group">
	<label class="control-label" for="reg_content"><?php echo $this->lang->line('reg_form_content'); ?></label>
	<div class="controls">
		<textarea id="reg_content" name="content" class="textarea-large" rows="10" disabled><?php echo $contactformobj->content;?></textarea>
	</div>
	</div>
			
	<!-- date received -->
	<div class="control-group">
	<label class="control-label" for="reg_form_date"><?php echo $this->lang->line('reg_form_date'); ?></label>
	<div class="controls">
	<input type="text" id="reg_form_date" name="date_received" class="input-medium" value="<?php echo format_date($contactformobj->date_received); ?>" disabled />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="Back" />
	</div>
	
	</div>
	
	</form>
	<!-- / form 1 edit -->