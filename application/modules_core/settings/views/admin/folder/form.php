
<ul id="nav-info" class="clearfix">
	<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
	<li><a href="<?php echo site_url($this->uri->segment(1).'/settings/folder/index');?>">Folder</a></li>
	<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('page_title');?></h4>
	
	<div class="form-box-content">
		<!-- form content -->
			
		<!-- parent -->
		<div class="control-group">
		<label class="control-label" for="folder_parent">Parent Folder:</label>
		<div class="controls">
		<input type="text" name="folder_parent" id="folder_parent" value="<?php echo $this->admin_model_folder->form_value('folder_parent'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- name -->
		<div class="control-group">
		<label class="control-label" for="folder_name">* Folder Name</label>
		<div class="controls">
		<input type="text" name="folder_name" id="folder_name" value="<?php echo $this->admin_model_folder->form_value('folder_name'); ?>" class="input-medium" />
		</div>
		</div>
			
		<!-- action button -->
		<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('folder_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
		</div>
	</div>
</form>
	<!-- / form 1 edit -->