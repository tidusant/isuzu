

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/products/index');?>"><?php echo $this->lang->line('product_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />


<form class="form-horizontal form-box" method="post" action="" enctype="multipart/form-data" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('product_module');?></h4>
	
	<ul class="nav nav-tabs" id="language-tabs">
		<li class="active"><a href="#language-tabs-langvn">VN</a></li>
		<li><a href="#language-tabs-langen">EN</a></li>
		<li><a href="#slide-tabs-image">Images</a></li>
		<li><a href="#techinfo-tabs-product">Technical Info</a></li>
	</ul>
	<div class="tab-content">
		<!-- vietnamese language -->
		<div class="tab-pane active" id="language-tabs-langvn">
			<div class="form-box-content">
				<!-- product category -->
				<div class="control-group">
				<label class="control-label" for="product_category">* <?php echo $this->lang->line('product_category'); ?></label>
				<div class="controls">
					<select name="product_cate_pc_id" id="product_category" class="select-chosen">
						<option value="0">-None-</option>
						<?php if($category_list!=false) {
								$selected_option = '';
								foreach($category_list->result() as $al) {
									
									if($this->admin_model_product->form_value('product_cate_pc_id') == $al->pc_id) {
										$selected_option = 'selected';
									}
									else $selected_option = '';
									
									echo '<option value="'.$al->pc_id.'" '.$selected_option.'>'.$al->pc_name.'</option>';
								}
						}?>
					</select>
				</div>
				</div>
				
				<!-- product name -->
				<div class="control-group">
				<label class="control-label" for="pro_name">* <?php echo $this->lang->line('product_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="product_name" id="pro_name" value="<?php echo $this->admin_model_product->form_value('product_name'); ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- slug seo -->
				<div class="control-group">
				<label class="control-label" for="pro_slug">* <?php echo $this->lang->line('product_slug'); ?></label>
				<div class="controls">
				<input type="text" name="product_slug" id="pro_slug" value="<?php echo $this->admin_model_product->form_value('product_slug'); ?>" class="slugify input-medium" />
				</div>
				</div>
				
				<!-- product intro -->
				<div class="control-group">
				<label class="control-label" for="pro_intro"><?php echo $this->lang->line('product_intro'); ?></label>
				<div class="controls">
				<textarea id="pro_intro" name="product_intro" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_product->form_value('product_intro'); ?></textarea>
				</div>
				</div>
				
				<!-- product desc -->
				<div class="control-group">
				<label class="control-label" for="pro_description"><?php echo $this->lang->line('product_description'); ?></label>
				<div class="controls">
				<textarea id="pro_description" name="product_description" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_product->form_value('product_description'); ?></textarea>
				</div>
				</div>
				
				<!-- source doc link -->
				<div class="control-group">
				<label class="control-label" for="source_document_id">Product Catalogue</label>
				<div class="controls">
					<input type="text" name="product_source_doc" id="source_document_id" value="<?php echo $this->admin_model_product->form_value('product_source_doc'); ?>" class="input-large" />
					<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=2&subfolder=&editor=mce_0&field_id=source_document_id&lang=eng&fldr=media/products/files/" class="btn iframe-btn" type="button">Browse</a>
				</div>
				</div>
				
				<!-- is hot product -->
				<div class="control-group">
				<label class="control-label" for="product_ishot"><?php echo $this->lang->line('product_ishot'); ?></label>
				<div class="controls">
					<input type="checkbox" name="ishot" id="product_ishot" value="1" <?php if ($this->admin_model_product->form_value('ishot')) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
				
				<!-- order -->
				<div class="control-group">
				<label class="control-label" for="order_priority"><?php echo $this->lang->line('product_priority'); ?></label>
				<div class="controls">
				<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_product->form_value('display_order')) echo '09'; else echo $this->admin_model_product->form_value('display_order'); ?>" />
				</div>
				</div>
				
				<!-- active -->
				<div class="control-group">
				<label class="control-label" for="product_active"><?php echo $this->lang->line('product_active'); ?></label>
				<div class="controls">
					<input type="checkbox" name="active" id="product_active" value="1" <?php if ($this->admin_model_product->form_value('active') or (!$_POST and !uri_assoc('p_id'))) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
			</div>
			
		</div>
		
		<!-- english language -->
		<div class="tab-pane" id="language-tabs-langen">
			<div class="form-box-content">
			
				<!-- product name -->
				<div class="control-group">
				<label class="control-label" for="pro_name_en"><?php echo $this->lang->line('product_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="product_name_en" id="pro_name_en" value="<?php if($productobj_en!=false) echo $productobj_en->product_name; ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- product intro -->
				<div class="control-group">
				<label class="control-label" for="pro_intro_en"><?php echo $this->lang->line('product_intro'); ?></label>
				<div class="controls">
				<textarea id="pro_intro_en" name="product_intro_en" class="tinymce textarea-large" rows="10"><?php if($productobj_en!=false) echo $productobj_en->product_intro; ?></textarea>
				</div>
				</div>
				
				<!-- product desc -->
				<div class="control-group">
				<label class="control-label" for="pro_description_en"><?php echo $this->lang->line('product_description'); ?></label>
				<div class="controls">
				<textarea id="pro_description_en" name="product_description_en" class="tinymce textarea-large" rows="10"><?php if($productobj_en!=false) echo $productobj_en->product_description; ?></textarea>
				</div>
				</div>
				
			</div>
		</div>
		
		<!-- product slide images -->
		<div class="tab-pane" id="slide-tabs-image">
			<div class="form-box-content">
				<?php if(uri_assoc('p_id')) { ?>
				<!-- image select -->
				<div class="control-group">
				<div class="controls">
				<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_product->form_value('product_image_link');?>" alt="" id="image_show" /></a>
				</div>
				</div>
				<?php }?>
				<div class="control-group">
					<label class="control-label" for="image_select_id">Avatar Image</label>
					<div class="controls">
						<input class="input-large" id="image_select_id" name="product_image_link" type="text" value="<?php echo $this->admin_model_product->form_value('product_image_link');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/products/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
					</div>
				</div>
			</div>
			
			<!-- slide images -->
			<?php echo $slide_image_product;?>
			<!-- noi that -->
			<?php echo $interior_image_product;?>
			<!-- ngoai that -->
			<?php echo $exterior_image_product;?>
			<!-- an toan -->
			<?php echo $safety_image_product;?>
			<!-- bang mau -->
			<?php echo $pallete_image_product;?>
		</div>
		
		<!-- tech info select -->
		<div class="tab-pane" id="techinfo-tabs-product">
			<div class="form-box-content" id="pattern_techinfo">
			</div>
		</div>
		
	</div><!-- tab content -->
	
	<div class="form-box-content">
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('p_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
	</div>
	
	</form>
	<!-- / form 1 edit -->