			
			<div class="title_full_line"><p><?php echo $this->lang->line('title_partner_page');?></p></div>
			
        	<div class="left_subpage"><!--Begin: left subpage-->
            	
                <div class="dealer"><!--Begin: dealer-->
                	<div id="tabsholder">
						
						<?php if($partner_location!=false) {?>
                        <ul class="tabs">
							<?php $location_array = array();
								foreach($partner_location->result() as $location) {
									$location_array[] = $location->ll_id;?>
								<li id="tab<?php echo $location->ll_id;?>"><?php echo $location->location;?></li>
							<?php }?>
                        </ul>
						<?php }?>
						
						<?php if(isset($location_array) && sizeof($location_array) > 0) {?>
                        <div class="contents marginbot">
							
							<?php foreach($location_array as $location_id) {
							$partner_list = $this->model_partner->get_partner_by_location($location_id, 10, $cur_lang);
							if($partner_list!=false) {?>
                            <div id="content<?php echo $location_id;?>" class="tabscontent">
								<?php foreach($partner_list->result() as $pl) {?>
                            	<div class="item_dealer">
									<?php if($pl->partner_link_image!=NULL) {?>
											<img src="<?php 
											if(!strstr($pl->partner_link_image, 'uploads/assets/media')) {
												echo $pl->partner_link_image;
											} else {
												$folder_link_image = str_replace($this->config->item('admin_mediastore_real_url'), '', $pl->partner_link_image);
												echo image_thumb($this->config->item('original_image_upload_path').$folder_link_image, '203', '129');
											}?>" alt="<?php echo $pl->partner_name;?>" />
									<?php } else {?>
										<img src="<?php echo base_url();?>assets/images/dealer.png" alt="<?php echo $pl->partner_name;?>" />
									<?php }?>
                                    <div class="content_item_dealer">
                                    	<!--h3><?php //echo $pl->partner_name;?></h3-->
                                        <?php if($pl->partner_address!='') {?><p><?php echo $this->lang->line('partner_address');?> : </p>
                                        <p><span  style="color:#37b3e7"><a target="_blank" href="<?php echo link_to_gmap($pl->partner_address);?>"><?php echo $pl->partner_address;?></a></span></p><?php }?>
                                        <?php if($pl->partner_tel!='') {?><p><?php echo $this->lang->line('partner_tel');?>: <?php echo $pl->partner_tel;?></p><?php }?>
                                        <?php if($pl->partner_fax!='') {?><p><?php echo $this->lang->line('partner_fax');?>: <?php echo $pl->partner_fax;?></p><?php }?>
                                        <?php if($pl->partner_email!='') {?><p><?php echo $this->lang->line('partner_email');?>: <a href="mailto:<?php echo $pl->partner_email;?>"><?php echo $pl->partner_email;?></a></p><?php }?>
										<?php if($pl->partner_description!='') {?><p><?php echo $pl->partner_description;?></p><?php }?>
                                    </div>
                                </div>
								<?php }?>
                                
                            </div>
                            <?php }
							}?>
                        </div>
						<?php }?>
                        
                    </div>
					<!-- /Tabs -->
                </div><!--End: dealer-->
                
            </div><!--End: left subpage-->
            
			<div class="right_subpage"><!--Begin: right subpage-->
				<div class="right_product_list">
					<div class="title_right_product_list"><?php echo $this->lang->line('sidebar_product_catalog');?></div>
					<?php echo modules::run('products/_render_other_page_sidebar', $cur_lang);?>
				</div>
				<!-- right banner -->
				<?php echo modules::run('products/_render_right_banner');?>
			</div><!--End: right subpage-->