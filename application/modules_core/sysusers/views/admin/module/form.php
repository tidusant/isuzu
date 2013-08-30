<?php $this->load->view('administration/header'); ?>

<div id="page-content">

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url('gotthat');?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url('sysusers/gotthat/mmodule');?>">Module</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php $this->load->view('administration/system_messages'); ?>
<br />
	
<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" />

	<h4 class="form-box-header"><?php echo $action_type;?> Module</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	<!-- name -->
	<div class="control-group">
	<label class="control-label" for="modulename">* <?php echo $this->lang->line('module_name'); ?>:</label>
	<div class="controls">
	<input type="text" name="module_name" id="modulename" value="<?php echo $this->admin_model_module->form_value('module_name'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- display order -->
	<div class="control-group">
	<label class="control-label" for="ordering">* <?php echo $this->lang->line('member_priority'); ?>:</label>
	<div class="controls">
	<input type="text" name="display_order" id="ordering" value="<?php if(!$this->admin_model_module->form_value('display_order')) echo '09'; else echo $this->admin_model_module->form_value('display_order'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- active -->
	<div class="control-group">
	<label class="control-label" for="group_active"><?php echo $this->lang->line('member_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="active" id="group_active" value="1" <?php if($this->admin_model_module->form_value('active') or (!$_POST and !uri_assoc('m_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('m_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->
</div>

<?php $this->load->view('administration/footer'); ?>