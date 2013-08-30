<style type="text/css">
	a.thumbnail img {
		width: 160px;
		height: 120px;
	}
</style>

<ul id="nav-info" class="clearfix">
<li><a href="<?php echo site_url($this->uri->segment(1));?>"><i class="icon-home"></i></a></li>
<li><a href="<?php echo site_url($this->uri->segment(1).'/catalog/gallery');?>">Catalog Image Storage</a></li>
<li class="active"><a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/index/'.$this->uri->segment(5));?>">Catalog Images Management</a></li>
</ul>

<h3 class="page-header"><?php echo $cate_gallery_name;?> &raquo; media list</h3>

<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/addimg/'.$this->uri->segment(5))?>" class="btn btn-primary">Add More Images</a>

<br />
<?php echo modules::run('administration/_render_system_alert_message');?>
<br />

	<ul class="nav nav-tabs" id="directory-tabs">
		<li class="active"><a href="#media-type-image">Image</a></li>
		<li><a href="#media-type-video">Video</a></li>
	</ul>
	
	<form action="<?php echo site_url($this->uri->uri_string());?>" name="category_form_upload" id="category_form_upload_media" method="post">
	
	<div class="tab-content">
		
		<!-- image -->
		<div class="tab-pane active" id="media-type-image">
			<ul class="thumbnails" data-toggle="gallery-options">
			<?php if($cate_gallery_images!=false && $cate_gallery_images!='') {
					$cate_gallery_images = explode('|', $cate_gallery_images);
					$cate_gallery_caption_img = explode('|', $cate_gallery_caption);
					$cate_gallery_caption_en_img = explode('|',$cate_gallery_caption_en);
					
					foreach($cate_gallery_images as $index=>$img) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/deleteimg/file/'.base64_encode($this->uri->segment(5).'-'.$img));?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false;"><button type="button" class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							
							<a href="javascript:void(0)" class="thumbnail"><img src="<?php 
							$full_path_img = $cate_gallery_full_path.'/'.$img;
							$full_path_img = str_replace($this->config->item('admin_mediastore_real_url'), '', $full_path_img);
							echo image_thumb($this->config->item('original_image_upload_path').$full_path_img, '160', '120');?>" alt="" /></a>
							<p style="text-align:center;">
								<input style="color:#787777;text-align:center" type="textbox" name="catalog_gallery_caption[]" id="catalog_gallery_caption_<?php echo $img;?>" onfocus="if(this.value == '<?php echo $this->lang->line('caption_title_textbox');?>') this.value = '';" onblur="if(this.value == '') this.value = '<?php echo $this->lang->line('caption_title_textbox');?>';" value="<?php if(isset($cate_gallery_caption_img[$index]) && $cate_gallery_caption_img[$index]!='') echo $cate_gallery_caption_img[$index]; else echo $this->lang->line('caption_title_textbox');?>" />
							</p>
							<p style="text-align:center;"><input style="color:#787777;text-align:center" type="textbox" name="catalog_gallery_caption_en[]" id="catalog_gallery_caption_en_<?php echo $img;?>" onfocus="if(this.value == '<?php echo $this->lang->line('caption_title_textbox_en');?>') this.value = '';" onblur="if(this.value == '') this.value = '<?php echo $this->lang->line('caption_title_textbox_en');?>';" value="<?php if(isset($cate_gallery_caption_en_img[$index]) && $cate_gallery_caption_en_img[$index] !='') echo $cate_gallery_caption_en_img[$index]; else echo $this->lang->line('caption_title_textbox_en');?>" />
							</p>
						</li>
			<?php }
			}?>
			</ul>
		
		</div>
		
		<!-- video -->
		<div class="tab-pane" id="media-type-video">
			<ul class="thumbnails" data-toggle="gallery-options">
			<?php if($cate_gallery_video!=false && $cate_gallery_video!='') {
					$cate_gallery_video = explode('|', $cate_gallery_video);
					$cate_gallery_caption_video = explode('|', $cate_gallery_caption);
					$cate_gallery_caption_en_video = explode('|',$cate_gallery_caption_en);
					
					foreach($cate_gallery_video as $index=>$video) {?>
						<li>
							<div class="thumbnails-options">
							<div class="btn-group">
							<a href="<?php echo site_url($this->uri->segment(1).'/filemanager/categal/deletevideo/file/'.base64_encode($this->uri->segment(5).'-'.$video));?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('page_delete_warning'); ?>')) return false;"><button type="button" class="btn btn-small btn-danger"><i class="icon-remove"></i></button></a>
							</div>
							</div>
							<!-- video link -->
							<input type="textbox" name="gal_video[]" id="gal_video_<?php echo $index;?>" class="input-large" value="<?php echo $video;?>" style="height:20px;" />
						</li>
			<?php }
			}
			
			unset($cate_gallery_caption);
			unset($cate_gallery_caption_en)?>
			</ul>
		</div>
		
	</div>
	
	<div class="form-box-content" style="text-align:right;">
		<!-- form content -->
		<div class="form-actions">
			<button class="btn btn-success" type="submit">Save</button>
		</div>
	</div>
	</form>