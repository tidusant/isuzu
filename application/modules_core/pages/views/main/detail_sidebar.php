			<div class="left_subpage"><!--Begin: left subpage-->
            	<?php if(isset($facebook_intializing)) echo $facebook_intializing;
				if(isset($sharethis_intializing)) echo $sharethis_intializing;?>
                <div class="news_detail">
					<?php if($page_detail!=false) {?>
                	<div class="top_page_detail">
                    	<div class="label_page_detail"><p><?php echo $page_detail->page_title;?></p></div>
                        <div class="social_share">
							<?php echo sharethis_widget_toolbar_detail();?>
                        </div>
                    </div>
                    
                    <div class="content_news_detail">
                    	<h3><?php echo $page_detail->page_title;?></h3>
						<?php if($page_detail->page_content=='') echo $this->lang->line('page_not_avail_language'); else echo $page_detail->page_content;?>
                        
                        <div class="analytic_news_detail">
                        	<div class="detail_fb_like"><?php echo facebook_ref_page(site_url($this->uri->uri_string()));?></div>
                            <div class="detail_more_like"><?php echo sharethis_widget_detail();?></div>
                        </div>
                        
                    </div>
					<?php }?>
                </div>
				
            </div><!--End: left subpage-->
			
			<!-- right column -->
			<div class="right_subpage"><!--Begin: right subpage-->
				<?php echo modules::run('products/_render_right_banner');?>
			</div>