

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/pagetree/index');?>"><?php echo $this->lang->line('pagetree_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('pagetree_name');?></h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- name -->
	<div class="control-group">
	<label class="control-label" for="pagetree_name">* <?php echo $this->lang->line('pagetree_name'); ?>:</label>
	<div class="controls">
	<input type="text" name="pt_name" id="pagetree_name" value="<?php echo $this->admin_model_pagetree->form_value('pt_name'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- author image -->
	<?php /* if(isset($authors->ImageLink) && $authors->ImageLink != '') {?>
	<div class="control-group">
	<div class="controls">
		<img src="<?php echo $authors->ImageLink;?>s100-c/" alt="<?php echo $authors->AuthorName;?>" />
	</div>
	</div>
	<?php }*/ ?>
	
	<!--div class="control-group">
	<label class="control-label" for="author_image">Image Link:</label>
	<div class="controls">
		<input type="text" name="ImageLink" id="author_imagelink" value="<?php // echo $this->admin_model_author->form_value('ImageLink'); ?>" class="input-xlarge" />
	</div>
	</div-->
	
	<!-- order -->
	<div class="control-group">
	<label class="control-label" for="order_priority"><?php echo $this->lang->line('pagetree_priority'); ?></label>
	<div class="controls">
	<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_pagetree->form_value('display_order')) echo '09'; else echo $this->admin_model_pagetree->form_value('display_order'); ?>" />
	</div>
	</div>
	
	<!-- active -->
	<div class="control-group">
	<label class="control-label" for="pagetree_active"><?php echo $this->lang->line('pagetree_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="active" id="pagetree_active" value="1" <?php if ($this->admin_model_pagetree->form_value('active') or (!$_POST and !uri_assoc('pt_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('pt_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->
