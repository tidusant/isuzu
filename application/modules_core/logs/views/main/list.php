<?php $this->load->view('header');?>

<div class="main_content_comic"><!--Begin: main content comic-->
    
    	<?php $this->load->view('widgets/leftsubpageauthor');?>
			
			<div class="truyen_che">
				<div class="title_truyen_che">Danh sách tác giả</div>
				
				<div class="content_truyen_che"><!--Begin: content truyen che-->
					<table>
					  <thead>
					  <tr class="odd">
						  <th scope="col">Tên tác giả</th>
						  <th scope="col">Hình ảnh</th>	
						  <th scope="col">Số truyện</th>
						  <th scope="col">Lượt like</th>
							<th scope="col">Lượt xem</th>
				  
					  </tr>	
					  </thead>
					 
					 <?php if($list_authors!=false):?>
						<tbody>
						  <?php $_run=0; 
						  foreach($list_authors->result() as $author):?>
						  <tr<?php if($_run%2==0) echo ' class="odd"';?>>
								<td><a href="<?php echo site_url('truyen/tac-gia/'.$author->slug);?>"><?php echo $author->title;?></a></td>
								<td><a href="<?php echo site_url('truyen/tac-gia/'.$author->slug);?>"><img src="<?php echo $author->picture; ?>" style="max-width:50px;" alt="<?php echo $author->title;?>" /></a></td>
								<td><?php echo $author->truyen_count;?></td>
								<td><?php echo $author->like_count;?></td>
								<td><?php echo $author->view_count;?></td>
						  </tr>	
						  <?php $_run+=1;
						  endforeach;?>
					  
						</tbody>
						<?php endif;?>
					  </table>
					
					<?php if(isset($pagination)) echo '<div id="paging">'.$pagination.'</div>';?>
				</div><!--/: content truyen che-->
				
			</div><!--/: truyen che-->
				
    </div><!--/: main content comic-->

<?php $this->load->view('footer');?>