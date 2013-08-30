		<div class="product_detail"><!--Begin: full page-->
            
            	<div class="title_product_detail">
            		<div class="titel_w_line"><p><a href="<?php echo site_url($this->uri->segment(1));?>"><?php echo $this->lang->line('title_product_page');?></a>&nbsp;<span><a href="<?php echo site_url($this->uri->segment(1).'/loai/'.$category_slug);?>"><?php echo $category_name;?></a></span>&nbsp;<span><?php echo $product_name;?></span></p></div>
                </div>
                
				<?php if($product_detail!=false) {?>
                <div class="short_info_product_detail"><!--Begin: short product detail-->
					<?php if($product_detail->product_image_link!='') {?>
						<img src="<?php 
							$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $product_detail->product_image_link);
							echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, $this->config->item('product_detail_size_w'), $this->config->item('product_detail_size_h'));?>" alt="<?php echo $product_detail->product_name;?>" />
					<?php } else { ?>
						<img src="<?php echo base_url();?>assest/images/product_detail.png" alt="<?php echo $product_detail->product_name;?>" width="<?php echo $this->config->item('product_detail_size_w');?>" height="<?php echo $this->config->item('product_detail_size_h');?>" />
					<?php }
					if($product_detail->product_description=='') echo $this->lang->line('page_not_avail_language'); else echo process_output($product_detail->product_description);?>
                </div><!--End: short product detail-->
                <?php }?>
				
			<div id="tabs">
				<ul class="sub_product_nav">
					<li><a name="scroll_to" href="#thongsokithuat"><?php echo $this->lang->line('product_detail_thongsokythuat_tab');?></a></li>
					
					<?php if($product_interior_tab <> 0) {?>
					<li><a name="scroll_to" href="#noithat"><?php echo $this->lang->line('product_detail_noithat_tab');?></a></li>
					<?php }
					
					if($product_exterior_tab <> 0){ ?>
					<li><a name="scroll_to" href="#ngoaithat"><?php echo $this->lang->line('product_detail_ngoaithat_tab');?></a></li>
					<?php }
					if($product_safety_tab <> 0) {?>
					<li><a name="scroll_to" href="#antoan"><?php echo $this->lang->line('product_detail_antoan_tab');?></a></li>
					<?php }
					if($product_pallete_tab <> 0) {?>
					<li><a name="scroll_to" href="#bangmau"><?php echo $this->lang->line('product_detail_bangmau_tab');?></a></li>
					<?php }
					if($cate_gallery!=false) {?>
					<li><a target="_blank" href="<?php echo site_url('san-pham/loai/'.$category_slug.'/thu-vien');?>"><?php echo $this->lang->line('product_detail_thuvien_tab');?></a></li>
					<?php }?>
				</ul>
                
                <?php if($thongsokithuat_tab!='0') {?>
                <div class="content_sub_product" id="thongsokithuat"><!--Begin: content sub product detail-->
					
					<div class="select_car_type">
                    	<p><?php echo $this->lang->line('product_detail_select_which_product');?>:</p>
						
						<div class="check_box">
						<?php if($list_other_products!=false) {
							echo '<select class="select_test_drive" name="select_other_product" id="select_other_product" style="font-size:14px;width:309px;background-color: #333030;color: #FFF;">
							<option value="tp_0">-'.$this->lang->line('product_select_model_vehicle').'-</option>';
							$header_other_products = '';
							$other_product_arr = array();
							foreach($list_other_products->result() as $other_product) {
								if($this->model_product->check_product_tech_pattern($other_product->product_cate_pc_id, $other_product->product_id)) {
								$header_other_products .= '<th scope="col" style="background: #B62326;font-weight:bold;color:#FFF" class="compare_product tp_'.$other_product->product_id.'">'.$other_product->product_name.'</th>';
									$other_product_arr[] = $other_product->product_id;
									echo '<option value="tp_'.$other_product->product_id.'">'.$other_product->product_name.'</option>';
								}
							}
							echo '</select>';
						}?>
						</div>
                    </div>
                    
					
                    <div class="thongso_kythuat">
						
                    	<table>
							
							<?php if($list_pattern_group!=false) {
							foreach($list_pattern_group as $group_id=>$group_name) {
							
							$product_pattern_by_group = $this->model_product->get_product_tech_pattern_by_group($group_id, $product_cate_id, $product_id, $lang);?>
							<!-- 1 group -->
							<thead>
							<tr class="odd">
								<?php if($product_pattern_by_group!=false) {?>
                              <th scope="col" style="background:#A71115; text-align:left;"><p style="text-transform:uppercase;"><?php echo $group_name;?></p></th>
							  <th scope="col" style="background: #B62326;font-weight:bold;color:#FFF"><?php echo $product_detail->product_name;?></th>
							  <?php if(isset($header_other_products) && $header_other_products!='') echo $header_other_products;
							  }?>
							</tr>	
							</thead>
                         
							<tbody>
							<?php
							if($product_pattern_by_group!=false) {
							$_count = 1;
								foreach($product_pattern_by_group->result() as $info) {?>
							<tr<?php if(($_count % 2)==0) echo ' class="odd"';?>>
                              <th scope="row" <?php if(($_count % 2)==0) echo ' class="column1"'; else echo ' class="non-column"';?>><?php echo $info->pattern_name;?> <span style="float:right"><?php echo $info->pattern_unit;?></span></th>
                              <td><?php echo $info->tech_value;?></td>
							  <?php 
								if(isset($other_product_arr) && count($other_product_arr) > 0)
								{
									foreach($other_product_arr as $p_id) {
										$body_other_products = $this->model_product->get_product_tech_pattern_value($p_id, $info->id, $lang);
										
										if($body_other_products!=false) {
											foreach($body_other_products->result() as $other_info)
												echo '<td class="compare_product tp_'.$p_id.'">'.$other_info->tech_value.'</td>';
												
											unset($body_other_products);
										}
									}
								}
								?>
							</tr>
							<?php $_count+=1;
								}
							}?>
                            </tbody>
                            <?php }
							}?>
                         
                        </table>
                        
                    </div>
					
                </div><!--End: content sub product detail-->
				<?php } else {?>
				 <div class="content_sub_product" id="thongsokithuat"><!--Begin: content sub product detail-->
					<div class="select_car_type">
                    	<p><?php echo $this->lang->line('tech_info_updating');?></p>
					</div>
				 </div>
				<?php }
				if($product_interior_tab <> 0) {?>
				<!-- noi that -->
				<div class="content_sub_product" id="noithat"><!--Begin: content sub product detail-->
					<?php echo $product_interior_content_render;?>
                </div><!--End: content sub product detail noithat-->
				<?php }
				if($product_exterior_tab <> 0) {?>
				<!-- ngoai that -->
				<div class="content_sub_product" id="ngoaithat"><!--Begin: content sub product detail-->
					<?php echo $product_exterior_content_render;?>
                </div><!--End: content sub product detail ngoaithat-->
				<?php }
				if($product_safety_tab <> 0) {?>
				<!-- safety -->
				<div class="content_sub_product" id="antoan"><!--Begin: content sub product detail-->
					<?php echo $product_safety_content_render;?>
                </div><!--End: content sub product detail antoan-->
				<?php }
				if($product_pallete_tab <> 0) {?>
				<!-- bangmau -->
				<div class="content_sub_product" id="bangmau"><!--Begin: content sub product detail-->
					<?php echo $product_pallete_content_render;?>
                </div><!--End: content sub product detail bangmau-->
				<?php }?>
			</div> <!-- tabs div -->
        </div><!--End: full page-->