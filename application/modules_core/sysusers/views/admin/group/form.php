
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/system_users/groups');?>">Admin Group</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message'); ?>
<br />
	
<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type;?> Group</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	<!-- name -->
	<div class="control-group">
	<label class="control-label" for="groupnaming">* <?php echo $this->lang->line('group_name'); ?>:</label>
	<div class="controls">
	<input type="text" name="group_name" id="groupnaming" value="<?php echo $this->admin_model_membergroup->form_value('group_name'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- permission -->
	<div class="control-group">
	<label class="control-label" for="module_col">Module Permission</label>
	<div class="controls">
		<?php if($module_list!=false) {
		foreach($module_list->result() as $m) {?>
		<div style="display:inline;">
		<span><input type="checkbox" name="module_col[]" id="md_<?php echo $m->module_id?>" value="<?php echo $m->module_id;?>" <?php if(isset($module_by_group) && $module_by_group!=false) { foreach($module_by_group->result() as $mg) { if($mg->module_id==$m->module_id) { echo 'checked="checked"'; break; } } } ?> />&nbsp;<?php echo $m->module_name;?></span>
				
		</div>
		<br />
		<?php } } ?>
	</div>
	</div>
	
	<!-- description -->
	<div class="control-group">
	<label class="control-label" for="group_description"><?php echo $this->lang->line('group_description'); ?></label>
	<div class="controls">
	<textarea id="group_description" name="description" class="textarea-large" rows="10"><?php echo $this->admin_model_membergroup->form_value('description'); ?></textarea>
	</div>
	</div>
	
	<!-- active -->
	<div class="control-group">
	<label class="control-label" for="group_active"><?php echo $this->lang->line('member_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="active" id="group_active" value="1" <?php if($this->admin_model_membergroup->form_value('active') or (!$_POST and !uri_assoc('group_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('group_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->