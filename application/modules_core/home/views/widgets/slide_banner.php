	<div class="slide_big"><!--Begin: slide-->
		<div class="wrapper">
			<div class="slide_content">
				
				<div id="slide_banner" class="nivoSlider">
					<?php if($banner_slide!=false) {
						foreach($banner_slide->result() as $banner) {?>
							<a href="<?php echo $banner->banner_link;?>">
							<?php if($banner->banner_link_image!='') {?><img src="<?php 
							if(!strstr($banner->banner_link_image, base_url())) {
								echo $banner->banner_link_image;
							} else {
								$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $banner->banner_link_image);
								echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, '912', '340');
							}?>" width="912" height="340" />
							<?php } else {?>
							<img src="<?php echo base_url()?>assets/images/slide.png" width="912" height="340" />
							<?php }?></a>
					<?php }
					}?>
                </div>
				
			</div>
		</div>
	</div><!--End: slide-->