
            	<div class="lastest_news_sub" id="sidebar_latest_news">
                	<div class="title_lastest_news_sub"><?php echo $this->lang->line('news_sidebar_lastest');?></div>
                    <div class="content_lastest_news_sub">
						<?php if($sidebar_latest_news!=false) {?>
                    	<ul>
							<?php foreach($sidebar_latest_news->result() as $news) {?>
                        	<li><a href="<?php echo site_url('tin-tuc/'.$news->event_slug);?>"><?php echo $news->event_title;?></a></li>
							<?php }?>
                        </ul>
						<?php }?>
                    </div>
                </div>