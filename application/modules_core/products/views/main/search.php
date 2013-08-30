<?php $this->load->view('home/header');?>

<div class="main_content_comic"><!--Begin: main content comic-->
		
		<?php $this->load->view('home/widgets/leftsubpage');?>
        
        <div class="right_subpage"><!--Begin: right subpage comic-->
				<?php $this->load->view('home/widgets/filteraz');
				$this->load->view('home/widgets/storystatus');?>
                
			<div class="type_comic"><!--Begin: type comic-->
				<div class="title_type_comic"><?php echo $this->lang->line('story_search_keyword_with_main_title').' '.$keyword;?></div>
					<div class="content_type_comic"><!--Begin: content type comic-->
							<?php $this->load->view('home/widgets/type_view');?>
							<div id="dynamic_type_view">
							<?php $_run = 0; if($list_truyen!=false):
									foreach($list_truyen->result() as $tm):?>
							<div class="item_list_comic<?php if($_run > 0) echo ' mrL23';?>">
								<div class="photo_comic">
									<div class="img_comic">
										<a href="<?php echo site_url('truyen/xem/'.$tm->NameSlug);?>" title="<?php echo word_limiter(strip_tags($tm->Description), 20);?>" class="tooltip"><img src="<?php echo fix_link_image($tm->PictureLink, 'w110');?>" alt="" width="110px" height="148px" /></a>
										<div class="chap_update">[ Chap <?php echo $tm->StoryChapterCount;?> ]</div>
									</div>
								</div>
								<div class="name_comic"><a href="<?php echo site_url('truyen/xem/'.$tm->NameSlug);?>"><?php echo $tm->Name;?></a></div>
								<div class="date_update_comic"><?php echo date("d/m/Y", $tm->UpdatedOn); ?></div>
							</div><!--/: item comic-->
							<?php 	$_run += 1;
									if($_run == 5) { $_run = 0; }
								endforeach;
							endif;?>
							</div>
							<?php if(isset($pagination)) echo '<div id="paging">'.$pagination.'</div>';?>
					   
						</div><!--/: content type comic-->
						
					</div><!--/: type comic-->
			</div><!--/: right subpage comic-->
			
    </div><!--/: main content comic-->

<?php $this->load->view('home/footer');?>