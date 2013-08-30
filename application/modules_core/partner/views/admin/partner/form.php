
<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo $this->uri->uri_string();?>"><?php echo $this->lang->line('partner_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('partner_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
		<li><a href="#slide-tabs-image">Image</a></li>
	</ul>
	
	<div class="tab-content">
		<!-- vietnamese language -->
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
			<!-- form content -->
			
			<div class="control-group">
			<label class="control-label" for="partner_name">* <?php echo $this->lang->line('partner_location'); ?>:</label>
			<div class="controls">
			<select name="partner_location" class="select-chosen">
				<?php foreach($location_list->result() as $ll) {
					echo '<option value="'.$ll->ll_id.'">'.$ll->location.'</option>';
				}?>
			</select>
			</div>
			</div>
			
			<!-- name -->
			<div class="control-group">
			<label class="control-label" for="partner_name">* <?php echo $this->lang->line('partner_name'); ?>:</label>
			<div class="controls">
			<input type="text" name="partner_name" id="partner_name" value="<?php echo $this->admin_model_partner->form_value('partner_name'); ?>" class="input-medium" />
			</div>
			</div>
			
			<!-- description -->
			<div class="control-group">
			<label class="control-label" for="partner_description"><?php echo $this->lang->line('partner_description'); ?></label>
			<div class="controls">
			<textarea id="event_description" name="partner_description" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_partner->form_value('partner_description'); ?></textarea>
			</div>
			</div>
			
			<!-- url -->
			<div class="control-group">
			<label class="control-label" for="partner_url"><?php echo $this->lang->line('partner_url'); ?>:</label>
			<div class="controls">
			<input type="text" name="partner_url" id="partner_url" value="<?php echo $this->admin_model_partner->form_value('partner_url'); ?>" class="input-medium" />
			</div>
			</div>
			
			
			<!-- order -->
			
			<div class="control-group">
			<label class="control-label" for="partner_priority"><?php echo $this->lang->line('partner_priority'); ?></label>
			<div class="controls">
			<input type="text" id="partner_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_partner->form_value('display_order')) echo '09'; else echo $this->admin_model_partner->form_value('display_order');?>" />
			</div>
			</div>
			
			<!-- active -->
			
			<div class="control-group">
			<label class="control-label" for="news_active"><?php echo $this->lang->line('partner_active'); ?></label>
			<div class="controls">
				<input type="checkbox" name="active" id="partner_active" value="1" <?php if ($this->admin_model_partner->form_value('active') or (!$_POST and !uri_assoc('pa_id'))) { ?>checked="checked"<?php } ?> />
			</div>
			</div>
			
		</div>
		</div>
		
		<!-- english language -->
		<div class="tab-pane" id="language-tabs-langen">
			<div class="form-box-content">
				<!-- name -->
				<div class="control-group">
				<label class="control-label" for="partner_name_en"><?php echo $this->lang->line('partner_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="partner_name_en" id="partner_name_en" value="<?php if($partnerobj_en!=false) echo $partnerobj_en->partner_name; ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- description -->
				<div class="control-group">
				<label class="control-label" for="partner_description_en"><?php echo $this->lang->line('partner_description'); ?></label>
				<div class="controls">
				<textarea id="partner_description_en" name="partner_description_en" class="tinymce textarea-large" rows="10"><?php if($partnerobj_en!=false) echo $partnerobj_en->partner_description; ?></textarea>
				</div>
				</div>
			</div>
		</div>
		
		<!-- product slide images -->
		<div class="tab-pane" id="slide-tabs-image">
			<div class="form-box-content">
			<?php if(uri_assoc('pa_id')) { ?>
				<!-- image select -->
				<div class="control-group">
				<div class="controls">
				<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_partner->form_value('partner_link_image');?>" alt="" id="image_show" /></a>
				</div>
				</div>
				<?php }?>
				<div class="control-group">
					<label class="control-label" for="image_select_id">Avatar Image</label>
					<div class="controls">
						<input class="input-large" id="image_select_id" name="partner_link_image" type="text" value="<?php echo $this->admin_model_partner->form_value('partner_link_image');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/partners/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('pa_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	</form>
	<!-- / form 1 edit -->
