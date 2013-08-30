

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/accessories/index');?>"><?php echo $this->lang->line('accessory_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" enctype="multipart/form-data" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('accessory_module');?></h4>
	
	<!-- tabs -->
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
		<li><a href="#slide-tabs-image">Image</a></li>
	</ul>
	<div class="tab-content">
		<!-- vietnamese language -->
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
				<!-- accessory name -->
				<div class="control-group">
				<label class="control-label" for="accessory_name">* <?php echo $this->lang->line('accessory_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="acc_name" id="accessory_name" value="<?php echo $this->admin_model_accessory->form_value('acc_name'); ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- price -->
				<div class="control-group">
				<label class="control-label" for="acc_price">Price</label>
				<div class="controls">
				<input type="text" name="acc_price" id="acc_price" value="<?php echo $this->admin_model_accessory->form_value('acc_price'); ?>" class="input-small" />
				</div>
				</div>
				
				<!-- accessory desc -->
				<div class="control-group">
				<label class="control-label" for="accessory_description"><?php echo $this->lang->line('accessory_description'); ?></label>
				<div class="controls">
				<textarea id="accessory_description" name="acc_desc" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_accessory->form_value('acc_desc'); ?></textarea>
				</div>
				</div>
				
				<!-- feature accessory -->
				<div class="control-group">
				<label class="control-label" for="accessory_feature"><?php echo $this->lang->line('accessory_feature'); ?></label>
				<div class="controls">
					<input type="checkbox" name="feature" id="accessory_feature" value="1" <?php if ($this->admin_model_accessory->form_value('feature')) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
				
				<!-- order -->
				<div class="control-group">
				<label class="control-label" for="order_priority"><?php echo $this->lang->line('accessory_priority'); ?></label>
				<div class="controls">
				<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_accessory->form_value('display_order')) echo '09'; else echo $this->admin_model_accessory->form_value('display_order'); ?>" />
				</div>
				</div>
				
				<!-- active -->
				<div class="control-group">
				<label class="control-label" for="accessory_active"><?php echo $this->lang->line('accessory_active'); ?></label>
				<div class="controls">
					<input type="checkbox" name="active" id="accessory_active" value="1" <?php if ($this->admin_model_accessory->form_value('active') or (!$_POST and !uri_assoc('a_id'))) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
			
			</div>
		</div>
		
		<!-- english language -->
		<div class="tab-pane" id="language-tabs-langen">
			<div class="form-box-content">
				<div class="control-group">
				<label class="control-label" for="accessory_name_en"><?php echo $this->lang->line('accessory_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="acc_name_en" id="accessory_name_en" value="<?php if($accessoryobj_en!=false) echo $accessoryobj_en->acc_name;?>" class="input-medium" />
				</div>
				</div>
				
				<!-- accessory desc -->
				<div class="control-group">
				<label class="control-label" for="accessory_description_en"><?php echo $this->lang->line('accessory_description'); ?></label>
				<div class="controls">
				<textarea id="accessory_description_en" name="acc_desc_en" class="tinymce textarea-large" rows="10"><?php if($accessoryobj_en!=false) echo $accessoryobj_en->acc_desc;?></textarea>
				</div>
				</div>
			</div>
		</div>
		
		<!-- product slide images -->
		<div class="tab-pane" id="slide-tabs-image">
			<div class="form-box-content">
				<?php if(uri_assoc('a_id')) { ?>
				<!-- image select -->
				<div class="control-group">
				<div class="controls">
				<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_accessory->form_value('acc_link_image');?>" alt="" id="image_show" /></a>
				</div>
				</div>
				<?php }?>
				<div class="control-group">
					<label class="control-label" for="image_select_id">Avatar Image</label>
					<div class="controls">
						<input class="input-large" id="image_select_id" name="acc_link_image" type="text" value="<?php echo $this->admin_model_accessory->form_value('acc_link_image');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/rearbody/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="form-box-content">
	<div class="form-actions">
		<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('a_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
		<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
	</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->