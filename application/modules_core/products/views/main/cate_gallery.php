			<div class="product_detail"><!--Begin: full page-->
            
            	<div class="title_product_detail">
            		<div class="titel_w_line">
                    	<p>
						<a href="<?php echo site_url('san-pham');?>"><?php echo $this->lang->line('title_product_page');?></a> <span><a href="<?php echo site_url('san-pham/loai/'.$this->uri->segment(3))?>"><?php echo $catalog_info->pc_name;?></a></span> <span><?php echo $this->lang->line('button_slidebanner_gallery');?></span> 
						</p>
                    </div>
                </div>
                
                <div class="content_sub_product"><!--Begin: content sub product detail-->
					<?php echo $catalog_gallery_content;?>
                </div><!--End: content sub product detail-->
               
            </div><!--End: full page-->