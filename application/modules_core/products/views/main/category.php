			<div class="left_subpage"><!--Begin: left subpage-->
            
            	<div class="product_list_page"><!--Begin: product list-->
                	<div class="titel_w_line">
                    	<p>
						<a href="<?php echo site_url('san-pham');?>"><?php echo $this->lang->line('title_product_page');?></a> <span><?php echo $catalog_name;?></span> 
						</p>
                    </div>
                    
                    <div class="content_product_list">
						<?php if($product_list!=false) {
						foreach($product_list->result() as $pl) {?>
                    	<div class="item_product_list">
                        	<a href="<?php echo site_url('san-pham/chi-tiet/'.$pl->product_slug);?>">
								<?php if($pl->product_image_link!=NULL) {?>
									<img src="<?php 
									$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $pl->product_image_link);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('product_catalog_size_w'), $this->config->item('product_catalog_size_h'));?>" alt="<?php echo $pl->product_name;?>" />
								<?php } else {?>
									<img src="<?php echo base_url();?>assets/images/product_list.png" alt="<?php echo $pl->product_name;?>" />
								<?php }?>
							</a>
                            <h3><a href="<?php echo site_url('san-pham/chi-tiet/'.$pl->product_slug);?>"><?php echo $pl->product_name;?></a></h3>
                            <?php if(strip_tags($pl->product_description)=='') echo $this->lang->line('page_not_avail_language'); else {
								if(strstr(strip_tags(strtolower($pl->product_description)), '[p]') || strstr(strip_tags(strtolower($pl->product_description)), '[/p]')) {
									$product_short_desc = product_short_desc_output($pl->product_description);
									foreach($product_short_desc as $short_desc) echo '<p>'.$short_desc.'</p>';
								}
								else echo '<p>'.word_limiter(strip_tags($pl->product_description), 25).'</p>';
							}?>
                            <div class="view_product_detail"><a href="<?php echo site_url('san-pham/chi-tiet/'.$pl->product_slug);?>"><?php echo $this->lang->line('button_page_detail');?></a></div>
                        </div>
                        <?php }
						} else {?>
						<div style="background:#fff;"><?php echo $this->lang->line('product_not_update');?></div>
                        <?php }?>
                    </div>
                	
                </div><!--End: product list-->
                
            </div><!--End: left subpage-->
			
            <!-- right column -->
			<div class="right_subpage" id="sidebar_product"><!--Begin: right subpage-->
            	<div class="right_product_list">
                	<div class="title_right_product_list"><?php echo $this->lang->line('sidebar_product_catalog');?></div>
					<?php echo modules::run('products/_render_sidebar', $cur_lang);?>
				</div>
                <!-- right banner -->
                <?php echo modules::run('products/_render_right_banner');?>
            </div><!--End: right subpage-->