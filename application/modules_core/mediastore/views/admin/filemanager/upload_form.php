	<?php echo form_open_multipart(site_url($this->uri->segment(1).'/filemanager/attach_upload_media'), 'id="form_media"'); ?>
		
		<div class="form-box-content">
			<!-- form content -->
			<div class="control-group">
			<label class="control-label" for="dir_name">Directory to upload:</label>
			<div class="controls">
				<select name="directory_name" id="dir_name">
					<option value="news/">-News-</option>
					<option value="products/">-Products-</option>
					<option value="categories/">-Categories-</option>
					<option value="pages/">-Pages-</option>
					<option value="partners/">-Partners-</option>
					<option value="banners/">-Banners-</option>
				</select>
			</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="browse_files">Browse Files:</label>
				<div class="controls">
					<input type="file" id="browse_files" name="userfile[]" class="fileupload" multiple />
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<button id="px-submit" type="submit">Upload</button>
					<button id="px-clear" type="reset">Clear</button>
				</div>
			</div>
			
		</div>
		
    </form>