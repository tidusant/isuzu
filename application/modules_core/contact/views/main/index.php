			<div class="left_subpage"><!--Begin: left subpage-->
            
            	<div class="contact_subpage">
                	<div class="titel_w_line">
                    	<p><?php echo $this->lang->line('title_contact_page');?></p>
                    </div>
                    
                    <div class="contact_form">
						
						<?php echo modules::run('home/_render_system_message');?>
						<br clear="all" />
						
						<form action="" name="contact_form" id="contact_form" method="post">
                    	<div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_fullname');?>: <span>*</span></div>
                            <div class="form_contact"><input type="text" name="fullname" id="fullname" class="input_contact" value="<?php echo set_value('fullname');?>" /></div>
                        </div>
                        <div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_company');?>:</div>
                            <div class="form_contact"><input type="text" name="company" id="company" class="input_contact" value="<?php echo set_value('company');?>" /></div>
                        </div>
                        <div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_address');?>:</div>
                            <div class="form_contact"><input type="text" name="address" id="address" class="input_contact" value="<?php echo set_value('address');?>" /></div>
                        </div>
                        <div class="line_contact_form">
                        	<div class="label_contact">Email: <span>*</span></div>
                            <div class="form_contact"><input type="text" name="email" id="email" class="input_contact" value="<?php echo set_value('email');?>" /></div>
                        </div>
                       
                        <div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_phone');?>: <span>*</span></div>
                            <div class="form_contact"><input type="text" name="phone" id="phone" class="input_contact" value="<?php echo set_value('phone');?>" /></div>
                        </div>
                        <div class="line_contact_form">
                        	<div class="label_contact">Fax:</div>
                            <div class="form_contact"><input type="text" name="fax" id="fax" class="input_contact" value="<?php echo set_value('fax');?>" /></div>
                        </div>
                        
                        <div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_subject');?>: <span>*</span></div>
                            <div class="form_contact"><input type="text" name="subject" id="subject" class="input_contact" value="<?php echo set_value('subject');?>" /></div>
                        </div>
                        
                        <div class="line_contact_form">
                        	<div class="label_contact"><?php echo $this->lang->line('contact_form_content');?>: <span>*</span></div>
                            <div class="form_contact"><textarea name="content" id="content" class="textarea_contact"><?php echo set_value('content');?></textarea></div>
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
                    
                </div>
			
            </div><!--End: left subpage-->
            
            <div class="right_subpage"><!--Begin: right subpage-->
            
            	<div class="info_contact">
                	<div class="title_info_contact"><img src="<?php echo base_url();?><?php echo $this->lang->line('contactImg');?>" alt="" /></div>
                    <div class="content_info_contact">
                    	<p><strong><?php echo $this->lang->line('contact_office_main_sales');?></strong></p>
						<?php echo modules::run('home/_render_footer_contact_info');?>
                    </div>
                </div>
                <?php echo modules::run('products/_render_right_banner');?>
            </div><!--End: right subpage-->