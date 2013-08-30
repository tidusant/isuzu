<div class="left_subpage"><!--Begin: left subpage comic-->
	<div class="box_left_subpage"><!--Begin: box left subpage comic-->
		<div class="title_left_subpage">Thể loại</div>
		<div class="content_left_subpage">
			<div class="left_sub_nav">
				<ul>
					<li><a href="<?php echo site_url('truyen');?>" <?php if($this->uri->segment(2)=='' && $this->uri->segment(2)!='the-loai') echo 'class="active_left"';?>>Tất cả thể loại</a></li>
					<?php if($list_the_loai!=false):
							$url_slug = '';
							if($this->uri->segment(2) == 'the-loai')
								$url_slug = trim($this->uri->segment(3));
							elseif($this->uri->segment(2) == 'ki-tu' ||  $this->uri->segment(2) == 'trang-thai') {
								if($this->uri->segment(4) == 'the-loai' && $this->uri->segment(5) != '')
									$url_slug = trim($this->uri->segment(5));
							}
							foreach($list_the_loai->result() as $item):?>
								<li><a href="<?php echo site_url('truyen/the-loai/'.$item->slug);?>" <?php if($url_slug == $item->slug) echo 'class="active_left"';?>><?php echo $item->title;?></a></li>
					<?php endforeach;
					endif;?>
				</ul>
			</div>
		</div>
	</div><!--/: box left subpage comic-->
	
	<div class="box_left_subpage"><!--Begin: box left subpage comic-->
		<div class="title_left_subpage">Xem nhiều nhất</div>
		<div class="content_left_subpage">
			
			<?php if($list_truyen_view!=false):
			foreach($list_truyen_view->result() as $rc):?>
			<div class="item_comic_xem_nhieu"><!--Begin: item comic xem nhieu-->
				<div class="img_xem_nhieu"><a href="<?php echo site_url('truyen/xem/'.$rc->slug);?>"><img src="<?php echo fix_link_image($rc->picture, 'w50');?>" width="50px" height="67px" alt="<?php echo $rc->title;?>" /></a></div>
				<h4><a href="<?php echo site_url('truyen/xem/'.$rc->slug);?>"><?php echo $rc->title;?></a></h4>
				<p><?php echo word_limiter(strip_tags($rc->infomation), 15);?></p>
			</div><!--/: item comic xem nhieu-->
			<?php endforeach;
			endif;?>

		</div>
	</div><!--/: box left subpage comic-->
</div><!--/: left subpage comic-->