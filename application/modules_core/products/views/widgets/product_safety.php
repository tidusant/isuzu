					<?php if($product_safety!=false) {
						$_run = 0;
					foreach($product_safety as $img) {?>
                	<div class="item_detail_product<?php if($_run > 0) echo ' mrL20';?>">
						<a href="#" rel="lightbox">
							<?php if($img!='') {
							$safety_image_src = $product_full_path.'/'.$img;
							if($safety_image_src!='') {
								if(!strstr($interior_image_src, base_url())) {
									$safety_image_src = $safety_image_src;
								} else {
									$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $safety_image_src);
									$safety_image_src = image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('product_gallery_size_w'), $this->config->item('product_gallery_size_h'));
								}
								
							}?>
								<img src="<?php echo $safety_image_src;?>" width="<?php echo $this->config->item('product_gallery_size_w');?>" height="<?php echo $this->config->item('product_gallery_size_h');?>" />
							<?php } else {?>
								<img src="<?php echo base_url();?>assets/images/noithat.png" alt="" width="<?php echo $this->config->item('product_gallery_size_w');?>" height="<?php echo $this->config->item('product_gallery_size_h');?>" />
							<?php }?>
						</a>
						<p><?php $caption = explode('.', $img);
						echo $caption[0];?></p>
                    </div>
                    <?php $_run += 1;
							if($_run==3) $_run=0;
						}
					}?>