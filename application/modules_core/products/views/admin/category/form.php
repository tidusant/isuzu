<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>"><?php echo $this->lang->line('category_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('category_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
		<li><a href="#slide-tabs-singleimage">Image</a></li>
	</ul>
	<div class="tab-content">
		<!-- vietnamese language -->
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
				<!-- name -->
				<div class="control-group">
				<label class="control-label" for="category_name">* <?php echo $this->lang->line('category_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="pc_name" id="category_name" value="<?php echo $this->admin_model_category->form_value('pc_name'); ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- slug seo -->
				<div class="control-group">
				<label class="control-label" for="category_slug">* <?php echo $this->lang->line('product_slug'); ?></label>
				<div class="controls">
				<input type="text" name="pc_slug" id="category_slug" value="<?php echo $this->admin_model_category->form_value('pc_slug'); ?>" class="slugify input-medium" />
				</div>
				</div>
				
				<!-- description -->
				<div class="control-group">
				<label class="control-label" for="category_description"><?php echo $this->lang->line('product_description'); ?></label>
				<div class="controls">
				<textarea id="category_description" name="pc_desc" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_category->form_value('pc_desc'); ?></textarea>
				</div>
				</div>
				
				<!-- source doc link -->
				<div class="control-group">
				<label class="control-label" for="source_document_id">Catalogue Link</label>
				<div class="controls">
					<input type="text" name="pc_source_doc" id="source_document_id" value="<?php echo $this->admin_model_category->form_value('pc_source_doc'); ?>" class="input-large" />
					<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=2&subfolder=&editor=mce_0&field_id=source_document_id&lang=eng&fldr=media/categories/files/" class="btn iframe-btn" type="button">Browse</a>
				</div>
				</div>
				
				<!-- order -->
				<div class="control-group">
				<label class="control-label" for="order_priority"><?php echo $this->lang->line('product_priority'); ?></label>
				<div class="controls">
				<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_category->form_value('display_order')) echo '09'; else echo $this->admin_model_category->form_value('display_order'); ?>" />
				</div>
				</div>
				
				<!-- active -->
				<div class="control-group">
				<label class="control-label" for="category_active"><?php echo $this->lang->line('product_active'); ?></label>
				<div class="controls">
					<input type="checkbox" name="active" id="category_active" value="1" <?php if ($this->admin_model_category->form_value('active') or (!$_POST and !uri_assoc('cate_id'))) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
				
			</div>
		</div>
		
		<!-- english language -->
		<div class="tab-pane" id="language-tabs-langen">
			<div class="form-box-content">
				<!-- name -->
				<div class="control-group">
				<label class="control-label" for="category_name_en"><?php echo $this->lang->line('category_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="pc_name_en" id="category_name_en" value="<?php if($catalogobj_en!=false) echo $catalogobj_en->pc_name;?>" class="input-medium" />
				</div>
				</div>
				<!-- description -->
				<div class="control-group">
				<label class="control-label" for="category_description_en"><?php echo $this->lang->line('product_description'); ?></label>
				<div class="controls">
				<textarea id="category_description_en" name="pc_desc_en" class="tinymce textarea-large" rows="10"><?php if($catalogobj_en!=false) echo $catalogobj_en->pc_desc;?></textarea>
				</div>
				</div>
			</div>
		</div>
		
		<!-- catalog avatar images -->
		<div class="tab-pane" id="slide-tabs-singleimage">
			<div class="form-box-content">
				
				<!-- slide banner catalog -->
				<div class="control-group">
					<label class="control-label" for="category_slide_image">Catalog Slide</label>
					<div class="controls">
						<select class="select-chosen" name="pc_slide_id" id="category_slide_image">
						<option value="0">-None-</option>
						<?php if($slide_images_list!=false) {
							foreach($slide_images_list->result() as $img) {?>
							<option value="<?php echo $img->id;?>"<?php if($this->admin_model_category->form_value('pc_slide_id') == $img->id) echo ' selected';?>><?php echo $img->cate_gallery_name;?></option>
						  <?php }
						}?>
						</select>
					</div>
				</div>
				<!-- gallery catalog -->
				<!-- select image -->
				<div class="control-group">
				<label class="control-label" for="category_gallery_image_select">Catalog Gallery</label>
					<div class="controls">
						<select class="select-chosen" id="category_gallery_image_select" name="pc_gallery_id">
							<option value="0">-None-</option>
							<?php if($gallery_images_list!=false) {
								foreach($gallery_images_list->result() as $img) {?>
							  <option value="<?php echo $img->id;?>"<?php if($this->admin_model_category->form_value('pc_gallery_id') == $img->id) echo ' selected';?>><?php echo $img->cate_gallery_name;?></option>
							<?php }
							}?>
						</select>
					</div>
				</div>
				
				<!-- submenu image -->
				<div class="control-group">
					<label class="control-label" for="image_select_id">Submenu Image</label>
					<div class="controls">
						<?php if(uri_assoc('cate_id') && $this->admin_model_category->form_value('pc_image_link_sub')!='') { ?>
						<p><a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_category->form_value('pc_image_link_sub');?>" alt="" id="image_show" /></a></p>
						<?php }?>
						<input class="input-xlarge" id="image_select_id" name="pc_image_link_sub" type="text" value="<?php echo $this->admin_model_category->form_value('pc_image_link_sub');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/categories/submenu/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
				
				<!-- logo for index page -->
				<div class="control-group">
					<label class="control-label" for="image_select_id">Logo Image</label>
					<div class="controls">
						<?php if(uri_assoc('cate_id') && $this->admin_model_category->form_value('pc_image_link')!='') { ?>
						<p><a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_category->form_value('pc_image_link');?>" alt="" id="image_show" /></a></p>
						<?php }?>
						<input class="input-xlarge" id="image_select_id" name="pc_image_link" type="text" value="<?php echo $this->admin_model_category->form_value('pc_image_link');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/categories/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="image_select_id_ex">Avatar Image</label>
					<div class="controls">
						<!-- main image -->
						<?php if(uri_assoc('cate_id') && $this->admin_model_category->form_value('pc_image_link_extra') != '') { ?>
						<p><a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_category->form_value('pc_image_link_extra');?>" alt="" id="image_show" /></a></p>
						<?php }?>
						<input class="input-xlarge" id="image_select_id_ex" name="pc_image_link_extra" type="text" value="<?php echo $this->admin_model_category->form_value('pc_image_link_extra');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/categories/&field_id=image_select_id_ex" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('cate_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->