			<div class="full_page">
            	<div class="titel_w_line"><p><?php echo $this->lang->line('title_part_page');?></p></div>
				
				<?php if($category_list!=false) {
				foreach($category_list->result() as $cate) {?>
                <div class="list_cate">
                	<div class="image_cate">
						<a href="<?php echo site_url('phu-tung/loai/'.$cate->pc_slug);?>">
							<?php if($cate->pc_image_link_extra!=NULL) {?>
								<img src="<?php 
									$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $cate->pc_image_link_extra);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('product_index_size_w'), $this->config->item('product_index_size_h'));?>" alt="<?php echo $cate->pc_name;?>" width="<?php echo $this->config->item('product_index_size_w');?>" height="<?php echo $this->config->item('product_index_size_h');?>" />
							<?php } else {?>
								<img src="<?php echo base_url();?>assets/images/product_cate.png" alt="<?php echo $cate->pc_name;?>" width="<?php echo $this->config->item('product_index_size_w');?>" height="<?php echo $this->config->item('product_index_size_h');?>" />
							<?php }?>
						</a>
					</div>
                    <div class="name_cate"><a href="<?php echo site_url('phu-tung/loai/'.$cate->pc_slug);?>">
						<?php if($cate->pc_image_link!=NULL) {?>
						<img src="<?php echo $cate->pc_image_link;?>" alt="<?php echo $cate->pc_name;?>" />
						<?php } else {?>
						<img src="<?php echo base_url();?>assets/images/name_cate_<?php echo $cate->pc_id;?>.png" alt="<?php echo $cate->pc_name;?>" />
						<?php }?>
					</a></div>
                </div>
                <?php }
				}?>
				
            </div>