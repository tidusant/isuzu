<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/productgal/index'.$this->uri->segment(5));?>">Product Image Manage</a></li>
<li class="active"><a href="">Add Media</a></li>
</ul>

<h3>Media Uploading Form</h3>	
	
	<?php echo form_open_multipart(site_url($this->uri->segment(1).'/filemanager/productgal/uploadimg/'), 'id="form_media"'); ?>
		
		<h4 class="form-box-header">Image File Upload</h4>
		<div class="form-box-content">
			<!-- form content -->
			<input type="hidden" name="dir_to_upload" value="<?php echo $product_gal_info->created_folder;?>" />
			<input type="hidden" name="pro_gal" value="<?php echo $product_gal_info->id;?>" />
			<div class="control-group">
			<label class="control-label" for="upload-file">Files</label>
			<div class="controls">
			<input type="file" id="upload-file" name="userfile[]" multiple />
			</div>
			</div>
			
		</div>
		
		<h4 class="form-box-header">Insert Video Link</h4>
		<div class="form-box-content">
			<!-- form content -->
			<br />
			<div class="control-group">
				<label class="control-label" for="video-link">Youtube Links</label>
				<div class="controls" id="textboxarea">
					<p id="video-link1"><input type="text" name="video_link[]" id="video-link" value="" class="input-xlarge" /></p>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<button class="btn btn-info" type="button" id="addButton">Add More Link</button>
					<button class="btn" type="button" id="removeButton">Remove Link</button>
				</div>
			</div>
			
		</div>
		
		<div class="form-box-content">
			<div class="form-actions">
			<button class="btn btn-success" type="submit"><i class="icon-upload"></i> Insert</button>
			<button class="btn btn-danger" type="reset">Reset</button>
			</div>
		</div>
		
    </form>
	
	<p style="text-align:center;"><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/productgal/index/'.$this->uri->segment(5));?>">VIEW LIST</a></p>