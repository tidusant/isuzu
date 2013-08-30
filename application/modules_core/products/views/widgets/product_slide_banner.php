	<div class="slide_big"><!--Begin: slide-->
		<div class="wrapper">
			<div class="slide_content">
				
				<div id="slide_banner" class="nivoSlider">
					<?php if($product_slide_banner!=false) {
						foreach($product_slide_banner as $slide_img) {?>
							<a href="<?php echo site_url($this->uri->uri_string());?>"><img src="<?php echo $product_full_path.'/'.$slide_img;?>" width="912" height="340" /></a>
					<?php }
					}?>
                </div>
				
				<div class="btn_product_list">
					<div <?php echo $this->lang->line('button_test_drive_class');?>><a href="<?php echo site_url('dang-ki-lai-thu');?>"><?php echo $this->lang->line('button_slidebanner_testdrive');?></a></div>
					<?php if($category_info->pc_gallery_id > 0) {?>
					<div class="gallery_btn"><a href="<?php echo site_url('san-pham/loai/'.$category_info->pc_slug.'/thu-vien');?>"><?php echo $this->lang->line('button_slidebanner_gallery');?></a></div><?php }?>
					<?php if($download_catalogue_link!='') {?><div class="download_catalogue_btn"><a href="<?php echo $download_catalogue_link;?>"><?php echo $this->lang->line('button_slidebanner_downloadcatalog');?></a></div><?php }?>
				</div>
				
			</div>
		</div>
	</div><!--End: slide-->