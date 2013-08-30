<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/index');?>"><?php echo $this->lang->line('modul_mediastore');?></a></li>
<li class="active"><a href="">Add Media</a></li>
</ul>

<h3>Image Uploading Form</h3>

	<!-- The file upload form used as target for the file upload widget -->
	<?php echo form_open_multipart(site_url($this->uri->segment(1).'/filemanager/attach_upload_media'), 'id="form_media"'); ?>
		
		<h4 class="form-box-header">File Upload</h4>
		<div class="form-box-content">
		
			<div class="control-group">
			<label class="control-label" for="upload_type">Upload type:</label>
			<div class="controls">
				<p><input type="radio" name="upload_type" id="image_type" />&nbsp; Image&nbsp;&nbsp;
				<input type="radio" name="upload_type" id="pdf_type" />&nbsp; Pdf</p>
			</div>
			</div>
			
			<!-- form content -->
			<div class="control-group">
			<label class="control-label" for="dir_name">Images directory to upload:</label>
			<div class="controls">
				<select name="directory_name" id="dir_name_img" disabled>
					<option value="news/">-News-</option>
					<option value="products/">-Products-</option>
					<option value="categories/">-Categories-</option>
					<option value="pages/">-Pages-</option>
					<option value="partners/">-Partners-</option>
					<option value="banners/">-Banners-</option>
					<option value="accessories/">-Accessories-</option>
					<option value="rearbody/">-Rearbody-</option>
					<option value="parts/">-Parts-</option>
				</select>
			</div>
			</div>
			
			<!-- other file upload -->
			<div class="control-group">
			<label class="control-label" for="dir_name_pdf">Pdf directory to upload:</label>
			<div class="controls">
				<select name="directory_name" id="dir_name_pdf" disabled>
					<option value="categories/files/">-Categories-</option>
					<option value="products/files/">-Products-</option>
				</select>
			</div>
			</div>
			
			<div class="control-group">
			<label class="control-label" for="upload-file">File</label>
			<div class="controls">
			<input type="file" id="upload-file" name="userfile[]" multiple />
			</div>
			</div>
			<div class="form-actions">
			<button class="btn btn-success" type="submit"><i class="icon-upload"></i> Upload</button>
			<button class="btn btn-danger" type="reset">Cancel</button>
			</div>
			
		</div>
		
    </form>
	
	<p style="text-align:center"><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/index');?>">VIEW LIST</a></p>