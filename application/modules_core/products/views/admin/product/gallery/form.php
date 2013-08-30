<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/products/index');?>">Product List</a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/products/gallery/index');?>">Product Gallery</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="">

	<h4 class="form-box-header"><?php echo $action_type.' Product Gallery';?></h4>
		
	<div class="form-box-content">
		<!-- gallery name -->
		<div class="control-group">
		<label class="control-label" for="product_gallery_name">* Name:</label>
		<div class="controls">
		<input type="text" name="product_gallery_name" id="product_gallery_name" value="<?php echo $this->admin_model_productgallery->form_value('product_gallery_name'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- product gallery type -->
		<div class="control-group">
		<label class="control-label" for="product_gallery_type">* Type</label>
		<div class="controls">
		<select name="product_gallery_type" id="product_gallery_type" class="chosen">
			<?php if($product_gallery_type_list!=false) {
			foreach($product_gallery_type_list->result() as $type) {?>
				<option value="<?php echo $type->id;?>" <?php if($this->admin_model_productgallery->form_value('product_gallery_type')==$type->id) echo 'selected';?>><?php echo $type->type_name;?></option>
			<?php }
			}?>
		</select>
		</div>
		</div>
		
		<div class="form-actions">
			<input type="submit" name="btn_submit" class="btn btn-success" value="<?php if(uri_assoc('cgal_id')) echo $this->lang->line('edit_action'); else echo $this->lang->line('add_action');?>" />
			<input type="submit" name="btn_cancel" class="btn btn-danger" value="<?php echo $this->lang->line('cancel_action');?>" />
		</div>
		
	</div>
	
</form>
<!-- / form 1 edit -->