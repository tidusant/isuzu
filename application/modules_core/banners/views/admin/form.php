

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'banners/index');?>">Banners</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

	<h4 class="form-box-header"><?php echo $action_type;?> Banner</h4>
	<div class="form-box-content">
	
	<!-- form content -->
	
	<!-- banner title -->
	<div class="control-group">
	<label class="control-label" for="banner_title">* <?php echo $this->lang->line('banner_title'); ?>:</label>
	<div class="controls">
	<input type="text" name="banner_title" id="banner_title" value="<?php echo $this->admin_model_banner->form_value('banner_title'); ?>" class="input-medium" />
	</div>
	</div>
	
	<!-- banner link -->
	<div class="control-group">
	<label class="control-label" for="banner_link"><?php echo $this->lang->line('banner_link'); ?>:</label>
	<div class="controls">
	<input type="text" name="banner_link" id="banner_link" value="<?php echo $this->admin_model_banner->form_value('banner_link'); ?>" class="input-large" />
	</div>
	</div>
	
	<!-- image -->
	<?php if(uri_assoc('banner_id') && $this->admin_model_banner->form_value('banner_link_image') != NULL) { ?>
	<!-- image select -->
	<div class="control-group">
	<div class="controls">
	<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_banner->form_value('banner_link_image');?>" alt="" id="image_show" /></a>
	</div>
	</div>
	<?php }?>
	<div class="control-group">
		<label class="control-label" for="image_select_id">Banner Image</label>
		<div class="controls">
			<input class="input-large" id="image_select_id" name="banner_link_image" type="text" value="<?php echo $this->admin_model_banner->form_value('banner_link_image');?>" />
			<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/banners/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
		</div>
	</div>
	
	<!-- position -->
	<div class="control-group">
	<label class="control-label" for="banner_position"><?php echo $this->lang->line('banner_position'); ?></label>
	<div class="controls">
		<select name="position_id" id="banner_position" class="select-chosen">
			<?php if($bannerposition_list!=false) {
					$selected_option = '';
					foreach($bannerposition_list->result() as $bp) {
						if($this->admin_model_banner->form_value('position_id') == $bp->position_id) {
							$selected_option = 'selected';
						}
						else $selected_option = '';
						
						echo '<option value="'.$bp->position_id.'" '.$selected_option.'>'.$bp->pos_name.'</option>';
					}
			}?>
		</select>
	</div>
	</div>
	
	<!-- priority -->
	
	<div class="control-group">
	<label class="control-label" for="banner_priority"><?php echo $this->lang->line('banner_priority'); ?></label>
	<div class="controls">
	<input type="text" id="banner_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_banner->form_value('display_order')) echo '09'; else echo $this->admin_model_banner->form_value('display_order');?>" />
	</div>
	</div>
	
	<!-- active -->
	
	<div class="control-group">
	<label class="control-label"><?php echo $this->lang->line('banner_active'); ?></label>
	<div class="controls">
		<input type="checkbox" name="active" id="banner_active" value="1" <?php if ($this->admin_model_banner->form_value('active') or (!$_POST and !uri_assoc('banner_id'))) { ?>checked="checked"<?php } ?> />
	</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('banner_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->