
        	<div class="full_page"><!--Begin: full page-->
            	<div class="titel_w_line"><p><?php echo $this->lang->line('title_faq_page');?></p></div>
                
                <div class="left_faq"><!--Begin: left faq-->
					<?php echo modules::run('home/_render_system_message');?>
                	 <div class="faq_post"><!--Begin: form post-->
                     	<h3><?php echo $this->lang->line('faq_whatyourquestion');?></h3>
						<form name="form_ask_faq" id="form_ask_faq" method="post" action="">
							
							<input type="text" name="full_name" class="input03" value="<?php echo $this->lang->line('faq_form_fullname');?>" onblur="if(this.value=='') this.value= '<?php echo $this->lang->line('faq_form_fullname');?>';" onfocus="if(this.value=='<?php echo $this->lang->line('faq_form_fullname');?>') this.value='';" />
							
							<input type="text" name="email" class="input03" value="Email" onblur="if(this.value=='') this.value= 'Email';" onfocus="if(this.value=='Email') this.value='';" />
							
							<textarea class="textarea-input04" name="content"><?php echo $this->lang->line('faq_form_question');?></textarea>
							
							<input type="submit" name="submit" class="btn_faq" value="Submit" />
						</form>
                     </div><!--End: form post-->
                     
					 <?php if(isset($faq_list) && $faq_list!=false) {
					 foreach($faq_list->result() as $faq) { ?>
                     <div class="list_faq" id="question_<?php echo $faq->faq_id?>"><!--Begin: list faq-->
                     	<div class="quest">
                        	<h3><?php echo $faq->faq_question;?></h3>
                           
                        </div>
                        <div class="answer">
                        	<p><strong><?php echo $this->lang->line('faq_theanswer');?>:</strong> <?php if($faq->faq_answer=='') echo $this->lang->line('page_not_avail_language'); else echo $faq->faq_answer;?></p>
                        </div>
                     </div><!--End: list faq-->
					 <?php }
					 }?>
                     
                </div><!--End: left faq-->
                
				<!-- right column -->
				<div class="right_faq">
					<div class="title_right_faq"><?php echo $this->lang->line('faq_sidebar');?></div>
					
					<div class="content_right_faq">
						<?php if($get_sidebar_faq!=false) {?>
                    	<ul>
							<?php foreach($get_sidebar_faq->result() as $faq) {?>
								<li><a href="#question_<?php echo $faq->faq_id;?>"><?php echo $faq->faq_question;?></a></li>
							<?php }?>
                        </ul>
						<?php }?>
                    </div>
					<br />
					<?php echo modules::run('products/_render_right_banner');?>
				</div>
              
            </div><!--End: full page-->