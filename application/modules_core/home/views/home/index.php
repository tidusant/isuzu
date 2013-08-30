			
			<?php if($event_promotion!=false) {
			$_run = 0;?>
			<!-- promotion -->
        	<div class="promotion_home"><!--Begin: promotion home-->
            	<div class="titel_w_line"><p><a href="tin-tuc" style="text-decoration: none;"><?php echo $this->lang->line('title_home_promotion');?></a></p></div>
				<?php foreach($event_promotion->result() as $ep) {
				if($_run==0) { // first row ?>
                <div class="lasted_promotion_home">
                	<a href="<?php echo site_url('tin-tuc/'.$ep->event_slug);?>">
						<?php if($ep->event_link_image!='') {?>
							<img src="<?php 
								$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $ep->event_link_image);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('home_promotion_size_w'), $this->config->item('home_promotion_size_h'));?>" alt="<?php echo $ep->event_title;?>" />
						<?php } else {?>
							<!-- no image -->
							<img src="<?php echo base_url();?>assets/images/home_promotion.png" alt="<?php echo $ep->event_title;?>" />
						<?php }?>
					</a>
                    <p><a href="<?php echo site_url('tin-tuc/'.$ep->event_slug);?>"><?php echo $ep->event_title;?></a></p>
                </div>
				<?php } else {?>
                <div class="more_pro_home"><p><a href="<?php echo site_url('tin-tuc/'.$ep->event_slug);?>"><?php echo $ep->event_title;?></a></p></div>
				<?php }
				$_run += 1;
				}?>
				
            </div><!--End: promotion home-->
            <?php } ?>
			
            <div class="product_home"><!--Begin: product home-->
            	<div class="titel_w_line"><p><a href="san-pham" style="text-decoration: none;"><?php echo $this->lang->line('title_home_products');?></a></p></div>
                
				<div class="slider4">
				
				<?php if(isset($catalog_home) && $catalog_home!=false) {
					$_run = 0;
						foreach($catalog_home->result() as $catalog) { ?>
                <div class="product_item_home">
                	<a href="<?php echo site_url('san-pham/loai/'.$catalog->pc_slug)?>">
						
						<?php if($catalog->pc_image_link_extra!=NULL) {
						
							$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $catalog->pc_image_link_extra);
							echo '<img src="'.image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('home_catalog_size_w'), $this->config->item('home_catalog_size_h')).'" alt="'.$catalog->pc_name.'" />';
							
						} else {?>
							<img src="<?php echo base_url();?>assets/images/product_cate.png" alt="<?php echo $catalog->pc_name;?>" width="174" height="120" />
						<?php }?>
					</a>
                    <div class="name_product_img"><a href="<?php echo site_url('san-pham/loai/'.$catalog->pc_slug)?>">
						<?php if($catalog->pc_image_link!=NULL) {?>
							<img src="<?php echo $catalog->pc_image_link;?>" alt="<?php echo $catalog->pc_name;?>" height="12" />
						<?php } else echo $catalog->pc_name;?>
					</a></div>
                </div>
				<?php $_run += 1; }
				} ?>
                </div>
            </div><!--End: product home-->
            
			<!-- news -->
            <div class="news_home"><!--Begin: news home-->
            	<div class="titel_w_line"><p><a href="tin-tuc" style="text-decoration: none;"><?php echo $this->lang->line('title_home_newsevent');?></a></p></div>
				<?php if($event_news!=false) { $_run = 0;
				foreach($event_news->result() as $news) {
					if($news->event_ontop=='1' && $_run==0) {?>
						<div class="lasted_news_home">
							<a href="<?php echo site_url('tin-tuc/'.$news->event_slug);?>">
								<?php if($news->event_link_image!='') {?>
									<img src="<?php 
									$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $news->event_link_image);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('home_news_size_w'), $this->config->item('home_news_size_h'));?>" alt="<?php echo $news->event_title;?>" />
								<?php } else {?>
									<!-- no image -->
									<img src="<?php echo base_url();?>assets/images/home_news.png" alt="<?php echo $news->event_title;?>" />
								<?php }?>
							</a>
							<p><a href="<?php echo site_url('tin-tuc/'.$news->event_slug);?>"><?php echo $news->event_title;?></a></p>
						</div>
					<?php } else {?>
                <div class="more_news_home"><p><a href="<?php echo site_url('tin-tuc/'.$news->event_slug);?>"><?php echo $news->event_title;?></a></p></div>
				<?php } $_run+=1; 
					}
				} ?>
            </div><!--End: news home-->
            
            <div class="part_home"><!--Begin: part home - belong to product -->
				<?php if($page_show_home!=false) {
				$_runpage = 1;
				foreach($page_show_home->result() as $ct) {?>
					<div class="item_part_home <?php if($_runpage > 1) echo 'mrL16';?>">
						<div class="titel_w_line"><p><a href="<?php echo site_url('san-pham/'.$ct->page_slug);?>" style="text-decoration: none;"><?php echo $ct->page_title;?></a></p></div>
						<div class="content_item_part_home">
							<a href="<?php echo site_url('san-pham/'.$ct->page_slug);?>"><img src="<?php echo base_url();?>assets/images/part0<?php echo $_runpage;?>.png" alt="<?php echo $ct->page_title;?>" width="<?php echo $this->config->item('home_part_size_w');?>" height="<?php echo $this->config->item('home_part_size_h');?>" /></a>
							<p><?php echo word_limiter(strip_tags($ct->page_content), 25);?></p>
							<div class="view_more"><a href="<?php echo site_url('san-pham/'.$ct->page_slug);?>"><?php echo $this->lang->line('button_page_detail');?></a></div>
						</div>
					</div>
				<?php $_runpage += 1;
					}
				}?>
            </div><!--End: part home-->