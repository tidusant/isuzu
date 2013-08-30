				
				<?php if($allow_reg_event=='1') {?>
            	<div class="registration_form_event">
                	<div class="title_lastest_news_sub"><?php echo $this->lang->line('regeventform_title');?></div>
                    <div class="content_form_registration">
                    	<form name="event_registration" id="event_registration" method="post" action="<?php echo site_url($this->uri->uri_string());?>">
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_fullname');?>:</div>
                            <div class="form_reg"><input type="text" class="input_reg" name="fullname" id="fullname" value="<?php echo set_value('fullname');?>" />&nbsp;<span>*</span></div>
                        </div>
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_gender');?>:</div>
                            <div class="form_reg">
							<input type="radio" name="gender" id="gender-male" value="1" <?php echo set_radio('gender', '1', true);?> /><?php echo $this->lang->line('eventform_gender_male');?>  
							<input type="radio" name="gender" id="gender-female" value="0" <?php echo set_radio('gender', '0');?> /><?php echo $this->lang->line('eventform_gender_female');?></div>
                        </div>
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_birthdate');?>:</div>
                             <div class="form_reg"><input type="text" class="input_reg" name="birthdate" id="birthdate" value="<?php echo set_value('birthdate');?>" />&nbsp;<span>*</span></div>
                        </div>
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_address');?>:</div>
                             <div class="form_reg"><input type="text" class="input_reg" name="address" id="address" value="<?php echo set_value('address');?>" /></div>
                        </div>
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_city');?>:</div>
                            <div class="form_reg">
                            	<select class="select_reg" name="city">
									<?php selectbox_tinhthanh();?>
                                </select>
                            </div>
                        </div><div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_itemowner');?>:</div>
                            <div class="form_reg">
								<input type="text" class="input_reg" name="model_owning" id="model_owning" value="<?php echo set_value('model_owning');?>" />
                            </div>
                        </div>
                        <div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_phone');?>:</div>
                             <div class="form_reg"><input type="text" class="input_reg" name="phone" id="phone" value="<?php echo set_value('phone');?>" />&nbsp;<span>*</span></div>
                        </div>
                        <div class="line_form">
                        	<div class="label">Email:</div>
                             <div class="form_reg"><input type="text" class="input_reg" name="email" id="email" value="<?php echo set_value('email');?>" />&nbsp;<span>*</span></div>
                        </div>
						
						<div class="line_form">
                        	<div class="label"><?php echo $this->lang->line('eventform_company');?>:</div>
                            <div class="form_reg"><input type="text" class="input_reg" name="company" id="company" value="<?php echo set_value('company');?>" /></div>
                        </div>
						
                        <div class="line_form">
                        	<div class="label">&nbsp;</div>
                             <div class="form_reg">
                             	 <input type="submit" class="btn_submit_reg" value="<?php echo $this->lang->line('submit');?>" />
                                 <input type="reset" class="btn_cancel_reg" value="<?php echo $this->lang->line('cancel');?>" />
                             </div>
                        </div>
                        </form>
                    </div>	
                </div>
				<?php }
				echo modules::run('news/_render_sidebar');?>