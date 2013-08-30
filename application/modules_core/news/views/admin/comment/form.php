
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->uri_string());?>"><?php echo $this->lang->line('comment_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" />

	<h4 class="form-box-header"><?php echo $action_type;?> Comments</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- author name -->
	<div class="control-group">
	<label class="control-label" for="author_name">* <?php echo $this->lang->line('comment_author'); ?>:</label>
	<div class="controls">
	<input type="text" name="cmt_author" id="author_name" value="<?php echo $this->admin_model_comment->form_value('cmt_author'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- cmt email -->
	<div class="control-group">
	<label class="control-label" for="author_email">* <?php echo $this->lang->line('comment_email'); ?></label>
	<div class="controls">
	<input type="text" name="cmt_email" id="author_email" value="<?php echo $this->admin_model_comment->form_value('cmt_email'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- content -->
	<div class="control-group">
	<label class="control-label" for="comment_content">* <?php echo $this->lang->line('comment_content'); ?></label>
	<div class="controls">
	<textarea id="comment_content" name="cmt_content" class="textarea-large" rows="10"><?php echo $this->admin_model_comment->form_value('cmt_content'); ?></textarea>
	</div>
	</div>
	
	<!-- active -->
	<div class="control-group">
	<label class="control-label" for="comment_active"><?php echo $this->lang->line('comment_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="enable" id="comment_active" value="1" <?php if ($this->admin_model_comment->form_value('enable') or (!$_POST and !uri_assoc('cmt_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('cmt_id')) echo 'Approve';?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->