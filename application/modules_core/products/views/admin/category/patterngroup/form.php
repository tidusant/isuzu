<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/pattern-group/index');?>">Pattern Group</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string());?>">

	<h4 class="form-box-header"><?php echo $action_type.' Pattern Group';?></h4>
	
	<div class="form-box-content">
		
		<!-- label name -->
		<div class="control-group">
		<label class="control-label" for="group_name">* Group Name:</label>
		<div class="controls">
		<input type="text" name="group_name" id="group_name" value="<?php echo $this->admin_model_patterngroup->form_value('group_name'); ?>" class="input-large" />
		</div>
		</div>
		
		<!-- english -->
		<div class="control-group">
		<label class="control-label" for="group_name_en">Group Name (EN):</label>
		<div class="controls">
		<input type="text" name="group_name_en" id="group_name_en" value="<?php if(isset($group_name_en) && $group_name_en!=false) echo $group_name_en;?>" class="input-large" />
		</div>
		</div>
		
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('group_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
		
	</div>
	
</form>
<!-- / form 1 edit -->