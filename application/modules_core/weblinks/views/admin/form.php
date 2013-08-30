<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('weblink_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('weblink_module');?></h4>
	
	<div class="form-box-content">
	
		<!-- form content -->
		
		<!-- title -->
		<div class="control-group">
		<label class="control-label" for="weblink_title">* <?php echo $this->lang->line('news_title'); ?>:</label>
		<div class="controls">
		<input type="text" name="title" id="weblink_title" value="<?php echo $this->admin_model_weblink->form_value('title'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- link -->
		<div class="control-group">
		<label class="control-label" for="web_link">* <?php echo $this->lang->line('web_links'); ?></label>
		<div class="controls">
		<input type="text" name="weblink" id="web_link" value="<?php echo $this->admin_model_weblink->form_value('weblink'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- order -->
		<div class="control-group">
		<label class="control-label" for="weblink_priority"><?php echo $this->lang->line('news_priority'); ?></label>
		<div class="controls">
		<input type="text" id="weblink_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_weblink->form_value('display_order')) echo '09'; else echo $this->admin_model_weblink->form_value('display_order');?>" />
		</div>
		</div>
		
		<!-- active -->
		<div class="control-group">
		<label class="control-label" for="news_active"><?php echo $this->lang->line('news_active'); ?></label>
		<div class="controls">
			<input type="checkbox" name="active" id="news_active" value="1" <?php if ($this->admin_model_weblink->form_value('active') or (!$_POST and !uri_assoc('weblink_id'))) { ?>checked="checked"<?php } ?> />
		</div>
		</div>
			
	</div>
	
	<!-- global action -->
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('weblink_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
</form>
	<!-- / form 1 edit -->
	