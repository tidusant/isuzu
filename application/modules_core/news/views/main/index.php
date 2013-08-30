			<?php if(isset($facebook_intializing)) echo $facebook_intializing;
			if(isset($sharethis_intializing)) echo $sharethis_intializing;?>
			
			<div class="title_full_line"><p><?php echo $this->lang->line('title_news_page');?></p></div>
			
			<div class="left_subpage"><!--Begin: left subpage-->
				
				<?php if($this->uri->segment(2)!='trang' && $this->uri->segment(3)=='') {
				if($promotion_latest!=false) {?>
            	<div class="promotion_subpage">
                    
                    <div class="item_promotion_sub">
                    	<a href="<?php echo site_url('tin-tuc/'.$promotion_latest->event_slug);?>">
							<?php if($promotion_latest->event_link_image!='') {?>
								<img src="<?php 
									$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $promotion_latest->event_link_image);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('news_index_promotion_w'), $this->config->item('news_index_promotion_h'));?>" alt="<?php echo $promotion_latest->event_title;?>" alt="<?php echo $promotion_latest->event_title;?>" />
							<?php } else { ?>
								<!-- no image -->
								<img src="<?php echo base_url();?>assets/images/promotion.png" alt="<?php echo $promotion_latest->event_title;?>" alt="<?php echo $promotion_latest->event_title;?>" />
							<?php } ?>
						</a>
                        <h3><a href="<?php echo site_url('tin-tuc/'.$promotion_latest->event_slug);?>"><?php echo $promotion_latest->event_title;?></a></h3>
                        <p><?php if(strip_tags($promotion_latest->event_content)=='') echo $this->lang->line('page_not_avail_language'); else {
							if(strstr($promotion_latest->event_content, '[') && strstr($promotion_latest->event_content, ']')) {
								echo news_short_desc_output($promotion_latest->event_content);
							} else echo word_limiter(strip_tags($promotion_latest->event_content), $short_desc_limit_promotion);
						}?></p>
						<div class="view_detail"><a href="<?php echo site_url('tin-tuc/'.$promotion_latest->event_slug);?>"><?php echo $this->lang->line('button_news_detail');?></a></div>
                    </div>
                </div>
                <?php }
				if($news_ontop_latest!=false) { ?>
				<div class="title_full_line"><p><?php echo $this->lang->line('title_news_topnews')?></p></div>
                <div class="top_news_sub">                	
                    <div class="content_top_news_sub">
                    	<div class="img_topnews"><a href="<?php echo site_url('tin-tuc/'.$news_ontop_latest->event_slug);?>">
						
						<?php if($news_ontop_latest->event_link_image!='') {?>
							<img src="<?php 
								$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $news_ontop_latest->event_link_image);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('news_index_top_w'), $this->config->item('news_index_top_h'));?>" alt="<?php echo $news_ontop_latest->event_title;?>" class="img_topnews" />
						<?php } else {?>
							<!-- no image -->
							<img src="<?php echo base_url();?>assets/images/top-news.png" alt="<?php echo $news_ontop_latest->event_title;?>" />
						<?php }
						unset($news_ontop_image);?>
						
						</a></div>
                        <h3><a href="<?php echo site_url('tin-tuc/'.$news_ontop_latest->event_slug);?>"><?php echo $news_ontop_latest->event_title;?></a></h3>
                        <p><?php if(strip_tags($news_ontop_latest->event_content)=='') echo $this->lang->line('page_not_avail_language'); else {
							if(strstr($news_ontop_latest->event_content, '[') && strstr($news_ontop_latest->event_content, ']')) {
								echo news_short_desc_output($news_ontop_latest->event_content);
							} else echo word_limiter(strip_tags($news_ontop_latest->event_content), $short_desc_limit_topnews);
						}?></p>
                        
                        <div class="analytic_top_news">
                        	<div class="fb_like"><?php echo facebook_ref_page(site_url('tin-tuc/'.$news_ontop_latest->event_slug));?></div>
                            <div class="more_like"><?php echo sharethis_widget($news_ontop_latest->event_title, site_url('tin-tuc/'.$news_ontop_latest->event_slug));?></div>
                            <div class="count_cm">
                            	<?php echo $this->model_news->get_comment_count_news($news_ontop_latest->event_id);?> <span><img src="<?php echo base_url()?>assets/images/news/double_comment.png" alt="<?php echo $this->lang->line('button_comment');?>" height="24" /></span>
                            </div>
                        </div>
                    </div>
                </div><!--End: top news-->
				<?php }
				} // seperate paging listing
				// news listing
				$_run = 1;
				if($news_list!=false) {
				foreach($news_list->result() as $item) {
				if($this->uri->segment(3)=='' && $_run == 5) { echo '<div id="hidden-news-item">'; }?>
                <div class="news_item_sub<?php if($_run % 2 == 0) echo ' mrL12';?>"><!--Begin: news item-->
                	<div class="content_news_item_sub">
                        <h3><a href="<?php echo site_url('tin-tuc/'.$item->event_slug);?>"><?php echo $item->event_title;?></a></h3>
                        <a href="<?php echo site_url('tin-tuc/'.$item->event_slug);?>">
						<?php if($item->event_link_image != '') {?>
							<img src="<?php 
							$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $item->event_link_image);
									echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('news_index_record_w'), $this->config->item('news_index_record_h'));?>" alt="<?php echo $item->event_title;?>" />
						<?php } else {?>
							<img src="<?php echo base_url();?>assets/images/news_post2.png" alt="<?php echo $item->event_title;?>" />
						<?php }
						unset($news_image);?>
						</a>
                        <p><?php if(strip_tags($item->event_content)=='') echo $this->lang->line('page_not_avail_language'); else {
							if(strstr($item->event_content, '[') && strstr($item->event_content, ']')) {
								echo word_limiter(news_short_desc_output($item->event_content), $short_desc_limit_mininews);
							} else echo word_limiter(strip_tags($item->event_content), $short_desc_limit_mininews);
						}?></p>
                    </div>
                    
                     <div class="analytic_news_item">
                        <div class="fb_like"><?php echo facebook_ref_page(site_url('tin-tuc/'.$item->event_slug));?></div>
                        <div class="more_like"><?php echo sharethis_widget($item->event_title, site_url('tin-tuc/'.$item->event_slug));?></div>
                        <div class="count_cm">
                            <?php echo $this->model_news->get_comment_count_news($item->event_id);?> <span><img src="<?php echo base_url()?>assets/images/news/double_comment.png" alt="<?php echo $this->lang->line('button_comment');?>" height="24" /></span>
                        </div>
                    </div>
                </div><!--End: news item-->
                <?php 	if($this->uri->segment(3)=='' && $_run==4) {
						echo '<div class="title_full_line"><p><a href="#show-news-item" id="show-news-item">'.$this->lang->line('button_news_show_more').'</a></p></div>';
						}
						if($this->uri->segment(3)=='' && $news_list->num_rows() == $_run) echo '</div><!-- show more-->';
						$_run+=1;
						
					}
				}?>
				<br />
				<!-- paging -->
				<?php if(isset($pagination)) echo '<div id="paging">'.$pagination.'</div>';?>
				<!-- paging -->
				
            </div><!--End: left subpage-->
            
			<!-- right column -->
			<div class="right_subpage" id="sidebar_sticky"><!--Begin: right subpage-->
            	<?php echo modules::run('news/_render_sidebar');?>
				<!-- right banner -->
				<?php echo modules::run('products/_render_right_banner');?>
			</div><!--End: right subpage-->
			
			<script type="text/javascript">
				$(document).ready(function() {
					//$("div#hidden-news-item").hide();
					$('a#show-news-item').click(function(){
						$("div#hidden-news-item").slideDown();
						FB.XFBML.parse();
					});
				});
			</script>