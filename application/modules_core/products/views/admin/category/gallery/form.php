<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/index');?>">Catalog List</a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery/index');?>">Catalog Gallery</a></li>
<li class="active"><a href=""><?php echo $action_type;?></a></li>
</ul>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

<form class="form-horizontal form-box" method="post" action="<?php echo site_url($this->uri->uri_string());?>">

	<h4 class="form-box-header"><?php echo $action_type.' Catalog Gallery';?></h4>
		
	<div class="form-box-content">
		<!-- gallery name -->
		<div class="control-group">
		<label class="control-label" for="cate_gallery_name">* Name:</label>
		<div class="controls">
		<input type="text" name="cate_gallery_name" id="cate_gallery_name" value="<?php echo $this->admin_model_categallery->form_value('cate_gallery_name'); ?>" class="input-medium" />
		</div>
		</div>
		
		<!-- catalog type -->
		<div class="control-group">
		<label class="control-label" for="cate_type">* Type</label>
		<div class="controls">
		<select name="cate_type" id="cate_type" class="chosen">
			<option value="cate-gallery" <?php if($this->admin_model_categallery->form_value('cate_type')=='cate-gallery') echo 'selected';?>>Catalog Image Gallery</option>
			<option value="cate-slide" <?php if($this->admin_model_categallery->form_value('cate_type')=='cate-slide') echo 'selected';?>>Slide Image</option>
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