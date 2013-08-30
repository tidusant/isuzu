
        	<div class="full_page">
				
            	<div class="titel_w_line"><p><?php echo $this->lang->line('title_testdrivereg_page');?></p></div>
				
                <div class="content_test_drive">
					
                	<p><?php echo $intro_above_form_1;?></p>
                    
					<br clear="all" />
					
					<?php echo modules::run('home/_render_system_message');?><br />
					
					<div class="contact_form">
						
						<form name="testdriveform" id="testdriveform" method="post" action="">
							
							<div class="line_contact_form">
								<div class="label_contact"><span>*</span> <?php echo $this->lang->line('testdriveform_item_registered');?>:</div>
								<div class="form_contact">
									<select class="select_test_drive" name="model_select">
										 <?php if($selectbox_catalog_list!=false) {
										 foreach($selectbox_catalog_list->result() as $cate) {?>
											<optgroup label="<?php echo $cate->pc_name;?>">
												<?php 
												$selectbox_product_list = $this->model_product->get_product_list_by_cate_selectbox($cate->pc_id, 100, $this->_cur_lang);
												if($selectbox_product_list!=false) {
													foreach($selectbox_product_list->result() as $product) echo '<option value="'.$product->product_name.'" '.set_select('model_select', $product->product_name).'>'.$product->product_name.'</option>';
												}
												unset($selectbox_product_list);
												?>
											</optgroup>
										 <?php }
										 }?>
										
									</select>
									
									</div>
							</div>
							
							<div class="line_contact_form">
								<div class="label_contact"><span>*</span> <?php echo $this->lang->line('testdriveform_fullname');?>:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="fullname" id="fullname" value="<?php echo set_value('fullname');?>" /></div>
							</div>
							
							<div class="line_contact_form">
								<div class="label_contact"><?php echo $this->lang->line('testdriveform_gender');?>:</div>
								<div class="form_contact">
									<input type="radio" name="gender" id="gender-male" value="1" <?php echo set_radio('gender', '1', TRUE); ?> /><?php echo $this->lang->line('testdriveform_male');?>  
									<input type="radio" name="gender" id="gender-female" value="0" <?php echo set_radio('gender', '0'); ?> /><?php echo $this->lang->line('testdriveform_female');?>  </div>
							</div>
							
							<div class="line_contact_form">
								<div class="label_contact"><span>*</span> <?php echo $this->lang->line('testdriveform_birthdate');?>:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="birthdate" id="birthdate" value="<?php echo set_value('birthdate');?>" /></div>
							</div>
							<div class="line_contact_form">
								<div class="label_contact"><?php echo $this->lang->line('testdriveform_address');?>:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="address" id="address" value="<?php echo set_value('address');?>" /></div>
							</div>
							
							<div class="line_contact_form">
								<div class="label_contact"><?php echo $this->lang->line('testdriveform_city');?>:</div>
								<div class="form_contact">
									<select class="select_test_drive" name="city">
										<?php selectbox_tinhthanh();?>
									</select>
								</div>
							</div>
							<div class="line_contact_form">
								<div class="label_contact"><?php echo $this->lang->line('testdriveform_country');?>:</div>
								<div class="form_contact">
									<select class="select_test_drive" name="country">
										<option value="viet-nam" <?php echo set_select('country', 'viet-name');?>>Việt Nam</option>
										<option value="nhat-ban" <?php echo set_select('country', 'nhat-ban');?>>Nhật Bản</option>
									</select></div>
							</div>
							<div class="line_contact_form">
								<div class="label_contact"><span>*</span> <?php echo $this->lang->line('testdriveform_phone');?>:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="phone" id="phone" value="<?php echo set_value('phone');?>" /></div>
							</div>
						   
							<div class="line_contact_form">
								<div class="label_contact">Email:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="email" id="email" value="<?php echo set_value('email');?>" /></div>
							</div>
							<div class="line_contact_form">
								<div class="label_contact"><?php echo $this->lang->line('testdriveform_company');?>:</div>
								<div class="form_contact"><input type="text" class="input_contact" name="company" id="company" value="<?php echo set_value('company');?>" /></div>
							</div>
							
							<div class="line_contact_form">
								<div class="label_contact"> <?php echo $this->lang->line('testdriveform_itemowner');?>:</div>
								<div class="form_contact">
									<input type="text" class="input_contact" name="model_owning" id="model_owning" value="<?php echo set_value('model_owning');?>" />
								</div>
							</div>
							
						   
							<div class="line_contact_form">
								<div class="label_contact">&nbsp;</div>
								 <div class="form_contact">
									 <input type="submit" class="btn_submit_contact" value="<?php echo $this->lang->line('submit');?>" />
									 <input type="reset" class="btn_cancel_contact" value="<?php echo $this->lang->line('cancel');?>" />
								 </div>
							</div>
						</form>
					</div>
					
					<br clear="all" /><br /><br /><br />
					
					<p><?php echo $intro_above_form_2;?></p>	
                
				</div>
            </div>