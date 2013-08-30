			
        	<div class="left_subpage"><!--Begin: left subpage-->
				
				<?php echo modules::run('home/_render_system_message');?>
				
				<?php if(isset($facebook_intializing)) echo $facebook_intializing;
				if(isset($sharethis_intializing)) echo $sharethis_intializing;?>
				
                <div class="news_detail">
					<?php if($news_detail!=false) {?>
                	<div class="top_page_detail">
                    	<div class="label_news_detail"><p><?php echo $this->lang->line('title_news_topnews');?></p></div>
                        <div class="social_share">
							<?php echo sharethis_widget_toolbar_detail();?>
                        </div>
                    </div>
                    
                    <div class="content_news_detail">
                    	<h3><?php echo $news_detail->event_title;?></h3>
						<div class="top_news_detail">
							<div class="month_year"><h3><?php echo $this->lang->line('news_posted_at');?>&nbsp;<?php $date_posted = format_news_date($news_detail->created_on); if(strstr($date_posted, '/')) { $date_posted = explode('/', $date_posted); echo $date_posted[0].'<span>/'.$date_posted[1].'</span><span>/'.$date_posted[2].'</span>'; } ?></h3></div>
						</div>
						<?php if($news_detail->event_content=='') echo $this->lang->line('page_not_avail_language'); else {
							if(strstr($news_detail->event_content, '[') && strstr($news_detail->event_content, ']')) echo str_replace('[','', str_replace(']','', $news_detail->event_content));
							else echo $news_detail->event_content;
						}?>
						
                        <div class="analytic_news_detail">
                        	<div class="detail_fb_like"><?php echo facebook_ref_page(site_url('tin-tuc/'.$news_detail->event_slug));?></div>
                            <div class="detail_more_like"><?php echo sharethis_widget_detail();?></div>
							<?php if($news_detail->comment_allow!='0') {?>
                            <div class="count_cm">
                            	<?php echo $this->model_news->get_comment_count_news($news_detail->event_id);?> <span><?php echo $this->lang->line('button_comment');?></span>
                            </div>
							<?php }?>
                        </div>
                        
						<?php if($news_detail->comment_allow!='0') { ?>
                        <!-- comment -->
                        <div class="comment_post">
							<form name="form_comment" action="<?php echo site_url('tin-tuc/binh-luan');?>" method="post">
							<input type="hidden" name="news_no" value="<?php echo $news_detail->event_id;?>" />
                        	<input type="text" name="authorname" class="input01" value="<?php echo $this->lang->line('comment_fullname');?>" onblur="if(this.value=='') this.value= '<?php echo $this->lang->line('comment_fullname');?>';" onfocus="if(this.value=='<?php echo $this->lang->line('comment_fullname');?>') this.value='';" />
                            <input type="text" class="input01" name="email" value="Email" onblur="if(this.value=='') this.value= 'Email';" onfocus="if(this.value=='Email') this.value='';" />
							
							<textarea class="textarea-input02" name="comment" onblur="if(this.value=='') this.value= '<?php echo $this->lang->line('comment_writecomment');?>';" onfocus="if(this.value=='<?php echo $this->lang->line('comment_writecomment');?>') this.value='';"><?php echo $this->lang->line('comment_writecomment');?></textarea>
							
                            <input type="submit" class="btn_comment" name="submit" value="Submit" />
							</form>
                        </div>
						<?php if($comment_list!=false) {
						foreach($comment_list->result() as $cmt) {?>
                        <div class="list_comment">
                        	<h3><?php echo $cmt->cmt_author;?></h3>
                            <p><?php echo strip_tags($cmt->cmt_content);?><span><?php echo $cmt->cmt_date;?></span></p>
                        </div>
                        <?php }
						}
						}?>
                    </div>
					<?php }?>
                </div>
                
            </div><!--End: left subpage-->
            
			<div class="right_subpage" id="sidebar_sticky"><!--Begin: right subpage-->
				<!-- sidebar -->
				<?php echo modules::run('news/_render_sidebar_detail');?>
				<!-- right banner -->
				<?php echo modules::run('products/_render_right_banner');?>
			</div>