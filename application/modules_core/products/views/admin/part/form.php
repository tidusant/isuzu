

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/parts/index');?>"><?php echo $this->lang->line('part_module');?></a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="" enctype="multipart/form-data" />

	<h4 class="form-box-header"><?php echo $action_type.' '.$this->lang->line('part_module');?></h4>
	
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
				<!-- product category -->
				<div class="control-group">
				<label class="control-label" for="product_category">* <?php echo $this->lang->line('product_category'); ?></label>
				<div class="controls">
					<select name="product_cate_pc_id" id="product_category" class="select-chosen">
						<option value="0">-None-</option>
						<?php if($category_list!=false) {
								$selected_option = '';
								foreach($category_list->result() as $al) {
									if($this->admin_model_part->form_value('product_cate_pc_id') == $al->pc_id) {
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
				<label class="control-label" for="pa_name">* <?php echo $this->lang->line('part_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="part_name" id="pa_name" value="<?php echo $this->admin_model_part->form_value('part_name'); ?>" class="input-medium" />
				</div>
				</div>
				
				<!-- price -->
				<div class="control-group">
				<label class="control-label" for="acc_price">Price</label>
				<div class="controls">
				<input type="text" name="part_price" id="part_price" value="<?php echo $this->admin_model_part->form_value('part_price'); ?>" class="input-small" />
				</div>
				</div>
				
				<!-- product desc -->
				<div class="control-group">
				<label class="control-label" for="pa_description"><?php echo $this->lang->line('part_description'); ?></label>
				<div class="controls">
				<textarea id="pa_description" name="part_desc" class="tinymce textarea-large" rows="10"><?php echo $this->admin_model_part->form_value('part_desc'); ?></textarea>
				</div>
				</div>
				
				<!-- order -->
				<div class="control-group">
				<label class="control-label" for="order_priority"><?php echo $this->lang->line('part_priority'); ?></label>
				<div class="controls">
				<input type="text" id="order_priority" name="display_order" class="input-mini" value="<?php if(!$this->admin_model_part->form_value('display_order')) echo '09'; else echo $this->admin_model_part->form_value('display_order'); ?>" />
				</div>
				</div>
				
				<!-- active -->
				<div class="control-group">
				<label class="control-label" for="part_active"><?php echo $this->lang->line('part_active'); ?></label>
				<div class="controls">
					<input type="checkbox" name="active" id="part_active" value="1" <?php if ($this->admin_model_part->form_value('active') or (!$_POST and !uri_assoc('pa_id'))) { ?>checked="checked"<?php } ?> />
				</div>
				</div>
				
			</div>
	
		</div>
		
		<!-- en -->
		<div class="tab-pane" id="language-tabs-langen">
			<div class="form-box-content">
				<!-- product name -->
				<div class="control-group">
				<label class="control-label" for="pa_name"><?php echo $this->lang->line('part_name'); ?>:</label>
				<div class="controls">
				<input type="text" name="part_name_en" id="pa_name" value="<?php if($partobj_en!=false) echo $partobj_en->part_name;?>" class="input-medium" />
				</div>
				</div>
				
				<!-- desc -->
				<div class="control-group">
				<label class="control-label" for="pa_description_en"><?php echo $this->lang->line('part_description'); ?></label>
				<div class="controls">
				<textarea id="pa_description_en" name="part_desc_en" class="tinymce textarea-large" rows="10"><?php if($partobj_en!=false) echo $partobj_en->part_desc;?></textarea>
				</div>
				</div>
			</div>
		</div>
		
		<!-- image gallery -->
		<div class="tab-pane" id="slide-tabs-image">
			<div class="form-box-content">
				<?php if(uri_assoc('pa_id')) { ?>
				<!-- image select -->
				<div class="control-group">
				<div class="controls">
				<a href="#" rel="lightbox"><img src="<?php echo $this->admin_model_part->form_value('part_link_image');?>" alt="" id="image_show" /></a>
				</div>
				</div>
				<?php }?>
				<div class="control-group">
					<label class="control-label" for="image_select_id">Avatar Image</label>
					<div class="controls">
						<input class="input-large" id="image_select_id" name="part_link_image" type="text" value="<?php echo $this->admin_model_part->form_value('part_link_image');?>" />
						<a href="<?php echo base_url()?>assets/admin/js/tinymce/plugins/filemanager/dialog.php?type=1&subfolder=&editor=mce_0&lang=eng&fldr=media/parts/&field_id=image_select_id" class="btn iframe-btn" type="button">Browse</a>
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