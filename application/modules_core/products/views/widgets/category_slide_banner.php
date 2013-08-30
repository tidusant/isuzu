	<div class="slide_big"><!--Begin: slide-->
		<div class="wrapper">
			<div class="slide_content">
				
				<div id="slide_banner" class="nivoSlider">
					<?php if($category_slide_banner!=false) {
						foreach($category_slide_banner as $slide_img) {
						$catalog_image_banner = $category_full_path.'/'.$slide_img;
						if($catalog_image_banner!='') {
							if(!strstr($catalog_image_banner, base_url())) {
								$catalog_image_banner = $catalog_image_banner;
							} else {
								$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $catalog_image_banner);
								$catalog_image_banner = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, '912', '340');
							}
							
						}?>
							<a href="<?php echo site_url($this->uri->uri_string());?>"><img src="<?php echo $catalog_image_banner;?>" width="912" height="340" /></a>
					<?php }
					}?>
                </div>
				
				<div class="btn_product_list">
					<div <?php echo $this->lang->line('button_test_drive_class');?>><a href="<?php echo site_url('dang-ki-lai-thu');?>"><?php echo $this->lang->line('button_slidebanner_testdrive');?></a></div>
					<?php if($category_info->pc_gallery_id > 0) {?>
					<div class="gallery_btn"><a href="<?php echo site_url('san-pham/loai/'.$this->uri->segment(3).'/thu-vien');?>"><?php echo $this->lang->line('button_slidebanner_gallery');?></a></div><?php }?>
					<?php if($category_info->pc_source_doc!='') {?><div class="download_catalogue_btn"><a href="<?php echo strip_tags($category_info->pc_source_doc);?>"><?php echo $this->lang->line('button_slidebanner_downloadcatalog');?></a></div><?php }?>
				</div>
				
			</div>
		</div>
	</div><!--End: slide-->