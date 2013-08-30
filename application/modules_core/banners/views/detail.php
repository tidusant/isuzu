<?php $this->load->view('header');?>

<div class="main_content_comic"><!--Begin: main content comic-->
    
    	<?php $this->load->view('widgets/leftsubpageauthor');?>
        <div class="right_trang_truyen"><!--Begin: right trang truyen-->
			
		<?php if($author_detail!=false):?>
          <div class="title_right_tt">
				Tác giả <span><?php echo $author_detail->title;?></span>
          </div>
          
          <div class="content_right_tt"><!--Begin: content right trang truyen-->
          
          	<div class="photo_comic_tt"><img src="<?php echo $author_detail->picture;?>s175-c/"  alt="tác giả <?php echo $author_detail->title;?>" /></div>
            
            <div class="info_comic_tt"><!--Begin: info trang truyen-->
            
                <div class="so_luoc_comic_tt">
                	<h3>Tiểu sử</h3>
                    <p><?php echo $author_detail->infomation ?></p>
                </div><!--/: so luoc trang truyen-->
                
                
                <div class="analytic_comic"><!--Begin: analytic comic-->
                	<ul>
                    	<li><strong>Lượt xem:</strong> <?php echo $author_detail->view_count ?></li>
                        <li><strong>Website:</strong> <?php $website = $author_detail->web_page ; $web = ( ($website !="") ?  "<a  target ='_blank' href='$website'>Xem Web</a>" : "Đang Update" ); echo $web ?></li>
                        <li><strong>Số truyện</strong> <?php echo $author_detail->truyen_count; ?></li>
                    </ul>
                </div><!--/: analytic comic-->
                
            </div><!--/: info trang truyen-->
            
          </div>  <!--/: content right trang truyen--> 
			<?php endif;?>
			
        </div><!--/: right trang truyen-->
        
        <?php $_run = 0;
		if($list_truyen_author!=false):?>
        <div class="related_comic"><!--Begin: truyen cung loai-->
        	<div class="title_related_comic">Truyện của tác giả</div>
            <div class="content_related_comic">
				<?php foreach($list_truyen_author->result() as $rc):?>
            	<div class="item_list_comic<?php if($_run > 0) echo ' mrL23';?>"><!--Begin: item comic-->
					<div class="photo_comic">
						<div class="img_comic">
							<a href="<?php echo site_url('truyen/xem/'.$rc->slug);?>" title="<?php echo word_limiter(strip_tags($rc->infomation), 20);?>" class="tooltip"><img src="<?php echo $rc->picture;?>w110/" alt="" width="110px" height="148px" /></a>
							<div class="chap_update">[ Chap <?php echo $rc->truyen_chapter_count;?> ]</div>
						</div>
					</div>
					<div class="name_comic"><a href="<?php echo site_url('truyen/xem/'.$rc->slug);?>"><?php echo $rc->title;?></a></div>
					<div class="date_update_comic"><?php echo date("d/m/Y", $rc->updated_on); ?></div>
				</div><!--/: item comic-->
				<?php $_run += 1;
					if($_run == 5) { $_run = 0; }
				endforeach;?>
            </div>
        </div><!--/: truyen cung loai-->
		<?php endif;?>
		
    </div><!--/: main content comic-->

<?php $this->load->view('footer');?>