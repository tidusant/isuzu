

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/partners/location');?>"><?php echo $this->lang->line('location_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type;?> Location</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- location name -->
	<div class="control-group">
	<label class="control-label" for="location_name">* <?php echo $this->lang->line('partner_location'); ?>:</label>
	<div class="controls">
	<input type="text" name="location" id="location_name" value="<?php echo $this->admin_model_location->form_value('location'); ?>" class="input-large" />
	</div>
	</div>
	
	<!-- location name english -->
	<div class="control-group">
	<label class="control-label" for="location_name"><?php echo $this->lang->line('partner_location'); ?>(EN):</label>
	<div class="controls">
	<input type="text" name="location_en" id="location_name" value="<?php echo $this->admin_model_location->form_value('location_en'); ?>" class="input-large" />
	</div>
	</div>
	
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('l_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	</div>
	
	</form>
	<!-- / form 1 edit -->
	